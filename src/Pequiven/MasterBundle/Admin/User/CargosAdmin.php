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
 * Administracion de Cargos
 *
 * @author Gilbert <glavrjk@gmail.com>
 */
class CargosAdmin extends Admin {

    protected function configureShowFields(\Sonata\AdminBundle\Show\ShowMapper $show) {
        $show
                ->add('id')
                ->add('gerenciasecond')
                ->add('codigo')
                ->addIdentifier('charge')
                ->add('User')
                ->add('staff')
        ;
    }

    protected function configureFormFields(FormMapper $form) {
        $form
                ->add('gerencia', 'sonata_type_model_autocomplete', array(
                    'property' => array('description'),
                    'multiple' => false,
                    "required" => true,
                    'attr' => array('class' => 'input input-large'),
                ))
                ->add('gerenciasecond', 'sonata_type_model_autocomplete', array(
                    'property' => array('description'),
                    'multiple' => false,
                    "required" => true,
                    'attr' => array('class' => 'input input-large'),
                ))
                ->add('coordinacion')
                ->add('parent')
                ->add('codigo')
                ->add('charge')
                ->add('User', 'sonata_type_model_autocomplete', array(
                    'property' => 'firstname',
                    'multiple' => false,
                ))
                ->add('staff')
                ->add('enabled')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter) {
        $filter
                ->add('gerencia', 'doctrine_orm_model_autocomplete', array(), null, array(
                    'property' => array('description'),
                    'multiple' => false,
                    "required" => false,
                    'attr' => array('class' => 'input input-large'),
                ))
                ->add('gerenciasecond', 'doctrine_orm_model_autocomplete', array(), null, array(
                    'property' => array('description'),
                    'multiple' => false,
                    "required" => false,
                    'attr' => array('class' => 'input input-large'),
                ))
                ->add('codigo')
                ->add('charge')
                ->add('User')
                ->add('parent')
                ->add('enabled')
        ;
    }

    protected function configureListFields(ListMapper $list) {
        $list
                ->add('gerenciasecond')
                ->addIdentifier('charge')
                ->add('User')
                ->add('staff')
        ;
    }

}
