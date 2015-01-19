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
 * Description of ToolService
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class ToolService 
{
    /**
     * Retorna el ultimo dia del mes y año necesitado
     * @param type $elAnio
     * @param type $elMes
     * @return type
     */
    public static function getLastDayMonth($elAnio,$elMes) {
        return date("d",(mktime(0,0,0,$elMes+1,1,$elAnio)-1));
    }
}
