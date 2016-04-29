<?php

namespace Pequiven\MasterBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Administrador de los Gráficos
 *
 */
class ChartAdmin extends Admin implements \Symfony\Component\DependencyInjection\ContainerAwareInterface
{   
    private $container;
    
    // Field to be shown on show page of the object
    protected function configureShowFields(\Sonata\AdminBundle\Show\ShowMapper $show) {
        $show
            ->add('alias')
            ->add('description')
            ->add('typeOfChart','choice',array(
                'choices' => \Pequiven\SEIPBundle\Entity\Chart::getLabelsTypeOfChart(),
                'translation_domain' => 'PequivenSEIPBundle'
            ))
            ;
    }
    
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $form) {
        $form
            ->add('alias')
            ->add('description')
            ->add('shortDescription')
            ->add('typeOfChart','choice',array(
                'choices' => \Pequiven\SEIPBundle\Entity\Chart::getLabelsTypeOfChart(),
                'translation_domain' => 'PequivenSEIPBundle'
            ))
            ->add('nameFunctionAngular')
            ;
    }
    
    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $filter) {
        $filter
            ->add('indicators','doctrine_orm_model_autocomplete',array(),null,array(
                'property' => array('ref','description')
            ))
            ->add('alias')
            ->add('description')
            ->add('typeOfChart', null, array(), 'choice',array(
                'choices' => \Pequiven\SEIPBundle\Entity\Chart::getLabelsTypeOfChart(),
                'translation_domain' => 'PequivenSEIPBundle'
            ))
            ;
    }
    // Fields to be shown on lists
    protected function configureListFields(ListMapper $list) {
        $list
            ->addIdentifier('id')
            ->add('alias')
            ->add('description')
            ->add('shortDescription')
            ->add('typeOfChart')
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
