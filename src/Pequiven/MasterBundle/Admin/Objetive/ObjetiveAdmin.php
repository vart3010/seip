<?php

namespace Pequiven\MasterBundle\Admin\Objetive;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Administrador del objetivo
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
class ObjetiveAdmin extends Admin
{
    protected function configureShowFields(\Sonata\AdminBundle\Show\ShowMapper $show)
    {
         $show
            ->add('description')
            ->add('ref')
            ->add('weight')
            ->add('goal')
            ->add('complejo')
            ->add('gerencia')
            ->add('gerenciaSecond')
            ->add('parents')
            ->add('indicators')
            ->add('period')
            ->add('evalObjetive')
            ->add('evalIndicator')
            ->add('evalArrangementProgram')
            ->add('evalSimpleAverage')
            ->add('evalWeightedAverage')
            ->add('enabled');
    }
    
    protected function configureFormFields(FormMapper $form) {
        $form
            ->add('description')
            ->add('ref')
            ->add('weight')
            ->add('goal')
            ->add('complejo')
            ->add('gerencia')
            ->add('gerenciaSecond')
            ->add('parents')
            ->add('indicators')
            ->add('period')
            ->add('evalObjetive',null,array(
                'required' => false,
            ))
            ->add('evalIndicator',null,array(
                'required' => false,
            ))
            ->add('evalArrangementProgram',null,array(
                'required' => false,
            ))
            ->add('evalSimpleAverage',null,array(
                'required' => false,
            ))
            ->add('evalWeightedAverage',null,array(
                'required' => false,
            ))
            ->add('enabled',null,array(
                'required' => false,
            ))
        ;
    }
    
    protected function configureDatagridFilters(DatagridMapper $filter) {
        $filter
            ->add('ref')
            ->add('description')
            ->add('weight')
            ->add('enabled')
            ;
    }
    
    protected function configureListFields(ListMapper $list) {
        $list
            ->addIdentifier('ref')
            ->add('description')
            ->add('weight')
            ->add('enabled')
            ;
    }
    
    protected function configureRoutes(\Sonata\AdminBundle\Route\RouteCollection $collection) 
    {
        $collection->remove('create');
    }
}
