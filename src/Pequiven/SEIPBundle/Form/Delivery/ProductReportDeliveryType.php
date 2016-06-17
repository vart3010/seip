<?php

namespace Pequiven\SEIPBundle\Form\Delivery;

use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository;
use Pequiven\SEIPBundle\Form\SeipAbstractForm;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductReportDeliveryType extends SeipAbstractForm {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        //$entity = new \Pequiven\SEIPBundle\Entity\DataLoad\ProductReport();
        $entity = $builder->getData();
        $productGroup = $product = null;
        if ($entity != null) {
            $productGroup = $entity->getProductGroupDelivery();
            $productionLine = $productGroup->getProductionLine();
            //$plant = $plantReport->getPlant();
        }

        $queryBuilderEnable = $this->getQueryBuilderEnabled();
        $builder
                ->add('productGroupDelivery', null, array(
                    'label_attr' => array('class' => 'label'),
                    "empty_value" => "",
                    "attr" => array("class" => "select2 input-large"),
                    "disabled" => true,
                    "query_builder" => $queryBuilderEnable,
                ))
                ->add('product', null, array(
                    'label_attr' => array('class' => 'label'),
                    "empty_value" => "",
                    "attr" => array("class" => "select2 input-large"),
                    //"property" => array("name"),
                    //"entity_alias" => "products_alias",
                    //"callback" => $queryBuilderEnable
                    "query_builder" => function(\Pequiven\SEIPBundle\Repository\CEI\ProductRepository $repository) use ($productionLine) {
                return $repository->findQueryByProductionLine($productionLine);
            },
                ))
//            ->add('indicator','tecno_ajax_autocomplete',array(
//                'label_attr' => array('class' => 'label'),
//                'entity_alias' => 'indicator_product_report_alias',
//                'attr' => array(
//                        //"class" => "input input-xlarge validate[required]"
//                        "class" => "input input-xlarge "
//                    ),
//                "property" => array("description","ref"),
//                "required" => false,
//                "callback" => function(\Pequiven\IndicatorBundle\Repository\IndicatorRepository $repository) use ($plant){
//                    return $repository->getQueryPeriod();
//                },
//            ))
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
            'data_class' => 'Pequiven\SEIPBundle\Entity\Delivery\ProductReportDelivery',
            "translation_domain" => "PequivenSEIPBundle",
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'pequiven_seipbundle_delivery_productreport';
    }

}
