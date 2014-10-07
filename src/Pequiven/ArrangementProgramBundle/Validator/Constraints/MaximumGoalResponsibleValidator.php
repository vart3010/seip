<?php

namespace Pequiven\ArrangementProgramBundle\Validator\Constraints;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Valida que una persona no pueda tener mas de "n" metas activas asignadas en un periodo
 *
 * @author Carlos Mendoza <inhak20@tecnocreaciones.com>
 */
class MaximumGoalResponsibleValidator extends ConstraintValidator implements ContainerAwareInterface
{
    /**
     * Contenedor de dependencias
     * @var ContainerInterface
     */
    private $container;
    
    public function validate($object, Constraint $constraint)
    {
        $timelines = $object->getTimelines();
        
        $limitGoals = 1;
        $period = $this->container->get('pequiven.repository.period')->findOneActive();
        
        $goalRepository = $this->container->get('pequiven_seip.repository.arrangementprogram_goal');
        
        $errors = array();
        $criteria = array();
        if($object->getId() > 0){
            $criteria['notArrangementProgram'] = $object;
        }
        foreach ($timelines[0]->getGoals() as $currentGoal) {
            $reposible = $currentGoal->getResponsible();
            $goals = $goalRepository->findGoalsByUserAndPeriod($reposible,$period,$criteria);
            $countGoals = count($goals);
            $countGoals++;//Mas 1 de la meta actual
            foreach ($timelines[0]->getGoals() as $subGoal) {
                if($currentGoal !== $subGoal){
                    $countGoals++;//Mas 1 de otras metas del mismo programa de gestion
                }
            }
            if($countGoals > $limitGoals){
                $errors[$reposible->getId()] = array('%1' => $reposible,'%2' => $countGoals,'%3'=> $limitGoals,'%period%' => $period);
            }
        }
        
        foreach ($errors as $error) {
            $this->context->addViolation($constraint->message,$error);
        }
    }
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
    
    /**
     * 
     * @return Request
     */
    public function getRequest()
    {
        return $this->container->get('request');
    }

}
