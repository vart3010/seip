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
class WarehouseAdmin extends BaseAdmin {

    protected function configureShowFields(ShowMapper $show) {
        $show
                ->add("id")
                ->add("descripcion")

        ;
        parent::configureShowFields($show);
    }

    protected function configureFormFields(FormMapper $form) {
        $form
                ->add("descripcion")
        ;
        parent::configureFormFields($form);
    }

    protected function configureDatagridFilters(DatagridMapper $filter) {
        $filter
                ->add("id")
                ->add("descripcion")
        ;
        parent::configureDatagridFilters($filter);
    }

    protected function configureListFields(ListMapper $list) {
        $list
                ->addIdentifier("id")
                ->addIdentifier("descripcion")
        ;
        parent::configureListFields($list);
    }

    public function toString($object) {
        $toString = '-';
        if ($object->getId() > 0) {
            $toString = $object->getDescripcion();
        }
        return \Pequiven\SEIPBundle\Service\ToolService::truncate($toString, array('limit' => 50));
    }

}
