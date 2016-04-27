<?php

namespace Pequiven\SEIPBundle\Service;

use Doctrine\Bundle\DoctrineBundle\Registry;
use ErrorException;
use Exception;
use LogicException;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Pequiven\SEIPBundle\Entity\User\Notification;
use Pequiven\SEIPBundle\Entity\User;


/**
 * Servicios para las notificaciones
 * 
 * 
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
class NotificationService implements ContainerAwareInterface {

    private $container;

    /**
     * 
     * @param Notification
     */
    public function setDataNotification($title, $message, $type, $status, $path, $user) {

        $securityContext = $this->container->get('security.context');        
        $em = $this->getDoctrine()->getManager();                
        
        $notificacion = new Notification();                

        $notificacion->setTitle($title);
        $notificacion->setDescription($message);        
        $notificacion->setType($type);                                      
        $notificacion->setStatus($status);                                      
        $notificacion->setPath($path);                                      
        $notificacion->setUser($user);                

        $em->persist($notificacion);
        $em->flush();            

        $this->setUserNotification($user);
    }

    public function setUserNotification($user){
    	
        $securityContext = $this->container->get('security.context');
    	$em = $this->getDoctrine()->getManager();                

    	$user = $this->container->get('pequiven.repository.user')->find($user->getId()); 

        $dataNotification = $user->getNotify() + 1;            
    	$user->setNotify($dataNotification);
        $em->flush();               	        

    }

    public function findMessageUser(){        
        $securityContext = $this->container->get('security.context');
        $em = $this->getDoctrine()->getManager();                

        $user = $this->container->get('pequiven.repository.user')->find($securityContext->getToken()->getUser()->getId()); 
        
        if ($user->getNotify() > 0) {
            $dataNotification = $user->getNotify() - 1;
            $user->setNotify($dataNotification);
            $em->flush();      
        }
    }

    public function findReadNotification($id){
        
        $em = $this->getDoctrine()->getManager();                

        $notification = $em->getRepository("\Pequiven\SEIPBundle\Entity\User\Notification")->find($id);        
        
        $notification->setReadNotification(true);

        $em->flush();      
    }

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
	
	/**
     * Shortcut to return the Doctrine Registry service.
     *
     * @return Registry
     *
     * @throws LogicException If DoctrineBundle is not available
     */
    public function getDoctrine() {
        if (!$this->container->has('doctrine')) {
            throw new LogicException('The DoctrineBundle is not registered in your application.');
        }

        return $this->container->get('doctrine');
    }

}

