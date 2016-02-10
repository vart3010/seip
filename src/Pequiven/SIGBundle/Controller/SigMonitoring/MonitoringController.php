<?php

namespace Pequiven\SIGBundle\Controller\SigMonitoring;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Controlador Seguimiento y Eficacia
 *
 * @author Maximo Sojo <maxsojo13@gmail.com>
 */
class MonitoringController extends ResourceController
{
    public function listAction(Request $request)
    {
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();
        
        $criteria = $request->get('filter',$this->config->getCriteria());
        $sorting = $request->get('sorting',$this->config->getSorting());
        
        //$repository = $this->getRepository();        
        $repository = $this->container->get('pequiven.repository.sig_management_system'); 
        
        if ($this->config->isPaginated()) {
            $resources = $this->resourceResolver->getResource(
                $repository,
                'createPaginatorManagementSystems',
                array($criteria, $sorting)
            );
            
            $maxPerPage = $this->config->getPaginationMaxPerPage();
            if(($limit = $request->query->get('limit')) && $limit > 0){
                if($limit > 100){
                    $limit = 100;
                }
                $maxPerPage = $limit;
            }
            $resources->setCurrentPage($request->get('page', 1), true, true);
            $resources->setMaxPerPage($maxPerPage);
        } else {
            $resources = $this->resourceResolver->getResource(
                $repository,
                'findBy',
                array($criteria, $sorting, $this->config->getLimit())
            );
        }
        $routeParameters = array(
            '_format' => 'json'            
        );
        $apiDataUrl = $this->generateUrl('pequiven_sig_monitoring_list', $routeParameters);        
        
        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('list.html'))
            ->setTemplateVar($this->config->getPluralResourceName())
        ;

        $view->getSerializationContext()->setGroups(array('id','api_list'));

        if($request->get('_format') == 'html'){
        	$data = array(
                'apiDataUrl' => $apiDataUrl,
                $this->config->getPluralResourceName() => $resources,                
            );            
            $view->setData($data);
        }else{
            $formatData = $request->get('_formatData','default');

            $view->setData($resources->toArray('',array(),$formatData));
        }
        return $this->handleView($view); 
    }

    public function showAction(Request $request){
    	
    	$id = $request->get('id');
    	$managemensystems = $this->container->get('pequiven.repository.sig_management_system')->find($id); 
    	
    	return $this->render('PequivenSIGBundle:Monitoring:show.html.twig', array('data' => $managemensystems));
    }
}
