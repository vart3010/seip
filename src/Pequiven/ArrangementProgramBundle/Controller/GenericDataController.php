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
        return $this->handleView($view);
    }
    
    /**
     * Obtiene los tipos de meta de acuerdo al tipo de actividad
     */
    function getTypeGoalAction($category)
    {
        $results = $this->get('pequiven.repository.type_goal')->findByCategory($category);
        $view = $this->view();
        $view->setData($results);
        return $this->handleView($view);
    }
    
    /**
     * Busca los objetivos operativos de un objetivo tactico y del usuario logueado
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return type
     * @throws type
     */
    function getOperationalObjectivesAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $objetiveTactic = $em->find('Pequiven\ObjetiveBundle\Entity\Objetive', $request->get('idObjetiveTactical'));
        if(!$objetiveTactic){
            throw $this->createNotFoundException('objetive tactic not found!');
        }
        
        $repository = $this->get('pequiven.repository.objetiveoperative');
        $results = $repository->findObjetivesOperationalByObjetiveTactic($objetiveTactic);
        $view = $this->view();
        $view->setData($results);
        $view->getSerializationContext()->setGroups(array('id','api_list','lineStrategics'));
        return $this->handleView($view);
    }
}
