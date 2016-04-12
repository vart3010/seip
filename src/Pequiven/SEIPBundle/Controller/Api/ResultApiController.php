<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Controller\Api;

use Pequiven\SEIPBundle\Service\ToolService;

/**
 * API de Resultados
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class ResultApiController extends \FOS\RestBundle\Controller\FOSRestController {

    const RESULT_OK = 1;
    const RESULT_NO_ITEMS = 2;
    const RESULT_NUM_PERSONAL_NOT_EXIST = 3;
    const RESULT_INVALID_CONFIGURATION = 4;

    /**
     * No tiene auditoria
     */
    const RESULT_NO_AUDIT = 5;

    private $errors;

    private function addErrorTrans($error, array $parameters = array()) {
        if (is_array($error)) {
            $this->errors = array_merge($this->errors, $error);
        } else {
            $message = $this->trans($error, $parameters, 'PequivenSEIPBundle');
            $this->errors[md5($message)] = $message;
        }
    }

    function getUserItemsAction(\Symfony\Component\HttpFoundation\Request $request) {
        $this->errors = array();
        $numPersonal = $request->get('numPersonal');
        $periodName = $request->get('period');
        $status = self::RESULT_OK;

        $criteria = $arrangementPrograms = $objetives = $goals = $arrangementProgramsForObjetives = $objetivesOO = $objetivesOT = $objetivesOE = array();

        if ($periodName === null) {
            $this->addErrorTrans('pequiven_seip.errors.you_must_specify_the_period_inquiry');
        }
        if ($numPersonal === null) {
            $this->addErrorTrans('pequiven_seip.errors.you_must_specify_number_staff_consult');
        }

        $period = $this->container->get('pequiven.repository.period')->findOneBy(array(
            'name' => $periodName,
        ));

        $user = $this->get('pequiven_seip.repository.user')->findUserByNumPersonal($numPersonal);

        if (!$user && $numPersonal != '') {
            $this->addErrorTrans('pequiven_seip.errors.the_number_staff_does_not_exist', array(
                '%numPersonal%' => $numPersonal,
            ));
            $status = self::RESULT_NUM_PERSONAL_NOT_EXIST;
        }

        if ($periodName != '' && !$period) {
            $this->addErrorTrans('pequiven_seip.errors.the_period_does_not_exist', array(
                '%period%' => $periodName
            ));
        }

        $periodActual = $period;
        $canBeEvaluated = $isValidAudit = true;
        if (count($this->errors) == 0) {
            //Repositorios
            $goalRepository = $this->container->get('pequiven_seip.repository.arrangementprogram_goal');
            $arrangementProgramRepository = $this->container->get('pequiven_seip.repository.arrangementprogram');
            $allArrangementPrograms = $arrangementProgramsObjects = $allIndicators = array();

            //Programas de gestion donde es responsable
            $arrangementProgramsGoals = $arrangementProgramRepository->findByUserAndPeriodNotGoals($user, $period, $criteria);
            foreach ($arrangementProgramsGoals as $arrangementProgramsGoal) {
                $arrangementProgramsObjects[$arrangementProgramsGoal->getId()] = $arrangementProgramsGoal;
                $allArrangementPrograms[$arrangementProgramsGoal->getId()] = $arrangementProgramsGoal;
                $arrangementProgramsForObjetives[$arrangementProgramsGoal->getId()] = $arrangementProgramsGoal;
            }

            //Metas de otros programa de gestion donde no es reponsable
            $goalsNotResponsible = $goalRepository->findGoalsByUserAndPeriod($user, $period, $criteria);
            foreach ($goalsNotResponsible as $goal) {
                $goals[$goal->getId()] = $goal;
                $arrangementProgram = $goal->getTimeline()->getArrangementProgram();
                $arrangementProgramsForObjetives[$arrangementProgram->getId()] = $arrangementProgram;
                $allArrangementPrograms[$arrangementProgram->getId()] = $arrangementProgram;
            }

            //METAS EN LAS CUALES YA NO SE ENCUENTRA ASIGNADO
            $goalsPast = $goalRepository->getDivestedIdGoalsbyUser($user->getId(), $period->getid());
            $em = $this->getDoctrine()->getManager();
            foreach ($goalsPast as $goal) {
                $goals[$goal["id_affected"]] = $em->getRepository('Pequiven\ArrangementProgramBundle\Entity\Goal')->find($goal["id_affected"]);
            }

            //PROGRAMAS EN LOS CUALES YA NO SE ENCUENTRA ASIGNADO
            $arrangementprogramPast = $arrangementProgramRepository->getDivestedIdAPbyUser($user->getId(), $period->getid());
            foreach ($arrangementprogramPast as $ap) {
                $arrangementProgramsObjects[$ap["id_affected"]] = $em->getRepository('Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram')->find($ap["id_affected"]);
            }

            ToolService::getObjetiveFromPrograms($arrangementProgramsForObjetives, $objetives);

            foreach ($arrangementProgramsObjects as $key => $arrangementProgram) {
                $period = $arrangementProgram->getPeriod();

                $summary = $arrangementProgram->getSummary();

                $planDateStart = $summary['dateStartPlanned'];
                $planDateEnd = $summary['dateEndPlanned'];

                $realDateStart = $summary['dateStartReal'];
                $realDateEnd = $summary['dateEndReal'];

                $advanceToDate = 0.0;

                foreach ($arrangementProgram->getTimeLine()->getGoals() as $goal) {
                    if ((new \DateTime()) >= ($goal->getperiod()->getDateEnd())) {
                        $fecha = 12;
                    } else {
                        $fecha = date("m");
                    }
                    $advanceToDate = $advanceToDate + $goal->getGoalDetails()->getPlannedTotal($fecha) * $goal->getWeight() / 100;
                }

                //LOCALIZO MOVIMIENTOS DE PERSONAL EN EL PROGRAMA DE GESTION
                $em = $this->getDoctrine()->getManager();
                $movements = $em->getRepository('PequivenArrangementProgramBundle:MovementEmployee\MovementEmployee')->FindMovementDetailsbyAPbyUser($arrangementProgram->getid(), $user->getid());

                $valores = array();
                $tipos = array();
                $planeado = array();
                $idarray = 0;
                $aporte = 0;
                $aportePlan = 0;

                //ALMACENO EN ARRAYS LOS VALORES DE PLAN, REAL Y TIPO
                foreach ($movements as $mov) {
                    $valores[$idarray] = $mov->getRealAdvance();
                    $realResult[$idarray] = $mov->getRealAdvance() + $mov->getPenalty();
                    $planeado[$idarray] = $mov->getplanned();
                    $tipos[$idarray] = $mov->getType();
                    $idarray++;
                }

                //SI EL PROGRAMA DE GESTION TIENE MOVIMIENTOS
                if ($tipos != null) {

                    //NO SE TOMA EN CUENTA PARA EVALUACIONES CUANDO.
                    //SI EL EMPLEADO AL FINAL SALE DEL PROGRAMA DE GESTION DE PLAN 0%
                    //SI EL EMPLEADO AL PRINCIPIO ENTRA CON UN PROGRAMA DE GESTION DE REAL 100%                    
                    if ((($tipos[count($tipos) - 1] == 'O') && ($planeado[count($tipos) - 1] == 0)) || ((reset($tipos) == 'I') && (reset($realResult) >= 100))) {
                        $eval = "N/A";
                        $aporte = 0;
                        $aportePlan = 0;
                    } else {
                        $evalI = 0;
                        $eval = 0;
                        //SI LOS MOVIMIENTOS COMIENZAN CON UNA SALIDA, SE AÑADE LA ENTRADA AL PROGRAMA DE GESTION INICIALIZADO EN CERO
                        //PORQUE EL EMPLEADO SE ENCUENTRA DESDE QUE SE CREO EL PROGRAMA
                        if ((reset($tipos) == 'O')) {
                            $status = 'Pasada';
                            array_unshift($tipos, 'I');
                            array_unshift($valores, 0);
                            array_unshift($planeado, 0);
                        } else {
                            $status = 'Actual';
                        }

                        //SI LOS MOVIMIENTOS CONCLUYEN CON UNA ENTRADA, SE AÑADE LA SALIDA DEL PROGRAMA DE GESTION CON EL VALOR ACTUAL DEL MISMO
                        //PORQUE EL EMPLEADO SE MANTUVO COMO RESPONSABLE HASTA EL FINAL DEL PERIODO
                        if (($tipos[count($tipos) - 1] == 'I')) {
                            $status = 'Actual';
                            $tipos[] = 'O';
                            $valores[] = $arrangementProgram->getUpdateResultByAdmin() ? ToolService::formatResult($arrangementProgram->getResultModified()) : ToolService::formatResult($arrangementProgram->getResultReal());
                            $planeado[] = $advanceToDate;
                        } else {
                            $status = 'Pasada';
                        }

                        //DETERMINO LA CANTIDAD DE MOVIMIENTOS EN EL PROGRAMA DE GESTION
                        $cant_mov = count($valores);
                        $noaplican = 0;

                        for ($i = 0; $i < $cant_mov; $i++) {
                            //PARA EL CALCULO DEL APORTE SE APLICA DISTANCIA ENTRE DOS PUNTOS EN UNA RECTA REAL LA FORMULA ES DESTINO MENOS ORIGEN                            
                            if ($tipos[$i] == 'I') {
                                //UNA ENTRADA ES CONSIDERADA ORIGEN
                                $aporte = $aporte - $valores[$i];
                                $aportePlan = $aportePlan - $planeado[$i];
                            }
                            if ($tipos[$i] == 'O') {
                                //UNA SALIDA ES CONSIDERADA DESTINO
                                $aporte = $aporte + $valores[$i];
                                $aportePlan = $aportePlan + $planeado[$i];
                            }

                            //SE CONTRUYEN INTERVALOS DE EVALUACIÓN YA QUE TODA SALIDA TENDRÁ SU CORRESPONDIENTE ENTRADA O VICEVERSA
                            if ($i % 2 != 0) {
                                //SI NO EXISTE UNA VARIACION EN EL PLAN DENTRO DEL INTERVALO, NO SE TOMA EN CUENTA PARA EVALUARLO
                                if ($planeado[$i] == $planeado[$i - 1]) {
                                    //SIN EMBARGO SI EXISTE UN AVANCE EN EL REAL SI SE TOMA EN CUENTA Y SE ASUME COMO EL 100% DE CUMPLIMIENTO
                                    if ($valores[$i] > $valores[$i - 1]) {
                                        $evalI = 100;
                                    } else {
                                        $evalI = 0;
                                        //SE SUMAN DOS YA QUE LOS INTERVALOS CONTIENEN DOS ELEMENTOS
                                        $noaplican = $noaplican + 2;
                                    }
                                } else {
                                    //CALCULO LA EVALUACION INDIVIDUAL POR MOVIMIENTO CON UNA ENTRADA Y UNA SALIDA. OSEA POR INTERVALO, EXTREMO MENOS ORIGEN
                                    $evalI = (100 * (($valores[$i] - $valores[$i - 1]) / ($planeado[$i] - $planeado[$i - 1])));
                                }
                            }
                            $eval = $eval + $evalI;
                        }

                        //SI LA CANTIDAD DE MOVIMIENTOS COINCIDE CON LA CANTIDAD DE ELEMENTOS QUE NO APLICAN NO SE EVALUA LA META
                        if ($cant_mov == $noaplican) {
                            $eval = "N/A";
                        } else {
                            //SE DETERMINA UN PROMEDIO SIMPLE DE LAS EVALUACIONES INDIVIDUALES POR INTERVALO, TOMANDO EN CONSIDERACIÓN LAS QUE APLIQUEN
                            $eval = $eval / (($cant_mov - $noaplican) / 2);
                            //SI LA EVALUACION SUPERA EL 120% SE REDIMENSIONA AL MAXIMO PERMITIDO.
                            if ($eval > 120) {
                                $eval = 120;
                            }
                        }

                        //SE REDIMENSIONAN LOS APORTES Y EVALUACIONES QUE DIERON RESULTADO NEGATIVO. SUCEDE CUANDO EL PROGRAMA DE GESTION
                        //ACTUALMENTE ESTA POR DEBAJO DE CUANDO ENTRO DEBIDO A LAS PENALIZACIONES
                        if (($aporte < 0) || ($eval < 0)) {
                            $aporte = 0;
                            $eval = 0;
                        }
                    }
                } else {
                    //SI EL PROGRAMA DE GESTION NO TIENE MOVIMIENTOS, LOS VALORES ACTUALES SON LOS VALORES DE LA EVALUACION
                    $status = 'Actual';
                    $aporte = $arrangementProgram->getUpdateResultByAdmin() ? ToolService::formatResult($arrangementProgram->getResultModified()) : ToolService::formatResult($arrangementProgram->getResultReal());
                    if ($advanceToDate == 0) {
                        $eval = "N/A";
                    } else {
                        $eval = ($aporte * 100) / ($advanceToDate);
                    }
                    $aportePlan = $advanceToDate;
                }

                if ($eval == "N/A") {
                    unset($arrangementPrograms[$key]);
                } else {
                    $arrangementPrograms[$key] = array(
                        'id' => sprintf('PG-%s', $arrangementProgram->getId()),
                        'ref' => $arrangementProgram->getref(),
                        'description' => $arrangementProgram->getdescription(),
                        'result' => number_format($eval, 2),
                        'dateStart' => array(
                            'plan' => $this->formatDateTime($planDateStart),
                            'real' => $this->formatDateTime($realDateStart)
                        ),
                        'dateEnd' => array(
                            'plan' => $this->formatDateTime($planDateEnd),
                            'real' => $this->formatDateTime($realDateEnd)
                        ),
                        'aporte' => $aporte,
                        'aportePlan' => $aportePlan,
                            //'eval' => $eval,
                            //'observaciones' => $movements,
                            //'tipo' => $status,
                    );
                }
            }

            $gerenciaFirst = $user->getGerencia();
            $gerenciaSecond = $user->getGerenciaSecond();

            if ($gerenciaFirst && $gerenciaFirst->isValidAudit() === false) {
                $isValidAudit = false;
                $this->addErrorTrans('pequiven_seip.errors.the_first_line_management_no_audit', array("%gerenciaFirst%" => $gerenciaFirst));
                $status = self::RESULT_NO_AUDIT;
            }
            if ($gerenciaSecond && $gerenciaSecond->isValidAudit() === false) {
                $isValidAudit = false;
                $this->addErrorTrans('pequiven_seip.errors.the_second_line_management_no_audit', array("%gerenciaSecond%" => $gerenciaSecond->getGerencia()));
                $status = self::RESULT_NO_AUDIT;
            }

            if (($user->getLevelRealByGroup() == \Pequiven\MasterBundle\Model\Rol::ROLE_MANAGER_FIRST ) || $user->getLevelRealByGroup() == \Pequiven\MasterBundle\Model\Rol::ROLE_GENERAL_COMPLEJO) {
                if ($gerenciaFirst) {
                    foreach ($gerenciaFirst->getTacticalObjectives() as $objetive) {
                        if ($objetive->getObjetiveLevel()->getLevel() == \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_TACTICO) {
                            if ($objetive->getPeriod()->getId() == $periodActual->getId()) {
                                $objetives[$objetive->getId()] = $objetive;
                            }
                        }
                    }
                } else {
                    $this->addErrorTrans('pequiven_seip.errors.the_user_is_not_assigned_first_line_management', array(
                        '%user%' => $user,
                    ));
                    $status = self::RESULT_INVALID_CONFIGURATION;
                }
            } else if ($user->getLevelRealByGroup() == \Pequiven\MasterBundle\Model\Rol::ROLE_MANAGER_SECOND) {
                if ($gerenciaSecond) {
                    foreach ($gerenciaSecond->getOperationalObjectives() as $objetive) {
                        if ($objetive->getPeriod()->getId() == $periodActual->getId()) {
                            $objetives[$objetive->getId()] = $objetive;
                        }
                    }
                } else {
                    $this->addErrorTrans('pequiven_seip.errors.the_user_is_not_assigned_second_line_management', array(
                        '%user%' => $user,
                    ));
                    $status = self::RESULT_INVALID_CONFIGURATION;
                }
            } else if ($user->getLevelRealByGroup() == \Pequiven\MasterBundle\Model\Rol::ROLE_DIRECTIVE) {
                $objetivesStrategic = $this->get('pequiven.repository.objetive')->findAllStrategicByPeriod($period);
                foreach ($objetivesStrategic as $objetive) {
                    if ($objetive->getPeriod()->getId() == $periodActual->getId()) {
                        $objetives[$objetive->getId()] = $objetive;
                    }
                }
            }

            //Recorrer todos los objetivos
            foreach ($objetives as $key => $objetive) {
                $period = $objetive->getPeriod();
                $planDateStart = $period->getDateStart();
                $planDateEnd = $period->getDateEnd();

                foreach ($objetive->getArrangementPrograms() as $arrangementProgram) {
                    $allArrangementPrograms[$arrangementProgram->getId()] = $arrangementProgram;
                }
                foreach ($objetive->getIndicators() as $indicator) {
                    $allIndicators[$indicator->getId()] = $indicator;
                }

                $data = array(
                    'id' => sprintf('OB-%s', $objetive->getId()),
                    'description' => $objetive->getDescription(),
                    'result' => $objetive->getUpdateResultByAdmin() ? $this->formatResult($objetive->getResultModified()) : $this->formatResult($objetive->getResult()),
                    'dateStart' => array(
                        'plan' => $this->formatDateTime($planDateStart),
                        'real' => $this->formatDateTime($planDateStart)
                    ),
                    'dateEnd' => array(
                        'plan' => $this->formatDateTime($planDateEnd),
                        'real' => $this->formatDateTime($planDateEnd)
                    ),
                );
                if ($objetive->getObjetiveLevel()->getLevel() == \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_OPERATIVO) {
                    if ($objetive->getgerencia() == $user->getgerencia()) {
                        $objetivesOO[$objetive->getId()] = $data;
                    }
                } else if ($objetive->getObjetiveLevel()->getLevel() == \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_TACTICO) {
                    if ($objetive->getgerencia() == $user->getgerencia()) {
                        $objetivesOT[$objetive->getId()] = $data;
                    }
                } else if ($objetive->getObjetiveLevel()->getLevel() == \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_ESTRATEGICO) {
                    if ($objetive->getgerencia() == $user->getgerencia()) {
                        $objetivesOE[$objetive->getId()] = $data;
                    }
                }
            }

            foreach ($goals as $key => $goal) {
                $goalDetails = $goal->getGoalDetails();
                $summary = $goalDetails->getSummary();

                $planDateStart = $goal->getStartDate();
                $realDateStart = clone($planDateStart);
                $realDateStart->setDate($realDateStart->format('Y'), $summary['realMonthDateStart'], 1);

                $planDateEnd = $goal->getEndDate();
                $realDateEnd = clone($planDateEnd);
                $realDateEnd->setDate($realDateEnd->format('Y'), $summary['realMonthDateEnd'], \Pequiven\SEIPBundle\Service\ToolService::getLastDayMonth($realDateEnd->format('Y'), $summary['realMonthDateEnd']));

                if ((new \DateTime()) >= ($goal->getperiod()->getDateEnd())) {
                    $fecha = 12;
                } else {
                    $fecha = date("m");
                }

                //LOCALIZO MOVIMIENTOS DE PERSONAL EN LA META
                $em = $this->getDoctrine()->getManager();
                $movements = $em->getRepository('PequivenArrangementProgramBundle:MovementEmployee\MovementEmployee')->FindMovementDetailsbyGoalbyUser($goal->getid(), $user->getid());

                $valores = array();
                $tipos = array();
                $planeado = array();
                $idarray = 0;
                $aporte = 0;
                $aportePlan = 0;

                //ALMACENO EN ARRAYS LOS VALORES DE PLAN, REAL Y TIPO
                foreach ($movements as $mov) {
                    $valores[$idarray] = $mov->getRealAdvance();
                    $planeado[$idarray] = $mov->getplanned();
                    $realResult[$idarray] = $mov->getRealAdvance() + $mov->getPenalty();
                    $tipos[$idarray] = $mov->getType();
                    $idarray++;
                }

                //SI LA META TIENE MOVIMIENTOS
                if ($tipos != null) {

                    //NO SE TOMA EN CUENTA PARA EVALUACIONES CUANDO.
                    //SI EL EMPLEADO AL FINAL SALE DE LA META DE PLAN 0%
                    //SI EL EMPLEADO AL PRINCIPIO ENTRA CON UNA META DE REAL 100%
                    if ((($tipos[count($tipos) - 1] == 'O') && ($planeado[count($tipos) - 1] == 0)) || ((reset($tipos) == 'I') && (reset($realResult) >= 100))) {
                        $eval = "N/A";
                        $aporte = 0;
                        $aportePlan = 0;
                    } else {
                        $evalI = 0;
                        $eval = 0;
                        //SI LOS MOVIMIENTOS COMIENZAN CON UNA SALIDA, SE AÑADE LA ENTRADA A LA META INICIALIZADA EN CERO
                        //PORQUE EL EMPLEADO SE ENCUENTRA DESDE QUE SE CREO EL PROGRAMA
                        if ((reset($tipos) == 'O')) {
                            $status = 'Pasada';
                            array_unshift($tipos, 'I');
                            array_unshift($valores, 0);
                            array_unshift($planeado, 0);
                        } else {
                            $status = 'Actual';
                        }

                        //SI LOS MOVIMIENTOS CONCLUYEN CON UNA ENTRADA, SE AÑADE LA SALIDA A LA META CON EL VALOR ACTUAL DE LA MISMA
                        //PORQUE EL EMPLEADO SE MANTUVO COMO RESPONSABLE HASTA EL FINAL DEL PERIODO
                        if (($tipos[count($tipos) - 1] == 'I')) {
                            $status = 'Actual';
                            $tipos[] = 'O';
                            $valores[] = $goal->getUpdateResultByAdmin() ? ToolService::formatResult($goal->getResultModified()) : ToolService::formatResult($goal->getResult());
                            $planeado[] = $goal->getGoalDetails()->getPlannedTotal($fecha);
                        } else {
                            $status = 'Pasada';
                        }

                        //DETERMINO LA CANTIDAD DE MOVIMIENTOS EN LA META
                        $cant_mov = count($valores);
                        $noaplican = 0;

                        for ($i = 0; $i < $cant_mov; $i++) {
                            //PARA EL CALCULO DEL APORTE SE APLICA DISTANCIA ENTRE DOS PUNTOS EN UNA RECTA REAL LA FORMULA ES DESTINO MENOS ORIGEN                            
                            if ($tipos[$i] == 'I') {
                                //UNA ENTRADA ES CONSIDERADA ORIGEN
                                $aporte = $aporte - $valores[$i];
                                $aportePlan = $aportePlan - $planeado[$i];
                            }
                            if ($tipos[$i] == 'O') {
                                //UNA SALIDA ES CONSIDERADA DESTINO
                                $aporte = $aporte + $valores[$i];
                                $aportePlan = $aportePlan + $planeado[$i];
                            }

                            //SE CONTRUYEN INTERVALOS DE EVALUACIÓN YA QUE TODA SALIDA TENDRÁ SU CORRESPONDIENTE ENTRADA O VICEVERSA
                            if ($i % 2 != 0) {
                                //SI NO EXISTE UNA VARIACION EN EL PLAN DENTRO DEL INTERVALO, NO SE TOMA EN CUENTA PARA EVALUARLO
                                if ($planeado[$i] == $planeado[$i - 1]) {
                                    //SIN EMBARGO SI EXISTE UN AVANCE EN EL REAL SI SE TOMA EN CUENTA Y SE ASUME COMO EL 100% DE CUMPLIMIENTO
                                    if ($valores[$i] > $valores[$i - 1]) {
                                        $evalI = 100;
                                    } else {
                                        $evalI = 0;
                                        //SE SUMAN DOS YA QUE LOS INTERVALOS CONTIENEN DOS ELEMENTOS
                                        $noaplican = $noaplican + 2;
                                    }
                                } else {
                                    //CALCULO LA EVALUACION INDIVIDUAL POR MOVIMIENTO CON UNA ENTRADA Y UNA SALIDA. OSEA POR INTERVALO, EXTREMO MENOS ORIGEN
                                    $evalI = (100 * (($valores[$i] - $valores[$i - 1]) / ($planeado[$i] - $planeado[$i - 1])));
                                }
                            }
                            $eval = $eval + $evalI;
                        }

                        //SI LA CANTIDAD DE MOVIMIENTOS COINCIDE CON LA CANTIDAD DE ELEMENTOS QUE NO APLICAN NO SE EVALUA LA META
                        if ($cant_mov == $noaplican) {
                            $eval = "N/A";
                        } else {
                            //SE DETERMINA UN PROMEDIO SIMPLE DE LAS EVALUACIONES INDIVIDUALES POR INTERVALO, TOMANDO EN CONSIDERACIÓN LAS QUE APLIQUEN
                            $eval = $eval / (($cant_mov - $noaplican) / 2);
                            //SI LA EVALUACION SUPERA EL 120% SE REDIMENSIONA AL MAXIMO PERMITIDO.
                            if ($eval > 120) {
                                $eval = 120;
                            }
                        }

                        //SE REDIMENSIONAN LOS APORTES Y EVALUACIONES QUE DIERON RESULTADO NEGATIVO. SUCEDE CUANDO LA META 
                        //ACTUALMENTE ESTA POR DEBAJO DE CUANDO ENTRO DEBIDO A LAS PENALIZACIONES
                        if (($aporte < 0) || ($eval < 0)) {
                            $aporte = 0;
                            $eval = 0;
                        }
                    }
                } else {
                    //SI LA META NO TIENE MOVIMIENTOS, LOS VALORES ACTUALES SON LOS VALORES DE LA EVALUACION
                    $status = 'Actual';
                    $aporte = $goal->getUpdateResultByAdmin() ? ToolService::formatResult($goal->getResultModified()) : ToolService::formatResult($goal->getResult());
                    if ($goal->getGoalDetails()->getPlannedTotal($fecha) == 0) {
                        $eval = "N/A";
                    } else {
                        $eval = ($aporte * 100) / ($goal->getGoalDetails()->getPlannedTotal($fecha));
                    }
                    $aportePlan = $goal->getGoalDetails()->getPlannedTotal($fecha);
                }

                if ($eval == "N/A") {
                    unset($goals[$key]);
                } else {
                    $goals[$key] = array(
                        'id' => sprintf('ME-%s', $goal->getId()),
                        'description' => $goal->getName(),
                        'result' => number_format($eval, 2),
                        'dateStart' => array(
                            'plan' => $this->formatDateTime($planDateStart),
                            'real' => $this->formatDateTime($realDateStart)
                        ),
                        'dateEnd' => array(
                            'plan' => $this->formatDateTime($planDateEnd),
                            'real' => $this->formatDateTime($realDateEnd)
                        ),
                        'aporte' => $aporte,
                        'aportePlan' => $aportePlan,
                            // 'eval' => $eval,
                            //'observaciones' => $movements,
                            //'tipo' => $status,
                    );
                }
            }
            $referenceType = \Symfony\Component\Routing\Generator\UrlGeneratorInterface::ABSOLUTE_URL;
            foreach ($allArrangementPrograms as $arrangementProgram) {
                $details = $arrangementProgram->getDetails();
                $url = $this->generateUrl('pequiven_seip_arrangementprogram_show', array(
                    'id' => $arrangementProgram->getId()
                        ), $referenceType
                );
                $link = sprintf('<a href="%s" target="_blank">%s</a>', $url, $arrangementProgram);
                //Se evalua que la notificacion no este en progeso
                if ($details->getNotificationInProgressByUser() !== null) {
                    $this->addErrorTrans('pequiven_seip.errors.user_must_complete_notification_process_management_program', array(
                        '%user%' => $details->getNotificationInProgressByUser(),
                        '%arrangementProgram%' => $link,
                    ));
                    $canBeEvaluated = false;
                    continue;
                }
                //Se evalua que no tenga avance cargado
//                if($details->getLastNotificationInProgressByUser()  === null && $arrangementProgram->getResult() == 0){
//                    $this->addErrorTrans('pequiven_seip.errors.the_management_program_does_not_progress_loaded',array(
//                        '%arrangementProgram%' => $link,
//                    ));
//                    $canBeEvaluated = false;
//                }
            }

//            Se comento para no evaluar los indicadores en cero
//            foreach ($allIndicators as $indicator) {
//                if($indicator->hasNotification() === false){
//                    $url = $this->generateUrl('pequiven_indicator_show',
//                        array(
//                            'id' => $indicator->getId()
//                        ),\Symfony\Component\Routing\Generator\UrlGeneratorInterface::ABSOLUTE_URL
//                    );
//                    $link = sprintf('<a href="%s" target="_blank">%s</a>',$url,$indicator);
//                    $this->addErrorTrans('pequiven_seip.errors.the_indicator_has_not_loaded_values',array(
//                        '%indicator%' => $link,
//                    ));
//                    $canBeEvaluated = false;
//                }
//            }

            $resultService = $this->getResultService();
            $isValidAdvance = $resultService->validateAdvanceOfObjetives($objetives);
            if (!$isValidAdvance) {
                $canBeEvaluated = $isValidAdvance;
                $this->addErrorTrans($resultService->getErrors());
            }

            //Se evalua que tenga por lo menos un item
            if (count($goals) == 0 && count($arrangementPrograms) == 0 && count($objetives) == 0) {
                $canBeEvaluated = false;
                $this->addErrorTrans('pequiven_seip.errors.user_has_no_associated_items_evaluation', array(
                    '%user%' => $user,
                ));
                $status = self::RESULT_NO_ITEMS;
            }
        }//endif if count errors

        $totalItems = count($goals) + count($arrangementPrograms) + count($objetivesOO) + count($objetivesOT) + count($objetivesOE);

        if ($totalItems == 0) {
            $canBeEvaluated = false;
            $this->addErrorTrans('pequiven_seip.errors.user_not_quantity_items', array(
                '%user%' => $user,
            ));
        }
        if (!$canBeEvaluated || count($this->errors) > 0) {
            $goals = $arrangementPrograms = $objetives = $objetivesOO = $objetivesOT = $objetivesOE = array();
        }

        $data = array(
            'data' => array(
                'user' => $user,
                'evaluation' => array(
                    'management' => array(
                        'goals' => $goals,
                        'arrangementPrograms' => $arrangementPrograms,
                    ),
                    'results' => array(
                        'objetives' => array(
                            'OO' => $objetivesOO,
                            'OT' => $objetivesOT,
                            'OE' => $objetivesOE,
                        ),
                    ),
                ),
                'quantityItems' => $totalItems,
            ),
            'status' => $status,
            'errors' => $this->errors,
            'success' => true,
        );
        if (!$canBeEvaluated || count($this->errors) > 0) {
            $data['success'] = false;
        }
        $view = $this->view($data);
        $view->getSerializationContext()->setGroups(array('api_list', 'api_result', 'sonata_api_read'));

        return $this->handleView($view);
    }

    function getItemsSaiAction(\Symfony\Component\HttpFoundation\Request $request) {

        $this->errors = array();
        $periodName = $request->get('period');
        $typeGerencia = $request->get('typeGerencia');
        $codeGerencia = $request->get('codeGerencia');

        $objetives = $objetivesOO = $objetivesOT = $objetivesOE = array();

        if ($periodName === null) {
            $this->addErrorTrans('pequiven_seip.errors.you_must_specify_the_period_inquiry');
        }
        if ($typeGerencia === null) {
            $this->addErrorTrans('pequiven_seip.errors.you_must_specify_type_gerencia');
        }
        if ($codeGerencia === null) {
            $this->addErrorTrans('pequiven_seip.errors.you_must_specify_code_gerencia');
        }

        $period = $this->container->get('pequiven.repository.period')->findOneBy(array(
            'name' => $periodName,
        ));
        if ($typeGerencia == 1) {
            $gerencia = $this->container->get('pequiven.repository.gerenciafirst')->findOneBy(array(
                'abbreviation' => $codeGerencia,
            ));
        } else {
            $gerencia = $this->container->get('pequiven.repository.gerenciasecond')->findOneBy(array(
                'abbreviation' => $codeGerencia,
            ));
        }

        $periodActual = $period;
        $totalItems = 0;

        if ($typeGerencia == 1) {
            foreach ($gerencia->getTacticalObjectives() as $objetive) {
//                if($objetive->getObjetiveLevel()->getLevel() == \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_TACTICO){
                if ($objetive->getPeriod()->getId() == $periodActual->getId()) {
                    $objetives[$objetive->getId()] = $objetive;
                }
//                }
            }
        } else {
            foreach ($gerencia->getOperationalObjectives() as $objetive) {
                if ($objetive->getPeriod()->getId() == $periodActual->getId()) {
                    $objetives[$objetive->getId()] = $objetive;
                }
            }
        }

//        $objetivesStrategic = $this->get('pequiven.repository.objetive')->findAllStrategicByPeriod($period);
//        foreach ($objetivesStrategic as $objetive) {
//            if($objetive->getPeriod()->getId() == $periodActual->getId()){
//                $objetives[$objetive->getId()] = $objetive;
//            }
//        }
        //Recorrer todos los objetivos
        foreach ($objetives as $key => $objetive) {
            $period = $objetive->getPeriod();

            $data = array(
                'ref' => sprintf('OB-%s', $objetive->getRef()),
                'description' => $objetive->getDescription(),
//                'result' => $objetive->getUpdateResultByAdmin() ? $this->formatResult($objetive->getResultModified()) : $this->formatResult($objetive->getResult()),
                'result' => $this->formatResult($objetive->getResult()),
                'level' => $objetive->getObjetiveLevel()->getDescription(),
//                'dateStart' => array(
//                    'plan' => $this->formatDateTime($planDateStart),
//                    'real' => $this->formatDateTime($planDateStart)
//                ),
//                'dateEnd' => array(
//                    'plan' => $this->formatDateTime($planDateEnd),
//                    'real' => $this->formatDateTime($planDateEnd)
//                ),
            );
            if ($objetive->getObjetiveLevel()->getLevel() == \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_OPERATIVO) {
                $objetivesOO[$objetive->getId()] = $data;
            } else if ($objetive->getObjetiveLevel()->getLevel() == \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_TACTICO) {
                $objetivesOT[$objetive->getId()] = $data;
            } else if ($objetive->getObjetiveLevel()->getLevel() == \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_ESTRATEGICO) {
                $objetivesOE[$objetive->getId()] = $data;
            }
            $totalItems++;
        }

        $data = array(
            'data' => array(
                'gerencia' => $gerencia->getDescription(),
                'performance' => array(
                    'objetives' => array(
                        'OO' => $objetivesOO,
                        'OT' => $objetivesOT,
                        'OE' => $objetivesOE,
                    ),
                ),
                'quantityItems' => $totalItems,
            ),
            'errors' => $this->errors,
            'success' => true,
        );

        $view = $this->view($data);
        $view->getSerializationContext()->setGroups(array('api_list', 'api_result', 'sonata_api_read'));

        return $this->handleView($view);
    }

    /**
     * Buscar objetivos del programa de gestion
     * @param type $arrangementPrograms
     * @param type $objetives
     */
    private function getObjetiveFromPrograms($arrangementPrograms, &$objetives) {
        foreach ($arrangementPrograms as $arrangementProgram) {
            $objetive = null;
            if ($arrangementProgram->getType() == \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_OPERATIVE) {
                $objetive = $arrangementProgram->getOperationalObjective();
            } elseif ($arrangementProgram->getType() == \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_TACTIC) {
                $objetive = $arrangementProgram->getTacticalObjective();
            }
            if ($objetive) {
                $objetives[$objetive->getId()] = $objetive;
            }
        }
    }

    /**
     * Formatea los decimales antes de enviar los resultados.
     * @param type $result
     * @return type
     */
    private function formatResult($result) {
        return number_format($result, 2);
    }

    /**
     * Formatea la fecha antes de enviarla en la api.
     * 
     * @param type $date
     * @return type
     */
    private function formatDateTime($date) {
        $r = '';
        if (is_a($date, 'DateTime')) {
            $r = $date->format('d-m-Y');
        } else {
            $r = $date;
        }
        return $r;
    }

    /**
     * Servicio de resultados
     * @return \Pequiven\SEIPBundle\Service\ResultService
     */
    private function getResultService() {
        return $this->container->get('seip.service.result');
    }

    protected function trans($id, array $parameters = array(), $domain = 'messages') {
        return $this->get('translator')->trans($id, $parameters, $domain);
    }

}
