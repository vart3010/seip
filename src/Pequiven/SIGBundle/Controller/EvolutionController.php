<?php

namespace Pequiven\SIGBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Controlador de Evolución
 *
 * @author Maximo Sojo <maxsojo13@gmail.com>
 */
class EvolutionController extends ResourceController
{
    /**
     * 
     * @return \Pequiven\SEIPBundle\Service\SecurityService
     */
    protected function getSecurityService() {

        return $this->container->get('seip.service.security');
    } 
	/**
     *  Period
     *
     */
    protected function getPeriodService() {
        return $this->container->get('pequiven_seip.service.period');
    }
   
}