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
 * Description of AddObjetiveOperativeFieldListener
 *
 * @author matias
 */
class AddObjetiveOperativeFieldListener implements EventSubscriberInterface{
    
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
            return $this->addObjetiveOperativeForm($form,$object['parentTactic']);
        }
        
        $this->addObjetiveOperativeForm($form,$object['parentTactic'],$object);
    }

    public function preSubmit(FormEvent $event) {
        $form = $event->getForm();
        $object = $event->getData();
        
        $objetiveParentTacticId = array_key_exists('parentTactic', $object) ? $object['parentTactic'] : null;

        $this->addObjetiveOperativeForm($form,$objetiveParentTacticId);
    }

    private function addObjetiveOperativeForm($form,$objetiveParentTacticId,$objetiveParent = null) {
        
        $formOptions = array(
            'class' => 'PequivenObjetiveBundle:Objetive',
            'empty_value' => '',
            'label' => 'form.parent_operative',
            'label_attr' => array('class' => 'label'),
            'translation_domain' => 'PequivenObjetiveBundle',
            'property' => 'description',
            'attr' => array('class' => 'populate select2-offscreen','style' => 'width:400px')
        );
        
        if($this->registerIndicator) {
            $formOptions['mapped'] = false;
            $formOptions['required'] = false;
            $formOptions['attr'] = array('class' => 'placeholder select2-offscreen','style' => 'width:300px');
        }

        if ($objetiveParent) {
            $formOptions['data'] = $objetiveParent;
        }
        
        return $form->add('parentOperative', 'entity', $formOptions);
    }

}
