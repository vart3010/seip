<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\SEIPBundle\EventListener;

use DateTime;
use JMS\Serializer\EventDispatcher\Events;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\ObjectEvent;
use JMS\Serializer\EventDispatcher\PreSerializeEvent;
use Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram;
use Pequiven\ArrangementProgramBundle\Entity\GoalDetails;
use Pequiven\ObjetiveBundle\Entity\ObjetiveLevel;
use Pequiven\SEIPBundle\Entity\Sip\Center\Observations;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\PropertyAccess\PropertyAccessor;

/**
 * Listerner del serializador
 *
 * @author matias
 */
class SerializerListener implements EventSubscriberInterface, ContainerAwareInterface {

    /**
     *
     * @var ContainerInterface
     */
    private $container;

    public static function getSubscribedEvents() {
        return array(
            array('event' => Events::POST_SERIALIZE, 'method' => 'onPostSerializeObjetive', 'class' => 'Pequiven\ObjetiveBundle\Entity\Objetive', 'format' => 'json'),
            array('event' => Events::POST_SERIALIZE, 'method' => 'onPostSerializeIndicator', 'class' => 'Pequiven\IndicatorBundle\Entity\Indicator', 'format' => 'json'),
            array('event' => Events::POST_SERIALIZE, 'method' => 'onPostSerializeGoalDetails', 'class' => 'Pequiven\ArrangementProgramBundle\Entity\GoalDetails', 'format' => 'json'),
            array('event' => Events::POST_SERIALIZE, 'method' => 'onPostSerializeArrangementProgram', 'class' => 'Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram', 'format' => 'json'),
            array('event' => Events::POST_SERIALIZE, 'method' => 'onPostSerializeArrangementProgramTemplate', 'class' => 'Pequiven\ArrangementProgramBundle\Entity\ArrangementProgramTemplate', 'format' => 'json'),
            array('event' => Events::POST_SERIALIZE, 'method' => 'onPostSerializeMonitor', 'class' => 'Pequiven\SEIPBundle\Entity\Monitor', 'format' => 'json'),
            array('event' => Events::POST_SERIALIZE, 'method' => 'onPostSerializeUser', 'class' => 'Pequiven\SEIPBundle\Entity\User', 'format' => 'json'),
            array('event' => Events::POST_SERIALIZE, 'method' => 'onPostSerializeGerencia', 'class' => 'Pequiven\MasterBundle\Entity\Gerencia', 'format' => 'json'),
            array('event' => Events::POST_SERIALIZE, 'method' => 'onPostSerializeGerenciaSecond', 'class' => 'Pequiven\MasterBundle\Entity\GerenciaSecond', 'format' => 'json'),
            array('event' => Events::POST_SERIALIZE, 'method' => 'onPostSerializeGoal', 'class' => 'Pequiven\ArrangementProgramBundle\Entity\Goal', 'format' => 'json'),
            array('event' => Events::POST_SERIALIZE, 'method' => 'onPostSerializeReportTemplate', 'class' => 'Pequiven\SEIPBundle\Entity\DataLoad\ReportTemplate', 'format' => 'json'),
            array('event' => Events::POST_SERIALIZE, 'method' => 'onPostSerializeReportTemplateDelivery', 'class' => 'Pequiven\SEIPBundle\Entity\Delivery\ReportTemplateDelivery', 'format' => 'json'),
            array('event' => Events::POST_SERIALIZE, 'method' => 'onPostSerializePlantReport', 'class' => 'Pequiven\SEIPBundle\Entity\DataLoad\PlantReport', 'format' => 'json'),
            array('event' => Events::POST_SERIALIZE, 'method' => 'onPostSerializeWorkStudyCircle', 'class' => 'Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle', 'format' => 'json'),
            array('event' => Events::POST_SERIALIZE, 'method' => 'onPostSerializeProposal', 'class' => 'Pequiven\SEIPBundle\Entity\Politic\Proposal', 'format' => 'json'),
            array('event' => Events::POST_SERIALIZE, 'method' => 'onPostSerializeMeeting', 'class' => 'Pequiven\SEIPBundle\Entity\Politic\Meeting', 'format' => 'json'),
            array('event' => Events::POST_SERIALIZE, 'method' => 'onPostSerializeMeetingFile', 'class' => 'Pequiven\SEIPBundle\Entity\Politic\MeetingFile', 'format' => 'json'),
            array('event' => Events::POST_SERIALIZE, 'method' => 'onPostSerializeCutl', 'class' => 'Pequiven\SEIPBundle\Entity\Sip\Cutl', 'format' => 'json'),
            array('event' => Events::POST_SERIALIZE, 'method' => 'onPostSerializeCenter', 'class' => 'Pequiven\SEIPBundle\Entity\Sip\Centro', 'format' => 'json'),
            array('event' => Events::POST_SERIALIZE, 'method' => 'onPostSerializeNominaCentro', 'class' => 'Pequiven\SEIPBundle\Entity\Sip\NominaCentro', 'format' => 'json'),
            array('event' => Events::POST_SERIALIZE, 'method' => 'onPostSerializeOnePerTen', 'class' => 'Pequiven\SEIPBundle\Entity\Sip\OnePerTen', 'format' => 'json'),
            array('event' => Events::POST_SERIALIZE, 'method' => 'onPostSerializeOnePerTenMembers', 'class' => 'Pequiven\SEIPBundle\Entity\Sip\OnePerTenMembers', 'format' => 'json'),
            array('event' => Events::POST_SERIALIZE, 'method' => 'onPostSerializeObservationsSip', 'class' => 'Pequiven\SEIPBundle\Entity\Sip\Center\Observations', 'format' => 'json'),
            array('event' => Events::POST_SERIALIZE, 'method' => 'onPostSerializeInventorySip', 'class' => 'Pequiven\SEIPBundle\Entity\Sip\Center\Inventory', 'format' => 'json'),
        );
    }

