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

use Pequiven\ObjetiveBundle\Model\ObjetiveLevel;

/**
 * Modelo de pre-planificacion
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
abstract class PrePlanning extends PrePlanningTypeObject implements PrePlanningInterface
{
    /**
     * Nombre para el nodo root.
     */
    const DEFAULT_NAME = 'ROOT-NODE';
    
    /**
     * Tipo de objeto (Root) este tipo no tiene instancia
     */
    const TYPE_OBJECT_ROOT_NODE = 0;
    
    /**
     * Estatus borrador
     */
    const STATUS_DRAFT = 0;
    
    /**
     * Estatus aprobado
     */
    const STATUS_IMPORTED = 1;
    
    /**
     * No se ha seleccionado nada (Vacio)
     */
    const TO_IMPORT_DEFAULT = 0;
    
    /**
     * Si desea importar
     */
    const TO_IMPORT_YES = 1;
    
    /**
     * No desea importar
     */
    const TO_IMPORT_NO = 2;

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
