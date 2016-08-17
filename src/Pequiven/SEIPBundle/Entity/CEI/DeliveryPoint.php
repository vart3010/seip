<?php

namespace Pequiven\SEIPBundle\Entity\CEI;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\SEIPBundle\Model\CEI\DeliveryPoint as Model;

/**
 * punto de despacho 
 *
 * @author Victor Tortolero <vart10.30@gmail.com>
 * @ORM\Table(name="seip_cei_DeliveryPoint")
 * @ORM\Entity()
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
     * Nombre del punto de despacho 
     * @var String 
     * @ORM\Column(name="descripcion",type="string",nullable=false)
     */
    private $descripcion;

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
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\Warehouse")
     * @ORM\JoinColumn(nullable=false)
     */
    private $warehouse;

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

}
