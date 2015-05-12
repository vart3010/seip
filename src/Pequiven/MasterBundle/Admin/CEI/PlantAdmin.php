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
 * Administrador de planta
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class PlantAdmin extends BaseAdmin
{
    protected function configureShowFields(\Sonata\AdminBundle\Show\ShowMapper $show) 
    {
        $show
            ->add('id')
            ->add('name')
            ->add('alias')
            ->add('designCapacity')
            ->add('unitMeasure')
            ->add('location')
            ->add('products')
            ->add('services')
            ;
        parent::configureShowFields($show);
    }
    
    protected function configureFormFields(FormMapper $form) 
    {
        $form
            ->add('name')
            ->add('alias')
            ->add('designCapacity')
            ->add('unitMeasure')
            ->add('location')
            ->add('products',"sonata_type_model_autocomplete",array(
                'property' => 'name',
                'multiple' => true,
                'required' => false,
                "callback" => function (ProductAdmin $admin, $property, $value){
                    $datagrid = $admin->getDatagrid();
                    $qb = $datagrid->getQuery();
                    $alias = $qb->getRootAlias();
                    $qb
                        ->andWhere($alias.'.enabled = :enabled')
                        ->setParameter('enabled',true)
                    ;
                }
            ))
            ->add('services',"sonata_type_model_autocomplete",array(
                'property' => 'name',
                'multiple' => true,
                'required' => false,
                "callback" => function (ServiceAdmin $admin, $property, $value){
                    $datagrid = $admin->getDatagrid();
                    $qb = $datagrid->getQuery();
                    $alias = $qb->getRootAlias();
                    $qb
                        ->andWhere($alias.'.enabled = :enabled')
                        ->setParameter('enabled',true)
                    ;
                }
            ))
            ;
        parent::configureFormFields($form);
    }
    
    protected function configureDatagridFilters(DatagridMapper $filter) 
    {
        $filter
            ->add('name')
            ->add('alias')
            ->add('designCapacity')
            ->add('unitMeasure')
            ->add('location')
            ;
        parent::configureDatagridFilters($filter);
    }
    
    protected function configureListFields(ListMapper $list) 
    {
        $list
            ->addIdentifier('name')
            ->add('alias')
            ->add('designCapacity')
            ->add('location')
            ;
        parent::configureListFields($list);
    }
}
