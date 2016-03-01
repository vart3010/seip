<?php

namespace Pequiven\SEIPBundle\Entity\HouseSupply\Inventory;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\SEIPBundle\Entity\User;
use Pequiven\SEIPBundle\Entity\HouseSupply\Inventory\houseSupplyProduct;
use Pequiven\SEIPBundle\Entity\HouseSupply\Inventory\houseSupplyInventoryCharge;

/**
 * Cargo de Items de Inventario
 *
 * @author Gilbert C. <glavrjk@gmail.com>
 * 
 * @ORM\Table(name="seip_gsh_inventory_charge_items")
 * @ORM\Entity()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class houseSupplyInventoryChargeItems {

    /**
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     *
     * @var string
     * @ORM\Column(name="type",type="integer",nullable=false)
     */
    private $type;

    /**
     * @var \DateTime
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * 
     * @var houseSupplyInventoryCharge
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\HouseSupply\Inventory\houseSupplyInventoryCharge", inversedBy="inventoryChargeItems")
     * @ORM\JoinColumn(name="inventoryCharge_id", referencedColumnName="id")
     */
    private $inventoryCharge;

    /**
     * 
     * @var houseSupplyProduct
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\HouseSupply\Inventory\houseSupplyProduct", inversedBy="inventoryChargeItems")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $product;

    /**
     *
     * @var float
     * @ORM\Column(name="cant",type="float",nullable=false)
     */
    private $cant;

    /**
     *
     * @var integer
     * @ORM\Column(name="line",type="integer",nullable=false)
     */
    private $line;

    /**
     *
     * @var float
     * @ORM\Column(name="cost",type="float",nullable=true)
     */
    private $cost;

    /**
     *
     * @var float
     * @ORM\Column(name="totalLine",type="float",nullable=true)
     */
    private $totalLine;

    /**
     * Creado por
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $createdBy;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;

    function getId() {
        return $this->id;
    }

    function getType() {
        return $this->type;
    }

    function getDate() {
        return $this->date;
    }

    function getInventoryCharge() {
        return $this->inventoryCharge;
    }

    function getProduct() {
        return $this->product;
    }

    function getCant() {
        return $this->cant;
    }

    function getLine() {
        return $this->line;
    }

    function getCost() {
        return $this->cost;
    }

    function getTotalLine() {
        return $this->totalLine;
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

    function setId($id) {
        $this->id = $id;
    }

    function setType($type) {
        $this->type = $type;
    }

    function setDate(\DateTime $date) {
        $this->date = $date;
    }

    function setInventoryCharge(houseSupplyInventoryCharge $inventoryCharge) {
        $this->inventoryCharge = $inventoryCharge;
    }

    function setProduct(houseSupplyProduct $product) {
        $this->product = $product;
    }

    function setCant($cant) {
        $this->cant = $cant;
    }

    function setLine($line) {
        $this->line = $line;
    }

    function setCost($cost) {
        $this->cost = $cost;
    }

    function setTotalLine($totalLine) {
        $this->totalLine = $totalLine;
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

}
