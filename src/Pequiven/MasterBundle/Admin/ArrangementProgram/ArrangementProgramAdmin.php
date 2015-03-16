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
            ->add('couldBePenalized')
            ->add('forcePenalize')
            ;
    }
    
    protected function configureFormFields(FormMapper $form) 
    {
        $form
            ->add('ref')
            ->add('period')
            ->add('tacticalObjective','sonata_type_model_autocomplete',array(
                'property' => array('ref','description')
            ))
            ->add('operationalObjective','sonata_type_model_autocomplete',array(
                'required' => false,
                'property' => array('ref','description')
            ))
            ->add('description')
            ->add('isAvailableInResult',null,array(
                'required' => false,
            ))
            ->add('couldBePenalized',null,array(
                'required' => false,
            ))
            ->add('forcePenalize',null,array(
                'required' => false,
            ))
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
            ->add('couldBePenalized')
            ->add('forcePenalize')
            ;
    }
    
    protected function configureListFields(ListMapper $list) {
        $list
            ->addIdentifier('ref')
            ->add('period')
            ->add('description')
            ;
    }
    
    protected function configureRoutes(\Sonata\AdminBundle\Route\RouteCollection $collection) {
        $collection->remove('create');
    }
    
    public function prePersist($object) {
        if($object->isCouldBePenalized() === false){
            $object->setForcePenalize(false);
        }
    }
    
    public function preUpdate($object) {
        if($object->isCouldBePenalized() === false){
            $object->setForcePenalize(false);
        }
    }
}
