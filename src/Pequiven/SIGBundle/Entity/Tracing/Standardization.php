<?php

namespace Pequiven\SIGBundle\Entity\Tracing;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\SIGBundle\Model\Tracing\Standardization as model;

/**
 * Sistema de gestión
 *
 * @ORM\Table(name="ManagementSystem_Monitoring_Standardization") 
 * @ORM\Entity(repositoryClass="Pequiven\SIGBundle\Repository\Tracing\StandardizationRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Standardization extends model
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
     * Area
     * @var text
     * @ORM\Column(name="area",type="text")
     */
    private $area;

    /**
     * Code
     * @var string
     * @ORM\Column(name="code",type="string",length=150)
     */
    private $code;

    /**
     * description
     * @var text
     * @ORM\Column(name="description",type="text")
     */
    private $description;

    /**
     * arrangementProgram
     * @var \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram
     * @ORM\ManyToOne(targetEntity="Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram",inversedBy="standardization")
     * @ORM\JoinColumn(nullable=true)
     */
    private $arrangementProgram;

    /**
     * analysis
     * @var string
     * @ORM\Column(name="analysis",type="string", nullable=true)
     */
    private $analysis;

    /**
     * status
     * @var integer
     * @ORM\Column(name="status",type="integer")
     */
    private $status = 0;
    
    /**
     * Habilitado para consultas
     * @var boolean
     * @ORM\Column(name="enabled",type="boolean")
     */
    private $enabled = true;

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
     * type
     * @var integer
     * @ORM\Column(name="relationObject",type="integer")
     */
    protected $relationObject;

    /**
     * Mantenimiento
     * @var \Pequiven\SIGBundle\Entity\Tracing\Maintenance
     * @ORM\ManyToMany(targetEntity="\Pequiven\SIGBundle\Entity\Tracing\Maintenance", mappedBy="standardization")     
     * 
     */
    private $maintenance;

    /**
     * Responsables
     * @var \Pequiven\SEIPBundle\Entity\User
     *
     * @ORM\ManyToMany(targetEntity="\Pequiven\SEIPBundle\Entity\User",inversedBy="maintenanceResponsibles", cascade={"persist","remove"})     
     * @ORM\JoinTable(name="ManagementSystem_Monitoring_Maintenance_responsibles")    
     */
    private $responsible;
    
     /**
     * type
     * @var integer
     * @ORM\Column(name="typeObject",type="integer")
     */
    private $typeObject;

    /**
     * File
     * @var string
     * @ORM\Column(name="file",type="string",length=150, nullable=true)
     */
    private $file;

    /**
     * Constructor
     */
    public function __construct(){
        $this->maintenance = new \Doctrine\Common\Collections\ArrayCollection();
        $this->responsible = new \Doctrine\Common\Collections\ArrayCollection();         
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
     * Set area
     *
     * @param string $area
     * @return 
     */
    public function setArea($area)
    {
        $this->area = $area;

        return $this;
    }

    /**
     * Get area
     *
     * @return string 
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return 
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return 
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
     * Set arrangementProgram
     *
     * @param string $arrangementProgram
     * @return arrangementProgram
     */
    public function setArrangementProgram($arrangementProgram)
    {
        $this->arrangementProgram = $arrangementProgram;

        return $this;
    }

    /**
     * Get arrangementProgram
     *
     * @return string 
     */
    public function getArrangementProgram()
    {
        return $this->arrangementProgram;
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
     * Set status
     *
     * @param string $status
     * @return Status
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

    /**
     * Add maintenance
     *
     * @param \Pequiven\SIGBundle\Entity\Tracing\Maintenance $maintenance
     * @return User
     */
    public function addMaintenance(\Pequiven\SIGBundle\Entity\Tracing\Maintenance $maintenance) {
        $this->maintenance[] = $maintenance;

        return $this;
    }

    /**
     * Remove maintenance
     *
     * @param \Pequiven\SIGBundle\Entity\Tracing\Maintenance $maintenance
     */
    public function removeMaintenance(\Pequiven\SIGBundle\Entity\Tracing\Maintenance $maintenance) {
        $this->maintenance->removeElement($maintenance);
    }

    /**
     * Get maintenance
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMaintenance() {
        return $this->maintenance;
    }

    /**
     * Add responsible
     *
     * @param \Pequiven\SEIPBundle\Entity\User $responsible
     * @return Indicator
     */
    public function addResponsible(\Pequiven\SEIPBundle\Entity\User $responsible) {
        $this->responsible[] = $responsible;

        return $this;
    }

    /**
     * Remove responsible
     *
     * @param \Pequiven\SEIPBundle\Entity\User $responsible
     */
    public function removeResponsible(\Pequiven\SEIPBundle\Entity\User $responsible) {
        $this->responsible->removeElement($responsible);
    }

    /**
     * Get responsible
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getResponsible() {
        return $this->responsible;
    }
    
    /**
     * Set typeObject
     *
     * @param string $typeObject
     * @return 
     */
    public function setTypeObject($typeObject)
    {
        $this->typeObject = $typeObject;

        return $this;
    }

    /**
     * Get typeObject
     *
     * @return string 
     */
    public function getTypeObject()
    {
        return $this->typeObject;
    }

    /**
     * Set relationObject
     *
     * @param string $relationObject
     * @return 
     */
    public function setRelationObject($relationObject)
    {
        $this->relationObject = $relationObject;

        return $this;
    }

    /**
     * Get relationObject
     *
     * @return string 
     */
    public function getRelationObject()
    {
        return $this->relationObject;
    }

    /**
     * Set file
     *
     * @param string $file
     * @return 
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return string 
     */
    public function getFile()
    {
        return $this->file;
    }

}
