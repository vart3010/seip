<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\MasterBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Grupos de Indicadores
 *
 * @author Gilbert <glavrjk@gmail.com>
 */
class IndicatorGroupAdmin extends Admin {

    private $container;

    protected function configureShowFields(\Sonata\AdminBundle\Show\ShowMapper $show) {
        $show
                ->add('id')
                ->add('codigo')
                ->add('description')
                ->add('parent')
                ->add('enabled')
        ;
    }

    protected function configureFormFields(FormMapper $form) {
        $form
//               >add('id')
                ->add('codigo')
                ->add('description')
                ->add('logo')
                ->add('color', 'sonata_type_color_selector', array(
                    'required' => false,
                ))
//                ->add('indicators', 'sonata_type_model_autocomplete', array(                    
//                    'property' => array('ref', 'description'),
//                    'multiple' => true,
//                    'required' => false,
//                    'label' => 'Indicadores Asociados'
//                ))
                ->add('parent', 'sonata_type_model_autocomplete', array(
                    'class' => 'Pequiven\IndicatorBundle\Entity\IndicatorGroup',
                    'property' => array('description'),
                    'multiple' => false,
                    "required" => false,
                    'label' => 'Grupo de Indicadores Padre',
                    'attr' => array('class' => 'input input-large'),
                ))
                
                ->add('enabled', null, array(
                    "required" => false,
                ))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter) {
        $filter
                ->add('id')
                ->add('codigo')
                ->add('description')
                ->add('enabled')
        ;
    }

    protected function configureListFields(ListMapper $list) {
        $list
                ->addIdentifier('id')
                ->add('codigo')
                ->add('description')
                ->add('enabled');
    }

//    public function toString($object) {
//        $toString = '-';
//        if ($object->getId() > 0) {
//            $toString = $object->getCharge();
//        }
//        return \Pequiven\SEIPBundle\Service\ToolService::truncate($toString, array('limit' => 100));
//    }

    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
        $this->container = $container;
    }

}
