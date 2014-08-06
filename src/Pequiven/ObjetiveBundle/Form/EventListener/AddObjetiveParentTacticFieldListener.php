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
    
    public static function getSubscribedEvents() {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_SUBMIT => 'preSubmit'
        );
    }
    
    public function __construct() {
        $this->container = PequivenObjetiveBundle::getContainer();
        $this->securityContext = $this->container->get('security.context');
        $this->user = $this->securityContext->getToken()->getUser();
        $this->em = $this->container->get('doctrine')->getManager();
        
        $this->complejoObject = new Complejo();
        $this->complejoNameArray = $this->complejoObject->getComplejoNameArray();
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
            'empty_value' => 'Seleccione el objetivo táctico',
            'label' => 'form.parent_tactic',
            'label_attr' => array('class' => 'label'),
            'translation_domain' => 'PequivenObjetiveBundle',
            'property' => 'description',
            'attr' => array('class' => 'populate select2-offscreen','style' => 'width:400px')
        );
        
        if($this->user->getComplejo()->getComplejoName() === $this->complejoNameArray[\Pequiven\MasterBundle\Entity\Complejo::COMPLEJO_ZIV]){
            $formOptions['query_builder'] = function (EntityRepository $er) use ($objetiveParentStrategicId){
                        $qb = $er->createQueryBuilder('objetive')
                         ->where('objetive.parent = :parentId')
                         ->setParameter('parentId', $objetiveParentStrategicId)
                                ;
                        return $qb;
                    };
                } else{
            $complejoId = $this->user->getComplejo()->getId();            
            $formOptions['query_builder'] = function (EntityRepository $er) use ($complejoId,$objetiveParentStrategicId){
                $qb = $er->createQueryBuilder('objetive')
                         ->where('objetive.complejo = :complejoId AND objetive.parent = :parentId')
                         ->setParameter('complejoId', $complejoId)
                         ->setParameter('parentId', $objetiveParentStrategicId)
                        ;
                return $qb;
            };
        }
        

        if ($objetiveParent) {
            $formOptions['data'] = $objetiveParent;
        }
        
        return $form->add('parent', 'entity', $formOptions);
    }

}
