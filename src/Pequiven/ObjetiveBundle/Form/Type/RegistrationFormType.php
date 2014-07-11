<?php
namespace Pequiven\ObjetiveBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Pequiven\ObjetiveBundle\Form\EventListener\AddObjetiveLevelFieldListener;
use Pequiven\ObjetiveBundle\Form\EventListener\AddComplejoFieldListener;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RegistrationFormType
 *
 * @author matias
 */
class RegistrationFormType extends AbstractType {
    //put your code here
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder->add('description', 'text', array('label' => 'form.objetive', 'translation_domain' => 'PequivenObjetiveBundle'))
                ->add('objetiveLevel', 'entity', array('label' => 'form.objetive_level', 'translation_domain' => 'PequivenObjetiveBundle','class' => 'PequivenObjetiveBundle:ObjetiveLevel', 'property' => 'description','empty_value' => ''))
                ->add('complejo', 'entity', array('label' => 'form.complejo', 'translation_domain' => 'PequivenObjetiveBundle','class' => 'PequivenMasterBundle:Complejo', 'property' => 'description','empty_value' => ''))
                ->addEventSubscriber(new AddComplejoFieldListener())
                ->add('parent','entity',array('label' => 'form.parent', 'translation_domain' => 'PequivenObjetiveBundle', 'class' => 'PequivenObjetiveBundle:Objetive', 'property' => 'description', 'empty_value' => ''))
                ->add('save', 'submit',array('label' => 'form.register', 'translation_domain' => 'PequivenObjetiveBundle'))
            ;
        //
//                        ->add('dueDate', null, array('widget' => 'single_text'))
    }
    
    public function getName(){
        return 'pequiven_objetive_registration';
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver){
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\ObjetiveBundle\Entity\Objetive',
            ));
    }
}
