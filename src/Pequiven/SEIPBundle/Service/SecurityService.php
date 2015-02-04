<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Service;

/**
 * Servicio para evaluar la seguridad en la aplicacion
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class SecurityService implements \Symfony\Component\DependencyInjection\ContainerAwareInterface
{
    private $container;
    
    public function isGranted($rol,$object = null) {
        $valid = $this->getSecurityContext()->isGranted($rol);
        if(!$valid){
            throw $this->createAccessDeniedHttpException($this->buildRoleMessage($rol));
        }
        
    }
    
    private function buildRoleMessage($rol)
    {
        return $this->trans(sprintf('pequiven_seip.security.403.%s',  strtolower($rol)));
    }

    private function getMessagesException($object)
    {
        $className = ClassUtils::getRealClass(get_class($object));
        static $messages = array(
            'Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram' => 'Programa de gestion'
        );
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
    private function createAccessDeniedHttpException($message = 'Permission Denied!', \Exception $previous = null)
    {
        return new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException($message, $previous);
    }
    
    protected function trans($id,array $parameters = array(), $domain = 'PequivenSEIPBundle')
    {
        return $this->container->get('translator')->trans($id, $parameters, $domain);
    }
    
    /**
     * Envia un mensaje flash
     * 
     * @param array $type success|error
     * @param type $message
     * @param type $parameters
     * @param type $domain
     * @return type
     */
    protected function setFlash($type,$message,$parameters = array(),$domain = 'flashes')
    {
        return $this->get('session')->getBag('flashes')->add($type,$this->trans($message, $parameters, $domain));
    }
    
    /**
     * 
     * @return \Symfony\Component\Security\Core\SecurityContextInterface
     * @throws \LogicException
     */
    protected function getSecurityContext()
    {
        if (!$this->container->has('security.context')) {
            throw new \LogicException('The SecurityBundle is not registered in your application.');
        }

        return $this->container->get('security.context');
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
    private function getUser()
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
    
    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
        $this->container = $container;
    }
}
