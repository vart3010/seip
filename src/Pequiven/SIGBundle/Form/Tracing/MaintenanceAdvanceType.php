<?php

namespace Pequiven\SIGBundle\Form\Tracing;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class MaintenanceAdvanceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {   
        $builder
            ->add('analysis', 'textarea', array(
                'label' => 'Analisis',
                'label_attr' => array('class' => 'label'),
                'attr'=> array('class'=> 'input input-xlarge ' )))              
            ->add('advance', 'text', array(
                'label' => 'Avance',
                'label_attr' => array('class' => 'label'),
                'attr'=> array('class'=> 'input input-xlarge ' )))                         
            ->add('observations', 'textarea', array(
                'label' => 'Observación',
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
            
            'data_class' => 'Pequiven\SIGBundle\Entity\Tracing\MaintenanceAdvance',            

        ));
    }

    /**
     *
     * @return string
     */
    public function getName()
    {
        return 'sig_maintenance_advance';
    }
    
}