<?php

namespace Pequiven\SIGBundle\Controller;

use Pequiven\SEIPBundle\Controller\SEIPController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController as baseController;


/**
 * Controlador de Sistemas de Gestión del SIG
 *
 */
 
class ManagementSystemController extends baseController 
{
    
    /**
     * Servicio de los Indicadores
     * @return \Pequiven\IndicatorBundle\Service\IndicatorService
     */
    public function getIndicatorService()
    {
        return $this->container->get('pequiven_indicator.service.inidicator');
    }
    
    /**
     * Servicio que calcula los resultados
     * @return \Pequiven\SEIPBundle\Service\ResultService
     */
    public function getResultService()
    {
        return $this->container->get('seip.service.result');
    }

    /**
     * Busca los Tipos de Acción para el Plan
     * @param type $param
     */
    function gettypeAction(\Symfony\Component\HttpFoundation\Request $request) {
        
        //$user = $this->getUser();
        //$criteria = $request->get('filter',$this->config->getCriteria());
        $repository = $this->get('pequiven.repository.managementsystem_sig');
        $results = $repository->findAll();
        //var_dump(count($results));
        //die();
        $view = $this->view();
        $view->setData($results);
        $view->getSerializationContext()->setGroups(array('id','api_list'));
        return $this->handleView($view);
    }
    
}