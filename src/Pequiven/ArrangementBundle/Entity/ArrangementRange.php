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
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @author matias
 */
class ArrangementRange extends modelArrangementRange implements \Pequiven\SEIPBundle\Entity\PeriodItemInterface
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
     * @ORM\OneToOne(targetEntity="\Pequiven\ObjetiveBundle\Entity\Objetive",mappedBy="arrangementRange")
     
     */
    private $objetive;
    
    /**
     * Indicator
     * @var \Pequiven\IndicatorBundle\Entity\Indicator
     * @ORM\OneToOne(targetEntity="Pequiven\IndicatorBundle\Entity\Indicator",mappedBy="arrangementRange")
     */
    private $indicator;
    
    /**
     * ArrangementRangeType
     * @var \Pequiven\MasterBundle\Entity\ArrangementRangeType
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\ArrangementRangeType")
     * @ORM\JoinColumn(name="typeRangeTop", referencedColumnName="id")
     */
    private $typeRangeTop;
    
    /**
     * ArrangementRangeType
     * @var \Pequiven\MasterBundle\Entity\ArrangementRangeType
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\ArrangementRangeType")
     * @ORM\JoinColumn(name="typeRangeMiddleTop", referencedColumnName="id")
     */
    private $typeRangeMiddleTop;
    
    /**
     * ArrangementRangeType
     * @var \Pequiven\MasterBundle\Entity\ArrangementRangeType
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\ArrangementRangeType")
     * @ORM\JoinColumn(name="typeRangeMiddleBottom", referencedColumnName="id")
     */
    private $typeRangeMiddleBottom;
    
    /**
     * ArrangementRangeType
     * @var \Pequiven\MasterBundle\Entity\ArrangementRangeType
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\ArrangementRangeType")
     * @ORM\JoinColumn(name="typeRangeBottom", referencedColumnName="id")
     */
    private $typeRangeBottom;
    
    //RANGO ALTO BÁSICO
    /**
     * Operador rango alto basico
     * 
     * @var \Pequiven\MasterBundle\Entity\Operator
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Operator")
     * @ORM\JoinColumn(name="op_rankTopBasic", referencedColumnName="id")
     */
    private $opRankTopBasic;
    
    /**
     * Valor rango alto basico
     * 
     * @var float
     * @ORM\Column(name="rankTopBasic", type="float", nullable=true)
     */
    private $rankTopBasic;
    
    //RANGO ALTO MIXTO
    /**
     * Operador del rango alto mixto
     * @var \Pequiven\MasterBundle\Entity\Operator
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Operator")
     * @ORM\JoinColumn(name="op_rankTopMixed_top", referencedColumnName="id")
     */
    private $opRankTopMixedTop;
    
    /**
     * @var float
     * 
     * @ORM\Column(name="rankTopMixedTop", type="float", nullable=true)
     */
    private $rankTopMixedTop;
    
    /**
     * Operator
     * @var \Pequiven\MasterBundle\Entity\Operator
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Operator")
     * @ORM\JoinColumn(name="op_rankTopMixed_bottom", referencedColumnName="id")
     */
    private $opRankTopMixedBottom;
    
    /**
     * @var float
     * 
     * @ORM\Column(name="rankTopMixedBottom", type="float", nullable=true)
     */
    private $rankTopMixedBottom;
    
    //RANGO MEDIO ALTO BÁSICO
    /**
     * Operator
     * @var \Pequiven\MasterBundle\Entity\Operator
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Operator")
     * @ORM\JoinColumn(name="op_rankMiddleTopBasic", referencedColumnName="id")
     */
    private $oprankMiddleTopBasic;
    
    /**
     * @var float
     * 
     * @ORM\Column(name="rankMiddleTopBasic", type="float", nullable=true)
     */
    private $rankMiddleTopBasic;
    
    //RANGO MEDIO ALTO MIXTO
    /**
     * Operator
     * @var \Pequiven\MasterBundle\Entity\Operator
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Operator")
     * @ORM\JoinColumn(name="op_rankMiddleTopMixed_top", referencedColumnName="id")
     */
    private $opRankMiddleTopMixedTop;
    
    /**
     * @var float
     * 
     * @ORM\Column(name="rankMiddleTopMixedTop", type="float", nullable=true)
     */
    private $rankMiddleTopMixedTop;
    
    /**
     * Operator
     * @var \Pequiven\MasterBundle\Entity\Operator
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Operator")
     * @ORM\JoinColumn(name="op_rankMiddleTopMixed_bottom", referencedColumnName="id")
     */
    private $opRankMiddleTopMixedBottom;
    
    /**
     * @var float
     * 
     * @ORM\Column(name="rankMiddleTopMixedBottom", type="float", nullable=true)
     */
    private $rankMiddleTopMixedBottom;
    
    //RANGO MEDIO BAJO BÁSICO
    /**
     * Operator
     * @var \Pequiven\MasterBundle\Entity\Operator
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Operator")
     * @ORM\JoinColumn(name="op_rankMiddleBottomBasic", referencedColumnName="id")
     */
    private $oprankMiddleBottomBasic;
    
    /**
     * @var float
     * 
     * @ORM\Column(name="rankMiddleBottomBasic", type="float", nullable=true)
     */
    private $rankMiddleBottomBasic;
    
    //RANGO MEDIO BAJO MIXTO
    /**
     * Operator
     * @var \Pequiven\MasterBundle\Entity\Operator
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Operator")
     * @ORM\JoinColumn(name="op_rankMiddleBottomMixed_top", referencedColumnName="id")
     */
    private $opRankMiddleBottomMixedTop;
    
    /**
     * @var float
     * 
     * @ORM\Column(name="rankMiddleBottomMixedTop", type="float", nullable=true)
     */
    private $rankMiddleBottomMixedTop;
    
    /**
     * Operator
     * @var \Pequiven\MasterBundle\Entity\Operator
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Operator")
     * @ORM\JoinColumn(name="op_rankMiddleBottomMixed_bottom", referencedColumnName="id")
     */
    private $opRankMiddleBottomMixedBottom;
    
    /**
     * @var float
     * 
     * @ORM\Column(name="rankMiddleBottomMixedBottom", type="float", nullable=true)
     */
    private $rankMiddleBottomMixedBottom;
    
    //RANGO BAJO BÁSICO
    /**
     * Operator
     * @var \Pequiven\MasterBundle\Entity\Operator
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Operator")
     * @ORM\JoinColumn(name="op_rankBottomBasic", referencedColumnName="id")
     */
    private $oprankBottomBasic;
    
    /**
     * @var float
     * 
     * @ORM\Column(name="rankBottomBasic", type="float", nullable=true)
     */
    private $rankBottomBasic;
    
    //RANGO BAJO MIXTO
    /**
     * Operator
     * @var \Pequiven\MasterBundle\Entity\Operator
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Operator")
     * @ORM\JoinColumn(name="op_rankBottomMixed_top", referencedColumnName="id")
     */
    private $opRankBottomMixedTop;
    
    /**
     * @var float
     * 
     * @ORM\Column(name="rankBottomMixedTop", type="float", nullable=true)
     */
    private $rankBottomMixedTop;
    
    /**
     * Operator
     * @var \Pequiven\MasterBundle\Entity\Operator
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Operator")
     * @ORM\JoinColumn(name="op_rankBottomMixed_bottom", referencedColumnName="id")
     */
    private $opRankBottomMixedBottom;
    
    /**
     * @var float
     * 
     * @ORM\Column(name="rankBottomMixedBottom", type="float", nullable=true)
     */
    private $rankBottomMixedBottom;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled = true;    

    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;
    
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
        $this->objetive->setArrangementRange($this);

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
        $this->indicator->setArrangementRange($this);

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
     * Set typeRangeMiddleTop
     *
     * @param \Pequiven\MasterBundle\Entity\ArrangementRangeType $typeRangeMiddleTop
     * @return ArrangementRange
     */
    public function setTypeRangeMiddleTop(\Pequiven\MasterBundle\Entity\ArrangementRangeType $typeRangeMiddleTop = null)
    {
        $this->typeRangeMiddleTop = $typeRangeMiddleTop;

        return $this;
    }

    /**
     * Get typeRangeMiddleTop
     *
     * @return \Pequiven\MasterBundle\Entity\ArrangementRangeType 
     */
    public function getTypeRangeMiddleTop()
    {
        return $this->typeRangeMiddleTop;
    }

    /**
     * Set typeRangeMiddleBottom
     *
     * @param \Pequiven\MasterBundle\Entity\ArrangementRangeType $typeRangeMiddleBottom
     * @return ArrangementRange
     */
    public function setTypeRangeMiddleBottom(\Pequiven\MasterBundle\Entity\ArrangementRangeType $typeRangeMiddleBottom = null)
    {
        $this->typeRangeMiddleBottom = $typeRangeMiddleBottom;

        return $this;
    }

    /**
     * Get typeRangeMiddleBottom
     *
     * @return \Pequiven\MasterBundle\Entity\ArrangementRangeType 
     */
    public function getTypeRangeMiddleBottom()
    {
        return $this->typeRangeMiddleBottom;
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
     * Set rankTopBasic
     *
     * @param float $rankTopBasic
     * @return ArrangementRange
     */
    public function setRankTopBasic($rankTopBasic)
    {
        $this->rankTopBasic = $rankTopBasic;

        return $this;
    }

    /**
     * Get rankTopBasic
     *
     * @return float 
     */
    public function getRankTopBasic()
    {
        return $this->rankTopBasic;
    }

    /**
     * Set rankTopMixedTop
     *
     * @param float $rankTopMixedTop
     * @return ArrangementRange
     */
    public function setRankTopMixedTop($rankTopMixedTop)
    {
        $this->rankTopMixedTop = $rankTopMixedTop;

        return $this;
    }

    /**
     * Get rankTopMixedTop
     *
     * @return float 
     */
    public function getRankTopMixedTop()
    {
        return $this->rankTopMixedTop;
    }

    /**
     * Set rankTopMixedBottom
     *
     * @param float $rankTopMixedBottom
     * @return ArrangementRange
     */
    public function setRankTopMixedBottom($rankTopMixedBottom)
    {
        $this->rankTopMixedBottom = $rankTopMixedBottom;

        return $this;
    }

    /**
     * Get rankTopMixedBottom
     *
     * @return float 
     */
    public function getRankTopMixedBottom()
    {
        return $this->rankTopMixedBottom;
    }

    /**
     * Set rankMiddleTopBasic
     *
     * @param float $rankMiddleTopBasic
     * @return ArrangementRange
     */
    public function setRankMiddleTopBasic($rankMiddleTopBasic)
    {
        $this->rankMiddleTopBasic = $rankMiddleTopBasic;

        return $this;
    }

    /**
     * Get rankMiddleTopBasic
     *
     * @return float 
     */
    public function getRankMiddleTopBasic()
    {
        return $this->rankMiddleTopBasic;
    }

    /**
     * Set rankMiddleTopMixedTop
     *
     * @param float $rankMiddleTopMixedTop
     * @return ArrangementRange
     */
    public function setRankMiddleTopMixedTop($rankMiddleTopMixedTop)
    {
        $this->rankMiddleTopMixedTop = $rankMiddleTopMixedTop;

        return $this;
    }

    /**
     * Get rankMiddleTopMixedTop
     *
     * @return float 
     */
    public function getRankMiddleTopMixedTop()
    {
        return $this->rankMiddleTopMixedTop;
    }

    /**
     * Set rankMiddleTopMixedBottom
     *
     * @param float $rankMiddleTopMixedBottom
     * @return ArrangementRange
     */
    public function setRankMiddleTopMixedBottom($rankMiddleTopMixedBottom)
    {
        $this->rankMiddleTopMixedBottom = $rankMiddleTopMixedBottom;

        return $this;
    }

    /**
     * Get rankMiddleTopMixedBottom
     *
     * @return float 
     */
    public function getRankMiddleTopMixedBottom()
    {
        return $this->rankMiddleTopMixedBottom;
    }

    /**
     * Set rankMiddleBottomBasic
     *
     * @param float $rankMiddleBottomBasic
     * @return ArrangementRange
     */
    public function setRankMiddleBottomBasic($rankMiddleBottomBasic)
    {
        $this->rankMiddleBottomBasic = $rankMiddleBottomBasic;

        return $this;
    }

    /**
     * Get rankMiddleBottomBasic
     *
     * @return float 
     */
    public function getRankMiddleBottomBasic()
    {
        return $this->rankMiddleBottomBasic;
    }

    /**
     * Set rankMiddleBottomMixedTop
     *
     * @param float $rankMiddleBottomMixedTop
     * @return ArrangementRange
     */
    public function setRankMiddleBottomMixedTop($rankMiddleBottomMixedTop)
    {
        $this->rankMiddleBottomMixedTop = $rankMiddleBottomMixedTop;

        return $this;
    }

    /**
     * Get rankMiddleBottomMixedTop
     *
     * @return float 
     */
    public function getRankMiddleBottomMixedTop()
    {
        return $this->rankMiddleBottomMixedTop;
    }

    /**
     * Set rankMiddleBottomMixedBottom
     *
     * @param float $rankMiddleBottomMixedBottom
     * @return ArrangementRange
     */
    public function setRankMiddleBottomMixedBottom($rankMiddleBottomMixedBottom)
    {
        $this->rankMiddleBottomMixedBottom = $rankMiddleBottomMixedBottom;

        return $this;
    }

    /**
     * Get rankMiddleBottomMixedBottom
     *
     * @return float 
     */
    public function getRankMiddleBottomMixedBottom()
    {
        return $this->rankMiddleBottomMixedBottom;
    }

    /**
     * Set rankBottomBasic
     *
     * @param float $rankBottomBasic
     * @return ArrangementRange
     */
    public function setRankBottomBasic($rankBottomBasic)
    {
        $this->rankBottomBasic = $rankBottomBasic;

        return $this;
    }

    /**
     * Get rankBottomBasic
     *
     * @return float 
     */
    public function getRankBottomBasic()
    {
        return $this->rankBottomBasic;
    }

    /**
     * Set rankBottomMixedTop
     *
     * @param float $rankBottomMixedTop
     * @return ArrangementRange
     */
    public function setRankBottomMixedTop($rankBottomMixedTop)
    {
        $this->rankBottomMixedTop = $rankBottomMixedTop;

        return $this;
    }

    /**
     * Get rankBottomMixedTop
     *
     * @return float 
     */
    public function getRankBottomMixedTop()
    {
        return $this->rankBottomMixedTop;
    }

    /**
     * Set rankBottomMixedBottom
     *
     * @param float $rankBottomMixedBottom
     * @return ArrangementRange
     */
    public function setRankBottomMixedBottom($rankBottomMixedBottom)
    {
        $this->rankBottomMixedBottom = $rankBottomMixedBottom;

        return $this;
    }

    /**
     * Get rankBottomMixedBottom
     *
     * @return float 
     */
    public function getRankBottomMixedBottom()
    {
        return $this->rankBottomMixedBottom;
    }

    /**
     * Set opRankTopBasic
     *
     * @param \Pequiven\MasterBundle\Entity\Operator $opRankTopBasic
     * @return ArrangementRange
     */
    public function setOpRankTopBasic(\Pequiven\MasterBundle\Entity\Operator $opRankTopBasic = null)
    {
        $this->opRankTopBasic = $opRankTopBasic;

        return $this;
    }

    /**
     * Get opRankTopBasic
     *
     * @return \Pequiven\MasterBundle\Entity\Operator 
     */
    public function getOpRankTopBasic()
    {
        return $this->opRankTopBasic;
    }

    /**
     * Set opRankTopMixedTop
     *
     * @param \Pequiven\MasterBundle\Entity\Operator $opRankTopMixedTop
     * @return ArrangementRange
     */
    public function setOpRankTopMixedTop(\Pequiven\MasterBundle\Entity\Operator $opRankTopMixedTop = null)
    {
        $this->opRankTopMixedTop = $opRankTopMixedTop;

        return $this;
    }

    /**
     * Get opRankTopMixedTop
     *
     * @return \Pequiven\MasterBundle\Entity\Operator 
     */
    public function getOpRankTopMixedTop()
    {
        return $this->opRankTopMixedTop;
    }

    /**
     * Set opRankTopMixedBottom
     *
     * @param \Pequiven\MasterBundle\Entity\Operator $opRankTopMixedBottom
     * @return ArrangementRange
     */
    public function setOpRankTopMixedBottom(\Pequiven\MasterBundle\Entity\Operator $opRankTopMixedBottom = null)
    {
        $this->opRankTopMixedBottom = $opRankTopMixedBottom;

        return $this;
    }

    /**
     * Get opRankTopMixedBottom
     *
     * @return \Pequiven\MasterBundle\Entity\Operator 
     */
    public function getOpRankTopMixedBottom()
    {
        return $this->opRankTopMixedBottom;
    }

    /**
     * Set oprankMiddleTopBasic
     *
     * @param \Pequiven\MasterBundle\Entity\Operator $oprankMiddleTopBasic
     * @return ArrangementRange
     */
    public function setOprankMiddleTopBasic(\Pequiven\MasterBundle\Entity\Operator $oprankMiddleTopBasic = null)
    {
        $this->oprankMiddleTopBasic = $oprankMiddleTopBasic;

        return $this;
    }

    /**
     * Get oprankMiddleTopBasic
     *
     * @return \Pequiven\MasterBundle\Entity\Operator 
     */
    public function getOprankMiddleTopBasic()
    {
        return $this->oprankMiddleTopBasic;
    }

    /**
     * Set opRankMiddleTopMixedTop
     *
     * @param \Pequiven\MasterBundle\Entity\Operator $opRankMiddleTopMixedTop
     * @return ArrangementRange
     */
    public function setOpRankMiddleTopMixedTop(\Pequiven\MasterBundle\Entity\Operator $opRankMiddleTopMixedTop = null)
    {
        $this->opRankMiddleTopMixedTop = $opRankMiddleTopMixedTop;

        return $this;
    }

    /**
     * Get opRankMiddleTopMixedTop
     *
     * @return \Pequiven\MasterBundle\Entity\Operator 
     */
    public function getOpRankMiddleTopMixedTop()
    {
        return $this->opRankMiddleTopMixedTop;
    }

    /**
     * Set opRankMiddleTopMixedBottom
     *
     * @param \Pequiven\MasterBundle\Entity\Operator $opRankMiddleTopMixedBottom
     * @return ArrangementRange
     */
    public function setOpRankMiddleTopMixedBottom(\Pequiven\MasterBundle\Entity\Operator $opRankMiddleTopMixedBottom = null)
    {
        $this->opRankMiddleTopMixedBottom = $opRankMiddleTopMixedBottom;

        return $this;
    }

    /**
     * Get opRankMiddleTopMixedBottom
     *
     * @return \Pequiven\MasterBundle\Entity\Operator 
     */
    public function getOpRankMiddleTopMixedBottom()
    {
        return $this->opRankMiddleTopMixedBottom;
    }

    /**
     * Set oprankMiddleBottomBasic
     *
     * @param \Pequiven\MasterBundle\Entity\Operator $oprankMiddleBottomBasic
     * @return ArrangementRange
     */
    public function setOprankMiddleBottomBasic(\Pequiven\MasterBundle\Entity\Operator $oprankMiddleBottomBasic = null)
    {
        $this->oprankMiddleBottomBasic = $oprankMiddleBottomBasic;

        return $this;
    }

    /**
     * Get oprankMiddleBottomBasic
     *
     * @return \Pequiven\MasterBundle\Entity\Operator 
     */
    public function getOprankMiddleBottomBasic()
    {
        return $this->oprankMiddleBottomBasic;
    }

    /**
     * Set opRankMiddleBottomMixedTop
     *
     * @param \Pequiven\MasterBundle\Entity\Operator $opRankMiddleBottomMixedTop
     * @return ArrangementRange
     */
    public function setOpRankMiddleBottomMixedTop(\Pequiven\MasterBundle\Entity\Operator $opRankMiddleBottomMixedTop = null)
    {
        $this->opRankMiddleBottomMixedTop = $opRankMiddleBottomMixedTop;

        return $this;
    }

    /**
     * Get opRankMiddleBottomMixedTop
     *
     * @return \Pequiven\MasterBundle\Entity\Operator 
     */
    public function getOpRankMiddleBottomMixedTop()
    {
        return $this->opRankMiddleBottomMixedTop;
    }

    /**
     * Set opRankMiddleBottomMixedBottom
     *
     * @param \Pequiven\MasterBundle\Entity\Operator $opRankMiddleBottomMixedBottom
     * @return ArrangementRange
     */
    public function setOpRankMiddleBottomMixedBottom(\Pequiven\MasterBundle\Entity\Operator $opRankMiddleBottomMixedBottom = null)
    {
        $this->opRankMiddleBottomMixedBottom = $opRankMiddleBottomMixedBottom;

        return $this;
    }

    /**
     * Get opRankMiddleBottomMixedBottom
     *
     * @return \Pequiven\MasterBundle\Entity\Operator 
     */
    public function getOpRankMiddleBottomMixedBottom()
    {
        return $this->opRankMiddleBottomMixedBottom;
    }

    /**
     * Set oprankBottomBasic
     *
     * @param \Pequiven\MasterBundle\Entity\Operator $oprankBottomBasic
     * @return ArrangementRange
     */
    public function setOprankBottomBasic(\Pequiven\MasterBundle\Entity\Operator $oprankBottomBasic = null)
    {
        $this->oprankBottomBasic = $oprankBottomBasic;

        return $this;
    }

    /**
     * Get oprankBottomBasic
     *
     * @return \Pequiven\MasterBundle\Entity\Operator 
     */
    public function getOprankBottomBasic()
    {
        return $this->oprankBottomBasic;
    }

    /**
     * Set opRankBottomMixedTop
     *
     * @param \Pequiven\MasterBundle\Entity\Operator $opRankBottomMixedTop
     * @return ArrangementRange
     */
    public function setOpRankBottomMixedTop(\Pequiven\MasterBundle\Entity\Operator $opRankBottomMixedTop = null)
    {
        $this->opRankBottomMixedTop = $opRankBottomMixedTop;

        return $this;
    }

    /**
     * Get opRankBottomMixedTop
     *
     * @return \Pequiven\MasterBundle\Entity\Operator 
     */
    public function getOpRankBottomMixedTop()
    {
        return $this->opRankBottomMixedTop;
    }

    /**
     * Set opRankBottomMixedBottom
     *
     * @param \Pequiven\MasterBundle\Entity\Operator $opRankBottomMixedBottom
     * @return ArrangementRange
     */
    public function setOpRankBottomMixedBottom(\Pequiven\MasterBundle\Entity\Operator $opRankBottomMixedBottom = null)
    {
        $this->opRankBottomMixedBottom = $opRankBottomMixedBottom;

        return $this;
    }

    /**
     * Get opRankBottomMixedBottom
     *
     * @return \Pequiven\MasterBundle\Entity\Operator 
     */
    public function getOpRankBottomMixedBottom()
    {
        return $this->opRankBottomMixedBottom;
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
    
    function getDeletedAt() {
        return $this->deletedAt;
    }

    function setDeletedAt($deletedAt) {
        $this->deletedAt = $deletedAt;
        
        return $this;
    }
    
    function getPeriod() {
        return $this->period;
    }

    function setPeriod(\Pequiven\SEIPBundle\Entity\Period $period) {
        $this->period = $period;
        
        return $this;
    }
    
    public function __clone() {
        if($this->id){
            $this->id = null;
            $this->createdAt = null;
            $this->updatedAt = null;
            $this->userCreatedAt = null;
            $this->userUpdatedAt = null;
            
            $this->objetive = null;
            $this->indicator = null;
            
            $this->period = null;
        }
    }
    
    
    
    public function __toString() {
        return (string)$this->id;
    }
}
