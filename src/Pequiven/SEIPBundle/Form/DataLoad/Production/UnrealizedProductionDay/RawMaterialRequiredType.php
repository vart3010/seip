<?php

namespace Pequiven\SEIPBundle\Form\DataLoad\Production\UnrealizedProductionDay;

use Pequiven\SEIPBundle\Form\SeipAbstractForm;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RawMaterialRequiredType extends SeipAbstractForm
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $queryBuilderEnable = $this->getQueryBuilderEnabled();
        $builder
            ->add('rawMaterial',null,array(
                'label_attr' => array('class' => 'label'),
                "empty_value" => "",
                "attr" => array("class" => "input-large"),
                "query_builder" => $queryBuilderEnable,
            ))
            ->add('requiredAmount',null,[
                'label_attr' => array('class' => 'label'),
                "attr" => array("class" => "input input-large"),
            ])
            ->add('amountNotAvailable',null,[
                'label_attr' => array('class' => 'label'),
                "attr" => array("class" => "input input-large"),
            ])
            ->add('unitMeasure',null,[
                'label_attr' => array('class' => 'label'),
                "attr" => array("class" => "input-large"),
            ])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay\RawMaterialRequired',
            "translation_domain" => "PequivenSEIPBundle",
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'rawmaterialrequired';
    }
}
