<?php

namespace Pequiven\ArrangementProgramBundle\EventListener;

use Pequiven\ArrangementProgramBundle\ArrangementProgramEvents;
use Pequiven\SEIPBundle\EventListener\BaseEventListerner;
use Sylius\Bundle\ResourceBundle\Event\ResourceEvent;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

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
        );
    }
    
    function onArrangementProgramPostSendToReview(ResourceEvent $event) {
        $object = $event->getSubject();
        $template = $this->getPathForTemplate('draftToInRevision');
        $this->mailerSendMessage($template, $context, $fromEmail, $toEmail);
    }
    
    private function getPathForTemplate($templateName) {
        return sprintf('PequivenArrangementProgramBundle:ArrangementProgram:email/%s.html.twig',$templateName);
    }
}
