<?php

namespace Pequiven\MasterBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Administrador del Rango de Gestión
 *
 */
class ArrangementRangeAdmin extends Admin implements \Symfony\Component\DependencyInjection\ContainerAwareInterface
{   
    private $container;
    
    protected function configureShowFields(\Sonata\AdminBundle\Show\ShowMapper $show) {
        $show
            ->add('objetive')
            ->add('indicator')
            ->add('typeRangeTop')
            ->add('opRankTopBasic')
            ->add('rankTopBasic')
            ->add('opRankTopMixedTop')
            ->add('rankTopMixedTop')
            ->add('opRankTopMixedBottom')
            ->add('rankTopMixedBottom')
            ->add('typeRangeMiddleTop')
            ->add('oprankMiddleTopBasic')
            ->add('rankMiddleTopBasic')
            ->add('opRankMiddleTopMixedTop')
            ->add('rankMiddleTopMixedTop')
            ->add('opRankMiddleTopMixedBottom')
            ->add('rankMiddleTopMixedBottom')
            ->add('typeRangeMiddleBottom')
            ->add('oprankMiddleBottomBasic')
            ->add('rankMiddleBottomBasic')
            ->add('opRankMiddleBottomMixedTop')
            ->add('rankMiddleBottomMixedTop')
            ->add('opRankMiddleBottomMixedBottom')
            ->add('rankMiddleBottomMixedBottom')
            ->add('typeRangeBottom')
            ->add('oprankBottomBasic')
            ->add('rankBottomBasic')
            ->add('opRankBottomMixedTop')
            ->add('rankBottomMixedTop')
            ->add('opRankBottomMixedBottom')
            ->add('rankBottomMixedBottom')
            ->add('enabled')
            ;
    }
    
    protected function configureFormFields(FormMapper $form) {
        $form
            ->add('objetive','sonata_type_model_autocomplete',array(
                'property' => array('ref','description'),
                'multiple' => false,
                "required" => false,
             ))
            ->add('indicator','sonata_type_model_autocomplete',array(
                'property' => array('ref','description'),
                'multiple' => false,
                "required" => false,
             ))
            ->add('typeRangeTop')
            ->add('opRankTopBasic')
            ->add('rankTopBasic')
            ->add('opRankTopMixedTop')
            ->add('rankTopMixedTop')
            ->add('opRankTopMixedBottom')
            ->add('rankTopMixedBottom')
            ->add('typeRangeMiddleTop')
            ->add('oprankMiddleTopBasic')
            ->add('rankMiddleTopBasic')
            ->add('opRankMiddleTopMixedTop')
            ->add('rankMiddleTopMixedTop')
            ->add('opRankMiddleTopMixedBottom')
            ->add('rankMiddleTopMixedBottom')
            ->add('typeRangeMiddleBottom')
            ->add('oprankMiddleBottomBasic')
            ->add('rankMiddleBottomBasic')
            ->add('opRankMiddleBottomMixedTop')
            ->add('rankMiddleBottomMixedTop')
            ->add('opRankMiddleBottomMixedBottom')
            ->add('rankMiddleBottomMixedBottom')
            ->add('typeRangeBottom')
            ->add('oprankBottomBasic')
            ->add('rankBottomBasic')
            ->add('opRankBottomMixedTop')
            ->add('rankBottomMixedTop')
            ->add('opRankBottomMixedBottom')
            ->add('rankBottomMixedBottom')
            ->add('enabled')
            ;
    }
    
    protected function configureDatagridFilters(DatagridMapper $filter) {
        $filter
            ->add('objetive','doctrine_orm_model_autocomplete',array(),null,array(
                'property' => array('ref','description')
            ))
            ->add('indicator','doctrine_orm_model_autocomplete',array(),null,array(
                'property' => array('ref','description')
            ))
            ->add("period")
            ;
    }
    
    protected function configureListFields(ListMapper $list) {
        $list
            ->addIdentifier('id')
            ->add('objetive')
            ->add('indicator')
            ->add('typeRangeTop')
            ->add('typeRangeMiddleTop')
            ->add('typeRangeMiddleBottom')
            ->add('typeRangeBottom')
            ;
    }
    
    public function prePersist($object)
    {
        $object->setPeriod($this->getPeriodService()->getPeriodActive());
    }
    
    public function postUpdate($object) 
    {
//        $objetives = $object->getObjetives();
//        $this->getResultService()->updateResultOfObjects($objetives);
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
    protected function getPeriodService()
    {
        return $this->container->get('pequiven_seip.service.period');
    }
    
    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
        $this->container = $container;
    }
    
//    protected function configureRoutes(\Sonata\AdminBundle\Route\RouteCollection $collection) 
//    {
//        $collection->remove('create');
//    }
}
