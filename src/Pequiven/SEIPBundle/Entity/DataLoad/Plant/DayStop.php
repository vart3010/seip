<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com.ve
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Entity\DataLoad\Plant;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\SEIPBundle\Model\BaseModel;

/**
 * Dias de paradas
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="seip_report_plant_report_day_stop")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class DayStop extends BaseModel
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
     * Dia de la parada
     * @var \DateTime
     * @ORM\Column(name="day",type="datetime")
     */
    private $day;
    
    /**
     * Horas de la parada
     * @var float
     * @ORM\Column(name="hours",type="float")
     */
    private $hours = 0;
    
    /**
     * Hora de parada
     * @var \Pequiven\SEIPBundle\Entity\CEI\StopTime
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\StopTime")
     */
    private $stopTime;
    
    /**
     * Otro tiempo de parada
     * @var boolean
     * @ORM\Column(name="other_time",type="boolean")
     */
    private $otherTime = false;
    
    /**
     * Planificacion de parada de planta
     * 
     * @var PlantStopPlanning
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Plant\PlantStopPlanning",inversedBy="dayStops")
     * @ORM\JoinColumn(nullable=false)
     */
    private $plantStopPlanning;
    
    /**
     * Periodo.
     * 
     * @var \Pequiven\SEIPBundle\Entity\Period
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Period")
     * @ORM\JoinColumn(nullable=true)
     */
    private $period;

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
     * Set day
     *
     * @param \DateTime $day
     * @return DayStop
     */
    public function setDay($day)
    {
        $this->day = $day;

        return $this;
    }

    /**
     * Get day
     *
     * @return \DateTime 
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * Set hours
     *
     * @param float $hours
     * @return DayStop
     */
    public function setHours($hours)
    {
        $this->hours = $hours;

        return $this;
    }

    /**
     * Get hours
     *
     * @return float 
     */
    public function getHours()
    {
        return $this->hours;
    }
    
    /**
     * Set plantStopPlanning
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Plant\PlantStopPlanning $plantStopPlanning
     * @return DayStop
     */
    public function setPlantStopPlanning(\Pequiven\SEIPBundle\Entity\DataLoad\Plant\PlantStopPlanning $plantStopPlanning)
    {
        $this->plantStopPlanning = $plantStopPlanning;

        return $this;
    }

    /**
     * Get plantStopPlanning
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\Plant\PlantStopPlanning 
     */
    public function getPlantStopPlanning()
    {
        return $this->plantStopPlanning;
    }
    
    /**
     * Set otherTime
     *
     * @param boolean $otherTime
     * @return DayStop
     */
    public function setOtherTime($otherTime)
    {
        $this->otherTime = $otherTime;

        return $this;
    }

    /**
     * Get otherTime
     *
     * @return boolean 
     */
    public function getOtherTime()
    {
        return $this->otherTime;
    }

    /**
     * Set stopTime
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\StopTime $stopTime
     * @return DayStop
     */
    public function setStopTime(\Pequiven\SEIPBundle\Entity\CEI\StopTime $stopTime = null)
    {
        $this->stopTime = $stopTime;

        return $this;
    }

    /**
     * Get stopTime
     *
     * @return \Pequiven\SEIPBundle\Entity\CEI\StopTime 
     */
    public function getStopTime()
    {
        return $this->stopTime;
    }
    
    public function getNroDay()
    {
        return (int)$this->day->format("d");
    }
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function calculate()
    {
        $hours = $this->hours;
        if($this->otherTime === false && $this->stopTime !== null){
            $hours = $this->stopTime->getHours();
        }
        $this->hours = $hours;
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
}
