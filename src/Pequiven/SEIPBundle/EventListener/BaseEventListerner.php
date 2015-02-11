<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\SEIPBundle\EventListener;

/**
 * Description of BaseEventListerner
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
abstract class BaseEventListerner implements \Symfony\Component\EventDispatcher\EventSubscriberInterface, \Symfony\Component\DependencyInjection\ContainerAwareInterface
{
    protected $container;
    
    protected function trans($id, $parameters = array(), $domain = 'PequivenSEIPBundle')
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
    protected function getUser()
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

    /**
     * Envia un mensaje de correo con el mailer
     */
    protected function mailerSendMessage($templateName, $context, $fromEmail, $toEmail) 
    {
        if($from === null){
            $from = $this->getSeipConfiguration()->getEmailFromDefault();
        }
        $this->container->get('pequiven_seip.mailer.twig_swift')->sendMessage($templateName, $context, $fromEmail, $toEmail);
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
     * Configuracion global del SEIP
     * 
     * @return \Pequiven\SEIPBundle\Service\Configuration
     */
    protected function getSeipConfiguration() {
        return $this->container->get('seip.configuration');
    }
    
    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
        $this->container = $container;
    }
}
