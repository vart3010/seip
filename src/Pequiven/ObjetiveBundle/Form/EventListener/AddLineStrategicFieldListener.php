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
use Pequiven\ObjetiveBundle\Entity\ObjetiveLevel;
use Pequiven\MasterBundle\Entity\Complejo;
use Pequiven\ObjetiveBundle\PequivenObjetiveBundle;
use Doctrine\ORM\EntityRepository;

/**
 * Description of AddComplejoFieldListener
 *
 * @author matias
 */
class AddLineStrategicFieldListener implements EventSubscriberInterface {
    //put your code here
    
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
            return $this->addLineStrategicForm($form, $object);
        }
        
        $this->addLineStrategicForm($form, $object);
    }
    
    public function preSubmit(FormEvent $event){
        $form = $event->getForm();
        $this->addLineStrategicForm($form);
    }
    //$builder->add('complejo2', 'entity', array('label' => 'form.complejo', 'translation_domain' => 'PequivenObjetiveBundle','class' => 'PequivenMasterBundle:Complejo', 'property' => 'description','empty_value' => 'Todo','expanded' => true));
    public function addLineStrategicForm($form, $lineStrategic = null){
        
        $formOptions = array(
            'class' => 'PequivenMasterBundle:LineStrategic',
            'label' => 'form.line_strategic',
            'label_attr' => array('class' => 'label'),
            'translation_domain' => 'PequivenObjetiveBundle',
            'property' => 'descriptionSelect',
            'empty_value' => 'Seleccione la línea estratégica'
        );
        $formOptions['attr'] = array('class' => 'populate placeholder select2-offscreen', 'style' => 'width:300px');
        if($lineStrategic){
            $formOptions['data'] = $lineStrategic;
        }
        
        $form->add('lineStrategic','entity',$formOptions);
    }
}
