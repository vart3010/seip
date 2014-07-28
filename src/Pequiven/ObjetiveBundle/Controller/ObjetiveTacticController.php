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
        $objetiveLevel = new ObjetiveLevel();
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();
        //Obtenemos el valor del nivel del objetivo
        $objectObjLevel = $objetiveLevel->typeObjetiveLevel($securityContext,array('em' => $em));
        
        if($securityContext->isGranted(array('ROLE_MANAGER_FIRST_AUX'))){
            $realUser = $em->getRepository('PequivenSEIPBundle:User')->findOneBy(array('id' => $user->getParent()->getId()));
            $personal = $em->getRepository('PequivenMasterBundle:Personal')->findOneBy(array('numPersonal' => $realUser->getNumPersonal()));
        } else{
            $personal = $em->getRepository('PequivenMasterBundle:Personal')->findOneBy(array('numPersonal' => $user->getNumPersonal()));
        }

        $cargo = $em->getRepository('PequivenMasterBundle:Cargo')->findOneBy(array('id' => $personal->getCargo()->getId()));
        $gerencia = $em->getRepository('PequivenMasterBundle:Gerencia')->findOneBy(array('id' => $cargo->getGerencia()->getId()));        
        $complejo = $gerencia->getComplejo();
        $complejoObject = new \Pequiven\MasterBundle\Entity\Complejo();
        $complejoNameArray = $complejoObject->getComplejoNameArray();
        
        $em->getConnection()->beginTransaction();
        if($form->isValid()){
            $object = $form->getData();
            $data =  $this->container->get('request')->get("pequiven_objetive_tactic_registration");
            var_dump($data);
            die();
            $object->setWeight(bcadd(str_replace(',', '.',$data['weight']),'0',3));
            $object->setGoal(bcadd(str_replace(',', '.', $data['goal']),'0',3));
            $object->setRankTop(bcadd(str_replace(',', '.', $data['rankTop']),'0',3));
            $object->setRankMiddleTop(bcadd(str_replace(',', '.', $data['rankMiddleTop']),'0',3));
            $object->setRankMiddleBottom(bcadd(str_replace(',', '.', $data['rankMiddleBottom']),'0',3));
            $object->setRankBottom(bcadd(str_replace(',', '.', $data['rankBottom']),'0',3));

            $securityContext = $this->container->get('security.context');
            $object->setUserCreatedAt($user);
            if($complejo->getComplejoName() === $complejoNameArray[\Pequiven\MasterBundle\Entity\Complejo::COMPLEJO_ZIV]){
                for($i = 0; $i < count($data['complejo']); $i++){
                    ${$nameObject.$i} = clone $object;
                    $complejo = $em->getRepository('PequivenMasterBundle:Complejo')->findOneBy(array('id' => $data['complejo'][$i]));
                    ${$nameObject.$i}->setComplejo($complejo);
                    $em->persist(${$nameObject.$i});
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
            
            return $this->redirect($this->generateUrl('pequiven_seip_menu_home'));
        }
        
        return $this->container->get('templating')->renderResponse('PequivenObjetiveBundle:Tactic:register.html.'.$this->container->getParameter('fos_user.template.engine'),
            array('form' => $form->createView(),
                'object' => $objectObjLevel
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
        
        //TODO: Colocar esto en función
        $user = $securityContext->getToken()->getUser();
        if($securityContext->isGranted(array('ROLE_MANAGER_FIRST_AUX'))){
            $realUser = $em->getRepository('PequivenSEIPBundle:User')->findOneBy(array('id' => $user->getParent()->getId()));
            $personal = $em->getRepository('PequivenMasterBundle:Personal')->findOneBy(array('numPersonal' => $realUser->getNumPersonal()));
        } else{
            $personal = $em->getRepository('PequivenMasterBundle:Personal')->findOneBy(array('numPersonal' => $user->getNumPersonal()));
        }
        $cargo = $em->getRepository('PequivenMasterBundle:Cargo')->findOneBy(array('id' => $personal->getCargo()->getId()));
        $gerencia = $em->getRepository('PequivenMasterBundle:Gerencia')->findOneBy(array('id' => $cargo->getGerencia()->getId()));        
        $complejo = $gerencia->getComplejo();
        $complejoObject = new \Pequiven\MasterBundle\Entity\Complejo();
        $complejoNameArray = $complejoObject->getComplejoNameArray();
        
        $lineStrategicId = $request->request->get('lineStrategicId');
        $objetiveLevelId = ObjetiveLevel::LEVEL_ESTRATEGICO;
        
        if($complejo->getComplejoName() === $complejoNameArray[\Pequiven\MasterBundle\Entity\Complejo::COMPLEJO_ZIV]){
            $results = $em->getRepository('PequivenObjetiveBundle:Objetive')->getByOptionGroupRef(array('type' => 'TACTIC_ZIV','lineStrategicId' => $lineStrategicId, 'objetiveLevelId' => $objetiveLevelId));
        } else{
            $results = $em->getRepository('PequivenObjetiveBundle:Objetive')->getByOptionGroupRef(array('type' => 'TACTIC','lineStrategicId' => $lineStrategicId, 'objetiveLevelId' => $objetiveLevelId, 'complejoId' => $complejo->getId()));
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
        
        //TODO: Colocar esto en función
        $user = $securityContext->getToken()->getUser();
        if($securityContext->isGranted(array('ROLE_MANAGER_FIRST_AUX'))){
            $realUser = $em->getRepository('PequivenSEIPBundle:User')->findOneBy(array('id' => $user->getParent()->getId()));
            $personal = $em->getRepository('PequivenMasterBundle:Personal')->findOneBy(array('numPersonal' => $realUser->getNumPersonal()));
        } else{
            $personal = $em->getRepository('PequivenMasterBundle:Personal')->findOneBy(array('numPersonal' => $user->getNumPersonal()));
        }
        $cargo = $em->getRepository('PequivenMasterBundle:Cargo')->findOneBy(array('id' => $personal->getCargo()->getId()));
        $gerencia = $em->getRepository('PequivenMasterBundle:Gerencia')->findOneBy(array('id' => $cargo->getGerencia()->getId()));        
        $complejo = $gerencia->getComplejo();
        
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
