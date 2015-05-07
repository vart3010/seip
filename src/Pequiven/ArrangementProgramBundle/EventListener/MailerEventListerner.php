<?php

namespace Pequiven\ArrangementProgramBundle\EventListener;

use Pequiven\ArrangementProgramBundle\ArrangementProgramEvents;
use Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram;
use Pequiven\SEIPBundle\EventListener\BaseEventListerner;
use Sylius\Bundle\ResourceBundle\Event\ResourceEvent;
use Pequiven\SEIPBundle\EventListener\SeipEvents;

/**
 * Captura los eventos del programa de gestion y envia los correos
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
class MailerEventListerner extends BaseEventListerner
{
    public static function getSubscribedEvents() {
        return array(
            ArrangementProgramEvents::ARRANGEMENT_PROGRAM_POST_SEND_TO_REVIEW => 'onArrangementProgramPostSendToReview',
            ArrangementProgramEvents::ARRANGEMENT_PROGRAM_POST_REVISED => 'onArrangementProgramPostRevised',
            ArrangementProgramEvents::ARRANGEMENT_PROGRAM_POST_APPROVED => 'onArrangementProgramPostApproved',
            ArrangementProgramEvents::ARRANGEMENT_PROGRAM_POST_RETURN_TO_REVIEW => 'onArrangementProgramPostReturnToReview',
            ArrangementProgramEvents::ARRANGEMENT_PROGRAM_POST_RETURN_TO_DRAFT => 'onArrangementProgramPostReturnToDraft',
            SeipEvents::PRE_PLANNING_POST_SEND_TO_DRAFT => 'onPrePlanningSentToDraft',
            SeipEvents::PRE_PLANNING_POST_SEND_TO_REVIEW => 'onPrePlanningSendToReview',
        );
    }
    
    /**
     * Envia un correo de notificacion a las personas responsabes de revisar el programa de gestion
     * @param ResourceEvent $event
     */
    function onArrangementProgramPostSendToReview(ResourceEvent $event) {
        $templateName = 'draftToInRevision';
        $methodEmailList = 'getEmailsToReviser';
        $this->sendEmail($event, $templateName, $methodEmailList);
    }
    
    /**
     * Envia un correo de notificacion a las personas responsabes de aprobar el programa de gestion
     * @param ResourceEvent $event
     */
    function onArrangementProgramPostRevised(ResourceEvent $event) {
        $templateName = 'inRevisionToRevised';
        $methodEmailList = 'getEmailsToApprove';
        $this->sendEmail($event, $templateName, $methodEmailList);
    }
    
    /**
     * Envia un correo de notificacion a las personas involucradas en el programa de gestion que se aprobo
     * @param ResourceEvent $event
     */
    function onArrangementProgramPostApproved(ResourceEvent $event) {
        $templateName = 'revisedToAproved';
        $methodEmailList = 'getEmailsAllResponsibles';
        $this->sendEmail($event, $templateName, $methodEmailList);
        
        $templateName = 'notityToNotifiers';
        $methodEmailList = 'getEmailsUserToNotify';
        $this->sendEmail($event, $templateName, $methodEmailList);
    }
    
    /**
     * Envia un correo de notificacion a las personas involucradas en el programa de gestion que se regreso a revision
     * @param ResourceEvent $event
     */
    function onArrangementProgramPostReturnToReview(ResourceEvent $event) {
        $templateName = 'returnRevisedToInRevision';
        $methodEmailList = 'getEmailsToReviser';
        $this->sendEmail($event, $templateName, $methodEmailList);
    }
    
    /**
     * Envia un correo de notificacion a las personas involucradas en el programa de gestion que se regreso a borrador
     * @param ResourceEvent $event
     */
    function onArrangementProgramPostReturnToDraft(ResourceEvent $event) {
        $templateName = 'returnInRevisionToDraft';
        $methodEmailList = 'getEmailsToReturnDraft';
        $this->sendEmail($event, $templateName, $methodEmailList);
    }
    
    /**
     * Envia un correo al dueno de se le devolvio el arbol a borrador de pre-planificacion
     * @param \Symfony\Component\EventDispatcher\GenericEvent $event
     */
    public function onPrePlanningSentToDraft(\Symfony\Component\EventDispatcher\GenericEvent $event) 
    {
        $object = $event->getSubject();
        $gerencia = null;
        $userTree = $object->getUser();
        $users = array($userTree);
        $usersEmail = $this->getEmailsInString($users);
        
        $configuration = $userTree->getConfiguration();
        $prePlanningConfiguration = $configuration->getPrePlanningConfiguration();
        if($object->getLevelPlanning() == \Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanning::LEVEL_TACTICO){
            $gerencia = $prePlanningConfiguration->getGerencia();
        }elseif($object->getLevelPlanning() == \Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanning::LEVEL_OPERATIVO){
            $gerencia = $prePlanningConfiguration->getGerenciaSecond();
        }
        $template = 'PequivenSEIPBundle:PrePlanning:Email/sendToDraft.html.twig';
        $toEmail = $usersEmail;
        
        $context = array(
            'user' => $userTree,
            'gerencia' => $gerencia
        );
        $this->mailerSendMessage($template, $context, null, $toEmail);
    }
    
    public function onPrePlanningSendToReview(\Symfony\Component\EventDispatcher\GenericEvent $event) 
    {
        $object = $event->getSubject();
        $gerencia = null;
        
        $usersEmail = $this->getSeipConfiguration()->getEmailNotifyToRevision();
        $userTree = $object->getUser();
        $configuration = $userTree->getConfiguration();
        $prePlanningConfiguration = $configuration->getPrePlanningConfiguration();
        if($object->getLevelPlanning() == \Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanning::LEVEL_TACTICO){
            $gerencia = $prePlanningConfiguration->getGerencia();
        }elseif($object->getLevelPlanning() == \Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanning::LEVEL_OPERATIVO){
            $gerencia = $prePlanningConfiguration->getGerenciaSecond();
        }
        $template = 'PequivenSEIPBundle:PrePlanning:Email/sendToRevision.html.twig';
        $toEmail = $usersEmail;
        
        $context = array(
            'user' => $userTree,
            'gerencia' => $gerencia
        );
        $this->mailerSendMessage($template, $context, null, $toEmail);
    }
    
    /**
     * Envia el correo de notificacion correspondiente
     * @param ResourceEvent $event
     * @param type $templateName
     * @param type $methodEmailList
     */
    private function sendEmail(ResourceEvent $event,$templateName,$methodEmailList) {
        if($this->getSeipConfiguration()->isArrangementProgramSendEmailNotifications() == false){
            return ;
        }
        $object = $event->getSubject();
        $template = $this->getPathForTemplate($templateName);
        $context = array(
            'user' => $this->getUser(),
            'arrangementProgram' => $object
        );
        $toEmail = $this->$methodEmailList($object);
        $this->mailerSendMessage($template, $context, null, $toEmail);
    }

    private function getConfiguration(ArrangementProgram $entity)
    {
        $configuration = $entity->getTacticalObjective()->getGerencia()->getConfiguration();
        return $configuration;
    }
    
    /**
     * Retorna los usuarios encargados de revision
     * 
     * @param ArrangementProgram $entity
     * @return type
     */
    private function getUserToReviser(ArrangementProgram $entity) {
        $configuration =  $this->getConfiguration($entity);
        $users = array();
        if($entity->getCategoryArrangementProgram()->getId() == ArrangementProgram::ASSOCIATE_ARRANGEMENT_PROGRAM_PLA){
            $notifyToGerenciaSecond = $this->getNotifyToGerenciaSecond($entity);

            if($configuration){
                foreach ($configuration->getArrangementProgramUserToRevisers() as $value) {
                    if($notifyToGerenciaSecond !== null){
                        if($value->getGerenciaSecond() !== $notifyToGerenciaSecond){
                            continue;
                        }
                    }
                    $users[] = $value;
                }
            }
        } else{
            if($configuration){
                foreach ($configuration->getArrangementProgramSigUsersToReviser() as $value) {
                    $users[] = $value;
                }
            }
        }
        return $users;
    }
    
    /**
     * Retorna los usuarios encargados de notificar
     * 
     * @param ArrangementProgram $entity
     * @return type
     */
    private function getUserToNotify(ArrangementProgram $entity) {
        $configuration =  $this->getConfiguration($entity);
        $users = array();
        
        if($entity->getCategoryArrangementProgram()->getId() == ArrangementProgram::ASSOCIATE_ARRANGEMENT_PROGRAM_PLA){
            $notifyToGerenciaSecond = $this->getNotifyToGerenciaSecond($entity);

            if($configuration){
                foreach ($configuration->getArrangementProgramUsersToNotify() as $value) {
                    if($notifyToGerenciaSecond !== null){
                        if($value->getGerenciaSecond() !== $notifyToGerenciaSecond){
                            continue;
                        }
                    }
                    $users[] = $value;
                }
            }
        } else{
            if($configuration){
                foreach ($configuration->getArrangementProgramSigUsersToNotify() as $value) {
                    $users[] = $value;
                }
            }
        }
        return $users;
    }
    
    /**
     * Retorna los usuarios encargados de aprobar el programa de gestion
     * 
     * @param ArrangementProgram $entity
     * @return type
     */
    private function getUserToAprrove(ArrangementProgram $entity)
    {
        $configuration =  $this->getConfiguration($entity);
        $users = array();
        if($entity->getCategoryArrangementProgram()->getId() == ArrangementProgram::ASSOCIATE_ARRANGEMENT_PROGRAM_PLA){
            if($configuration){
                if($entity->getType() == ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_TACTIC){
                    $users = $configuration->getArrangementProgramUsersToApproveTactical();
                }else if($entity->getType() == ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_OPERATIVE){
                    $notifyToGerenciaSecond = $this->getNotifyToGerenciaSecond($entity);
                    $allUsersToAprrove = $configuration->getArrangementProgramUsersToApproveOperative();
                    foreach ($allUsersToAprrove as $value) {
                        if($notifyToGerenciaSecond !== null){
                            if($value->getGerenciaSecond() !== $notifyToGerenciaSecond){
                                continue;
                            }
                        }
                        $users[] = $value;
                    }
                }
            }
        } else{
            if($configuration){
                foreach ($configuration->getArrangementProgramSigUsersToApprove() as $value) {
                    $users[] = $value;
                }
            }
        }
        return $users;
    }
    
    /**
     * Retorna los usuarios involucrados en el programa de gestion
     * 
     * @param ArrangementProgram $entity
     * @return type
     */
    private function getUserAllResponsibles(ArrangementProgram $entity)
    {
        $users = array();
        
        //Buscar los responsables del programa
        foreach ($entity->getResponsibles() as $responsible) {
            $users[$responsible->getEmail()] = $responsible;
        }
        
        $timeline = $entity->getTimeline();
        //Buscar los responsables de las metas
        foreach ($timeline->getGoals() as $goal) {
            foreach ($goal->getResponsibles() as $responsible) {
                $users[$responsible->getEmail()] = $responsible;
            }
        }
        
        return $users;
    }
    
    /**
     * Retorna los correos de las personas encargadas de revisar el programa de gestion
     * @param ArrangementProgram $entity
     * @return type
     */
    private function getEmailsToReviser(ArrangementProgram $entity) 
    {
        $emails = $this->getEmailsInString($this->getUserToReviser($entity));
        return $emails;
    }
    
    /**
     * Retorna los correos de las personas encargadas de aprobar el programa de gestion
     * @param ArrangementProgram $entity
     * @return type
     */
    private function getEmailsToApprove(ArrangementProgram $entity) 
    {
        $emails = $this->getEmailsInString($this->getUserToAprrove($entity));
        return $emails;
    }
    
    /**
     * Retorna los correos de las personas encargadas de notificar el programa de gestion
     * @param ArrangementProgram $entity
     * @return type
     */
    private function getEmailsUserToNotify(ArrangementProgram $entity) 
    {
        $emails = $this->getEmailsInString($this->getUserToNotify($entity));
        return $emails;
    }
    
    /**
     * Retorna los correos de las personas responsabes del programa de gestion
     * @param ArrangementProgram $entity
     * @return type
     */
    private function getEmailsAllResponsibles(ArrangementProgram $entity) 
    {
        $emails = $this->getEmailsInString($this->getUserAllResponsibles($entity));
        return $emails;
    }
    
    /**
     * Retorna el correo de la persona que creo el programa y que lo envio a revision
     * 
     * @param ArrangementProgram $entity
     * @return type
     */
    private function getEmailsToReturnDraft(ArrangementProgram $entity)
    {
        $users = array();
        $users[] = $entity->getCreatedBy();
        if($entity->getDetails()->getSendToReviewBy() != null){
            $users[] = $entity->getDetails()->getSendToReviewBy();
        }
        return $this->getEmailsInString($users);
    }


    /**
     * Retorna un array asociativo con los correos y usuarios
     * 
     * @param array $users
     * @return type
     */
    private function getEmailsInString(array $users) {
        $emails = array();
        foreach ($users as $user) {
            if(strpos($user->getEmail(), '@') === false){
                continue;
            }
            $emails[$user->getEmail()] = (string)$user;
        }
        return $emails;
    }
    
    /**
     * Si el programa de gestion es operativo y la gerencia es un complejo, retorna la gerencia a la que se debe notificar
     * @param ArrangementProgram $entity
     * @return type
     */
    private function getNotifyToGerenciaSecond(ArrangementProgram $entity)
    {
        $notifyToGerenciaSecond = null;
        if($entity->getType() == ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_OPERATIVE){
            $objetiveOperative = $entity->getOperationalObjective();
            $gerenciaSecond = $objetiveOperative->getGerenciaSecond();
            if(
                $gerenciaSecond && ($gerencia = $gerenciaSecond->getGerencia()) != null 
                && ($gerenciaGroup = $gerencia->getGerenciaGroup()) != null
                && $gerenciaGroup->getGroupName() == \Pequiven\MasterBundle\Entity\GerenciaGroup::TYPE_COMPLEJOS
                )
                {
                $notifyToGerenciaSecond = $gerenciaSecond;
            }
        }
        return $notifyToGerenciaSecond;
    }

    /**
     * Contruye el path del template twig del contenido del email
     * @param type $templateName
     * @return type
     */
    private function getPathForTemplate($templateName) {
        return sprintf('PequivenArrangementProgramBundle:ArrangementProgram:email/%s.html.twig',$templateName);
    }
}
