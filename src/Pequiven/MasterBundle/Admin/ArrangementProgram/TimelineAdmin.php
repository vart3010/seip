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
 * Administracion de la linea de tiempo
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class TimelineAdmin extends Admin
{
    protected function configureShowFields(\Sonata\AdminBundle\Show\ShowMapper $show) 
    {
        $show
            ->add('id')
            ->add('goals')
            ->add('arrangementProgram')
        ;
    }
    
    protected function configureFormFields(FormMapper $form) 
    {
         $form
            ->add('goals','sonata_type_model_autocomplete',array(
                'property' => 'name',
                'multiple' => true,
            ))
            ->add('arrangementProgram',null,array(
                'disabled' => true
            ))
        ;
    }
    
    protected function configureListFields(ListMapper $list) 
    {
        $list
            ->addIdentifier('id')
            ->add('arrangementProgram')
            ->add('goals')
        ;
    }
}
