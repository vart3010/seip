<?php

namespace Pequiven\MasterBundle\Admin\User;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Configuracion del usuario
 *
 * @author inhack20
 */
class ConfigurationAdmin extends Admin
{
    protected function configureFormFields(FormMapper $form) {
        $form
            ->add('localizations')
                ;
    }
}
