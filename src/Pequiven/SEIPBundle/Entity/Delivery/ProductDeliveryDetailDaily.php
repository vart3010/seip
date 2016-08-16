<?php

namespace Pequiven\SEIPBundle\Entity\Delivery;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\SEIPBundle\Model\Delivery\ProductDeliveryDetailDaily as BaseModel;

/**
 * Description of ProductDeliveryDetailDaily
 *
 * @author Victor Tortolero <vart10.30@gmail.com>
 * @ORM\Table(name="seip_delivery_product_detail_daily")
 * @ORM\Entity()
 */
class ProductDeliveryDetailDaily extends BaseModel {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Producto de reporte
     * @var \Pequiven\SEIPBundle\Entity\Delivery\ProductReportDelivery
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Delivery\ProductReportDelivery",inversedBy="productDeliveryDetailDaily")
     * @ORM\JoinColumn(nullable=false)
     */
    private $productReportDelivery;

    
    /**
     * punto de despacho
     * @var \Pequiven\SEIPBundle\Entity\CEI\DeliveryPoint
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\DeliveryPoint")
     * @ORM\JoinColumn(nullable=false)
     */
    private $deliveryPonint;

    /**
     * Mes
     * @var integer
     * @ORM\Column(name="month",type="integer",length=2,nullable=false)
     */
    private $month;

    /**
     * plan
     * @var float
     * @ORM\Column(name="plan",type="float")
     */
    private $plan = 0;

    /**
     * programa
     * @var float
     * @ORM\Column(name="programa",type="float")
     */
    private $program = 0;

    /**
     * real
     * @var float
     * @ORM\Column(name="real",type="float")
     */
    private $real = 0;

    function getMonth() {
        return $this->month;
    }

    function getPlan() {
        return $this->plan;
    }

    function getProgram() {
        return $this->program;
    }

    function getReal() {
        return $this->real;
    }

    function setMonth($month) {
        $this->month = $month;
    }

    function setPlan($plan) {
        $this->plan = $plan;
    }

    function setProgram($program) {
        $this->program = $program;
    }

    function setReal($real) {
        $this->real = $real;
    }

    function getId() {
        return $this->id;
    }

    function getProductReportDelivery() {
        return $this->productReportDelivery;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setProductReportDelivery(\Pequiven\SEIPBundle\Entity\Delivery\ProductReportDelivery $productReportDelivery) {
        $this->productReportDelivery = $productReportDelivery;
    }

    function getDeliveryPonint() {
        return $this->deliveryPonint;
    }

    function setDeliveryPonint(\Pequiven\SEIPBundle\Entity\CEI\DeliveryPoint $deliveryPonint) {
        $this->deliveryPonint = $deliveryPonint;
    }

}