    public function onPreSerialize(PreSerializeEvent $event) {
        // do something
    }

    /**
     * Función que serializa el objeto de objetivo para la vista
     * @param ObjectEvent $event
     */
    public function onPostSerializeObjetive(ObjectEvent $event) {
        $object = $event->getObject();
        if ($object->getObjetiveLevel() && $object->getObjetiveLevel()->getLevel() === ObjetiveLevel::LEVEL_ESTRATEGICO) {
            $lineStrategics = $event->getObject()->getLineStrategics();
            $event->getVisitor()->addData('groupBy', $lineStrategics[0]->getRef() . $lineStrategics[0]->getDescription());
            $data['self']['href'] = $this->generateUrl('objetiveStrategic_show', array('id' => $object->getId()));
            $event->getVisitor()->addData('_links', $data);
        } elseif ($object->getObjetiveLevel() && $object->getObjetiveLevel()->getLevel() === ObjetiveLevel::LEVEL_TACTICO) {
            $parents = $object->getParents();
            $totalParents = count($parents);
            $valueGroupBy = '';
            $i = 1;
            foreach ($parents as $parent) {
                $valueGroupBy.= $parent->getRef() . $parent->getDescription() . '<br>';
            }
            $event->getVisitor()->addData('groupBy', $valueGroupBy);
            $event->getVisitor()->addData('totalParents', count($parents));
            $data['self']['href'] = $this->generateUrl('objetiveTactic_show', array('id' => $object->getId()));
            $event->getVisitor()->addData('_links', $data);
        } elseif ($object->getObjetiveLevel() && $object->getObjetiveLevel()->getLevel() === ObjetiveLevel::LEVEL_OPERATIVO) {
            $parents = $object->getParents();
            $valueGroupBy = '';
            foreach ($parents as $parent) {
                $valueGroupBy.= $parent->getRef() . $parent->getDescription();
            }
            $event->getVisitor()->addData('groupBy', $valueGroupBy);
//            $event->getVisitor()->addData('gerenciaSecond', $object->getGerenciaSecond()->getDescription());
            $event->getVisitor()->addData('totalParents', count($parents));
            $data['self']['href'] = $this->generateUrl('objetiveOperative_show', array('id' => $object->getId()));
            $event->getVisitor()->addData('_links', $data);
        }
    }

    /**
     * Función que serializa el objeto de indicador para la vista
     * @param ObjectEvent $event
     */
    public function onPostSerializeIndicator(ObjectEvent $event) {
        $indicator = $event->getObject();
        $objetives = $indicator->getObjetives();
        $links = array();
        $links['self'] = array(
            'href' => $this->generateUrl('pequiven_indicator_show', array('id' => $indicator->getId())),
        );

        $visitor = $event->getVisitor();
        if ($objetives[0] != null) {
            $visitor->addData('groupBy', $objetives[0]->getRef() . $objetives[0]->getDescription());
            if ($objetives[0]->getObjetiveLevel()->getLevel() > ObjetiveLevel::LEVEL_TACTICO) {
                $visitor->addData('gerenciaSecond', $objetives[0]->getGerenciaSecond()->getDescription());
            }
        }
        $visitor->addData('_links', $links);

        $arrangementRangeService = $this->getArrangementRangeService();
        $errorArrangementRange = '';
        if ($indicator->getArrangementRange() !== null) {//En caso de que el indicador tenga un rango de gestión asignado, se procede a evaluar la definición del rango
            $errorArrangementRange = $arrangementRangeService->validateArrangementRange($indicator->getArrangementRange(), $indicator->getTendency());
            if ($errorArrangementRange == null) {
                $errorArrangementRange = $this->trans('pequiven_indicator.indicatorsWithoutErrorText', array(), 'PequivenIndicatorBundle');
            }
        } else {//En caso de que el indicador no tenga un rango de gestión asignado se setea el mensaje de error
            $errorArrangementRange = $this->trans('pequiven_indicator.errors.arrangementRange_not_assigned', array(), 'PequivenIndicatorBundle');
        }

        $visitor->addData('errorText', $errorArrangementRange);
    }

