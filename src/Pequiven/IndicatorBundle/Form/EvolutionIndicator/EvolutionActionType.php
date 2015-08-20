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
            ->add('action', 'text', array(
                'label' => 'Acción',
                'label_attr' => array('class' => 'label'),
                'attr'=> array('class'=> 'input input-large validate[required]' )))
            ->add('indicatorAction', 'text', array(
                'label' => 'Tipo de Acción',
                'label_attr' => array('class' => 'label'),
                //'class' => 'PequivenSIGBundle:TypeActionManagementSystem',
                'attr'=> array(
                        'class'    => 'select2 input-xlarge',
                        'ng-model' => 'model.typeAction.indicatorAction'
                    )
                
                /*'query_builder' => function(\Pequiven\SIGBundle\Repository\TypeActionManagementSystemRepository $repository){
                               return $repository->findAll(); },*/
                //'empty_value' => 'pequiven.select',
                //'required' => true,
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
                'attr'=> array('class'=> 'input input-large validate[required]' )))
            ->add('observations', 'textarea', array(
                'label'=>'Observaciones',
                'label_attr' => array('class' => 'label'),
                'attr'=> array('class'=> 'input input-large validate[required]' )))
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