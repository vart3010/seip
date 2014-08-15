<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\ArrangementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\ArrangementBundle\Model\ArrangementRange as modelArrangementRange;

/**
 * ArrangementRangeType
 *
 * @ORM\Table(name="seip_arrangement_range")
 * @ORM\Entity(repositoryClass="Pequiven\ArrangementBundle\Repository\ArrangementRangeRepository")
 * @author matias
 */
class ArrangementRange extends modelArrangementRange {
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

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
     * Objetive
     * @var \Pequiven\ObjetiveBundle\Entity\Objetive
     * @ORM\ManyToOne(targetEntity="\Pequiven\ObjetiveBundle\Entity\Objetive")
     * @ORM\JoinColumn(name="fk_objetive", referencedColumnName="id")
     */
    private $objetive;
    
    /**
     * Indicator
     * @var \Pequiven\IndicatorBundle\Entity\Indicator
     * @ORM\ManyToOne(targetEntity="\Pequiven\IndicatorBundle\Entity\Indicator")
     * @ORM\JoinColumn(name="fk_indicator", referencedColumnName="id")
     */
    private $indicator;
    
    /**
     * ArrangementRangeType
     * @var \Pequiven\MasterBundle\Entity\ArrangementRangeType
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\ArrangementRangeType")
     * @ORM\JoinColumn(name="type_range_top", referencedColumnName="id")
     */
    private $typeRangeTop;
    
    /**
     * ArrangementRangeType
     * @var \Pequiven\MasterBundle\Entity\ArrangementRangeType
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\ArrangementRangeType")
     * @ORM\JoinColumn(name="type_range_middle", referencedColumnName="id")
     */
    private $typeRangeMiddle;
    
    /**
     * ArrangementRangeType
     * @var \Pequiven\MasterBundle\Entity\ArrangementRangeType
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\ArrangementRangeType")
     * @ORM\JoinColumn(name="type_range_bottom", referencedColumnName="id")
     */
    private $typeRangeBottom;
    
    /**
     * Operator
     * @var \Pequiven\MasterBundle\Entity\Operator
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Operator")
     * @ORM\JoinColumn(name="op_rank_top", referencedColumnName="id")
     */
    private $opRankTop;
    
    /**
     * @var float
     * 
     * @ORM\Column(name="rank_top", type="float", nullable=true)
     */
    private $rankTop;
    
    /**
     * Operator
     * @var \Pequiven\MasterBundle\Entity\Operator
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Operator")
     * @ORM\JoinColumn(name="op_rank_middle_top", referencedColumnName="id")
     */
    private $opRankMiddleTop;
    
    /**
     * @var float
     * 
     * @ORM\Column(name="rank_middle_top", type="float", nullable=true)
     */
    private $rankMiddleTop;
    
    /**
     * Operator
     * @var \Pequiven\MasterBundle\Entity\Operator
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Operator")
     * @ORM\JoinColumn(name="op_rank_middle_bottom", referencedColumnName="id")
     */
    private $opRankMiddleBottom;
    
    /**
     * @var float
     * 
     * @ORM\Column(name="rank_middle_bottom", type="float", nullable=true)
     */
    private $rankMiddleBottom;
    
    /**
     * Operator
     * @var \Pequiven\MasterBundle\Entity\Operator
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Operator")
     * @ORM\JoinColumn(name="op_rank_bottom", referencedColumnName="id")
     */
    private $opRankBottom;
    
    /**
     * @var float
     * 
     * @ORM\Column(name="rank_bottom", type="float", nullable=true)
     */
    private $rankBottom;
    
    /**
     * Operator
     * @var \Pequiven\MasterBundle\Entity\Operator
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Operator")
     * @ORM\JoinColumn(name="op_rank_top_top_top", referencedColumnName="id")
     */
    private $opRankTopTopTop;
    
    /**
     * @var float
     * 
     * @ORM\Column(name="rank_top_top_top", type="float", nullable=true)
     */
    private $rankTopTopTop;
    
