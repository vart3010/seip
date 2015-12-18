<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com.ve
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Entity\DataLoad\Service;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\SEIPBundle\Model\BaseModel;

/**
 * Plan de consumo de servicios
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="seip_report_plant_service_planning")
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Repository\DataLoad\PlantReportRepository")
 */
class ConsumerPlanningService extends BaseModel
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
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\PlantReport",inversedBy="consumerPlanningServices")
     * @ORM\JoinColumn(nullable=false)
     */
    private $plantReport;
    
    /**
     * Servicio
     * @var \Pequiven\SEIPBundle\Entity\CEI\Service
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\Service")
     * @ORM\JoinColumn(nullable=false)
     */
    private $service;

    /**
     * Detalles
     * @var DetailConsumerPlanningService
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Service\DetailConsumerPlanningService",mappedBy="consumerPlanningService",cascade={"persist","remove"})
     */
    private $detailConsumerPlanningServices;
    
    
    /**
     * Alicuota de lo que se necesita para una tonelada
     * @var float
     * @ORM\Column(name="aliquot",type="float")
     */
    private $aliquot = 0;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->detailConsumerPlanningServices = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return ConsumerPlanningService
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
     * Set service
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\Service $service
     * @return ConsumerPlanningService
     */
    public function setService(\Pequiven\SEIPBundle\Entity\CEI\Service $service)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * Get service
     *
     * @return \Pequiven\SEIPBundle\Entity\CEI\Service 
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * Add detailConsumerPlanningServices
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Service\DetailConsumerPlanningService $detailConsumerPlanningServices
     * @return ConsumerPlanningService
     */
    public function addDetailConsumerPlanningService(\Pequiven\SEIPBundle\Entity\DataLoad\Service\DetailConsumerPlanningService $detailConsumerPlanningServices)
    {
        $detailConsumerPlanningServices->setConsumerPlanningService($this);
        $this->detailConsumerPlanningServices->add($detailConsumerPlanningServices);

        return $this;
    }

    /**
     * Remove detailConsumerPlanningServices
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Service\DetailConsumerPlanningService $detailConsumerPlanningServices
     */
    public function removeDetailConsumerPlanningService(\Pequiven\SEIPBundle\Entity\DataLoad\Service\DetailConsumerPlanningService $detailConsumerPlanningServices)
    {
        $this->detailConsumerPlanningServices->removeElement($detailConsumerPlanningServices);
    }

    /**
     * Get detailConsumerPlanningServices
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDetailConsumerPlanningServices()
    {
        return $this->detailConsumerPlanningServices;
    }
    
    public function getDetails()
    {
        return $this->detailConsumerPlanningServices;
    }
    
    /**
     * 
     * @return DetailConsumerPlanningService
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
        $_toString = "-";
        if($this->getService()){
            $_toString = (string)$this->getService();
        }
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
}
