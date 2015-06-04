<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Entity\DataLoad\Plant;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\SEIPBundle\Model\DataLoad\Plant\Range as BaseModel;

/**
 * Rango de los dias de paradas
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="seip_report_data_load_plant_range")
 * @ORM\Entity()
 */
class Range extends BaseModel
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
     * Fecha de inicio
     * @var \DateTime
     * @ORM\Column(name="date_from",type="date")
     */
    private $dateFrom;
    
    /**
     * Fecha fin
     * @var \DateTime
     * @ORM\Column(name="date_end",type="date")
     */
    private $dateEnd;
    
    /**
     * Horas de la parada
     * @var float
     * @ORM\Column(name="hours",type="float",nullable=true)
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
     * Planificacion de paradas
     * @var \Pequiven\SEIPBundle\Entity\DataLoad\Plant\PlantStopPlanning
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Plant\PlantStopPlanning",inversedBy="ranges")
     * @ORM\JoinColumn(nullable=false)
     */
    private $plantStopPlanning;

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
     * Set dateFrom
     *
     * @param \DateTime $dateFrom
     * @return Range
     */
    public function setDateFrom($dateFrom)
    {
        $this->dateFrom = $dateFrom;

        return $this;
    }

    /**
     * Get dateFrom
     *
     * @return \DateTime 
     */
    public function getDateFrom()
    {
        return $this->dateFrom;
    }

    /**
     * Set dateEnd
     *
     * @param \DateTime $dateEnd
     * @return Range
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * Get dateEnd
     *
     * @return \DateTime 
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * Set hours
     *
     * @param float $hours
     * @return Range
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
     * Set otherTime
     *
     * @param boolean $otherTime
     * @return Range
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
     * @return Range
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

    /**
     * Set plantStopPlanning
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Plant\PlantStopPlanning $plantStopPlanning
     * @return Range
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
}
