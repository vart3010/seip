<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\MasterBundle\Model;

/**
 * Description of FormulaLevel
 *
 * @author matias
 */
class FormulaLevel extends \Pequiven\SEIPBundle\Model\Common\CommonObject {
    
    const LEVEL_DEFAULT = 0;
    const LEVEL_ESTRATEGICO = 1;
    const LEVEL_TACTICO = 2;
    const LEVEL_OPERATIVO = 3;
    
    public $level_name = array();
    
    public function __construct() {
        $this->level_name[self::LEVEL_DEFAULT] = 'FORMULA_ESTRATEGICO';
        $this->level_name[self::LEVEL_ESTRATEGICO] = 'FORMULA_ESTRATEGICO';
        $this->level_name[self::LEVEL_TACTICO] = 'FORMULA_TACTICO';
        $this->level_name[self::LEVEL_OPERATIVO] = 'FORMULA_OPERATIVO';
    }
    
    /**
     * Retorna todos los niveles
     * @return type
     */
    public function getLevelNameArray() {
        return $this->level_name;
    }
}
