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
            ->add('ref', 'hidden', array(
                'label' => 'Referencia',
                'label_attr' => array('class' => 'label'),
                'attr'=> array(
                    'class'    => 'input input-large ',
                    'disabled' => false,
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
                'class'=> 'select2 input-large form-control')))
            ->add('dateStart', 'date', array(
                'label'=>'Fecha de Inicio',
                'label_attr' => array('class' => 'label'),
                'format' => 'd/M/y',
                'widget' => 'single_text',
                'attr' => array('class' => 'input input-large')               
                ))
            ->add('dateEnd', 'date', array(
                'label'=>'Fecha de Cierre',
                'label_attr' => array('class' => 'label'),
                'format' => 'd/M/y',
                'widget' => 'single_text',
                'attr' => array('class' => 'input input-large')  
                ))            
            ->add('evolutionCause','entity',array(
                'label' => 'Causa de Desviación',
                'label_attr' => array('class' => 'label'),
                'class' => 'Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionCause',
                'property' => 'causes',
                'attr'=> array(
                'class'   => 'select2 input-large form-control',
                'onclick' => 'cargaData()'
                //'ng-model' => 'model.lastPeriod',
                //'ng-options' => 'value as value.ref for (key,value) in data.lastPeriod'
                ),
                               )) 
              /*->add('evolutionCause',null,array(
                'label' => 'Causa del Plan de Acción',
                'label_attr' => array('class' => 'label'),
                //'class' => 'Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionCause',
                'property' => 'causes',
                'attr'=> array(
                'class'=> 'select2 input-large form-control',
                'ng-model' => 'model.causesEvolution',
                'ng-options' => 'value as value.ref for (key,value) in data.causesEvolution'
                ),
                               )) */
            /*->add('evolutionCause', null, array(
                    'query_builder' => function(\Pequiven\IndicatorBundle\Repository\Indicator\EvolutionIndicator\EvolutionCauseRepository $repository) use($options) {
                        return $repository->getCausesByIndicator($options['indicator']);
                    },
                    'label' => 'Causas del Indicador',
                    'label_attr' => array('class' => 'label'),
                    'attr' => array(
                        'class' => "input-large select2",
                        'onclick' => 'cargaData()',
                        'style' => 'width: 270px',
                        //'multiple' => 'multiple'
                    ),
                    'empty_value' => 'Seleccione...',
                    'required' => true,
                ))*/
        ;
    }
    
    /**
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {   
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionAction',
            //'indicator'  => 1736

        ));
    }

    /**
     *
     * @return string
     */
    public function getName()
    {
        return 'actionResults';
    }
}