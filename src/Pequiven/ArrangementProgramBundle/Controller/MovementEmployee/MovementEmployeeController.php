<?php

namespace Pequiven\ArrangementProgramBundle\Controller\MovementEmployee;

use Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram;
use Pequiven\ArrangementProgramBundle\Entity\Goal;
use Pequiven\ArrangementProgramBundle\Entity\MovementEmployee\MovementEmployee;
use Pequiven\SEIPBundle\Controller\SEIPController;
use Symfony\Component\HttpFoundation\Request;
use Pequiven\ArrangementProgramBundle\Form\MovementEmployee\AssignMovType;
use Pequiven\ArrangementProgramBundle\Form\MovementEmployee\RemoveMovType;

class MovementEmployeeController extends SEIPController {

    public function showAction(Request $request) {
        $id = $request->get('idGoal');

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('PequivenArrangementProgramBundle:Goal')->find($id);

        $type = 'Goal';

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

    public function showAPAction(Request $request) {
        $id = $request->get('idAP');

        $em = $this->getDoctrine()->getManager();
        $type = 'AP';
        $entity = $em->getRepository('PequivenArrangementProgramBundle:arrangementprogram')->find($id);

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
        $responsibles = $this->get('pequiven_seip.repository.user')->findQuerytoRemoveAssingedAP($id, false);

        //MOVIMIENTOS REALIZADOS
        $movements = $this->get('pequiven_seip.repository.arrangementprogram_movement')->FindMovementDetailsbyAP($id);

        //ARREGLO DE CAUSAS
        $causes = \Pequiven\ArrangementProgramBundle\Model\MovementEmployee::getAllCauses();

        return $this->render('PequivenArrangementProgramBundle:MovementEmployee:showAP.html.twig', array(
                    'AP' => $entity,
                    'user' => $this->getUser(),
                    'assign' => $formassign->createView(),
                    'remove' => $formremove->createView(),
                    'responsibles' => $responsibles,
                    'movements' => $movements,
                    'causes' => $causes
        ));
    }

    public function deleteAction(Request $request) {

        $em = $this->getDoctrine()->getManager();

        $id = $request->get('idMov');
        $type = $request->get('type');
        $idAffected = $request->get('idAffected');

        $mov = $em->getRepository('PequivenArrangementProgramBundle:MovementEmployee\MovementEmployee')->find($id);
        $em->remove($mov);
        $em->flush();        
        
        $this->get('session')->getFlashBag()->add('success', "Movimiento Eliminado Exitosamente");

        if ($type == 'Goal') {
            return $this->redirect($this->generateUrl('goal_movement', array('idGoal' => $idAffected)));
        }
        if ($type == 'AP') {
            return $this->redirect($this->generateUrl('AP_movement', array('idAP' => $idAffected)));
        }
    }

    public function assignAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $securityService = $this->getSecurityService();

        //VALIDO PERMISOLOGÍA POR SI ACASO SE ACCEDE DESDE URL DIRECTA
        if ((($securityService->isGranted(array("ROLE_SEIP_ARRANGEMENT_PROGRAM_MOVEMENT_GOALS")))) || ($securityService->isGranted(array("ROLE_SEIP_ARRANGEMENT_PROGRAM_MOVEMENT_GOALS_POST_MORTEM")))) {

            $movement = new MovementEmployee();
            $formAssign = $this->createForm(new AssignMovType(), $movement);
            $formAssign->handleRequest($request);

            $em->getConnection()->beginTransaction();

            if ($securityService->isGranted(array("ROLE_SEIP_ARRANGEMENT_PROGRAM_MOVEMENT_GOALS_POST_MORTEM"))) {
                $post_mortem = true;
            } else {
                $post_mortem = false;
            }

            if ($formAssign->isSubmitted()) {

                //DATOS DE AssignMovType
                $cause = $request->get("AssignMov")["cause"];
                $date = new \DateTime(str_replace("/", "-", ($request->get("AssignMov")["date"])));
                $obs = $request->get("AssignMov")["observations"];

                //DATOS AUDITORIA
                $login = $this->getUser();

                //DATOS DE AssignMovType
                $id_user = ($request->get("AssignMov")["User"]);
                $user = $em->getRepository('PequivenSEIPBundle:User')->findOneById($id_user);

                $period = $this->getPeriodService()->getPeriodActive();

                //VERIFICO SI SE TRATA DE UNA META O UN PROGRAMA DE GESTION
                if (!is_null($request->get('idGoal'))) {
                    $id = $request->get('idGoal');
                    $tipo = 'Goal';
                    $entity = $em->getRepository('PequivenArrangementProgramBundle:Goal')->findOneById($id);

                    //VERIFICO SI EL EMPLEADO PERTENECE A LA META
                    $bandera = $em->getRepository('PequivenArrangementProgramBundle:Goal')->verificationGoalUser($user, $entity, $period);

                    //VALOR PARA EL RETURN
                    $arrangementProgram = $entity->getTimeline()->getArrangementProgram();
                    $idap = $arrangementProgram->getid();

                    //CALCULO PENALIZACIONES Y AVANCES PARA LA FECHA
                    $datos = $this->CalculateAdvancePenalty($entity, $date);
                }

                if (!is_null($request->get('idAP'))) {
                    $id = $request->get('idAP');
                    $tipo = 'AP';

                    $entity = $em->getRepository('PequivenArrangementProgramBundle:arrangementprogram')->find($id);

                    //VERIFICO SI EL EMPLEADO PERTENECE AL AP
                    $bandera = $em->getRepository('PequivenArrangementProgramBundle:arrangementprogram')->verificationAPUser($user, $entity, $period);

                    //VALOR PARA EL RETURN
                    $idap = $id;

                    //CALCULO PENALIZACIONES Y AVANCES PARA LA FECHA
                    $datos = $this->CalculateAdvancePenaltyAP($entity, $date);
                }

                //SI EL EMPLEADO NO SE ENCUENTRA ASIGNADO A LA META
                if (($bandera == null)) {
                    //CARGO LOS DATOS EN DB
                    $movement = new MovementEmployee();
                    $movement->setCreatedBy($login);
                    $movement->setDate($date);
                    $movement->setType('I');
                    $movement->setId_Affected($id);
                    $movement->setCause($cause);
                    $movement->setObservations($obs);
                    $movement->setrealAdvance($datos['realResult'] - $datos['penalty']);
                    $movement->setPentalty($datos['penalty']);
                    $movement->setPlanned($datos['plannedResult']);
                    $movement->setTypeMov($tipo);
                    $movement->setUser($user);
                    $movement->setPeriod($period);
                    $em->persist($movement);

                    //AGREGO AL USUARIO EN LA META O PROGRAMA                
                    $entity->addResponsible($user);
                    $em->persist($entity);
                } else {

                    if ($post_mortem == false) {
                        $this->get('session')->getFlashBag()->add('error', "El Empleado ya se Encuentra Asignado");
                    } else {
                        //CARGO LOS DATOS EN DB
                        $movement = new MovementEmployee();
                        $movement->setCreatedBy($login);
                        $movement->setDate($date);
                        $movement->setType('I');
                        $movement->setId_Affected($id);
                        $movement->setCause($cause);
                        $movement->setObservations($obs);
                        $movement->setrealAdvance($datos['realResult'] - $datos['penalty']);
                        $movement->setPentalty($datos['penalty']);
                        $movement->setPlanned($datos['plannedResult']);
                        $movement->setTypeMov($tipo);
                        $movement->setUser($user);
                        $period = $this->getPeriodService()->getPeriodActive();
                        $movement->setPeriod($period);
                        $em->persist($movement);
                    }
                }

                //VALIDACIÓN DE INTEGRIDAD DE DATOS EN REGISTRO DE BD
                try {
                    $em->flush();
                    $em->getConnection()->commit();
                } catch (Exception $e) {
                    $em->getConnection()->rollback();
                    throw $e;
                }
            }
        } else {
            $this->get('session')->getFlashBag()->add('error', "No tiene los Permisos para Realizar la Acción");
        }

        return $this->redirect($this->generateUrl('arrangementprogram_update', array('id' => $idap)));
        //return $this->redirect($this->generateUrl('goal_movement', array('idGoal' => $id)));
    }

