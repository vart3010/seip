<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\IndicatorBundle\Form\Type\Tactic;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Pequiven\IndicatorBundle\PequivenIndicatorBundle;

use Pequiven\ObjetiveBundle\Form\EventListener\AddLineStrategicFieldListener;
use Pequiven\IndicatorBundle\Form\EventListener\AddFormulaFieldListener;
/**
 * Description of RegistrationFormType
 *
 * @author matias
 */
class RegistrationFormType extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options){
        $container = PequivenIndicatorBundle::getContainer();
        $securityContext = $container->get('security.context');
        $em = $container->get('doctrine')->getManager();
        
        //Referencia del Objetivo Táctico al cual se le podrían añadir los indicadores creados
        $builder->add('refObjetive','hidden',array('data' => '','mapped' => false));
        //Nombre del indicador a crear
        $builder->add('description', 'textarea', array('label' => 'form.indicator', 'label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenIndicatorBundle','attr' => array('cols' => 50, 'rows' => 5,'class' => 'input')));
        //Referencia del indicador a crear
        $builder->add('ref','text',array('label' => 'form.ref', 'label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenIndicatorBundle', 'read_only' => true,'attr' => array('class' => 'input','size' => 7)));
        
        //Peso del Objetivo
//        $builder->add('weight','percent',array('label' => 'form.weight','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenIndicatorBundle','attr' => array('placeholder' => "100,000"), 'required' => false));
        //Meta del Objetivo
        $builder->add('goal','percent',array('label' => 'form.goal','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenIndicatorBundle','attr' => array('placeholder' => "100,000")));
        //Fórmula del indicador a crear
        $builder->addEventSubscriber(new AddFormulaFieldListener());
        
        //Rango de Gestión
            //Rango Alto del Indicador
//            $builder->add('rankTop','percent',array('label' => 'form.rankTop','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenIndicatorBundle','attr' => array('placeholder' => "100,000"), 'required' => false));
//            //Rango Medio Alto del indicador
//            $builder->add('rankMiddleTop','percent',array('label' => 'form.rankMiddleTop','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenIndicatorBundle','attr' => array('placeholder' => "100,000"), 'required' => false));
//            //Rango Medio Bajo del Indicador
//            $builder->add('rankMiddleBottom','percent',array('label' => 'form.rankMiddleBottom','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenIndicatorBundle','attr' => array('placeholder' => "100,000"), 'required' => false));
//            //Rango Bajo del Indicador
//            $builder->add('rankBottom','percent',array('label' => 'form.rankBottom','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenIndicatorBundle','attr' => array('placeholder' => "100,000"), 'required' => false));
    }
    
    public function getName(){
        return 'pequiven_indicator_tacticfo_registration';
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver){
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\IndicatorBundle\Entity\Indicator',
            ));
    }
}
