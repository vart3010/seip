<?php

namespace Pequiven\SEIPBundle\Form\DataLoad\Notification;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductReportType extends BaseNotification
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //$entity = new \Pequiven\SEIPBundle\Entity\DataLoad\ProductReport();
        
//        $paramateretsDaysDisabled = $this->getParametersDisabled();
        $builder
//            ->add('product',null,$paramateretsDaysDisabled)
            ->add('productDetailDailyMonths','collection',array(
                'type' => new ProductDetailDailyMonthType($this->dateNotification, $this->reportTemplate)
            ))
            ->add('inventorys','collection',array(
                'type' => new InventoryType($this->dateNotification, $this->reportTemplate)
            ))
            ->add('rawMaterialConsumptionPlannings','collection',[
                'type' => new RawMaterialConsumptionPlanningType($this->dateNotification, $this->reportTemplate)
            ])
            ->add('unrealizedProductions','collection',[
                'type' => new UnrealizedProductionType($this->dateNotification, $this->reportTemplate)
            ])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\SEIPBundle\Entity\DataLoad\ProductReport',
            "translation_domain" => "PequivenSEIPBundle",
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'productreport';
    }
}
