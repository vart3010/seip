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
    private $januaryPlanned;

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
    private $februaryPlanned;

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
    private $marchPlanned;

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
    private $aprilPlanned;

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
    private $mayPlanned;

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
    private $junePlanned;

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
    private $julyPlanned;

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
    private $augustPlanned;

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
    private $septemberPlanned;

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
    private $octoberPlanned;

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
    private $novemberPlanned;

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
    private $decemberPlanned;

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

    function getJanuaryPlanned() {
        return $this->januaryPlanned;
    }

    function getJanuaryReal() {
        return $this->januaryReal;
    }

    function getFebruaryPlanned() {
        return $this->februaryPlanned;
    }

    function getFebruaryReal() {
        return $this->februaryReal;
    }

    function getMarchPlanned() {
        return $this->marchPlanned;
    }

    function getMarchReal() {
        return $this->marchReal;
    }

    function getAprilPlanned() {
        return $this->aprilPlanned;
    }

    function getAprilReal() {
        return $this->aprilReal;
    }

    function getMayPlanned() {
        return $this->mayPlanned;
    }

    function getMayReal() {
        return $this->mayReal;
    }

    function getJunePlanned() {
        return $this->junePlanned;
    }

    function getJuneReal() {
        return $this->juneReal;
    }

    function getJulyPlanned() {
        return $this->julyPlanned;
    }

    function getJulyReal() {
        return $this->julyReal;
    }

    function getAugustPlanned() {
        return $this->augustPlanned;
    }

    function getAugustReal() {
        return $this->augustReal;
    }

    function getSeptemberPlanned() {
        return $this->septemberPlanned;
    }

    function getSeptemberReal() {
        return $this->septemberReal;
    }

    function getOctoberPlanned() {
        return $this->octoberPlanned;
    }

    function getOctoberReal() {
        return $this->octoberReal;
    }

    function getNovemberPlanned() {
        return $this->novemberPlanned;
    }

    function getNovemberReal() {
        return $this->novemberReal;
    }

    function getDecemberPlanned() {
        return $this->decemberPlanned;
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

    function setJanuaryPlanned($januaryPlanned) {
        $this->januaryPlanned = $januaryPlanned;
    }

    function setJanuaryReal($januaryReal) {
        $this->januaryReal = $januaryReal;
    }

    function setFebruaryPlanned($februaryPlanned) {
        $this->februaryPlanned = $februaryPlanned;
    }

    function setFebruaryReal($februaryReal) {
        $this->februaryReal = $februaryReal;
    }

    function setMarchPlanned($marchPlanned) {
        $this->marchPlanned = $marchPlanned;
    }

    function setMarchReal($marchReal) {
        $this->marchReal = $marchReal;
    }

    function setAprilPlanned($aprilPlanned) {
        $this->aprilPlanned = $aprilPlanned;
    }

    function setAprilReal($aprilReal) {
        $this->aprilReal = $aprilReal;
    }

    function setMayPlanned($mayPlanned) {
        $this->mayPlanned = $mayPlanned;
    }

    function setMayReal($mayReal) {
        $this->mayReal = $mayReal;
    }

    function setJunePlanned($junePlanned) {
        $this->junePlanned = $junePlanned;
    }

    function setJuneReal($juneReal) {
        $this->juneReal = $juneReal;
    }

    function setJulyPlanned($julyPlanned) {
        $this->julyPlanned = $julyPlanned;
    }

    function setJulyReal($julyReal) {
        $this->julyReal = $julyReal;
    }

    function setAugustPlanned($augustPlanned) {
        $this->augustPlanned = $augustPlanned;
    }

    function setAugustReal($augustReal) {
        $this->augustReal = $augustReal;
    }

    function setSeptemberPlanned($septemberPlanned) {
        $this->septemberPlanned = $septemberPlanned;
    }

    function setSeptemberReal($septemberReal) {
        $this->septemberReal = $septemberReal;
    }

    function setOctoberPlanned($octoberPlanned) {
        $this->octoberPlanned = $octoberPlanned;
    }

    function setOctoberReal($octoberReal) {
        $this->octoberReal = $octoberReal;
    }

    function setNovemberPlanned($novemberPlanned) {
        $this->novemberPlanned = $novemberPlanned;
    }

    function setNovemberReal($novemberReal) {
        $this->novemberReal = $novemberReal;
    }

    function setDecemberPlanned($decemberPlanned) {
        $this->decemberPlanned = $decemberPlanned;
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
