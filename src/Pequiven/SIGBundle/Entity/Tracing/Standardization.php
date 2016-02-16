<?php

namespace Pequiven\SIGBundle\Entity\Tracing;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Sistema de gestión
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Pequiven\SIGBundle\Repository\Tracing\StandartizationRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Standardization 
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
     * @var string
     * @ORM\Column(name="area",type="string",length=150)
     */
    private $area;

    /**
     * Detection
     * @var string
     * @ORM\Column(name="detection",type="string",length=150)
     */
    private $detection;

    /**
     * Code
     * @var string
     * @ORM\Column(name="code",type="string",length=150)
     */
    private $code;

    /**
     * type
     * @var string
     * @ORM\Column(name="type",type="string",length=150)
     */
    private $type;

    /**
     * description
     * @var string
     * @ORM\Column(name="description",type="string")
     */
    private $description;

    /**
     * treatment
     * @var string
     * @ORM\Column(name="treatment",type="string")
     */
    private $treatment;
    
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
     * Set area
     *
     * @param string $area
     * @return ManagementSystem
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
     * Set detection
     *
     * @param string $detection
     * @return ManagementSystem
     */
    public function setDetection($detection)
    {
        $this->detection = $detection;

        return $this;
    }

    /**
     * Get detection
     *
     * @return string 
     */
    public function getDetection()
    {
        return $this->detection;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return ManagementSystem
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
     * Set type
     *
     * @param string $type
     * @return ManagementSystem
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
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
     * Set treatment
     *
     * @param string $treatment
     * @return ManagementSystem
     */
    public function setTreatment($treatment)
    {
        $this->treatment = $treatment;

        return $this;
    }

    /**
     * Get treatment
     *
     * @return string 
     */
    public function getTreatment()
    {
        return $this->treatment;
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
     * Set enabled
     *
     * @param boolean $enabled
     * @return ManagementSystem
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
    
}
