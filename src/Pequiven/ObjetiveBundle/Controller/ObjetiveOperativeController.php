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
use Pequiven\ObjetiveBundle\Form\Type\Operative\RegistrationFormType as BaseFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 * Description of ObjetiveOperativeController
 *
 * @author matias
 */
class ObjetiveOperativeController extends Controller {
    //put your code here
    
    public function createAction(Request $request){

        $form = $this->createForm(new BaseFormType());
        $form->handleRequest($request);
        $nameObject = 'object';
        
        $em = $this->getDoctrine()->getManager();
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();
        $role = $user->getRoles();
        $complejoObject = new \Pequiven\MasterBundle\Entity\Complejo();
        $complejoNameArray = $complejoObject->getComplejoNameArray();
        
        $em->getConnection()->beginTransaction();
        if($form->isValid()){
            $object = $form->getData();
            $data =  $this->container->get('request')->get("pequiven_objetive_operative_registration");
            //var_dump($data);
            //die();
            $object->setWeight(bcadd(str_replace(',', '.',$data['weight']),'0',3));
            $object->setGoal(bcadd(str_replace(',', '.', $data['goal']),'0',3));
            $object->setRankTop(bcadd(str_replace(',', '.', $data['rankTop']),'0',3));
            $object->setRankMiddleTop(bcadd(str_replace(',', '.', $data['rankMiddleTop']),'0',3));
            $object->setRankMiddleBottom(bcadd(str_replace(',', '.', $data['rankMiddleBottom']),'0',3));
            $object->setRankBottom(bcadd(str_replace(',', '.', $data['rankBottom']),'0',3));
            
            //Obtenemos y Seteamos el nivel del objetivo
            $objetiveLevel = $em->getRepository('PequivenObjetiveBundle:ObjetiveLevel')->findOneBy(array('level' => ObjetiveLevel::LEVEL_OPERATIVO));
            $object->setObjetiveLevel($objetiveLevel);

            $securityContext = $this->container->get('security.context');
            $object->setUserCreatedAt($user);
            $objetive = $em->getRepository('PequivenObjetiveBundle:Objetive')->findOneBy(array('id' => $data['parent']));
                    
            if($user->getComplejo()->getComplejoName() === $complejoNameArray[\Pequiven\MasterBundle\Entity\Complejo::COMPLEJO_ZIV] && !$securityContext->isGranted(array('ROLE_DIRECTIVE','ROLE_DIRECTIVE_AUX'))){
                $object->setGerencia($user->getGerencia());
                for($i = 0; $i < count($data['complejo']); $i++){
                    ${$nameObject.$i} = clone $object;
                    $complejo = $em->getRepository('PequivenMasterBundle:Complejo')->findOneBy(array('id' => $data['complejo'][$i]));
                    $parent = $em->getRepository('PequivenObjetiveBundle:Objetive')->findOneBy(array('complejo' => $data['complejo'][$i], 'ref' => $objetive->getRef()));
                    ${$nameObject.$i}->setComplejo($complejo);
                    ${$nameObject.$i}->setParent($parent);
                    $em->persist(${$nameObject.$i});
                }
            } elseif($user->getComplejo()->getComplejoName() === $complejoNameArray[\Pequiven\MasterBundle\Entity\Complejo::COMPLEJO_ZIV] && $securityContext->isGranted(array('ROLE_DIRECTIVE','ROLE_DIRECTIVE_AUX'))){
                if(!isset($data['check_gerencia'])){//En caso de que las gerencias a impactar por el objetivo sean seleccionadas en el select
                    for($i = 0; $i < count($data['gerencia']); $i++){
                        ${$nameObject.$i} = clone $object;
                        $gerencia = $em->getRepository('PequivenMasterBundle:Gerencia')->findOneBy(array('id' => $data['gerencia'][$i]));
                        $complejo = $gerencia->getComplejo();
                        $parent = $em->getRepository('PequivenObjetiveBundle:Objetive')->findOneBy(array('lineStrategic' => $data['lineStrategic'], 'complejo' => $complejo->getId(), 'ref' => $objetive->getRef()));
                        ${$nameObject.$i}->setGerencia($gerencia);
                        ${$nameObject.$i}->setComplejo($complejo);
                        ${$nameObject.$i}->setParent($parent);
                        $em->persist(${$nameObject.$i});
                    }
                } else{//En caso de que las gerencias a impactar, sean todas la de los complejos seleccionados
                    $j = 0;
                    for($i=0;$i<count($data['complejo']);$i++){//Recorremos todos los complejos seleccionados
                        $complejo = $em->getRepository('PequivenMasterBundle:Complejo')->findOneBy(array('id' => $data['complejo'][$i]));
                        $parent = $em->getRepository('PequivenObjetiveBundle:Objetive')->findOneBy(array('lineStrategic' => $data['lineStrategic'], 'complejo' => $complejo->getId(), 'ref' => $objetive->getRef()));
                        //Obtenemos todas las gerencias 
                        $gerencias = $em->getRepository('PequivenMasterBundle:Gerencia')->findBy(array('complejo' => $data['complejo'][$i]));
                        foreach($gerencias as $gerencia){//Recorremos todos los resultados de las gerencias obtenidas
                            ${$nameObject.$j} = clone $object;
                            ${$nameObject.$j}->setGerencia($gerencia);
                            ${$nameObject.$j}->setComplejo($complejo);
                            ${$nameObject.$j}->setParent($parent);
                            $em->persist(${$nameObject.$j});
                            $j++;
                        }
                    }
                }
            } else{
                $em->persist($object);
            }
            
            try{
            $em->flush();
            $em->getConnection()->commit();
            } catch (Exception $e){
                $em->getConnection()->rollback();
                throw $e;
            }
            
            return $this->redirect($this->generateUrl('pequiven_objetive_home', array('type' => 'operative')));
        }
        
        return $this->container->get('templating')->renderResponse('PequivenObjetiveBundle:Operative:register.html.'.$this->container->getParameter('fos_user.template.engine'),
            array('form' => $form->createView(),
                'role_name' => $role[0]
                ));
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
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();
        $complejoObject = new \Pequiven\MasterBundle\Entity\Complejo();
        $complejoNameArray = $complejoObject->getComplejoNameArray();
        
        $lineStrategicId = $request->request->get('lineStrategicId');
        $objetiveLevelId = ObjetiveLevel::LEVEL_ESTRATEGICO;
        
        if($user->getComplejo()->getComplejoName() === $complejoNameArray[\Pequiven\MasterBundle\Entity\Complejo::COMPLEJO_ZIV]){
            $results = $em->getRepository('PequivenObjetiveBundle:Objetive')->getByOptionGroupRef(array('type' => 'OPERATIVE_ZIV','lineStrategicId' => $lineStrategicId, 'objetiveLevelId' => $objetiveLevelId));
        } else{
            $results = $em->getRepository('PequivenObjetiveBundle:Objetive')->getByOptionGroupRef(array('type' => 'OPERATIVE','lineStrategicId' => $lineStrategicId, 'objetiveLevelId' => $objetiveLevelId, 'complejoId' => $user->getComplejo()->getId()));
        }
        foreach ($results as $result){
            $objetiveChildrenStrategic[] = array("id" => $result->getId(), "description" => $result->getRef() . ' ' . $result->getDescription());
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
        $data = array();
        $objetiveChildrenTactic = array();
        $em = $this->getDoctrine()->getManager();
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();
        $complejoObject = new \Pequiven\MasterBundle\Entity\Complejo();
        $complejoNameArray = $complejoObject->getComplejoNameArray();
        
        $objetiveStrategicId = $request->request->get('objetiveStrategicId');
        
        if($user->getComplejo()->getComplejoName() === $complejoNameArray[\Pequiven\MasterBundle\Entity\Complejo::COMPLEJO_ZIV] && !$securityContext->isGranted(array('ROLE_MANAGER_SECOND','ROLE_MANAGER_SECOND_AUX'))){
            $objetive = $em->getRepository('PequivenObjetiveBundle:Objetive')->findOneBy(array('id' => $objetiveStrategicId));
            $objetives = $em->getRepository('PequivenObjetiveBundle:Objetive')->findBy(array('ref' => $objetive->getRef()));
            $contParents = 1;
            $totalParents = count($objetives);
            $parents = '';
            foreach($objetives as $objetiveParent){
                if($contParents == $totalParents){
                    $parents.= $objetiveParent->getId();
                } else{
                    $parents.= $objetiveParent->getId().',';
                }
                $contParents++;
            }
            $query = $em->createQueryBuilder()
                    ->select('o')
                    ->from('\Pequiven\ObjetiveBundle\Entity\Objetive', 'o')
                    ->andWhere("o.parent IN (".$parents.")")
                    ->groupBy('o.ref');
            if($securityContext->isGranted(array('ROLE_MANAGER_FIRST','ROLE_MANAGER_FIRST_AUX'))){
                //$results = $em->getRepository('PequivenObjetiveBundle:Objetive')->findBy(array('parent' => $parents));
                $query->andWhere('o.gerencia = ' . $user->getGerencia()->getId());
            }
            $q = $query->getQuery();
            $results = $q->getResult();
        } else{
            $results = $em->getRepository('PequivenObjetiveBundle:Objetive')->findBy(array('parent' => $objetiveStrategicId, 'complejo' => $user->getComplejo()->getId(), 'gerencia' => $user->getGerencia()->getId()));
        }
        foreach ($results as $result){
            $objetiveChildrenTactic[] = array("id" => $result->getId(), "description" => $result->getRef() . ' ' . $result->getDescription());
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
        $complejoNameArray = $complejoObject->getComplejoNameArray();
        
        $objetiveTacticId = $request->request->get('objetiveTacticId');
        
        //Obtener el objetivo para obtener la referencia
        $objetiveTactic = $em->getRepository('PequivenObjetiveBundle:Objetive')->findOneBy(array('id' => $objetiveTacticId));
        
        //Obtenemos los Objetivos Tácticos que tengan como referencia el obtenido en el paso anterior
        if($securityContext->isGranted(array('ROLE_MANAGER_FIRST','ROLE_MANAGER_FIRST_AUX'))){
            $results = $em->getRepository('PequivenObjetiveBundle:Objetive')->findBy(array('ref' => $objetiveTactic->getRef(), 'gerencia' => $user->getGerencia()->getId()));
        } else{
            $results = $em->getRepository('PequivenObjetiveBundle:Objetive')->findBy(array('ref' => $objetiveTactic->getRef()));
        }
        
        $i=1;
        $total = count($results);
        foreach ($results as $result){
            if($i == 1){
                $complejoChildren[] = array("id" => $result->getComplejo()->getId(), "description" => $result->getComplejo()->getDescription());
            } else{
                if($objectBefore->getComplejo()->getId() != $result->getComplejo()->getId()){
                    if($i < $total){
                        $complejoChildren[] = array("id" => $objectBefore->getComplejo()->getId(), "description" => $objectBefore->getComplejo()->getDescription());
                    } else{
                        $complejoChildren[] = array("id" => $result->getComplejo()->getId(), "description" => $result->getComplejo()->getDescription());
                    }
                }
            }
            $objectBefore = clone $result;
            $i++;
//            $complejoChildren[] = array("id" => $result->getComplejo()->getId(), "description" => $result->getComplejo()->getDescription());
        }
        
        $response->setData($complejoChildren);
        
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
            //var_dump($result);
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
