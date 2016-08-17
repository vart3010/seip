<?php

namespace Pequiven\SEIPBundle\Entity\Delivery;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of ProductReportDetailMonth
 *
 * @author Victor Tortolero <vart10.30@gmail.com>
 * @ORM\Table(name="seip_delivery_product_detail_month")
 * @ORM\Entity()
 */
class ProductGroupReportDetailMonth {

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
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Delivery\ProductGroupDelivery",inversedBy="productGroupDeliveryDetailMonth")
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
     * total plan
     * @var float
     * @ORM\Column(name="totalPlan",type="float")
     */
    private $totalPlan = 0;

    /**
     * total program
     * @var float
     * @ORM\Column(name="totalProgram",type="float")
     */
    private $totalProgram = 0;

    /**
     * total real
     * @var float
     * @ORM\Column(name="totalReal",type="float")
     */
    private $totalReal = 0;

    /**
     * Periodo.
     * 
     * @var \Pequiven\SEIPBundle\Entity\Period
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Period")
     * @ORM\JoinColumn(nullable=true)
     */
    private $period;

    function getId() {
        return $this->id;
    }

    function getProductReportDelivery() {
        return $this->productReportDelivery;
    }

    function getMonth() {
        return $this->month;
    }

    function getTotalPlan() {
        return $this->totalPlan;
    }

    function getTotalProgram() {
        return $this->totalProgram;
    }

    function getTotalReal() {
        return $this->totalReal;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setProductReportDelivery(\Pequiven\SEIPBundle\Entity\Delivery\ProductReportDelivery $productReportDelivery) {
        $this->productReportDelivery = $productReportDelivery;
    }

    function setMonth($month) {
        $this->month = $month;
    }

    function setTotalPlan($totalPlan) {
        $this->totalPlan = $totalPlan;
    }

    function setTotalProgram($totalProgram) {
        $this->totalProgram = $totalProgram;
    }

    function setTotalReal($totalReal) {
        $this->totalReal = $totalReal;
    }

    function getPeriod() {
        return $this->period;
    }

    function setPeriod(\Pequiven\SEIPBundle\Entity\Period $period) {
        $this->period = $period;
    }

}
