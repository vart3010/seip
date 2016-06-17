<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\IndicatorBundle\Entity\Indicator;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\IndicatorBundle\Model\Indicator\IndicatorChartDetails as Model;

/**
 * Etiquetas del indicador
 *
 * @ORM\Table(name="seip_indicator_chart_details")
 * @ORM\Entity(repositoryClass="Pequiven\IndicatorBundle\Repository\Indicator\IndicatorChartDetailsRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @ORM\HasLifecycleCallbacks()
 */
class IndicatorChartDetails extends Model implements \Pequiven\SEIPBundle\Entity\PeriodItemInterface
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
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;
    
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=300, nullable=true)
     */
    private $description;
    
    /**
     * Indicador
     * 
     * @var \Pequiven\IndicatorBundle\Entity\Indicator
     * @ORM\ManyToOne(targetEntity="Pequiven\IndicatorBundle\Entity\Indicator",inversedBy="indicatorsChartDetails")
     * @ORM\JoinColumn(nullable=false)
     */
    private $indicator;
    
    /**
     * Indicador
     * 
     * @var \Pequiven\SEIPBundle\Entity\Chart
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Chart",inversedBy="indicatorsChartDetails")
     * @ORM\JoinColumn(nullable=false)
     */
    private $chart;
    
    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="orderShow", type="integer")
     */
    private $orderShow = 1;
    
    /**
     * Periodo.
     * 
     * @var \Pequiven\SEIPBundle\Entity\Period
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Period")
     * @ORM\JoinColumn(nullable=false)
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return \Pequiven\IndicatorBundle\Entity\Indicator\TagIndicator
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return \Pequiven\IndicatorBundle\Entity\Indicator\TagIndicator
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    
    /**
     * Set description
     * @param type $description
     * @return \Pequiven\IndicatorBundle\Entity\Indicator\TagIndicator
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    /**
     * Set indicator
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator $indicator
     * @return \Pequiven\IndicatorBundle\Entity\Indicator\IndicatorChartDetails
     */
    public function setIndicator(\Pequiven\IndicatorBundle\Entity\Indicator $indicator)
    {
        $this->indicator = $indicator;

        return $this;
    }

    /**
     * Get indicator
     *
     * @return \Pequiven\IndicatorBundle\Entity\Indicator 
     */
    public function getIndicator()
    {
        return $this->indicator;
    }
    
    /**
     * Set chart
     *
     * @param \Pequiven\SEIPBundle\Entity\Chart $chart
     * @return \Pequiven\IndicatorBundle\Entity\Indicator\IndicatorChartDetails
     */
    public function setChart(\Pequiven\SEIPBundle\Entity\Chart $chart)
    {
        $this->chart = $chart;

        return $this;
    }

    /**
     * Get chart
     *
     * @return \Pequiven\SEIPBundle\Entity\Chart 
     */
    public function getChart()
    {
        return $this->chart;
    }
    
    /**
     * Set show
     *
     * @param boolean $showTag
     * @return \Pequiven\IndicatorBundle\Entity\Indicator\TagIndicator
     */
    public function setShowTag($showTag)
    {
        $this->showTag = $showTag;

        return $this;
    }

    /**
     * Get showTag
     *
     * @return boolean 
     */
    public function getShowTag()
    {
        return $this->showTag;
    }

    
    function getDeletedAt() 
    {
        return $this->deletedAt;
    }

    /**
     * Set deletedAt
     * @param type $deletedAt
     * @return \Pequiven\IndicatorBundle\Entity\Indicator\TagIndicator
     */
    function setDeletedAt($deletedAt) 
    {
        $this->deletedAt = $deletedAt;
        return $this;
    }
    
    function getOrderShow() {
        return $this->orderShow;
    }

    function setOrderShow($orderShow) {
        $this->orderShow = $orderShow;
    }
    
    function getPeriod() {
        return $this->period;
    }

    function setPeriod(\Pequiven\SEIPBundle\Entity\Period $period) 
    {
        $this->period = $period;
        
        return $this;
    }
    
}