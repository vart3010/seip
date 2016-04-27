<?php

namespace Pequiven\SEIPBundle\Controller\Planning;

use Symfony\Component\HttpFoundation\Request;
use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Pequiven\ObjetiveBundle\Model\ObjetiveLevel;

/**
 * Controlador de los objetivos (Planificacion)
 *
 * @author Matias
 */
class ObjetiveController extends ResourceController
{
    public function showAction(Request $request) 
    {
        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('show.html'))
            ->setTemplateVar($this->config->getResourceName())
            ->setData($this->findOr404($request))
        ;
        $view->getSerializationContext()->setGroups(array('id','api_list','api_details','indicators','formula','gerenciaSecond'));
        return $this->handleView($view);
    }
    
    function listAction(Request $request)
    {
        $level = $request->get('level');
        
        $rol = null;
        $roleByLevel = array(
            ObjetiveLevel::LEVEL_ESTRATEGICO => 'ROLE_SEIP_PLANNING_LIST_OBJECTIVE_STRATEGIC',
            ObjetiveLevel::LEVEL_TACTICO => 'ROLE_SEIP_PLANNING_LIST_OBJECTIVE_TACTIC',
            ObjetiveLevel::LEVEL_OPERATIVO => 'ROLE_SEIP_PLANNING_LIST_OBJECTIVE_OPERATIVE',
        );
        
        if(isset($roleByLevel[$level])){
            $rol = $roleByLevel[$level];
        }
        
        $this->getSecurityService()->checkSecurity($rol);
        
        $criteria = $request->get('filter', $this->config->getCriteria());
        $sorting = $request->get('sorting', $this->config->getSorting());
        $repository = $this->getRepository();

        $criteria['objetiveLevel'] = $level;

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
        $apiDataUrl = $this->generateUrl('pequiven_objetive_list',$routeParameters);
        
        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('list.html'))
                ->setTemplateVar($this->config->getPluralResourceName())
        ;
        $view->getSerializationContext()->setGroups(array('id','api_list','indicators','formula','gerenciaSecond'));
        if ($request->get('_format') == 'html') {
            $labelsStatus = array();
            foreach (\Pequiven\ObjetiveBundle\Entity\Objetive::getLabelsStatus() as $key => $value) {
                $labelsStatus[] = array(
                    'id' => $key,
                    'description' => $this->trans($value,array(),'PequivenObjetiveBundle'),
                );
            }
            $data = array(
                'apiDataUrl' => $apiDataUrl,
                $this->config->getPluralResourceName() => $resources,
                'level' => $level,
                'labelsStatus' => $labelsStatus,
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
        
        $results = $this->get('pequiven.repository.gerenciafirst')->getGerenciaOptions();

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

        $results = $this->get('pequiven.repository.gerenciasecond')->findByGerenciaFirst(array('gerencia' => $gerencia));

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
    
    public function updateAction(Request $request) 
    {
        $resource = $this->findOr404($request);
        $form = $this->getForm($resource);

        if (($request->isMethod('PUT') || $request->isMethod('POST')) && $form->submit($request)->isValid()) {

            $this->domainManager->update($resource);

            return $this->redirectHandler->redirect($this->generateLinkUrlOnly($resource));
        }

        if ($this->config->isApiRequest()) {
            return $this->handleView($this->view($form));
        }

        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('update.html'))
            ->setData(array(
                $this->config->getResourceName() => $resource,
                'form'                           => $form->createView()
            ))
        ;

        return $this->handleView($view);
    }
    /**
     * Aprueba un objetivo
     * @param Request $request
     * @return type
     */
    public function approvedAction(Request $request) 
    {
        $resource = $this->findOr404($request);
        
        $securityService = $this->getSecurityService();
        $roleByLevel = array(
            ObjetiveLevel::LEVEL_ESTRATEGICO => array('ROLE_SEIP_OBJECTIVE_APPROVED_STRATEGIC'),
            ObjetiveLevel::LEVEL_TACTICO => array('ROLE_SEIP_OBJECTIVE_APPROVED_TACTIC'),
            ObjetiveLevel::LEVEL_OPERATIVO => array('ROLE_SEIP_OBJECTIVE_APPROVED_OPERATIVE'),
        );
        
        $level = $resource->getObjetiveLevel()->getLevel();
        if(isset($roleByLevel[$level])){
            $rol = $roleByLevel[$level];
        }
        
        $securityService->checkSecurity($rol,$resource);
        
        $details = $resource->getDetails();
        if($details === null){
            $details = new \Pequiven\ObjetiveBundle\Entity\Objetive\ObjetiveDetails();
        }
        $details->setApprovalDate(new \DateTime());
        $details->setApprovedBy($this->getUser());
        $resource->setDetails($details);
        
        $resource->setStatus(\Pequiven\ObjetiveBundle\Entity\Objetive::STATUS_APPROVED);
        
        $this->domainManager->update($resource, 'approved');
        
        return $this->redirectHandler->redirect($this->generateLinkUrlOnly($resource));
    }
    
    /**
     * Elimina un objetivo
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteAction(Request $request) 
    {
        $redirectUrl = $request->get("redirectUrl");
        $resource = $this->findOr404($request);
        $this->domainManager->delete($resource);

        return $this->redirectHandler->redirect($redirectUrl);
    }
    
    /**
     * 
     * @return \Pequiven\SEIPBundle\Service\SecurityService
     */
    protected function getSecurityService()
    {
        return $this->container->get('seip.service.security');
    }
    
    /**
     * Genera solo la url de el objeto
     * 
     * @param type $entity
     * @param type $type
     * @return type
     */
    protected function generateLinkUrlOnly($entity,$type = \Pequiven\SEIPBundle\Service\LinkGenerator::TYPE_LINK_DEFAULT,array $parameters = array())
    {
        return $this->container->get('seip.service.link_generator')->generateOnlyUrl($entity,$type,$parameters);
    }
}
