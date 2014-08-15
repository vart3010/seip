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
use Pequiven\ObjetiveBundle\Form\Type\Strategic\RegistrationFormType as BaseFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 * Description of ObjetiveStrategicController
 *
 * @author matias
 */
class ObjetiveStrategicController extends Controller {
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
        //Primero obtenemos todos los objetivos estratégicos
        $em = $this->getDoctrine()->getManager();
        $objectView = array();
        $objetives = $em->getRepository('PequivenObjetiveBundle:Objetive')->findBy(array('objetiveLevel' => ObjetiveLevel::LEVEL_ESTRATEGICO,'complejo' => \Pequiven\MasterBundle\Entity\Complejo::COMPLEJO_ZIV));
        
        foreach($objetives as $objetive){
            
        }
        
        return $this->container->get('templating')->renderResponse('PequivenObjetiveBundle:Strategic:list.html.'.$this->container->getParameter('fos_user.template.engine'),
            array(

            ));
    }
    
    public function createAction(Request $request){
        
        $form = $this->createForm(new BaseFormType());
        $form->handleRequest($request);
        $nameObject = 'object';
        $lastId = '';
        //Obtenemos el valor del nivel del objetivo
        $em = $this->getDoctrine()->getManager();
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();;
        //$objetiveLevel = new ObjetiveLevel();
        //$objectObjLevel = $objetiveLevel->typeObjetiveLevel($this->container->get('security.context'),array('em' => $em));
        
        $em->getConnection()->beginTransaction();
        if($form->isValid()){
            $object = $form->getData();
            $data =  $this->container->get('request')->get("pequiven_objetive_strategic_registration");
            //$object->setWeight(bcadd($data['weight'],'0',3));
            $object->setGoal(bcadd(str_replace(',', '.', $data['goal']),'0',3));
            $object->setUserCreatedAt($user);
            
            //Obtenemos y Seteamos el nivel del objetivo
            $objetiveLevel = $em->getRepository('PequivenObjetiveBundle:ObjetiveLevel')->findOneBy(array('level' => ObjetiveLevel::LEVEL_ESTRATEGICO));
            $object->setObjetiveLevel($objetiveLevel);
            
            //Obtenemos y Seteamos todos los complejos que esten activos respectivamente
            $results = $em->getRepository('PequivenMasterBundle:Complejo')->findBy(array('enabled' => true));
            $total = count($results);            
            if(is_array($results) && $total > 0){
                $i = 0;
                foreach ($results as $result){
                    ${$nameObject.$i} = clone $object;
                    ${$nameObject.$i}->setComplejo($result);
                    $em->persist(${$nameObject.$i});
                    $i++;
                }
            }
            
            //Recorremos el select de los complejos
//            for($i = 0; $i < count($data['complejo']); $i++){
//                ${$nameObject.$i} = clone $object;
//                $complejo = $em->getRepository('PequivenMasterBundle:Complejo')->findOneBy(array('id' => $data['complejo'][$i]));
//                ${$nameObject.$i}->setComplejo($complejo);
//                $em->persist(${$nameObject.$i});
//            }
            
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
            
            return $this->redirect($this->generateUrl('pequiven_objetive_home', array('type' => 'strategic')));
        }
        
        return $this->container->get('templating')->renderResponse('PequivenObjetiveBundle:Strategic:register.html.'.$this->container->getParameter('fos_user.template.engine'),
            array('form' => $form->createView(),
                ));
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
     * Devuelve la Referencia del Objetivo, de acuerdo a la cantidad que ya se encuentren registrados
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function displayRefObjetiveAction(Request $request){
        $response = new JsonResponse();
        $objetive = new Objetive();
        $data = array();
        $options = array();
        
        $lineStrategicId = $request->request->get('lineStrategicId');
        $options['lineStrategicId'] = $lineStrategicId;
        $options['type'] = 'STRATEGIC';
        $ref = $objetive->setNewRef($options);
        
        $data[] = array('ref' => $ref);
        $response->setData($data);
        return $response;
    }

}
