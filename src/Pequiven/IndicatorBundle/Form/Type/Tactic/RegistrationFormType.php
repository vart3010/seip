<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\IndicatorBundle\Form\Type\Tactic;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Pequiven\IndicatorBundle\PequivenIndicatorBundle;
use Pequiven\MasterBundle\Entity\ArrangementRangeType;

use Pequiven\ObjetiveBundle\Form\EventListener\AddLineStrategicFieldListener;
use Pequiven\IndicatorBundle\Form\EventListener\AddFormulaFieldListener;
/**
 * Description of RegistrationFormType
 *
 * @author matias
 */
class RegistrationFormType extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options){
        $container = PequivenIndicatorBundle::getContainer();
        $securityContext = $container->get('security.context');
        $em = $container->get('doctrine')->getManager();
        
        //Referencia del Objetivo Táctico al cual se le podrían añadir los indicadores creados
        $builder->add('refObjetive','hidden',array('data' => '','mapped' => false));
        //Nombre del indicador a crear
        $builder->add('description', 'textarea', array('label' => 'form.indicator', 'label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenIndicatorBundle','attr' => array('cols' => 50, 'rows' => 5,'class' => 'input')));
        //Referencia del indicador a crear
        $builder->add('ref','text',array('label' => 'form.ref', 'label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenIndicatorBundle', 'read_only' => true,'attr' => array('class' => 'input','size' => 7)));
        
        //Peso del Objetivo
//        $builder->add('weight','percent',array('label' => 'form.weight','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenIndicatorBundle','attr' => array('placeholder' => "100,000"), 'required' => false));
        //Meta del Objetivo
        $builder->add('goal','percent',array('label' => 'form.goal','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenIndicatorBundle','attr' => array('placeholder' => "100,000")));
        //Fórmula del indicador a crear
        $builder->addEventSubscriber(new AddFormulaFieldListener());

