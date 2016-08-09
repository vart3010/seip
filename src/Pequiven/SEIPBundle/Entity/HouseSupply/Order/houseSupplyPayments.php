<?php

namespace Pequiven\SEIPBundle\Entity\HouseSupply\Order;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\SEIPBundle\Entity\User;
use Pequiven\SEIPBundle\Entity\HouseSupply\Order\houseSupplyOrder;

/**
 * Pagos
 *
 * @author Gilbert C. <glavrjk@gmail.com>
 * 
 * @ORM\Table(name="seip_gsh_order_payments")
 * @ORM\Entity()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class houseSupplyPayments {

    /**
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * 
     * @var HouseSupplyOrder
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\HouseSupply\Order\HouseSupplyOrder", inversedBy="payments")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id", nullable=false)
     */
    private $order;

    /**
     * 1. TRANSFERENCIA / 2. TARJETA DE DEBITO / 3. TARJETA DE CREDITO
     * @var interger
     * @ORM\Column(name="type",type="integer",nullable=false)
     */
    private $type;

    /**
     * 
     * @var string
     * @ORM\Column(name="ref",type="string",nullable=false)
     */
    private $ref;

    /**
     *
     * @var float
     * @ORM\Column(name="total",type="float",nullable=false)
     */
    private $total;

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

    function getOrder() {
        return $this->order;
    }

    function getType() {
        return $this->type;
    }

    function getRef() {
        return $this->ref;
    }

    function getTotal() {
        return $this->total;
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

    function setOrder(HouseSupplyOrder $order) {
        $this->order = $order;
    }

    function setType($type) {
        $this->type = $type;
    }

    function setRef($ref) {
        $this->ref = $ref;
    }

    function setTotal($total) {
        $this->total = $total;
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
