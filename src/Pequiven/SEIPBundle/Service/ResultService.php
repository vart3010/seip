<?php

namespace Pequiven\SEIPBundle\Service;

use Pequiven\MasterBundle\Entity\Formula;
use Pequiven\IndicatorBundle\Entity\Indicator;
use Pequiven\MasterBundle\Entity\Tendency;
use Pequiven\MasterBundle\Entity\ArrangementRangeType;
use Pequiven\MasterBundle\Entity\Operator;
use Pequiven\SEIPBundle\Model\Common\CommonObject;
use Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram;
use Pequiven\ArrangementProgramBundle\Entity\Goal;

/**
 * Servicio que se encarga de actualizar los resultados
 * 
 * service seip.service.result
 * @author inhack20
 */
class ResultService implements \Symfony\Component\DependencyInjection\ContainerAwareInterface {

    protected $errors;
    protected $container;

    public function __construct() {
        $this->errors = array();
    }

    /**
     * Devuelve un resultado por el tipo
     * @param array $results Pequiven\SEIPBundle\Model\Result
     * @param int $type Pequiven\SEIPBundle\Model\Result::TYPE_RESULT_*
     * @return array
     */
    public function getResultByType($results, $type) {
        $myResult = null;
        if ($results != null) {
            foreach ($results as $result) {
                if ($result->getTypeResult() == $type) {
                    $myResult = $result;
                    break;
                }
                if ($result->getChildrens()->count() > 0) {
                    $childResult = $this->getResultByType($result->getChildrens(), $type);
                    if ($childResult != null) {
                        $myResult = $childResult;
                        break;
                    }
                }
            }
        }
        return $myResult;
    }

    /**
     * Actualiza los resultados de un objetivo
     * @param \Pequiven\SEIPBundle\Entity\Result\Result $myResult
     */
    private function updateResultOfObjetive(\Pequiven\SEIPBundle\Entity\Result\Result &$myResult, $andFlush = true) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($myResult->getResultDetails());

        $objetive = $this->resolveObjetiveOfResult($myResult);
        $results = $objetive->getResults();
        $total = 0.0;
        $countResult = 0;
        //Los resultados siempre son por promedio ponderado
        foreach ($results as $result) {
            $countResult++;
            if ($result->getChildrens()->count() > 0) {
                //Calcular el valor del resultado, a partir de los hijos
                $totalChild = 0.0;
                $countResultChild = 0;
                foreach ($result->getChildrens() as $children) {
                    $countResultChild++;
                    if ($result->getTypeCalculation() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_CALCULATION_SIMPLE_AVERAGE) {
                        $totalChild += $children->getResult();
                    } elseif ($result->getTypeCalculation() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_CALCULATION_WEIGHTED_AVERAGE) {
                        $totalChild += $children->getResultWithWeight();
                    }
                }
                if ($result->getTypeCalculation() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_CALCULATION_SIMPLE_AVERAGE) {
                    $totalChild += ($totalChild / $countResultChild);
                } elseif ($result->getTypeCalculation() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_CALCULATION_WEIGHTED_AVERAGE) {
                    //Nada que hacer
                }

                $total += ($totalChild * $result->getWeight()) / 100;
            } else {
                $total += $result->getResultWithWeight();
            }
        }

//        if($myResult->getTypeCalculation() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_CALCULATION_SIMPLE_AVERAGE){
//            $total = ($total / $countResult);
//        }elseif($myResult->getTypeCalculation() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_CALCULATION_WEIGHTED_AVERAGE){
//            //Nada que hacer
//        }

        $objetive->setResultOfObjetive($total); //Resultado del objetivo
        $objetive->updateLastDateCalculateResult();

        if ($andFlush) {
            $em->persist($objetive);
        }

