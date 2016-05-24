<?php

namespace Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\IndicatorBundle\Model\Indicator\EvolutionIndicator\EvolutionActionVerification as Model;

/**
 * Verification Plan de Acción y Seguimiento del informe de evolucion
 *
 * @author Maximo Sojo <maxsojo13@gmail.com>
 * @ORM\Table(name="seip_report_evolution_action_verification")
 * @ORM\Entity()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class EvolutionActionVerification extends Model {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="ref" , type="string", length=15, nullable=true)
     */
    private $ref;
    
    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="string", length=500, nullable=true)
     */
    private $comment;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
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
     * @ORM\ManyToOne(targetEntity="\Pequiven\SIGBundle\Entity\TypeVerificationManagementSystem", inversedBy="verificationPlan")
     * @ORM\JoinColumn(name="verification_id", referencedColumnName="id")
     */
    private $typeVerification;

    /**
     * @ORM\ManyToOne(targetEntity="\Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionAction", inversedBy="verificationRel")
     * @ORM\JoinColumn(name="action_id", referencedColumnName="id")
     */
    private $actionPlan;

     /**
     * @var text
     *
     * @ORM\Column(name="indicator_id", type="integer", nullable=true)
     */
     private $indicator;

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
     * @param type $ref
     * @return type
     */
    public function setRef($ref) {
        $this->ref = $ref;
        return $ref;
    }

    /**
     * 
     * @return type
     */
    public function getRef() {
        return $this->ref;
    }

    /**
     * 
     * @param type $comment
     * @return type
     */
    public function setComment($comment) {
        $this->comment = $comment;
        return $comment;
    }

    /**
     * 
     * @return type
     */
    public function getComment() {
        return $this->comment;
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
     * Set typeVerification
     *
     * @param \Pequiven\SIGBundle\Entity\TypeVerificationManagementSystem $typeVerification
     */
    public function setTypeVerification(\Pequiven\SIGBundle\Entity\TypeVerificationManagementSystem $typeVerification) {
        
        $this->typeVerification = $typeVerification;

        return $this;
    }

    /**
     * Get typeVerification
     *
     * @return Pequiven\SIGBundle\Entity\TypeVerificationManagementSystem
     */
    public function getTypeVerification() {
        return $this->typeVerification;
    }

    /**
     * Set actionPlan
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionIndicationVerification $actionPlan
     */
    public function setActionPlan(\Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionAction $actionPlan) {
        
        $this->actionPlan = $actionPlan;

        return $this;
    }

    /**
     * Get actionPlan
     *
     * @return Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionIndicatorVerification
     */
    public function getActionPlan() {
        return $this->actionPlan;
    }
}
