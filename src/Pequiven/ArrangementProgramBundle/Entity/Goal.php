<?php

namespace Pequiven\ArrangementProgramBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Tpg\ExtjsBundle\Annotation as Extjs;

/**
 * Meta
 * @Extjs\Model
 * @Extjs\ModelProxy("/api/goals")
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Pequiven\ArrangementProgramBundle\Repository\GoalRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Goal
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
     * @ORM\Column(name="name", type="string", length=255)
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
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(name="user_responsible_id")
     */
    private $responsible;

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
     * @ORM\OneToOne(targetEntity="Pequiven\ArrangementProgramBundle\Entity\GoalDetails",inversedBy="goal",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $goalDetails;

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
     * Set responsible
     *
     * @param integer $responsible
     * @return Goal
     */
    public function setResponsible($responsible)
    {
        $this->responsible = $responsible;

        return $this;
    }

    /**
     * Get responsible
     *
     * @return integer 
     */
    public function getResponsible()
    {
        return $this->responsible;
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
        $this->goalDetails = new GoalDetails();
    }
}
