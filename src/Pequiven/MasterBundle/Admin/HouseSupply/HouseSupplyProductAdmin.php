<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\MasterBundle\Admin\HouseSupply;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Administracion de Productos de HouseSupply
 *
 * @author Gilbert <glavrjk@gmail.com>
 */
class HouseSupplyProductAdmin extends Admin {

    protected function configureShowFields(ShowMapper $show) {
        $show
                ->add('id')
                ->add('code')
                ->add('description')
                ->add('price')
                ->add('cost')
                ->add('maxPerUser')
        ;
    }

    protected function configureFormFields(FormMapper $form) {
        $form
                
                ->add('code')
                ->add('description')
                ->add('price')
                ->add('cost')
                ->add('maxPerUser')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter) {
        $filter
                ->add('id')
                ->add('code')
                ->add('description')
                ->add('price')
                ->add('cost')
                ->add('maxPerUser')
        ;
    }

    protected function configureListFields(ListMapper $list) {
        $list
                ->add('id')
                ->add('code')
                ->add('description')
                ->add('price')
                ->add('cost')
                ->add('maxPerUser')

        ;
    }

}
