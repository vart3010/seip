<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controlador para probar funcionalidades
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @Route("/test")
 */
class TestController extends Controller  
{
    /**
     * @Route("/sendPrePlanningEmailRevision")
     * @param \Pequiven\SEIPBundle\Controller\Request $request
     */
    function sendPrePlanningEmailRevision(Request $request) 
    {
        $user = $this->getUser();
        $parameters = array(
            'user' => $user,
            'gerencia' => 'Planificacion'
        );
        
        return $this->render('PequivenSEIPBundle:PrePlanning:Email/sendToRevision.html.twig',$parameters);
    }
    /**
     * @Route("/sendPrePlanningEmailToDraft")
     * @param \Pequiven\SEIPBundle\Controller\Request $request
     */
    function sendPrePlanningEmailToDraft(Request $request) 
    {
        $user = $this->getUser();
        $parameters = array(
            'user' => $user,
            'gerencia' => 'Planificacion'
        );
        
        return $this->render('PequivenSEIPBundle:PrePlanning:Email/sendToDraft.html.twig',$parameters);
    }
}
