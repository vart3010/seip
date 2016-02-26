<?php

namespace Pequiven\SEIPBundle\Entity\HouseSupply\Inventory;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\SEIPBundle\Entity\User;
use Pequiven\SEIPBundle\Entity\HouseSupply\Inventory\houseSupplyInventoryCharge;

/**
 * Depositos
 *
 * @author Gilbert C. <glavrjk@gmail.com>
 * 
 * @ORM\Table(name="seip_gsh_deposit")
 * @ORM\Entity()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class houseSupplyDeposit {

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
     * @var string
     * @ORM\Column(name="description",type="string",nullable=false)
     */
    private $description;

    /**
     * Creado por
     * @var User
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
     * Inventario
     * 
     * @var houseSupplyInventory
     * @ORM\OneToMany(targetEntity="\Pequiven\SEIPBundle\Entity\HouseSupply\Inventory\houseSupplyInventory",mappedBy="deposit",cascade={"persist","remove"})
     */
    protected $inventory;

    /**
     * Cargos de Inventario
     * 
     * @var houseSupplyInventoryCharge
     * @ORM\OneToMany(targetEntity="\Pequiven\SEIPBundle\Entity\HouseSupply\Inventory\houseSupplyInventoryCharge",mappedBy="deposit",cascade={"persist","remove"})
     */
    protected $inventoryCharge;
    
    function getId() {
        return $this->id;
    }

    function getDescription() {
        return $this->description;
    }

    function getCreatedBy() {
        return $this->createdBy;
    }

    function getCreatedAt() {
        return $this->createdAt;
    }

    function getUpdatedAt() {
        return $this->updatedAt;
    }

    function getDeletedAt() {
        return $this->deletedAt;
    }

    function getInventory() {
        return $this->inventory;
    }

    function getInventoryCharge() {
        return $this->inventoryCharge;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setCreatedBy(User $createdBy) {
        $this->createdBy = $createdBy;
    }

    function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }

    function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    function setDeletedAt($deletedAt) {
        $this->deletedAt = $deletedAt;
    }

    function setInventory(houseSupplyInventory $inventory) {
        $this->inventory = $inventory;
    }

    function setInventoryCharge(houseSupplyInventoryCharge $inventoryCharge) {
        $this->inventoryCharge = $inventoryCharge;
    }



}