    public function onPostSerializeGoalDetails(ObjectEvent $event) {
        $data = array();
        $object = $event->getObject();
        $goal = $object->getGoal();

        $arrangementProgram = $goal->getTimeline()->getArrangementProgram();
        $date = new DateTime();

        //Habilitar la carga de lo real
        $isLoadRealEnabled = false;
        //Habilitar la carga de los planeado
        $isLoadPlannedEnabled = false;

        //Habilitar la carga de los planeado segun la fecha inicio y fin
        $isForceLoadPlannedEnabled = false;
        if ($arrangementProgram != null) {
            if ($this->getArrangementProgramManager()->hasPermissionToNotify($arrangementProgram) === true
            ) {
                $details = $arrangementProgram->getDetails();
                $user = $this->getUser();
                if ($details->getNotificationInProgressByUser() !== null && $details->getNotificationInProgressByUser() === $user) {
                    $isLoadRealEnabled = true;
                }
            }
            if (
                    $arrangementProgram->getStatus() == ArrangementProgram::STATUS_DRAFT ||
                    $arrangementProgram->getStatus() == ArrangementProgram::STATUS_IN_REVIEW ||
                    $arrangementProgram->getStatus() == ArrangementProgram::STATUS_REVISED
            ) {
                $isForceLoadPlannedEnabled = true;
            }
            //Sino tiene permisos para planificar en el programa de gestion
            if (
                    $this->getArrangementProgramManager()->hasPermissionToPlanned($arrangementProgram)
            ) {
                $isLoadPlannedEnabled = true;
                $isForceLoadPlannedEnabled = true;
            }
            if ($arrangementProgram->getStatus() == ArrangementProgram::STATUS_APPROVED || $arrangementProgram->getStatus() == ArrangementProgram::STATUS_REJECTED) {
                $isLoadPlannedEnabled = false;
            }
        } else {
            $isLoadPlannedEnabled = true;
            $isForceLoadPlannedEnabled = true;
        }

        //Habilitar carga de valores reales de meses adelantados
        $isEnabledLoadRealFuture = false;
        //Habilitar la carga de valores reales atrasados
        $isEnabledLoadRealLate = false;
        //Habilitar edicion del valor real dependiendo si la planeada no esta vacia
        $isEnabledEditByPlannedLoad = false;
        //Deshabilitar las celdas planeadas cuando se distribuya el 100%
        $disablePlannedOnComplete = true;

        //Habilitar la carga por trimestre
        $isEnabledLoadByQuarter = true;

        //Habilitar la carga del primer trimestre (Requiere isEnabledLoadByQuarter)
        $isEnabledLoadByQuarterFirst = false;
        //Habilitar la carga de valores planificados del primer trimestre (Requiere isEnabledLoadByQuarterFirst)
        $isEnabledLoadByQuarterFirstPlanned = false;
        //Habilitar la carga de valores reales del primer trimestre (Requiere isEnabledLoadByQuarterFirst)
        $isEnabledLoadByQuarterFirstReal = false;

        //Habilitar la carga del segundo trimestre (Requiere isEnabledLoadByQuarter)
        $isEnabledLoadByQuarterSecond = true;
        //Habilitar la carga de valores planificados del segundo trimestre (Requiere isEnabledLoadByQuarterSecond)
        $isEnabledLoadByQuarterSecondPlanned = false;
        //Habilitar la carga de valores reales del segundo trimestre (Requiere isEnabledLoadByQuarterSecond)
        $isEnabledLoadByQuarterSecondReal = true;

        //Habilitar la carga del tercer trimestre (Requiere isEnabledLoadByQuarter)
        $isEnabledLoadByQuarterThird = false;
        //Habilitar la carga de valores planificados del tercer trimestre (Requiere isEnabledLoadByQuarterThird)
        $isEnabledLoadByQuarterThirdPlanned = false;
        //Habilitar la carga de valores reales del tercer trimestre (Requiere isEnabledLoadByQuarterThird)
        $isEnabledLoadByQuarterThirdReal = false;

        //Habilitar la carga del cuarto trimestre (Requiere isEnabledLoadByQuarter)
        $isEnabledLoadByQuarterFourth = false;
        //Habilitar la carga de valores planificados del cuarto trimestre (Requiere isEnabledLoadByQuarterFourth)
        $isEnabledLoadByQuarterFourthPlanned = false;
        //Habilitar la carga de valores reales del cuarto trimestre (Requiere isEnabledLoadByQuarterFourth)
        $isEnabledLoadByQuarterFourthReal = false;

        $month = $date->format('m');

        if ($isEnabledLoadRealFuture === false) {
            foreach (GoalDetails::getMonthsReal() as $key => $monthGoal) {
                if ($month < $monthGoal) {
                    $data[$key]['isEnabled'] = false;
                }
            }
        }
        if ($isEnabledLoadRealLate === false) {
            foreach (GoalDetails::getMonthsReal() as $key => $monthGoal) {
                if ($month > $monthGoal) {
                    $data[$key]['isEnabled'] = false;
                }
            }
        }

        if ($disablePlannedOnComplete === true) {
            //Limite de porcentaje que se asigna al planeado
            $limitPlannedPercentaje = 100;
            $percentajeAcumulated = 0;
            $propertyAccessor = new PropertyAccessor();
            $disable = false;
            foreach (GoalDetails::getMonthsPlanned() as $planned => $monthNumber) {
                $percentaje = $propertyAccessor->getValue($object, $planned);
                $percentajeAcumulated += $percentaje;
                if ($disable) {
                    $data[$planned]['isEnabled'] = false;
                    continue;
                }
                if ($percentajeAcumulated >= $limitPlannedPercentaje) {
                    $disable = true;
                }
            }
            foreach (GoalDetails::getMonthsPlanned() as $planned => $monthNumber) {
                $percentaje = $propertyAccessor->getValue($object, $planned);
                if ($disable === true && ($percentaje == 0 && $percentaje == '0' || $percentaje == '' || $percentaje == null)) {
                    $data[$planned]['isEnabled'] = false;
                }
            }
        }

        if ($isEnabledLoadByQuarter === true) {
            $currentCuarter = null;
            $quarterDef = array(
                1 => array(1, 2, 3),
                2 => array(4, 5, 6),
                3 => array(7, 8, 9),
                4 => array(10, 11, 12),
            );
            foreach ($quarterDef as $key => $quarter) {
                foreach ($quarter as $monthQuarter) {
                    if ($monthQuarter == $month) {
                        $currentCuarter = $key;
                        break;
                    }
                }
                if ($currentCuarter !== null) {
                    break;
                }
            }
            /**
             * Deshabilitar meses que no estan en el trimestre
             */
            $disableQuartes = function ($months, &$data, $currentCuarter) use ($quarterDef) {
                foreach ($months as $planned => $monthNumber) {
                    $disable = true;
                    foreach ($quarterDef[$currentCuarter] as $monthQuarter) {
                        if ($monthNumber == $monthQuarter) {
                            $disable = false;
                        }
                    }
                    if ($disable === true) {
                        $data[$planned]['isEnabled'] = false;
                    } else {
                        $data[$planned]['isEnabled'] = true;
                    }
                }
            };

            $enableQuartes = function($months, &$data, $cuarter) use ($quarterDef) {

                foreach ($months as $planned => $monthNumber) {
                    $disable = true;
                    foreach ($quarterDef[$cuarter] as $monthQuarter) {
                        if ($monthNumber == $monthQuarter) {
                            $disable = false;
                        }
                    }
                    if ($disable === false) {
                        $data[$planned]['isEnabled'] = true;
                    } else {
                        $data[$planned]['isEnabled'] = false;
                    }
                }
            };

            $disableQuartes(GoalDetails::getMonthsPlanned(), $data, $currentCuarter);
            $disableQuartes(GoalDetails::getMonthsReal(), $data, $currentCuarter);

            if ($isEnabledLoadByQuarterFirst === true) {
                if ($isEnabledLoadByQuarterFirstPlanned === true) {
                    $enableQuartes(GoalDetails::getMonthsPlanned(), $data, 1);
                }
                if ($isEnabledLoadByQuarterFirstReal === true) {
                    $enableQuartes(GoalDetails::getMonthsReal(), $data, 1);
                }
            }
            if ($isEnabledLoadByQuarterSecond === true) {
                if ($isEnabledLoadByQuarterSecondPlanned === true) {
                    $enableQuartes(GoalDetails::getMonthsPlanned(), $data, 2);
                }
                if ($isEnabledLoadByQuarterSecondReal === true) {
                    $enableQuartes(GoalDetails::getMonthsReal(), $data, 2);
                }
            }
            if ($isEnabledLoadByQuarterThird === true) {
                if ($isEnabledLoadByQuarterThirdPlanned === true) {
                    $enableQuartes(GoalDetails::getMonthsPlanned(), $data, 3);
                }
                if ($isEnabledLoadByQuarterThirdReal === true) {
                    $enableQuartes(GoalDetails::getMonthsReal(), $data, 3);
                }
            }
            if ($isEnabledLoadByQuarterFourth === true) {
                if ($isEnabledLoadByQuarterFourthPlanned === true) {
                    $enableQuartes(GoalDetails::getMonthsPlanned(), $data, 4);
                }
                if ($isEnabledLoadByQuarterFourthReal === true) {
                    $enableQuartes(GoalDetails::getMonthsReal(), $data, 4);
                }
            }
        }

        if ($isEnabledEditByPlannedLoad === true) {
            $propertyAccessor = new PropertyAccessor();
            foreach (GoalDetails::getMonthsPlanned() as $planned => $monthNumber) {
                $value = $propertyAccessor->getValue($object, $planned);
                $monthReal = GoalDetails::getMonthOfRealByMonth($monthNumber);
                if ($value == '' || $value == '0' || $value === null) {
                    $data[$monthReal]['isEnabled'] = false;
                }
            }
        }

        if ($isLoadPlannedEnabled === false) {
            foreach (GoalDetails::getMonthsPlanned() as $key => $monthGoal) {
                $data[$key]['isEnabled'] = false;
            }
        }
        if ($isLoadRealEnabled === false) {
            foreach (GoalDetails::getMonthsReal() as $key => $monthGoal) {
                $data[$key]['isEnabled'] = false;
            }
        }
        if ($isForceLoadPlannedEnabled === true) {
            $startDate = $goal->getStartDate();
            $endDate = $goal->getEndDate();
            $monthStart = $startDate->format('m');
            $monthEnd = $endDate->format('m');
            foreach (GoalDetails::getMonthsPlanned() as $key => $monthGoal) {
                if ($monthGoal >= $monthStart && $monthGoal <= $monthEnd) {
                    $data[$key]['isEnabled'] = true;
                } else {
                    $data[$key]['isEnabled'] = false;
                }
            }
        }

        $details = $arrangementProgram->getDetails();
        $user = $this->getUser();
        //var_dump($user); die();
        if($details->getNotificationInProgressByUser() != null){
//            if($details->getNotificationInProgressByUser()->getId() === $user->getId() && (($arrangementProgram->getType() == ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_TACTIC && $arrangementProgram->getTacticalObjective()->getGerencia()->getId() == 9) || ($arrangementProgram->getType() == ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_OPERATIVE && $arrangementProgram->getOperationalObjective()->getGerenciaSecond()->getGerencia()->getId() == 9))){
            //if($details->getNotificationInProgressByUser()->getId() === $user->getId() && (($arrangementProgram->getType() == ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_TACTIC && $arrangementProgram->getTacticalObjective()->getGerencia()->getId() == 35) || ($arrangementProgram->getType() == ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_OPERATIVE && $arrangementProgram->getOperationalObjective()->getGerencia()->getId() == 35))){
            if($details->getNotificationInProgressByUser()->getId() === $user->getId() && (($arrangementProgram->getType() == ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_TACTIC && $arrangementProgram->getTacticalObjective()->getGerencia()->getId() == 24) || ($arrangementProgram->getType() == ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_OPERATIVE && $arrangementProgram->getOperationalObjective()->getGerencia()->getId() == 24))){
           //if((($arrangementProgram->getType() == ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_TACTIC && $arrangementProgram->getTacticalObjective()->getGerencia()->getId() == 9) || ($arrangementProgram->getType() == ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_OPERATIVE && $arrangementProgram->getOperationalObjective()->getGerencia()->getId() == 9))){
                $data['januaryReal']['isEnabled'] = true;
                $data['februaryReal']['isEnabled'] = true;
                $data['marchReal']['isEnabled'] = true;
                //$data['aprilReal']['isEnabled'] = true;
                //$data['mayReal']['isEnabled'] = true;
                //$data['juneReal']['isEnabled'] = true;
                //$data['julyReal']['isEnabled'] = true;
                //$data['augustReal']['isEnabled'] = true;
                //$data['septemberReal']['isEnabled'] = true;
                //$data['octoberReal']['isEnabled'] = true;
                //$data['novemberReal']['isEnabled'] = true;
                //$data['decemberReal']['isEnabled'] = true;
            }
        }

        $event->getVisitor()->addData('_data', $data);
    }

