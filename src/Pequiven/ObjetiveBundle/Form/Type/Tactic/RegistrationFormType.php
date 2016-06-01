<?php
namespace Pequiven\ObjetiveBundle\Form\Type\Tactic;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Pequiven\MasterBundle\Entity\ArrangementRangeType;
use Pequiven\MasterBundle\Entity\Operator;
use Pequiven\MasterBundle\Entity\Tendency;

use Pequiven\ObjetiveBundle\Form\EventListener\AddLineStrategicFieldListener;
use Pequiven\ObjetiveBundle\Form\EventListener\AddComplejoFieldListener;
use Pequiven\ObjetiveBundle\Form\EventListener\AddGerenciaFieldListener;
use Pequiven\ObjetiveBundle\Form\EventListener\AddObjetiveParentStrategicFieldListener;

use Pequiven\ObjetiveBundle\Form\EventListener\AddIndicatorStrategicFieldListener;
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
class RegistrationFormType extends AbstractType implements ContainerAwareInterface {
    
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

        //Nombre de la localidad del usuario que esta logueado
        $builder->add('complejo_name','hidden',array('data' => $user->getComplejo()->getRef(),'mapped' => false));

        //Línea estratégica del objetivo a crear
        $builder->addEventSubscriber(new AddLineStrategicFieldListener($this->container,array('typeTactic' => true)));
        //Objetivo Estratégico al cual impactará el objetivo a crear
        $builder->addEventSubscriber(new AddObjetiveParentStrategicFieldListener($this->container));
        
        if($securityContext->isGranted(array('ROLE_DIRECTIVE','ROLE_DIRECTIVE_AUX'))){
            //Localidad(es) donde impactará el objetivo a crear
            $builder->addEventSubscriber(new AddComplejoFieldListener($this->container));
            //Gerencia donde impactará el objetivo a crear
            $builder->addEventSubscriber(new AddGerenciaFieldListener($this->container));
            $builder->add('check_gerencia','checkbox',array('label' => 'form.question.allGerencias','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle', 'required' => false, 'mapped' => false));
        }
        
        //Nombre del objetivo a crear
        $builder->add('description', 'textarea', array('label' => 'form.objetiveTactic', 'label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle','attr' => array('cols' => 50, 'rows' => 5,'class' => 'input validate[required]')));
        //Referencia del objetivo a crear
        $builder->add('ref','text',array('label' => 'form.ref', 'label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle', 'read_only' => true,'attr' => array('class' => 'input','size' => 5)));      
        //Peso del Objetivo
        //$builder->add('weight','percent',array('label' => 'form.weight','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle','attr' => array('class' => 'input', 'size' => 8), 'required' => false));
        //Meta del Objetivo
        $builder->add('goal','percent',array('label' => 'form.goalObjetiveTactic','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle','attr' => array('class' => 'input validate[required]', 'size' => 8)));
        
        //Rango de Gestión
            $objectArrangementRangeType = new ArrangementRangeType();
            $rangeTypeNameArray = $objectArrangementRangeType->getRangeTypeNameArray();
            
            //Tendencia del indicador
            $dataTendency = $em->getRepository('PequivenMasterBundle:Tendency')->findOneBy(array('ref' => Tendency::TENDENCY_MAX));
            $builder->add('tendency','entity',array('label' => 'form.conduct','data' => $dataTendency,'label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle', 'expanded' => true, 'multiple' => false, 'property' => 'description','class' => 'PequivenMasterBundle:Tendency','empty_value' => false, 'required' => false));
            
