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
use Pequiven\ObjetiveBundle\Form\Type\Tactic\RegistrationFormType as BaseFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 * Description of ObjetiveController
 *
 * @author matias
 */
class ObjetiveTacticController extends Controller{
    //put your code here
    
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction($name)
    {
        return array('name' => $name);
    }
    
    public function listAction(){
        return array();
    }
    
    public function createAction(Request $request){

        $form = $this->createForm(new BaseFormType());
        $form->handleRequest($request);
        $nameObject = 'object';
        
        $em = $this->getDoctrine()->getManager();
        
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();
        $role = $user->getRoles();
        //Obtenemos el valor del nivel del objetivo
        $complejoObject = new \Pequiven\MasterBundle\Entity\Complejo();
        $complejoNameArray = $complejoObject->getComplejoNameArray();
        
        $em->getConnection()->beginTransaction();
        if($form->isValid()){
            $object = $form->getData();
            $data =  $this->container->get('request')->get("pequiven_objetive_tactic_registration");
            $object->setWeight(bcadd(str_replace(',', '.',$data['weight']),'0',3));
            $object->setGoal(bcadd(str_replace(',', '.', $data['goal']),'0',3));
            $object->setRankTop(bcadd(str_replace(',', '.', $data['rankTop']),'0',3));
            $object->setRankMiddleTop(bcadd(str_replace(',', '.', $data['rankMiddleTop']),'0',3));
            $object->setRankMiddleBottom(bcadd(str_replace(',', '.', $data['rankMiddleBottom']),'0',3));
            $object->setRankBottom(bcadd(str_replace(',', '.', $data['rankBottom']),'0',3));
            
            //Obtenemos y Seteamos el nivel del objetivo
            $objetiveLevel = $em->getRepository('PequivenObjetiveBundle:ObjetiveLevel')->findOneBy(array('level' => ObjetiveLevel::LEVEL_TACTICO));
            $object->setObjetiveLevel($objetiveLevel);

            $object->setUserCreatedAt($user);
            $objetive = $em->getRepository('PequivenObjetiveBundle:Objetive')->findOneBy(array('id' => $data['parent']));
            if($user->getComplejo()->getComplejoName() === $complejoNameArray[\Pequiven\MasterBundle\Entity\Complejo::COMPLEJO_ZIV] && !$securityContext->isGranted(array('ROLE_DIRECTIVE','ROLE_DIRECTIVE_AUX'))){
                $object->setGerencia($user->getGerencia());
                for($i = 0; $i < count($data['complejo']); $i++){
                    ${$nameObject.$i} = clone $object;
                    $complejo = $em->getRepository('PequivenMasterBundle:Complejo')->findOneBy(array('id' => $data['complejo'][$i]));
                    $parent = $em->getRepository('PequivenObjetiveBundle:Objetive')->findOneBy(array('lineStrategic' => $data['lineStrategic'], 'complejo' => $data['complejo'][$i], 'ref' => $objetive->getRef()));
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
            
            return $this->redirect($this->generateUrl('pequiven_objetive_home', array('type' => 'tactic')));
//                    $this->forward('PequivenObjetiveBundle:Objetive:redirectObjetive', array(
//               'message' => 'Objetivo Táctico creado exitosamente'
//            ));
//            return $this->container->get('templating')->renderResponse('PequivenObjetiveBundle:Tactic:register.html.'.$this->container->getParameter('fos_user.template.engine'),
//                array('form' => $form->createView(),
//                    'object' => $objectObjLevel,
//                    'action' => 'successful'
//                    ));
        }
        
        return $this->container->get('templating')->renderResponse('PequivenObjetiveBundle:Tactic:register.html.'.$this->container->getParameter('fos_user.template.engine'),
            array('form' => $form->createView(),
                'role_name' => $role[0]
                ));
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
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();
        $complejoObject = new \Pequiven\MasterBundle\Entity\Complejo();
        $complejoNameArray = $complejoObject->getComplejoNameArray();
        
        $lineStrategicId = $request->request->get('lineStrategicId');
        $objetiveLevelId = ObjetiveLevel::LEVEL_ESTRATEGICO;
        
        if($user->getComplejo()->getComplejoName() === $complejoNameArray[\Pequiven\MasterBundle\Entity\Complejo::COMPLEJO_ZIV]){
            $results = $em->getRepository('PequivenObjetiveBundle:Objetive')->getByOptionGroupRef(array('type' => 'TACTIC_ZIV','lineStrategicId' => $lineStrategicId, 'objetiveLevelId' => $objetiveLevelId));
        } else{
            $results = $em->getRepository('PequivenObjetiveBundle:Objetive')->getByOptionGroupRef(array('type' => 'TACTIC','lineStrategicId' => $lineStrategicId, 'objetiveLevelId' => $objetiveLevelId, 'complejoId' => $user->getComplejo()->getId()));
        }
        foreach ($results as $result){
            $objetiveChildrenStrategic[] = array("id" => $result->getId(), "description" => $result->getRef() . ' ' . $result->getDescription());
        }
        
        $response->setData($objetiveChildrenStrategic);
        
        return $response;
    }
    
    /**
     * Devuelve los Complejos de acuerdo al Objetivo Estratégico seleccionado
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function selectComplejoFromObjetiveStrategicAction(Request $request){
        $response = new JsonResponse();
        $complejoChildren = array();
        $em = $this->getDoctrine()->getManager();
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();
        
        $lineStrategicId = $request->request->get('lineStrategicId');
        $objetiveStrategicId = $request->request->get('objetiveStrategicId');
        $objetiveObject = $em->getRepository('PequivenObjetiveBundle:Objetive')->findOneBy(array('id'=>$objetiveStrategicId));
        
        $results = $em->getRepository('PequivenObjetiveBundle:Objetive')->findBy(array('ref' => $objetiveObject->getRef(), 'lineStrategic' => $lineStrategicId));
        foreach ($results as $result){
            $complejoChildren[] = array("id" => $result->getComplejo()->getId(), "description" => $result->getComplejo()->getDescription());
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
    
    public function testComplejoAction(){
        $response = new JsonResponse();
        $complejoChildren = array();
        
        for($i = 1; $i<=6; $i++){
            $complejoChildren[] = array("id" => $i, "description" => 'Complejo '.$i);
        }
        
        $response->setData($complejoChildren);
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
