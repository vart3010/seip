<?php

namespace Pequiven\SEIPBundle\Form\DataLoad\ServiceFactor;

use Pequiven\SEIPBundle\Form\SeipAbstractForm;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ConsumerPlanningServiceFactorType extends SeipAbstractForm
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entity = new \Pequiven\SEIPBundle\Entity\DataLoad\ServiceFactor\ConsumerPlanningServiceFactor();
        $entity = $builder->getData();
        $plant = $entity->getPlantReport()->getPlant();
        
        $parametersPreSet = array(
            'label_attr' => array('class' => 'label'),
            "empty_value" => "",
            "attr" => array("class" => "select2 input-large"),
            "disabled" => true,
        );
        $builder
            ->add('plantReport',null,$parametersPreSet)
            ->add('enabled',null,array(
                'label_attr' => array('class' => 'label'),
                "attr" => array("class" => "switch medium mid-margin-right","data-text-on"=>"Si","data-text-off"=>"No"),
                "required" => false,
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\SEIPBundle\Entity\DataLoad\ServiceFactor\ConsumerPlanningServiceFactor',
            "translation_domain" => "PequivenSEIPBundle",
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pequiven_seipbundle_dataload_servicefactor_consumerplanningservicefactor';
    }
}
