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
            ->add('process')
            ->add('timelines')
            ->add('status')
            ->add('period')
            ->add('categoryArrangementProgramt')
            ->add('tacticalObjective')
            ->add('operationalObjective')
            ->add('operatingIndicator')
            ->add('location')
            ->add('responsible')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pequiven_arrangementprogrambundle_arrangementprogram';
    }
}
