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
            ->add('typeDetailValue','choice',array(
                'choices' => \Pequiven\IndicatorBundle\Entity\Indicator::getLabelsTypeDetail(),
                'translation_domain' => 'PequivenIndicatorBundle'
            ))
            ->add('calculationMethod','choice',array(
                'choices' => \Pequiven\IndicatorBundle\Entity\Indicator::getLabelsCalculationMethod(),
                'translation_domain' => 'PequivenIndicatorBundle'
            ))
            ->add('refParent')
            ->add('totalPlan')
            ->add('weight')
            ->add('indicatorWeight')
            ->add('goal')
            ->add('formula')
            ->add('tendency')
            ->add('summary')
            ->add('arrangementRange')
            ->add('frequencyNotificationIndicator')
            ->add('valueFinal')
            ->add('childrens')
            ->add('valuesIndicator')
            ->add('couldBePenalized')
            ->add('forcePenalize')
            ->add('resultInPercentage')
            ->add('showRealValue')
            ->add('showPlanValue')
            ->add('showResults')
            ->add('showFeatures')
            ->add('requiredToImport')
            ->add('details')
            ;
    }
    
    protected function configureFormFields(FormMapper $form) 
    {
        $object = $this->getSubject();
        $childrensParameters = array(
            'class' => 'Pequiven\IndicatorBundle\Entity\Indicator',
            'multiple' => true,
            'required' => false,
            "property" => array("ref","description"),
        );
        $id = null;
        if($object != null && $object->getId() !== null){
            $indicatorLevel = $object->getIndicatorLevel();
            $level = $indicatorLevel->getLevel();
//            $childrensParameters['query_builder'] = function(\Pequiven\IndicatorBundle\Repository\IndicatorRepository $repository) use ($level){
//                return $repository->getQueryChildrenLevel($level);
//            };
            $childrensParameters['callback'] = function ($admin, $property, $value) {
//                $datagrid = $admin->getDatagrid();
//                $queryBuilder = $datagrid->getQuery();
//                $queryBuilder
//                    ->andWhere($queryBuilder->getRootAlias() . '.foo=:barValue')
//                    ->setParameter('barValue', $admin->getRequest()->get('bar'))
//                ;
//                $datagrid->setValue($property, null, $value);
            };
            $id = $object->getId();
        }
        
        $form
            ->tab('General')
                ->add('ref')
                ->add('description')
                ->add('summary',null,array(
                    'required' => false,
                ))
                ->add('lineStrategics')
                ->add('orderShowFromParent')
                ->add('typeOfCalculation','choice',array(
                    'choices' => \Pequiven\IndicatorBundle\Entity\Indicator::getTypesOfCalculation(),
                    'translation_domain' => 'PequivenIndicatorBundle'
                ))
                ->add('calculationMethod','choice',array(
                    'choices' => \Pequiven\IndicatorBundle\Entity\Indicator::getLabelsCalculationMethod(),
                    'translation_domain' => 'PequivenIndicatorBundle'
                ))
                ->add('typeDetailValue','choice',array(
                    'choices' => \Pequiven\IndicatorBundle\Entity\Indicator::getLabelsTypeDetail(),
                    'translation_domain' => 'PequivenIndicatorBundle'
                ))
                ->add('refParent')
                ->add('totalPlan')
                ->add('weight')
                ->add('indicatorWeight')
                ->add('goal')
                ->add('formula')
                ->add('tendency')
                ->add('frequencyNotificationIndicator')
                ->add('valueFinal')
                ->add('childrens','sonata_type_model_autocomplete',$childrensParameters);
                if($object != null && $object->getId() !== null){
                    if($object->getIndicatorLevel()->getLevel() == IndicatorLevel::LEVEL_ESTRATEGICO){
                        $form->add('lineStrategics');
                    }
                }
        $form
                ->add('formulaDetails','sonata_type_collection',
                    array(
                         'cascade_validation' => true,
                         'by_reference' => false,
    //                    'type_options' => array(
    //                        'delete' => true,
    //                    ),
                    ),
                    array(
                        'edit'   => 'inline',
                        'inline' => 'table',
    //                    'sortable' => 'position',
                        'link_parameters' => array('indicator_id' => $id)
                    ),
                    array(
                    )
                )    
                ->add('couldBePenalized',null,array(
                    'required' => false,
                ))
                ->add('evaluateInPeriod',null,array(
                    'required' => false,
                ))
                ->add('forcePenalize',null,array(
                    'required' => false,
                ))
                ->add('resultInPercentage',null,array(
                    'required' => false,
                ))
                ->add('showTagInResult',null,array(
                    'required' => false,
                ))
                ->add('showRealValue',null,array(
                    'required' => false,
                ))
                ->add('showPlanValue',null,array(
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
                ->end()
            ->end()
            ;
        
        $form
            ->tab("Details")
                ->with('Details')
                    ->add('details','sonata_type_admin',array(
                         'cascade_validation' => true,
                         'delete' => false,
                    ),
                    array(
                        'edit'   => 'inline',
                        'inline' => 'table',
                    ))
                ->end()
                ->with('Snippets')
                    ->add("snippetPlan",null,array(
                        "attr" => array("rows" => 4,)
                    ))
                    ->add("snippetReal",null,array(
                        "attr" => array("rows" => 4,)
                    ))
                ->end()
                ->with('Opciones de visualizacion')
                    ->add('showResults',null,array(
                        'required' => false,
                    ))
                    ->add('showFeatures',null,array(
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
            ->add('resultInPercentage')
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
    
    public function prePersist($object) 
    {
        
        $object->setPeriod($this->getPeriodService()->getPeriodActive());
        if($object->isCouldBePenalized() === false){
            $object->setForcePenalize(false);
        }
        foreach ($object->getFormulaDetails() as $formulaDetails)
        {
            $formulaDetails->setIndicator($object);
        }
    }
    
    public function preUpdate($object) 
    {
        foreach ($object->getFormulaDetails() as $formulaDetails)
        {
            $formulaDetails->setIndicator($object);
        }
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
        return $this->container->get('pequiven_seip.service.period');
    }
    
    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
        $this->container = $container;
    }
    
    protected function configureRoutes(\Sonata\AdminBundle\Route\RouteCollection $collection) 
    {
        $collection->remove('create');
    }
}
