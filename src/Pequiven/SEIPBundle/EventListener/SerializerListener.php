<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\SEIPBundle\EventListener;

use DateTime;
use JMS\Serializer\EventDispatcher\Events;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\ObjectEvent;
use JMS\Serializer\EventDispatcher\PreSerializeEvent;
use Pequiven\ArrangementProgramBundle\Entity\GoalDetails;
use Pequiven\ObjetiveBundle\Entity\ObjetiveLevel;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Description of SerializerListener
 *
 * @author matias
 */
class SerializerListener implements EventSubscriberInterface,  ContainerAwareInterface {
    /**
     *
     * @var ContainerInterface
     */
    private $container;
    
    public static function getSubscribedEvents() {
        return array(
            array('event' => Events::POST_SERIALIZE, 'method' => 'onPostSerializeObjetive', 'class' => 'Pequiven\ObjetiveBundle\Entity\Objetive', 'format' => 'json'),
            array('event' => Events::POST_SERIALIZE, 'method' => 'onPostSerializeIndicator', 'class' => 'Pequiven\IndicatorBundle\Entity\Indicator', 'format' => 'json'),
            array('event' => Events::POST_SERIALIZE, 'method' => 'onPostSerializeGoalDetails', 'class' => 'Pequiven\ArrangementProgramBundle\Entity\GoalDetails', 'format' => 'json'),
            array('event' => Events::POST_SERIALIZE, 'method' => 'onPostSerializeArrangementProgram', 'class' => 'Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram', 'format' => 'json'),
        );
    }

    public function onPreSerialize(PreSerializeEvent $event) {
        // do something
    }

    /**
     * Función que serializa el objeto de objetivo para la vista
     * @param ObjectEvent $event
     */
    public function onPostSerializeObjetive(ObjectEvent $event) {
        if ($event->getObject()->getObjetiveLevel() && $event->getObject()->getObjetiveLevel()->getLevel() === ObjetiveLevel::LEVEL_ESTRATEGICO) {
            $lineStrategics = $event->getObject()->getLineStrategics();
            $event->getVisitor()->addData('groupBy', $lineStrategics[0]->getRef() . $lineStrategics[0]->getDescription());
        } elseif ($event->getObject()->getObjetiveLevel() && $event->getObject()->getObjetiveLevel()->getLevel() === ObjetiveLevel::LEVEL_TACTICO) {
            $object = $event->getObject();
            $parents = $object->getParents();
            $valueGroupBy = '';
            foreach ($parents as $parent) {
                $valueGroupBy.= $parent->getRef() . $parent->getDescription();
            }
            $event->getVisitor()->addData('groupBy', $valueGroupBy);
            $event->getVisitor()->addData('totalParents', count($parents));
            $event->getContext();
        } elseif ($event->getObject()->getObjetiveLevel() && $event->getObject()->getObjetiveLevel()->getLevel() === ObjetiveLevel::LEVEL_OPERATIVO) {
            $object = $event->getObject();
            $parents = $object->getParents();
            $valueGroupBy = '';
            foreach ($parents as $parent) {
                $valueGroupBy.= $parent->getRef() . $parent->getDescription();
            }
            $event->getVisitor()->addData('groupBy', $valueGroupBy);
            $event->getVisitor()->addData('totalParents', count($parents));
        }
    }

    /**
     * Función que serializa el objeto de indicador para la vista
     * @param ObjectEvent $event
     */
    public function onPostSerializeIndicator(ObjectEvent $event) {
        $objetives = $event->getObject()->getObjetives();
        $event->getVisitor()->addData('groupBy', $objetives[0]->getRef() . $objetives[0]->getDescription());
    }
    
