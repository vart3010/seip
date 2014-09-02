<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\IndicatorBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Pequiven\IndicatorBundle\Entity\Indicator;
use Pequiven\IndicatorBundle\Entity\IndicatorLevel;
use Pequiven\ArrangementBundle\Entity\ArrangementRange;
use Pequiven\IndicatorBundle\Form\Type\Tactic\RegistrationFormType as BaseFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController as baseController;

/**
 * Description of IndicatorTacticController
 *
 * @author matias
 */
class IndicatorTacticController extends baseController {
    //put your code here
    
    /**
     * @Template("PequivenIndicatorBundle:Tactic:list.html.twig")
     * @return type
     */
    public function listAction(){
        
        return array(
            
        );
    }
    
    /**
     * Función que devuelve el paginador con los indicadores tácticos
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function indicatorListAction(Request $request){

        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();
        
        $criteria = $request->get('filter',$this->config->getCriteria());
        $sorting = $request->get('sorting',$this->config->getSorting());
        $repository = $this->getRepository();
        
        $criteria['indicatorLevel'] = IndicatorLevel::LEVEL_TACTICO;
        
        if ($this->config->isPaginated()) {
            $resources = $this->resourceResolver->getResource(
                $repository,
                'createPaginatorByLevel',
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
        if($request->get('_format') == 'html'){
            $view->setData($resources);
        }else{
            $formatData = $request->get('_formatData','default');
            
            $view->setData($resources->toArray('',array(),$formatData));
            
        }
        return $this->handleView($view);
    }
    
    /**
     * Función que registra un indicador táctico a partir del registro de un objetivo táctico
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @Template("PequivenIndicatorBundle:Tactic:registerFromObjetive.html.twig")
     * @return type
     * @throws \Pequiven\IndicatorBundle\Controller\Exception
     */
    public function createFromObjetiveAction(Request $request){

        $form = $this->createForm(new BaseFormType());
        $form->handleRequest($request);
        $nameObject = 'object';
        $lastId = '';
        
        $em = $this->getDoctrine()->getManager();
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();
        
        $em->getConnection()->beginTransaction();
        
        if($form->isValid()){
            $object = $form->getData();
            $data =  $this->container->get('request')->get("pequiven_indicator_tacticfo_registration");
            
            $object->setRefParent($data['refObjetive']);
            $object->setTmp(true);
            //$object->setGoal(bcadd(str_replace(',', '.', $data['weight']),'0',3));
            $object->setGoal(bcadd(str_replace(',', '.', $data['goal']),'0',3));
            $object->setUserCreatedAt($user);
            
            //Obtenemos y seteamos el nivel del indicador
            $indicatorLevel = $em->getRepository('PequivenIndicatorBundle:IndicatorLevel')->findOneBy(array('level' => IndicatorLevel::LEVEL_TACTICO));
            $object->setIndicatorLevel($indicatorLevel);
            
            //En caso de que el Indicador tenga Fórmula se obtiene y se setea respectivamente
            if(isset($data['formula'])){
                $formula = $em->getRepository('PequivenMasterBundle:Formula')->findOneBy(array('id' => $data['formula']));
                $object->setFormula($formula);
            }
            
            $em->persist($object);
            
            try{
                $em->flush();
                $lastId = $em->getConnection()->lastInsertId();
                $em->getConnection()->commit();
            } catch (Exception $e){
                $em->getConnection()->rollback();
                throw $e;
            }
            
            $lastObjectInsert = $em->getRepository('PequivenIndicatorBundle:Indicator')->findOneBy(array('id' => $lastId));
            $this->createArrangementRange($lastObjectInsert, $data);
            
            return $this->redirect($this->generateUrl('pequiven_indicator_register_redirect'));
        }
        
        return array(
            'form' => $form->createView(),
            );
    }
    
