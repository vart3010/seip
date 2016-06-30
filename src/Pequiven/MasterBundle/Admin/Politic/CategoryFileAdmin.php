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
                ->add('sectionFile', 'choice', array(
                    'choices' => \Pequiven\SEIPBundle\Entity\Politic\CategoryFile::getTypesOfSection(),
                    'translation_domain' => 'sip'
                ))
        ;
    }

    protected function configureFormFields(FormMapper $form) {
        $form
                ->add('description')
                ->add('sectionFile', 'choice', array(
                    'choices' => \Pequiven\SEIPBundle\Entity\Politic\CategoryFile::getTypesOfSection(),
                    'translation_domain' => 'sip'
                ))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter) {
        $filter
                ->add('description')
                ->add('sectionFile', null, array(), 'choice', array(
                    'choices' => \Pequiven\SEIPBundle\Entity\Politic\CategoryFile::getTypesOfSection(),
                    'translation_domain' => 'sip'
                ))
        ;
    }

    protected function configureListFields(ListMapper $list) {
        $list
                ->addIdentifier('id')
                ->add('description')
        ;
    }

}
