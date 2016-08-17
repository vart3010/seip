<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com.ve
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\MasterBundle\Admin\CEI;

use Pequiven\MasterBundle\Admin\BaseAdmin;
use Sonata\AdminBundle\Admin\Admin;
//use Pequiven\SEIPBundle\Entity\CEI\Product;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Administrador de centros de acopio 
 *
 * @author Victor Tortolero <vart10.30@gmail.com>
 */
class DeliveryPointAdmin extends Admin {

    protected function configureShowFields(ShowMapper $show) {
        $show
                ->add("descripcion")
                ->add("period")
                ->add("delivery")
        ;
        parent::configureShowFields($show);
    }

    protected function configureFormFields(FormMapper $form) {
        $form
                ->add("descripcion")
                ->add('warehouse', 'sonata_type_model_autocomplete', array(
                    'property' => array('descripcion'),
                    'multiple' => false,
                    'required' => true,
                ))
                ->add("period")

        ;
        parent::configureFormFields($form);
    }

    protected function configureDatagridFilters(DatagridMapper $filter) {
        $filter
                ->add("descripcion")
                ->add("period")
                ->add("warehouse")
        ;
        parent::configureDatagridFilters($filter);
    }

    protected function configureListFields(ListMapper $list) {
        $list
                ->addIdentifier("descripcion")
                ->add("warehouse")
                ->add("period")
        ;
        parent::configureListFields($list);
    }

}
