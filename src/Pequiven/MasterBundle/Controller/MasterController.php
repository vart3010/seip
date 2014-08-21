<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\MasterBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 * Description of MasterController
 *
 * @author matias
 */
class MasterController extends Controller {
    //put your code here
    
    /**
     * Función que muestra la página inicial de los maestros
     * @param type $type
     * @return type
     */
    public function showHomeAction($type,$action){
        return $this->container->get('templating')->renderResponse('PequivenMasterBundle:Default:index.html.'.$this->container->getParameter('fos_user.template.engine'),
        array('type' => $type,
            'notification' => true,
            'action' => $action
            ));
    }
    
    /**
     * Devuelve las gerencias de 1ra línea de acuerdo al complejo seleccionado
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function selectGerenciaFirstFromComplejoAction(Request $request){
        $response = new JsonResponse();
        $gerenciaFirst = array();
        $complejoId = $request->request->get('complejoId');
        $em = $this->getDoctrine()->getManager();
        $results = $em->getRepository('PequivenMasterBundle:Gerencia')->findBy(array('complejo' => $complejoId));
        foreach ($results as $result){
            $gerenciaFirst[] = array("id" => $result->getId(), "description" => $result->getDescription());
        }
//        var_dump($gerenciaFirst[0]->getId());
//        die();
        $response->setData($gerenciaFirst);
//        var_dump($response);
        //var_dump(new JsonResponse($objetiveChildrenTactic));
//        die();
        return $response;
    }
}
