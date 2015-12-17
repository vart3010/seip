<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\MasterBundle\Admin\User;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Administracion de Coordinaciones
 *
 * @author Gilbert <glavrjk@gmail.com>
 */
class CoordinacionAdmin extends Admin {

    protected function configureShowFields(\Sonata\AdminBundle\Show\ShowMapper $show) {
        $show
                ->add('id')
                ->add('description')
                ->add('sumary')
                ->add('gerenciaSecond')
                ->add('complejo')                
                ->add('enabled')
        ;
    }

    protected function configureFormFields(FormMapper $form) {
        $form
                ->add('description')
                ->add('sumary')
                ->add('gerenciaSecond','sonata_type_model_autocomplete',array(
                    'property' => array('description'),
                    'multiple' => false,
                    "required" => false,
                 ))
                ->add('complejo')
                ->add('enabled')
        ;
//                ->add('gerenciaSecond')
    }

    protected function configureDatagridFilters(DatagridMapper $filter) {
        $filter
                ->add('id')
                ->add('complejo')
                ->add('gerenciaSecond','doctrine_orm_model_autocomplete',array(),null,array(
                    'property' => array('description')
                ))
                ->add('enabled')
        ;
//                ->add('gerenciaSecond')
    }

    protected function configureListFields(ListMapper $list) {
        $list
                ->addIdentifier('description')
                ->add('complejo')
                ->add('gerenciaSecond')
                ->add('enabled')

        ;
    }

}
