<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com.ve
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Entity\Delivery;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\SEIPBundle\Model\Delivery\ReportTemplateDelivery as BaseModel;

/**
 * Reporte plantilla de ventas
 *
 * @author Victor Tortolero <vart10.30@gmail.com>
 * @ORM\Table(name="seip_delivery_report_template")
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Repository\Delivery\ReportTemplateDeliveryRepository")
 */
class ReportTemplateDelivery extends BaseModel {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Referencia
     * @var string
     * @ORM\Column(name="ref",nullable=true)
     */
    private $ref;

    /**
     * Nombre del reporte
     * @var string
     * @ORM\Column(name="name")
     */
    private $name;

    /**
     * Periodo.
     * @var \Pequiven\SEIPBundle\Entity\Period
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Period")
     * @ORM\JoinColumn(nullable=false)
     */
    private $period;

    /**
     * Empresa.
     * @var \Pequiven\SEIPBundle\Entity\CEI\Company
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\Company")
     * @ORM\JoinColumn(nullable=false)
     */
    private $company;

    /**
     * Localidad.
     * @var \Pequiven\SEIPBundle\Entity\CEI\Location
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\Location")
     * @ORM\JoinColumn(nullable=false)
     */
    private $location;

    /**
     * Region
     * @var \Pequiven\SEIPBundle\Entity\CEI\Region
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\Region")
     * @ORM\JoinColumn(nullable=false)
     */
    private $region;

    /**
     * Plantillas de plantas
     * @var \Pequiven\SEIPBundle\Entity\Delivery\ProductGroupDelivery
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\Delivery\ProductGroupDelivery",mappedBy="reportTemplateDelivery",cascade={"remove"})
     */
    private $productGroupDelivery;

    /**
     * Usuarios
     * @var type 
     * @ORM\ManyToMany(targetEntity="Pequiven\SEIPBundle\Entity\User",mappedBy="reportTemplatesDelivery")
     */
    private $users;

    /**
     * Nombre Corto del reporte
     * @var string
     * @ORM\Column(name="shortName", nullable=true)
     */
    private $shortName;

    /**
     * Ícono del ReportTemplate
     * 
     * @var string
     * 
     * @ORM\Column(name="icon",type="text", nullable=true)
     */
    protected $icon;

    /**
     * @var \Pequiven\SEIPBundle\Entity\DataLoad\ReportTemplate
     * @ORM\OneToOne(targetEntity="\Pequiven\SEIPBundle\Entity\DataLoad\ReportTemplate")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true)
     */
    private $parent;

    /**
     * Constructor
     */
    public function __construct() {
        $this->productGroupDelivery = new \Doctrine\Common\Collections\ArrayCollection();
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * 
     * @param \Pequiven\SEIPBundle\Entity\User $user
     * @return \Pequiven\SEIPBundle\Entity\Delivery\ReportTemplateDelivery
     */
    public function addUser(\Pequiven\SEIPBundle\Entity\User $user) {
        $this->users[] = $user;

        return $this;
    }

    /**
     * 
     * @param \Pequiven\SEIPBundle\Entity\User $user
     */
    public function removeUser(\Pequiven\SEIPBundle\Entity\User $user) {
        $this->users->removeElement($user);
    }

    /**
     * 
     * @return type
     */
    public function getUser() {
        return $this->users;
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
     * Set name
     *
     * @param string $name
     * @return ReportTemplate
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set ref
     *
     * @param string $ref
     * @return ReportTemplate
     */
    public function setRef($ref) {
        $this->ref = $ref;

        return $this;
    }

    /**
     * Get ref
     *
     * @return string 
     */
    public function getRef() {
        return $this->ref;
    }

    /**
     * Set period
     *
     * @param \Pequiven\SEIPBundle\Entity\Period $period
     * @return ReportTemplate
     */
    public function setPeriod(\Pequiven\SEIPBundle\Entity\Period $period) {
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
     * Set company
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\Company $company
     * @return ReportTemplate
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
     * @return ReportTemplate
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
     * Set region
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\Region $region
     * @return ReportTemplate
     */
    public function setRegion(\Pequiven\SEIPBundle\Entity\CEI\Region $region) {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return \Pequiven\SEIPBundle\Entity\CEI\Region 
     */
    public function getRegion() {
        return $this->region;
    }

    /**
     * 
     * @param \Pequiven\SEIPBundle\Entity\Delivery\ProductGroupDelivery $productGroupDelivery
     * @return \Pequiven\SEIPBundle\Entity\Delivery\ReportTemplateDelivery
     */
    public function addProductGroupDeliveryDelivery(ProductGroupDelivery $productGroupDelivery) {
        $this->productGroupDelivery[] = $productGroupDelivery;

        return $this;
    }

    /**
     * 
     * @param \Pequiven\SEIPBundle\Entity\Delivery\ProductGroupDelivery $productReportDelivery
     */
    public function removeProductGroupDelivery(ProductGroupDelivery $productReportDelivery) {
        $this->productGroupDelivery->removeElement($productReportDelivery);
    }

    /**
     * 
     * @return type
     */
    public function getProductGroupDelivery() {
        return $this->productGroupDelivery;
    }

    public function getReportTemplateWithName() {
        $full = sprintf("%s (%s)", $this->getName(), $this->getRef());
        return $full;
    }

    public function __toString() {
       return $this->getRef() ? : "-"; 
    }

    public function recalculate() {
        foreach ($this->plantReports as $plantReport) {
            $plantReport->recalculate();
        }
    }

    function getShortName() {
        return $this->shortName;
    }

    function setShortName($shortName) {
        $this->shortName = $shortName;
    }

    /**
     * 
     * @return type
     */
    public function getIcon() {
        return $this->icon;
    }

    /**
     * 
     * @param type $icon
     */
    public function setIcon($icon) {
        $this->icon = $icon;
    }

    /**
     * Set parent
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\ReportTemplate $parent
     * @return Indicator
     */
    public function setParent(\Pequiven\SEIPBundle\Entity\DataLoad\ReportTemplate $parent = null) {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\ReportTemplate 
     */
    public function getParent() {
        return $this->parent;
    }

}
