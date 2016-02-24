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
     * analysis
     * @var text
     * @ORM\Column(name="analysis",type="text", nullable=true)
     */
    private $analysis;

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
     * advance
     * @var string
     * @ORM\Column(name="advance",type="string",length=150)
     */
    private $advance;

    /**
     * status
     * @var integer
     * @ORM\Column(name="status",type="integer")
     */
    private $status = 0;

    /**
     * statusVerification
     * @var integer
     * @ORM\Column(name="statusVerification",type="integer")
     */
    private $statusVerification;

    /**
     * observations
     * @var string
     * @ORM\Column(name="observations",type="text")
     */
    private $observations;

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
     * Constructor
     */
    public function __construct(){

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
     * Set advance
     *
     * @param string $advance
     * @return 
     */
    public function setAdvance($advance)
    {
        $this->advance = $advance;

        return $this;
    }

    /**
     * Get advance
     *
     * @return string 
     */
    public function getAdvance()
    {
        return $this->advance;
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
     * Set observations
     *
     * @param string $observations
     * @return observations
     */
    public function setObservations($observations)
    {
        $this->observations = $observations;

        return $this;
    }

    /**
     * Get observations
     *
     * @return string 
     */
    public function getObservations()
    {
        return $this->observations;
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
     * Set enabled
     *
     * @param boolean $enabled
     * @return 
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean 
     */
    public function getEnabled()
    {
        return $this->enabled;
    }
    
    public function __toString() {
        return $this->getDescription()?:'-';
    }

     /**
     * Set managementSystem
     *
     * @param \Pequiven\SIGBundle\Entity\ManagementSystem $managementSystem
     * @return ManagementSystem
     */
    public function setManagementSystem(\Pequiven\SIGBundle\Entity\ManagementSystem $managementSystem = null)
    {
        $this->managementSystem = $managementSystem;

        return $this;
    }

    /**
     * Get managementSystem
     *
     * @return \Pequiven\SIGBundle\Entity\ManagementSystem 
     */
    public function getManagementSystem()
    {
        return $this->managementSystem;
    }
    
}
