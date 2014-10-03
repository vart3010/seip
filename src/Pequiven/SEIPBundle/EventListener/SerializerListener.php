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

/**
 * Description of SerializerListener
 *
 * @author matias
 */
class SerializerListener implements EventSubscriberInterface {

    //put your code here
    public static function getSubscribedEvents() {
        return array(
            array('event' => Events::POST_SERIALIZE, 'method' => 'onPostSerializeObjetive', 'class' => 'Pequiven\ObjetiveBundle\Entity\Objetive', 'format' => 'json'),
            array('event' => Events::POST_SERIALIZE, 'method' => 'onPostSerializeIndicator', 'class' => 'Pequiven\IndicatorBundle\Entity\Indicator', 'format' => 'json'),
            array('event' => Events::POST_SERIALIZE, 'method' => 'onPostSerializeGoalDetails', 'class' => 'Pequiven\ArrangementProgramBundle\Entity\GoalDetails', 'format' => 'json'),
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
        if ($event->getObject()->getObjetiveLevel()->getLevel() === ObjetiveLevel::LEVEL_ESTRATEGICO) {
            $lineStrategics = $event->getObject()->getLineStrategics();
            $event->getVisitor()->addData('groupBy', $lineStrategics[0]->getRef() . $lineStrategics[0]->getDescription());
        } elseif ($event->getObject()->getObjetiveLevel()->getLevel() === ObjetiveLevel::LEVEL_TACTICO) {
            $object = $event->getObject();
            $parents = $object->getParents();
            $valueGroupBy = '';
            foreach ($parents as $parent) {
                $valueGroupBy.= $parent->getRef() . $parent->getDescription();
            }
            $event->getVisitor()->addData('groupBy', $valueGroupBy);
            $event->getVisitor()->addData('totalParents', count($parents));
        } elseif ($event->getObject()->getObjetiveLevel()->getLevel() === ObjetiveLevel::LEVEL_OPERATIVO) {
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
        //Permitir cargar valores reales de meses adelantados
        $isEnabledLoadRealFuture = false;
        //Deshabilitar la carga de valores reales atrasados
        $isEnabledLoadRealLate = false;
        
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
        $event->getVisitor()->addData('_data',$data);
        
    }
}
