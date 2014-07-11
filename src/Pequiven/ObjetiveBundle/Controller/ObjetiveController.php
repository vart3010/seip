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
    
    public function createAction(Request $request){
        
        $form = $this->createForm(new BaseFormType());
        $form->handleRequest($request);
        
        
        if($form->isValid()){
            $object = $form->getData();
            $object->create();

            $xx = $this->container->get('pequiven_objetive.registration.form.type');
            var_dump($object);
            $em = $this->getDoctrine()->getManager();
            $em->persist($object);
            //var_dump($object->getFkObjetiveLevel()->getId());
            $em->flush();
            die();
//            $objetive = new Objetive();
//            $objetive->setFkObjetiveLevel($object->getFkObjetiveLevel()->getId());
//            $objetive->setFkComplejo($object->getFkComplejo()->getId());
//            $object->setFkObjetiveLevel();
            
        }
        
        return $this->container->get('templating')->renderResponse('PequivenObjetiveBundle:Default:register.html.'.$this->container->getParameter('fos_user.template.engine'),
            array('form' => $form->createView()));
    }
    
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
}
