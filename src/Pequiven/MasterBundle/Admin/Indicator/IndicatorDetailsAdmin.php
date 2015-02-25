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
class IndicatorDetailsAdmin extends Admin implements \Symfony\Component\DependencyInjection\ContainerAwareInterface
{
    /**
     *
     * @var ContainerAware
     */
    private $container;
    
    protected function configureShowFields(\Sonata\AdminBundle\Show\ShowMapper $show) 
    {
        $show
            ->add('previusValue')
            ->add('lastNotificationBy')
            ->add('lastNotificationAt')
//            ->add('lastNotificationParameters')
            ->add('lastFormulaUsed')
            ->add('resultPlanUnitGroup')
            ;
    }
    
    protected function configureFormFields(FormMapper $form) 
    {
        $selectUnitParameters = array();
        
        $unitConverter = $this->getUnitConverter();
        $unitsTypes = $unitConverter->getAvailableUnit()->getUnitsTypes();
        $selectUnits = array();
        foreach ($unitsTypes as $type => $data) {
            $dataUnits = array();
            $unitDescription = $data['description'];
            foreach ($data['units'] as $unit)
            {
                $dataUnits[json_encode(array('unitType' => $type,'unit' => $unit['name']))] = sprintf('%s (%s)',$unit['name'],$unit['aliases'][0]);
            }
            $selectUnits [] = array(
                $unitDescription => $dataUnits,
            );
        }
        $selectUnitParameters['choices'] = $selectUnits;
        $selectUnitParameters['empty_value'] = '';
        $form
            ->add('resultPlanUnitGroup','choice',$selectUnitParameters)
            ->add('resultRealUnitGroup','choice',$selectUnitParameters)
            ->add('resultManagementUnitGroup','choice',$selectUnitParameters)
            ;
    }
    
    protected function configureDatagridFilters(DatagridMapper $filter) 
    {
        $filter
            ->add('indicator')
            ;
    }
    protected function configureListFields(ListMapper $list) 
    {
        $list
            ->addIdentifier('id')
            ->add('indicator')
            ;
    }
    protected function configureRoutes(\Sonata\AdminBundle\Route\RouteCollection $collection) 
    {
        $collection->remove('create');
        $collection->remove('delete');
    }
    
    /**
     * 
     * @return \Tecnocreaciones\Bundle\ToolsBundle\Service\UnitConverter
     */
    private function getUnitConverter()
    {
        return $this->container->get('tecnocreaciones_tools.unit_converter');
    }
    
    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) 
    {
        $this->container = $container;
    }
}
