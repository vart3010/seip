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
}