        $objectArrangementRangeType = new ArrangementRangeType();
        $rangeTypeNameArray = $objectArrangementRangeType->getRangeTypeNameArray();
        //Rango de Gestión Alto
        $selectRangeTypeTop = $em->getRepository('PequivenMasterBundle:ArrangementRangeType')->findBy(array('description' => array($rangeTypeNameArray[ArrangementRangeType::RANGE_TYPE_TOP_BASIC],$rangeTypeNameArray[ArrangementRangeType::RANGE_TYPE_TOP_COMPOUND])));
        $builder->add('arrangementRangeTypeTop','entity',array('label' => 'form.arrangementRangeType','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenIndicatorBundle', 'expanded' => true, 'multiple' => false, 'property' => 'description','class' => 'PequivenMasterBundle:ArrangementRangeType','empty_value' => false, 'required' => false,'choices' => $selectRangeTypeTop,'mapped' => false));
        $builder->add('typeArrangementRangeTypeTop','hidden',array('data' => '','mapped' => false));
        //Rango Alto Básico
            $builder->add('rankTop','percent',array('label_attr' => array('class' => 'label'),'attr' => array('placeholder' => "100,000",'size' => '8'), 'required' => false,'mapped' => false));
            $builder->add('opRankTop','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));
            
        //Rango Alto Compuesto
            //Rango Alto-Alto
                $builder->add('rankTopTopTop','percent',array('label_attr' => array('class' => 'label'),'attr' => array('placeholder' => "100,000",'size' => '8'), 'required' => false,'mapped' => false));
                $builder->add('opRankTopTopTop','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));
                $builder->add('rankTopTopBottom','percent',array('label_attr' => array('class' => 'label'),'attr' => array('placeholder' => "100,000",'size' => '8'), 'required' => false,'mapped' => false));
                $builder->add('opRankTopTopBottom','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));
            //Rango Alto-Bajo
                $builder->add('rankTopBottomTop','percent',array('label_attr' => array('class' => 'label'),'attr' => array('placeholder' => "100,000",'size' => '8'), 'required' => false,'mapped' => false));
                $builder->add('opRankTopBottomTop','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));
                $builder->add('rankTopBottomBottom','percent',array('label_attr' => array('class' => 'label'),'attr' => array('placeholder' => "100,000",'size' => '8'), 'required' => false,'mapped' => false));
                $builder->add('opRankTopBottomBottom','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));
                
        //Rango de Gestión Medio
        $selectRangeTypeMiddle = $em->getRepository('PequivenMasterBundle:ArrangementRangeType')->findBy(array('description' => array($rangeTypeNameArray[ArrangementRangeType::RANGE_TYPE_MIDDLE_BASIC],$rangeTypeNameArray[ArrangementRangeType::RANGE_TYPE_MIDDLE_COMPOUND])));
        $builder->add('arrangementRangeTypeMiddle','entity',array('label' => 'form.arrangementRangeType','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenIndicatorBundle', 'expanded' => true, 'multiple' => false, 'property' => 'description','class' => 'PequivenMasterBundle:ArrangementRangeType','empty_value' => false, 'required' => false,'choices' => $selectRangeTypeMiddle,'mapped' => false));
        $builder->add('typeArrangementRangeTypeMiddle','hidden',array('data' => '','mapped' => false));
        //Rango Medio Básico
            $builder->add('rankMiddleTop','percent',array('label_attr' => array('class' => 'label'),'attr' => array('placeholder' => "100,000",'size' => '8'), 'required' => false,'mapped' => false));
            $builder->add('opRankMiddleTop','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));
            $builder->add('rankMiddleBottom','percent',array('label_attr' => array('class' => 'label'),'attr' => array('placeholder' => "100,000",'size' => '8'), 'required' => false,'mapped' => false));
            $builder->add('opRankMiddleBottom','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));
            
        //Rango Medio Compuesto
            //Rango Medio-Alto
                $builder->add('rankMiddleTopTop','percent',array('label_attr' => array('class' => 'label'),'attr' => array('placeholder' => "100,000",'size' => '8'), 'required' => false,'mapped' => false));
                $builder->add('opRankMiddleTopTop','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));
                $builder->add('rankMiddleTopBottom','percent',array('label_attr' => array('class' => 'label'),'attr' => array('placeholder' => "100,000",'size' => '8'), 'required' => false,'mapped' => false));
                $builder->add('opRankMiddleTopBottom','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));
            //Rango Medio-Bajo
                $builder->add('rankMiddleBottomTop','percent',array('label_attr' => array('class' => 'label'),'attr' => array('placeholder' => "100,000",'size' => '8'), 'required' => false,'mapped' => false));
                $builder->add('opRankMiddleBottomTop','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));
                $builder->add('rankMiddleBottomBottom','percent',array('label_attr' => array('class' => 'label'),'attr' => array('placeholder' => "100,000",'size' => '8'), 'required' => false,'mapped' => false));
                $builder->add('opRankMiddleBottomBottom','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));
                
        //Rango de Gestión Bajo
        $selectRangeTypeBottom = $em->getRepository('PequivenMasterBundle:ArrangementRangeType')->findBy(array('description' => array($rangeTypeNameArray[ArrangementRangeType::RANGE_TYPE_BOTTOM_BASIC],$rangeTypeNameArray[ArrangementRangeType::RANGE_TYPE_BOTTOM_COMPOUND])));
        $builder->add('arrangementRangeTypeBottom','entity',array('label' => 'form.arrangementRangeType','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenIndicatorBundle', 'expanded' => true, 'multiple' => false, 'property' => 'description','class' => 'PequivenMasterBundle:ArrangementRangeType','empty_value' => false, 'required' => false,'choices' => $selectRangeTypeBottom,'mapped' => false));
        $builder->add('typeArrangementRangeTypeBottom','hidden',array('data' => '','mapped' => false,'mapped' => false));
        //Rango Bajo Básico
            $builder->add('rankBottom','percent',array('label_attr' => array('class' => 'label'),'attr' => array('placeholder' => "100,000",'size' => '8'), 'required' => false,'mapped' => false));
            $builder->add('opRankBottom','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));
            
        //Rango Bajo Compuesto
            //Rango Bajo-Alto
                $builder->add('rankBottomTopTop','percent',array('label_attr' => array('class' => 'label'),'attr' => array('placeholder' => "100,000",'size' => '8'), 'required' => false,'mapped' => false));
                $builder->add('opRankBottomTopTop','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));
                $builder->add('rankBottomTopBottom','percent',array('label_attr' => array('class' => 'label'),'attr' => array('placeholder' => "100,000",'size' => '8'), 'required' => false,'mapped' => false));
                $builder->add('opRankBottomTopBottom','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));
            //Rango Bajo-Bajo
                $builder->add('rankBottomBottomTop','percent',array('label_attr' => array('class' => 'label'),'attr' => array('placeholder' => "100,000",'size' => '8'), 'required' => false,'mapped' => false));
                $builder->add('opRankBottomBottomTop','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));
                $builder->add('rankBottomBottomBottom','percent',array('label_attr' => array('class' => 'label'),'attr' => array('placeholder' => "100,000",'size' => '8'), 'required' => false,'mapped' => false));
                $builder->add('opRankBottomBottomBottom','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));
        //Rango de Gestión
            //Rango Alto del Indicador
//            $builder->add('rankTop','percent',array('label' => 'form.rankTop','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenIndicatorBundle','attr' => array('placeholder' => "100,000"), 'required' => false));
//            //Rango Medio Alto del indicador
//            $builder->add('rankMiddleTop','percent',array('label' => 'form.rankMiddleTop','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenIndicatorBundle','attr' => array('placeholder' => "100,000"), 'required' => false));
//            //Rango Medio Bajo del Indicador
//            $builder->add('rankMiddleBottom','percent',array('label' => 'form.rankMiddleBottom','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenIndicatorBundle','attr' => array('placeholder' => "100,000"), 'required' => false));
//            //Rango Bajo del Indicador
//            $builder->add('rankBottom','percent',array('label' => 'form.rankBottom','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenIndicatorBundle','attr' => array('placeholder' => "100,000"), 'required' => false));
    }
    
    public function getName(){
        return 'pequiven_indicator_tacticfo_registration';
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver){
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\IndicatorBundle\Entity\Indicator',
            ));
    }
}
