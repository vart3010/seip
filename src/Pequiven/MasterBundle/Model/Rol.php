<?php

namespace Pequiven\MasterBundle\Model;

use Exception;
use Sonata\UserBundle\Entity\BaseGroup as BaseGroup;

/**
 * Modelo de rol
 *
 * @author matias
 */
class Rol extends BaseGroup {

    /**
     * Propietario
     */
    const TYPE_ROL_OWNER = 0;

    /**
     * Rol Creado Especial
     */
    const TYPE_ROL_SPECIAL = 2;

    /**
     * Auxiliar
     */
    const TYPE_ROL_AUX = 1;
    const ROLE_DEFAULT = 0;
    const ROLE_WORKER_PQV = 1000;
    const ROLE_SUPERVISER = 2000;
    const ROLE_COORDINATOR = 2500;
    const ROLE_MANAGER_SECOND = 3000;

    /**
     * Gerencia de primera linea
     */
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

    public function __construct() {
        parent::__construct(null, array());
    }

    /**
     * Devuelve el nombre del rol
     * @param type $role
     * @return type
     * @throws Exception
     */
    static function getRoleName($role) {
        $rolesNames = self::getRolesNames();
        if (!isset($rolesNames[$role])) {
            throw new Exception(sprintf("Role name '%s' dont exists", $role));
        }
        return $rolesNames[$role];
    }

    /**
     * Devuelve el nivel del rol
     * @param type $role
     * @return type
     * @throws Exception
     */
    static function getRoleLevel($role) {
        $rolesLevel = self::getRolesLevel();
        if (!isset($rolesLevel[$role])) {
            throw new Exception(sprintf("Role level '%s' dont exists", $role));
        }
        return $rolesLevel[$role];
    }

    /**
     * Devuelve el nivel de los roles
     * @staticvar array $rolesLevel
     * @return array
     */
    static function getRolesLevel() {
        static $rolesLevel = array(
            self::ROLE_DEFAULT => self::ROLE_DEFAULT,
            self::ROLE_WORKER_PQV => self::ROLE_WORKER_PQV,
            self::ROLE_SUPERVISER => self::ROLE_SUPERVISER,
            self::ROLE_COORDINATOR => self::ROLE_COORDINATOR,
            self::ROLE_MANAGER_SECOND => self::ROLE_MANAGER_SECOND,
            self::ROLE_MANAGER_FIRST => self::ROLE_MANAGER_FIRST,
            self::ROLE_GENERAL_COMPLEJO => self::ROLE_GENERAL_COMPLEJO,
            self::ROLE_DIRECTIVE => self::ROLE_DIRECTIVE,
            self::ROLE_ADMIN => self::ROLE_ADMIN,
            self::ROLE_SUPER_ADMIN => self::ROLE_SUPER_ADMIN,
        );

        $rolesLevel[self::ROLE_SUPERVISER_AUX] = $rolesLevel[self::ROLE_SUPERVISER];
        $rolesLevel[self::ROLE_MANAGER_SECOND_AUX] = $rolesLevel[self::ROLE_MANAGER_SECOND];
        $rolesLevel[self::ROLE_MANAGER_FIRST_AUX] = $rolesLevel[self::ROLE_MANAGER_FIRST];
        $rolesLevel[self::ROLE_GENERAL_COMPLEJO_AUX] = $rolesLevel[self::ROLE_GENERAL_COMPLEJO];
        $rolesLevel[self::ROLE_DIRECTIVE_AUX] = $rolesLevel[self::ROLE_DIRECTIVE];

        return $rolesLevel;
    }

    /**
     * Devuelve el nombre de los roles
     * @staticvar array $rolesNames
     * @return string
     */
    static function getRolesNames() {
        static $rolesNames = array(
            self::ROLE_DEFAULT => 'ROLE_WORKER_PQV',
            self::ROLE_WORKER_PQV => 'ROLE_WORKER_PQV',
            self::ROLE_SUPERVISER => 'ROLE_SUPERVISER',
            self::ROLE_COORDINATOR => 'ROLE_COORDINATOR',
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

    static function getTypeOfRol() {
        static $typesOfRol = array(
            self::TYPE_ROL_AUX => "roles.rol_aux",
            self::TYPE_ROL_OWNER => "roles.rol_owner",
            self::TYPE_ROL_SPECIAL => "roles.rol_special"
        );

        return $typesOfRol;
    }

}
