<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\SEIPBundle\EventListener;
use JMS\Serializer\EventDispatcher\Events;

/**
 * Description of SerializerListener
 *
 * @author matias
 */
class SerializerListener implements \JMS\Serializer\EventDispatcher\EventSubscriberInterface  {
    //put your code here
    public static function getSubscribedEvents()
    {
        return array(
            array('event' => Events::POST_SERIALIZE, 'method' => 'onPostSerializeObjetive', 'class' => 'Pequiven\ObjetiveBundle\Entity\Objetive', 'format' => 'json'),
            array('event' => Events::POST_SERIALIZE, 'method' => 'onPostSerializeIndicator', 'class' => 'Pequiven\IndicatorBundle\Entity\Indicator', 'format' => 'json'),
        );
    }

    public function onPreSerialize(\JMS\Serializer\EventDispatcher\PreSerializeEvent $event)
    {
        // do something
    }

    
    public function onPostSerializeObjetive(\JMS\Serializer\EventDispatcher\ObjectEvent $event)
    {
        if($event->getObject()->getObjetiveLevel()->getLevel() === \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_ESTRATEGICO){
            $lineStrategics = $event->getObject()->getLineStrategics();
            $event->getVisitor()->addData('groupBy',$lineStrategics[0]->getRef().$lineStrategics[0]->getDescription());
        } elseif($event->getObject()->getObjetiveLevel()->getLevel() === \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_TACTICO){
            $object = $event->getObject();
//            echo 'hola';
//            die();
            $parents = $object->getParents();
            $valueGroupBy = '';
            foreach($parents as $parent){
                $valueGroupBy.= $parent->getRef().$parent->getDescription();
            }
            $event->getVisitor()->addData('groupBy',$valueGroupBy);
            $event->getVisitor()->addData('totalParents',count($parents));
        } elseif($event->getObject()->getObjetiveLevel()->getLevel() === \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_OPERATIVO){
            $object = $event->getObject();
            $parents = $object->getParents();
            $valueGroupBy = '';
            foreach($parents as $parent){
                $valueGroupBy.= $parent->getRef().$parent->getDescription();
            }
            $event->getVisitor()->addData('groupBy',$valueGroupBy);
            $event->getVisitor()->addData('totalParents',count($parents));
        }
    }
    
    public function onPostSerializeIndicator(\JMS\Serializer\EventDispatcher\ObjectEvent $event)
    {
        $objetives = $event->getObject()->getObjetives();
        $event->getVisitor()->addData('groupBy',$objetives[0]->getRef().$objetives[0]->getDescription());
    }
}
