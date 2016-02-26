<?php

namespace Pequiven\SEIPBundle\Entity\HouseSupply;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Productos
 *
 * @author Máximo Sojo
 * 
 * @ORM\Table(name="seip_gsh_product")
 * @ORM\Entity()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class houseSupplyProduct
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
     *
     * @var ineteger
     * @ORM\Column(name="code",type="integer",nullable=false)
     */
    private $code;

    /**
     *
     * @var string
     * @ORM\Column(name="description",type="string",nullable=false)
     */
    private $description;

    /**
     *
     * @var float
     * @ORM\Column(name="price",type="float",nullable=false)
     */
    private $price;

    /**
     *
     * @var integer
     * @ORM\Column(name="maxPerUser",type="integer",nullable=false)
     */
    private $maxPerUser;

    /**
     * Inventario
     * 
     * @var \Pequiven\SEIPBundle\Entity\houseSupply\houseSupplyInventory
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\houseSupply\houseSupplyInventory",mappedBy="product",cascade={"persist","remove"})
     */
    protected $inventory;
    
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
     * Constructor
     */
    public function __construct() {

        $this->inventory = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set code
     *
     * @param string $code
     * @return Observation
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
     * @return Observation
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
     * Set price
     *
     * @param string $price
     * @return Observation
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set maxPerUser
     *
     * @param string $maxPerUser
     * @return Observation
     */
    public function setMaxPerUser($maxPerUser)
    {
        $this->maxPerUser = $maxPerUser;

        return $this;
    }

    /**
     * Get maxPerUser
     *
     * @return string 
     */
    public function getMaxPerUser()
    {
        return $this->maxPerUser;
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
