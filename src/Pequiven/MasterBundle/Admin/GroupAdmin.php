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

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\UserBundle\Admin\Entity\GroupAdmin as BaseGroupAdmin;

/**
 * Description of GroupAdmin
 *
 * @author Carlos Mendoza <inhack20@tecnocreaciones.com>
 */
class GroupAdmin extends BaseGroupAdmin {

    protected function configureShowFields(\Sonata\AdminBundle\Show\ShowMapper $show) {
        $show
                ->add('name')
                ->add('description')
                ->add('level')
        ;
    }

    protected function configureFormFields(\Sonata\AdminBundle\Form\FormMapper $formMapper) {
        $formMapper
                ->add('name')
                ->add('description')
                ->add('level')
                ->add('typeRol', 'choice', array(
                    'choices' => \Pequiven\MasterBundle\Entity\Rol::getTypeOfRol(),
                    'translation_domain' => "PequivenMasterBundle"
                ))
                ->add('roles', 'sonata_security_roles', array(
                    'expanded' => true,
                    'multiple' => true,
                    'required' => false,
                    'translation_domain' => $this->getTranslationDomain()
                ))
        ;
    }

    protected function configureDatagridFilters(\Sonata\AdminBundle\Datagrid\DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('name')
                ->add('description')
                ->add('typeRol', null, array(), 'choice', array(
                    'choices' => \Pequiven\MasterBundle\Entity\Rol::getTypeOfRol(),
                    'translation_domain' => "PequivenMasterBundle"
                ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->addIdentifier('description')
                ->add('roles', null, array(
                    'translation_domain' => $this->getTranslationDomain()
                ))
        ;
    }

    public function prePersist($object) {
//        $object->setDescription($object->getName());
    }

    public function preUpdate($object) {
//        $object->setDescription($object->getName());
    }

}
