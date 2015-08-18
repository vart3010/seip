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
    
}