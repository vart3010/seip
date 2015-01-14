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
    function isAllowLoadArrangementProgram()
    {
        $result = false;
        $period = $this->getPeriodActive();
        $now = new \DateTime();
        var_dump($period->getDateEndLoadArrangementProgram() <= $now);
        die;
        if($period->getDateStartLoadArrangementProgram() >= $now && $period->getDateEndLoadArrangementProgram() <= $now){
            $result = true;
        }
        return $result;
    }
    
    /**
     * 
     * @return \Pequiven\SEIPBundle\Entity\Period
     */
    function getPeriodActive()
    {
        $period = $this->container->get('pequiven.repository.period')->findOneActive();
        return $period;
    }
}
