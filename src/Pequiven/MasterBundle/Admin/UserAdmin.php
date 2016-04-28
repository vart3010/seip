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
use Sonata\UserBundle\Admin\Entity\UserAdmin as Base;
use Pequiven\SEIPBundle\Model\Common\CommonObject;

/**
 * Administrador de usuario
 *
 * @author Carlos Mendoza <inhack20@tecnocreaciones.com>
 */
class UserAdmin extends Base {

    protected function configureFormFields(\Sonata\AdminBundle\Form\FormMapper $formMapper) {
        $formMapper
                ->tab("Configuración General")
                ->with('Status')
                ->add('username')
                ->add('email')
                ->add('plainPassword', 'text', array(
                    'required' => (!$this->getSubject() || is_null($this->getSubject()->getId()))
                ))
                ->add('locked', null, array('required' => false))
                ->add('expired', null, array('required' => false))
                ->add('enabled', null, array('required' => false))
                ->add('credentialsExpired', null, array('required' => false))
                ->add('statusWorker', 'choice', array(
                    'choices' => CommonObject::getLabelsStatusWorker(),
                    'label' => 'Status del Trabajador',
                    'translation_domain' => 'PequivenSEIPBundle',
                ))
                ->add('affiliatedWorker', null, array(
                    'label' => 'Trabajador de Empresa Filial o Mixta',
                    'required' => false,
                ))
                ->end()
                
                ->with('Localizacion')
                ->add('complejo', 'sonata_type_model_autocomplete', array(
                    'required' => false,
                    'property' => array('description'),
                    'label' => 'Complejo'
                ))
                ->add('gerencia', 'sonata_type_model_autocomplete', array(
                    'required' => false,
                    'property' => array('description'),
                    'label' => 'Gerencia de Primera Línea'
                ))
                ->add('gerenciaSecond', 'sonata_type_model_autocomplete', array(
                    'required' => false,
                    'property' => array('description'),
                    'label' => 'Gerencia de Segunda Línea'
                ))
                ->end()
                
                ->with('Perfil')
                ->add('dateOfBirth', 'birthday', array('required' => false))
                ->add('identification', null, array('required' => false, 'label' => 'Cédula'))
                ->add('firstname', null, array('required' => false))
                ->add('lastname', null, array('required' => false))
                ->add('numPersonal', null, array('required' => false, 'label' => 'Número de Personal'))
                ->add('cellphone', null, array('required' => false, 'label' => 'Número de Celular'))
                ->add('gender', 'sonata_user_gender', array(
                    'required' => true,
                    'translation_domain' => $this->getTranslationDomain()
                ))
                ->add('locale', 'locale', array('required' => false))
                ->add('phone', null, array('required' => false))
                ->end()
                
                ->end()
        ;

        $formMapper
                ->tab("Grupos de Roles")
                ->with("Grupos Disponibles")
                ->add('groups', 'sonata_type_model', array(
                    'required' => false,
                    'expanded' => true,
                    'multiple' => true
                ))
                ->end()
                ->end()
        ;
        
        if ($this->getSubject() && !$this->getSubject()->hasRole('ROLE_SUPER_ADMIN')) {
            $formMapper
                    ->tab("Roles Individuales")
                    ->with("Lista de Roles")
                    ->add('realRoles', 'sonata_security_roles', array(
                        'label' => 'form.label_roles',
                        'expanded' => true,
                        'multiple' => true,
                        'required' => false,
                        'translation_domain' => $this->getTranslationDomain()
                    ))
                    ->end()
                    ->end()
            ;
        }

        $formMapper
                ->tab("Miscelaneos")
                ->with('Redes Sociales')
                ->add('facebookUid', null, array('required' => false))
                ->add('facebookName', null, array('required' => false))
                ->add('twitterUid', null, array('required' => false))
                ->add('twitterName', null, array('required' => false))
                ->add('gplusUid', null, array('required' => false))
                ->add('gplusName', null, array('required' => false))
                ->end()
                ->with('Seguridad')
                ->add('token', null, array('required' => false))
                ->add('twoStepVerificationCode', null, array('required' => false))
                ->end()
                ->end()
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->addIdentifier('username')
                ->add('email')
                ->add('groups')
                ->add('enabled', null, array('editable' => true))
                ->add('createdAt', null, array(
                    'format' => 'Y-m-d h:i:s a'
                ))
        ;

        if ($this->isGranted('ROLE_SEIP_UNLOCKED_USER')) {
            $listMapper->add('locked', null, array('editable' => true));
        }

        if ($this->isGranted('ROLE_ALLOWED_TO_SWITCH')) {
            $listMapper
                    ->add('impersonating', 'string', array('template' => 'SonataUserBundle:Admin:Field/impersonating.html.twig'))
            ;
        }

        if ($this->isGranted('ROLE_SUPER_ADMIN')) {
            $listMapper->add('quarterToLoadOperationProduction', null, array('editable' => true));
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(\Sonata\AdminBundle\Datagrid\DatagridMapper $filterMapper) {
        $filterMapper
                ->add('id')
                ->add('username')
                ->add('firstname')
                ->add('lastname')
                ->add('numPersonal')
                ->add('locked')
                ->add('email')
                ->add('groups')
        ;
    }

    public function preUpdate($user) {
        parent::preUpdate($user);
        if ($user->getConfiguration() == null) {
            $user->setConfiguration(new \Pequiven\SEIPBundle\Entity\User\Configuration());
        }
    }

}
