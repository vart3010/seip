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
use Doctrine\ORM\EntityRepository;
use Pequiven\ObjetiveBundle\Entity\ObjetiveLevel;
/**
 * Description of AddObjetiveParentTacticFieldListener
 *
 * @author matias
 */
class AddObjetiveParentTacticFieldListener implements EventSubscriberInterface{
    
    public static function getSubscribedEvents() {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_SUBMIT => 'preSubmit'
        );
    }

    public function preSetData(FormEvent $event) {
        $object = $event->getData();
        $form = $event->getForm();

        if (null === $object) {
            return $this->addObjetiveParentTacticForm($form,$object['parent_strategic']);
        }
        
        $objetiveParent = $object->getParent();
        $this->addObjetiveParentTacticForm($form,$object['parent_strategic'],$object);
    }

    public function preSubmit(FormEvent $event) {
        $form = $event->getForm();
        $object = $event->getData();
        
        
        $objetiveParentStrategicId = array_key_exists('parent_strategic', $object) ? $object['parent_strategic'] : null;
        
        $this->addObjetiveParentTacticForm($form,$objetiveParentStrategicId);
        
        
    }

    private function addObjetiveParentTacticForm($form,$objetiveParentStrategicId,$objetiveParent = null) {
        
        
        $container = PequivenObjetiveBundle::getContainer();
        $securityContext = $container->get('security.context');
        $user = $securityContext->getToken()->getUser();
        
        $formOptions = array(
            'class' => 'PequivenObjetiveBundle:Objetive',
            'empty_value' => 'Seleccione el objetivo táctico',
            'label' => 'form.parent_tactic',
            'label_attr' => array('class' => 'label'),
            'translation_domain' => 'PequivenObjetiveBundle',
            'property' => 'description',
            'attr' => array('class' => 'populate select2-offscreen red-gradient','style' => 'width:50%')
        );
        
        $objetiveLevel = new ObjetiveLevel();
        $objetiveLevelName = $objetiveLevel->getLevelNameArray();
        $em = $container->get('doctrine')->getManager();
        if($securityContext->isGranted(array('ROLE_MANAGER_SECOND_AUX'))){
            $realUser = $em->getRepository('PequivenSEIPBundle:User')->findOneBy(array('id' => $user->getParent()->getId()));
            $personal = $em->getRepository('PequivenMasterBundle:Personal')->findOneBy(array('numPersonal' => $realUser->getNumPersonal()));
        } else{
            $personal = $em->getRepository('PequivenMasterBundle:Personal')->findOneBy(array('numPersonal' => $user->getNumPersonal()));
        }
        $cargo = $em->getRepository('PequivenMasterBundle:Cargo')->findOneBy(array('id' => $personal->getCargo()->getId()));
        $gerencia = $em->getRepository('PequivenMasterBundle:Gerencia')->findOneBy(array('id' => $cargo->getGerencia()->getId()));
        $complejoId = $gerencia->getComplejo()->getId();
        $objetiveLevelId = $em->getRepository('PequivenObjetiveBundle:ObjetiveLevel')->findOneBy(array('levelName' => $objetiveLevelName[ObjetiveLevel::LEVEL_TACTICO]))->getId();
        
        
        $formOptions['query_builder'] = function (EntityRepository $er) use ($complejoId,$objetiveParentStrategicId){
            $qb = $er->createQueryBuilder('objetive')
                     ->where('objetive.complejo = :complejoId AND objetive.parent = :objetiveLevelId')
                     ->setParameter('complejoId', $complejoId)
                     ->setParameter('objetiveLevelId', $objetiveParentStrategicId)
                    ;
            return $qb;
        };
        

        if ($objetiveParent) {
            $formOptions['data'] = $objetiveParent;
        }
        
        return $form->add('parent', 'entity', $formOptions);
    }

}
