<?php

namespace Pequiven\ArrangementProgramBundle\Controller;

use Pequiven\SEIPBundle\Controller\SEIPController;

/**
 * Controlador de data generica del bundle
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
class GenericDataController extends SEIPController 
{
    
    /**
     * Obtiene los responsable de una meta
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
     */
    function getTypeGoalAction($category)
    {
        $results = $this->get('pequiven.repository.type_goal')->findByCategory($category);
        $view = $this->view();
        $view->setData($results);
        return $view;
    }
}
