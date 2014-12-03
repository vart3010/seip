<?php

namespace Pequiven\MasterBundle\Admin\Result;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Administrador de resultado
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
class ResultAdmin extends Admin
{
    protected function configureFormFields(FormMapper $form) {
        $form
            ->add('description')
            ->add('weight')
            ->add('typeResult','choice',array(
                'choices' => \Pequiven\SEIPBundle\Model\Result\Result::getTypeResults(),
                'translation_domain' => 'PequivenSEIPBundle'
            ))
            ->add('typeCalculation','choice',array(
                'choices' => \Pequiven\SEIPBundle\Model\Result\Result::getTypeCalculations(),
                'translation_domain' => 'PequivenSEIPBundle'
            ))
            ->add('objetives')
            ;
    }
    
    protected function configureDatagridFilters(DatagridMapper $filter) {
        $filter
            ->add('description')
            ->add('typeResult')
            ->add('typeCalculation')
            ;
    }
    
    protected function configureListFields(ListMapper $list) {
        $list
            ->addIdentifier('description')
            ->addIdentifier('typeResult')
            ->addIdentifier('typeCalculation')
            ;
    }
}
