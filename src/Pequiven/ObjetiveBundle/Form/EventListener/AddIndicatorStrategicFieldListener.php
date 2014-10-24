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
use Symfony\Component\DependencyInjection\ContainerInterface;
use Pequiven\MasterBundle\Entity\Complejo;
use Doctrine\ORM\EntityRepository;

/**
 * Description of AddIndicatorStrategicFieldListener
 *
 * @author matias
 */
class AddIndicatorStrategicFieldListener implements EventSubscriberInterface {
    //put your code here
    protected $container;
    protected $securityContext;
    protected $user;
    protected $em;
    
    protected $typeStrategic = false;
    protected $typeTactic = false;
    protected $typeOperative = false;
    
    public static function getSubscribedEvents() {
        return array(
        FormEvents::PRE_SET_DATA => 'preSetData',
        FormEvents::PRE_SUBMIT => 'preSubmit'
        );
    }
    
    public function __construct(ContainerInterface $container,$options = array()) {
        $this->container = $container;
        $this->securityContext = $this->container->get('security.context');
        $this->user = $this->securityContext->getToken()->getUser();
        $this->em = $this->container->get('doctrine')->getManager();
        
        if(isset($options['typeStrategic'])){
            $this->typeStrategic = true;
        }
        if(isset($options['typeTactic'])){
            $this->typeTactic = true;
        }
        if(isset($options['typeOperative'])){
            $this->typeOperative = true;
        }
    }
    
    public function preSetData(FormEvent $event){
        $object = $event->getData();
        $form = $event->getForm();
        
        if(null === $object){
           return $this->addIndicatorStrategicForm($form, $object);
        }
        
        $this->addIndicatorStrategicForm($form, $object);
    }
    
    public function preSubmit(FormEvent $event){
        $form = $event->getForm();
        $this->addIndicatorStrategicForm($form);
    }
    
    public function addIndicatorStrategicForm($form,$indicator = null){
        
        $formOptions = array(
            'class' => 'PequivenIndicatorBundle:Indicator',
            'label_attr' => array('class' => 'label'),
            'translation_domain' => 'PequivenObjetiveBundle',
            'property' => 'description',
            'attr' => array('class' => 'select2-offscreen populate placeholder','multiple' => 'multiple', 'style' => 'width:300px','required' => false),
            'multiple' => true,
            'required' => false,
            'mapped' => false
        );
        
        if($this->typeStrategic){
            $formOptions['label'] = 'form.indicatorsStrategic';
        } elseif($this->typeTactic){
            $formOptions['label'] = 'form.indicatorsTactic';
        } elseif($this->typeOperative){
            $formOptions['label'] = 'form.indicatorsOperative';
        }
        
        if($indicator){
            $formOptions['data'] = $indicator;
        }
        
        $form->add('indicators','entity',$formOptions);
    }
}
