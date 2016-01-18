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
 * Administracion de Cargos
 *
 * @author Gilbert <glavrjk@gmail.com>
 */
class FeeStructureAdmin extends Admin {

    protected function configureShowFields(\Sonata\AdminBundle\Show\ShowMapper $show) {
        $show
                ->add('id')
                ->add('gerencia')
                ->add('gerenciasecond')
                ->add('codigo')
                ->add('charge')
                ->add('User')
                ->add('staff')
        ;
    }

    protected function configureFormFields(FormMapper $form) {
        $form
                ->add('complejo', 'sonata_type_model_autocomplete', array(
                    'property' => array('description'),
                    'multiple' => false,
                    "required" => true,
                    'attr' => array('class' => 'input input-large'),
                ))
                ->add('gerencia', 'sonata_type_model_autocomplete', array(
                    'property' => array('description'),
                    'multiple' => false,
                    "required" => true,
                    'attr' => array('class' => 'input input-large'),
                ))
                ->add('gerenciasecond', 'sonata_type_model_autocomplete', array(
                    'property' => array('description'),
                    'multiple' => false,
                    "required" => false,
                    'attr' => array('class' => 'input input-large'),
                ))
                ->add('coordinacion', 'sonata_type_model_autocomplete', array(
                    'property' => array('description'),
                    'multiple' => false,
                    "required" => false,
                    'attr' => array('class' => 'input input-large'),
                ))
                ->add('parent', 'sonata_type_model_autocomplete', array(
                    'class' => 'Pequiven\SEIPBundle\Entity\User\FeeStructure',
                    'property' => array('charge'),
                    'multiple' => false,
                    "required" => false,
                    'attr' => array('class' => 'input input-large'),
                ))
                ->add('codigo')
                ->add('charge')
                ->add('User', 'sonata_type_model_autocomplete', array(
                    'property' => array('firstname'),
                    'multiple' => false,
                    'required' => false,
                ))
                ->add('staff', null, array(
                    'required' => false,
                ))
                ->add('enabled', null, array(
                    "required" => false,
                ))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter) {
        $filter
                ->add('id')
                ->add('gerencia', 'doctrine_orm_model_autocomplete', array(), null, array(
                    'property' => array('description'),
                    'multiple' => false,
                    "required" => false,
                    'attr' => array('class' => 'input input-large'),
                ))
                ->add('gerenciasecond', 'doctrine_orm_model_autocomplete', array(), null, array(
                    'property' => array('description'),
                    'multiple' => false,
                    "required" => false,
                    'attr' => array('class' => 'input input-large'),
                ))
                ->add('charge')
        ;
    }

    protected function configureListFields(ListMapper $list) {
        $list
                ->add('id')
                ->addIdentifier('charge')
                ->add('User')
                ->add('enabled', null, array(
                    'editable' => true
                ))
                ->add('gerencia')
                ->add('gerenciasecond')
        ;
    }

    public function toString($object) {
        $toString = '-';
        if ($object->getId() > 0) {
            $toString = $object->getCharge();
        }
        return \Pequiven\SEIPBundle\Service\ToolService::truncate($toString, array('limit' => 100));
    }

}