    /**
     * Operator
     * @var \Pequiven\MasterBundle\Entity\Operator
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Operator")
     * @ORM\JoinColumn(name="op_rank_top_top_bottom", referencedColumnName="id")
     */
    private $opRankTopTopBottom;
    
    /**
     * @var float
     * 
     * @ORM\Column(name="rank_top_top_bottom", type="float", nullable=true)
     */
    private $rankTopTopBottom;
    
    /**
     * Operator
     * @var \Pequiven\MasterBundle\Entity\Operator
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Operator")
     * @ORM\JoinColumn(name="op_rank_top_bottom_top", referencedColumnName="id")
     */
    private $opRankTopBottomTop;
    
    /**
     * @var float
     * 
     * @ORM\Column(name="rank_top_bottom_top", type="float", nullable=true)
     */
    private $rankTopBottomTop;
    
    /**
     * Operator
     * @var \Pequiven\MasterBundle\Entity\Operator
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Operator")
     * @ORM\JoinColumn(name="op_rank_top_bottom_bottom", referencedColumnName="id")
     */
    private $opRankTopBottomBottom;
    
    /**
     * @var float
     * 
     * @ORM\Column(name="rank_top_bottom_bottom", type="float", nullable=true)
     */
    private $rankTopBottomBottom;
    
        /**
     * Operator
     * @var \Pequiven\MasterBundle\Entity\Operator
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Operator")
     * @ORM\JoinColumn(name="op_rank_middle_top_top", referencedColumnName="id")
     */
    private $opRankMiddleTopTop;
    
    /**
     * @var float
     * 
     * @ORM\Column(name="rank_middle_top_top", type="float", nullable=true)
     */
    private $rankMiddleTopTop;
    
    /**
     * Operator
     * @var \Pequiven\MasterBundle\Entity\Operator
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Operator")
     * @ORM\JoinColumn(name="op_rank_middle_top_bottom", referencedColumnName="id")
     */
    private $opRankMiddleTopBottom;
    
    /**
     * @var float
     * 
     * @ORM\Column(name="rank_middle_top_bottom", type="float", nullable=true)
     */
    private $rankMiddleTopBottom;
    
    /**
     * Operator
     * @var \Pequiven\MasterBundle\Entity\Operator
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Operator")
     * @ORM\JoinColumn(name="op_rank_middle_bottom_top", referencedColumnName="id")
     */
    private $opRankMiddleBottomTop;
    
    /**
     * @var float
     * 
     * @ORM\Column(name="rank_middle_bottom_top", type="float", nullable=true)
     */
    private $rankMiddleBottomTop;
    
    /**
     * Operator
     * @var \Pequiven\MasterBundle\Entity\Operator
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Operator")
     * @ORM\JoinColumn(name="op_rank_middle_bottom_bottom", referencedColumnName="id")
     */
    private $opRankMiddleBottomBottom;
    
    /**
     * @var float
     * 
     * @ORM\Column(name="rank_middle_bottom_bottom", type="float", nullable=true)
     */
    private $rankMiddleBottomBottom;
    
    /**
     * Operator
     * @var \Pequiven\MasterBundle\Entity\Operator
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Operator")
     * @ORM\JoinColumn(name="op_rank_bottom_top_top", referencedColumnName="id")
     */
    private $opRankBottomTopTop;
    
    /**
     * @var float
     * 
     * @ORM\Column(name="rank_bottom_top_top", type="float", nullable=true)
     */
    private $rankBottomTopTop;
    
    /**
     * Operator
     * @var \Pequiven\MasterBundle\Entity\Operator
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Operator")
     * @ORM\JoinColumn(name="op_rank_bottom_top_bottom", referencedColumnName="id")
     */
    private $opRankBottomTopBottom;
    
    /**
     * @var float
     * 
     * @ORM\Column(name="rank_bottom_top_bottom", type="float", nullable=true)
     */
    private $rankBottomTopBottom;
    
    /**
     * Operator
     * @var \Pequiven\MasterBundle\Entity\Operator
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Operator")
     * @ORM\JoinColumn(name="op_rank_bottom_bottom_top", referencedColumnName="id")
     */
    private $opRankBottomBottomTop;
    
