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
 * Modelo de Pre-Planificacion del usuario
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
abstract class PrePlanningUser 
{
    const FORM_PLANNING = 'planning';
    const FORM_STATISTICS = 'statistics';
    
    /**
     * Estatus borrador
     */
    const STATUS_DRAFT = 0;
     /**
     * Estatus aprobado
     */
    const STATUS_IMPORTED = 1;
    
    /**
     * Estatus en revision
     */
    const STATUS_IN_REVIEW = 2;
    
    /**
     * Estatus aprobado
     */
    const STATUS_APPROVED = 3;
    
    /**
     * Retorna las etiquetas de los estatus
     * @return array
     */
    public static function getLabelsStatus()
    {
        return array(
            self::STATUS_DRAFT => 'pequiven_seip.pre_planning_user.status.draft',
            self::STATUS_IMPORTED => 'pequiven_seip.pre_planning_user.status.imported',
            self::STATUS_IN_REVIEW => 'pequiven_seip.pre_planning_user.status.in_review',
            self::STATUS_APPROVED => 'pequiven_seip.pre_planning_user.status.approved',
        );
    }
}
