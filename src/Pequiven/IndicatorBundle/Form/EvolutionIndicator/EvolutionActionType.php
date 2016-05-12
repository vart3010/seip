<?php

namespace Pequiven\IndicatorBundle\Form\EvolutionIndicator;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class EvolutionActionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {   
        $id = $this->id;
        $typeObject = $this->typeObject;        
        $builder
            ->add('action', 'text', array(
                'label' => 'Acción',
                'label_attr' => array('class' => 'label'),
                'attr'=> array('class'=> 'input input-large ' )))            
            ->add('indicatorAction','entity',array(
                'label' => 'Tipo de Acción',
                'label_attr' => array('class' => 'label'),
                'class' => 'Pequiven\SIGBundle\Entity\TypeActionManagementSystem',
                'property' => 'description',
                'attr'=> array(
                'class'=> 'select2 input-large form-control')))
            ->add('dateStart', 'date', array(
                'label'=>'Fecha de Inicio',
                'label_attr' => array('class' => 'label'),
                'format' => 'd/M/y',
                'widget' => 'single_text',
                'attr' => array('class' => 'input input-large')               
                ))
            ->add('dateEnd', 'date', array(
                'label'=>'Fecha de Cierre',
                'label_attr' => array('class' => 'label'),
                'format' => 'd/M/y',
                'widget' => 'single_text',
                'attr' => array('class' => 'input input-large')  
                ))                        
            ->add('evolutionCause', null, array(
                    'query_builder' => function(\Pequiven\IndicatorBundle\Repository\Indicator\EvolutionIndicator\EvolutionCauseRepository $repository) use($id, $typeObject) {
                        return $repository->getCausesByObject($id, $typeObject);
                    },                               
                    'label' => 'Causa del Plan',
                    'label_attr' => array('class' => 'label'),
                    'attr' => array(
                        'class' => "input-large select2",                        
                        'style' => 'width: 270px',                        
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
            'data_class' => 'Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionAction',            
        ));
    }

    /**
     *
     * @return string
     */
    public function getName()
    {
        return 'actionResults';
    }

    protected $id;
    protected $typeObject;
    
    public function __construct ($id, $typeObject)
    {
        $this->id = $id;       
        $this->typeObject = $typeObject; 
    }
}