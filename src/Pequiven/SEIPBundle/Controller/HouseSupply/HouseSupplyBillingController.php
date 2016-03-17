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

        $fechaOrder = strtotime('-1 week', strtotime(date("Y-m-d h:m:s")));
        $cycle = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyCycle')->FindCycleBilling(new \DateTime($fechaOrder));

        if (!empty($cycle)) {
            $orders = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrder')->findBy(array('cycle' => $cycle[0]->getId()));
        } else {
            $orders = null;
        }

        //NUEVO NUMERO DE PEDIDO
        $newbillNro = $em->getRepository('PequivenSEIPBundle:HouseSupply\Billing\HouseSupplyBilling')->FindNextBillNro($type);
        $newbill = str_pad((($newbillNro[0]['nro']) + 1), 5, 0, STR_PAD_LEFT);
        
        $client=null;
        $orderobj=null;

//        if (($request->get('member')) && ($request->get('member') != 0)) {
//            $member = $em->getRepository('PequivenSEIPBundle:User')->findOneById($request->get('member'));
//            $searchitemsbymember = array(
//                'client' => $member,
//                'type' => 3,
//                'workStudyCircle' => $wsc,
//            );
//            $items = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrderItems')->findBy($searchitemsbymember);
//        } else {
//            if (($request->get('typemember') == 0) || ($request->get('member') == 0)) {
//                $member = null;
//                $searchitemsbymember = array(
//                    'type' => 3,
//                    'workStudyCircle' => $wsc,
//                );
//                $items = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrderItems')->findBy($searchitemsbymember);
//            }
//        }

        return $this->render('PequivenSEIPBundle:HouseSupply\Billing:create.html.twig', array(
                    'type' => $type,
                    'newbill' => $newbill,
                    'orders' => $orders,
                    'client' => $client,
                    'orderobj' => $orderobj,
        ));
    }

}
