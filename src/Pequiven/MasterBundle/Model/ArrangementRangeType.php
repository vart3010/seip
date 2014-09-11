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
    const RANGE_TYPE_MIDDLE_TOP_BASIC = 'TYPE_MIDDLE_TOP_BASIC';
    const RANGE_TYPE_MIDDLE_BOTTOM_BASIC = 'TYPE_MIDDLE_BOTTOM_BASIC';
    const RANGE_TYPE_BOTTOM_BASIC = 'TYPE_BOTTOM_BASIC';
    const RANGE_TYPE_TOP_MIXED = 'TYPE_TOP_MIXED';
    const RANGE_TYPE_MIDDLE_TOP_MIXED = 'TYPE_MIDDLE_TOP_MIXED';
    const RANGE_TYPE_MIDDLE_BOTTOM_MIXED = 'TYPE_MIDDLE_BOTTOM_MIXED';
    const RANGE_TYPE_BOTTOM_MIXED = 'TYPE_BOTTOM_MIXED';
    
    public $rangeTypeName = array();
    
    public function __construct() {
        $this->rangeTypeName[self::RANGE_TYPE_TOP_BASIC] = 'Rango Alto Básico';
        $this->rangeTypeName[self::RANGE_TYPE_MIDDLE_TOP_BASIC] = 'Rango Medio Alto Básico';
        $this->rangeTypeName[self::RANGE_TYPE_MIDDLE_BOTTOM_BASIC] = 'Rango Medio Bajo Básico';
        $this->rangeTypeName[self::RANGE_TYPE_BOTTOM_BASIC] = 'Rango Bajo Básico';
        $this->rangeTypeName[self::RANGE_TYPE_TOP_MIXED] = 'Rango Alto Mixto';
        $this->rangeTypeName[self::RANGE_TYPE_MIDDLE_TOP_MIXED] = 'Rango Medio Alto Mixto';
        $this->rangeTypeName[self::RANGE_TYPE_MIDDLE_BOTTOM_MIXED] = 'Rango Medio Bajo Mixto';
        $this->rangeTypeName[self::RANGE_TYPE_BOTTOM_MIXED] = 'Rango Bajo Mixto';
    }
    
    /**
     * Retorna todos los tipos de rango de gestión
     * @return type
     */
    public function getRangeTypeNameArray() {
        return $this->rangeTypeName;
    }
}
