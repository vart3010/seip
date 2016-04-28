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
use Pequiven\MasterBundle\Admin\BaseAdmin;

/**
 * Administrador de fallas
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class FailAdmin extends BaseAdmin
{
    protected function configureShowFields(\Sonata\AdminBundle\Show\ShowMapper $show) 
    {
        $show
            ->add("name")
            ->add("typeFail","choice",array(
                "choices" => \Pequiven\SEIPBundle\Model\CEI\Fail::getTypeFailsLabels(),
            ))
            ;
        parent::configureShowFields($show);
    }
    
    protected function configureFormFields(FormMapper $form) 
    {
        $form
            ->add("name")
            ->add("typeFail","choice",array(
                "empty_value" => "",
                "choices" => \Pequiven\SEIPBundle\Model\CEI\Fail::getTypeFailsLabels(),
                "translation_domain" => "PequivenSEIPBundle"
            ))
            ;
        parent::configureFormFields($form);
    }
    
    protected function configureDatagridFilters(DatagridMapper $filter) 
    {
        $filter
            ->add("name")
            ->add("typeFail",null,array(),"choice",array(
                "choices" => \Pequiven\SEIPBundle\Model\CEI\Fail::getTypeFailsLabels(),
                "translation_domain" => "PequivenSEIPBundle",
            ))
            ;
        parent::configureDatagridFilters($filter);
    }
    
    protected function configureListFields(ListMapper $list) 
    {
        $list
            ->addIdentifier("name")
            ->add("typeFail","choice",array(
                "choices" => \Pequiven\SEIPBundle\Model\CEI\Fail::getTypeFailsLabels(),
            ))
            ;
        parent::configureListFields($list);
    }
    
}