            $operatorHigherEqualThan = $em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => Operator::OPERATOR_HIGHER_EQUAL_THAN));
            $operatorSmallerEqualThan = $em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => Operator::OPERATOR_SMALLER_EQUAL_THAN));
            
            //Rango de Gestión Alto
            $selectRangeTypeTop = $em->getRepository('PequivenMasterBundle:ArrangementRangeType')->findBy(array('description' => array($rangeTypeNameArray[ArrangementRangeType::RANGE_TYPE_TOP_BASIC],$rangeTypeNameArray[ArrangementRangeType::RANGE_TYPE_TOP_MIXED])));
            $builder->add('arrangementRangeTypeTop','entity',array('label' => 'form.arrangementRangeTypeTop','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle', 'expanded' => true, 'multiple' => false, 'property' => 'description','class' => 'PequivenMasterBundle:ArrangementRangeType','empty_value' => false, 'required' => false,'choices' => $selectRangeTypeTop,'mapped' => false,'data' => $selectRangeTypeTop[0]));
            $builder->add('typeArrangementRangeTypeTop','hidden',array('data' => '','mapped' => false));
            //Rango Alto Básico
                $builder->add('rankTopBasic','percent',array('label_attr' => array('class' => 'label'),'attr' => array('size' => '8','class' => 'input'), 'required' => false,'mapped' => false, 'data' => 1));
                $builder->add('opRankTopBasic','entity',array('label_attr' => array('class' => 'label'),'attr' => array('style' => 'border-radius:6px;'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false,'data' => $operatorHigherEqualThan));
            //Rango Alto Mixto
                $builder->add('rankTopMixedTop','percent',array('label_attr' => array('class' => 'label'),'attr' => array('size' => '8', 'class' => 'input'), 'required' => false,'mapped' => false));
                $builder->add('opRankTopMixedTop','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));
                $builder->add('rankTopMixedBottom','percent',array('label_attr' => array('class' => 'label'),'attr' => array('size' => '8', 'class' => 'input'), 'required' => false,'mapped' => false));
                $builder->add('opRankTopMixedBottom','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));

            //Rango de Gestión Medio Alto
            $selectRangeTypeMiddleTop = $em->getRepository('PequivenMasterBundle:ArrangementRangeType')->findBy(array('description' => array($rangeTypeNameArray[ArrangementRangeType::RANGE_TYPE_MIDDLE_TOP_BASIC],$rangeTypeNameArray[ArrangementRangeType::RANGE_TYPE_MIDDLE_TOP_MIXED])));
            $builder->add('arrangementRangeTypeMiddleTop','entity',array('label' => 'form.arrangementRangeTypeMiddleTop','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle', 'expanded' => true, 'multiple' => false, 'property' => 'description','class' => 'PequivenMasterBundle:ArrangementRangeType','empty_value' => false, 'required' => false,'choices' => $selectRangeTypeMiddleTop,'mapped' => false));
            $builder->add('typeArrangementRangeTypeMiddleTop','hidden',array('data' => '','mapped' => false));
            //Rango Medio Alto Básico
                $builder->add('rankMiddleTopBasic','percent',array('label_attr' => array('class' => 'label'),'attr' => array('size' => '8', 'class' => 'input'), 'required' => false,'mapped' => false, 'data' => 0.99));
                $builder->add('opRankMiddleTopBasic','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false, 'data' => $operatorSmallerEqualThan));
            //Rango Medio Alto Mixto
                $builder->add('rankMiddleTopMixedTop','percent',array('label_attr' => array('class' => 'label'),'attr' => array('size' => '8', 'class' => 'input'), 'required' => false,'mapped' => false));
                $builder->add('opRankMiddleTopMixedTop','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));
                $builder->add('rankMiddleTopMixedBottom','percent',array('label_attr' => array('class' => 'label'),'attr' => array('size' => '8', 'class' => 'input'), 'required' => false,'mapped' => false));
                $builder->add('opRankMiddleTopMixedBottom','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));
            
            //Rango de Gestión Medio Bajo
            $selectRangeTypeMiddleBottom = $em->getRepository('PequivenMasterBundle:ArrangementRangeType')->findBy(array('description' => array($rangeTypeNameArray[ArrangementRangeType::RANGE_TYPE_MIDDLE_BOTTOM_BASIC],$rangeTypeNameArray[ArrangementRangeType::RANGE_TYPE_MIDDLE_BOTTOM_MIXED])));
            $builder->add('arrangementRangeTypeMiddleBottom','entity',array('label' => 'form.arrangementRangeTypeMiddleBottom','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle', 'expanded' => true, 'multiple' => false, 'property' => 'description','class' => 'PequivenMasterBundle:ArrangementRangeType','empty_value' => false, 'required' => false,'choices' => $selectRangeTypeMiddleBottom,'mapped' => false));
            $builder->add('typeArrangementRangeTypeMiddleBottom','hidden',array('data' => '','mapped' => false));
            //Rango Medio Bajo Básico
                $builder->add('rankMiddleBottomBasic','percent',array('label_attr' => array('class' => 'label'),'attr' => array('size' => '8','class' => 'input'), 'required' => false,'mapped' => false, 'data' => 0.9));
                $builder->add('opRankMiddleBottomBasic','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false, 'data' => $operatorHigherEqualThan));
            //Rango Medio Bajo Mixto
                $builder->add('rankMiddleBottomMixedTop','percent',array('label_attr' => array('class' => 'label'),'attr' => array('size' => '8', 'class' => 'input'), 'required' => false,'mapped' => false));
                $builder->add('opRankMiddleBottomMixedTop','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));
                $builder->add('rankMiddleBottomMixedBottom','percent',array('label_attr' => array('class' => 'label'),'attr' => array('size' => '8', 'class' => 'input'), 'required' => false,'mapped' => false));
                $builder->add('opRankMiddleBottomMixedBottom','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));

            //Rango de Gestión Bajo
            $selectRangeTypeBottom = $em->getRepository('PequivenMasterBundle:ArrangementRangeType')->findBy(array('description' => array($rangeTypeNameArray[ArrangementRangeType::RANGE_TYPE_BOTTOM_BASIC],$rangeTypeNameArray[ArrangementRangeType::RANGE_TYPE_BOTTOM_MIXED])));
            $builder->add('arrangementRangeTypeBottom','entity',array('label' => 'form.arrangementRangeTypeBottom','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle', 'expanded' => true, 'multiple' => false, 'property' => 'description','class' => 'PequivenMasterBundle:ArrangementRangeType','empty_value' => false, 'required' => false,'choices' => $selectRangeTypeBottom,'mapped' => false));
            $builder->add('typeArrangementRangeTypeBottom','hidden',array('data' => '','mapped' => false,'mapped' => false));
        //Comportamiento No Estable
            //Rango Bajo Básico
                $builder->add('rankBottomBasic','percent',array('label_attr' => array('class' => 'label'),'attr' => array('size' => '8','class' => 'input'), 'required' => false,'mapped' => false,'data' => 0.89));
                $builder->add('opRankBottomBasic','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false, 'data' => $operatorSmallerEqualThan));
            //Rango Bajo Mixto
                $builder->add('rankBottomMixedTop','percent',array('label_attr' => array('class' => 'label'),'attr' => array('size' => '8','class' => 'input'), 'required' => false,'mapped' => false));
                $builder->add('opRankBottomMixedTop','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));
                $builder->add('rankBottomMixedBottom','percent',array('label_attr' => array('class' => 'label'),'attr' => array('size' => '8','class' => 'input'), 'required' => false,'mapped' => false));
                $builder->add('opRankBottomMixedBottom','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));
        //Comportamiento Estable
            //Rango Bajo Básico Alto
                $builder->add('rankBottomTopBasic','percent',array('label_attr' => array('class' => 'label'),'attr' => array('size' => '8','class' => 'input'), 'required' => false,'mapped' => false,'data' => 0.89));
                $builder->add('opRankBottomTopBasic','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false, 'data' => $operatorSmallerEqualThan));
            //Rango Bajo Básico Bajo
                $builder->add('rankBottomBottomBasic','percent',array('label_attr' => array('class' => 'label'),'attr' => array('size' => '8','class' => 'input'), 'required' => false,'mapped' => false,'data' => 0.89));
                $builder->add('opRankBottomBottomBasic','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false, 'data' => $operatorSmallerEqualThan));
                
        //Tipo de Evaluación
            //Evaluar por Objetivo
            $builder->add('evalObjetive','checkbox',array('label' => 'form.evalByObjetiveOperative','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle', 'required' => false));
            //Evaluar por Indicador
            $builder->add('evalIndicator','checkbox',array('label' => 'form.evalIndicatorObjetiveTactic','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle', 'required' => false));
            //Evaluar por Programa de Gestión
            $builder->add('evalArrangementProgram','checkbox',array('label' => 'form.evalArrangementProgram','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle', 'required' => false));
            //Indicadores asociados al objetivo a crear
            $builder->addEventSubscriber(new AddIndicatorStrategicFieldListener($this->container,array('typeTactic' => true)));
    }
    
    public function getName(){
        return 'pequiven_objetive_tactic_registration';
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver){
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\ObjetiveBundle\Entity\Objetive',
            ));
    }
}
