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
