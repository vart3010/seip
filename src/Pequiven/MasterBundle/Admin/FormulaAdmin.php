<?php

namespace Pequiven\MasterBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Admin de formula
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
class FormulaAdmin extends Admin implements \Symfony\Component\DependencyInjection\ContainerAwareInterface
{
    private $container;
    
    protected function configureFormFields(FormMapper $form) {
        $form
            ->add('description')
            ->add('equation')
            ->add('equationReal')
            ->add('formulaLevel')
            ->add('enabled')
            ->add('variables')
            ->add('typeOfCalculation','choice',array(
                'choices' => \Pequiven\MasterBundle\Entity\Formula::getTypesOfCalculation(),
                'translation_domain' => 'PequivenIndicatorBundle'
            ))
            ->add('variableToRealValue')
            ->add('variableToPlanValue')
        ;
    }
    
    protected function configureDatagridFilters(DatagridMapper $filter) {
        $filter
            ->add('description')
            ->add('equation')
            ->add('equationReal')
            ->add('enabled')
            ;
    }
    
    protected function configureListFields(ListMapper $list) {
        $list
            ->addIdentifier('description')
            ->addIdentifier('equation')
            ->add('equationReal')
            ->add('enabled')
            ;
    }
    
    public function preUpdate($object) 
    {
        $indicatorService = $this->container->get('pequiven_indicator.service.inidicator');
        $errorFormula = $indicatorService->validateFormula($object);
        
        if($errorFormula !== null){
            $flashBag = $this->getRequest()->getSession()->getFlashBag();
            $flashBag->add("error",$errorFormula);
//            $this->getRequest()->getSession()->getFlashBag()->add("success",$errorFormula);
        }
        
        
    }
    
    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
        $this->container = $container;
    }
}
