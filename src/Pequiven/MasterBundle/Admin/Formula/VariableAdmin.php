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
            ;
    }
    
    protected function configureFormFields(FormMapper $form) {
        $form
            ->add('name')
            ->add('description')
            ->add('staticValue')
            ->add('equation',null,array(
                'attr' => array(
                    'rows' => 10
                )
            ))
            ;
    }
    
    protected function configureDatagridFilters(DatagridMapper $filter) {
        $filter
            ->add('name')
            ->add('description')
            ->add('staticValue')
            ;
    }
    
    protected function configureListFields(ListMapper $list) {
        $list
            ->addIdentifier('name')
            ->addIdentifier('description')
            ->addIdentifier('staticValue')
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
    private function getPeriodService()
    {
        return $this->container->get('pequiven_seip.service.period');
    }
    
    public function preUpdate($object) {
        \Pequiven\SEIPBundle\Service\ToolService::validateName($object->getName());
    }
}
