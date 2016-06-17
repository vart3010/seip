<?php

namespace Pequiven\MasterBundle\Admin\CEI;

use Pequiven\MasterBundle\Admin\BaseAdmin;
use Pequiven\SEIPBundle\Entity\CEI\Product;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Valor del factor de conversion
 *
 * @author Victor Tortolero <vart10.30@gmail.com>
 */
class FactorConversionValueAdmin extends BaseAdmin {

    protected function configureShowFields(ShowMapper $show) {
        $show
                ->add('id')
                ->add('factorConversion')
                ->add('productReport')
                ->add('factor')

        ;
        parent::configureShowFields($show);
    }

    protected function configureFormFields(FormMapper $form) {
//        $childrensParameters = array(
//            'class' => 'Pequiven\SEIPBundle\Entity\DataLoad\ProductReport',
//            'label' => 'Producto',
//            'empty_value' => ' ',
//            'required' => false,
//            "property" => array("name"),
//        );

        $form
                ->add('factorConversion', 'sonata_type_model_autocomplete', array(
                    'required' => false,
                    'property' => array('alias'),
                ))
                ->add('productReport', 'entity', array(
                    'class' => 'Pequiven\SEIPBundle\Entity\DataLoad\ProductReport',
                    'label' => 'Producto',
                    'empty_value' => ' ',
                    'property' => 'nameComplete',
                    'required' => true,
                ))
//                ->add('productReport', 'sonata_type_model_autocomplete', array(
//                    'required' => false,
//                    'property' => array('name'),
//                ))
//                ->add('productReport')
                ->add('factor')

        ;

        parent::configureFormFields($form);
    }

    protected function configureDatagridFilters(DatagridMapper $filter) {
        $filter
                ->add('id')
                ->add('factorConversion')
                ->add('productReport')
                ->add('factor')
        ;
        parent::configureDatagridFilters($filter);
    }

    protected function configureListFields(ListMapper $list) {
        $list
                ->addIdentifier('id')
                ->add('factorConversion')
                ->add('productReport')
                ->add('factor')
        ;
        parent::configureListFields($list);
    }

}
