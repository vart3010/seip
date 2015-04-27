<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Model;

/**
 * Modelo del periodo
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
abstract class Period implements PeriodInterface
{
    
    /**
     * Se ven todos los períodos
     */
    const VIEW_ALL_PERIODS = 0;
    
    /**
     * 
     */
    const VIEW_ONLY_PERIOD_ACTIVE = 1;
    
    function isActive()
    {
        return $this->getStatus();
    }
    
    function getYear()
    {
        return $this->getDateStart()->format('Y');
    }
}
