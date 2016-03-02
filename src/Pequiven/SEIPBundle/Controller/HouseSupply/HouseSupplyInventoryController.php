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
use Pequiven\SEIPBundle\Entity\HouseSupply\Inventory\houseSupplyInventoryChargeItems;
use Pequiven\SEIPBundle\Form\HouseSupply\Inventory\houseSupplyInventoryChargeType;
use Pequiven\SEIPBundle\Entity\HouseSupply\Inventory\houseSupplyProduct;

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
        $newchargeNro = $em->getRepository('PequivenSEIPBundle:HouseSupply\Inventory\HouseSupplyInventoryCharge')->FindNextInvChargeNro($type);
        $newcharge = str_pad((($newchargeNro[0]['nro']) + 1), 5, 0, STR_PAD_LEFT);

        $search = array(
            'nroCharge' => $newchargeNro[0]['nro'],
            'type' => $type
        );

        //ULTIMA CARGA REALIZADA
        $lastcharge = $em->getRepository('PequivenSEIPBundle:HouseSupply\Inventory\HouseSupplyInventoryCharge')->findOneBy($search);

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

        $em = $this->getDoctrine()->getManager();
        $securityService = $this->getSecurityService();

        //OBTENGO EL TIPO DE MOVIMIENTO DE UNIDADES
        $type = $request->get('type');

        if ($type == 1) {
            $sign = 1;
        } else {
            $sign = -1;
        }

        //CALCULO EL NUEVO CORRELATIVO
        $newnroobj = $em->getRepository('PequivenSEIPBundle:HouseSupply\Inventory\HouseSupplyInventoryCharge')->FindNextInvChargeNro($type);
        
        if ($newnroobj[0]['nro']) {
            $newnro = $newnroobj[0]['id'] + 1;
        } else {
            $newnro = 1;
        }

        //OBTENGO EL DEPOSITO        
        $deposit = $em->getRepository('PequivenSEIPBundle:HouseSupply\Inventory\HouseSupplyDeposit')->findOneById($request->get('deposit'));

        //OBTENGO LISTA DE PRODUCTOS
        $dataProduct = json_decode($request->get('dataProduct'));

        $totalCharge = $totalCant = 0;

        foreach ($dataProduct->datos as $prod) {
            $totalCant = $totalCant + $prod->cantidad;
            $totalCharge = $totalCharge + $prod->subtotal;
        }

        $em->getConnection()->beginTransaction();

        //OBTENGO LOS VALORES DEL FORMULARIO
        $inventorycharge = new houseSupplyInventoryCharge();
        $form = $this->createForm(new houseSupplyInventoryChargeType(), $inventorycharge);
        $form->handleRequest($request);
        $date = new \DateTime(str_replace("/", "-", ($request->get("HouseSupplyInventoryCharge")["date"])));
        $obs = $request->get("HouseSupplyInventoryCharge")["observations"];

        //CARGO LA OPERACION DE INVENTARIO EN LA BASE DE DATOS
        $charge = new houseSupplyInventoryCharge();
        $charge->setDate($date);
        $charge->setObservations($obs);
        $charge->setNroCharge($newnro);
        $charge->setType($type);
        $charge->setSign($sign);
        $charge->setDeposit($deposit);
        $charge->setTotalCharge($totalCharge);
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
        foreach ($dataProduct->datos as $prod) {

            $line++;
            $product = $em->getRepository('PequivenSEIPBundle:HouseSupply\Inventory\HouseSupplyProduct')->findOneById($prod->producto);

            $inventorychargeitems = new houseSupplyInventoryChargeItems();
            $inventorychargeitems->setType($type);
            $inventorychargeitems->setSign($sign);
            $inventorychargeitems->setDate($date);
            $inventorychargeitems->setInventoryCharge($charge);
            $inventorychargeitems->setProduct($product);
            $inventorychargeitems->setCant($prod->cantidad);
            $inventorychargeitems->setLine($line);
            $inventorychargeitems->setCost($prod->costo);
            $inventorychargeitems->setTotalLine($prod->subtotal);
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
            $disponible = ($inventory->getAvailable()) + ($sign * $prod->cantidad);
            $inventory->setAvailable($disponible);
            $em->flush();

            //ACTUALIZO EL COSTO DEL PRODUCTO
            $product->setCost($prod->costo);

            //ACTUALIZO MAXIMO POR PERSONA EN LA INSTANCIA DEL PRODUCTO
            $instance = $product->getInstance();
            $dispInst = ($instance->getAvailable()) + ($sign * $prod->cantidad);

            $poblacion = $deposit->getComplejo()->getNumberMembersCET();

            if ($dispInst < 0) {
                $instance->setMaxPerUser(0);
            } else {
                $instance->setMaxPerUser(floor($dispInst / $poblacion));
            }
            $em->flush();
        }

        return $this->redirect($this->generateUrl("pequiven_housesupply_inventory_charge", array("type" => $type)));
    }

}
