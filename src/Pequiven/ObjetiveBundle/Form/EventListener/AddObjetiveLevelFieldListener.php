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
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Pequiven\ObjetiveBundle\Entity\ObjetiveLevel;
use Pequiven\ObjetiveBundle\Repository\ObjetiveLevelRepository;
/**
 * Description of AddObjetiveLevelFieldListener
 *
 * @author matias
 */
class AddObjetiveLevelFieldListener implements EventSubscriberInterface,  ContainerAwareInterface {
    //put your code here
    protected $container;
    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
        $this->container = $container;
    }
    
    public function getSubscribedEvents() {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_SUBMIT => 'preSubmit'
                );
    }
    
    private function addObjetiveLevelForm($form, $objetiveLevel = null){

        $formOptions = array(
            'class' => 'PequivenObjetiveBundle:ObjetiveLevel',
            'empty_value' => 'Escoja el nivel de objetivo',
            'label' => 'form.objetive_level',
            'translation_domain' => 'PequivenObjetiveBundle',
          'query_builder' => function(ObjetiveLevelRepository $olr) {
            return $olr->getByUser();
          }
        );
    }
    
    public function preSetData(FormEvent $event){
        
    }
    
    public function preSetSubmit(FormEvent $event){
        
    }
}
