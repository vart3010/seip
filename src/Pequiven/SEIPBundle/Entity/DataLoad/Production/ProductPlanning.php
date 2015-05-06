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
     * Dias de paradas
     * @var \Pequiven\SEIPBundle\Entity\CEI\DayStop
     * @ORM\ManyToMany(targetEntity="Pequiven\SEIPBundle\Entity\CEI\DayStop")
     */
    private $daysStops;

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
     * @var \Pequiven\SEIPBundle\Entity\DataLoad\ProductReport
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\ProductReport",inversedBy="productPlannings")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $productReport;
    
    /**
     * Rangos de distribucion
     * @var \Pequiven\SEIPBundle\Entity\DataLoad\Production\Range
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\Range",mappedBy="productPlanning",cascade={"persist"})
     */
    protected $ranges;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->daysStops = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add daysStops
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\DayStop $daysStops
     * @return ProductPlanning
     */
    public function addDaysStop(\Pequiven\SEIPBundle\Entity\CEI\DayStop $daysStops)
    {
        $this->daysStops[] = $daysStops;

        return $this;
    }

    /**
     * Remove daysStops
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\DayStop $daysStops
     */
    public function removeDaysStop(\Pequiven\SEIPBundle\Entity\CEI\DayStop $daysStops)
    {
        $this->daysStops->removeElement($daysStops);
    }

    /**
     * Get daysStops
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDaysStops()
    {
        return $this->daysStops;
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
    
    public function __toString() 
    {
        $_toString = "-";
        if($this->getId() > 0){
            $_toString = $this->getMonthLabel();
        }
        return $_toString;
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

}