        if ($objetive->getParents()->count() > 0) {//Actualizar los resultados del padre
            foreach ($objetive->getParents() as $parent) {
                $myResult = $this->getResultByType($parent->getResults(), \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_RESULT_OBJECTIVE);

                if ($myResult) {
                    $this->calculateResult($myResult);
                }
            }
        }
    }

    /**
     * Calcula los resultados
     * @param \Pequiven\SEIPBundle\Entity\Result\Result $result
     */
    public function calculateResult(\Pequiven\SEIPBundle\Entity\Result\Result &$result, $andFlush = true) {
        $em = $this->getDoctrine()->getManager();

        if ($result->getTypeResult() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_RESULT_ARRANGEMENT_PROGRAM) {
            $this->calculateResultTypeArrangementPrograms($result);
        } elseif ($result->getTypeResult() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_RESULT_INDICATOR) {
            $this->calculateResultTypeIndicator($result);
        } elseif ($result->getTypeResult() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_RESULT_OBJECTIVE) {
            $this->calculateResultTypeObjetive($result);
        }

        if ($result->getParent() !== null && $result->getTypeResult() !== \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_RESULT_OF_RESULT) {
            $parent = $result->getParent();
            foreach ($result->getChildrens() as $child) {
                $this->calculateResult($child);
            }
            $this->calculateResultItems($parent, $parent->getChildrens());

            $em->persist($parent);
        } else if ($result->getParent() == null && $result->getTypeResult() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_RESULT_OF_RESULT) {
            $parent = $result;
            foreach ($result->getChildrens() as $child) {
                $this->calculateResult($child);
            }
            $this->calculateResultItems($parent, $parent->getChildrens());
            $em->persist($parent);
        } else if ($result->getTypeResult() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_RESULT_OF_RESULT) {
            if ($result->getParent() == null) {
                $parent = $result;
            } else {
                $parent = $result->getParent();
            }
            foreach ($result->getChildrens() as $child) {
                $this->calculateResult($child);
            }
            $this->calculateResultItems($parent, $parent->getChildrens());

            $em->persist($parent);
        }

        $result->updateLastDateCalculateResult();
        $this->updateResultOfObjetive($result, $andFlush);

        if ($andFlush) {
            $em->flush();
        }
    }

    /**
     * Calcula el resultado a partir de los programas de gestion
     * 
     * @param \Pequiven\SEIPBundle\Entity\Result\Result $result
     */
    private function calculateResultTypeArrangementPrograms(\Pequiven\SEIPBundle\Entity\Result\Result &$result) {
        $objetive = $this->resolveObjetiveOfResult($result);
        $arrangementPrograms = $objetive->getArrangementPrograms();
        $countArrangementPrograms = count($arrangementPrograms);
        $total = 0.0;
        $countResult = 0;
        if ($result->getTypeCalculation() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_CALCULATION_SIMPLE_AVERAGE) {
            if ($countArrangementPrograms > 0) {
                foreach ($arrangementPrograms as $arrangementProgram) {
                    if (!$arrangementProgram->isAvailableInResult()) {
                        continue;
                    }
                    $countResult++;
                    $total += $arrangementProgram->getResult();
                }
            }
        } elseif ($result->getTypeCalculation() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_CALCULATION_WEIGHTED_AVERAGE) {
            //Fix error al configurar mal la regla del resultado en el PG
            $em = $this->getDoctrine()->getManager();
            $indicators = $objetive->getIndicators();
            foreach ($arrangementPrograms as $value) {
                $value->clearLastDateCalculateResult();
                $em->persist($value);
            }
            foreach ($indicators as $value) {
                $value->clearLastDateCalculateResult();
                $em->persist($value);
            }
            $em->flush();
            throw new \LogicException(sprintf('Los programas de gestion no se calculan con promedio ponderado, revise el resultado con id "%s"', $result->getId()));
        }

        if ($result->getTypeCalculation() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_CALCULATION_SIMPLE_AVERAGE) {
            if ($countResult == 0) {//Fix division por cero
                $countResult = 1;
            }
            $total = ($total / $countResult);
        } elseif ($result->getTypeCalculation() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_CALCULATION_WEIGHTED_AVERAGE) {
            //Nada que hacer
        }
        $periodService = $this->getPeriodService();
        $result->setTotal($total);
    }

    /**
     * Calcula los resultados a partir de los indicadores
     * 
     * @param \Pequiven\SEIPBundle\Entity\Result\Result $result
     */
    private function calculateResultTypeIndicator(\Pequiven\SEIPBundle\Entity\Result\Result &$result) {
        $objetive = $this->resolveObjetiveOfResult($result);
        $itemsResult = $objetive->getIndicators();
        $this->calculateResultItems($result, $itemsResult, true);
    }

    /**
     * Calcula los resultados a partir de los resultados de cada objetivo
     * 
     * @param \Pequiven\SEIPBundle\Entity\Result\Result $result
     */
    private function calculateResultTypeObjetive(\Pequiven\SEIPBundle\Entity\Result\Result &$result) {
        $objetive = $this->resolveObjetiveOfResult($result);
        $itemsResult = $objetive->getChildrens();
        $this->calculateResultItems($result, $itemsResult);
    }

    private function resolveObjetiveOfResult(\Pequiven\SEIPBundle\Entity\Result\Result &$result) {
        $objetive = null;
        if ($result->getParent() != null) {
            $objetive = $result->getParent()->getObjetive();
        } else {
            $objetive = $result->getObjetive();
        }
        return $objetive;
    }

    /**
     * Calcula los resultados de los items
     * 
     * @param \Pequiven\SEIPBundle\Entity\Result\Result $result
     * @param type $itemsResult
     * @param type $debug
     */
    private function calculateResultItems(\Pequiven\SEIPBundle\Entity\Result\Result &$result, $itemsResult) {
        $total = 0;
        $countResult = 0;
        if ($result->getTypeCalculation() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_CALCULATION_SIMPLE_AVERAGE) {
            foreach ($itemsResult as $item) {
                if (method_exists($item, 'getEnabled')) {
                    if ($item->getEnabled() == false) {
                        continue;
                    }
                }
                if (!$item->isAvailableInResult()) {
                    continue;
                }
                $countResult++;
                $total += $item->getResult();
            }
        } elseif ($result->getTypeCalculation() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_CALCULATION_WEIGHTED_AVERAGE) {
            foreach ($itemsResult as $item) {
                if (method_exists($item, 'getEnabled')) {
                    if ($item->getEnabled() == false) {
                        continue;
                    }
                }
                if (!$item->isAvailableInResult()) {
                    continue;
                }

                $countResult++;
                $total += $item->getResultWithWeight();
            }
        }
        if ($result->getTypeCalculation() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_CALCULATION_SIMPLE_AVERAGE) {
            //Fix division por cero
            if ($countResult == 0) {
                $countResult = 1;
            }
            $total = ($total / $countResult);
        } elseif ($result->getTypeCalculation() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_CALCULATION_WEIGHTED_AVERAGE) {
            //Nada que hacer
        }

        $result->setTotal($total);
    }

    /**
     * Actualiza los resultados de los objetivos
     * @param type $objects
     */
    public function updateResultOfObjects($objects, $andFlush = true) {
        if ($objects === null) {
            return;
        }
        if (!is_array($objects) && !is_a($objects, 'Doctrine\ORM\PersistentCollection')) {
            $objects = array($objects);
        }
        foreach ($objects as $object) {
            foreach ($object->getResults() as $result) {
                $this->calculateResult($result, $andFlush);
            }
        }
    }

    /**
     * Refresca el valor del programa de gestion
     * 
     * @param \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram $arrangementProgram
     */
    public function refreshValueArrangementProgram(ArrangementProgram $arrangementProgram, $andFlush = true) {
        $periodService = $this->getPeriodService();
        $amountPenalty = 0;
        $em = $this->getDoctrine()->getManager();


        //DETERMINO SI EL PROGRAMA SE PENALIZA POR PORCENTAJE O NO
        $lastNotificationInProgressDate = $arrangementProgram->getDetails()->getLastNotificationInProgressDate();
        if ($arrangementProgram->isCouldBePenalized() && ($periodService->isPenaltyInResult($lastNotificationInProgressDate) === true || $arrangementProgram->isForcePenalize() === true)) {
            $amountPenalty = $periodService->getPeriodActive()->getPercentagePenalty();
        }

        //RECALCULO LOS VALORES ORIGINALES DE LAS METAS SIN PENALIZAR
        $arrangementProgram->getSummary(array(
            'limitMonthToNow' => true,
            'refresh' => true,
                ), $em);

        //OBTENGO LOS VALORES DEL PROGRAMA DE GESTION SIN PENALIZAR
        $beforepenaltyAP = $arrangementProgram->getSummary(array(
            'limitMonthToNow' => true,
            'refresh' => false,
                ), $em);

        //SALVO EL VALOR DEL AP SIN PENALIZAR
        $arrangementProgram->setresultBeforepenalty($beforepenaltyAP['advances']);

        //ESTABLEZCO EL VALOR DE PENALIZACIONES EN METAS POR RETRASO Y POR PORCENTAJE (DOS PENALIZACIONES DISTINTAS)
        $this->setPenaltiesbyGoal($arrangementProgram, $amountPenalty);

        //PENALIZO LAS METAS
        $totalAP = 0;
        foreach ($arrangementProgram->getTimeline()->getGoals() as $goal) {
            $advance = $goal->getResult();
            $penalties = $goal->getPenalty() + $goal->getPercentagepenalty();
            if ((($advance - $penalties) < 0) || (($advance - $penalties) >= 120)) {
                if (($advance - $penalties) < 0) {
                    $valor = 0;
                } else {
                    $valor = 120 - $penalties;
                }
            } else {
                $valor = $advance - $penalties;
            }
            $goal->setResult($valor);
            $goal->setResultReal($valor);
            $totalAP = $totalAP + ($valor * ($goal->getWeight() / 100));

            //SALVO EL VALOR DE LA META PENALIZADA SIN RESTRICCIONES DE RANGO ES DECIR >120%
            $goal->setresultBeforepenalty($advance - $penalties);

            $em->persist($goal);

            //TRAIGO LOS MOVIMIENTOS DE LA META
            $movements = $em->getRepository('PequivenArrangementProgramBundle:MovementEmployee\MovementEmployee')->FindMovementDetailsbyGoal($goal->getId());

            //ACTUALIZO LOS MOVIMIENTOS CON LOS VALORES ACTUALIZADOS DE LA META POR FECHA DE EMISION
            if ($movements != null) {
                foreach ($movements as $mov) {
                    $datos = $this->CalculateAdvancePenalty($goal, $mov->getDate());
                    if (($datos['realResult'] - $datos['penalty']) < 0) {
                        $mov->setrealAdvance(0);
                    } else {
                        $mov->setrealAdvance($datos['realResult'] - $datos['penalty']);
                    }
                    $mov->setPentalty($datos['penalty']);
                    $mov->setPlanned($datos['plannedResult']);
                    $em->persist($mov);
                }
            }
        }

        $em->flush();

        //ACTUALIZO LOS PROGRAMAS DE GESTION. EN CASO DE SER NEGATIVO EL RESULTADO SE ESTABLECE COMO CERO. SI ES MAYOR A 120, SE ESTABLECE COMO 120
        if (($totalAP < 0) || ($totalAP >= 120)) {
            if ($totalAP < 0) {
                $arrangementProgram->setResult(0);
                $arrangementProgram->setResultReal(0);
                $arrangementProgram->setTotalAdvance(0);
            } else {
                $arrangementProgram->setResult(120);
                $arrangementProgram->setResultReal(120);
                $arrangementProgram->setTotalAdvance(120);
            }
        } else {
            $arrangementProgram->setResult($totalAP);
            $arrangementProgram->setResultReal($totalAP);
            $arrangementProgram->setTotalAdvance($totalAP);
        }

        //SALVO EL VALOR DEL PROGRAMA CUANDO ESTE SOBREPASA LOS 120% DE CUMPLIMIENTO O QUEDA COMO NEGATIVO
        $arrangementProgram->setRealResult($totalAP);

        //CALCULO Y GUARDO EL VALOR DE LA PENALIZACIÓN DEL AP
        $arrangementProgram->setPenalty($beforepenaltyAP['advances'] - $totalAP);

        //INGRESO LOS DATOS DE AUDITORIA
        $arrangementProgram->updateLastDateCalculateResult();

        $em->persist($arrangementProgram);

        $this->updateResultOfObjects($arrangementProgram->getObjetiveByType());

        //TRAIGO LOS MOVIMIENTOS DEL PROGRAMA
        $movementsAP = $em->getRepository('PequivenArrangementProgramBundle:MovementEmployee\MovementEmployee')->FindMovementDetailsbyAP($arrangementProgram->getId());

        //ACTUALIZO LOS MOVIMIENTOS CON LOS VALORES ACTUALIZADOS DE LA META POR FECHA DE EMISION
        if ($movementsAP != null) {
            foreach ($movementsAP as $mov) {
                $datos = $this->CalculateAdvancePenaltyAP($arrangementProgram, $mov->getDate());
                if (($datos['realResult'] - $datos['penalty']) < 0) {
                    $mov->setrealAdvance(0);
                } else {
                    $mov->setrealAdvance($datos['realResult'] - $datos['penalty']);
                }
                $mov->setPentalty($datos['penalty']);
                $mov->setPlanned($datos['plannedResult']);
                $em->persist($mov);
            }
        }

        $em->flush();
    }

    /* Establece Penalizaciones de Metas
     * 
     * @param Request $request
     */

    public function setPenaltiesbyGoal(ArrangementProgram $resource, $porcentaje) {

        $real = array();
        $planned = array();
        $em = $this->getDoctrine()->getManager();
        $timeline = $resource->getTimeline();

        foreach ($timeline->getGoals() as $timeline_goals) {

            //ENERO
            $sump = $timeline_goals->getGoalDetails()->getJanuaryPlanned();
            $sumr = $timeline_goals->getGoalDetails()->getJanuaryReal();
            $planned[1] = $sump;
            $real[1] = $sumr;

            //+FEBRERO
            $sump += $timeline_goals->getGoalDetails()->getFebruaryPlanned();
            $sumr += $timeline_goals->getGoalDetails()->getFebruaryReal();
            $planned[2] = $sump;
            $real[2] = $sumr;

            //+MARZO
            $sump += $timeline_goals->getGoalDetails()->getMarchPlanned();
            $sumr += $timeline_goals->getGoalDetails()->getMarchReal();
            $planned[3] = $sump;
            $real[3] = $sumr;

            //+ABRIL
            $sump += $timeline_goals->getGoalDetails()->getAprilPlanned();
            $sumr += $timeline_goals->getGoalDetails()->getAprilReal();
            $planned[4] = $sump;
            $real[4] = $sumr;

            //+MAYO
            $sump += $timeline_goals->getGoalDetails()->getMayPlanned();
            $sumr += $timeline_goals->getGoalDetails()->getMayReal();
            $planned[5] = $sump;
            $real[5] = $sumr;

            //+JUNIO
            $sump += $timeline_goals->getGoalDetails()->getJunePlanned();
            $sumr += $timeline_goals->getGoalDetails()->getJuneReal();
            $planned[6] = $sump;
            $real[6] = $sumr;

            //+JULIO
            $sump += $timeline_goals->getGoalDetails()->getJulyPlanned();
            $sumr += $timeline_goals->getGoalDetails()->getJulyReal();
            $planned[7] = $sump;
            $real[7] = $sumr;

            //+AGOSTO
            $sump += $timeline_goals->getGoalDetails()->getAugustPlanned();
            $sumr += $timeline_goals->getGoalDetails()->getAugustReal();
            $planned[8] = $sump;
            $real[8] = $sumr;

            //+SEPTIEMBRE
            $sump += $timeline_goals->getGoalDetails()->getSeptemberPlanned();
            $sumr += $timeline_goals->getGoalDetails()->getSeptemberReal();
            $planned[9] = $sump;
            $real[9] = $sumr;

            //+OCTUBRE
            $sump += $timeline_goals->getGoalDetails()->getOctoberPlanned();
            $sumr += $timeline_goals->getGoalDetails()->getOctoberReal();
            $planned[10] = $sump;
            $real[10] = $sumr;

            //+NOVIEMBRE
            $sump += $timeline_goals->getGoalDetails()->getNovemberPlanned();
            $sumr += $timeline_goals->getGoalDetails()->getNovemberReal();
            $planned[11] = $sump;
            $real[11] = $sumr;

            //+DICIEMBRE
            $sump += $timeline_goals->getGoalDetails()->getDecemberPlanned();
            $sumr += $timeline_goals->getGoalDetails()->getDecemberReal();
            $planned[12] = $sump;
            $real[12] = $sumr;


            if ((new \DateTime()) >= ($timeline_goals->getperiod()->getDateEnd())) {
                $mes = 12;
            } else {
                if ((date("n") == 1) || (date("n") == 12)) {
                    $mes = date("n");
                } else {
                    $mes = date("n") - 1;
                }
            }

            $mayor = 0;
            for ($i = 1; $i <= $mes; $i++) {
                $penal = 0;
                for ($j = $i; $j <= $mes; $j++) {
                    if ($real[$j] < $planned[$i]) {
                        $penal++;
                    } else {
                        break;
                    }
                }

                if ($penal > $mayor) {
                    $mayor = $penal;
                }

                if ($planned[$i] == 100) {
                    break;
                }
            }

            //CARGO LA PENALIZACIÓN POR INCUMPLIMIENTO Y POR PORCENTAJE (DOS PENALIZACIONES DISTINTAS)
            $timeline_goals->setPenalty($mayor);
            $timeline_goals->setpercentagepenalty($porcentaje);

            $em->persist($timeline_goals);
        }
        $em->flush();
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

    /**
     * Refresca el valor de un indicador
     * 
     * @param Indicator $indicator
     */
    public function refreshValueIndicator(\Pequiven\IndicatorBundle\Entity\Indicator $indicator, $andFlush = true) {
        $em = $this->getDoctrine()->getManager();
        $details = $indicator->getDetails();
        if (!$details) {
            $details = new \Pequiven\IndicatorBundle\Entity\Indicator\IndicatorDetails();
            $indicator->setDetails($details);
        }
        $previusValue = $indicator->getValueFinal();
        $details
                ->setPreviusValue($previusValue)
        ;
        if ($indicator->getFrequencyNotificationIndicator() === null) {
            throw new \Exception(sprintf('El indicador "%s" no tiene frecuencia de notificacion asignada. #%s', (string) $indicator, $indicator->getId()));
        }

        $indicatorService = $this->getIndicatorService();
        $arrangementRangeService = $this->getArrangementRangeService();

        $formula = $indicator->getFormula();
        if ($formula !== null && $indicatorService->validateFormula($formula) === null) {
            if ($indicator->getTypeOfCalculation() == Indicator::TYPE_CALCULATION_FORMULA_MANUALLY) {
                $this->evaluateIndicatorByFormula($indicator);
            } elseif ($indicator->getTypeOfCalculation() == Indicator::TYPE_CALCULATION_FORMULA_AUTOMATIC) {
                $this->calculateFormulaRealPlanAutomaticFromChild($indicator);
            } elseif ($indicator->getTypeOfCalculation() == Indicator::TYPE_CALCULATION_FORMULA_AUTOMATIC_FROM_EQ) {
                $this->calculateFormulaAutomaticFromEQFromChild($indicator);
            }
        }
        //Refrescando los valores de cada resultado del indicador
        foreach ($indicator->getValuesIndicator() as $valueIndicator) {
            $formulaParameters = $valueIndicator->getFormulaParameters();
            if (is_array($formulaParameters)) {
                $valueOfIndicator = $indicatorService->calculateFormulaValue($formula, $formulaParameters);
                $valueIndicator->setValueOfIndicator($valueOfIndicator);
                $em->persist($valueIndicator);
            }
        }

        $snippetPlan = $indicator->getSnippetPlan();
        $snippetReal = $indicator->getSnippetReal();

        $parametersForTemplate = array(
            'indicator' => $indicator,
        );
        if ($snippetPlan !== null) {
            $snippetPlanValue = trim($this->renderString($snippetPlan, $parametersForTemplate));
            $indicator->setTotalPlan($snippetPlanValue);
        }
        if ($snippetReal !== null) {
            $snippetRealValue = trim($this->renderString($snippetReal, $parametersForTemplate));
            $indicator->setValueFinal($snippetRealValue);
        }

        $indicator->updateLastDateCalculateResult();

        $tendenty = $indicator->getTendency();
        if (!$tendenty) {
            throw new \LogicException(sprintf('El indicador "%s(%s)" no tiene una tendencia definida.', $indicator->getRef(), $indicator->getId()));
        }
        $arrangementRange = $indicator->getArrangementRange();
        if (!$arrangementRange) {
            throw new \LogicException(sprintf('El indicador "%s(%s)" no tiene un rango de gestión definido.', $indicator->getRef(), $indicator->getId()));
        }

        //Validamos que no existe error en el rango del Indicador para que pueda ser recalculado sin problemas
        $error = $arrangementRangeService->validateArrangementRange($arrangementRange, $tendenty);
        $result = 0;
        if ($tendenty->getRef() == \Pequiven\MasterBundle\Model\Tendency::TENDENCY_MAX) {
            $result = $indicator->getResult();

            $indicator->setResultReal($result);

            if ($error == null) {
                if ($indicator->hasNotification()) {
                    if ($this->calculateRangeGood($indicator, $tendenty)) {//Rango Verde R*100% (Máximo 100)
                        $indicator->setTypeOfRangeFromResult(Indicator::RESULT_RANGE_GOOD);
//                        if ($result > 100) {
                        $result = 100;
//                        }
                    } else if ($this->calculateRangeMiddle($indicator, $tendenty)) {//Rango Medio R*50%
                        $indicator->setTypeOfRangeFromResult(Indicator::RESULT_RANGE_MIDDLE);
                        $result = $this->recalculateResultByRange($indicator, $tendenty);
                        $value = $result;
                        $varMulti = 10 * $result;
                        $varDiv = bcdiv($varMulti, 100, 2);
                        $result = bcsub($value, $varDiv, 2);
                    } else if ($this->calculateRangeBad($indicator, $tendenty)) {//Rango Rojo R*0%
                        $indicator->setTypeOfRangeFromResult(Indicator::RESULT_RANGE_BAD);
                        $result = $this->recalculateResultByRange($indicator, $tendenty);
                        $value = $result;
                        $varMulti = 20 * $result;
                        $varDiv = bcdiv($varMulti, 100, 2);
                        $result = bcsub($value, $varDiv, 2);
//                        if ($result < 0) {
//                            $result = 0;
//                        }
                    }
                } else {
                    $result = 0;
                }
            } else {
                throw new \LogicException(sprintf('El indicador "%s(%s)" %s', $indicator->getRef(), $indicator->getId(), $error));
            }
        } else if ($tendenty->getRef() == \Pequiven\MasterBundle\Model\Tendency::TENDENCY_MIN) {//Decreciente
            $result = $indicator->getResult();
//            $resultValue = $indicator->getResult();
            $indicator->setResultReal($result);
//            var_dump($result);var_dump($indicator->getId());die();

            if ($error == null) {
                if ($indicator->hasNotification()) {
                    if ($this->calculateRangeGood($indicator, $tendenty)) {//Rango Verde R*100% (Máximo 100)
                        $indicator->setTypeOfRangeFromResult(Indicator::RESULT_RANGE_GOOD);
//                        if ($result > 100) {
//                            $result = 100;
//                        }
//                        $result = 100 - $result;
//                        if ($result > 100) {
//                            $result = 100;
//                        }
                        $result = 100;
                    } else if ($this->calculateRangeMiddle($indicator, $tendenty)) {//Rango Medio R*50%
                        $indicator->setTypeOfRangeFromResult(Indicator::RESULT_RANGE_MIDDLE);
                        $result = $this->recalculateResultByRange($indicator, $tendenty);
                        $varMulti = 10 * $result;
                        $varDiv = bcdiv($varMulti, 100, 2);
                        $result = bcsub($result, $varDiv, 2);
//                        $result = $result/2;
                    } else if ($this->calculateRangeBad($indicator, $tendenty)) {//Rango Rojo R*0%
                        $indicator->setTypeOfRangeFromResult(Indicator::RESULT_RANGE_BAD);
                        $result = $this->recalculateResultByRange($indicator, $tendenty);
//                        var_dump($result);die();
                        $varMulti = 20 * $result;
                        $varDiv = bcdiv($varMulti, 100, 2);
                        $result = bcsub($result, $varDiv, 2);
                        if ($result < 0) {
                            $result = 0;
                        }
//                        $result = 0;
                    }
                } else {
                    $result = 0;
                }
            } else {
                throw new \LogicException(sprintf('El indicador "%s(%s)" %s', $indicator->getRef(), $indicator->getId(), $error));
            }
        } else if ($tendenty->getRef() == \Pequiven\MasterBundle\Model\Tendency::TENDENCY_EST) {
            $result = $indicator->getResult();
            $indicator->setResultReal($result);

            if ($error == null) {
                if ($indicator->hasNotification()) {
                    if ($this->calculateRangeGood($indicator, $tendenty)) {//Rango Verde R*100% (Máximo 100)
                        $indicator->setTypeOfRangeFromResult(Indicator::RESULT_RANGE_GOOD);
                        $result = $this->recalculateResultByRange($indicator, $tendenty);
//                        if ($result > 100) {
//                            $result = 100;
//                        }
                    } else if ($this->calculateRangeMiddle($indicator, $tendenty)) {//Rango Medio R*50%
                        $indicator->setTypeOfRangeFromResult(Indicator::RESULT_RANGE_MIDDLE);
                        $result = $this->recalculateResultByRange($indicator, $tendenty);
                        $varMulti = 10 * $result;
                        $varDiv = bcdiv($varMulti, 100, 2);
                        $result = bcsub($result, $varDiv, 2);
//                        $result = $result / 2;
                    } else if ($this->calculateRangeBad($indicator, $tendenty)) {//Rango Rojo R*0%
                        $indicator->setTypeOfRangeFromResult(Indicator::RESULT_RANGE_BAD);
                        //var_dump($indicator->getId());
                        $result = $this->recalculateResultByRange($indicator, $tendenty);
                        //var_dump($result);
                        $varMulti = 20 * $result;
                        //var_dump($varMulti);
                        $varDiv = bcdiv($varMulti, 100, 2);
                        //var_dump($varDiv);
                        $result = bcsub($result, $varDiv, 2);
                        //var_dump($result);
//                        if ($result < 0) {
//                            $result = 0;
//                        }
//                        $result = 0;
                        //die();
                    }
                } else {
                    $result = 0;
                }
            } else {
                throw new \LogicException(sprintf('El indicador "%s(%s)" esta mal configurado: "%s"', $indicator->getRef(), $indicator->getId(), $error));
            }
        }
        $periodService = $this->getPeriodService();
        $amountPenalty = 0;
        $lastNotificationAt = $indicator->getDetails()->getLastNotificationAt();
        if ($indicator->isCouldBePenalized() && ($periodService->isPenaltyInResult($lastNotificationAt) === true || $indicator->isForcePenalize() === true)) {
            $amountPenalty = $periodService->getPeriodActive()->getPercentagePenalty();
        }
        if ($result == 0) {
            $amountPenalty = 0;
        }

        $resultComplete = $result - $amountPenalty;
        $resultComplete = $resultComplete > 100 ? 100 : ($resultComplete < 0 ? 0 : $resultComplete);

//        $indicator->setResult($result - $amountPenalty);
        $indicator->setResult($resultComplete);

        $em->persist($indicator);
        $em->persist($details);
        if ($andFlush) {
            $em->flush();
        }
        $objetives = $indicator->getObjetives();

        $this->updateResultOfObjects($objetives);

//        $indicatorService->updateTagIndicator($indicator);

        if ($indicator->getParent() !== null) {
            $this->refreshValueIndicator($indicator->getParent(), true);
        }
    }

    /**
     * Evalua el resultado del indicador de acuerdo al tipo de calculo de la formula
     * @param Indicator $indicator
     */
    private function evaluateIndicatorByFormula(Indicator &$indicator) {
        $formula = $indicator->getFormula();
        $typeOfCalculation = $formula->getTypeOfCalculation();
        if ($typeOfCalculation == Formula::TYPE_CALCULATION_SIMPLE_AVERAGE) {
            $this->calculateFormulaSimpleAverage($indicator);
        } elseif ($typeOfCalculation == Formula::TYPE_CALCULATION_REAL_AND_PLAN_AUTOMATIC) {
            $this->calculateFormulaRealPlanAutomatic($indicator);
        } elseif ($typeOfCalculation == Formula::TYPE_CALCULATION_REAL_AUTOMATIC) {
            $this->calculateFormulaRealAutomatic($indicator);
        } elseif ($typeOfCalculation == Formula::TYPE_CALCULATION_ACCUMULATE) {
            $this->calculateFormulaAccumulate($indicator);
        } elseif ($typeOfCalculation == Formula::TYPE_CALCULATION_REAL_AND_PLAN_FROM_EQ) {
            $this->calculateFormulaRealPlanAutomaticFromEQ($indicator);
        }
    }

    /**
     * Función que recalcula el resultado para el rango verde
     * @param Indicator $indicator
     * @param type $result
     * @return type
     */
    public function recalculateResultByRange(Indicator &$indicator, Tendency &$tendency) {
        $arrangementRange = $indicator->getArrangementRange();
        $result = $indicator->getResult();
        $arrangementRangeTypeArray = ArrangementRangeType::getRefsSummary();

        if ($tendency->getRef() == Tendency::TENDENCY_EST) {
            $varToCatch = bcadd($arrangementRange->getRankTopMixedBottom(), $arrangementRange->getRankTopMixedTop(), 2) / 2;
            if ($varToCatch == 0) {
                $varToCatch = $varToCatch + 1;
                $result = $result + 1;
            }
            if ($result > $varToCatch) {
                $varMulti = $varToCatch * 100;
                $result = bcdiv($varMulti, $result, 2);

//                $varSum = bcadd($varToCatch, $varToCatch, 2);
//                $varResult = bcadd($result, 0, 2);
//
//                if ($varSum < $varResult) {
//                    $varMinus = bcsub($varResult, $varSum, 2);
//                } else {
//                    $varMinus = bcsub($varSum, $varResult, 2);
//                }
//
//                if ($varToCatch >= -1 && $varToCatch <= 1) {
//                    $varMulti = $varMinus;
//                    $varToCatch = 1;
//                } else {
//                    $varMulti = $varMinus * 100;
//                }
//
//                $result = bcdiv($varMulti, $varToCatch, 2);
            } else {
                //var_dump($result);
                $varMulti = $result * 100;
                $result = bcdiv($varMulti, $varToCatch, 2);
                //var_dump($result);
                //die();
                //var_dump($varMulti);
                //var_dump($result);
//                $varResult = bcadd($result, 0, 2);
//                $varMinus = bcsub($varToCatch, $varResult, 2);
//                if ($varToCatch >= -1 && $varToCatch <= 1) {
//                    $varMulti = $varMinus;
//                    $varToCatch = 1;
//                } else {
//                    $varMulti = $varMinus * 100;
//                }
//                $varDiv = bcdiv($varMulti, $varToCatch, 2);
//
//
//                $result = bcsub(100, $varDiv, 2);
            }
        } else if ($tendency->getRef() == Tendency::TENDENCY_MAX) {
            if ($arrangementRange->getTypeRangeTop() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_TOP_BASIC]) {
                $varToCatch = $arrangementRange->getRankTopBasic();
                if ($varToCatch == 0) {
                    $varToCatch = $varToCatch + 1;
                    $result = $result + 1;
                }
                $varMulti = $result * 100;
                $result = bcdiv($varMulti, $varToCatch, 2);
            } elseif ($arrangementRange->getTypeRangeTop() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_TOP_MIXED]) {
                $varToCatch = $arrangementRange->getRankTopMixedTop();
                if ($varToCatch == 0) {
                    $varToCatch = $varToCatch + 1;
                    $result = $result + 1;
                }
                $varMulti = $result * 100;
                $result = bcdiv($varMulti, $varToCatch, 2);
            }
        } elseif ($tendency->getRef() == Tendency::TENDENCY_MIN) {
            if ($arrangementRange->getTypeRangeBottom() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_BOTTOM_BASIC]) {
                $varToCatch = $arrangementRange->getRankBottomBasic();
                if ($varToCatch == 0) {
                    $varToCatch = $varToCatch + 1;
                    $result = $result + 1;
                }
                $varMulti = $varToCatch * 100;
                $result = bcdiv($varMulti, $result, 2);
            } elseif ($arrangementRange->getTypeRangeBottom() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_BOTTOM_MIXED]) {
                $varToCatch = $arrangementRange->getRankBottomMixedTop();
                if ($varToCatch == 0) {
                    $varToCatch = $varToCatch + 1;
                    $result = $result + 1;
                }
                $varMulti = $varToCatch * 100;
                $result = bcdiv($varMulti, $result, 2);
            }
        }

        return $result;
    }

    /**
     * Cálculo de Rango Verde para los Indicadores con tendencia Estable
     * @param type $result
     * @return boolean
     */
    public function calculateRangeGood(Indicator &$indicator, Tendency &$tendency, $typeResult = CommonObject::TYPE_RESULT_EVALUATION) {
        $arrangementRangeTypeArray = ArrangementRangeType::getRefsSummary();
        $arrangementRange = $indicator->getArrangementRange();
        $result = $indicator->getResult();
        if ($typeResult == CommonObject::TYPE_RESULT_ARRANGEMENT) {
            $result = $indicator->getResultReal();
        }
        $isGood = false;
        if ($tendency->getRef() == Tendency::TENDENCY_EST) {
            if (strcmp($arrangementRange->getOpRankTopMixedTop()->getRef(), Operator::REF_OPERATOR_HIGHER_THAN) == 0 && strcmp($arrangementRange->getOpRankTopMixedBottom()->getRef(), Operator::REF_OPERATOR_SMALLER_THAN) == 0) {
                if ($result > $arrangementRange->getRankTopMixedTop() && $result < $arrangementRange->getRankTopMixedBottom()) {
                    $isGood = true;
                }
            } elseif ($arrangementRange->getOpRankTopMixedTop()->getRef() == Operator::REF_OPERATOR_HIGHER_THAN && $arrangementRange->getOpRankTopMixedBottom()->getRef() == Operator::REF_OPERATOR_SMALLER_EQUAL_THAN) {
                if ($result > $arrangementRange->getRankTopMixedTop() && $result <= $arrangementRange->getRankTopMixedBottom()) {
                    $isGood = true;
                }
            } elseif ($arrangementRange->getOpRankTopMixedTop()->getRef() == Operator::REF_OPERATOR_HIGHER_EQUAL_THAN && $arrangementRange->getOpRankTopMixedBottom()->getRef() == Operator::REF_OPERATOR_SMALLER_THAN) {
                if ($result >= $arrangementRange->getRankTopMixedTop() && $result < $arrangementRange->getRankTopMixedBottom()) {
                    $isGood = true;
                }
            } elseif ($arrangementRange->getOpRankTopMixedTop()->getRef() == Operator::REF_OPERATOR_HIGHER_EQUAL_THAN && $arrangementRange->getOpRankTopMixedBottom()->getRef() == Operator::REF_OPERATOR_SMALLER_EQUAL_THAN) {
                if ($result >= $arrangementRange->getRankTopMixedTop() && $result <= $arrangementRange->getRankTopMixedBottom()) {
                    $isGood = true;
                }
            }
        } elseif ($tendency->getRef() == Tendency::TENDENCY_MAX) {
            if ($arrangementRange->getTypeRangeTop() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_TOP_BASIC]) {
                if (strcmp($arrangementRange->getOpRankTopBasic()->getRef(), Operator::REF_OPERATOR_EQUAL) == 0) {
                    if ($result == $arrangementRange->getRankTopBasic()) {
                        $isGood = true;
                    }
                } elseif (strcmp($arrangementRange->getOpRankTopBasic()->getRef(), Operator::REF_OPERATOR_HIGHER_THAN) == 0) {
                    if ($result > $arrangementRange->getRankTopBasic()) {
                        $isGood = true;
                    }
                } elseif (strcmp($arrangementRange->getOpRankTopBasic()->getRef(), Operator::REF_OPERATOR_HIGHER_EQUAL_THAN) == 0) {
                    if ($result >= $arrangementRange->getRankTopBasic()) {
                        $isGood = true;
                    }
                }
            } elseif ($arrangementRange->getTypeRangeTop() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_TOP_MIXED]) {
                if (strcmp($arrangementRange->getOpRankTopMixedTop()->getRef(), Operator::REF_OPERATOR_HIGHER_THAN) == 0 && strcmp($arrangementRange->getOpRankTopMixedBottom()->getRef(), Operator::REF_OPERATOR_SMALLER_THAN) == 0) {
                    if ($result > $arrangementRange->getRankTopMixedTop() && $result < $arrangementRange->getRankTopMixedBottom()) {
                        $isGood = true;
                    }
                } elseif ($arrangementRange->getOpRankTopMixedTop()->getRef() == Operator::REF_OPERATOR_HIGHER_THAN && $arrangementRange->getOpRankTopMixedBottom()->getRef() == Operator::REF_OPERATOR_SMALLER_EQUAL_THAN) {
                    if ($result > $arrangementRange->getRankTopMixedTop() && $result <= $arrangementRange->getRankTopMixedBottom()) {
                        $isGood = true;
                    }
                } elseif ($arrangementRange->getOpRankTopMixedTop()->getRef() == Operator::REF_OPERATOR_HIGHER_EQUAL_THAN && $arrangementRange->getOpRankTopMixedBottom()->getRef() == Operator::REF_OPERATOR_SMALLER_THAN) {
                    if ($result >= $arrangementRange->getRankTopMixedTop() && $result < $arrangementRange->getRankTopMixedBottom()) {
                        $isGood = true;
                    }
                } elseif ($arrangementRange->getOpRankTopMixedTop()->getRef() == Operator::REF_OPERATOR_HIGHER_EQUAL_THAN && $arrangementRange->getOpRankTopMixedBottom()->getRef() == Operator::REF_OPERATOR_SMALLER_EQUAL_THAN) {
                    if ($result >= $arrangementRange->getRankTopMixedTop() && $result <= $arrangementRange->getRankTopMixedBottom()) {
                        $isGood = true;
                    }
                }
            }
        } elseif ($tendency->getRef() == Tendency::TENDENCY_MIN) {
            if ($arrangementRange->getTypeRangeBottom() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_BOTTOM_BASIC]) {
                if (strcmp($arrangementRange->getOpRankBottomBasic()->getRef(), Operator::REF_OPERATOR_EQUAL) == 0) {
                    if ($result == $arrangementRange->getRankBottomBasic()) {
                        $isGood = true;
                    }
                } elseif (strcmp($arrangementRange->getOpRankBottomBasic()->getRef(), Operator::REF_OPERATOR_SMALLER_THAN) == 0) {
                    if ($result < $arrangementRange->getRankBottomBasic()) {
                        $isGood = true;
                    }
                } elseif (strcmp($arrangementRange->getOpRankBottomBasic()->getRef(), Operator::REF_OPERATOR_SMALLER_EQUAL_THAN) == 0) {
                    if ($result <= $arrangementRange->getRankBottomBasic()) {
                        $isGood = true;
                    }
                }
            } elseif ($arrangementRange->getTypeRangeBottom() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_BOTTOM_MIXED]) {
                if (strcmp($arrangementRange->getOpRankBottomMixedTop()->getRef(), Operator::REF_OPERATOR_HIGHER_THAN) == 0 && strcmp($arrangementRange->getOpRankBottomMixedBottom()->getRef(), Operator::REF_OPERATOR_SMALLER_THAN) == 0) {
                    if ($result > $arrangementRange->getRankBottomMixedTop() && $result < $arrangementRange->getRankBottomMixedBottom()) {
                        $isGood = true;
                    }
                } elseif ($arrangementRange->getOpRankBottomMixedTop()->getRef() == Operator::REF_OPERATOR_HIGHER_THAN && $arrangementRange->getOpRankBottomMixedBottom()->getRef() == Operator::REF_OPERATOR_SMALLER_EQUAL_THAN) {
                    if ($result > $arrangementRange->getRankBottomMixedTop() && $result <= $arrangementRange->getRankBottomMixedBottom()) {
                        $isGood = true;
                    }
                } elseif ($arrangementRange->getOpRankBottomMixedTop()->getRef() == Operator::REF_OPERATOR_HIGHER_EQUAL_THAN && $arrangementRange->getOpRankBottomMixedBottom()->getRef() == Operator::REF_OPERATOR_SMALLER_THAN) {
                    if ($result >= $arrangementRange->getRankBottomMixedTop() && $result < $arrangementRange->getRankBottomMixedBottom()) {
                        $isGood = true;
                    }
                } elseif ($arrangementRange->getOpRankBottomMixedTop()->getRef() == Operator::REF_OPERATOR_HIGHER_EQUAL_THAN && $arrangementRange->getOpRankBottomMixedBottom()->getRef() == Operator::REF_OPERATOR_SMALLER_EQUAL_THAN) {
                    if ($result >= $arrangementRange->getRankBottomMixedTop() && $result <= $arrangementRange->getRankBottomMixedBottom()) {
                        $isGood = true;
                    }
                }
            }
        }

        return $isGood;
    }

    /**
     * Cálculo de Rango Amarillo para los Indicadores con tendencia Estable
     * 
     * @param type $result
     * @return boolean
     */
    public function calculateRangeMiddle(Indicator &$indicator, Tendency &$tendency, $typeResult = CommonObject::TYPE_RESULT_EVALUATION) {
        $arrangementRange = $indicator->getArrangementRange();
        $arrangementRangeTypeArray = ArrangementRangeType::getRefsSummary();
        $result = $indicator->getResult();
        if ($typeResult == CommonObject::TYPE_RESULT_ARRANGEMENT) {
            $result = $indicator->getResultReal();
        }
        $isMiddle = false;

        if ($tendency->getRef() == Tendency::TENDENCY_EST) {
            if (strcmp($arrangementRange->getOpRankMiddleBottomMixedTop()->getRef(), Operator::REF_OPERATOR_HIGHER_THAN) == 0 && strcmp($arrangementRange->getOpRankMiddleBottomMixedBottom()->getRef(), Operator::REF_OPERATOR_SMALLER_THAN) == 0) {
                if ($result > $arrangementRange->getRankMiddleBottomMixedTop() && $result < $arrangementRange->getRankMiddleBottomMixedBottom()) {
                    $isMiddle = true;
                }
            } elseif (strcmp($arrangementRange->getOpRankMiddleBottomMixedTop()->getRef(), Operator::REF_OPERATOR_HIGHER_THAN) == 0 && strcmp($arrangementRange->getOpRankMiddleBottomMixedBottom()->getRef(), Operator::REF_OPERATOR_SMALLER_EQUAL_THAN) == 0) {
                if ($result > $arrangementRange->getRankMiddleBottomMixedTop() && $result <= $arrangementRange->getRankMiddleBottomMixedBottom()) {
                    $isMiddle = true;
                }
            } elseif (strcmp($arrangementRange->getOpRankMiddleBottomMixedTop()->getRef(), Operator::REF_OPERATOR_HIGHER_EQUAL_THAN) == 0 && strcmp($arrangementRange->getOpRankMiddleBottomMixedBottom()->getRef(), Operator::REF_OPERATOR_SMALLER_THAN) == 0) {
                if ($result >= $arrangementRange->getRankMiddleBottomMixedTop() && $result < $arrangementRange->getRankMiddleBottomMixedBottom()) {
                    $isMiddle = true;
                }
            } elseif (strcmp($arrangementRange->getOpRankMiddleBottomMixedTop()->getRef(), Operator::REF_OPERATOR_HIGHER_EQUAL_THAN) == 0 && strcmp($arrangementRange->getOpRankMiddleBottomMixedBottom()->getRef(), Operator::REF_OPERATOR_SMALLER_EQUAL_THAN) == 0) {
                if ($result >= $arrangementRange->getRankMiddleBottomMixedTop() && $result <= $arrangementRange->getRankMiddleBottomMixedBottom()) {
                    $isMiddle = true;
                }
            }
            if (strcmp($arrangementRange->getOpRankMiddleTopMixedTop()->getRef(), Operator::REF_OPERATOR_HIGHER_THAN) == 0 && strcmp($arrangementRange->getOpRankMiddleTopMixedBottom()->getRef(), Operator::REF_OPERATOR_SMALLER_THAN) == 0) {
                if ($result > $arrangementRange->getRankMiddleTopMixedTop() && $result < $arrangementRange->getRankMiddleTopMixedBottom()) {
                    $isMiddle = true;
                }
            } elseif (strcmp($arrangementRange->getOpRankMiddleTopMixedTop()->getRef(), Operator::REF_OPERATOR_HIGHER_THAN) == 0 && strcmp($arrangementRange->getOpRankMiddleTopMixedBottom()->getRef(), Operator::REF_OPERATOR_SMALLER_EQUAL_THAN) == 0) {
                if ($result > $arrangementRange->getRankMiddleTopMixedTop() && $result <= $arrangementRange->getRankMiddleTopMixedBottom()) {
                    $isMiddle = true;
                }
            } elseif (strcmp($arrangementRange->getOpRankMiddleTopMixedTop()->getRef(), Operator::REF_OPERATOR_HIGHER_EQUAL_THAN) == 0 && strcmp($arrangementRange->getOpRankMiddleTopMixedBottom()->getRef(), Operator::REF_OPERATOR_SMALLER_THAN) == 0) {
                if ($result >= $arrangementRange->getRankMiddleTopMixedTop() && $result < $arrangementRange->getRankMiddleTopMixedBottom()) {
                    $isMiddle = true;
                }
            } elseif (strcmp($arrangementRange->getOpRankMiddleTopMixedTop()->getRef(), Operator::REF_OPERATOR_HIGHER_EQUAL_THAN) == 0 && strcmp($arrangementRange->getOpRankMiddleTopMixedBottom()->getRef(), Operator::REF_OPERATOR_SMALLER_EQUAL_THAN) == 0) {
                if ($result >= $arrangementRange->getRankMiddleTopMixedTop() && $result <= $arrangementRange->getRankMiddleTopMixedBottom()) {
                    $isMiddle = true;
                }
            }
        } elseif ($tendency->getRef() == Tendency::TENDENCY_MAX) {
            if ($arrangementRange->getTypeRangeMiddleTop() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_MIDDLE_TOP_BASIC] || $arrangementRange->getTypeRangeMiddleBottom() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_MIDDLE_BOTTOM_BASIC]) {
                if (strcmp($arrangementRange->getOpRankMiddleTopBasic()->getRef(), Operator::REF_OPERATOR_EQUAL) == 0) {
                    if ($result == $arrangementRange->getRankMiddleTopBasic() || $result == $arrangementRange->getRankMiddleBottomBasic()) {
                        $isMiddle = true;
                    }
                } elseif (strcmp($arrangementRange->getOprankMiddleBottomBasic()->getRef(), Operator::REF_OPERATOR_HIGHER_THAN) == 0 && strcmp($arrangementRange->getOprankMiddleTopBasic()->getRef(), Operator::REF_OPERATOR_SMALLER_THAN) == 0) {
                    if ($result > $arrangementRange->getRankMiddleBottomBasic() && $result < $arrangementRange->getRankMiddleTopBasic()) {
                        $isMiddle = true;
                    }
                } elseif ($arrangementRange->getOprankMiddleBottomBasic()->getRef() == Operator::REF_OPERATOR_HIGHER_THAN && $arrangementRange->getOprankMiddleTopBasic()->getRef() == Operator::REF_OPERATOR_SMALLER_EQUAL_THAN) {
                    if ($result > $arrangementRange->getRankMiddleBottomBasic() && $result <= $arrangementRange->getRankMiddleTopBasic()) {
                        $isMiddle = true;
                    }
                } elseif ($arrangementRange->getOprankMiddleBottomBasic()->getRef() == Operator::REF_OPERATOR_HIGHER_EQUAL_THAN && $arrangementRange->getOprankMiddleTopBasic()->getRef() == Operator::REF_OPERATOR_SMALLER_THAN) {
                    if ($result >= $arrangementRange->getRankMiddleBottomBasic() && $result < $arrangementRange->getRankMiddleTopBasic()) {
                        $isMiddle = true;
                    }
                } elseif ($arrangementRange->getOprankMiddleBottomBasic()->getRef() == Operator::REF_OPERATOR_HIGHER_EQUAL_THAN && $arrangementRange->getOprankMiddleTopBasic()->getRef() == Operator::REF_OPERATOR_SMALLER_EQUAL_THAN) {
                    if ($result >= $arrangementRange->getRankMiddleBottomBasic() && $result <= $arrangementRange->getRankMiddleTopBasic()) {
                        $isMiddle = true;
                    }
                }
            } elseif ($arrangementRange->getTypeRangeMiddleTop() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_MIDDLE_TOP_MIXED] || $arrangementRange->getTypeRangeMiddleBottom() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_MIDDLE_BOTTOM_MIXED]) {
                if (strcmp($arrangementRange->getOpRankMiddleBottomMixedTop()->getRef(), Operator::REF_OPERATOR_HIGHER_THAN) == 0 && strcmp($arrangementRange->getOpRankMiddleBottomMixedBottom()->getRef(), Operator::REF_OPERATOR_SMALLER_THAN) == 0) {
                    if ($result > $arrangementRange->getRankMiddleBottomMixedTop() && $result < $arrangementRange->getRankMiddleBottomMixedBottom()) {
                        $isMiddle = true;
                    }
                } elseif (strcmp($arrangementRange->getOpRankMiddleBottomMixedTop()->getRef(), Operator::REF_OPERATOR_HIGHER_THAN) == 0 && strcmp($arrangementRange->getOpRankMiddleBottomMixedBottom()->getRef(), Operator::REF_OPERATOR_SMALLER_EQUAL_THAN) == 0) {
                    if ($result > $arrangementRange->getRankMiddleBottomMixedTop() && $result <= $arrangementRange->getRankMiddleBottomMixedBottom()) {
                        $isMiddle = true;
                    }
                } elseif (strcmp($arrangementRange->getOpRankMiddleBottomMixedTop()->getRef(), Operator::REF_OPERATOR_HIGHER_EQUAL_THAN) == 0 && strcmp($arrangementRange->getOpRankMiddleBottomMixedBottom()->getRef(), Operator::REF_OPERATOR_SMALLER_THAN) == 0) {
                    if ($result >= $arrangementRange->getRankMiddleBottomMixedTop() && $result < $arrangementRange->getRankMiddleBottomMixedBottom()) {
                        $isMiddle = true;
                    }
                } elseif (strcmp($arrangementRange->getOpRankMiddleBottomMixedTop()->getRef(), Operator::REF_OPERATOR_HIGHER_EQUAL_THAN) == 0 && strcmp($arrangementRange->getOpRankMiddleBottomMixedBottom()->getRef(), Operator::REF_OPERATOR_SMALLER_EQUAL_THAN) == 0) {
                    if ($result >= $arrangementRange->getRankMiddleBottomMixedTop() && $result <= $arrangementRange->getRankMiddleBottomMixedBottom()) {
                        $isMiddle = true;
                    }
                }
                if (strcmp($arrangementRange->getOpRankMiddleTopMixedTop()->getRef(), Operator::REF_OPERATOR_HIGHER_THAN) == 0 && strcmp($arrangementRange->getOpRankMiddleTopMixedBottom()->getRef(), Operator::REF_OPERATOR_SMALLER_THAN) == 0) {
                    if ($result > $arrangementRange->getRankMiddleTopMixedTop() && $result < $arrangementRange->getRankMiddleTopMixedBottom()) {
                        $isMiddle = true;
                    }
                } elseif (strcmp($arrangementRange->getOpRankMiddleTopMixedTop()->getRef(), Operator::REF_OPERATOR_HIGHER_THAN) == 0 && strcmp($arrangementRange->getOpRankMiddleTopMixedBottom()->getRef(), Operator::REF_OPERATOR_SMALLER_EQUAL_THAN) == 0) {
                    if ($result > $arrangementRange->getRankMiddleTopMixedTop() && $result <= $arrangementRange->getRankMiddleTopMixedBottom()) {
                        $isMiddle = true;
                    }
                } elseif (strcmp($arrangementRange->getOpRankMiddleTopMixedTop()->getRef(), Operator::REF_OPERATOR_HIGHER_EQUAL_THAN) == 0 && strcmp($arrangementRange->getOpRankMiddleTopMixedBottom()->getRef(), Operator::REF_OPERATOR_SMALLER_THAN) == 0) {
                    if ($result >= $arrangementRange->getRankMiddleTopMixedTop() && $result < $arrangementRange->getRankMiddleTopMixedBottom()) {
                        $isMiddle = true;
                    }
                } elseif (strcmp($arrangementRange->getOpRankMiddleTopMixedTop()->getRef(), Operator::REF_OPERATOR_HIGHER_EQUAL_THAN) == 0 && strcmp($arrangementRange->getOpRankMiddleTopMixedBottom()->getRef(), Operator::REF_OPERATOR_SMALLER_EQUAL_THAN) == 0) {
                    if ($result >= $arrangementRange->getRankMiddleTopMixedTop() && $result <= $arrangementRange->getRankMiddleTopMixedBottom()) {
                        $isMiddle = true;
                    }
                }
            }
        } elseif ($tendency->getRef() == Tendency::TENDENCY_MIN) {
            if ($arrangementRange->getTypeRangeMiddleTop() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_MIDDLE_TOP_BASIC] || $arrangementRange->getTypeRangeMiddleBottom() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_MIDDLE_BOTTOM_BASIC]) {
                if (strcmp($arrangementRange->getOpRankMiddleTopBasic()->getRef(), Operator::REF_OPERATOR_EQUAL) == 0) {
                    if ($result == $arrangementRange->getRankMiddleTopBasic() || $result == $arrangementRange->getRankMiddleBottomBasic()) {
                        $isMiddle = true;
                    }
                } elseif (strcmp($arrangementRange->getOprankMiddleBottomBasic()->getRef(), Operator::REF_OPERATOR_HIGHER_THAN) == 0 && strcmp($arrangementRange->getOprankMiddleTopBasic()->getRef(), Operator::REF_OPERATOR_SMALLER_THAN) == 0) {
                    if ($result > $arrangementRange->getRankMiddleBottomBasic() && $result < $arrangementRange->getRankMiddleTopBasic()) {
                        $isMiddle = true;
                    }
                } elseif ($arrangementRange->getOprankMiddleBottomBasic()->getRef() == Operator::REF_OPERATOR_HIGHER_THAN && $arrangementRange->getOprankMiddleTopBasic()->getRef() == Operator::REF_OPERATOR_SMALLER_EQUAL_THAN) {
                    if ($result > $arrangementRange->getRankMiddleBottomBasic() && $result <= $arrangementRange->getRankMiddleTopBasic()) {
                        $isMiddle = true;
                    }
                } elseif ($arrangementRange->getOprankMiddleBottomBasic()->getRef() == Operator::REF_OPERATOR_HIGHER_EQUAL_THAN && $arrangementRange->getOprankMiddleTopBasic()->getRef() == Operator::REF_OPERATOR_SMALLER_THAN) {
                    if ($result >= $arrangementRange->getRankMiddleBottomBasic() && $result < $arrangementRange->getRankMiddleTopBasic()) {
                        $isMiddle = true;
                    }
                } elseif ($arrangementRange->getOprankMiddleBottomBasic()->getRef() == Operator::REF_OPERATOR_HIGHER_EQUAL_THAN && $arrangementRange->getOprankMiddleTopBasic()->getRef() == Operator::REF_OPERATOR_SMALLER_EQUAL_THAN) {
                    if ($result >= $arrangementRange->getRankMiddleBottomBasic() && $result <= $arrangementRange->getRankMiddleTopBasic()) {
                        $isMiddle = true;
                    }
                }
            } elseif ($arrangementRange->getTypeRangeMiddleTop() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_MIDDLE_TOP_MIXED] || $arrangementRange->getTypeRangeMiddleBottom() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_MIDDLE_BOTTOM_MIXED]) {
                if (strcmp($arrangementRange->getOpRankMiddleBottomMixedTop()->getRef(), Operator::REF_OPERATOR_HIGHER_THAN) == 0 && strcmp($arrangementRange->getOpRankMiddleBottomMixedBottom()->getRef(), Operator::REF_OPERATOR_SMALLER_THAN) == 0) {
                    if ($result > $arrangementRange->getRankMiddleBottomMixedTop() && $result < $arrangementRange->getRankMiddleBottomMixedBottom()) {
                        $isMiddle = true;
                    }
                } elseif (strcmp($arrangementRange->getOpRankMiddleBottomMixedTop()->getRef(), Operator::REF_OPERATOR_HIGHER_THAN) == 0 && strcmp($arrangementRange->getOpRankMiddleBottomMixedBottom()->getRef(), Operator::REF_OPERATOR_SMALLER_EQUAL_THAN) == 0) {
                    if ($result > $arrangementRange->getRankMiddleBottomMixedTop() && $result <= $arrangementRange->getRankMiddleBottomMixedBottom()) {
                        $isMiddle = true;
                    }
                } elseif (strcmp($arrangementRange->getOpRankMiddleBottomMixedTop()->getRef(), Operator::REF_OPERATOR_HIGHER_EQUAL_THAN) == 0 && strcmp($arrangementRange->getOpRankMiddleBottomMixedBottom()->getRef(), Operator::REF_OPERATOR_SMALLER_THAN) == 0) {
                    if ($result >= $arrangementRange->getRankMiddleBottomMixedTop() && $result < $arrangementRange->getRankMiddleBottomMixedBottom()) {
                        $isMiddle = true;
                    }
                } elseif (strcmp($arrangementRange->getOpRankMiddleBottomMixedTop()->getRef(), Operator::REF_OPERATOR_HIGHER_EQUAL_THAN) == 0 && strcmp($arrangementRange->getOpRankMiddleBottomMixedBottom()->getRef(), Operator::REF_OPERATOR_SMALLER_EQUAL_THAN) == 0) {
                    if ($result >= $arrangementRange->getRankMiddleBottomMixedTop() && $result <= $arrangementRange->getRankMiddleBottomMixedBottom()) {
                        $isMiddle = true;
                    }
                }
                if (strcmp($arrangementRange->getOpRankMiddleTopMixedTop()->getRef(), Operator::REF_OPERATOR_HIGHER_THAN) == 0 && strcmp($arrangementRange->getOpRankMiddleTopMixedBottom()->getRef(), Operator::REF_OPERATOR_SMALLER_THAN) == 0) {
                    if ($result > $arrangementRange->getRankMiddleTopMixedTop() && $result < $arrangementRange->getRankMiddleTopMixedBottom()) {
                        $isMiddle = true;
                    }
                } elseif (strcmp($arrangementRange->getOpRankMiddleTopMixedTop()->getRef(), Operator::REF_OPERATOR_HIGHER_THAN) == 0 && strcmp($arrangementRange->getOpRankMiddleTopMixedBottom()->getRef(), Operator::REF_OPERATOR_SMALLER_EQUAL_THAN) == 0) {
                    if ($result > $arrangementRange->getRankMiddleTopMixedTop() && $result <= $arrangementRange->getRankMiddleTopMixedBottom()) {
                        $isMiddle = true;
                    }
                } elseif (strcmp($arrangementRange->getOpRankMiddleTopMixedTop()->getRef(), Operator::REF_OPERATOR_HIGHER_EQUAL_THAN) == 0 && strcmp($arrangementRange->getOpRankMiddleTopMixedBottom()->getRef(), Operator::REF_OPERATOR_SMALLER_THAN) == 0) {
                    if ($result >= $arrangementRange->getRankMiddleTopMixedTop() && $result < $arrangementRange->getRankMiddleTopMixedBottom()) {
                        $isMiddle = true;
                    }
                } elseif (strcmp($arrangementRange->getOpRankMiddleTopMixedTop()->getRef(), Operator::REF_OPERATOR_HIGHER_EQUAL_THAN) == 0 && strcmp($arrangementRange->getOpRankMiddleTopMixedBottom()->getRef(), Operator::REF_OPERATOR_SMALLER_EQUAL_THAN) == 0) {
                    if ($result >= $arrangementRange->getRankMiddleTopMixedTop() && $result <= $arrangementRange->getRankMiddleTopMixedBottom()) {
                        $isMiddle = true;
                    }
                }
            }
        }

        return $isMiddle;
    }

    /**
     * Cálculo de Rango Rojo para los Indicadores con tendencia Estable
     * @param type $result
     * @return boolean
     */
    public function calculateRangeBad(Indicator &$indicator, Tendency &$tendency, $typeResult = CommonObject::TYPE_RESULT_EVALUATION) {
        $arrangementRange = $indicator->getArrangementRange();
        $arrangementRangeTypeArray = ArrangementRangeType::getRefsSummary();
        $result = $indicator->getResult();
        if ($typeResult == CommonObject::TYPE_RESULT_ARRANGEMENT) {
            $result = $indicator->getResultReal();
        }
        $isBad = false;

        if ($tendency->getRef() == Tendency::TENDENCY_EST) {
            if (strcmp($arrangementRange->getOpRankBottomMixedBottom()->getRef(), Operator::REF_OPERATOR_SMALLER_THAN) == 0 && strcmp($arrangementRange->getOpRankBottomMixedTop()->getRef(), Operator::REF_OPERATOR_HIGHER_THAN) == 0) {
                if ($result < $arrangementRange->getRankBottomMixedBottom() || $result > $arrangementRange->getRankBottomMixedTop()) {
                    $isBad = true;
                }
            } elseif (strcmp($arrangementRange->getOpRankBottomMixedBottom()->getRef(), Operator::REF_OPERATOR_SMALLER_EQUAL_THAN) == 0 && strcmp($arrangementRange->getOpRankBottomMixedTop()->getRef(), Operator::REF_OPERATOR_HIGHER_THAN) == 0) {
                if ($result <= $arrangementRange->getRankBottomMixedBottom() || $result > $arrangementRange->getRankBottomMixedTop()) {
                    $isBad = true;
                }
            } elseif (strcmp($arrangementRange->getOpRankBottomMixedBottom()->getRef(), Operator::REF_OPERATOR_SMALLER_THAN) == 0 && strcmp($arrangementRange->getOpRankBottomMixedTop()->getRef(), Operator::REF_OPERATOR_HIGHER_EQUAL_THAN) == 0) {
                if ($result < $arrangementRange->getRankBottomMixedBottom() || $result > $arrangementRange->getRankBottomMixedTop()) {
                    $isBad = true;
                }
            } elseif (strcmp($arrangementRange->getOpRankBottomMixedBottom()->getRef(), Operator::REF_OPERATOR_SMALLER_EQUAL_THAN) == 0 && strcmp($arrangementRange->getOpRankBottomMixedTop()->getRef(), Operator::REF_OPERATOR_HIGHER_EQUAL_THAN) == 0) {
                if ($result <= $arrangementRange->getRankBottomMixedBottom() || $result >= $arrangementRange->getRankBottomMixedTop()) {
                    $isBad = true;
                }
            }
        } elseif ($tendency->getRef() == Tendency::TENDENCY_MAX) {
            if ($arrangementRange->getTypeRangeBottom() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_BOTTOM_BASIC]) {
                if (strcmp($arrangementRange->getOprankBottomBasic()->getRef(), Operator::REF_OPERATOR_EQUAL) == 0) {
                    if ($result == $arrangementRange->getRankBottomBasic()) {
                        $isBad = true;
                    }
                } elseif (strcmp($arrangementRange->getOprankBottomBasic()->getRef(), Operator::REF_OPERATOR_SMALLER_THAN) == 0) {
                    if ($result < $arrangementRange->getRankBottomBasic()) {
                        $isBad = true;
                    }
                } elseif (strcmp($arrangementRange->getOprankBottomBasic()->getRef(), Operator::REF_OPERATOR_SMALLER_EQUAL_THAN) == 0) {
                    if ($result <= $arrangementRange->getRankBottomBasic()) {
                        $isBad = true;
                    }
                }
            } elseif ($arrangementRange->getTypeRangeBottom() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_BOTTOM_MIXED]) {
                if (strcmp($arrangementRange->getOpRankBottomMixedTop()->getRef(), Operator::REF_OPERATOR_HIGHER_THAN) == 0 && strcmp($arrangementRange->getOpRankBottomMixedBottom()->getRef(), Operator::REF_OPERATOR_SMALLER_THAN) == 0) {
                    if ($result > $arrangementRange->getRankBottomMixedTop() && $result < $arrangementRange->getRankBottomMixedBottom()) {
                        $isBad = true;
                    }
                } elseif ($arrangementRange->getOpRankBottomMixedTop()->getRef() == Operator::REF_OPERATOR_HIGHER_THAN && $arrangementRange->getOpRankBottomMixedBottom()->getRef() == Operator::REF_OPERATOR_SMALLER_EQUAL_THAN) {
                    if ($result > $arrangementRange->getRankBottomMixedTop() && $result <= $arrangementRange->getRankBottomMixedBottom()) {
                        $isBad = true;
                    }
                } elseif ($arrangementRange->getOpRankBottomMixedTop()->getRef() == Operator::REF_OPERATOR_HIGHER_EQUAL_THAN && $arrangementRange->getOpRankBottomMixedBottom()->getRef() == Operator::REF_OPERATOR_SMALLER_THAN) {
                    if ($result >= $arrangementRange->getRankBottomMixedTop() && $result < $arrangementRange->getRankBottomMixedBottom()) {
                        $isBad = true;
                    }
                } elseif ($arrangementRange->getOpRankBottomMixedTop()->getRef() == Operator::REF_OPERATOR_HIGHER_EQUAL_THAN && $arrangementRange->getOpRankBottomMixedBottom()->getRef() == Operator::REF_OPERATOR_SMALLER_EQUAL_THAN) {
                    if ($result >= $arrangementRange->getRankBottomMixedTop() && $result <= $arrangementRange->getRankBottomMixedBottom()) {
                        $isBad = true;
                    }
                }
            }
        } elseif ($tendency->getRef() == Tendency::TENDENCY_MIN) {
            if ($arrangementRange->getTypeRangeTop() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_TOP_BASIC]) {
                if (strcmp($arrangementRange->getOpRankTopBasic()->getRef(), Operator::REF_OPERATOR_EQUAL) == 0) {
                    if ($result == $arrangementRange->getRankTopBasic()) {
                        $isBad = true;
                    }
                } elseif (strcmp($arrangementRange->getOprankTopBasic()->getRef(), Operator::REF_OPERATOR_HIGHER_THAN) == 0) {
                    if ($result > $arrangementRange->getRankTopBasic()) {
                        $isBad = true;
                    }
                } elseif (strcmp($arrangementRange->getOprankTopBasic()->getRef(), Operator::REF_OPERATOR_HIGHER_EQUAL_THAN) == 0) {
                    if ($result >= $arrangementRange->getRankTopBasic()) {
                        $isBad = true;
                    }
                }
            } elseif ($arrangementRange->getTypeRangeTop() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_TOP_MIXED]) {
                if (strcmp($arrangementRange->getOpRankTopMixedTop()->getRef(), Operator::REF_OPERATOR_HIGHER_THAN) == 0 && strcmp($arrangementRange->getOpRankTopMixedBottom()->getRef(), Operator::REF_OPERATOR_SMALLER_THAN) == 0) {
                    if ($result > $arrangementRange->getRankTopMixedTop() && $result < $arrangementRange->getRankTopMixedBottom()) {
                        $isBad = true;
                    }
                } elseif ($arrangementRange->getOpRankTopMixedTop()->getRef() == Operator::REF_OPERATOR_HIGHER_THAN && $arrangementRange->getOpRankTopMixedBottom()->getRef() == Operator::REF_OPERATOR_SMALLER_EQUAL_THAN) {
                    if ($result > $arrangementRange->getRankTopMixedTop() && $result <= $arrangementRange->getRankTopMixedBottom()) {
                        $isBad = true;
                    }
                } elseif ($arrangementRange->getOpRankTopMixedTop()->getRef() == Operator::REF_OPERATOR_HIGHER_EQUAL_THAN && $arrangementRange->getOpRankTopMixedBottom()->getRef() == Operator::REF_OPERATOR_SMALLER_THAN) {
                    if ($result >= $arrangementRange->getRankTopMixedTop() && $result < $arrangementRange->getRankTopMixedBottom()) {
                        $isBad = true;
                    }
                } elseif ($arrangementRange->getOpRankTopMixedTop()->getRef() == Operator::REF_OPERATOR_HIGHER_EQUAL_THAN && $arrangementRange->getOpRankTopMixedBottom()->getRef() == Operator::REF_OPERATOR_SMALLER_EQUAL_THAN) {
                    if ($result >= $arrangementRange->getRankTopMixedTop() && $result <= $arrangementRange->getRankTopMixedBottom()) {
                        $isBad = true;
                    }
                }
            }
        }

        return $isBad;
    }

    /**
     * Calcula la formula con promedio simple
     * 
     * @param Indicator $indicator
     */
    private function calculateFormulaSimpleAverage(\Pequiven\IndicatorBundle\Entity\Indicator &$indicator) {
        $valuesIndicator = $indicator->getValuesIndicator();
        $quantity = 0;
        $value = 0.0;
        
        $details = $indicator->getDetails();
        $formula = $indicator->getFormula();
        
        $totalVariables = count($formula->getVariables());
        foreach ($valuesIndicator as $valueIndicator) {
            if($details){
                if ($details->getSourceResult() == \Pequiven\IndicatorBundle\Model\Indicator\IndicatorDetails::SOURCE_RESULT_LAST_VALID) {
                    $contVar = 0;
                    foreach($formula->getVariables() as $variable){
                        if($valueIndicator->getParameter($variable->getName()) != 0){
                            $contVar++;
                        }
                    }
                    if($contVar == $totalVariables){
                        $quantity++;
                        $value += $valueIndicator->getValueOfIndicator();
                    }
                } else{
                    $quantity++;
                    $value += $valueIndicator->getValueOfIndicator();
                }
            }
        }
        if ($quantity == 0) {//Fix error de division por cero.
            $quantity = 1;
        }
        $value = ($value / $quantity);

        $indicator->setValueFinal($value);
        $indicator->setResult($value);
    }

    /**
     * Calcula la formula con plan y real a partir de la formula
     * 
     * @param Indicator $indicator
     */
    private function calculateFormulaRealPlanAutomatic(\Pequiven\IndicatorBundle\Entity\Indicator &$indicator) {

        $formula = $indicator->getFormula();
        $variableToPlanValueName = $formula->getVariableToPlanValue()->getName();
        $variableToRealValueName = $formula->getVariableToRealValue()->getName();

        $valuesIndicator = $indicator->getValuesIndicator();

        $details = $indicator->getDetails();
        $valuesIndicatorQuantity = count($valuesIndicator);
        $i = 0;
//        var_dump($valuesIndicatorQuantity);
//        var_dump($indicator->getId());
//        die();
        $totalPlan = $totalReal = $value = 0.0;
        $numberResultsValids = 0;
        foreach ($valuesIndicator as $valueIndicator) {
            $i++;
            $formulaParameters = $valueIndicator->getFormulaParameters();
            $plan = $formulaParameters[$variableToPlanValueName];
            $real = $formulaParameters[$variableToRealValueName];

            if ($details) {
                if ($details->getSourceResult() == \Pequiven\IndicatorBundle\Model\Indicator\IndicatorDetails::SOURCE_RESULT_LAST_VALID) {
                    if (($plan != 0 || $real != 0)) {
                        $totalPlan = $plan;
                        $totalReal = $real;
                    }
                    continue;
                } elseif ($details->getSourceResult() == \Pequiven\IndicatorBundle\Model\Indicator\IndicatorDetails::SOURCE_RESULT_LAST && $i !== $valuesIndicatorQuantity) {
                    continue;
                }
            }
            $totalPlan += $plan;
            $totalReal += $real;
            
            if($indicator->getPlanIsNotAccumulative()){
                if (($plan != 0 || $real != 0)) {
                    $numberResultsValids++;
                    $totalPlan = $plan;
                }
            }
        }
        
        if($indicator->getPlanIsNotAccumulative()){
            $totalReal = $totalReal/$numberResultsValids;
        }
        
//        die;
        $value = $totalReal;
        $indicator
                ->setTotalPlan($totalPlan)
                ->setValueFinal($value);
    }

    /**
     * Calcula la formula con plan y real a partir de la formula
     * 
     * @param Indicator $indicator
     */
    private function calculateFormulaRealPlanAutomaticFromChild(\Pequiven\IndicatorBundle\Entity\Indicator &$indicator) {
        $childrens = $indicator->getChildrens();
        $indicatorService = $this->getIndicatorService();

        $resultsItems = array();
        $formula = $indicator->getFormula();
        //Obtener los valores de los hijos
        foreach ($childrens as $child) {
            $i = 0;

            if (!$child->getIgnoredByParentResult()) {
                foreach ($child->getValuesIndicator() as $valueIndicator) {

                    $plan = $real = 0.0;
                    $formulaParameters = $valueIndicator->getFormulaParameters();

                    if ($formula->getTypeOfCalculation() == Formula::TYPE_CALCULATION_REAL_AND_PLAN_AUTOMATIC) {
                        $variableToPlanValueName = $formula->getVariableToPlanValue()->getName();
                        $variableToRealValueName = $formula->getVariableToRealValue()->getName();
                        if (!isset($resultsItems[$i])) {
                            $resultsItems[$i] = array($variableToPlanValueName => 0.0, $variableToRealValueName => 0.0);
                        }
                        if (isset($formulaParameters[$variableToPlanValueName])) {
                            $plan = $formulaParameters[$variableToPlanValueName];
                        }
                        if (isset($formulaParameters[$variableToRealValueName])) {
                            $real = $formulaParameters[$variableToRealValueName];
                        }

                        $resultsItems[$i][$variableToPlanValueName] = $resultsItems[$i][$variableToPlanValueName] + $plan;
                        $resultsItems[$i][$variableToRealValueName] = $resultsItems[$i][$variableToRealValueName] + $real;
                    } elseif ($formula->getTypeOfCalculation() == Formula::TYPE_CALCULATION_REAL_AND_PLAN_FROM_EQ) {
                        if (!isset($resultsItems[$i])) {
                            $resultsItems[$i] = array(Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_PLAN => 0.0, Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_REAL => 0.0);
                        }
                        $result = $this->getFormulaResultFromEQ($formula, $formulaParameters);
                        $plan = $result[Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_PLAN];
                        $real = $result[Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_REAL];

                        $resultsItems[$i][Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_PLAN] = $resultsItems[$i][Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_PLAN] + $plan;
                        $resultsItems[$i][Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_REAL] = $resultsItems[$i][Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_REAL] + $real;
                    }
                    $i++;
                }//fin for each
            }
        }//fin for each childrens

        $details = $indicator->getDetails();
        $valuesIndicatorQuantity = count($resultsItems);
        $i = 0;
        $totalPlan = $totalReal = 0.0;
        //Calcular el total plan y real.
        foreach ($resultsItems as $resultItem) {
            $i++;
            if ($details) {
                if ($details->getSourceResult() == \Pequiven\IndicatorBundle\Model\Indicator\IndicatorDetails::SOURCE_RESULT_LAST_VALID) {
                    if ($formula->getTypeOfCalculation() == Formula::TYPE_CALCULATION_REAL_AND_PLAN_FROM_EQ && ($resultItem[Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_PLAN] != 0 || $resultItem[Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_REAL] != 0)) {
                        $totalPlan = $resultItem[Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_PLAN];
                        $totalReal = $resultItem[Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_REAL];
                    } elseif ($formula->getTypeOfCalculation() == Formula::TYPE_CALCULATION_REAL_AND_PLAN_AUTOMATIC && ($resultItem[$formula->getVariableToPlanValue()->getName()] != 0 || $resultItem[$formula->getVariableToRealValue()->getName()] != 0)) {
                        $totalPlan = $resultItem[$formula->getVariableToPlanValue()->getName()];
                        $totalReal = $resultItem[$formula->getVariableToRealValue()->getName()];
                    }
                    continue;
                } elseif ($details->getSourceResult() == \Pequiven\IndicatorBundle\Model\Indicator\IndicatorDetails::SOURCE_RESULT_LAST && $i !== $valuesIndicatorQuantity) {
                    continue;
                }
            }

            //Para cuando la fórmula del indicador es real/plan automático
            if ($formula->getTypeOfCalculation() == Formula::TYPE_CALCULATION_REAL_AND_PLAN_AUTOMATIC) {
                $totalPlan += $resultItem[$formula->getVariableToPlanValue()->getName()];
                $totalReal += $resultItem[$formula->getVariableToRealValue()->getName()];
            } else {
                $totalPlan += $resultItem[Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_PLAN];
                $totalReal += $resultItem[Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_REAL];
            }
        }

        $frequencyNotificationIndicator = $indicator->getFrequencyNotificationIndicator();

        //Actualizar valores de los resultados del indicador padre.
        if ($formula->getTypeOfCalculation() == Formula::TYPE_CALCULATION_REAL_AND_PLAN_AUTOMATIC) {
            $variableToPlanValueName = $formula->getVariableToPlanValue()->getName();
            $variableToRealValueName = $formula->getVariableToRealValue()->getName();
        } elseif ($formula->getTypeOfCalculation() == Formula::TYPE_CALCULATION_REAL_AND_PLAN_FROM_EQ) {
            $variableToPlanValueName = Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_PLAN;
            $variableToRealValueName = Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_REAL;
        }

        //Completar la cantidad de resultados de acuerdo a la frecuencia
        $valuesIndicator = $indicator->getValuesIndicator();
        if (count($valuesIndicator) != $frequencyNotificationIndicator->getNumberResultsFrequency()) {
            $user = $this->getUser();
            $em = $this->getDoctrine()->getManager();
            foreach ($indicator->getValuesIndicator() as $valueIndicator) {
                $indicator->removeValuesIndicator($valueIndicator);
                $em->remove($valueIndicator);
            }
            $em->flush();
            for ($i = 0; $i < $frequencyNotificationIndicator->getNumberResultsFrequency(); $i++) {
                $valueIndicator = new Indicator\ValueIndicator();
                $valueIndicator
                        ->setFormula($formula)
                        ->setCreatedBy($user)
                ;
                $vars = array();
                foreach ($formula->getVariables() as $variable) {
                    $vars[$variable->getName()] = 0.0;
                }
                $valueIndicator->setFormulaParameters($vars);
                $indicator->addValuesIndicator($valueIndicator);
            }
        }
        $i = 0;
        foreach ($indicator->getValuesIndicator() as $valueIndicator) {
            $formulaUsed = $valueIndicator->getFormula();
            $formulaParameters = $valueIndicator->getFormulaParameters();
            $variableToPlanValueName = $formulaUsed->getVariableToPlanValue();
            $variableToRealValueName = $formulaUsed->getVariableToRealValue();
            $plan = $real = 0.0;

            if (isset($resultsItems[$i])) {
                if ($formula->getTypeOfCalculation() == Formula::TYPE_CALCULATION_REAL_AND_PLAN_AUTOMATIC) {
                    $plan = $resultsItems[$i][$variableToPlanValueName->getName()];
                    $real = $resultsItems[$i][$variableToRealValueName->getName()];
                } else {
                    $plan = $resultsItems[$i][Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_PLAN];
                    $real = $resultsItems[$i][Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_REAL];
                }
            }
            if ($formula->getTypeOfCalculation() == Formula::TYPE_CALCULATION_REAL_AND_PLAN_AUTOMATIC) {
                $valueIndicator->setParameter($variableToPlanValueName->getName(), $plan);
                $valueIndicator->setParameter($variableToRealValueName->getName(), $real);
            } else {
                $valueIndicator->setParameter($variableToPlanValueName, $plan);
                $valueIndicator->setParameter($variableToRealValueName, $real);
            }
            $value = $indicatorService->calculateFormulaValue($formulaUsed, $valueIndicator->getFormulaParameters());
            $valueIndicator->setValueOfIndicator($value);
            $valueIndicator->setFormula($formula);
            $i++;
        }
        $indicator
                ->setTotalPlan($totalPlan)
                ->setValueFinal($totalReal);
    }

    /**
     * Calcula el resultado del indicador automáticamente a partir de la ecuación definida en la fórmula y el valor de las variables a partir de la formula de los indicadores 
     * 
     * @param Indicator $indicator
     */
    private function calculateFormulaAutomaticFromEQFromChild(\Pequiven\IndicatorBundle\Entity\Indicator &$indicator) {
        $childrens = $indicator->getChildrens();
        $indicatorService = $this->getIndicatorService();

        $resultsItems = array();
        //Obtener los valores de los hijos
        $formula = $indicator->getFormula();
        foreach ($childrens as $child) {
            $numberResult = 0;
            foreach ($child->getValuesIndicator() as $valueIndicator) {
                if (!isset($resultsItems[$numberResult])) {
                    $resultsItems[$numberResult] = array();
                }
                $resultsItems[$numberResult][] = $valueIndicator;
                $numberResult++;
            }//fin for each
        }//fin for each childrens

        $details = $indicator->getDetails();
        $valuesIndicatorQuantity = count($resultsItems);

        $i = 0;
        $totalPlan = $totalReal = 0.0;
        $frequencyNotificationIndicator = $indicator->getFrequencyNotificationIndicator();

        //Completar la cantidad de resultados de acuerdo a la frecuencia
        $valuesIndicator = $indicator->getValuesIndicator();
        if (count($valuesIndicator) != $frequencyNotificationIndicator->getNumberResultsFrequency()) {
            $user = $this->getUser();
            $em = $this->getDoctrine()->getManager();
            foreach ($indicator->getValuesIndicator() as $valueIndicator) {
                $indicator->removeValuesIndicator($valueIndicator);
                $em->remove($valueIndicator);
            }
            $em->flush();

            for ($i = 0; $i < $frequencyNotificationIndicator->getNumberResultsFrequency(); $i++) {
                $valueIndicator = new Indicator\ValueIndicator();
                $valueIndicator
                        ->setFormula($formula)
                        ->setCreatedBy($user)
                ;
                $indicator->addValuesIndicator($valueIndicator);
            }
        }

        $variableToPlanValueName = Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_PLAN;
        $variableToRealValueName = Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_REAL;
        $i = 0;
        $calculationMethod = $indicator->getCalculationMethod();
        $formulaUsed = $indicator->getFormula();
        foreach ($indicator->getValuesIndicator() as $valueIndicator) {
            $typeOfCalculation = $formulaUsed->getTypeOfCalculation();
            if ($calculationMethod == Indicator::CALCULATION_METHOD_ACCUMULATION_OF_VARIABLES) {
                foreach ($formulaUsed->getVariables() as $variable) {
                    if (isset($resultsItems[$i]) == false) {
                        continue;
                    }
                    $nameParameter = $variable->getName();
                    $valueParameter = $valueIndicator->getParameter($nameParameter, 0);
                    $valueParameterInit = $valueParameter;
                    $results = $resultsItems[$i];
                    if ($variable->isFromEQ()) {
                        $parametersForTemplate = array(
                            'indicator' => $indicator,
                            'result_number' => ($i + 1),
                            'results' => $results,
                        );
                        $valueParameter = trim($this->renderString($variable->getEquation(), $parametersForTemplate));
                    } else {
                        if (!$variable->isStaticValue()) {
                            $valueParameter = 0;
                        }
//                        else{
//                            if($indicator->getValidVariableStaticValue()){
//                                $valueParameter = 0;
//                            }
//                        }
                        foreach ($results as $resultItem) {
                            $childValueParameter = $resultItem->getParameter($nameParameter);
                            if ($childValueParameter !== null) {
                                if ($variable->isStaticValue()) {//En caso de que la variable sea "estática" y tenga que obtener el valor del indicador hijo
                                    if (count($indicator->getChildrens()) == 1) {
                                        $valueParameter = $childValueParameter;
                                    }
//                                    else{
//                                        $valueParameter += $childValueParameter;
//                                    }
                                } else {
                                    $valueParameter += $childValueParameter;
                                }
                            }
                        }

//                        if ($variable->isStaticValue() && $indicator->getValidVariableStaticValue()) {
//                            if($valueParameterInit != $valueParameter){
//                                
//                            }
//                        }
                    }
                    $valueIndicator->setParameter($nameParameter, $valueParameter);
                }
            } else if ($calculationMethod == Indicator::CALCULATION_METHOD_AVERAGE_BASED_ON_NUMBER_CHILDREN) {
                if ($indicator->getFormula()->getTypeOfCalculation() == Formula::TYPE_CALCULATION_REAL_AND_PLAN_AUTOMATIC) {
                    $variableToRealValueName = $indicator->getFormula()->getVariableToRealValue()->getName();
                    $variableToPlanValueName = $indicator->getFormula()->getVariableToPlanValue()->getName();
                }
                if (isset($resultsItems[$i]) == false) {
                    continue;
                }
                $results = $resultsItems[$i];
                $totalRealChild = 0.0;
                $totalPlanChild = 0;
                foreach ($results as $childValueIndicator) {
                    $formulaChild = $childValueIndicator->getIndicator()->getFormula();
                    $value = $indicatorService->calculateFormulaValue($formulaChild, $childValueIndicator->getFormulaParameters());
                    $totalRealChild += $value;
                    $totalPlanChild++;
                }
                $valueIndicator->setParameter($variableToPlanValueName, $totalPlanChild);
                $valueIndicator->setParameter($variableToRealValueName, $totalRealChild);
            } else if ($calculationMethod == Indicator::CALCULATION_METHOD_AVERAGE_PLAN_REAL_CHILDREN) {
                if (isset($resultsItems[$i]) == false) {
                    continue;
                }
                $results = $resultsItems[$i];
                $totalRealChild = $totalPlanChild = 0.0;
                $totalChild = count($results);
                foreach ($results as $childValueIndicator) {
                    $formulaChild = $childValueIndicator->getIndicator()->getFormula();
                    $value = $indicatorService->calculateFormulaValue($formulaChild, $childValueIndicator->getFormulaParameters());
                    if ($formulaUsed->getTypeOfCalculation() == Formula::TYPE_CALCULATION_REAL_AND_PLAN_AUTOMATIC) {
                        $planVariableName = $formulaUsed->getVariableToPlanValue()->getName();
                        $realVariableName = $formulaUsed->getVariableToRealValue()->getName();
                    } else {
                        $planVariableName = $variableToPlanValueName;
                        $realVariableName = $variableToRealValueName;
                    }
                    if($formulaUsed->getTypeOfCalculation() == Formula::TYPE_CALCULATION_SIMPLE_AVERAGE) {
                        $variablesAverage = $formulaUsed->getVariables();
                        $realVariableName = $variablesAverage[0]->getName();
                    }
                    $valuePlan = $childValueIndicator->getParameter($planVariableName);
                    $valueReal = $childValueIndicator->getParameter($realVariableName);
                    $totalPlanChild += (float) $valuePlan;
                    $totalRealChild += (float) $valueReal;
                }

                $totalPlanAcumulated = ($totalPlanChild / $totalChild);
                $totalRealAcumulated = ($totalRealChild / $totalChild);
                if ($formulaUsed->getTypeOfCalculation() == Formula::TYPE_CALCULATION_REAL_AND_PLAN_AUTOMATIC) {
                    $planVariableName = $formulaUsed->getVariableToPlanValue()->getName();
                    $realVariableName = $formulaUsed->getVariableToRealValue()->getName();
                    $valueIndicator->setParameter($planVariableName, $totalPlanAcumulated);
                    $valueIndicator->setParameter($realVariableName, $totalRealAcumulated);
                }
                if($formulaUsed->getTypeOfCalculation() == Formula::TYPE_CALCULATION_SIMPLE_AVERAGE) {
                    $variablesAverage = $formulaUsed->getVariables();
                    $variableToRealValueName = $variablesAverage[0]->getName();
                }

                $valueIndicator->setParameter($variableToPlanValueName, $totalPlanAcumulated);
                $valueIndicator->setParameter($variableToRealValueName, $totalRealAcumulated);
            } else if ($calculationMethod == Indicator::CALCULATION_METHOD_WEIGHTED_AVERAGE_RESULT_CHILDREN) {
                if (isset($resultsItems[$i]) == false) {
                    continue;
                }
                $results = $resultsItems[$i];
                $totalRealChild = $totalPlanChild = 0.0;
                $totalChild = count($results);
                foreach ($results as $childValueIndicator) {
                    $formulaChild = $childValueIndicator->getIndicator()->getFormula();
                    $value = $indicatorService->calculateFormulaValue($formulaChild, $childValueIndicator->getFormulaParameters());
                    if ($formulaUsed->getTypeOfCalculation() == Formula::TYPE_CALCULATION_REAL_AND_PLAN_AUTOMATIC) {
                        $planVariableName = $formulaUsed->getVariableToPlanValue()->getName();
                        $realVariableName = $formulaUsed->getVariableToRealValue()->getName();
                    } else {
                        $planVariableName = $variableToPlanValueName;
                        $realVariableName = $variableToRealValueName;
                    }
                    $valuePlan = $childValueIndicator->getParameter($planVariableName);
                    $valueReal = $childValueIndicator->getParameter($realVariableName);
                    $totalPlanChild += (float) $valuePlan;
                    $totalRealChild += (float) $valueReal;
                }
                
                $totalPlanAcumulated = ($totalPlanChild / $totalChild);
                $totalRealAcumulated = ($totalRealChild / $totalChild);
                if ($formulaUsed->getTypeOfCalculation() == Formula::TYPE_CALCULATION_REAL_AND_PLAN_AUTOMATIC) {
                    $planVariableName = $formulaUsed->getVariableToPlanValue()->getName();
                    $realVariableName = $formulaUsed->getVariableToRealValue()->getName();
                    $valueIndicator->setParameter($planVariableName, $totalPlanAcumulated);
                    $valueIndicator->setParameter($realVariableName, $totalRealAcumulated);
                }



                $valueIndicator->setParameter($variableToPlanValueName, $totalPlanAcumulated);
                $valueIndicator->setParameter($variableToRealValueName, $totalRealAcumulated);
            } elseif ($calculationMethod == Indicator::CALCULATION_METHOD_OF_EQUATION_PARTIAL_VARIABLES) {
                foreach ($formulaUsed->getVariables() as $variable) {
                    //En caso de que el número del resultado no este cargado
                    if (isset($resultsItems[$i]) == false) {
                        continue;
                    }
                    $nameParameter = $variable->getName();
                    $valueParameter = $valueIndicator->getParameter($nameParameter, 0);
                    $valueParameterInit = $valueParameter;
                    $results = $resultsItems[$i];
                    
                    if ($variable->isFromEQ()) {
                        $childrensObjects = $indicator->getChildrens();
                        $children = $childrensObjects[0];
                        $parametersForTemplate = array(
                            'indicator' => $children,
                            'numValueIndicator' => ($i + 1),
                        );
                        $valueParameter = (float)trim($this->renderString($variable->getEquation(), $parametersForTemplate));
                    } else {
//                        if (!$variable->isStaticValue()) {
//                            $valueParameter = 0.0;
//                        }
//                        else{
//                            if($indicator->getValidVariableStaticValue()){
//                                $valueParameter = 0;
//                            }
//                        }
                        /*foreach ($results as $resultItem) {
                            $childValueParameter = $resultItem->getParameter($nameParameter);
                            if ($childValueParameter !== null) {
                                if ($variable->isStaticValue()) {//En caso de que la variable sea "estática" y tenga que obtener el valor del indicador hijo
                                    if (count($indicator->getChildrens()) == 1) {
                                        $valueParameter = $childValueParameter;
                                    }
//                                    else{
//                                        $valueParameter += $childValueParameter;
//                                    }
                                } else {
                                    $valueParameter += $childValueParameter;
                                }
                            }
                        }*/

//                        if ($variable->isStaticValue() && $indicator->getValidVariableStaticValue()) {
//                            if($valueParameterInit != $valueParameter){
//                                
//                            }
//                        }
                    }
                    $valueIndicator->setParameter($nameParameter, $valueParameter);
                }
                //var_dump($resultsItems[$i]);
                //die();
            }
            $i++;
            //var_dump($valueIndicator->getFormulaParameters());
            //var_dump($formulaUsed);
            $value = $indicatorService->calculateFormulaValue($formulaUsed, $valueIndicator->getFormulaParameters());
            //var_dump($value);
            //die();
            $valueIndicator->setValueOfIndicator($value);
        }
        $this->evaluateIndicatorByFormula($indicator);

        if ($calculationMethod == Indicator::CALCULATION_METHOD_WEIGHTED_AVERAGE_RESULT_CHILDREN) {
            $resultTotalChilds = 0.0;
            foreach ($childrens as $child) {
                $weight = $child->getIndicatorWeight();
//                var_dump(sprintf("(%s / 100) * %s = %s",$child->getResultReal(),$weight,($child->getResultReal() / 100) * $weight));
                $resultTotalChilds += ($child->getResultReal() / 100) * $weight;
            }
//            var_dump($resultTotalChilds);
            $indicator
                    ->setTotalPlan(100)
                    ->setValueFinal($resultTotalChilds);
        }
//        die;
    }

    /**
     * Calcula la formula con plan y real automatico a partir de equaciones de las formulas
     * 
     * @param Indicator $indicator
     */
    private function calculateFormulaRealPlanAutomaticFromEQ(\Pequiven\IndicatorBundle\Entity\Indicator &$indicator) {
        $formula = $indicator->getFormula();
        $details = $indicator->getDetails();
        $valuesIndicator = $indicator->getValuesIndicator();
        $totalPlan = $totalReal = $value = $equation_real = $equation_plan = 0.0;

        $valuesIndicatorQuantity = count($valuesIndicator);
        $i = 0;
        //var_dump($valuesIndicatorQuantity);
        foreach ($valuesIndicator as $valueIndicator) {
            $formulaParameters = $valueIndicator->getFormulaParameters();
            $resultItem = $this->getFormulaResultFromEQ($formula, $formulaParameters);
            $valueIndicator->setParameter(Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_PLAN, $resultItem[Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_PLAN]);
            $valueIndicator->setParameter(Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_REAL, $resultItem[Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_REAL]);
            $i++;
            if ($details) {
                if ($details->getSourceResult() == \Pequiven\IndicatorBundle\Model\Indicator\IndicatorDetails::SOURCE_RESULT_LAST_VALID) {
                    if (($resultItem[Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_PLAN] != 0 || $resultItem[Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_REAL] != 0)) {
                        if($indicator->getNumberValueIndicatorToForce() > 0){
                            if($i == $indicator->getNumberValueIndicatorToForce()){
                                $totalPlan = $resultItem[Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_PLAN];
                                $totalReal = $resultItem[Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_REAL];
                            }
                        } else{
                            $totalPlan = $resultItem[Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_PLAN];
                            $totalReal = $resultItem[Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_REAL];
                        }
                    }
                    continue;
                } elseif ($details->getSourceResult() == \Pequiven\IndicatorBundle\Model\Indicator\IndicatorDetails::SOURCE_RESULT_LAST && $i !== $valuesIndicatorQuantity) {

                    continue;
                }
            }

            $totalPlan += $resultItem[Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_PLAN];
            $totalReal += $resultItem[Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_REAL];
        }
        
        //var_dump($totalReal);
        //die();

        $value = $totalReal;
        $indicator
                ->setTotalPlan($totalPlan)
                ->setValueFinal($value);
    }

    /**
     * Evalua una formula y evalua el resultado cuando el tipo de calculo es a partir de ecuarcion
     * @param Formula $formula
     * @param type $formulaParameters
     * @return type
     */
    private function getFormulaResultFromEQ(Formula $formula, $formulaParameters) {
        $equation_real = $equation_plan = 0.0;
        $indicatorService = $this->getIndicatorService();
        $sourceEquationPlan = $indicatorService->parseFormulaVars($formula, $formula->getSourceEquationPlan());
        $sourceEquationReal = $indicatorService->parseFormulaVars($formula, $formula->getSourceEquationReal());
        if (!is_array($formulaParameters)) {
            $formulaParameters = array();
        }
        foreach ($formulaParameters as $name => $value) {
            $$name = 0;
            if (isset($formulaParameters[$name])) {
                $$name = $value;
            }
        }
        @eval(sprintf('$equation_real = %s;', $sourceEquationReal));
        @eval(sprintf('$equation_plan = %s;', $sourceEquationPlan));

        return array(
            Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_REAL => $equation_real,
            Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_PLAN => $equation_plan,
        );
    }

    /**
     * Calcula la formula con real a partir de la formula
     * 
     * @param Indicator $indicator
     */
    private function calculateFormulaRealAutomatic(\Pequiven\IndicatorBundle\Entity\Indicator &$indicator) {
        $formula = $indicator->getFormula();
        $variableToRealValueName = $formula->getVariableToRealValue()->getName();

        $valuesIndicator = $indicator->getValuesIndicator();

        $totalReal = $value = 0.0;
        foreach ($valuesIndicator as $valueIndicator) {
            $formulaParameters = $valueIndicator->getFormulaParameters();
            $totalReal += $formulaParameters[$variableToRealValueName];
        }

        $value = $totalReal;
        $indicator
                ->setValueFinal($value);
    }

    /**
     * Calcula la formula acumulativo de cada valor de resultado
     * 
     * @param Indicator $indicator
     */
    private function calculateFormulaAccumulate(\Pequiven\IndicatorBundle\Entity\Indicator &$indicator) {
        $valuesIndicator = $indicator->getValuesIndicator();
        $quantity = 0;
        $value = 0.0;
        foreach ($valuesIndicator as $valueIndicator) {
            $quantity++;
            $value += $valueIndicator->getValueOfIndicator();
        }
        $indicator->setValueFinal($value);
    }

    /**
     * Obtiene el resumen del resultado de mis hijos
     * @param \Pequiven\ObjetiveBundle\Entity\Objetive $objetive
     * @param type $childrens
     * @return type
     */
    public function getResultChildresObjetives(\Pequiven\ObjetiveBundle\Entity\Objetive $objetive, $childrens) {
        $myProgress = $myContribution = $myContributionWithWeight = $myDuty = $myDutyWithWeight = 0.0;
        $result = $this->getResultByType($objetive->getResults(), \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_RESULT_OBJECTIVE);
        $countMyChildrens = count($childrens);
        $countAllChildrens = count($objetive->getChildrens());
        if ($result) {
            $this->calculateResultItems($result, $childrens);
            $myProgress = $result->getResult();
            $weight = $result->getWeight();
            if ($result->getTypeCalculation() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_CALCULATION_SIMPLE_AVERAGE) {
                $myContribution = (($myProgress * $countMyChildrens) / $countAllChildrens);
                $myContributionWithWeight = ((($myProgress * $countMyChildrens) / $countAllChildrens) * $weight) / 100;
                $myDuty = (100 / $countAllChildrens) * $countMyChildrens;
                $myDutyWithWeight = ($myDuty * $weight / 100);
            } else {
                $totalWeight = 0.0;
                foreach ($childrens as $child) {
                    $totalWeight +=$child->getWeight();
                }
                $myContribution = $myProgress;
                $myContributionWithWeight = ($myProgress * $weight) / 100;
                $myDuty = $totalWeight;
                $myDutyWithWeight = ($totalWeight * $weight ) / 100;
            }
        }

        return array(
            'myProgress' => $myProgress,
            'myContribution' => $myContribution,
            'myContributionWithWeight' => $myContributionWithWeight,
            'myDuty' => $myDuty, //Mi deber
            'myDutyWithWeight' => $myDutyWithWeight, //Mi deber con peso
        );
    }

    /**
     * Valida que los objetivos tengan avances
     * @param array $objetives
     * @return boolean
     */
    public function validateAdvanceOfObjetives($objetives, $valid = true) {

        $limitErrors = 10;
        foreach ($objetives as $objetive) {
            $childrens = $objetive->getChildrens();
            $arrangementPrograms = $objetive->getArrangementPrograms();
            //Se evalua que los programas de gestion tengan notificacion.
            foreach ($arrangementPrograms as $arrangementProgram) {
                $details = $arrangementProgram->getDetails();
                $url = $this->generateUrl('pequiven_seip_arrangementprogram_show', array(
                    'id' => $arrangementProgram->getId()
                        ), \Symfony\Component\Routing\Generator\UrlGeneratorInterface::ABSOLUTE_URL
                );
                $link = sprintf('<a href="%s" target="_blank">%s</a>', $url, $arrangementProgram);
                //Se evalua que la notificacion no este en progeso
                if ($details->getNotificationInProgressByUser() !== null) {
                    $this->addErrorTrans('pequiven_seip.errors.user_must_complete_notification_process_management_program', array(
                        '%user%' => $details->getNotificationInProgressByUser(),
                        '%arrangementProgram%' => $link,
                    ));
                    $valid = false;
                    continue;
                }
                //Se evalua que no tenga avance cargado
//                if($details->getLastNotificationInProgressByUser()  === null && $arrangementProgram->getResult() == 0){
//                    $this->addErrorTrans('pequiven_seip.errors.the_management_program_does_not_progress_loaded',array(
//                        '%arrangementProgram%' => $link,
//                    ));
//                    $valid = false;
//                }
            }

//            Se comento para no evaluar los indicadores en cero
//            $indicators = $objetive->getIndicators();
//            foreach ($indicators as $indicator) {
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
//                    $valid = false;
//                }
//            }

            if (count($childrens) > 0) {
                $valid = $this->validateAdvanceOfObjetives($childrens, $valid);
            }
            if (!$valid && count($this->errors) > $limitErrors) {
                return false;
            }
        }
        return $valid;
    }

    /**
     * Retorna los valores por defecto del widget para el rango de gestión
     * @param Indicator $indicator
     * @return string
     */
    public function getDataChartWidget(Indicator $indicator) {
        $data = array();
        $data["caption"] = $indicator->hasNotification() == true ? number_format($indicator->getResultReal(), 2, ',', '.') : $this->trans('pequiven_indicator.summary.without_result', array(), 'PequivenIndicatorBundle');
        $data["captionOnTop"] = "1";
        $data["bgcolor"] = "FFFFFF";
        $data["bordercolor"] = "DCCEA1";
        $data["charttopmargin"] = "0";
        $data["chartbottommargin"] = "0";
        $data["tickmarkdistance"] = "3";
        $data["valuepadding"] = "-2";
        $data["pointerradius"] = "0";
        $data["majortmcolor"] = "000000";
        $data["majortmnumber"] = "3";
        $data["minortmnumber"] = "4";
        $data["minortmheight"] = "4";
        $data["majortmheight"] = "8";
        $data["showshadow"] = "0";
        $data["pointerbgcolor"] = "FFFFFF";
        $data["pointerbordercolor"] = "000000";
        $data["showValue"] = "0";
        $data["showTickValues"] = "0";
        $data["showTickMarks"] = "0";
        $data["gaugeborderthickness"] = "3";
        $data["basefontcolor"] = "000000";
        $data["gaugefillmix"] = "{color},{FFFFFF}";
        $data["gaugefillratio"] = "50,50";
        $data["showborder"] = "0";

        $tendency = $indicator->getTendency();
        if ($indicator->hasNotification()) {
            if ($this->calculateRangeGood($indicator, $tendency, CommonObject::TYPE_RESULT_ARRANGEMENT)) {
                $data["captionFontColor"] = "#1aaf5d";
            } elseif ($this->calculateRangeMiddle($indicator, $tendency, CommonObject::TYPE_RESULT_ARRANGEMENT)) {
                $data["captionFontColor"] = "#f2c500";
            } elseif ($this->calculateRangeBad($indicator, $tendency, CommonObject::TYPE_RESULT_ARRANGEMENT)) {
                $data["captionFontColor"] = "#c02d00";
            }
        } else {
            $data["captionFontColor"] = "#000000";
        }
        return $data;
    }

    /**
     * Evalua un valor en el rango estándar
     * @param type $value
     * @return type
     */
    public function evaluateRangeStandar($value) {
        $type = CommonObject::TYPE_RANGE_GOOD;
        $rangeTop = (float) 70;
        $rangeMiddle = (float) 40;

        if ($value < $rangeMiddle) {
            $type = CommonObject::TYPE_RANGE_BAD;
        } elseif ($value >= $rangeMiddle && $value < $rangeTop) {
            $type = CommonObject::TYPE_RANGE_MIDDLE;
        }

        return $type;
    }

    /**
     * Evalua un valor de acuerdo a los rangos de gestión de un total de items en especifico en especifico 
     * @param type $value
     * @return type
     */
    public function evaluateRangeByTotal($value, $total = 1) {
        $type = CommonObject::TYPE_RANGE_GOOD;
        $rangeTop = (float) 1;
        $rangeMiddle = (float) 2.5;

        $div = $value / $total;

        if ($div > $rangeMiddle) {
            $type = CommonObject::TYPE_RANGE_BAD;
        } elseif ($div > $rangeTop && $div < $rangeMiddle) {
            $type = CommonObject::TYPE_RANGE_MIDDLE;
        }

        return $type;
    }

