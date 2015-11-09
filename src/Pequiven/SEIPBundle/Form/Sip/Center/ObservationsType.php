<?php

namespace Pequiven\SEIPBundle\Form\Sip\Center;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ObservationsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('observations', 'textarea', array(
                'label' => 'Observación',
                'label_attr' => array('class' => 'label'),
                'attr' => array(
                    'class'     => 'input full-width autoexpanding validate[required]',
                    'maxlength' => 3500
                )))            
                         
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\SEIPBundle\Entity\Sip\Center\Observations'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sip_center_observations';
    }
}