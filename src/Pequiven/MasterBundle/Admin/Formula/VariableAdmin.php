<?php

namespace Pequiven\MasterBundle\Admin\Formula;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Admin de Variable de la formula
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
class VariableAdmin extends Admin implements \Symfony\Component\DependencyInjection\ContainerAwareInterface
{
    private $container;
    protected function configureShowFields(\Sonata\AdminBundle\Show\ShowMapper $show) {
        $show
            ->add('name')
            ->add('description')
            ->add('equation')
            ->add('summary')
            ->add('unitResult')
            ;
    }
    
    protected function configureFormFields(FormMapper $form) {
        $unitConverter = $this->getUnitConverter();
        $selectUnits = $unitConverter->toArray();
        
        $selectUnitParameters['choices'] = $selectUnits;
        $selectUnitParameters['empty_value'] = '';
        $selectUnitParameters['required'] = false;
        
        $form
            ->add('name')
            ->add('description')
            ->add('staticValue',null,array(
                'required' => false,
            ))
            ->add('usedOnlyByTag',null,array(
                'required' => false,
            ))
            ->add('showRealInDashboardPie',null,array(
                'required' => false,
            ))
            ->add('showPlanInDashboardPie',null,array(
                'required' => false,
            ))
            ->add('showRealInDashboardBarArea',null,array(
                'required' => false,
            ))
            ->add('showPlanInDashboardBarArea',null,array(
                'required' => false,
            ))
            ->add('showRealInDashboardColumn',null,array(
                'required' => false,
            ))
            ->add('showPlanInDashboardColumn',null,array(
                'required' => false,
            ))
            ->add('equation',null,array(
                'attr' => array(
                    'rows' => 10
                )
            ))
            ->add('summary', null, array(
                'required' => false,
            ))
            ->add('unitResult',"choice",$selectUnitParameters)
            ;
    }
    
    protected function configureDatagridFilters(DatagridMapper $filter) {
        $filter
            ->add('name')
            ->add('description')
            ->add('staticValue')
            ->add('usedOnlyByTag')
            ->add('showRealInDashboardPie')
            ->add('showPlanInDashboardPie')
            ->add('showRealInDashboardBarArea')
            ->add('showPlanInDashboardBarArea')
            ->add('showRealInDashboardColumn')
            ->add('showPlanInDashboardColumn')
            ;
    }
    
    protected function configureListFields(ListMapper $list) {
        $list
            ->addIdentifier('name')
            ->addIdentifier('description')
            ->addIdentifier('staticValue')
            ->addIdentifier('usedOnlyByTag')
            ;
    }
    
    public function prePersist($object) 
    {
        \Pequiven\SEIPBundle\Service\ToolService::validateName($object->getName());
        $object->setPeriod($this->getPeriodService()->getPeriodActive());
    }

    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) 
    {
        $this->container = $container;
    }
    /**
     * @return \Pequiven\SEIPBundle\Service\PeriodService
     */
    protected function getPeriodService()
    {
        return $this->container->get('pequiven_seip.service.period');
    }
    
    /**
     * 
     * @return \Tecnocreaciones\Bundle\ToolsBundle\Service\UnitConverter
     */
    private function getUnitConverter()
    {
        return $this->container->get('tecnocreaciones_tools.unit_converter');
    }
    
    public function preUpdate($object) {
        \Pequiven\SEIPBundle\Service\ToolService::validateName($object->getName());
    }
}
