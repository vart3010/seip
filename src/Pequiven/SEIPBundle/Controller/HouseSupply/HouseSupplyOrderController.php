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

/**
 * CONTROLADOR DE PEDIDOS DE CASA - ABASTO
 * @author Gilbert C. <glavrjk@gmail.com>
 */
class HouseSupplyOrderController extends SEIPController {

    public function chargeAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $type = 1;

        $searchwsc = array(
            'coordinator' => $user,
            'phase' => 1,
        );

        $wsc = $em->getRepository('PequivenSEIPBundle:Politic\WorkStudyCircle')->findOneBy($searchwsc);

        $dep = array('complejo' => $wsc->getComplejo()->getId());
        $deposit = $em->getRepository('PequivenSEIPBundle:HouseSupply\Inventory\HouseSupplyDeposit')->findOneBy($dep);

        $searchInventory = array(
            'deposit' => $deposit,
        );

        $inventory = $em->getRepository('PequivenSEIPBundle:HouseSupply\Inventory\HouseSupplyInventory')->findBy($searchInventory);

        //SI SE VA A CREAR EL PEDIDO
        $crear = 1;

        if ($crear == 1) {
            //NUEVO NUMERO DE PEDIDO
            $neworderNro = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrder')->FindNextOrderNro($type);

            $neworder = str_pad((($neworderNro[0]['nro']) + 1), 5, 0, STR_PAD_LEFT);

            if (($request->get('member')) && ($request->get('member') != 0)) {
                $member = $em->getRepository('PequivenSEIPBundle:User')->findOneById($request->get('member'));
                $searchitemsbymember = array(
                    'client' => $member,
                    'type' => 3,
                    'workStudyCircle' => $wsc,
                );
                $items = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrderItems')->findBy($searchitemsbymember);
            } else {
                if (($request->get('typemember') == 0) || ($request->get('member') == 0)) {
                    $member = null;
                    $searchitemsbymember = array(
                        'type' => 3,
                        'workStudyCircle' => $wsc,
                    );
                    $items = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrderItems')->findBy($searchitemsbymember);
                }
            }

            return $this->render('PequivenSEIPBundle:HouseSupply\Order:create.html.twig', array(
                        'type' => $type,
                        'neworder' => $neworder,
                        'inventory' => $inventory,
                        'wsc' => $wsc,
                        'items' => $items,
                        'memberobj' => $member,
            ));
        } else {
            $this->get('session')->getFlashBag()->add('error', "Su Círculo de Estudio Ya Realizó un Pedido para este Mes");
            $this->showAction($request);
        }
    }

    public function totalAction(Request $request) {
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

        //NUEVO NUMERO DE PEDIDO
        $neworderNro = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrder')->FindNextOrderNro($type);
        $neworder = str_pad((($neworderNro[0]['nro']) + 1), 5, 0, STR_PAD_LEFT);
        $items = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrder')->TotalOrder($wsc->getid());

        return $this->render('PequivenSEIPBundle:HouseSupply\Order:total.html.twig', array(
                    'type' => $type,
                    'neworder' => $neworder,
                    'wsc' => $wsc,
                    'items' => $items
        ));
    }

    public function addItemAction(Request $request) {

        $iva = 0.12;
        $em = $this->getDoctrine()->getManager();
        $client = $request->get('datauser');
        $wsc = $em->getRepository('PequivenSEIPBundle:Politic\WorkStudyCircle')->findOneById($wsc = $request->get('wsc'));
        $clientobj = $em->getRepository('PequivenSEIPBundle:User')->findOneById($client);
        $cant = $request->get('cantidad');
        $product = $request->get('producto');
        $productobj = $em->getRepository('PequivenSEIPBundle:HouseSupply\Inventory\HouseSupplyProduct')->findOneById($product);
        $line = $request->get('linea');
        $date = new \DateTime((date("Y-m-d h:m:s")));

        $em->getConnection()->beginTransaction();

        $order = new houseSupplyOrderItems();
        $order->setDate($date);
        $order->setType(3);
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

        if ($productobj->getExento() == 1) {
            $order->setTotalLineTaxes(0);
        } else {
            $order->setTotalLineTaxes($productobj->getPrice() * $cant * $iva);
        }

        $em->persist($order);
        try {
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            throw $e;
        }

        return $this->redirect($this->generateUrl("pequiven_housesupply_order_charge", array("member" => $client, 'typemember' => 1)));
    }

    public function deleteItemAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $em->getFilters()->disable('softdeleteable');
        $id = $request->get('id');
        $member = $request->get('member');
        $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrder')->DeleteItemOrder($id);
        $em->getFilters()->enable('softdeleteable');
        return $this->redirect($this->generateUrl("pequiven_housesupply_order_charge", array("member" => $member, 'typemember' => 1)));
    }

    public function registerAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $type = 1;
        $date = new \DateTime((date("Y-m-d h:m:s")));

        if ($type == 1) {
            $signo = 1;
        } else {
            $signo = -1;
        }

        $searchwsc = array(
            'coordinator' => $user,
            'phase' => 1,
        );

        $wsc = $em->getRepository('PequivenSEIPBundle:Politic\WorkStudyCircle')->findOneBy($searchwsc);

        //NUEVO NUMERO DE PEDIDO
        $neworderNro = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrder')->FindNextOrderNro($type);
        //$neworder = str_pad((($neworderNro[0]['nro']) + 1), 5, 0, STR_PAD_LEFT);
        //
        //CICLO DE ORDENES
        $ciclo = 1;
        $cycle = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyCycle')->FindCycle($ciclo, new \DateTime((date("Y-m-d h:m:s"))));

        $searchItems = array(
            'workStudyCircle' => $wsc,
            'type' => 3,
        );

        //TRAIGO LOS DOCUMENTOS EN ESPERA
        $waitingItems = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrderItems')->findBy($searchItems);

        //OBTENGO EL DEPOSITO   
        $searchDepo = array(
            'complejo' => $wsc->getComplejo()->getId(),
        );

        $deposit = $em->getRepository('PequivenSEIPBundle:HouseSupply\Inventory\HouseSupplyDeposit')->findOneBy($searchDepo);

        $em->getConnection()->beginTransaction();

        //COMIENZO A LLENAR EL ENCABEZADO DE LA ORDEN
        $order = new houseSupplyOrder();
        $order->setDate($date);
        $order->setDateBilling($date);
        $order->setType($type);
        $order->setSign($signo);
        $order->setworkStudyCircle($wsc);
        $order->setCycle($cycle[0]);
        $order->setNroOrder($neworderNro[0]['nro'] + 1);
        $order->setCreatedBy($this->getUser());
        $em->persist($order);

        $baseImponible = 0;
        $iva = 0;

        foreach ($waitingItems as $items) {
            $items->setType($type);
            $items->setDate($date);
            $items->setOrder($order);
            $em->persist($items);

            $prod = $items->getproduct();

            $instancia = $prod->getInstance();
            $instancia->setAvailable(($instancia->getAvailable()) - ($items->getCant()));
            $em->persist($instancia);

            $search = array(
                'product' => $items->getProduct()->getId(),
                'deposit' => $deposit->getId()
                    )
            ;

            $inventory = $em->getRepository('PequivenSEIPBundle:HouseSupply\Inventory\HouseSupplyInventory')->findOneBy($search);
            $inventory->setAvailable(($inventory->getAvailable()) - ($items->getCant()));
            $em->persist($inventory);

            $baseImponible+=$items->getTotalLine();
            $iva+=$items->getTotalLineTaxes();
        }

        $order->setTaxable($baseImponible);
        $order->setTax($iva);
        $order->setTotalOrder($baseImponible + $iva);

        try {
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            throw $e;
        }

        $this->get('session')->getFlashBag()->add('success', "Pedido Registrado Exitosamente");
        $this->showAction($request);
    }

    public function showAction(Request $request) {
        return $this->render('PequivenSEIPBundle:HouseSupply\Order:show.html.twig');
    }

}
