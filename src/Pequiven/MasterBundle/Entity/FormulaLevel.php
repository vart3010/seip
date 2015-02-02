<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\MasterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\MasterBundle\Model\FormulaLevel as modelFormulaLevel;

/**
 * FormulaLevel
 * @ORM\Table(name="seip_formula_level")
 * @ORM\Entity(repositoryClass="Pequiven\MasterBundle\Repository\FormulaLevelRepository")
 * @author matias
 */
class FormulaLevel extends modelFormulaLevel implements \Pequiven\SEIPBundle\Entity\PeriodItemInterface
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
     * @ORM\Column(name="description", type="string", length=100)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="level_name", type="string", length=50)
     */
    private $levelName;

    /**
     * @var integer
     *
     * @ORM\Column(name="level", type="integer")
     */
    private $level;
    

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;
    
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
     * @return IndicatorLevel
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
     * @return IndicatorLevel
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
     * @return IndicatorLevel
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
     * Set levelName
     *
     * @param string $levelName
     * @return IndicatorLevel
     */
    public function setLevelName($levelName)
    {
        $this->levelName = $levelName;

        return $this;
    }

    /**
     * Get levelName
     *
     * @return string 
     */
    public function getLevelName()
    {
        return $this->levelName;
    }

    /**
     * Set level
     *
     * @param integer $level
     * @return IndicatorLevel
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer 
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return IndicatorLevel
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
     * @return IndicatorLevel
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
     * @return IndicatorLevel
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
    
    public function __toString()
    {
        return $this->getDescription()?: '-';
    }
    
    function getPeriod() {
        return $this->period;
    }

    function setPeriod(\Pequiven\SEIPBundle\Entity\Period $period) {
        $this->period = $period;
        
        return $this;
    }
    
    public function __clone() {
        if($this->id > 0){
            $this->id = 0;
            $this->createdAt = null;
            $this->updatedAt = null;
            $this->userCreatedAt = null;
            $this->userUpdatedAt = null;
            $this->period = null;
        }
    }
}
