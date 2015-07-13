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
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Repository\DataLoad\ProductReportRepository")
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
     * Plantilla de planta
     * 
     * @var \Pequiven\SEIPBundle\Entity\DataLoad\PlantReport
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\PlantReport",inversedBy="productsReport")
     * @ORM\JoinColumn(nullable=false)
     */
    private $plantReport;
    
    /**
     * Producto
     * @var \Pequiven\SEIPBundle\Entity\CEI\Product
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\Product",inversedBy="productReports")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;
    
    /**
     * Presupuesto de Materias prima
     * @var \Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial\RawMaterialConsumptionPlanning
     *
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial\RawMaterialConsumptionPlanning",mappedBy="productReport")
     */
    private $rawMaterialConsumptionPlannings;
    
    /**
     * Planificacion de productos
     * @var Production\ProductPlanning
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\ProductPlanning",mappedBy="productReport",cascade={"remove","persist"})
     */
    protected $productPlannings;
    
    /**
     * Detalles del producto de cada mes
     * @var Production\ProductDetailDailyMonth
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\ProductDetailDailyMonth",mappedBy="productReport",cascade={"remove"})
     */
    protected $productDetailDailyMonths;
    
    /**
     * Inventarios
     * @var Inventory\Inventory
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Inventory\Inventory",mappedBy="productReport")
     */
    private $inventorys;
    
    /**
     * Produccion no realizada
     * @var Production\UnrealizedProduction
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProduction",mappedBy="productReport")
     */
    private $unrealizedProductions;
    
    /**
     * Indicador
     * @var \Pequiven\IndicatorBundle\Entity\Indicator
     * @ORM\ManyToOne(targetEntity="Pequiven\IndicatorBundle\Entity\Indicator")
     */
    private $indicator;
    
    private $name = '';

    public function __construct() {
        $this->productPlannings = new \Doctrine\Common\Collections\ArrayCollection();
        $this->productDetailDailyMonths = new \Doctrine\Common\Collections\ArrayCollection();
        $this->rawMaterialConsumptionPlannings = new \Doctrine\Common\Collections\ArrayCollection();
        $this->inventorys = new \Doctrine\Common\Collections\ArrayCollection();
        $this->unrealizedProductions = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set plantReport
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\PlantReport $plantReport
     * @return ProductReport
     */
    public function setPlantReport(\Pequiven\SEIPBundle\Entity\DataLoad\PlantReport $plantReport)
    {
        $this->plantReport = $plantReport;

        return $this;
    }

    /**
     * Get plantReport
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\PlantReport 
     */
    public function getPlantReport()
    {
        return $this->plantReport;
    }

    /**
     * Add rawMaterialConsumptionPlannings
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial\RawMaterialConsumptionPlanning $rawMaterialConsumptionPlannings
     * @return ProductReport
     */
    public function addRawMaterialConsumptionPlanning(\Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial\RawMaterialConsumptionPlanning $rawMaterialConsumptionPlannings)
    {
        $rawMaterialConsumptionPlannings->setProductReport($this);
        $this->rawMaterialConsumptionPlannings->add($rawMaterialConsumptionPlannings);

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
     * Add inventorys
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Inventory\Inventory $inventorys
     * @return ProductReport
     */
    public function addInventory(\Pequiven\SEIPBundle\Entity\DataLoad\Inventory\Inventory $inventorys)
    {
        $inventorys->setProductReport($this);
        $this->inventorys->add($inventorys);

        return $this;
    }

    /**
     * Remove inventorys
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Inventory\Inventory $inventorys
     */
    public function removeInventory(\Pequiven\SEIPBundle\Entity\DataLoad\Inventory\Inventory $inventorys)
    {
        $this->inventorys->removeElement($inventorys);
    }

    /**
     * Get inventorys
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getInventorys()
    {
        return $this->inventorys;
    }
    
    /**
     * Add unrealizedProductions
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProduction $unrealizedProductions
     * @return ProductReport
     */
    public function addUnrealizedProduction(\Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProduction $unrealizedProductions)
    {
        $unrealizedProductions->setProductReport($this);
        $this->unrealizedProductions->add($unrealizedProductions);

        return $this;
    }

    /**
     * Remove unrealizedProductions
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProduction $unrealizedProductions
     */
    public function removeUnrealizedProduction(\Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProduction $unrealizedProductions)
    {
        $this->unrealizedProductions->removeElement($unrealizedProductions);
    }

    /**
     * Get unrealizedProductions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUnrealizedProductions()
    {
        return $this->unrealizedProductions;
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
    
    /**
     * Get Inventories
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getInventorySortByMonth()
    {
        $sorted = array();
        foreach ($this->inventorys as $productDetailDailyMonth) {
            $sorted[$productDetailDailyMonth->getMonth()] = $productDetailDailyMonth;
        }
        ksort($sorted);
        return $sorted;
    }
    
    /**
     * Get unrealizedProductions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUnrealizedProductionsSortByMonth()
    {
        $sorted = array();
        foreach ($this->unrealizedProductions as $productDetailDailyMonth) {
            $sorted[$productDetailDailyMonth->getMonth()] = $productDetailDailyMonth;
        }
        ksort($sorted);
        return $sorted;
    }

    /**
     * Set indicator
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator $indicator
     * @return ProductReport
     */
    public function setIndicator(\Pequiven\IndicatorBundle\Entity\Indicator $indicator = null)
    {
        $this->indicator = $indicator;

        return $this;
    }

    /**
     * Get indicator
     *
     * @return \Pequiven\IndicatorBundle\Entity\Indicator 
     */
    public function getIndicator()
    {
        return $this->indicator;
    }
    
    public function recalculate()
    {
        foreach ($this->rawMaterialConsumptionPlannings as $value) {
            $value->calculate();
        }
        foreach ($this->inventorys as $value) {
            $value->calculate();
        }
        foreach ($this->unrealizedProductions as $value) {
            $value->calculate();
        }
    }
    
    public function getName(){
        $name = '';
        if($this->getProduct() && $this->getPlantReport()){
            $name = $this->getPlantReport()->getPlant()->getName().' - '.$this->getProduct()->getName();
        }
        return $name;
    }
    
    public function __toString() 
    {
        $_toString = "-";
        if($this->getProduct()){
            $_toString = sprintf("%s",(string)$this->getProduct());
        }
        
        return $_toString;
    }
}