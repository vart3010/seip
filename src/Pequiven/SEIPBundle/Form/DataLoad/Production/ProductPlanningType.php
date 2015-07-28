<?php

namespace Pequiven\SEIPBundle\Form\DataLoad\Production;

use Pequiven\SEIPBundle\Entity\DataLoad\Production\ProductPlanning;
use Pequiven\SEIPBundle\Service\ToolService;
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
        $typeGross = false;
        
        if($entity instanceof ProductPlanning){
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
            if($entity->getType() === ProductPlanning::TYPE_GROSS){
                $typeGross = true;
            }
        }
        $monthsDiff = array_diff_key(ToolService::getMonthsLabels(),$monthsReady);
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
            ->add("ranges","collection",array(
                'label_attr' => array('class' => 'label'),
                "type" => new RangeType(),
                "allow_add"    => true,
                'by_reference' => false,
                'allow_delete' => true,
                'cascade_validation' => true,
            ))
        ;
        if($typeGross === true){
            $builder->add('netProductionPercentage',null,array(
                'label_attr' => array('class' => 'label'),
                "attr" => array("class" => "input input-mini"),
                "required"=>false
            ));
        }
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\SEIPBundle\Entity\DataLoad\Production\ProductPlanning',
            "translation_domain" => "PequivenSEIPBundle",
            'cascade_validation' => true,
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
