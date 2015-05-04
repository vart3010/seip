<?php

namespace Pequiven\SEIPBundle\Form\DataLoad\Production;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductPlanningType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('month',"choice",array(
                'label_attr' => array('class' => 'label'),
                "attr" => array("class" => "select2 input-large"),
                "choices" => \Pequiven\SEIPBundle\Service\ToolService::getMonthsLabels(),
                "empty_value" => "",
            ))
            ->add('totalMonth',null,array(
                'label_attr' => array('class' => 'label'),
                "attr" => array("class" => "input input-large"),
            ))
            ->add('designCapacity',null,array(
                'label_attr' => array('class' => 'label'),
                "attr" => array("class" => "input input-large"),
            ))
            ->add('daysStops',null,array(
                'label_attr' => array('class' => 'label'),
                "attr" => array("class" => "select2 input-large"),
                "multiple" => true,
//                "required" => false,
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\SEIPBundle\Entity\DataLoad\Production\ProductPlanning',
            "translation_domain" => "PequivenSEIPBundle",
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pequiven_seipbundle_dataload_production_productplanning';
    }
}
