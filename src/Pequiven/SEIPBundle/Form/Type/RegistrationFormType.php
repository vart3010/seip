<?php
namespace Pequiven\SEIPBundle\Form\Type;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Tecnocreaciones\Vzla\GovernmentBundle\Form\Type\RegistrationFormType as BaseType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Description of RegistrationFormType
 *
 * @author matias
 */
class RegistrationFormType extends BaseType {
    //put your code here
    public function buildForm(FormBuilderInterface $builder, array $options) {
        parent::buildForm($builder, $options);
        $parametersUser = array(
            'class' => 'Pequiven\MasterBundle\Entity\Rol',
                'property' => 'description',
                'label' => 'pequiven_seip.rol',
                'translation_domain' => 'PequivenSEIPBundle',
            'multiple' => true
        );
        $builder->add('numPersonal');
        $builder->add('complejo');
        $builder->add('gerencia');
    }
    
    public function getName() {
        return 'pequiven_seip_user_registration';
    }
}
