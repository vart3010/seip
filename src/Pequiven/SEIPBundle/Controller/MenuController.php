<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\SEIPBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface as UserInterfaceType;
/**
 * Description of MenuController
 *
 * @author matias
 */
class MenuController extends Controller {
    //put your code here
    /**
     * Redirecciona
     * 
     */
    public function showHomeAction(){
        //var_dump($this->container->get('ruta'));
        //die();
        return $this->container->get('templating')->renderResponse('PequivenSEIPBundle:Default:index.html.'.$this->container->getParameter('fos_user.template.engine'));
    }
}
