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
    
    public function setIdObject($idObject);
    
    public function setTypeObject($typeObject);
}
