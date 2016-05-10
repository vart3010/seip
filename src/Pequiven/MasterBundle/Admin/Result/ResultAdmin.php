<?php

namespace Pequiven\MasterBundle\Admin\Result;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Administrador de resultado
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
class ResultAdmin extends Admin implements \Symfony\Component\DependencyInjection\ContainerAwareInterface 
{
    protected $container;
    
    protected function configureShowFields(\Sonata\AdminBundle\Show\ShowMapper $show) 
    {
        $show
            ->add('description')
            ->add('weight')
            ->add('typeResult')
            ->add('typeCalculation','choice',array(
                'choices' => \Pequiven\SEIPBundle\Model\Result\Result::getTypeCalculations(),
                'translation_domain' => 'PequivenSEIPBundle'
            ))
            ->add('objetive')
            ->add('parent')
            ;
    }
    
    protected function configureFormFields(FormMapper $form) {
        $form
            ->add('description')
            ->add('weight')
            ->add('typeResult','choice',array(
                'choices' => \Pequiven\SEIPBundle\Model\Result\Result::getTypeResults(),
                'translation_domain' => 'PequivenSEIPBundle'
            ))
            ->add('typeCalculation','choice',array(
                'choices' => \Pequiven\SEIPBundle\Model\Result\Result::getTypeCalculations(),
                'translation_domain' => 'PequivenSEIPBundle'
            ))
            ->add('objetive','sonata_type_model_autocomplete',array(
                'property' => array('ref','description'),
                'required' => false,
            ))
            ->add('parent','entity',array(
                'class' => 'Pequiven\SEIPBundle\Entity\Result\Result',
                'query_builder' => function(\Pequiven\SEIPBundle\Repository\Result\ResultRepository $repository){
                    return $repository->getQueryOfValidParents();
                },
                'property' => 'descriptionText',
                'required' => false,
            ))
            ;
    }
    
    protected function configureDatagridFilters(DatagridMapper $filter) {
        $filter
            ->add('description')
            ->add('typeResult')
            ->add('typeCalculation')
            ->add('objetive','doctrine_orm_model_autocomplete',array(),null,array(
                'property' => array('ref','description')
            ))
            ->add('period')
            ;
    }
    
    protected function configureListFields(ListMapper $list) {
        $list
            ->addIdentifier('description')
            ->add('typeResult')
            ->add('typeCalculation')
            ->add('objetive')
            ;
    }
    
    public function prePersist($object) 
    {
        $object->setPeriod($this->getPeriodService()->getPeriodActive());
        $parent = $object->getParent();
        if($parent != null){
            $object->setObjetive(null);
        }
    }
    
    public function preUpdate($object) {
        $parent = $object->getParent();
        if($parent != null){
            $object->setObjetive(null);
        }
    }

    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
        $this->container = $container;
    }
    
    public function toString($object) 
    {
        $toString = '-';
        if($object->getId() > 0){
            $toString = $object->getPeriod()->getDescription().' - '.$object->getDescription();
        }
        return \Pequiven\SEIPBundle\Service\ToolService::truncate($toString,array('limit' => 50));
    }
    
    /**
     * @return \Pequiven\SEIPBundle\Service\PeriodService
     */
    protected function getPeriodService()
    {
        return $this->container->get('pequiven_seip.service.period');
    }
}
