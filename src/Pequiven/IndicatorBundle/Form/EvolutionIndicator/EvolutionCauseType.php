<?php

namespace Pequiven\IndicatorBundle\Form\EvolutionIndicator;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EvolutionCauseType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('causes', 'text', array(
                'label' => 'Causa',
                'label_attr' => array('class' => 'label'),
                'attr' => array(
                    'class' => 'input input-large validate[required]' 
                    )))
            ->add('valueOfcauses', 'number', array(
                'label'=>'Valor de la Causa',
                'label_attr' => array('class' => 'label'),
                'disabled'   => false,
                'attr' => array(
                    'class'    => 'input input-large validate[required]',
                    'maxlength'=> 3                    
                    )))
            /*->add('month', 'number', array(
                'label'=>'Mes de la Causa',
                'label_attr' => array('class' => 'label'),
                'disabled' => false,
                'attr' => array('class' => 'input input-large validate[required]')))*/
                         
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionCause'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'evolutioncause';
    }
}