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
use Pequiven\MasterBundle\Entity\Complejo;
use Doctrine\ORM\EntityRepository;
use Pequiven\ObjetiveBundle\Entity\ObjetiveLevel;
/**
 * Description of AddObjetiveParentTacticFieldListener
 *
 * @author matias
 */
class AddObjetiveParentTacticFieldListener implements EventSubscriberInterface{
    
    //put your code here
    protected $container;
    protected $securityContext;
    protected $user;
    protected $em;
    
    protected $complejoObject;
    protected $complejoNameArray = array();
    
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
        
        $this->complejoObject = new Complejo();
        $this->complejoNameArray = $this->complejoObject->getRefNameArray();
        
        if(isset($options['registerIndicator'])){
            $this->registerIndicator = true;
        }
    }

    public function preSetData(FormEvent $event) {
        $object = $event->getData();
        $form = $event->getForm();

        if (null === $object) {
            return $this->addObjetiveParentTacticForm($form,$object['parent_strategic']);
        }
        
        $this->addObjetiveParentTacticForm($form,$object['parent_strategic'],$object);
    }

    public function preSubmit(FormEvent $event) {
        $form = $event->getForm();
        $object = $event->getData();
        
        $objetiveParentStrategicId = array_key_exists('parent_strategic', $object) ? $object['parent_strategic'] : null;

        $this->addObjetiveParentTacticForm($form,$objetiveParentStrategicId);
    }

    private function addObjetiveParentTacticForm($form,$objetiveParentStrategicId,$objetiveParent = null) {
        
        $formOptions = array(
            'class' => 'PequivenObjetiveBundle:Objetive',
            'empty_value' => '',
            'label' => 'form.parent_tactic',
            'label_attr' => array('class' => 'label'),
            'translation_domain' => 'PequivenObjetiveBundle',
            'property' => 'description',
            'attr' => array('class' => 'placeholder populate select2-offscreen','multiple' => 'multiple','style' => 'width:400px'),
            'multiple' => true
        );
                    
        if($this->registerIndicator) {
            $formOptions['mapped'] = false;
            $formOptions['required'] = false;
            $formOptions['attr'] = array('class' => 'placeholder select2-offscreen','style' => 'width:300px');
        }

        if ($objetiveParent) {
            $formOptions['data'] = $objetiveParent;
        }
        
        if($this->registerIndicator) {
            return $form->add('parentTactic', 'entity', $formOptions);
        } else{
            return $form->add('parents', 'entity', $formOptions);
        }
    }

}
