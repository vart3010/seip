<?php

namespace Pequiven\SEIPBundle\Entity\HouseSupply\Inventory;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\SEIPBundle\Entity\User;
use Pequiven\SEIPBundle\Entity\HouseSupply\Inventory\houseSupplyInventory;
use Pequiven\SEIPBundle\Entity\HouseSupply\Inventory\houseSupplyInventoryChargeItems;
use Pequiven\SEIPBundle\Entity\HouseSupply\Order\houseSupplyOrderItems;
use Pequiven\SEIPBundle\Entity\HouseSupply\Inventory\houseSupplyProduct;

/**
 * Instancias de Productos
 *
 * @author Gilbert C. <glavrjk@gmail.com>
 * 
 * @ORM\Table(name="seip_gsh_product_instance")
 * @ORM\Entity()
 * @ORM\Entity("Pequiven\SEIPBundle\Repository\HouseSupply\Inventory\HouseSupplyProductInstanceRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class houseSupplyProductInstance {

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
     * @ORM\Column(name="maxPerUser",type="float",nullable=false)
     */
    private $maxPerUser;

    /**
     * Productos en Instancia
     * 
     * @var houseSupplyProduct
     * @ORM\OneToMany(targetEntity="\Pequiven\SEIPBundle\Entity\HouseSupply\Inventory\houseSupplyProduct",mappedBy="instance",cascade={"persist","remove"})
     */
    protected $product;

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

    function getCode() {
        return $this->code;
    }

    function getDescription() {
        return $this->description;
    }

    function getMaxPerUser() {
        return $this->maxPerUser;
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

    function setCode($code) {
        $this->code = $code;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setMaxPerUser($maxPerUser) {
        $this->maxPerUser = $maxPerUser;
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
