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
     * @var integer
     *
     * @ORM\Column(name="period", type="integer")
     */
    private $period;
    
    /**
     * Programa de gestión asociada.
     * @var integer
     *
     * @ORM\Column(name="associatedProgramManagement", type="integer")
     */
    private $associatedProgramManagement;

    /**
     * Objetivo táctico
     * @var integer
     *
     * @ORM\Column(name="tacticalObjective", type="integer")
     */
    private $tacticalObjective;

    /**
     * Objetivo operativo.
     * @var integer
     *
     * @ORM\Column(name="operationalObjective", type="integer")
     */
    private $operationalObjective;

    /**
     * Indicador operativo
     * @var integer
     *
     * @ORM\Column(name="operatingIndicator", type="integer")
     */
    private $operatingIndicator;

    /**
     * Localidad
     * @var integer
     *
     * @ORM\Column(name="location", type="integer")
     */
    private $location;

    /**
     * Area
     * @var integer
     *
     * @ORM\Column(name="area", type="integer")
     */
    private $area;

    /**
     * Proceso
     * @var string
     *
     * @ORM\Column(name="process", type="string", length=255)
     */
    private $process;

    /**
     * Responsable
     * @var integer
     *
     * @ORM\Column(name="responsible", type="integer")
     */
    private $responsible;

    /**
     * Lineas de tiempo
     * @var integer
     *
     * @ORM\Column(name="timelines", type="integer")
     */
    private $timelines;

    /**
     * Revisado por
     * @var integer
     *
     * @ORM\Column(name="reviewedBy", type="integer")
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
     * @var integer
     *
     * @ORM\Column(name="approvedBy", type="integer")
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
     * Set associatedProgramManagement
     *
     * @param integer $associatedProgramManagement
     * @return ArrangementProgram
     */
    public function setAssociatedProgramManagement($associatedProgramManagement)
    {
        $this->associatedProgramManagement = $associatedProgramManagement;

        return $this;
    }

    /**
     * Get associatedProgramManagement
     *
     * @return integer 
     */
    public function getAssociatedProgramManagement()
    {
        return $this->associatedProgramManagement;
    }

    /**
     * Set tacticalObjective
     *
     * @param integer $tacticalObjective
     * @return ArrangementProgram
     */
    public function setTacticalObjective($tacticalObjective)
    {
        $this->tacticalObjective = $tacticalObjective;

        return $this;
    }

    /**
     * Get tacticalObjective
     *
     * @return integer 
     */
    public function getTacticalObjective()
    {
        return $this->tacticalObjective;
    }

    /**
     * Set operationalObjective
     *
     * @param integer $operationalObjective
     * @return ArrangementProgram
     */
    public function setOperationalObjective($operationalObjective)
    {
        $this->operationalObjective = $operationalObjective;

        return $this;
    }

    /**
     * Get operationalObjective
     *
     * @return integer 
     */
    public function getOperationalObjective()
    {
        return $this->operationalObjective;
    }

    /**
     * Set operatingIndicator
     *
     * @param integer $operatingIndicator
     * @return ArrangementProgram
     */
    public function setOperatingIndicator($operatingIndicator)
    {
        $this->operatingIndicator = $operatingIndicator;

        return $this;
    }

    /**
     * Get operatingIndicator
     *
     * @return integer 
     */
    public function getOperatingIndicator()
    {
        return $this->operatingIndicator;
    }

    /**
     * Set location
     *
     * @param integer $location
     * @return ArrangementProgram
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return integer 
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set area
     *
     * @param integer $area
     * @return ArrangementProgram
     */
    public function setArea($area)
    {
        $this->area = $area;

        return $this;
    }

    /**
     * Get area
     *
     * @return integer 
     */
    public function getArea()
    {
        return $this->area;
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
     * Set responsible
     *
     * @param integer $responsible
     * @return ArrangementProgram
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
     * Set goals
     *
     * @param integer $goals
     * @return ArrangementProgram
     */
    public function setGoals($goals)
    {
        $this->goals = $goals;

        return $this;
    }

    /**
     * Get goals
     *
     * @return integer 
     */
    public function getGoals()
    {
        return $this->goals;
    }

    /**
     * Set reviewedBy
     *
     * @param integer $reviewedBy
     * @return ArrangementProgram
     */
    public function setReviewedBy($reviewedBy)
    {
        $this->reviewedBy = $reviewedBy;

        return $this;
    }

    /**
     * Get reviewedBy
     *
     * @return integer 
     */
    public function getReviewedBy()
    {
        return $this->reviewedBy;
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
     * Set approvedBy
     *
     * @param integer $approvedBy
     * @return ArrangementProgram
     */
    public function setApprovedBy($approvedBy)
    {
        $this->approvedBy = $approvedBy;

        return $this;
    }

    /**
     * Get approvedBy
     *
     * @return integer 
     */
    public function getApprovedBy()
    {
        return $this->approvedBy;
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
}
