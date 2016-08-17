<?php

namespace Pequiven\SEIPBundle\Entity\CEI;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\SEIPBundle\Model\CEI\Warehouse as Model;

/**
 * almacen
 *
 * @author Victor Tortolero <vart10.30@gmail.com>
 * @ORM\Table(name="seip_cei_Warehouse")
 * @ORM\Entity()
 */
class Warehouse extends Model {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Nombre del punto de despacho 
     * @var String 
     * @ORM\Column(name="descripcion",type="text",nullable=false)
     */
    private $descripcion;

    /**
     * @var Pequiven\SEIPBundle\Entity\CEI\DeliveryPoint
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\CEI\DeliveryPoint", mappedBy="warehouse")
     * */
    private $deliveryPoint;

    /**
     * Periodo.
     * 
     * @var \Pequiven\SEIPBundle\Entity\Period
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Period")
     * @ORM\JoinColumn(nullable=true)
     */
    private $period;

    /**
     * Constructor
     */
    public function __construct() {
        $this->deliveryPoint = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * 
     * @param \Pequiven\SEIPBundle\Entity\CEI\DeliveryPoint $deliveryPoint
     * @return \Pequiven\SEIPBundle\Entity\CEI\Warehouse
     */
    public function addDeliveryPoint(DeliveryPoint $deliveryPoint) {
        $deliveryPoint->setDeliveryPoint($this);

        $this->deliveryPoint->add($deliveryPoint);

        return $this;
    }

    /**
     * 
     * @return type
     */
    function getDeliveryPoint() {
        return $this->deliveryPoint;
    }

    /**
     * 
     * @param \Pequiven\SEIPBundle\Entity\CEI\DeliveryPoint $deliveryPoint
     */
    public function removeDeliveryPoint(DeliveryPoint $deliveryPoint) {
        $this->deliveryPoint->removeElement($deliveryPoint);
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

    public function __toString() {
        return $this->descripcion ? : '-';
    }

    function getPeriod() {
        return $this->period;
    }

    function setPeriod(\Pequiven\SEIPBundle\Entity\Period $period) {
        $this->period = $period;
    }

}
