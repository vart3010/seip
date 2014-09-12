<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\ObjetiveBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Pequiven\MasterBundle\Entity\Complejo;
use Pequiven\ObjetiveBundle\Entity\Objetive;
use Pequiven\ObjetiveBundle\Entity\ObjetiveLevel;
use Pequiven\ObjetiveBundle\Entity\ObjetiveIndicator;
use Pequiven\ArrangementBundle\Entity\ArrangementRange;
use Pequiven\ObjetiveBundle\Form\Type\Tactic\RegistrationFormType as BaseFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController as baseController;
/**
 * Description of ObjetiveController
 *
 * @author matias
 */
class ObjetiveTacticController extends baseController{
    //put your code here
    
    /**
     * Función que retorna la vista con la lista de los objetivos tácticos
     * @Template("PequivenObjetiveBundle:Tactic:list.html.twig")
     * @return type
     */
    public function listAction(){
        return array(
            
        );
    }
    
    /**
     * Función que devuelve el paginador con los objetivos tácticos
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function objetiveListAction(Request $request){

//        $em = $this->getDoctrine()->getManager();
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();
        
        $criteria = $request->get('filter',$this->config->getCriteria());
        $sorting = $request->get('sorting',$this->config->getSorting());
        $repository = $this->getRepository();
        
        $criteria['objetiveLevel'] = ObjetiveLevel::LEVEL_TACTICO;
        
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
//            var_dump($this->config->getRedirectRoute('objetiveTacticList'));
//            die();
            $view->setData($resources->toArray('',array(),$formatData));
        }
        return $this->handleView($view);
    }
    
    /**
     * Función que registra un objetivo táctico
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @Template("PequivenObjetiveBundle:Tactic:register.html.twig")
     * @return type
     * @throws \Pequiven\ObjetiveBundle\Controller\Exception
     */
    public function createAction(Request $request){

        $form = $this->createForm(new BaseFormType());
        $form->handleRequest($request);
        $nameObject = 'object';
        $lastId = '';
        $em = $this->getDoctrine()->getManager();
        
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();
        $role = $user->getRoles();

        //Obtenemos el valor de referencia del complejo
        $complejoObject = new Complejo();
        $complejoNameArray = $complejoObject->getRefNameArray();
        
        $em->getConnection()->beginTransaction();
        if($form->isValid()){
            $object = $form->getData();
            $data =  $this->container->get('request')->get("pequiven_objetive_tactic_registration");
            $object->setWeight(bcadd(str_replace(',', '.',$data['weight']),'0',3));
            $object->setGoal(bcadd(str_replace(',', '.', $data['goal']),'0',3));
            $ref = $data['ref'];
            
            //Obtenemos y Seteamos el nivel del objetivo
            $objetiveLevel = $em->getRepository('PequivenObjetiveBundle:ObjetiveLevel')->findOneBy(array('level' => ObjetiveLevel::LEVEL_TACTICO));
            $object->setObjetiveLevel($objetiveLevel);

            $object->setUserCreatedAt($user);
            //Obtenemos el objetivo estratégico al cual pertenecerá el objetivo táctico a crear
            $objetive = $em->getRepository('PequivenObjetiveBundle:Objetive')->findOneBy(array('id' => $data['parent']));
            $indicators = isset($data['indicators']) ? $em->getRepository('PequivenIndicatorBundle:Indicator')->findBy(array('refParent' => $ref)) : array();
            //Si el usuario tiene rol Directivo
            if($securityContext->isGranted(array('ROLE_DIRECTIVE','ROLE_DIRECTIVE_AUX'))){
                //En caso de que las gerencias a impactar por el objetivo sean seleccionadas en el select
                if(!isset($data['check_gerencia'])){
                    for($i = 0; $i < count($data['gerencia']); $i++){
                        ${$nameObject.$i} = clone $object;
                        ${$nameObject.$i}->resetIndicators();
                        $gerencia = $em->getRepository('PequivenMasterBundle:Gerencia')->findOneBy(array('id' => $data['gerencia'][$i]));
                        ${$nameObject.$i}->setGerencia($gerencia);
                        ${$nameObject.$i}->setParent($objetive);
                        if(isset($data['indicators'])){
                            foreach($data['indicators'] as $value){
                                $indicator = $em->getRepository('PequivenIndicatorBundle:Indicator')->findOneBy(array('id' => $value));
                                ${$nameObject.$i}->addIndicator($indicator);
                            }
                        }
                        $em->persist(${$nameObject.$i});
                    }
                } else{//En caso de que las gerencias a impactar, sean todas la de las localidades seleccionadas
                    $j = 0;
                    for($i=0;$i<count($data['complejo']);$i++){//Recorremos todas las localidades seleccionadas
                        //Obtenemos todas las gerencias de 1ra línea de las localidades seleccionadas
                        $gerencias = $em->getRepository('PequivenMasterBundle:Gerencia')->findBy(array('complejo' => $data['complejo'][$i]));
                        foreach($gerencias as $gerencia){//Recorremos todos los resultados de las gerencias obtenidas
                            ${$nameObject.$j} = clone $object;
                            ${$nameObject.$i}->resetIndicators();
                            ${$nameObject.$j}->setGerencia($gerencia);
                            ${$nameObject.$j}->setParent($objetive);
                            if(isset($data['indicators'])){
                                foreach($data['indicators'] as $value){
                                    $indicator = $em->getRepository('PequivenIndicatorBundle:Indicator')->findOneBy(array('id' => $value));
                                    ${$nameObject.$j}->addIndicator($indicator);
                                }
                            }
                            $em->persist(${$nameObject.$j});
                            $j++;
                        }
                    }
                }
                //Si el usuario tiene rol Gerente General de Complejo o Gerente 1ra línea
            } elseif($securityContext->isGranted(array('ROLE_GENERAL_COMPLEJO','ROLE_GENERAL_COMPLEJO_AUX','ROLE_MANAGER_FIRST','ROLE_MANAGER_FIRST_AUX'))){
                $object->setGerencia($user->getGerencia());
                $object->setParent($objetive);
                if(isset($data['indicators'])){
                    foreach($data['indicators'] as $value){
                        $indicator = $em->getRepository('PequivenIndicatorBundle:Indicator')->findOneBy(array('id' => $value));
                        $object->addIndicator($indicator);
                    }
                }
                $em->persist($object);
            } else{
                if(isset($data['indicators'])){
                    foreach($data['indicators'] as $value){
                        $indicator = $em->getRepository('PequivenIndicatorBundle:Indicator')->findOneBy(array('id' => $value));
                        $object->addIndicator($indicator);
                    }
                }
                $em->persist($object);
            }
            
            try{
                
                $em->flush();
                $lastId = $em->getConnection()->lastInsertId();
                $em->getConnection()->commit();
            } catch (Exception $e){
                $em->getConnection()->rollback();
                throw $e;
            }
            
            $objetives = $em->getRepository('PequivenObjetiveBundle:Objetive')->findBy(array('ref' => $ref));

            if(isset($data['typeArrangementRangeTypeTop']) && $data['typeArrangementRangeTypeTop'] != null){
                $this->createArrangementRange($objetives, $data);
            }
            
            return $this->redirect($this->generateUrl('pequiven_objetive_home', 
                    array('type' => 'objetiveTactic',
                          'action' => 'REGISTER_SUCCESSFULL'
                        )
                    ));
        }
      
        return array(
            'form' => $form->createView(),
            'role_name' => $role[0]
                );
    }
    
