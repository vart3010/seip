<?php

namespace Pequiven\SEIPBundle\Form\Sip\Center;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Pequiven\SEIPBundle\Model\Sip\Center\Observations;

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
                'label' => 'Requerimiento ',
                'label_attr' => array('class' => 'label'),
                'attr' => array(
                    'class'     => 'input input-xlarge autoexpanding',
                    'maxlength' => 1000),
                'required' => true
                ))
            ->add('fecha', 'date', array(
                'label'=>'Fecha ',
                'label_attr' => array('class' => 'label'),
                'format' => 'd/M/y',
                'widget' => 'single_text',
                'attr'   => array('class' => 'input input-large'),
                'required' => true
                ))
            ->add('categoria', 'choice', array(
                'label' => 'Categoria ',                
                'choices' => Observations::getCategoriasObservations(),
                'label_attr' => array('class' => 'label'),
                'attr' => array(
                    'class' => 'select2 input-large form-control',
                    'style' => 'width: 300px',
                    ),
                'required' => true,
                'empty_value' => 'Seleccione...',
                ))           
                         
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