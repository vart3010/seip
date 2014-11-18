<?php

namespace Pequiven\MasterBundle\Admin\Indicator;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Administrador de las frecuencias de notificacion de los indicadores
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
class FrequencyNotificationIndicatorAdmin extends Admin
{
    protected function configureFormFields(FormMapper $form) {
        $form
            ->add('description')
            ->add('days')
            ->add('enabled')
                ;
    }
    
    protected function configureDatagridFilters(DatagridMapper $filter) {
        $filter
            ->add('description')
            ->add('days')
            ->add('enabled')
        ;
    }
    
    protected function configureListFields(ListMapper $list) {
        $list
            ->addIdentifier('description')
            ->add('days')
            ->add('enabled')
            ;
    }
}
