<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\MasterBundle\Admin\Indicator;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Administrador del detalle de indicador
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class IndicatorDetailsAdmin extends Admin implements \Symfony\Component\DependencyInjection\ContainerAwareInterface {

    /**
     *
     * @var ContainerAware
     */
    private $container;

    protected function configureShowFields(\Sonata\AdminBundle\Show\ShowMapper $show) {
        $show
                ->add('previusValue')
                ->add('lastNotificationBy')
                ->add('lastNotificationAt')
                ->add('lastFormulaUsed')
                ->add('resultPlanUnitGroup')
                ->add('sourceResult', 'choice', array(
                    'choices' => \Pequiven\IndicatorBundle\Model\Indicator\IndicatorDetails::getSourceResultLabels(),
                    'translation_domain' => 'PequivenIndicatorBundle',
                ))
        ;
    }

    protected function configureFormFields(FormMapper $form) {
        $selectUnitParameters = array();

        $unitConverter = $this->getUnitConverter();
        $selectUnits = $unitConverter->toArray();

        $selectUnitParameters['choices'] = $selectUnits;
        $selectUnitParameters['empty_value'] = '';
        $selectUnitParameters['required'] = false;


        $indicatorService = $this->getIndicatorService();
        
        $indicatorDetails = $this->getSubject();
        
        if ($indicatorDetails != null && $indicatorDetails->getId() !== null) {
            $indicator = $indicatorDetails->getIndicator();
            //$variables = $indicatorService->getArrayVariablesFormulaWithData($indicator->getIndicator(),array("viewVariablesRealPlan","viewVariablesRealPlan"));
            $variables = $indicatorService->getVariablesInArray($indicator);



            $varsIndicator["choices"] = $variables;
            $varsIndicator["empty_value"] = '';

            //$entity = new \Pequiven\MasterBundle\Entity\Formula();
           // $query = $this->modelManager->getEntityManager($entity)->createQuery('SELECT s FROM Pequiven\MasterBundle\Entity\Formula s ');



            $query = $this->container->get('pequiven.repository.variable')->getVariablesByFormula($indicator->getFormula()->getId());
        }
        
        
        $form
                ->add('resultPlanUnitGroup', 'choice', $selectUnitParameters)
                ->add('resultRealUnitGroup', 'choice', $selectUnitParameters)
                ->add('resultManagementUnitGroup', 'choice', $selectUnitParameters)
                ->add('sourceResult', 'choice', array(
                    'choices' => \Pequiven\IndicatorBundle\Model\Indicator\IndicatorDetails::getSourceResultLabels(),
                    'translation_domain' => 'PequivenIndicatorBundle',
                ))
                ->add('isCheckReal', null, array(
                    'required' => false,
                ))

                //->add('varIndicatorReal', 'entity', $varsIndicator)
                
                ->add('isCheckPlan', null, array(
                    'required' => false,
                ))
        
                 ;
        
        if ($indicatorDetails != null && $indicatorDetails->getId() !== null) {
            $form
                    ->add('varIndicatorReal', 'sonata_type_model', array(
                        'class'=> 'Pequiven\MasterBundle\Entity\Formula\Variable',
                        'multiple' => false,
                        "required" => true,
                        "query"=>$query,
                        "btn_add"=>false
                        ))
                    ->add('varIndicatorPlan', 'sonata_type_model', array(
                        'class'=> 'Pequiven\MasterBundle\Entity\Formula\Variable',
                        'multiple' => false,
                        "required" => true,
                        "query"=>$query,
                        "btn_add"=>false
                        ))
                ;
        }
    }

    protected function configureDatagridFilters(DatagridMapper $filter) {
        $filter
                ->add('indicator', 'doctrine_orm_model_autocomplete', array(), null, array(
                    'property' => array('ref', 'description')
                ))
        ;
    }

    protected function configureListFields(ListMapper $list) {
        $list
                ->addIdentifier('id')
                ->add('indicator')
        ;
    }

    protected function configureRoutes(\Sonata\AdminBundle\Route\RouteCollection $collection) {
        $collection->remove('create');
        $collection->remove('delete');
    }

    /**
     * 
     * @return \Tecnocreaciones\Bundle\ToolsBundle\Service\UnitConverter
     */
    private function getUnitConverter() {
        return $this->container->get('tecnocreaciones_tools.unit_converter');
    }

    private function getIndicatorService() {
        return $this->container->get('pequiven_indicator.service.inidicator');
    }
    
    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
        $this->container = $container;
    }
    
    
    private function getDoctrineService() {
        return $this->container->get('doctrine');
    }

}
