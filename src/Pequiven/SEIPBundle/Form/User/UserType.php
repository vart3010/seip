<?php

namespace Pequiven\SEIPBundle\Form\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                //->add('ref', 'text', array('attr'=> array('class'=> 'form-control' )))
                ->add('indentification', 'text', array(
                    'label' => 'Cédula',
                    'label_attr' => array('class' => 'label'),
                    'attr' => array('class' => 'input input-large'),
                    'required' => false))
                ->add('cellphone', 'text', array(
                    'label' => 'Teléfono Celular',
                    'label_attr' => array('class' => 'label'),
                    'attr' => array('class' => 'input input-large'),
                    'required' => false))
                ->add('ext', 'text', array(
                    'label' => 'Extensión',
                    'label_attr' => array('class' => 'label'),
                    'attr' => array('class' => 'input input-large'),
                    'required' => false))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\SEIPBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'userType_data';
    }

}
