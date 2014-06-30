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
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Doctrine\ORM\EntityManager;
/**
 * Description of RegistrationListener
 *
 * @author matias
 */
class RegistrationListener implements EventSubscriberInterface {
    //put your code here
    protected $container;
    
//    public function __construct(ContainerInterface $container) {
//        $this->container = $container;
//    }
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
    
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
        var_dump($role.'<br>');
        
        $em = $this->container->get('doctrine')->getManager();
        $personal = $em->getRepository('Pequiven\SEIPBundle\Entity\Personal');
        $num_personal = $user->getNumPersonal();
        
        if(is_array($results = $personal->getByNumPersonal($num_personal))){
            foreach($results as $result){
                var_dump($result->getNomPersonal());
            }
            //var_dump('hola');
        }
        
        //var_dump($user.'<br>');
        
//        $user->addRole('ROLE_SUPER_ADMIN');
//        if($event->getRequest()->get('role') == 'client'){
//            $user->addRole('ROLE_SUPERVISER');
//        }
        
        die();
    }
}
