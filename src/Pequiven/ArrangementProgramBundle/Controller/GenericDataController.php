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
     * Obtiene los responsable que se pueden asignar a una meta
     */
    function getResponsibleGoalsAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $responsiblesId = $request->get('responsibles',array());
        $results = array();
        if(count($responsiblesId) > 0){
            $repository = $this->getRepositoryById('user');
            $users = $repository->findUsers($responsiblesId);
            if(!$users){
                throw $this->createNotFoundException();
            }
            $results = $this->getRepositoryById('user')->findToAssingTacticArrangementProgramGoal($users);
        }
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
     * 
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
        $view->getSerializationContext()->setGroups(array('id','api_list'));
        return $this->handleView($view);
    }
    
    /**
     * Busca los objetivos operativos tacticos del usuario logueado
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return type
     * @throws type
     */
    function getTacticalObjectivesAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $user = $this->getUser();
        $repository = $this->get('pequiven.repository.objetiveoperative');
        $results = $repository->findTacticalObjetives($user);
        $view = $this->view();
        $view->setData($results);
        $view->getSerializationContext()->setGroups(array('id','api_list'));
        return $this->handleView($view);
    }
    
    /**
     * Busca los objetivos operativos tacticos del usuario logueado
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return type
     * @throws type
     */
    function getOperativesObjectivesAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $user = $this->getUser();
        $repository = $this->get('pequiven.repository.objetiveoperative');
        $results = $repository->findOperativeObjetives($user);
        $view = $this->view();
        $view->setData($results);
        $view->getSerializationContext()->setGroups(array('id','api_list'));
        return $this->handleView($view);
    }
    
    /**
     * Busca las gerencias de primera linea del usuario
     * 
     * @param type $param
     */
    function getFirstLineManagementAction(\Symfony\Component\HttpFoundation\Request $request) {
        
        $user = $this->getUser();
        $criteria = array();
        if($this->getUserManager()->isAllowFilterComplejo($user) === false){
            $criteria['complejo'] =  $user->getComplejo();
        }
        $repository = $this->get('pequiven.repository.gerenciafirst');
        $results = $repository->findGerencia($criteria);
        $view = $this->view();
        $view->setData($results);
        $view->getSerializationContext()->setGroups(array('id','api_list','complejo'));
        return $this->handleView($view);
    }
    
    /**
     * Busca las gerencias de segunda linea
     * @param type $param
     */
    function getSecondLineManagementAction(\Symfony\Component\HttpFoundation\Request $request) {
        
        $user = $this->getUser();
        $criteria = array();
        if($this->getUserManager()->isAllowFilterFirstLineManagement($user) === false){
            $criteria['gerencia'] =  $user->getGerencia();
        }
        $repository = $this->get('pequiven.repository.gerenciasecond');
        $results = $repository->findGerenciaSecond($criteria);
        $view = $this->view();
        $view->setData($results);
        $view->getSerializationContext()->setGroups(array('id','api_list','gerencia','complejo'));
        return $this->handleView($view);
    }
    
    /**
     * Busca los complejos
     * @param type $param
     */
    function getComplejosAction(\Symfony\Component\HttpFoundation\Request $request) {
        
        $user = $this->getUser();
        $repository = $this->get('pequiven_seip.repository.complejo');
        $results = $repository->findComplejos();
        $view = $this->view();
        $view->setData($results);
        $view->getSerializationContext()->setGroups(array('id','api_list'));
        return $this->handleView($view);
    }
    
    /**
     * Busca los responsables
     * @param type $param
     */
    function getResponsiblesAction(\Symfony\Component\HttpFoundation\Request $request) {
        
        $user = $this->getUser();
        $repository = $this->get('pequiven_seip.repository.user');
        $results = $repository->findUsersByCriteria();
        $view = $this->view();
        $view->setData($results);
        $view->getSerializationContext()->setGroups(array('id','api_list','gerencia'));
        return $this->handleView($view);
    }
    
    /**
     * Manejador de usuario o administrador
     * @return \Pequiven\SEIPBundle\Model\UserManager
     */
    private function getUserManager() 
    {
        return $this->get('seip.user_manager');
    }
}