    public function onPostSerializeArrangementProgram(ObjectEvent $event) {
        $links = $data = array();
        $object = $event->getObject();
        if ($object->getId() > 0) {
            $links['self']['href'] = $this->generateUrl('pequiven_seip_arrangementprogram_show', array('id' => $object->getId()));
            $links['self']['edit']['href'] = $this->generateUrl('arrangementprogram_update', array('id' => $object->getId()));
        }
        $data['summary'] = $object->getSummary();
        $event->getVisitor()->addData('_data', $data);
        if ($object->getDescription() != "") {
            $event->getVisitor()->addData('name_program', $object->getDescription());
        } else {
            $event->getVisitor()->addData('name_program', "No cargado");
        }
        $event->getVisitor()->addData('_links', $links);
    }

    public function onPostSerializeArrangementProgramTemplate(ObjectEvent $event) {
        $links = array();
        $object = $event->getObject();
        if ($object->getId() > 0) {
            $links['self']['href'] = $this->generateUrl('pequiven_seip_arrangementprogram_template_show', array('id' => $object->getId()));
            $links['self']['edit']['href'] = $this->generateUrl('arrangementprogram_template_update', array('id' => $object->getId()));
        }
        $event->getVisitor()->addData('_links', $links);
    }

    /**
     * Función que serializa el objeto de indicador para la vista
     * @param ObjectEvent $event
     */
    public function onPostSerializeMonitor(ObjectEvent $event) {
        $monitor = $event->getObject();
        $range = array();
        $filter = array();
        $res = array();
        $images = array();
        $routeImage = array();
        $images['good'] = $this->generateAsset('bundles/pequivenseip/logotipos/bullet_green.png');
        $images['middle'] = $this->generateAsset('bundles/pequivenseip/logotipos/bullet_yellow.png');
        $images['bad'] = $this->generateAsset('bundles/pequivenseip/logotipos/bullet_red.png');

        $range['good'] = (float) 70;
        $range['bad'] = (float) 40;

        //Acomodar Data
        //Obj. Táctico Original
        $res['objTacticOriginal'] = $monitor->getObjTacticOriginal() == 0 ? bcadd(0, '0', 2) : bcadd(((float) $monitor->getObjTacticOriginalReal() / (float) $monitor->getObjTacticOriginal()) * 100, '0', 2);
        if ($res['objTacticOriginal'] >= $range['good']) {
            $filter['objTacticOriginal'] = 1;
        } elseif ($res['objTacticOriginal'] < $range['good'] && $res['objTacticOriginal'] >= $range['bad']) {
            $filter['objTacticOriginal'] = 2;
        } elseif ($res['objTacticOriginal'] < $range['bad']) {
            $filter['objTacticOriginal'] = 3;
        }
        if ($filter['objTacticOriginal'] == 1) {
            $routeImage['objTacticOriginal'] = $images['good'];
        } elseif ($filter['objTacticOriginal'] == 2) {
            $routeImage['objTacticOriginal'] = $images['middle'];
        } else {
            $routeImage['objTacticOriginal'] = $images['bad'];
        }

        //Ind. Táctico Original
        $res['indTacticOriginal'] = $monitor->getIndTacticOriginal() == 0 ? bcadd(0, '0', 2) : bcadd(((float) $monitor->getIndTacticOriginalReal() / (float) $monitor->getIndTacticOriginal()) * 100, '0', 2);
        if ($res['indTacticOriginal'] >= $range['good']) {
            $filter['indTacticOriginal'] = 1;
        } elseif ($res['indTacticOriginal'] < $range['good'] && $res['indTacticOriginal'] >= $range['bad']) {
            $filter['indTacticOriginal'] = 2;
        } elseif ($res['indTacticOriginal'] < $range['bad']) {
            $filter['indTacticOriginal'] = 3;
        }
        if ($filter['indTacticOriginal'] == 1) {
            $routeImage['indTacticOriginal'] = $images['good'];
        } elseif ($filter['indTacticOriginal'] == 2) {
            $routeImage['indTacticOriginal'] = $images['middle'];
        } else {
            $routeImage['indTacticOriginal'] = $images['bad'];
        }

        //Obj. Operativo Original
        $res['objOperativeOriginal'] = $monitor->getObjOperativeOriginal() == 0 ? bcadd(0, '0', 2) : bcadd(((float) $monitor->getObjOperativeOriginalReal() / (float) $monitor->getObjOperativeOriginal()) * 100, '0', 2);
        if ($res['objOperativeOriginal'] >= $range['good']) {
            $filter['objOperativeOriginal'] = 1;
        } elseif ($res['objOperativeOriginal'] < $range['good'] && $res['objOperativeOriginal'] >= $range['bad']) {
            $filter['objOperativeOriginal'] = 2;
        } elseif ($res['objOperativeOriginal'] < $range['bad']) {
            $filter['objOperativeOriginal'] = 3;
        }
        if ($filter['objOperativeOriginal'] == 1) {
            $routeImage['objOperativeOriginal'] = $images['good'];
        } elseif ($filter['objOperativeOriginal'] == 2) {
            $routeImage['objOperativeOriginal'] = $images['middle'];
        } else {
            $routeImage['objOperativeOriginal'] = $images['bad'];
        }

        //Obj. Operativo Vinculante
        $res['objOperativeVinculante'] = $monitor->getObjOperativeVinculante() == 0 ? bcadd(0, '0', 2) : bcadd(((float) $monitor->getObjOperativeVinculanteReal() / (float) $monitor->getObjOperativeVinculante()) * 100, '0', 2);
        if ($res['objOperativeVinculante'] >= $range['good']) {
            $filter['objOperativeVinculante'] = 1;
        } elseif ($res['objOperativeVinculante'] < $range['good'] && $res['objOperativeVinculante'] >= $range['bad']) {
            $filter['objOperativeVinculante'] = 2;
        } elseif ($res['objOperativeVinculante'] < $range['bad']) {
            $filter['objOperativeVinculante'] = 3;
        }
        if ($filter['objOperativeVinculante'] == 1) {
            $routeImage['objOperativeVinculante'] = $images['good'];
        } elseif ($filter['objOperativeVinculante'] == 2) {
            $routeImage['objOperativeVinculante'] = $images['middle'];
        } else {
            $routeImage['objOperativeVinculante'] = $images['bad'];
        }

        //Ind. Operativo Original
        $res['indOperativeOriginal'] = $monitor->getIndOperativeOriginal() == 0 ? bcadd(0, '0', 2) : bcadd(((float) $monitor->getIndOperativeOriginalReal() / (float) $monitor->getIndOperativeOriginal()) * 100, '0', 2);
        if ($res['indOperativeOriginal'] >= $range['good']) {
            $filter['indOperativeOriginal'] = 1;
        } elseif ($res['indOperativeOriginal'] < $range['good'] && $res['indOperativeOriginal'] >= $range['bad']) {
            $filter['indOperativeOriginal'] = 2;
        } elseif ($res['indOperativeOriginal'] < $range['bad']) {
            $filter['indOperativeOriginal'] = 3;
        }
        if ($filter['indOperativeOriginal'] == 1) {
            $routeImage['indOperativeOriginal'] = $images['good'];
        } elseif ($filter['indOperativeOriginal'] == 2) {
            $routeImage['indOperativeOriginal'] = $images['middle'];
        } else {
            $routeImage['indOperativeOriginal'] = $images['bad'];
        }

        //Ind. Operativo Vinculante
        $res['indOperativeVinculante'] = $monitor->getIndOperativeVinculante() == 0 ? bcadd(0, '0', 2) : bcadd(((float) $monitor->getIndOperativeVinculanteReal() / (float) $monitor->getIndOperativeVinculante()) * 100, '0', 2);
        if ($res['indOperativeVinculante'] >= $range['good']) {
            $filter['indOperativeVinculante'] = 1;
        } elseif ($res['indOperativeVinculante'] < $range['good'] && $res['indOperativeVinculante'] >= $range['bad']) {
            $filter['indOperativeVinculante'] = 2;
        } elseif ($res['indOperativeVinculante'] < $range['bad']) {
            $filter['indOperativeVinculante'] = 3;
        }
        if ($filter['indOperativeVinculante'] == 1) {
            $routeImage['indobjOperativeVinculante'] = $images['good'];
        } elseif ($filter['indOperativeVinculante'] == 2) {
            $routeImage['indOperativeVinculante'] = $images['middle'];
        } else {
            $routeImage['indOperativeVinculante'] = $images['bad'];
        }

        //Resultados
        //Obj. Táctico Original
        $event->getVisitor()->addData('resObjTacticOriginal', $res['objTacticOriginal']);
        $event->getVisitor()->addData('imageObjTacticOriginal', $routeImage['objTacticOriginal']);
        //Ind. Táctico Original
        $event->getVisitor()->addData('resIndTacticOriginal', $res['indTacticOriginal']);
        $event->getVisitor()->addData('imageIndTacticOriginal', $routeImage['indTacticOriginal']);
        //Obj. Operativo Original
        $event->getVisitor()->addData('resObjOperativeOriginal', $res['objOperativeOriginal']);
        $event->getVisitor()->addData('imageObjOperativeOriginal', $routeImage['objOperativeOriginal']);
        //Obj. Operativo Vinculante
        $event->getVisitor()->addData('resObjOperativeVinculante', $res['objOperativeVinculante']);
        $event->getVisitor()->addData('imageObjOperativeVinculante', $routeImage['objOperativeVinculante']);
        //Ind. Operativo Original
        $event->getVisitor()->addData('resIndOperativeOriginal', $res['indOperativeOriginal']);
        $event->getVisitor()->addData('imageIndOperativeOriginal', $routeImage['indOperativeOriginal']);
        //Ind. Operativo Vinculante
        $event->getVisitor()->addData('resIndOperativeVinculante', $res['indOperativeVinculante']);
        $event->getVisitor()->addData('imageIndOperativeVinculante', $routeImage['indOperativeVinculante']);
    }

