<?php

namespace Pequiven\SEIPBundle\Entity\CEI;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\SEIPBundle\Model\CEI\Warehouse as Model;

/**
 * almacen
 *
 * @author Victor Tortolero <vart10..30@gmail.com>
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
     * User
     * @var \Pequiven\SEIPBundle\Entity\CEI\DeliveryPoint
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\DeliveryPoint", inversedBy="warehouse")
     */
    private $deliveryPoint;

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

    function getDeliveryPoint() {
        return $this->deliveryPoint;
    }

    function setDeliveryPoint(\Pequiven\SEIPBundle\Entity\CEI\DeliveryPoint $deliveryPoint) {
        $this->deliveryPoint = $deliveryPoint;
    }

    public function __toString() {
        return $this->descripcion;
    }

}