    /**
     * @var float
     * 
     * @ORM\Column(name="rank_bottom_bottom_top", type="float", nullable=true)
     */
    private $rankBottomBottomTop;
    
    /**
     * Operator
     * @var \Pequiven\MasterBundle\Entity\Operator
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Operator")
     * @ORM\JoinColumn(name="op_rank_bottom_bottom_bottom", referencedColumnName="id")
     */
    private $opRankBottomBottomBottom;
    
    /**
     * @var float
     * 
     * @ORM\Column(name="rank_bottom_bottom_bottom", type="float", nullable=true)
     */
    private $rankBottomBottomBottom;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled = true;    

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
     * @return ArrangementRange
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
     * @return ArrangementRange
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
     * Set rankTop
     *
     * @param float $rankTop
     * @return ArrangementRange
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
     * @return ArrangementRange
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
     * @return ArrangementRange
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
     * @return ArrangementRange
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
     * Set rankTopTopTop
     *
     * @param float $rankTopTopTop
     * @return ArrangementRange
     */
    public function setRankTopTopTop($rankTopTopTop)
    {
        $this->rankTopTopTop = $rankTopTopTop;

        return $this;
    }

    /**
     * Get rankTopTopTop
     *
     * @return float 
     */
    public function getRankTopTopTop()
    {
        return $this->rankTopTopTop;
    }

    /**
     * Set rankTopTopBottom
     *
     * @param float $rankTopTopBottom
     * @return ArrangementRange
     */
    public function setRankTopTopBottom($rankTopTopBottom)
    {
        $this->rankTopTopBottom = $rankTopTopBottom;

        return $this;
    }

    /**
     * Get rankTopTopBottom
     *
     * @return float 
     */
    public function getRankTopTopBottom()
    {
        return $this->rankTopTopBottom;
    }

    /**
     * Set rankTopBottomTop
     *
     * @param float $rankTopBottomTop
     * @return ArrangementRange
     */
    public function setRankTopBottomTop($rankTopBottomTop)
    {
        $this->rankTopBottomTop = $rankTopBottomTop;

        return $this;
    }

    /**
     * Get rankTopBottomTop
     *
     * @return float 
     */
    public function getRankTopBottomTop()
    {
        return $this->rankTopBottomTop;
    }

    /**
     * Set rankTopBottomBottom
     *
     * @param float $rankTopBottomBottom
     * @return ArrangementRange
     */
    public function setRankTopBottomBottom($rankTopBottomBottom)
    {
        $this->rankTopBottomBottom = $rankTopBottomBottom;

        return $this;
    }

    /**
     * Get rankTopBottomBottom
     *
     * @return float 
     */
    public function getRankTopBottomBottom()
    {
        return $this->rankTopBottomBottom;
    }

    /**
     * Set rankMiddleTopTop
     *
     * @param float $rankMiddleTopTop
     * @return ArrangementRange
     */
    public function setRankMiddleTopTop($rankMiddleTopTop)
    {
        $this->rankMiddleTopTop = $rankMiddleTopTop;

        return $this;
    }

    /**
     * Get rankMiddleTopTop
     *
     * @return float 
     */
    public function getRankMiddleTopTop()
    {
        return $this->rankMiddleTopTop;
    }

    /**
     * Set rankMiddleTopBottom
     *
     * @param float $rankMiddleTopBottom
     * @return ArrangementRange
     */
    public function setRankMiddleTopBottom($rankMiddleTopBottom)
    {
        $this->rankMiddleTopBottom = $rankMiddleTopBottom;

        return $this;
    }

    /**
     * Get rankMiddleTopBottom
     *
     * @return float 
     */
    public function getRankMiddleTopBottom()
    {
        return $this->rankMiddleTopBottom;
    }

    /**
     * Set rankMiddleBottomTop
     *
     * @param float $rankMiddleBottomTop
     * @return ArrangementRange
     */
    public function setRankMiddleBottomTop($rankMiddleBottomTop)
    {
        $this->rankMiddleBottomTop = $rankMiddleBottomTop;

        return $this;
    }

