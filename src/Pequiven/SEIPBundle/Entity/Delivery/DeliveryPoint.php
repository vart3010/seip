<?php

namespace Pequiven\SEIPBundle\Entity\Delivery;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\SEIPBundle\Model\Delivery\DeliveryPoint as Model;

/**
 * punto de despacho 
 *
 * @author Victor Tortolero <vart10.30@gmail.com>
 * @ORM\Table(name="seip_cei_DeliveryPoint")
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Repository\Delivery\DeliveryPointRepository")
 */
class DeliveryPoint extends Model {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Referencia del punto de despacho 
     * @var String 
     * @ORM\Column(name="ref",type="string",nullable=false)
     */
    private $ref;

    /**
     * Nombre del punto de despacho 
     * @var String 
     * @ORM\Column(name="descripcion",type="string",nullable=false)
     */
    private $descripcion;

    /**
     * Plantillas de plantas
     * @var \Pequiven\SEIPBundle\Entity\Delivery\ProductGroupDelivery
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\Delivery\ProductGroupDelivery",mappedBy="deliveryPoint",cascade={"remove"})
     */
    private $productGroupDelivery;

    /**
     * Periodo.
     * 
     * @var \Pequiven\SEIPBundle\Entity\Period
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Period")
     * @ORM\JoinColumn(nullable=false)
     */
    private $period;

    /**
     * Almacen
     * @var \Pequiven\SEIPBundle\Entity\CEI\Warehouse
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\Warehouse",inversedBy="deliveryPoint")
     * @ORM\JoinColumn(nullable=false)
     */
    private $warehouse;

    /**
     * Usuarios
     * @var type 
     * @ORM\ManyToMany(targetEntity="Pequiven\SEIPBundle\Entity\User",mappedBy="deliveryPoint")
     */
    private $users;

    public function __construct() {
        $this->productGroupDelivery = new \Doctrine\Common\Collections\ArrayCollection();
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * 
     * @param \Pequiven\SEIPBundle\Entity\User $user
     * @return \Pequiven\SEIPBundle\Entity\Delivery\ReportTemplateDelivery
     */
    public function addUser(\Pequiven\SEIPBundle\Entity\User $user) {
        $this->users[] = $user;

        return $this;
    }

    /**
     * 
     * @param \Pequiven\SEIPBundle\Entity\User $user
     */
    public function removeUser(\Pequiven\SEIPBundle\Entity\User $user) {
        $this->users->removeElement($user);
    }

    /**
     * 
     * @return type
     */
    public function getUser() {
        return $this->users;
    }

    /**
     * 
     * @param \Pequiven\SEIPBundle\Entity\Delivery\ProductGroupDelivery $productGroupDelivery
     * @return \Pequiven\SEIPBundle\Entity\Delivery\ReportTemplateDelivery
     */
    public function addProductGroupDeliveryDelivery(ProductGroupDelivery $productGroupDelivery) {
        $this->productGroupDelivery[] = $productGroupDelivery;

        return $this;
    }

    /**
     * 
     * @param \Pequiven\SEIPBundle\Entity\Delivery\ProductGroupDelivery $productReportDelivery
     */
    public function removeProductGroupDelivery(ProductGroupDelivery $productReportDelivery) {
        $this->productGroupDelivery->removeElement($productReportDelivery);
    }

    /**
     * 
     * @return type
     */
    public function getProductGroupDelivery() {
        return $this->productGroupDelivery;
    }

    function getWarehouse() {
        return $this->warehouse;
    }

    function setWarehouse(\Pequiven\SEIPBundle\Entity\CEI\Warehouse $warehouse) {
        $this->warehouse = $warehouse;
    }

    function getId() {
        return $this->id;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function getPeriod() {
        return $this->period;
    }

    function setPeriod(\Pequiven\SEIPBundle\Entity\Period $period) {
        $this->period = $period;
    }

    function getRef() {
        return $this->ref;
    }

    function setRef(String $ref) {
        $this->ref = $ref;
    }

}
