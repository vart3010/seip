<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\MasterBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Base para administradores
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
abstract class BaseAdmin extends Admin {

    protected function configureShowFields(\Sonata\AdminBundle\Show\ShowMapper $show) {
        $show
                ->add('enabled')
                ->add('createdAt')
                ->add('updatedAt')
        ;
    }

    protected function configureFormFields(FormMapper $form) {
        $form
                ->add('enabled', null, array(
                    "required" => false,
                ))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter) {
        $filter
                ->add('enabled')
        ;
    }

    protected function configureListFields(ListMapper $list) {
        $list
                ->add('enabled', null, array('editable' => true))
        ;
    }

    protected function getQueryAllEnable() {
        $queryBuilderEnable = function (\Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository $repository) {
            return $repository->getQueryAllEnabled();
        };
        return $queryBuilderEnable;
    }

}
