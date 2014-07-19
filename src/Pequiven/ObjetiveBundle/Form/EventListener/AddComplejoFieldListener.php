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
use Pequiven\ObjetiveBundle\Entity\ObjetiveLevel;
use Pequiven\ObjetiveBundle\PequivenObjetiveBundle;
use Doctrine\ORM\EntityRepository;

/**
 * Description of AddComplejoFieldListener
 *
 * @author matias
 */
class AddComplejoFieldListener implements EventSubscriberInterface {
    //put your code here
    protected $container;
    
    public static function getSubscribedEvents() {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_SUBMIT => 'preSubmit'
                );
    }
    
    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null){
        $this->container = $container;
    }
    
    public function preSetData(FormEvent $event){
        $object = $event->getData();
        $form = $event->getForm();
        
        if(null === $object){
            return $this->addComplejoForm($form, $object);
        }
        
        $this->addComplejoForm($form, $object);
    }
    
    public function preSubmit(FormEvent $event){
        $form = $event->getForm();
        $this->addComplejoForm($form);
    }
    //$builder->add('complejo2', 'entity', array('label' => 'form.complejo', 'translation_domain' => 'PequivenObjetiveBundle','class' => 'PequivenMasterBundle:Complejo', 'property' => 'description','empty_value' => 'Todo','expanded' => true));
    public function addComplejoForm($form, $complejo = null){
        
        $container = PequivenObjetiveBundle::getContainer();
        $user = $container->get('security.context')->getToken()->getUser();
        $type = 'entity';
        $formOptions = array(
            'class' => 'PequivenMasterBundle:Complejo',
            'label' => 'form.complejo',
            'label_attr' => array('class' => 'label'),
            'translation_domain' => 'PequivenObjetiveBundle',
            'property' => 'description'
        );
        
        if($container->get('security.context')->isGranted(array('ROLE_DIRECTIVE'))){
            $formOptions['empty_value'] =  'Todo';
            $formOptions['expanded'] = true;
            $formOptions['multiple'] = true;
            $formOptions['mapped'] = false;
            $formOptions['attr'] = array('class' => 'selectMultiple multiple white-gradient easy-multiple-selection check-list replacement');
        } else{
            $em = $container->get('doctrine')->getManager();
            $personal = $em->getRepository('PequivenMasterBundle:Personal')->findOneBy(array('numPersonal' => $user->getNumPersonal()));
            $cargo = $em->getRepository('PequivenMasterBundle:Cargo')->findOneBy(array('id' => $personal->getCargo()->getId()));
            $gerencia = $em->getRepository('PequivenMasterBundle:Gerencia')->findOneBy(array('id' => $cargo->getGerencia()->getId()));
            $complejo = $complejo == null ? $gerencia->getComplejo() : $complejo;
            $complejoId = $gerencia->getComplejo()->getId();
            $formOptions['empty_value'] = 'Seleccione su Complejo';
            $formOptions['choices'] = $em->getRepository('PequivenMasterBundle:Complejo')->findOneBy(array('id' => $gerencia->getComplejo()->getId()));
            $formOptions['query_builder'] = function(EntityRepository $er) use ($complejoId){
                $qb = $er->createQueryBuilder('complejo')
                         ->where('complejo.id = :complejoId')
                         ->setParameter('complejoId', $complejoId)
                        ;
                return $qb;
            };
            $formOptions['attr'] = array('class' => 'select red-gradient check-list replacement', 'style' => 'width:300px');
            //var_dump($gerencia->getComplejo()->getDescription());
            //die();
        }
        
        if($complejo){
            $formOptions['data'] = $complejo;
        }
        
        $form->add('complejo','entity',$formOptions);
    }
}
