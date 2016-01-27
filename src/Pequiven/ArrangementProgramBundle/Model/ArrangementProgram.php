<?php

namespace Pequiven\ArrangementProgramBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\SEIPBundle\Service\ResultService;

/**
 * Modelo del programa de gestion
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
abstract class ArrangementProgram {

    const TYPE_ARRANGEMENT_PROGRAM_TACTIC = 1;
    const TYPE_ARRANGEMENT_PROGRAM_OPERATIVE = 2;
    const ASSOCIATE_ARRANGEMENT_PROGRAM_SIG = 1;
    const ASSOCIATE_ARRANGEMENT_PROGRAM_PLA = 2;

    /**
     * Resumen Tipo "Cargados"
     */
    const SUMMARY_TYPE_CHARGED = 'CHARGED';

    /**
     * Resumen Por Status
     */
    const SUMMARY_TYPE_BY_STATUS = 'BY_STATUS';

    /**
     * Resumen Por Notificados
     */
    const SUMMARY_TYPE_NOTIFIED = 'NOTIFIED';

    /**
     * Resumen Por No Notificados
     */
    const SUMMARY_TYPE_NOT_NOTIFIED = 'NOT_NOTIFIED';

    /**
     * Resumen Por Notificados pero con Notificación en Progreso
     */
    const SUMMARY_TYPE_NOTIFIED_BUT_STILL_IN_PROGRESS = 'NOTIFIED_BUT_STILL_IN_PROGRESS';

    /**
     * Estatus borrador
     */
    const STATUS_DRAFT = 0;

    /**
     * Estatus en revision
     */
    const STATUS_IN_REVIEW = 1;

    /**
     * Estatus revisado
     */
    const STATUS_REVISED = 2;

    /**
     * Estatus aprobado
     */
    const STATUS_APPROVED = 3;

    /**
     * Estatus rechazado
     */
    const STATUS_REJECTED = 4;

    /**
     * Estatus finalizado
     */
    const STATUS_FINISHED = 5;

    /**
     * Estatus cerrado
     */
    const STATUS_CLOSED = 6;

    /**
     * Programa de gestión asociada.
     * @var \Pequiven\MasterBundle\Entity\ArrangementProgram\CategoryArrangementProgram
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\MasterBundle\Entity\ArrangementProgram\CategoryArrangementProgram")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $categoryArrangementProgram;

    /**
     * Tipo de programa de gestion
     * @var integer
     *
     * @ORM\Column(name="type", type="integer", nullable=false)
     */
    protected $type;

    /**
     * Sistema de Calidad Asociado.
     * @var \Pequiven\SIGBundle\Entity\ManagementSystem
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SIGBundle\Entity\ManagementSystem")
     */
    protected $managementSystem;

    /**
     * Retorna la etiqueta del tipo de programa de gestion
     * @return string
     */
    function getTypeLabel() {
        $labels = array(
            self::TYPE_ARRANGEMENT_PROGRAM_TACTIC => 'pequiven.arrangement_program.type.tactic',
            self::TYPE_ARRANGEMENT_PROGRAM_OPERATIVE => 'pequiven.arrangement_program.type.operative',
        );
        if (isset($labels[$this->type])) {
            return $labels[$this->type];
        }
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return ArrangementProgram
     */
    public function setStatus($status) {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * Set timeline
     *
     * @param \Pequiven\ArrangementProgramBundle\Entity\Timeline $timeline
     * @return ArrangementProgram
     */
    public function setTimeline(\Pequiven\ArrangementProgramBundle\Entity\Timeline $timeline = null) {
        $this->timeline = $timeline;

        return $this;
    }

    /**
     * Get timeline
     *
     * @return \Pequiven\ArrangementProgramBundle\Entity\Timeline 
     */
    public function getTimeline() {
        return $this->timeline;
    }

    /**
     * Set categoryArrangementProgram
     *
     * @param \Pequiven\MasterBundle\Entity\ArrangementProgram\CategoryArrangementProgram $categoryArrangementProgram
     * @return ArrangementProgram
     */
    public function setCategoryArrangementProgram(\Pequiven\MasterBundle\Entity\ArrangementProgram\CategoryArrangementProgram $categoryArrangementProgram = null) {
        $this->categoryArrangementProgram = $categoryArrangementProgram;

        return $this;
    }

    /**
     * Get categoryArrangementProgram
     *
     * @return \Pequiven\MasterBundle\Entity\ArrangementProgram\CategoryArrangementProgram 
     */
    public function getCategoryArrangementProgram() {
        return $this->categoryArrangementProgram;
    }

    function getType() {
        return $this->type;
    }

    function setType($type) {
        $this->type = $type;

        return $this;
    }

    /**
     * Valida el total del peso de la linea de tiempo
     * @return boolean
     */
    function isValidTimeLine() {
        $timeline = $this->getTimeline();
        //Sino se asigno ninguna meta al crear el programa de gestion
        if (!$timeline) {
            return;
        }
        $weight = 0;
        foreach ($timeline->getGoals() as $goal) {
            $weight+= $goal->getWeight();
        }
        if ($weight > 100) {
            return false;
        }
        return true;
    }

    /**
     * Valida que cada meta tenga por lo menos un reponsable
     * @return boolean
     */
    function isValidResponsiblesGoals() {
        $timeline = $this->getTimeline();
        //Sino se asigno ninguna meta al crear el programa de gestion
        if (!$timeline) {
            return;
        }
        $valid = true;
        foreach ($timeline->getGoals() as $goal) {
            if ($goal->getResponsibles()->count() == 0) {
                $valid = false;
                break;
            }
        }
        return $valid;
    }

    /**
     * Valida si el programa de gestion tiene asignados los responsables
     * @return boolean
     */
    function isValidResponsibles() {
        $responsibles = $this->getResponsibles();
        if ($responsibles != null && $responsibles->count() > 0) {
            return true;
        }
        return false;
    }

    /**
     * Retorna las etiquetas definidas para los estatus del programa de gestion
     * 
     * @staticvar array $labelsStatus
     * @return string
     */
    static function getLabelsStatus() {
        static $labelsStatus = array(
            self::STATUS_DRAFT => 'pequiven.arrangement_program.status.draft',
            self::STATUS_IN_REVIEW => 'pequiven.arrangement_program.status.in_review',
            self::STATUS_REVISED => 'pequiven.arrangement_program.status.revised',
            self::STATUS_APPROVED => 'pequiven.arrangement_program.status.approved',
            self::STATUS_REJECTED => 'pequiven.arrangement_program.status.rejected',
            self::STATUS_FINISHED => 'pequiven.arrangement_program.status.finished',
        );
        return $labelsStatus;
    }

    /**
     * Retorna la etiqueta que corresponde a un estatus del programa de gestion
     * @return string
     */
    function getLabelStatus() {
        $labels = $this->getLabelsStatus();
        if (isset($labels[$this->status])) {
            return $labels[$this->status];
        }
    }

    /**
     * Retorna el porcentaje de avance del programa de gestion
     * 
     * @param array $options limitMonthToNow: limita los resultados al mes actual
     * @return type
     */
    function getSummary(array $options = array(), $em = null) {

        $summary = array(
            'weight' => 0,
            'advances' => 0,
            'advancesPlanned' => 0,
            'dateStartPlanned' => null,
            'dateStartReal' => null,
            'dateEndPlanned' => null,
            'dateEndReal' => null,
        );

        $refresh = false;
        if (isset($options['refresh']) && $options['refresh'] == true) {
            $refresh = true;
        }

        $limitMonthToNow = false;
        $month = null;
        if (isset($options['limitMonthToNow'])) {
            $date = new \DateTime();
            $month = $date->format('m');
            $limitMonthToNow = (boolean) $options['limitMonthToNow'];
        }
        $totalWeight = 0;
        $advancesReal = 0;
        $advancesPlanned = 0;
        $timeline = $this->getTimeline();
        $advancesGoalDetailsReal = array();
        $advancesGoalDetailsPlanned = array();
        $dateStartPlanned = $dateStartReal = $dateEndPlanned = $dateEndReal = null;
        $realMonthDateStart = 13;
        $realMonthDateEnd = -1;

        if ($timeline) {
            $propertyAccessor = \Symfony\Component\PropertyAccess\PropertyAccess::createPropertyAccessor();
            foreach ($timeline->getGoals() as $goal) {
                $advanceRealGoal = $advanceRealGoalWeight = 0.0;
                //Buscar la fecha de inicio planificada
                if ($dateStartPlanned === null || $dateStartPlanned > $goal->getStartDate()) {
                    $dateStartPlanned = $goal->getStartDate();
                }
                //Buscar la fecha de fin planificada
                if ($dateEndPlanned === null || $dateEndPlanned < $goal->getEndDate()) {
                    $dateEndPlanned = $goal->getEndDate();
                }
                $goalDetails = $goal->getGoalDetails();

                $weight = 0;
                if ($goalDetails !== null && $goalDetails->getGoal() !== null) {
                    $weight = $goalDetails->getGoal()->getWeight();
                }
                $totalWeight += $weight;
                $reflection = new \ReflectionClass($goalDetails);
                $nameMatchReal = '^get\w+Real$';
                $nameMatchPlanned = '^get\w+Planned$';
                foreach ($reflection->getMethods() as $method) {
                    $methodName = $method->getName();
                    if (preg_match('/' . $nameMatchReal . '/i', $methodName)) {
                        $class = $method->getDeclaringClass();
                        if (!strpos($class, 'Pequiven\ArrangementProgramBundle\Entity\GoalDetails')) {
                            continue;
                        }
                        $real = $goalDetails->$methodName();
                        $advanceReal = (($weight / 100) * $real);
                        $nameProperty = GoalDetails::getRealNameProperty($methodName);
                        if (!isset($advancesGoalDetailsReal[$nameProperty])) {
                            $advancesGoalDetailsReal[$nameProperty] = 0;
                        }
                        $advancesGoalDetailsReal[$nameProperty] += $advanceReal;
                        $advancesReal += $advanceReal;
                        $advanceRealGoal += $real;
                        $advanceRealGoalWeight += $advanceReal;

                        $month = GoalDetails::getMonthOfReal($nameProperty);
                        if ($real > 0 && $realMonthDateStart > $month) {
                            $realMonthDateStart = $month;
                        }
                        if ($real > 0 && $realMonthDateEnd < $month) {
                            $realMonthDateEnd = $month;
                        }
                    }
                    if (preg_match('/' . $nameMatchPlanned . '/i', $methodName)) {
                        $class = $method->getDeclaringClass();
                        if (!strpos($class, 'Pequiven\ArrangementProgramBundle\Entity\GoalDetails')) {
                            continue;
                        }
                        if ($limitMonthToNow === true) {
                            $plannedString = GoalDetails::getRealNameProperty($methodName);
                            $plannedMonth = GoalDetails::getMonthOfPlanned($plannedString);
                            if ($plannedMonth > $month) {
                                continue;
                            }
                        }
                        $planned = $goalDetails->$methodName();
                        $advancePlanned = ($weight / 100) * $planned;

                        $nameProperty = GoalDetails::getRealNameProperty($methodName);
                        if (!isset($advancesGoalDetailsPlanned[$nameProperty])) {
                            $advancesGoalDetailsPlanned[$nameProperty] = 0;
                        }
                        $advancesGoalDetailsPlanned[$nameProperty] += $advancePlanned;
                        $advancesPlanned += $advancePlanned;
                    }
                }

                if (($refresh == true) && ( $em <> null)) {
                    //RESTAURO EL VALOR DE LA META
                    $goal->setAdvance($advanceRealGoal);
                    $goal->setResultReal($advanceRealGoal);

                    //SALVO EL VALOR DE LA META CUANDO ESTA SOBREPASA LOS 120% DE CUMPLIMIENTO O QUEDA COMO NEGATIVO
                    $goal->setRealResult($advanceRealGoal);
                    $em->persist($goal);
                    $em->flush();
                }             
            }
        }

        if ($dateStartPlanned) {
            $dateStartReal = clone($dateStartPlanned);
        }
        if ($dateEndPlanned) {
            $dateEndReal = clone($dateEndPlanned);
        }
        if ($realMonthDateStart != 13) {
            $dateStartReal->setDate($dateStartReal->format('Y'), $realMonthDateStart, 1);
        }
        if ($realMonthDateEnd != -1) {
            $dateEndReal->setDate($dateEndReal->format('Y'), $realMonthDateEnd, \Pequiven\SEIPBundle\Service\ToolService::getLastDayMonth($dateEndReal->format('Y'), $realMonthDateEnd));
        }

//        die;
        $summary['advances'] = $advancesReal;
        $summary['weight'] = $totalWeight;
        $summary['advancesPlanned'] = $advancesPlanned;
        $summary['detailsAdvancesPlanned'] = $advancesGoalDetailsPlanned;
        $summary['detailsAdvancesReal'] = $advancesGoalDetailsReal;
        $summary['dateStartPlanned'] = $dateStartPlanned;
        $summary['dateEndPlanned'] = $dateEndPlanned;
        $summary['dateStartReal'] = $dateStartReal;
        $summary['dateEndReal'] = $dateEndReal;
        return $summary;
    }

    /**
     * Retorna true si se puede editar el programa de gestion
     * 
     * @return boolean
     */
    final public function isEditable() {
        $valid = true;
        $status = array(self::STATUS_APPROVED, self::STATUS_FINISHED, self::STATUS_CLOSED);

        if (in_array($this->status, $status, true)) {
            $valid = false;
        }
        return $valid;
    }

    /**
     * Retorna true si se puede reportar avances en el programa de gestion
     * 
     * @return boolean
     */
    final public function isNotificable() {
        $valid = false;
        $status = array(self::STATUS_APPROVED);
        if (in_array($this->status, $status, true)) {
            $valid = true;
        }
        return $valid;
    }

    /**
     * Retorna true si se puede planificar en el programa de gestion
     * 
     * @return boolean
     */
    final public function isPlanneable() {
        $valid = true;
        $status = array(self::STATUS_FINISHED, self::STATUS_CLOSED, self::STATUS_APPROVED, self::STATUS_REJECTED);
        if (in_array($this->status, $status, true)) {
            $valid = false;
        }
        return $valid;
    }

    /**
     * Devuelve el objetivo dependiendo del tipo de programa de gestion
     */
    function getObjetiveByType() {
        $objetive = null;
        if ($this->getType() == self::TYPE_ARRANGEMENT_PROGRAM_TACTIC) {
            $objetive = $this->getTacticalObjective();
        } elseif ($this->getType() == self::TYPE_ARRANGEMENT_PROGRAM_OPERATIVE) {
            $objetive = $this->getOperationalObjective();
        }
        return $objetive;
    }

    /**
     * Devuelve el objetivo tactico
     */
    public function getTacticalObjective() {
        
    }

    /**
     * Devuelve el objetivo operativo
     */
    public function getOperationalObjective() {
        
    }

    /**
     * Set ManagementSystem
     *
     * @param \Pequiven\SIGBundle\Entity\ManagementSystem $managementSystem
     * @return ArrangementProgram
     */
    public function setManagementSystem(\Pequiven\SIGBundle\Entity\ManagementSystem $managementSystem = null) {
        $this->managementSystem = $managementSystem;

        return $this;
    }

    /**
     * Get getManagementSystem
     *
     * @return \Pequiven\SIGBundle\Entity\ManagementSystem 
     */
    public function getManagementSystem() {
        return $this->managementSystem;
    }

}
