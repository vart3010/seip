<?php

namespace Pequiven\ObjetiveBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\ObjetiveBundle\Model\Objetive as modelObjetive;
use Pequiven\SEIPBundle\Entity\PeriodItemInterface;
use Pequiven\SEIPBundle\Entity\Result\ResultItemInterface;

/**
 * Objetive
 * 
 * @ORM\Entity(repositoryClass="Pequiven\ObjetiveBundle\Repository\ObjetiveRepository")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="seip_objetive")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Objetive extends modelObjetive implements ResultItemInterface,PeriodItemInterface
{
    //Texto a mostrar en los select
    protected $descriptionSelect;
    
    protected $typeView = '';

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
     * User que lo creo
     * @var \Pequiven\SEIPBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(name="fk_user_created_at", referencedColumnName="id")
     */
    private $userCreatedAt;

    /**
     * User que lo actualizo
     * @var \Pequiven\SEIPBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(name="fk_user_updated_at", referencedColumnName="id")
     */
    private $userUpdatedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
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
     * @ORM\Column(name="eval_objetive", type="boolean")
     */
    private $evalObjetive = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="eval_indicator", type="boolean")
     */
    private $evalIndicator = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="eval_arrangement_program", type="boolean")
     */
    private $evalArrangementProgram = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="eval_simple_average", type="boolean")
     */
    private $evalSimpleAverage = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="eval_weighted_average", type="boolean")
     */
    private $evalWeightedAverage = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled = true;

    /**
     * LineStrategic
     * 
     * @var \Pequiven\MasterBundle\Entity\LineStrategic
     * @ORM\ManyToMany(targetEntity="\Pequiven\MasterBundle\Entity\LineStrategic", inversedBy="objetives")
     * @ORM\JoinTable(name="seip_objetives_linestrategics")
     */
    private $lineStrategics;

    /**
     * Complejo
     * 
     * @var \Pequiven\MasterBundle\Entity\Complejo
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Complejo")
     * @ORM\JoinColumn(name="fk_complejo", referencedColumnName="id")
     */
    private $complejo;

    /**
     * Gerencia
     * 
     * @var \Pequiven\MasterBundle\Entity\Gerencia
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Gerencia",inversedBy="tacticalObjectives")
     * @ORM\JoinColumn(name="fk_gerencia", referencedColumnName="id")
     */
    private $gerencia;
    
    /**
     * Gerencia de segunda linea
     * 
     * @var \Pequiven\MasterBundle\Entity\GerenciaSecond
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\GerenciaSecond",inversedBy="operationalObjectives")
     * @ORM\JoinColumn(name="fk_gerencia_second", referencedColumnName="id")
     */
    private $gerenciaSecond;

    /**
     * @ORM\ManyToMany(targetEntity="\Pequiven\ObjetiveBundle\Entity\Objetive", inversedBy="parents", cascade={"persist","remove"})
     * @ORM\JoinTable(name="seip_objetives_parents",
     *      joinColumns={@ORM\JoinColumn(name="parent_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="children_id", referencedColumnName="id")})
     */
    private $childrens;

    /**
     * @ORM\ManyToMany(targetEntity="\Pequiven\ObjetiveBundle\Entity\Objetive", mappedBy="childrens")
     */
    private $parents;
    
    /**
     * Tendency
     * @var \Pequiven\MasterBundle\Entity\Tendency
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Tendency")
     * @ORM\JoinColumn(name="fk_tendency", referencedColumnName="id")
     */
    private $tendency;
    
    /**
     * @ORM\ManyToMany(targetEntity="\Pequiven\IndicatorBundle\Entity\Indicator", inversedBy="objetives", cascade={"persist","remove"})
     * @ORM\JoinTable(name="seip_objetives_indicators")
     */
    private $indicators;
    
    /**
     * Periodo.
     * @var \Pequiven\SEIPBundle\Entity\Period
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Period")
     * @ORM\JoinColumn(nullable=false)
     */
    private $period;
    
    /**
     * Revisado por
     * @var \Pequiven\SEIPBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\User")
     */
    private $reviewedBy;

    /**
     * Fecha de revision
     * @var \DateTime
     * @ORM\Column(name="revisionDate", type="datetime",nullable=true)
     */
    private $revisionDate;

    /**
     * Aprobado por
     * @var \Pequiven\SEIPBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\User")
     */
    private $approvedBy;

    /**
     * Fecha de aprobacion
     * @var \DateTime
     * @ORM\Column(name="approvalDate", type="datetime",nullable=true)
     */
    private $approvalDate;

    /**
     * Estatus del Objetivo
     * @var integer
     * @ORM\Column(name="status", type="integer")
     */
    protected $status = self::STATUS_DRAFT;
    
    /**
     * @var \Pequiven\SEIPBundle\Entity\Result\Result Description
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\Result\Result", mappedBy="objetive",cascade={"remove"})
     */
    private $results;
    
    /**
     * Resultado del objetivo
     * 
     * @var float
     * @ORM\Column(name="resultOfObjetive",type="float")
     */
    private $resultOfObjetive = 0;
    
    /**
     *
     * @var \Pequiven\ArrangementBundle\Entity\ArrangementRange
     * @ORM\OneToOne(targetEntity="Pequiven\ArrangementBundle\Entity\ArrangementRange",inversedBy="objetive",cascade={"remove","persist"})
     */
    protected $arrangementRange;

    /**
     * @var \DateTime
     * @ORM\Column(name="lastDateCalculateResult", type="datetime",nullable=true)
     */
    private $lastDateCalculateResult;
    
    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;
    
    /**
     * ¿Es requerido para importacion?
     * 
     * @var boolean
     * @ORM\Column(name="requiredToImport",type="boolean")
     */
    protected $requiredToImport = false;
    
    /**
    * @ORM\ManyToMany(targetEntity="Pequiven\SIGBundle\Entity\ManagementSystem", inversedBy="objetives")
    * @ORM\JoinTable(name="seip_objetives_management_systems")
    */
    private $managementSystems;
    
    /**
     * Detalles del objetivo
     * 
     * @var \Pequiven\ObjetiveBundle\Entity\Objetive\ObjetiveDetails
     * @ORM\OneToOne(targetEntity="Pequiven\ObjetiveBundle\Entity\Objetive\ObjetiveDetails",cascade={"persist","remove"})
     */
    protected $details;
    
    /**
     * ¿El resultado que irá a evaluaciones, será colocado manualmente? Quiere decir que de acuerdo a previa solicitud y justificación se puede editar el resultado del objetivo.
     * 
     * @var boolean
     * @ORM\Column(name="updateResultByAdmin",type="boolean")
     */
    protected $updateResultByAdmin = false;
    
    /**
     * Resultado modificado
     * 
     * @var float
     * @ORM\Column(name="resultModified",type="float")
     */
    protected $resultModified = 0; 

    /**
     * ProcessManagementSystem
     * 
     * @ORM\ManyToMany(targetEntity="Pequiven\SIGBundle\Entity\ProcessManagementSystem", inversedBy="objetive")
     * @ORM\JoinTable(name="management_systems_objetive_process")
     */
    protected $processManagementSystem;

    /**
     * @var boolean
     *
     * @ORM\Column(name="showEvolutionView", type="boolean")
     */
    private $showEvolutionView = false;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->childrens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->parents = new \Doctrine\Common\Collections\ArrayCollection();
        $this->indicators = new \Doctrine\Common\Collections\ArrayCollection();
        $this->lineStrategics = new \Doctrine\Common\Collections\ArrayCollection();
        $this->results = new \Doctrine\Common\Collections\ArrayCollection();
        $this->managementSystems = new \Doctrine\Common\Collections\ArrayCollection();
        $this->processManagementSystem = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Objetive
     */
    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Objetive
     */
    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Objetive
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return Objetive
     */
    public function setEnabled($enabled) {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean 
     */
    public function getEnabled() {
        return $this->enabled;
    }

    /**
     * Is enabled
     *
     * @return boolean 
     */
    public function isEnabled() {
        return $this->enabled;
    }

    /**
     * Set userCreatedAt
     *
     * @param \Pequiven\SEIPBundle\Entity\User $userCreatedAt
     * @return Objetive
     */
    public function setUserCreatedAt(\Pequiven\SEIPBundle\Entity\User $userCreatedAt = null) {
        $this->userCreatedAt = $userCreatedAt;

        return $this;
    }

    /**
     * Get userCreatedAt
     *
     * @return \Pequiven\SEIPBundle\Entity\User 
     */
    public function getUserCreatedAt() {
        return $this->userCreatedAt;
    }

    /**
     * Set userUpdatedAt
     *
     * @param \Pequiven\SEIPBundle\Entity\User $userUpdatedAt
     * @return Objetive
     */
    public function setUserUpdatedAt(\Pequiven\SEIPBundle\Entity\User $userUpdatedAt = null) {
        $this->userUpdatedAt = $userUpdatedAt;

        return $this;
    }

    /**
     * Get userUpdatedAt
     *
     * @return \Pequiven\SEIPBundle\Entity\User 
     */
    public function getUserUpdatedAt() {
        return $this->userUpdatedAt;
    }

    /**
     * Set complejo
     *
     * @param \Pequiven\MasterBundle\Entity\Complejo $complejo
     * @return Objetive
     */
    public function setComplejo(\Pequiven\MasterBundle\Entity\Complejo $complejo = null) {
        $this->complejo = $complejo;

        return $this;
    }

    /**
     * Get complejo
     *
     * @return \Pequiven\MasterBundle\Entity\Complejo 
     */
    public function getComplejo() {
        return $this->complejo;
    }

    /**
     * Set gerencia
     *
     * @param \Pequiven\MasterBundle\Entity\Gerencia $gerencia
     * @return Objetive
     */
    public function setGerencia(\Pequiven\MasterBundle\Entity\Gerencia $gerencia = null) {
        $this->gerencia = $gerencia;

        return $this;
    }

    /**
     * Get gerencia
     *
     * @return \Pequiven\MasterBundle\Entity\Gerencia 
     */
    public function getGerencia() {
        return $this->gerencia;
    }

    /**
     * Set weight
     *
     * @param float $weight
     * @return Objetive
     */
    public function setWeight($weight) {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Set goal
     *
     * @param float $goal
     * @return Objetive
     */
    public function setGoal($goal) {
        $this->goal = $goal;

        return $this;
    }

    /**
     * Get goal
     *
     * @return float 
     */
    public function getGoal() {
        return $this->goal;
    }

    /**
     * Set evalObjetive
     *
     * @param boolean $evalObjetive
     * @return Objetive
     */
    public function setEvalObjetive($evalObjetive) {
        $this->evalObjetive = $evalObjetive;

        return $this;
    }

    /**
     * Get evalObjetive
     *
     * @return boolean 
     */
    public function getEvalObjetive() {
        return $this->evalObjetive;
    }

    /**
     * Set evalIndicator
     *
     * @param boolean $evalIndicator
     * @return Objetive
     */
    public function setEvalIndicator($evalIndicator) {
        $this->evalIndicator = $evalIndicator;

        return $this;
    }

    /**
     * Get evalIndicator
     *
     * @return boolean 
     */
    public function getEvalIndicator() {
        return $this->evalIndicator;
    }

    /**
     * Set evalArrangementProgram
     *
     * @param boolean $evalArrangementProgram
     * @return Objetive
     */
    public function setEvalArrangementProgram($evalArrangementProgram) {
        $this->evalArrangementProgram = $evalArrangementProgram;

        return $this;
    }

    /**
     * Get evalArrangementProgram
     *
     * @return boolean 
     */
    public function getEvalArrangementProgram() {
        return $this->evalArrangementProgram;
    }

    /**
     * Set evalSimpleAverage
     *
     * @param boolean $evalSimpleAverage
     * @return Objetive
     */
    public function setEvalSimpleAverage($evalSimpleAverage) {
        $this->evalSimpleAverage = $evalSimpleAverage;

        return $this;
    }

    /**
     * Get evalSimpleAverage
     *
     * @return boolean 
     */
    public function getEvalSimpleAverage() {
        return $this->evalSimpleAverage;
    }

    /**
     * Set evalWeightedAverage
     *
     * @param boolean $evalWeightedAverage
     * @return Objetive
     */
    public function setEvalWeightedAverage($evalWeightedAverage) {
        $this->evalWeightedAverage = $evalWeightedAverage;

        return $this;
    }

    /**
     * Get evalWeightedAverage
     *
     * @return boolean 
     */
    public function getEvalWeightedAverage() {
        return $this->evalWeightedAverage;
    }

    /**
     * Set ref
     *
     * @param string $ref
     * @return Objetive
     */
    public function setRef($ref) {
        $this->ref = $ref;

        return $this;
    }

    /**
     * Get ref
     *
     * @return string 
     */
    public function getRef() {
        return $this->ref;
    }

    /**
     * Get descriptionSelect
     * 
     * @return string
     */
    public function getDescriptionSelect() {
        $this->descriptionSelect = $this->getRef() . ' ' . $this->getDescription();
        return $this->descriptionSelect;
    }
    
    /**
     * Set gerenciaSecond
     *
     * @param \Pequiven\MasterBundle\Entity\GerenciaSecond $gerenciaSecond
     * @return Objetive
     */
    public function setGerenciaSecond(\Pequiven\MasterBundle\Entity\GerenciaSecond $gerenciaSecond = null)
    {
        $this->gerenciaSecond = $gerenciaSecond;

        return $this;
    }

    /**
     * Get gerenciaSecond
     *
     * @return \Pequiven\MasterBundle\Entity\GerenciaSecond 
     */
    public function getGerenciaSecond()
    {
        return $this->gerenciaSecond;
    }

    /**
     * Add indicators
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator $indicators
     * @return Objetive
     */
    public function addIndicator(\Pequiven\IndicatorBundle\Entity\Indicator $indicators)
    {
        
        if(!$this->indicators->contains($indicators)){
            $this->indicators->add($indicators);
        }

        return $this;
    }

    /**
     * Remove indicators
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator $indicators
     */
    public function removeIndicator(\Pequiven\IndicatorBundle\Entity\Indicator $indicators)
    {
        $this->indicators->removeElement($indicators);
    }

    /**
     * Get indicators
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIndicators()
    {
        return $this->indicators;
    }
    
    public function resetIndicators(){
        $this->indicators = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add childrens
     *
     * @param \Pequiven\ObjetiveBundle\Entity\Objetive $childrens
     * @return Objetive
     */
    public function addChildren(\Pequiven\ObjetiveBundle\Entity\Objetive $childrens)
    {
        $childrens->addParent($this);
        $this->childrens->add($childrens);

        return $this;
    }

    /**
     * Remove childrens
     *
     * @param \Pequiven\ObjetiveBundle\Entity\Objetive $childrens
     */
    public function removeChildren(\Pequiven\ObjetiveBundle\Entity\Objetive $childrens)
    {
        $this->childrens->removeElement($childrens);
    }

    /**
     * Get childrens
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildrens()
    {
        return $this->childrens;
    }

    /**
     * Add parents
     *
     * @param \Pequiven\ObjetiveBundle\Entity\Objetive $parents
     * @return Objetive
     */
    public function addParent(\Pequiven\ObjetiveBundle\Entity\Objetive $parents)
    {
        if(!$this->parents->contains($parents)){
            $this->parents->add($parents);
        }

        return $this;
    }

    /**
     * Remove parents
     *
     * @param \Pequiven\ObjetiveBundle\Entity\Objetive $parents
     */
    public function removeParent(\Pequiven\ObjetiveBundle\Entity\Objetive $parents)
    {
        $this->parents->removeElement($parents);
    }

    /**
     * Get parents
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getParents()
    {
        return $this->parents;
    }

    /**
     * Add lineStrategics
     *
     * @param \Pequiven\MasterBundle\Entity\LineStrategic $lineStrategics
     * @return Objetive
     */
    public function addLineStrategic(\Pequiven\MasterBundle\Entity\LineStrategic $lineStrategics)
    {
        $this->lineStrategics[] = $lineStrategics;

        return $this;
    }

    /**
     * Remove lineStrategics
     *
     * @param \Pequiven\MasterBundle\Entity\LineStrategic $lineStrategics
     */
    public function removeLineStrategic(\Pequiven\MasterBundle\Entity\LineStrategic $lineStrategics)
    {
        $this->lineStrategics->removeElement($lineStrategics);
    }

    /**
     * Get lineStrategics
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLineStrategics()
    {
        return $this->lineStrategics;
    }

    /**
     * Set tendency
     *
     * @param \Pequiven\MasterBundle\Entity\Tendency $tendency
     * @return Objetive
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
     * Set revisionDate
     *
     * @param \DateTime $revisionDate
     * @return Objetive
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
     * @return Objetive
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
     * @return Objetive
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
     * Set reviewedBy
     *
     * @param \Pequiven\SEIPBundle\Entity\User $reviewedBy
     * @return Objetive
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
     * @return Objetive
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
    
    /**
     * 
     * @return type
     */
    public function getTypeView() {
        return $this->typeView;
    }

    /**
     * 
     * @param type $typeView
     */
    public function setTypeView($typeView) {
        $this->typeView = $typeView;
    }
    
    /**
     * @ORM\PostLoad
     */
    public function postLoad(){
        
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


    /**
     * Set period
     *
     * @param \Pequiven\SEIPBundle\Entity\Period $period
     * @return Objetive
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
    
    public function getDescriptionWithGerenciaSecond()
    {
        return $this->getDescriptionSelect() .' - ' . $this->getGerenciaSecond();
    }

    /**
     * Add results
     *
     * @param \Pequiven\SEIPBundle\Entity\Result\Result $results
     * @return Objetive
     */
    public function addResult(\Pequiven\SEIPBundle\Entity\Result\Result $results)
    {
        $results->setObjetive($this);
        $this->results->add($results);

        return $this;
    }

    /**
     * Remove results
     *
     * @param \Pequiven\SEIPBundle\Entity\Result\Result $results
     */
    public function removeResult(\Pequiven\SEIPBundle\Entity\Result\Result $results)
    {
        $this->results->removeElement($results);
    }

    /**
     * Get results
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getResults()
    {
        return $this->results;
    }
    
    function getResultOfObjetive() 
    {
        return $this->resultOfObjetive;
    }

    function setResultOfObjetive($resultOfObjetive) 
    {
        $this->resultOfObjetive = $resultOfObjetive;
        
        return $this;
    }
    
    function getDeletedAt() {
        return $this->deletedAt;
    }

    function setDeletedAt($deletedAt) {
        $this->deletedAt = $deletedAt;
        
        return $this;
    }

    /**
     * Get weight
     *
     * @return float 
     */
    public function getWeight() {
        return $this->weight;
    }
    
    public function getResult() {
        return $this->getResultOfObjetive();
    }

    public function getResultWithWeight() {
        $result = ( $this->getResult() * $this->getWeight()) / 100;
        return $result;
    }
    
    public function updateLastDateCalculateResult() 
    {
        $this->lastDateCalculateResult = new \DateTime();
    }
    
    public function clearLastDateCalculateResult() {
        $this->lastDateCalculateResult = null;
    }
    
    public function isAvailableInResult() 
    {
        return true;
    }
    
    function setIndicators($indicators) {
        $this->indicators = $indicators;
    }
    
    function setResults($results) {
        $this->results = $results;
    }
    
    function isCouldBePenalized() 
    {
        return false;
    }

    function isForcePenalize() 
    {
        return false;
    }
    public function setResultReal($resultReal) {}
    public function setResult($result) {}
    
    public function __toString() 
    {
        $description = \Pequiven\SEIPBundle\Service\ToolService::truncate($this->getDescription());
        $toString = $this->getRef().' '.$description;
        return $toString?:'-';
    }
    
    public function __clone() {
        if($this->id){
            $this->id = null;
            $this->createdAt = null;
            $this->updatedAt = null;
            $this->userCreatedAt = null;
            $this->ref = null;
            $this->details = null;
            
            $this->childrens = new ArrayCollection();
            $this->parents = new ArrayCollection();
            
            $this->managementSystems = new ArrayCollection();
            $this->processManagementSystem = new ArrayCollection();
            
            $this->period = null;
            $this->reviewedBy = null;
            $this->revisionDate = null;
            $this->approvedBy = null;
            $this->approvalDate = null;
            $this->status = 0;
            
            $this->resultOfObjetive = 0;
            
            $this->lastDateCalculateResult = null;
            $this->deletedAt = null;
        }
    }

    /**
     * Set requiredToImport
     *
     * @param boolean $requiredToImport
     * @return Objetive
     */
    public function setRequiredToImport($requiredToImport)
    {
        $this->requiredToImport = $requiredToImport;

        return $this;
    }

    /**
     * Get requiredToImport
     *
     * @return boolean 
     */
    public function getRequiredToImport()
    {
        return $this->requiredToImport;
    }

    /**
     * Set details
     *
     * @param \Pequiven\ObjetiveBundle\Entity\Objetive\ObjetiveDetails $details
     * @return Objetive
     */
    public function setDetails(\Pequiven\ObjetiveBundle\Entity\Objetive\ObjetiveDetails $details = null)
    {
        $this->details = $details;

        return $this;
    }

    /**
     * Get details
     *
     * @return \Pequiven\ObjetiveBundle\Entity\Objetive\ObjetiveDetails 
     */
    public function getDetails()
    {
        return $this->details;
    }
    
    /**
     * Add managementSystems
     *
     * @param \Pequiven\SIGBundle\Entity\ManagementSystem $managementSystems
     * @return Objetive
     */
    public function addManagementSystem(\Pequiven\SIGBundle\Entity\ManagementSystem $managementSystems)
    {
        $this->managementSystems[] = $managementSystems;

        return $this;
    }

    /**
     * Remove managementSystems
     *
     * @param \Pequiven\SIGBundle\Entity\ManagementSystem $managementSystems
     */
    public function removeManagementSystem(\Pequiven\SIGBundle\Entity\ManagementSystem $managementSystems)
    {
        $this->managementSystems->removeElement($managementSystems);
    }

    /**
     * Get managementSystems
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getManagementSystems()
    {
        return $this->managementSystems;
    }
    
    /**
     * Set updateResultByAdmin
     *
     * @param boolean $updateResultByAdmin
     * @return Objetive
     */
    public function setUpdateResultByAdmin($updateResultByAdmin)
    {
        $this->updateResultByAdmin = $updateResultByAdmin;

        return $this;
    }

    /**
     * Get updateResultByAdmin
     *
     * @return boolean 
     */
    public function getUpdateResultByAdmin()
    {
        return $this->updateResultByAdmin;
    }
    
    /**
     * Set resultModified
     * @param float $resultModified
     * @return Objetive
     */
    public function setResultModified($resultModified)
    {
        $this->resultModified = $resultModified;

        return $this;
    }

    /**
     * Get resultModified
     *
     * @return float 
     */
    public function getResultModified()
    {
        return $this->resultModified;
    }

    /**
     * Add processManagementSystem
     *
     * @param \Pequiven\SIGBundle\Entity\ProcessManagementSystem $processManagementSystem
     * @return Objetive
     */
    public function addProcessManagementSystem(\Pequiven\SIGBundle\Entity\ProcessManagementSystem $processManagementSystem)
    {
        $this->processManagementSystem[] = $processManagementSystem;

        return $this;
    }

    /**
     * Remove processManagementSystem
     *
     * @param \Pequiven\SIGBundle\Entity\ManagementSystem $processManagementSystem
     */
    public function removeProcessManagementSystem(\Pequiven\SIGBundle\Entity\ProcessManagementSystem $processManagementSystem)
    {
        $this->processManagementSystem->removeElement($processManagementSystem);
    }

    /**
     * Get processManagementSystem
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProcessManagementSystem()
    {
        return $this->processManagementSystem;
    }

    /**
     * Set showEvolutionView
     *
     * @param boolean $showEvolutionView
     * @return Objetive
     */
    public function setShowEvolutionView($showEvolutionView) {
        $this->showEvolutionView = $showEvolutionView;

        return $this;
    }

    /**
     * Get showEvolutionView
     *
     * @return boolean 
     */
    public function getShowEvolutionView() {
        return $this->showEvolutionView;
    }
}