    /**
     * Get rankMiddleBottomTop
     *
     * @return float 
     */
    public function getRankMiddleBottomTop()
    {
        return $this->rankMiddleBottomTop;
    }

    /**
     * Set rankMiddleBottomBottom
     *
     * @param float $rankMiddleBottomBottom
     * @return ArrangementRange
     */
    public function setRankMiddleBottomBottom($rankMiddleBottomBottom)
    {
        $this->rankMiddleBottomBottom = $rankMiddleBottomBottom;

        return $this;
    }

    /**
     * Get rankMiddleBottomBottom
     *
     * @return float 
     */
    public function getRankMiddleBottomBottom()
    {
        return $this->rankMiddleBottomBottom;
    }

    /**
     * Set rankBottomTopTop
     *
     * @param float $rankBottomTopTop
     * @return ArrangementRange
     */
    public function setRankBottomTopTop($rankBottomTopTop)
    {
        $this->rankBottomTopTop = $rankBottomTopTop;

        return $this;
    }

    /**
     * Get rankBottomTopTop
     *
     * @return float 
     */
    public function getRankBottomTopTop()
    {
        return $this->rankBottomTopTop;
    }

    /**
     * Set rankBottomTopBottom
     *
     * @param float $rankBottomTopBottom
     * @return ArrangementRange
     */
    public function setRankBottomTopBottom($rankBottomTopBottom)
    {
        $this->rankBottomTopBottom = $rankBottomTopBottom;

        return $this;
    }

    /**
     * Get rankBottomTopBottom
     *
     * @return float 
     */
    public function getRankBottomTopBottom()
    {
        return $this->rankBottomTopBottom;
    }

    /**
     * Set rankBottomBottomTop
     *
     * @param float $rankBottomBottomTop
     * @return ArrangementRange
     */
    public function setRankBottomBottomTop($rankBottomBottomTop)
    {
        $this->rankBottomBottomTop = $rankBottomBottomTop;

        return $this;
    }

    /**
     * Get rankBottomBottomTop
     *
     * @return float 
     */
    public function getRankBottomBottomTop()
    {
        return $this->rankBottomBottomTop;
    }

    /**
     * Set rankBottomBottomBottom
     *
     * @param float $rankBottomBottomBottom
     * @return ArrangementRange
     */
    public function setRankBottomBottomBottom($rankBottomBottomBottom)
    {
        $this->rankBottomBottomBottom = $rankBottomBottomBottom;

        return $this;
    }

    /**
     * Get rankBottomBottomBottom
     *
     * @return float 
     */
    public function getRankBottomBottomBottom()
    {
        return $this->rankBottomBottomBottom;
    }

    /**
     * Set userCreatedAt
     *
     * @param \Pequiven\SEIPBundle\Entity\User $userCreatedAt
     * @return ArrangementRange
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
     * @return ArrangementRange
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
     * Set objetive
     *
     * @param \Pequiven\ObjetiveBundle\Entity\Objetive $objetive
     * @return ArrangementRange
     */
    public function setObjetive(\Pequiven\ObjetiveBundle\Entity\Objetive $objetive = null)
    {
        $this->objetive = $objetive;

        return $this;
    }

    /**
     * Get objetive
     *
     * @return \Pequiven\ObjetiveBundle\Entity\Objetive 
     */
    public function getObjetive()
    {
        return $this->objetive;
    }

    /**
     * Set indicator
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator $indicator
     * @return ArrangementRange
     */
    public function setIndicator(\Pequiven\IndicatorBundle\Entity\Indicator $indicator = null)
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
     * Set typeRangeTop
     *
     * @param \Pequiven\MasterBundle\Entity\ArrangementRangeType $typeRangeTop
     * @return ArrangementRange
     */
    public function setTypeRangeTop(\Pequiven\MasterBundle\Entity\ArrangementRangeType $typeRangeTop = null)
    {
        $this->typeRangeTop = $typeRangeTop;

        return $this;
    }

