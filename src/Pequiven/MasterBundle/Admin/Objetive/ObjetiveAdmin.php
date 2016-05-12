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
            ->add('status','choice',array(
                'choices' => \Pequiven\ObjetiveBundle\Entity\Objetive::getLabelsStatus(),
                'translation_domain' => 'PequivenObjetiveBundle'
            ))
             ;
         
         if ($this->isGranted('ROLE_SEIP_UPDATE_RESULT_OBJECTS')){
            $show
                ->add('updateResultByAdmin')
                ->add('resultModified')
                    ;
        }
    }
    
    protected function configureFormFields(FormMapper $form) {
        $object = $this->getSubject();
        $form
            ->tab('General')
                    ->add('description')
                    ->add('ref')
                    ->add('weight')
                    ->add('goal')
                    ->add('complejo')
                    ->add('gerencia')
                    ->add('gerenciaSecond','sonata_type_model_autocomplete',array(
                        'property' => array('description'),
                        'required' => false,
                    ))
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
                    ->add('status','choice',array(
                        'choices' => \Pequiven\ObjetiveBundle\Entity\Objetive::getLabelsStatus(),
                        'translation_domain' => 'PequivenObjetiveBundle'
                    ))
                ->end()
                    ->with('SIG')
                    ->add('managementSystems','sonata_type_model_autocomplete',array(
                        'property' => array('description'),
                        'multiple' => true,
                        'required' => false,
                    ))
                    ->add('processManagementSystem','sonata_type_model_autocomplete',array(
                        'property' => array('description'),
                        'multiple' => true,
                        'required' => false,
                    ))
                    ->add('showEvolutionView',null,array(                        
                        'required' => false,
                    ))
                    ->end()
            ->end()
        ;
        if ($this->isGranted('ROLE_SEIP_UPDATE_RESULT_OBJECTS')){
            $form
                ->tab('Details')
                    ->add('updateResultByAdmin', null, array(
                'required' => false,
            ))
                    ->end()
                ->end()
            ;
            if ($object != null && $object->getId() !== null) {
                if ($object->getUpdateResultByAdmin()) {
                    $form
                        ->tab('Details')
                            ->add('resultModified')
                            ->end()
                        ->end()
                    ;
                }
            }
        }
    }
    
    protected function configureDatagridFilters(DatagridMapper $filter) {
        $filter
            ->add('ref')
            ->add('description')
            ->add('weight')
            ->add('requiredToImport')
            ->add('period')
            ->add('enabled')
            ->add('status',null,array(),'choice',array(
                'choices' => \Pequiven\ObjetiveBundle\Entity\Objetive::getLabelsStatus(),
                'translation_domain' => 'PequivenObjetiveBundle'
            ))
            ;
        if ($this->isGranted('ROLE_SEIP_UPDATE_RESULT_OBJECTS')){
            $filter->add('updateResultByAdmin');
        }
    }
    
    protected function configureListFields(ListMapper $list) {
        $list
            ->addIdentifier('ref')
            ->add('description')
            ->add('weight')
            ->add('status')
            ;
        if ($this->isGranted('ROLE_SEIP_UPDATE_RESULT_OBJECTS')){
            $list->add('updateResultByAdmin',null, array('editable' => true));
        }
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
