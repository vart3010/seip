<?php

namespace Pequiven\MasterBundle\Form\Gerencia;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ConfigurationType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('arrangementProgramUserToRevisers',null,array(
                'attr' => array(
                    'class' => 'select2 input-xlarge'
                )
            ))
            ->add('arrangementProgramUsersToApproveTactical',null,array(
                'attr' => array(
                    'class' => 'select2 input-xlarge'
                )
            ))
            ->add('arrangementProgramUsersToApproveOperative',null,array(
                'attr' => array(
                    'class' => 'select2 input-xlarge'
                )
            ))
            ->add('arrangementProgramUsersToNotify',null,array(
                'attr' => array(
                    'class' => 'select2 input-xlarge'
                )
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\MasterBundle\Entity\Gerencia\Configuration'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pequiven_masterbundle_gerencia_configuration';
    }
}
