<?php

namespace Pequiven\SEIPBundle\Entity\Delivery;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\MasterBundle\Model\Base\ModelBaseMaster;

/**
 * Reporte de planta
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
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
     * Reporte de plantilla
     * @var ReportTemplateDelivery
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
     * Planta que hace el producto
     * 
     * @var \Pequiven\SEIPBundle\Entity\CEI\Plant
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\Plant",inversedBy="plantReport")
     * @ORM\JoinColumn(nullable=true)
     */
    private $plant;

    /**
     * Productos del reporte
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
     * Production line.
     * 
     * @var \Pequiven\SEIPBundle\Entity\CEI\ProductionLine
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\ProductionLine",inversedBy="productGroupDelivery")
     * @ORM\JoinColumn(nullable=true)
     */
    private $productionLine;

    /**
     * @var \Pequiven\SEIPBundle\Entity\Delivery\ProductReportDelivery
     * @ORM\OneToOne(targetEntity="\Pequiven\SEIPBundle\Entity\Delivery\ProductReportDelivery")
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

    function getReportTemplateDelivery() {
        return $this->reportTemplateDelivery;
    }

    function getCompany() {
        return $this->company;
    }

    function getLocation() {
        return $this->location;
    }

    function getEntity() {
        return $this->entity;
    }

    function getPlant() {
        return $this->plant;
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

    function setReportTemplateDelivery(ReportTemplateDelivery $reportTemplateDelivery) {
        $this->reportTemplateDelivery = $reportTemplateDelivery;
    }

    function setCompany(\Pequiven\SEIPBundle\Entity\CEI\Company $company) {
        $this->company = $company;
    }

    function setLocation(\Pequiven\SEIPBundle\Entity\CEI\Location $location) {
        $this->location = $location;
    }

    function setEntity(\Pequiven\SEIPBundle\Entity\CEI\Entity $entity) {
        $this->entity = $entity;
    }

    function setPlant(\Pequiven\SEIPBundle\Entity\CEI\Plant $plant) {
        $this->plant = $plant;
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

    public function init(\Pequiven\SEIPBundle\Entity\Delivery\ReportTemplateDelivery $reportTemplateDelivery) {
        $this->setReportTemplateDelivery($reportTemplateDelivery);
        $this->setCompany($reportTemplateDelivery->getCompany());
        $this->setLocation($reportTemplateDelivery->getLocation());
    }

}