    public function removeAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $securityService = $this->getSecurityService();

        if (!is_null($request->get('idGoal'))) {
            $id = $request->get('idGoal');
            $tipo = 'Goal';
        }

        if (!is_null($request->get('idAP'))) {
            $id = $request->get('idAP');
            $tipo = 'AP';
        }

        //VALIDO PERMISOLOGÍA POR SI ACASO SE ACCEDE DESDE URL DIRECTA
        if ((($securityService->isGranted(array("ROLE_SEIP_ARRANGEMENT_PROGRAM_MOVEMENT_GOALS")))) || ($securityService->isGranted(array("ROLE_SEIP_ARRANGEMENT_PROGRAM_MOVEMENT_GOALS_POST_MORTEM")))) {

            if ($securityService->isGranted(array("ROLE_SEIP_ARRANGEMENT_PROGRAM_MOVEMENT_GOALS_POST_MORTEM"))) {
                $post_mortem = true;
            } else {
                $post_mortem = false;
            }

            $movement = new MovementEmployee();
            $formRemove = $this->createForm(new RemoveMovType($id, $post_mortem, $tipo), $movement);
            $formRemove->handleRequest($request);

            $em->getConnection()->beginTransaction();

            if ($formRemove->isSubmitted()) {

                //DATOS DE RemoveMovType
                $cause = $request->get("RemoveMov")["cause"];
                $date = new \DateTime(str_replace("/", "-", ($request->get("RemoveMov")["date"])));
                $obs = $request->get("RemoveMov")["observations"];

                //DATOS AUDITORIA
                $login = $this->getUser();

                //DATOS DE RemoveMovType
                $id_user = ($request->get("RemoveMov")["User"]);
                $user = $em->getRepository('PequivenSEIPBundle:User')->findOneById($id_user);
                $period = $this->getPeriodService()->getPeriodActive();

                //VERIFICO SI SE TRATA DE UNA META O UN PROGRAMA DE GESTION
                if (!is_null($request->get('idGoal'))) {
                    $id = $request->get('idGoal');
                    $tipo = 'Goal';
                    $entity = $em->getRepository('PequivenArrangementProgramBundle:Goal')->findOneById($id);

                    //VERIFICO SI EL EMPLEADO PERTENECE A LA META
                    $bandera = $em->getRepository('PequivenArrangementProgramBundle:Goal')->verificationGoalUser($user, $entity, $period);

                    //VALOR PARA EL RETURN
                    $arrangementProgram = $entity->getTimeline()->getArrangementProgram();
                    $idap = $arrangementProgram->getid();

                    //CALCULO PENALIZACIONES Y AVANCES PARA LA FECHA
                    $datos = $this->CalculateAdvancePenalty($entity, $date);
                }

                if (!is_null($request->get('idAP'))) {
                    $id = $request->get('idAP');
                    $tipo = 'AP';

                    $entity = $em->getRepository('PequivenArrangementProgramBundle:arrangementprogram')->find($id);

                    //VERIFICO SI EL EMPLEADO PERTENECE AL AP
                    $bandera = $em->getRepository('PequivenArrangementProgramBundle:arrangementprogram')->verificationAPUser($user, $entity, $period);

                    //VALOR PARA EL RETURN
                    $idap = $id;

                    //CALCULO PENALIZACIONES Y AVANCES PARA LA FECHA
                    $datos = $this->CalculateAdvancePenaltyAP($entity, $date);
                }

                //VALIDO QUE LAS METAS O PROGRAMAS NO QUEDEN VACIOS
                $responsibles = $entity->getresponsibles();

                if (count($responsibles) <= 1) {
                    foreach ($responsibles as $resp) {
                        if (($resp->getid()) != ($user->getid())) {
                            $va = 1;
                        } else {
                            $va = 0;
                        }
                    }
                } else {
                    $va = 1;
                }

                if ($va == 0) {
                    $this->get('session')->getFlashBag()->add('error', "NO Puede quedar sin Responsables, Por favor Asigne un Empleado antes de Retirar");
                } else {
                    //SI EL EMPLEADO ENCUENTRA ASIGNADO A LA META
                    if ($bandera <> null) {
                        //CARGO LOS DATOS EN DB
                        $movement = new MovementEmployee();
                        $movement->setCreatedBy($login);
                        $movement->setDate($date);
                        $movement->setType('O');
                        $movement->setId_Affected($id);
                        $movement->setCause($cause);
                        $movement->setObservations($obs);
                        $movement->setrealAdvance($datos['realResult'] - $datos['penalty']);
                        $movement->setPentalty($datos['penalty']);
                        $movement->setPlanned($datos['plannedResult']);
                        $movement->setTypeMov($tipo);
                        $movement->setUser($user);
                        $movement->setPeriod($this->getPeriodService()->getPeriodActive());
                        $em->persist($movement);

                        //ELIMINO AL USUARIO EN LA META
                        $entity->removeResponsible($user);
                        $em->persist($entity);
                    } else {

                        if ($post_mortem == false) {
                            $this->get('session')->getFlashBag()->add('error', "El Empleado Seleccionado no se Encuentra Asignado a la Meta");
                        } else {
                            //CARGO LOS DATOS EN DB
                            $movement = new MovementEmployee();
                            $movement->setCreatedBy($login);
                            $movement->setDate($date);
                            $movement->setType('O');
                            $movement->setId_Affected($id);
                            $movement->setCause($cause);
                            $movement->setObservations($obs);
                            $movement->setrealAdvance($datos['realResult'] - $datos['penalty']);
                            $movement->setPentalty($datos['penalty']);
                            $movement->setPlanned($datos['plannedResult']);
                            $movement->setTypeMov($tipo);
                            $movement->setUser($user);
                            $movement->setPeriod($this->getPeriodService()->getPeriodActive());
                            $em->persist($movement);
                        }
                    }

                    //VALIDACIÓN DE INTEGRIDAD DE DATOS EN REGISTRO DE BD
                    try {
                        $em->flush();
                        $em->getConnection()->commit();
                    } catch (Exception $e) {
                        $em->getConnection()->rollback();
                        throw $e;
                    }
                }
            }
        } else {
            $this->get('session')->getFlashBag()->add('error', "No tiene los Permisos para Realizar la Acción");
        }

