<?php

namespace Pequiven\MasterBundle\Model;

/**
 * Modelo de Tendencia
 *
 * @author matias
 */
abstract class Tendency {
    //put your code here
    const TENDENCY_MAX = 'MAX';
    const TENDENCY_MIN = 'MIN';
    const TENDENCY_EST = 'EST';
    
    public $tendencyName = array();
    
    public function __construct() {
        $this->tendencyName[self::TENDENCY_MAX] = 'Favorable';
        $this->tendencyName[self::TENDENCY_MIN] = 'Desfavorable';
        $this->tendencyName[self::TENDENCY_EST] = 'Estable';
    }
    
    /**
     * Retorna todas las Tendencias
     * @return type
     */
    public function getTendencyNameArray() {
        return $this->tendencyName;
    }    
}
