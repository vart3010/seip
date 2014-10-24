<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\MasterBundle\Model;

/**
 * Description of Direction
 *
 * @author matias
 */
class Direction {
     
    const DIRECTION_RRHH = 1;
    const DIRECTION_PROYECTOS = 2;
    
    public $refName = array();
    
    public function __construct() {
        $this->refName[self::DIRECTION_RRHH] = 'DIRECTION_RRHH';
        $this->refName[self::DIRECTION_PROYECTOS] = 'DIRECTION_PROYECTOS';
    }
    
    /**
     * Retorna las referencias de las direcciones ejecutivas
     * @return type
     */
    public function getRefNameArray() {
        return $this->refName ;
    }
}
