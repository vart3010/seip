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
class ProductGroupDeliveryDetailDaily extends BaseModel {

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
     * @var \Pequiven\SEIPBundle\Entity\Delivery\ProductGroupDelivery
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Delivery\ProductGroupDelivery",inversedBy="productGroupDeliveryDetailDaily")
     * @ORM\JoinColumn(nullable=false)
     */
    private $productReportDelivery;

    /**
     * Mes
     * @var integer
     * @ORM\Column(name="month",type="integer",length=2,nullable=false)
     */
    private $month;

    /**
     * Periodo.
     * 
     * @var \Pequiven\SEIPBundle\Entity\Period
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Period")
     * @ORM\JoinColumn(nullable=true)
     */
    private $period;

    /**
     * real
     * @var float
     * @ORM\Column(name="real",type="float")
     */
    private $real = 0;

    function getId() {
        return $this->id;
    }

    function getProductReportDelivery() {
        return $this->productReportDelivery;
    }

    function getMonth() {
        return $this->month;
    }

    function getReal() {
        return $this->real;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setProductReportDelivery(\Pequiven\SEIPBundle\Entity\Delivery\ProductGroupDelivery $productReportDelivery) {
        $this->productReportDelivery = $productReportDelivery;
    }

    function setMonth($month) {
        $this->month = $month;
    }

    function setReal($real) {
        $this->real = $real;
    }

    function getPeriod() {
        return $this->period;
    }

    function setPeriod(\Pequiven\SEIPBundle\Entity\Period $period) {
        $this->period = $period;
    }

}
