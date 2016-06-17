<?php

namespace Pequiven\SEIPBundle\Form\DataLoad;

use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository;
use Pequiven\SEIPBundle\Form\SeipAbstractForm;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductReportGroupType extends SeipAbstractForm {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        //$entity = new \Pequiven\SEIPBundle\Entity\DataLoad\ProductReport();
        $entity = $builder->getData();
        $plantReport = $plant = null;
        if ($entity != null) {
            $plantReport = $entity->getPlantReport();
            $plantReportId = $plantReport->getId();
            $plant = $plantReport->getPlant();
            $permitGroup = $plant->getPermitGroupProduct();
        }

        $queryBuilderEnable = $this->getQueryBuilderEnabled();
        $builder
                ->add('plantReport', null, array(
                    'label_attr' => array('class' => 'label'),
                    "empty_value" => "",
                    "attr" => array("class" => "select2 input-xlarge"),
                    "disabled" => true,
                    "query_builder" => $queryBuilderEnable,
                ))
                ->add("nameGroup", null, array(
                    'label' => 'Nombre de Grupo',
                    'label_attr' => array('class' => 'label'),
                    'attr' => array('class' => 'input small-margin-right'),
                    'required'=>true
                ))
                ->add('childrensGroup', null, array(
                    'label' => 'Productos',
                    'label_attr' => array('class' => 'label'),
                    "empty_value" => "",
                     'required'=>true,
                    "attr" => array("class" => "select2 input-large"),
                    //"property" => array("name"),
                    //"entity_alias" => "products_alias",
                    //"callback" => $queryBuilderEnable
                    "query_builder" => function(\Pequiven\SEIPBundle\Repository\DataLoad\ProductReportRepository $repository) use ($plantReportId) {
                return $repository->findByPlantReport($plantReportId, true);
            },
                ))
                ->add('indicator', 'tecno_ajax_autocomplete', array(
                    'label_attr' => array('class' => 'label'),
                    'entity_alias' => 'indicator_product_report_alias',
                    'attr' => array(
                        //"class" => "input input-xlarge validate[required]"
                        "class" => "input input-xlarge "
                    ),
                    "property" => array("description", "ref"),
                    "required" => false,
                    "callback" => function(\Pequiven\IndicatorBundle\Repository\IndicatorRepository $repository) use ($plant) {
                return $repository->getQueryPeriod();
            },
                ))
                ->add('enabled', null, array(
                    'label_attr' => array('class' => 'label'),
                    "attr" => array("class" => "switch medium mid-margin-right", "data-text-on" => "Si", "data-text-off" => "No"),
                    "required" => false,
                ))
        ;
        $builder
                ->add('isGroup', null, array(
                    'label' => "Permitir Subproductos",
                    'label_attr' => array('class' => 'label'),
                    "attr" => array("class" => "switch medium mid-margin-right", "data-text-on" => "Si", "data-text-off" => "No"),
                    "required" => false,
                    "disabled" => !$permitGroup
        ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\SEIPBundle\Entity\DataLoad\ProductReport',
            "translation_domain" => "PequivenSEIPBundle",
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'pequiven_seipbundle_dataload_productreportgroup';
    }

}
