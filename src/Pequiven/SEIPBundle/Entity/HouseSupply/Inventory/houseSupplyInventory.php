<?php

namespace Pequiven\SEIPBundle\Entity\HouseSupply\Inventory;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\SEIPBundle\Entity\HouseSupply\Inventory\houseSupplyDeposit;
use Pequiven\SEIPBundle\Entity\HouseSupply\Inventory\houseSupplyProduct;

/**
 * Productos
 *
 * @author Gilbert C. <glavrjk@gmail.com>
 * 
 * @ORM\Table(name="seip_gsh_inventory")
 * @ORM\Entity("Pequiven\SEIPBundle\Repository\HouseSupply\Inventory\HouseSupplyInventoryRepository") 
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @ORM\HasLifecycleCallbacks()
 */
class houseSupplyInventory {

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
     * @var houseSupplyProduct
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\HouseSupply\Inventory\houseSupplyProduct", inversedBy="inventory")
     * @ORM\JoinColumn(name="producto_id", referencedColumnName="id")
     */
    private $product;

    /**
     * 
     * @var houseSupplyDeposit
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\HouseSupply\Inventory\houseSupplyDeposit", inversedBy="inventory")
     * @ORM\JoinColumn(name="deposit_id", referencedColumnName="id")
     */
    private $deposit;

    /**
     *
     * @var float
     * @ORM\Column(name="available",type="float",nullable=true)
     */
    private $available = 0;

    /**
     *
     * @var datetime
     * @ORM\Column(name="lastChargeDate",type="datetime",nullable=true)
     */
    private $lastChargeDate;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updatedAt", type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;

    function getId() {
        return $this->id;
    }

    function getProduct() {
        return $this->product;
    }

    function getDeposit() {
        return $this->deposit;
    }

    function getAvailable() {
        return $this->available;
    }

    function getLastChargeDate() {
        return $this->lastChargeDate;
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

    function setId($id) {
        $this->id = $id;
    }

    function setProduct(houseSupplyProduct $product) {
        $this->product = $product;
    }

    function setDeposit(houseSupplyDeposit $deposit) {
        $this->deposit = $deposit;
    }

    function setAvailable($available) {
        $this->available = $available;
    }

    function setLastChargeDate(\DateTime $lastChargeDate) {
        $this->lastChargeDate = $lastChargeDate;
    }

    function setCreatedAt(\DateTime $createdAt) {
        $this->createdAt = $createdAt;
    }

    function setUpdatedAt(\DateTime $updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    function setDeletedAt($deletedAt) {
        $this->deletedAt = $deletedAt;
    }

}
