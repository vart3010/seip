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
/**
 * Description of AddGerenciaFieldListener
 *
 * @author matias
 */
class AddGerenciaFieldListener implements EventSubscriberInterface {
    //put your code here
    public function getSubscribedEvents() {
        return array(
        FormEvents::PRE_SET_DATA => 'preSetData',
        FormEvents::PRE_SUBMIT => 'pre_submit'
        );
    }
    
    public function preSetData(FormEvent $event){
        
    }
    
    public function preSetSubmit(FormEvent $event){
        
    }
}
