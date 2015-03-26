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

use Pequiven\MasterBundle\Admin\BaseAdmin;
use Pequiven\SEIPBundle\Entity\CEI\Product;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Administrador de producto
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class ProductAdmin extends BaseAdmin
{
    protected function configureShowFields(ShowMapper $show) 
    {
        $show
            ->add('id')
            ->add('name')
            ->add('components')
            ->add('typeOf','choice',array(
                'choices' => Product::getTypesLabel(),
                'translation_domain' => 'PequivenSEIPBundle'
            ))
            ;
        parent::configureShowFields($show);
    }
    
    protected function configureFormFields(FormMapper $form) 
    {
        $form
            ->add('name')
            ->add('components','sonata_type_model_autocomplete',array(
                'property' => 'name',
                'multiple' => true,
                'required' => false,
                'callback' => function (ProductAdmin $admin, $property, $value){
                    $datagrid = $admin->getDatagrid();
                    $qb = $datagrid->getQuery();
                    $alias = $qb->getRootAlias();
                    $qb
                        ->andWhere($alias.'.enabled = :enabled')
                        ->setParameter('enabled', true)
                        ->andWhere($alias.'.typeOf = :typeOf')
                        ->andWhere($qb->expr()->like($alias.'.name',"'%".$value."%'"))
                        ->setParameter('typeOf', Product::TYPE_PRODUCT)
                        ;
                },
            ))
            ->add('typeOf','choice',array(
                'choices' => Product::getTypesLabel(),
                'translation_domain' => 'PequivenSEIPBundle'
            ))
            ;
        parent::configureFormFields($form);
    }
    
    protected function configureDatagridFilters(DatagridMapper $filter) 
    {
        $filter
            ->add('name')
            ->add('typeOf',null,array(),'choice',array(
                'choices' => Product::getTypesLabel(),
                'translation_domain' => 'PequivenSEIPBundle'
            ))
            ;
        parent::configureDatagridFilters($filter);
    }
    
    protected function configureListFields(ListMapper $list) 
    {
        $list
            ->addIdentifier('name')
            ->add('typeOf')
            ;
        parent::configureListFields($list);
    }
}
