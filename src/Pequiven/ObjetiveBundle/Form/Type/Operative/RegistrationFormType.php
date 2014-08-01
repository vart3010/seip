<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\ObjetiveBundle\Form\Type\Operative;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Pequiven\ObjetiveBundle\PequivenObjetiveBundle;
use Pequiven\ObjetiveBundle\Entity\ObjetiveLevel;

use Pequiven\ObjetiveBundle\Form\EventListener\AddObjetiveLevelFieldListener;
use Pequiven\ObjetiveBundle\Form\EventListener\AddLineStrategicFieldListener;
use Pequiven\ObjetiveBundle\Form\EventListener\AddObjetiveParentStrategicFieldListener;
use Pequiven\ObjetiveBundle\Form\EventListener\AddObjetiveParentTacticFieldListener;
use Pequiven\ObjetiveBundle\Form\EventListener\AddComplejoFieldListener;
use Pequiven\ObjetiveBundle\Form\EventListener\AddGerenciaFieldListener;
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
        $user = $securityContext->getToken()->getUser();
        
        //Nommbre del Complejo del usuario que esta logueado
        $builder->add('complejo_name','hidden',array('data' => $user->getComplejo()->getComplejoName(),'mapped' => false));
        
        //Nivel del objetivo del objetivo a crear
        $builder->add('objetive_level_name','hidden',array('data' => $objectObjLevel->getLevelName(),'mapped' => false));
        
        //Referencia del objetivo a crear
        $builder->add('ref','text',array('label' => 'form.ref', 'label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle', 'read_only' => true,'attr' => array('class' => 'input')));
        
        //Nombre del objetivo a crear
        $builder->add('description', 'textarea', array('label' => 'form.objetive', 'label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle','attr' => array('cols' => 50, 'rows' => 5,'class' => 'input')));

        //Nivel del objetivo a crear
        $builder->addEventSubscriber(new AddObjetiveLevelFieldListener(array('level' => ObjetiveLevel::LEVEL_OPERATIVO)));
        
        //Línea estratégica del objetivo a crear
        $builder->addEventSubscriber(new AddLineStrategicFieldListener());
        
        //Objetivo Estratégico al cual impactará el objetivo a crear
        $builder->addEventSubscriber(new AddObjetiveParentStrategicFieldListener(array('typeOperative' => true)));
        
        //Objetivo Estratégico al cual impactará el objetivo a crear
        $builder->addEventSubscriber(new AddObjetiveParentTacticFieldListener());
        
        //Complejo(s) donde impactará(n) el objetivo a crear (Depndiendo de si pertenece a la Sede Corporativa)
        $builder->addEventSubscriber(new AddComplejoFieldListener(array('typeOperative' => true)));
        
        //Gerencia donde impactará el objetivo a crear
        $builder->addEventSubscriber(new AddGerenciaFieldListener());
        
        //Peso del Objetivo
        $builder->add('weight','percent',array('label' => 'form.weight','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle','attr' => array('placeholder' => "100,000"), 'required' => false));
        //Meta del Objetivo
        $builder->add('goal','percent',array('label' => 'form.goal','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle','attr' => array('placeholder' => "100,000")));
        
        //Rango de Gestión
            //Rango Alto del Objetivo
            $builder->add('rankTop','percent',array('label' => 'form.rankTop','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle','attr' => array('placeholder' => "100,000"), 'required' => false));
            //Rango Medio Alto del Objetivo
            $builder->add('rankMiddleTop','percent',array('label' => 'form.rankMiddleTop','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle','attr' => array('placeholder' => "100,000"), 'required' => false));
            //Rango Medio Bajo del Objetivo
            $builder->add('rankMiddleBottom','percent',array('label' => 'form.rankMiddleBottom','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle','attr' => array('placeholder' => "100,000"), 'required' => false));
            //Rango Bajo del Objetivo
            $builder->add('rankBottom','percent',array('label' => 'form.rankBottom','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle','attr' => array('placeholder' => "100,000"), 'required' => false));
        
        //Tipo de Evaluación
            //Evaluar por Indicador
            $builder->add('evalIndicator','checkbox',array('label' => 'form.evalIndicator','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle', 'required' => false));
            //Evaluar por Programa de Gestión
            $builder->add('evalArrangementProgram','checkbox',array('label' => 'form.evalArrangementProgram','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle', 'required' => false));
        
         //Forma de Evaluación   
            //Evaluar por Promedio Simple
            $builder->add('evalSimpleAverage','checkbox',array('label' => 'form.evalSimpleAverage','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle', 'required' => false));
            //Evaluar por Promedio Ponderado
            $builder->add('evalWeightedAverage','checkbox',array('label' => 'form.evalWeightedAverage','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle', 'required' => false));
    }
    
    public function getName(){
        return 'pequiven_objetive_operative_registration';
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver){
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\ObjetiveBundle\Entity\Objetive',
            ));
    }
}