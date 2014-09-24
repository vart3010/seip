<?php

namespace Pequiven\ArrangementProgramBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Controlador de data generica del bundle
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 * @Route("/data")
 */
class GenericDataController extends FOSRestController {
    
    /**
     * Obtiene los responsable de una meta
     *
     * @Route("/responsible-goals.{_format}", name="pequiven_arrangementprogram_data_responsible_goals",requirements={"_format"="json|xml"},defaults={"_format"="json"},options={"expose"="true"})
     * @Method("GET")
     */
    function getResponsibleGoalsAction()
    {
        $repository = $this->get('pequiven.repository.user');
        $view = $this->view();
        $view->setData($repository->findAll());
        return $view;
    }
    
    /**
     * Obtiene los tipos de meta de acuerdo al tipo de actividad
     *
     * @Route("/type-goal.{_format}", name="pequiven_arrangementprogram_data_type_goal",requirements={"_format"="json|xml"},defaults={"_format"="json"},options={"expose"="true"})
     * @Method("GET")
     */
    function getTypeGoalAction()
    {
        $repository = $this->get('pequiven.repository.type_goal');
        $view = $this->view();
        $view->setData($repository->findAll());
        return $view;
    }
}
