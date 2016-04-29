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
 * Administrador de entidades
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class EntityAdmin extends BaseAdmin
{
    protected function configureShowFields(\Sonata\AdminBundle\Show\ShowMapper $show){
        $show
            ->add("id")
            ->add("location")
            ->add("name")
            ->add("alias")
            ->add("typeLocation")
            ->add('state')
            ;
        parent::configureShowFields($show);
    }
    
    protected function configureFormFields(FormMapper $form) 
    {
        $queryAllEnable = $this->getQueryAllEnable();
        $form
            ->add("location",null,array(
                "query_builder" => $queryAllEnable,
            ))
            ->add("name")
            ->add("alias")
            ->add("typeLocation")
            ->add('state')
            ;
        parent::configureFormFields($form);
    }
    
    protected function configureDatagridFilters(DatagridMapper $filter) 
    {
        $filter
            ->add("location")
            ->add("name")
            ->add("alias")
            ->add("typeLocation")
            ->add('state')
            ;
        parent::configureDatagridFilters($filter);
    }
    protected function configureListFields(ListMapper $list) 
    {
        $list
            ->addIdentifier("name")
            ->add("location")
            ->add("alias")
            ->add('canBeNetProductionGreaterThanGross', null, array('editable' => true, 'required' => false))
            ;
        parent::configureListFields($list);
    }
}
