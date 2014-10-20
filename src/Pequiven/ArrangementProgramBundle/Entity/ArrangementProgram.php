<?php

namespace Pequiven\ArrangementProgramBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\ArrangementProgramBundle\Model\ArrangementProgram as Model;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Programa de gestion
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Pequiven\ArrangementProgramBundle\Repository\ArrangementProgramRepository")
 */
class ArrangementProgram extends Model
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
     * Referencia del programa de gestion
     * @var string
     * @ORM\Column(name="ref",type="string",length=100)
     */
    private $ref = 'TEMP';

    /**
     * Periodo.
     * @var \Pequiven\SEIPBundle\Entity\Period
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Period")
     * @ORM\JoinColumn(nullable=false)
     */
    private $period;
    
    /**
     * Programa de gestión asociada.
     * @var \Pequiven\MasterBundle\Entity\ArrangementProgram\CategoryArrangementProgram
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\MasterBundle\Entity\ArrangementProgram\CategoryArrangementProgram")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categoryArrangementProgram;

    /**
     * Objetivo táctico
     * @var \Pequiven\ObjetiveBundle\Entity\Objetive
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\ObjetiveBundle\Entity\Objetive")
     * @ORM\JoinColumn(name="tactical_objective_id")
     */
    private $tacticalObjective;

    /**
     * Objetivo operativo.
     * @var \Pequiven\ObjetiveBundle\Entity\Objetive
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\ObjetiveBundle\Entity\Objetive")
     * @ORM\JoinColumn(name="operational_objective_id")
     */
    private $operationalObjective;

    /**
     * Proceso
     * @var string
     *
     * @ORM\Column(name="process", type="string", length=255)
     */
    private $process;

    /**
     * Creado por
     * @var \Pequiven\SEIPBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $createdBy;
    
    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updatedAt", type="datetime")
     */
    private $updatedAt;
    
    /**
     * Detalles del programa de gestion
     * 
     * @var \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram\Details
     * @ORM\OneToOne(targetEntity="Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram\Details",cascade={"persist","remove"})
     * @ORM\Joincolumn(nullable=false)
     */
    protected $details;
    
    /**
     * Historiales 
     * 
     * @var \Pequiven\SEIPBundle\Entity\Historical
     * @ORM\ManyToMany(targetEntity="Pequiven\SEIPBundle\Entity\Historical",cascade={"persist","remove"})
     */
    protected $histories;

    public function __construct() {
        $this->responsibles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->histories = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set process
     *
     * @param string $process
     * @return ArrangementProgram
     */
    public function setProcess($process)
    {
        $this->process = $process;

        return $this;
    }

    /**
     * Get process
     *
     * @return string 
     */
    public function getProcess()
    {
        return $this->process;
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

    /**
     * Set categoryArrangementProgram
     *
     * @param \Pequiven\MasterBundle\Entity\ArrangementProgram\CategoryArrangementProgram $categoryArrangementProgram
     * @return ArrangementProgram
     */
    public function setCategoryArrangementProgram(\Pequiven\MasterBundle\Entity\ArrangementProgram\CategoryArrangementProgram $categoryArrangementProgram = null)
    {
        $this->categoryArrangementProgram = $categoryArrangementProgram;

        return $this;
    }

    /**
     * Get categoryArrangementProgram
     *
     * @return \Pequiven\MasterBundle\Entity\ArrangementProgram\CategoryArrangementProgram 
     */
    public function getCategoryArrangementProgram()
    {
        return $this->categoryArrangementProgram;
    }

    /**
     * Set tacticalObjective
     *
     * @param \Pequiven\ObjetiveBundle\Entity\Objetive $tacticalObjective
     * @return ArrangementProgram
     */
    public function setTacticalObjective(\Pequiven\ObjetiveBundle\Entity\Objetive $tacticalObjective = null)
    {
        $this->tacticalObjective = $tacticalObjective;

        return $this;
    }

    /**
     * Get tacticalObjective
     *
     * @return \Pequiven\ObjetiveBundle\Entity\Objetive 
     */
    public function getTacticalObjective()
    {
        return $this->tacticalObjective;
    }

    /**
     * Set operationalObjective
     *
     * @param \Pequiven\ObjetiveBundle\Entity\Objetive $operationalObjective
     * @return ArrangementProgram
     */
    public function setOperationalObjective(\Pequiven\ObjetiveBundle\Entity\Objetive $operationalObjective = null)
    {
        $this->operationalObjective = $operationalObjective;

        return $this;
    }

    /**
     * Get operationalObjective
     *
     * @return \Pequiven\ObjetiveBundle\Entity\Objetive 
     */
    public function getOperationalObjective()
    {
        return $this->operationalObjective;
    }

    function getType() {
        return $this->type;
    }

    function setType($type) {
        $this->type = $type;
        
        return $this;
    }
    
    function getCreatedBy() {
        return $this->createdBy;
    }

    function setCreatedBy(\Pequiven\SEIPBundle\Entity\User $createdBy) {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * Set ref
     *
     * @param string $ref
     * @return ArrangementProgram
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
     * Set status
     *
     * @param integer $status
     * @return ArrangementProgram
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
     * Add responsibles
     *
     * @param \Pequiven\SEIPBundle\Entity\User $responsibles
     * @return ArrangementProgram
     */
    public function addResponsible(\Pequiven\SEIPBundle\Entity\User $responsibles)
    {
        $this->responsibles[] = $responsibles;

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

    /**
     * Set timeline
     *
     * @param \Pequiven\ArrangementProgramBundle\Entity\Timeline $timeline
     * @return ArrangementProgram
     */
    public function setTimeline(\Pequiven\ArrangementProgramBundle\Entity\Timeline $timeline = null)
    {
        $timeline->setArrangementProgram($this);
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return ArrangementProgram
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
     * @return ArrangementProgram
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
     * Set details
     *
     * @param \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram\Details $details
     * @return ArrangementProgram
     */
    public function setDetails(\Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram\Details $details)
    {
        $this->details = $details;

        return $this;
    }

    /**
     * Get details
     *
     * @return \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram\Details 
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Add histories
     *
     * @param \Pequiven\SEIPBundle\Entity\Historical $histories
     * @return ArrangementProgram
     */
    public function addHistory(\Pequiven\SEIPBundle\Entity\Historical $history)
    {
        $this->histories->add($history);

        return $this;
    }

    /**
     * Remove histories
     *
     * @param \Pequiven\SEIPBundle\Entity\Historical $histories
     */
    public function removeHistory(\Pequiven\SEIPBundle\Entity\Historical $histories)
    {
        $this->histories->removeElement($histories);
    }

    /**
     * Get histories
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getHistories()
    {
        return $this->histories;
    }
}
