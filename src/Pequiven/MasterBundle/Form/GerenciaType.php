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
        $parametersGerenciaVinculant = array(
            'class' => 'Pequiven\MasterBundle\Entity\GerenciaSecond',
            'property' => 'description',
            'label' => 'pequiven_master.gerencia_second_vinculant',
            'translation_domain' => 'PequivenMasterBundle',
            'attr' => array(
                'class' => 'select2 input-xlarge'
            ),
            'multiple' => true,
            'required' => false,
        );
        
        $parametersGerenciaSupport = array(
            'class' => 'Pequiven\MasterBundle\Entity\GerenciaSecond',
            'property' => 'description',
            'label' => 'pequiven_master.gerencia_second_support',
            'translation_domain' => 'PequivenMasterBundle',
            'attr' => array(
                'class' => 'select2 input-xlarge'
            ),
            'multiple' => true,
            'required' => false,
        );
        
        
        $builder
            ->add('description')
            ->add('abbreviation')
            ->add('modular')
            ->add('vinculante')
            ->add('enabled')
            ->add('complejo')
            ->add('direction')
            ->add('gerenciaSecondVinculants','entity',$parametersGerenciaVinculant)
            ->add('gerenciaSecondSupports','entity',$parametersGerenciaSupport)
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
