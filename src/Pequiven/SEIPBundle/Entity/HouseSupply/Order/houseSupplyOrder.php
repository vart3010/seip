<?php

namespace Pequiven\SEIPBundle\Entity\HouseSupply\Order;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\SEIPBundle\Entity\User;
use Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle;
use Pequiven\SEIPBundle\Entity\HouseSupply\Order\houseSupplyOrderItems;
use Pequiven\SEIPBundle\Entity\HouseSupply\Billing\houseSupplyBilling;
use Pequiven\SEIPBundle\Entity\HouseSupply\Order\houseSupplyCycle;

/**
 * Ordenes
 *
 * @author Gilbert C. <glavrjk@gmail.com>
 * 
 * @ORM\Table(name="seip_gsh_order")
 * @ORM\Entity()
 * @ORM\Entity("Pequiven\SEIPBundle\Repository\HouseSupply\Order\HouseSupplyOrderRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
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
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var \DateTime
     * @ORM\Column(name="dateBilling", type="datetime", nullable=true)
     */
    private $dateBilling;

    /**
     * 1. PEDIDO / 2. DEVOLUCION DE PEDIDO
     * @var string
     * @ORM\Column(name="type",type="string",nullable=false)
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
     * @var integer
     * @ORM\Column(name="nroOrder",type="integer",nullable=true)
     */
    private $nroOrder;

    /**
     *
     * @var integer
     * @ORM\Column(name="nroDevol",type="integer",nullable=true)
     */
    private $nroDevol;

    /**
     * 
     * @var integer
     * @ORM\Column(name="idAffected",type="integer",nullable=true)
     */
    private $idAffected;

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
    protected $orderItems;

    /**
     * @var houseSupplyBilling
     * @ORM\OneToMany(targetEntity="\Pequiven\SEIPBundle\Entity\HouseSupply\Billing\houseSupplyBilling",mappedBy="order",cascade={"persist"}))
     */
    protected $bills;

    /**
     * Creado por
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\User")
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

    function getDateBilling() {
        return $this->dateBilling;
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

    function getNroOrder() {
        return $this->nroOrder;
    }

    function getNroDevol() {
        return $this->nroDevol;
    }

    function getIdAffected() {
        return $this->idAffected;
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

    function getBills() {
        return $this->bills;
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

    function setDateBilling(\DateTime $dateBilling) {
        $this->dateBilling = $dateBilling;
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

    function setNroOrder($nroOrder) {
        $this->nroOrder = $nroOrder;
    }

    function setNroDevol($nroDevol) {
        $this->nroDevol = $nroDevol;
    }

    function setIdAffected($idAffected) {
        $this->idAffected = $idAffected;
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

    function setBills(houseSupplyBilling $bills) {
        $this->bills = $bills;
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
