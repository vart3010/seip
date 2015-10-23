<?php

namespace Pequiven\IndicatorBundle\Form\EvolutionIndicator;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EvolutionCauseAnalysisType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', 'textarea', array(
                'label' => 'Analisis de las Causas',
                'label_attr' => array('class' => 'label'),
                'attr' => array(
                    'class' => 'input full-width autoexpanding validate[required]',
                    'maxlength' => 3500
                     )))            
                         
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionCauseAnalysis'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'causeAnalysis_form';
    }
}