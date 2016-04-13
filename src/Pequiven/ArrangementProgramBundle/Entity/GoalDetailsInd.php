<?php

namespace Pequiven\ArrangementProgramBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Tpg\ExtjsBundle\Annotation as Extjs;
use Pequiven\ArrangementProgramBundle\Entity\GoalDetails;
use Pequiven\SEIPBundle\Entity\User;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Detalles de la meta
 *
 * @Extjs\Model
 * @Extjs\ModelProxy("/api/goals/details")
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Pequiven\ArrangementProgramBundle\Repository\GoalDetailsIndRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class GoalDetailsInd {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * Estatus
     * @var integer
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status = 0;

    /**
     * Meta
     * 
     * @var \Pequiven\ArrangementProgramBundle\Entity\GoalDetails
     * @ORM\ManyToOne(targetEntity="Pequiven\ArrangementProgramBundle\Entity\GoalDetails",inversedBy="goalDetailsInd")
     */
    private $goalDetails;

    /**
     * Meta
     * 
     * @var \Pequiven\SEIPBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\User",inversedBy="goalDetailsInd")
     */
    private $user;

    /**
     * Planificado para enero
     * @var float
     *
     * @ORM\Column(name="januaryPlanned", type="float",nullable=true)
     */
    public $januaryPlanned;

    /**
     * Real de enero
     * @var float
     *
     * @ORM\Column(name="januaryReal", type="float",nullable=true)
     */
    private $januaryReal;

    /**
     * Planificado para febrero
     * @var float
     *
     * @ORM\Column(name="februaryPlanned", type="float",nullable=true)
     */
    public $februaryPlanned;

    /**
     * Real de febrero
     * @var float
     *
     * @ORM\Column(name="februaryReal", type="float",nullable=true)
     */
    private $februaryReal;

    /**
     * Planificado para marzo
     * @var float
     *
     * @ORM\Column(name="marchPlanned", type="float",nullable=true)
     */
    public $marchPlanned;

    /**
     * @var float
     *
     * @ORM\Column(name="marchReal", type="float",nullable=true)
     */
    private $marchReal;

    /**
     * Planificado para abril
     * @var float
     *
     * @ORM\Column(name="aprilPlanned", type="float",nullable=true)
     */
    public $aprilPlanned;

    /**
     * Real de abril
     * @var float
     *
     * @ORM\Column(name="aprilReal", type="float",nullable=true)
     */
    private $aprilReal;

    /**
     * Planificado para mayo
     * @var float
     *
     * @ORM\Column(name="mayPlanned", type="float",nullable=true)
     */
    public $mayPlanned;

    /**
     * Real de mayo
     * @var float
     *
     * @ORM\Column(name="mayReal", type="float",nullable=true)
     */
    private $mayReal;

    /**
     * Planificado para junio
     * @var float
     *
     * @ORM\Column(name="junePlanned", type="float",nullable=true)
     */
    public $junePlanned;

    /**
     * Real de junio
     * @var float
     *
     * @ORM\Column(name="juneReal", type="float",nullable=true)
     */
    private $juneReal;

    /**
     * Planificado para julio
     * @var float
     *
     * @ORM\Column(name="julyPlanned", type="float",nullable=true)
     */
    public $julyPlanned;

    /**
     * Real de julio
     * @var float
     *
     * @ORM\Column(name="julyReal", type="float",nullable=true)
     */
    private $julyReal;

    /**
     * Planificado para agosto
     * @var float
     *
     * @ORM\Column(name="augustPlanned", type="float",nullable=true)
     */
    public $augustPlanned;

    /**
     * Real de agosto
     * @var float
     *
     * @ORM\Column(name="augustReal", type="float",nullable=true)
     */
    private $augustReal;

    /**
     * Planificado para septiembre
     * @var float
     *
     * @ORM\Column(name="septemberPlanned", type="float",nullable=true)
     */
    public $septemberPlanned;

    /**
     * Real de septiembre
     * @var float
     *
     * @ORM\Column(name="septemberReal", type="float",nullable=true)
     */
    private $septemberReal;

    /**
     * Planificado para octubre
     * @var float
     *
     * @ORM\Column(name="octoberPlanned", type="float",nullable=true)
     */
    public $octoberPlanned;

    /**
     * Real de octubre
     * @var float
     *
     * @ORM\Column(name="octoberReal", type="float",nullable=true)
     */
    private $octoberReal;

    /**
     * Planificado para noviembre
     * @var float
     *
     * @ORM\Column(name="novemberPlanned", type="float",nullable=true)
     */
    public $novemberPlanned;

    /**
     * Real de noviembre
     * @var float
     *
     * @ORM\Column(name="novemberReal", type="float",nullable=true)
     */
    private $novemberReal;

    /**
     * Planificado para diciembre
     * @var float
     *
     * @ORM\Column(name="decemberPlanned", type="float",nullable=true)
     */
    public $decemberPlanned;

    /**
     * Real de diciembre
     * @var float
     *
     * @ORM\Column(name="decemberReal", type="float",nullable=true)
     */
    private $decemberReal;

    /**
     * Penalizacion
     * @var integer
     *
     * @ORM\Column(name="penalty", type="integer", nullable=true)
     */
    private $penalty = 0;

    /**
     * Penalizacion de Porcentaje
     * @var integer
     *
     * @ORM\Column(name="percentagepenalty", type="float", nullable=true)
     */
    private $percentagepenalty = 0;

    /**
     * Resultado Antes de la Penalización
     * @var float
     *
     * @ORM\Column(name="resultbeforepenalty", type="float", nullable=true)
     */
    private $resultBeforepenalty = 0;

    function getId() {
        return $this->id;
    }

    function getDeletedAt() {
        return $this->deletedAt;
    }

    function getStatus() {
        return $this->status;
    }

    function getGoalDetails() {
        return $this->goalDetails;
    }

    function getUser() {
        return $this->user;
    }

    function getJanuaryReal() {
        return $this->januaryReal;
    }

    function getFebruaryReal() {
        return $this->februaryReal;
    }

    function getMarchReal() {
        return $this->marchReal;
    }

    function getAprilReal() {
        return $this->aprilReal;
    }

    function getMayReal() {
        return $this->mayReal;
    }

    function getJuneReal() {
        return $this->juneReal;
    }

    function getJulyReal() {
        return $this->julyReal;
    }

    function getAugustReal() {
        return $this->augustReal;
    }

    function getSeptemberReal() {
        return $this->septemberReal;
    }

    function getOctoberReal() {
        return $this->octoberReal;
    }

    function getNovemberReal() {
        return $this->novemberReal;
    }

    function getDecemberReal() {
        return $this->decemberReal;
    }

    function getPenalty() {
        return $this->penalty;
    }

    function getPercentagepenalty() {
        return $this->percentagepenalty;
    }

    function getResultBeforepenalty() {
        return $this->resultBeforepenalty;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDeletedAt($deletedAt) {
        $this->deletedAt = $deletedAt;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setGoalDetails(\Pequiven\ArrangementProgramBundle\Entity\GoalDetails $goalDetails) {
        $this->goalDetails = $goalDetails;
    }

    function setUser(\Pequiven\SEIPBundle\Entity\User $user) {
        $this->user = $user;
    }

    function setJanuaryReal($januaryReal) {
        $this->januaryReal = $januaryReal;
    }

    function setFebruaryReal($februaryReal) {
        $this->februaryReal = $februaryReal;
    }

    function setMarchReal($marchReal) {
        $this->marchReal = $marchReal;
    }

    function setAprilReal($aprilReal) {
        $this->aprilReal = $aprilReal;
    }

    function setMayReal($mayReal) {
        $this->mayReal = $mayReal;
    }

    function setJuneReal($juneReal) {
        $this->juneReal = $juneReal;
    }

    function setJulyReal($julyReal) {
        $this->julyReal = $julyReal;
    }

    function setAugustReal($augustReal) {
        $this->augustReal = $augustReal;
    }

    function setSeptemberReal($septemberReal) {
        $this->septemberReal = $septemberReal;
    }

    function setOctoberReal($octoberReal) {
        $this->octoberReal = $octoberReal;
    }

    function setNovemberReal($novemberReal) {
        $this->novemberReal = $novemberReal;
    }

    function setDecemberReal($decemberReal) {
        $this->decemberReal = $decemberReal;
    }

    function setPenalty($penalty) {
        $this->penalty = $penalty;
    }

    function setPercentagepenalty($percentagepenalty) {
        $this->percentagepenalty = $percentagepenalty;
    }

    function setResultBeforepenalty($resultBeforepenalty) {
        $this->resultBeforepenalty = $resultBeforepenalty;
    }

    function getJanuaryPlanned() {
        $this->getGoalDetails()->getJanuaryPlanned();
    }

    function getFebruaryPlanned() {
        $this->getGoalDetails()->getFebruaryPlanned();
    }

    function getMarchPlanned() {
        $this->getGoalDetails()->getMarchPlanned();
    }

    function getAprilPlanned() {
        $this->getGoalDetails()->getAprilPlanned();
    }

    function getMayPlanned() {
        $this->getGoalDetails()->getMayPlanned();
    }

    function getJunePlanned() {
        $this->getGoalDetails()->getJunePlanned();
    }

    function getJulyPlanned() {
        $this->getGoalDetails()->getJulyPlanned();
    }

    function getAugustPlanned() {
        $this->getGoalDetails()->getAugustPlanned();
    }

    function getSeptemberPlanned() {
        $this->getGoalDetails()->getSeptemberPlanned();
    }

    function getOctoberPlanned() {
        $this->getGoalDetails()->getOctoberPlanned();
    }

    function getNovemberPlanned() {
        $this->getGoalDetails()->getNovemberPlanned();
    }

    function getDecemberPlanned() {
        $this->getGoalDetails()->getDecemberPlanned();
    }

    public function __toString() {
        $toString = $this->getId() ? '' . $this->getId() : '-';
        return $toString;
    }

    public function __clone() {
        if ($this->id > 0) {
            $this->id = null;
            $this->goal = null;
        }
    }

}
