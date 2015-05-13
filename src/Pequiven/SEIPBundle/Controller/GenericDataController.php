<?php

namespace Pequiven\SEIPBundle\Controller;

use Pequiven\SEIPBundle\Controller\SEIPController;

/**
 * Controlador de data generica en el SEIP
 *
 * @author Matías Jiménez
 */
class GenericDataController extends SEIPController 
{
    
    /**
     * Retorna las localidades activas dependiendo del criterio o del usuario
     * @param type $param
     */
    function getComplejosAction(\Symfony\Component\HttpFoundation\Request $request) {
        
        $user = $this->getUser();
        $criteria = $request->get('filter',$this->config->getCriteria());
        $repository = $this->get('pequiven_seip.repository.complejo');
        $results = $repository->findComplejos();
        $view = $this->view();
        $view->setData($results);
        $view->getSerializationContext()->setGroups(array('id','api_list','gerencias'));
        return $this->handleView($view);
    }
    
    /**
     * Retorna las gerencias de primera línea dependiendo del criterio o del usuario
     * 
     * @param type $param
     */
    function getFirstLineManagementAction(\Symfony\Component\HttpFoundation\Request $request) {
        
        $user = $this->getUser();
        $criteria = $request->get('filter',$this->config->getCriteria());
        $repository = $this->get('pequiven.repository.gerenciafirst');
        $results = $repository->findGerencia($criteria);
        $view = $this->view();
        $view->setData($results);
        $view->getSerializationContext()->setGroups(array('id','api_list','complejo','gerencia_group'));
        return $this->handleView($view);
    }
    
    /**
     * Retorna las gerencias de segunda línea dependiendo del criterio o del usuario
     * @param type $param
     */
    function getSecondLineManagementAction(\Symfony\Component\HttpFoundation\Request $request) {
        $criteria = $request->get('filter',$this->config->getCriteria());
        $user = $this->getUser();
        $repository = $this->get('pequiven.repository.gerenciasecond');
        $results = $repository->findGerenciaSecond($criteria);
        $view = $this->view();
        $view->setData($results);
        $view->getSerializationContext()->setGroups(array('id','api_list','gerencia','complejo'));
        return $this->handleView($view);
    }
    
    public function getLocationByAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $company = $request->get("company");
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("Pequiven\SEIPBundle\Entity\CEI\Location");
        $results = $repository->findByCompany($company);
        
        $view = $this->view();
        $view->setData($results);
        $view->getSerializationContext()->setGroups(array('id','api_list'));
        return $this->handleView($view);
    }
    
    public function getPlantByLocationAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $location = $request->get("location");
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("Pequiven\SEIPBundle\Entity\CEI\Plant");
        $results = $repository->findByLocation($location);
        
        $view = $this->view();
        $view->setData($results);
        $view->getSerializationContext()->setGroups(array('id','api_list'));
        return $this->handleView($view);
    }
    
    public function getProductByPlantAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $plant = $request->get("plant");
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("Pequiven\SEIPBundle\Entity\CEI\Product");
        $results = $repository->findByPlant($plant);
        
        $view = $this->view();
        $view->setData($results);
        $view->getSerializationContext()->setGroups(array('id','api_list'));
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