    public function onPostSerializeUser(ObjectEvent $event) {
        $links = array();
        $object = $event->getObject();
        $group = $object->getRealGroup();
        $links['self']['href'] = $this->generateUrl('pequiven_user_update', array('id' => $object->getId()));
        $links['self']['edit'] = $this->generateUrl('pequiven_user_update', array('id' => $object->getId()));
        $event->getVisitor()->addData('_links', $links);
        $rol = 'SIN ASIGNAR';
        if ($group) {
            $rol = $group->getDescription();
        }

        $event->getVisitor()->addData('rol', $rol);
    }

    public function onPostSerializeReportTemplate(ObjectEvent $event) {
        $object = $event->getObject();
        $links = array(
            "self" => array(),
        );
        $links['self']['show'] = $this->generateUrl('pequiven_report_template_show', array('id' => $object->getId()));
        $links['self']['update'] = $this->generateUrl('pequiven_report_template_update', array('id' => $object->getId()));
        $links['self']['load'] = $this->generateUrl('pequiven_report_template_load', array('id' => $object->getId()));
        $event->getVisitor()->addData('_links', $links);
    }

    public function onPostSerializeReportTemplateDelivery(ObjectEvent $event) {
        $object = $event->getObject();
        $links = array(
            "self" => array(),
        );
        $links['self']['show'] = $this->generateUrl('pequiven_report_template_delivery_update', array('id' => $object->getId()));
        $links['self']['update'] = $this->generateUrl('pequiven_report_template_delivery_update', array('id' => $object->getId()));
        //$links['self']['load'] = $this->generateUrl('pequiven_report_template_delivery_load', array('id' => $object->getId()));
        $event->getVisitor()->addData('_links', $links);
    }

