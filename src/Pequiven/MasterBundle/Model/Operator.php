<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\MasterBundle\Model;

/**
 * Description of Operator
 *
 * @author matias
 */
class Operator 
{
    const OPERATOR_HIGHER_THAN = 1;
    const OPERATOR_SMALLER_THAN = 2;
    const OPERATOR_HIGHER_EQUAL_THAN = 3;
    const OPERATOR_SMALLER_EQUAL_THAN = 4;
    const OPERATOR_EQUAL = 5;
    
    const REF_OPERATOR_HIGHER_THAN = ">";
    const REF_OPERATOR_SMALLER_THAN = "<";
    const REF_OPERATOR_HIGHER_EQUAL_THAN = ">=";
    const REF_OPERATOR_SMALLER_EQUAL_THAN = "<=";
    const REF_OPERATOR_EQUAL = "=";
    
    public $operatorName = array();
    
    public function __construct() {
        $this->operatorName[self::OPERATOR_HIGHER_THAN] = 'Mayor que';
        $this->operatorName[self::OPERATOR_SMALLER_THAN] = 'Menor que';
        $this->operatorName[self::OPERATOR_HIGHER_EQUAL_THAN] = 'Mayor o igual que';
        $this->operatorName[self::OPERATOR_SMALLER_EQUAL_THAN] = 'Menor o igual que';
        $this->operatorName[self::OPERATOR_EQUAL] = 'Igual';
    }
    
    /**
     * Retorna todos los operadores
     * @return type
     */
    public function getOperatorNameArray() {
        return $this->operatorName;
    }
}
