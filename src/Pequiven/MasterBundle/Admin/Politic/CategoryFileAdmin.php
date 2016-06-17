<?php

namespace Pequiven\MasterBundle\Admin\Politic;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Admin\Admin;
//use Pequiven\MasterBundle\Admin\BaseAdmin;

/**
 * Admin de etiquetas de archivos cargadsoa reuniones de circulos de trabajo
 */
class CategoryFileAdmin extends Admin {

    protected function configureShowFields(ShowMapper $show) {
        $show
                ->add('id')
                ->add('description')
        ;
    }

    protected function configureFormFields(FormMapper $form) {
        $form
                ->add('description')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter) {
        $filter
                ->add('description')
        ;
    }

    protected function configureListFields(ListMapper $list) {
        $list
                ->addIdentifier('id')
                ->add('description')
        ;
    }

}
