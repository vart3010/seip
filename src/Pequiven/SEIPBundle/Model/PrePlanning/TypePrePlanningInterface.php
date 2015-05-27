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
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
interface TypePrePlanningInterface 
{
    const LEVEL_DEFAULT = ObjetiveLevel::LEVEL_DEFAULT;
    const LEVEL_ESTRATEGICO = ObjetiveLevel::LEVEL_ESTRATEGICO;
    const LEVEL_TACTICO = ObjetiveLevel::LEVEL_TACTICO;
    const LEVEL_OPERATIVO = ObjetiveLevel::LEVEL_OPERATIVO;
    /**
     * Tipo objetivo
     */
    const TYPE_OBJECT_OBJETIVE = 1;
    /**
     * Tipo programa de gestion
     */
    const TYPE_OBJECT_ARRANGEMENT_PROGRAM = 2;
    /**
     * Tipo indicador
     */
    const TYPE_OBJECT_INDICATOR = 3;
    /**
     * Tipo meta de programa de gestion
     */
    const TYPE_OBJECT_ARRANGEMENT_PROGRAM_GOAL = 4;
    
    /**
     * Tipo de objeto resultado
     */
    const TYPE_OBJECT_RESULT = 5;
    
    /**
     * Tipo de objeto de tendencia
     */
    const TYPE_OBJECT_TENDENCY = 6;
    
    /**
     * Tipo de objeto de formula
     */
    const TYPE_OBJECT_FORMULA = 7;
    
    /**
     * Tipo de objeto de nivel de formula
     */
    const TYPE_OBJECT_FORMULA_LEVEL = 8;
    
    /**
     * Tipo de objeto de rango
     */
    const TYPE_OBJECT_ARRANGEMENT_RANGE = 9;
    
    /**
     * Tipo de objeto de nivel de objetivo
     */
    const TYPE_OBJECT_OBJETIVE_LEVEL = 10;
    
    /**
     * Tipo de objeto de frecuencia de notificacion
     */
    const TYPE_OBJECT_FREQUENCY_NOTIFICATION_INDICATOR = 11;
    
    /**
     * Tipo de objeto de variable
     */
    const TYPE_OBJECT_VARIABLE = 12;
    
    /**
     * Tipo de objeto de variable
     */
    const TYPE_OBJECT_INDICATOR_LEVEL = 13;
    
    /**
     * Tipo de objeto de tag de indicador
     */
    const TYPE_OBJECT_TAG_INDICATOR = 14;
    
    public function setIdSourceObject($idSourceObject);
    
    public function setTypeObject($typeObject);
}
