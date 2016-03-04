<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\SEIPBundle\Controller\HouseSupply;

use Pequiven\SEIPBundle\Controller\SEIPController;
use Symfony\Component\HttpFoundation\Request;
use Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle;
use Pequiven\SEIPBundle\Entity\HouseSupply\Order\houseSupplyOrderItems;
use Pequiven\SEIPBundle\Repository\HouseSupply\Order\HouseSupplyOrderRepository;

/**
 * CONTROLADOR DE PEDIDOS DE CASA - ABASTO
 * @author Gilbert C. <glavrjk@gmail.com>
 */
class HouseSupplyOrderController extends SEIPController {

    public function ShowAction(Request $request) {
        var_dump("hola");
        die();
    }

    public function chargeAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $permiso = 1;
        $type = 1;

        $searchwsc = array(
            'coordinator' => $user,
            'phase' => 1,
        );

        $wsc = $em->getRepository('PequivenSEIPBundle:Politic\WorkStudyCircle')->findOneBy($searchwsc);

        if ($permiso == 1) {

            //NUEVO NUMERO DE PEDIDO
            $neworderNro = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrder')->FindNextOrderNro($type);
            $neworder = str_pad((($neworderNro[0]['nro']) + 1), 5, 0, STR_PAD_LEFT);

            $search = array(
                'workStudyCircle' => $wsc,
                'type' => $type,
            );

            //ULTIMO PEDIDO REALIZADO
            $lastorder = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrder')->findOneBy($search);

            //LISTA DE PRODUCTOS DISPONIBLES
            $products = $em->getRepository('PequivenSEIPBundle:HouseSupply\Inventory\HouseSupplyProduct')->getAvailableProduct();

            return $this->render('PequivenSEIPBundle:HouseSupply\Order:create.html.twig', array(
                        'type' => $type,
                        'neworder' => $neworder,
                        'lastorder' => $lastorder,
                        'products' => $products,
                        'wsc' => $wsc,
            ));
        }
    }

    public function saveOrderAction(Request $request) {
        var_dump($request->get("datos"));
        die();
    }

}
