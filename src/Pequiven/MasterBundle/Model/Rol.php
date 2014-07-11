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
    const ROLE_MANAGER_FIRST = 3;
    const ROLE_MANAGER_SECOND = 4;
    const ROLE_DIRECTIVE = 5;
    const ROLE_ADMIN = 6;
    const ROLE_SUPER_ADMIN = 7;
    
    public $rol_name = array();
    
    public function __construct() {
        $this->rol_name[self::ROLE_DEFAULT] = 'ROLE_WORKER_PQV';
        $this->rol_name[self::ROLE_WORKER_PQV] = 'ROLE_WORKER_PQV';
        $this->rol_name[self::ROLE_SUPERVISER] = 'ROLE_SUPERVISER';
        $this->rol_name[self::ROLE_MANAGER_FIRST] = 'ROLE_MANAGER_FIRST';
        $this->rol_name[self::ROLE_MANAGER_SECOND] = 'ROLE_MANAGER_SECOND';
        $this->rol_name[self::ROLE_DIRECTIVE] = 'ROLE_DIRECTIVE';
        $this->rol_name[self::ROLE_ADMIN] = 'ROLE_ADMIN';
        $this->rol_name[self::ROLE_SUPER_ADMIN] = 'ROLE_SUPER_ADMIN';
    }
    
}
