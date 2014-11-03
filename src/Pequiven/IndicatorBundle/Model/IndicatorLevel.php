<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\IndicatorBundle\Model;

/**
 * Description of IndicatorLevel
 *
 * @author matias
 */
class IndicatorLevel extends \Pequiven\SEIPBundle\Model\Common\CommonObject {
    //put your code here
    const LEVEL_DEFAULT = 0;
    const LEVEL_ESTRATEGICO = 1;
    const LEVEL_TACTICO = 2;
    const LEVEL_OPERATIVO = 3;
    
    public $level_name = array();
    
    public function __construct() {
        $this->level_name[self::LEVEL_DEFAULT] = 'INDICADOR_ESTRATEGICO';
        $this->level_name[self::LEVEL_ESTRATEGICO] = 'INDICADOR_ESTRATEGICO';
        $this->level_name[self::LEVEL_TACTICO] = 'INDICADOR_TACTICO';
        $this->level_name[self::LEVEL_OPERATIVO] = 'INDICADOR_OPERATIVO';
    }
    
    /**
     * Retorna todos los niveles
     * @return type
     */
    public function getLevelNameArray() {
        return $this->level_name;
    }
}
