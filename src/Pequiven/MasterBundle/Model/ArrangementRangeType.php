<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\MasterBundle\Model;

/**
 * Description of Arrangement_Range_Type
 *
 * @author matias
 */
class ArrangementRangeType {
    //put your code here
    const RANGE_TYPE_TOP_BASIC = 'TYPE_TOP_BASIC';
    const RANGE_TYPE_MIDDLE_BASIC = 'TYPE_MIDDLE_BASIC';
    const RANGE_TYPE_BOTTOM_BASIC = 'TYPE_BOTTOM_BASIC';
    const RANGE_TYPE_TOP_COMPOUND = 'TYPE_TOP_COMPOUND';
    const RANGE_TYPE_MIDDLE_COMPOUND = 'TYPE_MIDDLE_COMPOUND';
    const RANGE_TYPE_BOTTOM_COMPOUND = 'TYPE_BOTTOM_COMPOUND';
    
    public $rangeTypeName = array();
    
    public function __construct() {
        $this->rangeTypeName[self::RANGE_TYPE_TOP_BASIC] = 'Rango Alto Básico';
        $this->rangeTypeName[self::RANGE_TYPE_MIDDLE_BASIC] = 'Rango Medio Básico';
        $this->rangeTypeName[self::RANGE_TYPE_BOTTOM_BASIC] = 'Rango Bajo Básico';
        $this->rangeTypeName[self::RANGE_TYPE_TOP_COMPOUND] = 'Rango Alto Compuesto';
        $this->rangeTypeName[self::RANGE_TYPE_MIDDLE_COMPOUND] = 'Rango Medio Compuesto';
        $this->rangeTypeName[self::RANGE_TYPE_BOTTOM_COMPOUND] = 'Rango Bajo Compuesto';
    }
    
    /**
     * Retorna todos los tipos de rango de gestión
     * @return type
     */
    public function getRangeTypeNameArray() {
        return $this->rangeTypeName;
    }
}
