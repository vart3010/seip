<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\MasterBundle\Admin\ArrangementProgram;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Administrador del programa de gestion
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class ArrangementProgramAdmin extends Admin
{
    protected function configureShowFields(\Sonata\AdminBundle\Show\ShowMapper $show)
    {
        $show
            ->add('ref')
            ->add('period')
            ->add('tacticalObjective')
            ->add('operationalObjective')
            ->add('description')
            ->add('timeline')
            ->add('isAvailableInResult')
            ;
    }
    
    protected function configureFormFields(FormMapper $form) 
    {
        $form
            ->add('ref')
            ->add('period')
            ->add('tacticalObjective')
            ->add('operationalObjective',null,array(
                'required' => false,
            ))
            ->add('description')
            ->add('isAvailableInResult')
            ;
    }
    
    protected function configureDatagridFilters(DatagridMapper $filter) {
        $filter
            ->add('ref')
            ->add('period')
            ->add('tacticalObjective')
            ->add('operationalObjective')
            ->add('description')
            ->add('isAvailableInResult')
            ;
    }
    
    protected function configureListFields(ListMapper $list) {
        $list
            ->addIdentifier('ref')
            ->add('period')
            ->add('description')
            ;
    }
}
