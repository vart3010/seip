<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\ObjetiveBundle\Form\EventListener;

/**
 * Description of AddObjetiveParentStrategicFieldListener
 *
 * @author matias
 */
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Pequiven\ObjetiveBundle\PequivenObjetiveBundle;
use Doctrine\ORM\EntityRepository;
use Pequiven\ObjetiveBundle\Entity\ObjetiveLevel;

/**
 * Description of AddObjetiveLevelFieldListener
 *
 * @author matias
 */
class AddObjetiveParentStrategicFieldListener implements EventSubscriberInterface{
    
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
            return $this->addObjetiveParentStrategicForm($form,$object);
        }

        $this->addObjetiveParentStrategicForm($form,$object);
    }

    public function preSubmit(FormEvent $event) {
        $form = $event->getForm();

        $this->addObjetiveParentStrategicForm($form);
    }

    private function addObjetiveParentStrategicForm($form,$objetiveParent = null) {
        $container = PequivenObjetiveBundle::getContainer();
        $user = $container->get('security.context')->getToken()->getUser();
        
        $formOptions = array(
            'class' => 'PequivenObjetiveBundle:Objetive',
            'empty_value' => 'Seleccione el objetivo estratégico',
            'label' => 'form.parent_strategic',
            'label_attr' => array('class' => 'label'),
            'translation_domain' => 'PequivenObjetiveBundle',
            'property' => 'description',
            'attr' => array('class' => 'populate select2-offscreen red-gradient','style' => 'width:50%')
        );
        
        $objetiveLevel = new ObjetiveLevel();
        $objetiveLevelName = $objetiveLevel->getLevelNameArray();
        $em = $container->get('doctrine')->getManager();
        $personal = $em->getRepository('PequivenMasterBundle:Personal')->findOneBy(array('numPersonal' => $user->getNumPersonal()));
        $cargo = $em->getRepository('PequivenMasterBundle:Cargo')->findOneBy(array('id' => $personal->getCargo()->getId()));
        $gerencia = $em->getRepository('PequivenMasterBundle:Gerencia')->findOneBy(array('id' => $cargo->getGerencia()->getId()));
        $complejoId = $gerencia->getComplejo()->getId();
        $objetiveLevelId = $em->getRepository('PequivenObjetiveBundle:ObjetiveLevel')->findOneBy(array('levelName' => $objetiveLevelName[ObjetiveLevel::LEVEL_ESTRATEGICO]))->getId();
        
        $formOptions['query_builder'] = function (EntityRepository $er) use ($complejoId,$objetiveLevelId){
            $qb = $er->createQueryBuilder('objetive')
                     ->where('objetive.complejo = :complejoId AND objetive.objetiveLevel = :objetiveLevelId')
                     ->setParameter('complejoId', $complejoId)
                     ->setParameter('objetiveLevelId', $objetiveLevelId)
                    ;
            return $qb;
        };
        
        if($container->get('security.context')->isGranted(array('ROLE_MANAGER_SECOND'))){
            $formOptions['mapped'] = false;
        }

        if ($objetiveParent) {
            $formOptions['data'] = $objetiveParent;
        }
        
        if($container->get('security.context')->isGranted(array('ROLE_MANAGER_FIRST'))){
            return $form->add('parent', 'entity', $formOptions);
        } elseif ($container->get('security.context')->isGranted(array('ROLE_MANAGER_SECOND'))){
            return $form->add('parent_strategic', 'entity', $formOptions);
        }
    }

}
