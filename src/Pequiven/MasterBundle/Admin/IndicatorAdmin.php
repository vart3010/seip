<?php

namespace Pequiven\MasterBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Pequiven\IndicatorBundle\Entity\IndicatorLevel;

/**
 * Administrador del Indicador
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
class IndicatorAdmin extends Admin implements \Symfony\Component\DependencyInjection\ContainerAwareInterface
{   
    private $container;
    
    protected function configureShowFields(\Sonata\AdminBundle\Show\ShowMapper $show) {
        $show
            ->add('ref')
            ->add('description')
            ->add('typeOfCalculation','choice',array(
                'choices' => \Pequiven\IndicatorBundle\Entity\Indicator::getTypesOfCalculation(),
                'translation_domain' => 'PequivenIndicatorBundle'
            ))
            ->add('refParent')
            ->add('totalPlan')
            ->add('weight')
            ->add('goal')
            ->add('formula')
            ->add('tendency')
            ->add('arrangementRange')
            ->add('frequencyNotificationIndicator')
            ->add('valueFinal')
            ->add('childrens')
            ->add('valuesIndicator')
            ->add('couldBePenalized')
            ->add('forcePenalize')
            ->add('requiredToImport')
            ;
    }
    
    protected function configureFormFields(FormMapper $form) {
        $object = $this->getSubject();
        $childrensParameters = array(
            'class' => 'Pequiven\IndicatorBundle\Entity\Indicator',
            'multiple' => true,
            'required' => false,
        );
        $id = null;
        if($object != null && $object->getId() !== null){
            $indicatorLevel = $object->getIndicatorLevel();
            $level = $indicatorLevel->getLevel();
            $childrensParameters['query_builder'] = function(\Pequiven\IndicatorBundle\Repository\IndicatorRepository $repository) use ($level){
                return $repository->getQueryChildrenLevel($level);
            };
            $id = $object->getId();
        }
        
        if($object != null && $object->getId() !== null){
            if($object->getIndicatorLevel()->getLevel() == IndicatorLevel::LEVEL_ESTRATEGICO){
                $form->add('lineStrategics');
            }
        }
        
        $form
            ->add('ref')
            ->add('description')
            ->add('lineStrategics')
            ->add('typeOfCalculation','choice',array(
                'choices' => \Pequiven\IndicatorBundle\Entity\Indicator::getTypesOfCalculation(),
                'translation_domain' => 'PequivenIndicatorBundle'
            ))
            ->add('refParent')
            ->add('totalPlan')
            ->add('weight')
            ->add('goal')
            ->add('formula')
            ->add('tendency')
            ->add('frequencyNotificationIndicator')
            ->add('valueFinal')
            ->add('childrens','entity',$childrensParameters)
            ->add('formulaDetails','sonata_type_collection',
                array(
                     'cascade_validation' => true,
                ),
                array(
//                    'edit'   => 'inline',
//                    'inline' => 'table',
                    'link_parameters' => array('indicator_id' => $id)
                ),
                array(
                )
            )    
            ->add('couldBePenalized',null,array(
                'required' => false,
            ))
            ->add('forcePenalize',null,array(
                'required' => false,
            ))
            ->add('requiredToImport',null,array(
                'required' => false,
            ))
            ->add('enabled',null,array(
                'required' => false,
            ))
            ->add('backward',null,array(
                'required' => false,
            ))
            ;
    }
    
    protected function configureDatagridFilters(DatagridMapper $filter) {
        $filter
            ->add('ref')
            ->add('description')
            ->add('formula')
            ->add('typeOfCalculation',null,array(),'choice',array(
                'choices' => \Pequiven\IndicatorBundle\Entity\Indicator::getTypesOfCalculation(),
                'translation_domain' => 'PequivenIndicatorBundle'
            ))
            ->add('tendency')
            ->add('frequencyNotificationIndicator')
            ->add('valueFinal')
            ->add('couldBePenalized')
            ->add('forcePenalize')
            ->add('requiredToImport')
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
            ->add('tendency')
            ->add('arrangementRange')
            ->add('enabled')
            ;
    }
    
    public function prePersist($object) {
        $object->setPeriod($this->getPeriodService()->getPeriodActive());
        if($object->isCouldBePenalized() === false){
            $object->setForcePenalize(false);
        }
    }
    
    public function preUpdate($object) {
        if($object->isCouldBePenalized() === false){
            $object->setForcePenalize(false);
        }
    }
    
    /**
     * Servicio que calcula los resultados
     * @return \Pequiven\SEIPBundle\Service\ResultService
     */
    public function getResultService()
    {
        return $this->container->get('seip.service.result');
    }
    
    /**
     * @return \Pequiven\SEIPBundle\Service\PeriodService
     */
    private function getPeriodService()
    {
        return $this->container->get('pequiven_arrangement_program.service.period');
    }
    
    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
        $this->container = $container;
    }
    
    protected function configureRoutes(\Sonata\AdminBundle\Route\RouteCollection $collection) 
    {
        $collection->remove('create');
    }
}
