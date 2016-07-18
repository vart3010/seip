<?php

namespace Pequiven\SEIPBundle\Entity\DataLoad\GasFlow;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\SEIPBundle\Model\DataLoad\RawMaterial\Range as BaseModel;

/**
 * Rango de distribucion
 *
 * @author Matías Jiménez <matei249@gmail.com>
 * @ORM\Table(name="seip_report_plant_gas_flow_range")
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
     * Planificacion de producto
     * @var \Pequiven\SEIPBundle\Entity\DataLoad\GasFlow\DetailConsumerPlanningGasFlow
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\GasFlow\DetailConsumerPlanningGasFlow",inversedBy="ranges")
     * @ORM\JoinColumn(nullable=false)
     */
    private $detailConsumerPlanningGasFlow;

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
     * Tipo de rango
     * @var integer
     * @ORM\Column(name="type",type="integer")
     */
    private $type;
    
    /**
     * Valor fijo o porcentaje del factor de capacidad
     * @var float
     * @ORM\Column(name="value",type="float")
     */
    private $value;
    
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

    function getType() {
        return $this->type;
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
     * Set type
     *
     * @param integer $type
     * @return Range
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Set value
     *
     * @param float $value
     * @return Range
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return float 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set detailConsumerPlanningGasFlow
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\GasFlow\DetailConsumerPlanningGasFlow $detailConsumerPlanningGasFlow
     * @return Range
     */
    public function setDetailConsumerPlanningGasFlow(\Pequiven\SEIPBundle\Entity\DataLoad\GasFlow\DetailConsumerPlanningGasFlow $detailConsumerPlanningGasFlow)
    {
        $this->detailConsumerPlanningGasFlow = $detailConsumerPlanningGasFlow;

        return $this;
    }

    /**
     * Get detailConsumerPlanningGasFlow
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\GasFlow\DetailConsumerPlanningGasFlow 
     */
    public function getDetailConsumerPlanningGasFlow()
    {
        return $this->detailConsumerPlanningGasFlow;
    }
    
     public function __toString() {
        $_toString = "-";
        
        if($this->getId() > 0){
            $_toString = $this->getId()."";
        }
        return $_toString;
    }
    
    /**
     * Set period
     *
     * @param \Pequiven\SEIPBundle\Entity\Period $period
     * @return Range
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