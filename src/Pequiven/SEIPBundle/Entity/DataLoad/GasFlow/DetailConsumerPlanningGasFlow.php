<?php

namespace Pequiven\SEIPBundle\Entity\DataLoad\GasFlow;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\SEIPBundle\Model\DataLoad\Detail;

/**
 * Detalle de consumo de Flujo de gas (Plan y Real)
 *
 * @author Matías Jiménez <matei249@gmail.com>
 * @ORM\Table(name="seip_report_plant_gas_flow_detail_consumer")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class DetailConsumerPlanningGasFlow extends Detail
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     *
     * @var \Pequiven\SEIPBundle\Entity\DataLoad\GasFlow\ConsumerPlanningGasFlow
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\GasFlow\ConsumerPlanningGasFlow",inversedBy="detailConsumerPlanningGasFlow")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $consumerPlanningGasFlow;

    /**
     * Rangos de distribucion
     * @var Range
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\GasFlow\Range",mappedBy="detailConsumerPlanningGasFlow",cascade={"persist","remove"})
     */
    protected $ranges;
    
    /**
     * @var \Pequiven\SEIPBundle\Entity\DataLoad\GasFlow\DetailConsumerPlanningGasFlow
     * @ORM\OneToOne(targetEntity="\Pequiven\SEIPBundle\Entity\DataLoad\GasFlow\DetailConsumerPlanningGasFlow")
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
     * Plan x
     * @var float
     * @ORM\Column(name="plan_flow",type="float")
     */
    protected $planFlow = 0;

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
     * Set consumerPlanningGasFlow
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\GasFlow\ConsumerPlanningGasFlow $consumerPlanningGasFlow
     * @return DetailConsumerPlanningGasFlow
     */
    public function setConsumerPlanningGasFlow(\Pequiven\SEIPBundle\Entity\DataLoad\GasFlow\ConsumerPlanningGasFlow $consumerPlanningGasFlow)
    {
        $this->consumerPlanningGasFlow = $consumerPlanningGasFlow;

        return $this;
    }

    /**
     * Get consumerPlanningGasFlow
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\GasFlow\ConsumerPlanningGasFlow
     */
    public function getConsumerPlanningGasFlow()
    {
        return $this->consumerPlanningGasFlow;
    }

    /**
     * Add ranges
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\GasFlow\Range $ranges
     * @return DetailConsumerPlanningGasFlow
     */
    public function addRange(\Pequiven\SEIPBundle\Entity\DataLoad\GasFlow\Range $ranges)
    {
        $ranges->setDetailConsumerPlanningGasFlow($this);
        $this->ranges->add($ranges);

        return $this;
    }

    /**
     * Remove ranges
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\GasFlow\Range $ranges
     */
    public function removeRange(\Pequiven\SEIPBundle\Entity\DataLoad\GasFlow\Range $ranges)
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

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function totalize()
    {
        parent::totalize();
    }
    
        
    /**
     * Set parent
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\GasFlow\DetailConsumerPlanningGasFlow $parent
     * @return DetailConsumerPlanningGasFlow
     */
    public function setParent(\Pequiven\SEIPBundle\Entity\DataLoad\GasFlow\DetailConsumerPlanningGasFlow $parent = null) {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\GasFlow\DetailConsumerPlanningGasFlow 
     */
    public function getParent() {
        return $this->parent;
    }
    
    /**
     * Set period
     *
     * @param \Pequiven\SEIPBundle\Entity\Period $period
     * @return DetailConsumerPlanningGasFlow
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
    
    function getPlanFlow() {
        return $this->planFlow;
    }

    function setPlanFlow($planFlow) {
        $this->planFlow = $planFlow;
    }


}
