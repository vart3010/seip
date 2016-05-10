<?php

namespace Pequiven\MasterBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Admin de formula
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
class FormulaAdmin extends Admin implements \Symfony\Component\DependencyInjection\ContainerAwareInterface
{
    private $container;
    
    protected function configureShowFields(\Sonata\AdminBundle\Show\ShowMapper $show) {
        $show
            ->add('description')
            ->add('equation')
            ->add('equationReal')
            ->add('formulaLevel')
            ->add('enabled')
            ->add('variables')
            ->add('typeOfCalculation','choice',array(
                'choices' => \Pequiven\MasterBundle\Entity\Formula::getTypesOfCalculation(),
                'translation_domain' => 'PequivenIndicatorBundle'
            ))
            ->add('variableToRealValue')
            ->add('variableToPlanValue')
            ->add('sourceEquationReal',null,array(
                'label' => 'Source Equation Real (equation_real)'
            ))
            ->add('sourceEquationPlan',null,array(
                'label' => 'Source Equation Plan (equation_plan)'
            ))
            ->add('dashboardEquationReal',null,array(
                'label' => 'Dashboard Equation Real'
            ))
            ->add('dashboardEquationPlan',null,array(
                'label' => 'Dashboard Equation Plan'
            ))
            ->add('cardEquationReal',null,array(
                'label' => 'Ficha Equation Real'
            ))
            ->add('cardEquationPlan',null,array(
                'label' => 'Ficha Equation Plan'
            ))
            ->add('indicators')
            ;
        
    }
    
    protected function configureFormFields(FormMapper $form) {
        $form
            ->add('description')
            ->add('equation')
            ->add('equationReal')
            ->add('formulaLevel')
            ->add('enabled')
            ->add('variables')
            ->add('typeOfCalculation','choice',array(
                'choices' => \Pequiven\MasterBundle\Entity\Formula::getTypesOfCalculation(),
                'translation_domain' => 'PequivenIndicatorBundle'
            ))
            ->add('variableToRealValue')
            ->add('variableToPlanValue')
            ->add('sourceEquationReal',null,array(
                'label' => 'Source Equation Real (equation_real)'
            ))
            ->add('sourceEquationPlan',null,array(
                'label' => 'Source Equation Plan (equation_plan)'
            ))
            ->add('dashboardEquationReal',null,array(
                'label' => 'Dashboard Equation Real'
            ))
            ->add('dashboardEquationPlan',null,array(
                'label' => 'Dashboard Equation Plan'
            ))
            ->add('cardEquationReal',null,array(
                'label' => 'Ficha Equation Real'
            ))
            ->add('cardEquationPlan',null,array(
                'label' => 'Ficha Equation Plan'
            ))
        ;
    }
    
    protected function configureDatagridFilters(DatagridMapper $filter) {
        $filter
            ->add('description')
            ->add('equation')
            ->add('equationReal')
            ->add('enabled')
            ->add('variables')
            ;
    }
    
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('description')
            ->addIdentifier('equation')
            ->add('equationReal')
            ->add('enabled')
            ;
    }
    
    public function prePersist($object) {
        $object->setPeriod($this->getPeriodService()->getPeriodActive());
    }
    
    public function preUpdate($object) 
    {
        $indicatorService = $this->container->get('pequiven_indicator.service.inidicator');
        $errorFormula = $indicatorService->validateFormula($object);
        
        if($errorFormula !== null){
            $flashBag = $this->getRequest()->getSession()->getFlashBag();
            $flashBag->add("error",$errorFormula);
        }
    }
    
    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
        $this->container = $container;
    }
    
    /**
     * @return \Pequiven\SEIPBundle\Service\PeriodService
     */
    protected function getPeriodService()
    {
        return $this->container->get('pequiven_seip.service.period');
    }
}
