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
    
    protected $registerIndicator = false;
    
    public static function getSubscribedEvents() {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_SUBMIT => 'preSubmit'
                );
    }
    
    /**
     * 
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     * @param type $options
     */
    public function __construct(ContainerInterface $container,$options = array()) {
        $this->container = $container;
        $this->securityContext = $this->container->get('security.context');
        $this->user = $this->securityContext->getToken()->getUser();
        $this->em = $this->container->get('doctrine')->getManager();
        
        if(isset($options['registerIndicator'])){
            $this->registerIndicator = true;
        }
    }
    
    public function preSetData(FormEvent $event){
        $object = $event->getData();
        $form = $event->getForm();
        
        if(null === $object){
            return $this->addGerenciaSecondForm($form,$object);
        }
        
        $gerenciaId = array_key_exists('gerencia', $object) ? $object['gerencia'] : null;
        
        $this->addGerenciaSecondForm($form, $object);
    }
    
    public function preSubmit(FormEvent $event){
        $form = $event->getForm();
        $object = $event->getData();
        
        $gerenciaId = array_key_exists('gerencia', $object) ? $object['gerencia'] : null;
        
        $this->addGerenciaSecondForm($form);
    }
    
    public function addGerenciaSecondForm($form,$gerenciaSecond = null){
        
        $formOptions = array(
            'class' => 'PequivenMasterBundle:GerenciaSecond',
            'label' => 'form.gerencia_second',
            'label_attr' => array('class' => 'label'),
            'translation_domain' => 'PequivenObjetiveBundle',
            'property' => 'description',
        );

        $formOptions['attr'] = array('class' => 'select2-offscreen populate placeholder','multiple' => 'multiple', 'style' => 'width:300px');
        $formOptions['multiple'] = true;
        $formOptions['mapped'] = false;
        $formOptions['empty_value'] = '';
        
        if($this->registerIndicator){
            $formOptions['attr'] = array('class' => 'select2-offscreen placeholder', 'style' => 'width:300px');
            $formOptions['multiple'] = false;
            $formOptions['mapped'] = false;
            $formOptions['required'] = false;
        }

        if($gerenciaSecond){
            $formOptions['data'] = $gerenciaSecond;
        }

        $form->add('gerenciaSecond','entity',$formOptions);

        if($gerenciaSecond){
            $formOptions['data'] = $gerenciaSecond;
        }

        $form->add('gerenciaSecond','entity',$formOptions);
    }
}
