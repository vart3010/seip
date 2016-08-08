<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\SEIPBundle\Controller\HouseSupply;

use Pequiven\SEIPBundle\Controller\SEIPController;
use Symfony\Component\HttpFoundation\Request;
use Pequiven\SEIPBundle\Entity\HouseSupply\Order\houseSupplyOrderItems;
use Pequiven\SEIPBundle\Entity\HouseSupply\Order\houseSupplyOrder;
use Pequiven\SEIPBundle\Entity\HouseSupply\Order\houseSupplyPayments;

/**
 * CONTROLADOR DE PEDIDOS DE CASA - ABASTO
 * @author Gilbert C. <glavrjk@gmail.com>
 */
class HouseSupplyOrderKitController extends SEIPController {

    /**
     * CARGA LA PANTALLA DE CREACION DE PEDIDOS
     * @param Request $request
     * @return type
     */
    public function chargeAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $type = 1;

        $searchwsc = array(
            'coordinator' => $user,
            'phase' => 1,
        );

        $wsc = $em->getRepository('PequivenSEIPBundle:Politic\WorkStudyCircle')->findOneBy($searchwsc);

        //VALIDO SI EN EL CICLO TIENE PEDIDOS REALIZADOS
        $cycle = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyCycle')->FindCycle(new \DateTime((date("Y-m-d h:m:s"))));

