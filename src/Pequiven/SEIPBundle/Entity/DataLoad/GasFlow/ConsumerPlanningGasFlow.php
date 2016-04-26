<?php

namespace Pequiven\SEIPBundle\Entity\DataLoad\GasFlow;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\SEIPBundle\Model\BaseModel;

/**
 * Plan de consumo de flujo de gas
 *
 * @author Matias Jimenez <matei249@gmail.com>
 * @ORM\Table(name="seip_report_plant_gas_flow_planning")
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Repository\DataLoad\PlantReportRepository")
 */
class ConsumerPlanningGasFlow extends BaseModel
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
     * Reporte de planta
     * @var \Pequiven\SEIPBundle\Entity\DataLoad\PlantReport
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\PlantReport",inversedBy="consumerPlanningGasFlow")
     * @ORM\JoinColumn(nullable=false)
     */
    private $plantReport;

    /**
     * Detalles
     * @var DetailConsumerPlanningGasFlow
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\GasFlow\DetailConsumerPlanningGasFlow",mappedBy="consumerPlanningGasFlow",cascade={"persist","remove"})
     */
    private $detailConsumerPlanningGasFlow;
    
    /**
     * @var \Pequiven\SEIPBundle\Entity\DataLoad\GasFlow\ConsumerPlanningGasFlow
     * @ORM\OneToOne(targetEntity="\Pequiven\SEIPBundle\Entity\DataLoad\GasFlow\ConsumerPlanningGasFlow")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true)
     */
    private $parent;
    
    /**
     * Periodo.
     * 
     * @var \Pequiven\SEIPBundle\Entity\Period
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Period")
     * @ORM\JoinColumn(nullable=true)
     */
    private $period;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->detailConsumerPlanningGasFlow = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set plantReport
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\PlantReport $plantReport
     * @return ConsumerPlanningGasFlow
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
     * Add detailConsumerPlanningGasFlow
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\GasFlow\DetailConsumerPlanningGasFlow $detailConsumerPlanningGasFlow
     * @return ConsumerPlanningGasFlow
     */
    public function addDetailConsumerPlanningGasFlow(\Pequiven\SEIPBundle\Entity\DataLoad\GasFlow\DetailConsumerPlanningGasFlow $detailConsumerPlanningGasFlow)
    {
        $detailConsumerPlanningGasFlow->setConsumerPlanningGasFlow($this);
        $this->detailConsumerPlanningGasFlow->add($detailConsumerPlanningGasFlow);

        return $this;
    }

    /**
     * Remove detailConsumerPlanningGasFlow
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\GasFlow\DetailConsumerPlanningGasFlow $detailConsumerPlanningGasFlow
     */
    public function removeDetailConsumerPlanningGasFlow(\Pequiven\SEIPBundle\Entity\DataLoad\GasFlow\DetailConsumerPlanningGasFlow $detailConsumerPlanningGasFlow)
    {
        $this->detailConsumerPlanningGasFlow->removeElement($detailConsumerPlanningGasFlow);
    }

    /**
     * Get detailConsumerPlanningGasFlow
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDetailConsumerPlanningGasFlow()
    {
        return $this->detailConsumerPlanningGasFlow;
    }
    
    public function getDetails()
    {
        return $this->detailConsumerPlanningGasFlow;
    }
    
    /**
     * 
     * @return DetailConsumerPlanningGasFlow
     */
    public function getDetailsByMonth() 
    {
        $details = array();
        foreach ($this->getDetails() as $detail) {
            $details[$detail->getMonth()] = $detail;
        }
        ksort($details);
        return $details;
    }
    
    function getAliquot() {
        return $this->aliquot;
    }

    function setAliquot($aliquot) {
        $this->aliquot = $aliquot;
    }
        
    public function __toString() {
        $_toString = "Flujo de Gas";

        return $_toString;
    }
    
    function getTotalToDay()
    {
        $now = new \DateTime();
        $month = (int)$now->format("m");
        $day = (int)$now->format("d");
        
        $details = $this->getDetailsByMonth();
        $totalPlan = $totalReal = $totalPlanBefore = $totalRealBefore = 0.0;
        foreach ($details as $monthDetail => $detail) {
                if($monthDetail > $month){
                    break;
                }

                if($month == $monthDetail){
                    $totalToDay = $detail->getTotalToDay($day);
                    $totalPlan = $totalPlan + $totalToDay['tp'];
                    $totalReal = $totalReal + $totalToDay['tr'];
                }else{
                    $totalPlan = $totalPlan + $detail->getTotalPlan();
                    $totalReal = $totalReal + $detail->getTotalReal();
                    
                    $totalPlanBefore = $totalPlan;
                    $totalRealBefore = $totalReal;
                }
        }
        $percentage = $percentageBefore = 0;
        if($totalPlan > 0){
            $percentage = ($totalReal * 100) / $totalPlan;
        }
        if($totalPlanBefore > 0){
            $percentageBefore = ($totalRealBefore * 100) / $totalPlanBefore;
        }
        $total = array(
            'tp' => $totalPlan,
            'tr' => $totalReal,
            'percentage' => $percentage,
            
            'tp_b' => $totalPlanBefore,
            'tr_b' => $totalRealBefore,
            'percentage_b' => $percentageBefore,
        );
        return $total;
    }
    
    /**
     * Retorna el resumen
     * @param \DateTime $date
     * @return type
     */
    public function getSummary(\DateTime $date)
    {
        $month = (int)$date->format("m");
        $day = (int)$date->format("d");
        
        $totalDay = $totalMonth = $totalYear = $totalDayPlan = $totalMonthPlan = $totalYearPlan = 0.0;
        $details = $this->getDetailsByMonth();
        foreach ($details as $monthDetail => $detail) {
                $totalYear = $totalYear + $detail->getTotalReal();
                $totalYearPlan = $totalYearPlan + $detail->getTotalPlan();
                
                if($monthDetail > $month){
                    break;
                }

                if($month == $monthDetail){
                    $totalDayName = 'getDay'.$day.'Real';
                    $totalDayPlanName = 'getDay'.$day.'Plan';
                    
                    $totalDay = $detail->$totalDayName();
                    $totalDayPlan = $detail->$totalDayPlanName();
                    
                    $totalMonth = $totalMonth + $detail->getTotalReal();
                    $totalMonthPlan = $totalMonthPlan + $detail->getTotalPlan();
                }
        }
        
        $total = array(
            'total_day' => $totalDay,
            'total_month' => $totalMonth,
            'total_year' => $totalYear,
            
            'total_day_plan' => $totalDayPlan,
            'total_month_plan' => $totalMonthPlan,
            'total_year_plan' => $totalYearPlan,
        );
        return $total;
    }
    
    /**
     * Set parent
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\GasFlow\ConsumerPlanningGasFlow $parent
     * @return ConsumerPlanningGasFlow
     */
    public function setParent(\Pequiven\SEIPBundle\Entity\DataLoad\GasFlow\ConsumerPlanningGasFlow $parent = null) {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\GasFlow\ConsumerPlanningGasFlow 
     */
    public function getParent() {
        return $this->parent;
    }
    
    /**
     * Set period
     *
     * @param \Pequiven\SEIPBundle\Entity\Period $period
     * @return ConsumerPlanningGasFlow
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

}
