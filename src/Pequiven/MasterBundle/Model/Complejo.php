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
    //put your code here
    //put your code here
    //put your code here
    const COMPLEJO_DEFAULT = 0;
    const COMPLEJO_CPMORON = 1;
    const COMPLEJO_CPAMC = 2;
    const COMPLEJO_CPJAA = 3;
    const COMPLEJO_PRONAVAY = 4;
    const COMPLEJO_PROPARAGUANA = 5;
    const COMPLEJO_ZIV = 6;    
    
    public $complejo_name = array();
    
    public function __construct() {
        $this->complejo_name[self::COMPLEJO_DEFAULT] = 'ZIV';
        $this->complejo_name[self::COMPLEJO_CPMORON] = 'CPMORON';
        $this->complejo_name[self::COMPLEJO_CPAMC] = 'CPAMC';
        $this->complejo_name[self::COMPLEJO_CPJAA] = 'CPJAA';
        $this->complejo_name[self::COMPLEJO_PRONAVAY] = 'NAVAY';
        $this->complejo_name[self::COMPLEJO_PROPARAGUANA] = 'PARAGUANA';
        $this->complejo_name[self::COMPLEJO_ZIV] = 'ZIV';
    }
    
    /**
     * Retorna todos los complejos
     * @return type
     */
    public function getComplejoNameArray() {
        return $this->complejo_name ;
    }
}
