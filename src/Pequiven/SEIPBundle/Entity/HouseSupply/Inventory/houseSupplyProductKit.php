<?php

namespace Pequiven\SEIPBundle\Entity\HouseSupply\Inventory;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\SEIPBundle\Entity\User;
use Pequiven\SEIPBundle\Entity\HouseSupply\Inventory\houseSupplyProductKitItems;
use Pequiven\SEIPBundle\Entity\HouseSupply\Order\houseSupplyCycle;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Kit de Productos
 *
 * @author Máximo Sojo
 * 
 * @ORM\Table(name="seip_gsh_productkit")
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Repository\HouseSupply\Inventory\HouseSupplyProductKitRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class houseSupplyProductKit {

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
     * @var houseSupplyProductKitItems
     * @ORM\OneToMany(targetEntity="\Pequiven\SEIPBundle\Entity\HouseSupply\Inventory\houseSupplyProductKitItems",mappedBy="productKit",cascade={"persist"}))
     */
    protected $productKitItems;

    /**
     * @var houseSupplyCycle
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\HouseSupply\Order\houseSupplyCycle",mappedBy="productKit",cascade={"persist"}))
     */
    protected $cycle;

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
    
    public function __toString() {
        return $this->description;
    }

        function getId() {
        return $this->id;
    }

    function getCode() {
        return $this->code;
    }

    function getDescription() {
        return $this->description;
    }

    function getProductKitItems() {
        return $this->productKitItems;
    }

    function getCycle() {
        return $this->cycle;
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

    function setProductKitItems(houseSupplyProductKitItems $productKitItems) {
        $this->productKitItems = $productKitItems;
    }

    function setCycle(houseSupplyCycle $cycle) {
        $this->cycle = $cycle;
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
