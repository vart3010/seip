<?php

namespace Pequiven\SIGBundle\Form\Tracing;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class StandardizationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {   
        $builder
            ->add('area', 'text', array(
                'label' => 'Área o Proceso',
                'label_attr' => array('class' => 'label'),
                'attr'=> array('class'=> 'input input-xlarge ' ))) 
            ->add('detection', 'choice', array(            
                'label' => 'Detección',
                'label_attr' => array('class' => 'label'),
                'attr'=> array('class'=> 'select2 input-xlarge form-control' ),
                    "choices" => \Pequiven\SIGBundle\Entity\Tracing\Standardization::getDetectionArray(),                     
                    'required' => true,
            ))                         
            ->add('code', 'text', array(
                'label' => 'Codigo',
                'label_attr' => array('class' => 'label'),
                'attr'=> array('class'=> 'input input-xlarge ' ))) 
            ->add('type', 'choice', array(            
                'label' => 'Tipo de NC',
                'label_attr' => array('class' => 'label'),
                'attr'=> array('class'=> 'select2 input-xlarge form-control' ),
                    "choices" => \Pequiven\SIGBundle\Entity\Tracing\Standardization::getTypeNcArray(),                     
                    'required' => true,
            )) 
            ->add('description', 'textarea', array(
                'label' => 'Descripción de la NC',
                'label_attr' => array('class' => 'label'),
                'attr'=> array('class'=> 'input input-xlarge ' ))) 
            ->add('treatment', 'text', array(
                'label' => 'Tratamiento',
                'label_attr' => array('class' => 'label'),
                'attr'=> array('class'=> 'input input-xlarge ' )))
        ;
    }
    
    /**
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {   
        $resolver->setDefaults(array(
            
            'data_class' => 'Pequiven\SIGBundle\Entity\Tracing\Standardization',            

        ));
    }

    /**
     *
     * @return string
     */
    public function getName()
    {
        return 'sig_standardization';
    }
    
}