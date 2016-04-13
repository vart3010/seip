<?php

namespace Pequiven\SEIPBundle\Form\DataLoad\Notification;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PlantReportType extends BaseNotification
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //$entity = new \Pequiven\SEIPBundle\Entity\DataLoad\PlantReport();
        
        $builder
            ->add('productsReport','collection',[
                'type' => new ProductReportType($this->dateNotification, $this->reportTemplate),
                'cascade_validation' => true,
            ])
            ->add('consumerPlanningServices','collection',[
                'type' => new ConsumerPlanningServiceType($this->dateNotification, $this->reportTemplate),
                'cascade_validation' => true,
            ])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\SEIPBundle\Entity\DataLoad\PlantReport',
            "translation_domain" => "PequivenSEIPBundle",
            'cascade_validation' => true,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'plantreport';
    }
}
