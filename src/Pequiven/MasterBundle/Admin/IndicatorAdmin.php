<?php

namespace Pequiven\MasterBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

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
            ;
    }
    
    protected function configureFormFields(FormMapper $form) {
        $object = $this->getSubject();
        $childrensParameters = array(
            'class' => 'Pequiven\IndicatorBundle\Entity\Indicator',
            'multiple' => true,
            'required' => false,
        );
        if($object != null && $object->getId() !== null){
            $indicatorLevel = $object->getIndicatorLevel();
            $level = $indicatorLevel->getLevel();
            $childrensParameters['query_builder'] = function(\Pequiven\IndicatorBundle\Repository\IndicatorRepository $repository) use ($level){
                return $repository->getQueryChildrenLevel($level);
            };
           
        }
        
        $form
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
            ->add('childrens','entity',$childrensParameters)
            ->add('enabled')
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
    
    protected function configureRoutes(\Sonata\AdminBundle\Route\RouteCollection $collection) 
    {
        $collection->remove('create');
    }
}
