<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com.ve
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\MasterBundle\Admin\CEI;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Pequiven\MasterBundle\Admin\BaseAdmin;

/**
 * Administrador de materia prima
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class RawMaterialAdmin extends BaseAdmin
{
    protected function configureShowFields(ShowMapper $show) 
    {
        $show
            ->add("product")
            ->add("type","choice",array(
                "choices" => \Pequiven\SEIPBundle\Model\CEI\RawMaterial::getTypeLabels(),
                "translation_domain" => "PequivenSEIPBundle"
            ))
            ;
        parent::configureShowFields($show);
    }
    
    protected function configureFormFields(FormMapper $form) 
    {
        $form
            ->add("product","sonata_type_model_autocomplete",array(
                'property' => array("name")
            ))
            ->add("type","choice",array(
                "empty_value" => "",
                "choices" => \Pequiven\SEIPBundle\Model\CEI\RawMaterial::getTypeLabels(),
                "translation_domain" => "PequivenSEIPBundle"
            ))
            ;
        parent::configureFormFields($form);
    }
    
    protected function configureDatagridFilters(DatagridMapper $filter) 
    {
        $filter
            ->add("product")
            ->add("type",null,array(),"choice",array(
                "choices" => \Pequiven\SEIPBundle\Model\CEI\RawMaterial::getTypeLabels(),
                "translation_domain" => "PequivenSEIPBundle"
            ))
            ;
        parent::configureDatagridFilters($filter);
    }
    
    protected function configureListFields(ListMapper $list) 
    {
        $list
            ->addIdentifier("id")
            ->add("product")
            ->add("type","choice",array(
                "choices" => \Pequiven\SEIPBundle\Model\CEI\RawMaterial::getTypeLabels(),
                "translation_domain" => "PequivenSEIPBundle"
            ))
            ;
        parent::configureListFields($list);
    }
}
