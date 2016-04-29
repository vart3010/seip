<?php

namespace Pequiven\SEIPBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * MOVIMIENTO DE EMPLEADOS EN CARGOS DURANTE EL PERÍODO
 * @author Gilbert <glavrjk@gmail.com>
 * @ORM\Entity()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @ORM\Table(name="MovementFeeStructure")
 */
class MovementFeeStructure {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $createdBy;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updatedAt", type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;

    /** ID USUARIO
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\User",inversedBy="movementFeeStructure")
     * @ORM\JoinColumn(nullable=true)
     */
    private $User;

    /**
     * Periodo.
     * @var \Pequiven\SEIPBundle\Entity\Period
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Period")
     * @ORM\JoinColumn(nullable=false)
     */
    private $period;

    /**
     * @var \DateTime
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * ID AFECTADO EN FeeStructure
     * @var integer
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\User\FeeStructure",inversedBy="movementFeeStructure")
     * @ORM\JoinColumn(nullable=false)
     */
    private $feestructure;

    /**
     * TIPO DE MOVIMIENTO: I-> ENTRADA / O-> SALIDA
     * @var string
     *
     * @ORM\Column(name="type", type="text",nullable=false)
     */
    private $type;

    /**
     * CAUSA DE MOVIMIENTO: ASIG-> ASIGNACIÓN / SUP->SUPLENCIA / AUS-> AUSENCIA / CAMB-> CAMBIO
     * @var string
     *
     * @ORM\Column(name="cause", type="text",nullable=false)
     */
    private $cause;

    /**
     * OBSERVACIONES
     * @var string
     *
     * @ORM\Column(name="observations", type="text",nullable=true)
     */
    private $observations;

    public function __construct() {
        //$this->assistances = new \Doctrine\Common\Collections\ArrayCollection();
        //$this->meetingFile = new \Doctrine\Common\Collections\ArrayCollection();
    }

    function getId() {
        return $this->id;
    }

    function getCreatedBy() {
        return $this->createdBy;
    }

    function getCreatedAt() {
        return $this->createdAt;
    }

    function getUpdatedAt() {
        return $this->updatedAt;
    }

    function getDeletedAt() {
        return $this->deletedAt;
    }

    function getUser() {
        return $this->User;
    }

    function getType() {
        return $this->type;
    }

    function getFeestructure() {
        return $this->feestructure;
    }

    function getPeriod() {
        return $this->period;
    }

    function getDate() {
        return $this->date;
    }

    function getCause() {
        return $this->cause;
    }

    function getObservations() {
        return $this->observations;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCreatedBy($createdBy) {
        $this->createdBy = $createdBy;
    }

    function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }

    function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    function setDeletedAt($deletedAt) {
        $this->deletedAt = $deletedAt;
    }

    function setUser($User) {
        $this->User = $User;
    }

    function setType($type) {
        $this->type = $type;
    }

    function setFeestructure($feestructure) {
        $this->feestructure = $feestructure;
    }

    function setPeriod(\Pequiven\SEIPBundle\Entity\Period $period) {
        $this->period = $period;
    }

    function setDate($date) {
        $this->date = $date;
    }

    function setCause($cause) {
        $this->cause = $cause;
    }

    function setObservations($observations) {
        $this->observations = $observations;
    }

}
