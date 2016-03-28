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
 * CONTROLADOR DE FACTURACION DE CASA - ABASTO
 * @author Gilbert C. <glavrjk@gmail.com>
 */
class HouseSupplyBillingController extends SEIPController {

    public function chargeAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $type = 1;

        $fechaOrder = new \DateTime();
        $fechaOrder->sub(new \DateInterval('P7D'));
//         var_dump($fechaOrder->format('Y-m-d h:m:s'));
//        die();
//        
        $cycle = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyCycle')->FindCycleBilling($fechaOrder->format('Y-m-d h:m:s'));


        if (!empty($cycle)) {
            $orders = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrder')->findBy(array('cycle' => $cycle[0]->getId(), 'invoiced' => false));
        } else {
            $orders = null;
        }

        //NUEVO NUMERO DE PEDIDO
        $newbillNro = $em->getRepository('PequivenSEIPBundle:HouseSupply\Billing\HouseSupplyBilling')->FindNextBillNro($type);
        $newbill = str_pad((($newbillNro[0]['nro']) + 1), 5, 0, STR_PAD_LEFT);
//        $items = null;
        $orderobj = null;

        if (($request->get('order')) && ($request->get('order') != 0)) {
            $id = $request->get('order');
            $orderobj = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrder')->findOneById($id);
//            $items = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrder')->TotalOrder($orderobj->getWorkStudyCircle()->getId(), 1, $id);            
        }

        return $this->render('PequivenSEIPBundle:HouseSupply\Billing:create.html.twig', array(
                    'type' => $type,
                    'newbill' => $newbill,
                    'orders' => $orders,
//                    'items' => $items,
                    'orderobj' => $orderobj,
        ));
    }

}
