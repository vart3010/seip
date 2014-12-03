<?php

namespace Pequiven\SEIPBundle\EventListener;

use Pequiven\ArrangementProgramBundle\ArrangementProgramEvents;
use Pequiven\SEIPBundle\Entity\Historical;
use Sylius\Bundle\ResourceBundle\Event\ResourceEvent;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Escucha los eventos ocurridos para registrarlos
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
class HistoricalListerner implements EventSubscriberInterface, ContainerAwareInterface
{
    protected $container;
    
    public static function getSubscribedEvents() {
        return array(
            ArrangementProgramEvents::ARRANGEMENT_PROGRAM_PRE_CREATE => 'onPreCreateArrangementProgram',
            ArrangementProgramEvents::ARRANGEMENT_PROGRAM_PRE_REVISED => 'onPreRevisedArrangementProgram',
            ArrangementProgramEvents::ARRANGEMENT_PROGRAM_PRE_APPROVED => 'onPreApprovedArrangementProgram',
            ArrangementProgramEvents::ARRANGEMENT_PROGRAM_PRE_SEND_TO_REVIEW => 'onPreSendToReviewArrangementProgram',
            ArrangementProgramEvents::ARRANGEMENT_PROGRAM_PRE_REJECTED => 'onPreRejectedArrangementProgram',
            ArrangementProgramEvents::ARRANGEMENT_PROGRAM_PRE_RETURN_TO_DRAFT => 'onPreSendToDraftArrangementProgram',
            ArrangementProgramEvents::ARRANGEMENT_PROGRAM_PRE_RETURN_TO_REVIEW => 'onPreReturnToReviewArrangementProgram',
            ArrangementProgramEvents::ARRANGEMENT_PROGRAM_PRE_START_THE_NOTIFICATION_PROCESS => 'onPreStartTheNotificationProcess',
            ArrangementProgramEvents::ARRANGEMENT_PROGRAM_PRE_FINISH_THE_NOTIFICATION_PROCESS => 'onPreFinishTheNotificationProcess',
            SeipEvents::VALUE_INDICATOR_PRE_ADD => 'onPreAddValueIndicatorToIndicator',
            SeipEvents::VALUE_INDICATOR_PRE_UPDATE => 'onPreUpdateValueIndicatorToIndicator',
            SeipEvents::INDICATOR_PRE_ADD_OBSERVATION => 'onPreAddObservationToIndicator',
        );
    }
    
    /**
     * Se agrega al historico cuando se creo el programa de gestion
     * @param ResourceEvent $event
     */
    function onPreCreateArrangementProgram(ResourceEvent $event) {
        $object = $event->getSubject();
         $this->createHistorical(
                $object,
                ArrangementProgramEvents::ARRANGEMENT_PROGRAM_PRE_CREATE
        );
    }
    
    /**
     * Se agrega una entrada al historico cuando se revisa el programa de gestion
     * @param ResourceEvent $event
     */
    function onPreRevisedArrangementProgram(ResourceEvent $event) {
        $object = $event->getSubject();
         $this->createHistorical(
                $object,
                ArrangementProgramEvents::ARRANGEMENT_PROGRAM_PRE_REVISED
        );
    }
    
    /**
     * Se agrega una entrada al historico cuando se aprueba el programa de gestion
     * @param ResourceEvent $event
     */
    function onPreApprovedArrangementProgram(ResourceEvent $event) {
        $object = $event->getSubject();
         $this->createHistorical(
                $object,
                ArrangementProgramEvents::ARRANGEMENT_PROGRAM_PRE_APPROVED
        );
    }
    
    /**
     * Se agrega una entrada al historico cuando se envia a revision el programa de gestion
     * @param ResourceEvent $event
     */
    function onPreSendToReviewArrangementProgram(ResourceEvent $event) {
        $object = $event->getSubject();
         $this->createHistorical(
                $object,
                ArrangementProgramEvents::ARRANGEMENT_PROGRAM_PRE_SEND_TO_REVIEW
        );
    }
    
    /**
     * Se agrega una entrada al historico cuando se rechaza el programa de gestion
     * @param ResourceEvent $event
     */
    function onPreRejectedArrangementProgram(ResourceEvent $event) {
        $object = $event->getSubject();
         $this->createHistorical(
                $object,
                ArrangementProgramEvents::ARRANGEMENT_PROGRAM_PRE_REJECTED
        );
    }
    
