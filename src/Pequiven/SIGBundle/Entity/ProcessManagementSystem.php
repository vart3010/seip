<?php

namespace Pequiven\SIGBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\SIGBundle\Model\ProcessManagementSystem as model;

/**
 * Sistema de gestión
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Pequiven\SIGBundle\Repository\ProcessManagementSystemRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class ProcessManagementSystem extends model
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
    * @ORM\ManyToMany(targetEntity="\Pequiven\SIGBundle\Entity\ManagementSystem", inversedBy="processManagementSystem")
    * @ORM\JoinTable(name="management_systems_process")
    */
    private $managementSystem;

    /**
     * Proceso de los objetivos
     * 
     * @ORM\ManyToMany(targetEntity="Pequiven\ObjetiveBundle\Entity\Objetive", mappedBy="processManagementSystem")
     * 
     */
    protected $objetive;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->managementSystem = new \Doctrine\Common\Collections\ArrayCollection();        
        $this->objetive = new \Doctrine\Common\Collections\ArrayCollection();        
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
    * Add managementSystem
    *
    * @param \Pequiven\SIGBundle\Entity\ManagementSystem $managementSystem
    * @return ManagementSystem
    */
    public function addManagementSystem(\Pequiven\SIGBundle\Entity\ManagementSystem $managementSystem)
    {
        $this->managementSystem[] = $managementSystem;

        return $this;
    }

    /**
    * Remove managementSystem
    *
    * @param \Pequiven\SIGBundle\Entity\ManagementSystem $managementSystem
    */
    public function removeManagementSystem(\Pequiven\SIGBundle\Entity\ManagementSystem $managementSystem)
    {
        $this->managementSystem->removeElement($managementSystem);
    }

    /**
    * Get managementSystem
    *
    * @return \Doctrine\Common\Collections\Collection 
    */
    public function getManagementSystem()
    {
        return $this->managementSystem;
    }

    /**
    * Add objetive
    *
    * @param \Pequiven\ObjetiveBundle\Entity\Objetive $objetive
    * @return ManagementSystem
    */
    public function addObjetive(\Pequiven\ObjetiveBundle\Entity\Objetive $objetive)
    {
        $this->objetive[] = $objetive;

        return $this;
    }

    /**
    * Remove objetive
    *
    * @param \Pequiven\ObjetiveBundle\Entity\Objetive $objetive
    */
    public function removeObjetive(\Pequiven\ObjetiveBundle\Entity\Objetive $objetive)
    {
        $this->objetive->removeElement($objetive);
    }

    /**
    * Get objetive
    *
    * @return \Doctrine\Common\Collections\Collection 
    */
    public function getObjetive()
    {
        return $this->objetive;
    }
}
