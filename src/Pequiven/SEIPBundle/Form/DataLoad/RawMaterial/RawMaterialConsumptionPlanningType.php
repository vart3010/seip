<?php

namespace Pequiven\SEIPBundle\Form\DataLoad\RawMaterial;

use Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial\RawMaterialConsumptionPlanning as RawMaterialConsumptionPlanning2;
use Pequiven\SEIPBundle\Form\SeipAbstractForm;
use Pequiven\SEIPBundle\Model\DataLoad\RawMaterial\RawMaterialConsumptionPlanning;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RawMaterialConsumptionPlanningType extends SeipAbstractForm
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entity = new RawMaterialConsumptionPlanning2();
        $entity = $builder->getData();
        
        $product = $entity->getProductReport()->getProduct();
        $rawMaterials = $product->getRawMaterials();
        
        $builder
            ->add('type',"choice",array(
                "empty_value" => "",
                'label_attr' => array('class' => 'label'),
                "attr" => array("class" => "select2 input-large"),
                "choices" => RawMaterialConsumptionPlanning::getTypeLabels()
            ))
            ->add('product',null,array(
                "empty_value" => "",
                'label_attr' => array('class' => 'label'),
                "attr" => array("class" => "select2 input-large"),
                "query_builder" => function (\Pequiven\SEIPBundle\Repository\CEI\ProductRepository $repository) use ($rawMaterials) {
                    return $repository->findIn($rawMaterials);
                },
            ))
            ->add('aliquot',null,array(
                'label_attr' => array('class' => 'label'),
                "attr" => array("class" => "input"),
            ))
            ->add('automaticCalculationPlan',null,array(
                'label_attr' => array('class' => 'label'),
                "attr" => array("class" => "input"),
                "required" => false,
            ))
            ->add('productReport',null,array(
                'label_attr' => array('class' => 'label'),
                "attr" => array("class" => "select2 input-large"),
                "data" => $entity->getProductReport(),
                "disabled" => true,
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial\RawMaterialConsumptionPlanning',
            "translation_domain" => "PequivenSEIPBundle",
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pequiven_seipbundle_dataload_rawmaterial_rawmaterialconsumptionplanning';
    }
}
