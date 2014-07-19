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
            return $this->addObjetiveLevelForm($form, $object);
        }
        
        $this->addObjetiveLevelForm($form, $object);
    }
    
    public function preSubmit(FormEvent $event){
        $form = $event->getForm();
        $this->addObjetiveLevelForm($form);
    }
    
    private function addObjetiveLevelForm($form, $objetiveLevel = null){
        $container = PequivenObjetiveBundle::getContainer();
        $user = $container->get('security.context')->getToken()->getUser();
        $em = $container->get('doctrine')->getManager();
        $objLevel = new ObjetiveLevel();
        $object = $objLevel->typeObjetiveLevel($container->get('security.context'),array('em' => $em));
        $objLevelId = $object->getId();

        $formOptions = array(
            'class' => 'PequivenObjetiveBundle:ObjetiveLevel',
            'empty_value' => 'Seleccione el nivel del objetivo',
            'label' => 'form.objetive_level',
            'label_attr' => array('class' => 'label'),
            'translation_domain' => 'PequivenObjetiveBundle',
            'property' => 'description',
            'choices' => $object->getLevel(),
            'query_builder' => function(EntityRepository $er) use ($objLevelId) {
                $qb = $er->createQueryBuilder('objlevel')
                         ->where('objlevel.id = :objLevelId')
                         ->setParameter('objLevelId', $objLevelId)
                            ;
                return $qb;
          }
        );
        $formOptions['attr'] = array('class' => 'select red-gradient check-list replacement', 'style' => 'width:300px');
        if($object){
            $formOptions['data'] = $object;
        }
        
        $form->add('objetiveLevel','entity',$formOptions);
    }
}
