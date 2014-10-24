<?php

namespace Pequiven\ArrangementProgramBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Valida que los responsables de las metas sean de un nivel menor que el mio en el rol
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
class LevelRolesResponsible extends Constraint 
{
    public $service = 'pequiven.orm.validator.arrangement_program.level_roles_responsible';
    
    public $message = 'pequiven.validators.arrangement_program.goal.level_roles_responsible';
    /**
     * The validator must be defined as a service with this name.
     *
     * @return string
     */
    public function validatedBy()
    {
        return $this->service;
    }
    
    public function getTargets() {
        return self::CLASS_CONSTRAINT;
    }
}
