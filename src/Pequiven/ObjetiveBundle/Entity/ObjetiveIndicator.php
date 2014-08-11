<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\ObjetiveBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\ObjetiveBundle\Model\ObjetiveIndicator as modelObjetiveIndicator;

/**
 * Objetive
 * 
 * @ORM\Entity(repositoryClass="Pequiven\ObjetiveBundle\Repository\ObjetiveIndicatorRepository")
 * @ORM\Table(name="seip_objetive_indicator")
 * @author matias
 */
class ObjetiveIndicator extends modelObjetiveIndicator {
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set objetive
     *
     * @param \Pequiven\ObjetiveBundle\Entity\Objetive $objetive
     * @return ObjetiveIndicator
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
     * @return ObjetiveIndicator
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
}
