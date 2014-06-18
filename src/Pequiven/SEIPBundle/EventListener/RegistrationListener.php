<?php
namespace Pequiven\SEIPBundle\EventListener;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Tecnocreaciones\Bundle\AjaxFOSUserBundle\Event\FormEvent;
use Tecnocreaciones\Bundle\AjaxFOSUserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
/**
 * Description of RegistrationListener
 *
 * @author matias
 */
class RegistrationListener implements EventSubscriberInterface {
    //put your code here
     static public function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::REGISTRATION_SUCCESS => 'onRegistrationSuccess',
        );
    }
    
    function onRegistrationSuccess(FormEvent $event) {
        /** @var $user \FOS\UserBundle\Model\UserInterface */
        $user = $event->getForm()->getData();
        $role = $event->getRequest()->get('role');
//        var_dump($event->getRequest()->get('role'));
        if($role == 'client'){
            $user->addRole('ROLE_CLIENT');
        }
    }
}
