<?php

namespace Pequiven\ArrangementProgramBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\ArrangementProgramBundle\Model\ChangeUserGoal as Model;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\SEIPBundle\Entity\Result\ResultItemInterface;
use Pequiven\SEIPBundle\Entity\PeriodItemInterface;

/**
 * Programa de gestion
 *
 * @ORM\Entity(repositoryClass="Pequiven\ArrangementProgramBundle\Repository\ArrangementProgramRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class ChangeUserGoal extends Model implements \Pequiven\SEIPBundle\Entity\Result\ResultItemInterface, PeriodItemInterface {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\ArrangementProgramBundle\Entity\Goal")
     * @ORM\JoinColumn(nullable=false)
     */
    private $goal;
    
    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @var integer
     * 
     * @ORM\Column (name="start_date_user_goal",type="datetime")
     * @ORM\ManyToOne(targetEntity="Pequiven\ArrangementProgramBundle\Entity\Goal")
     */
    private $status_user_goal;
    
    
    
    
    
    /**
     * Referencia del programa de gestion
     * @var string
     * @ORM\Column(name="ref",type="string",length=100,nullable=false)
     */
    private $ref = null;

    /**
     * Periodo.
     * @var \Pequiven\SEIPBundle\Entity\Period
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Period")
     * @ORM\JoinColumn(nullable=false)
     */
    private $period;

    /**
     * Objetivo táctico
     * @var \Pequiven\ObjetiveBundle\Entity\Objetive
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\ObjetiveBundle\Entity\Objetive",inversedBy="tacticalArrangementPrograms")
     * @ORM\JoinColumn(name="tactical_objective_id")
     */
    private $tacticalObjective;

    /**
     * Objetivo operativo.
     * @var \Pequiven\ObjetiveBundle\Entity\Objetive
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\ObjetiveBundle\Entity\Objetive",inversedBy="operationalArrangementPrograms")
     * @ORM\JoinColumn(name="operational_objective_id")
     */
    private $operationalObjective;

    /**
     * Proceso
     * @var string
     *
     * @ORM\Column(name="process", type="string", length=255, nullable=true)
     */
    private $process;

    /**
     * Descripcion del programa
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * Estatus del programa de gestion
     * @var integer
     *
     * @ORM\Column(name="status", type="integer")
     */
    protected $status = self::STATUS_DRAFT;

    /**
     * Responsables del programa
     * @var \Pequiven\SEIPBundle\Entity\User
     *
     * @ORM\ManyToMany(targetEntity="Pequiven\SEIPBundle\Entity\User",inversedBy="arrangementPrograms")
     */
    protected $responsibles;

    /**
     * Linea de tiempo
     * @var \Pequiven\ArrangementProgramBundle\Entity\Timeline
     *
     * @ORM\OneToOne(targetEntity="Pequiven\ArrangementProgramBundle\Entity\Timeline",inversedBy="arrangementProgram",cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    protected $timeline;

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

    /**
     * Observaciones
     * 
     * @var \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram\Observation
     * @ORM\OneToMany(targetEntity="Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram\Observation",mappedBy="arrangementProgram",cascade={"persist","remove"})
     */
    protected $observations;

    /**
     * Avance total del programa
     * @var float
     * @ORM\Column(name="totalAdvance",type="float")
     */
    protected $totalAdvance = 0;

    /**
     * Avance del programa hasta la fecha
     * 
     * @var integer
     * @ORM\Column(name="progressToDate",type="float")
     */
    protected $progressToDate = 0;

    /**
     * @var \DateTime
     * @ORM\Column(name="lastDateCalculateResult", type="datetime",nullable=true)
     */
    private $lastDateCalculateResult;

    /**
     *
     * @var boolean
     * @ORM\Column(name="isAvailableInResult",type="boolean")
     */
    private $isAvailableInResult = true;

    /**
     * ¿Se puede penalizar el resultado?
     * @var boolean
     * @ORM\Column(name="couldBePenalized",type="boolean")
     */
    private $couldBePenalized = true;

    /**
     * ¿Forzar la penalizacion del resultado?
     * @var boolean
     * @ORM\Column(name="forcePenalize",type="boolean")
     */
    private $forcePenalize = false;

    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * Resultado original
     * 
     * @var float
     * @ORM\Column(name="resultReal",type="float")
     */
    protected $resultReal = 0;

    public function __construct() {
        $this->responsibles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->histories = new \Doctrine\Common\Collections\ArrayCollection();
        $this->observations = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
