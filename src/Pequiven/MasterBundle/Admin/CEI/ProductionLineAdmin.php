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

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Pequiven\MasterBundle\Admin\BaseAdmin;

/**
 * Administrador de linea de producto
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class ProductionLineAdmin extends BaseAdmin
{
    protected function configureShowFields(ShowMapper $show) 
    {
        $show
            ->add('id')
            ->add('name')
            ;
        parent::configureShowFields($show);
    }
    
    protected function configureFormFields(FormMapper $form) 
    {
        $form
            ->add('name')
            ;
        parent::configureFormFields($form);
    }
    
    protected function configureDatagridFilters(DatagridMapper $filter) 
    {
        $filter
            ->add('name')
            ;
        parent::configureDatagridFilters($filter);
    }
    
    protected function configureListFields(ListMapper $list) 
    {
        $list
            ->addIdentifier('name')
            ;
        parent::configureListFields($list);
    }
}
