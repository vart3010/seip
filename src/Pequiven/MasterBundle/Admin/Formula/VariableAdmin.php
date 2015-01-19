<?php

namespace Pequiven\MasterBundle\Admin\Formula;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Admin de Variable de la formula
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
class VariableAdmin extends Admin
{
    protected function configureShowFields(\Sonata\AdminBundle\Show\ShowMapper $show) {
        $show
            ->add('name')
            ->add('description')
            ;
    }
    
    protected function configureFormFields(FormMapper $form) {
        $form
            ->add('name')
            ->add('description')
            ;
    }
    
    protected function configureDatagridFilters(DatagridMapper $filter) {
        $filter
            ->add('name')
            ->add('description')
            ;
    }
    
    protected function configureListFields(ListMapper $list) {
        $list
            ->addIdentifier('name')
            ->addIdentifier('description')
            ;
    }
}
