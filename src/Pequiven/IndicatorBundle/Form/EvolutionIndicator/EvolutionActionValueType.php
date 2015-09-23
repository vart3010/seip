<?php

namespace Pequiven\IndicatorBundle\Form\EvolutionIndicator;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class EvolutionActionValueType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('advance', 'text', array(
                'label'=>'Avance %',
                'label_attr' => array('class' => 'label'),
                'attr'=> array(
                    'class'=> 'input input-large ',
                    'maxlength'=> 3 
                    )))
            ->add('observations', 'textarea', array(
                'label'=>'Observaciones',
                'label_attr' => array('class' => 'label'),
                'attr'=> array('class'=> 'input input-large ' )))
            
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionActionValue'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'actionValue';
    }
}