<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\MasterBundle\Model;

/**
 * Description of Complejo
 *
 * @author matias
 */
class Complejo {
    
    const COMPLEJO_DEFAULT = 0;
    const COMPLEJO_CPMORON = 1;
    const COMPLEJO_CPAMC = 2;
    const COMPLEJO_CPJAA = 3;
    const COMPLEJO_PRONAVAY = 4;
    const COMPLEJO_PROPARAGUANA = 5;
    const COMPLEJO_ZIV = 6;
    
    public $refName = array();
    
    public function __construct() {
        $this->refName[self::COMPLEJO_DEFAULT] = 'ZIV';
        $this->refName[self::COMPLEJO_CPMORON] = 'CPMORON';
        $this->refName[self::COMPLEJO_CPAMC] = 'CPAMC';
        $this->refName[self::COMPLEJO_CPJAA] = 'CPJAA';
        $this->refName[self::COMPLEJO_PRONAVAY] = 'NAVAY';
        $this->refName[self::COMPLEJO_PROPARAGUANA] = 'PARAGUANA';
        $this->refName[self::COMPLEJO_ZIV] = 'CORP.';
    }
    
    /**
     * Retorna las referencias de los complejos
     * @return type
     */
    public function getRefNameArray() {
        return $this->refName ;
    }
}
