<?php

namespace Pequiven\ArrangementProgramBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Detalles de la meta
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Pequiven\ArrangementProgramBundle\Repository\GoalDetailsRepository")
 */
class GoalDetails
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
     * Planificado para enero
     * @var integer
     *
     * @ORM\Column(name="januaryPlanned", type="integer",nullable=true)
     */
    private $januaryPlanned;

    /**
     * Real de enero
     * @var integer
     *
     * @ORM\Column(name="januaryReal", type="integer",nullable=true)
     */
    private $januaryReal;

    /**
     * Planificado para febrero
     * @var integer
     *
     * @ORM\Column(name="februaryPlanned", type="integer",nullable=true)
     */
    private $februaryPlanned;

    /**
     * Real de febrero
     * @var integer
     *
     * @ORM\Column(name="februaryReal", type="integer",nullable=true)
     */
    private $februaryReal;

    /**
     * Planificado para marzo
     * @var integer
     *
     * @ORM\Column(name="marchPlanned", type="integer",nullable=true)
     */
    private $marchPlanned;

    /**
     * @var integer
     *
     * @ORM\Column(name="marchReal", type="integer",nullable=true)
     */
    private $marchReal;

    /**
     * Planificado para abril
     * @var integer
     *
     * @ORM\Column(name="aprilPlanned", type="integer",nullable=true)
     */
    private $aprilPlanned;

    /**
     * Real de abril
     * @var integer
     *
     * @ORM\Column(name="aprilReal", type="integer",nullable=true)
     */
    private $aprilReal;

    /**
     * Planificado para mayo
     * @var integer
     *
     * @ORM\Column(name="mayPlanned", type="integer",nullable=true)
     */
    private $mayPlanned;

    /**
     * Real de mayo
     * @var integer
     *
     * @ORM\Column(name="mayReal", type="integer",nullable=true)
     */
    private $mayReal;

    /**
     * Planificado para junio
     * @var integer
     *
     * @ORM\Column(name="junePlanned", type="integer",nullable=true)
     */
    private $junePlanned;

    /**
     * Real de junio
     * @var integer
     *
     * @ORM\Column(name="juneReal", type="integer",nullable=true)
     */
    private $juneReal;

    /**
     * Planificado para julio
     * @var integer
     *
     * @ORM\Column(name="julyPlanned", type="integer",nullable=true)
     */
    private $julyPlanned;

    /**
     * Real de julio
     * @var integer
     *
     * @ORM\Column(name="julyReal", type="integer",nullable=true)
     */
    private $julyReal;

    /**
     * Planificado para agosto
     * @var integer
     *
     * @ORM\Column(name="augustPlanned", type="integer",nullable=true)
     */
    private $augustPlanned;

    /**
     * Real de agosto
     * @var integer
     *
     * @ORM\Column(name="augustReal", type="integer",nullable=true)
     */
    private $augustReal;

    /**
     * Planificado para septiembre
     * @var integer
     *
     * @ORM\Column(name="septemberPlanned", type="integer",nullable=true)
     */
    private $septemberPlanned;

    /**
     * Real de septiembre
     * @var integer
     *
     * @ORM\Column(name="septemberReal", type="integer",nullable=true)
     */
    private $septemberReal;

    /**
     * Planificado para octubre
     * @var integer
     *
     * @ORM\Column(name="octoberPlanned", type="integer",nullable=true)
     */
    private $octoberPlanned;

    /**
     * Real de octubre
     * @var integer
     *
     * @ORM\Column(name="octoberReal", type="integer",nullable=true)
     */
    private $octoberReal;

    /**
     * Planificado para noviembre
     * @var integer
     *
     * @ORM\Column(name="novemberPlanned", type="integer",nullable=true)
     */
    private $novemberPlanned;

    /**
     * Real de noviembre
     * @var integer
     *
     * @ORM\Column(name="novemberReal", type="integer",nullable=true)
     */
    private $novemberReal;

    /**
     * Planificado para diciembre
     * @var integer
     *
     * @ORM\Column(name="decemberPlanned", type="integer",nullable=true)
     */
    private $decemberPlanned;

    /**
     * Real de diciembre
     * @var integer
     *
     * @ORM\Column(name="decemberReal", type="integer",nullable=true)
     */
    private $decemberReal;

    /**
     * Estatus
     * @var integer
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status = 0;
    
    /**
     * Meta
     * 
     * @var \Pequiven\ArrangementProgramBundle\Entity\Goal
     * @ORM\OneToOne(targetEntity="Pequiven\ArrangementProgramBundle\Entity\Goal",mappedBy="goalDetails")
     */
    private $goal;

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
     * Set januaryPlanned
     *
     * @param integer $januaryPlanned
     * @return GoalDetails
     */
    public function setJanuaryPlanned($januaryPlanned)
    {
        $this->januaryPlanned = $januaryPlanned;

        return $this;
    }

    /**
     * Get januaryPlanned
     *
     * @return integer 
     */
    public function getJanuaryPlanned()
    {
        return $this->januaryPlanned;
    }

    /**
     * Set januaryReal
     *
     * @param integer $januaryReal
     * @return GoalDetails
     */
    public function setJanuaryReal($januaryReal)
    {
        $this->januaryReal = $januaryReal;

        return $this;
    }

    /**
     * Get januaryReal
     *
     * @return integer 
     */
    public function getJanuaryReal()
    {
        return $this->januaryReal;
    }

    /**
     * Set februaryPlanned
     *
     * @param integer $februaryPlanned
     * @return GoalDetails
     */
    public function setFebruaryPlanned($februaryPlanned)
    {
        $this->februaryPlanned = $februaryPlanned;

        return $this;
    }

    /**
     * Get februaryPlanned
     *
     * @return integer 
     */
    public function getFebruaryPlanned()
    {
        return $this->februaryPlanned;
    }

    /**
     * Set februaryReal
     *
     * @param integer $februaryReal
     * @return GoalDetails
     */
    public function setFebruaryReal($februaryReal)
    {
        $this->februaryReal = $februaryReal;

        return $this;
    }

    /**
     * Get februaryReal
     *
     * @return integer 
     */
    public function getFebruaryReal()
    {
        return $this->februaryReal;
    }

    /**
     * Set marchPlanned
     *
     * @param integer $marchPlanned
     * @return GoalDetails
     */
    public function setMarchPlanned($marchPlanned)
    {
        $this->marchPlanned = $marchPlanned;

        return $this;
    }

    /**
     * Get marchPlanned
     *
     * @return integer 
     */
    public function getMarchPlanned()
    {
        return $this->marchPlanned;
    }

    /**
     * Set marchReal
     *
     * @param integer $marchReal
     * @return GoalDetails
     */
    public function setMarchReal($marchReal)
    {
        $this->marchReal = $marchReal;

        return $this;
    }

    /**
     * Get marchReal
     *
     * @return integer 
     */
    public function getMarchReal()
    {
        return $this->marchReal;
    }

    /**
     * Set aprilPlanned
     *
     * @param integer $aprilPlanned
     * @return GoalDetails
     */
    public function setAprilPlanned($aprilPlanned)
    {
        $this->aprilPlanned = $aprilPlanned;

        return $this;
    }

    /**
     * Get aprilPlanned
     *
     * @return integer 
     */
    public function getAprilPlanned()
    {
        return $this->aprilPlanned;
    }

    /**
     * Set aprilReal
     *
     * @param integer $aprilReal
     * @return GoalDetails
     */
    public function setAprilReal($aprilReal)
    {
        $this->aprilReal = $aprilReal;

        return $this;
    }

    /**
     * Get aprilReal
     *
     * @return integer 
     */
    public function getAprilReal()
    {
        return $this->aprilReal;
    }

    /**
     * Set mayPlanned
     *
     * @param integer $mayPlanned
     * @return GoalDetails
     */
    public function setMayPlanned($mayPlanned)
    {
        $this->mayPlanned = $mayPlanned;

        return $this;
    }

    /**
     * Get mayPlanned
     *
     * @return integer 
     */
    public function getMayPlanned()
    {
        return $this->mayPlanned;
    }

    /**
     * Set mayReal
     *
     * @param integer $mayReal
     * @return GoalDetails
     */
    public function setMayReal($mayReal)
    {
        $this->mayReal = $mayReal;

        return $this;
    }

    /**
     * Get mayReal
     *
     * @return integer 
     */
    public function getMayReal()
    {
        return $this->mayReal;
    }

    /**
     * Set junePlanned
     *
     * @param integer $junePlanned
     * @return GoalDetails
     */
    public function setJunePlanned($junePlanned)
    {
        $this->junePlanned = $junePlanned;

        return $this;
    }

    /**
     * Get junePlanned
     *
     * @return integer 
     */
    public function getJunePlanned()
    {
        return $this->junePlanned;
    }

    /**
     * Set juneReal
     *
     * @param integer $juneReal
     * @return GoalDetails
     */
    public function setJuneReal($juneReal)
    {
        $this->juneReal = $juneReal;

        return $this;
    }

    /**
     * Get juneReal
     *
     * @return integer 
     */
    public function getJuneReal()
    {
        return $this->juneReal;
    }

    /**
     * Set julyPlanned
     *
     * @param integer $julyPlanned
     * @return GoalDetails
     */
    public function setJulyPlanned($julyPlanned)
    {
        $this->julyPlanned = $julyPlanned;

        return $this;
    }

    /**
     * Get julyPlanned
     *
     * @return integer 
     */
    public function getJulyPlanned()
    {
        return $this->julyPlanned;
    }

    /**
     * Set julyReal
     *
     * @param integer $julyReal
     * @return GoalDetails
     */
    public function setJulyReal($julyReal)
    {
        $this->julyReal = $julyReal;

        return $this;
    }

    /**
     * Get julyReal
     *
     * @return integer 
     */
    public function getJulyReal()
    {
        return $this->julyReal;
    }

    /**
     * Set augustPlanned
     *
     * @param integer $augustPlanned
     * @return GoalDetails
     */
    public function setAugustPlanned($augustPlanned)
    {
        $this->augustPlanned = $augustPlanned;

        return $this;
    }

    /**
     * Get augustPlanned
     *
     * @return integer 
     */
    public function getAugustPlanned()
    {
        return $this->augustPlanned;
    }

    /**
     * Set augustReal
     *
     * @param integer $augustReal
     * @return GoalDetails
     */
    public function setAugustReal($augustReal)
    {
        $this->augustReal = $augustReal;

        return $this;
    }

    /**
     * Get augustReal
     *
     * @return integer 
     */
    public function getAugustReal()
    {
        return $this->augustReal;
    }

    /**
     * Set septemberPlanned
     *
     * @param integer $septemberPlanned
     * @return GoalDetails
     */
    public function setSeptemberPlanned($septemberPlanned)
    {
        $this->septemberPlanned = $septemberPlanned;

        return $this;
    }

    /**
     * Get septemberPlanned
     *
     * @return integer 
     */
    public function getSeptemberPlanned()
    {
        return $this->septemberPlanned;
    }

    /**
     * Set septemberReal
     *
     * @param integer $septemberReal
     * @return GoalDetails
     */
    public function setSeptemberReal($septemberReal)
    {
        $this->septemberReal = $septemberReal;

        return $this;
    }

    /**
     * Get septemberReal
     *
     * @return integer 
     */
    public function getSeptemberReal()
    {
        return $this->septemberReal;
    }

    /**
     * Set octoberPlanned
     *
     * @param integer $octoberPlanned
     * @return GoalDetails
     */
    public function setOctoberPlanned($octoberPlanned)
    {
        $this->octoberPlanned = $octoberPlanned;

        return $this;
    }

    /**
     * Get octoberPlanned
     *
     * @return integer 
     */
    public function getOctoberPlanned()
    {
        return $this->octoberPlanned;
    }

    /**
     * Set octoberReal
     *
     * @param integer $octoberReal
     * @return GoalDetails
     */
    public function setOctoberReal($octoberReal)
    {
        $this->octoberReal = $octoberReal;

        return $this;
    }

    /**
     * Get octoberReal
     *
     * @return integer 
     */
    public function getOctoberReal()
    {
        return $this->octoberReal;
    }

    /**
     * Set novemberPlanned
     *
     * @param integer $novemberPlanned
     * @return GoalDetails
     */
    public function setNovemberPlanned($novemberPlanned)
    {
        $this->novemberPlanned = $novemberPlanned;

        return $this;
    }

    /**
     * Get novemberPlanned
     *
     * @return integer 
     */
    public function getNovemberPlanned()
    {
        return $this->novemberPlanned;
    }

    /**
     * Set novemberReal
     *
     * @param integer $novemberReal
     * @return GoalDetails
     */
    public function setNovemberReal($novemberReal)
    {
        $this->novemberReal = $novemberReal;

        return $this;
    }

    /**
     * Get novemberReal
     *
     * @return integer 
     */
    public function getNovemberReal()
    {
        return $this->novemberReal;
    }

    /**
     * Set decemberPlanned
     *
     * @param integer $decemberPlanned
     * @return GoalDetails
     */
    public function setDecemberPlanned($decemberPlanned)
    {
        $this->decemberPlanned = $decemberPlanned;

        return $this;
    }

    /**
     * Get decemberPlanned
     *
     * @return integer 
     */
    public function getDecemberPlanned()
    {
        return $this->decemberPlanned;
    }

    /**
     * Set decemberReal
     *
     * @param integer $decemberReal
     * @return GoalDetails
     */
    public function setDecemberReal($decemberReal)
    {
        $this->decemberReal = $decemberReal;

        return $this;
    }

    /**
     * Get decemberReal
     *
     * @return integer 
     */
    public function getDecemberReal()
    {
        return $this->decemberReal;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return GoalDetails
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set goal
     *
     * @param \Pequiven\ArrangementProgramBundle\Entity\Goal $goal
     * @return GoalDetails
     */
    public function setGoal(\Pequiven\ArrangementProgramBundle\Entity\Goal $goal = null)
    {
        $this->goal = $goal;

        return $this;
    }

    /**
     * Get goal
     *
     * @return \Pequiven\ArrangementProgramBundle\Entity\Goal 
     */
    public function getGoal()
    {
        return $this->goal;
    }
}
