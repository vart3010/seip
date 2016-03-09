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

        $dep = array('complejo' => $wsc->getComplejo()->getId());
        $deposit = $em->getRepository('PequivenSEIPBundle:HouseSupply\Inventory\HouseSupplyDeposit')->findOneBy($dep);

        $searchInventory = array(
            'deposit' => $deposit,
        );

        $inventory = $em->getRepository('PequivenSEIPBundle:HouseSupply\Inventory\HouseSupplyInventory')->findBy($searchInventory);

        //SI SE VA A CREAR EL PEDIDO
        $crear = 1;

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
        $date = new \DateTime(str_replace("/", "-", (time())));

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

    public function saveOrderAction(Request $request) {
        var_dump($request->get("datos"));
        die();
    }

}
