<?php

namespace Pequiven\SIGBundle\Entity\Tracing;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Sistema de gestión
 *
 * @ORM\Table(name="ManagementSystem_Monitoring_Maintenance") 
 * @ORM\Entity(repositoryClass="Pequiven\SIGBundle\Repository\Tracing\StandardizationRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Maintenance 
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
     * dateStart
     * @var string
     * @ORM\Column(name="dateStart",type="datetime")
     */
    private $dateStart;

    /**
     * dateEnd
     * @var string
     * @ORM\Column(name="dateEnd",type="datetime")
     */
    private $dateEnd;

    /**
     * Avance
     * 
     * @var \Pequiven\SIGBundle\Entity\Tracing\MaintenanceAdvance
     * @ORM\OneToMany(targetEntity="Pequiven\SIGBundle\Entity\Tracing\MaintenanceAdvance",mappedBy="maintenance",cascade={"persist","remove"})
     */
    protected $advance;

    /**
     * status
     * @var integer
     * @ORM\Column(name="status",type="integer")
     */
    private $status = 1;

    /**
     * statusVerification
     * @var integer
     * @ORM\Column(name="statusVerification",type="integer", nullable=true)
     */
    private $statusVerification;

    /**
     * statusVerification
     * @var datetime
     * @ORM\Column(name="dateVerification",type="datetime", nullable=true)
     */
    private $dateVerification;

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
     * standardization
     * 
     * @var \Pequiven\SIGBundle\Entity\Tracing\Standardization
     * @ORM\ManyToMany(targetEntity="\Pequiven\SIGBundle\Entity\Tracing\Standardization",inversedBy="maintenance", cascade={"persist","remove"}) 
     * @ORM\JoinTable(name="ManagementSystem_Monitoring_Standardization_Maintenance")    
     */
    private $standardization;

    /**
     * analysis
     * @var text
     * @ORM\Column(name="analysis",type="text", nullable=true)
     */
    private $analysis;

    /**
     * Constructor
     */
    public function __construct(){
        $this->standardization = new \Doctrine\Common\Collections\ArrayCollection();
        $this->advance = new \Doctrine\Common\Collections\ArrayCollection();        
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
     * Set dateStart
     *
     * @param string $dateStart
     * @return 
     */
    public function setDateStart($dateStart)
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    /**
     * Get dateStart
     *
     * @return string 
     */
    public function getDateStart()
    {
        return $this->dateStart;
    }

    /**
     * Set dateEnd
     *
     * @param string $dateEnd
     * @return 
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * Get dateEnd
     *
     * @return string 
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return 
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
     * Set statusVerification
     *
     * @param string $statusVerification
     * @return 
     */
    public function setStatusVerification($statusVerification)
    {
        $this->statusVerification = $statusVerification;

        return $this;
    }

    /**
     * Get statusVerification
     *
     * @return string 
     */
    public function getStatusVerification()
    {
        return $this->statusVerification;
    }

    /**
     * Set dateVerification
     *
     * @param string $dateVerification
     * @return 
     */
    public function setDateVerification($dateVerification)
    {
        $this->dateVerification = $dateVerification;

        return $this;
    }

    /**
     * Get dateVerification
     *
     * @return string 
     */
    public function getDateVerification()
    {
        return $this->dateVerification;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return 
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
     * @return 
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
     * @return 
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
     * Add standardization
     *
     * @param \Pequiven\SIGBundle\Entity\Tracing\Standardization $standardization
     * @return Indicator
     */
    public function addStandardization(\Pequiven\SIGBundle\Entity\Tracing\Standardization $standardization) {
        $this->standardization[] = $standardization;

        return $this;
    }

    /**
     * Remove standardization
     *
     * @param \Pequiven\SIGBundle\Entity\Tracing\Standardization $standardization
     */
    public function removeStandardization(\Pequiven\SIGBundle\Entity\Tracing\Standardization $responsible) {
        $this->standardization->removeElement($standardization);
    }

    /**
     * Get standardization
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStandardization() {
        return $this->standardization;
    }

    

    /**
     * Set analysis
     *
     * @param string $analysis
     * @return analysis
     */
    public function setAnalysis($analysis)
    {
        $this->analysis = $analysis;

        return $this;
    }

    /**
     * Get analysis
     *
     * @return string 
     */
    public function getAnalysis()
    {
        return $this->analysis;
    }    
    
}
