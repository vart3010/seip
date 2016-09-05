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
                ->add('instance')
                ->add('description')
                ->add('price')
                ->add('cost')
                ->add('taxes')
                ->add('exento')
                ->add('maxPerUserForce')
        ;
    }

    protected function configureFormFields(FormMapper $form) {
        $form
                ->add('code')
                ->add('instance')
                ->add('description')
                ->add('price', null, array(
                    'label' => 'Precio sin Impuestos',
                ))
                ->add('cost', null, array(
                    'label' => 'Costo',
                ))
                ->add('taxes', null, array(
                    'label' => 'Valor Impuestos',
                ))
                ->add('exento')
                ->add('maxPerUserForce', null, array(
                    'label' => 'Artículos Máximos por Persona',
                ))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter) {
        $filter
                ->add('id')
                ->add('instance')
                ->add('code')
                ->add('description')
                ->add('exento')
        ;
    }

    protected function configureListFields(ListMapper $list) {
        $list
                ->addIdentifier('id')
                ->add('code')
                ->add('description')
                ->add('exento')
                ->add('price')
        ;
    }

}
