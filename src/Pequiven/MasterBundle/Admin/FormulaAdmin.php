<?php

namespace Pequiven\MasterBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Admin de formula
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
class FormulaAdmin extends Admin
{
    protected function configureFormFields(FormMapper $form) {
        $form
            ->add('description')
            ->add('equation')
            ->add('equationReal')
            ->add('formulaLevel')
            ->add('enabled')
            ->add('variables')
        ;
    }
    
    protected function configureDatagridFilters(DatagridMapper $filter) {
        $filter
            ->add('description')
            ->add('equation')
            ->add('equationReal')
            ->add('enabled')
            ;
    }
    
    protected function configureListFields(ListMapper $list) {
        $list
            ->addIdentifier('description')
            ->addIdentifier('equation')
            ->add('equationReal')
            ->add('enabled')
            ;
    }
}
