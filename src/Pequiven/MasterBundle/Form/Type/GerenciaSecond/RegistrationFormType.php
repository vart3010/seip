<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\MasterBundle\Form\Type\GerenciaSecond;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Pequiven\MasterBundle\PequivenMasterBundle;

use Pequiven\MasterBundle\Form\EventListener\AddComplejoFieldListener;
use Pequiven\MasterBundle\Form\EventListener\AddGerenciaFirstFieldListener;
/**
 * Description of RegistrationFormType
 *
 * @author matias
 */
class RegistrationFormType extends AbstractType {
    //put your code here
    
    public function buildForm(FormBuilderInterface $builder, array $options){
        $container = PequivenMasterBundle::getContainer();
        $securityContext = $container->get('security.context');
        $em = $container->get('doctrine')->getManager();
        $user = $securityContext->getToken()->getUser();

        //Select del Complejo
        $builder->addEventSubscriber(new AddComplejoFieldListener());
        //Select de Gerencia de 1ra línea
        $builder->addEventSubscriber(new AddGerenciaFirstFieldListener());
        //Nombre de la Gerencia de 2da línea a crear
        $builder->add('description', 'textarea', array('label' => 'form.gerencia_second', 'label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenMasterBundle','attr' => array('cols' => 50, 'rows' => 5,'class' => 'input')));
        
    }
    
    public function getName(){
        return 'pequiven_master_gerenciaSecond_registration';
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver){
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\MasterBundle\Entity\GerenciaSecond',
            ));
    }
}
