<?php

namespace Pequiven\SEIPBundle\Entity\HouseSupply;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Productos
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 * 
 * @ORM\Table(name="seip_gsh_inventory")
 * @ORM\Entity()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class houseSupplyInventory
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
     * Product
     * @var \Pequiven\SEIPBundle\Entity\houseSupply\houseSupplyProduct
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\houseSupply\houseSupplyProduct", inversedBy="inventory")
     * @ORM\JoinColumn(name="producto_id", referencedColumnName="id")
     */
    private $product;

    /**
     *
     * @var string
     * @ORM\Column(name="desposit",type="string",nullable=false)
     */
    private $desposit;

    /**
     *
     * @var string
     * @ORM\Column(name="available",type="integer",nullable=false)
     */
    private $available;

    /**
     *
     * @var integer
     * @ORM\Column(name="lastCharge",type="integer",nullable=false)
     */
    private $lastCharge;

    /**
     *
     * @var datetime
     * @ORM\Column(name="lastChargeDate",type="datetime",nullable=false)
     */
    private $lastChargeDate;
    
    /**
     * Creado por
     * @var \Pequiven\SEIPBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $createdBy;
    
    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="createdAt", type="datetime")
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set available
     *
     * @param ineteger $available
     * @return Available
     */
    public function setAvailable($available)
    {
        $this->available = $available;

        return $this;
    }

    /**
     * Get available
     *
     * @return ineteger 
     */
    public function getAvailable()
    {
        return $this->available;
    }

    /**
     * Set lastCharge
     *
     * @param ineteger $lastCharge
     * @return lastCharge
     */
    public function setLastCharge($lastCharge)
    {
        $this->lastCharge = $lastCharge;

        return $this;
    }

    /**
     * Get lastCharge
     *
     * @return ineteger 
     */
    public function getLastCharge()
    {
        return $this->lastCharge;
    }

    /**
     * Set lastChargeDate
     *
     * @param ineteger $lastChargeDate
     * @return lastChargeDate
     */
    public function setLastChargeDate($lastChargeDate)
    {
        $this->lastChargeDate = $lastChargeDate;

        return $this;
    }

    /**
     * Get lastChargeDate
     *
     * @return ineteger 
     */
    public function getLastChargeDate()
    {
        return $this->lastChargeDate;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Observation
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
     * Set createdBy
     *
     * @param \Pequiven\SEIPBundle\Entity\User $createdBy
     * @return Observation
     */
    public function setCreatedBy(\Pequiven\SEIPBundle\Entity\User $createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return \Pequiven\SEIPBundle\Entity\User 
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Chart
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
     * @return Chart
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
}
