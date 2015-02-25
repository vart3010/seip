<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\MasterBundle\Admin\Formula;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Administrador del detalle de formula del indicador
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class FormulaDetailAdmin extends Admin
{
    protected function configureShowFields(\Sonata\AdminBundle\Show\ShowMapper $show)
    {
        $show
            ->add('indicator')
            ->add('variable')
            ->add('variableDescription')
            ->add('unitType')
            ->add('unit')
            ->add('createdAt')
            ->add('updatedAt')
            ;
    }
    
    protected function configureFormFields(FormMapper $form) 
    {
        $form
//            ->add('indicator')
            ->add('variable')
            ->add('variableDescription')
            ->add('unitType')
            ->add('unit')
            ;
    }
    
    protected function configureDatagridFilters(DatagridMapper $filter) 
    {
        $filter
            ->add('indicator')
            ->add('variable')
            ->add('variableDescription')
            ->add('unitType')
            ->add('unit')
            ;
    }
    
    protected function configureListFields(ListMapper $list) 
    {
        $list
            ->add('variable')
            ->add('variableDescription')
            ->add('unitType')
            ->add('unit')
            ;
    }
}
