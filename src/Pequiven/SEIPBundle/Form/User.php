<?php

namespace Pequiven\SEIPBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Description of User
 *
 * @author matias
 */
class User extends AbstractType {
    
            /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $parametersUser = array(
            'class' => 'Pequiven\MasterBundle\Entity\Rol',
                'property' => 'name',
                'attr' => array(
                    'class' => 'select2 input-xlarge'
                ),
            'multiple' => true
        );
        
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('numPersonal')
            ->add('complejo')
            ->add('gerencia')
            ->add('gerenciaSecond')
            ->add('direction')
            ->add('groups','entity',$parametersUser)
            ->add('username')
            ->add('usernameCanonical')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\SEIPBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pequiven_seipbundle_user';
    }
}
