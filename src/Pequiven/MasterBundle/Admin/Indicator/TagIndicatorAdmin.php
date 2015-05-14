<?php

namespace Pequiven\MasterBundle\Admin\Indicator;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Administrador de la etiqueta del indicador
 *
 */
class TagIndicatorAdmin extends Admin implements \Symfony\Component\DependencyInjection\ContainerAwareInterface
{
    /**
     *
     * @var ContainerAware
     */
    private $container;
    
    protected function configureShowFields(\Sonata\AdminBundle\Show\ShowMapper $show) {
        $show
            ->add('id')
            ->add('valueOfTag')
            ->add('indicator')
            ->add('unitResult')
            ->add('createdAt')
            ->add('createdBy')
            ;
    }
    
    protected function configureFormFields(FormMapper $form) 
    {
        $unitConverter = $this->getUnitConverter();
        $selectUnits = $unitConverter->toArray();
        
        $selectUnitParameters['choices'] = $selectUnits;
        $selectUnitParameters['empty_value'] = '';
        $selectUnitParameters['required'] = false;
        
        $form
            ->add('description')
            ->add('orderShow')
            ->add('valueOfTag')
            ->add('textOfTag')
            ->add('indicator')
            ->add('equationReal',null,array(
                'attr' => array(
                    'rows' => 10
                )
            ))
            ->add('typeTag','choice',array(
                'choices' => \Pequiven\IndicatorBundle\Entity\Indicator\TagIndicator::getLabelTypesOfTag(),
                'translation_domain' => 'PequivenIndicatorBundle'
            ))
            ->add('typeCalculationTag','choice',array(
                'choices' => \Pequiven\IndicatorBundle\Entity\Indicator\TagIndicator::getLabelTypesOfValueInput(),
                'translation_domain' => 'PequivenIndicatorBundle'
            ))
            ->add('showInIndicatorResult',null,array(
                'required' => false,
            ))
            ->add('sourceResult')
            ->add('unitResult',"choice",$selectUnitParameters)
            ;
    }
    
    protected function configureDatagridFilters(DatagridMapper $filter) {
        $filter
            ->add('indicator')
            ->add('description')
            ->add('period')
            ;
    }
    
    protected function configureListFields(ListMapper $list) {
         $list
            ->addIdentifier('id')
            ->add('description')
            ->add('valueOfTag')
            ->add('textOfTag')
            ->add('indicator')
            ;
    }
    
    protected function configureRoutes(\Sonata\AdminBundle\Route\RouteCollection $collection) 
    {
//        $collection->remove('create');
    }
    
//    public function toString($object) 
//    {
//        $toString = '-';
//        if($object->getId() > 0){
//            $toString = $object->getPeriod()->getDescription().' - '.$object->getRef().' - '.$object->getDescription();
//        }
//        return \Pequiven\SEIPBundle\Service\ToolService::truncate($toString,array('limit' => 50));
//    }
    
    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) 
    {
        $this->container = $container;
    }
    
    /**
     * 
     * @return \Tecnocreaciones\Bundle\ToolsBundle\Service\UnitConverter
     */
    private function getUnitConverter()
    {
        return $this->container->get('tecnocreaciones_tools.unit_converter');
    }
}
