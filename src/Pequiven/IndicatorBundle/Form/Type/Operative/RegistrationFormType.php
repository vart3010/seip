<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\IndicatorBundle\Form\Type\Operative;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Pequiven\MasterBundle\Entity\ArrangementRangeType;
use Pequiven\MasterBundle\Entity\Tendency;

use Pequiven\ObjetiveBundle\Form\EventListener\AddLineStrategicFieldListener;
use Pequiven\ObjetiveBundle\Form\EventListener\AddObjetiveParentStrategicFieldListener;
use Pequiven\ObjetiveBundle\Form\EventListener\AddObjetiveParentTacticFieldListener;
use Pequiven\ObjetiveBundle\Form\EventListener\AddComplejoFieldListener;
use Pequiven\ObjetiveBundle\Form\EventListener\AddGerenciaFieldListener;
use Pequiven\ObjetiveBundle\Form\EventListener\AddGerenciaSecondFieldListener;
use Pequiven\ObjetiveBundle\Form\EventListener\AddObjetiveOperativeFieldListener;
use Pequiven\IndicatorBundle\Form\EventListener\AddFormulaFieldListener;
/**
 * Description of RegistrationFormType
 *
 * @author matias
 */
class RegistrationFormType extends AbstractType implements ContainerAwareInterface {
    
    protected $typeForm;
    protected $container;
    
    public function __construct($type = 'fromObjetive') {
        $this->typeForm = $type;
    }
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options){
        $container = $this->container;
        $securityContext = $container->get('security.context');
        $em = $container->get('doctrine')->getManager();
        $user = $securityContext->getToken()->getUser();
        
        if($this->typeForm == 'regular'){
            //Rol del usuario que esta logueado
            $array = $user->getRoles();
            $builder->add('role_name','hidden',array('data' => $array[0],'mapped' => false));
            
            //Línea estratégica del objetivo a crear
            $builder->addEventSubscriber(new AddLineStrategicFieldListener());
            //Objetivo Estratégico al cual impactará el indicador a crear
            $builder->addEventSubscriber(new AddObjetiveParentStrategicFieldListener(array('registerIndicator' => true)));
            //Objetivo Táctico al cual impactará el indicador a crear
            $builder->addEventSubscriber(new AddObjetiveParentTacticFieldListener(array('registerIndicator' => true)));
            
            if($securityContext->isGranted(array('ROLE_DIRECTIVE','ROLE_DIRECTIVE_AUX'))){
                //Localidad(es) donde impactará el indicador a crear
                $builder->addEventSubscriber(new AddComplejoFieldListener(array('registerIndicator' => true,'typeOperative' => true)));
                //Gerencia de 1ra línea donde impactará el indicador a crear
                $builder->addEventSubscriber(new AddGerenciaFieldListener(array('registerIndicator' => true)));
            }
            if($securityContext->isGranted(array('ROLE_DIRECTIVE','ROLE_DIRECTIVE_AUX','ROLE_GENERAL_COMPLEJO','ROLE_GENERAL_COMPLEJO_AUX','ROLE_MANAGER_FIRST','ROLE_MANAGER_FIRST_AUX'))){
                //Gerencia de 2da línea dónde impactará el indicador a crear
                $builder->addEventSubscriber(new AddGerenciaSecondFieldListener(array('registerIndicator' => true)));
            }
            //Objetivo Operativo donde impactará el indicador a crear
            $builder->addEventSubscriber(new AddObjetiveOperativeFieldListener(array('registerIndicator' => true)));
        } elseif($this->typeForm == 'fromObjetive'){
            //Referencia del Objetivo Operativo al cual se le podrían añadir los indicadores a crear
            $builder->add('refObjetive','hidden',array('data' => '','mapped' => false));
        }
        
        //Nombre del indicador a crear
        $builder->add('description', 'textarea', array('label' => 'form.indicator', 'label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenIndicatorBundle','attr' => array('cols' => 50, 'rows' => 5,'class' => 'input')));
        //Referencia del indicador a crear
        $builder->add('ref','text',array('label' => 'form.ref', 'label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenIndicatorBundle', 'read_only' => true,'attr' => array('class' => 'input','size' => 10)));
        
        //Peso del Indicador
        $builder->add('weight','percent',array('label' => 'form.weight','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenIndicatorBundle','attr' => array('placeholder' => "100", 'class' => 'input', 'size' => 8), 'required' => false));
        //Meta del Indicador
        $builder->add('goal','percent',array('label' => 'form.goal','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenIndicatorBundle','attr' => array('placeholder' => "100", 'class' => 'input', 'size' => 8)));
        //Fórmula del indicador a crear
        $builder->addEventSubscriber(new AddFormulaFieldListener());
        
        //Tendencia del indicador
        $dataTendency = $em->getRepository('PequivenMasterBundle:Tendency')->findOneBy(array('ref' => Tendency::TENDENCY_MAX));
        $builder->add('tendency','entity',array('label' => 'form.tendency','data' => $dataTendency,'label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenIndicatorBundle', 'expanded' => true, 'multiple' => false, 'property' => 'description','class' => 'PequivenMasterBundle:Tendency','empty_value' => false, 'required' => false));
        
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
    }
    
    public function getName(){
        if($this->typeForm == 'fromObjetive'){
            return 'pequiven_indicator_operativefo_registration';
        } elseif($this->typeForm == 'regular'){
            return 'pequiven_indicator_operative_registration';
        }
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver){
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\IndicatorBundle\Entity\Indicator',
            ));
    }
}
