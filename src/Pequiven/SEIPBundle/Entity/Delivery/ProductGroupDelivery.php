<?php

namespace Pequiven\SEIPBundle\Entity\Delivery;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\MasterBundle\Model\Base\ModelBaseMaster;

/**
 * Reporte de grupo de productos de despacho
 *
 * @author Victor Tortolero <vart10.30@gmail.com>
 * @ORM\Table(name="seip_delivery_product_group")
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Repository\Delivery\ProductGroupDeliveryRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class ProductGroupDelivery extends ModelBaseMaster {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Reporte de delivery
     * @var \Pequiven\SEIPBundle\Entity\Delivery\DeliveryPoint
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Delivery\DeliveryPoint",inversedBy="productGroupDelivery")
     * @ORM\JoinColumn(nullable=false)
     */
    private $deliveryPoint;

    /**
     * Productos del reporte
     * @var \Pequiven\SEIPBundle\Entity\Delivery\ProductReportDelivery
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\Delivery\ProductReportDelivery",mappedBy="productGroupDelivery",cascade={"remove"})
     */
    private $productsReportDelivery;

    /**
     * Detalles del producto  diario
     * @var \Pequiven\SEIPBundle\Entity\Delivery\ProductGroupDeliveryDetailDaily
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\Delivery\ProductGroupDeliveryDetailDaily",mappedBy="productReportDelivery",cascade={"remove"})
     */
    private $productGroupDeliveryDetailDaily;

    /**
     * Detalles del producto mensual
     * @var \Pequiven\SEIPBundle\Entity\Delivery\ProductGroupDeliveryDetailMonth
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\Delivery\ProductGroupDeliveryDetailMonth",mappedBy="productReportDelivery",cascade={"remove"})
     */
    private $productGroupDeliveryDetailMonth;

    /**
     * Usuarios
     * @var type 
     * @ORM\ManyToMany(targetEntity="Pequiven\SEIPBundle\Entity\User",mappedBy="plantReports")
     */
    private $users;

    /**
     * Periodo.
     * 
     * @var \Pequiven\SEIPBundle\Entity\Period
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Period")
     * @ORM\JoinColumn(nullable=true)
     */
    private $period;

    /**
     * Production line.
     * 
     * @var \Pequiven\SEIPBundle\Entity\CEI\ProductionLine
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\ProductionLine",inversedBy="productGroupDelivery")
     * @ORM\JoinColumn(nullable=true)
     */
    private $productionLine;

    /**
     * @var \Pequiven\SEIPBundle\Entity\Delivery\ProductGroupDelivery
     * @ORM\OneToOne(targetEntity="\Pequiven\SEIPBundle\Entity\Delivery\ProductGroupDelivery")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true)
     */
    private $parent;

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
     * Constructor
     */
    public function __construct() {
        $this->productsReportDelivery = new \Doctrine\Common\Collections\ArrayCollection();
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
        $this->productDeliveryDetailDaily = new \Doctrine\Common\Collections\ArrayCollection();
        $this->productDeliveryDetailMonth = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * 
     * @param \Pequiven\SEIPBundle\Entity\Delivery\ProductGroupDeliveryDetailMonth $productGroupDetailDaily
     * @return \Pequiven\SEIPBundle\Entity\Delivery\ProductGroupDelivery
     */
    public function addProductGroupDeliveryDetailMonth(ProductGroupDeliveryDetailMonth $productGroupDetailMonth) {
        $productGroupDetailMonth->setProductReport($this);

        $this->productDeliveryDetailMonth->add($productGroupDetailMonth);

        return $this;
    }

    /**
     * 
     * @param \Pequiven\SEIPBundle\Entity\Delivery\ProductGroupDeliveryDetailMonth $productGroupDetailMonth
     */
    public function removeProductGroupDeliveryDetailMonth(ProductGroupDeliveryDetailMonth $productGroupDetailMonth) {
        $this->productDeliveryDetailMonth->removeElement($productGroupDetailMonth);
    }

    /**
     * 
     * @return type
     */
    function getProductGroupDeliveryDetailMonth() {
        return $this->productGroupDeliveryDetailMonth;
    }

    /**
     * 
     * @param \Pequiven\SEIPBundle\Entity\Delivery\ProductGroupDeliveryDetailDaily $productGroupDetailDaily
     * @return \Pequiven\SEIPBundle\Entity\Delivery\ProductGroupDelivery
     */
    public function addProductGroupDeliveryDetailDaily(ProductGroupDeliveryDetailDaily $productGroupDetailDaily) {
        $productGroupDetailDaily->setProductReport($this);

        $this->productDeliveryDetailDaily->add($productGroupDetailDaily);

        return $this;
    }

    /**
     * 
     * @param \Pequiven\SEIPBundle\Entity\Delivery\ProductGroupDeliveryDetailDaily $productGroupDetailDaily
     */
    public function removeProductGroupDeliveryDetailDaily(ProductGroupDeliveryDetailDaily $productGroupDetailDaily) {
        $this->productDeliveryDetailDaily->removeElement($productGroupDetailDaily);
    }

    /**
     * 
     * @return type
     */
    function getProductGroupDeliveryDetailDaily() {
        return $this->productGroupDeliveryDetailDaily;
    }

    function getPlan() {
        return $this->plan;
    }

    function getProgram() {
        return $this->program;
    }

    /**
     * 
     * @param \Pequiven\SEIPBundle\Entity\Delivery\ProductReportDelivery $productsReportDelivery
     * @return \Pequiven\SEIPBundle\Entity\Delivery\ProductGroupDelivery
     */
    public function addProductsReportDelivery(\Pequiven\SEIPBundle\Entity\Delivery\ProductReportDelivery $productsReportDelivery) {
        $this->productsReportDelivery[] = $productsReportDelivery;

        return $this;
    }

    /**
     * 
     * @param \Pequiven\SEIPBundle\Entity\Delivery\ProductReportDelivery $productsReportDelivery
     */
    public function removeProductsReportDelivery(\Pequiven\SEIPBundle\Entity\Delivery\ProductReportDelivery $productsReportDelivery) {
        $this->productsReportDelivery->removeElement($productsReportDelivery);
    }

    /**
     * 
     * @return type
     */
    public function getProductsReportDelivery() {
        return $this->productsReportDelivery;
    }

    public function __toString() {
        $_toString = "-";
        if ($this->getProductionLine()) {
            $_toString = (string) $this->getProductionLine();
        }
        return $_toString;
    }

    /**
     * 
     * @param \Pequiven\SEIPBundle\Entity\Delivery\ProductGroupDelivery $parent
     * @return \Pequiven\SEIPBundle\Entity\Delivery\ProductGroupDelivery
     */
    public function setParent(\Pequiven\SEIPBundle\Entity\Delivery\ProductGroupDelivery $parent = null) {
        $this->parent = $parent;

        return $this;
    }

    /**
     * 
     * @return type
     */
    public function getParent() {
        return $this->parent;
    }

    function getId() {
        return $this->id;
    }

    function getUsers() {
        return $this->users;
    }

    function getPeriod() {
        return $this->period;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setUsers(\Pequiven\SEIPBundle\Entity\User $users) {
        $this->users = $users;
    }

    function setPeriod(\Pequiven\SEIPBundle\Entity\Period $period) {
        $this->period = $period;
    }

    function getProductionLine() {
        return $this->productionLine;
    }

    function setProductionLine(\Pequiven\SEIPBundle\Entity\CEI\ProductionLine $productionLine) {
        $this->productionLine = $productionLine;
    }

    function getDeliveryPoint() {
        return $this->deliveryPoint;
    }

    function setDeliveryPoint(DeliveryPoint $deliveryPoint) {
        $this->deliveryPoint = $deliveryPoint;
    }

//    public function init(DeliveryPoint $deliveryPointId) {
//        $this->setDeliveryPoint($deliveryPointId);
//        $this->setCompany($deliveryPointId->getCompany());
//        $this->setLocation($deliveryPointId->getLocation());
//        #$this->setReportTemplateDelivery($reportTemplateDelivery);
//        #$this->setCompany($reportTemplateDelivery->getCompany());
//        #$this->setLocation($reportTemplateDelivery->getLocation());
//    }
}
