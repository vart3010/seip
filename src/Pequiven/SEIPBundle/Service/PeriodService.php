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
            ($now >= $period->getDateStartNotificationArrangementProgram() && $now <= $period->getDateEndNotificationArrangementProgram()) ||
            ($now >= $period->getDateStartClearanceNotificationArrangementProgram() && $now <= $period->getDateEndClearanceNotificationArrangementProgram() && $this->isGranted('ROLE_ARRANGEMENT_PROGRAM_CLEARANCE'))
          ){
            $result = true;
        }
        return $result;
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
    function getPeriodActive()
    {
        $period = $this->container->get('pequiven.repository.period')->findOneActive();
        return $period;
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
    
    private function isGranted($roles) {
        if (!$this->container->has('security.context')) {
            throw new \LogicException('The SecurityBundle is not registered in your application.');
        }

        return $this->container->get('security.context')->isGranted($roles);
    }
}
