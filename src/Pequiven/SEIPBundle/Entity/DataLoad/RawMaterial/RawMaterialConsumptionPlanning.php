<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com.ve
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\SEIPBundle\Model\DataLoad\RawMaterial\RawMaterialConsumptionPlanning as BaseModel;

/**
 * Presupuesto de consumo de materia prima
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="seip_report_product_raw_material_consumption_planning")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class RawMaterialConsumptionPlanning extends BaseModel
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
     * 
     * @var \Pequiven\SEIPBundle\Entity\CEI\Product
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\Product")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;
    
    /**
     * Tipo de materia prima
     * 
     * @var integer
     * @ORM\Column(name="type",type="integer")
     */
    private $type;
    
    /**
     * Presupuesto de Materias prima
     * @var \Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial\DetailRawMaterialConsumption
     *
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial\DetailRawMaterialConsumption",mappedBy="rawMaterialConsumptionPlanning",cascade={"remove","persist"})
     */
    private $detailRawMaterialConsumptions;
    
    /**
     * Reporte Producto
     * 
     * @var \Pequiven\SEIPBundle\Entity\DataLoad\ProductReport
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\ProductReport",inversedBy="rawMaterialConsumptionPlannings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $productReport;
    
    /**
     * Total plan (Bruta)
     * @var float
     * @ORM\Column(name="totalPlan",type="float")
     */
    private $totalPlan = 0;
    
    /**
     * Total real (Bruta)
     * @var float
     * @ORM\Column(name="totalReal",type="float")
     */
    private $totalReal = 0;
    
    /**
     * Porcentaje de cumplimiento (Bruta)
     * @var float
     * @ORM\Column(name="percentage",type="float")
     */
    private $percentage = 0;
    
    /**
     * Alicuota de lo que se necesita para una tonelada
     * @var float
     * @ORM\Column(name="aliquot",type="float")
     */
    private $aliquot = 0;
    
    /**
     * ¿Cálculo de plan automático?
     * @var boolean 
     * @ORM\Column(name="automaticCalculationPlan",type="boolean")
     */
    private $automaticCalculationPlan = true;

    /**
     * Periodo.
     * 
     * @var \Pequiven\SEIPBundle\Entity\Period
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Period")
     * @ORM\JoinColumn(nullable=true)
     */
    private $period;
    
    /**
     * @var \Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial\RawMaterialConsumptionPlanning
     * @ORM\OneToOne(targetEntity="\Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial\RawMaterialConsumptionPlanning")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true)
     */
    private $parent;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->detailRawMaterialConsumptions = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set type
     *
     * @param integer $type
     * @return RawMaterialConsumptionPlanning
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set totalPlan
     *
     * @param float $totalPlan
     * @return RawMaterialConsumptionPlanning
     */
    public function setTotalPlan($totalPlan)
    {
        $this->totalPlan = $totalPlan;

        return $this;
    }

    /**
     * Get totalPlan
     *
     * @return float 
     */
    public function getTotalPlan()
    {
        return $this->totalPlan;
    }

    /**
     * Set totalReal
     *
     * @param float $totalReal
     * @return RawMaterialConsumptionPlanning
     */
    public function setTotalReal($totalReal)
    {
        $this->totalReal = $totalReal;

        return $this;
    }

    /**
     * Get totalReal
     *
     * @return float 
     */
    public function getTotalReal()
    {
        return $this->totalReal;
    }

    /**
     * Set percentage
     *
     * @param float $percentage
     * @return RawMaterialConsumptionPlanning
     */
    public function setPercentage($percentage)
    {
        $this->percentage = $percentage;

        return $this;
    }

    /**
     * Get percentage
     *
     * @return float 
     */
    public function getPercentage()
    {
        return $this->percentage;
    }

    /**
     * Set product
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\Product $product
     * @return RawMaterialConsumptionPlanning
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
     * Add detailRawMaterialConsumptions
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial\DetailRawMaterialConsumption $detailRawMaterialConsumptions
     * @return RawMaterialConsumptionPlanning
     */
    public function addDetailRawMaterialConsumption(\Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial\DetailRawMaterialConsumption $detailRawMaterialConsumptions)
    {
        $detailRawMaterialConsumptions->setRawMaterialConsumptionPlanning($this);
        
        $this->detailRawMaterialConsumptions->add($detailRawMaterialConsumptions);

        return $this;
    }

    /**
     * Remove detailRawMaterialConsumptions
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial\DetailRawMaterialConsumption $detailRawMaterialConsumptions
     */
    public function removeDetailRawMaterialConsumption(\Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial\DetailRawMaterialConsumption $detailRawMaterialConsumptions)
    {
        $this->detailRawMaterialConsumptions->removeElement($detailRawMaterialConsumptions);
    }

    /**
     * Get detailRawMaterialConsumptions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDetailRawMaterialConsumptions()
    {
        return $this->detailRawMaterialConsumptions;
    }

    /**
     * Set productReport
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\ProductReport $productReport
     * @return RawMaterialConsumptionPlanning
     */
    public function setProductReport(\Pequiven\SEIPBundle\Entity\DataLoad\ProductReport $productReport)
    {
        $this->productReport = $productReport;

        return $this;
    }

    /**
     * Get productReport
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\ProductReport 
     */
    public function getProductReport()
    {
        return $this->productReport;
    }
    
    function getAutomaticCalculationPlan() {
        return $this->automaticCalculationPlan;
    }
    function isAutomaticCalculationPlan() {
        return $this->automaticCalculationPlan;
    }

    function setAutomaticCalculationPlan($automaticCalculationPlan) {
        $this->automaticCalculationPlan = $automaticCalculationPlan;
        
        return $this;
    }
    
    function getAliquot() {
        return $this->aliquot;
    }

    function setAliquot($aliquot) 
    {
        $this->aliquot = $aliquot;
        
        return $this;
    }

        
    public function __toString() {
        $_toString = "-";
        if($this->getProduct()){
            $_toString = (string)$this->getProduct();
        }
        return $_toString;
    }
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function calculate()
    {
        $detailRawMaterialConsumptions = $this->getDetailRawMaterialConsumptions();
        $totalPlan = $totalReal = 0.0;
        foreach ($detailRawMaterialConsumptions as $detailRawMaterialConsumption) 
        {
            $detailRawMaterialConsumption->totalize();
            $totalPlan += $detailRawMaterialConsumption->getTotalPlan();
            $totalReal += $detailRawMaterialConsumption->getTotalReal();
        }
        if($totalPlan > 0){
            $percentage = ($totalReal * 100) / $totalPlan;
        }else{
            $percentage = 0;
        }
        
        $this->setTotalPlan($totalPlan);
        $this->setTotalReal($totalReal);
        $this->setPercentage($percentage);
    }

    /**
     * Set period
     *
     * @param \Pequiven\SEIPBundle\Entity\Period $period
     * @return Objetive
     */
    public function setPeriod(\Pequiven\SEIPBundle\Entity\Period $period = null)
    {
        $this->period = $period;

        return $this;
    }

    /**
     * Get period
     *
     * @return \Pequiven\SEIPBundle\Entity\Period 
     */
    public function getPeriod()
    {
        return $this->period;
    }
    
    /**
     * Set parent
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial\RawMaterialConsumptionPlanning $parent
     * @return RawMaterialConsumptionPlanning
     */
    public function setParent(\Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial\RawMaterialConsumptionPlanning $parent = null) {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial\RawMaterialConsumptionPlanning 
     */
    public function getParent() {
        return $this->parent;
    }
}
