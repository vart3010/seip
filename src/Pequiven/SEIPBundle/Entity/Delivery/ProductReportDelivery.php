<?php

namespace Pequiven\SEIPBundle\Entity\Delivery;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\MasterBundle\Model\Base\ModelBaseMaster;

/**
 * Producto de reporte despacho
 *
 * @author Victor Tortolero <vart10.30@gmail.com>
 * @ORM\Table(name="seip_delivery_product_report")
 */
class ProductReportDelivery extends ModelBaseMaster {

    /**
     * @var integer
     *
     * @ORM\Column(name="id",length=6, type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Plantilla de grupo de productos ventas
     * 
     * @var \Pequiven\SEIPBundle\Entity\Delivery\ProductGroupDelivery
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Delivery\ProductGroupDelivery",inversedBy="productsReportDelivery")
     * @ORM\JoinColumn(nullable=false)
     */
    private $productGroupDelivery;

    /**
     * Detalles del producto 
     * @var \Pequiven\SEIPBundle\Entity\Delivery\ProductDeliveryDetailDaily
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\Delivery\ProductDeliveryDetailDaily",mappedBy="productReportDelivery",cascade={"remove"})
     */
    private $productDeliveryDetailDaily;
    

    /**
     * Producto
     * @var \Pequiven\SEIPBundle\Entity\CEI\Product
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\Product",inversedBy="productReports")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;
//
//    /**
//     * Indicador
//     * @var \Pequiven\IndicatorBundle\Entity\Indicator
//     * @ORM\ManyToOne(targetEntity="Pequiven\IndicatorBundle\Entity\Indicator")
//     */
//    private $indicator;
//
//    
    /**
     * Periodo.
     * 
     * @var \Pequiven\SEIPBundle\Entity\Period
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Period")
     * @ORM\JoinColumn(nullable=true)
     */
    private $period;

    /**
     * Tipo de producto de despacho(ENSACADO,GRANULADA)
     * 
     * @var integer
     * @ORM\Column(name="type",type="integer")
     */
    protected $type;

    /**
     * @var \Pequiven\SEIPBundle\Entity\Delivery\ProductReportDelivery
     * @ORM\OneToOne(targetEntity="\Pequiven\SEIPBundle\Entity\Delivery\ProductReportDelivery")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true)
     */
    private $parent;
    private $name = '';

    public function __construct() {
        $this->productDeliveryDetailDaily = new \Doctrine\Common\Collections\ArrayCollection();
    }

    function getId() {
        return $this->id;
    }

//    function getIndicator() {
//        return $this->indicator;
//    }

    function getPeriod() {
        return $this->period;
    }

    function getParent() {
        return $this->parent;
    }

    function getName() {
        return $this->name;
    }

    function setId($id) {
        $this->id = $id;
    }

    function getType() {
        return $this->type;
    }

    function setType($type) {
        $this->type = $type;
    }

//    function setIndicator(\Pequiven\IndicatorBundle\Entity\Indicator $indicator) {
//        $this->indicator = $indicator;
//    }

    function setPeriod(\Pequiven\SEIPBundle\Entity\Period $period) {
        $this->period = $period;
    }

    function setParent(\Pequiven\SEIPBundle\Entity\Delivery\ProductReportDelivery $parent) {
        $this->parent = $parent;
    }

    function setName($name) {
        $this->name = $name;
    }

    function getProductGroupDelivery() {
        return $this->productGroupDelivery;
    }

    function setProductGroupDelivery(\Pequiven\SEIPBundle\Entity\Delivery\ProductGroupDelivery $productGroupDelivery) {
        $this->productGroupDelivery = $productGroupDelivery;
    }

    function getProduct() {
        return $this->product;
    }

    function setProduct(\Pequiven\SEIPBundle\Entity\CEI\Product $product) {
        $this->product = $product;
    }

    /**
     * 
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\ProductDetailDailyMonth $productDetailDailyMonth
     * @return \Pequiven\SEIPBundle\Entity\Delivery\ProductReportDelivery
     */
    public function addProductDeliveryDetailDaily(\Pequiven\SEIPBundle\Entity\DataLoad\Production\ProductDetailDailyMonth $productDetailDailyMonth) {
        $productDetailDailyMonth->setProductReport($this);

        $this->productGroupDelivery->add($productDetailDailyMonth);

        return $this;
    }
    
    /**
     * 
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\ProductDetailDailyMonth $productDetailDailyMonth
     */
    public function removeProductDetailDailyMonth(\Pequiven\SEIPBundle\Entity\DataLoad\Production\ProductDetailDailyMonth $productDetailDailyMonth) {
        $this->productGroupDelivery->removeElement($productDetailDailyMonth);
    }
    
    /**
     * 
     * @return type
     */
    function getProductDeliveryDetailDaily() {
        return $this->productDeliveryDetailDaily;
    }

}
