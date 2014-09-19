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
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled = true;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="tmp", type="boolean")
     */
    private $tmp = false;
    
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
     * Tendency
     * @var \Pequiven\MasterBundle\Entity\Tendency
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Tendency")
     * @ORM\JoinColumn(name="fk_tendency", referencedColumnName="id")
     */
    private $tendency;
    
    /**
     * @ORM\ManyToMany(targetEntity="\Pequiven\ObjetiveBundle\Entity\Objetive", mappedBy="indicators")
     */
    private $objetives;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->objetives = new \Doctrine\Common\Collections\ArrayCollection();
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
    
    /**
     * Devuelve el valor referencial del indicador
     * <b> x.x Estratégico </b>
     * <b> x.x.x Táctico </b>
     * <b> x.x.x.x Operativo </b>
     * @param type $options
     * @return boolean
     */
    public function setNewRef($options = array()) {
        $container = \Pequiven\IndicatorBundle\PequivenIndicatorBundle::getContainer();
        $securityContext = $container->get('security.context');
        $em = $container->get('doctrine')->getManager();
        
        if ($options['type'] == 'STRATEGIC') {
            $lineStrategic = $em->getRepository('PequivenMasterBundle:LineStrategic')->findOneBy(array('id' => $options['lineStrategicId']));
            $results = $em->getRepository('PequivenIndicatorBundle:Indicator')->getByOptionRef($options);
            $refLineStrategic = 'IE-'.$lineStrategic->getRef();
            $total = count($results);
            if (is_array($results) && $total > 0) {
                $ref = $refLineStrategic . ($total + 1) . '.';
            } else {
                $ref = $refLineStrategic . '1.';
            }
        } elseif($options['type'] == 'TACTIC'){
            $lineStrategic = $em->getRepository('PequivenMasterBundle:LineStrategic')->findOneBy(array('id' => $options['lineStrategicId']));
            $results = $em->getRepository('PequivenIndicatorBundle:Indicator')->getByOptionRef($options);
            $refLineStrategic = 'IT-'.$lineStrategic->getRef();
            $total = count($results);
            if (is_array($results) && $total > 0) {
                $ref = $refLineStrategic . ($total + 1) . '.';
            } else {
                $ref = $refLineStrategic . '1.';
            }
        } elseif($options['type'] == 'OPERATIVE'){
            $lineStrategic = $em->getRepository('PequivenMasterBundle:LineStrategic')->findOneBy(array('id' => $options['lineStrategicId']));
            $results = $em->getRepository('PequivenIndicatorBundle:Indicator')->getByOptionRef($options);
            $refLineStrategic = 'IO-'.$lineStrategic->getRef();
            $total = count($results);
            if (is_array($results) && $total > 0) {
                $ref = $refLineStrategic . ($total + 1) . '.';
            } else {
                $ref = $refLineStrategic . '1.';
            }
        } 
        
        return $ref;
    }
    
    /**
     * Devuelve el valor de referencia del indicador creado a partir del formulario de objetivo
     * <b> x.x Estratégico </b>
     * <b> x.x.x Táctico </b>
     * <b> x.x.x.x Operativo </b>
     * @param type $options
     * @return boolean
     */
    public function setNewRefFromObjetive($options = array()){
        $container = \Pequiven\IndicatorBundle\PequivenIndicatorBundle::getContainer();
        $securityContext = $container->get('security.context');
        $em = $container->get('doctrine')->getManager();
        
        if ($options['type'] == 'STRATEGIC') {
            $results = $em->getRepository('PequivenIndicatorBundle:Indicator')->getByOptionRefParent($options);
            $refIndicator = 'IE-'.$options['refParent'];
            $total = count($results);
            if (is_array($results) && $total > 0) {
                $ref = $refIndicator . ($total + 1) . '.';
            } else {
                $ref = $refIndicator . '1.';
            }
        } elseif($options['type'] == 'TACTIC'){
            $results = $em->getRepository('PequivenIndicatorBundle:Indicator')->getByOptionRefParent($options);
            $refIndicator = 'IT-'.$options['refParent'];
            $total = count($results);
            if (is_array($results) && $total > 0) {
                $ref = $refIndicator . ($total + 1) . '.';
            } else {
                $ref = $refIndicator . '1.';
            }
        } elseif($options['type'] == 'OPERATIVE'){
            $results = $em->getRepository('PequivenIndicatorBundle:Indicator')->getByOptionRefParent($options);
            $refIndicator = 'IO-'.$options['refParent'];
            $total = count($results);
            if (is_array($results) && $total > 0) {
                $ref = $refIndicator . ($total + 1) . '.';
            } else {
                $ref = $refIndicator . '1.';
            }
        }
        
        return $ref;
    }

    /**
     * Set tendency
     *
     * @param \Pequiven\MasterBundle\Entity\Tendency $tendency
     * @return Indicator
     */
    public function setTendency(\Pequiven\MasterBundle\Entity\Tendency $tendency = null)
    {
        $this->tendency = $tendency;

        return $this;
    }

    /**
     * Get tendency
     *
     * @return \Pequiven\MasterBundle\Entity\Tendency 
     */
    public function getTendency()
    {
        return $this->tendency;
    }

    /**
     * Set tmp
     *
     * @param boolean $tmp
     * @return Indicator
     */
    public function setTmp($tmp)
    {
        $this->tmp = $tmp;

        return $this;
    }

    /**
     * Get tmp
     *
     * @return boolean 
     */
    public function getTmp()
    {
        return $this->tmp;
    }

    /**
     * Set refParent
     *
     * @param string $refParent
     * @return Indicator
     */
//    public function setRefParent($refParent)
//    {
//        $this->refParent = $refParent;
//
//        return $this;
//    }

    /**
     * Get refParent
     *
     * @return string 
     */
//    public function getRefParent()
//    {
//        return $this->refParent;
//    }

    /**
     * Add objetives
     *
     * @param \Pequiven\ObjetiveBundle\Entity\Objetive $objetives
     * @return Indicator
     */
    public function addObjetive(\Pequiven\ObjetiveBundle\Entity\Objetive $objetives)
    {
        $this->objetives->add($objetives);

        return $this;
    }

    /**
     * Remove objetives
     *
     * @param \Pequiven\ObjetiveBundle\Entity\Objetive $objetives
     */
    public function removeObjetive(\Pequiven\ObjetiveBundle\Entity\Objetive $objetives)
    {
        $this->objetives->removeElement($objetives);
    }

    /**
     * Get objetives
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getObjetives()
    {
        return $this->objetives;
    }
    

    /**
     * Set arrangementRange
     *
     * @param \Pequiven\ArrangementBundle\Entity\ArrangementRange $arrangementRange
     * @return Indicator
     */
    public function setArrangementRange(\Pequiven\ArrangementBundle\Entity\ArrangementRange $arrangementRange = null)
    {
        $this->arrangementRange = $arrangementRange;

        return $this;
    }

    /**
     * Get arrangementRange
     *
     * @return \Pequiven\ArrangementBundle\Entity\ArrangementRange 
     */
    public function getArrangementRange()
    {
        return $this->arrangementRange;
    }
    
    public function resetObjetives(){
        $this->objetives = new \Doctrine\Common\Collections\ArrayCollection();
    }
}
