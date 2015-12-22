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
use Pequiven\SEIPBundle\Model\DataLoad\Detail;

/**
 * Detalle de consumo de servicios (Plan y Real)
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="seip_report_plant_service_detail_consumer")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class DetailConsumerPlanningService extends Detail
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
     * @var \Pequiven\SEIPBundle\Entity\DataLoad\Service\ConsumerPlanningService
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Service\ConsumerPlanningService",inversedBy="detailConsumerPlanningServices")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $consumerPlanningService;

    /**
     * Rangos de distribucion
     * @var Range
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Service\Range",mappedBy="detailConsumerPlanningService",cascade={"persist","remove"})
     */
    protected $ranges;
    
    /**
     * @var \Pequiven\SEIPBundle\Entity\DataLoad\Service\DetailConsumerPlanningService
     * @ORM\OneToOne(targetEntity="\Pequiven\SEIPBundle\Entity\DataLoad\Service\DetailConsumerPlanningService")
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
     * Set consumerPlanningService
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Service\ConsumerPlanningService $consumerPlanningService
     * @return DetailConsumerPlanningService
     */
    public function setConsumerPlanningService(\Pequiven\SEIPBundle\Entity\DataLoad\Service\ConsumerPlanningService $consumerPlanningService)
    {
        $this->consumerPlanningService = $consumerPlanningService;

        return $this;
    }

    /**
     * Get consumerPlanningService
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\Service\ConsumerPlanningService
     */
    public function getConsumerPlanningService()
    {
        return $this->consumerPlanningService;
    }

    /**
     * Add ranges
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Service\Range $ranges
     * @return DetailConsumerPlanningService
     */
    public function addRange(\Pequiven\SEIPBundle\Entity\DataLoad\Service\Range $ranges)
    {
        $ranges->setDetailConsumerPlanningService($this);
        $this->ranges->add($ranges);

        return $this;
    }

    /**
     * Remove ranges
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Service\Range $ranges
     */
    public function removeRange(\Pequiven\SEIPBundle\Entity\DataLoad\Service\Range $ranges)
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
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Service\DetailConsumerPlanningService $parent
     * @return DetailConsumerPlanningService
     */
    public function setParent(\Pequiven\SEIPBundle\Entity\DataLoad\Service\DetailConsumerPlanningService $parent = null) {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\Service\DetailConsumerPlanningService 
     */
    public function getParent() {
        return $this->parent;
    }
    
    /**
     * Set period
     *
     * @param \Pequiven\SEIPBundle\Entity\Period $period
     * @return DetailConsumerPlanningService
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