    public function onPostSerializePlantReport(ObjectEvent $event) {
        $object = $event->getObject();
        $reportTemplate = $object->getReportTemplate();
        $links = array(
        );
        $links['load'] = $this->generateUrl('pequiven_report_template_load', array('id' => $reportTemplate->getId(), 'plant_report' => $object->getId()));
        $event->getVisitor()->addData('_links', $links);
    }

    public function onPostSerializeGerencia(ObjectEvent $event) {
        $object = $event->getObject();
        $links = array(
            'show_result' => $this->generateUrl('pequiven_seip_result_visualize_gerencia', array('level' => \Pequiven\SEIPBundle\Model\Common\CommonObject::LEVEL_GERENCIA, 'id' => $object->getId()))
        );
        $event->getVisitor()->addData('linkToExportMatriz', $this->generateUrl('pequiven_gerenciafirst_export', array('id' => $object->getId())));
//        $event->getVisitor()->addData('linkToExportResult', $this->generateUrl('pequiven_seip_result_export', array('level' => \Pequiven\SEIPBundle\Model\Common\CommonObject::LEVEL_GERENCIA,'id' => $object->getId())));
        $event->getVisitor()->addData('_links', $links);
    }

    public function onPostSerializeGerenciaSecond(ObjectEvent $event) {
        $object = $event->getObject();
        $links = array(
            'show_result' => $this->generateUrl('pequiven_seip_result_visualize_gerencia', array('level' => \Pequiven\SEIPBundle\Model\Common\CommonObject::LEVEL_GERENCIA_SECOND, 'id' => $object->getId()))
        );
//        $event->getVisitor()->addData('linkToExportResult', $this->generateUrl('pequiven_seip_result_export', array('level' => \Pequiven\SEIPBundle\Model\Common\CommonObject::LEVEL_GERENCIA_SECOND,'id' => $object->getId())));
        $event->getVisitor()->addData('_links', $links);
    }