    public function onPostSerializeGoalDetails(ObjectEvent $event) {
        $data = array();
        $object = $event->getObject();
        
        $date = new DateTime();
        
        //Habilitar la carga de lo real
        $isLoadRealEnabled = true;
        //Habilitar la carga de los planeado
        $isLoadPlannedEnabled = true;
        //Habilitar carga de valores reales de meses adelantados
        $isEnabledLoadRealFuture = false;
        //Habilitar la carga de valores reales atrasados
        $isEnabledLoadRealLate = true;
        //Habilitar edicion del valor real dependiendo si la planeada no esta vacia
        $isEnabledEditByPlannedLoad = true;
        //Deshabilitar las celdas planeadas cuando se distribuya el 100%
        $disablePlannedOnComplete = true;
        
        //Habilitar la carga por trimestre
        $isEnabledLoadByQuarter = true;
        
        //Habilitar la carga del primer trimestre (Requiere isEnabledLoadByQuarter)
        $isEnabledLoadByQuarterFirst = false;
        //Habilitar la carga de valores planificados del primer trimestre (Requiere isEnabledLoadByQuarterFirst)
        $isEnabledLoadByQuarterFirstPlanned = true;
        //Habilitar la carga de valores reales del primer trimestre (Requiere isEnabledLoadByQuarterFirst)
        $isEnabledLoadByQuarterFirstReal = true;
        
        //Habilitar la carga del segundo trimestre (Requiere isEnabledLoadByQuarter)
        $isEnabledLoadByQuarterSecond = false;
        //Habilitar la carga de valores planificados del segundo trimestre (Requiere isEnabledLoadByQuarterSecond)
        $isEnabledLoadByQuarterSecondPlanned = true;
        //Habilitar la carga de valores reales del segundo trimestre (Requiere isEnabledLoadByQuarterSecond)
        $isEnabledLoadByQuarterSecondReal = true;
        
        //Habilitar la carga del tercer trimestre (Requiere isEnabledLoadByQuarter)
        $isEnabledLoadByQuarterThird = false;
        //Habilitar la carga de valores planificados del tercer trimestre (Requiere isEnabledLoadByQuarterThird)
        $isEnabledLoadByQuarterThirdPlanned = true;
        //Habilitar la carga de valores reales del tercer trimestre (Requiere isEnabledLoadByQuarterThird)
        $isEnabledLoadByQuarterThirdReal = true;
        
        //Habilitar la carga del cuarto trimestre (Requiere isEnabledLoadByQuarter)
        $isEnabledLoadByQuarterFourth = false;
        //Habilitar la carga de valores planificados del cuarto trimestre (Requiere isEnabledLoadByQuarterFourth)
        $isEnabledLoadByQuarterFourthPlanned = true;
        //Habilitar la carga de valores reales del cuarto trimestre (Requiere isEnabledLoadByQuarterFourth)
        $isEnabledLoadByQuarterFourthReal = true;
        
        $month = $date->format('m');
        
        if($isLoadRealEnabled === false){
            foreach (GoalDetails::getMonthsReal() as $key => $monthGoal) {
                $data[$key]['isEnabled'] = false;
            }
        }
        if($isEnabledLoadRealFuture === false){
            foreach (GoalDetails::getMonthsReal() as $key => $monthGoal) {
                if($month < $monthGoal){
                    $data[$key]['isEnabled'] = false;
                }
            }
        }
        if($isLoadPlannedEnabled === false){
            foreach (GoalDetails::getMonthsPlanned() as $key => $monthGoal) {
                $data[$key]['isEnabled'] = false;
            }
        }
        if($isEnabledLoadRealLate === false){
            foreach (GoalDetails::getMonthsReal() as $key => $monthGoal) {
                if($month > $monthGoal){
                    $data[$key]['isEnabled'] = false;
                }
            }
        }
                
        if($disablePlannedOnComplete === true){
            //Limite de porcentaje que se asigna al planeado
            $limitPlannedPercentaje = 100;
            $percentajeAcumulated = 0;
            $propertyAccessor = new \Symfony\Component\PropertyAccess\PropertyAccessor();
            $disable = false;
            foreach (GoalDetails::getMonthsPlanned() as $planned => $monthNumber) {
                $percentaje = $propertyAccessor->getValue($object,$planned);
                $percentajeAcumulated += $percentaje;
                if($disable){
                    $data[$planned]['isEnabled'] = false;
                    continue;
                }
                if($percentajeAcumulated >= $limitPlannedPercentaje){
                    $disable = true;
                }
            }
            foreach (GoalDetails::getMonthsPlanned() as $planned => $monthNumber) {
                $percentaje = $propertyAccessor->getValue($object,$planned);
                if($disable === true && ($percentaje == 0 && $percentaje == '0' || $percentaje == '' || $percentaje == null)){
                    $data[$planned]['isEnabled'] = false;
                }
            }
        }
        
        if($isEnabledLoadByQuarter === true){
            $currentCuarter = null;
            $quarterDef = array(
                1 => array(1,2,3),
                2 => array(4,5,6),
                3 => array(7,8,9),
                4 => array(10,11,12),
            );
            foreach ($quarterDef as $key => $quarter) {
                foreach ($quarter as $monthQuarter) {
                    if($monthQuarter == $month){
                        $currentCuarter = $key;
                        break;
                    }
                }
                if($currentCuarter !== null){
                    break;
                }
            }
            /**
             * Deshabilitar meses que no estan en el trimestre
             */
            $disableQuartes = function ($months,&$data,$currentCuarter) use ($quarterDef) {
                foreach ($months as $planned => $monthNumber) {
                    $disable = true;
                    foreach ($quarterDef[$currentCuarter] as $monthQuarter) {
                        if($monthNumber == $monthQuarter){
                            $disable = false;
                        }
                    }
                    if($disable === true){
                        $data[$planned]['isEnabled'] = false;
                    }else{
                        $data[$planned]['isEnabled'] = true;
                    }
                }
            };
            
            $enableQuartes = function($months,&$data,$cuarter) use ($quarterDef) {
                
                 foreach ($months as $planned => $monthNumber) {
                    $disable = true;
                    foreach ($quarterDef[$cuarter] as $monthQuarter) {
                        if($monthNumber == $monthQuarter){
                            $disable = false;
                        }
                    }
                    if($disable === false){
                        $data[$planned]['isEnabled'] = true;
                    }else{
                        $data[$planned]['isEnabled'] = false;
                    }
                }
            };
            
            $disableQuartes(GoalDetails::getMonthsPlanned(),$data,$currentCuarter);
            $disableQuartes(GoalDetails::getMonthsReal(),$data,$currentCuarter);
            
            if($isEnabledLoadByQuarterFirst === true){
                if($isEnabledLoadByQuarterFirstPlanned === true){
                    $enableQuartes(GoalDetails::getMonthsPlanned(),$data,1);
                }
                if($isEnabledLoadByQuarterFirstReal === true){
                    $enableQuartes(GoalDetails::getMonthsReal(),$data,1);
                }
            }
            if($isEnabledLoadByQuarterSecond === true){
                if($isEnabledLoadByQuarterSecondPlanned === true){
                    $enableQuartes(GoalDetails::getMonthsPlanned(),$data,2);
                }
                if($isEnabledLoadByQuarterSecondReal === true){
                    $enableQuartes(GoalDetails::getMonthsReal(),$data,2);
                }
            }
            if($isEnabledLoadByQuarterThird === true){
                if($isEnabledLoadByQuarterThirdPlanned === true){
                    $enableQuartes(GoalDetails::getMonthsPlanned(),$data,3);
                }
                if($isEnabledLoadByQuarterThirdReal === true){
                    $enableQuartes(GoalDetails::getMonthsReal(),$data,3);
                }
            }
            if($isEnabledLoadByQuarterFourth === true){
                if($isEnabledLoadByQuarterFourthPlanned === true){
                    $enableQuartes(GoalDetails::getMonthsPlanned(),$data,4);
                }
                if($isEnabledLoadByQuarterFourthReal === true){
                    $enableQuartes(GoalDetails::getMonthsReal(),$data,4);
                }
            }
        }
        
        if($isEnabledEditByPlannedLoad === true){
            $propertyAccessor = new \Symfony\Component\PropertyAccess\PropertyAccessor();
            foreach (GoalDetails::getMonthsPlanned() as $planned => $monthNumber) {
                $value = $propertyAccessor->getValue($object,$planned);
                $monthReal = GoalDetails::getMonthOfRealByMonth($monthNumber);
                if($value == '' || $value == '0' || $value === null){
                    $data[$monthReal]['isEnabled'] = false;
                }
            }
        }
        
        $event->getVisitor()->addData('_data',$data);
        
    }
    
    public function onPostSerializeArrangementProgram(ObjectEvent $event) {
        $links = $data = array();
        $object = $event->getObject();
        if($object->getId() > 0){
            $links['self']['href'] = $this->generateUrl('pequiven_seip_arrangementprogram_show', array('id' => $object->getId()));
            $links['self']['edit']['href'] = $this->generateUrl('arrangementprogram_edit', array('id' => $object->getId()));
        }
        $data['advances'] = $object->getAdvances();
        $event->getVisitor()->addData('_data',$data);
        $event->getVisitor()->addData('_links',$links);
    }
    
    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
        $this->container = $container;
    }
    
    protected function generateUrl($route,array $parameters){
        return $this->container->get('fos_rest.router')->generate($route, $parameters, \Symfony\Bundle\FrameworkBundle\Routing\Router::ABSOLUTE_URL);
    }
    
    function trans($id, $parameters = array(), $domain = 'messages')
    {
        return $this->container->get('translator')->trans($id, $parameters, $domain);
    }
}
