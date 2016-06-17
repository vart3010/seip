<?php

namespace Pequiven\SIGBundle\Form\Tracing;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class MaintenanceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {   
        $builder
             ->add('dateStart', 'date', array(
                'label'=>'Fecha Inicio',
                'label_attr' => array('class' => 'label'),
                'format' => 'd/M/y',
                'widget' => 'single_text',
                'attr' => array('class' => 'input input-large')               
                ))
            ->add('dateEnd', 'date', array(
                'label'=>'Fecha Cierre',
                'label_attr' => array('class' => 'label'),
                'format' => 'd/M/y',
                'widget' => 'single_text',
                'attr' => array('class' => 'input input-large')  
                ))
            
            ->add('analysis', 'textarea', array(
                'label' => 'Analisis',
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
            
            'data_class' => 'Pequiven\SIGBundle\Entity\Tracing\Maintenance',            

        ));
    }

    /**
     *
     * @return string
     */
    public function getName()
    {
        return 'sig_maintenance';
    }
    
}