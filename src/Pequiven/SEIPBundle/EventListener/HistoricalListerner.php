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
            ArrangementProgramEvents::ARRANGEMENT_PROGRAM_PRE_CREATE => 'onPreCreateArrangementProgram'
        );
    }
    
    function onPreCreateArrangementProgram(ResourceEvent $event) {
        $object = $event->getSubject();
         $this->createHistorical(
                $object,
                ArrangementProgramEvents::ARRANGEMENT_PROGRAM_PRE_CREATE
        );
        
    }
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
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
}
