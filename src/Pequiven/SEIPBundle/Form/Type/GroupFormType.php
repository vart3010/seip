<?php

namespace Pequiven\SEIPBundle\Form\Type;

/**
 * Grupos de roles
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
class GroupFormType extends \FOS\UserBundle\Form\Type\GroupFormType {
    
    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('name', null, array('label' => 'form.group_name', 'translation_domain' => 'FOSUserBundle'))
                ->add('description', null, array('label' => 'form.group_description', 'translation_domain' => 'FOSUserBundle'))
                ->add('level', null, array('label' => 'form.group_level', 'translation_domain' => 'FOSUserBundle'))
                ->add('roles', 'choice', array(
                    'label' => 'form.group_roles',
                    'translation_domain' => 'FOSUserBundle',
                    'choices' => array(
                        'ROLE_WORKER_PQV' => 'Trabajador de pequiven',
                        'ROLE_WORKER_PLANNING' => 'Trabajador de planificacion',
                    ),
                    'multiple' => true,
                    'required' => true
                ))
            ;
    }
    
    public function getName()
    {
        return 'seip_user_group';
    }
}
