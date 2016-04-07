<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\SEIPBundle\Controller\User;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController as baseController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Controlador de Notificaciones
 *
 * @author Maximo Sojo <maxsojo13@gmail.com>
 */
class NotificationController extends baseController {

    /**
     *
     *
     */
    public function notificationAction(){
        
        $securityContext = $this->container->get('security.context');        
        $em = $this->getDoctrine()->getManager();  

        $types = [
            1 => "objetives",
            2 => "programt",
            3 => "indicators",
            4 => "standardization",
            5 => "production",
            6 => "evolution",
        ];

        $notification = $em->getRepository("\Pequiven\SEIPBundle\Entity\User\Notification")->findBy(array('user' => $securityContext->getToken()->getUser()), array('createdAt' => 'DESC'));

        return $this->render('PequivenSEIPBundle:User:notification.html.twig', array('notifications' => $notification, 'types' => $types));
    }
    
    /**
     *
     *
     */
    public function getNotificationAction(Request $request){
        $response = new JsonResponse();        
        
        $em = $this->getDoctrine()->getManager();   

        $notification = $em->getRepository("\Pequiven\SEIPBundle\Entity\User\Notification")->find($request->get('idMessage'));
        
        if ($notification->getReadNotification() != true) {
            $this->getNotificationService()->findMessageUser();        
            $this->getNotificationService()->findReadNotification($request->get('idMessage'));            
        }
        
        $data = [
            'description' => $notification->getDescription(),
            'path'        => $notification->getPath()
        ];

        $response->setData($data);

        return $response;        
    }

    /**
     *
     *
     */
    public function delNotificationAction(Request $request){
        $response = new JsonResponse();        
        
        $em = $this->getDoctrine()->getManager();   

        $notification = $em->getRepository("\Pequiven\SEIPBundle\Entity\User\Notification")->find($request->get('idMessage'));
        
        //$em->remove($notification);
        $notification->setTypeMessage(3);

        $em->flush();
        
        $response->setData($notification->getDescription());

        return $response;        
    }

     /**
     *
     *
     */
    public function NotificationFavouriteAction(Request $request){
        $response = new JsonResponse();        
        
        $em = $this->getDoctrine()->getManager();   

        $notification = $em->getRepository("\Pequiven\SEIPBundle\Entity\User\Notification")->find($request->get('idMessage'));
        
        $notification->setTypeMessage(2);
        
        $em->flush();
        
        $response->setData($notification->getDescription());

        return $response;        
    }

    public function getNotifyDataAction(Request $request){
        $em = $this->getDoctrine()->getManager();   
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();        
        $notifyUser = $user->getNotify();

        $response = new JsonResponse();   
        $notify = $fav = $trash = 0;
        $objetives = $programt = $indicators = $standardization = $production = $evolution = 0;

        $notification = $em->getRepository("\Pequiven\SEIPBundle\Entity\User\Notification")->findBy(array('user' => $user));
        
        foreach ($notification as $valueNotify) {
            if ($valueNotify->getTypeMessage() == 1) {
                $notify = $notify + 1;
            }elseif($valueNotify->getTypeMessage() == 2){
                $fav = $fav + 1;
            }elseif ($valueNotify->getTypeMessage() == 3) {
                $trash = $trash + 1;
            }
            
            if ($valueNotify->getTypeMessage() != 2 and $valueNotify->getTypeMessage() != 3) {                
                if ($valueNotify->getType() == 1) {
                    $objetives = $objetives + 1;
                }elseif ($valueNotify->getType() == 2) {
                    $programt = $programt + 1;
                }elseif ($valueNotify->getType() == 3) {
                    $indicators = $indicators + 1;
                }elseif ($valueNotify->getType() == 4) {
                    $standardization = $standardization + 1;
                }elseif ($valueNotify->getType() == 5) {
                    $production = $production + 1;
                }elseif ($valueNotify->getType() == 6) {
                    $evolution = $evolution + 1;
                }
            }
            
        }

        $data = [
            'notify'          => $notify,
            'fav'             => $fav,
            'trash'           => $trash,
            'objetives'       => $objetives,
            'programt'        => $programt,
            'indicators'      => $indicators,
            'standardization' => $standardization,
            'production'      => $production,
            'evolution'       => $evolution,
            'notifyUser'      => $notifyUser
        ];

        $response->setData($data);

        return $response;        
    }

    public function getNotificationUserAction(Request $request){
        $em = $this->getDoctrine()->getManager();   
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();        
        
        $notifyUser = $user->getNotify();

        $response = new JsonResponse();   
        
        $data = [
            'notifyUser'      => $notifyUser
        ];

        $response->setData($data);

        return $response; 
    }

    public function getMessagesDataAction(Request $request){
        
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser()->getId();

        $response = new JsonResponse();        
        
        $description = $data = [];

        $em = $this->getDoctrine()->getManager();   
        
        if ($request->get('typeData') == 0) {
            $notification = $em->getRepository("\Pequiven\SEIPBundle\Entity\User\Notification")->findBy(array('typeMessage' => $request->get('type'), 'user' => $user),array('id' => 'DESC'));            
        }else {
            $notification = $em->getRepository("\Pequiven\SEIPBundle\Entity\User\Notification")->findBy(array('type' => $request->get('typeData'), 'typeMessage' => $request->get('type'), 'user' => $user),array('id' => 'DESC'));                        
        }

        if ($notification) {            
            foreach ($notification as $valueNotification) {            
                $id = $valueNotification->getId();
                $description[$id] = $valueNotification->getDescription();
                $title[$id] = $valueNotification->getTitle();
                
                $dateCreated = $valueNotification->getCreatedAt();
                $dateCreated->setTimestamp((int)$dateCreated->format('U'));            
                $fechaCreated = $dateCreated->format('d-m-Y'); 

                $date[$id] = $fechaCreated;
                $read[$id] = $valueNotification->getReadNotification();
                $status[$id] = $valueNotification->getStatus();
                $ids[] = $valueNotification->getId();
            }

            $data = [
                'description' => $description,
                'title'       => $title,
                'date'        => $date,
                'id'          => $ids,
                'read'        => $read,
                'status'      => $status,
                'cont'        => count($ids)
            ];
        }

        $response->setData($data);

        return $response;  
    }

    /**
     * 
     * @return \Pequiven\SEIPBundle\Service\SecurityService
     */
    protected function getSecurityService() {
        return $this->container->get('seip.service.security');
    }

    /**
     *  Notification
     *
     */
    protected function getNotificationService() {        
        return $this->container->get('seip.service.notification');        
    }

}
