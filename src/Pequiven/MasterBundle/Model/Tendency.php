<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\MasterBundle\Model;

/**
 * Description of Tendency
 *
 * @author matias
 */
class Tendency {
    //put your code here
    const TENDENCY_MAX = 'MAX';
    const TENDENCY_MIN = 'MIN';
    
    public $tendencyName = array();
    
    public function __construct() {
        $this->tendencyName[self::TENDENCY_MAX] = 'Favorable';
        $this->tendencyName[self::TENDENCY_MIN] = 'Desfavorable';
    }
    
    /**
     * Retorna todas las Tendencias
     * @return type
     */
    public function getTendencyNameArray() {
        return $this->tendencyName;
    }    
}
