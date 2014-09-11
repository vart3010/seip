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
use Pequiven\IndicatorBundle\Form\Type\Strategic\RegistrationFormType as BaseFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController as baseController;
/**
 * Description of IndicatorStrategicController
 *
 * @author matias
 */
class IndicatorStrategicController extends baseController {
    
    /** Función que retorna la vista con la lista de los indicadores estratégicos
     * @Template("PequivenIndicatorBundle:Strategic:list.html.twig")
     * @return type
     */
    public function listAction(){
        
        return array(
            
        );
    }
    
    /**
     * Función que devuelve el paginador con los indicadores estratégicos
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function indicatorListAction(Request $request){

        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();
        
        $criteria = $request->get('filter',$this->config->getCriteria());
        $sorting = $request->get('sorting',$this->config->getSorting());
        $repository = $this->getRepository();
        
        $criteria['indicatorLevel'] = IndicatorLevel::LEVEL_ESTRATEGICO;
        
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
     * Función que registra un indicador estratégico a partir del registro de un objetivo estratégico
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @Template("PequivenIndicatorBundle:Strategic:registerFromObjetive.html.twig")
     * @return type
     * @throws \Pequiven\IndicatorBundle\Controller\Exception
     */
    public function createFromObjetiveAction(Request $request){
        
        $form = $this->createForm(new BaseFormType('fromObjetive'));
        $form->handleRequest($request);
        $nameObject = 'object';
        $lastId = '';
        
        $em = $this->getDoctrine()->getManager();
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();
        
        $em->getConnection()->beginTransaction();
        
        if($form->isValid()){
            $object = $form->getData();
            $data =  $this->container->get('request')->get("pequiven_indicator_strategicfo_registration");
            
            $object->setRefParent($data['refObjetive']);
            $object->setTmp(true);
            //$object->setGoal(bcadd(str_replace(',', '.', $data['weight']),'0',3));
            $object->setGoal(bcadd(str_replace(',', '.', $data['goal']),'0',3));
            $object->setUserCreatedAt($user);
            //Obtenemos y seteamos la línea estratégica del indicador
            $object->setLineStrategic($em->getRepository('PequivenMasterBundle:LineStrategic')->findOneBy(array('id' => $data['lineStrategicObjetive'])));
            //Obtenemos y seteamos el nivel del indicador
            $indicatorLevel = $em->getRepository('PequivenIndicatorBundle:IndicatorLevel')->findOneBy(array('level' => IndicatorLevel::LEVEL_ESTRATEGICO));
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
     * Función que registra un indicador estratégico
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @Template("PequivenIndicatorBundle:Strategic:register.html.twig")
     * @return type
     * @throws \Pequiven\IndicatorBundle\Controller\Exception
     */
    public function createAction(Request $request){

        $form = $this->createForm(new BaseFormType('regular'));
        $form->handleRequest($request);
        $nameObject = 'object';
        $lastId = '';
        
        $em = $this->getDoctrine()->getManager();
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();
        
        $em->getConnection()->beginTransaction();
        
        if($form->isValid()){
            $object = $form->getData();
            $data =  $this->container->get('request')->get("pequiven_indicator_strategic_registration");
            
            $objetive = $em->getRepository('PequivenObjetiveBundle:Objetive')->findOneBy(array('id' => $data['parent']));
            $object->setRefParent($objetive->getRef());
            
            //$object->setGoal(bcadd(str_replace(',', '.', $data['weight']),'0',3));
            $object->setGoal(bcadd(str_replace(',', '.', $data['goal']),'0',3));
            $object->setUserCreatedAt($user);
            
            //Obtenemos y seteamos el nivel del indicador
            $indicatorLevel = $em->getRepository('PequivenIndicatorBundle:IndicatorLevel')->findOneBy(array('level' => IndicatorLevel::LEVEL_ESTRATEGICO));
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
            //$objetives = $em->getRepository('PequivenObjetiveBundle:Objetive')->findBy(array('ref' => $objetive->getRef()));
            $this->createObjetiveIndicator($lastObjectInsert);
            
            return $this->redirect($this->generateUrl('pequiven_indicator_home', 
                    array('type' => 'indicatorStrategic',
                          'action' => 'REGISTER_SUCCESSFULL'
                        )
                    ));
        }
        
        return array(
            'form' => $form->createView(),
            );
    }
    
    /**
     * Función que guarda en la tabla intermedia el indicador creado al objetivo estratégico seleccionado
     * @param \Pequiven\IndicatorBundle\Entity\Indicator $indicator
     * @return boolean
     * @throws \Pequiven\IndicatorBundle\Controller\Exception
     */
    public function createObjetiveIndicator(Indicator $indicator){
        
        $em = $this->getDoctrine()->getManager();
        $objetives = $em->getRepository('PequivenObjetiveBundle:Objetive')->findBy(array('ref' => $indicator->getRefParent()));
        $totalObjetives = count($objetives);
        $em->getConnection()->beginTransaction();
        if($totalObjetives > 0){
            foreach($objetives as $objetive){
                $objetive->addIndicator($indicator);
                $em->persist($objetive);
            }
        }
        
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
            $arrangementRange->setRankTopBasic(bcadd(str_replace(',', '.', $data['rankTopBasic']),'0',3));
            $arrangementRange->setOpRankTopBasic($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankTopBasic'])));
        } else if($data['typeArrangementRangeTypeTop'] == 'TOP_MIXED'){
            $arrangementRange->setRankTopMixedTop(bcadd(str_replace(',', '.', $data['rankTopMixedTop']),'0',3));
            $arrangementRange->setOpRankTopMixedTop($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankTopMixedTop'])));
            $arrangementRange->setRankTopMixedBottom(bcadd(str_replace(',', '.', $data['rankTopMixedBottom']),'0',3));
            $arrangementRange->setOpRankTopMixedBottom($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankTopMixedBottom'])));
        }
        
        //Seteamos los valores de rango medio alto
        $arrangementRange->setTypeRangeMiddleTop($em->getRepository('PequivenMasterBundle:ArrangementRangeType')->findOneBy(array('id' => $data['arrangementRangeTypeMiddleTop'])));
        if($data['typeArrangementRangeTypeMiddleTop'] == 'MIDDLE_TOP_BASIC'){
            $arrangementRange->setRankMiddleTopBasic(bcadd(str_replace(',', '.', $data['rankMiddleTopBasic']),'0',3));
            $arrangementRange->setOpRankMiddleTopBasic($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankMiddleTopBasic'])));
        } else if($data['typeArrangementRangeTypeMiddleTop'] == 'MIDDLE_TOP_MIXED'){
            $arrangementRange->setRankMiddleTopMixedTop(bcadd(str_replace(',', '.', $data['rankMiddleTopMixedTop']),'0',3));
            $arrangementRange->setOpRankMiddleTopMixedTop($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankMiddleTopMixedTop'])));
            $arrangementRange->setRankMiddleTopMixedBottom(bcadd(str_replace(',', '.', $data['rankMiddleTopMixedBottom']),'0',3));
            $arrangementRange->setOpRankMiddleTopMixedBottom($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankMiddleTopMixedBottom'])));
        }
        
        //Seteamos los valores de rango medio bajo
        $arrangementRange->setTypeRangeMiddleBottom($em->getRepository('PequivenMasterBundle:ArrangementRangeType')->findOneBy(array('id' => $data['arrangementRangeTypeMiddleBottom'])));
        if($data['typeArrangementRangeTypeMiddleBottom'] == 'MIDDLE_BOTTOM_BASIC'){
            $arrangementRange->setRankMiddleBottomBasic(bcadd(str_replace(',', '.', $data['rankMiddleBottomBasic']),'0',3));
            $arrangementRange->setOpRankMiddleBottomBasic($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankMiddleBottomBasic'])));
        } else if($data['typeArrangementRangeTypeMiddleBottom'] == 'MIDDLE_BOTTOM_MIXED'){
            $arrangementRange->setRankMiddleBottomMixedTop(bcadd(str_replace(',', '.', $data['rankMiddleBottomMixedTop']),'0',3));
            $arrangementRange->setOpRankMiddleBottomMixedTop($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankMiddleBottomMixedTop'])));
            $arrangementRange->setRankMiddleBottomMixedBottom(bcadd(str_replace(',', '.', $data['rankMiddleBottomMixedBottom']),'0',3));
            $arrangementRange->setOpRankMiddleBottomMixedBottom($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankMiddleBottomMixedBottom'])));
        }
        
        //Seteamos los valores de rango bajo
        $arrangementRange->setTypeRangeBottom($em->getRepository('PequivenMasterBundle:ArrangementRangeType')->findOneBy(array('id' => $data['arrangementRangeTypeBottom'])));
        if($data['typeArrangementRangeTypeBottom'] == 'BOTTOM_BASIC'){
            $arrangementRange->setRankBottomBasic(bcadd(str_replace(',', '.', $data['rankBottomBasic']),'0',3));
            $arrangementRange->setOpRankBottomBasic($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankBottomBasic'])));
        } else if($data['typeArrangementRangeTypeBottom'] == 'BOTTOM_MIXED'){
            $arrangementRange->setRankBottomMixedTop(bcadd(str_replace(',', '.', $data['rankBottomMixedTop']),'0',3));
            $arrangementRange->setOpRankBottomMixedTop($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankBottomMixedTop'])));
            $arrangementRange->setRankBottomMixedBottom(bcadd(str_replace(',', '.', $data['rankBottomMixedBottom']),'0',3));
            $arrangementRange->setOpRankBottomMixedBottom($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankBottomMixedBottom'])));
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
     * Devuelve los Indicadores Estratégicos de acuerdo a la Línea Estratégica que este
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function selectIndicatorStrategicFromRefParentAction(Request $request){
        $response = new JsonResponse();
        
        $indicatorsStrategic = array();
        $em = $this->getDoctrine()->getManager();
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();
        
        $refParentId = $request->request->get('refParentId');
        $indicatorLevelId = IndicatorLevel::LEVEL_ESTRATEGICO;
        
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
        $em = $this->getDoctrine()->getManager();
        
        $objetiveStrategicId = $request->request->get('objetiveStrategicId');
        $options['refParent'] = $em->getRepository('PequivenObjetiveBundle:Objetive')->findOneBy(array('id' => $objetiveStrategicId))->getRef();
        $options['type'] = 'STRATEGIC';
        $ref = $indicator->setNewRefFromObjetive($options);
        
        $data[] = array('ref' => $ref);
        $response->setData($data);
        return $response;
    }
    
    /**
     * Devuelve la Referencia del Indicador, de acuerdo a la cantidad que ya se encuentren registrados para el objetivo estratégico que se esta creando
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
        $options['type'] = 'STRATEGIC';
        $ref = $indicator->setNewRefFromObjetive($options);
        
        $data[] = array('ref' => $ref);
        $response->setData($data);
        return $response;
    }
}
