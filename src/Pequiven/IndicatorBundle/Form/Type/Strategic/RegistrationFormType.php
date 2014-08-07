<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\IndicatorBundle\Form\Type\Strategic;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Pequiven\IndicatorBundle\PequivenIndicatorBundle;
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
        
        //Nombre del indicador a crear
        $builder->add('description', 'textarea', array('label' => 'form.indicator', 'label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenIndicatorBundle','attr' => array('cols' => 50, 'rows' => 5,'class' => 'input')));
        //Peso del Objetivo
        $builder->add('weight','percent',array('label' => 'form.weight','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenIndicatorBundle','attr' => array('placeholder' => "100,000"), 'required' => false));
        //Meta del Objetivo
        $builder->add('goal','percent',array('label' => 'form.goal','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenIndicatorBundle','attr' => array('placeholder' => "100,000")));
        
        //Rango de Gestión
            //Rango Alto del Indicador
            $builder->add('rankTop','percent',array('label' => 'form.rankTop','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenIndicatorBundle','attr' => array('placeholder' => "100,000"), 'required' => false));
            //Rango Medio Alto del indicador
            $builder->add('rankMiddleTop','percent',array('label' => 'form.rankMiddleTop','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenIndicatorBundle','attr' => array('placeholder' => "100,000"), 'required' => false));
            //Rango Medio Bajo del Indicador
            $builder->add('rankMiddleBottom','percent',array('label' => 'form.rankMiddleBottom','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenIndicatorBundle','attr' => array('placeholder' => "100,000"), 'required' => false));
            //Rango Bajo del Indicador
            $builder->add('rankBottom','percent',array('label' => 'form.rankBottom','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenIndicatorBundle','attr' => array('placeholder' => "100,000"), 'required' => false));
    }
    
    public function getName(){
        return 'pequiven_indicator_strategic_registration';
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver){
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\IndicatorBundle\Entity\Indicator',
            ));
    }
}
