<?php

namespace Pequiven\MasterBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GerenciaType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description')
            ->add('ref')
            ->add('abbreviation')
            ->add('modular')
            ->add('vinculante')
            ->add('enabled')
            ->add('userCreatedAt')
            ->add('userUpdatedAt')
            ->add('complejo')
            ->add('direction')
            ->add('configuration',new Gerencia\ConfigurationType())
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\MasterBundle\Entity\Gerencia'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pequiven_masterbundle_gerencia';
    }
}
