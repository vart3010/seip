<?php

namespace Pequiven\SEIPBundle\Entity\HouseSupply\Inventory;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\SEIPBundle\Entity\User;
use Pequiven\SEIPBundle\Entity\HouseSupply\Inventory\houseSupplyDeposit;
use Pequiven\SEIPBundle\Entity\HouseSupply\Inventory\houseSupplyInventoryChargeItems;

/**
 * Cargo de Inventario
 *
 * @author Gilbert C. <glavrjk@gmail.com>
 * 
 * @ORM\Table(name="seip_gsh_inventory_charge") 
 * @ORM\Entity("Pequiven\SEIPBundle\Repository\HouseSupply\Inventory\HouseSupplyInventoryChargeRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @ORM\HasLifecycleCallbacks()
 */
class houseSupplyInventoryCharge {

    /**
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     *
     * @var string
     * @ORM\Column(name="type",type="integer",nullable=false)
     */
    private $type;

    /**
     *
     * @var string
     * @ORM\Column(name="sign",type="integer",nullable=false)
     */
    private $sign;

    /**
     *
     * @var integer
     * @ORM\Column(name="nroCharge",type="integer",nullable=true)
     */
    private $nroCharge;

    /**
     *
     * @var float
     * @ORM\Column(name="totalCharge",type="float",nullable=true)
     */
    private $totalCharge;

    /**
     *
     * @var string
     * @ORM\Column(name="description",type="text",nullable=true)
     */
    private $observations;

    /**
     * 
     * @var houseSupplyDeposit
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\HouseSupply\Inventory\houseSupplyDeposit", inversedBy="inventoryCharge")
     * @ORM\JoinColumn(name="deposit_id", referencedColumnName="id")
     */
    private $deposit;

    /**
     * Carga de Items de Inventario
     * 
     * @var houseSupplyInventoryChargeItems
     * @ORM\OneToMany(targetEntity="\Pequiven\SEIPBundle\Entity\HouseSupply\Inventory\houseSupplyInventoryChargeItems",mappedBy="inventoryCharge",cascade={"persist","remove"})
     */
    protected $inventoryChargeItems;

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

    function getDate() {
        return $this->date;
    }

    function getType() {
        return $this->type;
    }

    function getSign() {
        return $this->sign;
    }

    function getNroCharge() {
        return $this->nroCharge;
    }

    function getTotalCharge() {
        return $this->totalCharge;
    }

    function getObservations() {
        return $this->observations;
    }

    function getDeposit() {
        return $this->deposit;
    }

    function getInventoryChargeItems() {
        return $this->inventoryChargeItems;
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

    function setDate(\DateTime $date) {
        $this->date = $date;
    }

    function setType($type) {
        $this->type = $type;
    }

    function setSign($sign) {
        $this->sign = $sign;
    }

    function setNroCharge($nroCharge) {
        $this->nroCharge = $nroCharge;
    }

    function setTotalCharge($totalCharge) {
        $this->totalCharge = $totalCharge;
    }

    function setObservations($observations) {
        $this->observations = $observations;
    }

    function setDeposit(houseSupplyDeposit $deposit) {
        $this->deposit = $deposit;
    }

    function setInventoryChargeItems(houseSupplyInventoryChargeItems $inventoryChargeItems) {
        $this->inventoryChargeItems = $inventoryChargeItems;
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
