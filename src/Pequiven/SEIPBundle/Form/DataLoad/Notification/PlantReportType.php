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
        
        $parametersToSet = array(
            'label_attr' => array('class' => 'label'),
            "empty_value" => "",
            "attr" => array("class" => "select2 input-large"),
        );
        
        $builder
            ->add('productsReport','collection',[
                'type' => new ProductReportType($this->dateNotification, $this->reportTemplate)
            ])
            ->add('consumerPlanningServices',null,$parametersToSet)
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
