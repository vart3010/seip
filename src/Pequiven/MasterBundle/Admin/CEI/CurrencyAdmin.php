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
use Pequiven\MasterBundle\Admin\BaseAdmin;

/**
 * Administrador de moneda
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class CurrencyAdmin extends BaseAdmin
{
    protected function configureShowFields(\Sonata\AdminBundle\Show\ShowMapper $show) 
    {
        $show
            ->add('id')
            ->add('name')
            ->add('code')
            ;
        parent::configureShowFields($show);
    }
    
    protected function configureFormFields(FormMapper $form) 
    {
        $form
            ->add('name')
            ->add('code')
            ;
        parent::configureFormFields($form);
    }
    
    protected function configureDatagridFilters(DatagridMapper $filter) 
    {
        $filter
            ->add('name')
            ->add('code')
            ;
        parent::configureDatagridFilters($filter);
    }
    
    protected function configureListFields(ListMapper $list) 
    {
        $list
            ->addIdentifier('name')
            ->add('code')
            ;
        parent::configureListFields($list);
    }
}