     /**
      * Función que guarda en la tabla intermedia el rango de gestión (semáforo) del objetivo creado
      * @param type $objetives
      * @param type $data
      * @return boolean
      * @throws \Pequiven\ObjetiveBundle\Controller\Exception
      */
    public function createArrangementRange($objetives = array() ,$data = array()){
        $arrangementRange = new ArrangementRange();
        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();
        $totalObjetives = count($objetives);
        
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
        
        if($totalObjetives > 0){
            foreach($objetives as $objetive){
                $objectArrangementRange = clone $arrangementRange;
                $objectArrangementRange->setObjetive($objetive);
                $em->persist($objectArrangementRange);
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
     * Devuelve los Objetivos Estratégicos de acuerdo a la Línea Estratégica seleccionada
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function selectObjetiveStrategicFromLineStrategicAction(Request $request){
        $response = new JsonResponse();
        $data = array();
        $objetiveChildrenStrategic = array();
        $em = $this->getDoctrine()->getManager();
        
        $lineStrategicId = $request->request->get('lineStrategicId');
        $objetiveLevelId = ObjetiveLevel::LEVEL_ESTRATEGICO;
        
        //En caso de que la variable de línea estratégica sea un número
        if(is_numeric($lineStrategicId)){
            $results = $em->getRepository('PequivenObjetiveBundle:Objetive')->findBy(array('lineStrategic' => $lineStrategicId,'objetiveLevel' => $objetiveLevelId));
            $totalResults = count($results);
            if(is_array($results) && $totalResults > 0){
                foreach ($results as $result){
                    $objetiveChildrenStrategic[] = array("id" => $result->getId(), "description" => $result->getRef() . ' ' . $result->getDescription());
                }
            } else{
                $objetiveChildrenStrategic[] = array("empty" => true);
            }
        } else{
            $objetiveChildrenStrategic[] = array("empty" => true,"initial" => true);
        }
        $response->setData($objetiveChildrenStrategic);
        
        return $response;
    }
    
    /**
     * Devuelve las Gerencias de acuerdo a los Complejos seleccionados (Sólo para el caso de que el usuario sea rol directivo)
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function selectGerenciaFromComplejoAction(Request $request){
        $response = new JsonResponse();
        $dataGerencia = array();
        $complejos = $request->request->get('complejos');
        $em = $this->getDoctrine()->getManager();
        $results = $em->getRepository('PequivenMasterBundle:Gerencia')->getGerenciaOptions(array('complejos' => $complejos));
        $data = '';
        foreach($results as $result){
            foreach($result as $gerencia){
                $dataGerencia[] = array(
                    'idComplejo' => $gerencia->getComplejo()->getId(),
                    'optGroup' => $gerencia->getComplejo()->getDescription(),
                    'id' => $gerencia->getId(),
                    'description' => $gerencia->getDescription()
                    );
            }
        }
        
        $response->setData($dataGerencia);
        
        return $response;
    }
    
    
    
    /**
     * Devuelve la Referencia del Objetivo, de acuerdo a la cantidad que ya se encuentren registrados
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function displayRefObjetiveAction(Request $request){
        $response = new JsonResponse();
        $objetive = new Objetive();
        $data = array();
        $options = array();
        $em = $this->getDoctrine()->getManager();
        $securityContext = $this->container->get('security.context');
        
        $objetiveStrategicId = $request->request->get('objetiveStrategicId');
        $options['objetiveStrategicId'] = $objetiveStrategicId;
        $options['type'] = 'TACTIC';
        $options['type_ref'] = 'TACTIC_REF';
        
        $ref = $objetive->setNewRef($options);
        
        $data[] = array('ref' => $ref);
        $response->setData($data);
        return $response;
    }
}
