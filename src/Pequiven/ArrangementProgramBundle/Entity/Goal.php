<?php

namespace Pequiven\ArrangementProgramBundle\Entity;

const GOAL_TYPE_FORM = 'full';
const GOAL_TYPE_TEMPLATE = 'template';

use Doctrine\ORM\Mapping as ORM;
use Tpg\ExtjsBundle\Annotation as Extjs;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Meta
 * @Extjs\Model
 * @Extjs\ModelProxy("/api/goals")
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Pequiven\ArrangementProgramBundle\Repository\GoalRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Goal implements \Pequiven\SEIPBundle\Entity\PeriodItemInterface
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
     * Nombre
     * @var string
     *
     * @ORM\Column(name="name", type="text")
     */
    private $name;

    /**
     * Tipo de meta
     * @var \Pequiven\MasterBundle\Entity\ArrangementProgram\TypeGoal
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\MasterBundle\Entity\ArrangementProgram\TypeGoal")
     */
    private $typeGoal;

    /**
     * Fecha de inicio
     * @var \DateTime
     *
     * @ORM\Column(name="startDate", type="datetime")
     */
    private $startDate;

    /**
     * Fecha fin
     * @var \DateTime
     *
     * @ORM\Column(name="endDate", type="datetime")
     */
    private $endDate;

    /**
     * Responsables
     * @var \Pequiven\SEIPBundle\Entity\User
     *
     * @ORM\ManyToMany(targetEntity="Pequiven\SEIPBundle\Entity\User",inversedBy="goals")
     * @ORM\JoinTable(name="goals_users")
     */
    private $responsibles;

    /**
     * Peso
     * @var integer
     *
     * @ORM\Column(name="weight", type="integer")
     */
    private $weight;

    /**
     * Observaciones
     * @var string
     *
     * @ORM\Column(name="observations", type="text",nullable=true)
     */
    private $observations;

    /**
     * Estatus
     * @var integer
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status = 0;
    
    /**
     * Linea de tiempo
     * @var \Pequiven\ArrangementProgramBundle\Entity\Timeline
     * @ORM\ManyToOne(targetEntity="Pequiven\ArrangementProgramBundle\Entity\Timeline",inversedBy="goals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $timeline;
    
    /**
     * Detalles de la meta
     * 
     * @var \Pequiven\ArrangementProgramBundle\Entity\GoalDetails
     * @ORM\OneToOne(targetEntity="Pequiven\ArrangementProgramBundle\Entity\GoalDetails",inversedBy="goal",cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $goalDetails;
    
    /**
     * Periodo.
     * @var \Pequiven\SEIPBundle\Entity\Period
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Period")
     * @ORM\JoinColumn(nullable=false)
     */
    private $period;
    
    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;
    
    public function __construct() {
        $this->responsibles = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Goal
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     * @return Goal
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime 
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     * @return Goal
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime 
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set weight
     *
     * @param integer $weight
     * @return Goal
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return integer 
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set observations
     *
     * @param string $observations
     * @return Goal
     */
    public function setObservations($observations)
    {
        $this->observations = $observations;

        return $this;
    }

    /**
     * Get observations
     *
     * @return string 
     */
    public function getObservations()
    {
        return $this->observations;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Goal
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
     * Set typeGoal
     *
     * @param \Pequiven\MasterBundle\Entity\ArrangementProgram\TypeGoal $typeGoal
     * @return Goal
     */
    public function setTypeGoal(\Pequiven\MasterBundle\Entity\ArrangementProgram\TypeGoal $typeGoal = null)
    {
        $this->typeGoal = $typeGoal;

        return $this;
    }

    /**
     * Get typeGoal
     *
     * @return \Pequiven\MasterBundle\Entity\ArrangementProgram\TypeGoal 
     */
    public function getTypeGoal()
    {
        return $this->typeGoal;
    }

    /**
     * Set timeline
     *
     * @param \Pequiven\ArrangementProgramBundle\Entity\Timeline $timeline
     * @return Goal
     */
    public function setTimeline(\Pequiven\ArrangementProgramBundle\Entity\Timeline $timeline = null)
    {
        $this->timeline = $timeline;

        return $this;
    }

    /**
     * Get timeline
     *
     * @return \Pequiven\ArrangementProgramBundle\Entity\Timeline 
     */
    public function getTimeline()
    {
        return $this->timeline;
    }

    /**
     * Set goalDetails
     *
     * @param \Pequiven\ArrangementProgramBundle\Entity\GoalDetails $goalDetails
     * @return Goal
     */
    public function setGoalDetails(\Pequiven\ArrangementProgramBundle\Entity\GoalDetails $goalDetails = null)
    {
        $goalDetails->setGoal($this);
        $this->goalDetails = $goalDetails;

        return $this;
    }

    /**
     * Get goalDetails
     *
     * @return \Pequiven\ArrangementProgramBundle\Entity\GoalDetails 
     */
    public function getGoalDetails()
    {
        return $this->goalDetails;
    }
    
    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
        if($this->goalDetails == null){
            $this->goalDetails = new GoalDetails();
        }
    }

    /**
     * Add responsibles
     *
     * @param \Pequiven\SEIPBundle\Entity\User $responsibles
     * @return Goal
     */
    public function addResponsible(\Pequiven\SEIPBundle\Entity\User $responsible)
    {
        $responsible->addGoal($this); 
        $this->responsibles->add($responsible);

        return $this;
    }

    /**
     * Remove responsibles
     *
     * @param \Pequiven\SEIPBundle\Entity\User $responsibles
     */
    public function removeResponsible(\Pequiven\SEIPBundle\Entity\User $responsibles)
    {
        $this->responsibles->removeElement($responsibles);
    }

    /**
     * Get responsibles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getResponsibles()
    {
        return $this->responsibles;
    }
    
    public function __toString() 
    {
        return $this->getName()?:'-';
    }
    
    /**
     * Set period
     *
     * @param \Pequiven\SEIPBundle\Entity\Period $period
     * @return ArrangementProgram
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
    
    function getDeletedAt() {
        return $this->deletedAt;
    }

    function setDeletedAt($deletedAt) {
        $this->deletedAt = $deletedAt;
        
        return $this;
    }
    
    public function __clone() {
        if($this->id > 0){
           $this->id = null;
           
           $this->goalDetails = clone($this->goalDetails);
           $this->goalDetails->setGoal($this);
        }
    }
}
