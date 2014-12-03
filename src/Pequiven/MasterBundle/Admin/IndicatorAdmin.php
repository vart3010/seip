<?php

namespace Pequiven\MasterBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Administrador del admin
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
class IndicatorAdmin extends Admin
{
    protected function configureFormFields(FormMapper $form) {
        $object = $this->getSubject();
        $childrensParameters = array(
            'class' => 'Pequiven\IndicatorBundle\Entity\Indicator',
            'multiple' => true,
            'required' => false,
        );
        if($object != null && $object->getId() !== null){
            $indicatorLevel = $object->getIndicatorLevel();
            $level = $indicatorLevel->getLevel();
            $childrensParameters['query_builder'] = function(\Pequiven\IndicatorBundle\Repository\IndicatorRepository $repository) use ($level){
                return $repository->getQueryChildrenLevel($level);
            };
           
        }
        
        $form
            ->add('ref')
            ->add('description')
            ->add('typeOfCalculation','choice',array(
                'choices' => \Pequiven\IndicatorBundle\Entity\Indicator::getTypesOfCalculation(),
                'translation_domain' => 'PequivenIndicatorBundle'
            ))
            ->add('totalPlan')
            ->add('weight')
            ->add('goal')
            ->add('formula')
            ->add('tendency')
            ->add('frequencyNotificationIndicator')
            ->add('valueFinal')
            ->add('childrens','entity',$childrensParameters)
            ->add('enabled')
            ;
    }
    
    protected function configureDatagridFilters(DatagridMapper $filter) {
        $filter
            ->add('ref')
            ->add('description')
            ->add('typeOfCalculation',null,array(),'choice',array(
                'choices' => \Pequiven\IndicatorBundle\Entity\Indicator::getTypesOfCalculation(),
                'translation_domain' => 'PequivenIndicatorBundle'
            ))
            ->add('tendency')
            ->add('frequencyNotificationIndicator')
            ->add('valueFinal')
            ->add('enabled')
            ;
    }
    
    protected function configureListFields(ListMapper $list) {
        $list
            ->addIdentifier('ref')
            ->add('description')
            ->add('formula')
            ->add('frequencyNotificationIndicator')
            ->add('valueFinal')
            ->add('enabled')
            ;
    }
}
