<?php

namespace Pequiven\IndicatorBundle\Form\EvolutionIndicator;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class EvolutionActionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ref', 'text', array(
                'label' => 'Referencia',
                'label_attr' => array('class' => 'label'),
                'attr'=> array(
                    'class'    => 'input input-large ',
                    'disabled' => false
                    ))) 
            ->add('action', 'text', array(
                'label' => 'Acción',
                'label_attr' => array('class' => 'label'),
                'attr'=> array('class'=> 'input input-large ' )))            
            ->add('indicatorAction','entity',array(
                'label' => 'Tipo de Acción',
                'label_attr' => array('class' => 'label'),
                'class' => 'Pequiven\SIGBundle\Entity\TypeActionManagementSystem',
                'property' => 'description',
                'attr'=> array(
                'class'=> 'select2 input-large form-control'),
                               ))
            ->add('dateStart', 'date', array(
                'label'=>'Fecha de Inicio',
                'label_attr' => array('class' => 'label'),
                'attr'=> array('class'=> 'validate[required]' )))
            ->add('dateEnd', 'date', array(
                'label'=>'Fecha de Cierre',
                'label_attr' => array('class' => 'label'),
                'attr'=> array('class'=> 'validate[required]' )))
            ->add('advance', 'text', array(
                'label'=>'Avance %',
                'label_attr' => array('class' => 'label'),
                'attr'=> array('class'=> 'input input-large ' )))
            ->add('observations', 'textarea', array(
                'label'=>'Observaciones',
                'label_attr' => array('class' => 'label'),
                'attr'=> array('class'=> 'input input-large ' )))
            ->add('evolutionCause','entity',array(
                'label' => 'Causa del Plan de Acción',
                'label_attr' => array('class' => 'label'),
                'class' => 'Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionCause',
                'property' => 'causes',
                'attr'=> array(
                'class'=> 'select2 input-large form-control',
                //'ng-model' => 'model.lastPeriod',
                //'ng-options' => 'value as value.ref for (key,value) in data.lastPeriod'
                ),
                               )) 
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionAction'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pequiven_indicatorbundle_evolutionindicator_evolutionaction';
    }
}