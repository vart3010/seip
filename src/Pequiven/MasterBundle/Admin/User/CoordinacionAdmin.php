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
 * Administracion de Coordinaciones
 *
 * @author Gilbert <glavrjk@gmail.com>
 */
class CoordinacionAdmin extends Admin {

    protected function configureShowFields(\Sonata\AdminBundle\Show\ShowMapper $show) {
        $show
                ->add('id')
                ->add('description')
                ->add('sumary')
                ->add('gerenciasecond')
                ->add('enabled')
        ;
    }

    protected function configureFormFields(FormMapper $form) {
        $form
                ->add('description')
                ->add('sumary')
                ->add('gerenciasecond', 'sonata_type_model_autocomplete', array(
                    'property' => array('description'),
                    'multiple' => false,
                    "required" => true,
                    'attr' => array('class' => 'input input-large'),
                ))
                ->add('enabled', null, array(
                    'required' => false,
                ))
        ;
//                ->add('gerenciaSecond')
    }

    protected function configureDatagridFilters(DatagridMapper $filter) {
        $filter
                ->add('id')
                ->add('gerenciasecond', 'doctrine_orm_model_autocomplete', array(), null, array(
                    'property' => array('description'),
                    'multiple' => false,
                    "required" => false,
                    'attr' => array('class' => 'input input-large'),
                ))
                ->add('description')                
        ;
//                ->add('gerenciaSecond')
    }

    protected function configureListFields(ListMapper $list) {
        $list
                ->add('id')
                ->addIdentifier('description')
                ->add('gerenciasecond')
                ->add('enabled', null, array(
                    'editable' => true
                ))

        ;
    }

    public function toString($object) {
        $toString = '-';
        if ($object->getId() > 0) {
            $toString = $object->getDescription() . ' (' . $object->getGerenciasecond()->getDescription() . ')';
        }
        return \Pequiven\SEIPBundle\Service\ToolService::truncate($toString, array('limit' => 100));
    }

}
