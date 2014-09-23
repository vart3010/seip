<?php

namespace Pequiven\ArrangementProgramBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GoalType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',null,array(
                'label' => 'pequiven.form.name',
                'label_attr' => array('class' => 'label'),
                'attr' => array(
                    'class' => "input input-xlarge"
                )
            ))
            ->add('typeGoal',null,array(
                'label' => 'pequiven.form.type_goal',
                'label_attr' => array('class' => 'label'),
                'attr' => array(
                    'class' => "select2 input-xlarge"
                ),
                'empty_value' => 'pequiven.form.not_applicable',
                'required' => false,
            ))
            ->add('startDate','date',array(
                'label' => 'pequiven.form.start_date',
                'label_attr' => array('class' => 'label'),
                'attr' => array(
                    'class' => "input input-medium"
                ),
                'widget' => 'single_text'
            ))
            ->add('endDate','date',array(
                'label' => 'pequiven.form.end_date',
                'label_attr' => array('class' => 'label'),
                'attr' => array(
                    'class' => "input input-medium"
                ),
                'widget' => 'single_text'
            ))
            ->add('responsible',null,array(
                'label' => 'pequiven.form.responsible',
                'label_attr' => array('class' => 'label'),
                'attr' => array(
                    'class' => "select2 input-xlarge"
                ),
                'required' => true,
            ))
            ->add('weight','integer',array(
                'label' => 'pequiven.form.weight',
                'label_attr' => array('class' => 'label'),
                'attr' => array(
                    'class' => "input input-mini",
                    'min' => '1',
                ),
            ))
            ->add('observations',null,array(
                'label' => 'pequiven.form.observations',
                'label_attr' => array('class' => 'label'),
                'attr' => array(
                    'class' => "input input-xlarge"
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
            'data_class' => 'Pequiven\ArrangementProgramBundle\Entity\Goal',
            'translation_domain' => 'PequivenArrangementProgramBundle'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'goal';
    }
}
