<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\MasterBundle\Admin\Formula;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Administrador del detalle de formula del indicador
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class FormulaDetailAdmin extends Admin implements ContainerAwareInterface
{
    /**
     *
     * @var ContainerAware
     */
    private $container;
    
    protected function configureShowFields(ShowMapper $show)
    {
        $show
            ->add('indicator')
            ->add('variable')
            ->add('variableDescription')
            ->add('unitType')
            ->add('unit')
            ->add('createdAt')
            ->add('updatedAt')
            ;
    }
    
    protected function configureFormFields(FormMapper $form) 
    {
        $object = $this->getSubject();
        $indicatorId = $this->getRequest()->get('indicator_id');
        if(!$indicatorId){
            $indicatorId = $this->getRequest()->get('objectId');
        }
        $indicator = null;
        $diableIndicator = true;
        $variableParameters = array(
            'class' => 'Pequiven\MasterBundle\Entity\Formula\Variable'
        );
        
        if($object != null && $object->getId() !== null){
            $indicator = $object->getIndicator();
        }
        if(!$indicator){
            $indicator = $this->container->get('pequiven.repository.indicator')->find($indicatorId);
            $diableIndicator = false;
        }
        
        if($indicator){
            if($object){
                $object->setIndicator($indicator);
            }
            
            $variables = $indicator->getFormula()->getVariables();
            $variablesId = array();
            foreach ($variables as $variable) 
            {
                $variablesId[] = $variable->getId();
            }
            $variableParameters['query_builder'] = function(\Doctrine\ORM\EntityRepository $repository) use ($variablesId)
            {
                $qb = $repository->createQueryBuilder('v');
                $qb->andWhere($qb->expr()->in('v.id',$variablesId));
                return $qb;
            };
            
        }else{
            $diableIndicator = false;
        }
        $diableIndicator = false;
//        $diableVariable = !$diableIndicator;
        $diableVariable = false;
        $variableParameters['disabled'] = $diableVariable;
        
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
//        DIE;
        $form
            ->add('variable','entity',$variableParameters)
            ->add('variableDescription',null,array(
                'required' => false,
            ))
            ->add('unitGroup','choice',array(
                'choices' => $selectUnits,
                'empty_value' => '',
            ))
            ;
    }
    
    protected function configureDatagridFilters(DatagridMapper $filter) 
    {
        $filter
            ->add('indicator')
            ->add('variable')
            ->add('variableDescription')
            ->add('unitType')
            ->add('unit')
            ;
    }
    
    protected function configureListFields(ListMapper $list) 
    {
        $list
            ->addIdentifier('id')
            ->add('indicator')
            ->add('variable')
//            ->add('variableDescription')
            ->add('unitType')
            ->add('unit')
            ;
    }
    
    public function prePersist($object) 
    {
//        $this->getRequest()->get($key)
       
    }

    /**
     * Shortcut to return the Doctrine Registry service.
     *
     * @return \Doctrine\Bundle\DoctrineBundle\Registry
     *
     * @throws \LogicException If DoctrineBundle is not available
     */
    private function getDoctrine()
    {
        if (!$this->container->has('doctrine')) {
            throw new \LogicException('The DoctrineBundle is not registered in your application.');
        }

        return $this->container->get('doctrine');
    }
    
    /**
     * 
     * @return \Tecnocreaciones\Bundle\ToolsBundle\Service\UnitConverter
     */
    private function getUnitConverter()
    {
        return $this->container->get('tecnocreaciones_tools.unit_converter');
    }


    public function setContainer(ContainerInterface $container = null) 
    {
        $this->container = $container;
    }
}
