<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\MasterBundle\Form\Type\Gerencia;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Pequiven\MasterBundle\PequivenMasterBundle;
use Pequiven\MasterBundle\Entity\Gerencia;

use Pequiven\MasterBundle\Form\EventListener\AddComplejoFieldListener;
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
        //Nombre de la Gerencia de 1ra línea a crear
        $builder->add('description', 'textarea', array('label' => 'form.gerencia_first', 'label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenMasterBundle','attr' => array('cols' => 50, 'rows' => 5,'class' => 'input')));
    }
    
    public function getName(){
        return 'pequiven_master_gerenciaFirst_registration';
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver){
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\MasterBundle\Entity\Gerencia',
            ));
    }
}