//    public function getUserItems($numPersonal, $periodName) {
    public function getUserItems($idUser, $periodName) {
        $this->errors = array();
        //$numPersonal = $request->get('numPersonal');
        //$periodName = $request->get('period');
        //$status = self::RESULT_OK;
        $status = \Pequiven\SEIPBundle\Controller\Api\ResultApiController::RESULT_OK;

        $criteria = $arrangementPrograms = $objetives = $goals = $arrangementProgramsForObjetives = $objetivesOO = $objetivesOT = $objetivesOE = array();

        if ($periodName === null) {
            $this->addErrorTrans('pequiven_seip.errors.you_must_specify_the_period_inquiry');
        }

//        if ($numPersonal === null) {
//            $this->addErrorTrans('pequiven_seip.errors.you_must_specify_number_staff_consult');
//        }

        $period = $this->container->get('pequiven.repository.period')->findOneBy(array(
            'name' => $periodName,
        ));

//        $user = $this->container->get('pequiven_seip.repository.user')->findUserByNumPersonal($numPersonal);
        $user = $this->container->get('pequiven_seip.repository.user')->find($idUser);

//        if (!$user && $numPersonal != '') {
//            $this->addErrorTrans('pequiven_seip.errors.the_number_staff_does_not_exist', array(
//                '%numPersonal%' => $numPersonal,
//            ));
//            $status = \Pequiven\SEIPBundle\Controller\Api\ResultApiController::RESULT_NUM_PERSONAL_NOT_EXIST;
//        }

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
            $goalsPast = $goalRepository->getDivestedIdGoalsbyUser($idUser, $period->getid());
            $em = $this->getDoctrine()->getManager();
            foreach ($goalsPast as $goal) {
                $goals[$goal["id_affected"]] = $em->getRepository('Pequiven\ArrangementProgramBundle\Entity\Goal')->find($goal["id_affected"]);
            }

            //PROGRAMAS EN LOS CUALES YA NO SE ENCUENTRA ASIGNADO
            $arrangementprogramPast = $arrangementProgramRepository->getDivestedIdAPbyUser($idUser, $period->getid());
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
                    $planeado[$idarray] = $mov->getplanned();
                    $realResult[$idarray] = $mov->getRealAdvance() + $mov->getPentalty();
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


                $arrangementPrograms[$key] = array(
                    'id' => sprintf('PG-%s', $arrangementProgram->getId()),
                    'ref' => $arrangementProgram->getRef(),
                    'description' => $arrangementProgram->getDescription(),
                    'result' => $arrangementProgram->getUpdateResultByAdmin() ? ToolService::formatResult($arrangementProgram->getResultModified()) : ToolService::formatResult($arrangementProgram->getResultReal()),
                    'resultToDate' => $advanceToDate,
                    'dateStart' => array(
                        'plan' => ToolService::formatDateTime($planDateStart),
                        'real' => ToolService::formatDateTime($realDateStart)
                    ),
                    'dateEnd' => array(
                        'plan' => ToolService::formatDateTime($planDateEnd),
                        'real' => ToolService::formatDateTime($realDateEnd)
                    ),
                    'aporte' => $aporte,
                    'aportePlan' => $aportePlan,
                    'eval' => $eval,
                    'observaciones' => $movements,
                    'tipo' => $status,
                );
            }

            $gerenciaFirst = $user->getGerencia();
            $gerenciaSecond = $user->getGerenciaSecond();

            if ($gerenciaFirst && $gerenciaFirst->isValidAudit() === false) {
                $isValidAudit = false;
                $this->addErrorTrans('pequiven_seip.errors.the_first_line_management_no_audit', array("%gerenciaFirst%" => $gerenciaFirst));
                $status = \Pequiven\SEIPBundle\Controller\Api\ResultApiController::RESULT_NO_AUDIT;
            }
            if ($gerenciaSecond && $gerenciaSecond->isValidAudit() === false) {
                $isValidAudit = false;
                $this->addErrorTrans('pequiven_seip.errors.the_second_line_management_no_audit', array("%gerenciaSecond%" => $gerenciaSecond->getGerencia()));
                $status = \Pequiven\SEIPBundle\Controller\Api\ResultApiController::RESULT_NO_AUDIT;
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
                    $status = \Pequiven\SEIPBundle\Controller\Api\ResultApiController::RESULT_INVALID_CONFIGURATION;
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
                    $status = \Pequiven\SEIPBundle\Controller\Api\ResultApiController::RESULT_INVALID_CONFIGURATION;
                }
            } else if ($user->getLevelRealByGroup() == \Pequiven\MasterBundle\Model\Rol::ROLE_DIRECTIVE) {
                $objetivesStrategic = $this->container->get('pequiven.repository.objetive')->findAllStrategicByPeriod($period);
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
                    'ref' => sprintf('%s', $objetive->getRef()),
                    'description' => $objetive->getDescription(),
                    'result' => $objetive->getUpdateResultByAdmin() ? ToolService::formatResult($objetive->getResultModified()) : ToolService::formatResult($objetive->getResult()),
                    'dateStart' => array(
                        'plan' => ToolService::formatDateTime($planDateStart),
                        'real' => ToolService::formatDateTime($planDateStart)
                    ),
                    'dateEnd' => array(
                        'plan' => ToolService::formatDateTime($planDateEnd),
                        'real' => ToolService::formatDateTime($planDateEnd)
                    ),
                    'gerencia' => $objetive->getgerencia(),
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
                    $realResult[$idarray] = $mov->getRealAdvance() + $mov->getPentalty();
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


                $goals[$key] = array(
                    'id' => sprintf('ME-%s', $goal->getId()),
                    'description' => $goal->getName(),
                    'weight' => $goal->getWeight(),
                    'result' => $goal->getUpdateResultByAdmin() ? ToolService::formatResult($goal->getResultModified()) : ToolService::formatResult($goal->getResult()),
                    'resultToDate' => $goal->getGoalDetails()->getPlannedTotal($fecha),
                    'dateStart' => array(
                        'plan' => ToolService::formatDateTime($planDateStart),
                        'real' => ToolService::formatDateTime($realDateStart)
                    ),
                    'dateEnd' => array(
                        'plan' => ToolService::formatDateTime($planDateEnd),
                        'real' => ToolService::formatDateTime($realDateEnd)
                    ),
                    'aporte' => $aporte,
                    'aportePlan' => $aportePlan,
                    'eval' => $eval,
                    'observaciones' => $movements,
                    'tipo' => $status,
                );
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
            //$resultService = ToolService::getResultService();
            $isValidAdvance = $this->validateAdvanceOfObjetives($objetives);
            if (!$isValidAdvance) {
                $canBeEvaluated = $isValidAdvance;
                $this->addErrorTrans($this->getErrors());
            }

            //Se evalua que tenga por lo menos un item
            if (count($goals) == 0 && count($arrangementPrograms) == 0 && count($objetives) == 0) {
                $canBeEvaluated = false;
                $this->addErrorTrans('pequiven_seip.errors.user_has_no_associated_items_evaluation', array(
                    '%user%' => $user,
                ));
                $status = \Pequiven\SEIPBundle\Controller\Api\ResultApiController::RESULT_NO_ITEMS;
            }
        }//endif if count errors

        $totalItems = count($goals) + count($arrangementPrograms) + count($objetivesOO) + count($objetivesOT) + count($objetivesOE);

        if ($totalItems == 0) {
            $canBeEvaluated = false;
            $this->addErrorTrans('pequiven_seip.errors.user_not_quantity_items', array(
                '%user%' => $user,
            ));
        }
