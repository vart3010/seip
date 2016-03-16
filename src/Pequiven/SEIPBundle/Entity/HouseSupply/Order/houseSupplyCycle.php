<?php

namespace Pequiven\SEIPBundle\Entity\HouseSupply\Order;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\SEIPBundle\Entity\User;
use Pequiven\SEIPBundle\Entity\HouseSupply\Order\houseSupplyOrder;

/**
 * Ciclos de Pedidos por Grupo de WorkstudyCircle
 *
 * @author Gilbert C. <glavrjk@gmail.com>
 * 
 * @ORM\Table(name="seip_gsh_cycle") 
 * @ORM\Entity("Pequiven\SEIPBundle\Repository\HouseSupply\Order\HouseSupplyCycleRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class houseSupplyCycle {

    /**
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     * @ORM\Column(name="dateBeginOrder", type="datetime", nullable=false)
     */
    private $dateBeginOrder;

    /**
     * @var \DateTime
     * @ORM\Column(name="dateEndOrder", type="datetime", nullable=false)
     */
    private $dateEndOrder;

    /**
     *
     * @var integer
     * @ORM\Column(name="workStudyCircleGroup",type="integer",nullable=false)
     */
    private $workStudyCircleGroup;

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

    /**
     * @var houseSupplyOrder
     * @ORM\OneToMany(targetEntity="\Pequiven\SEIPBundle\Entity\HouseSupply\Order\houseSupplyOrder",mappedBy="cycle",cascade={"persist"}))
     */
    private $houseSupplyOrder;

    function getId() {
        return $this->id;
    }

    function getDateBeginOrder() {
        return $this->dateBeginOrder;
    }

    function getDateEndOrder() {
        return $this->dateEndOrder;
    }

    function getWorkStudyCircleGroup() {
        return $this->workStudyCircleGroup;
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

    function getHouseSupplyOrder() {
        return $this->houseSupplyOrder;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDateBeginOrder(\DateTime $dateBeginOrder) {
        $this->dateBeginOrder = $dateBeginOrder;
    }

    function setDateEndOrder(\DateTime $dateEndOrder) {
        $this->dateEndOrder = $dateEndOrder;
    }

    function setWorkStudyCircleGroup($workStudyCircleGroup) {
        $this->workStudyCircleGroup = $workStudyCircleGroup;
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

    function setHouseSupplyOrder(houseSupplyOrder $houseSupplyOrder) {
        $this->houseSupplyOrder = $houseSupplyOrder;
    }

}
