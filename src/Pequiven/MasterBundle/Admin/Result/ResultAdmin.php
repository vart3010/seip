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
            ->add('objetive')
            ->add('parent','entity',array(
                'class' => 'Pequiven\SEIPBundle\Entity\Result\Result',
                'query_builder' => function(\Pequiven\SEIPBundle\Repository\Result\ResultRepository $repository){
                    return $repository->getQueryOfValidParents();
                },
                'required' => false,
            ))
            ;
    }
    
    protected function configureDatagridFilters(DatagridMapper $filter) {
        $filter
            ->add('description')
            ->add('typeResult')
            ->add('typeCalculation')
            ->add('objetive')
            ;
    }
    
    protected function configureListFields(ListMapper $list) {
        $list
            ->addIdentifier('description')
            ->add('typeResult')
            ->add('typeCalculation')
            ->add('objetive')
            ;
    }
    
    public function prePersist($object) 
    {
        $parent = $object->getParent();
        if($parent != null){
            $object->setObjetive(null);
        }
    }
    
    public function preUpdate($object) {
        $parent = $object->getParent();
        if($parent != null){
            $object->setObjetive(null);
        }
    }
}