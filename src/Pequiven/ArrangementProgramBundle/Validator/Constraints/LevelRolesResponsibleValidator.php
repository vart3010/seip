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
        $responsibles = $object->getResponsibles();
        $topLevel = 0;
        $userTopLevel = null;
        foreach ($responsibles as $r) {
            foreach ($r->getGroups() as $group) {
                if($group->getLevel() > $topLevel){
                    $topLevel = $group->getLevel();
                    $userTopLevel = $r;
                }
            }
        }
        
        $responsible = $userTopLevel;
        $timeline = $object->getTimeline();
        //Sino se asigno ninguna meta al crear el programa de gestion
        if(!$timeline){
            return;
        }
        $goals = $timeline->getGoals();
        $errors = array();
        if($responsible){
            foreach ($responsible->getGroups() as $group) {
                foreach ($goals as $goal) {
                    foreach ($goal->getResponsibles() as $goalResponsible) {
                        foreach ($goalResponsible->getGroups() as $groupResponsibleGoal) {
                            if($groupResponsibleGoal->getLevel() > $group->getLevel()){
                                $errors[$goalResponsible->getId()] = array('%responsibleProgram%' => $responsible,'%responsibleGoals%' => $goalResponsible, '%goal%' => $goal);
                            }
                        }
                    }
                }
            }

            foreach ($errors as $error) {
                $this->context->addViolation($constraint->message,$error);
            }
        }
    }
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}
