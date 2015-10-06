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
     * CAUSA DE MOVIMIENTO: A-> AUSENCIA / C-> CAMBIO
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

    /**
     * TIPO DE MOVIMIENTO: A-> META / B-> PROGRAMA DE GESTIÓN / C-> OBJ. OPERATIVO / D-> OBJ. TACTICO / E-> OBJ. ESTRATÉGICO
     * @var string
     *
     * @ORM\Column(name="type", type="text",nullable=false)
     */
    private $type;

    /**
     * ID DE LA META, SERÁ LA BASE DE LOS CALCULOS DE AVANCE SIN EMBARGO LA PREDOMINACIÓN DE LA BUSQUEDA LO DEFINE EL TYPE
     * @ORM\ManyToOne(targetEntity="Pequiven\ArrangementProgramBundle\Entity\Goal",inversedBy="movementEmployee")
     * @ORM\JoinColumn(name="goal_id", referencedColumnName="id", nullable=false)
     */
    private $Goal;

    /**
     * Periodo.
     * @var \Pequiven\SEIPBundle\Entity\Period
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Period")
     * @ORM\JoinColumn(nullable=false)
     */
    private $period;

    /**
     * ID DE DETALLE DE ENTRADA
     * @ORM\OneToOne(targetEntity="Pequiven\ArrangementProgramBundle\Entity\MovementEmployee\MovementDetails")
     * @ORM\JoinColumn(name="in_id", referencedColumnName="id", nullable=false) 
     */
    private $in;

    /**
     * ID DE DETALLE DE SALIDA
     * @ORM\OneToOne(targetEntity="Pequiven\ArrangementProgramBundle\Entity\MovementEmployee\MovementDetails")
     *  @ORM\JoinColumn(name="out_id", referencedColumnName="id", nullable=true) 
     */
    private $out;

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
    function getGoal() {
        return $this->Goal;
    }

    /**
     * 
     * @param type $Goal
     */
    function setGoal($Goal) {
        $this->Goal = $Goal;
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
     * @param type $cause
     */
    function setCause($cause) {
        $this->cause = $cause;
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
     * @param type $observations
     */
    function setObservations($observations) {
        $this->observations = $observations;
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
    
    function getIn() {
        return $this->in;
    }

    function getOut() {
        return $this->out;
    }

    function setIn($in) {
        $this->in = $in;
    }

    function setOut($out) {
        $this->out = $out;
    }



}
