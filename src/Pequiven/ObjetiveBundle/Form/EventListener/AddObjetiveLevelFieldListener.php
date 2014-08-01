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
use Pequiven\ObjetiveBundle\PequivenObjetiveBundle;
use Doctrine\ORM\EntityRepository;
/**
 * Description of AddObjetiveLevelFieldListener
 *
 * @author matias
 */
class AddObjetiveLevelFieldListener implements EventSubscriberInterface {
    //put your code here
    protected $container;
    protected $securityContext;
    protected $user;
    protected $em;
       
    protected $object;
    
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
        
        $objLevel = new ObjetiveLevel();
        $this->object = $this->em->getRepository('PequivenObjetiveBundle:ObjetiveLevel')->findOneBy(array('level' => $options['level']));
    }
    
    public function preSetData(FormEvent $event){
        $object = $event->getData();
        $form = $event->getForm();
        
        if(null === $object){
            return $this->addObjetiveLevelForm($form, $object);
        }
        
        $this->addObjetiveLevelForm($form, $object);
    }
    
    public function preSubmit(FormEvent $event){
        $form = $event->getForm();
        $this->addObjetiveLevelForm($form);
    }
    
    private function addObjetiveLevelForm($form, $objetiveLevel = null){
//        $objLevel = new ObjetiveLevel();
//        $object = $objLevel->typeObjetiveLevel($this->securityContext,array('em' => $this->em));
//        $objLevelId = $object->getId();

        $formOptions = array(
            'class' => 'PequivenObjetiveBundle:ObjetiveLevel',
            'empty_value' => 'Seleccione el nivel del objetivo',
            'label' => 'form.objetive_level',
            'label_attr' => array('class' => 'label'),
            'translation_domain' => 'PequivenObjetiveBundle',
            'property' => 'description',
            'query_builder' => function(EntityRepository $er) {
                $qb = $er->createQueryBuilder('objlevel')
                         ->where('objlevel.id = :objLevelId')
                         ->setParameter('objLevelId', $this->object->getId())
                            ;
                return $qb;
          }
        );
        $formOptions['attr'] = array('class' => 'select red-gradient check-list replacement', 'style' => 'width:300px');
        if($this->object){
            $formOptions['data'] = $this->object;
        }
        
        $form->add('objetiveLevel','entity',$formOptions);
    }
}
