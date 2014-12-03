<?php

namespace Pequiven\SEIPBundle\Controller\Planning;

use Symfony\Component\HttpFoundation\Request;
use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Controlador de los indicadores (Planificacion)
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
class IndicatorController extends ResourceController
{
    public function showAction(Request $request) {
        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('show.html'))
            ->setTemplateVar($this->config->getResourceName())
            ->setData($this->findOr404($request))
        ;
        $view->getSerializationContext()->setGroups(array('id','api_list','valuesIndicator','api_details','sonata_api_read'));
        return $this->handleView($view);
    }
    
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
}
