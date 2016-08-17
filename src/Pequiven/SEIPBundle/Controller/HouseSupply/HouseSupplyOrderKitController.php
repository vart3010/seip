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
use Pequiven\SEIPBundle\Entity\HouseSupply\Inventory\houseSupplyInventoryCharge;
use Pequiven\SEIPBundle\Entity\HouseSupply\Inventory\houseSupplyInventoryChargeItems;
//use Pequiven\SEIPBundle\Entity\HouseSupply\Order\houseSupplyOrder;

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

        $searchCriteria = array(
            'cycle' => $cycle[0]->getId(),
            'workStudyCircle' => $wsc->getId(),
            'type' => array(1, 4, 5),
        );

        if ($cycle) {
            $order = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrder')->findBy($searchCriteria);

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
     * CREA LA LISTA DE PEDIDOS
     * @param Request $request
     * @return type
     */
    public function listAction(Request $request) {

        $criteria = $request->get('filter', $this->config->getCriteria());
        $sorting = $request->get('sorting', $this->config->getSorting());
//$repository = $this->getRepository();
        $repository = $this->get('pequiven.repository.housesupply_order');
//var_dump(get_class($repository));die();
//$orders = $this->get('pequiven.repository.housesupply_order')->findAll(); //Carga las Órdenes
        
        $arrayStatusHouseSupplyOrder = houseSupplyOrder::getStatus();
        
        $statusHouseSupplyOrder = array();
        $statusHouseSupplyOrder[] = array('id' => houseSupplyOrder::REGISTRADA,'description' => $arrayStatusHouseSupplyOrder[houseSupplyOrder::REGISTRADA]);
        $statusHouseSupplyOrder[] = array('id' => houseSupplyOrder::DEVUELTA,'description' => $arrayStatusHouseSupplyOrder[houseSupplyOrder::DEVUELTA]);
        $statusHouseSupplyOrder[] = array('id' => houseSupplyOrder::ESPERA,'description' => $arrayStatusHouseSupplyOrder[houseSupplyOrder::ESPERA]);
        $statusHouseSupplyOrder[] = array('id' => houseSupplyOrder::PAGADA,'description' => $arrayStatusHouseSupplyOrder[houseSupplyOrder::PAGADA]);
        $statusHouseSupplyOrder[] = array('id' => houseSupplyOrder::ENTREGADA,'description' => $arrayStatusHouseSupplyOrder[houseSupplyOrder::ENTREGADA]);
        
        $securityService = $this->getSecurityService();
        if (!$securityService->isGranted(array("ROLE_SEIP_HOUSESUPPLY_VIEW_ALL_ORDERS"))) {
            $criteria['ownWsc'] = $this->getUser()->getWorkStudyCircle()->getId();
        }

        if ($this->config->isPaginated()) {
            $resources = $this->resourceResolver->getResource(
                    $repository, 'createPaginatorByHouseSupplyOrder', array($criteria, $sorting)
            );

            $maxPerPage = $this->config->getPaginationMaxPerPage();
            if (($limit = $request->query->get('limit')) && $limit > 0) {
                if ($limit > 100) {
                    $limit = 100;
                }
                $maxPerPage = $limit;
            }
            $resources->setCurrentPage($request->get('page', 1), true, true);
            $resources->setMaxPerPage($maxPerPage);
        } else {
            $resources = $this->resourceResolver->getResource(
                    $repository, 'findBy', array($criteria, $sorting, $this->config->getLimit())
            );
        }
        $routeParameters = array(
            '_format' => 'json',
        );
        $apiDataUrl = $this->generateUrl('pequiven_housesupply_order_list', $routeParameters);

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('list.html'))
                ->setTemplateVar($this->config->getPluralResourceName())
        ;
        if ($request->get('_format') == 'html') {
            $data = array(
                'apiDataUrl' => $apiDataUrl,
                $this->config->getPluralResourceName() => $resources,
                'statusHouseSupplyOrder' => $statusHouseSupplyOrder,
            );
            $view->setData($data);
        } else {
            $view->getSerializationContext()->setGroups(array('id', 'api_list', 'work_study_circle', 'house_supply_cycle', 'house_supply_product_kit', 'date', 'complejo'));
            $formatData = $request->get('_formatData', 'default');

            $view->setData($resources->toArray('', array(), $formatData));
        }
        return $this->handleView($view);
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
            $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrder')->DeleteItemOrder($items->getId());
        }

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
        $orderDetails = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrder')->TotalOrder($id);
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
        $user = $this->getUser();
        $searchwsc = array(
            'coordinator' => $user,
            'phase' => 1,
        );

        $wsc = $em->getRepository('PequivenSEIPBundle:Politic\WorkStudyCircle')->findOneBy($searchwsc);

        $allOrders = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrder')->findBy(array('type' => 1, 'workStudyCircle' => $wsc));
        $members = array();

        if ($request->get('idOrder')) {
            $id = $request->get('idOrder');
            $order = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrder')->findOneById($id);
            foreach ($order->getOrderItems() as $items) {
                if (!isset($members[$items->getClient()->getId()])) {
                    $members[$items->getClient()->getId()] = $items->getClient();
                }
            }
            $orderDetails = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrder')->TotalOrder($id, $type = 1);
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
            $payment->setRef(strtoupper($ref));
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

    /**
     * MUESTRA LA VISTA DE ENTREGA (DESPACHO) DE PEDIDOS
     * @param Request $request
     * @return type
     */
    public function DeliveryOrderAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $allOrders = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrder')->findBy(array('type' => 4));
        $members = array();

        if ($request->get('idOrder')) {
            $id = $request->get('idOrder');
            $order = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrder')->findOneById($id);
            foreach ($order->getOrderItems() as $items) {
                if (!isset($members[$items->getClient()->getId()])) {
                    $members[$items->getClient()->getId()] = $items->getClient();
                }
            }
            $orderDetails = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrder')->TotalOrder($id);
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

        return $this->render('PequivenSEIPBundle:HouseSupply\Order:deliveryOrderkit.html.twig', array(
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
     * REGISTRA LA ENTREGA DE UN PEDIDO
     * @param Request $request
     * @return type
     * @throws \Pequiven\SEIPBundle\Controller\HouseSupply\Exception
     */
    public function DelivererOrderAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $idOrder = $request->get('id');
        $order = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrder')->findOneById($idOrder);

//CALCULO EL NUEVO CORRELATIVO
        $newnroobj = $em->getRepository('PequivenSEIPBundle:HouseSupply\Inventory\HouseSupplyInventoryCharge')->FindNextInvChargeNro(2);

        if ($newnroobj[0]['nro']) {
            $newnro = $newnroobj[0]['nro'] + 1;
        } else {
            $newnro = 1;
        }

        $searchCriteria = array(
            'complejo' => $order->getWorkStudyCircle()->getComplejo()->getId()
        );


//OBTENGO EL DEPOSITO        
        $deposit = $em->getRepository('PequivenSEIPBundle:HouseSupply\Inventory\HouseSupplyDeposit')->findOneBy($searchCriteria);

//OBTENGO LISTA DE PRODUCTOS
        $orderDetails = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrder')->TotalOrder($idOrder);
        $date = new \DateTime;
        $obs = 'Orden Nro. ' . str_pad($order->getNroOrder(), 5, 0, STR_PAD_LEFT) . ' del ' . ($order->getDateOrder()->format('d/m/Y'));

        $em->getConnection()->beginTransaction();

//CARGO LA OPERACION DE INVENTARIO EN LA BASE DE DATOS
        $charge = new houseSupplyInventoryCharge();
        $charge->setDate($date);
        $charge->setObservations($obs);
        $charge->setNroCharge($newnro);
        $charge->setType(2);
        $charge->setSign(-1);
        $charge->setDeposit($deposit);
        $charge->setTotalCharge(null);
        $charge->setCreatedBy($this->getUser());
        $em->persist($charge);

//CARGO LOS ITEMS DE LA OPERACION DE INVENTARIO;
        try {
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            throw $e;
        }

//CARGO LOS ITEMS DEL CARGO DE INVENTARIO
        $line = 0;
        foreach ($orderDetails as $prod) {

            $line++;
            $product = $em->getRepository('PequivenSEIPBundle:HouseSupply\Inventory\HouseSupplyProduct')->findOneById($prod["prodID"]);

            $inventorychargeitems = new houseSupplyInventoryChargeItems();
            $inventorychargeitems->setType(2);
            $inventorychargeitems->setSign(-1);
            $inventorychargeitems->setDate($date);
            $inventorychargeitems->setInventoryCharge($charge);
            $inventorychargeitems->setProduct($product);
            $inventorychargeitems->setCant($prod["cant"]);
            $inventorychargeitems->setLine($line);
            $inventorychargeitems->setCost(null);
            $inventorychargeitems->setTotalLine(null);
            $inventorychargeitems->setCreatedBy($this->getUser());
            $em->persist($inventorychargeitems);
            $em->flush();

//ACTUALIZO LAS EXISTENCIAS EN INVENTARIO            
            $search = array(
                'product' => $product->getId(),
                'deposit' => $deposit->getId()
                    )
            ;

            $inventory = $em->getRepository('PequivenSEIPBundle:HouseSupply\Inventory\HouseSupplyInventory')->findOneBy($search);
            $disponible = ($inventory->getAvailable()) - ($prod["cant"]);
            $inventory->setAvailable($disponible);
            $em->persist($inventory);
            $em->flush();
        }

//ACTUALIZO LOS DATOS DE LA ORDEN Y EL ESTATUS
        $order->setType(5);
        $order->setDateDelivery($date);
        $order->setDeliveredBy($this->getUser());
        $em->persist($order);
        $em->flush();

        $this->get('session')->getFlashBag()->add('success', "Despacho de Orden Registrado Correctamente");
        return $this->redirect($this->generateUrl("pequiven_housesupply_orderkit_delivery", array("idOrder" => $idOrder)));
    }

    /**
     * MUESTRA LA VISTA DE ANULACIÓN DE PEDIDOS
     * @param Request $request
     * @return type
     */
    public function CancelOrderAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $allOrders = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrder')->findBy(array('type' => array(4)));
        $members = array();

        if ($request->get('idOrder')) {
            $id = $request->get('idOrder');
            $order = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrder')->findOneById($id);
            foreach ($order->getOrderItems() as $items) {
                if (!isset($members[$items->getClient()->getId()])) {
                    $members[$items->getClient()->getId()] = $items->getClient();
                }
            }
            $orderDetails = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrder')->TotalOrder($id);
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

        return $this->render('PequivenSEIPBundle:HouseSupply\Order:cancelOrderkit.html.twig', array(
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
     * ANULACION DE ORDENES DE PEDIDO
     * @param Request $request
     * @return type
     */
    public function AnnulOrderAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $idOrder = $request->get('id');
        $order = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrder')->findOneById($idOrder);
        $date = new \DateTime((date("Y-m-d h:m:s")));

        foreach ($order->getOrderItems() as $orderItems) {
            $orderItems->setType(2);
            $orderItems->setDeletedAt($date);
            $orderItems->setDeletedBy($this->getUser());
            $em->flush();
        }

        $order->setType(2);
        $order->setDeletedAt($date);
        $order->setDeletedBy($this->getUser());
        $em->flush();

        $this->get('session')->getFlashBag()->add('success', "Devolución de Orden Procesada Correctamente");
        return $this->redirect($this->generateUrl("pequiven_housesupply_orderkit_cancel", array("idOrder" => $idOrder)));
    }

}
