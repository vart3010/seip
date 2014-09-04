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
     * Función que registra un objetivo operativo
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @Template("PequivenObjetiveBundle:Operative:register.html.twig")
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
        $complejoObject = new \Pequiven\MasterBundle\Entity\Complejo();
        $complejoNameArray = $complejoObject->getRefNameArray();
        
        $em->getConnection()->beginTransaction();
        if($form->isValid()){
            $object = $form->getData();
            $data =  $this->container->get('request')->get("pequiven_objetive_operative_registration");
            
            $object->setWeight(bcadd(str_replace(',', '.',$data['weight']),'0',3));
            $object->setGoal(bcadd(str_replace(',', '.', $data['goal']),'0',3));
            
            //Obtenemos y Seteamos el nivel del objetivo
            $objetiveLevel = $em->getRepository('PequivenObjetiveBundle:ObjetiveLevel')->findOneBy(array('level' => ObjetiveLevel::LEVEL_OPERATIVO));
            $object->setObjetiveLevel($objetiveLevel);

            $securityContext = $this->container->get('security.context');
            $object->setUserCreatedAt($user);
            //Obtenemos el objetivo táctico al cual pertenecerá el objetivo operativo a crear
            $objetive = $em->getRepository('PequivenObjetiveBundle:Objetive')->findOneBy(array('id' => $data['parent']));

            //Si el usuario tiene rol Directivo
            if($securityContext->isGranted(array('ROLE_DIRECTIVE','ROLE_DIRECTIVE_AUX'))){
                //En caso de que las gerencias de 2da línea a impactar por el objetivo sean seleccionadas en el select
                if(!isset($data['check_gerencia'])){
                    for($i = 0; $i < count($data['gerenciaSecond']); $i++){
                        ${$nameObject.$i} = clone $object;
                        $gerenciaSecond = $em->getRepository('PequivenMasterBundle:GerenciaSecond')->findOneBy(array('id' => $data['gerenciaSecond'][$i]));
                        $complejo = $gerenciaSecond->getGerencia()->getComplejo();
                        $parent = $em->getRepository('PequivenObjetiveBundle:Objetive')->findOneBy(array('lineStrategic' => $data['lineStrategic'], 'complejo' => $complejo->getId(), 'ref' => $objetive->getRef(), 'gerencia' => $gerenciaSecond->getGerencia()->getId()));
                        ${$nameObject.$i}->setGerencia($gerenciaSecond->getGerencia());
                        ${$nameObject.$i}->setGerenciaSecond($gerenciaSecond);
                        ${$nameObject.$i}->setComplejo($complejo);
                        ${$nameObject.$i}->setParent($parent);
                        $em->persist(${$nameObject.$i});
                    }
                } else{//En caso de que las gerencias de 2da línea a impactar, sean todas la de las gerencias de 1ra línea seleccionadas
                    $j = 0;
                    //Obtenemos las gerencias de 1ra línea seleccionadas
                    $gerencias = $em->getRepository('PequivenMasterBundle:Gerencia')->findBy(array('id' => $data['gerencia']));

                    foreach ($gerencias as $gerencia){
                        $gerenciasSecond = $em->getRepository('PequivenMasterBundle:GerenciaSecond')->findBy(array('gerencia' => $gerencia->getId()));
                        $complejo = $gerencia->getComplejo();
                        $parent = $em->getRepository('PequivenObjetiveBundle:Objetive')->findOneBy(array('lineStrategic' => $data['lineStrategic'], 'complejo' => $complejo->getId(), 'ref' => $objetive->getRef(), 'gerencia' => $gerencia->getId()));
                        foreach($gerenciasSecond as $gerenciaSecond){
                            ${$nameObject.$j} = clone $object;
                            ${$nameObject.$j}->setGerencia($gerencia);
                            ${$nameObject.$j}->setGerenciaSecond($gerenciaSecond);
                            ${$nameObject.$j}->setComplejo($complejo);
                            ${$nameObject.$j}->setParent($parent);
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
                        $gerenciaSecond = $em->getRepository('PequivenMasterBundle:GerenciaSecond')->findOneBy(array('id' => $data['gerenciaSecond'][$i]));
                        $complejo = $gerenciaSecond->getGerencia()->getComplejo();
                        ${$nameObject.$i}->setGerencia($gerenciaSecond->getGerencia());
                        ${$nameObject.$i}->setGerenciaSecond($gerenciaSecond);
                        ${$nameObject.$i}->setComplejo($complejo);
                        ${$nameObject.$i}->setParent($objetive);
                        $em->persist(${$nameObject.$i});
                    }
                } else{//En caso de que las gerencias de 2da línea a impactar, sean todas la de las gerencias de 1ra línea seleccionadas
                    $j = 0;
                    $gerenciasSecond = $em->getRepository('PequivenMasterBundle:GerenciaSecond')->findBy(array('complejo' => $user->getComplejo()->getId(),'modular' => true));
                    $gerencia = $user->getGerencia();
                    foreach($gerenciasSecond as $gerenciaSecond){
                        ${$nameObject.$j} = clone $object;
                        $complejo = $gerenciaSecond->getComplejo();
                        ${$nameObject.$j}->setGerencia($gerencia);
                        ${$nameObject.$j}->setGerenciaSecond($gerenciaSecond);
                        ${$nameObject.$j}->setComplejo($complejo);
                        ${$nameObject.$j}->setParent($objetive);
                        $em->persist(${$nameObject.$j});
                        $j++;
                    }
                }
            } elseif($securityContext->isGranted(array('ROLE_MANAGER_FIRST','ROLE_MANAGER_FIRST_AUX'))){
                //En caso de que las gerencias de 2da línea a impactar por el objetivo sean seleccionadas en el select
                if(!isset($data['check_gerencia'])){
                    for($i = 0; $i < count($data['gerenciaSecond']); $i++){
                        ${$nameObject.$i} = clone $object;
                        $gerenciaSecond = $em->getRepository('PequivenMasterBundle:GerenciaSecond')->findOneBy(array('id' => $data['gerenciaSecond'][$i]));
                        $complejo = $gerenciaSecond->getGerencia()->getComplejo();
                        ${$nameObject.$i}->setGerencia($gerenciaSecond->getGerencia());
                        ${$nameObject.$i}->setGerenciaSecond($gerenciaSecond);
                        ${$nameObject.$i}->setComplejo($complejo);
                        ${$nameObject.$i}->setParent($objetive);
                        $em->persist(${$nameObject.$i});
                    }
                } else{//En caso de que las gerencias de 2da línea a impactar, sean todas la de las gerencias de 1ra línea seleccionadas
                    $j = 0;
                    $gerenciasSecond = $em->getRepository('PequivenMasterBundle:GerenciaSecond')->findBy(array('gerencia' => $user->getGerencia()->getId()));
                    $gerencia = $user->getGerencia();
                    foreach($gerenciasSecond as $gerenciaSecond){
                        ${$nameObject.$j} = clone $object;
                        $complejo = $gerenciaSecond->getComplejo();
                        ${$nameObject.$j}->setGerencia($gerencia);
                        ${$nameObject.$j}->setGerenciaSecond($gerenciaSecond);
                        ${$nameObject.$j}->setComplejo($complejo);
                        ${$nameObject.$j}->setParent($objetive);
                        $em->persist(${$nameObject.$j});
                        $j++;
                    }
                }
            } elseif($securityContext->isGranted(array('ROLE_MANAGER_SECOND','ROLE_MANAGER_SECOND_AUX'))){
                $object->setParent($objetive);
                $em->persist($object);
            } else{
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
            
            $lastObjectInsert = $em->getRepository('PequivenObjetiveBundle:Objetive')->findOneBy(array('id' => $lastId));
            $objetives = $em->getRepository('PequivenObjetiveBundle:Objetive')->findBy(array('ref' => $lastObjectInsert->getRef()));
            if(isset($data['indicators'])){
                $this->createObjetiveIndicator($objetives,$data['indicators']);
            }
            $this->createArrangementRange($objetives, $data);
            
            return $this->redirect($this->generateUrl('pequiven_objetive_home', 
                    array('type' => 'objetiveOperative',
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
     * Función que guarda en la tabla intermedia los indicadores asignados al objetivo creado
     * @param type $objetives
     * @param type $indicators
     * @throws \Pequiven\ObjetiveBundle\Controller\Exception
     */
    public function createObjetiveIndicator($objetives = array(),$indicators = array()){
        $totalObjetives = count($objetives);
        $totalIndicators = count($indicators);
        $objetiveIndicator = new ObjetiveIndicator();
        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();
        if($totalObjetives > 0){
            foreach($objetives as $objetive){
                $objetiveIndicator->setObjetive($objetive);
                if($totalIndicators > 0){
                    for($i = 0; $i < $totalIndicators; $i++){
                        $objectObjetiveIndicator = clone $objetiveIndicator;
                        $indicator = $em->getRepository('PequivenIndicatorBundle:Indicator')->findOneBy(array('id' => $indicators[$i]));
                        $indicator->setTmp(false);
                        $em->persist($indicator);
                        $objectObjetiveIndicator->setIndicator($indicator);
                        $em->persist($objectObjetiveIndicator);
                    }
                }
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
        $data = array();
        $objetiveChildrenStrategic = array();
        $em = $this->getDoctrine()->getManager();
        
        $lineStrategicId = $request->request->get('lineStrategicId');
        $objetiveLevelId = ObjetiveLevel::LEVEL_ESTRATEGICO;
        
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
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();
        
        $objetiveStrategicId = $request->request->get('objetiveStrategicId');
        
        if(is_numeric($objetiveStrategicId)){
            $objetiveStrategic = $em->getRepository('PequivenObjetiveBundle:Objetive')->findOneBy(array('id' => $objetiveStrategicId));
            $query = $em->createQueryBuilder()
                        ->select('o')
                        ->from('\Pequiven\ObjetiveBundle\Entity\Objetive', 'o')
                        ->andWhere("o.parent = ".$objetiveStrategic->getId())
                        ->groupBy('o.ref')
                    ;
            if($securityContext->isGranted(array('ROLE_GENERAL_COMPLEJO','ROLE_GENERAL_COMPLEJO_AUX','ROLE_MANAGER_FIRST','ROLE_MANAGER_FIRST_AUX','ROLE_MANAGER_SECOND','ROLE_MANAGER_SECOND_AUX'))){
                $query->andWhere("o.gerencia = " . $user->getGerencia()->getId());
            }
            $q = $query->getQuery();
            $results = $q->getResult();

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
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();
        $complejoObject = new \Pequiven\MasterBundle\Entity\Complejo();
        $complejoNameArray = $complejoObject->getRefNameArray();
        
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
        
        
//        if($securityContext->isGranted(array('ROLE_MANAGER_FIRST','ROLE_MANAGER_FIRST_AUX'))){
//            //Obtenemos las gerencias de 1ra línea por complejo para el usuario logueado
//            $gerenciasResult = $em->getRepository('PequivenMasterBundle:Gerencia')->findBy(array('ref' => $user->getGerencia()->getRef(), 'complejo' => $complejosArray));
//            foreach($gerenciasResult as $gerencia){
//                $gerenciasObjectArray[] = $gerencia->getId();
//            }
//            $results = $em->getRepository('PequivenMasterBundle:GerenciaSecond')->findBy(array('enabled' => 1,'gerencia' => $gerenciasObjectArray));
//
//        }
        
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
        $objetive = new Objetive();
        $data = array();
        $options = array();
        $em = $this->getDoctrine()->getManager();
        $securityContext = $this->container->get('security.context');
        
        $objetiveTacticId = $request->request->get('objetiveTacticId');
        
        
        $options['objetiveTacticId'] = $objetiveTacticId;
        $options['type'] = 'OPERATIVE';
        $options['type_ref'] = 'OPERATIVE_REF';
        
        $ref = $objetive->setNewRef($options);
        
        $data[] = array('ref' => $ref);
        $response->setData($data);
        return $response;
    }
}
