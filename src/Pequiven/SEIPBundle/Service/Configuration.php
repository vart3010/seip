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

use Tecnocreaciones\Bundle\ToolsBundle\Model\Configuration\ConfigurationManager;
use Tecnocreaciones\Bundle\ToolsBundle\Entity\Configuration\BaseGroup as Group;

/**
 * Configuracion del sistema
 *
 * @author Carlos Mendoza <inhack20@tecnocreaciones.com>
 */
class Configuration extends ConfigurationManager
{
    /**
     * Formato de fechas
     */
    const GENERAL_DATE_FORMAT = 'GENERAL_DATE_FORMAT';
    
    /**
     * Obtiene el tiempo de que se tomara en cuenta para mostrar los indicadores
     * 
     * @param string $default
     */
    function getGeneralDateFormat($default = 'Y-m-d h:i a')
    {
        return $this->get(self::GENERAL_DATE_FORMAT, $default);
    }
    
    /**
     * Establece el tiempo de que se tomara en cuenta para mostrar los indicadores
     * 
     * @param string $default
     */
    function setGeneralDateFormat($default = 'Y-m-d h:i a',$description = null, Group $group = null)
    {
        $this->set(self::GENERAL_DATE_FORMAT, $default,$description,$group);
        return $this;
    }
}
