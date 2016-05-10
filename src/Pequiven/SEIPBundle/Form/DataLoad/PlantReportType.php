<?php

namespace Pequiven\SEIPBundle\Form\DataLoad;

use Pequiven\SEIPBundle\Form\SeipAbstractForm;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PlantReportType extends SeipAbstractForm {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        //$entity = new \Pequiven\SEIPBundle\Entity\DataLoad\PlantReport();
        $entity = $builder->getData();
        $location = $entity->getReportTemplate()->getLocation();

        $parametersPreSet = array(
            'label_attr' => array('class' => 'label'),
            "empty_value" => "",
            "attr" => array("class" => "select2 input-large"),
            "disabled" => true,
        );

        $parametersToSet = array(
            'label_attr' => array('class' => 'label'),
            "empty_value" => "",
            "attr" => array("class" => "select2 input-large"),
        );

        $builder
                ->add('reportTemplate', null, $parametersPreSet)
                ->add('company', null, $parametersPreSet)
                ->add('location', null, $parametersPreSet)
                ->add('entity', null, array(
                    'label_attr' => array('class' => 'label'),
                    "empty_value" => "",
                    "attr" => array("class" => "select2 input-large"),
                    "query_builder" => function (\Pequiven\SEIPBundle\Repository\CEI\EntityRepository $repository) use ($location) {
                return $repository->findQueryByLocation($location);
            },
                ))
                ->add('plant', null, $parametersToSet)
                //->add('childrensGroup', null, $parametersToSet)
                ->add('currentCapacity', null, array(
                    'label_attr' => array('class' => 'label'),
                    "attr" => array("class" => "input"),
                ))
                ->add('enabled', null, array(
                    'label_attr' => array('class' => 'label'),
                    "attr" => array("class" => "switch medium mid-margin-right", "data-text-on" => "Si", "data-text-off" => "No"),
                    "required" => false,
                ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\SEIPBundle\Entity\DataLoad\PlantReport',
            "translation_domain" => "PequivenSEIPBundle",
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'pequiven_seipbundle_dataload_plantreport';
    }

}
