<?php

namespace Pequiven\SEIPBundle\Entity\DataLoad\ServiceFactor;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\SEIPBundle\Model\DataLoad\Detail;

/**
 * Detalle de consumo de factor de servicio (Plan y Real)
 *
 * @author Matías Jiménez <matei249@gmail.com>
 * @ORM\Table(name="seip_report_plant_service_factor_detail_consumer")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class DetailConsumerPlanningServiceFactor extends Detail
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
     * @var \Pequiven\SEIPBundle\Entity\DataLoad\ServiceFactor\ConsumerPlanningServiceFactor
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\ServiceFactor\ConsumerPlanningServiceFactor",inversedBy="detailConsumerPlanningServiceFactor")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $consumerPlanningServiceFactor;

    /**
     * Rangos de distribucion
     * @var Range
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\ServiceFactor\Range",mappedBy="detailConsumerPlanningServiceFactor",cascade={"persist","remove"})
     */
    protected $ranges;
    
    /**
     * @var \Pequiven\SEIPBundle\Entity\DataLoad\ServiceFactor\DetailConsumerPlanningServiceFactor
     * @ORM\OneToOne(targetEntity="\Pequiven\SEIPBundle\Entity\DataLoad\ServiceFactor\DetailConsumerPlanningServiceFactor")
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
     * Set consumerPlanningServiceFactor
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\ServiceFactor\ConsumerPlanningServiceFactor $consumerPlanningServiceFactor
     * @return DetailConsumerPlanningServiceFactor
     */
    public function setConsumerPlanningServiceFactor(\Pequiven\SEIPBundle\Entity\DataLoad\ServiceFactor\ConsumerPlanningServiceFactor $consumerPlanningServiceFactor)
    {
        $this->consumerPlanningServiceFactor = $consumerPlanningServiceFactor;

        return $this;
    }

    /**
     * Get consumerPlanningServiceFactor
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\ServiceFactor\ConsumerPlanningServiceFactor
     */
    public function getConsumerPlanningServiceFactor()
    {
        return $this->consumerPlanningServiceFactor;
    }

    /**
     * Add ranges
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\ServiceFactor\Range $ranges
     * @return DetailConsumerPlanningServiceFactor
     */
    public function addRange(\Pequiven\SEIPBundle\Entity\DataLoad\ServiceFactor\Range $ranges)
    {
        $ranges->setDetailConsumerPlanningServiceFactor($this);
        $this->ranges->add($ranges);

        return $this;
    }

    /**
     * Remove ranges
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\ServiceFactor\Range $ranges
     */
    public function removeRange(\Pequiven\SEIPBundle\Entity\DataLoad\ServiceFactor\Range $ranges)
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
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\ServiceFactor\DetailConsumerPlanningServiceFactor $parent
     * @return DetailConsumerPlanningServiceFactor
     */
    public function setParent(\Pequiven\SEIPBundle\Entity\DataLoad\ServiceFactor\DetailConsumerPlanningServiceFactor $parent = null) {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\ServiceFactor\DetailConsumerPlanningServiceFactor 
     */
    public function getParent() {
        return $this->parent;
    }
    
    /**
     * Set period
     *
     * @param \Pequiven\SEIPBundle\Entity\Period $period
     * @return DetailConsumerPlanningServiceFactor
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
