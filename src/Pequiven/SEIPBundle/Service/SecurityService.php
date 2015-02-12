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

use Pequiven\MasterBundle\Entity\Rol;

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
            
            'ROLE_SEIP_OBJECTIVE_VIEW_STRATEGIC' => 'evaluateStrategicObjetive',
            'ROLE_SEIP_OBJECTIVE_VIEW_TACTIC' => 'evaluateTacticObjetive',
            'ROLE_SEIP_OBJECTIVE_VIEW_OPERATIVE' => 'evaluateOperativeObjetive',
            
            'ROLE_SEIP_INDICATOR_VIEW_STRATEGIC' => 'evaluateStrategicIndicator',
            'ROLE_SEIP_INDICATOR_VIEW_TACTIC' => 'evaluateTacticIndicator',
            'ROLE_SEIP_INDICATOR_VIEW_OPERATIVE' => 'evaluateOperativeIndicator',
            
            'ROLE_SEIP_RESULT_VIEW_TACTIC' => 'evaluateTacticResult',
            'ROLE_SEIP_RESULT_VIEW_OPERATIVE' => 'evaluateTacticResult',
            
            'ROLE_SEIP_ARRANGEMENT_PROGRAM_VIEW_TACTIC' => 'evaluateTacticArrangementProgram',
            'ROLE_SEIP_ARRANGEMENT_PROGRAM_VIEW_OPERATIVE' => 'evaluateTacticArrangementProgram',
        );
    }
    
    private function evaluateTacticArrangementProgram($rol, \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram $arrangementProgram)
    {
        $user = $this->getUser();
        $valid = false;
        $rol = $user->getLevelRealByGroup();
        if($rol === Rol::ROLE_DIRECTIVE){
            $valid = true;
        }else{
            if($arrangementProgram->getType() == \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_TACTIC){
                $objetive = $arrangementProgram->getTacticalObjective();
                $gerencia = $objetive->getGerencia();
                if($rol == Rol::ROLE_GENERAL_COMPLEJO && $gerencia->getComplejo() === $user->getComplejo()){
                    $valid = true;
                }elseif($rol == Rol::ROLE_MANAGER_FIRST && $gerencia === $user->getGerencia()){
                    $valid = true;
                }elseif(($rol == Rol::ROLE_MANAGER_SECOND || $rol == Rol::ROLE_SUPERVISER || $rol == Rol::ROLE_WORKER_PQV) && $gerencia === $user->getGerenciaSecond()->getGerencia()){
                    $valid = true;
                }
            }elseif($arrangementProgram->getType() == \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_OPERATIVE){
                $objetive = $arrangementProgram->getOperationalObjective();
                $gerenciaSecond = $objetive->getGerenciaSecond();
                $gerencia = $gerenciaSecond->getGerencia();
                if($rol == Rol::ROLE_GENERAL_COMPLEJO && $gerencia->getComplejo() === $user->getComplejo()){
                    $valid = true;
                }elseif($rol == Rol::ROLE_MANAGER_FIRST && $gerencia === $user->getGerencia()){
                    $valid = true;
                }elseif(($rol == Rol::ROLE_MANAGER_SECOND || $rol == Rol::ROLE_SUPERVISER || $rol == Rol::ROLE_WORKER_PQV) && $gerenciaSecond === $user->getGerenciaSecond()){
                    $valid = true;
                }
            }
            
            if($valid === false){
                if($arrangementProgram->getResponsibles()->contains($user) === true){
                    $valid = true;
                }
                if($valid === false){
                    $goals = $arrangementProgram->getTimeline()->getGoals();
                    foreach ($goals as $goal) {
                        if($goal->getResponsibles()->contains($user) === true){
                            $valid = true;
                            break;
                        }
                    }
                }
            }
        }
        if(!$valid){
            $this->checkSecurity();
        }
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
    
    private function evaluateTacticResult($rol,$entity) 
    {
        $user = $this->getUser();
        $valid = false;
        $rol = $user->getLevelRealByGroup();
        if($rol === Rol::ROLE_DIRECTIVE){
            $valid = true;
        }else{
            if(is_a($entity, 'Pequiven\MasterBundle\Entity\Gerencia')){
                $gerencia = $entity;
                if($rol == Rol::ROLE_GENERAL_COMPLEJO && $gerencia->getComplejo() === $user->getComplejo()){
                    $valid = true;
                }elseif($rol == Rol::ROLE_MANAGER_FIRST && $gerencia === $user->getGerencia()){
                    $valid = true;
                }elseif(($rol == Rol::ROLE_MANAGER_SECOND || $rol == Rol::ROLE_SUPERVISER || $rol == Rol::ROLE_WORKER_PQV) && $gerencia === $user->getGerenciaSecond()->getGerencia()){
                    $valid = true;
                }
            }elseif(is_a($entity, 'Pequiven\MasterBundle\Entity\GerenciaSecond')){
                $gerenciaSecond = $entity;
                $gerencia = $entity->getGerencia();
                if($rol == Rol::ROLE_GENERAL_COMPLEJO && $gerencia->getComplejo() === $user->getComplejo()){
                    $valid = true;
                }elseif($rol == Rol::ROLE_MANAGER_FIRST && $gerencia === $user->getGerencia()){
                    $valid = true;
                }elseif(($rol == Rol::ROLE_MANAGER_SECOND || $rol == Rol::ROLE_SUPERVISER || $rol == Rol::ROLE_WORKER_PQV) && $gerenciaSecond === $user->getGerenciaSecond()){
                    $valid = true;
                }
            }
        }
        if(!$valid){
            $this->checkSecurity();
        }
    }


    private function evaluateStrategicIndicator($rol, \Pequiven\IndicatorBundle\Entity\Indicator $indicator)
    {
        $user = $this->getUser();
        $valid = false;
        $rol = $user->getLevelRealByGroup();
        if($rol === Rol::ROLE_DIRECTIVE){
            $valid = true;
        }else{
        }
        if(!$valid){
            $this->checkSecurity();
        }
    }
    
    function evaluateOperativeIndicator($rol, \Pequiven\IndicatorBundle\Entity\Indicator $indicator)
    {
        $valid = false;
        $user = $this->getUser();
        $rol = $user->getLevelRealByGroup();
        if($rol === Rol::ROLE_DIRECTIVE){
            $valid = true;
        }else{
            foreach ($indicator->getObjetives() as $objetive) {
                $gerenciaSecond = $objetive->getGerenciaSecond();
                $gerencia = $gerenciaSecond->getGerencia();

                if($rol == Rol::ROLE_GENERAL_COMPLEJO && $gerencia->getComplejo() === $user->getComplejo()){
                    $valid = true;
                }elseif($rol == Rol::ROLE_MANAGER_FIRST && $gerencia === $user->getGerencia()){
                    $valid = true;
                }elseif(($rol == Rol::ROLE_MANAGER_SECOND || $rol == Rol::ROLE_SUPERVISER || $rol == Rol::ROLE_WORKER_PQV) && $gerenciaSecond === $user->getGerenciaSecond()){
                    $valid = true;
                }
                
                if($valid === true){
                    break;
                }
            }
        }
        
        if(!$valid){
            $this->checkSecurity();
        }
    }
    
    function evaluateTacticIndicator($rol, \Pequiven\IndicatorBundle\Entity\Indicator $indicator)
    {
        $valid = false;
        $user = $this->getUser();
        $rol = $user->getLevelRealByGroup();
        if($rol === Rol::ROLE_DIRECTIVE){
            $valid = true;
        }else{
            foreach ($indicator->getObjetives() as $objetive) {
                $gerencia = $objetive->getGerencia();
                if($rol == Rol::ROLE_GENERAL_COMPLEJO && $gerencia->getComplejo() === $user->getComplejo()){
                    $valid = true;
                }elseif($rol == Rol::ROLE_MANAGER_FIRST && $gerencia === $user->getGerencia()){
                    $valid = true;
                }elseif(($rol == Rol::ROLE_MANAGER_SECOND || $rol == Rol::ROLE_SUPERVISER || $rol == Rol::ROLE_WORKER_PQV) && $gerencia === $user->getGerenciaSecond()->getGerencia()){
                    $valid = true;
                }
                
                if($valid === true){
                    break;
                }
            }
        }
        
        if(!$valid){
            $this->checkSecurity();
        }
    }
    
    private function evaluateTacticObjetive($rol, \Pequiven\ObjetiveBundle\Entity\Objetive $objetive)
    {
        $valid = false;
        $user = $this->getUser();
        $rol = $user->getLevelRealByGroup();
        
        if($rol === Rol::ROLE_DIRECTIVE){
            $valid = true;
        }else{
            $gerencia = $objetive->getGerencia();
            if($rol == Rol::ROLE_GENERAL_COMPLEJO && $gerencia->getComplejo() === $user->getComplejo()){
                $valid = true;
            }elseif($rol == Rol::ROLE_MANAGER_FIRST && $gerencia === $user->getGerencia()){
                $valid = true;
            }elseif(($rol == Rol::ROLE_MANAGER_SECOND || $rol == Rol::ROLE_SUPERVISER || $rol == Rol::ROLE_WORKER_PQV) && $gerencia === $user->getGerenciaSecond()->getGerencia()){
                $valid = true;
            }
        }
        if(!$valid){
            $this->checkSecurity();
        }
    }
    
    private function evaluateOperativeObjetive($rol, \Pequiven\ObjetiveBundle\Entity\Objetive $objetive)
    {
        $user = $this->getUser();
        $rol = $user->getLevelRealByGroup();
        $valid = false;
        if($rol == Rol::ROLE_DIRECTIVE){
            $valid = true;
        }else{
            $gerenciaSecond = $objetive->getGerenciaSecond();
            $gerencia = $gerenciaSecond->getGerencia();
            
            if($rol == Rol::ROLE_GENERAL_COMPLEJO && $gerencia->getComplejo() === $user->getComplejo()){
                $valid = true;
            }elseif($rol == Rol::ROLE_MANAGER_FIRST && $gerencia === $user->getGerencia()){
                $valid = true;
            }elseif(($rol == Rol::ROLE_MANAGER_SECOND || $rol == Rol::ROLE_SUPERVISER || $rol == Rol::ROLE_WORKER_PQV) && $gerenciaSecond === $user->getGerenciaSecond()){
                $valid = true;
            }
        }
        if(!$valid){
            $this->checkSecurity();
        }
    }
    private function evaluateStrategicObjetive($rol, \Pequiven\ObjetiveBundle\Entity\Objetive $objetive)
    {
        $user = $this->getUser();
        $valid = false;
        $rol = $user->getLevelRealByGroup();
        if($rol === Rol::ROLE_DIRECTIVE){
            $valid = true;
        }else{
        }
        if(!$valid){
            $this->checkSecurity();
        }
    }


    /**
     * Evalua que el usuario tenga acceso a la seccion especifica, ademas se valida con un segundo metodo
     * @param type $rol
     * @param type $parameters
     * @throws type
     */
    public function checkSecurity($rol = null,$parameters = null) {
        if($rol === null){
            throw $this->createAccessDeniedHttpException($this->trans('pequiven_seip.security.permission_denied'));
        }
        $roles = $rol;
        if(!is_array($rol)){
            $roles = array($rol);
        }
        $valid = $this->isGranted($roles,$parameters);
        $quantityRoles = count($roles);
        foreach ($roles as $rol) {
            if(!$valid){
                throw $this->createAccessDeniedHttpException($this->buildMessage($rol));
            }
            $methodValidMap = $this->getMethodValidMap();
            if($quantityRoles == 1 && isset($methodValidMap[$rol])){
                $method = $methodValidMap[$rol];
                $valid = call_user_func_array(array($this,$method),array($rol,$parameters));
            }
        }
    }
    
    /**
     * Genera el mensaje de error
     * @param type $rol
     * @param type $prefix
     * @return type
     */
    private function buildMessage($rol,$prefix = '403')
    {
        return $this->trans(sprintf('pequiven_seip.security.%s.%s', $prefix,strtolower($rol)));
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
     * @return \Pequiven\SEIPBundle\Entity\User
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
    
    function isGranted($roles,$object = null)
    {
        return $this->getSecurityContext()->isGranted($roles,$object);
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
