<?php

namespace Pequiven\IndicatorBundle\Form\EvolutionIndicator;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class IndicatorConfigSigType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder            
            ->add('indicatorSigMedition','text',array(
                'label' => 'Formula de Medición',
                'label_attr' => array('class' => 'label'),
                //'class' => 'Pequiven\IndicatorBundle\Entity\Indicator',
                //'property' => 'ref',
                'attr'=> array(
                'class'=> 'input input-large form-control',
                //'ng-model' => 'model.lastPeriod',
                //'ng-options' => 'value as value.ref for (key,value) in data.lastPeriod'
                )))            
            /*->add('indicatorSigObjetive','text',array(
                'label' => 'Valor Objetivo 2015',
                'label_attr' => array('class' => 'label'),
                //'class' => 'Pequiven\IndicatorBundle\Entity\Indicator',
                //'property' => 'ref',
                'attr'=> array(
                'class'=> 'input input-large form-control',
                //'ng-model' => 'model.lastPeriod',
                //'ng-options' => 'value as value.ref for (key,value) in data.lastPeriod'
                )))*/
            /*->add('indicatorSigTendency','entity',array(
                'label' => 'Tendencia',
                'label_attr' => array('class' => 'label'),
                'class' => 'Pequiven\MasterBundle\Entity\Tendency',
                'property' => 'description',
                'attr'=> array(
                'class'=> 'select2 input-large form-control',
                //'ng-model' => 'model.lastPeriod',
                //'ng-options' => 'value as value.ref for (key,value) in data.lastPeriod'
                )))*/
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\IndicatorBundle\Entity\Indicator'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'configSig';
    }
}