    public function onPostSerializeGoal(ObjectEvent $event) {
        
    }

    public function onPostSerializeWorkStudyCircle(ObjectEvent $event) {
        $object = $event->getObject();

        $gerenciasText = '';
        $gerencias = $object->getGerencias();
        $totalGerencias = count($gerencias);
        $cont = 1;
        foreach ($gerencias as $gerencia) {
            if ($cont == $totalGerencias) {
                $gerenciasText.= $gerencia->getDescription();
            } else {
                $gerenciasText.= $gerencia->getDescription() . '-';
            }
            $cont++;
        }

        $links['self']['show'] = $object->getPhase() == \Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle::PHASE_ONE ? $this->generateUrl('pequiven_work_study_circle_show', array('id' => $object->getId())) : $this->generateUrl('pequiven_work_study_circle_show_phase', array('id' => $object->getId()));

        $event->getVisitor()->addData('_links', $links);
        $event->getVisitor()->addData('gerencias', $gerenciasText);
    }

    public function onPostSerializeProposal(ObjectEvent $event) {
        $object = $event->getObject();

        $links['self']['show'] = $this->generateUrl('pequiven_proposal_show', array('id' => $object->getId()));

        $event->getVisitor()->addData('_links', $links);
    }

    public function onPostSerializeMeeting(ObjectEvent $event) {
        $object = $event->getObject();

        $links['self']['show'] = $this->generateUrl('pequiven_meeting_show', array('id' => $object->getId()));

        $event->getVisitor()->addData('_links', $links);
    }

    public function onPostSerializeCutl(ObjectEvent $event) {
        $object = $event->getObject();

        $links['self']['show'] = $this->generateUrl('pequiven_sip_cutl_show', array('id' => $object->getId()));

        $event->getVisitor()->addData('_links', $links);
    }

    public function onPostSerializeCenter(ObjectEvent $event) {
        $object = $event->getObject();

//        $codEstado = $object->getCodigoEstado();
//        $codMunicipio = $object->getCodigoMunicipio();
//        $codParroquia = $object->getCodigoParroquia();
//        $estado = $this->container->get('pequiven.repository.estado')->findOneBy(array('id' => $codEstado));
//        $municipio = $this->container->get('pequiven.repository.municipio')->findOneBy(array('codigoMunicipio' => $codMunicipio));
//        $parroquia = $this->container->get('pequiven.repository.parroquia')->findOneBy(array('codigoParroquia' => $codParroquia, 'codigoMunicipio' => $codMunicipio));

        $links['self']['show'] = $this->generateUrl('pequiven_sip_center_show', array('id' => $object->getId()));

        $event->getVisitor()->addData('_links', $links);
//        $event->getVisitor()->addData('estado', $estado->getDescription());
//        $event->getVisitor()->addData('municipio', $municipio->getDescription());
//        $event->getVisitor()->addData('parroquia', $parroquia->getDescription());
    }

