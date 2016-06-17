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
class PlantAdmin extends BaseAdmin {

    private $container;

    protected function configureShowFields(\Sonata\AdminBundle\Show\ShowMapper $show) {
        $show
                ->add('id')
                ->add('name')
                ->add('alias')
                ->add('designCapacity')
                ->add('unitMeasure')
                ->add('entity')
                ->add('products')
                ->add('services')
        ;
        parent::configureShowFields($show);
    }

    protected function configureFormFields(FormMapper $form) {
        $queryAllEnable = $this->getQueryAllEnable();

        $childrensParameters = array(
            'class' => 'Pequiven\SEIPBundle\Entity\CEI\Plant',
            'multiple' => true,
            'required' => false,
            "property" => array("name"),
        );

        $form
                ->add('name')
                ->add('alias')
                ->add('designCapacity')
                ->add('unitMeasure')
                ->add('entity', null, array(
                    "query_builder" => $queryAllEnable,
                ))
                ->add('products', "sonata_type_model_autocomplete", array(
                    'property' => 'name',
                    'multiple' => true,
                    'required' => false,
                    "callback" => function (ProductAdmin $admin, $property, $value) {
                        $datagrid = $admin->getDatagrid();
                        $qb = $datagrid->getQuery();
                        $alias = $qb->getRootAlias();
                        $qb
                        ->andWhere($alias . '.enabled = :enabled')
                        ->setParameter('enabled', true)
                        ->andWhere($qb->expr()->like($alias . ".name", $qb->expr()->literal("%" . $value . "%")))
                        ;
                    }
                ))
                ->add('childrens', 'sonata_type_model_autocomplete', $childrensParameters)
                ->add('services', "sonata_type_model_autocomplete", array(
                    'property' => 'name',
                    'multiple' => true,
                    'required' => false,
                    "callback" => function (ServiceAdmin $admin, $property, $value) {
                        $datagrid = $admin->getDatagrid();
                        $qb = $datagrid->getQuery();
                        $alias = $qb->getRootAlias();
                        $qb
                        ->andWhere($alias . '.enabled = :enabled')
                        ->setParameter('enabled', true)
                        ;
                    }
                ))
                ->add('permitGroupProduct',null, array(
                    'required' => false,
                ))
        ;
        parent::configureFormFields($form);
    }

    protected function configureDatagridFilters(DatagridMapper $filter) {
        $filter
                ->add('name')
                ->add('alias')
                ->add('designCapacity')
                ->add('unitMeasure')
                ->add('entity')
        ;
        parent::configureDatagridFilters($filter);
    }

    protected function configureListFields(ListMapper $list) {
        $list
                ->addIdentifier('name')
                ->add('alias')
                ->add('designCapacity')
                ->add('entity')
        ;
        parent::configureListFields($list);
    }

    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
        $this->container = $container;
    }

}
