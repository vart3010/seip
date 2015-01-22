<?php

namespace Pequiven\SEIPBundle\Controller\Planning;

use Symfony\Component\HttpFoundation\Request;
use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Controlador de los indicadores (Planificacion)
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
class IndicatorController extends ResourceController
{
    public function showAction(Request $request) {
        $resource = $this->findOr404($request);
        
        $errorFormula = null;
        if($resource->getFormula() !== null){
            $indicatorService = $this->container->get('pequiven_indicator.service.inidicator');
            $formula = $resource->getFormula();
            $errorFormula = $indicatorService->validateFormula($formula);
        }
        
        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('show.html'))
            ->setData(array(
                $this->config->getResourceName() => $resource,
                'errorFormula' => $errorFormula,
            ))
        ;
        $view->getSerializationContext()->setGroups(array('id','api_list','valuesIndicator','api_details','sonata_api_read'));
        return $this->handleView($view);
    }
    
    /**
     * Lista de Indicadores por nivel(Estratégico, Táctico u Operativo)
     * @param Request $request
     * @return type
     */
    function listAction(Request $request)
    {
        $level = $request->get('level');
        $criteria = $request->get('filter', $this->config->getCriteria());
        $sorting = $request->get('sorting', $this->config->getSorting());
        $repository = $this->getRepository();

        $criteria['indicatorLevel'] = $level;

        if ($this->config->isPaginated()) {
            $resources = $this->resourceResolver->getResource(
                    $repository, 'createPaginatorByLevel', array($criteria, $sorting)
            );

            $maxPerPage = $this->config->getPaginationMaxPerPage();
            if (($limit = $request->query->get('limit')) && $limit > 0) {
                if ($limit > 100) {
                    $limit = 100;
                }
                $maxPerPage = $limit;
            }
            $resources->setCurrentPage($request->get('page', 1), true, true);
            $resources->setMaxPerPage($maxPerPage);
        } else {
            $resources = $this->resourceResolver->getResource(
                    $repository, 'findBy', array($criteria, $sorting, $this->config->getLimit())
            );
        }
        $routeParameters = array(
            '_format' => 'json',
            'level' => $level,
        );
        $apiDataUrl = $this->generateUrl('pequiven_indicator_list',$routeParameters);
        
        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('list.html'))
                ->setTemplateVar($this->config->getPluralResourceName())
        ;
        $view->getSerializationContext()->setGroups(array('id','api_list','valuesIndicator','api_details','sonata_api_read','formula'));
        if ($request->get('_format') == 'html') {
            $data = array(
                'apiDataUrl' => $apiDataUrl,
                $this->config->getPluralResourceName() => $resources,
                'level' => $level,
            );
            $view->setData($data);
        } else {
            $formatData = $request->get('_formatData', 'default');

            $view->setData($resources->toArray('', array(), $formatData));
        }
        return $this->handleView($view);
    }
    
    /**
     * @Security("is_granted('ROLE_WORKER_PLANNING')")
     * @param Request $request
     * @return type
     */
    function addObservationAction(Request $request)
    {
        $resource = $this->findOr404($request);
        
        $comment = $request->get('observation');
        if($comment == ''){
            $this->setFlash('error', 'pequiven.error.empty_comment');
            return $this->redirectHandler->redirectTo($resource);
        }
                
            $observation = new \Pequiven\SEIPBundle\Entity\Observation();
            $observation
                ->setDescription($comment)
                ->setCreatedBy($this->getUser())
                ;
            $resource->addObservation($observation);

            $this->domainManager->dispatchEvent('pre_add_observation', new \Sylius\Bundle\ResourceBundle\Event\ResourceEvent($resource));
            $this->domainManager->update($resource);
            
            $this->setFlash('success', 'pequiven.indicator.add_observation');
                
        return $this->redirectHandler->redirectTo($resource);
    }
    
    /**
     * A
     * @param \Pequiven\IndicatorBundle\Entity\Indicator $entity
     * @param type $description
     */
    private function addObservation(\Pequiven\IndicatorBundle\Entity\Indicator $entity,$description) {
        $observation = new \Pequiven\SEIPBundle\Entity\Observation();
            $observation
                ->setDescription($description)
                ->setCreatedBy($this->getUser())
                ;
            $entity->addObservation($observation);
    }
    
    /**
     * Gerencias de 1ra línea para la tabla de visualización del menú de planificación
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function selectGerenciaFirstAction(Request $request) {
        $response = new JsonResponse();

        $dataGerencia = array();
        $em = $this->getDoctrine()->getManager();
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();
        
        $results = $em->getRepository('PequivenMasterBundle:Gerencia')->getGerenciaOptions();

        $totalResults = count($results);
        if (is_array($results) && $totalResults > 0) {
            foreach ($results as $result) {
                foreach ($result as $gerencia) {
                    $dataGerencia[] = array(
                        'idComplejo' => $gerencia->getComplejo()->getId(),
                        'optGroup' => $gerencia->getComplejo()->getDescription(),
                        'id' => $gerencia->getId(),
                        'description' => $gerencia->getDescription()
                    );
                }
            }
        } else {
            $dataGerencia[] = array("empty" => true);
        }

        $response->setData($dataGerencia);

        return $response;
    }
    
    /**
     * Función que devuelve la(s) gerencias de 2da línea asociada a las gerencias de 1ra línea cargadas de acuerdo al objetivo táctico seleccionado
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function selectGerenciaSecondListAction(Request $request) {
        $response = new JsonResponse();
        $gerenciaSecondChildren = array();
        $em = $this->getDoctrine()->getManager();
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();
            
        $gerencia = $request->request->get('gerencia');

        $results = $em->getRepository('PequivenMasterBundle:GerenciaSecond')->findByGerenciaFirst(array('gerencia' => $gerencia));

        foreach ($results as $result) {
            $complejo = $result->getGerencia()->getComplejo();
            $gerencia = $result->getGerencia();
            $gerenciaSecondChildren[] = array(
                'idGroup' => $complejo->getId() . '-' . $gerencia->getId(),
                'optGroup' => $complejo->getRef() . '-' . $gerencia->getDescription(),
                'id' => $result->getId(),
                'description' => $result->getDescription()
            );
        }

        $response->setData($gerenciaSecondChildren);

        return $response;
    }
}
