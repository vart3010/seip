<?php

namespace Pequiven\SEIPBundle\Entity\HouseSupply\Inventory;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\SEIPBundle\Entity\HouseSupply\Inventory\houseSupplyInventory;
use Pequiven\SEIPBundle\Entity\HouseSupply\Inventory\houseSupplyProductInstance;
use Pequiven\SEIPBundle\Entity\HouseSupply\Inventory\houseSupplyProductKitItems;
use Pequiven\SEIPBundle\Entity\HouseSupply\Inventory\houseSupplyInventoryChargeItems;
use Pequiven\SEIPBundle\Entity\HouseSupply\Order\houseSupplyOrderItems;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Productos
 *
 * @author Máximo Sojo
 * 
 * @ORM\Table(name="seip_gsh_product")
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Repository\HouseSupply\Inventory\HouseSupplyProductRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class houseSupplyProduct {

    /**
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * 
     * @var houseSupplyProductInstance
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\HouseSupply\Inventory\houseSupplyProductInstance", inversedBy="product")
     * @ORM\JoinColumn(name="instance_id", referencedColumnName="id")
     */
    private $instance;

    /**
     *
     * @var string
     * @ORM\Column(name="code",type="string",nullable=true)
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
     * @var float
     * @ORM\Column(name="cost",type="float",nullable=true)
     */
    private $cost;

    /**
     *
     * @var float
     * @ORM\Column(name="taxes",type="float",nullable=true)
     */
    private $taxes;

    /**
     * @var boolean
     *
     * @ORM\Column(name="exento", type="boolean")
     */
    private $exento = false;

    /**
     *
     * @var float
     * @ORM\Column(name="maxPerUserForce",type="float",nullable=true)
     */
    private $maxPerUserForce = null;

    /**
     * Inventario
     * 
     * @var houseSupplyInventory
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\houseSupply\Inventory\houseSupplyInventory",mappedBy="product",cascade={"persist","remove"})
     */
    protected $inventory;

    /**
     * @var houseSupplyProductKitItems
     * @ORM\OneToMany(targetEntity="\Pequiven\SEIPBundle\Entity\HouseSupply\Inventory\houseSupplyProductKitItems",mappedBy="product",cascade={"persist"}))
     */
    protected $productKitItems;

    /**
     * Carga de Items de Inventario
     * 
     * @var houseSupplyInventoryChargeItems
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\houseSupply\Inventory\houseSupplyInventoryChargeItems",mappedBy="product",cascade={"persist","remove"})
     */
    protected $inventoryChargeItems;

    /**
     * @var houseSupplyOrderItems
     * @ORM\OneToMany(targetEntity="\Pequiven\SEIPBundle\Entity\HouseSupply\Order\houseSupplyOrderItems",mappedBy="product",cascade={"persist"}))
     */
    protected $orderItems;

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

    public function __toString() {
        return $this->getDescription();
    }

    function getId() {
        return $this->id;
    }

    function getInstance() {
        return $this->instance;
    }

    function getCode() {
        return $this->code;
    }

    function getDescription() {
        return $this->description;
    }

    function getPrice() {
        return $this->price;
    }

    function getCost() {
        return $this->cost;
    }

    function getTaxes() {
        return $this->taxes;
    }

    function getExento() {
        return $this->exento;
    }

    function getMaxPerUserForce() {
        return $this->maxPerUserForce;
    }

    function getInventory() {
        return $this->inventory;
    }

    function getProductKitItems() {
        return $this->productKitItems;
    }

    function getInventoryChargeItems() {
        return $this->inventoryChargeItems;
    }

    function getOrderItems() {
        return $this->orderItems;
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

    function setInstance(houseSupplyProductInstance $instance) {
        $this->instance = $instance;
    }

    function setCode($code) {
        $this->code = $code;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setPrice($price) {
        $this->price = $price;
    }

    function setCost($cost) {
        $this->cost = $cost;
    }

    function setTaxes($taxes) {
        $this->taxes = $taxes;
    }

    function setExento($exento) {
        $this->exento = $exento;
    }

    function setMaxPerUserForce($maxPerUserForce) {
        $this->maxPerUserForce = $maxPerUserForce;
    }

    function setInventory(houseSupplyInventory $inventory) {
        $this->inventory = $inventory;
    }

    function setProductKitItems(houseSupplyProductKitItems $productKitItems) {
        $this->productKitItems = $productKitItems;
    }

    function setInventoryChargeItems(houseSupplyInventoryChargeItems $inventoryChargeItems) {
        $this->inventoryChargeItems = $inventoryChargeItems;
    }

    function setOrderItems(houseSupplyOrderItems $orderItems) {
        $this->orderItems = $orderItems;
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
