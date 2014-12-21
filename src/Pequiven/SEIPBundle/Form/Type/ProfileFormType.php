<?php

namespace Pequiven\SEIPBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\ProfileFormType as BaseProfileFormType;

class ProfileFormType extends BaseProfileFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
                ->add('firstname',null,array(
                    'label' => 'form.first_name',
                    'translation_domain' => 'TecnocreacionesVzlaGovernmentBundle',
                ))
                ->add('lastname',null,array(
                    'label' => 'form.last_name',
                    'translation_domain' => 'TecnocreacionesVzlaGovernmentBundle',
                ))
                ;
        $builder
                ->add('numPersonal',null,array(
                    'label' => 'form.num_personal',
                    'translation_domain' => 'PequivenSEIPBundle',
                ))
                ;
    }

    public function getName()
    {
        return 'pequiven_seip_user_profile';
    }
}
