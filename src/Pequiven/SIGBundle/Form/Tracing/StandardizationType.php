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
        $period = $this->period;

        $builder
            ->add('area', 'textarea', array(
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
            ->add('arrangementProgram', 'text', array(
                'label' => 'Programa de Gestión',
                'label_attr' => array('class' => 'label'),
                'attr'=> array('class'=> 'input input-xlarge ' )))
            ->add('arrangementProgram', null, array(
                    'query_builder' => function(\Pequiven\ArrangementProgramBundle\Repository\ArrangementProgramRepository $repository) use($period) {
                        return $repository->getArrangementByStandardization($period);
                    },                               
                    'label' => 'Causa del Plan',
                    'label_attr' => array('class' => 'label'),
                    'attr' => array(
                        'class' => "input-large select2",
                        //'onclick' => 'cargaData()',
                        'style' => 'width: 270px',
                        //'multiple' => 'multiple'
                    ),
                    'empty_value' => 'Seleccione...',
                    'required' => true,
                ))
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

    protected $period;
    
    public function __construct ($period)
    {
        $this->period = $period;               
    }
    
}