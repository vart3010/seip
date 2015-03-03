<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\MasterBundle\Admin\CEI;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Administrador de compañia (Control estadistico e informacion)
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class CompanyAdmin extends Admin
{
    protected function configureShowFields(\Sonata\AdminBundle\Show\ShowMapper $show) 
    {
        $show
            ->add('id')
            ->add('rif')
            ->add('description')
            ->add('enabled')
            ->add('createdAt')
            ->add('updatedAt')
            ;
    }
    
    protected function configureFormFields(FormMapper $form) 
    {
        $form
            ->add('rif')
            ->add('description')
            ->add('enabled')
            ;
    }
    
    protected function configureDatagridFilters(DatagridMapper $filter) 
    {
        $filter
            ->add('rif')
            ->add('description')
            ->add('enabled')
            ;
    }
    
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->add('rif')
            ->add('description')
            ->add('enabled')
            ;
    }
}
