<?php

namespace Pequiven\SEIPBundle\Form\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LocalizationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('location',null,array(
                'label_attr' => array('class' => 'label'),
                'attr' => array(
                    'class' => 'select2 input-xlarge'
                )
            ))
            ->add('gerencia',null,array(
                'label_attr' => array('class' => 'label'),
                'attr' => array(
                    'class' => 'select2 input-xlarge'
                ),
                'group_by'=> 'complejo'
            ))
            ->add('gerenciaSecond',null,array(
                'label_attr' => array('class' => 'label'),
                'attr' => array(
                    'class' => 'select2 input-xlarge'
                ),
                'group_by'=> 'gerencia'
            ))
            ->add('rol','entity',array(
                'class' => 'Pequiven\MasterBundle\Entity\Rol',
                'property' => 'description',
                'label_attr' => array('class' => 'label'),
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
            'data_class' => 'Pequiven\SEIPBundle\Entity\User\Localization',
            'translation_domain' => 'PequivenSEIPBundle'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pequiven_seipbundle_user_localization';
    }
}
