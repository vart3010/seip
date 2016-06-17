<?php

namespace Pequiven\SEIPBundle\Entity\Sip\Center;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Parroquia
 * @author Maximo Sojo maxsojo13@gmail.com
 * @ORM\Table(name="sip_centro_material")
 * @ORM\Entity()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Material {

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
     * @ORM\Column(name="material", type="string")
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
     * Inventario
     * 
     * @var \Pequiven\SEIPBundle\Entity\Sip\Center\Inventory
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\Sip\Center\Inventory",mappedBy="material",cascade={"persist","remove"})
     */
    protected $inventory;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->inventory = new \Doctrine\Common\Collections\ArrayCollection();

    }
    
    
    function getId() {
        return $this->id;
    }   

    function setDescription($description) {
        $this->description = $description;
    }

    function getDescription() {
        return $this->description;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return material
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
     * @return material
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
     * @return material
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
     * @return material
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
     * Add inventory
     *
     * @param \Pequiven\SEIPBundle\Entity\Sip\Center\Material $inventory
     */
    public function addTypeAction(\Pequiven\SEIPBundle\Entity\Sip\Center\Material $inventory) {

        $this->inventory->add($inventory);

        return $this;
    }

    /**
     * Remove inventory
     *
     * @param \Pequiven\SEIPBundle\Entity\Sip\Center\Material $inventory
     */
    public function removeTypeAction(\Pequiven\SEIPBundle\Entity\Sip\Center\Material $inventory) {
        $this->inventory->removeElement($inventory);
    }

    /**
     * Get indicatorCause
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTypeAction() {
        return $this->inventory;
    }
    
}
