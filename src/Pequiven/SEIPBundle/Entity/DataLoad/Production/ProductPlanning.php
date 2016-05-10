<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com.ve
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Entity\DataLoad\Production;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\SEIPBundle\Model\DataLoad\Production\ProductPlanning as BaseModel;

/**
 * Planificacion de producto
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="seip_report_product_report_product_planning")
 * @ORM\Entity()
 */
class ProductPlanning extends BaseModel
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
     * Mes
     * @var integer
     * @ORM\Column(name="month",type="integer",nullable=false)
     */
    private $month;
    
    /**
     * Tipo (Bruta o Neta)
     * @var integer
     * @ORM\Column(name="type",type="integer",nullable=false)
     */
    private $type;

    /**
     * Total a planificar en el mes
     * @var float
     * @ORM\Column(name="total_month",type="float")
     */
    private $totalMonth;
    
    /**
     * Capacidad de producción diaria
     * @var float
     * @ORM\Column(name="daily_production_capacity",type="float")
     */
    private $dailyProductionCapacity;
    
    /**
     * Porcentaje de produccion bruta que va para la neta
     * @var float
     * @ORM\Column(name="net_production_percentage",type="float")
     */
    private $netProductionPercentage = 0.0;
    
    /**
     * @var \Pequiven\SEIPBundle\Entity\DataLoad\ProductReport
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\ProductReport",inversedBy="productPlannings")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $productReport;
    
    /**
     * Rangos de distribucion
     * @var \Pequiven\SEIPBundle\Entity\DataLoad\Production\Range
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\Range",mappedBy="productPlanning",cascade={"persist","remove"})
     */
    protected $ranges;
    
    /**
     * Periodo.
     * 
     * @var \Pequiven\SEIPBundle\Entity\Period
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Period")
     * @ORM\JoinColumn(nullable=true)
     */
    private $period;

    /**
     * @var \Pequiven\SEIPBundle\Entity\DataLoad\Production\ProductPlanning
     * @ORM\OneToOne(targetEntity="\Pequiven\SEIPBundle\Entity\DataLoad\Production\ProductPlanning")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true)
     */
    private $parent;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ranges = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set month
     *
     * @param integer $month
     * @return ProductPlanning
     */
    public function setMonth($month)
    {
        $this->month = $month;

        return $this;
    }

    /**
     * Get month
     *
     * @return integer 
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * Set totalMonth
     *
     * @param float $totalMonth
     * @return ProductPlanning
     */
    public function setTotalMonth($totalMonth)
    {
        $this->totalMonth = $totalMonth;

        return $this;
    }

    /**
     * Get totalMonth
     *
     * @return float 
     */
    public function getTotalMonth()
    {
        return $this->totalMonth;
    }

    /**
     * Set productReport
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\ProductReport $productReport
     * @return ProductPlanning
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
    
    /**
     * Add ranges
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\Range $ranges
     * @return ProductPlanning
     */
    public function addRange(\Pequiven\SEIPBundle\Entity\DataLoad\Production\Range $ranges)
    {
        $ranges->setProductPlanning($this);
        if(!$this->ranges->contains($ranges)){
            $this->ranges->add($ranges);
        }

        return $this;
    }

    /**
     * Remove ranges
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\Range $ranges
     */
    public function removeRange(\Pequiven\SEIPBundle\Entity\DataLoad\Production\Range $ranges)
    {
        $this->ranges->removeElement($ranges);
    }

    /**
     * Get ranges
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRanges()
    {
        return $this->ranges;
    }
    
    function getDailyProductionCapacity() {
        return $this->dailyProductionCapacity;
    }

    function setDailyProductionCapacity($dailyProductionCapacity) {
        $this->dailyProductionCapacity = $dailyProductionCapacity;
        return $this;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return ProductPlanning
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
        return (int)$this->type;
    }
    
    function getNetProductionPercentage() {
        return $this->netProductionPercentage;
    }

    function setNetProductionPercentage($netProductionPercentage) {
        $this->netProductionPercentage = $netProductionPercentage;
        
        return $this;
    }
    
    public function __toString() 
    {
        $_toString = "-";
        if($this->getId() > 0){
            $_toString = $this->getMonthLabel();
        }
        return $_toString;
    }
    
    public function isValidCapacity()
    {
        return !($this->dailyProductionCapacity > $this->totalMonth);
    }
    
    public function __clone() 
    {
        if($this->id > 0){
            $this->id = null;
            $this->type = null;
            $ranges = $this->ranges;
            $this->ranges = new \Doctrine\Common\Collections\ArrayCollection();
            foreach ($ranges as $range) {
                $this->addRange(clone($range));
            }
        }
    }
    
    /**
     * Set period
     *
     * @param \Pequiven\SEIPBundle\Entity\Period $period
     * @return ProductPlanning
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
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\ProductPlanning $parent
     * @return ProductPlanning
     */
    public function setParent(\Pequiven\SEIPBundle\Entity\DataLoad\Production\ProductPlanning $parent = null) {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\Production\ProductPlanning 
     */
    public function getParent() {
        return $this->parent;
    }
}
