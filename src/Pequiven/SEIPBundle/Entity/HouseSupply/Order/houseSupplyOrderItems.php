<?php

namespace Pequiven\SEIPBundle\Entity\HouseSupply\Order;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\SEIPBundle\Entity\User;
use Pequiven\SEIPBundle\Entity\HouseSupply\Inventory\houseSupplyProduct;
use Pequiven\SEIPBundle\Entity\HouseSupply\Order\houseSupplyOrder;
use Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle;

/**
 * Items de Factura
 *
 * @author Gilbert C. <glavrjk@gmail.com>
 * 
 * @ORM\Table(name="seip_gsh_order_items") 
 * @ORM\Entity()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class houseSupplyOrderItems {

    /**
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * 1. PEDIDO / 2. DEVOLUCION DE PEDIDO / 3. EN ESPERA
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
     * @var \DateTime
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * 
     * @var houseSupplyOrder
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\HouseSupply\Order\houseSupplyOrder", inversedBy="orderItems")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id", nullable=true)
     */
    private $order;

    /**
     * 
     * @var User
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\User", inversedBy="houseSupplyOrderItems")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $client;

    /**
     * 
     * @var WorkStudyCircle
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle", inversedBy="houseSupplyOrderItems")
     * @ORM\JoinColumn(name="workstudycircle_id", referencedColumnName="id")
     */
    private $workStudyCircle;

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
     * @ORM\Column(name="price",type="float",nullable=true)
     */
    private $price;

    /**
     *
     * @var float
     * @ORM\Column(name="totalLine",type="float",nullable=true)
     */
    private $totalLine;

    /**
     *
     * @var float
     * @ORM\Column(name="totalLineTaxes",type="float",nullable=true)
     */
    private $totalLineTaxes;

    /**
     * 
     * @var houseSupplyProduct
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\HouseSupply\Inventory\houseSupplyProduct", inversedBy="orderItems")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $product;

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

    function getSign() {
        return $this->sign;
    }

    function getDate() {
        return $this->date;
    }

    function getOrder() {
        return $this->order;
    }

    function getClient() {
        return $this->client;
    }

    function getWorkStudyCircle() {
        return $this->workStudyCircle;
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

    function getPrice() {
        return $this->price;
    }

    function getTotalLine() {
        return $this->totalLine;
    }

    function getTotalLineTaxes() {
        return $this->totalLineTaxes;
    }

    function getProduct() {
        return $this->product;
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

    function setSign($sign) {
        $this->sign = $sign;
    }

    function setDate(\DateTime $date) {
        $this->date = $date;
    }

    function setOrder(houseSupplyOrder $order) {
        $this->order = $order;
    }

    function setClient(User $client) {
        $this->client = $client;
    }

    function setWorkStudyCircle(WorkStudyCircle $workStudyCircle) {
        $this->workStudyCircle = $workStudyCircle;
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

    function setPrice($price) {
        $this->price = $price;
    }

    function setTotalLine($totalLine) {
        $this->totalLine = $totalLine;
    }

    function setTotalLineTaxes($totalLineTaxes) {
        $this->totalLineTaxes = $totalLineTaxes;
    }

    function setProduct(houseSupplyProduct $product) {
        $this->product = $product;
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
