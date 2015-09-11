<?php

namespace Pequiven\IndicatorBundle\Form\EvolutionIndicator;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class IndicatorLastPeriodType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder            
            /*->add('indicatorlastPeriod','entity',array(
                'label' => 'Relación Indicador 2014',
                'label_attr' => array('class' => 'label'),
                'class' => 'Pequiven\IndicatorBundle\Entity\Indicator',
                'property' => 'ref',
                'attr'=> array(
                'class'=> 'select2 input-large form-control',
                //'ng-model' => 'model.lastPeriod',
                //'ng-options' => 'value as value.ref for (key,value) in data.lastPeriod'
                ),
                               ))*/
            ->add('indicatorlastPeriod', null, array(
                    'query_builder' => function(\Pequiven\IndicatorBundle\Repository\IndicatorRepository $repository) {
                        return $repository->getLastPeriod(1);
                    },
                    'label' => 'Relación Indicador 2014',
                    'label_attr' => array('class' => 'label'),
                    'attr' => array(
                        'class' => "input-xlarge select2",
                        'style' => 'width: 270px',
                        //'multiple' => 'multiple'
                    ),
                    'empty_value' => 'Seleccione...',
                    'required' => true,
                ))            
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
        return 'lastPeriod';
    }
}