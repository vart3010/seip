<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\MasterBundle\Admin\Indicator;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Archivos de indicador
 *
 * @author Victor Tortolero <vart10.30@gmail.com>
 */
class IndicatorFileAdmin extends \Pequiven\MasterBundle\Admin\BaseAdmin {

    protected function configureShowFields(\Sonata\AdminBundle\Show\ShowMapper $show) {
        $show
                ->add('id')
                ->add('indicator')
                ->add('nameFileOriginal')
                ->add('extensionFile')

        ;
        parent::configureShowFields($show);
    }

    protected function configureFormFields(FormMapper $form) {
        $form
                ->add('indicator')
                ->add('nameFileOriginal')
                ->add('description')
                ->add('extensionFile')

        ;
        parent::configureFormFields($form);
    }
    

    protected function configureDatagridFilters(DatagridMapper $filter) {
        $filter
                ->add('id')
                ->add('indicator')
                ->add('nameFileOriginal')
                ->add('extensionFile')

        ;
        parent::configureDatagridFilters($filter);
    }

    protected function configureListFields(ListMapper $list) {
        $list
                ->addIdentifier('id')
                ->add('image', null, array(
                    'template' => 'PequivenSEIPBundle:Planning:showImage.html.twig'
                ))
                ->add('indicator')
                ->add('nameFileOriginal')
                ->add('extensionFile')

        ;
        parent::configureListFields($list);
    }

}
