<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\SEIPBundle\Controller\HouseSupply;

use Pequiven\SEIPBundle\Controller\SEIPController;
use Symfony\Component\HttpFoundation\Request;

/**
 * CONTROLADOR DE PEDIDOS DE CASA - ABASTO
 * @author Gilbert C. <glavrjk@gmail.com>
 */
class HouseSupplyOrderController extends SEIPController {

    public function indexAction(Request $request){
    	var_dump("hola");
    	die();
    }

    public function chargeAction(Request $request) {
        return $this->render('PequivenSEIPBundle:HouseSupply:Order/show.html.twig');
    }

    public function saveOrderAction(Request $request) {
    	var_dump($request->get("datos"));
    	die();
    }

}
