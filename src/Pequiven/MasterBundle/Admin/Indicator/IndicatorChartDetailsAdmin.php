<?php

namespace Pequiven\MasterBundle\Admin\Indicator;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Administrador de los detalles de los gráficos del indicador
 *
 */
class IndicatorChartDetailsAdmin extends Admin implements \Symfony\Component\DependencyInjection\ContainerAwareInterface
{
    /**
     *
     * @var ContainerAware
     */
    private $container;
    
    protected function configureShowFields(\Sonata\AdminBundle\Show\ShowMapper $show) {
        $show
            ->add('id')
            ->add('description')
            ->add('indicator')
            ->add('chart')
            ->add('orderShow')
            ->add('period')
            ;
    }
    
    protected function configureFormFields(FormMapper $form) 
    {
        
        $form
            ->add('description')
            ->add('orderShow', null, array(
                'required' => false,
            ))
            ->add('indicator','sonata_type_model_autocomplete',array(
                'property' => array('ref','description'),
                'multiple' => false,
                "required" => true,
             ))
            ->add('chart','sonata_type_model_autocomplete',array(
                'property' => array('ref','description'),
                'multiple' => false,
                "required" => true,
             ))
            ;
    }
    
    protected function configureDatagridFilters(DatagridMapper $filter) {
        $filter
            ->add('indicator','doctrine_orm_model_autocomplete',array(),null,array(
                'property' => array('ref','description')
            ))
            ->add('chart','doctrine_orm_model_autocomplete',array(),null,array(
                'property' => array('description')
            ))
            ->add('description')
            ->add('period')
            ;
    }
    
    protected function configureListFields(ListMapper $list) {
         $list
            ->addIdentifier('id')
            ->add('description',null, array('editable' => true))
            ->add('chart')
            ->add('indicator')
            ->add('orderShow',null, array('editable' => true))
            ->add('period')
            ;
    }
    
    public function prePersist($object) 
    {
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
}
