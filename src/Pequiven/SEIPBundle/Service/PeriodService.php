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
    
    function getPeriodActive()
    {
        $period = $this->container->get('pequiven.repository.period')->findOneActive();
        return $period;
    }
}
