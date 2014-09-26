<?php

namespace Pequiven\MasterBundle\Model;

use FOS\UserBundle\Entity\Group as BaseGroup;

/**
 * Description of Rol
 *
 * @author matias
 */
class Rol extends BaseGroup
{
    const ROLE_DEFAULT = 0;
    const ROLE_WORKER_PQV = 1000;
    const ROLE_SUPERVISER = 2000;
    const ROLE_MANAGER_SECOND = 3000;
    const ROLE_MANAGER_FIRST = 4000;
    const ROLE_GENERAL_COMPLEJO = 5000;
    const ROLE_DIRECTIVE = 6000;
    const ROLE_ADMIN = 7000;
    const ROLE_SUPER_ADMIN = 8000;
    const ROLE_SUPERVISER_AUX = 9000;
    const ROLE_MANAGER_SECOND_AUX = 10000;
    const ROLE_MANAGER_FIRST_AUX = 11000;
    const ROLE_GENERAL_COMPLEJO_AUX = 12000;
    const ROLE_DIRECTIVE_AUX = 13000;
    
    public $rol_name = array();
    
    public function __construct() {
        $this->rol_name = self::getRolesNames();
        parent::__construct(null,array());
    }
    
    
    static function getRoleName($role) {
        $rolesNames = self::getRolesNames();
        if(isset($rolesNames[$role])){
            return $rolesNames[$role];
        }
        return null;
    }
    static function getRolesNames() {
        static $rolesNames = array(
            self::ROLE_DEFAULT => 'ROLE_WORKER_PQV',
            self::ROLE_WORKER_PQV => 'ROLE_WORKER_PQV',
            self::ROLE_SUPERVISER => 'ROLE_SUPERVISER',
            self::ROLE_MANAGER_SECOND => 'ROLE_MANAGER_SECOND',
            self::ROLE_MANAGER_FIRST => 'ROLE_MANAGER_FIRST',
            self::ROLE_GENERAL_COMPLEJO => 'ROLE_GENERAL_COMPLEJO',
            self::ROLE_DIRECTIVE => 'ROLE_DIRECTIVE',
            self::ROLE_ADMIN => 'ROLE_ADMIN',
            self::ROLE_SUPER_ADMIN => 'ROLE_SUPER_ADMIN',
            self::ROLE_SUPERVISER_AUX => 'ROLE_SUPERVISER_AUX',
            self::ROLE_MANAGER_SECOND_AUX => 'ROLE_MANAGER_SECOND_AUX',
            self::ROLE_MANAGER_FIRST_AUX => 'ROLE_MANAGER_FIRST_AUX',
            self::ROLE_GENERAL_COMPLEJO_AUX => 'ROLE_GENERAL_COMPLEJO_AUX',
            self::ROLE_DIRECTIVE_AUX => 'ROLE_DIRECTIVE_AUX',
        );
        return $rolesNames;
    }
}
