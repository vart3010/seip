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
 * Servicio para evaluar la seguridad en la aplicacion (seip.service.security)
 * 
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class SecurityService implements \Symfony\Component\DependencyInjection\ContainerAwareInterface
{
    private $container;
    
    private function getMethodValidMap()
    {
        return array(
            'ROLE_SEIP_PRE_PLANNING_CREATE_TACTIC' => 'evaluatePrePlanning',
            'ROLE_SEIP_PRE_PLANNING_CREATE_OPERATIVE' => 'evaluatePrePlanning',
        );
    }
    
    /**
     * Evalua que tambien se encuentre habilitado la pre-planificacion
     * @throws type
     */
    private function evaluatePrePlanning()
    {
        $seipConfiguration = $this->getSeipConfiguration();
        if($seipConfiguration->isEnablePrePlanning() === false){
            throw $this->createAccessDeniedHttpException($this->buildMessage('the_pre_planning_is_not_enabled', 'error'));
        }
    }

    public function checkSecurity($rol,$parameters = null) {
        if($rol === null){
            throw $this->createAccessDeniedHttpException($this->trans('pequiven_seip.security.permission_denied'));
        }
        $valid = $this->getSecurityContext()->isGranted($rol,$parameters);
        if(!$valid){
            throw $this->createAccessDeniedHttpException($this->buildMessage($rol));
        }
        $methodValidMap = $this->getMethodValidMap();
        if(isset($methodValidMap[$rol])){
            $method = $methodValidMap[$rol];
            $valid = call_user_func_array(array($this,$method),array($rol,$parameters));
        }
    }
    
    private function buildMessage($rol,$prefix = '403')
    {
        return $this->trans(sprintf('pequiven_seip.security.%s.%s', $prefix,strtolower($rol)));
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
        $this->setFlash('error', $message);
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
        return $this->container->get('session')->getBag('flashes')->add($type,$message);
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
    
    /**
     * 
     * @return \Pequiven\SEIPBundle\Service\Configuration
     */
    private function getSeipConfiguration()
    {
        return $this->container->get('seip.configuration');
    }
    
    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
        $this->container = $container;
    }
}
