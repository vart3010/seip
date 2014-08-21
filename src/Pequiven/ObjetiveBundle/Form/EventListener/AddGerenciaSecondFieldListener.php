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
use Pequiven\MasterBundle\Entity\Gerencia;
use Doctrine\ORM\EntityRepository;

/**
 * Description of AddGerenciaSecondFieldListener
 *
 * @author matias
 */
class AddGerenciaSecondFieldListener implements EventSubscriberInterface {
    //put your code here
    protected $container;
    protected $securityContext;
    protected $user;
    protected $em;
    
    public static function getSubscribedEvents() {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_SUBMIT => 'preSubmit'
                );
    }
    
    public function __construct($options = array()) {
        $this->container = PequivenObjetiveBundle::getContainer();
        $this->securityContext = $this->container->get('security.context');
        $this->user = $this->securityContext->getToken()->getUser();
        $this->em = $this->container->get('doctrine')->getManager();
    }
    
    public function preSetData(FormEvent $event){
        $object = $event->getData();
        $form = $event->getForm();
        
        if(null === $object){
            return $this->addGerenciaSecondForm($form);
        }
        
        $gerenciaId = array_key_exists('gerencia', $object) ? $object['gerencia'] : null;
        
        $this->addGerenciaSecondForm($form, $gerenciaId);
    }
    
    public function preSubmit(FormEvent $event){
        $form = $event->getForm();
        $object = $event->getData();
        
        $gerenciaId = array_key_exists('gerencia', $object) ? $object['gerencia'] : null;
        
        $this->addGerenciaSecondForm($form,$gerenciaId);
    }
    
    public function addGerenciaSecondForm($form,$complejoId = null, $complejo = null){

        $formOptions = array(
            'class' => 'PequivenMasterBundle:GerenciaSecond',
            'label' => 'form.gerencia_second',
            'label_attr' => array('class' => 'label'),
            'translation_domain' => 'PequivenMasterBundle',
            'property' => 'description',
            'empty_value' => '',
            'attr' => array(
                'class' => 'populate placeholder select2-offscreen select2-allowclear', 'style' => 'width:300px'
                ),
        );
        
        $formOptions['query_builder'] = function(EntityRepository $er) use ($complejoId){
                    $qb = $er->createQueryBuilder('gerencia')
                             ->where('gerencia.complejo = :complejoId')
                             ->setParameter('complejoId', $complejoId)
                            ;
                    return $qb;
                };
        
        if($complejo){
            $formOptions['data'] = $complejo;
        }

        $form->add('gerencia','entity',$formOptions);
    }
}
