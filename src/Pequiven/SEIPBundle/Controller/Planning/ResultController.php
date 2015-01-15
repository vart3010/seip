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
     * Función que renderiza el Monitor de Objetivos Operativos
     * @Template("PequivenSEIPBundle:Planning:Result/Operative/showMonitor.html.twig")
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return type
     */
    public function showMonitorOperativeAction(Request $request) {
        $categories = array();
        $resultIndicator = array();                
        $resultArrangementProgram = array();                
        
        $em = $this->getDoctrine();
        $id = $request->get('id');
        
        $gerenciaSecond = $em->getRepository('PequivenMasterBundle:GerenciaSecond')->findOneBy(array('id' => $id));
        $object = $em->getRepository('PequivenObjetiveBundle:Objetive')->getObjetivesByGerenciaSecond($gerenciaSecond);
        $entity = $gerenciaSecond;
        
        //Configuramos el alto del gráfico
        $totalObjects = count($object);
        $heightChart = ($totalObjects * 30) + 150;
        
        //Data del gráfico
        foreach($object as $objetive){
            $refObjetive = $objetive->getRef();
            $flagResultIndicator = false;
            $flagResultArrangementProgram = false;
            $categories[] = array('label' => $refObjetive);
            foreach($objetive->getResults() as $result){
                $urlObjetive =  $this->generateUrl('objetiveOperative_show', array('id' => $objetive->getId()));
                if($result->getTypeResult() == \Pequiven\SEIPBundle\Model\Result\Result::TYPE_RESULT_INDICATOR){
                    $resultIndicator[] = array('value' => bcadd($result->getResultWithWeight(),'0',2),'link' => $urlObjetive);
                    $flagResultIndicator = true;
                }
                if($result->getTypeResult() == \Pequiven\SEIPBundle\Model\Result\Result::TYPE_RESULT_ARRANGEMENT_PROGRAM){
                    $resultArrangementProgram[] = array('value' => bcadd($result->getResultWithWeight(),'0',2),'link' => $urlObjetive, 'bgColor' => '');
                    $flagResultArrangementProgram = true;
                }
            }
            
            if(!$flagResultArrangementProgram){
                $resultArrangementProgram[] = array('value' => bcadd(0,'0',2));
            }
            if(!$flagResultIndicator){
                $resultIndicator[] = array('value' => bcadd(0,'0',2));
            }
        }
        

        return array(
            'object' => $object,
            'entity' => $entity,
            'categories' => $categories,
            'resultIndicator' => $resultIndicator,
            'resultArrangementProgram' => $resultArrangementProgram,
            'heightChart' => $heightChart,
        );
    }
    
    /**
     * Función que renderiza el Monitor de Objetivos Operativos
     * 
     * @Template("PequivenSEIPBundle:Planning:Result/Operative/showMonitor.html.twig")
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return type
     */
    public function showMonitorAction(Request $request) {
        $categories = array();
        $resultIndicator = $resultArrangementProgram = $resultObjetives = array();
        $showResultObjetives = false;
        $level = $request->get('level');
        
        $em = $this->getDoctrine();
        $id = $request->get('id');
        
        $tree = $objetives = array();
        $caption = '';
        if($level == \Pequiven\SEIPBundle\Model\Common\CommonObject::LEVEL_GERENCIA){
            $showResultObjetives = true;
            $caption = $this->trans('result.captionObjetiveTactical',array(),'PequivenSEIPBundle');
            $gerencia = $em->getRepository('PequivenMasterBundle:Gerencia')->findWithObjetives($id);
            $objetives = $gerencia->getTacticalObjectives();
            foreach ($objetives as $objetive) {
                foreach ($objetive->getParents() as $parent) {
                    if(!isset($tree[(string)$parent])){
                        $tree[(string)$parent] = array(
                            'parent' => $parent,
                            'child' => array(),
                        );
                    }
                    $tree[(string)$parent]['child'][(string)$objetive] = $objetive;
                }
            }
            $entity = $gerencia;
        }elseif($level == \Pequiven\SEIPBundle\Model\Common\CommonObject::LEVEL_GERENCIA_SECOND){
            $caption = $this->trans('result.captionObjetiveOperative',array(),'PequivenSEIPBundle');
            $gerenciaSecond = $em->getRepository('PequivenMasterBundle:GerenciaSecond')->findWithObjetives($id);
            $objetives = $gerenciaSecond->getOperationalObjectives();
            foreach ($objetives as $objetive) {
                foreach ($objetive->getParents() as $parent) {
                    if(!isset($tree[(string)$parent])){
                        $tree[(string)$parent] = array(
                            'parent' => $parent,
                            'child' => array(),
                        );
                    }
                    $tree[(string)$parent]['child'][(string)$objetive] = $objetive;
                }
            }
            $entity = $gerenciaSecond;
        }
        $subCaption = $this->trans('result.subCaptionObjetiveOperative',array(),'PequivenSEIPBundle');
        $data = array(
            'dataSource' => array(
                'chart' => array(
                    'caption' => $caption,
                    'subCaption' => $subCaption,
                ),
                'categories' => array(
                    'category' => array(),
                ),
                'dataset' => array(),
            ),
        );
        //Configuramos el alto del gráfico
        $totalObjects = count($objetives);
        $heightChart = ($totalObjects * 30) + 150;
        
        //Data del gráfico
        foreach($objetives as $objetive){
            $refObjetive = $objetive->getRef();
            $flagResultIndicator = $flagResultArrangementProgram = $flagResultObjetives = false;
            $categories[] = array('label' => $refObjetive);
            foreach($objetive->getResults() as $result){
                $urlObjetive =  $this->generateUrl('objetiveOperative_show', array('id' => $objetive->getId()));
                $totalIndicator = 0.0;
                $totalObjetives = 0.0;
                $flagResultIndicatorInternal = false;
                $flagResultObjetivesInternal = false;
                
                if($result->getTypeResult() == \Pequiven\SEIPBundle\Model\Result\Result::TYPE_RESULT_INDICATOR){
                    $totalIndicator += $result->getResultWithWeight();
                    $flagResultIndicator = $flagResultIndicatorInternal = true;
                }
                if($result->getTypeResult() == \Pequiven\SEIPBundle\Model\Result\Result::TYPE_RESULT_ARRANGEMENT_PROGRAM){
                    $resultArrangementProgram[] = array('value' => bcadd($result->getResultWithWeight(),'0',2),'link' => $urlObjetive, 'bgColor' => '');
                    $flagResultArrangementProgram = true;
                }
                if($result->getTypeResult() == \Pequiven\SEIPBundle\Model\Result\Result::TYPE_RESULT_OBJECTIVE){
                    $totalObjetives+= $result->getResultWithWeight();
                    $flagResultObjetives = $flagResultObjetivesInternal = true;
                }
                if($result->getTypeResult() == \Pequiven\SEIPBundle\Model\Result\Result::TYPE_RESULT_OF_RESULT){
                    foreach ($result->getChildrens() as $child) {
                        if($child->getTypeResult() == \Pequiven\SEIPBundle\Model\Result\Result::TYPE_RESULT_INDICATOR){
                            $totalIndicator += $child->getResultWithWeight();
                            $flagResultIndicator = $flagResultIndicatorInternal = true;
                        }elseif($child->getTypeResult() == \Pequiven\SEIPBundle\Model\Result\Result::TYPE_RESULT_OBJECTIVE){
                            $totalObjetives+= $child->getResultWithWeight();
                            $flagResultObjetives = $flagResultObjetivesInternal = true;
                        }
                    }
                }
                
                if($flagResultIndicatorInternal === true){
                    $resultIndicator[] = array('value' => bcadd($totalIndicator,'0',2),'link' => $urlObjetive);
                }
                if($flagResultObjetivesInternal === true){
                    $resultObjetives[] = array('value' => bcadd($totalObjetives,'0',2),'link' => $urlObjetive, 'bgColor' => '');
                }
            }
            
            //Completar valores para que no de error.
            if(!$flagResultArrangementProgram){
                $resultArrangementProgram[] = array('value' => bcadd(0,'0',2));
            }
            if(!$flagResultIndicator){
                $resultIndicator[] = array('value' => bcadd(0,'0',2));
                
            }
            if(!$flagResultObjetives){
                $resultObjetives[] = array('value' => bcadd(0,'0',2));
            }
        }
        if(count($resultIndicator) > 0){
            $data['dataSource']['dataset'][] = array(
                    'seriesname' => $this->trans('chart.result.objetiveOperative.seriesNamePlan1'),
                    'data' => $resultIndicator,
                );
        }
        if(count($resultArrangementProgram) > 0){
            $data['dataSource']['dataset'][] = array(
                'seriesname' => $this->trans('chart.result.objetiveOperative.seriesNamePlan2'),
                'data' => $resultArrangementProgram,
            );
        }
        if($showResultObjetives && count($resultObjetives) > 0){
            $data['dataSource']['dataset'][] = array(
                'seriesname' => $this->trans('chart.result.objetiveOperative.seriesNamePlan3'),
                'data' => $resultObjetives,
            );
        }
        
        $data['dataSource']['categories']['category'] = $categories;
        
        $resultService = $this->getResultService();
        
        return array(
            'object' => $objetives,
            'entity' => $entity,
            'heightChart' => $heightChart,
            'data' => $data,
            'tree' => $tree,
            'resultService' => $resultService,
        );
    }
    
    protected function trans($id,array $parameters = array(), $domain = 'messages')
    {
        return $this->get('translator')->trans($id, $parameters, $domain);
    }
    
    /**
     * Servicio de resultados
     * @return \Pequiven\SEIPBundle\Service\ResultService
     */
    private function getResultService(){
        return $this->container->get('seip.service.result');
    }
}
