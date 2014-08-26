<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\MasterBundle\Model;

/**
 * Description of Rol
 *
 * @author matias
 */
class Rol {
    //put your code here
    //put your code here
    const ROLE_DEFAULT = 0;
    const ROLE_WORKER_PQV = 1;
    const ROLE_SUPERVISER = 2;
    const ROLE_MANAGER_SECOND = 3;
    const ROLE_MANAGER_FIRST = 4;
    const ROLE_GENERAL_COMPLEJO = 5;
    const ROLE_DIRECTIVE = 6;
    const ROLE_ADMIN = 7;
    const ROLE_SUPER_ADMIN = 8;
    const ROLE_SUPERVISER_AUX = 9;
    const ROLE_MANAGER_SECOND_AUX = 10;
    const ROLE_MANAGER_FIRST_AUX = 11;
    const ROLE_GENERAL_COMPLEJO_AUX = 12;
    const ROLE_DIRECTIVE_AUX = 13;
    
    public $rol_name = array();
    
    public function __construct() {
        $this->rol_name[self::ROLE_DEFAULT] = 'ROLE_WORKER_PQV';
        $this->rol_name[self::ROLE_WORKER_PQV] = 'ROLE_WORKER_PQV';
        $this->rol_name[self::ROLE_SUPERVISER] = 'ROLE_SUPERVISER';
        $this->rol_name[self::ROLE_MANAGER_SECOND] = 'ROLE_MANAGER_SECOND';
        $this->rol_name[self::ROLE_MANAGER_FIRST] = 'ROLE_MANAGER_FIRST';
        $this->rol_name[self::ROLE_GENERAL_COMPLEJO] = 'ROLE_GENERAL_COMPLEJO';
        $this->rol_name[self::ROLE_DIRECTIVE] = 'ROLE_DIRECTIVE';
        $this->rol_name[self::ROLE_ADMIN] = 'ROLE_ADMIN';
        $this->rol_name[self::ROLE_SUPER_ADMIN] = 'ROLE_SUPER_ADMIN';
        $this->rol_name[self::ROLE_SUPERVISER_AUX] = 'ROLE_SUPERVISER_AUX';
        $this->rol_name[self::ROLE_MANAGER_SECOND_AUX] = 'ROLE_MANAGER_SECOND_AUXS';
        $this->rol_name[self::ROLE_MANAGER_FIRST_AUX] = 'ROLE_MANAGER_FIRST_AUX';
        $this->rol_name[self::ROLE_GENERAL_COMPLEJO_AUX] = 'ROLE_GENERAL_COMPLEJO_AUX';
        $this->rol_name[self::ROLE_DIRECTIVE_AUX] = 'ROLE_DIRECTIVE_AUX';
    }
    
}
