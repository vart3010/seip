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
 * Administracion de Inventario
 *
 * @author Gilbert <glavrjk@gmail.com>
 */
class HouseSupplyProductInstanceAdmin extends Admin {

    protected function configureShowFields(ShowMapper $show) {
        $show
                ->add('id')                
                ->add('code')
                ->add('description')
                ->add('available')
                ->add('maxPerUser')
                ->add('maxPerUserForce')
        ;
    }

    protected function configureFormFields(FormMapper $form) {
        $form
                ->add('id')
                ->add('code')
                ->add('description')
                ->add('available')
                ->add('maxPerUser')
                ->add('maxPerUserForce')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter) {
        $filter
                ->add('id')
                ->add('code')
                ->add('description')
                ->add('available')
                ->add('maxPerUser')
                ->add('maxPerUserForce')
        ;
    }

    protected function configureListFields(ListMapper $list) {
        $list
                ->addIdentifier('id')
                ->add('code')
                ->add('description')
                ->add('available')
                ->add('maxPerUser')
                ->add('maxPerUserForce')
        ;
    }

}
