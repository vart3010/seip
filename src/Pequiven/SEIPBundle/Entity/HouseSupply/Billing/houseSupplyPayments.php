<?php

namespace Pequiven\SEIPBundle\Entity\HouseSupply\Billing;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\SEIPBundle\Entity\User;

/**
 * Pagos
 *
 * @author Gilbert C. <glavrjk@gmail.com>
 * 
 * @ORM\Table(name="seip_gsh_payments")
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
     * @var houseSupplyBilling
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\HouseSupply\Billing\houseSupplyBilling", inversedBy="payments")
     * @ORM\JoinColumn(name="bill_id", referencedColumnName="id", nullable=true)
     */
    private $bill;

    /**
     * 1. TRANSFERENCIA / 2. TARJETA DE DEBITO / 3. TARJETA DE CREDITO
     * @var string
     * @ORM\Column(name="type",type="string",nullable=false)
     */
    private $type;

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

    function getBill() {
        return $this->bill;
    }

    function getType() {
        return $this->type;
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

    function setBill(houseSupplyBilling $bill) {
        $this->bill = $bill;
    }

    function setType($type) {
        $this->type = $type;
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
