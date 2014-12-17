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
        $parametersUser = array(
            'class' => 'Pequiven\MasterBundle\Entity\GerenciaSecond',
            'property' => 'description',
            'attr' => array(
                'class' => 'select2 input-xlarge'
            ),
            'multiple' => true,
        );
        
        $builder
            ->add('description')
            ->add('abbreviation')
            ->add('modular')
            ->add('vinculante')
            ->add('enabled')
            ->add('complejo')
            ->add('direction')
            ->add('gerenciaSecondVinculants','entity',$parametersUser)
            ->add('configuration',new Gerencia\ConfigurationType(),array(
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
            'data_class' => 'Pequiven\MasterBundle\Entity\Gerencia',
            'cascade_validation' => true,
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
