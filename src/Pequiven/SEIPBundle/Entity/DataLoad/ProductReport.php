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
class ProductReport extends BaseModel {

    /**
     * @var integer
     *
     * @ORM\Column(name="id",length=6, type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nameGroup",type="string",length=255,nullable=true)
     */
    private $nameGroup;

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
     * @ORM\JoinColumn(nullable=true)
     */
    private $product;

    /**
     * factores de convercion
     * @var \Pequiven\SEIPBundle\Entity\CEI\FactorConversionValue

     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\CEI\FactorConversionValue",mappedBy="productReport")
     */
    private $factorConversionValue;

    /**
     * Presupuesto de Materias prima
     * @var \Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial\RawMaterialConsumptionPlanning
     *
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial\RawMaterialConsumptionPlanning",mappedBy="productReport",cascade={"remove"})
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
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Inventory\Inventory",mappedBy="productReport",cascade={"remove"})
     */
    private $inventorys;

    /**
     * Produccion no realizada
     * @var Production\UnrealizedProduction
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProduction",mappedBy="productReport",cascade={"remove"})
     */
    private $unrealizedProductions;

    /**
     * Indicador
     * @var \Pequiven\IndicatorBundle\Entity\Indicator
     * @ORM\ManyToOne(targetEntity="Pequiven\IndicatorBundle\Entity\Indicator")
     */
    private $indicator;

    /**
     * Periodo.
     * 
     * @var \Pequiven\SEIPBundle\Entity\Period
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Period")
     * @ORM\JoinColumn(nullable=true)
     */
    private $period;

    /**
     * @var \Pequiven\SEIPBundle\Entity\DataLoad\ProductReport
     * @ORM\OneToOne(targetEntity="\Pequiven\SEIPBundle\Entity\DataLoad\ProductReport")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true)
     */
    private $parent;

    /**
     * @ORM\ManyToMany(targetEntity="\Pequiven\SEIPBundle\Entity\DataLoad\ProductReport")
     */
    protected $parentGroup;

    /**
     * @ORM\ManyToMany(targetEntity="\Pequiven\SEIPBundle\Entity\DataLoad\ProductReport")
     * @ORM\JoinTable(name="seip_product_report_groups")
     */
    protected $childrensGroup;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isGroup", type="boolean")
     */
    private $isGroup = false;
    private $name = '';
    private $nameComplete = '';

