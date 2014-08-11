<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\IndicatorBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Description of AddComplejoFieldListener
 *
 * @author matias
 */
class AddFormulaFieldListener implements EventSubscriberInterface {
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
            return $this->addFormulaForm($form, $object);
        }
        
        $this->addFormulaForm($form, $object);
    }
    
    public function preSubmit(FormEvent $event){
        $form = $event->getForm();
        $this->addFormulaForm($form);
    }
    //$builder->add('complejo2', 'entity', array('label' => 'form.complejo', 'translation_domain' => 'PequivenObjetiveBundle','class' => 'PequivenMasterBundle:Complejo', 'property' => 'description','empty_value' => 'Todo','expanded' => true));
    public function addFormulaForm($form, $formula = null){
        
        $formOptions = array(
            'class' => 'PequivenMasterBundle:Formula',
            'label' => 'form.formula',
            'label_attr' => array('class' => 'label'),
            'translation_domain' => 'PequivenIndicatorBundle',
            'property' => 'equation',
            'required' => false,
            'mapped' => false
        );
        $formOptions['attr'] = array('class' => 'populate placeholder select2-offscreen', 'style' => 'width:300px','required' => false);
        if($formula){
            $formOptions['data'] = $formula;
        }
        
        $form->add('formula','entity',$formOptions);
    }
}
