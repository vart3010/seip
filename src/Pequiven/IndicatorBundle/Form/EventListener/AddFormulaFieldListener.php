<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\IndicatorBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Pequiven\MasterBundle\Entity\FormulaLevel;
use Doctrine\ORM\EntityRepository;

/**
 * Description of AddComplejoFieldListener
 *
 * @author matias
 */
class AddFormulaFieldListener implements EventSubscriberInterface {
    //put your code here
    
    protected $container;
    protected $securityContext;
    protected $user;
    protected $em;
    
    protected $typeStrategic = false;
    protected $typeTactic = false;
    protected $typeOperative = false;
    protected $levelFormula = '';
    
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
        
        if(isset($options['typeStrategic'])){
            $this->typeStrategic = true;
            $this->levelFormula = FormulaLevel::LEVEL_ESTRATEGICO;
        }
        if(isset($options['typeTactic'])){
            $this->typeTactic = true;
            $this->levelFormula = FormulaLevel::LEVEL_TACTICO;
        }
        if(isset($options['typeOperative'])){
            $this->typeOperative = true;
            $this->levelFormula = FormulaLevel::LEVEL_OPERATIVO;
        }
    }

    public function preSetData(FormEvent $event){
        $object = $event->getData();
        $form = $event->getForm();
        
        if(null === $object){
            return $this->addFormulaForm($form, $object);
        }
        
        $this->addFormulaForm($form, $object);
    }
    
    public function preSubmit(FormEvent $event){
        $form = $event->getForm();
        $this->addFormulaForm($form);
    }
    //$builder->add('complejo2', 'entity', array('label' => 'form.complejo', 'translation_domain' => 'PequivenObjetiveBundle','class' => 'PequivenMasterBundle:Complejo', 'property' => 'description','empty_value' => 'Todo','expanded' => true));
    public function addFormulaForm($form, $formula = null){
        
        $formOptions = array(
            'class' => 'PequivenMasterBundle:Formula',
            'label_attr' => array('class' => 'label'),
            'translation_domain' => 'PequivenIndicatorBundle',
            'property' => 'equation',
            'required' => false,
            'mapped' => false
        );
        if($this->typeStrategic){
            $formOptions['label'] = 'form.formulaIndicatorStrategic';
        } elseif($this->typeTactic){
            $formOptions['label'] = 'form.formulaIndicatorTactic';
        } elseif($this->typeOperative){
            $formOptions['label'] = 'form.formulaIndicatorOperative';
        }
        $formOptions['choices'] = $this->em->getRepository('PequivenMasterBundle:Formula')->findBy(array('formulaLevel' => $this->levelFormula));
        $formOptions['attr'] = array('class' => 'populate placeholder select2-offscreen', 'style' => 'width:300px','required' => false);
        if($formula){
            $formOptions['data'] = $formula;
        }
        
        $form->add('formula','entity',$formOptions);
    }
}
