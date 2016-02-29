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

        $idDepo = $request->get('deposit');


        $newcharge = $em->getRepository('PequivenSEIPBundle:HouseSupply\Inventory\HouseSupplyInventoryCharge')->FindLastInvChargeId();
        $lastcharge = $em->getRepository('PequivenSEIPBundle:HouseSupply\Inventory\HouseSupplyInventoryCharge')->findOneById(max($newcharge));
        $deposits = $em->getRepository('PequivenSEIPBundle:HouseSupply\Inventory\HouseSupplyDeposit')->findAll();

        $form = new houseSupplyInventoryChargeType();

        $newcharge = str_pad((array_sum($newcharge)), 5, 0, STR_PAD_LEFT);

        return $this->render('PequivenSEIPBundle:HouseSupply\Inventory:charge.html.twig', array(
                    'deposits' => $deposits,
                    'newcharge' => $newcharge,
                    'lastcharge' => $lastcharge,
                    'form' => $form,
        ));
    }

}
