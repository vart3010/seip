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
class IndicatorAdmin extends Admin implements \Symfony\Component\DependencyInjection\ContainerAwareInterface {

    private $container;

    protected function configureShowFields(\Sonata\AdminBundle\Show\ShowMapper $show) {
        $show
                ->add('ref')
                ->add('description')
                ->add('typeOfCalculation', 'choice', array(
                    'choices' => \Pequiven\IndicatorBundle\Entity\Indicator::getTypesOfCalculation(),
                    'translation_domain' => 'PequivenIndicatorBundle'
                ))
                ->add('typeOfResultSection', 'choice', array(
                    'choices' => \Pequiven\IndicatorBundle\Entity\Indicator::getTypesOfResultSection(),
                    'translation_domain' => 'PequivenIndicatorBundle',
                    'required' => false,
                ))
                ->add('typeDetailValue', 'choice', array(
                    'choices' => \Pequiven\IndicatorBundle\Entity\Indicator::getLabelsTypeDetail(),
                    'translation_domain' => 'PequivenIndicatorBundle'
                ))
                ->add('calculationMethod', 'choice', array(
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
                ->add('showCharts')
                ->add('showEvolutionView')
                ->add('viewDataChartEvolutionConsultedMonth')
                ->add('decimalsToChartEvolution')
                ->add('showTags')
                ->add('notshowIndicatorNoEvaluateInPeriod')
                ->add('requiredToImport')
                ->add('details')
                ->add('typeOfCompany', 'choice', array(
                    "choices" => \Pequiven\IndicatorBundle\Entity\Indicator::getTypesOfCompanies(),
                    "translation_domain" => "PequivenMasterBundle",
                    'required' => false,
                ))
        ;
    }

    protected function configureFormFields(FormMapper $form) {
        $object = $this->getSubject();
        $childrensParameters = array(
            'class' => 'Pequiven\IndicatorBundle\Entity\Indicator',
            'multiple' => true,
            'required' => false,
            "property" => array("ref", "description"),
        );
        $id = null;
        if ($object != null && $object->getId() !== null) {
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
                ->add('summary', null, array(
                    'required' => false,
                ))
                ->add('typeOfCalculation', 'choice', array(
                    'choices' => \Pequiven\IndicatorBundle\Entity\Indicator::getTypesOfCalculation(),
                    'translation_domain' => 'PequivenIndicatorBundle'
                ))
                ->add('typeOfResultSection', 'choice', array(
                    'choices' => \Pequiven\IndicatorBundle\Entity\Indicator::getTypesOfResultSection(),
                    'translation_domain' => 'PequivenIndicatorBundle',
                    'required' => false,
                ))
                ->add('calculationMethod', 'choice', array(
                    'choices' => \Pequiven\IndicatorBundle\Entity\Indicator::getLabelsCalculationMethod(),
                    'translation_domain' => 'PequivenIndicatorBundle'
                ))
                ->add('typeDetailValue', 'choice', array(
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
                ->add('charts', 'sonata_type_model_autocomplete', array(
                    'property' => array('alias', 'description'),
                    'multiple' => true,
                    'required' => false,
                ))
                ->add('indicatorGroup', 'sonata_type_model_autocomplete', array(
                    'property' => array('description'),
                    'multiple' => true,
                    'required' => false,
                    'label' => 'Grupos de Indicadores'
                ))
                ->add('showIndicatorGroups', null, array(
                    'label' => 'Mostrar si Tiene Grupo de Indicadores en el Dashboard',
                    'required' => false,
                        )
                )
                ->add('childrens', 'sonata_type_model_autocomplete', $childrensParameters)
        ;
        $form
                ->add('formulaDetails', 'sonata_type_collection', array(
                    'cascade_validation' => true,
                    'by_reference' => false,
                        //                    'type_options' => array(
                        //                        'delete' => true,
                        //                    ),
                        ), array(
                    'edit' => 'inline',
                    'inline' => 'table',
                    //                    'sortable' => 'position',
                    'link_parameters' => array('indicator_id' => $id)
                        ), array(
                        )
                )
                ->add('couldBePenalized', null, array(
                    'required' => false,
                ))
                ->add('evaluateInPeriod', null, array(
                    'required' => false,
                ))
                ->add('notshowIndicatorNoEvaluateInPeriod', null, array(
                    'required' => false,
                ))
                ->add('forcePenalize', null, array(
                    'required' => false,
                ))
                ->add('resultInPercentage', null, array(
                    'required' => false,
                ))
                ->add('showRealValue', null, array(
                    'required' => false,
                ))
                ->add('showPlanValue', null, array(
                    'required' => false,
                ))
                ->add('requiredToImport', null, array(
                    'required' => false,
                ))
                ->add('enabled', null, array(
                    'required' => false,
                ))
                ->add('isValueFromTextReal', null, array(
                    'required' => false,
                ))
                ->add('textValueFromVariableReal', null, array(
                    'required' => false,
                ))
                ->add('isValueFromTextPlan', null, array(
                    'required' => false,
                ))
                ->add('textValueFromVariablePlan', null, array(
                    'required' => false,
                ))
                ->add('planIsNotAccumulative', null, array(
                    'required' => false,
                ))
                ->add('numberValueIndicatorToForce')
                ->end()
                ->end()
        ;

        $form->tab('Dashboards (Tableros)');
        if ($object != null && $object->getId() !== null) {
            if ($object->getIndicatorLevel()->getLevel() == IndicatorLevel::LEVEL_ESTRATEGICO) {
                $form
                        ->with('Estratégico')
                        ->add('lineStrategics')
                        ->end();
            }
        }
        $form
                ->with('Gráficos Personalizados')
                ->add('lineStrategics')
                ->add('complejoDashboardSpecific', 'sonata_type_model_autocomplete', array(
                    'property' => array('description'),
                    'required' => false,
                ))
                ->add('orderShowFromParent')
                ->add('showByDashboardSpecific', null, array(
                    'required' => false,
                ))
                ->end();
        $form
                ->with('Esferas')
                ->add('showResultWithoutPercentageInDashboard', null, array(
                    'required' => false,
                ))
                ->end()
                ->end();


        $form
                ->tab("Details")
                ->with('Details')
                ->add('showByRealValue')
                ->add('showByPlanValue')
                ->add('details', 'sonata_type_admin', array(
                    'cascade_validation' => true,
                    'delete' => false,
                        ), array(
                    'edit' => 'inline',
                    'inline' => 'standard',
                ))
                ->end()
                ->with('Ficha Indicador')
                ->add('isValueRealFromEquationRealFormula', null, array(
                    'required' => false,
                ))
                ->add('isValuePlanFromEquationPlanFormula', null, array(
                    'required' => false,
                ))
                ->end()
                ->with('Resultados del Indicador')
                ->add('resultIsFromChildrensResult', null, array(
                    'required' => false,
                ))
                ->add('ignoredByParentResult', null, array(
                    'required' => false,
                ))
                ->end()
                ->with('Gráficos del Indicador')
                ->add('resultIsAccumulative', null, array(
                    'required' => false,
                ))
                ->add('resultIsAccumulativeWithToMonth', null, array(
                    'required' => false,
                ))
                ->add('showColumnAccumulativeInDashboard', null, array(
                    'required' => false,
                ))
                ->add('showColumnPlanOneTimeInDashboard', null, array(
                    'required' => false,
                ))
                ->add('resultsAdditionalInDashboardColumn', null, array(
                    'required' => false,
                ))
                ->add('showColumnPlanAtTheEnd', null, array(
                    'required' => false,
                ))
                ->add('showDashboardByQuarter', null, array(
                    'required' => false,
                ))
                ->end()
                ->with('Etiqueta del Indicador')
                ->add('showTagsInTwoColumns', null, array(
                    'required' => false,
                ))
                ->add('showTagInResult', null, array(
                    'required' => false,
                ))
                ->add('showTagInDashboardResult', null, array(
                    'required' => false,
                ))
                ->end()
                ->with('Snippets')
                ->add("snippetPlan", null, array(
                    "attr" => array("rows" => 4,)
                ))
                ->add("snippetReal", null, array(
                    "attr" => array("rows" => 4,)
                ))
                ->end()
                ->with('Tipo de Compañia')
                ->add('typeOfCompany', 'choice', array(
                    "choices" => \Pequiven\IndicatorBundle\Entity\Indicator::getTypesOfCompanies(),
                    "translation_domain" => "PequivenMasterBundle",
                    'required' => false,
                ))
                ->end()
                ->with('Opciones de visualizacion en la ficha')
                ->add('showResults', null, array(
                    'required' => false,
                ))
                ->add('showFeatures', null, array(
                    'required' => false,
                ))
                ->add('showRange', null, array(
                    'required' => false
                ))
                ->end()
                ->with('Opciones de visualizacion en el dashboard')
                ->add('showCharts', null, array(
                    'required' => false,
                ))
                ->add('showTags', null, array(
                    'required' => false,
                ))
                ->end()
                ->with('SIG')
                ->add('managementSystems', 'sonata_type_model_autocomplete', array(
                    'property' => array('description'),
                    'multiple' => true,
                    'required' => false,
                ))
                ->add('showEvolutionView', null, array(
                    'required' => false,
                ))
                ->add('viewDataChartEvolutionConsultedMonth', null, array(
                    'required' => false,
                ))
                ->add('decimalsToChartEvolution', null, array(
                    'required' => false,
                ))
                ->add('loadFiles', null, array(
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
                ->add('typeOfCalculation', null, array(), 'choice', array(
                    'choices' => \Pequiven\IndicatorBundle\Entity\Indicator::getTypesOfCalculation(),
                    'translation_domain' => 'PequivenIndicatorBundle'
                ))
                ->add('typeOfResultSection', null, array(), 'choice', array(
                    'choices' => \Pequiven\IndicatorBundle\Entity\Indicator::getTypesOfResultSection(),
                    'translation_domain' => 'PequivenIndicatorBundle',
                    'required' => false,
                ))
                ->add('tendency')
                ->add('frequencyNotificationIndicator')
                ->add('valueFinal')
                ->add('couldBePenalized')
                ->add('forcePenalize')
                ->add('resultInPercentage')
                ->add('requiredToImport')
                ->add('period')
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
        if ($object->isCouldBePenalized() === false) {
            $object->setForcePenalize(false);
        }
        foreach ($object->getFormulaDetails() as $formulaDetails) {
            $formulaDetails->setIndicator($object);
        }
    }

    public function preUpdate($object) {
        foreach ($object->getFormulaDetails() as $formulaDetails) {
            $formulaDetails->setIndicator($object);
        }
        if ($object->isCouldBePenalized() === false) {
            $object->setForcePenalize(false);
        }
    }

    /**
     * Servicio que calcula los resultados
     * @return \Pequiven\SEIPBundle\Service\ResultService
     */
    public function getResultService() {
        return $this->container->get('seip.service.result');
    }

    /**
     * 
     * @return type
     */
    private function getIndicatorService() {
        return $this->container->get('pequiven_indicator.service.inidicator');
    }

    /**
     * @return \Pequiven\SEIPBundle\Service\PeriodService
     */
    protected function getPeriodService() {
        return $this->container->get('pequiven_seip.service.period');
    }

    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
        $this->container = $container;
    }

    protected function configureRoutes(\Sonata\AdminBundle\Route\RouteCollection $collection) {
        $collection->remove('create');
    }

    public function toString($object) {
        $toString = '-';
        if ($object->getId() > 0) {
            $toString = $object->getPeriod()->getDescription() . ' - ' . $object->getRef() . ' - ' . $object->getDescription();
        }
        return \Pequiven\SEIPBundle\Service\ToolService::truncate($toString, array('limit' => 50));
    }

}
