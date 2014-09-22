<?php

namespace Pequiven\ArrangementProgramBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Programa de gestion
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Pequiven\ArrangementProgramBundle\Repository\ArrangementProgramRepository")
 */
class ArrangementProgram
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
     * Periodo.
     * @var \Pequiven\SEIPBundle\Entity\Period
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Period")
     */
    private $period;
    
    /**
     * Programa de gestión asociada.
     * @var \Pequiven\MasterBundle\Entity\ArrangementProgram\CategoryArrangementProgram
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\MasterBundle\Entity\ArrangementProgram\CategoryArrangementProgram")
     */
    private $categoryArrangementProgramt;

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
     * Indicador operativo
     * @var \Pequiven\IndicatorBundle\Entity\Indicator
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\IndicatorBundle\Entity\Indicator")
     */
    private $operatingIndicator;

    /**
     * Localidad
     * @var \Pequiven\MasterBundle\Entity\Complejo
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\MasterBundle\Entity\Complejo")
     */
    private $location;

    /**
     * Proceso
     * @var string
     *
     * @ORM\Column(name="process", type="string", length=255)
     */
    private $process;

    /**
     * Responsable
     * @var \Pequiven\SEIPBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(name="user_responsible_id")
     */
    private $responsible;

    /**
     * Lineas de tiempo
     * @var \Pequiven\ArrangementProgramBundle\Entity\Timeline
     *
     * @ORM\Column(name="timelines", type="integer")
     * @ORM\OneToMany(targetEntity="Pequiven\ArrangementProgramBundle\Entity\Timeline",mappedBy="arrangementProgram")
     */
    private $timelines;

    /**
     * Revisado por
     * @var \Pequiven\SEIPBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\User")
     */
    private $reviewedBy;

    /**
     * Fecha de revision
     * @var \DateTime
     *
     * @ORM\Column(name="revisionDate", type="datetime")
     */
    private $revisionDate;

    /**
     * Aprobado por
     * @var \Pequiven\SEIPBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\User")
     */
    private $approvedBy;

    /**
     * Fecha de aprobacion
     * @var \DateTime
     *
     * @ORM\Column(name="approvalDate", type="datetime")
     */
    private $approvalDate;

    /**
     * Estatus del programa de gestion
     * @var integer
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;

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
     * Set timelines
     *
     * @param integer $timelines
     * @return ArrangementProgram
     */
    public function setTimelines($timelines)
    {
        $this->timelines = $timelines;

        return $this;
    }

    /**
     * Get timelines
     *
     * @return integer 
     */
    public function getTimelines()
    {
        return $this->timelines;
    }

    /**
     * Set revisionDate
     *
     * @param \DateTime $revisionDate
     * @return ArrangementProgram
     */
    public function setRevisionDate($revisionDate)
    {
        $this->revisionDate = $revisionDate;

        return $this;
    }

    /**
     * Get revisionDate
     *
     * @return \DateTime 
     */
    public function getRevisionDate()
    {
        return $this->revisionDate;
    }

    /**
     * Set approvalDate
     *
     * @param \DateTime $approvalDate
     * @return ArrangementProgram
     */
    public function setApprovalDate($approvalDate)
    {
        $this->approvalDate = $approvalDate;

        return $this;
    }

    /**
     * Get approvalDate
     *
     * @return \DateTime 
     */
    public function getApprovalDate()
    {
        return $this->approvalDate;
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
     * Set categoryArrangementProgramt
     *
     * @param \Pequiven\MasterBundle\Entity\ArrangementProgram\CategoryArrangementProgram $categoryArrangementProgramt
     * @return ArrangementProgram
     */
    public function setCategoryArrangementProgramt(\Pequiven\MasterBundle\Entity\ArrangementProgram\CategoryArrangementProgram $categoryArrangementProgramt = null)
    {
        $this->categoryArrangementProgramt = $categoryArrangementProgramt;

        return $this;
    }

    /**
     * Get categoryArrangementProgramt
     *
     * @return \Pequiven\MasterBundle\Entity\ArrangementProgram\CategoryArrangementProgram 
     */
    public function getCategoryArrangementProgramt()
    {
        return $this->categoryArrangementProgramt;
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

    /**
     * Set operatingIndicator
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator $operatingIndicator
     * @return ArrangementProgram
     */
    public function setOperatingIndicator(\Pequiven\IndicatorBundle\Entity\Indicator $operatingIndicator = null)
    {
        $this->operatingIndicator = $operatingIndicator;

        return $this;
    }

    /**
     * Get operatingIndicator
     *
     * @return \Pequiven\IndicatorBundle\Entity\Indicator 
     */
    public function getOperatingIndicator()
    {
        return $this->operatingIndicator;
    }

    /**
     * Set location
     *
     * @param \Pequiven\MasterBundle\Entity\Complejo $location
     * @return ArrangementProgram
     */
    public function setLocation(\Pequiven\MasterBundle\Entity\Complejo $location = null)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return \Pequiven\MasterBundle\Entity\Complejo 
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set responsible
     *
     * @param \Pequiven\SEIPBundle\Entity\User $responsible
     * @return ArrangementProgram
     */
    public function setResponsible(\Pequiven\SEIPBundle\Entity\User $responsible = null)
    {
        $this->responsible = $responsible;

        return $this;
    }

    /**
     * Get responsible
     *
     * @return \Pequiven\SEIPBundle\Entity\User 
     */
    public function getResponsible()
    {
        return $this->responsible;
    }

    /**
     * Set reviewedBy
     *
     * @param \Pequiven\SEIPBundle\Entity\User $reviewedBy
     * @return ArrangementProgram
     */
    public function setReviewedBy(\Pequiven\SEIPBundle\Entity\User $reviewedBy = null)
    {
        $this->reviewedBy = $reviewedBy;

        return $this;
    }

    /**
     * Get reviewedBy
     *
     * @return \Pequiven\SEIPBundle\Entity\User 
     */
    public function getReviewedBy()
    {
        return $this->reviewedBy;
    }

    /**
     * Set approvedBy
     *
     * @param \Pequiven\SEIPBundle\Entity\User $approvedBy
     * @return ArrangementProgram
     */
    public function setApprovedBy(\Pequiven\SEIPBundle\Entity\User $approvedBy = null)
    {
        $this->approvedBy = $approvedBy;

        return $this;
    }

    /**
     * Get approvedBy
     *
     * @return \Pequiven\SEIPBundle\Entity\User 
     */
    public function getApprovedBy()
    {
        return $this->approvedBy;
    }
}
