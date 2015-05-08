<?php

namespace Pequiven\SIGBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\SIGBundle\Model\ManagementSystem as modelManagementSystem;

/**
 * Sistema de gestión
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Pequiven\SIGBundle\Repository\ManagementSystemRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class ManagementSystem extends modelManagementSystem
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
     * Descripcion
     * @var string
     * @ORM\Column(name="description",type="string",length=150)
     */
    private $description;
    
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
     * Política de Sistema de Gestión
     * @var \Pequiven\SIGBundle\Entity\PoliticManagementSystem
     * @ORM\ManyToOne(targetEntity="Pequiven\SIGBundle\Entity\PoliticManagementSystem")
     */
    protected $politicManagementSystem;
    
    /**
    * @ORM\ManyToMany(targetEntity="\Pequiven\ObjetiveBundle\Entity\Objetive", mappedBy="managementSystems")
    */
    private $objetives;
    
    /**
    * @ORM\ManyToMany(targetEntity="\Pequiven\IndicatorBundle\Entity\Indicator", mappedBy="managementSystems")
    */
    private $indicators;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->objetives = new \Doctrine\Common\Collections\ArrayCollection();
        $this->indicators = new \Doctrine\Common\Collections\ArrayCollection();
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

    /**
     * Set politicManagementSystem
     *
     * @param \Pequiven\SIGBundle\Entity\PoliticManagementSystem $politicManagementSystem
     * @return ManagementSystem
     */
    public function setPoliticManagementSystem(\Pequiven\SIGBundle\Entity\PoliticManagementSystem $politicManagementSystem = null)
    {
        $this->politicManagementSystem = $politicManagementSystem;

        return $this;
    }

    /**
     * Get politicManagementSystem
     *
     * @return \Pequiven\SIGBundle\Entity\PoliticManagementSystem 
     */
    public function getPoliticManagementSystem()
    {
        return $this->politicManagementSystem;
    }
    
    /**
    * Add objetives
    *
    * @param \Pequiven\ObjetiveBundle\Entity\Objetive $objetives
    * @return ManagementSystem
    */
    public function addObjetive(\Pequiven\ObjetiveBundle\Entity\Objetive $objetives)
    {
        $this->objetives[] = $objetives;

        return $this;
    }

    /**
    * Remove objetives
    *
    * @param \Pequiven\ObjetiveBundle\Entity\Objetive $objetives
    */
    public function removeObjetive(\Pequiven\ObjetiveBundle\Entity\Objetive $objetives)
    {
        $this->objetives->removeElement($objetives);
    }

    /**
    * Get objetives
    *
    * @return \Doctrine\Common\Collections\Collection 
    */
    public function getObjetives()
    {
        return $this->objetives;
    }
    
    /**
    * Add indicators
    *
    * @param \Pequiven\IndicatorBundle\Entity\Indicator $indicators
    * @return ManagementSystem
    */
    public function addIndicator(\Pequiven\IndicatorBundle\Entity\Indicator $indicators)
    {
        $this->indicators[] = $indicators;

        return $this;
    }

    /**
    * Remove indicators
    *
    * @param \Pequiven\IndicatorBundle\Entity\Indicator $indicators
    */
    public function removeIndicator(\Pequiven\IndicatorBundle\Entity\Indicator $indicators)
    {
        $this->indicators->removeElement($indicators);
    }

    /**
    * Get indicators
    *
    * @return \Doctrine\Common\Collections\Collection 
    */
    public function getIndicators()
    {
        return $this->indicators;
    }
}
