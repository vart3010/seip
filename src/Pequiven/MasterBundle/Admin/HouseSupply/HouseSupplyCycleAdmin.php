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
 * Administracion de Ciclos de Órdenes de Pedido HouseSupply
 *
 * @author Gilbert <glavrjk@gmail.com>
 */
class HouseSupplyCycleAdmin extends Admin {

    protected function configureShowFields(ShowMapper $show) {
        $show
                ->add('id')
                ->add('dateBeginOrder')
                ->add('dateEndOrder')
                ->add('productKit')
                ->add('workStudyCircleGroup')
        ;
    }

    protected function configureFormFields(FormMapper $form) {
        $form
                ->add('dateBeginOrder', 'sonata_type_date_picker', array(
                    'label' => 'Fecha de Inicio para la Creación de Pedidos',
                ))
                ->add('dateEndOrder', 'sonata_type_date_picker', array(
                    'label' => 'Fecha de Cierre para la Creación de Pedidos',
                ))
                ->add('productKit', null, array(
                    'label' => 'Kit Asociado',
                ))
                ->add('workStudyCircleGroup', null, array(
                    'label' => 'Grupo de Círculos de Estudio que Pueden Crear Pedidos',
                ))

        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter) {
        $filter
                ->add('id')
                ->add('dateBeginOrder')
                ->add('dateEndOrder')
                ->add('productKit')
                ->add('workStudyCircleGroup')
        ;
    }

    protected function configureListFields(ListMapper $list) {
        $list
                ->addIdentifier('id')
                ->add('dateBeginOrder')
                ->add('dateEndOrder')
                ->add('productKit')
                ->add('workStudyCircleGroup')
        ;
    }

}
