<?php

namespace Pequiven\ArrangementProgramBundle\Controller;

use Pequiven\SEIPBundle\Controller\SEIPController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Controlador de data generica del bundle
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 * @Route("/data")
 */
class GenericDataController extends SEIPController 
{
    
    /**
     * Obtiene los responsable de una meta
     *
     * @Route("/responsible-goals.{_format}", name="pequiven_arrangementprogram_data_responsible_goals",requirements={"_format"="json|xml"},defaults={"_format"="json"},options={"expose"="true"})
     * @Method("GET")
     */
    function getResponsibleGoalsAction()
    {
        $user = $this->getUser();
        $results = $this->getRepositoryById('user')->findToAssingTacticArrangementProgramGoal($user);
        $view = $this->view();
        $view->setData($results);
        return $view;
    }
    
    /**
     * Obtiene los tipos de meta de acuerdo al tipo de actividad
     *
     * @Route("/{category}/type-goal.{_format}", name="pequiven_arrangementprogram_data_type_goal",requirements={"_format"="json|xml"},defaults={"_format"="json"},options={"expose"="true"})
     * @Method("GET")
     */
    function getTypeGoalAction($category)
    {
        $results = $this->get('pequiven.repository.type_goal')->findByCategory($category);
        $view = $this->view();
        $view->setData($results);
        return $view;
    }
}
