<?php

namespace Pequiven\SEIPBundle\Entity\HouseSupply\Billing;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\SEIPBundle\Entity\User;
use Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle;
use Pequiven\SEIPBundle\Entity\HouseSupply\Billing\houseSupplyBilling;
use Pequiven\SEIPBundle\Entity\HouseSupply\Billing\houseSupplyBillingItems;
use Pequiven\SEIPBundle\Entity\HouseSupply\Billing\houseSupplyPayments;

/**
 * Facturas
 *
 * @author Gilbert C. <glavrjk@gmail.com>
 * 
 * @ORM\Table(name="seip_gsh_billing")
 * @ORM\Entity()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class houseSupplyBilling {

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
     * 1. FACTURA / 2. DEVOLUCION / 3. PEDIDO / 4. DEVOLUCION DE PEDIDO
     * @var string
     * @ORM\Column(name="type",type="string",nullable=false)
     */
    private $type;

    /**
     * 
     * @var houseSupplyBilling
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\HouseSupply\Billing\houseSupplyBilling", inversedBy="bills")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id", nullable=true)
     */
    private $order;

    /**
     * 
     * @var WorkStudyCircle
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle", inversedBy="houseSupplyBilling")
     * @ORM\JoinColumn(name="workstudycircle_id", referencedColumnName="id")
     */
    private $workStudyCircle;

    /**
     * 
     * @var User
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\User", inversedBy="houseSupplyBilling")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $client;

    /**
     *
     * @var integer
     * @ORM\Column(name="nroBill",type="integer",nullable=true)
     */
    private $nroBill;

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
     * @ORM\Column(name="taxable",type="float",nullable=false)
     */
    private $taxable;

    /**
     * MONTO DEL IVA
     * @var float
     * @ORM\Column(name="tax",type="float",nullable=false)
     */
    private $tax;

    /**
     *
     * @var float
     * @ORM\Column(name="totalBill",type="float",nullable=false)
     */
    private $totalBill;

    /**
     *
     * @var float
     * @ORM\Column(name="totalPaid",type="float",nullable=false)
     */
    private $totalPaid;

    /**
     * Facturas en HouseSupply
     * 
     * @var houseSupplyBilling
     * @ORM\OneToMany(targetEntity="\Pequiven\SEIPBundle\Entity\HouseSupply\Billing\houseSupplyPayments",mappedBy="bill",cascade={"persist","remove"})
     */
    protected $payments;

    /**
     * Facturas en HouseSupply
     * 
     * @var houseSupplyBilling
     * @ORM\OneToMany(targetEntity="\Pequiven\SEIPBundle\Entity\HouseSupply\Billing\houseSupplyBilling",mappedBy="order",cascade={"persist","remove"})
     */
    protected $bills;

    /**
     * @var houseSupplyBillingItems
     * @ORM\OneToMany(targetEntity="\Pequiven\SEIPBundle\Entity\HouseSupply\Billing\houseSupplyBillingItems",mappedBy="bill",cascade={"persist"}))
     */
    protected $billingItems;

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

    function getType() {
        return $this->type;
    }

    function getOrder() {
        return $this->order;
    }

    function getWorkStudyCircle() {
        return $this->workStudyCircle;
    }

    function getClient() {
        return $this->client;
    }

    function getNroBill() {
        return $this->nroBill;
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

    function getTotalBill() {
        return $this->totalBill;
    }

    function getTotalPaid() {
        return $this->totalPaid;
    }

    function getPayments() {
        return $this->payments;
    }

    function getBills() {
        return $this->bills;
    }

    function getBillingItems() {
        return $this->billingItems;
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

    function setOrder(houseSupplyBilling $order) {
        $this->order = $order;
    }

    function setWorkStudyCircle(WorkStudyCircle $workStudyCircle) {
        $this->workStudyCircle = $workStudyCircle;
    }

    function setClient(User $client) {
        $this->client = $client;
    }

    function setNroBill($nroBill) {
        $this->nroBill = $nroBill;
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

    function setTotalBill($totalBill) {
        $this->totalBill = $totalBill;
    }

    function setTotalPaid($totalPaid) {
        $this->totalPaid = $totalPaid;
    }

    function setPayments(houseSupplyBilling $payments) {
        $this->payments = $payments;
    }

    function setBills(houseSupplyBilling $bills) {
        $this->bills = $bills;
    }

    function setBillingItems(houseSupplyBillingItems $billingItems) {
        $this->billingItems = $billingItems;
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
