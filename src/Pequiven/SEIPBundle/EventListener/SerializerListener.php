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
            array('event' => Events::POST_SERIALIZE, 'method' => 'onPostSerialize', 'class' => 'Pequiven\ObjetiveBundle\Entity\Objetive', 'format' => 'json'),
        );
    }

    public function onPreSerialize(\JMS\Serializer\EventDispatcher\PreSerializeEvent $event)
    {
        // do something
    }

    
    public function onPostSerialize(\JMS\Serializer\EventDispatcher\ObjectEvent $event)
    {        
        //var_dump('hola');
        //var_dump($event->getObject());
        $lineStrategics = $event->getObject()->getLineStrategics();
        $event->getVisitor()->addData('groupBy',$lineStrategics[0]->getRef().$lineStrategics[0]->getDescription());
        //die();
        // do something
    }
}
