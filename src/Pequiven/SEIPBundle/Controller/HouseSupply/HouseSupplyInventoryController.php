<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\SEIPBundle\Controller\HouseSupply;

use Pequiven\SEIPBundle\Controller\SEIPController;
use Symfony\Component\HttpFoundation\Request;
use Pequiven\SEIPBundle\Entity\HouseSupply\Inventory\houseSupplyInventoryCharge;
use Pequiven\SEIPBundle\Form\HouseSupply\Inventory\houseSupplyInventoryChargeType;

/**
 * CONTROLADOR DE INVENTARIO DE CASA - ABASTO
 * @author Gilbert C. <glavrjk@gmail.com>
 */
class HouseSupplyInventoryController extends SEIPController {

    public function chargeAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        //OBTENGO EL TIPO DE MOVIMIENTO DE UNIDADES
        $type = $request->get('type');

        //NUEVO NUMERO DE CARGO DE DEPOSITO
        $newid = $em->getRepository('PequivenSEIPBundle:HouseSupply\Inventory\HouseSupplyInventoryCharge')->FindNextInvChargeId($type);
        $newcharge = str_pad((($newid[0]['id']) + 1), 5, 0, STR_PAD_LEFT);

        //ULTIMA CARGA REALIZADA
        $lastcharge = $em->getRepository('PequivenSEIPBundle:HouseSupply\Inventory\HouseSupplyInventoryCharge')->findOneById($newid[0]['id']);

        //LISTA DE DEPOSITOS EXISTENTES
        $deposits = $em->getRepository('PequivenSEIPBundle:HouseSupply\Inventory\HouseSupplyDeposit')->findAll();

        //LISTA DE PRODUCTOS DISPONIBLES
        if ($type == 1) {
            $products = $em->getRepository('PequivenSEIPBundle:HouseSupply\Inventory\HouseSupplyProduct')->findAll();
        } else {
            $products = $em->getRepository('PequivenSEIPBundle:HouseSupply\Inventory\HouseSupplyProduct')->findAll();
        }

        //FORMULARIO DE CARGA
        $form = $this->createForm(new houseSupplyInventoryChargeType());

        return $this->render('PequivenSEIPBundle:HouseSupply\Inventory:charge.html.twig', array(
                    'type' => $type,
                    'deposits' => $deposits,
                    'newcharge' => $newcharge,
                    'lastcharge' => $lastcharge,
                    'form' => $form->createView(),
                    'products' => $products,
        ));
    }

    public function createAction(Request $request) {

        //OBTENGO EL TIPO DE MOVIMIENTO DE UNIDADES
        $type = $request->get('type');

        return $this->redirect($this->generateUrl("pequiven_housesupply_inventory_charge", array("type" => $type)));
    }

}
