<?php

namespace Pequiven\SEIPBundle\Form\DataLoad\Service;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RangeType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateFrom',"date",array(
                'label_attr' => array('class' => 'label'),
                "attr" => array("class" => "input input-large date-from"),
                "widget" => "single_text",
                'format' => 'dd-MM-yyyy',
            ))
            ->add('dateEnd',"date",array(
                'label_attr' => array('class' => 'label'),
                "attr" => array("class" => "input input-large date-end"),
                "widget" => "single_text",
                'format' => 'dd-MM-yyyy',
            ))
            ->add('type',"choice",array(
                "empty_value" => "",
                'label_attr' => array('class' => 'label'),
                "attr" => array("class" => "select input-large select-range-type"),
                "choices" => \Pequiven\SEIPBundle\Entity\DataLoad\Production\Range::getTypeLabels(),
            ))
            ->add('value',null,array(
                'label_attr' => array('class' => 'label'),
                "attr" => array("class" => "input-unstyled input-mini"),
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\SEIPBundle\Entity\DataLoad\Service\Range',
            "translation_domain" => "PequivenSEIPBundle",
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pequiven_seipbundle_dataload_service_range';
    }
}