    public function onPostSerializeOnePerTen(ObjectEvent $event) {
        $object = $event->getObject();
        $user = $this->container->get('pequiven.repository.user')->findOneBy(array('id' => $object->getUser()));
        $links['self']['show'] = $this->generateUrl('pequiven_search_members', array('user' => $user->getId()));

        $gerencia = '';
        if ($user->getGerencia() != null) {
            $gerencia = $user->getGerencia()->getDescription();
        }

        $localidad = '';
        if ($user->getComplejo() != null) {
            $localidad = $user->getComplejo()->getDescription();
        }

        $textoVoto = 'NO';
        if ($object->getVasamblea6() == 1) {
            $textoVoto = 'SI';
        }

        $event->getVisitor()->addData('userName', $user->getFirstName() . " " . $user->getLastName());
        $event->getVisitor()->addData('textoVoto', $textoVoto);
        $event->getVisitor()->addData('gerencia', $gerencia);
        $event->getVisitor()->addData('localidad', $localidad);
        $event->getVisitor()->addData('_links', $links);
    }

    public function onPostSerializeNominaCentro(ObjectEvent $event) {
        $object = $event->getObject();
        $user = $this->container->get('pequiven.repository.user')->findOneBy(array('id' => $object->getUserid()));
        $gerencia = '';

        if ($user->getGerencia() != null) {
            $gerencia = $user->getGerencia()->getDescription();
        }

        $textoVoto = 'NO';

        if ($object->getVoto() == 1) {
            $textoVoto = 'SI';
        }

        $links['self']['show'] = $this->generateUrl('pequiven_search_members', array('user' => $user->getId()));

        $event->getVisitor()->addData('textoVoto', $textoVoto);
        $event->getVisitor()->addData('gerencia', $gerencia);
        $event->getVisitor()->addData('_links', $links);
    }

    public function onPostSerializeOnePerTenMembers(ObjectEvent $event) {
        $object = $event->getObject();
        $textoVoto = 'NO';

        if ($object->getVoto() == 1) {
            $textoVoto = 'SI';
        }

//        $links['self']['show'] = $this->generateUrl('pequiven_search_members', array('user' => $user->getID()));

        $event->getVisitor()->addData('textoVoto', $textoVoto);
//        $event->getVisitor()->addData('_links', $links);
    }

    public function onPostSerializeObservationsSip(ObjectEvent $event) {

        $object = $event->getObject();

        $links['self']['show'] = "";

        //$arrayLabel = Observations::getCategoriasObservations();
        //$arrayStatus = Observations::getStatusObservations();
        //$event->getVisitor()->addData('nombreCategoria', $arrayLabel[$object->getCategoria()]);
        //$event->getVisitor()->addData('nombreStatus', $arrayStatus[$object->getStatus()]);
        $event->getVisitor()->addData('_links', $links);
    }

    public function onPostSerializeInventorySip(ObjectEvent $event) {

        $object = $event->getObject();

        $inventory = $this->container->get('pequiven.repository.inventory')->findAll();

        $links['self']['show'] = "";

        //$arrayLabel = Observations::getCategoriasObservations();
        //$arrayStatus = Observations::getStatusObservations();
        //$event->getVisitor()->addData('nombreCategoria', $arrayLabel[$object->getCategoria()]);
        //$event->getVisitor()->addData('nombreStatus', $arrayStatus[$object->getStatus()]);
        $event->getVisitor()->addData('_links', $links);
    }

    public function onPostSerializeMeetingFile(ObjectEvent $event) {
        $object = $event->getObject();


        $nameOriginal = $object->getNameFile();
        $workStudyCircle = $object->getMeeting()->getWorkStudyCircle();

//        $links['self']['show'] = $this->generateUrl('pequiven_proposal_show', array('id' => $object->getId()));
        $links['self']['show'] = $this->generateUrl('pequiven_work_study_circle_download_file', array('id' => $object->getId()));
        $links['self']['circle'] = $this->generateUrl('pequiven_work_study_circle_show', array('id' => $workStudyCircle->getId()));


        $event->getVisitor()->addData('_links', $links);
        $event->getVisitor()->addData('nameOriginal', $nameOriginal);
        $event->getVisitor()->addData('nameWorkStudyCircle', $workStudyCircle->getName());
        $event->getVisitor()->addData('complejo', $workStudyCircle->getComplejo()->getDescription());
    }

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    protected function generateUrl($route, array $parameters) {
        return $this->container->get('fos_rest.router')->generate($route, $parameters, Router::ABSOLUTE_URL);
    }

    function trans($id, $parameters = array(), $domain = 'messages') {
        return $this->container->get('translator')->trans($id, $parameters, $domain);
    }

    function generateAsset($path, $packageName = null) {
        return $this->container->get('templating.helper.assets')
                        ->getUrl($path, $packageName);
    }

    /**
     * Manejador de programa de gestion
     * 
     * @return \Pequiven\ArrangementProgramBundle\Model\ArrangementProgramManager
     */
    private function getArrangementProgramManager() {
        return $this->container->get('seip.arrangement_program.manager');
    }

    /**
     * 
     * @return \Pequiven\ArrangementBundle\Service\ArrangementRangeService
     */
    protected function getArrangementRangeService() {
        return $this->container->get('pequiven_arrangement.service.arrangementrange');
    }

    /**
     * 
     * @return \Pequiven\SEIPBundle\Service\ResultService
     */
    protected function getResultService() {
        return $this->container->get('seip.service.result');
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
    public function getUser() {
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

}
