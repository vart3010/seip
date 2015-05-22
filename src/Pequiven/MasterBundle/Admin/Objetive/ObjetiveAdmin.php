<?php

namespace Pequiven\MasterBundle\Admin\Objetive;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Administrador del objetivo
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
class ObjetiveAdmin extends Admin
{
    protected function configureShowFields(\Sonata\AdminBundle\Show\ShowMapper $show)
    {
         $show
            ->add('description')
            ->add('ref')
            ->add('weight')
            ->add('goal')
            ->add('complejo')
            ->add('gerencia')
            ->add('gerenciaSecond')
            ->add('parents')
            ->add('indicators')
            ->add('objetiveLevel')
            ->add('period')
            ->add('evalObjetive')
            ->add('evalIndicator')
            ->add('evalArrangementProgram')
            ->add('evalSimpleAverage')
            ->add('evalWeightedAverage')
            ->add('requiredToImport')
            ->add('enabled')
             ;
    }
    
    protected function configureFormFields(FormMapper $form) {
        $form
            ->tab('General')
                    ->add('description')
                    ->add('ref')
                    ->add('weight')
                    ->add('goal')
                    ->add('complejo')
                    ->add('gerencia')
                    ->add('gerenciaSecond')
                    ->add('childrens','sonata_type_model_autocomplete',array(
                        'property' => array('period','ref'),
                        'multiple' => true,
                        'required' => false,
                    ))
                    ->add('indicators','sonata_type_model_autocomplete',array(
                        'property' => array('ref','description'),
                        'multiple' => true,
                        'required' => false,
                    ))
                    ->add('objetiveLevel')
                    ->add('period')
                ->end()
            ->end()
            ->tab('Details')
                    ->add('managementSystems','sonata_type_model_autocomplete',array(
                        'property' => array('description'),
                        'multiple' => true,
                        'required' => false,
                    ))
                    ->add('evalObjetive',null,array(
                        'required' => false,
                    ))
                    ->add('evalIndicator',null,array(
                        'required' => false,
                    ))
                    ->add('evalArrangementProgram',null,array(
                        'required' => false,
                    ))
                    ->add('evalSimpleAverage',null,array(
                        'required' => false,
                    ))
                    ->add('evalWeightedAverage',null,array(
                        'required' => false,
                    ))
                    ->add('requiredToImport',null,array(
                        'required' => false,
                    ))
                    ->add('enabled',null,array(
                        'required' => false,
                    ))
                    ->add('status',null,array(
                        'required' => false,
                    ))
                ->end()
            ->end()
        ;
    }
    
    protected function configureDatagridFilters(DatagridMapper $filter) {
        $filter
            ->add('ref')
            ->add('description')
            ->add('weight')
            ->add('requiredToImport')
            ->add('period')
            ->add('enabled')
            ->add('status')
            ;
    }
    
    protected function configureListFields(ListMapper $list) {
        $list
            ->addIdentifier('ref')
            ->add('description')
            ->add('weight')
            ->add('status')
            ;
    }
    
    protected function configureRoutes(\Sonata\AdminBundle\Route\RouteCollection $collection) 
    {
        $collection->remove('create');
    }
    
    public function toString($object) 
    {
        $toString = '-';
        if($object->getId() > 0){
            $toString = $object->getPeriod()->getDescription().' - '.$object->getRef().' - '.$object->getDescription();
        }
        return \Pequiven\SEIPBundle\Service\ToolService::truncate($toString,array('limit' => 50));
    }
}