        if ($cycle) {
            $order = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrder')->findBy(array('cycle' => $cycle[0]->getId(), 'workStudyCircle' => $wsc->getId()));

            if ((count($order) == 0) || ($order == null)) {
                //NUEVO NUMERO DE PEDIDO
                $neworderNro = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrder')->FindNextOrderNro($type);
                $neworder = str_pad((($neworderNro[0]['nro']) + 1), 5, 0, STR_PAD_LEFT);
                $member = null;
                $kit = $cycle[0]->getProductKit();
                return $this->render('PequivenSEIPBundle:HouseSupply\Order:createkit.html.twig', array(
                            'type' => $type,
                            'neworder' => $neworder,
                            'wsc' => $wsc,
                            'kit' => $kit,
                            'memberobj' => $member,
                            'cycle' => $cycle[0],
                ));
            } else {
                $this->get('session')->getFlashBag()->add('error', "Su Círculo de Estudio Ya Realizó un Pedido para esta Jornada");
                return $this->redirect($this->generateUrl("pequiven_housesupply_orderkit_show", array("id" => $order[0]->getId())));
            }
        } else {
            $this->get('session')->getFlashBag()->add('error', "Aún No se Encuentra Aperturado el Registro de Ordenes");
            return $this->redirect($this->generateUrl("pequiven_seip_default_index"));
        }
    }

    /**
     * AÑADE LOS ITEMS A LA ORDEN DE PEDIDOS
     * @param type $options
     * @throws \Pequiven\SEIPBundle\Controller\HouseSupply\Exception
     */
    public function addItemAction($options) {

        $idMember = $options['idMember'];
        $idWsc = $options['idWsc'];
        $idKit = $options['idKit'];

        $em = $this->getDoctrine()->getManager();
        $clientobj = $em->getRepository('PequivenSEIPBundle:User')->findOneById($idMember);
        $wsc = $em->getRepository('PequivenSEIPBundle:Politic\WorkStudyCircle')->findOneById($idWsc);
        $date = new \DateTime((date("Y-m-d h:m:s")));
        $kit = $em->getRepository('PequivenSEIPBundle:HouseSupply\Inventory\houseSupplyProductKit')->findOneById($idKit);

        $line = 1;

        if (isset($options['type'])) {
            $type = $options['type'];
        } else {
            $type = 3;
        }

        foreach ($kit->getProductKitItems() as $itemsKit) {
            $cant = $itemsKit->getCant();
            $productobj = $itemsKit->getProduct();
            $iva = $productobj->getTaxes();
            $order = new houseSupplyOrderItems();
            $order->setDate($date);
            $order->setType($type);
            $order->setSign(1);
            $order->setClient($clientobj);
            $order->setCant($cant);
            $order->setLine($line);
            $order->setProduct($productobj);
            $order->setCost($productobj->getCost() * $cant);
            $order->setTotalLine($productobj->getPrice() * $cant);
            $order->setPrice($productobj->getPrice());
            $order->setWorkStudyCircle($wsc);
            $order->setCreatedBy($this->getUser());

            if (isset($options['order'])) {
                $order->setOrder($options['order']);
            }

            if ($productobj->getExento() == 1) {
                $order->setTotalLineTaxes(0);
            } else {
                $order->setTotalLineTaxes($iva * $cant);
            }
            $em->persist($order);
            $line++;
        }

        $em->getConnection()->beginTransaction();
        try {
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            throw $e;
        }
    }

    /**
     * RETIRA UN ITEM DE PEDIDO DE ACUERDO AL MIEMBRO DEL CIRCULO
     * @param type $options
     * @throws \Pequiven\SEIPBundle\Controller\HouseSupply\Exception
     */
    public function RemoveItemAction($options) {

        $em = $this->getDoctrine()->getManager();
        $idMember = $options['idMember'];
        $idOrder = $options['order'];

        $arraySearch = array(
            'order' => $idOrder,
            'client' => $idMember
        );

        $orderItems = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrderItems')->findBy($arraySearch);

        foreach ($orderItems as $items) {
            $items->setType(2);
            $items->setDeletedBy($this->getUser());
            $em->remove($items);
        }

        $em->flush();
        $this->refreshTotalOrder($idOrder);
    }

    /**
     * REGISTRA EL PEDIDO EN BASE DE DATOS
     * @param type $options
     * @return type
     * @throws \Pequiven\SEIPBundle\Controller\HouseSupply\Exception
     */
    public function registerAction($options) {

        $em = $this->getDoctrine()->getManager();

        $type = $signo = 1;
        $date = new \DateTime((date("Y-m-d h:m:s")));

        $idwsc = $options['idWsc'];
        $wsc = $em->getRepository('PequivenSEIPBundle:Politic\WorkStudyCircle')->findOneById($idwsc);

        //NUEVO NUMERO DE PEDIDO
        $neworderNro = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrder')->FindNextOrderNro($type);
        $idNewOrder = $neworderNro[0]['nro'] + 1;

        //CICLO DE ORDENES
        $idCycle = $options['cycle'];
        $cycle = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyCycle')->findOneById($idCycle);

        $searchItems = array(
            'workStudyCircle' => $wsc,
            'type' => 3,
        );

        //TRAIGO LOS DOCUMENTOS EN ESPERA
        $waitingItems = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrderItems')->findBy($searchItems);

        //COMIENZO A LLENAR EL ENCABEZADO DE LA ORDEN
        $order = new houseSupplyOrder();
        $order->setDateOrder($date);
        $order->setType($type);
        $order->setSign($signo);
        $order->setworkStudyCircle($wsc);
        $order->setCycle($cycle);
        $order->setProductKit($cycle->getProductKit());
        $order->setNroOrder($idNewOrder);
        $order->setCreatedBy($this->getUser());
        $em->persist($order);

        foreach ($waitingItems as $items) {
            $items->setType($type);
            $items->setDate($date);
            $items->setOrder($order);
            $em->persist($items);
        }

        $em->getConnection()->beginTransaction();
        try {
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            throw $e;
        }

        return $order->getId();
    }

    /**
     * CREA EL PEDIDO
     * @param Request $request
     */
    public function totalAction(Request $request) {

        $options['idWsc'] = $request->get('wsc');
        $options['idKit'] = $request->get('kit');
        $options['cycle'] = $request->get('cycle');

        $members = $request->get('members');

        //REGISTRO LOS DOCUMENTOS DE LA ORDEN
        foreach ($members as $key => $member) {
            if ($member == 1) {
                $options['idMember'] = $key;
                $this->addItemAction($options);
            }
        }

        $newOrder = $this->registerAction($options);
        $this->refreshTotalOrder($newOrder);

        $this->get('session')->getFlashBag()->add('success', "Pedido Registrado Exitosamente");
        return $this->redirect($this->generateUrl("pequiven_housesupply_orderkit_show", array("id" => $newOrder)));
    }

    /**
     * MUESTRA EL PEDIDO
     * @param Request $request
     * @return type
     */
    public function showAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $id = $request->get('id');
        $order = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrder')->findOneById($id);
        $wsc = $order->getWorkStudyCircle()->getId();
        $orderDetails = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrder')->TotalOrder($type = 1, $id, $wsc);
        $productKit = $order->getProductKit();
        $cantKits = count($order->getOrderItems()) / count($productKit->getProductKitItems());
        $arrayStatus = \Pequiven\SEIPBundle\Model\HouseSupply\HouseSupplyOrder::getStatus();

        return $this->render('PequivenSEIPBundle:HouseSupply\Order:showkit.html.twig', array(
                    'order' => $order,
                    'productKit' => $productKit,
                    'cantKits' => $cantKits,
                    'orderDetails' => $orderDetails,
                    'arrayStatus' => $arrayStatus
        ));
    }

    /**
     * MUESTRA LA VISTA DE VALIDACION DE PEDIDOS
     * @param Request $request
     * @return type
     */
    public function checkAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $allOrders = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrder')->findBy(array('type' => 1));
        $members = array();

        if ($request->get('idOrder')) {
            $id = $request->get('idOrder');
            $order = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrder')->findOneById($id);
            foreach ($order->getOrderItems() as $items) {
                if (!isset($members[$items->getClient()->getId()])) {
                    $members[$items->getClient()->getId()] = $items->getClient();
                }
            }
            $orderDetails = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrder')->TotalOrder($type = 1, $id);
            $productKit = $order->getProductKit();
            $cantKits = count($order->getOrderItems()) / count($productKit->getProductKitItems());
        } else {
            $order = null;
            $cantKits = null;
            $orderDetails = null;
            $members = null;
        }

        $arrayPayments = \Pequiven\SEIPBundle\Model\HouseSupply\HouseSupplyPayments::getPaymentsTypes();
        $arrayStatus = \Pequiven\SEIPBundle\Model\HouseSupply\HouseSupplyOrder::getStatus();

        return $this->render('PequivenSEIPBundle:HouseSupply\Order:checkOrderkit.html.twig', array(
                    'order' => $order,
                    'ordersArray' => $allOrders,
                    'cantKits' => $cantKits,
                    'members' => $members,
                    'orderDetails' => $orderDetails,
                    'arrayPayments' => $arrayPayments,
                    'arrayStatus' => $arrayStatus
        ));
    }

    /**
     * EDITA EL PEDIDO REALIZADO EN EL PROCESO DE VALIDACION
     * @param Request $request
     * @return type
     */
    public function editMemberOrderCheckAction(Request $request) {

        $em = $this->getDoctrine()->getManager();

        $idKit = $request->get('idKit');
        $idOrder = $request->get('idOrder');
        $idMember = $request->get('idMember');
        $status = $request->get('status');

        $order = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrder')->findOneById($idOrder);

        $options['idWsc'] = $order->getWorkStudyCircle()->getId();
        $options['idKit'] = $idKit;
        $options['cycle'] = $order->getCycle()->getId();
        $options['type'] = 1;
        $options['idMember'] = $idMember;
        $options['order'] = $order;

        //AGREGO LOS DOCUMENTOS DE LA ORDEN                
        if ($status == 'true') {
            $this->addItemAction($options);
        } else {
            $this->RemoveItemAction($options);
        }

        $this->refreshTotalOrder($idOrder);
        $this->get('session')->getFlashBag()->add('success', "Pedido Actualizado");
        return $this->redirect($this->generateUrl("pequiven_housesupply_orderkit_check", array("idOrder" => $idOrder)));
    }

    public function refreshTotalOrder($idOrder) {

        $em = $this->getDoctrine()->getManager();
        $order = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrder')->findOneById($idOrder);

        $baseImponible = 0;
        $iva = 0;

        $list = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrderItems')->findBy(array('order' => $order));

        //TRAIGO LOS DOCUMENTOS EN ESPERA
        foreach ($list as $items) {
            $baseImponible+=$items->getTotalLine();
            $iva+=$items->getTotalLineTaxes();
        }

        $order->setTaxable($baseImponible);
        $order->setTax($iva);
        $order->setTotalOrder($baseImponible + $iva);

        $em->persist($order);
        $em->flush();
    }

    /**
     * REGISTRA EL PAGO DE UNA ORDEN DE PEDIDO
     * @param Request $request
     */
    public function PaymentOrderCheckAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $idOrder = $request->get('idOrder');
        $pays = json_decode($request->get('dataProduct'));
        $date = new \DateTime((date("Y-m-d h:m:s")));
        $order = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrder')->findOneById($idOrder);

        foreach ($pays->datos as $pay) {

            $concepto = 1 * $pay->concepto;
            $ref = $pay->ref;
            $monto = 1 * $pay->monto;

            //COMIENZO A LLENAR LOS PAGOS DE LA ORDEN
            $payment = new houseSupplyPayments();
            $payment->setOrder($order);
            $payment->setType($concepto);
            $payment->setRef($ref);
            $payment->setTotal($monto);
            $payment->setCreatedBy($this->getUser());
            $em->persist($payment);
        }

        //ACTUALIZO LOS DATOS DE LA ORDEN Y EL ESTATUS
        $order->setType(4);
        $order->setDatePay($date);
        $order->setPaidBy($this->getUser());

        $waitingItems = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrderItems')->findBy(array('order' => $order));

        foreach ($waitingItems as $items) {
            $items->setType(4);
            $em->persist($items);
        }

        $em->getConnection()->beginTransaction();
        try {
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            throw $e;
        }

        $this->get('session')->getFlashBag()->add('success', "Pago Procesado Exitosamente");
        return $this->redirect($this->generateUrl("pequiven_housesupply_orderkit_check", array("idOrder" => $idOrder)));
    }

}
