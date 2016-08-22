<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\SEIPBundle\Controller\HouseSupply;

use Pequiven\SEIPBundle\Controller\SEIPController;
use Symfony\Component\HttpFoundation\Request;
use Pequiven\SEIPBundle\Model\HouseSupply\HouseSupplyPayments;
use Pequiven\SEIPBundle\Model\HouseSupply\HouseSupplyOrder;

/**
 * CONTROLADOR DE PEDIDOS DE CASA - ABASTO
 * @author Gilbert C. <glavrjk@gmail.com>
 */
class HouseSupplyReportsController extends SEIPController {

    /**
     * REPORTE DE LA ORDEN DE PEDIDOS
     * @param Request $request
     * @return type
     */
    public function exportOrderAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $id = $request->get('id');
        $order = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrder')->findOneById($id);
        $wsc = $order->getWorkStudyCircle()->getId();
        $orderDetails = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrder')->TotalOrder($id);
        $productKit = $order->getProductKit();
        $cantKits = count($order->getOrderItems()) / count($productKit->getProductKitItems());
        $arrayStatus = HouseSupplyOrder::getStatus();
        $arrayPays = HouseSupplyPayments::getPaymentsTypes();

        $data = array(
            'order' => $order,
            'productKit' => $productKit,
            'cantKits' => $cantKits,
            'orderDetails' => $orderDetails,
            'arrayStatus' => $arrayStatus,
            'arrayPays' => $arrayPays
        );

        $twig = 'PequivenSEIPBundle:HouseSupply\Reports:exportOrderKit.html.twig';
        $archiveTittle = 'Orden de Pedido ' . str_pad(($order->getNroOrder()), 5, 0, STR_PAD_LEFT);
        $tittle = 'Ordenes de Pedido';
        $this->getReportService()->generateHouseSupplyPDF($data, $tittle, $twig, 'P', $archiveTittle);
    }

    /**
     * REPORTE DE LA CONSTANCIA DE DESPACHO
     * @param Request $request
     */
    public function exportDeliveryOrderAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $id = $request->get('id');
        $order = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrder')->findOneById($id);
        $orderDetails = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrder')->TotalOrder($id);
        $productKit = $order->getProductKit();
        $cantKits = count($order->getOrderItems()) / count($productKit->getProductKitItems());
        $arrayStatus = HouseSupplyOrder::getStatus();
        $arrayPays = HouseSupplyPayments::getPaymentsTypes();


        if (($request->get('indv') != null) && ($request->get('indv') == '1')) {
            $twig = 'PequivenSEIPBundle:HouseSupply\Reports:exportOrderKitInvididualDelivery.html.twig';
            $tittle = 'Nota de Entrega';
            $archiveTittle = 'Notas de Entrega de la Orden ' . str_pad(($order->getNroOrder()), 5, 0, STR_PAD_LEFT);
        } else {
            $twig = 'PequivenSEIPBundle:HouseSupply\Reports:exportOrderKitDelivery.html.twig';
            $tittle = 'Ordenes de Despacho';
            $archiveTittle = 'Orden de Despacho ' . str_pad(($order->getNroOrder()), 5, 0, STR_PAD_LEFT);
        }

        $data = array(
            'order' => $order,
            'productKit' => $productKit,
            'cantKits' => $cantKits,
            'orderDetails' => $orderDetails,
            'arrayStatus' => $arrayStatus,
            'arrayPays' => $arrayPays,
        );

        $this->getReportService()->generateHouseSupplyPDF($data, $tittle, $twig, 'P', $archiveTittle);
    }

}
