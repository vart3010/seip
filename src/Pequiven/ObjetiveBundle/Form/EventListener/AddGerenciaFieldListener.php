<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\ObjetiveBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Pequiven\ObjetiveBundle\PequivenObjetiveBundle;
use Pequiven\MasterBundle\Entity\Complejo;
use Doctrine\ORM\EntityRepository;
/**
 * Description of AddGerenciaFieldListener
 *
 * @author matias
 */
class AddGerenciaFieldListener implements EventSubscriberInterface {
    //put your code here
    protected $container;
    protected $securityContext;
    protected $user;
    protected $em;
    
    protected $complejoObject;
    protected $complejoNameArray = array();
    
    public static function getSubscribedEvents() {
        return array(
        FormEvents::PRE_SET_DATA => 'preSetData',
        FormEvents::PRE_SUBMIT => 'preSubmit'
        );
    }
    
    public function __construct() {
        $this->container = PequivenObjetiveBundle::getContainer();
        $this->securityContext = $this->container->get('security.context');
        $this->user = $this->securityContext->getToken()->getUser();
        $this->em = $this->container->get('doctrine')->getManager();
        
        $this->complejoObject = new Complejo();
        $this->complejoNameArray = $this->complejoObject->getComplejoNameArray();
    }
    
    public function preSetData(FormEvent $event){
        $object = $event->getData();
        $form = $event->getForm();
        
        if(null === $object){
           return $this->addGerenciaForm($form, $object);
        }
        
        $this->addGerenciaForm($form, $object);
    }
    
    public function preSubmit(FormEvent $event){
        $form = $event->getForm();
        $this->addGerenciaForm($form);
    }
    
    public function addGerenciaForm($form,$gerencia = null){
        //$this->getTypePersonal(array('ROLE_MANAGER_FIRST_AUX','ROLE_MANAGER_SECOND_AUX'));
        $gerenciaId = $this->user->getGerencia()->getId();
        $gerencia = $gerencia == null ? $this->user->getGerencia() : $gerencia;
        
        $formOptions = array(
            'class' => 'PequivenMasterBundle:Gerencia',
            'label' => 'form.gerencia',
            'label_attr' => array('class' => 'label'),
            'translation_domain' => 'PequivenObjetiveBundle',
            'property' => 'description',            
            'query_builder' => function (EntityRepository $er) use ($gerenciaId){
                $qb = $er->createQueryBuilder('gerencia')
                         ->where('gerencia.id = :gerenciaId')
                         ->setParameter('gerenciaId', $gerenciaId)
                        ;
                return $qb;
            }
        );
        
        if($this->securityContext->isGranted(array('ROLE_DIRECTIVE','ROLE_DIRECTIVE_AUX'))){
            $formOptions['choices'] = $this->em->getRepository('PequivenMasterBundle:Gerencia')->getGerenciaOptions();
            $gerencia = null;
            $formOptions['attr'] = array('class' => 'select2-offscreen populate placeholder','multiple' => 'multiple', 'style' => 'width:300px');
            $formOptions['multiple'] = true;
            $formOptions['mapped'] = false;
        } else{
             $formOptions['attr'] = array('class' => 'select red-gradient check-list allow-empty', 'style' => 'width:300px');
         }
        
        if($gerencia){
            $formOptions['data'] = $gerencia;
        }
        
        $form->add('gerencia','entity',$formOptions);
    }
}
