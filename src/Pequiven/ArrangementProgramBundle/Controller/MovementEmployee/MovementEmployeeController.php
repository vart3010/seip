<?php

namespace Pequiven\ArrangementProgramBundle\Controller\MovementEmployee;

use DateTime;
use Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram;
use Pequiven\ArrangementProgramBundle\Entity\Goal;
use Pequiven\ArrangementProgramBundle\Entity\MovementEmployee\MovementEmployee;
use Pequiven\SEIPBundle\Controller\SEIPController;
use Symfony\Component\HttpFoundation\Request;
use Pequiven\ArrangementProgramBundle\Form\MovementEmployee\AssignGoalType;
use Pequiven\ArrangementProgramBundle\Form\MovementEmployee\RemoveGoalType;

class MovementEmployeeController extends SEIPController {

    public function showAction(Request $request) {
        $id = $request->get('idGoal');

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('PequivenArrangementProgramBundle:Goal')->find($id);

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
        $formassign = $this->createForm(new AssignGoalType(), $MovementEmployee);
        $formremove = $this->createForm(new RemoveGoalType($id, $post_mortem), $MovementEmployee);

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

    public function assignAction(Request $request) {

        $id = $request->get('idGoal');

        $em = $this->getDoctrine()->getManager();
        $goal = $em->getRepository('PequivenArrangementProgramBundle:Goal')->findOneById($id);

        $securityService = $this->getSecurityService();

        //VALIDO PERMISOLOGÍA POR SI ACASO SE ACCEDE DESDE URL DIRECTA
        if ((($securityService->isGranted(array("ROLE_SEIP_ARRANGEMENT_PROGRAM_MOVEMENT_GOALS")))) || ($securityService->isGranted(array("ROLE_SEIP_ARRANGEMENT_PROGRAM_MOVEMENT_GOALS_POST_MORTEM")))) {

            $movement = new MovementEmployee();
            $formAssign = $this->createForm(new AssignGoalType(), $movement);
            $formAssign->handleRequest($request);

            $em->getConnection()->beginTransaction();

            if ($securityService->isGranted(array("ROLE_SEIP_ARRANGEMENT_PROGRAM_MOVEMENT_GOALS_POST_MORTEM"))) {
                $post_mortem = true;
            } else {
                $post_mortem = false;
            }


            if ($formAssign->isSubmitted()) {

                //DATOS DE AssignGoalType
                $cause = $request->get("AssignGoal")["cause"];
                $date = new \DateTime(str_replace("/", "-", ($request->get("AssignGoal")["date"])));
                $obs = $request->get("AssignGoal")["observations"];

                //DATOS AUDITORIA
                $login = $this->getUser();

                //DATOS DE AssignGoalType
                $id_user = ($request->get("AssignGoal")["User"]);
                $user = $em->getRepository('PequivenSEIPBundle:User')->findOneById($id_user);

                $period = $this->getPeriodService()->getPeriodActive();

                $bandera = $em->getRepository('PequivenArrangementProgramBundle:Goal')->verificationGoalUser($user, $goal, $period);

                //SI EL EMPLEADO NO SE ENCUENTRA ASIGNADO A LA META
                if ($bandera == null) {
                    //CARGO LOS DATOS EN DB
                    $movement = new MovementEmployee();
                    $movement->setCreatedBy($login);
                    $movement->setDate($date);
                    $movement->setType('I');
                    $movement->setGoal($goal);
                    $movement->setCause($cause);
                    $movement->setObservations($obs);

                    //CALCULO PENALIZACIONES Y AVANCES PARA LA FECHA
                    $datos = $this->CalculateAdvancePenalty($goal, $date);
                    $advance = $datos['realResult'] - $datos['penalty'];
                    if ($advance < 0) {
                        $advance = 0;
                    }

                    $movement->setrealAdvance($advance);
                    $movement->setPentalty($datos['penalty']);
                    $movement->setPlanned($datos['plannedResult']);
                    $movement->setTypeMov('Goal');
                    $movement->setUser($user);
                    $movement->setPeriod($period);
                    $em->persist($movement);

                    //AGREGO AL USUARIO EN LA META                
                    $goal->addResponsible($user);
                    $em->persist($goal);
                } else {

                    if ($post_mortem == false) {
                        $this->get('session')->getFlashBag()->add('error', "El Empleado ya se Encuentra Asignado a la Meta");
                    } else {
                        //CARGO LOS DATOS EN DB
                        $movement = new MovementEmployee();
                        $movement->setCreatedBy($login);
                        $movement->setDate($date);
                        $movement->setType('I');
                        $movement->setGoal($goal);
                        $movement->setCause($cause);
                        $movement->setObservations($obs);

                        //CALCULO PENALIZACIONES Y AVANCES PARA LA FECHA
                        $datos = $this->CalculateAdvancePenalty($goal, $date);
                        $advance = $datos['realResult'] - $datos['penalty'];
                        if ($advance < 0) {
                            $advance = 0;
                        }

                        $movement->setrealAdvance($advance);
                        $movement->setPentalty($datos['penalty']);
                        $movement->setPlanned($datos['plannedResult']);
                        $movement->setTypeMov('Goal');
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

        $arrangementProgram = $goal->getTimeline()->getArrangementProgram();
        $idap = $arrangementProgram->getid();
        return $this->redirect($this->generateUrl('arrangementprogram_update', array('id' => $idap)));
        //return $this->redirect($this->generateUrl('goal_movement', array('idGoal' => $id)));
    }

    public function removeAction(Request $request) {

        $id = $request->get('idGoal');

        $em = $this->getDoctrine()->getManager();
        $goal = $em->getRepository('PequivenArrangementProgramBundle:Goal')->findOneById($id);

        $securityService = $this->getSecurityService();

        //VALIDO PERMISOLOGÍA POR SI ACASO SE ACCEDE DESDE URL DIRECTA
        if ((($securityService->isGranted(array("ROLE_SEIP_ARRANGEMENT_PROGRAM_MOVEMENT_GOALS")))) || ($securityService->isGranted(array("ROLE_SEIP_ARRANGEMENT_PROGRAM_MOVEMENT_GOALS_POST_MORTEM")))) {

            if ($securityService->isGranted(array("ROLE_SEIP_ARRANGEMENT_PROGRAM_MOVEMENT_GOALS_POST_MORTEM"))) {
                $post_mortem = true;
            } else {
                $post_mortem = false;
            }

            $movement = new MovementEmployee();
            $formRemove = $this->createForm(new RemoveGoalType($id, $post_mortem), $movement);
            $formRemove->handleRequest($request);

            $em->getConnection()->beginTransaction();

            $responsibles = $goal->getresponsibles();

            if ($formRemove->isSubmitted()) {

                if (count($responsibles) <= 1) {
                    $this->get('session')->getFlashBag()->add('error', "La Meta NO Puede estar sin Responsables, Por favor Asigne un Empleado antes de Retirar");
                } else {

                    //DATOS DE RemoveGoalType
                    $cause = $request->get("RemoveGoal")["cause"];
                    $date = new \DateTime(str_replace("/", "-", ($request->get("RemoveGoal")["date"])));
                    $obs = $request->get("RemoveGoal")["observations"];

                    //DATOS AUDITORIA
                    $login = $this->getUser();

                    //DATOS DE RemoveGoalType
                    $id_user = ($request->get("RemoveGoal")["User"]);
                    $user = $em->getRepository('PequivenSEIPBundle:User')->findOneById($id_user);
                    $period = $this->getPeriodService()->getPeriodActive();

                    $bandera = $em->getRepository('PequivenArrangementProgramBundle:Goal')->verificationGoalUser($user, $goal, $period);

                    //SI EL EMPLEADO ENCUENTRA ASIGNADO A LA META
                    if ($bandera <> null) {
                        //CARGO LOS DATOS EN DB
                        $movement = new MovementEmployee();
                        $movement->setCreatedBy($login);
                        $movement->setDate($date);
                        $movement->setType('O');
                        $movement->setGoal($goal);
                        $movement->setCause($cause);
                        $movement->setObservations($obs);

                        //CALCULO PENALIZACIONES Y AVANCES PARA LA FECHA
                        $datos = $this->CalculateAdvancePenalty($goal, $date);

                        $advance = $datos['realResult'] - $datos['penalty'];
                        if ($advance < 0) {
                            $advance = 0;
                        }

                        $movement->setrealAdvance($advance);
                        $movement->setPentalty($datos['penalty']);
                        $movement->setPlanned($datos['plannedResult']);
                        $movement->setTypeMov('Goal');
                        $movement->setUser($user);
                        $movement->setPeriod($this->getPeriodService()->getPeriodActive());
                        $em->persist($movement);

                        //ELIMINO AL USUARIO EN LA META
                        $goal->removeResponsible($user);
                        $em->persist($goal);
                    } else {

                        if ($post_mortem == false) {
                            $this->get('session')->getFlashBag()->add('error', "El Empleado Seleccionado no se Encuentra Asignado a la Meta");
                        } else {
                            //CARGO LOS DATOS EN DB
                            $movement = new MovementEmployee();
                            $movement->setCreatedBy($login);
                            $movement->setDate($date);
                            $movement->setType('O');
                            $movement->setGoal($goal);
                            $movement->setCause($cause);
                            $movement->setObservations($obs);

                            //CALCULO PENALIZACIONES Y AVANCES PARA LA FECHA
                            $datos = $this->CalculateAdvancePenalty($goal, $date);

                            $advance = $datos['realResult'] - $datos['penalty'];
                            if ($advance < 0) {
                                $advance = 0;
                            }

                            $movement->setrealAdvance($advance);
                            $movement->setPentalty($datos['penalty']);
                            $movement->setPlanned($datos['plannedResult']);
                            $movement->setTypeMov('Goal');
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

        $arrangementProgram = $goal->getTimeline()->getArrangementProgram();
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

        $id = $request->get('idGoal');
        $reportService = $this->container->get('seip.service.report');
        $route = "MovementEmployee/Movimiento-en-Meta.jasper";
        $parameters = array("idGoal" => $id);
        $reportService->DownloadReportService($parameters, $route);

        return $this->redirect($this->generateUrl('goal_movement', array('idGoal' => $id)));
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
        $em = $this->getDoctrine()->getManager();

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

}
