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
        $type = 1;

        $searchwsc = array(
            'coordinator' => $user,
            'phase' => 1,
        );

        $wsc = $em->getRepository('PequivenSEIPBundle:Politic\WorkStudyCircle')->findOneBy($searchwsc);

        //SI SE VA A CREAR EL PEDIDO
        $crear = 1;

        if ($crear == 1) {

            //NUEVO NUMERO DE PEDIDO
            $neworderNro = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrder')->FindNextOrderNro($type);
            $neworder = str_pad((($neworderNro[0]['nro']) + 1), 5, 0, STR_PAD_LEFT);

            return $this->render('PequivenSEIPBundle:HouseSupply\Order:create.html.twig', array(
                        'type' => $type,
                        'neworder' => $neworder,
                        'products' => $products,
                        'wsc' => $wsc,
            ));
        }

        // SI VOY A AÑADIR ITEMS AL PEDIDO
        else {

            $search = array(
                'workStudyCircle' => $wsc,
                'type' => $type,
            );

            //ULTIMO PEDIDO REALIZADO
            $neworder = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrder')->findOneBy($search);

            //LISTA DE PRODUCTOS DISPONIBLES
            $products = $em->getRepository('PequivenSEIPBundle:HouseSupply\Inventory\HouseSupplyProduct')->getAvailableProduct();

            return $this->render('PequivenSEIPBundle:HouseSupply\Order:create.html.twig', array(
                        'type' => $type,
                        'neworder' => $neworder,
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
