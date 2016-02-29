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
 * CONTROLADOR DE INVENTARIO DE CASA - ABASTO
 * @author Gilbert C. <glavrjk@gmail.com>
 */
class HouseSupplyInventoryController extends SEIPController {

    public function chargeAction(Request $request) {
        $idDepo = $request->get('idDepo');
        $idDepo=2;

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('PequivenSEIPBundle:HouseSupply\Inventory\HouseSupplyDeposit')->find($idDepo);

        var_dump($entity);
        die();

        //INSTANCIACIÓN DE ENTIDADES
        $MovementEmployee = new MovementEmployee();

        //VERIFICO LA PERMISOLOGÍA DEL USUARIO SI PUEDE RETIRAR EMPLEADOS POST-MORTEM
        $securityService = $this->getSecurityService();
        if ($securityService->isGranted(array("ROLE_SEIP_ARRANGEMENT_PROGRAM_MOVEMENT_GOALS_POST_MORTEM"))) {
            $post_mortem = true;
        } else {
            $post_mortem = false;
        }

        //FORMULARIOS DE ENTRADA Y SALIDA
        $formassign = $this->createForm(new AssignMovType(), $MovementEmployee);
        $formremove = $this->createForm(new RemoveMovType($id, $post_mortem, $type), $MovementEmployee);

        //RESPONSABLES ASIGNADOS
        $responsibles = $this->get('pequiven_seip.repository.user')->findQuerytoRemoveAssingedGoal($id, false);

        //MOVIMIENTOS REALIZADOS
        $movements = $this->get('pequiven_seip.repository.arrangementprogram_movement')->FindMovementDetailsbyGoal($id);

        //ARREGLO DE CAUSAS
        $causes = \Pequiven\ArrangementProgramBundle\Model\MovementEmployee::getAllCauses();

        return $this->render('PequivenArrangementProgramBundle:MovementEmployee:show.html.twig', array(
                    'goal' => $entity,
                    'user' => $this->getUser(),
                    'assign' => $formassign->createView(),
                    'remove' => $formremove->createView(),
                    'responsibles' => $responsibles,
                    'movements' => $movements,
                    'causes' => $causes
        ));
    }

}
