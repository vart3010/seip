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

use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * Servicio para obtener datos del periodo (pequiven_arrangement_program.service.period)
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class PeriodService extends ContainerAware 
{
    /**
     * Retorna si se encuetra habilitada la notificacion del programa de gestion para el periodo activo.
     * @return boolean
     */
    function isAllowNotifyArrangementProgram()
    {
        $result = false;
        $period = $this->getPeriodActive();
        $now = new \DateTime();
        
        if(
            ($now >= $period->getDateStartNotificationArrangementProgram() && $now <= $period->getDateEndNotificationArrangementProgram())
          ){
            $result = true;
        }
        return $result;
    }
    /**
     * Puede notificar en periodo de holgura
     * @return boolean
     */
    function isAllowNotifyArrangementProgramInClearance()
    {
        $result = false;
        $period = $this->getPeriodActive();
        $now = new \DateTime();
        if($this->isGranted('ROLE_SEIP_ARRANGEMENT_PROGRAM_OPERATION_NOTIFY_CLEARANCE') && ($now >= $period->getDateStartClearanceNotificationArrangementProgram() && $now <= $period->getDateEndClearanceNotificationArrangementProgram())){
            $result = true;
        }
        return $result;
        
    }
    
    /**
     * Evalua si se debe aplicar la penalizacion al resultado
     * @return boolean
     */
    function isPenaltyInResult(\DateTime $dateToEvaluate = null)
    {
        if($dateToEvaluate === null){
            return false;
        }
        $period = $this->getPeriodActive();
        $r = ($dateToEvaluate >= $period->getDateStartPenalty() && $dateToEvaluate <= $period->getDateEndPenalty());
        return $r;
    }
    
    /**
     * Retorna si se encuetra habilitada la carga de programa de gestion para el periodo activo.
     * @return boolean
     */
    function isAllowLoadArrangementProgram()
    {
        $result = false;
        $period = $this->getPeriodActive();
        $now = new \DateTime();
        
        if($now >= $period->getDateStartLoadArrangementProgram() && $now <= $period->getDateEndLoadArrangementProgram()){
            $result = true;
        }
        return $result;
    }
    
    /**
     * Retorna el periodo activo
     * @return \Pequiven\SEIPBundle\Entity\Period
     */
    public function getPeriodActive()
    {
        $request = $this->getRequest();
        $session = $request->getSession();
        $periodActiveSerialize = $session->get('periodActiveSerialize');
        $periodRepository = $this->getRepository();
        $period = null;
        if($periodActiveSerialize !== null){
            $period = unserialize($periodActiveSerialize);
            $period = $this->getDoctrine()->getManager()->merge($period);
        }
        if(!$period){
            $period = $this->getUser()->getPeriod();
        }
        if(!$period){
            $period = $periodRepository->findOneActive();
        }
        
        return $period;
    }
    
    /**
     * Retorna la entidad del periodo activo para persistir en la base de datos la relacion
     * @return \Pequiven\SEIPBundle\Entity\Period
     */
    public function getEntityPeriodActive($forPersist = false)
    {
        $period = $this->getPeriodActive();
//        $periodRepository = $this->getRepository();
//        return $periodRepository->find($period->getId());
        return $period;
    }
    
    /**
     * Guardar el perido activo que selecciono el usuario
     * @param \Pequiven\SEIPBundle\Entity\Period $period
     */
    function setPeriodActive(\Pequiven\SEIPBundle\Entity\Period $period)
    {
        $request = $this->getRequest();
        $session = $request->getSession();
        $periodSerialize = serialize($period);
        $session->set('periodActiveSerialize', $periodSerialize);
        $user = $this->getUser();
        $user->setPeriod($period);
        $this->getUserManager()->updateUser($user);
    }
    
    /**
     * Limpia de la cache el periodo selecionado
     */
    public function clearCachePeriodActive() 
    {
        $request = $this->getRequest();
        $session = $request->getSession();
        $session->remove('periodActiveSerialize');
    }
    
    /**
     * Retorna el periodo siguiente
     * @return \Pequiven\SEIPBundle\Entity\Period
     */
    public function getNextPeriod()
    {
        $nextPeriod = null;
        $periodActive = $this->getEntityPeriodActive();
        if($periodActive){
            $nextPeriod = $periodActive->getChild();
        }
        return $nextPeriod;
    }
    
    /**
     * Retorna la lista de periodos disponibles para consultar
     * @return type
     */
    public function getPeriodsAvailableConsultation() 
    {
        return $this->getRepository()->findAll();
    }
    
    public function getListArrayPeriodsAvailableConsultation()
    {
        $request = $this->getRequest();
        $session = $request->getSession();
        $listArrayPeriods = $session->get('listPeriods');
        if($listArrayPeriods !== null){
            return $listArrayPeriods;
        }
        $periods = $this->getPeriodsAvailableConsultation();
        foreach ($periods as $period) {
            $listArrayPeriods[] = array(
                'id' => $period->getId(),
                'description' => (string)$period
            );
        }
        $session->set('listPeriods',$listArrayPeriods);
        return $listArrayPeriods;
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
    
    private function isGranted($roles) {
        if (!$this->container->has('security.context')) {
            throw new \LogicException('The SecurityBundle is not registered in your application.');
        }

        return $this->container->get('security.context')->isGranted($roles);
    }
    
    /**
     * 
     * @return \Symfony\Component\HttpFoundation\Request
     */
    public function getRequest()
    {
        return $this->container->get('request_stack')->getCurrentRequest();
    }
    
    /**
     * Repositorio del periodo
     * @return \Pequiven\SEIPBundle\Repository\PeriodRepository
     */
    private function getRepository()
    {
        return $this->container->get('pequiven.repository.period');
    }
    /**
     * @return \FOS\UserBundle\Model\UserManager
     */
    private function getUserManager()
    {
        return $this->container->get('fos_user.user_manager');
    }
    
    /**
     * Shortcut to return the Doctrine Registry service.
     *
     * @return \Doctrine\Bundle\DoctrineBundle\Registry
     *
     * @throws \LogicException If DoctrineBundle is not available
     */
    private function getDoctrine()
    {
        if (!$this->container->has('doctrine')) {
            throw new \LogicException('The DoctrineBundle is not registered in your application.');
        }

        return $this->container->get('doctrine');
    }
}
