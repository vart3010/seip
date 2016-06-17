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
use Doctrine\ORM\EntityRepository;

/**
 * Description of AddComplejoFieldListener
 *
 * @author matias
 */
class AddLineStrategicFieldListener implements EventSubscriberInterface {
    
    protected $container;
    protected $typeOperative = false;
    protected $typeTactic = false;
    protected $registerIndicator = false;
    
    /**
     * 
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     * @param type $options
     */
    public function __construct(ContainerInterface $container,$options = array()) {
        $this->container = $container;
        if(isset($options['typeOperative'])){
            $this->typeOperative = true;
        }
        if(isset($options['typeTactic'])){
            $this->typeTactic = true;
        }
        if(isset($options['registerIndicator'])){
            $this->registerIndicator = true;
        }
    }
    
    public static function getSubscribedEvents() {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_SUBMIT => 'preSubmit'
                );
    }

    public function preSetData(FormEvent $event){
        $object = $event->getData();
        $form = $event->getForm();
        
        if(null === $object){
            return $this->addLineStrategicForm($form);
        }

        $this->addLineStrategicForm($form, $object->getLineStrategics());
    }
    
    public function preSubmit(FormEvent $event){
        $form = $event->getForm();
        $this->addLineStrategicForm($form);
    }
    //$builder->add('complejo2', 'entity', array('label' => 'form.complejo', 'translation_domain' => 'PequivenObjetiveBundle','class' => 'PequivenMasterBundle:Complejo', 'property' => 'description','empty_value' => 'Todo','expanded' => true));
    public function addLineStrategicForm($form, $lineStrategic = null){
        
        $formOptions = array(
            'class' => 'PequivenMasterBundle:LineStrategic',
            'label' => 'form.lineStrategic',
            'label_attr' => array('class' => 'label'),
            'translation_domain' => 'PequivenObjetiveBundle',
            'property' => 'descriptionSelect',
            'empty_value' => '',            
        );
        
        if($this->typeOperative){
            $formOptions['attr'] = array('class' => 'placeholder select2-offscreen','style' => 'width:300px');
            $formOptions['mapped'] = false;
        } elseif($this->typeTactic){
            $formOptions['attr'] = array('class' => 'populate placeholder select2-offscreen','multiple' => 'multiple','style' => 'width:300px');
            $formOptions['multiple'] = true;
            $formOptions['mapped'] = false;
        } else{
            $formOptions['attr'] = array('class' => 'populate placeholder select2-offscreen', 'multiple' => 'multiple' ,'style' => 'width:300px');
            $formOptions['multiple'] = true;
            if($this->registerIndicator){
                $formOptions['mapped'] = false;
            }
        }
        
        //'empty_value' => 'Seleccione la línea estratégica'
        if($lineStrategic){
            //var_dump($lineStrategic);
            //die();
            $formOptions['data'] = $lineStrategic;
        }
        
        $form->add('lineStrategics','entity',$formOptions);
    }
}
