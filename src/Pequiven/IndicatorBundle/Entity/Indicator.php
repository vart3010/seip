<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\IndicatorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\IndicatorBundle\Model\Indicator as modelIndicator;

/**
 * Indicator
 *
 * @ORM\Table(name="seip_indicator")
 * @ORM\Entity(repositoryClass="Pequiven\IndicatorBundle\Repository\IndicatorRepository")
 * @author matias
 */
class Indicator extends modelIndicator {
    
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
     * User
     * @var \Pequiven\SEIPBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(name="fk_user_created_at", referencedColumnName="id")
     */
    private $userCreatedAt;

    /**
     * User
     * @var \Pequiven\SEIPBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(name="fk_user_updated_at", referencedColumnName="id")
     */
    private $userUpdatedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=300)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="ref", type="string", length=15, nullable=true)
     */
    private $ref;
    
        /**
     * @var float
     * 
     * @ORM\Column(name="weight", type="float", nullable=true)
     */
    private $weight;

    /**
     * @var float
     * 
     * @ORM\Column(name="goal", type="float", nullable=true)
     */
    private $goal;

    /**
     * @var float
     * 
     * @ORM\Column(name="rank_top", type="float", nullable=true)
     */
    private $rankTop;

    /**
     * @var float
     * 
     * @ORM\Column(name="rank_middle_top", type="float", nullable=true)
     */
    private $rankMiddleTop;

    /**
     * @var float
     * 
     * @ORM\Column(name="rank_middle_bottom", type="float", nullable=true)
     */
    private $rankMiddleBottom;

    /**
     * @var float
     * 
     * @ORM\Column(name="rank_bottom", type="float", nullable=true)
     */
    private $rankBottom;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled = true;
    
    /**
     * IndicatorLevel
     * @var \Pequiven\IndicatorBundle\Entity\IndicatorLevel
     * @ORM\ManyToOne(targetEntity="\Pequiven\IndicatorBundle\Entity\IndicatorLevel")
     * @ORM\JoinColumn(name="fk_indicator_level", referencedColumnName="id")
     */
    private $indicatorLevel;
    
    /**
     * Formula
     * @var \Pequiven\MasterBundle\Entity\Formula
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Formula")
     * @ORM\JoinColumn(name="fk_formula", referencedColumnName="id")
     */
    private $formula;

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
     * @return Indicator
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
     * @return Indicator
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
     *
     * @param string $description
     * @return Indicator
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
     * Set ref
     *
     * @param string $ref
     * @return Indicator
     */
    public function setRef($ref)
    {
        $this->ref = $ref;

        return $this;
    }

    /**
     * Get ref
     *
     * @return string 
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * Set weight
     *
     * @param float $weight
     * @return Indicator
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return float 
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set goal
     *
     * @param float $goal
     * @return Indicator
     */
    public function setGoal($goal)
    {
        $this->goal = $goal;

        return $this;
    }

    /**
     * Get goal
     *
     * @return float 
     */
    public function getGoal()
    {
        return $this->goal;
    }

    /**
     * Set rankTop
     *
     * @param float $rankTop
     * @return Indicator
     */
    public function setRankTop($rankTop)
    {
        $this->rankTop = $rankTop;

        return $this;
    }

    /**
     * Get rankTop
     *
     * @return float 
     */
    public function getRankTop()
    {
        return $this->rankTop;
    }

    /**
     * Set rankMiddleTop
     *
     * @param float $rankMiddleTop
     * @return Indicator
     */
    public function setRankMiddleTop($rankMiddleTop)
    {
        $this->rankMiddleTop = $rankMiddleTop;

        return $this;
    }

    /**
     * Get rankMiddleTop
     *
     * @return float 
     */
    public function getRankMiddleTop()
    {
        return $this->rankMiddleTop;
    }

    /**
     * Set rankMiddleBottom
     *
     * @param float $rankMiddleBottom
     * @return Indicator
     */
    public function setRankMiddleBottom($rankMiddleBottom)
    {
        $this->rankMiddleBottom = $rankMiddleBottom;

        return $this;
    }

    /**
     * Get rankMiddleBottom
     *
     * @return float 
     */
    public function getRankMiddleBottom()
    {
        return $this->rankMiddleBottom;
    }

    /**
     * Set rankBottom
     *
     * @param float $rankBottom
     * @return Indicator
     */
    public function setRankBottom($rankBottom)
    {
        $this->rankBottom = $rankBottom;

        return $this;
    }

    /**
     * Get rankBottom
     *
     * @return float 
     */
    public function getRankBottom()
    {
        return $this->rankBottom;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return Indicator
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean 
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set userCreatedAt
     *
     * @param \Pequiven\SEIPBundle\Entity\User $userCreatedAt
     * @return Indicator
     */
    public function setUserCreatedAt(\Pequiven\SEIPBundle\Entity\User $userCreatedAt = null)
    {
        $this->userCreatedAt = $userCreatedAt;

        return $this;
    }

    /**
     * Get userCreatedAt
     *
     * @return \Pequiven\SEIPBundle\Entity\User 
     */
    public function getUserCreatedAt()
    {
        return $this->userCreatedAt;
    }

    /**
     * Set userUpdatedAt
     *
     * @param \Pequiven\SEIPBundle\Entity\User $userUpdatedAt
     * @return Indicator
     */
    public function setUserUpdatedAt(\Pequiven\SEIPBundle\Entity\User $userUpdatedAt = null)
    {
        $this->userUpdatedAt = $userUpdatedAt;

        return $this;
    }

    /**
     * Get userUpdatedAt
     *
     * @return \Pequiven\SEIPBundle\Entity\User 
     */
    public function getUserUpdatedAt()
    {
        return $this->userUpdatedAt;
    }

    /**
     * Set indicatorLevel
     *
     * @param \Pequiven\IndicatorBundle\Entity\IndicatorLevel $indicatorLevel
     * @return Indicator
     */
    public function setIndicatorLevel(\Pequiven\IndicatorBundle\Entity\IndicatorLevel $indicatorLevel = null)
    {
        $this->indicatorLevel = $indicatorLevel;

        return $this;
    }

    /**
     * Get indicatorLevel
     *
     * @return \Pequiven\IndicatorBundle\Entity\IndicatorLevel 
     */
    public function getIndicatorLevel()
    {
        return $this->indicatorLevel;
    }

    /**
     * Set formula
     *
     * @param \Pequiven\MasterBundle\Entity\Formula $formula
     * @return Indicator
     */
    public function setFormula(\Pequiven\MasterBundle\Entity\Formula $formula = null)
    {
        $this->formula = $formula;

        return $this;
    }

    /**
     * Get formula
     *
     * @return \Pequiven\MasterBundle\Entity\Formula 
     */
    public function getFormula()
    {
        return $this->formula;
    }
}
