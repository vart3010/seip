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
        $queryBuilderEnable = function (\Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository $repository){
            return $repository->getQueryAllEnabled();
        };
        $builder
            ->add('type',"choice",array(
                'label_attr' => array('class' => 'label'),
                "attr" => array("class" => "select2 input-large"),
                "choices" => \Pequiven\SEIPBundle\Model\DataLoad\Production\ProductPlanning::getTypeLabels(),
                "empty_value" => "",
            ))
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
            ->add('dailyProductionCapacity',null,array(
                'label_attr' => array('class' => 'label'),
                "attr" => array("class" => "input input-large"),
            ))
            ->add('daysStops',null,array(
                'label_attr' => array('class' => 'label'),
                "attr" => array("class" => "select2 input-large"),
                "multiple" => true,
                "query_builder" => $queryBuilderEnable,
            ))
            ->add("ranges","collection",array(
                'label_attr' => array('class' => 'label'),
                "type" => new RangeType(),
                "allow_add"    => true,
                'by_reference' => false,
                'allow_delete' => true,
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