    /**
     * 
     * @param \Pequiven\IndicatorBundle\Entity\Indicator $indicator
     * @param type $data
     * @return boolean
     * @throws \Pequiven\IndicatorBundle\Controller\Exception
     */
    public function createArrangementRange(Indicator $indicator ,$data = array()){
        $arrangementRange = new ArrangementRange();
        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();
        
        $arrangementRange->setIndicator($indicator);
        //Seteamos los valores de rango alto
        $arrangementRange->setTypeRangeTop($em->getRepository('PequivenMasterBundle:ArrangementRangeType')->findOneBy(array('id' => $data['arrangementRangeTypeTop'])));
        if($data['typeArrangementRangeTypeTop'] == 'TOP_BASIC'){
            $arrangementRange->setRankTop(bcadd(str_replace(',', '.', $data['rankTop']),'0',3));
            $arrangementRange->setOpRankTop($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankTop'])));
        } else{
            $arrangementRange->setRankTopTopTop(bcadd(str_replace(',', '.', $data['rankTopTopTop']),'0',3));
            $arrangementRange->setOpRankTopTopTop($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankTopTopTop'])));
            $arrangementRange->setRankTopTopBottom(bcadd(str_replace(',', '.', $data['rankTopTopBottom']),'0',3));
            $arrangementRange->setOpRankTopTopBottom($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankTopTopBottom'])));
            $arrangementRange->setRankTopBottomTop(bcadd(str_replace(',', '.', $data['rankTopBottomTop']),'0',3));
            $arrangementRange->setOpRankTopBottomTop($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankTopBottomTop'])));
            $arrangementRange->setRankTopBottomBottom(bcadd(str_replace(',', '.', $data['rankTopBottomBottom']),'0',3));
            $arrangementRange->setOpRankTopBottomBottom($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankTopBottomBottom'])));
        }
        //Seteamos los valores de rango medio
        $arrangementRange->setTypeRangeMiddle($em->getRepository('PequivenMasterBundle:ArrangementRangeType')->findOneBy(array('id' => $data['arrangementRangeTypeMiddle'])));
        if($data['typeArrangementRangeTypeMiddle'] == 'MIDDLE_BASIC'){
            $arrangementRange->setRankMiddleTop(bcadd(str_replace(',', '.', $data['rankMiddleTop']),'0',3));
            $arrangementRange->setOpRankMiddleTop($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankMiddleTop'])));
            $arrangementRange->setRankMiddleBottom(bcadd(str_replace(',', '.', $data['rankMiddleBottom']),'0',3));
            $arrangementRange->setOpRankMiddleBottom($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankMiddleBottom'])));
        } else{
            $arrangementRange->setRankMiddleTopTop(bcadd(str_replace(',', '.', $data['rankMiddleTopTop']),'0',3));
            $arrangementRange->setOpRankMiddleTopTop($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankMiddleTopTop'])));
            $arrangementRange->setRankMiddleTopBottom(bcadd(str_replace(',', '.', $data['rankMiddleTopBottom']),'0',3));
            $arrangementRange->setOpRankMiddleTopBottom($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankMiddleTopBottom'])));
            $arrangementRange->setRankMiddleBottomTop(bcadd(str_replace(',', '.', $data['rankMiddleBottomTop']),'0',3));
            $arrangementRange->setOpRankMiddleBottomTop($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankMiddleBottomTop'])));
            $arrangementRange->setRankMiddleBottomBottom(bcadd(str_replace(',', '.', $data['rankMiddleBottomBottom']),'0',3));
            $arrangementRange->setOpRankMiddleBottomBottom($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankMiddleBottomBottom'])));
        }
        //Seteamos los valores de rango bajo
        $arrangementRange->setTypeRangeBottom($em->getRepository('PequivenMasterBundle:ArrangementRangeType')->findOneBy(array('id' => $data['arrangementRangeTypeBottom'])));
        if($data['typeArrangementRangeTypeBottom'] == 'BOTTOM_BASIC'){
            $arrangementRange->setRankBottom(bcadd(str_replace(',', '.', $data['rankBottom']),'0',3));
            $arrangementRange->setOpRankBottom($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankBottom'])));
        } else{
            $arrangementRange->setRankBottomTopTop(bcadd(str_replace(',', '.', $data['rankBottomTopTop']),'0',3));
            $arrangementRange->setOpRankBottomTopTop($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankBottomTopTop'])));
            $arrangementRange->setRankBottomTopBottom(bcadd(str_replace(',', '.', $data['rankBottomTopBottom']),'0',3));
            $arrangementRange->setOpRankBottomTopBottom($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankBottomTopBottom'])));
            $arrangementRange->setRankBottomBottomTop(bcadd(str_replace(',', '.', $data['rankBottomBottomTop']),'0',3));
            $arrangementRange->setOpRankBottomBottomTop($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankBottomBottomTop'])));
            $arrangementRange->setRankBottomBottomBottom(bcadd(str_replace(',', '.', $data['rankBottomBottomBottom']),'0',3));
            $arrangementRange->setOpRankBottomBottomBottom($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankBottomBottomBottom'])));
        }

        $em->persist($arrangementRange);
        
        try{
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $e){
            $em->getConnection()->rollback();
            throw $e;
        }
        
        return true;
    }
    
    /**
     * Devuelve los Indicadores Tácticos de acuerdo a la Línea Estratégica que este
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function selectIndicatorTacticFromRefParentAction(Request $request){
        $response = new JsonResponse();
        
        $indicatorsStrategic = array();
        $em = $this->getDoctrine()->getManager();
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();
        
        $refParentId = $request->request->get('refParentId');
        $indicatorLevelId = IndicatorLevel::LEVEL_TACTICO;
        
        $results = $em->getRepository('PequivenIndicatorBundle:Indicator')->findBy(array('refParent' => $refParentId, 'indicatorLevel' => $indicatorLevelId, 'tmp' => true));
        $totalResults = count($results);
        
        if(is_array($results) && $totalResults > 0){
            foreach ($results as $result){
                $indicatorsStrategic[] = array("id" => $result->getId(), "description" => $result->getRef() . ' ' . $result->getDescription());
            }
        } else{
            $indicatorsStrategic[] = array("empty" => true);
        }
        
        $response->setData($indicatorsStrategic);
        
        return $response;
    }
    
    /**
     * Devuelve la Referencia del Indicador, de acuerdo a la cantidad que ya se encuentren registrados por línea estratégica
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function displayRefIndicatorAction(Request $request){
        $response = new JsonResponse();
        $indicator = new Indicator();
        $data = array();
        $options = array();
        
        $lineStrategicId = $request->request->get('lineStrategicId');
        $options['lineStrategicId'] = $lineStrategicId;
        $options['type'] = 'TACTIC';
        $ref = $indicator->setNewRef($options);
        
        $data[] = array('ref' => $ref);
        $response->setData($data);
        return $response;
    }
    
    /**
     * Devuelve la Referencia del Indicador, de acuerdo a la cantidad que ya se encuentren registrados para el objetivo táctico que se esta creando
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function displayRefIndicatorFromObjetiveAction(Request $request){
        $response = new JsonResponse();
        $indicator = new Indicator();
        $data = array();
        $options = array();
        
        $refParent =  $request->request->get('refParentId');
        $options['refParent'] = $refParent;
        $options['type'] = 'TACTIC';
        $ref = $indicator->setNewRefFromObjetive($options);
        
        $data[] = array('ref' => $ref);
        $response->setData($data);
        return $response;
    }
}