    public function __construct() {
        $this->productPlannings = new \Doctrine\Common\Collections\ArrayCollection();
        $this->productDetailDailyMonths = new \Doctrine\Common\Collections\ArrayCollection();
        $this->rawMaterialConsumptionPlannings = new \Doctrine\Common\Collections\ArrayCollection();
        $this->inventorys = new \Doctrine\Common\Collections\ArrayCollection();
        $this->unrealizedProductions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->childrensGroup = new \Doctrine\Common\Collections\ArrayCollection();
        $this->parentGroup = new \Doctrine\Common\Collections\ArrayCollection();
        $this->factorConversionValue = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * 
     * @param \Pequiven\SEIPBundle\Entity\CEI\FactorConversionValue $factorConversionValue
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\ProductReport
     */
    public function addFactorConversionValue(\Pequiven\SEIPBundle\Entity\CEI\FactorConversionValue $factorConversionValue) {
        $factorConversionValue->setProductReport($this);
        $this->factorConversionValue->add($factorConversionValue);

        return $this;
    }

    /**
     * 
     * @param \Pequiven\SEIPBundle\Entity\CEI\FactorConversionValue $factorConversionValue
     */
    public function removeFactorConversionValue(\Pequiven\SEIPBundle\Entity\CEI\FactorConversionValue $factorConversionValue) {
        $this->factorConversionValue->removeElement($factorConversionValue);
    }

    /**
     * 
     * @return type
     */
    public function getFactorConversionValue() {
        return $this->factorConversionValue;
    }

    /**
     * 
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\ProductReport $childrens
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\ProductReport
     */
    public function addParentGroup(\Pequiven\SEIPBundle\Entity\DataLoad\ProductReport $childrens) {
        $childrens->setParent($this);
        $this->parentGroup->add($childrens);

        return $this;
    }

    /**
     * 
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\ProductReport $childrens
     */
    public function removeParentGroup(\Pequiven\SEIPBundle\Entity\DataLoad\ProductReport $childrens) {
        $this->parentGroup->removeElement($childrens);
    }

    /**
     * 
     * @return type
     */
    public function getParentGroup() {
        return $this->parentGroup;
    }

    /**
     * 
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\ProductReport $childrens
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\ProductReport
     */
    public function addChildrenGroup(\Pequiven\SEIPBundle\Entity\DataLoad\ProductReport $childrens) {
        $childrens->setParent($this);
        $this->childrensGroup->add($childrens);

        return $this;
    }

    /**
     * 
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\ProductReport $childrens
     */
    public function removeChildrenGroup(\Pequiven\SEIPBundle\Entity\DataLoad\ProductReport $childrens) {
        $this->childrensGroup->removeElement($childrens);
    }

    /**
     * 
     * @return type
     */
    public function getChildrensGroup() {
        return $this->childrensGroup;
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
     * Set product
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\Product $product
     * @return ProductReport
     */
    public function setProduct(\Pequiven\SEIPBundle\Entity\CEI\Product $product) {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \Pequiven\SEIPBundle\Entity\CEI\Product 
     */
    public function getProduct() {
        return $this->product;
    }

    /**
     * Add productPlannings
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\ProductPlanning $productPlannings
     * @return ProductReport
     */
    public function addProductPlanning(\Pequiven\SEIPBundle\Entity\DataLoad\Production\ProductPlanning $productPlannings) {
        $productPlannings->setProductReport($this);

        $this->productPlannings[] = $productPlannings;

        return $this;
    }

    /**
     * Remove productPlannings
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\ProductPlanning $productPlannings
     */
    public function removeProductPlanning(\Pequiven\SEIPBundle\Entity\DataLoad\Production\ProductPlanning $productPlannings) {
        $this->productPlannings->removeElement($productPlannings);
    }

    /**
     * Get productPlannings
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProductPlannings() {
        return $this->productPlannings;
    }

    /**
     * Add productDetailDailyMonths
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\ProductDetailDailyMonth $productDetailDailyMonths
     * @return ProductReport
     */
    public function addProductDetailDailyMonth(\Pequiven\SEIPBundle\Entity\DataLoad\Production\ProductDetailDailyMonth $productDetailDailyMonths) {
        $productDetailDailyMonths->setProductReport($this);

        $this->productDetailDailyMonths->add($productDetailDailyMonths);

        return $this;
    }

    /**
     * Remove productDetailDailyMonths
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\ProductDetailDailyMonth $productDetailDailyMonths
     */
    public function removeProductDetailDailyMonth(\Pequiven\SEIPBundle\Entity\DataLoad\Production\ProductDetailDailyMonth $productDetailDailyMonths) {
        $this->productDetailDailyMonths->removeElement($productDetailDailyMonths);
    }

    /**
     * Get productDetailDailyMonths
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProductDetailDailyMonths() {
        return $this->productDetailDailyMonths;
    }

    /**
     * Set plantReport
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\PlantReport $plantReport
     * @return ProductReport
     */
    public function setPlantReport(\Pequiven\SEIPBundle\Entity\DataLoad\PlantReport $plantReport) {
        $this->plantReport = $plantReport;

        return $this;
    }

    /**
     * Get plantReport
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\PlantReport 
     */
    public function getPlantReport() {
        return $this->plantReport;
    }

    /**
     * Add rawMaterialConsumptionPlannings
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial\RawMaterialConsumptionPlanning $rawMaterialConsumptionPlannings
     * @return ProductReport
     */
    public function addRawMaterialConsumptionPlanning(\Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial\RawMaterialConsumptionPlanning $rawMaterialConsumptionPlannings) {
        $rawMaterialConsumptionPlannings->setProductReport($this);
        $this->rawMaterialConsumptionPlannings->add($rawMaterialConsumptionPlannings);

        return $this;
    }

    /**
     * Remove rawMaterialConsumptionPlannings
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial\RawMaterialConsumptionPlanning $rawMaterialConsumptionPlannings
     */
    public function removeRawMaterialConsumptionPlanning(\Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial\RawMaterialConsumptionPlanning $rawMaterialConsumptionPlannings) {
        $this->rawMaterialConsumptionPlannings->removeElement($rawMaterialConsumptionPlannings);
    }

    /**
     * Get rawMaterialConsumptionPlannings
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRawMaterialConsumptionPlannings() {
        return $this->rawMaterialConsumptionPlannings;
    }

    /**
     * Add inventorys
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Inventory\Inventory $inventorys
     * @return ProductReport
     */
    public function addInventory(\Pequiven\SEIPBundle\Entity\DataLoad\Inventory\Inventory $inventorys) {
        $inventorys->setProductReport($this);
        $this->inventorys->add($inventorys);

        return $this;
    }

    /**
     * Remove inventorys
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Inventory\Inventory $inventorys
     */
    public function removeInventory(\Pequiven\SEIPBundle\Entity\DataLoad\Inventory\Inventory $inventorys) {
        $this->inventorys->removeElement($inventorys);
    }

    /**
     * Get inventorys
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getInventorys() {
        return $this->inventorys;
    }

    /**
     * Add unrealizedProductions
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProduction $unrealizedProductions
     * @return ProductReport
     */
    public function addUnrealizedProduction(\Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProduction $unrealizedProductions) {
        $unrealizedProductions->setProductReport($this);
        $this->unrealizedProductions->add($unrealizedProductions);

        return $this;
    }

    /**
     * Remove unrealizedProductions
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProduction $unrealizedProductions
     */
    public function removeUnrealizedProduction(\Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProduction $unrealizedProductions) {
        $this->unrealizedProductions->removeElement($unrealizedProductions);
    }

    /**
     * Get unrealizedProductions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUnrealizedProductions() {
        return $this->unrealizedProductions;
    }

    /**
     * Get productDetailDailyMonths
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProductDetailDailyMonthsSortByMonth() {
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
    public function getInventorySortByMonth() {
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
    public function getUnrealizedProductionsSortByMonth() {
        $sorted = array();
        foreach ($this->unrealizedProductions as $productDetailDailyMonth) {
            $sorted[$productDetailDailyMonth->getMonth()] = $productDetailDailyMonth;
        }
        ksort($sorted);
        return $sorted;
    }

    /**
     * FILTRO POR CAUSA
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUnrealizedProductionsSortByMonthWithOutProduction($failService) {
        $sorted = array();
        foreach ($this->unrealizedProductions as $productDetailDailyMonth) {
            if ($this->getFailsExceptOverProducction($productDetailDailyMonth, $this->unrealizedProductions, $failService)) {
                $sorted[$productDetailDailyMonth->getMonth()] = $productDetailDailyMonth;
            }
        }
        ksort($sorted);
        return $sorted;
    }

    /**
     * Obtiene todas las causas de PNR excepto la de sobre produccion 
     * PARCHE PARA CIERRE DE PRIMER TRIMESTRE DE 2016
     * @param type $productDailyMonth
     */
    public function getFailsExceptOverProducction($productDailyMonths, $unrealizedProductions, $failService) {
        //ID DE SOBRE PRODUCCION
        $idSobreProduction = 11;
        $band = false;

        foreach ($unrealizedProductions as $unrealizedProduction) {
            //var_dump($unrealizedProduction->getId());
            $internalOverProduction = $failService->getFailsCause($unrealizedProduction);
        }
        var_dump($internalOverProduction);
        die();
        
        $overProductionDay = $internalOverProduction["TYPE_FAIL_INTERNAL"]["Sobre Producción"];

        
        for ($i = 1; $i <= 31; $i++) {
            $dayDetails = sprintf('getDay%sDetails', $i);
            //var_dump($productDailyMonths->$dayDetails());
            $unrealizedProductionDay = $productDailyMonths->$dayDetails();
            //var_dump($unrealizedProductionDay->getInternalCauses());

            if ($overProductionDay[$i] != 0) {
                foreach ($unrealizedProductionDay->getInternalCauses() as $internalCauses) {
                    // var_dump($internalCauses->getFail()->getId());
                    if ($internalCauses->getFail()->getId() == $idSobreProduction) {
                        $band = true;
                        break;
                    }
                }
            }
        }
        //   die();


        return $band;
    }

    /**
     * Set indicator
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator $indicator
     * @return ProductReport
     */
    public function setIndicator(\Pequiven\IndicatorBundle\Entity\Indicator $indicator = null) {
        $this->indicator = $indicator;

        return $this;
    }

    /**
     * Get indicator
     *
     * @return \Pequiven\IndicatorBundle\Entity\Indicator 
     */
    public function getIndicator() {
        return $this->indicator;
    }

    public function recalculate() {
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

    public function getName() {
        $name = '';
        if ($this->getProduct() && $this->getPlantReport()) {
            $name = $this->getPlantReport()->getPlant()->getName() . ' - ' . $this->getProduct()->getName();
        }
        $this->name = $name;
        return $this->name;
    }

    public function getNameComplete() {
        $name = '';
        if ($this->getProduct() && $this->getPlantReport()) {
            $name = $this->getPeriod()->getName() . "-" . $this->getPlantReport()->getPlant()->getName() . ' - ' . $this->getProduct()->getName();
        }
        $this->name = $name;
        return $this->name;
    }

    public function __toString() {
        $_toString = "-";
        if ($this->getProduct()) {
            $_toString = sprintf("%s", (string) $this->getProduct());
        }

        return $_toString;
    }

    /**
     * Set period
     *
     * @param \Pequiven\SEIPBundle\Entity\Period $period
     * @return Objetive
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
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\ProductReport $parent
     * @return Indicator
     */
    public function setParent(\Pequiven\SEIPBundle\Entity\DataLoad\ProductReport $parent = null) {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\ProductReport 
     */
    public function getParent() {
        return $this->parent;
    }

    function getIsGroup() {
        return $this->isGroup;
    }

    function setIsGroup($isGroup) {
        $this->isGroup = $isGroup;
    }

    function getNameGroup() {
        return $this->nameGroup;
    }

    function setNameGroup($nameGroup) {
        $this->nameGroup = $nameGroup;
    }

}
