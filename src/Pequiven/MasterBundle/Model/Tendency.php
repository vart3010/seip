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
        $this->tendencyName[self::TENDENCY_MAX] = 'Creciente';
        $this->tendencyName[self::TENDENCY_MIN] = 'Decreciente';
        $this->tendencyName[self::TENDENCY_EST] = 'Estable';
    }
    
    /**
     * Retorna todas las Tendencias
     * @return type
     */
    public function getTendencyNameArray() {
        return $this->tendencyName;
    }
    
    /**
     * Retorna las etiquetas definidas para los tipos de resumen
     * 
     * @staticvar array $labelsStatus
     * @return string
     */
    static function getLabelsSummary()
    {
        static $labelsStatus = array(
            self::TENDENCY_EST => 'pequiven_arrangementRange.tendency.stable',
            self::TENDENCY_MAX => 'pequiven_arrangementRange.tendency.increasing',
            self::TENDENCY_MIN => 'pequiven_arrangementRange.tendency.decreasing',
        );
        return $labelsStatus;
    }
}
