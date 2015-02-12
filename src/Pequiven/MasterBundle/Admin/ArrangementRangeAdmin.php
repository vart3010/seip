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
//        $object = $this->getSubject();
//        $childrensParameters = array(
//            'class' => 'Pequiven\IndicatorBundle\Entity\Indicator',
//            'multiple' => true,
//            'required' => false,
//        );
//        if($object != null && $object->getId() !== null){
//            $indicatorLevel = $object->getIndicatorLevel();
//            $level = $indicatorLevel->getLevel();
//            $childrensParameters['query_builder'] = function(\Pequiven\IndicatorBundle\Repository\IndicatorRepository $repository) use ($level){
//                return $repository->getQueryChildrenLevel($level);
//            };
//           
//        }
//        
        $form
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
    
    protected function configureDatagridFilters(DatagridMapper $filter) {
//        $filter
//            ->add('ref')
//            ->add('description')
//            ->add('formula')
//            ->add('typeOfCalculation',null,array(),'choice',array(
//                'choices' => \Pequiven\IndicatorBundle\Entity\Indicator::getTypesOfCalculation(),
//                'translation_domain' => 'PequivenIndicatorBundle'
//            ))
//            ->add('tendency')
//            ->add('frequencyNotificationIndicator')
//            ->add('valueFinal')
//            ->add('enabled')
//            ;
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
    private function getPeriodService()
    {
        return $this->container->get('pequiven_arrangement_program.service.period');
    }
    
    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
        $this->container = $container;
    }
    
//    protected function configureRoutes(\Sonata\AdminBundle\Route\RouteCollection $collection) 
//    {
//        $collection->remove('create');
//    }
}