    /**
     * Get typeRangeTop
     *
     * @return \Pequiven\MasterBundle\Entity\ArrangementRangeType 
     */
    public function getTypeRangeTop()
    {
        return $this->typeRangeTop;
    }

    /**
     * Set typeRangeMiddle
     *
     * @param \Pequiven\MasterBundle\Entity\ArrangementRangeType $typeRangeMiddle
     * @return ArrangementRange
     */
    public function setTypeRangeMiddle(\Pequiven\MasterBundle\Entity\ArrangementRangeType $typeRangeMiddle = null)
    {
        $this->typeRangeMiddle = $typeRangeMiddle;

        return $this;
    }

    /**
     * Get typeRangeMiddle
     *
     * @return \Pequiven\MasterBundle\Entity\ArrangementRangeType 
     */
    public function getTypeRangeMiddle()
    {
        return $this->typeRangeMiddle;
    }

    /**
     * Set typeRangeBottom
     *
     * @param \Pequiven\MasterBundle\Entity\ArrangementRangeType $typeRangeBottom
     * @return ArrangementRange
     */
    public function setTypeRangeBottom(\Pequiven\MasterBundle\Entity\ArrangementRangeType $typeRangeBottom = null)
    {
        $this->typeRangeBottom = $typeRangeBottom;

        return $this;
    }

    /**
     * Get typeRangeBottom
     *
     * @return \Pequiven\MasterBundle\Entity\ArrangementRangeType 
     */
    public function getTypeRangeBottom()
    {
        return $this->typeRangeBottom;
    }

    /**
     * Set opRankTop
     *
     * @param \Pequiven\MasterBundle\Entity\Operator $opRankTop
     * @return ArrangementRange
     */
    public function setOpRankTop(\Pequiven\MasterBundle\Entity\Operator $opRankTop = null)
    {
        $this->opRankTop = $opRankTop;

        return $this;
    }

    /**
     * Get opRankTop
     *
     * @return \Pequiven\MasterBundle\Entity\Operator 
     */
    public function getOpRankTop()
    {
        return $this->opRankTop;
    }

    /**
     * Set opRankMiddleTop
     *
     * @param \Pequiven\MasterBundle\Entity\Operator $opRankMiddleTop
     * @return ArrangementRange
     */
    public function setOpRankMiddleTop(\Pequiven\MasterBundle\Entity\Operator $opRankMiddleTop = null)
    {
        $this->opRankMiddleTop = $opRankMiddleTop;

        return $this;
    }

    /**
     * Get opRankMiddleTop
     *
     * @return \Pequiven\MasterBundle\Entity\Operator 
     */
    public function getOpRankMiddleTop()
    {
        return $this->opRankMiddleTop;
    }

    /**
     * Set opRankMiddleBottom
     *
     * @param \Pequiven\MasterBundle\Entity\Operator $opRankMiddleBottom
     * @return ArrangementRange
     */
    public function setOpRankMiddleBottom(\Pequiven\MasterBundle\Entity\Operator $opRankMiddleBottom = null)
    {
        $this->opRankMiddleBottom = $opRankMiddleBottom;

        return $this;
    }

    /**
     * Get opRankMiddleBottom
     *
     * @return \Pequiven\MasterBundle\Entity\Operator 
     */
    public function getOpRankMiddleBottom()
    {
        return $this->opRankMiddleBottom;
    }

    /**
     * Set opRankBottom
     *
     * @param \Pequiven\MasterBundle\Entity\Operator $opRankBottom
     * @return ArrangementRange
     */
    public function setOpRankBottom(\Pequiven\MasterBundle\Entity\Operator $opRankBottom = null)
    {
        $this->opRankBottom = $opRankBottom;

        return $this;
    }

    /**
     * Get opRankBottom
     *
     * @return \Pequiven\MasterBundle\Entity\Operator 
     */
    public function getOpRankBottom()
    {
        return $this->opRankBottom;
    }

