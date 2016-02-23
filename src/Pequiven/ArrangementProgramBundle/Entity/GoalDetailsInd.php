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
     * Real de enero
     * @var float
     *
     * @ORM\Column(name="januaryReal", type="float",nullable=true)
     */
    private $januaryReal;

    /**
     * Real de febrero
     * @var float
     *
     * @ORM\Column(name="februaryReal", type="float",nullable=true)
     */
    private $februaryReal;

    /**
     * @var float
     *
     * @ORM\Column(name="marchReal", type="float",nullable=true)
     */
    private $marchReal;

    /**
     * Real de abril
     * @var float
     *
     * @ORM\Column(name="aprilReal", type="float",nullable=true)
     */
    private $aprilReal;

    /**
     * Real de mayo
     * @var float
     *
     * @ORM\Column(name="mayReal", type="float",nullable=true)
     */
    private $mayReal;

    /**
     * Real de junio
     * @var float
     *
     * @ORM\Column(name="juneReal", type="float",nullable=true)
     */
    private $juneReal;

    /**
     * Real de julio
     * @var float
     *
     * @ORM\Column(name="julyReal", type="float",nullable=true)
     */
    private $julyReal;

    /**
     * Real de agosto
     * @var float
     *
     * @ORM\Column(name="augustReal", type="float",nullable=true)
     */
    private $augustReal;

    /**
     * Real de septiembre
     * @var float
     *
     * @ORM\Column(name="septemberReal", type="float",nullable=true)
     */
    private $septemberReal;

    /**
     * Real de octubre
     * @var float
     *
     * @ORM\Column(name="octoberReal", type="float",nullable=true)
     */
    private $octoberReal;

    /**
     * Real de noviembre
     * @var float
     *
     * @ORM\Column(name="novemberReal", type="float",nullable=true)
     */
    private $novemberReal;

    /**
     * Real de diciembre
     * @var float
     *
     * @ORM\Column(name="decemberReal", type="float",nullable=true)
     */
    private $decemberReal;

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

    function setId($id) {
        $this->id = $id;
    }

    function setDeletedAt($deletedAt) {
        $this->deletedAt = $deletedAt;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setGoalDetails(GoalDetails $goalDetails) {
        $this->goalDetails = $goalDetails;
    }

    function setUser(User $user) {
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
