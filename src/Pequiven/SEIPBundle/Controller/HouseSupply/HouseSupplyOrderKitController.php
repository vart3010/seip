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
class HouseSupplyOrderKitController extends SEIPController {

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

        if ($cycle != null) {
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
                ));
            } else {
                $this->get('session')->getFlashBag()->add('error', "Su Círculo de Estudio Ya Realizó un Pedido para esta Jornada");

                return $this->redirect($this->generateUrl("pequiven_housesupply_orderkit_show", array("id" => $order[0]->getId())));
            }
        } else {
            $this->get('session')->getFlashBag()->add('error', "Aún No se Encuentra Aperturado el Registro de Ordenes");
            return $this->redirect($this->generateUrl("pequiven_housesupply_orderkit_show", array("id" => 0)));
        }
    }

    public function totalAction(Request $request) {

        $options['idWsc'] = $request->get('wsc');
        $options['idKit'] = $request->get('kit');

        $members = $request->get('members');

        //REGISTRO LOS DOCUMENTOS DE LA ORDEN
        foreach ($members as $key => $member) {
            if ($member == 1) {
                $options['idMember'] = $key;
                $this->addItemAction($options);
            }
        }



//        return $this->render('PequivenSEIPBundle:HouseSupply\Order:total.html.twig', array(
//                    'type' => $type,
//                    'neworder' => $neworder,
//                    'wsc' => $wsc,
//                    'items' => $items
//        ));
    }

    public function addItemAction($options) {

        $idMember = $options['idMember'];
        $idWsc = $options['idWsc'];
        $idKit = $options['idKit'];

        $iva = 0.12;
        $em = $this->getDoctrine()->getManager();
        $clientobj = $em->getRepository('PequivenSEIPBundle:User')->findOneById($idMember);
        $wsc = $em->getRepository('PequivenSEIPBundle:Politic\WorkStudyCircle')->findOneById($idWsc);
        $date = new \DateTime((date("Y-m-d h:m:s")));

        $kit = $em->getRepository('PequivenSEIPBundle:HouseSupply\Inventory\houseSupplyProductKit')->findOneById($idKit);

        $em->getConnection()->beginTransaction();
        $line = 1;

        foreach ($kit->getProductKitItems() as $itemsKit) {
            $cant = $itemsKit->getCant();
            $productobj = $itemsKit->getProduct();

            $order = new houseSupplyOrderItems();
            $order->setDate($date);
            $order->setType(1);
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
            $line++;
        }

        try {
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            throw $e;
        }

        // return $this->redirect($this->generateUrl("pequiven_housesupply_order_charge", array("member" => $idMember, 'typemember' => 1)));
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

    public function registerAction($options) {

        $em = $this->getDoctrine()->getManager();

        $type = $signo = 1;
        $date = new \DateTime((date("Y-m-d h:m:s")));

        $idwsc = $options['wsc'];
        $wsc = $em->getRepository('PequivenSEIPBundle:Politic\WorkStudyCircle')->findOneById($idwsc);

        //NUEVO NUMERO DE PEDIDO
        $neworderNro = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrder')->FindNextOrderNro($type);

        //CICLO DE ORDENES
        $idCycle = $options['cycle'];
        $cycle = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyCycle')->findOneById($idCycle);

        $searchItems = array(
            'workStudyCircle' => $wsc,
            'type' => 3,
        );

        //TRAIGO LOS DOCUMENTOS EN ESPERA
        $waitingItems = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrderItems')->findBy($searchItems);

        $em->getConnection()->beginTransaction();

        //COMIENZO A LLENAR EL ENCABEZADO DE LA ORDEN
        $order = new houseSupplyOrder();
        $order->setDate($date);        
        $order->setType($type);
        $order->setSign($signo);
        $order->setworkStudyCircle($wsc);
        $order->setCycle($cycle);
        $order->setProductKit($cycle->getProductKit());
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
        return $this->redirect($this->generateUrl("pequiven_housesupply_order_show", array("id" => $order->getId())));
    }

    public function showAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $id = $request->get('id');
        $order = $em->getRepository('PequivenSEIPBundle:HouseSupply\Order\HouseSupplyOrder')->findOneById($id);
        return $this->render('PequivenSEIPBundle:HouseSupply\Order:show.html.twig', array(
                    'order' => $order
        ));
    }

}
