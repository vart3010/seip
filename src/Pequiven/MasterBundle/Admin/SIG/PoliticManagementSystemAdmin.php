<?php

namespace Pequiven\MasterBundle\Admin\SIG;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Administrador de los sistemas de gestión
 *
 */
class PoliticManagementSystemAdmin extends Admin
{
    protected function configureShowFields(\Sonata\AdminBundle\Show\ShowMapper $show) 
    {
        $show
            ->add('id')
            ->add('description')
            ->add('descriptionBody')
            ->add('enabled')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('deletedAt')
            ;
    }
    
    protected function configureFormFields(FormMapper $form) 
    {
        $form
            ->add('description')
            ->add('descriptionBody')
            ->add('enabled',null,array(
                'required' => false,
            ))
            ;
    }
    
    protected function configureDatagridFilters(DatagridMapper $filter) 
    {
        $filter
            ->add('description')
            ->add('enabled')
            ->add('createdAt')
            ->add('updatedAt')
            ;
    }
    
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('description')
            ->add('enabled')
            ->add('createdAt')
            ;
    }
}
