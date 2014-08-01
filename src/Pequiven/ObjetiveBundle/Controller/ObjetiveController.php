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
use Pequiven\ObjetiveBundle\Form\Type\RegistrationFormType as BaseFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 * Description of ObjetiveController
 *
 * @author matias
 */
class ObjetiveController extends Controller{
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
    
    public function showHomeAction($type){
        if($type == 'strategic'){
            $message = "Objetivo Estratégico creado exitosamente";
        } elseif ($type == 'tactic'){
            $message = "Objetivo Táctico creado exitosamente";
        } elseif ($type == 'operative'){
            $message = "Objetivo Operativo creado exitosamente";
        }
        
        return $this->container->get('templating')->renderResponse('PequivenObjetiveBundle:Default:index.html.'.$this->container->getParameter('fos_user.template.engine'),
        array('message' => $message,
            'notification' => true
            ));

    }
    
    /**
     * Función que redirecciona
     * @param type $message
     * @return type
     */
    public function redirectObjetiveAction($message = ''){
        return $this->container->get('templating')->renderResponse('PequivenObjetiveBundle:Default:index.html.'.$this->container->getParameter('fos_user.template.engine'),
                array('message' => $message,
                    'notification' => true
                    ));
    }
    
    public function createAction(Request $request){
        
        $form = $this->createForm(new BaseFormType());        
        $form->handleRequest($request);
        $nameObject = 'object';
        
        
        //$objetiveLevelRepository = $em->getRepository('PequivenObjetiveBundle:ObjetiveLevel')->findBy(array('id' => 1));
        //Obtenemos el valor del nivel del objetivo
        $em = $this->getDoctrine()->getManager();
        $objetiveLevel = new ObjetiveLevel();
        $objectObjLevel = $objetiveLevel->typeObjetiveLevel($this->container->get('security.context'),array('em' => $em));
        
//        $result = $objetiveLevel->fetchBy($em,array('id' => 1));
//        var_dump($this->container->get('security.context')->getToken()->getUser()->getRoles());
//        var_dump($this->container->get('security.context')->isGranted(array('ROLE_MANAGER_FIRST')));
        $em->getConnection()->beginTransaction();
        if($form->isValid()){
            $object = $form->getData();
            $data =  $this->container->get('request')->get("pequiven_objetive_registration");
            var_dump($data);
            die();
            $object->setWeight(bcadd($data['weight'],'0',3));
            $object->setGoal(bcadd($data['goal'],'0',3));
            $object->setRankTop(bcadd($data['rankTop'],'0',3));
            $object->setRankMiddleTop(bcadd($data['rankMiddleTop'],'0',3));
            $object->setRankMiddleBottom(bcadd($data['rankMiddleBottom'],'0',3));
            $object->setRankBottom(bcadd($data['rankBottom'],'0',3));
//            var_dump('<br><br>');
//            var_dump($object->getWeight());
//            var_dump('<br><br>');
//            var_dump($data);
//            die();
            $securityContext = $this->container->get('security.context');
            $user = $securityContext->getToken()->getUser();;
            $object->setUserCreatedAt($user);
            if($securityContext->isGranted(array('ROLE_DIRECTIVE','ROLE_DIRECTIVE_AUX'))){
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
            //$em = $this->getDoctrine()->getManager();
            //$em->persist($object);
            //var_dump($object->getFkObjetiveLevel()->getId());
            //$em->flush();
        }
        
        return $this->container->get('templating')->renderResponse('PequivenObjetiveBundle:Default:register.html.'.$this->container->getParameter('fos_user.template.engine'),
            array('form' => $form->createView(),
                'object' => $objectObjLevel
                ));
    }
    
    /**
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function verifyObjetiveLevelAction(Request $request){
        $response = new JsonResponse();
        $objetiveLevel_id = $request->request->get('objetiveLevel_id');
        
        $data = array();
        if($objetiveLevel_id >= ObjetiveLevel::LEVEL_TACTICO){
            $data[] = array("verify" => "show");
        } else{
            $data[] = array("verify" => "hide");
        }
        
        $response->setData($data);
        
       return $response;
    }
    
    /**
     * Devuelve la Línea Estratégica de Acuerdo al Objetivo Estratégico seleccionado
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function verifyObjetiveParentLineStrategicAction(Request $request){
        $response = new JsonResponse();
        $data = array();
        $em = $this->getDoctrine()->getManager();
        $objetiveParentStrategic_id = $request->request->get('objetiveParentStrategic_id');
        $objetive = $em->getRepository('PequivenObjetiveBundle:Objetive')->findOneBy(array('id' => $objetiveParentStrategic_id));
        $lineStrategic = $objetive->getLineStrategic();
        $show_weight = $objetive->getEvalSimpleAverage() === true ? false : true;
        $data[] = array("description" => $lineStrategic->getDescription(),"show_weight" => $show_weight);
        
        $response->setData($data);
        
        return $response;
    }
    
    /**
     * Devuelve los Objetivos Tácticos hijos de acuerdo al Objetivo Estratégico seleccionado
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function selectObjetiveParentTacticAction(Request $request){
        $response = new JsonResponse();
        $objetiveChildrenTactic = array();
        $objetiveParentStrategic_id = $request->request->get('objetiveParentStrategic_id');
        $em = $this->getDoctrine()->getManager();
        $results = $em->getRepository('PequivenObjetiveBundle:Objetive')->findBy(array('parent' => $objetiveParentStrategic_id));
        foreach ($results as $result){
            $objetiveChildrenTactic[] = array("id" => $result->getId(), "description" => $result->getDescription());
        }
//        var_dump($objetiveChildrenTactic[0]->getId());
//        die();
        $response->setData($objetiveChildrenTactic);
        //var_dump($response[0]);
        //var_dump(new JsonResponse($objetiveChildrenTactic));
        //die();
        return $response;
    }
    
    public function displayRefObjetiveAction(Request $request){
        $response = new JsonResponse();
        
        return $response;
    }
    
    /**
     * Determina el peso por defecto a mostrar en el input text, y en su defecto cambiar los atributos con jquery
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function displayWeightObjetiveAction(Request $request){
        $response = new JsonResponse();
        
        $weightObjetive = array();
        $objetiveParentId = $request->request->get('objetiveParentId');
        $em = $this->getDoctrine()->getManager();
        $results = $em->getRepository('PequivenObjetiveBundle:Objetive')->findBy(array('parent' => $objetiveParentId));
        $totalWeight = 0;
        foreach ($results as $result){
            $totalWeight = $totalWeight + $result->getWeight();
        }
        $weight = 100 - $totalWeight;
        $weightObjetive[] = array("weight_max" => $weight);
        $response->setData($weightObjetive);
       
        return $response;
    }
}
