<?php

namespace Pequiven\SEIPBundle\Form\Delivery;

use Pequiven\SEIPBundle\Form\SeipAbstractForm;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductGroupDeliveryType extends SeipAbstractForm {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $entity = $builder->getData();

        $location = $entity->getReportTemplateDelivery()->getLocation();

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
                ->add('reportTemplateDelivery', null, $parametersPreSet)
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
                //->add('plant', null, $parametersToSet)
                ->add('productionLine', null, $parametersToSet)
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
            'data_class' => 'Pequiven\SEIPBundle\Entity\Delivery\ProductGroupDelivery',
            "translation_domain" => "PequivenSEIPBundle",
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'pequiven_seipbundle_delivery_productgroup';
    }

}
