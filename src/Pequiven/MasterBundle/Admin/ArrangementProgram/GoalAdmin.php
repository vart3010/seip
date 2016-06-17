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
 * Administrador de las metas
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class GoalAdmin extends Admin
{
    protected function configureShowFields(\Sonata\AdminBundle\Show\ShowMapper $show)
    {
        $show
            ->add('name')
            ->add('startDate')
            ->add('endDate')
            ->add('weight')
            ->add('goalDetails')
            ->add('observations')
            ->add('responsibles')
                ;
        if ($this->isGranted('ROLE_SEIP_UPDATE_RESULT_OBJECTS')){
            $show
                ->add('updateResultByAdmin')
                ->add('resultModified')
                    ;
        }
    }
    
    protected function configureFormFields(FormMapper $form) 
    {
        $object = $this->getSubject();
        $form
            ->add('name')
            ->add('startDate','sonata_type_date_picker',array())
            ->add('endDate','sonata_type_date_picker',array())
            ->add('weight')
            ->add('responsibles','sonata_type_model_autocomplete',array(
                'property' => 'username',
                'multiple' => true,
            ))
            ->add('observations')
            ;
        if ($this->isGranted('ROLE_SEIP_UPDATE_RESULT_OBJECTS')){
            $form->add('updateResultByAdmin', null, array(
                'required' => false,
            ));
            if ($object != null && $object->getId() !== null) {
                if ($object->getUpdateResultByAdmin()) {
                    $form->add('resultModified');
                }
            }
        }
    }
    
    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('name')
            ->add('startDate')
            ->add('endDate')
            ->add('weight')
            ->add("period")
                ;
        if ($this->isGranted('ROLE_SEIP_UPDATE_RESULT_OBJECTS')){
            $filter->add('updateResultByAdmin');
        }
    }
    
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('name')
            ->add('startDate')
            ->add('endDate')
            ->add('weight')
                ;
        if ($this->isGranted('ROLE_SEIP_UPDATE_RESULT_OBJECTS')){
            $list->add('updateResultByAdmin',null, array('editable' => true));
        }
    }
    
    protected function configureRoutes(\Sonata\AdminBundle\Route\RouteCollection $collection) {
        $collection->remove('create');
    }
}
