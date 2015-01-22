<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Model\PrePlanning;

/**
 * Modelo de pre-planificacion
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
abstract class PrePlanning  implements PrePlanningInterface
{
    /**
     * Nombre para el nodo root.
     */
    const DEFAULT_NAME = 'ROOT-NODE';
    
    /**
     * Tipo objetivo
     */
    const TYPE_OBJECT_ROOT_NODE = 0;
    
    /**
     * Estatus borrador
     */
    const STATUS_DRAFT = 0;
    
    /**
     * Estatus aprobado
     */
    const STATUS_APPROVED = 1;
    
    /**
     * Parametros de la pre planificacion
     * @var type 
     */
    protected $parameters;
    
    function getParameter($name,$default = null)
    {
        $parameters = $this->getParameters();
        if(isset($parameters[$name])){
            return $parameters[$name];
        }
        return $default;
    }
    
    function setParameter($key,$value) {
        $this->parameters[$key] = $value;
    }
}
