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
use Pequiven\ObjetiveBundle\Entity\Objetive;
use Pequiven\ObjetiveBundle\Entity\ObjetiveLevel;
use Pequiven\ObjetiveBundle\Entity\ObjetiveIndicator;
use Pequiven\ArrangementBundle\Entity\ArrangementRange;
use Pequiven\ObjetiveBundle\Form\Type\Operative\RegistrationFormType as BaseFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController as baseController;
/**
 * Description of ObjetiveOperativeController
 *
 * @author matias
 */
class ObjetiveOperativeController extends baseController {
    //put your code here
    
    /**
     * Función que retorna la vista con la lista de los objetivos operativos
     * @Template("PequivenObjetiveBundle:Operative:list.html.twig")
     * @return type
     */
    public function listAction(){
       return array(
            
        );
    }
    
    /**
     * Función que devuelve el paginador con los objetivos operativos
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
        
        $criteria['objetiveLevel'] = ObjetiveLevel::LEVEL_OPERATIVO;
        
        if ($this->config->isPaginated()) {
            $resources = $this->resourceResolver->getResource(
                $repository,
                'createPaginatorOperative',
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
     * Función que registra un objetivo operativo
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @Template("PequivenObjetiveBundle:Operative:register.html.twig")
     * @return type
     * @throws \Pequiven\ObjetiveBundle\Controller\Exception
     */
    public function createAction(Request $request){

        $form = $this->createForm($this->get('pequiven_objetive.operative.registration.form.type'));
        
        $nameObject = 'object';
        $lastId = '';
        
        $em = $this->getDoctrine()->getManager();
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();
        $role = $user->getRoles();
        
        $em->getConnection()->beginTransaction();
        if($request->isMethod('POST') && $form->submit($request)->isValid()){
            $object = $form->getData();
            $data =  $this->container->get('request')->get("pequiven_objetive_operative_registration");
            
            $ref = $data['ref'];
            $object->setWeight(bcadd(str_replace(',', '.',$data['weight']),'0',3));
            $object->setGoal(bcadd(str_replace(',', '.', $data['goal']),'0',3));
            
            //Obtenemos y Seteamos el nivel del objetivo
            $objetiveLevel = $em->getRepository('PequivenObjetiveBundle:ObjetiveLevel')->findOneBy(array('level' => ObjetiveLevel::LEVEL_OPERATIVO));
            $object->setObjetiveLevel($objetiveLevel);

            $securityContext = $this->container->get('security.context');
            $object->setUserCreatedAt($user);

            //Si el usuario tiene rol Directivo
            if($securityContext->isGranted(array('ROLE_DIRECTIVE','ROLE_DIRECTIVE_AUX'))){
                //En caso de que las gerencias de 2da línea a impactar por el objetivo sean seleccionadas en el select
                if(!isset($data['check_gerencia'])){
                    for($i = 0; $i < count($data['gerenciaSecond']); $i++){
                        ${$nameObject.$i} = clone $object;
                        ${$nameObject.$i}->resetIndicators();
                        $gerenciaSecond = $em->getRepository('PequivenMasterBundle:GerenciaSecond')->findOneBy(array('id' => $data['gerenciaSecond'][$i]));
                        $complejo = $gerenciaSecond->getGerencia()->getComplejo();
                        ${$nameObject.$i}->setGerencia($gerenciaSecond->getGerencia());
                        ${$nameObject.$i}->setGerenciaSecond($gerenciaSecond);
                        ${$nameObject.$i}->setComplejo($complejo);
                        if(isset($data['indicators'])){
                            foreach($data['indicators'] as $value){
                                $indicator = $em->getRepository('PequivenIndicatorBundle:Indicator')->findOneBy(array('id' => $value));
                                $indicator->setTmp(false);
                                $em->persist($indicator);
                                ${$nameObject.$i}->addIndicator($indicator);
                            }
                        }
                        $em->persist(${$nameObject.$i});
                    }
                } else{//En caso de que las gerencias de 2da línea a impactar, sean todas la de las gerencias de 1ra línea seleccionadas
                    $j = 0;
                    //Obtenemos las gerencias de 1ra línea seleccionadas
                    $gerencias = $em->getRepository('PequivenMasterBundle:Gerencia')->findBy(array('id' => $data['gerencia']));

                    foreach ($gerencias as $gerencia){
                        $gerenciasSecond = $em->getRepository('PequivenMasterBundle:GerenciaSecond')->findBy(array('gerencia' => $gerencia->getId()));
                        $complejo = $gerencia->getComplejo();
                        foreach($gerenciasSecond as $gerenciaSecond){
                            ${$nameObject.$j} = clone $object;
                            ${$nameObject.$j}->resetIndicators();
                            ${$nameObject.$j}->setGerencia($gerencia);
                            ${$nameObject.$j}->setGerenciaSecond($gerenciaSecond);
                            ${$nameObject.$j}->setComplejo($complejo);
                            if(isset($data['indicators'])){
                                foreach($data['indicators'] as $value){
                                    $indicator = $em->getRepository('PequivenIndicatorBundle:Indicator')->findOneBy(array('id' => $value));
                                    $indicator->setTmp(false);
                                    $em->persist(false);
                                    ${$nameObject.$j}->addIndicator($indicator);
                                }
                            }
                            $em->persist(${$nameObject.$j});
                            $j++;
                        }
                    }
                }
                //Si el usuario tiene rol Gerente General Complejo
            } elseif($securityContext->isGranted(array('ROLE_GENERAL_COMPLEJO','ROLE_GENERAL_COMPLEJO_AUX'))){
                //En caso de que las gerencias de 2da línea a impactar por el objetivo sean seleccionadas en el select
                if(!isset($data['check_gerencia'])){
                    for($i = 0; $i < count($data['gerenciaSecond']); $i++){
                        ${$nameObject.$i} = clone $object;
                        ${$nameObject.$i}->resetIndicators();
                        $gerenciaSecond = $em->getRepository('PequivenMasterBundle:GerenciaSecond')->findOneBy(array('id' => $data['gerenciaSecond'][$i]));
                        $complejo = $gerenciaSecond->getGerencia()->getComplejo();
                        ${$nameObject.$i}->setGerencia($gerenciaSecond->getGerencia());
                        ${$nameObject.$i}->setGerenciaSecond($gerenciaSecond);
                        ${$nameObject.$i}->setComplejo($complejo);
                        if(isset($data['indicators'])){
                            foreach($data['indicators'] as $value){
                                $indicator = $em->getRepository('PequivenIndicatorBundle:Indicator')->findOneBy(array('id' => $value));
                                $indicator->setTmp(false);
                                $em->persist($indicator);
                                ${$nameObject.$i}->addIndicator($indicator);
                            }
                        }
                        $em->persist(${$nameObject.$i});
                    }
                } else{//En caso de que las gerencias de 2da línea a impactar, sean todas la de las gerencias de 1ra línea seleccionadas
                    $j = 0;
                    $gerenciasSecond = $em->getRepository('PequivenMasterBundle:GerenciaSecond')->findBy(array('complejo' => $user->getComplejo()->getId(),'modular' => true));
                    $gerencia = $user->getGerencia();
                    foreach($gerenciasSecond as $gerenciaSecond){
                        ${$nameObject.$j} = clone $object;
                        ${$nameObject.$j}->resetIndicators();
                        $complejo = $gerenciaSecond->getComplejo();
                        ${$nameObject.$j}->setGerencia($gerencia);
                        ${$nameObject.$j}->setGerenciaSecond($gerenciaSecond);
                        ${$nameObject.$j}->setComplejo($complejo);
                        if(isset($data['indicators'])){
                            foreach($data['indicators'] as $value){
                                $indicator = $em->getRepository('PequivenIndicatorBundle:Indicator')->findOneBy(array('id' => $value));
                                $indicator->setTmp(false);
                                $em->persist($indicator);
                                ${$nameObject.$j}->addIndicator($indicator);
                            }
                        }
                        $em->persist(${$nameObject.$j});
                        $j++;
                    }
                }
            } elseif($securityContext->isGranted(array('ROLE_MANAGER_FIRST','ROLE_MANAGER_FIRST_AUX'))){
                //En caso de que las gerencias de 2da línea a impactar por el objetivo sean seleccionadas en el select
                if(!isset($data['check_gerencia'])){
                    for($i = 0; $i < count($data['gerenciaSecond']); $i++){
                        ${$nameObject.$i} = clone $object;
                        ${$nameObject.$i}->resetIndicators();
                        $gerenciaSecond = $em->getRepository('PequivenMasterBundle:GerenciaSecond')->findOneBy(array('id' => $data['gerenciaSecond'][$i]));
                        $complejo = $gerenciaSecond->getGerencia()->getComplejo();
                        ${$nameObject.$i}->setGerencia($gerenciaSecond->getGerencia());
                        ${$nameObject.$i}->setGerenciaSecond($gerenciaSecond);
                        ${$nameObject.$i}->setComplejo($complejo);
                        if(isset($data['indicators'])){
                            foreach($data['indicators'] as $value){
                                $indicator = $em->getRepository('PequivenIndicatorBundle:Indicator')->findOneBy(array('id' => $value));
                                $indicator->setTmp(false);
                                $em->persist($indicator);
                                ${$nameObject.$i}->addIndicator($indicator);
                            }
                        }
                        $em->persist(${$nameObject.$i});
                    }
                } else{//En caso de que las gerencias de 2da línea a impactar, sean todas la de las gerencias de 1ra línea seleccionadas
                    $j = 0;
                    $gerenciasSecond = $em->getRepository('PequivenMasterBundle:GerenciaSecond')->findBy(array('gerencia' => $user->getGerencia()->getId()));
                    $gerencia = $user->getGerencia();
                    foreach($gerenciasSecond as $gerenciaSecond){
                        ${$nameObject.$j} = clone $object;
                        ${$nameObject.$j}->resetIndicators();
                        $complejo = $gerenciaSecond->getComplejo();
                        ${$nameObject.$j}->setGerencia($gerencia);
                        ${$nameObject.$j}->setGerenciaSecond($gerenciaSecond);
                        ${$nameObject.$j}->setComplejo($complejo);
                        if(isset($data['indicators'])){
                            foreach($data['indicators'] as $value){
                                $indicator = $em->getRepository('PequivenIndicatorBundle:Indicator')->findOneBy(array('id' => $value));
                                $indicator->setTmp(false);
                                $em->persist($indicator);
                                ${$nameObject.$j}->addIndicator($indicator);
                            }
                        }
                        $em->persist(${$nameObject.$j});
                        $j++;
                    }
                }
            } elseif($securityContext->isGranted(array('ROLE_MANAGER_SECOND','ROLE_MANAGER_SECOND_AUX'))){
                if(isset($data['indicators'])){
                    foreach($data['indicators'] as $value){
                        $indicator = $em->getRepository('PequivenIndicatorBundle:Indicator')->findOneBy(array('id' => $value));
                        $indicator->setTmp(false);
                        $em->persist($indicator);
                        $object->addIndicator($indicator);
                    }
                }
                $em->persist($object);
            } else{
                if(isset($data['indicators'])){
                    foreach($data['indicators'] as $value){
                        $indicator = $em->getRepository('PequivenIndicatorBundle:Indicator')->findOneBy(array('id' => $value));
                        $indicator->setTmp(false);
                        $em->persist($indicator);
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
            
            $this->get('session')->getFlashBag()->add('success',$this->trans('action.messages.registerObjetiveOperativeSuccessfull', array(), 'PequivenObjetiveBundle'));
            
            return $this->redirect($this->generateUrl('pequiven_objetive_menu_list_operative', 
                    array(
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
    public function selectObjetiveStrategicFromLineStrategicOperativeAction(Request $request){
        $response = new JsonResponse();
        
        $objetiveChildrenStrategic = array();
        $em = $this->getDoctrine()->getManager();
        
        $lineStrategicId = $request->request->get('lineStrategicId');
        $lineStrategicArray = explode(',',$lineStrategicId);
        
        if(is_array($lineStrategicArray)){
            $results = $this->get('pequiven.repository.objetiveoperative')->getByLineStrategic($lineStrategicArray);
            $totalResults = count($results);
            if(is_array($results) && $totalResults > 0){
                foreach ($results as $result){
                    $objetiveChildrenStrategic[] = array("id" => $result->getId(), "description" => $result->getRef() . ' ' . $result->getDescription());
                }
            } else{
                $objetiveChildrenStrategic[] = array("empty" => true);
            }
        } else{
            $objetiveChildrenStrategic[] = array("empty" => true, "initial" => true);
        }
        
        $response->setData($objetiveChildrenStrategic);
        
        return $response;
    }
    
    /**
     * Devuelve los Objetivos Tácticos de acuerdo al Objetivo Estratégico seleccionado
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function selectObjetiveTacticFromObjetiveStrategicAction(Request $request){
        $response = new JsonResponse();
        $objetiveChildrenTactic = array();
        $em = $this->getDoctrine()->getManager();
        
        $objetiveStrategicId = explode(',',$request->request->get('objetiveStrategicId'));
        
        if(is_array($objetiveStrategicId)){
            $results = $this->get('pequiven.repository.objetiveoperative')->getByParent($objetiveStrategicId);

            $totalResults = count($results);
            if (is_array($results) && $totalResults > 0){
                foreach ($results as $result){
                    $objetiveChildrenTactic[] = array("id" => $result->getId(), "description" => $result->getRef() . ' ' . $result->getDescription());
                }
            } else{
                $objetiveChildrenTactic[] = array("empty" => true);
            }
        } else{
            $objetiveChildrenTactic[] = array("empty" => true, "initial" => true);
        }
        
        $response->setData($objetiveChildrenTactic);
        
        return $response;
    }
    
    /**
     * Devuelve los Objetivos Estratégicos de acuerdo al Objetivo Táctico seleccionado
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function selectObjetiveStrategicFromObjetiveTacticAction(Request $request){
        $response = new JsonResponse();
        $objetiveStrategicParent = array();
        $em = $this->getDoctrine()->getManager();
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();
        
        $objetiveTacticId = $request->request->get('objetiveTacticId');
        $lineStrategicId = $request->request->get('lineStrategicId');
        //Obtenemos el objetivo de acuerdo a la data recibida
        $objetiveTactic = $em->getRepository('PequivenObjetiveBundle:Objetive')->findOneBy(array('id' => $objetiveTacticId));
        
        //Obtenemos los objetivos estratégicos de acuerdo a la línea estratégica y el complejo del objetivo táctico
        $objetivesStrategics = $em->getRepository('PequivenObjetiveBundle:Objetive')->findBy(array('lineStrategic' => $lineStrategicId, 'complejo' => $objetiveTactic->getComplejo()->getId(), 'objetiveLevel' => ObjetiveLevel::LEVEL_ESTRATEGICO));
        foreach($objetivesStrategics as $objetiveStrategic){
            if($objetiveStrategic->getId() == $objetiveTactic->getParent()->getId()){
                $objetiveStrategicParent[] = array('id' => $objetiveStrategic->getId(), 'description' => $objetiveStrategic->getRef() . ' ' . $objetiveStrategic->getDescription(), 'selected' => 'YES');
            } else{
                $objetiveStrategicParent[] = array('id' => $objetiveStrategic->getId(), 'description' => $objetiveStrategic->getRef() . ' ' . $objetiveStrategic->getDescription(), 'selected' => 'NO');
            }
        }
        
        $response->setData($objetiveStrategicParent);
        
        return $response;
    }
    
    /**
     * Devuelve los Complejos en los cuales impactará el objetivo a crear de acuerdo al Objetivo Táctico seleccionado
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function selectComplejoFromObjetiveTacticAction(Request $request){
        $response = new JsonResponse();
        $complejoChildren = array();
        $em = $this->getDoctrine()->getManager();
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();
        $complejoObject = new \Pequiven\MasterBundle\Entity\Complejo();
        $complejoNameArray = $complejoObject->getRefNameArray();
        
        $objetiveTacticId = $request->request->get('objetiveTacticId');
        
        //Obtenemos el objetivo táctico para obtener la referencia
        $objetiveTactic = $em->getRepository('PequivenObjetiveBundle:Objetive')->findOneBy(array('id' => $objetiveTacticId));
        
        if($securityContext->isGranted(array('ROLE_DIRECTIVE','ROLE_DIRECTIVE_AUX'))){
            
        }
        
        //Obtenemos los Objetivos Tácticos que tengan como referencia el obtenido en el paso anterior
        $results = $em->getRepository('PequivenObjetiveBundle:Objetive')->findBy(array('ref' => $objetiveTactic->getRef()));
        
        $i=1;
        foreach ($results as $result){
            $complejo = $result->getGerencia()->getComplejo();
            if($i == 1){
                $complejoChildren[] = array("id" => $complejo->getId(), "description" => $complejo->getDescription());
            } else{
                if($objectBefore->getGerencia()->getComplejo()->getId() != $complejo->getId()){
                    $complejoChildren[] = array("id" => $complejo->getId(), "description" => $complejo->getDescription());
                }
            }
            $objectBefore = clone $result;
            $i++;
        }
        
        $response->setData($complejoChildren);
        
        return $response;
    }
    
    /**
     * Función que devuelve la(s) gerencias de 1ra línea asociada al objetivo seleccionado
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function selectGerenciaFirstFromComplejoAction(Request $request){
        $response = new JsonResponse();
        $gerenciaFirstChildren = array();
        $em = $this->getDoctrine()->getManager();
        
        $objetiveTacticId = $request->request->get('objetiveTacticId');
        $complejos = $request->request->get('complejos');
        $complejosArray = explode(',', $complejos);

        //Obtenemos el objetivo para obtener la referencia
        $objetiveTactic = $em->getRepository('PequivenObjetiveBundle:Objetive')->findOneBy(array('id' => $objetiveTacticId));
        
        //Obtenemos los Objetivos Tácticos que tengan como referencia el obtenido en el paso anterior
        $results = $em->getRepository('PequivenObjetiveBundle:Objetive')->findBy(array('ref' => $objetiveTactic->getRef()));
        
        $i=1;
        foreach ($results as $result){
            $complejo = $result->getGerencia()->getComplejo();
            $gerencia = $result->getGerencia();
            foreach ($complejosArray as $value){
                if($complejo->getId() == $value){
                    $gerenciaFirstChildren[] = array(
                        'idComplejo' => $complejo->getId(),
                        'optGroup' => $complejo->getDescription(),
                        'id' => $gerencia->getId(),
                        'description' => $gerencia->getDescription()
                            );
                }
            }
            $i++;
        }
        
        $response->setData($gerenciaFirstChildren);
        
        return $response;
    }
    
    /**
     * Función que devuelve la(s) gerencias de 2da línea asociadaa a las gerencias de 1ra línea cargadas de acuerdo al objetivo táctico seleccionado
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function selectGerenciaSecondFromGerenciaFirstAction(Request $request){
        $response = new JsonResponse();
        $gerenciaSecondChildren = array();
        $em = $this->getDoctrine()->getManager();
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();
        $gerenciasObjectArray = array();
        
        if($securityContext->isGranted(array('ROLE_DIRECTIVE','ROLE_DIRECTIVE_AUX'))){
            $complejos = $request->request->get('complejos');
            $gerencias = $request->request->get('gerencias');
            $gerenciasArray = explode(',', $gerencias);
            $complejosArray = explode(',', $complejos);
            $results = $em->getRepository('PequivenMasterBundle:GerenciaSecond')->findBy(array('enabled' => true, 'gerencia' => $gerenciasArray));
            $gerenciasObjectArray = $gerenciasArray;
            
        } elseif($securityContext->isGranted(array('ROLE_GENERAL_COMPLEJO','ROLE_GENERAL_COMPLEJO_AUX'))){
            $results = $em->getRepository('PequivenMasterBundle:GerenciaSecond')->findBy(array('enabled' => true, 'complejo' => $user->getComplejo()->getId(), 'modular' => true));
        } elseif($securityContext->isGranted(array('ROLE_MANAGER_FIRST','ROLE_MANAGER_FIRST_AUX'))){
            $results = $em->getRepository('PequivenMasterBundle:GerenciaSecond')->findBy(array('enabled' => true, 'gerencia' => $user->getGerencia()->getId()));
        }
        
        if($securityContext->isGranted(array('ROLE_DIRECTIVE','ROLE_DIRECTIVE_AUX'))){
            foreach ($results as $result){
                $complejo = $result->getGerencia()->getComplejo();
                $gerencia = $result->getGerencia();
                foreach ($complejosArray as $valueComplejo){
                    foreach($gerenciasObjectArray as $valueGerencia){
                        if($complejo->getId().'-'.$gerencia->getId() == $valueComplejo.'-'.$valueGerencia){
                            $gerenciaSecondChildren[] = array(
                              'idGroup' => $complejo->getId().'-'.$gerencia->getId(),
                                'optGroup' => $complejo->getRef().'-'.$gerencia->getDescription(),
                                'id' => $result->getId(),
                                'description' => $result->getDescription()
                            );
                        }
                    }
                }
            }
        } else{
            foreach ($results as $result){
                $complejo = $result->getGerencia()->getComplejo();
                $gerencia = $result->getGerencia();
                $gerenciaSecondChildren[] = array(
                    'idGroup' => $complejo->getId().'-'.$gerencia->getId(),
                    'optGroup' => $complejo->getRef().'-'.$gerencia->getDescription(),
                    'id' => $result->getId(),
                    'description' => $result->getDescription()
                );
            }
        }
        
        $response->setData($gerenciaSecondChildren);
        
        return $response;
    }
    
    /**
     * Devuelve las Gerencias de acuerdo a los Complejos seleccionados
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
        
        $data = array();
        $options = array();
        
        $objetiveTacticId = $request->request->get('objetiveTacticId');
        
        $options['objetiveTactics'] = $objetiveTacticId;
        
        $ref = $this->setNewRef($options);
        
        $data[] = array('ref' => $ref);
        $response->setData($data);
        return $response;
    }
    
    /**
     * Función que devuelve la referenica del objetivo operativo que se esta creando
     * @param array $options
     */
    public function setNewRef($options = array()){
        $em = $this->getDoctrine()->getManager();
        $objetivesTactics = explode(',',$options['objetiveTactics']);
        $totalObjetivesTactics = count($objetivesTactics);
        
        $objetiveTactic = $em->getRepository('PequivenObjetiveBundle:Objetive')->findOneBy(array('id' => $objetivesTactics[$totalObjetivesTactics - 1]));
        $refObjetiveTactic = $objetiveTactic->getRef();
        
        $results = $this->get('pequiven.repository.objetiveoperative')->getByParent($objetivesTactics[$totalObjetivesTactics - 1]);
        $total = count($results);
        if (is_array($results) && $total > 0) {
            $ref = $refObjetiveTactic . ($total + 1) . '.';
        } else {
            $ref = $refObjetiveTactic . '1.';
        }
        
        return $ref;
    }
    
}
