<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\MasterBundle\Admin\QualitySystem;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Administrador de los sistemas de calidad
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class QualitySystemAdmin extends Admin
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
            ->add('description')
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
