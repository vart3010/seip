<?php

namespace Pequiven\ArrangementProgramBundle\Entity\MovementEmployee;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * MOVIMIENTO DE EMPLEADOS EN METAS Y PROGRAMAS DE GESTIÓN DURANTE EL PERÍODO
 * @author Gilbert <glavrjk@gmail.com>
 * @ORM\Entity
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @ORM\Entity("Pequiven\ArrangementProgramBundle\Repository\MovementEmployee\MovementEmployeeRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class MovementEmployee {

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
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\User",inversedBy="movementEmployee")
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;

    /**
     * TIPO DE MOVIMIENTO: GOAL-> META / AP-> PROGRAMA DE GESTIÓN / OBJO-> OBJ. OPERATIVO / OBJT-> OBJ. TACTICO / OBJT-> OBJ. ESTRATÉGICO
     * @var string
     *
     * @ORM\Column(name="typeMov", type="text",nullable=false)
     */
    private $typeMov;

    /**
     * ID AFECTADO EN EL CAMPO. LA TABLA REFERENCIADA LO DEFINE EL CAMPO TYPE
     * @var integer
     *
     * @ORM\Column(name="id_affected", type="integer",nullable=false)
     */
    private $id_affected;

    /**
     * Periodo.
     * @var \Pequiven\SEIPBundle\Entity\Period
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Period")
     * @ORM\JoinColumn(nullable=false)
     */
    private $period;

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
     * @var \float
     * @ORM\Column(name="realAdvance", type="float", nullable=false)
     */
    private $realAdvance;

    /**
     * @var \float
     * @ORM\Column(name="planned", type="float", nullable=false)
     */
    private $planned;

    /**
     * @var \float
     * @ORM\Column(name="penalty", type="float", nullable=true)
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

    /**
     * 
     * @return type
     */
    function getDeletedAt() {
        return $this->deletedAt;
    }

    /**
     * 
     * @param type $deletedAt
     * @return \Pequiven\ArrangementProgramBundle\Entity\MovementEmployee\MovementEmployee
     */
    function setDeletedAt($deletedAt) {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * 
     * @return type
     */
    function getUser() {
        return $this->User;
    }

    /**
     * 
     * @param type $User
     */
    function setUser($User) {
        $this->User = $User;
    }

    /**
     * 
     * @return type
     */
    function getId_Affected() {
        return $this->id_affected;
    }

    /**
     * 
     * @param type $id_affected
     */
    function setId_Affected($id_affected) {
        $this->id_affected = $id_affected;
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
     * @return type
     */
    function getPeriod() {
        return $this->period;
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
     * @param \Pequiven\SEIPBundle\Entity\Period $period
     */
    function setPeriod(\Pequiven\SEIPBundle\Entity\Period $period = null) {
        $this->period = $period;
    }
    
    function getTypeMov() {
        return $this->typeMov;
    }

    function getDate() {
        return $this->date;
    }

    function getRealAdvance() {
        return $this->realAdvance;
    }

    function getPlanned() {
        return $this->planned;
    }

    function getPentalty() {
        return $this->pentalty;
    }

    function getCause() {
        return $this->cause;
    }

    function getObservations() {
        return $this->observations;
    }

    function setTypeMov($typeMov) {
        $this->typeMov = $typeMov;
    }

    function setDate($date) {
        $this->date = $date;
    }

    function setRealAdvance($realAdvance) {
        $this->realAdvance = $realAdvance;
    }

    function setPlanned($planned) {
        $this->planned = $planned;
    }

    function setPentalty($pentalty) {
        $this->pentalty = $pentalty;
    }

    function setCause($cause) {
        $this->cause = $cause;
    }

    function setObservations($observations) {
        $this->observations = $observations;
    }



    

}
