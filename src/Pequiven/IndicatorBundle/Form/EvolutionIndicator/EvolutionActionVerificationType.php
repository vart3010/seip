<?php

namespace Pequiven\IndicatorBundle\Form\EvolutionIndicator;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class EvolutionActionVerificationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            /*->add('ref', 'text', array(
                'label' => 'Referencia',
                'label_attr' => array('class' => 'label'),
                'attr'=> array('class'=> 'input input-large ' ))) */
            ->add('comment', 'textarea', array(
                'label' => 'Comentario',
                'label_attr' => array('class' => 'label'),
                'attr'=> array('class'=> 'input input-large autoexpanding' )))            
            ->add('typeVerification','entity',array(
                'label' => 'Verificación',
                'label_attr' => array('class' => 'label'),
                'class' => 'Pequiven\SIGBundle\Entity\TypeVerificationManagementSystem',
                'property' => 'description',
                'attr'=> array(
                'class'=> 'select2 input-large form-control',
                //'ng-model' => 'model.lastPeriod',
                //'ng-options' => 'value as value.ref for (key,value) in data.lastPeriod'
                ),
                               )) 
            ->add('actionPlan','entity',array(
                'label' => 'Plan de Acción',
                'label_attr' => array('class' => 'label'),
                'class' => 'Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionAction',
                'property' => 'ref',
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
            'data_class' => 'Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionActionVerification'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pequiven_indicatorbundle_evolutionindicator_evolutionactionverification';
    }
}