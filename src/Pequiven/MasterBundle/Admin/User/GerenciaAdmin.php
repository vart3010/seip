<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\MasterBundle\Admin\User;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Administrador de gerencia
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class GerenciaAdmin extends Admin
{
    protected function configureShowFields(\Sonata\AdminBundle\Show\ShowMapper $show) {
        $show
            ->add('id')
            ->add('ref')
            ->add('abbreviation')
            ->add('description')
            ->add('complejo')
            ->add('createdAt')
            ->add('tacticalObjectives')
            ->add('gerenciaSecondVinculants')
            ->add('gerenciaSecondSupports')
            ->add('gerenciaGroup')
            ->add('validAudit')
            ->add('enabled')
            ->add('normalizedManagement')
            ;
    }
    
    protected function configureFormFields(FormMapper $form) 
    {
        $form
            ->add('ref')
            ->add('abbreviation')
            ->add('description')
            ->add('complejo','sonata_type_model_autocomplete',array(
                'property' => array('description')
            ))
            ->add('tacticalObjectives','sonata_type_model_autocomplete',array(
                'required' => false,
                'property' => array('ref','description'),
                'multiple' => true,
            ))
            ->add('gerenciaSecondVinculants','sonata_type_model_autocomplete',array(
                'property' => array('ref','description'),
                'multiple' => true,
                'required' => false,
            ))
            ->add('gerenciaSecondSupports','sonata_type_model_autocomplete',array(
                'property' => array('ref','description'),
                'multiple' => true,
                'required' => false,
            ))
            ->add('gerenciaGroup','sonata_type_model_autocomplete',array(
                'property' => array('description'),
                'required' => false,
            ))
            ->add('validAudit',null,array(
                'required' => false,
            ))
            ->add('enabled',null,array(
                'required' => false,
            ))
            ->add('normalizedManagement',null,array(
                'required' => false,
            ))
            ;
    }
    protected function configureDatagridFilters(DatagridMapper $filter) {
        $filter
            ->add('id')
            ->add('ref')
            ->add('abbreviation')
            ->add('description')
            ->add('complejo')
            ->add('gerenciaGroup')
            ->add('validAudit')
            ->add('enabled')
            ->add('normalizedManagement')
            ;
    }
    protected function configureListFields(ListMapper $list) {
        $list
            ->addIdentifier('ref')
            ->add('abbreviation')
            ->add('description')
            ->add('complejo')
            ->add('gerenciaGroup')
        ;
    }
    
}