    /**
     * Set opRankTopTopTop
     *
     * @param \Pequiven\MasterBundle\Entity\Operator $opRankTopTopTop
     * @return ArrangementRange
     */
    public function setOpRankTopTopTop(\Pequiven\MasterBundle\Entity\Operator $opRankTopTopTop = null)
    {
        $this->opRankTopTopTop = $opRankTopTopTop;

        return $this;
    }

    /**
     * Get opRankTopTopTop
     *
     * @return \Pequiven\MasterBundle\Entity\Operator 
     */
    public function getOpRankTopTopTop()
    {
        return $this->opRankTopTopTop;
    }

    /**
     * Set opRankTopTopBottom
     *
     * @param \Pequiven\MasterBundle\Entity\Operator $opRankTopTopBottom
     * @return ArrangementRange
     */
    public function setOpRankTopTopBottom(\Pequiven\MasterBundle\Entity\Operator $opRankTopTopBottom = null)
    {
        $this->opRankTopTopBottom = $opRankTopTopBottom;

        return $this;
    }

    /**
     * Get opRankTopTopBottom
     *
     * @return \Pequiven\MasterBundle\Entity\Operator 
     */
    public function getOpRankTopTopBottom()
    {
        return $this->opRankTopTopBottom;
    }

    /**
     * Set opRankTopBottomTop
     *
     * @param \Pequiven\MasterBundle\Entity\Operator $opRankTopBottomTop
     * @return ArrangementRange
     */
    public function setOpRankTopBottomTop(\Pequiven\MasterBundle\Entity\Operator $opRankTopBottomTop = null)
    {
        $this->opRankTopBottomTop = $opRankTopBottomTop;

        return $this;
    }

    /**
     * Get opRankTopBottomTop
     *
     * @return \Pequiven\MasterBundle\Entity\Operator 
     */
    public function getOpRankTopBottomTop()
    {
        return $this->opRankTopBottomTop;
    }

    /**
     * Set opRankTopBottomBottom
     *
     * @param \Pequiven\MasterBundle\Entity\Operator $opRankTopBottomBottom
     * @return ArrangementRange
     */
    public function setOpRankTopBottomBottom(\Pequiven\MasterBundle\Entity\Operator $opRankTopBottomBottom = null)
    {
        $this->opRankTopBottomBottom = $opRankTopBottomBottom;

        return $this;
    }

    /**
     * Get opRankTopBottomBottom
     *
     * @return \Pequiven\MasterBundle\Entity\Operator 
     */
    public function getOpRankTopBottomBottom()
    {
        return $this->opRankTopBottomBottom;
    }

    /**
     * Set opRankMiddleTopTop
     *
     * @param \Pequiven\MasterBundle\Entity\Operator $opRankMiddleTopTop
     * @return ArrangementRange
     */
    public function setOpRankMiddleTopTop(\Pequiven\MasterBundle\Entity\Operator $opRankMiddleTopTop = null)
    {
        $this->opRankMiddleTopTop = $opRankMiddleTopTop;

        return $this;
    }

    /**
     * Get opRankMiddleTopTop
     *
     * @return \Pequiven\MasterBundle\Entity\Operator 
     */
    public function getOpRankMiddleTopTop()
    {
        return $this->opRankMiddleTopTop;
    }

    /**
     * Set opRankMiddleTopBottom
     *
     * @param \Pequiven\MasterBundle\Entity\Operator $opRankMiddleTopBottom
     * @return ArrangementRange
     */
    public function setOpRankMiddleTopBottom(\Pequiven\MasterBundle\Entity\Operator $opRankMiddleTopBottom = null)
    {
        $this->opRankMiddleTopBottom = $opRankMiddleTopBottom;

        return $this;
    }

    /**
     * Get opRankMiddleTopBottom
     *
     * @return \Pequiven\MasterBundle\Entity\Operator 
     */
    public function getOpRankMiddleTopBottom()
    {
        return $this->opRankMiddleTopBottom;
    }

