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
 * Description of AddGerenciaFieldListener
 *
 * @author matias
 */
class AddGerenciaFieldListener implements EventSubscriberInterface {
    //put your code here
    protected $container;
    protected $securityContext;
    protected $user;
    protected $em;
    
    protected $complejoObject;
    protected $complejoNameArray = array();
    protected $typeTactic = false;
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
        if(isset($options['typeTactic'])){
            $this->typeOperative = true;
        }
        if(isset($options['registerIndicator'])){
            $this->registerIndicator = true;
        }
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
        $data = $event->getData();
//        $this->addGerenciaForm($form,$data['gerencia']);
        $this->addGerenciaForm($form);
    }
    
    public function addGerenciaForm($form,$gerencia = null){
        $formOptions = array(
                'class' => 'PequivenMasterBundle:Gerencia',
                'label' => 'form.gerenciaFirst',
                'label_attr' => array('class' => 'label'),
                'translation_domain' => 'PequivenObjetiveBundle',
                'property' => 'description'
            );
        
        //Si el usuario tiene rol Gerente General Complejo
        if($this->securityContext->isGranted(array('ROLE_GENERAL_COMPLEJO','ROLE_GENERAL_COMPLEJO_AUX'))){
            $complejoId = $this->user->getComplejo()->getId();

            $formOptions['query_builder'] = function (EntityRepository $er) use ($complejoId){
                $qb = $er->createQueryBuilder('gerencia')
                         ->andWhere('gerencia.complejo = :complejoId')
                         ->setParameter('complejoId', $complejoId)
                            ;
                return $qb;
                };
            $formOptions['choices'] = $this->em->getRepository('PequivenMasterBundle:Gerencia')->findBy(array('complejo' => $complejoId,'modular' => true));
            $formOptions['attr'] = array('class' => 'select2-offscreen populate placeholder','multiple' => 'multiple', 'style' => 'width:300px');
            $formOptions['multiple'] = true;
            $formOptions['mapped'] = false;
            
            if($gerencia){
                $formOptions['data'] = $gerencia;
            }
            $form->add('gerencia','entity',$formOptions);
        } else{
            $gerencia = $gerencia == null ? $this->user->getGerencia() : $gerencia;

            if($this->securityContext->isGranted(array('ROLE_DIRECTIVE','ROLE_DIRECTIVE_AUX','ROLE_WORKER_PLANNING'))){
                    $formOptions['choices'] = $this->em->getRepository('PequivenMasterBundle:Gerencia')->getGerenciaOptions();
                $gerencia = null;
                $formOptions['attr'] = array('class' => 'select2-offscreen populate placeholder','multiple' => 'multiple', 'style' => 'width:300px');
                $formOptions['multiple'] = true;
                $formOptions['mapped'] = false;
                if($this->registerIndicator){
                    $formOptions['required'] = false;
                    $formOptions['multiple'] = false;
                    $formOptions['attr'] = array('class' => 'select2-offscreen placeholder', 'style' => 'width:300px');
                }
            } else{
                    $gerenciaId = $this->user->getGerencia()->getId();
                    $formOptions['query_builder'] = function (EntityRepository $er) use ($gerenciaId){
                            $qb = $er->createQueryBuilder('gerencia')
                                     ->where('gerencia.id = :gerenciaId')
                                     ->setParameter('gerenciaId', $gerenciaId)
                                    ;
                            return $qb;
                        };
                $formOptions['attr'] = array('class' => 'select red-gradient check-list allow-empty', 'style' => 'width:300px');
             }

            if($gerencia){
                $formOptions['data'] = $gerencia;
            }

            $form->add('gerencia','entity',$formOptions);
        }
    }
}
