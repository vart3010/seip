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
                'property' => 'description',
                'label' => 'pequiven_seip.rol',
                'translation_domain' => 'PequivenSEIPBundle',
                'attr' => array(
                    'class' => 'select2 input-xlarge'
                ),
            'multiple' => true
        );
        
        $builder
            ->add('firstName',null,array('label' => 'pequiven_seip.firstName','translation_domain' => 'PequivenSEIPBundle'))
            ->add('lastName',null,array('label' => 'pequiven_seip.lastName','translation_domain' => 'PequivenSEIPBundle'))
            ->add('numPersonal',null,array('label' => 'pequiven_seip.numPersonal','translation_domain' => 'PequivenSEIPBundle'))
            ->add('complejo','entity',array('class' => 'Pequiven\MasterBundle\Entity\Complejo','property' => 'description','required' => false,'empty_data' => null,'empty_value' => 'Ninguna','label' => 'pequiven_seip.complejo','translation_domain' => 'PequivenSEIPBundle','attr' => array('class' => 'select2 input-xlarge')))
            ->add('gerencia','entity',array('class' => 'Pequiven\MasterBundle\Entity\Gerencia','property' => 'description','required' => false,'empty_data' => null,'empty_value' => 'Ninguna','label' => 'pequiven_seip.gerenciaFirst','translation_domain' => 'PequivenSEIPBundle','attr' => array('class' => 'select2 input-xlarge')))
            ->add('gerenciaSecond','entity',array('class' => 'Pequiven\MasterBundle\Entity\GerenciaSecond','property' => 'description','required' => false,'empty_data' => null,'empty_value' => 'Ninguna','label' => 'pequiven_seip.gerenciaSecond','translation_domain' => 'PequivenSEIPBundle','attr' => array('class' => 'select2 input-xlarge')))
            ->add('direction',null,array('label' => 'pequiven_seip.direction','translation_domain' => 'PequivenSEIPBundle'))
            ->add('groups','entity',$parametersUser)
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