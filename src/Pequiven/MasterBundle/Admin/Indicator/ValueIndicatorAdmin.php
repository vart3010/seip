<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\MasterBundle\Admin\Indicator;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Administrador del valor del indicador
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class ValueIndicatorAdmin extends Admin
{
    protected function configureShowFields(\Sonata\AdminBundle\Show\ShowMapper $show) {
        $show
            ->add('id')
            ->add('valueOfIndicator')
            ->add('indicator')
            ->add('formula')
            ->add('formulaParameters')
            ->add('createdAt')
            ->add('createdBy')
            ;
    }
    
    protected function configureFormFields(FormMapper $form) {
        $form
//            ->add('indicator')
            ->add('formula')
            ->add('formulaParameters')
            ;
    }
    
    protected function configureDatagridFilters(DatagridMapper $filter) {
        $filter
            ->add('indicator')
            ->add('formula')
            ;
    }
    
    protected function configureListFields(ListMapper $list) {
         $list
            ->addIdentifier('id')
            ->add('valueOfIndicator')
            ->add('indicator')
            ;
    }
    
    protected function configureRoutes(\Sonata\AdminBundle\Route\RouteCollection $collection) 
    {
        $collection->remove('create');
    }
}
