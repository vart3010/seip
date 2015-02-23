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
 * Service (seip.configuration)
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
     * Limite de items en el periodo
     */
    const GENERAL_LIMIT_ITEMS = 'GENERAL_LIMIT_ITEMS';
    
    /**
     * Habilitar compatibilidad con el sistema integrado de gestion (SIG)
     */
    const SUPPORT_INTEGRATED_MANAGEMENT_SYSTEM = 'SUPPORT_INTEGRATED_MANAGEMENT_SYSTEM';
    
    /**
     * Habilitar el envio de correo electronico en los eventos del programa de gestion
     */
    const ARRANGEMENT_PROGRAM_SEND_EMAIL_NOTIFICATIONS = 'ARRANGEMENT_PROGRAM_SEND_EMAIL_NOTIFICATIONS';
    
    /**
     * Habilita la pre planificacion del periodo siguiente
     */
    const PRE_PLANNING_ENABLE_PRE_PLANNING = 'PRE_PLANNING_ENABLE_PRE_PLANNING';
    
    /**
     * Lista de correos que se debe notificar cuando se envie una pre-planificacion a revision.
     */
    const PRE_PLANNING_EMAIL_NOTIFY_TO_REVISION = 'PRE_PLANNING_EMAIL_NOTIFY_TO_REVISION';
    
    /**
     * Correo electronico origen por defecto
     */
    const EMAIL_FROM_DEFAULT = 'EMAIL_FROM_DEFAULT';
  
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
     * Obtiene el correo de origen por defecto
     * 
     * @param string $default
     */
    function getEmailFromDefault($default = 'seip@pequiven.com')
    {
        return $this->get(self::EMAIL_FROM_DEFAULT, $default);
    }
    
    /**
     * Obtiene el correo de origen por defecto
     * 
     * @param string $default
     */
    function getEmailNotifyToRevision($default = '[]')
    {
        $v = $this->get(self::PRE_PLANNING_EMAIL_NOTIFY_TO_REVISION, $default);
        $v = json_decode($v);
        return $v;
    }
    
    /**
     * Obtiene el limite de items establecido en el periodo
     * @param string $default
     */
    function getGeneralLimitItems($default = 40)
    {
        return $this->get(self::GENERAL_LIMIT_ITEMS, $default);
    }
    
    /**
     * Establece el limite de items establecido en el periodo
     * @param string $default
     */
    function setGeneralLimitItems($default = 40,$description = null, Group $group = null)
    {
        $this->set(self::GENERAL_LIMIT_ITEMS, $default,$description,$group);
        return $this;
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
     * Establece valor del formulario del programa de gestion "asociado a" (Por defecto)
     * 
     * @param string $default
     */
    function setArrangementProgramSendEmailNotifications($default,$description = 'Habilitar el envio de correos en notificacion de eventos del programa de gestion', Group $group = null)
    {
        $this->set(self::ARRANGEMENT_PROGRAM_SEND_EMAIL_NOTIFICATIONS, $default,$description,$group);
        return $this;
    }
    
    /**
     * Recupera valor del formulario del programa de gestion "asociado a" (Por defecto)
     * 
     * @param string $default
     */
    function isArrangementProgramSendEmailNotifications($default = false)
    {
        $this->get(self::ARRANGEMENT_PROGRAM_SEND_EMAIL_NOTIFICATIONS, $default);
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
    
    /**
     * Retorna si esta habilitada compatibilidad con el sistema integrado de gestion (SIG)
     * 
     * @param boolean $default
     * @return boolean
     */
    function isEnablePrePlanning($default = false) {
        return (boolean)$this->get(self::PRE_PLANNING_ENABLE_PRE_PLANNING, $default);
    }
    
    /**
     * Establece valor si esta habilitada compatibilidad con el sistema integrado de gestion (SIG)
     * 
     * @param string $default
     */
    function setEnablePrePlanning($default = false,$description = 'Habilita la pre planificacion del periodo siguiente', Group $group = null)
    {
        $this->set(self::PRE_PLANNING_ENABLE_PRE_PLANNING, (boolean)$default,$description,$group);
        return $this;
    }
}
