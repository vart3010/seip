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
            array('event' => Events::POST_SERIALIZE, 'method' => 'onPostSerializeMonitor', 'class' => 'Pequiven\SEIPBundle\Entity\Monitor', 'format' => 'json'),
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
        $object = $event->getObject();
        if ($object->getObjetiveLevel() && $object->getObjetiveLevel()->getLevel() === ObjetiveLevel::LEVEL_ESTRATEGICO) {
            $lineStrategics = $event->getObject()->getLineStrategics();
            $event->getVisitor()->addData('groupBy', $lineStrategics[0]->getRef() . $lineStrategics[0]->getDescription());
            $data['self']['href'] = $this->generateUrl('objetiveStrategic_show', array('id' => $object->getId()));
            $event->getVisitor()->addData('_links',$data);
        } elseif ($object->getObjetiveLevel() && $object->getObjetiveLevel()->getLevel() === ObjetiveLevel::LEVEL_TACTICO) {
            $parents = $object->getParents();
            $valueGroupBy = '';
            foreach ($parents as $parent) {
                $valueGroupBy.= $parent->getRef() . $parent->getDescription();
            }
            $event->getVisitor()->addData('groupBy', $valueGroupBy);
            $event->getVisitor()->addData('totalParents', count($parents));
            $data['self']['href'] = $this->generateUrl('objetiveTactic_show', array('id' => $object->getId()));
            $event->getVisitor()->addData('_links',$data);
        } elseif ($object->getObjetiveLevel() && $object->getObjetiveLevel()->getLevel() === ObjetiveLevel::LEVEL_OPERATIVO) {
            $parents = $object->getParents();
            $valueGroupBy = '';
            foreach ($parents as $parent) {
                $valueGroupBy.= $parent->getRef() . $parent->getDescription();
            }
            $event->getVisitor()->addData('groupBy', $valueGroupBy);
            $event->getVisitor()->addData('totalParents', count($parents));
            $data['self']['href'] = $this->generateUrl('objetiveOperative_show', array('id' => $object->getId()));
            $event->getVisitor()->addData('_links',$data);
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
        }
        $event->getVisitor()->addData('_data',$data);
        
    }
    
    public function onPostSerializeArrangementProgram(ObjectEvent $event) {
        $data = array();
        $object = $event->getObject();
        if($object->getId() > 0){
            $data['self']['href'] = $this->generateUrl('pequiven_seip_arrangementprogram_show', array('id' => $object->getId()));
            $data['self']['edit']['href'] = $this->generateUrl('arrangementprogram_edit', array('id' => $object->getId()));
        }
        $event->getVisitor()->addData('_links',$data);
    }
    
    /**
     * Función que serializa el objeto de indicador para la vista
     * @param ObjectEvent $event
     */
    public function onPostSerializeMonitor(ObjectEvent $event) {
        $monitor = $event->getObject();
        $range = array();
        $filter = array();
        $res = array();
        $images = array();
        $routeImage = array();
        $images['good'] = '/web/bundles/pequivenseip/logotipos/bullet_green.png';
        $images['middle'] = '/web/bundles/pequivenseip/logotipos/bullet_yellow.png';
        $images['bad'] = '/web/bundles/pequivenseip/logotipos/bullet_red.png';
        
        $range['good'] = (float)70;
        $range['bad'] =(float)40;
        
        //Acomodar Data
        
        //Obj. Táctico Original
        $res['objTacticOriginal'] = $monitor->getObjTacticOriginal() == 0 ? bcadd(0,'0',2) : bcadd(((float)$monitor->getObjTacticOriginalReal() / (float)$monitor->getObjTacticOriginal()) * 100,'0',2);
        if($res['objTacticOriginal'] >= $range['good']){
            $filter['objTacticOriginal'] = 1;
        } elseif ($res['objTacticOriginal'] < $range['good'] && $res['objTacticOriginal'] >= $range['bad']){
            $filter['objTacticOriginal'] = 2;
        } elseif($res['objTacticOriginal'] < $range['bad']){
            $filter['objTacticOriginal'] = 3;
        }
        if($filter['objTacticOriginal'] == 1){
            $routeImage['objTacticOriginal'] = $images['good'];
        } elseif($filter['objTacticOriginal'] == 2){
            $routeImage['objTacticOriginal'] = $images['middle'];
        } else{
            $routeImage['objTacticOriginal'] = $images['bad'];
        }
        
        //Ind. Táctico Original
        $res['indTacticOriginal'] = $monitor->getIndTacticOriginal() == 0 ? bcadd(0,'0',2) : bcadd(((float)$monitor->getIndTacticOriginalReal() / (float)$monitor->getIndTacticOriginal()) * 100,'0',2);
        if($res['indTacticOriginal'] >= $range['good']){
            $filter['indTacticOriginal'] = 1;
        } elseif ($res['indTacticOriginal'] < $range['good'] && $res['indTacticOriginal'] >= $range['bad']){
            $filter['indTacticOriginal'] = 2;
        } elseif($res['indTacticOriginal'] < $range['bad']){
            $filter['indTacticOriginal'] = 3;
        }
        if($filter['indTacticOriginal'] == 1){
            $routeImage['indTacticOriginal'] = $images['good'];
        } elseif($filter['indTacticOriginal'] == 2){
            $routeImage['indTacticOriginal'] = $images['middle'];
        } else{
            $routeImage['indTacticOriginal'] = $images['bad'];
        }
        
        //Obj. Operativo Original
        $res['objOperativeOriginal'] = $monitor->getObjOperativeOriginal() == 0 ? bcadd(0,'0',2) : bcadd(((float)$monitor->getObjOperativeOriginalReal() / (float)$monitor->getObjOperativeOriginal()) * 100,'0',2);
        if($res['objOperativeOriginal'] >= $range['good']){
            $filter['objOperativeOriginal'] = 1;
        } elseif ($res['objOperativeOriginal'] < $range['good'] && $res['objOperativeOriginal'] >= $range['bad']){
            $filter['objOperativeOriginal'] = 2;
        } elseif($res['objOperativeOriginal'] < $range['bad']){
            $filter['objOperativeOriginal'] = 3;
        }
        if($filter['objOperativeOriginal'] == 1){
            $routeImage['objOperativeOriginal'] = $images['good'];
        } elseif($filter['objOperativeOriginal'] == 2){
            $routeImage['objOperativeOriginal'] = $images['middle'];
        } else{
            $routeImage['objOperativeOriginal'] = $images['bad'];
        }
        
        //Obj. Operativo Vinculante
        $res['objOperativeVinculante'] = $monitor->getObjOperativeVinculante() == 0 ? bcadd(0,'0',2) : bcadd(((float)$monitor->getObjOperativeVinculanteReal() / (float)$monitor->getObjOperativeVinculante()) * 100,'0',2);
        if($res['objOperativeVinculante'] >= $range['good']){
            $filter['objOperativeVinculante'] = 1;
        } elseif ($res['objOperativeVinculante'] < $range['good'] && $res['objOperativeVinculante'] >= $range['bad']){
            $filter['objOperativeVinculante'] = 2;
        } elseif($res['objOperativeVinculante'] < $range['bad']){
            $filter['objOperativeVinculante'] = 3;
        }
        if($filter['objOperativeVinculante'] == 1){
            $routeImage['objOperativeVinculante'] = $images['good'];
        } elseif($filter['objOperativeVinculante'] == 2){
            $routeImage['objOperativeVinculante'] = $images['middle'];
        } else{
            $routeImage['objOperativeVinculante'] = $images['bad'];
        }
        
        //Ind. Operativo Original
        $res['indOperativeOriginal'] = $monitor->getIndOperativeOriginal() == 0 ? bcadd(0,'0',2) : bcadd(((float)$monitor->getIndOperativeOriginalReal() / (float)$monitor->getIndOperativeOriginal()) * 100,'0',2);
        if($res['indOperativeOriginal'] >= $range['good']){
            $filter['indOperativeOriginal'] = 1;
        } elseif ($res['indOperativeOriginal'] < $range['good'] && $res['indOperativeOriginal'] >= $range['bad']){
            $filter['indOperativeOriginal'] = 2;
        } elseif($res['indOperativeOriginal'] < $range['bad']){
            $filter['indOperativeOriginal'] = 3;
        }
        if($filter['indOperativeOriginal'] == 1){
            $routeImage['indOperativeOriginal'] = $images['good'];
        } elseif($filter['indOperativeOriginal'] == 2){
            $routeImage['indOperativeOriginal'] = $images['middle'];
        } else{
            $routeImage['indOperativeOriginal'] = $images['bad'];
        }
        
        //Ind. Operativo Vinculante
        $res['indOperativeVinculante'] = $monitor->getIndOperativeVinculante() == 0 ? bcadd(0,'0',2) : bcadd(((float)$monitor->getIndOperativeVinculanteReal() / (float)$monitor->getIndOperativeVinculante()) * 100,'0',2);
        if($res['indOperativeVinculante'] >= $range['good']){
            $filter['indOperativeVinculante'] = 1;
        } elseif ($res['indOperativeVinculante'] < $range['good'] && $res['indOperativeVinculante'] >= $range['bad']){
            $filter['indOperativeVinculante'] = 2;
        } elseif($res['indOperativeVinculante'] < $range['bad']){
            $filter['indOperativeVinculante'] = 3;
        }
        if($filter['indOperativeVinculante'] == 1){
            $routeImage['indobjOperativeVinculante'] = $images['good'];
        } elseif($filter['indOperativeVinculante'] == 2){
            $routeImage['indOperativeVinculante'] = $images['middle'];
        } else{
            $routeImage['indOperativeVinculante'] = $images['bad'];
        }
        
        //Resultados
        //Obj. Táctico Original
        $event->getVisitor()->addData('resObjTacticOriginal', $res['objTacticOriginal']);
        $event->getVisitor()->addData('imageObjTacticOriginal', $routeImage['objTacticOriginal']);        
        //Ind. Táctico Original
        $event->getVisitor()->addData('resIndTacticOriginal', $res['indTacticOriginal']);
        $event->getVisitor()->addData('imageIndTacticOriginal', $routeImage['indTacticOriginal']);
        //Obj. Operativo Original
        $event->getVisitor()->addData('resObjOperativeOriginal', $res['objOperativeOriginal']);
        $event->getVisitor()->addData('imageObjOperativeOriginal', $routeImage['objOperativeOriginal']);        
        //Obj. Operativo Vinculante
        $event->getVisitor()->addData('resObjOperativeVinculante', $res['objOperativeVinculante']);
        $event->getVisitor()->addData('imageObjOperativeVinculante', $routeImage['objOperativeVinculante']);        
        //Ind. Operativo Original
        $event->getVisitor()->addData('resIndOperativeOriginal', $res['indOperativeOriginal']);
        $event->getVisitor()->addData('imageIndOperativeOriginal', $routeImage['indOperativeOriginal']);
        //Ind. Operativo Vinculante
        $event->getVisitor()->addData('resIndOperativeVinculante', $res['indOperativeVinculante']);
        $event->getVisitor()->addData('imageIndOperativeVinculante', $routeImage['indOperativeVinculante']);
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
