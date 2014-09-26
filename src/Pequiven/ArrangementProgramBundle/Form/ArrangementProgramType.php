<?php

namespace Pequiven\ArrangementProgramBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArrangementProgramType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('categoryArrangementProgram',null,array(
                'label' => 'pequiven.form.category_arrangement_program',
                'label_attr' => array('class' => 'label'),
                'attr' => array(
                    'class' => "select2 input-large"
                )
            ))
            ->add('tacticalObjective',null,array(
                'label' => 'pequiven.form.tactical_objective',
                'label_attr' => array('class' => 'label'),
                'attr' => array(
                    'class' => "select2 input-xxlarge"
                )
            ))
            ->add('operationalObjective',null,array(
                'label' => 'pequiven.form.operational_objective',
                'label_attr' => array('class' => 'label'),
                'attr' => array(
                    'class' => "select2 input-xxlarge"
                )
            ))
            ->add('operatingIndicator',null,array(
                'label' => 'pequiven.form.operating_indicator',
                'label_attr' => array('class' => 'label'),
                'attr' => array(
                    'class' => "select2 input-xxlarge"
                )
            ))
            ->add('location',null,array(
                'label' => 'pequiven.form.location',
                'label_attr' => array('class' => 'label'),
                'attr' => array(
                    'class' => "select2 input-xlarge"
                )
            ))
            ->add('process',null,array(
                'label' => 'pequiven.form.process',
                'label_attr' => array('class' => 'label'),
                'attr' => array(
                    'class' => "input input-xlarge"
                )
            ))
            ->add('responsible',null,array(
                'label' => 'pequiven.form.responsible',
                'label_attr' => array('class' => 'label'),
                'attr' => array(
                    'class' => "select2 input-xlarge"
                )
            ))
            ->add('period',null,array(
                'label' => 'pequiven.form.period',
                'label_attr' => array('class' => 'label'),
                'attr' => array(
                    'class' => "select2 input-large"
                )
            ))
            ->add('timelines','collection',array(
                'type' => new TimelineType(),
                'allow_add' => true,
                'allow_delete' => false,
                'by_reference' => false,
                'cascade_validation' => true,
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram',
            'translation_domain' => 'PequivenArrangementProgramBundle',
            'cascade_validation' => true,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'arrangementprogram';
    }
}
