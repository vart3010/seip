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

    /** ID USUARIO
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\User",inversedBy="movementEmployee")
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;

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
     * @ORM\Column(name="planned", type="float", nullable=false)
     */
    private $planned;
    
    /**
     * @var \float
     * @ORM\Column(name="real_advance", type="float", nullable=false)
     */
    private $real_advance;
    
    /**
     * @var \float
     * @ORM\Column(name="advance", type="float", nullable=false)
     */
    private $advance;
    
    /**
     * @var \float
     * @ORM\Column(name="beforepenalty", type="float", nullable=true)
     */
    private $beforePenalty;
    
    /**
     * @var \float
     * @ORM\Column(name="penalty", type="float", nullable=true)
     */
    private $pentalty;
    

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
     * @return type
     */
    function getDate() {
        return $this->date;
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
     * @return type
     */
    function getAdvance() {
        return $this->advance;
    }

    /**
     * 
     * @return type
     */
    function getBeforePenalty() {
        return $this->beforePenalty;
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
     * @param \DateTime $date
     */
    function setDate($date) {
        $this->date = $date;
    }

    /**
     * 
     * @param \float $planned
     */
    function setPlanned($planned) {
        $this->planned = $planned;
    }

    /**
     * 
     * @return type
     */
    function getReal_advance() {
        return $this->real_advance;
    }

    /**
     * 
     * @param type $real_advance
     */
    function setReal_advance($real_advance) {
        $this->real_advance = $real_advance;
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
     * @param \float $beforePenalty
     */
    function setBeforePenalty($beforePenalty) {
        $this->beforePenalty = $beforePenalty;
    }

    /**
     * 
     * @param \float $pentalty
     */
    function setPentalty($pentalty) {
        $this->pentalty = $pentalty;
    }



}
