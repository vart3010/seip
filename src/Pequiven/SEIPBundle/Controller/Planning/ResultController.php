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
        
        $totalObjects = count($object);
        $heightChart = ($totalObjects * 30) + 100;
        
        //Data del gráfico
        foreach($object as $objetive){
            $categories[] = array('label' => $objetive->getRef());
            foreach($objetive->getResults() as $result){
                $urlObjetive =  $this->generateUrl('objetiveOperative_show', array('id' => $objetive->getId()));
                $resultIndicator[] = $result->getTypeResult() == \Pequiven\SEIPBundle\Model\Result\Result::TYPE_RESULT_INDICATOR ? array('value' => bcadd($result->getResultWithWeight(),'0',2),'link' => $urlObjetive) : bcadd(0,'0',2);
                $resultArrangementProgram[] = $result->getTypeResult() == \Pequiven\SEIPBundle\Model\Result\Result::TYPE_RESULT_ARRANGEMENT_PROGRAM ? array('value' => bcadd($result->getResultWithWeight(),'0',2),'link' => $urlObjetive, 'bgColor' => '') : bcadd(0,'0',2);
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
}
