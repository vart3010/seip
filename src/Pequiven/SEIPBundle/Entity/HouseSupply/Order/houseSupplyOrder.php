<?php

namespace Pequiven\SEIPBundle\Entity\HouseSupply\Order;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\SEIPBundle\Entity\User;
use Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle;
use Pequiven\SEIPBundle\Entity\HouseSupply\Order\houseSupplyOrderItems;
use Pequiven\SEIPBundle\Entity\HouseSupply\Order\houseSupplyCycle;
use Pequiven\SEIPBundle\Entity\HouseSupply\Inventory\houseSupplyProductKit;
use Pequiven\SEIPBundle\Entity\HouseSupply\Order\houseSupplyPayments;

/**
 * Ordenes
 *
 * @author Gilbert C. <glavrjk@gmail.com>
 * 
 * @ORM\Table(name="seip_gsh_order")
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Repository\HouseSupply\Order\HouseSupplyOrderRepository") 
 */
class houseSupplyOrder {

    /**
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     * @ORM\Column(name="dateOrder", type="datetime", nullable=false)
     */
    private $dateOrder;

    /**
     * @var \DateTime
     * @ORM\Column(name="datePay", type="datetime", nullable=true)
     */
    private $datePay;

    /**
     * @var \DateTime
     * @ORM\Column(name="dateDelivery", type="datetime", nullable=true)
     */
    private $dateDelivery;

    /**
     * REGISTRADA = 1; / DEVUELTA = 2; / ESPERA = 3; / PAGADA = 4; / ENTREGADA = 5;    
     * @var integer
     * @ORM\Column(name="type",type="integer",nullable=false)
     */
    private $type;

    /**
     *
     * @var integer
     * @ORM\Column(name="sign",type="integer",nullable=false)
     */
    private $sign;

    /**
     * 
     * @var WorkStudyCircle
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle", inversedBy="houseSupplyOrder")
     * @ORM\JoinColumn(name="workstudycircle_id", referencedColumnName="id")
     */
    private $workStudyCircle;

    /**
     * 
     * @var houseSupplyCycle
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\HouseSupply\Order\houseSupplyCycle", inversedBy="houseSupplyOrder")
     * @ORM\JoinColumn(name="cycle_id", referencedColumnName="id")
     */
    private $cycle;

    /**
     * 
     * @var houseSupplyProductKit
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\HouseSupply\Inventory\houseSupplyProductKit", inversedBy="houseSupplyOrder")
     * @ORM\JoinColumn(name="productkit_id", referencedColumnName="id", nullable=true)
     */
    private $productKit;

    /**
     *
     * @var integer
     * @ORM\Column(name="nroOrder",type="integer",nullable=true)
     */
    private $nroOrder;

    /**
     * BASE IMPONIBLE. MONTO SIN IVA
     * @var float
     * @ORM\Column(name="taxable",type="float",nullable=true)
     */
    private $taxable;

    /**
     * MONTO DEL IVA
     * @var float
     * @ORM\Column(name="tax",type="float",nullable=true)
     */
    private $tax;

    /**
     *
     * @var float
     * @ORM\Column(name="totalOrder",type="float",nullable=true)
     */
    private $totalOrder;

    /**
     * @var houseSupplyOrderItems
     * @ORM\OneToMany(targetEntity="\Pequiven\SEIPBundle\Entity\HouseSupply\Order\houseSupplyOrderItems",mappedBy="order",cascade={"persist"}))
     */
    private $orderItems;

    /**
     * @var houseSupplyPayments
     * @ORM\OneToMany(targetEntity="\Pequiven\SEIPBundle\Entity\HouseSupply\Order\houseSupplyPayments",mappedBy="order",cascade={"persist"}))
     */
    private $payments;

    /**
     * Creado por
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $createdBy;

    /**
     * Pagado por
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     */
    private $paidBy;

    /**
     * Despachado por
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     */
    private $deliveredBy;

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

    /**
     * Devuelto por
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     */
    private $deletedBy;

    function __construct() {
        $this->orderItems = new \Doctrine\Common\Collections\ArrayCollection();
    }

    function getId() {
        return $this->id;
    }

    function getDateOrder() {
        return $this->dateOrder;
    }

    function getDatePay() {
        return $this->datePay;
    }

    function getDateDelivery() {
        return $this->dateDelivery;
    }

    function getType() {
        return $this->type;
    }

    function getSign() {
        return $this->sign;
    }

    function getWorkStudyCircle() {
        return $this->workStudyCircle;
    }

    function getCycle() {
        return $this->cycle;
    }

    function getProductKit() {
        return $this->productKit;
    }

    function getNroOrder() {
        return $this->nroOrder;
    }

    function getTaxable() {
        return $this->taxable;
    }

    function getTax() {
        return $this->tax;
    }

    function getTotalOrder() {
        return $this->totalOrder;
    }

    function getOrderItems() {
        return $this->orderItems;
    }

    function getPayments() {
        return $this->payments;
    }

    function getCreatedBy() {
        return $this->createdBy;
    }

    function getPaidBy() {
        return $this->paidBy;
    }

    function getDeliveredBy() {
        return $this->deliveredBy;
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

    function getDeletedBy() {
        return $this->deletedBy;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDateOrder(\DateTime $dateOrder) {
        $this->dateOrder = $dateOrder;
    }

    function setDatePay(\DateTime $datePay) {
        $this->datePay = $datePay;
    }

    function setDateDelivery(\DateTime $dateDelivery) {
        $this->dateDelivery = $dateDelivery;
    }

    function setType($type) {
        $this->type = $type;
    }

    function setSign($sign) {
        $this->sign = $sign;
    }

    function setWorkStudyCircle(WorkStudyCircle $workStudyCircle) {
        $this->workStudyCircle = $workStudyCircle;
    }

    function setCycle(houseSupplyCycle $cycle) {
        $this->cycle = $cycle;
    }

    function setProductKit(houseSupplyProductKit $productKit) {
        $this->productKit = $productKit;
    }

    function setNroOrder($nroOrder) {
        $this->nroOrder = $nroOrder;
    }

    function setTaxable($taxable) {
        $this->taxable = $taxable;
    }

    function setTax($tax) {
        $this->tax = $tax;
    }

    function setTotalOrder($totalOrder) {
        $this->totalOrder = $totalOrder;
    }

    function setOrderItems(houseSupplyOrderItems $orderItems) {
        $this->orderItems = $orderItems;
    }

    function setPayments(houseSupplyPayments $payments) {
        $this->payments = $payments;
    }

    function setCreatedBy(User $createdBy) {
        $this->createdBy = $createdBy;
    }

    function setPaidBy(User $paidBy) {
        $this->paidBy = $paidBy;
    }

    function setDeliveredBy(User $deliveredBy) {
        $this->deliveredBy = $deliveredBy;
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

    function setDeletedBy(User $deletedBy) {
        $this->deletedBy = $deletedBy;
    }

}
