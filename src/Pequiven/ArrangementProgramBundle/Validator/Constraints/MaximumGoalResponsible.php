<?php

namespace Pequiven\ArrangementProgramBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Valida que una persona no pueda tener mas de "n" metas activas asignadas en un periodo
 *
 * @author Carlos Mendoza <inhak20@tecnocreaciones.com>
 */
class MaximumGoalResponsible extends Constraint
{
    public $service = 'pequiven.orm.validator.maximum_goal_responsible';
    
    public $message = 'pequiven.validators.arrangement_program.goal.maximum_responsible';
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