    /**
     * Se agrega una entrada al historico cuando se regresa el programa de gestion a borrador
     * @param ResourceEvent $event
     */
    function onPreSendToDraftArrangementProgram(ResourceEvent $event) {
        $object = $event->getSubject();
         $this->createHistorical(
                $object,
                ArrangementProgramEvents::ARRANGEMENT_PROGRAM_PRE_RETURN_TO_DRAFT
        );
    }
    
    /**
     * Se agrega una entrada al historico cuando se regresa el programa de gestion a revision
     * @param ResourceEvent $event
     */
    function onPreReturnToReviewArrangementProgram(ResourceEvent $event) {
        $object = $event->getSubject();
         $this->createHistorical(
                $object,
                ArrangementProgramEvents::ARRANGEMENT_PROGRAM_PRE_SEND_TO_REVIEW
        );
    }
    
    /**
     * Se agrega una entrada al historico cuando se inicia el proceso de notificacion en el programa de gestion
     * @param ResourceEvent $event
     */
    function onPreStartTheNotificationProcess(ResourceEvent $event) {
        $object = $event->getSubject();
        $user = $this->getUser();
         $this->createHistorical(
                $object,
                ArrangementProgramEvents::ARRANGEMENT_PROGRAM_PRE_START_THE_NOTIFICATION_PROCESS,
                array(
                    '%user%' => (string)$user
                )
        );
    }
    
    /**
     * Se agrega una entrada al historico cuando se inicia el proceso de notificacion en el programa de gestion
     * @param ResourceEvent $event
     */
    function onPreFinishTheNotificationProcess(ResourceEvent $event) {
        $object = $event->getSubject();
        $user = $this->getUser();
         $this->createHistorical(
                $object,
                ArrangementProgramEvents::ARRANGEMENT_PROGRAM_PRE_FINISH_THE_NOTIFICATION_PROCESS,
                array(
                    '%user%' => (string)$user
                )
        );
    }
    
    /**
     * Se agrega una entrada al historico cuando se regresa el programa de gestion a revision
     * @param ResourceEvent $event
     */
    function onPreAddObservationToIndicator(ResourceEvent $event) {
        $object = $event->getSubject();
        
         $this->createHistorical(
                $object,
                SeipEvents::INDICATOR_PRE_ADD_OBSERVATION
        );
    }
    
    /**
     * Se agrega una entrada al historico cuando se regresa el programa de gestion a revision
     * @param ResourceEvent $event
     */
    function onPreAddValueIndicatorToIndicator(ResourceEvent $event) {
        $object = $event->getSubject();
        $indicator = $object->getIndicator();
         $this->createHistorical(
            $indicator,
            SeipEvents::VALUE_INDICATOR_PRE_ADD,
            array(
                '%value%' => number_format($object->getValueOfIndicator(),3,',','.'),
            )
        );
    }
    
    /**
     * Se agrega una entrada al historico cuando se regresa el programa de gestion a revision
     * @param ResourceEvent $event
     */
    function onPreUpdateValueIndicatorToIndicator(ResourceEvent $event) {
        $object = $event->getSubject();
        $indicator = $object->getIndicator();
        $previusValue = $event->getArgument('previusValue');
         $this->createHistorical(
            $indicator,
            SeipEvents::VALUE_INDICATOR_PRE_UPDATE,
            array(
                '%previusValue%' => number_format($previusValue,3,',','.'),
                '%newValue%' => number_format($object->getValueOfIndicator(),3,',','.'),
            )
        );
    }
    
    private function createHistorical($object,$event,array $parameters = array(),$comment = null) {
        $user = $this->getUser();
        $history = new Historical();
        $history
                ->setEvent($this->trans($event,$parameters))
                ->setUser($user)
                ->setComment($comment)
                ;
        $object->addHistory($history);
    }
    
    function trans($id, $parameters = array(), $domain = 'historical')
    {
        return $this->container->get('translator')->trans($id, $parameters, $domain);
    }
    
    /**
     * Get a user from the Security Context
     *
     * @return mixed
     *
     * @throws \LogicException If SecurityBundle is not available
     *
     * @see Symfony\Component\Security\Core\Authentication\Token\TokenInterface::getUser()
     */
    public function getUser()
    {
        if (!$this->container->has('security.context')) {
            throw new \LogicException('The SecurityBundle is not registered in your application.');
        }

        if (null === $token = $this->container->get('security.context')->getToken()) {
            return;
        }

        if (!is_object($user = $token->getUser())) {
            return;
        }

        return $user;
    }
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}
