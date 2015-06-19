<?php

namespace Pequiven\SEIPBundle\Form\DataLoad\Plant;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PlantStopPlanningType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('plantReport',null,array(
                'label_attr' => array('class' => 'label'),
                "empty_value" => "",
                "attr" => array("class" => "select2 input-large"),
                "disabled" => true,
            ))
            ->add('month',"choice",array(
                'label_attr' => array('class' => 'label'),
                "attr" => array("class" => "select2 input-large"),
                "choices" => \Pequiven\SEIPBundle\Service\ToolService::getMonthsLabels(),
                "empty_value" => "",
            ))
            ->add('totalStops',null,array(
                'label_attr' => array('class' => 'label'),
                "attr" => array("class" => "input input-mini"),
            ))
            ->add('dayStops',"collection",array(
                "type" => new \Pequiven\SEIPBundle\Form\DataLoad\Production\DayStopType(),
                'label_attr' => array('class' => 'label'),
                "allow_add"    => true,
                'allow_delete' => true,
                'by_reference' => false,
                'cascade_validation' => true,
            ))
            ->add('enabled',null,array(
                'label_attr' => array('class' => 'label'),
                "attr" => array("class" => "switch medium mid-margin-right","data-text-on"=>"Si","data-text-off"=>"No"),
                "required" => false,
            ))
            ->add("ranges","collection",array(
                'label_attr' => array('class' => 'label'),
                "type" => new RangeType(),
                "allow_add"    => true,
                'allow_delete' => true,
                'by_reference' => false,
                'cascade_validation' => true,
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\SEIPBundle\Entity\DataLoad\Plant\PlantStopPlanning',
            "translation_domain" => "PequivenSEIPBundle",
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pequiven_seipbundle_dataload_plant_plantstopplanning';
    }
}
