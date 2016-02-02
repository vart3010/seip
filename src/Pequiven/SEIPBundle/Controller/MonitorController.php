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
use Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram;
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
     * Función que renderiza el Monitor de Objetivos Tácticos
     * @Template("PequivenSEIPBundle:Monitor:Tactic/objetiveGerenciaFirstGroup.html.twig")
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return type
     */
    public function displayObjetiveTacticAction(Request $request){
        
        $datas = $this->getDataObjetiveTacticGroupChart();
        
        $boxRender = $this->get('tecnocreaciones_box.render');
        return array(
            'dataPlanTactic' => $datas['dataPlanTactic'],
            'dataRealTactic' => $datas['dataRealTactic'],
            'dataPorcTactic' => $datas['dataPorcTactic'],
            'dataLinkTactic' => $datas['dataLinkTactic'],
            'optionsChart' => $datas['optionsChart'],
            'categories' => $datas['categories'],
            'boxRender' => $boxRender,
        );
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
     * Función que renderiza el Monitor de Programas de Gestión
     * @Template("PequivenSEIPBundle:Monitor:ArrangementProgram/gerenciaFirstGroup.html.twig")
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return type
     */
    public function displayArrangementProgramAction(Request $request){
        
        $datas = $this->getDataArrangementProgramGroupChart();
        return array(
            'dataPlan' => $datas['dataPlan'],
            'dataReal' => $datas['dataReal'],
            'dataPorc' => $datas['dataPorc'],
            'dataLink' => $datas['dataLink'],
            'optionsChart' => $datas['optionsChart'],
            'categories' => $datas['categories'],
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
        $boxRender = $this->get('tecnocreaciones_box.render');
        return array(
            'dataPlanTactic' => $datas['dataPlanTactic'],
            'dataRealTactic' => $datas['dataRealTactic'],
            'dataPorcTactic' => $datas['dataPorcTactic'],
            'dataLinkTactic' => $datas['dataLinkTactic'],
            'categories' => $datas['categories'],
            'gerenciaGroup' => $objectGerenciaGroup,
            'boxRender' => $boxRender,
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
        $boxRender = $this->get('tecnocreaciones_box.render');
        
        return array(
            'dataPlanOperative' => $datas['dataPlanOperative'],
            'dataRealOperative' => $datas['dataRealOperative'],
            'dataPorcOperative' => $datas['dataPorcOperative'],
            'dataLinkOperative' => $datas['dataLinkOperative'],
            'categories' => $datas['categories'],
            'gerenciaGroup' => $objectGerenciaGroup,
            'boxRender' => $boxRender,
            'optionsChart' => $datas['optionsChart']
        );
    }
    
    /**
     * Función que renderiza el Monitor de Programas de Gestión por Tipo de Grupo de Gerencia de 1ra Línea
     * @Template("PequivenSEIPBundle:Monitor:ArrangementProgram/gerenciaFirstByGroup.html.twig")
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return type
     */
    
    public function displayArrangementProgramByGroupAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $typeGroup = $request->get("typeGroup");
        
        $objectGerenciaGroup = $em->getRepository('PequivenMasterBundle:GerenciaGroup')->findOneBy(array('groupName' => $typeGroup));

        $datas = $this->getDataArrangementProgramByGroupChart($typeGroup);
        
        return array(
            'dataPlan' => $datas['dataPlan'],
            'dataReal' => $datas['dataReal'],
            'dataPorc' => $datas['dataPorc'],
            'dataLink' => $datas['dataLink'],
            'categories' => $datas['categories'],
            'gerenciaGroup' => $objectGerenciaGroup,
            'optionsChart' => $datas['optionsChart']
        );
    }
    
    /**
     * Función que obtiene los Objetivos Tácticos agrupados por tipo de Gerencia de 1ra Línea
     * @return type
     */
    public function getDataObjetiveTacticGroupChart(){
        $em = $this->getDoctrine()->getManager();
        $datas = array();
        $dataRealTactic = array();
        $dataPlanTactic = array();
        $dataPorcTactic = array();
        $dataLinkTactic = array();
        $categories = array();
        
        //Resultados Tácticos
        $resultsTactics = $this->container->get('pequiven.repository.monitor')->getTotalObjetivesTacticByGerenciaGroup();
        
        foreach($resultsTactics as $resultTactic){
            $resTactic = $resultTactic['PlanObjTactic'] == 0 ? bcadd(0,'0',2) : bcadd(((float)$resultTactic['RealObjTactic'] / (float)$resultTactic['PlanObjTactic']) * 100,'0',2);
            $urlTypeGroup =  $this->generateUrl('monitorObjetiveTacticByGroup', array('typeGroup' => $resultTactic['Grupo']));
            $dataPorcTactic[] = array('value' => $resTactic, 'link' => $urlTypeGroup);
            $dataPlanTactic[] = array('value' => $resultTactic['PlanObjTactic'], 'link' => $urlTypeGroup);
            $dataRealTactic[] = array('value' => $resultTactic['RealObjTactic'], 'link' => $urlTypeGroup);
            $dataLinkTactic[] = array('typeGroup' => $resultTactic['Descripcion'],'porcCarga' => $resTactic, 'linkTypeGroup' => $urlTypeGroup);
            $categories[] = array('label' => $resultTactic['Descripcion']);
        }
        $optionsChart = array('typeLabel' => 'auto');
        
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
    public function getDataObjetiveOperativeGroupChart(){
        $em = $this->getDoctrine()->getManager();
        $datas = array();
        $dataRealOperative = array();
        $dataPlanOperative = array();
        $dataPorcOperative = array();
        $dataLinkOperative = array();
        $categories = array();
        
        //Resultados Operativos
        $resultsOperatives = $this->container->get('pequiven.repository.monitor')->getTotalObjetivesOperativeByGerenciaGroup();
        
        foreach($resultsOperatives as $resultOperative){
            $linkGrupo = $this->generateUrl('monitorObjetiveOperativeByGroup', array('typeGroup' => $resultOperative['Grupo']));
            $resOperative = $resultOperative['PlanObjOperative'] == 0 ? bcadd(0,'0',2) : bcadd(((float)$resultOperative['RealObjOperative'] / (float)$resultOperative['PlanObjOperative']) * 100,'0',2);
            $dataPorcOperative[] = array('value' => $resOperative, 'link' => $linkGrupo);
            $dataPlanOperative[] = array('value' => $resultOperative['PlanObjOperative'], 'link' => $linkGrupo);
            $dataRealOperative[] = array('value' => $resultOperative['RealObjOperative'], 'link' => $linkGrupo);
            $dataLinkOperative[] = array('typeGroup' => $resultOperative['Descripcion'],'porcCarga' => $resOperative,'linkTypeGroup' => $linkGrupo);
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
     * Función que obtiene los Programas de Gestión agrupados por tipo de Gerencia de 1ra Línea
     * @return type
     */
    public function getDataArrangementProgramGroupChart(){
        $em = $this->getDoctrine()->getManager();
        $datas = array();
        $dataReal = array();
        $dataPlan= array();
        $dataPorc= array();
        $dataLink= array();
        $categories = array();
        
        //Resultados
        $results = $this->container->get('pequiven.repository.monitor')->getTotalArrangementProgramByGerenciaGroup();
        
        foreach($results as $result){
            $linkGrupo = $this->generateUrl('monitorArrangementProgramByGroup', array('typeGroup' => $result['Grupo']));
            $res = $result['PlanArrPro'] == 0 ? bcadd(0,'0',2) : bcadd(((float)$result['RealArrPro'] / (float)$result['PlanArrPro']) * 100,'0',2);
            $dataPorc[] = array('value' => $res , 'link' => $linkGrupo);
            $dataPlan[] = array('value' => $result['PlanArrPro'], 'link' => $linkGrupo);
            $dataReal[] = array('value' => $result['RealArrPro'], 'link' => $linkGrupo);
            $dataLink[] = array('typeGroup' => $result['Descripcion'],'porcCarga' => $res ,'linkTypeGroup' => $linkGrupo);
            $categories[] = array('label' => $result['Descripcion']);
        }
        $optionsChart = array('typeLabel' => 'auto');
        
        $datas['dataPorc'] = $dataPorc;
        $datas['dataPlan'] = $dataPlan;
        $datas['dataReal'] = $dataReal;
        $datas['dataLink'] = $dataLink;
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
        $resultsTactics = $this->container->get('pequiven.repository.monitor')->getTotalObjetivesTacticByGerenciaGroup(array('typeGroup' => $typeGroup));
        
        foreach($resultsTactics as $resultTactic){
            $resTactic = $resultTactic['PlanObjTactic'] == 0 ? bcadd(0,'0',2) : bcadd(((float)$resultTactic['RealObjTactic'] / (float)$resultTactic['PlanObjTactic']) * 100,'0',2);
            $urlGerencia = $this->generateUrl('listObjetiveTacticByGroup', array('typeGroup' => $typeGroup,'idGerencia' => $resultTactic['idGerencia']));
            $dataPorcTactic[] = array('value' => $resTactic, 'link' => $urlGerencia);
            $dataPlanTactic[] = array('value' => $resultTactic['PlanObjTactic'], 'link' => $urlGerencia);
            $dataRealTactic[] = array('value' => $resultTactic['RealObjTactic'], 'link' => $urlGerencia);
            $dataLinkTactic[] = array('typeGroup' => $resultTactic['Gerencia'],'porcCarga' => $resTactic, 'urlGerencia' => $urlGerencia);
            if($resultTactic['Grupo'] == 'CORP'){
                $optionsChart = array('typeLabel' => 'stagger');
                $categories[] = array('label' => $resultTactic['Resume'], 'toolText' => $resultTactic['Gerencia']);
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
        $resultsOperatives = $this->container->get('pequiven.repository.monitor')->getTotalObjetivesOperativeByGerenciaGroup(array('typeGroup' => $typeGroup));
        
        foreach($resultsOperatives as $resultOperative){
            $resOperative = $resultOperative['PlanObjOperative'] == 0 ? bcadd(0,'0',2) : bcadd(((float)$resultOperative['RealObjOperative'] / (float)$resultOperative['PlanObjOperative']) * 100,'0',2);
            $urlGerencia = $this->generateUrl('listObjetiveOperativeByGroup', array('typeGroup' => $typeGroup,'idGerencia' => $resultOperative['idGerencia']));
            $dataPorcOperative[] = array('value' => $resOperative, 'link' => $urlGerencia);
            $dataPlanOperative[] = array('value' => $resultOperative['PlanObjOperative'], 'link' => $urlGerencia);
            $dataRealOperative[] = array('value' => $resultOperative['RealObjOperative'], 'link' => $urlGerencia);
            $dataLinkOperative[] = array('typeGroup' => $resultOperative['Gerencia'],'porcCarga' => $resOperative, 'urlGerencia' => $urlGerencia);
            if($resultOperative['Grupo'] == 'CORP'){
                $optionsChart = array('typeLabel' => 'stagger');
                $categories[] = array('label' => $resultOperative['Resume'], 'toolText' => $resultOperative['Gerencia']);
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
    
    /**
     * Función que obtiene los Programas de Gestión agrupados por tipo de Gerencia de 1ra Línea
     * @return type
     */
    public function getDataArrangementProgramByGroupChart($typeGroup){
        $em = $this->getDoctrine()->getManager();
        $datas = array();
        $dataReal = array();
        $dataPlan= array();
        $dataPorc= array();
        $dataLink= array();
        $categories = array();
        $optionsChart = array();
        
        //Resultados
        $results = $this->container->get('pequiven.repository.monitor')->getTotalArrangementProgramByGerenciaGroup(array('typeGroup' => $typeGroup));
        
        foreach($results as $result){
            $res = $result['PlanArrPro'] == 0 ? bcadd(0,'0',2) : bcadd(((float)$result['RealArrPro'] / (float)$result['PlanArrPro']) * 100,'0',2);
            $urlGerencia = $this->generateUrl('pequiven_seip_arrangementprogram_by_gerencia', array('typeGroup' => $typeGroup,'idGerencia' => $result['idGerencia']));
            $dataPorc[] = array('value' => $res, 'link' => $urlGerencia);
            $dataPlan[] = array('value' => $result['PlanArrPro'], 'link' => $urlGerencia);
            $dataReal[] = array('value' => $result['RealArrPro'], 'link' => $urlGerencia);
            $dataLink[] = array('typeGroup' => $result['Gerencia'],'porcCarga' => $res, 'urlGerencia' => $urlGerencia);
            if($result['Grupo'] == 'CORP'){
                $optionsChart = array('typeLabel' => 'stagger');
                $categories[] = array('label' => $result['Resume'], 'toolText' => $result['Gerencia']);
            } else{
                $optionsChart = array('typeLabel' => 'auto');
                $categories[] = array('label' => $result['Gerencia']);
            }
        }
        $datas['dataPorc'] = $dataPorc;
        $datas['dataPlan'] = $dataPlan;
        $datas['dataReal'] = $dataReal;
        $datas['dataLink'] = $dataLink;
        $datas['categories'] = $categories;
        $datas['optionsChart'] = $optionsChart;
        
        return $datas;
    }
    
    /**
     * Función que retorna la vista con la lista de los Objetivos Tácticos
     * @Template("PequivenSEIPBundle:Monitor:Tactic/viewObjetiveByGerenciaFirst.html.twig")
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return type
     */
    public function listObjetiveTacticByGroupAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        
        $idGerencia = $request->get("idGerencia");
        $typeGroup = $request->get("typeGroup");
        
        $url = $this->generateUrl('objetiveTacticList', array('_format' => 'json','filter' => array('gerencia' => $idGerencia)));
        $urlReturn = $this->generateUrl('monitorObjetiveTacticByGroup', array('typeGroup' => $typeGroup));
        $gerencia = $this->get('pequiven.repository.gerenciafirst')->findOneBy(array('id' => $idGerencia));
        
        return array(
            'url' => $url,
            'urlReturn' => $urlReturn,
            'gerencia' => $gerencia
        );
    }
    
    /**
     * Función que retorna la vista con la lista de los Objetivos Operativos
     * @Template("PequivenSEIPBundle:Monitor:Operative/viewObjetiveByGerenciaFirst.html.twig")
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return type
     */
    public function listObjetiveOperativeByGroupAction(Request $request){
        $idGerencia = $request->get("idGerencia");
        $typeGroup = $request->get("typeGroup");
        $em = $this->getDoctrine()->getManager();
        $monitor = $this->container->get('pequiven.repository.monitor')->findOneBy(array('gerencia' => $idGerencia));
        $objectGerenciaGroup = $em->getRepository('PequivenMasterBundle:GerenciaGroup')->findOneBy(array('id' => $monitor->getTypeGroup()->getId()));
        $gerencia = $this->get('pequiven.repository.gerenciafirst')->findOneBy(array('id' => $idGerencia));
        
        $url = $this->generateUrl('objetiveOperativeList', array('_format' => 'json','filter' => array('gerenciaFirst' => $idGerencia)));
        $urlReturn = $this->generateUrl('monitorObjetiveOperativeByGroup', array('typeGroup' => $typeGroup));
        $urlVinculant = $this->generateUrl('listObjetiveOperativeVinculant', array('typeGroup' => $typeGroup,'idGerencia' => $idGerencia,'idComplejo' => $gerencia->getComplejo()->getId()));
        
        return array(
            'url' => $url,
            'urlVinculant' => $urlVinculant,
            'urlReturn' => $urlReturn,
            'gerenciaGroup' => $objectGerenciaGroup,
            'gerencia' => $gerencia
        );
    }
    
    /**
     * Función que retorna la vista con la lista de los Objetivos Operativos VInculantes a un Complejo
     * @Template("PequivenSEIPBundle:Monitor:Operative/viewObjetiveVinculant.html.twig")
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return type
     */
    public function listObjetiveOperativeVinculantAction(Request $request){
        $idGerencia = $request->get("idGerencia");
        $idComplejo = $request->get("idComplejo");
        $typeGroup = $request->get("typeGroup");
        $em = $this->getDoctrine()->getManager();
        
        $monitor = $this->container->get('pequiven.repository.monitor')->findOneBy(array('gerencia' => $idGerencia));
        $objectGerenciaGroup = $em->getRepository('PequivenMasterBundle:GerenciaGroup')->findOneBy(array('id' => $monitor->getTypeGroup()->getId()));
        $gerencia = $this->get('pequiven.repository.gerenciafirst')->findOneBy(array('id' => $idGerencia));
        
        $url = $this->generateUrl('objetiveVinculantOperativeList', array('_format' => 'json','filter' => array('gerencia' => $idGerencia,'complejo' => $idComplejo)));
        $urlMedular = $this->generateUrl('listObjetiveOperativeByGroup', array('typeGroup' => $typeGroup,'idGerencia' => $idGerencia));
        $urlReturn = $this->generateUrl('monitorObjetiveOperativeByGroup', array('typeGroup' => $typeGroup));
        
        return array(
            'url' => $url,
            'urlMedular' => $urlMedular,
            'urlReturn' => $urlReturn,
            'gerenciaGroup' => $objectGerenciaGroup,
            'gerencia' => $gerencia
        );
    }
    
    /**
     * Función que retorna la vista con la lista de los Programas de Gestión
     * @Template("PequivenArrangementProgramBundle:ArrangementProgram:viewByGerenciaFirst.html.twig")
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return type
     */
    public function listArrangementProgramByGroupAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        
        $idGerencia = $request->get("idGerencia");
        $typeGroup = $request->get("typeGroup");
        
        $url = $this->generateUrl('pequiven_seip_arrangementprogram_by_gerencia', array('_format' => 'json','filter' => array('gerencia' => $idGerencia)));
        $urlReturn = $this->generateUrl('monitorArrangementProgramByGroup', array('typeGroup' => $typeGroup));
        $gerencia = $this->get('pequiven.repository.gerenciafirst')->findOneBy(array('id' => $idGerencia));
        
        $labelsStatus = array();
            foreach (ArrangementProgram::getLabelsStatus() as $key => $value) {
                $labelsStatus[] = array(
                    'id' => $key,
                    'description' => $this->trans($value,array(),'PequivenArrangementProgramBundle'),
                );
            }
        
        return array(
            'url' => $url,
            'urlReturn' => $urlReturn,
            'labelsStatus' => $labelsStatus,
            'gerencia' => $gerencia
        );
    }
    
    //SECCIÓN DATA-LOAD
    /**
     * Función que renderiza el Dashboard de Producción por 
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return type
     */
    public function displayDashboardProductionAction(Request $request){
        
        $typeView = $request->get('typeView');
        
        $boxRender = $this->get('tecnocreaciones_box.render');
        $data = array(
            'boxRender' => $boxRender,
            'typeView' => $typeView,
        );
        
        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('Dashboard\DataLoad\Production\index.html'))
            ->setTemplateVar($this->config->getResourceName())
            ->setData($data)
        ;

        return $this->handleView($view);
    }
    
    /**
     * Función que renderiza el Dashboard de Producción por 
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return type
     */
    public function displayDashboardProductionReportTemplateAction(Request $request){
        $answer = $request->get('r');        
        $typeView = $request->get('typeView');
        $reportTemplateId = $request->get('reportTemplateId');
        $boxRender = $this->get('tecnocreaciones_box.render');
        
        $reportTemplateRepository = $this->container->get('pequiven.repository.report_template');
        
        $reportTemplate = $reportTemplateRepository->find($reportTemplateId);        
        
        $reportArray = $this->reportTemplateArray($reportTemplateRepository);
        $host= $_SERVER["HTTP_HOST"];

        $data = array(
            'boxRender'       => $boxRender,
            'typeView'        => $typeView,
            'reportTemplate'  => $reportTemplate,
            'reportArray'     => $reportArray,
            'host'            => $host,
            'answer'          => $answer
        );
        
        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('Dashboard\DataLoad\Production\ReportTemplate\index.html'))
            ->setTemplateVar($this->config->getResourceName())
            ->setData($data)
        ;

        return $this->handleView($view);
    }

    /**
     * Función que retorna un arreglo con las plantas a mostrar 
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return type
     */
    public function reportTemplateArray($reportTemplateRepository){
        //$host= $_SERVER["HTTP_HOST"];
        //$url= $_SERVER["REQUEST_URI"];

        $reportTemplateArray = $reportTemplateRepository->findBy(array('period' => $this->getPeriodService()->getPeriodActive()));        
        $reportArray = [];
        $reportUser = $this->getUser()->getReportTemplates();
        
        if($this->getSecurityService()->isGranted(array('ROLE_SEIP_OPERATION_REPORT_TEMPLATES_ALL'))){
            foreach ($reportTemplateArray as $valueReport) {
                $reportArray[] = $valueReport->getId();                            
            } 
        }else{
            foreach ($reportUser as $value) {                    
                $reportArray[] = $value->getId();                                            
            }            
        }

        return json_encode($reportArray);
    }

    /**
     * @return \Pequiven\SEIPBundle\Service\PeriodService
     */
    protected function getPeriodService()
    {
        return $this->container->get('pequiven_seip.service.period');
    }

     /**
     * 
     * @return \Pequiven\SEIPBundle\Service\SecurityService
     */
    protected function getSecurityService() {
        return $this->container->get('seip.service.security');
    }
}
