<?php

namespace Pequiven\ArrangementProgramBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TimelineType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('goals','collection',array(
                'type' => new GoalType(),
                'allow_add'    => true,
                'allow_delete' => true,
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
            'data_class' => 'Pequiven\ArrangementProgramBundle\Entity\Timeline',
            'translation_domain' => 'PequivenArrangementProgramBundle',
            'cascade_validation' => true,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'timeline';
    }
}
