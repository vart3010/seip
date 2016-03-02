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

/**
 * CONTROLADOR DE PEDIDOS DE CASA - ABASTO
 * @author Gilbert C. <glavrjk@gmail.com>
 */
class HouseSupplyOrderController extends SEIPController {

    public function indexAction(Request $request) {
        var_dump("hola");
        die();
    }

    public function chargeAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        //OBTENGO EL TIPO DE MOVIMIENTO DE UNIDADES
        $type = $request->get('type');

        $permiso = 1;

        if ($permiso == 1) {
//
//            //NUEVO NUMERO DE ORDEN
//            $neworderNro = $em->getRepository('PequivenSEIPBundle:HouseSupply\Billing\HouseSupplyBilling')->FindNextOrderNro($type);
//            $neworder = str_pad((($neworderNro[0]['nro']) + 1), 5, 0, STR_PAD_LEFT);
//
//            $search = array(
//                'nroBill' => $neworderNro[0]['nro'],
//                'type' => $type
//            );
//
//            //ULTIMA CARGA REALIZADA
//            $lastorder = $em->getRepository('PequivenSEIPBundle:HouseSupply\Billing\HouseSupplyBilling')->findOneBy($search);
//
//            //LISTA DE USUARIOS DISPONIBLES $this->get('pequiven_seip.repository.user')->
//
//            foreach ($this->getUser()->getWorkStudyCircle() as $phase) {
//                if($phase->getphase() = 1) {
//                    
//                }
//            }
//
//
//
//
//            $workstudyCircle = $em->getRepository('PequivenSEIPBundle:Politic\WorkStudyCircle')->findOneBy($wsc);
//
//            //LISTA DE PRODUCTOS DISPONIBLES            
//            $products = $em->getRepository('PequivenSEIPBundle:HouseSupply\Inventory\HouseSupplyProduct')->findAll();
//
//            //FORMULARIO DE CARGA
//            //$form = $this->createForm(new houseSupplyInventoryChargeType());
        }
//
////        return $this->render('PequivenSEIPBundle:HouseSupply\Order:charge.html.twig', array(
////                    'type' => $type,
////                    'deposits' => $deposits,
////                    'newcharge' => $neworder,
////                    'lastcharge' => $lastorder,
////                    'form' => $form->createView(),
////                    'products' => $products,
////        ));
    }

    public function saveOrderAction(Request $request) {
        var_dump($request->get("datos"));
        die();
    }

}
