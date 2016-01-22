<?php

namespace Pequiven\MasterBundle\Admin\Sip;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Administrador de los Materiales para los centros por CUTL
 *
 */
class SipMaterialAdmin extends Admin
{
    protected function configureShowFields(\Sonata\AdminBundle\Show\ShowMapper $show) 
    {
        $show
            ->add('id')
            ->add('description')
            ->add('enabled')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('deletedAt')
            ;
    }
    
    protected function configureFormFields(FormMapper $form) 
    {
        $form
            ->tab('General')
                    ->add('description')
                    ->add('enabled',null,array(
                        'required' => false,
                    ))
                ->end()
            ->end()            
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
