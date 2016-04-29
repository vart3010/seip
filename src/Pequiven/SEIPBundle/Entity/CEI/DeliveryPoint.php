<?php

namespace Pequiven\SEIPBundle\Entity\CEI;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\SEIPBundle\Model\CEI\DeliveryPoint as Model;

/**
 * punto de despacho 
 *
 * @author Victor Tortolero <vart10..30@gmail.com>
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
     * @var Pequiven\SEIPBundle\Entity\CEI\Warehouse
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\CEI\Warehouse", mappedBy="deliveryPoint")
     * */
    private $warehouse;

    /**
     * Constructor
     */
    public function __construct() {
        $this->warehouse = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * 
     * @param \Pequiven\SEIPBundle\Entity\CEI\Warehouse $warehouse
     * @return \Pequiven\SEIPBundle\Entity\CEI\DeliveryPoint
     */
    public function addWarehouse(Warehouse $warehouse) {
        $warehouse->setDeliveryPoint($this);

        $this->warehouse->add($warehouse);

        return $this;
    }

    function getWarehouse() {
        return $this->warehouse;
    }

    /**
     * 
     * @param \Pequiven\SEIPBundle\Entity\CEI\Warehouse $warehouse
     */
    public function removeWarehouse(Warehouse $warehouse) {
        $this->warehouse->removeElement($warehouse);
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

}
