<?php

namespace Pequiven\ArrangementProgramBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GoalDetailsType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('januaryPlanned')
            ->add('januaryReal')
            ->add('februaryPlanned')
            ->add('februaryReal')
            ->add('marchPlanned')
            ->add('marchReal')
            ->add('aprilPlanned')
            ->add('aprilReal')
            ->add('mayPlanned')
            ->add('mayReal')
            ->add('junePlanned')
            ->add('juneReal')
            ->add('julyPlanned')
            ->add('julyReal')
            ->add('augustPlanned')
            ->add('augustReal')
            ->add('septemberPlanned')
            ->add('septemberReal')
            ->add('octoberPlanned')
            ->add('octoberReal')
            ->add('novemberPlanned')
            ->add('novemberReal')
            ->add('decemberPlanned')
            ->add('decemberReal')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\ArrangementProgramBundle\Entity\GoalDetails',
            'csrf_protection' => false,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pequiven_arrangementprogrambundle_goaldetails';
    }
}
