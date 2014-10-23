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
     * Valor de programa de gestion asociado a (Por defecto)
     */
    const ARRANGEMENT_PROGRAM_ASSOCIATED_TO = 'ARRANGEMENT_PROGRAM_ASSOCIATED_TO';
    
    /**
     * Habilitar compatibilidad con el sistema integrado de gestion (SIG)
     */
    const SUPPORT_INTEGRATED_MANAGEMENT_SYSTEM = 'SUPPORT_INTEGRATED_MANAGEMENT_SYSTEM';
    
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
    
    /**
     * Establece valor del formulario del programa de gestion "asociado a" (Por defecto)
     * 
     * @param string $default
     */
    function setArrangementProgramAssociatedTo($default,$description = 'Valor del formulario del programa de gestion "asociado a"', Group $group = null)
    {
        $this->set(self::ARRANGEMENT_PROGRAM_ASSOCIATED_TO, $default,$description,$group);
        return $this;
    }
    
    /**
     * Obtiene el valor del formulario del programa de gestion "asociado a" (Por defecto)
     * 
     * @param string $default
     */
    function getArrangementProgramAssociatedTo($default = null)
    {
        $id = $this->get(self::ARRANGEMENT_PROGRAM_ASSOCIATED_TO, $default);
        $em = $this->getDoctrine()->getManager();
        return $em->find('Pequiven\MasterBundle\Entity\ArrangementProgram\CategoryArrangementProgram', $id);
    }
    
    /**
     * Retorna si esta habilitada compatibilidad con el sistema integrado de gestion (SIG)
     * 
     * @param boolean $default
     * @return boolean
     */
    function isSupportIntegratedManagementSystem($default = false) {
        return (boolean)$this->get(self::SUPPORT_INTEGRATED_MANAGEMENT_SYSTEM, $default);
    }
    
    /**
     * Establece valor si esta habilitada compatibilidad con el sistema integrado de gestion (SIG)
     * 
     * @param string $default
     */
    function setSupportIntegratedManagementSystem($default,$description = 'Compatibilidad con el sistema integrado de gestion (SIG)', Group $group = null)
    {
        $this->set(self::SUPPORT_INTEGRATED_MANAGEMENT_SYSTEM, $default,$description,$group);
        return $this;
    }
}
