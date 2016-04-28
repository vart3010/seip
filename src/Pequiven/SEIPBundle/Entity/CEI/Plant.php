<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Entity\CEI;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\SEIPBundle\Model\BaseModel;

/**
 * Planta
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="seip_cei_Plant")
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Repository\CEI\PlantRepository")
 */
class Plant extends BaseModel {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Entidad a la que pertenece
     * @var Entity
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\Entity")
     */
    protected $entity;

    /**
     * Nombre
     * 
     * @var String 
     * @ORM\Column(name="name",type="string",nullable=false)
     */
    private $name;

    /**
     * Alias corto de la planta
     * @var string
     * @ORM\Column(name="alias",type="string",length=200)
     */
    private $alias;

    /**
     * Capacidad de diseño
     * 
     * @var float
     * @ORM\Column(name="design_capacity",type="float")
     */
    private $designCapacity;

    /**
     * Unidad de medida
     * @var UnitMeasure
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\UnitMeasure")
     */
    protected $unitMeasure;

    /**
     * Productos que produce la planta
     * @var \Pequiven\SEIPBundle\Entity\CEI\Product
     *
     * @ORM\ManyToMany(targetEntity="Pequiven\SEIPBundle\Entity\CEI\Product",inversedBy="plants")
     * @ORM\JoinTable(name="plants_products")
     */
    private $products;

    /**
     * Servicios que consume la planta
     * @var \Pequiven\SEIPBundle\Entity\CEI\Service
     *
     * @ORM\ManyToMany(targetEntity="Pequiven\SEIPBundle\Entity\CEI\Service",inversedBy="plants")
     * @ORM\JoinTable(name="plants_services")
     */
    private $services;

    /**
     * Reporte de Planta
     * @var \Pequiven\SEIPBundle\Entity\DataLoad\PlantReport
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\PlantReport",mappedBy="plant",cascade={"remove"})
     */
    private $plantReport;

    /**
     * 
     * @var \Pequiven\SEIPBundle\Entity\CEI\Plant
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\Plant",inversedBy="childrens",cascade={"persist"})
     */
    private $parent;

    /**
     * 
     * @var \Pequiven\SEIPBundle\Entity\CEI\Plant
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\CEI\Plant",mappedBy="parent",cascade={"persist"})
     */
    private $childrens;

    /**
     * @var boolean
     *
     * @ORM\Column(name="permitGroupProduct", type="boolean")
     */
    private $permitGroupProduct = false;

    /**
     * Constructor
     */
    public function __construct() {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
        $this->childrens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->services = new \Doctrine\Common\Collections\ArrayCollection();
        $this->plantReport = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Plant
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
     * Set designCapacity
     *
     * @param float $designCapacity
     * @return Plant
     */
    public function setDesignCapacity($designCapacity) {
        $this->designCapacity = $designCapacity;

        return $this;
    }

    /**
     * Get designCapacity
     *
     * @return float 
     */
    public function getDesignCapacity() {
        return $this->designCapacity;
    }

    /**
     * Set unitMeasure
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\UnitMeasure $unitMeasure
     * @return Plant
     */
    public function setUnitMeasure(\Pequiven\SEIPBundle\Entity\CEI\UnitMeasure $unitMeasure = null) {
        $this->unitMeasure = $unitMeasure;

        return $this;
    }

    /**
     * Set alias
     *
     * @param string $alias
     * @return Plant
     */
    public function setAlias($alias) {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get alias
     *
     * @return string 
     */
    public function getAlias() {
        return $this->alias;
    }

    /**
     * Get unitMeasure
     *
     * @return \Pequiven\SEIPBundle\Entity\CEI\UnitMeasure 
     */
    public function getUnitMeasure() {
        return $this->unitMeasure;
    }

    /**
     * Add products
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\Product $products
     * @return Plant
     */
    public function addProduct(\Pequiven\SEIPBundle\Entity\CEI\Product $products) {
        $this->products[] = $products;

        return $this;
    }

    /**
     * Remove products
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\Product $products
     */
    public function removeProduct(\Pequiven\SEIPBundle\Entity\CEI\Product $products) {
        $this->products->removeElement($products);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProducts() {
        return $this->products;
    }

    /**
     * Add services
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\Service $services
     * @return Plant
     */
    public function addService(\Pequiven\SEIPBundle\Entity\CEI\Service $services) {
        $this->services[] = $services;

        return $this;
    }

    /**
     * Remove services
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\Service $services
     */
    public function removeService(\Pequiven\SEIPBundle\Entity\CEI\Service $services) {
        $this->services->removeElement($services);
    }

    /**
     * 
     * @param \Pequiven\SEIPBundle\Entity\CEI\Plant $plant
     * @return \Pequiven\SEIPBundle\Entity\CEI\Plant
     */
    public function setParent(Plant $plant = null) {
        $this->parent = $plant;
        return $this;
    }

    /**
     * 
     * @return type
     */
    public function getParent() {
        return $this->parent;
    }

    /**
     * Add Children
     * @param \Pequiven\SEIPBundle\Entity\CEI\Plant $childrens
     * @return \Pequiven\SEIPBundle\Entity\CEI\Plant
     */
    public function addChildren(\Pequiven\SEIPBundle\Entity\CEI\Plant $childrens) {
        $childrens->setParent($this);
        $this->childrens->add($childrens);

        return $this;
    }

    /**
     * Remove children
     * @param \Pequiven\SEIPBundle\Entity\CEI\Plant $childrens
     */
    public function removeChildren(\Pequiven\SEIPBundle\Entity\CEI\Plant $childrens) {
        $this->childrens->removeElement($childrens);
    }

    /**
     * Get childrens
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildrens() {
        return $this->childrens;
    }

    /**
     * 
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\lo$ plantReport
     * @return \Pequiven\SEIPBundle\Entity\CEI\Plant
     */
    public function addPlantReport(\Pequiven\SEIPBundle\Entity\DataLoad\PlantReport $plantReport) {
        $plantReport->setParent($this);
        $this->plantReport->add($plantReport);

        return $this;
    }

    /**
     * 
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\PlantReport $plantReport
     */
    public function removePlantReport(\Pequiven\SEIPBundle\Entity\DataLoad\PlantReport $plantReport) {
        $this->plantReport->removeElement($plantReport);
    }

    /**
     * 
     * @return type
     */
    public function getPlantReport() {
        return $this->plantReport;
    }

    /**
     * Get services
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getServices() {
        return $this->services;
    }

    /**
     * Set entity
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\Entity $entity
     * @return Plant
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

    public function __toString() {
        $_toString = "-";
        if ($this->getAlias() != "") {
            $_toString = $this->getAlias();
        } else {
            $_toString = $this->getName();
        }
        return $_toString;
    }

    function getPermitGroupProduct() {
        return $this->permitGroupProduct;
    }

    function setPermitGroupProduct($permitGroupProduct) {
        $this->permitGroupProduct = $permitGroupProduct;
    }

}
