<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\IndicatorBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Pequiven\IndicatorBundle\Entity\Indicator;
use Pequiven\IndicatorBundle\Entity\IndicatorLevel;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 * Description of IndicatorController
 *
 * @author matias
 */
class IndicatorController extends Controller {
    //put your code here
    public function listAction(){
        return $this->container->get('templating')->renderResponse('PequivenIndicatorBundle:Default:list.html.'.$this->container->getParameter('fos_user.template.engine'),
            array(
                'action' => 'view',
            ));
    }
    
    /**
     * Función que muestra la página inicial de los indicadores
     * @Template("PequivenIndicatorBundle:Default:index.html.twig")
     * @param type $type
     * @return type
     */
    public function showHomeAction($type,$action){
        return array(
            'type' => $type,
            'notification' => true,
            'action' => $action
        );
    }
    
    public function registerRedirectAction(){
        
        return $this->container->get('templating')->renderResponse('PequivenIndicatorBundle:Default:redirect.html.'.$this->container->getParameter('fos_user.template.engine'),
            array(
                'action' => 'view',
            ));
    }
    
    public function redirectRegisterAction(){
        
    }
}
