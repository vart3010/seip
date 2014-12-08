<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Pequiven\SEIPBundle\Controller\Planning;

use Symfony\Component\HttpFoundation\Request;
use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Description of ResultsController
 *
 * @author matias
 */
class ResultController extends ResourceController {
    //put your code here
    
        /**
     * Función que devuelve el paginador con las gerencias de 2da Línea
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function listResultAction(Request $request){
        
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();
        $em = $this->getDoctrine();
        
        $criteria = $request->get('filter',$this->config->getCriteria());
        $sorting = $request->get('sorting',$this->config->getSorting());
        $repository = $em->getRepository('PequivenMasterBundle:GerenciaSecond');
        
        //$criteria['user'] = $user->getId();
        
        if ($this->config->isPaginated()) {
            $resources = $this->resourceResolver->getResource(
                $repository,
                'createPaginatorGerenciaSecond',
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

        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('list.html'))
            ->setTemplateVar($this->config->getPluralResourceName())
        ;
        $view->getSerializationContext()->setGroups(array('id','api_list','complejo'));
        if($request->get('_format') == 'html'){
            $view->setData($resources);
        }else{
            $formatData = $request->get('_formatData','default');

            $view->setData($resources->toArray('',array(),$formatData));
        }
        return $this->handleView($view);
    }
    
    /**
     * Función que renderiza el Monitor de Objetivos Tácticos
     * @Template("PequivenSEIPBundle:Planning:Result/showMonitor.html.twig")
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return type
     */
    public function showMonitorAction(Request $request) {
        $em = $this->getDoctrine();
        $level = $request->get('level');
        $id = $request->get('id');
        
        if($level == 3){
            $gerenciaSecond = $em->getRepository('PequivenMasterBundle:GerenciaSecond')->findOneBy(array('id' => $id));
            $object = $em->getRepository('PequivenObjetiveBundle:Objetive')->getObjetivesByGerenciaSecond($gerenciaSecond);
        }

        return array(
            'object' => $object,
            'gerenciaSecond' => $gerenciaSecond,
        );
    }
}
