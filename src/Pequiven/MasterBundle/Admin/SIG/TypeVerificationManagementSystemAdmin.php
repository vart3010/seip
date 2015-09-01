<?php

namespace Pequiven\MasterBundle\Admin\SIG;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Administrador los tipos de verificación para el plan de acción
 *
 */
class TypeVerificationManagementSystemAdmin extends Admin
{
    protected function configureShowFields(\Sonata\AdminBundle\Show\ShowMapper $show) 
    {
        $show
            ->add('id')
            ->add('ref')
            ->add('description')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('deletedAt')
            ->add('status')
            ;
    }
    
    protected function configureFormFields(FormMapper $form) 
    {
        $form
            ->add('ref')                    
            ->add('description')
            ->add('status')
        ;
    }
    
    protected function configureDatagridFilters(DatagridMapper $filter) 
    {
        $filter
            ->add('ref')
            ->add('description')
            ->add('createdAt')
            ->add('updatedAt')
            ;
    }
    
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('ref')
            ->add('description')
            ->add('status')
            ->add('createdAt')
            ;
    }
}
