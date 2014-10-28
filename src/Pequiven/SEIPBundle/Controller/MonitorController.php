<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\SEIPBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController as baseController;
/**
 * Description of MonitorController
 *
 * @author matias
 */
class MonitorController extends baseController {
    
    /**
     * Función que devuelve el paginador con los objetivos tácticos
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function monitorTypeGroupListAction(Request $request) {

//        $em = $this->getDoctrine()->getManager();
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();

        $criteria = $request->get('filter', $this->config->getCriteria());
        $sorting = $request->get('sorting', $this->config->getSorting());
        $repository = $this->getRepository();

        if ($this->config->isPaginated()) {
            $resources = $this->resourceResolver->getResource(
                    $repository, 'createPaginatorTypeGroup', array($criteria, $sorting)
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

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('index.html'))
                ->setTemplateVar($this->config->getPluralResourceName())
        ;
//        $view->getSerializationContext()->setGroups(array('id', 'api_list', 'indicators', 'formula'));
        if ($request->get('_format') == 'html') {
            $view->setData($resources);
        } else {
            $formatData = $request->get('_formatData', 'default');

            $view->setData($resources->toArray('', array(), $formatData));
        }
        return $this->handleView($view);
    }
    
    /**
     * Función que devuelve el paginador con los objetivos tácticos
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function monitorTacticListAction(Request $request) {

//        $em = $this->getDoctrine()->getManager();
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();

        $criteria = $request->get('filter', $this->config->getCriteria());
        $sorting = $request->get('sorting', $this->config->getSorting());
        $repository = $this->getRepository();

        if ($this->config->isPaginated()) {
            $resources = $this->resourceResolver->getResource(
                    $repository, 'createPaginatorTactic', array($criteria, $sorting)
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

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('index.html'))
                ->setTemplateVar($this->config->getPluralResourceName())
        ;
//        $view->getSerializationContext()->setGroups(array('id', 'api_list', 'indicators', 'formula'));
        if ($request->get('_format') == 'html') {
            $view->setData($resources);
        } else {
            $formatData = $request->get('_formatData', 'default');

            $view->setData($resources->toArray('', array(), $formatData));
        }
        return $this->handleView($view);
    }
    
    /**
     * Función que renderiza el Monitor de Objetivos Operativos
     * @Template("PequivenSEIPBundle:Monitor:Operative/objetiveGerenciaFirstGroup.html.twig")
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return type
     */
    public function displayObjetiveOperativeAction(Request $request){
        $categories = array();
        $categories[] = array('label' => "Comercializadoras");
        $categories[] = array('label' => "Complejos");
        $categories[] = array('label' => "Sede Corporativa");
        $categories[] = array('label' => "Proyectos");
        
        $datas = $this->getDataObjetiveOperativeGroupChart();
        
        $i = 0;
        foreach($datas['dataLinkOperative'] as $data){
            $datas['dataLinkOperative'][$i]['typeGroup'] = $categories[$i]['label'];
            $i++;
        }
        
        return array(
            'dataPlanOperative' => $datas['dataPlanOperative'],
            'dataRealOperative' => $datas['dataRealOperative'],
            'dataPorcOperative' => $datas['dataPorcOperative'],
            'dataLinkOperative' => $datas['dataLinkOperative'],
            'categories' => $categories
        );
    }
    
    /**
     * Función que renderiza el Monitor de Objetivos Tácticos por Tipo de Grupo de Gerencia de 1ra Línea
     * @Template("PequivenSEIPBundle:Monitor:Tactic/objetiveGerenciaFirstByGroup.html.twig")
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return type
     */
    
    public function displayObjetiveTacticByGroupAction(Request $request){
        $typeGroup = $request->get("typeGroup");
        
        
        
        return array(
            
        );
    }
    
    /**
     * Función que obtiene los objetivos operativos agrupados por tipo de Gerencia de 1ra Línea
     * @return type
     */
    public function getDataObjetiveOperativeGroupChart(){
        $em = $this->getDoctrine()->getManager();
        $datas = array();
        $dataRealOperative = array();
        $dataPlanOperative = array();
        $dataPorcOperative = array();
        $dataLinkOperative = array();
        
        //Resultados Operativos
        $resultsOperatives = $em->getRepository('PequivenSEIPBundle:Monitor')->getTotalObjetivesOperativeByGerenciaGroup();
        
        foreach($resultsOperatives as $resultOperative){
            $resOperative = $resultOperative['PlanObjOperative'] == 0 ? bcadd(0,'0',2) : bcadd(((float)$resultOperative['RealObjOperative'] / (float)$resultOperative['PlanObjOperative']) * 100,'0',2);
            $dataPorcOperative[] = array('value' => $resOperative);
            $dataPlanOperative[] = array('value' => $resultOperative['PlanObjOperative']);
            $dataRealOperative[] = array('value' => $resultOperative['RealObjOperative']);
            $dataLinkOperative[] = array('typeGroup' => $resultOperative['typeGroup'],'porcCarga' => $resOperative);
        }
        $datas['dataPorcOperative'] = $dataPorcOperative;
        $datas['dataPlanOperative'] = $dataPlanOperative;
        $datas['dataRealOperative'] = $dataRealOperative;
        $datas['dataLinkOperative'] = $dataLinkOperative;
        
        return $datas;
    }
    
    /**
     * Función que obtiene los Objetivos Tácticos agrupados por tipo de Gerencia de 1ra Línea
     * @return type
     */
    public function getDataObjetiveTacticByGroupChart(){
        $em = $this->getDoctrine()->getManager();
        $datas = array();
        $dataRealTactic = array();
        $dataPlanTactic = array();
        $dataPorcOperative = array();
        $dataLinkOperative = array();
        
        //Resultados Operativos
        $resultsOperatives = $em->getRepository('PequivenSEIPBundle:Monitor')->getTotalObjetivesOperativeByGerenciaGroup();
        
        foreach($resultsOperatives as $resultOperative){
            $resOperative = $resultOperative['PlanObjOperative'] == 0 ? bcadd(0,'0',2) : bcadd(((float)$resultOperative['RealObjOperative'] / (float)$resultOperative['PlanObjOperative']) * 100,'0',2);
            $dataPorcOperative[] = array('value' => $resOperative);
            $dataPlanOperative[] = array('value' => $resultOperative['PlanObjOperative']);
            $dataRealOperative[] = array('value' => $resultOperative['RealObjOperative']);
            $dataLinkOperative[] = array('typeGroup' => $resultOperative['typeGroup'],'porcCarga' => $resOperative);
        }
        $datas['dataPorcOperative'] = $dataPorcOperative;
        $datas['dataPlanOperative'] = $dataPlanOperative;
        $datas['dataRealOperative'] = $dataRealOperative;
        $datas['dataLinkOperative'] = $dataLinkOperative;
        
        return $datas;
    }
}