    /**
     * Set opRankMiddleBottomTop
     *
     * @param \Pequiven\MasterBundle\Entity\Operator $opRankMiddleBottomTop
     * @return ArrangementRange
     */
    public function setOpRankMiddleBottomTop(\Pequiven\MasterBundle\Entity\Operator $opRankMiddleBottomTop = null)
    {
        $this->opRankMiddleBottomTop = $opRankMiddleBottomTop;

        return $this;
    }

    /**
     * Get opRankMiddleBottomTop
     *
     * @return \Pequiven\MasterBundle\Entity\Operator 
     */
    public function getOpRankMiddleBottomTop()
    {
        return $this->opRankMiddleBottomTop;
    }

    /**
     * Set opRankMiddleBottomBottom
     *
     * @param \Pequiven\MasterBundle\Entity\Operator $opRankMiddleBottomBottom
     * @return ArrangementRange
     */
    public function setOpRankMiddleBottomBottom(\Pequiven\MasterBundle\Entity\Operator $opRankMiddleBottomBottom = null)
    {
        $this->opRankMiddleBottomBottom = $opRankMiddleBottomBottom;

        return $this;
    }

    /**
     * Get opRankMiddleBottomBottom
     *
     * @return \Pequiven\MasterBundle\Entity\Operator 
     */
    public function getOpRankMiddleBottomBottom()
    {
        return $this->opRankMiddleBottomBottom;
    }

    /**
     * Set opRankBottomTopTop
     *
     * @param \Pequiven\MasterBundle\Entity\Operator $opRankBottomTopTop
     * @return ArrangementRange
     */
    public function setOpRankBottomTopTop(\Pequiven\MasterBundle\Entity\Operator $opRankBottomTopTop = null)
    {
        $this->opRankBottomTopTop = $opRankBottomTopTop;

        return $this;
    }

    /**
     * Get opRankBottomTopTop
     *
     * @return \Pequiven\MasterBundle\Entity\Operator 
     */
    public function getOpRankBottomTopTop()
    {
        return $this->opRankBottomTopTop;
    }

    /**
     * Set opRankBottomTopBottom
     *
     * @param \Pequiven\MasterBundle\Entity\Operator $opRankBottomTopBottom
     * @return ArrangementRange
     */
    public function setOpRankBottomTopBottom(\Pequiven\MasterBundle\Entity\Operator $opRankBottomTopBottom = null)
    {
        $this->opRankBottomTopBottom = $opRankBottomTopBottom;

        return $this;
    }

    /**
     * Get opRankBottomTopBottom
     *
     * @return \Pequiven\MasterBundle\Entity\Operator 
     */
    public function getOpRankBottomTopBottom()
    {
        return $this->opRankBottomTopBottom;
    }

    /**
     * Set opRankBottomBottomTop
     *
     * @param \Pequiven\MasterBundle\Entity\Operator $opRankBottomBottomTop
     * @return ArrangementRange
     */
    public function setOpRankBottomBottomTop(\Pequiven\MasterBundle\Entity\Operator $opRankBottomBottomTop = null)
    {
        $this->opRankBottomBottomTop = $opRankBottomBottomTop;

        return $this;
    }

    /**
     * Get opRankBottomBottomTop
     *
     * @return \Pequiven\MasterBundle\Entity\Operator 
     */
    public function getOpRankBottomBottomTop()
    {
        return $this->opRankBottomBottomTop;
    }

    /**
     * Set opRankBottomBottomBottom
     *
     * @param \Pequiven\MasterBundle\Entity\Operator $opRankBottomBottomBottom
     * @return ArrangementRange
     */
    public function setOpRankBottomBottomBottom(\Pequiven\MasterBundle\Entity\Operator $opRankBottomBottomBottom = null)
    {
        $this->opRankBottomBottomBottom = $opRankBottomBottomBottom;

        return $this;
    }

    /**
     * Get opRankBottomBottomBottom
     *
     * @return \Pequiven\MasterBundle\Entity\Operator 
     */
    public function getOpRankBottomBottomBottom()
    {
        return $this->opRankBottomBottomBottom;
    }
    
    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return ArrangementRange
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
}
