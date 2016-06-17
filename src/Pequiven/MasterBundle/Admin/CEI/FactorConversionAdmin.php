<?php

namespace Pequiven\MasterBundle\Admin\CEI;

use Pequiven\MasterBundle\Admin\BaseAdmin;
use Pequiven\SEIPBundle\Entity\CEI\Product;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Factor de conversion de producto
 *
 * @author Victor Tortolero <vart10.30@gmail.com>
 */
class FactorConversionAdmin extends BaseAdmin {

    protected function configureShowFields(ShowMapper $show) {
        $show
                ->add('id')
                ->add('productUnitFrom')
                ->add('productUnitTo')
                ->add('formula')
                ->add('alias')

        ;
        parent::configureShowFields($show);
    }

    protected function configureFormFields(FormMapper $form) {
        $form
                ->add('productUnitFrom')
                ->add('productUnitTo')
                ->add('formula')
                ->add('alias')

        ;

        parent::configureFormFields($form);
    }

    protected function configureDatagridFilters(DatagridMapper $filter) {
        $filter
                ->add('id')
                ->add('productUnitFrom')
                ->add('productUnitTo')
                ->add('alias')
        ;
        parent::configureDatagridFilters($filter);
    }

    protected function configureListFields(ListMapper $list) {
        $list
                ->addIdentifier('id')
                ->add('productUnitFrom')
                ->add('productUnitTo')
                ->add('formula')
                ->add('alias')
        ;
        parent::configureListFields($list);
    }

}
