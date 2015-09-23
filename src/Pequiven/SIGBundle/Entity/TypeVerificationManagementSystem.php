<?php

namespace Pequiven\SIGBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\SIGBundle\Model\TypeVerificationManagementSystem as model;

/**
 * Tipo de Verificación del Plan de Acción
 *
 * @ORM\Table(name="ManagementSystem_TypeVerification")
 * @ORM\Entity(repositoryClass="Pequiven\SIGBundle\Repository\TypeVerificationManagementSystemRepository") 
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class TypeVerificationManagementSystem extends model
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * Referencia
     * @var string
     * @ORM\Column(name="ref",type="string",length=20)
     */
    private $ref;
    
    /**
     * Descripción
     * @var boolean
     * @ORM\Column(name="description",type="string", length=255)
     */
    private $description;

    /**
     * Date created
     * 
     * @var type 
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at",type="datetime")
     */
    private $createdAt;
    
    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;
    
    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @var integer
     *
     *  @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status;
    
    /**
     * Verification en la lista de verificación
     * 
     * @var \Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionActionVerification
     * @ORM\OneToMany(targetEntity="Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionActionVerification",mappedBy="typeVerification",cascade={"persist","remove"})
     */
    protected $verificationPlan;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->verificationPlan = new \Doctrine\Common\Collections\ArrayCollection();
        
    }
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set ref
     *
     * @param string $description
     * @return ManagementSystem
     */
    public function setRef($ref)
    {
        $this->ref = $ref;

        return $this;
    }

    /**
     * Get ref
     *
     * @return string 
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * Set status
     *
     * @param string $description
     * @return ManagementSystem
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return ManagementSystem
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return ManagementSystem
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return ManagementSystem
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
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
     * Add verificationPlan
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionActionVerification $verificationPlan
     */
    public function addVerificationPlan(\Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionActionVerification $verificationPlan) {

        $this->verificationPlan->add($verificationPlan);

        return $this;
    }

    /**
     * Remove verificationPlan
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionAction $verificationPlan
     */
    public function removeVerificationPlan(\Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionActionVerification $verificationPlan) {
        $this->verificationPlan->removeElement($verificationPlan);
    }

    /**
     * Get verificationPlan
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVerificationPlan() {
        return $this->verificationPlan;
    }
}
