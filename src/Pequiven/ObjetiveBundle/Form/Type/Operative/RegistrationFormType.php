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
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Pequiven\ObjetiveBundle\PequivenObjetiveBundle;
use Pequiven\ObjetiveBundle\Entity\ObjetiveLevel;
use Pequiven\MasterBundle\Entity\ArrangementRangeType;

use Pequiven\ObjetiveBundle\Form\EventListener\AddObjetiveLevelFieldListener;
use Pequiven\ObjetiveBundle\Form\EventListener\AddLineStrategicFieldListener;
use Pequiven\ObjetiveBundle\Form\EventListener\AddObjetiveParentStrategicFieldListener;
use Pequiven\ObjetiveBundle\Form\EventListener\AddObjetiveParentTacticFieldListener;
use Pequiven\ObjetiveBundle\Form\EventListener\AddComplejoFieldListener;
use Pequiven\ObjetiveBundle\Form\EventListener\AddGerenciaFieldListener;
use Pequiven\ObjetiveBundle\Form\EventListener\AddGerenciaSecondFieldListener;

use Pequiven\ObjetiveBundle\Form\EventListener\AddIndicatorStrategicFieldListener;
/**
 * Description of RegistrationFormType
 *
 * @author matias
 */
class RegistrationFormType extends AbstractType {
    
