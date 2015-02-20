<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\SEIPBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\SEIPBundle\Model\Monitor as baseMonitor;

/**
 * Monitor
 * 
 * @ORM\Table(name="seip_monitor")
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Repository\MonitorRepository")
 * @author matias
 */
class Monitor extends baseMonitor implements PeriodItemInterface
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
     * @var integer
     * 
     * @ORM\Column(name="objTacticOriginal", type="integer", nullable=true)
     */
    private $objTacticOriginal;
    
    /**
     * @var integer
     * 
     * @ORM\Column(name="objTacticOriginalReal", type="integer", nullable=true)
     */
    private $objTacticOriginalReal;
    
    /**
     * @var integer
     * 
     * @ORM\Column(name="objTacticVinculante", type="integer", nullable=true)
     */
    private $objTacticVinculante;
    
    /**
     * @var integer
     * 
     * @ORM\Column(name="objTacticVinculanteReal", type="integer", nullable=true)
     */
    private $objTacticVinculanteReal;
    
    /**
     * @var integer
     * 
     * @ORM\Column(name="indTacticOriginal", type="integer", nullable=true)
     */
    private $indTacticOriginal;
    
    /**
     * @var integer
     * 
     * @ORM\Column(name="indTacticOriginalReal", type="integer", nullable=true)
     */
    private $indTacticOriginalReal;
    
    /**
     * @var integer
     * 
     * @ORM\Column(name="indTacticVinculante", type="integer", nullable=true)
     */
    private $indTacticVinculante;
    
    /**
     * @var integer
     * 
     * @ORM\Column(name="indTacticVinculanteReal", type="integer", nullable=true)
     */
    private $indTacticVinculanteReal;
    
    /**
     * @var integer
     * 
     * @ORM\Column(name="objOperativeOriginal", type="integer", nullable=true)
     */
    private $objOperativeOriginal;
    
    /**
     * @var integer
     * 
     * @ORM\Column(name="objOperativeOriginalReal", type="integer", nullable=true)
     */
    private $objOperativeOriginalReal;
    
    /**
     * @var integer
     * 
     * @ORM\Column(name="objOperativeVinculante", type="integer", nullable=true)
     */
    private $objOperativeVinculante;
    
    /**
     * @var integer
     * 
     * @ORM\Column(name="objOperativeVinculanteReal", type="integer", nullable=true)
     */
    private $objOperativeVinculanteReal;
    
    /**
     * @var integer
     * 
     * @ORM\Column(name="indOperativeOriginal", type="integer", nullable=true)
     */
    private $indOperativeOriginal;
    
    /**
     * @var integer
     * 
     * @ORM\Column(name="indOperativeOriginalReal", type="integer", nullable=true)
     */
    private $indOperativeOriginalReal;
    
    /**
     * @var integer
     * 
     * @ORM\Column(name="indOperativeVinculante", type="integer", nullable=true)
     */
    private $indOperativeVinculante;
    
    /**
     * @var integer
     * 
     * @ORM\Column(name="indOperativeVinculanteReal", type="integer", nullable=true)
     */
    private $indOperativeVinculanteReal;
    
    /**
     * @var integer
     * 
     * @ORM\Column(name="arrangementProgramTactic", type="integer", nullable=true)
     */
    private $arrangementProgramTactic;
    
    /**
     * @var integer
     * 
     * @ORM\Column(name="arrangementProgramTacticReal", type="integer", nullable=true)
     */
    private $arrangementProgramTacticReal;
    
    /**
     * @var integer
     * 
     * @ORM\Column(name="arrangementProgramOperative", type="integer", nullable=true)
     */
    private $arrangementProgramOperative;
    
    /**
     * @var integer
     * 
     * @ORM\Column(name="arrangementProgramOperativeReal", type="integer", nullable=true)
     */
    private $arrangementProgramOperativeReal;
    
    /**
     * Gerencia
     * 
     * @var \Pequiven\MasterBundle\Entity\Gerencia
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Gerencia")
     * @ORM\JoinColumn(name="fk_gerencia", referencedColumnName="id")
     */
    private $gerencia;
    
    /**
     @var \Pequiven\MasterBundle\Entity\GerenciaGroup
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\GerenciaGroup")
     * @ORM\JoinColumn(name="fk_type_group", referencedColumnName="id")
     */
    private $typeGroup;

    /**
     * Periodo.
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
     * @return Monitor
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
     * @return Monitor
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
     * Set objTacticOriginal
     *
     * @param integer $objTacticOriginal
     * @return Monitor
     */
    public function setObjTacticOriginal($objTacticOriginal)
    {
        $this->objTacticOriginal = $objTacticOriginal;

        return $this;
    }

    /**
     * Get objTacticOriginal
     *
     * @return integer 
     */
    public function getObjTacticOriginal()
    {
        return $this->objTacticOriginal;
    }

    /**
     * Set objTacticOriginalReal
     *
     * @param integer $objTacticOriginalReal
     * @return Monitor
     */
    public function setObjTacticOriginalReal($objTacticOriginalReal)
    {
        $this->objTacticOriginalReal = $objTacticOriginalReal;

        return $this;
    }

    /**
     * Get objTacticOriginalReal
     *
     * @return integer 
     */
    public function getObjTacticOriginalReal()
    {
        return $this->objTacticOriginalReal;
    }

    /**
     * Set objTacticVinculante
     *
     * @param integer $objTacticVinculante
     * @return Monitor
     */
    public function setObjTacticVinculante($objTacticVinculante)
    {
        $this->objTacticVinculante = $objTacticVinculante;

        return $this;
    }

    /**
     * Get objTacticVinculante
     *
     * @return integer 
     */
    public function getObjTacticVinculante()
    {
        return $this->objTacticVinculante;
    }

    /**
     * Set objTacticVinculanteReal
     *
     * @param integer $objTacticVinculanteReal
     * @return Monitor
     */
    public function setObjTacticVinculanteReal($objTacticVinculanteReal)
    {
        $this->objTacticVinculanteReal = $objTacticVinculanteReal;

        return $this;
    }

    /**
     * Get objTacticVinculanteReal
     *
     * @return integer 
     */
    public function getObjTacticVinculanteReal()
    {
        return $this->objTacticVinculanteReal;
    }

    /**
     * Set indTacticOriginal
     *
     * @param integer $indTacticOriginal
     * @return Monitor
     */
    public function setIndTacticOriginal($indTacticOriginal)
    {
        $this->indTacticOriginal = $indTacticOriginal;

        return $this;
    }

    /**
     * Get indTacticOriginal
     *
     * @return integer 
     */
    public function getIndTacticOriginal()
    {
        return $this->indTacticOriginal;
    }

    /**
     * Set indTacticOriginalReal
     *
     * @param integer $indTacticOriginalReal
     * @return Monitor
     */
    public function setIndTacticOriginalReal($indTacticOriginalReal)
    {
        $this->indTacticOriginalReal = $indTacticOriginalReal;

        return $this;
    }

    /**
     * Get indTacticOriginalReal
     *
     * @return integer 
     */
    public function getIndTacticOriginalReal()
    {
        return $this->indTacticOriginalReal;
    }

    /**
     * Set indTacticVinculante
     *
     * @param integer $indTacticVinculante
     * @return Monitor
     */
    public function setIndTacticVinculante($indTacticVinculante)
    {
        $this->indTacticVinculante = $indTacticVinculante;

        return $this;
    }

    /**
     * Get indTacticVinculante
     *
     * @return integer 
     */
    public function getIndTacticVinculante()
    {
        return $this->indTacticVinculante;
    }

    /**
     * Set indTacticVinculanteReal
     *
     * @param integer $indTacticVinculanteReal
     * @return Monitor
     */
    public function setIndTacticVinculanteReal($indTacticVinculanteReal)
    {
        $this->indTacticVinculanteReal = $indTacticVinculanteReal;

        return $this;
    }

    /**
     * Get indTacticVinculanteReal
     *
     * @return integer 
     */
    public function getIndTacticVinculanteReal()
    {
        return $this->indTacticVinculanteReal;
    }

    /**
     * Set objOperativeOriginal
     *
     * @param integer $objOperativeOriginal
     * @return Monitor
     */
    public function setObjOperativeOriginal($objOperativeOriginal)
    {
        $this->objOperativeOriginal = $objOperativeOriginal;

        return $this;
    }

    /**
     * Get objOperativeOriginal
     *
     * @return integer 
     */
    public function getObjOperativeOriginal()
    {
        return $this->objOperativeOriginal;
    }

    /**
     * Set objOperativeOriginalReal
     *
     * @param integer $objOperativeOriginalReal
     * @return Monitor
     */
    public function setObjOperativeOriginalReal($objOperativeOriginalReal)
    {
        $this->objOperativeOriginalReal = $objOperativeOriginalReal;

        return $this;
    }

    /**
     * Get objOperativeOriginalReal
     *
     * @return integer 
     */
    public function getObjOperativeOriginalReal()
    {
        return $this->objOperativeOriginalReal;
    }

    /**
     * Set objOperativeVinculante
     *
     * @param integer $objOperativeVinculante
     * @return Monitor
     */
    public function setObjOperativeVinculante($objOperativeVinculante)
    {
        $this->objOperativeVinculante = $objOperativeVinculante;

        return $this;
    }

    /**
     * Get objOperativeVinculante
     *
     * @return integer 
     */
    public function getObjOperativeVinculante()
    {
        return $this->objOperativeVinculante;
    }

    /**
     * Set objOperativeVinculanteReal
     *
     * @param integer $objOperativeVinculanteReal
     * @return Monitor
     */
    public function setObjOperativeVinculanteReal($objOperativeVinculanteReal)
    {
        $this->objOperativeVinculanteReal = $objOperativeVinculanteReal;

        return $this;
    }

    /**
     * Get objOperativeVinculanteReal
     *
     * @return integer 
     */
    public function getObjOperativeVinculanteReal()
    {
        return $this->objOperativeVinculanteReal;
    }

    /**
     * Set indOperativeOriginal
     *
     * @param integer $indOperativeOriginal
     * @return Monitor
     */
    public function setIndOperativeOriginal($indOperativeOriginal)
    {
        $this->indOperativeOriginal = $indOperativeOriginal;

        return $this;
    }

    /**
     * Get indOperativeOriginal
     *
     * @return integer 
     */
    public function getIndOperativeOriginal()
    {
        return $this->indOperativeOriginal;
    }

    /**
     * Set indOperativeOriginalReal
     *
     * @param integer $indOperativeOriginalReal
     * @return Monitor
     */
    public function setIndOperativeOriginalReal($indOperativeOriginalReal)
    {
        $this->indOperativeOriginalReal = $indOperativeOriginalReal;

        return $this;
    }

    /**
     * Get indOperativeOriginalReal
     *
     * @return integer 
     */
    public function getIndOperativeOriginalReal()
    {
        return $this->indOperativeOriginalReal;
    }

    /**
     * Set indOperativeVinculante
     *
     * @param integer $indOperativeVinculante
     * @return Monitor
     */
    public function setIndOperativeVinculante($indOperativeVinculante)
    {
        $this->indOperativeVinculante = $indOperativeVinculante;

        return $this;
    }

    /**
     * Get indOperativeVinculante
     *
     * @return integer 
     */
    public function getIndOperativeVinculante()
    {
        return $this->indOperativeVinculante;
    }

    /**
     * Set indOperativeVinculanteReal
     *
     * @param integer $indOperativeVinculanteReal
     * @return Monitor
     */
    public function setIndOperativeVinculanteReal($indOperativeVinculanteReal)
    {
        $this->indOperativeVinculanteReal = $indOperativeVinculanteReal;

        return $this;
    }

    /**
     * Get indOperativeVinculanteReal
     *
     * @return integer 
     */
    public function getIndOperativeVinculanteReal()
    {
        return $this->indOperativeVinculanteReal;
    }

    /**
     * Set arrangementProgramTactic
     *
     * @param integer $arrangementProgramTactic
     * @return Monitor
     */
    public function setArrangementProgramTactic($arrangementProgramTactic)
    {
        $this->arrangementProgramTactic = $arrangementProgramTactic;

        return $this;
    }

    /**
     * Get arrangementProgramTactic
     *
     * @return integer 
     */
    public function getArrangementProgramTactic()
    {
        return $this->arrangementProgramTactic;
    }

    /**
     * Set arrangementProgramTacticReal
     *
     * @param integer $arrangementProgramTacticReal
     * @return Monitor
     */
    public function setArrangementProgramTacticReal($arrangementProgramTacticReal)
    {
        $this->arrangementProgramTacticReal = $arrangementProgramTacticReal;

        return $this;
    }

    /**
     * Get arrangementProgramTacticReal
     *
     * @return integer 
     */
    public function getArrangementProgramTacticReal()
    {
        return $this->arrangementProgramTacticReal;
    }

    /**
     * Set arrangementProgramOperative
     *
     * @param integer $arrangementProgramOperative
     * @return Monitor
     */
    public function setArrangementProgramOperative($arrangementProgramOperative)
    {
        $this->arrangementProgramOperative = $arrangementProgramOperative;

        return $this;
    }

    /**
     * Get arrangementProgramOperative
     *
     * @return integer 
     */
    public function getArrangementProgramOperative()
    {
        return $this->arrangementProgramOperative;
    }

    /**
     * Set arrangementProgramOperativeReal
     *
     * @param integer $arrangementProgramOperativeReal
     * @return Monitor
     */
    public function setArrangementProgramOperativeReal($arrangementProgramOperativeReal)
    {
        $this->arrangementProgramOperativeReal = $arrangementProgramOperativeReal;

        return $this;
    }

    /**
     * Get arrangementProgramOperativeReal
     *
     * @return integer 
     */
    public function getArrangementProgramOperativeReal()
    {
        return $this->arrangementProgramOperativeReal;
    }

    /**
     * Set gerencia
     *
     * @param \Pequiven\MasterBundle\Entity\Gerencia $gerencia
     * @return Monitor
     */
    public function setGerencia(\Pequiven\MasterBundle\Entity\Gerencia $gerencia = null)
    {
        $this->gerencia = $gerencia;

        return $this;
    }

    /**
     * Get gerencia
     *
     * @return \Pequiven\MasterBundle\Entity\Gerencia 
     */
    public function getGerencia()
    {
        return $this->gerencia;
    }


    /**
     * Set typeGroup
     *
     * @param \Pequiven\MasterBundle\Entity\GerenciaGroup $typeGroup
     * @return Monitor
     */
    public function setTypeGroup(\Pequiven\MasterBundle\Entity\GerenciaGroup $typeGroup = null)
    {
        $this->typeGroup = $typeGroup;

        return $this;
    }

    /**
     * Get typeGroup
     *
     * @return \Pequiven\MasterBundle\Entity\GerenciaGroup 
     */
    public function getTypeGroup()
    {
        return $this->typeGroup;
    }
    
    /**
     * Set period
     *
     * @param \Pequiven\SEIPBundle\Entity\Period $period
     * @return Monitor
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
