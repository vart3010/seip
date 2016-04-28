<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\MasterBundle\Admin\DataLoad;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Pequiven\SEIPBundle\Model\DataLoad\ReportTemplate;

/**
 * Administrador de plantillas de reportes
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class ReportTemplateAdmin extends \Pequiven\MasterBundle\Admin\BaseAdmin
{
    protected function configureShowFields(\Sonata\AdminBundle\Show\ShowMapper $show) {
        $show
            ->add("description")
            ->add("location")
            ->add("typeReport","choice",array(
                "choices" => ReportTemplate::getReportTemplateTypesLabel(),
                "translation_domain" => "PequivenSEIPBundle"
            ))
            ->add("products")
            ;
        parent::configureShowFields($show);
    }
    
    protected function configureFormFields(FormMapper $form) 
    {
        $form
            ->add("description")
            ->add("location")
            ->add("typeReport","choice",array(
                "choices" => ReportTemplate::getReportTemplateTypesLabel(),
                "translation_domain" => "PequivenSEIPBundle"
            ))
            ->add("products","sonata_type_model_autocomplete",array(
                'property' => array("name"),
                "multiple" => true,
            ))
            ;
        parent::configureFormFields($form);
    }
    
    protected function configureDatagridFilters(DatagridMapper $filter) 
    {
        $filter
            ->add("location")
            ->add("typeReport",null,array(),"choice",array(
                "choices" => ReportTemplate::getReportTemplateTypesLabel(),
                "translation_domain" => "PequivenSEIPBundle"
            ))
            ;
        parent::configureDatagridFilters($filter);
    }
    protected function configureListFields(ListMapper $list) 
    {
        $list
            ->add("location")
            ->add("typeReport","choice",array(
                "choices" => ReportTemplate::getReportTemplateTypesLabel(),
                "translation_domain" => "PequivenSEIPBundle"
            ))
            ;
        parent::configureListFields($list);
    }
    
}