    protected $container;
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
    //put your code here
    public function buildForm(FormBuilderInterface $builder, array $options){
        $container = $this->container;
        $securityContext = $container->get('security.context');
        $em = $container->get('doctrine')->getManager();
        $user = $securityContext->getToken()->getUser();
        
        //Nombre del Complejo del usuario que esta logueado
        $builder->add('complejo_name','hidden',array('data' => $user->getComplejo()->getRef(),'mapped' => false));
        
        //Rol del usuario que esta logueado
        $array = $user->getRoles();
        $builder->add('role_name','hidden',array('data' => $array[0],'mapped' => false));
        
        //Línea estratégica del objetivo a crear
        $builder->addEventSubscriber(new AddLineStrategicFieldListener($this->container,array('typeOperative' => true)));
        
        //Objetivo Estratégico al cual impactará el objetivo a crear
        $builder->addEventSubscriber(new AddObjetiveParentStrategicFieldListener($this->container,array('typeOperative' => true)));
        
        //Objetivo Estratégico al cual impactará el objetivo a crear
        $builder->addEventSubscriber(new AddObjetiveParentTacticFieldListener($this->container));
        
        if($securityContext->isGranted(array('ROLE_DIRECTIVE','ROLE_DIRECTIVE_AUX'))){
            //Complejo(s) donde impactará(n) el objetivo a crear (Depndiendo de si pertenece a la Sede Corporativa)
            $builder->addEventSubscriber(new AddComplejoFieldListener($this->container,array('typeOperative' => true)));
            //Gerencia donde impactará el objetivo a crear
            $builder->addEventSubscriber(new AddGerenciaFieldListener($this->container));
        }
               
        if($securityContext->isGranted(array('ROLE_DIRECTIVE','ROLE_DIRECTIVE_AUX','ROLE_GENERAL_COMPLEJO','ROLE_GENERAL_COMPLEJO_AUX','ROLE_MANAGER_FIRST','ROLE_MANAGER_FIRST_AUX'))){
            $builder->addEventSubscriber(new AddGerenciaSecondFieldListener($this->container));
            $builder->add('check_gerencia','checkbox',array('label' => 'form.question.allGerenciasSecondFull','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle', 'required' => false, 'mapped' => false));
        }
        
        //Nombre del objetivo a crear
        $builder->add('description', 'textarea', array('label' => 'form.objetive', 'label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle','attr' => array('cols' => 50, 'rows' => 5,'class' => 'input')));
        //Referencia del objetivo a crear
        $builder->add('ref','text',array('label' => 'form.ref', 'label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle', 'read_only' => true,'attr' => array('class' => 'input','size' => 5)));        
        //Peso del Objetivo
        $builder->add('weight','percent',array('label' => 'form.weight','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle','attr' => array('placeholder' => "100"), 'required' => false));
        //Meta del Objetivo
        $builder->add('goal','percent',array('label' => 'form.goal','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle','attr' => array('placeholder' => "100")));
        
        //Rango de Gestión 
            $objectArrangementRangeType = new ArrangementRangeType();
            $rangeTypeNameArray = $objectArrangementRangeType->getRangeTypeNameArray();
            
            //Rango de Gestión Alto
            $selectRangeTypeTop = $em->getRepository('PequivenMasterBundle:ArrangementRangeType')->findBy(array('description' => array($rangeTypeNameArray[ArrangementRangeType::RANGE_TYPE_TOP_BASIC],$rangeTypeNameArray[ArrangementRangeType::RANGE_TYPE_TOP_MIXED])));
            $builder->add('arrangementRangeTypeTop','entity',array('label' => 'form.arrangementRangeTypeTop','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenIndicatorBundle', 'expanded' => true, 'multiple' => false, 'property' => 'description','class' => 'PequivenMasterBundle:ArrangementRangeType','empty_value' => false, 'required' => false,'choices' => $selectRangeTypeTop,'mapped' => false));
            $builder->add('typeArrangementRangeTypeTop','hidden',array('data' => '','mapped' => false));
            //Rango Alto Básico
                $builder->add('rankTopBasic','percent',array('label_attr' => array('class' => 'label'),'attr' => array('placeholder' => "100",'size' => '8'), 'required' => false,'mapped' => false));
                $builder->add('opRankTopBasic','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));
            //Rango Alto Mixto
                $builder->add('rankTopMixedTop','percent',array('label_attr' => array('class' => 'label'),'attr' => array('placeholder' => "100",'size' => '8'), 'required' => false,'mapped' => false));
                $builder->add('opRankTopMixedTop','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));
                $builder->add('rankTopMixedBottom','percent',array('label_attr' => array('class' => 'label'),'attr' => array('placeholder' => "100",'size' => '8'), 'required' => false,'mapped' => false));
                $builder->add('opRankTopMixedBottom','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));

            //Rango de Gestión Medio Alto
            $selectRangeTypeMiddleTop = $em->getRepository('PequivenMasterBundle:ArrangementRangeType')->findBy(array('description' => array($rangeTypeNameArray[ArrangementRangeType::RANGE_TYPE_MIDDLE_TOP_BASIC],$rangeTypeNameArray[ArrangementRangeType::RANGE_TYPE_MIDDLE_TOP_MIXED])));
            $builder->add('arrangementRangeTypeMiddleTop','entity',array('label' => 'form.arrangementRangeTypeMiddleTop','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenIndicatorBundle', 'expanded' => true, 'multiple' => false, 'property' => 'description','class' => 'PequivenMasterBundle:ArrangementRangeType','empty_value' => false, 'required' => false,'choices' => $selectRangeTypeMiddleTop,'mapped' => false));
            $builder->add('typeArrangementRangeTypeMiddleTop','hidden',array('data' => '','mapped' => false));
            //Rango Medio Alto Básico
                $builder->add('rankMiddleTopBasic','percent',array('label_attr' => array('class' => 'label'),'attr' => array('placeholder' => "100",'size' => '8'), 'required' => false,'mapped' => false));
                $builder->add('opRankMiddleTopBasic','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));
            //Rango Medio Alto Mixto
                $builder->add('rankMiddleTopMixedTop','percent',array('label_attr' => array('class' => 'label'),'attr' => array('placeholder' => "100",'size' => '8'), 'required' => false,'mapped' => false));
                $builder->add('opRankMiddleTopMixedTop','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));
                $builder->add('rankMiddleTopMixedBottom','percent',array('label_attr' => array('class' => 'label'),'attr' => array('placeholder' => "100",'size' => '8'), 'required' => false,'mapped' => false));
                $builder->add('opRankMiddleTopMixedBottom','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));
            
            //Rango de Gestión Medio Bajo
            $selectRangeTypeMiddleBottom = $em->getRepository('PequivenMasterBundle:ArrangementRangeType')->findBy(array('description' => array($rangeTypeNameArray[ArrangementRangeType::RANGE_TYPE_MIDDLE_BOTTOM_BASIC],$rangeTypeNameArray[ArrangementRangeType::RANGE_TYPE_MIDDLE_BOTTOM_MIXED])));
            $builder->add('arrangementRangeTypeMiddleBottom','entity',array('label' => 'form.arrangementRangeTypeMiddleBottom','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenIndicatorBundle', 'expanded' => true, 'multiple' => false, 'property' => 'description','class' => 'PequivenMasterBundle:ArrangementRangeType','empty_value' => false, 'required' => false,'choices' => $selectRangeTypeMiddleBottom,'mapped' => false));
            $builder->add('typeArrangementRangeTypeMiddleBottom','hidden',array('data' => '','mapped' => false));
            //Rango Medio Bajo Básico
                $builder->add('rankMiddleBottomBasic','percent',array('label_attr' => array('class' => 'label'),'attr' => array('placeholder' => "100",'size' => '8'), 'required' => false,'mapped' => false));
                $builder->add('opRankMiddleBottomBasic','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));
            //Rango Medio Bajo Mixto
                $builder->add('rankMiddleBottomMixedTop','percent',array('label_attr' => array('class' => 'label'),'attr' => array('placeholder' => "100",'size' => '8'), 'required' => false,'mapped' => false));
                $builder->add('opRankMiddleBottomMixedTop','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));
                $builder->add('rankMiddleBottomMixedBottom','percent',array('label_attr' => array('class' => 'label'),'attr' => array('placeholder' => "100",'size' => '8'), 'required' => false,'mapped' => false));
                $builder->add('opRankMiddleBottomMixedBottom','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));

            //Rango de Gestión Bajo
            $selectRangeTypeBottom = $em->getRepository('PequivenMasterBundle:ArrangementRangeType')->findBy(array('description' => array($rangeTypeNameArray[ArrangementRangeType::RANGE_TYPE_BOTTOM_BASIC],$rangeTypeNameArray[ArrangementRangeType::RANGE_TYPE_BOTTOM_MIXED])));
            $builder->add('arrangementRangeTypeBottom','entity',array('label' => 'form.arrangementRangeTypeBottom','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenIndicatorBundle', 'expanded' => true, 'multiple' => false, 'property' => 'description','class' => 'PequivenMasterBundle:ArrangementRangeType','empty_value' => false, 'required' => false,'choices' => $selectRangeTypeBottom,'mapped' => false));
            $builder->add('typeArrangementRangeTypeBottom','hidden',array('data' => '','mapped' => false,'mapped' => false));
            //Rango Bajo Básico
                $builder->add('rankBottomBasic','percent',array('label_attr' => array('class' => 'label'),'attr' => array('placeholder' => "100",'size' => '8'), 'required' => false,'mapped' => false));
                $builder->add('opRankBottomBasic','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));
            //Rango Bajo Mixto
                $builder->add('rankBottomMixedTop','percent',array('label_attr' => array('class' => 'label'),'attr' => array('placeholder' => "100",'size' => '8'), 'required' => false,'mapped' => false));
                $builder->add('opRankBottomMixedTop','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));
                $builder->add('rankBottomMixedBottom','percent',array('label_attr' => array('class' => 'label'),'attr' => array('placeholder' => "100",'size' => '8'), 'required' => false,'mapped' => false));
                $builder->add('opRankBottomMixedBottom','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));
        
        //Tipo de Evaluación
            //Evaluar por Indicador
            $builder->add('evalIndicator','checkbox',array('label' => 'form.evalIndicator','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle', 'required' => false));
            //Evaluar por Programa de Gestión
            $builder->add('evalArrangementProgram','checkbox',array('label' => 'form.evalArrangementProgram','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle', 'required' => false));
        
            //Indicadores asociados al objetivo a crear
            $builder->addEventSubscriber(new AddIndicatorStrategicFieldListener());
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
