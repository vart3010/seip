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
                    'class' => "input input-xlarge validate[required]",
                    'ng-model' => 'model.goal.name'
                ),
                'required' => true,
            ))
            ->add('typeGoal',null,array(
                'label' => 'pequiven.form.type_goal',
                'label_attr' => array('class' => 'label'),
                'attr' => array(
                    'class' => "select2 input-xlarge",
                    'ng-model' => 'model.goal.typeGoal',
                    'ng-options' => 'value as value.description for (key,value) in data.typeGoals',
                    'style' => 'width: 270px',
                ),
                'empty_value' => 'pequiven.form.not_applicable',
                'required' => false,
            ))
            ->add('startDate','date',array(
                'label' => 'pequiven.form.start_date',
                'label_attr' => array('class' => 'label'),
                'attr' => array(
                    'class' => "input input-medium validate[required]",
                    'ng-model' => 'model.goal.startDate'
                ),
                'widget' => 'single_text',
                'required' => true,
                'format' => 'yyyy-MM-dd'
            ))
            ->add('endDate','date',array(
                'label' => 'pequiven.form.end_date',
                'label_attr' => array('class' => 'label'),
                'attr' => array(
                    'class' => "input input-medium validate[required]",
                    'ng-model' => 'model.goal.endDate',
                ),
                'widget' => 'single_text',
                'required' => true,
                'format' => 'yyyy-MM-dd'
            ))
            ->add('responsible',null,array(
                'label' => 'pequiven.form.responsible',
                'label_attr' => array('class' => 'label'),
                'attr' => array(
                    'class' => "select2 input-xlarge",
                    'ng-model' => 'model.goal.responsible',
                    'ng-options' => 'value as (value.firstName + " "+ value.lastName + " ("+value.username+")") for (key,value) in data.responsibleGoals',
                    'style' => 'width: 270px',
                ),
                'empty_value' => 'Seleccione',
                'required' => true,
            ))
            ->add('weight','integer',array(
                'label' => 'pequiven.form.weight',
                'label_attr' => array('class' => 'label'),
                'attr' => array(
                    'class' => "input input-mini validate[required,min[1],max[100] ]",
                    'min' => '1',
                    'max' => '100',
                    'ng-model' => 'model.goal.weight',
                ),
                'required' => true,
            ))
            ->add('observations',null,array(
                'label' => 'pequiven.form.observations',
                'label_attr' => array('class' => 'label'),
                'attr' => array(
                    'class' => "input input-xlarge",
                    'ng-model' => 'model.goal.observations',
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
            'translation_domain' => 'PequivenArrangementProgramBundle',
            'csrf_protection' => false,
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
