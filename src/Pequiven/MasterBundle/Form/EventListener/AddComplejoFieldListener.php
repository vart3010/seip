<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\MasterBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Pequiven\MasterBundle\PequivenMasterBundle;
use Pequiven\MasterBundle\Entity\Complejo;
use Doctrine\ORM\EntityRepository;

/**
 * Description of AddComplejoFieldListener
 *
 * @author matias
 */
class AddComplejoFieldListener implements EventSubscriberInterface {
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
    
    public function __construct($options = array()) {
        $this->container = PequivenMasterBundle::getContainer();
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
            return $this->addComplejoForm($form, $object);
        }
        
        $this->addComplejoForm($form, $object);
    }
    
    public function preSubmit(FormEvent $event){
        $form = $event->getForm();
        $object = $event->getData();
        
        $this->addComplejoForm($form);
    }
    
    public function addComplejoForm($form, $complejo = null){

        $formOptions = array(
            'class' => 'PequivenMasterBundle:Complejo',
            'label' => 'form.complejo',
            'label_attr' => array('class' => 'label'),
            'translation_domain' => 'PequivenMasterBundle',
            'property' => 'description',
            'mapped' => false,
            'empty_value' => '',
            'attr' => array(
                'class' => 'populate placeholder select2-offscreen select2-allowclear', 'style' => 'width:300px'
                ),
        );
        
        if($complejo){
            $formOptions['data'] = $complejo;
        }

        $form->add('complejo','entity',$formOptions);
    }
}
