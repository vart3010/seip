<?php

namespace Pequiven\SEIPBundle\Form\Type;

use Tecnocreaciones\Vzla\GovernmentBundle\Form\Type\ProfileFormType as BaseProfileFormType;
use Symfony\Component\Form\FormBuilderInterface;

class ProfileFormType extends BaseProfileFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
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
