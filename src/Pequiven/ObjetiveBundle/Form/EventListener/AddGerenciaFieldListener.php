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
/**
 * Description of AddGerenciaFieldListener
 *
 * @author matias
 */
class AddGerenciaFieldListener implements EventSubscriberInterface {
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
           return $this->addGerenciaForm($form, $object);
        }
        
        $this->addGerenciaForm($form, $object);
    }
    
    public function preSubmit(FormEvent $event){
        $form = $event->getForm();
        $this->addGerenciaForm($form);
    }
    
    public function addGerenciaForm($form,$gerencia = null){
        $container = PequivenObjetiveBundle::getContainer();
        $user = $container->get('security.context')->getToken()->getUser();
        
        $em = $container->get('doctrine')->getManager();
        $personal = $em->getRepository('PequivenMasterBundle:Personal')->findOneBy(array('numPersonal' => $user->getNumPersonal()));
        $cargo = $em->getRepository('PequivenMasterBundle:Cargo')->findOneBy(array('id' => $personal->getCargo()->getId()));
        $gerenciaId = $cargo->getGerencia()->getId();
        $gerencia= $gerencia == null ? $cargo->getGerencia() : $gerencia;
        
        $formOptions = array(
            'class' => 'PequivenMasterBundle:Gerencia',
            'label' => 'form.gerencia',
            'label_attr' => array('class' => 'label'),
            'translation_domain' => 'PequivenObjetiveBundle',
            'property' => 'description',
            'empty_value' => 'Seleccione su Gerencia',
            'query_builder' => function (EntityRepository $er) use ($gerenciaId){
                $qb = $er->createQueryBuilder('gerencia')
                         ->where('gerencia.id = :gerenciaId')
                         ->setParameter('gerenciaId', $gerenciaId)
                        ;
                return $qb;
            }
        );
        $formOptions['attr'] = array('class' => 'select red-gradient check-list replacement', 'style' => 'width:300px');
        if($gerencia){
            $formOptions['data'] = $gerencia;
        }
        
        $form->add('gerencia','entity',$formOptions);
    }
}
