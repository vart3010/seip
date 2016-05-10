<?php

namespace Pequiven\SEIPBundle\Form\DataLoad\Service;

use Pequiven\SEIPBundle\Form\SeipAbstractForm;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ConsumerPlanningServiceType extends SeipAbstractForm
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entity = new \Pequiven\SEIPBundle\Entity\DataLoad\Service\ConsumerPlanningService();
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
            ->add('service',null,array(
                'label_attr' => array('class' => 'label'),
                "empty_value" => "",
                "attr" => array("class" => "select2 input-large"),
                "query_builder" => function (\Pequiven\SEIPBundle\Repository\CEI\ServiceRepository $repository) use ($plant){
                    return $repository->findQueryByPlant($plant);
                },
            ))
            ->add('aliquot',null,array(
                'label_attr' => array('class' => 'label'),
                "attr" => array("class" => "input"),
            ))
            ->add('typeOfPlanning', 'choice', array(
                'label' => 'Tipo de Planificación',
                'required' => true,
                'choices' => \Pequiven\SEIPBundle\Entity\DataLoad\Service\ConsumerPlanningService::getTypesOfPlanning(),
                'label_attr' => array('class' => 'label'),
                'attr' => array(
                    'class' => 'select2 input-large form-control',
                    'style' => 'width: 300px')
                    )
            )
            ->add('typeOfAliquot', 'choice', array(
                'label' => 'Tipo de Alícuota',
                'required' => true,
                'choices' => \Pequiven\SEIPBundle\Entity\DataLoad\Service\ConsumerPlanningService::getTypesOfAliquot(),
                'label_attr' => array('class' => 'label'),
                'attr' => array(
                    'class' => 'select2 input-large form-control',
                    'style' => 'width: 300px')
                    )
            )
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
            'data_class' => 'Pequiven\SEIPBundle\Entity\DataLoad\Service\ConsumerPlanningService',
            "translation_domain" => "PequivenSEIPBundle",
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pequiven_seipbundle_dataload_service_consumerplanningservice';
    }
}