        $arrangementProgram = $entity->getTimeline()->getArrangementProgram();
        $idap = $arrangementProgram->getid();
        return $this->redirect($this->generateUrl('arrangementprogram_update', array('id' => $idap)));
        //return $this->redirect($this->generateUrl('goal_movement', array('idGoal' => $id)));
    }

    /**
     * Función que Genera el Reporte de Movimientos en JasperReport
     * @param Request $request
     * @return type
     */
    public function exportAction(Request $request) {

        if (!is_null($request->get('idGoal'))) {
            $id = $request->get('idGoal');
            $reportService = $this->container->get('seip.service.report');
            $route = "MovementEmployee/Goal_Movement.jrxml";
            $parameters = array("idGoal" => $id);
            $reportService->DownloadReportService($parameters, $route);
            return $this->redirect($this->generateUrl('goal_movement', array('idGoal' => $id)));
        }

        if (!is_null($request->get('idAP'))) {
            $id = $request->get('idAP');
            $reportService = $this->container->get('seip.service.report');
            $route = "MovementEmployee/AP_Movement.jrxml";
            $parameters = array("idAP" => $id);
            $reportService->DownloadReportService($parameters, $route);
            return $this->redirect($this->generateUrl('goal_movement', array('idAP' => $id)));
        }
    }

    /**
     * CALCULA EL AVANCE, REAL Y PENALIZACIONES DE METAS A UNA FECHA
     * @param Goal $goal
     * @param type $date
     * @return array
     */
    function CalculateAdvancePenalty(Goal $goal, $date) {

        $real = array();
        $planned = array();

        $periodService = $this->getPeriodService();
        $amountPenalty = 0;

        $arrangementProgram = $goal->getTimeline()->getArrangementProgram();

        $lastNotificationInProgressDate = $arrangementProgram->getDetails()->getLastNotificationInProgressDate();

        if ($arrangementProgram->isCouldBePenalized() && ($periodService->isPenaltyInResult($lastNotificationInProgressDate) === true || $arrangementProgram->isForcePenalize() === true)) {
            $amountPenalty = $periodService->getPeriodActive()->getPercentagePenalty();
        }

        //ENERO
        $sump = $goal->getGoalDetails()->getJanuaryPlanned();
        $sumr = $goal->getGoalDetails()->getJanuaryReal();
        $planned[1] = $sump;
        $real[1] = $sumr;

        //+FEBRERO
        $sump += $goal->getGoalDetails()->getFebruaryPlanned();
        $sumr += $goal->getGoalDetails()->getFebruaryReal();
        $planned[2] = $sump;
        $real[2] = $sumr;

        //+MARZO
        $sump += $goal->getGoalDetails()->getMarchPlanned();
        $sumr += $goal->getGoalDetails()->getMarchReal();
        $planned[3] = $sump;
        $real[3] = $sumr;

        //+ABRIL
        $sump += $goal->getGoalDetails()->getAprilPlanned();
        $sumr += $goal->getGoalDetails()->getAprilReal();
        $planned[4] = $sump;
        $real[4] = $sumr;

        //+MAYO
        $sump += $goal->getGoalDetails()->getMayPlanned();
        $sumr += $goal->getGoalDetails()->getMayReal();
        $planned[5] = $sump;
        $real[5] = $sumr;

        //+JUNIO
        $sump += $goal->getGoalDetails()->getJunePlanned();
        $sumr += $goal->getGoalDetails()->getJuneReal();
        $planned[6] = $sump;
        $real[6] = $sumr;

        //+JULIO
        $sump += $goal->getGoalDetails()->getJulyPlanned();
        $sumr += $goal->getGoalDetails()->getJulyReal();
        $planned[7] = $sump;
        $real[7] = $sumr;

        //+AGOSTO
        $sump += $goal->getGoalDetails()->getAugustPlanned();
        $sumr += $goal->getGoalDetails()->getAugustReal();
        $planned[8] = $sump;
        $real[8] = $sumr;

        //+SEPTIEMBRE
        $sump += $goal->getGoalDetails()->getSeptemberPlanned();
        $sumr += $goal->getGoalDetails()->getSeptemberReal();
        $planned[9] = $sump;
        $real[9] = $sumr;

        //+OCTUBRE
        $sump += $goal->getGoalDetails()->getOctoberPlanned();
        $sumr += $goal->getGoalDetails()->getOctoberReal();
        $planned[10] = $sump;
        $real[10] = $sumr;

        //+NOVIEMBRE
        $sump += $goal->getGoalDetails()->getNovemberPlanned();
        $sumr += $goal->getGoalDetails()->getNovemberReal();
        $planned[11] = $sump;
        $real[11] = $sumr;

        //+DICIEMBRE
        $sump += $goal->getGoalDetails()->getDecemberPlanned();
        $sumr += $goal->getGoalDetails()->getDecemberReal();
        $planned[12] = $sump;
        $real[12] = $sumr;

        $mes = date_format($date, 'n');
        $mayor = 0;

        for ($i = 1; $i <= $mes; $i++) {
            $penal = 0;
            for ($j = $i; $j <= $mes; $j++) {
                if ($real [$j] < $planned[$i]) {
                    $penal++;
                } else {
                    break;
                }
            }

            if ($penal > $mayor) {
                $mayor = $penal;
            }

            if ($planned [$i] == 100) {
                break;
            }
        }

        if ($mayor == null) {
            $mayor = 0;
        }
        if ($real [$mes] == null) {
            $real[$mes] = 0;
        }
        if ($planned [$mes] == null) {
            $planned[$mes] = 0;
        }

        $retorno = array(
            'penalty' => ($mayor + $amountPenalty),
            'realResult' => $real[$mes],
            'plannedResult' => $planned[$mes]
        );

        return $retorno;
    }

    function CalculateAdvancePenaltyAP(ArrangementProgram $AP, $date) {

        $realResult = 0;
        $penalty = 0;
        $plannedResult = 0;

        //DETERMINO LAS METAS PERTENECIENTES AL AP
        foreach ($AP->getTimeline()->getGoals() as $meta) {
            //CALCULO PENALIZACIONES Y AVANCES PARA LA FECHA Y VOY SUMANDO POR META
            $datosAP = $this->CalculateAdvancePenalty($meta, $date);

            $realResult+=(($datosAP['realResult'] * $meta->getWeight())) / 100;
            $penalty+=(($datosAP['penalty'] * $meta->getWeight())) / 100;
            $plannedResult+=(($datosAP['plannedResult'] * $meta->getWeight())) / 100;
        }

        $advance = $realResult - $penalty;
        $retorno = array(
            'penalty' => $penalty,
            'realResult' => $advance,
            'plannedResult' => $plannedResult
        );

        return $retorno;
    }

}
