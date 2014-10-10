<?php

namespace Pequiven\ArrangementProgramBundle\Validator\Constraints;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validador que los responsables de las metas sean de un nivel menor que el mio en el rol
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
class LevelRolesResponsibleValidator extends ConstraintValidator implements ContainerAwareInterface
{
    /**
     * Contenedor de dependencias
     * @var ContainerInterface
     */
    private $container;
    
    public function validate($object, Constraint $constraint){
        $responsible = $object->getResponsible();
        $timeline = $object->getTimeline();
        $goals = $timeline->getGoals();
        $errors = array();
        foreach ($responsible->getGroups() as $group) {
            foreach ($goals as $goal) {
                foreach ($goal->getResponsibles() as $goalResponsible) {
                    foreach ($goalResponsible->getGroups() as $groupResponsibleGoal) {
                        if($groupResponsibleGoal->getLevel() > $group->getLevel()){
                            $errors[] = array('%responsibleProgram%' => $responsible,'%responsibleGoals%' => $goalResponsible, '%goal%' => $goal);
                        }
                    }
                }
            }
        }
        
        foreach ($errors as $error) {
            $this->context->addViolation($constraint->message,$error);
        }
    }
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}
