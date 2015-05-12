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
        $entity = $builder->getData();
        $monthsReady = array();
        if($entity instanceof \Pequiven\SEIPBundle\Entity\DataLoad\Production\ProductPlanning){
            $productReport = $entity->getProductReport();
            $myMonth = null;
            if($entity->getId() > 0){
                $myMonth = $entity->getMonth();
            }
            if($productReport){
                $productPlannings = $productReport->getProductPlanningsByType($entity->getType());
                foreach ($productPlannings as $productPlanning) {
                    $month = $productPlanning->getMonth();
                    if($myMonth !== null && $myMonth === $month){
                        continue;
                    }
                    $monthsReady[$month] = $month;
                }
            }
        }
        $monthsDiff = array_diff_key(\Pequiven\SEIPBundle\Service\ToolService::getMonthsLabels(),$monthsReady);
        $builder
            ->add('month',"choice",array(
                'label_attr' => array('class' => 'label'),
                "attr" => array("class" => "select2 input-large"),
                "choices" => $monthsDiff,
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
            ->add('daysStops',"collection",array(
                "type" => new DayStopType(),
                'label_attr' => array('class' => 'label'),
                "allow_add"    => true,
                'by_reference' => false,
                'allow_delete' => true,
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
