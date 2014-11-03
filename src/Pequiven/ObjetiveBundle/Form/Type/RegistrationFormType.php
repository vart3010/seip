<?php
namespace Pequiven\ObjetiveBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Pequiven\ObjetiveBundle\PequivenObjetiveBundle;
use Pequiven\ObjetiveBundle\Entity\ObjetiveLevel;

use Pequiven\ObjetiveBundle\Form\EventListener\AddObjetiveLevelFieldListener;
use Pequiven\ObjetiveBundle\Form\EventListener\AddLineStrategicFieldListener;
use Pequiven\ObjetiveBundle\Form\EventListener\AddComplejoFieldListener;
use Pequiven\ObjetiveBundle\Form\EventListener\AddGerenciaFieldListener;
use Pequiven\ObjetiveBundle\Form\EventListener\AddObjetiveParentStrategicFieldListener;
use Pequiven\ObjetiveBundle\Form\EventListener\AddObjetiveParentTacticFieldListener;
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
        $container = PequivenObjetiveBundle::getContainer();
        $securityContext = $container->get('security.context');
        $em = $container->get('doctrine')->getManager();
        $objetiveLevel = new ObjetiveLevel();
        $objectObjLevel = $objetiveLevel->typeObjetiveLevel($securityContext,array('em' => $em));
        
        $builder->add('objetive_level_name','hidden',array('data' => $objectObjLevel->getLevelName(),'mapped' => false));
        
        $builder->add('description', 'textarea', array('label' => 'form.objetive', 'label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle','attr' => array('cols' => 50, 'rows' => 5)));
//        if(\Pequiven\ObjetiveBundle\PequivenObjetiveBundle::getContainer()->get('security.context')->isGranted(array('ROLE_DIRECTIVE'))){
//            $builder->add('complejo2', 'entity', array('label' => 'form.complejo', 'translation_domain' => 'PequivenObjetiveBundle','class' => 'PequivenMasterBundle:Complejo', 'property' => 'description','empty_value' => 'Todo','expanded' => true));
//        } else{
//            $builder->add('complejo2', 'entity', array('label' => 'form.complejo', 'translation_domain' => 'PequivenObjetiveBundle','class' => 'PequivenMasterBundle:Complejo', 'property' => 'description','empty_value' => ''));
//        }
//        
        //Nivel del objetivo a crear
        $builder->addEventSubscriber(new AddObjetiveLevelFieldListener());
        
        //Línea estratégica del objetivo a crear
        if($securityContext->isGranted(array('ROLE_DIRECTIVE','ROLE_DIRECTIVE_AUX'))){
            $builder->addEventSubscriber(new AddLineStrategicFieldListener());
        }
        
        //Complejo(s) donde impactará(n) el objetivo a crear
        $builder->addEventSubscriber(new AddComplejoFieldListener());
        
        //Gerencia donde impactará el objetivo a crear
        if($securityContext->isGranted(array('ROLE_MANAGER_FIRST','ROLE_MANAGER_FIRST_AUX','ROLE_MANAGER_SECOND','ROLE_MANAGER_SECOND_AUX'))){
            $builder->addEventSubscriber(new AddGerenciaFieldListener());
        }
        
        //Objetivo Estratégico y Táctico, dependiendo del Rol del Usuario Gerente 1ra Línea o 2da Línea respectivamente
        if($securityContext->isGranted(array('ROLE_MANAGER_FIRST','ROLE_MANAGER_FIRST_AUX'))){
            $builder->addEventSubscriber(new AddObjetiveParentStrategicFieldListener());
            //$builder->add('parent','entity',array('label' => 'form.parent_strategic', 'translation_domain' => 'PequivenObjetiveBundle', 'class' => 'PequivenObjetiveBundle:Objetive', 'property' => 'description', 'empty_value' => ''));
        }elseif($securityContext->isGranted(array('ROLE_MANAGER_SECOND','ROLE_MANAGER_SECOND_AUX'))){
            $builder->addEventSubscriber(new AddObjetiveParentStrategicFieldListener());
            $builder->addEventSubscriber(new AddObjetiveParentTacticFieldListener());
        }
        
        //Peso del Objetivo
        $builder->add('weight','percent',array('label' => 'form.weight','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle','attr' => array('placeholder' => "100.000"), 'required' => false));
        //Meta del Objetivo
        $builder->add('goal','percent',array('label' => 'form.goal','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle','attr' => array('placeholder' => "100.000")));
        
        //Rango de Gestión
            //Rango Alto del Objetivo
            $builder->add('rankTop','percent',array('label' => 'form.rankTop','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle','attr' => array('placeholder' => "100.000")));
            //Rango Medio Alto del Objetivo
            $builder->add('rankMiddleTop','percent',array('label' => 'form.rankMiddleTop','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle','attr' => array('placeholder' => "100.000")));
            //Rango Medio Bajo del Objetivo
            $builder->add('rankMiddleBottom','percent',array('label' => 'form.rankMiddleBottom','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle','attr' => array('placeholder' => "100.000")));
            //Rango Bajo del Objetivo
            $builder->add('rankBottom','percent',array('label' => 'form.rankBottom','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle','attr' => array('placeholder' => "100.000")));
        
        //Tipo de Evaluación    
            //Evaluar por Objetivo
            $builder->add('evalObjetive','checkbox',array('label' => 'form.evalObjetive','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle', 'required' => false));
            //Evaluar por Indicador
            $builder->add('evalIndicator','checkbox',array('label' => 'form.evalIndicator','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle', 'required' => false));
            if($securityContext->isGranted(array('ROLE_MANAGER_FIRST','ROLE_MANAGER_FIRST_AUX','ROLE_MANAGER_SECOND','ROLE_MANAGER_SECOND_AUX'))){
                //Evaluar por Programa de Gestión
                $builder->add('evalArrangementProgram','checkbox',array('label' => 'form.evalArrangementProgram','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle', 'required' => false));
            }
        
         //Forma de Evaluación   
            //Evaluar por Promedio Simple
            $builder->add('evalSimpleAverage','checkbox',array('label' => 'form.evalSimpleAverage','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle', 'required' => false));
            //Evaluar por Promedio Ponderado
            $builder->add('evalWeightedAverage','checkbox',array('label' => 'form.evalWeightedAverage','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle', 'required' => false));
        
//        if($securityContext->isGranted(array('ROLE_MANAGER_SECOND'))){
//            //Peso del Objetivo
//            $builder->add('weight','percent',array('label' => 'form.weight','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle','attr' => array('placeholder' => "100.00",'data-mask' => '999.99')));
//        }
        
        //$builder->add('save', 'submit',array('label' => 'form.register', 'translation_domain' => 'PequivenObjetiveBundle'));
        
//        if(\Pequiven\ObjetiveBundle\PequivenObjetiveBundle::getContainer()->get('security.context')->isGranted(array('ROLE_DIRECTIVE'))){
//            $builder->add('complejo2', 'entity', array('label' => 'form.complejo', 'translation_domain' => 'PequivenObjetiveBundle','class' => 'PequivenMasterBundle:Complejo', 'property' => 'description','empty_value' => '','expanded' => true));
//        }
        
        //->add('objetiveLevel', 'entity', array('label' => 'form.objetive_level', 'translation_domain' => 'PequivenObjetiveBundle','class' => 'PequivenObjetiveBundle:ObjetiveLevel', 'property' => 'description','empty_value' => ''))
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
