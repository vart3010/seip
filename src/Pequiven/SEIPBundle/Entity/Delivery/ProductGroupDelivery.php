<?php

namespace Pequiven\SEIPBundle\Entity\Delivery;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\MasterBundle\Model\Base\ModelBaseMaster;

/**
 * Reporte de planta
 *
 * @author 
 * @ORM\Table(name="seip_delivery_product_group")
 * @ORM\Entity()
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
     * Reporte de plantilla
     * @var ReportTemplate
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Delivery\ReportTemplateDelivery",inversedBy="productGroupDelivery")
     * @ORM\JoinColumn(nullable=false)
     */
    private $reportTemplateDelivery;

    /**
     * Empresa
     * @var \Pequiven\SEIPBundle\Entity\CEI\Company
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\Company")
     * @ORM\JoinColumn(nullable=false)
     */
    private $company;

    /**
     * Localizacion (complejo).
     * @var \Pequiven\SEIPBundle\Entity\CEI\Location
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\Location")
     * @ORM\JoinColumn(nullable=false)
     */
    private $location;

    /**
     * Entidad donde esta el producto
     * 
     * @var \Pequiven\SEIPBundle\Entity\CEI\Entity
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\Entity")
     */
    private $entity;

    
    /**
     * linea de produccion 
     * 
     * @var \Pequiven\SEIPBundle\Entity\CEI\ProductionLine
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\ProductionLine",inversedBy="productGroupDelivery")
     * @ORM\JoinColumn(nullable=false)
     */
    private $productionLine;

    /**
     * Productos del reporte de ventas
     * @var \Pequiven\SEIPBundle\Entity\Delivery\ProductReportDelivery
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\Delivery\ProductReportDelivery",mappedBy="productGroupDelivery",cascade={"remove"})
     */
    private $productsReportDelivery;

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
     * @var \Pequiven\SEIPBundle\Entity\Delivery\ProductGroupDelivery
     * @ORM\OneToOne(targetEntity="\Pequiven\SEIPBundle\Entity\Delivery\ProductGroupDelivery")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true)
     */
    private $parent;
    
    

    /**
     * Constructor
     */
    public function __construct() {
        $this->productsReportDelivery = new \Doctrine\Common\Collections\ArrayCollection();

        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function addProductsReportDelivery(\Pequiven\SEIPBundle\Entity\Delivery\ProductReportDelivery $productsReportDelivery) {
        $this->productsReportDelivery[] = $productsReportDelivery;

        return $this;
    }

    /**
     * Remove productsReport
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\ProductReport $productsReport
     */
    public function removeProductsReportDelivery(\Pequiven\SEIPBundle\Entity\Delivery\ProductReportDelivery $productsReportDelivery) {
        $this->productsReportDelivery->removeElement($productsReportDelivery);
    }

    /**
     * Get productsReport
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProductsReportDelivery() {
        return $this->productsReportDelivery;
    }
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set reportTemplate
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\ReportTemplate $reportTemplate
     * @return PlantReport
     */
    public function setReportTemplate(\Pequiven\SEIPBundle\Entity\DataLoad\ReportTemplate $reportTemplate) {
        $this->reportTemplate = $reportTemplate;

        return $this;
    }

    /**
     * Get reportTemplate
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\ReportTemplate 
     */
    public function getReportTemplate() {
        return $this->reportTemplate;
    }

    /**
     * Add productsReport
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\ProductReport $productsReport
     * @return PlantReport
     */
//    public function addProductsReport(\Pequiven\SEIPBundle\Entity\DataLoad\ProductReport $productsReport) {
//        $this->productsReport[] = $productsReport;
//
//        return $this;
//    }

    /**
     * Remove productsReport
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\ProductReport $productsReport
     */
//    public function removeProductsReport(\Pequiven\SEIPBundle\Entity\DataLoad\ProductReport $productsReport) {
//        $this->productsReport->removeElement($productsReport);
//    }

    /**
     * Get productsReport
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
//    public function getProductsReport() {
//        return $this->productsReport;
//    }

    /**
     * Set company
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\Company $company
     * @return PlantReport
     */
    public function setCompany(\Pequiven\SEIPBundle\Entity\CEI\Company $company) {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return \Pequiven\SEIPBundle\Entity\CEI\Company 
     */
    public function getCompany() {
        return $this->company;
    }

    /**
     * Set location
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\Location $location
     * @return PlantReport
     */
    public function setLocation(\Pequiven\SEIPBundle\Entity\CEI\Location $location) {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return \Pequiven\SEIPBundle\Entity\CEI\Location 
     */
    public function getLocation() {
        return $this->location;
    }

    /**
     * Set entity
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\Entity $entity
     * @return PlantReport
     */
    public function setEntity(\Pequiven\SEIPBundle\Entity\CEI\Entity $entity = null) {
        $this->entity = $entity;

        return $this;
    }

    /**
     * Get entity
     *
     * @return \Pequiven\SEIPBundle\Entity\CEI\Entity 
     */
    public function getEntity() {
        return $this->entity;
    }

    function getProductionLine() {
        return $this->productionLine;
    }

    function setProductionLine(\Pequiven\SEIPBundle\Entity\CEI\Plant $productionLine) {
        $this->productionLine = $productionLine;
    }

    
    public function __toString() {
        $_toString = "-";
        if ($this->getProductionLine()) {
            $_toString = (string) $this->getProductionLine();
        }
        return $_toString;
    }

    public function getReportTemplateWithName() {
        $full = sprintf("%s (%s)", $this->reportTemplate->getName(), $this->reportTemplate->getRef());
        return $full;
    }

    /**
     * Set period
     *
     * @param \Pequiven\SEIPBundle\Entity\Period $period
     * @return PlantReport
     */
    public function setPeriod(\Pequiven\SEIPBundle\Entity\Period $period = null) {
        $this->period = $period;

        return $this;
    }

    /**
     * Get period
     *
     * @return \Pequiven\SEIPBundle\Entity\Period 
     */
    public function getPeriod() {
        return $this->period;
    }

    /**
     * Set parent
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\PlantReport $parent
     * @return Indicator
     */
    public function setParent(\Pequiven\SEIPBundle\Entity\DataLoad\PlantReport $parent = null) {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\PlantReport 
     */
    public function getParent() {
        return $this->parent;
    }
    
    function getReportTemplateDelivery() {
        return $this->reportTemplateDelivery;
    }

   
    function setReportTemplateDelivery(ReportTemplate $reportTemplateDelivery) {
        $this->reportTemplateDelivery = $reportTemplateDelivery;
    }

    


}
