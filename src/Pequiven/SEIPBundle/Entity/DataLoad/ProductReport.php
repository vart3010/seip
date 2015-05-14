<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com.ve
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Entity\DataLoad;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\SEIPBundle\Model\DataLoad\ProductReport as BaseModel;

/**
 * Producto de reporte
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="seip_report_product_report")
 * @ORM\Entity()
 */
class ProductReport extends BaseModel
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * Producto
     * @var \Pequiven\SEIPBundle\Entity\CEI\Product
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\Product")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;
    
    /**
     * Linea de negocio (Linea de producto)
     * 
     * @var ProductionLine
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\ProductionLine")
     */
    private $productionLine;

    /**
     * ¿Es materia prima?
     * @var boolean
     * @ORM\Column(name="is_raw_material",type="boolean")
     */
    private $isRawMaterial = false;
    
    /**
     * Unidad del producto
     * @var \Pequiven\SEIPBundle\Entity\CEI\UnitMeasure
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\UnitMeasure")
     */
    private $productUnit;
    
    /**
     * Plantilla de reporte
     * 
     * @var \Pequiven\SEIPBundle\Entity\DataLoad\ReportTemplate
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\ReportTemplate",inversedBy="productsReport")
     * @ORM\JoinColumn(nullable=false)
     */
    private $reportTemplate;
    
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
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\Plant")
     */
    private $plant;
    
    /**
     * Presupuesto de Materias prima
     * @var \Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial\RawMaterialConsumptionPlanning
     *
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial\RawMaterialConsumptionPlanning",mappedBy="productReport")
     */
    private $rawMaterialConsumptionPlannings;
    
    /**
     * Tipo de producto
     * @deprecated since version number
     * @var integer
     * @ORM\Column(name="type_product",type="integer",nullable=true)
     */
    private $typeProduct;
    
    /**
     * Planificacion de productos
     * @var Production\ProductPlanning
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\ProductPlanning",mappedBy="productReport",cascade={"remove"})
     */
    protected $productPlannings;
    
    /**
     * Detalles del producto de cada mes
     * @var Production\ProductDetailDailyMonth
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\ProductDetailDailyMonth",mappedBy="productReport",cascade={"remove"})
     */
    protected $productDetailDailyMonths;

    public function __construct() {
        $this->productPlannings = new \Doctrine\Common\Collections\ArrayCollection();
        $this->productDetailDailyMonths = new \Doctrine\Common\Collections\ArrayCollection();
        $this->rawMaterialConsumptionPlannings = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set isRawMaterial
     *
     * @param boolean $isRawMaterial
     * @return ProductReport
     */
    public function setIsRawMaterial($isRawMaterial)
    {
        $this->isRawMaterial = $isRawMaterial;

        return $this;
    }

    /**
     * Get isRawMaterial
     *
     * @return boolean 
     */
    public function getIsRawMaterial()
    {
        return $this->isRawMaterial;
    }
    
    /**
     * Set product
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\Product $product
     * @return ProductReport
     */
    public function setProduct(\Pequiven\SEIPBundle\Entity\CEI\Product $product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \Pequiven\SEIPBundle\Entity\CEI\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set productionLine
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\ProductionLine $productionLine
     * @return ProductReport
     */
    public function setProductionLine(\Pequiven\SEIPBundle\Entity\CEI\ProductionLine $productionLine = null)
    {
        $this->productionLine = $productionLine;

        return $this;
    }

    /**
     * Get productionLine
     *
     * @return \Pequiven\SEIPBundle\Entity\CEI\ProductionLine 
     */
    public function getProductionLine()
    {
        return $this->productionLine;
    }

    /**
     * Set plant
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\Plant $plant
     * @return ProductReport
     */
    public function setPlant(\Pequiven\SEIPBundle\Entity\CEI\Plant $plant = null)
    {
        $this->plant = $plant;

        return $this;
    }

    /**
     * Get plant
     *
     * @return \Pequiven\SEIPBundle\Entity\CEI\Plant 
     */
    public function getPlant()
    {
        return $this->plant;
    }

    /**
     * Set reportTemplate
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\ReportTemplate $reportTemplate
     * @return ProductReport
     */
    public function setReportTemplate(\Pequiven\SEIPBundle\Entity\DataLoad\ReportTemplate $reportTemplate)
    {
        $this->reportTemplate = $reportTemplate;

        return $this;
    }

    /**
     * Get reportTemplate
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\ReportTemplate 
     */
    public function getReportTemplate()
    {
        return $this->reportTemplate;
    }
    
    /**
     * Set typeProduct
     *
     * @param integer $typeProduct
     * @return ProductReport
     */
    public function setTypeProduct($typeProduct)
    {
        $this->typeProduct = $typeProduct;

        return $this;
    }

    /**
     * Get typeProduct
     *
     * @return integer 
     */
    public function getTypeProduct()
    {
        return $this->typeProduct;
    }

    /**
     * Set company
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\Company $company
     * @return ProductReport
     */
    public function setCompany(\Pequiven\SEIPBundle\Entity\CEI\Company $company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return \Pequiven\SEIPBundle\Entity\CEI\Company 
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set location
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\Location $location
     * @return ProductReport
     */
    public function setLocation(\Pequiven\SEIPBundle\Entity\CEI\Location $location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return \Pequiven\SEIPBundle\Entity\CEI\Location 
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Add productPlannings
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\ProductPlanning $productPlannings
     * @return ProductReport
     */
    public function addProductPlanning(\Pequiven\SEIPBundle\Entity\DataLoad\Production\ProductPlanning $productPlannings)
    {
        $productPlannings->setProductReport($this);
        
        $this->productPlannings[] = $productPlannings;

        return $this;
    }

    /**
     * Remove productPlannings
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\ProductPlanning $productPlannings
     */
    public function removeProductPlanning(\Pequiven\SEIPBundle\Entity\DataLoad\Production\ProductPlanning $productPlannings)
    {
        $this->productPlannings->removeElement($productPlannings);
    }

    /**
     * Get productPlannings
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProductPlannings()
    {
        return $this->productPlannings;
    }
    
    /**
     * Add productDetailDailyMonths
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\ProductDetailDailyMonth $productDetailDailyMonths
     * @return ProductReport
     */
    public function addProductDetailDailyMonth(\Pequiven\SEIPBundle\Entity\DataLoad\Production\ProductDetailDailyMonth $productDetailDailyMonths)
    {
        $productDetailDailyMonths->setProductReport($this);
        
        $this->productDetailDailyMonths->add($productDetailDailyMonths);

        return $this;
    }

    /**
     * Remove productDetailDailyMonths
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\ProductDetailDailyMonth $productDetailDailyMonths
     */
    public function removeProductDetailDailyMonth(\Pequiven\SEIPBundle\Entity\DataLoad\Production\ProductDetailDailyMonth $productDetailDailyMonths)
    {
        $this->productDetailDailyMonths->removeElement($productDetailDailyMonths);
    }

    /**
     * Get productDetailDailyMonths
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProductDetailDailyMonths()
    {
        return $this->productDetailDailyMonths;
    }
    
    /**
     * Get productDetailDailyMonths
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProductDetailDailyMonthsSortByMonth()
    {
        $sorted = array();
        foreach ($this->productDetailDailyMonths as $productDetailDailyMonth) {
            $sorted[$productDetailDailyMonth->getMonth()] = $productDetailDailyMonth;
        }
        ksort($sorted);
        return $sorted;
    }
    
    function getProductUnit() {
        return $this->productUnit;
    }

    function setProductUnit(\Pequiven\SEIPBundle\Entity\CEI\UnitMeasure $productUnit) {
        $this->productUnit = $productUnit;
        return $this;
    }
        
    /**
     * Add rawMaterialConsumptionPlannings
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial\RawMaterialConsumptionPlanning $rawMaterialConsumptionPlannings
     * @return ProductReport
     */
    public function addRawMaterialConsumptionPlanning(\Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial\RawMaterialConsumptionPlanning $rawMaterialConsumptionPlannings)
    {
        $this->rawMaterialConsumptionPlannings[] = $rawMaterialConsumptionPlannings;

        return $this;
    }

    /**
     * Remove rawMaterialConsumptionPlannings
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial\RawMaterialConsumptionPlanning $rawMaterialConsumptionPlannings
     */
    public function removeRawMaterialConsumptionPlanning(\Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial\RawMaterialConsumptionPlanning $rawMaterialConsumptionPlannings)
    {
        $this->rawMaterialConsumptionPlannings->removeElement($rawMaterialConsumptionPlannings);
    }

    /**
     * Get rawMaterialConsumptionPlannings
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRawMaterialConsumptionPlannings()
    {
        return $this->rawMaterialConsumptionPlannings;
    }
    
    /**
     * Set entity
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\Entity $entity
     * @return ProductReport
     */
    public function setEntity(\Pequiven\SEIPBundle\Entity\CEI\Entity $entity = null)
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * Get entity
     *
     * @return \Pequiven\SEIPBundle\Entity\CEI\Entity 
     */
    public function getEntity()
    {
        return $this->entity;
    }
    
    public function __toString() 
    {
        $_toString = "-";
        if($this->getProduct()){
            $_toString = sprintf("%s (%s)",(string) $this->getReportTemplate(),(string)$this->getProduct());
        }
        return $_toString;
    }
}