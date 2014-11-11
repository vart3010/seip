<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\ArrangementProgramBundle\EventListener;

use LogicException;
use Pequiven\ArrangementProgramBundle\ArrangementProgramEvents;
use Sylius\Bundle\ResourceBundle\Event\ResourceEvent;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * Listerner del bundle
 *
 * @author Carlos Mendoza <inhack20@tecnocreaciones.com>
 */
class EventListerner implements EventSubscriberInterface, ContainerAwareInterface
{
    protected $container;
    
    public static function getSubscribedEvents() {
        return array(
            ArrangementProgramEvents::ARRANGEMENT_PROGRAM_PRE_DELETE => 'onPreDeleteArrangementProgram',
            ArrangementProgramEvents::ARRANGEMENT_PROGRAM_PRE_CREATE => 'onPreCreateArrangementProgram',
            ArrangementProgramEvents::ARRANGEMENT_PROGRAM_POST_CREATE => 'onPreCreateArrangementProgram',
        );
    }
    /**
     * Verifica que se pueda eliminar el programa de gestion
     * @param ResourceEvent $event
     * @throws type
     */
    function onPreDeleteArrangementProgram(ResourceEvent $event) {
        $object = $event->getSubject();
         //Security check
        if($this->getArrangementProgramManager()->isAllowToDelete($object) === false){
            throw $this->createAccessDeniedHttpException();
        }
    }
    
    function onPreCreateArrangementProgram(ResourceEvent $event) {
        $object = $event->getSubject();
        
        $sequenceGenerator = $this->container->get('seip.sequence_generator');
        $object->setRef($sequenceGenerator->getNextArrangementProgram($object));
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
     * @throws LogicException If SecurityBundle is not available
     *
     * @see TokenInterface::getUser()
     */
    public function getUser()
    {
        if (!$this->container->has('security.context')) {
            throw new LogicException('The SecurityBundle is not registered in your application.');
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
    
    /**
     * Returns a AccessDeniedHttpException.
     *
     * This will result in a 403 response code. Usage example:
     *
     *     throw $this->createAccessDeniedHttpException('Permission Denied!');
     *
     * @param string    $message  A message
     * @param \Exception $previous The previous exception
     *
     * @return \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException
     */
    protected function createAccessDeniedHttpException($message = 'Permission Denied!', \Exception $previous = null)
    {
        return new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException($message, $previous);
    }
    
    /**
     * Manejador de programa de gestion
     * 
     * @return \Pequiven\ArrangementProgramBundle\Model\ArrangementProgramManager
     */
    private function getArrangementProgramManager()
    {
        return $this->container->get('seip.arrangement_program.manager');
    }
}
