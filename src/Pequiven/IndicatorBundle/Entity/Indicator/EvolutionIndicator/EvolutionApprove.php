<?php

namespace Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\IndicatorBundle\Model\Indicator\EvolutionIndicator\EvolutionCause as Model;

/**
 * Aprobación y Revision de Informe de evolucion
 *
 * @author Maximo Sojo <maxsojo13@gmail.com>
 * @ORM\Table(name="seip_report_evolution_approve")
 * @ORM\Entity(repositoryClass="Pequiven\IndicatorBundle\Repository\Indicator\EvolutionIndicator\EvolutionCauseRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class EvolutionApprove extends Model {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var text
     *
     * @ORM\Column(name="statusCheck", type="boolean")
     */
     private $statusCheck = false;

    /**
     * @var string
     *
     * @ORM\Column(name="statusApprove", type="boolean")
     */
    private $statusApprove = false;
    
    /**
     * Usuario que reviso
     * 
     * @var \Pequiven\SEIPBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     */
    private $userCheck;

    /**
     * Usuario que aprobo
     * 
     * @var \Pequiven\SEIPBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     */
    private $userApprove;

    /**
     * @var integer
     *
     * @ORM\Column(name="month", type="integer")
     */
    private $month;

    /**
     * @var integer
     *
     * @ORM\Column(name="typeObject", type="integer")
     */
    private $typeObject; 

    /**
     * @var text
     *
     * @ORM\Column(name="idObject", type="integer")
     */    
    private $idObject; 

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime",  nullable=true)
     */
    private $updatedAt;

    /**
     * Usuario que creo la causa
     * 
     * @var \Pequiven\SEIPBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     */
    private $createdBy;

    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * Constructor
     */
    public function __construct() {}    

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * Set idObject
     *
     * @param $idObject
     * @return idObject
     */
    public function setIdObject($idObject) {
        
        $this->idObject = $idObject;

        return $this;
    }

    /**
     * Get idObject
     *
     * @return idObject
     */
    public function getIdObject() {
        return $this->idObject;
    }

    /**
     * 
     * @param type $typeObject
     * @return type
     */
    public function setTypeObject($typeObject) {
        $this->typeObject = $typeObject;
        return $typeObject;
    }

    /**
     * 
     * @return type
     */
    public function getTypeObject() {
        return $this->typeObject;
    }

    /**
     * 
     * @param type $statusCheck
     * @return type
     */
    public function setStatusCheck($statusCheck) {
        $this->statusCheck = $statusCheck;
        return $statusCheck;
    }

    /**
     * 
     * @return type
     */
    public function getStatusCheck() {
        return $this->statusCheck;
    }

    /**
     * 
     * @param type $month
     * @return type
     */
    public function setMonth($month) {
        $this->month = $month;
        return $month;
    }

    /**
     * 
     * @return type
     */
    public function getMonth() {
        return $this->month;
    }

    /**
     * 
     * @param type $statusApprove
     * @return type
     */
    public function setStatusApprove($statusApprove) {
        $this->statusApprove = $statusApprove;
        return $statusApprove;
    }

    /**
     * 
     * @return type
     */
    public function getStatusApprove() {
        return $this->statusApprove;
    }

    /**
     * 
     * @param type $userCheck
     * @return type
     */
    public function setUserCheck($userCheck) {
        $this->userCheck = $userCheck;
        return $userCheck;
    }

    /**
     * 
     * @return type
     */
    public function getUserCheck() {
        return $this->userCheck;
    }

    /**
     * 
     * @param type $userApprove
     * @return type
     */
    public function setUserApprove($userApprove) {
        $this->userApprove = $userApprove;
        return $userApprove;
    }

    /**
     * 
     * @return type
     */
    public function getUserApprove() {
        return $this->userApprove;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Indicator
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
     * @return IndicatorSimpleValue
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
     * Set createdBy
     *
     * @param \Pequiven\SEIPBundle\Entity\User $createdBy
     * @return IndicatorSimpleValue
     */
    public function setCreatedBy(\Pequiven\SEIPBundle\Entity\User $createdBy) {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return \Pequiven\SEIPBundle\Entity\User 
     */
    public function getCreatedBy() {
        return $this->createdBy;
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     * @return ManagementSystem
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime 
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }  

    /**
     * 
     * @return string
     */
    public function __toString() {
        return $this->getCauses() ;
    }   
     
}
