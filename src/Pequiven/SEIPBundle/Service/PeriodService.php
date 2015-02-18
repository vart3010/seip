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
    function isPenaltyInResult(\DateTime $dateToEvaluate)
    {
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
        }
        if(!$period){
            $period = $periodRepository->findOneActive();
        }
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
        $periodActive = $this->getPeriodActive();
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
}
