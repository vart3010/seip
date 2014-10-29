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
        
        $datas = $this->getDataObjetiveOperativeGroupChart();
        $boxRender = $this->get('tecnocreaciones_box.render');
        return array(
            'dataPlanOperative' => $datas['dataPlanOperative'],
            'dataRealOperative' => $datas['dataRealOperative'],
            'dataPorcOperative' => $datas['dataPorcOperative'],
            'dataLinkOperative' => $datas['dataLinkOperative'],
            'optionsChart' => $datas['optionsChart'],
            'categories' => $datas['categories'],
            'boxRender' => $boxRender,
        );
    }
    
    /**
     * Función que renderiza el Monitor de Objetivos Tácticos por Tipo de Grupo de Gerencia de 1ra Línea
     * @Template("PequivenSEIPBundle:Monitor:Tactic/objetiveGerenciaFirstByGroup.html.twig")
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return type
     */
    public function displayObjetiveTacticByGroupAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $typeGroup = $request->get("typeGroup");
        
        $objectGerenciaGroup = $em->getRepository('PequivenMasterBundle:GerenciaGroup')->findOneBy(array('groupName' => $typeGroup));

        $datas = $this->getDataObjetiveTacticByGroupChart($typeGroup);
        
        return array(
            'dataPlanTactic' => $datas['dataPlanTactic'],
            'dataRealTactic' => $datas['dataRealTactic'],
            'dataPorcTactic' => $datas['dataPorcTactic'],
            'dataLinkTactic' => $datas['dataLinkTactic'],
            'categories' => $datas['categories'],
            'gerenciaGroup' => $objectGerenciaGroup,
            'optionsChart' => $datas['optionsChart']
        );
    }
    
    /**
     * Función que renderiza el Monitor de Objetivos Operativos por Tipo de Grupo de Gerencia de 1ra Línea
     * @Template("PequivenSEIPBundle:Monitor:Operative/objetiveGerenciaFirstByGroup.html.twig")
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return type
     */
    
    public function displayObjetiveOperativeByGroupAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $typeGroup = $request->get("typeGroup");
        
        $objectGerenciaGroup = $em->getRepository('PequivenMasterBundle:GerenciaGroup')->findOneBy(array('groupName' => $typeGroup));

        $datas = $this->getDataObjetiveOperativeByGroupChart($typeGroup);
        
        return array(
            'dataPlanOperative' => $datas['dataPlanOperative'],
            'dataRealOperative' => $datas['dataRealOperative'],
            'dataPorcOperative' => $datas['dataPorcOperative'],
            'dataLinkOperative' => $datas['dataLinkOperative'],
            'categories' => $datas['categories'],
            'gerenciaGroup' => $objectGerenciaGroup,
            'optionsChart' => $datas['optionsChart']
        );
    }
    
    /**
     * Función que obtiene los Objetivos Operativos agrupados por tipo de Gerencia de 1ra Línea
     * @return type
     */
    public function getDataObjetiveOperativeGroupChart(){
        $em = $this->getDoctrine()->getManager();
        $datas = array();
        $dataRealOperative = array();
        $dataPlanOperative = array();
        $dataPorcOperative = array();
        $dataLinkOperative = array();
        $categories = array();
        
        //Resultados Operativos
        $resultsOperatives = $em->getRepository('PequivenSEIPBundle:Monitor')->getTotalObjetivesOperativeByGerenciaGroup();
        
        foreach($resultsOperatives as $resultOperative){
            $resOperative = $resultOperative['PlanObjOperative'] == 0 ? bcadd(0,'0',2) : bcadd(((float)$resultOperative['RealObjOperative'] / (float)$resultOperative['PlanObjOperative']) * 100,'0',2);
            $dataPorcOperative[] = array('value' => $resOperative);
            $dataPlanOperative[] = array('value' => $resultOperative['PlanObjOperative']);
            $dataRealOperative[] = array('value' => $resultOperative['RealObjOperative']);
            $dataLinkOperative[] = array('typeGroup' => $resultOperative['Descripcion'],'porcCarga' => $resOperative,'linkTypeGroup' => $this->generateUrl('monitorObjetiveOperativeByGroup', array('typeGroup' => $resultOperative['Grupo'])));
            $categories[] = array('label' => $resultOperative['Descripcion']);
        }
        $optionsChart = array('typeLabel' => 'auto');
        
        $datas['dataPorcOperative'] = $dataPorcOperative;
        $datas['dataPlanOperative'] = $dataPlanOperative;
        $datas['dataRealOperative'] = $dataRealOperative;
        $datas['dataLinkOperative'] = $dataLinkOperative;
        $datas['optionsChart'] = $optionsChart;
        $datas['categories'] = $categories;
        
        return $datas;
    }
    
    /**
     * Función que obtiene los Objetivos Tácticos agrupados por tipo de Gerencia de 1ra Línea
     * @return type
     */
    public function getDataObjetiveTacticByGroupChart($typeGroup){
        $em = $this->getDoctrine()->getManager();
        $datas = array();
        $dataRealTactic = array();
        $dataPlanTactic = array();
        $dataPorcTactic = array();
        $dataLinkTactic = array();
        $categories = array();
        $optionsChart = array();
        
        //Resultados Tácticos
        $resultsTactics = $em->getRepository('PequivenSEIPBundle:Monitor')->getTotalObjetivesTacticByGerenciaGroup(array('typeGroup' => $typeGroup));
        
        foreach($resultsTactics as $resultTactic){
            $resTactic = $resultTactic['PlanObjTactic'] == 0 ? bcadd(0,'0',2) : bcadd(((float)$resultTactic['RealObjTactic'] / (float)$resultTactic['PlanObjTactic']) * 100,'0',2);
            $dataPorcTactic[] = array('value' => $resTactic);
            $dataPlanTactic[] = array('value' => $resultTactic['PlanObjTactic']);
            $dataRealTactic[] = array('value' => $resultTactic['RealObjTactic']);
            $dataLinkTactic[] = array('typeGroup' => $resultTactic['Gerencia'],'porcCarga' => $resTactic);
            if($resultTactic['Grupo'] == 'CORP'){
                $optionsChart = array('typeLabel' => 'stagger');
                $categories[] = array('label' => $resultTactic['Ref'], 'toolText' => $resultTactic['Gerencia']);
            } else{
                $optionsChart = array('typeLabel' => 'auto');
                $categories[] = array('label' => $resultTactic['Gerencia']);
            }
        }
        $datas['dataPorcTactic'] = $dataPorcTactic;
        $datas['dataPlanTactic'] = $dataPlanTactic;
        $datas['dataRealTactic'] = $dataRealTactic;
        $datas['dataLinkTactic'] = $dataLinkTactic;
        $datas['categories'] = $categories;
        $datas['optionsChart'] = $optionsChart;
        
        return $datas;
    }
    
    /**
     * Función que obtiene los Objetivos Operativos agrupados por tipo de Gerencia de 1ra Línea
     * @return type
     */
    public function getDataObjetiveOperativeByGroupChart($typeGroup){
        $em = $this->getDoctrine()->getManager();
        $datas = array();
        $dataRealOperative = array();
        $dataPlanOperative= array();
        $dataPorcOperative= array();
        $dataLinkOperative = array();
        $categories = array();
        $optionsChart = array();
        
        //Resultados Operativos
        $resultsOperatives = $em->getRepository('PequivenSEIPBundle:Monitor')->getTotalObjetivesOperativeByGerenciaGroup(array('typeGroup' => $typeGroup));
        
        foreach($resultsOperatives as $resultOperative){
            $resOperative = $resultOperative['PlanObjOperative'] == 0 ? bcadd(0,'0',2) : bcadd(((float)$resultOperative['RealObjOperative'] / (float)$resultOperative['PlanObjOperative']) * 100,'0',2);
            $dataPorcOperative[] = array('value' => $resOperative);
            $dataPlanOperative[] = array('value' => $resultOperative['PlanObjOperative']);
            $dataRealOperative[] = array('value' => $resultOperative['RealObjOperative']);
            $dataLinkOperative[] = array('typeGroup' => $resultOperative['Gerencia'],'porcCarga' => $resOperative);
            if($resultOperative['Grupo'] == 'CORP'){
                $optionsChart = array('typeLabel' => 'stagger');
                $categories[] = array('label' => $resultOperative['Ref'], 'toolText' => $resultOperative['Gerencia']);
            } else{
                $optionsChart = array('typeLabel' => 'auto');
                $categories[] = array('label' => $resultOperative['Gerencia']);
            }
        }
        $datas['dataPorcOperative'] = $dataPorcOperative;
        $datas['dataPlanOperative'] = $dataPlanOperative;
        $datas['dataRealOperative'] = $dataRealOperative;
        $datas['dataLinkOperative'] = $dataLinkOperative;
        $datas['categories'] = $categories;
        $datas['optionsChart'] = $optionsChart;
        
        return $datas;
    }
}