//        if (!$canBeEvaluated || count($this->errors) > 0) {
//            $goals = $arrangementPrograms = $objetives = $objetivesOO = $objetivesOT = $objetivesOE = array();
//        }

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
//        if (!$canBeEvaluated || count($this->errors) > 0) {
//            $data['success'] = false;
//        }

        return $data;
    }

    private function addErrorTrans($error, array $parameters = array()) {
        if (is_array($error)) {
            $this->errors = array_merge($this->errors, $error);
        } else {
            $message = $this->trans($error, $parameters, 'PequivenSEIPBundle');
            $this->errors[md5($message)] = $message;
        }
    }

    function getErrors() {
        return $this->errors;
    }

    /**
     * Shortcut to return the Doctrine Registry service.
     *
     * @return \Doctrine\Bundle\DoctrineBundle\Registry
     *
     * @throws \LogicException If DoctrineBundle is not available
     */
    protected function getDoctrine() {
        if (!$this->container->has('doctrine')) {
            throw new \LogicException('The DoctrineBundle is not registered in your application.');
        }

        return $this->container->get('doctrine');
    }

    /**
     * Get a user from the Security Context
     *
     * @return mixed
     *
     * @throws \LogicException If SecurityBundle is not available
     *
     * @see Symfony\Component\Security\Core\Authentication\Token\TokenInterface::getUser()
     */
    protected function getUser() {
        if (!$this->container->has('security.context')) {
            throw new \LogicException('The SecurityBundle is not registered in your application.');
        }

        if (null === $token = $this->container->get('security.context')->getToken()) {
            return;
        }

        if (!is_object($user = $token->getUser())) {
            return;
        }

        return $user;
    }

    /**
     * 
     * @return \Pequiven\IndicatorBundle\Service\IndicatorService
     */
    private function getIndicatorService() {
        return $this->container->get('pequiven_indicator.service.inidicator');
    }

    /**
     * 
     * @return \Pequiven\ArrangementBundle\Service\ArrangementRangeService
     */
    protected function getArrangementRangeService() {
        return $this->container->get('pequiven_arrangement.service.arrangementrange');
    }

    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
        $this->container = $container;
    }

    /**
     * Generates a URL from the given parameters.
     *
     * @param string         $route         The name of the route
     * @param mixed          $parameters    An array of parameters
     * @param bool|string    $referenceType The type of reference (one of the constants in UrlGeneratorInterface)
     *
     * @return string The generated URL
     *
     * @see UrlGeneratorInterface
     */
    protected function generateUrl($route, $parameters = array(), $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH) {
        return $this->container->get('router')->generate($route, $parameters, $referenceType);
    }

    function generateAsset($path, $packageName = null) {
        return $this->container->get('templating.helper.assets')
                        ->getUrl($path, $packageName);
    }

    protected function trans($id, array $parameters = array(), $domain = 'messages') {
        return $this->container->get('translator')->trans($id, $parameters, $domain);
    }

    /**
     * 
     * @return PeriodService
     */
    protected function getPeriodService() {
        return $this->container->get('pequiven_seip.service.period');
    }

    /**
     * Renders a string view.
     *
     * @param string   $view       The view name
     * @param array    $parameters An array of parameters to pass to the view
     * @param Response $response   A response instance
     *
     * @return String twig
     */
    private function renderString($string, array $parameters = array()) {
        $toolService = new ToolService();
        $parameters = array_merge($parameters, array(
            'tool_service' => $toolService,
            'date_now' => new \DateTime(),
        ));
        return $this->container->get('app.twig_string')->render($string, $parameters);
    }

}
