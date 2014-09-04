<?php
namespace Pequiven\ObjetiveBundle\Form\Type\Tactic;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Pequiven\ObjetiveBundle\PequivenObjetiveBundle;
use Pequiven\ObjetiveBundle\Entity\ObjetiveLevel;
use Pequiven\MasterBundle\Entity\ArrangementRangeType;

use Pequiven\ObjetiveBundle\Form\EventListener\AddObjetiveLevelFieldListener;
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
class RegistrationFormType extends AbstractType {
    
    //put your code here
    public function buildForm(FormBuilderInterface $builder, array $options){
        $container = PequivenObjetiveBundle::getContainer();
        $securityContext = $container->get('security.context');
        $em = $container->get('doctrine')->getManager();
        $user = $securityContext->getToken()->getUser();

        //Nombre de la localidad del usuario que esta logueado
        $builder->add('complejo_name','hidden',array('data' => $user->getComplejo()->getRef(),'mapped' => false));
        
        //Rol del usuario que esta logueado
        $array = $user->getRoles();
        $builder->add('role_name','hidden',array('data' => $array[0],'mapped' => false));

        //Línea estratégica del objetivo a crear
        $builder->addEventSubscriber(new AddLineStrategicFieldListener());
        //Objetivo Estratégico al cual impactará el objetivo a crear
        $builder->addEventSubscriber(new AddObjetiveParentStrategicFieldListener());
        
        if($securityContext->isGranted(array('ROLE_DIRECTIVE','ROLE_DIRECTIVE_AUX'))){
            //Localidad(es) donde impactará el objetivo a crear
            $builder->addEventSubscriber(new AddComplejoFieldListener());
            //Gerencia donde impactará el objetivo a crear
            $builder->addEventSubscriber(new AddGerenciaFieldListener());
            $builder->add('check_gerencia','checkbox',array('label' => 'form.question.allGerencias','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle', 'required' => false, 'mapped' => false));
        }
        
        //Nombre del objetivo a crear
        $builder->add('description', 'textarea', array('label' => 'form.objetive', 'label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle','attr' => array('cols' => 50, 'rows' => 5,'class' => 'input')));
        //Referencia del objetivo a crear
        $builder->add('ref','text',array('label' => 'form.ref', 'label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle', 'read_only' => true,'attr' => array('class' => 'input','size' => 5)));      
        //Peso del Objetivo
        $builder->add('weight','percent',array('label' => 'form.weight','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle','attr' => array('placeholder' => "100,000"), 'required' => false));
        //Meta del Objetivo
        $builder->add('goal','percent',array('label' => 'form.goal','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle','attr' => array('placeholder' => "100")));
        
        //Rango de Gestión
            $objectArrangementRangeType = new ArrangementRangeType();
            $rangeTypeNameArray = $objectArrangementRangeType->getRangeTypeNameArray();
            //Rango de Gestión Alto
            $selectRangeTypeTop = $em->getRepository('PequivenMasterBundle:ArrangementRangeType')->findBy(array('description' => array($rangeTypeNameArray[ArrangementRangeType::RANGE_TYPE_TOP_BASIC],$rangeTypeNameArray[ArrangementRangeType::RANGE_TYPE_TOP_COMPOUND])));
            $builder->add('arrangementRangeTypeTop','entity',array('label' => 'form.arrangementRangeType','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenIndicatorBundle', 'expanded' => true, 'multiple' => false, 'property' => 'description','class' => 'PequivenMasterBundle:ArrangementRangeType','empty_value' => false, 'required' => false,'choices' => $selectRangeTypeTop,'mapped' => false));
            $builder->add('typeArrangementRangeTypeTop','hidden',array('data' => '','mapped' => false));
            //Rango Alto Básico
                $builder->add('rankTop','percent',array('label_attr' => array('class' => 'label'),'attr' => array('placeholder' => "100",'size' => '8'), 'required' => false,'mapped' => false));
                $builder->add('opRankTop','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));

            //Rango Alto Compuesto
                //Rango Alto-Alto
                    $builder->add('rankTopTopTop','percent',array('label_attr' => array('class' => 'label'),'attr' => array('placeholder' => "100",'size' => '8'), 'required' => false,'mapped' => false));
                    $builder->add('opRankTopTopTop','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));
                    $builder->add('rankTopTopBottom','percent',array('label_attr' => array('class' => 'label'),'attr' => array('placeholder' => "100",'size' => '8'), 'required' => false,'mapped' => false));
                    $builder->add('opRankTopTopBottom','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));
                //Rango Alto-Bajo
                    $builder->add('rankTopBottomTop','percent',array('label_attr' => array('class' => 'label'),'attr' => array('placeholder' => "100",'size' => '8'), 'required' => false,'mapped' => false));
                    $builder->add('opRankTopBottomTop','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));
                    $builder->add('rankTopBottomBottom','percent',array('label_attr' => array('class' => 'label'),'attr' => array('placeholder' => "100",'size' => '8'), 'required' => false,'mapped' => false));
                    $builder->add('opRankTopBottomBottom','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));

            //Rango de Gestión Medio
            $selectRangeTypeMiddle = $em->getRepository('PequivenMasterBundle:ArrangementRangeType')->findBy(array('description' => array($rangeTypeNameArray[ArrangementRangeType::RANGE_TYPE_MIDDLE_BASIC],$rangeTypeNameArray[ArrangementRangeType::RANGE_TYPE_MIDDLE_COMPOUND])));
            $builder->add('arrangementRangeTypeMiddle','entity',array('label' => 'form.arrangementRangeType','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenIndicatorBundle', 'expanded' => true, 'multiple' => false, 'property' => 'description','class' => 'PequivenMasterBundle:ArrangementRangeType','empty_value' => false, 'required' => false,'choices' => $selectRangeTypeMiddle,'mapped' => false));
            $builder->add('typeArrangementRangeTypeMiddle','hidden',array('data' => '','mapped' => false));
            //Rango Medio Básico
                $builder->add('rankMiddleTop','percent',array('label_attr' => array('class' => 'label'),'attr' => array('placeholder' => "100",'size' => '8'), 'required' => false,'mapped' => false));
                $builder->add('opRankMiddleTop','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));
                $builder->add('rankMiddleBottom','percent',array('label_attr' => array('class' => 'label'),'attr' => array('placeholder' => "100",'size' => '8'), 'required' => false,'mapped' => false));
                $builder->add('opRankMiddleBottom','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));

            //Rango Medio Compuesto
                //Rango Medio-Alto
                    $builder->add('rankMiddleTopTop','percent',array('label_attr' => array('class' => 'label'),'attr' => array('placeholder' => "100",'size' => '8'), 'required' => false,'mapped' => false));
                    $builder->add('opRankMiddleTopTop','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));
                    $builder->add('rankMiddleTopBottom','percent',array('label_attr' => array('class' => 'label'),'attr' => array('placeholder' => "100",'size' => '8'), 'required' => false,'mapped' => false));
                    $builder->add('opRankMiddleTopBottom','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));
                //Rango Medio-Bajo
                    $builder->add('rankMiddleBottomTop','percent',array('label_attr' => array('class' => 'label'),'attr' => array('placeholder' => "100",'size' => '8'), 'required' => false,'mapped' => false));
                    $builder->add('opRankMiddleBottomTop','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));
                    $builder->add('rankMiddleBottomBottom','percent',array('label_attr' => array('class' => 'label'),'attr' => array('placeholder' => "100",'size' => '8'), 'required' => false,'mapped' => false));
                    $builder->add('opRankMiddleBottomBottom','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));

            //Rango de Gestión Bajo
            $selectRangeTypeBottom = $em->getRepository('PequivenMasterBundle:ArrangementRangeType')->findBy(array('description' => array($rangeTypeNameArray[ArrangementRangeType::RANGE_TYPE_BOTTOM_BASIC],$rangeTypeNameArray[ArrangementRangeType::RANGE_TYPE_BOTTOM_COMPOUND])));
            $builder->add('arrangementRangeTypeBottom','entity',array('label' => 'form.arrangementRangeType','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenIndicatorBundle', 'expanded' => true, 'multiple' => false, 'property' => 'description','class' => 'PequivenMasterBundle:ArrangementRangeType','empty_value' => false, 'required' => false,'choices' => $selectRangeTypeBottom,'mapped' => false));
            $builder->add('typeArrangementRangeTypeBottom','hidden',array('data' => '','mapped' => false,'mapped' => false));
            //Rango Bajo Básico
                $builder->add('rankBottom','percent',array('label_attr' => array('class' => 'label'),'attr' => array('placeholder' => "100",'size' => '8'), 'required' => false,'mapped' => false));
                $builder->add('opRankBottom','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));

            //Rango Bajo Compuesto
                //Rango Bajo-Alto
                    $builder->add('rankBottomTopTop','percent',array('label_attr' => array('class' => 'label'),'attr' => array('placeholder' => "100",'size' => '8'), 'required' => false,'mapped' => false));
                    $builder->add('opRankBottomTopTop','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));
                    $builder->add('rankBottomTopBottom','percent',array('label_attr' => array('class' => 'label'),'attr' => array('placeholder' => "100",'size' => '8'), 'required' => false,'mapped' => false));
                    $builder->add('opRankBottomTopBottom','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));
                //Rango Bajo-Bajo
                    $builder->add('rankBottomBottomTop','percent',array('label_attr' => array('class' => 'label'),'attr' => array('placeholder' => "100",'size' => '8'), 'required' => false,'mapped' => false));
                    $builder->add('opRankBottomBottomTop','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));
                    $builder->add('rankBottomBottomBottom','percent',array('label_attr' => array('class' => 'label'),'attr' => array('placeholder' => "100",'size' => '8'), 'required' => false,'mapped' => false));
                    $builder->add('opRankBottomBottomBottom','entity',array('label_attr' => array('class' => 'label'),'property' => 'ref','class' => 'PequivenMasterBundle:Operator','empty_value' => '', 'required' => false,'mapped' => false));        
        
        //Tipo de Evaluación
            //Evaluar por Objetivo
            $builder->add('evalObjetive','checkbox',array('label' => 'form.evalObjetive','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle', 'required' => false));
            //Evaluar por Indicador
            $builder->add('evalIndicator','checkbox',array('label' => 'form.evalIndicator','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle', 'required' => false));
            //Evaluar por Programa de Gestión
            $builder->add('evalArrangementProgram','checkbox',array('label' => 'form.evalArrangementProgram','label_attr' => array('class' => 'label'), 'translation_domain' => 'PequivenObjetiveBundle', 'required' => false));
            //Indicadores asociados al objetivo a crear
            $builder->addEventSubscriber(new AddIndicatorStrategicFieldListener());
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
