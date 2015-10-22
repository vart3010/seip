<?php

namespace Pequiven\ArrangementProgramBundle\Entity\MovementEmployee;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * MOVIMIENTO DE EMPLEADOS EN METAS Y PROGRAMAS DE GESTIÓN DURANTE EL PERÍODO
 * @author Gilbert <glavrjk@gmail.com>
 * @ORM\Entity()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @ORM\HasLifecycleCallbacks()
 */
class MovementDetails {

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

    /**
     * TIPO DE MOVIMIENTO: I-> ENTRADA / O-> SALIDA
     * @var string
     *
     * @ORM\Column(name="type", type="text",nullable=false)
     */
    private $type;

    /**
     * @var \DateTime
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var \decimal
     * @ORM\Column(name="realAdvance", type="decimal", nullable=false)
     */
    private $realAdvance;

    /**
     * @var \decimal
     * @ORM\Column(name="planned", type="decimal", nullable=false)
     */
    private $planned;

    /**
     * @var \decimal
     * @ORM\Column(name="penalty", type="decimal", nullable=true)
     */
    private $pentalty;

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

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Get CreatedBy
     * @return type
     */
    function getCreatedBy() {
        return $this->createdBy;
    }

    /**
     * Set CreatedBy
     * @param \Pequiven\SEIPBundle\Entity\User $createdBy
     * @return \Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle
     */
    function setCreatedBy(\Pequiven\SEIPBundle\Entity\User $createdBy) {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return WorkStudyCircle
     */
    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return WorkStudyCircle
     */
    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    function getDeletedAt() {
        return $this->deletedAt;
    }

    function setDeletedAt($deletedAt) {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * 
     * @return type
     */
    function getType() {
        return $this->type;
    }

    /**
     * 
     * @param type $type
     */
    function setType($type) {
        $this->type = $type;
    }

    /**
     * 
     * @param \DateTime $date
     */
    function setDate($date) {
        $this->date = $date;
    }

    /**
     * 
     * @return type
     */
    function getDate() {
        return $this->date;
    }

    /**
     * 
     * @return type
     */
    function getAdvance() {
        return $this->advance;
    }

    /**
     * 
     * @param \float $advance
     */
    function setAdvance($advance) {
        $this->advance = $advance;
    }

    /**
     * 
     * @return type
     */
    function getPentalty() {
        return $this->pentalty;
    }

    /**
     * 
     * @param \float $pentalty
     */
    function setPentalty($pentalty) {
        $this->pentalty = $pentalty;
    }

    /**
     * 
     * @return type
     */
    function getCause() {
        return $this->cause;
    }

    /**
     * 
     * @return type
     */
    function getObservations() {
        return $this->observations;
    }

    /**
     * 
     * @param type $cause
     */
    function setCause($cause) {
        $this->cause = $cause;
    }

    /**
     * 
     * @param type $observations
     */
    function setObservations($observations) {
        $this->observations = $observations;
    }
    
    /**
     * 
     * @return type
     */
    function getrealAdvance() {
        return $this->realAdvance;
    }

    /**
     * 
     * @return type
     */
    function getPlanned() {
        return $this->planned;
    }

    /**
     * 
     * @param type $realAdvance
     */
    function setrealAdvance($realAdvance) {
        $this->realAdvance = $realAdvance;
    }

    /**
     * 
     * @param type $planned
     */
    function setPlanned($planned) {
        $this->planned = $planned;
    }



}
