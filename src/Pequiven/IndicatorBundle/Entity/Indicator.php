<?php

namespace Pequiven\IndicatorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\IndicatorBundle\Model\Indicator as modelIndicator;
use Pequiven\SEIPBundle\Entity\PeriodItemInterface;

/**
 * Indicator
 *
 * @ORM\Table(name="seip_indicator")
 * @ORM\Entity(repositoryClass="Pequiven\IndicatorBundle\Repository\IndicatorRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @author matias
 */
class Indicator extends modelIndicator implements \Pequiven\SEIPBundle\Entity\Result\ResultItemInterface,PeriodItemInterface
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
     * @ORM\Column(name="lastDateCalculateResult", type="datetime",nullable=true)
     */
    private $lastDateCalculateResult;

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
     * @var string
     *
     * @ORM\Column(name="refParent", type="string", length=15, nullable=true)
     */
    private $refParent;
    
    /**
     * @var float
     * 
     * @ORM\Column(name="weight", type="float", nullable=true)
     */
    private $weight;
    
    /**
     * Total planificado
     * 
     * @var float
     * @ORM\Column(name="totalPlan", type="float", nullable=true)
     */
    private $totalPlan = 0;

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
     * Periodo.
     * 
     * @var \Pequiven\SEIPBundle\Entity\Period
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Period")
     * @ORM\JoinColumn(nullable=false)
     */
    private $period;
    
    /**
     * Valores del indicador
     * 
     * @var \Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator
     * @ORM\OneToMany(targetEntity="Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator",mappedBy="indicator",cascade={"persist","remove"})
     */
    protected $valuesIndicator;
    
    /**
     * Valor (Evaluado a partir de todos los valores y formula)
     * 
     * @var decimal
     * @ORM\Column(name="valueFinal", type="float",precision = 3)
     */
    protected $valueFinal = 0;
    
    /**
     * Frecuencia de notificacion del indicador
     * 
     * @var \Pequiven\IndicatorBundle\Entity\Indicator\FrequencyNotificationIndicator
     * @ORM\ManyToOne(targetEntity="Pequiven\IndicatorBundle\Entity\Indicator\FrequencyNotificationIndicator")
     
     */
    protected $frequencyNotificationIndicator;
    
    /**
     * Historiales o Eventos
     * 
     * @var \Pequiven\SEIPBundle\Entity\Historical
     * @ORM\ManyToMany(targetEntity="Pequiven\SEIPBundle\Entity\Historical",cascade={"persist","remove"})
     */
    protected $histories;
    
    /**
     * Observaciones
     * 
     * @var \Pequiven\SEIPBundle\Entity\Observation
     * @ORM\ManyToMany(targetEntity="Pequiven\SEIPBundle\Entity\Observation",cascade={"persist","remove"})
     */
    protected $observations;
    
    /**
     * Detalles del indicador
     * 
     * @var \Pequiven\IndicatorBundle\Entity\Indicator\IndicatorDetails
     * @ORM\OneToOne(targetEntity="Pequiven\IndicatorBundle\Entity\Indicator\IndicatorDetails",inversedBy="indicator",cascade={"persist","remove"})
     */
    protected $details;
    
    /**
     * Indicador al que impacta este indicador
     * 
     * @var \Pequiven\IndicatorBundle\Entity\Indicator
     * @ORM\ManyToOne(targetEntity="Pequiven\IndicatorBundle\Entity\Indicator",inversedBy="childrens",cascade={"persist"})
     */
    protected $parent;
    
    /**
     * Indicadores que impactan a este indicador
     * 
     * @var \Pequiven\IndicatorBundle\Entity\Indicator 
     * @ORM\OneToMany(targetEntity="Pequiven\IndicatorBundle\Entity\Indicator",mappedBy="parent",cascade={"persist"}))
     */
    protected $childrens;
    
    /**
     * Avance del indicador
     * 
     * @var integer
     * @ORM\Column(name="progressToDate",type="float")
     */
    protected $progressToDate = 0;
    
    /**
     * Resultado arrojado por la fórmula de evaluación del indicador
     * 
     * @var integer
     * @ORM\Column(name="resultReal",type="float")
     */
    protected $resultReal = 0;
    
    /**
     *
     * @var \Pequiven\ArrangementBundle\Entity\ArrangementRange
     * @ORM\OneToOne(targetEntity="Pequiven\ArrangementBundle\Entity\ArrangementRange",inversedBy="indicator",cascade={"remove"})
     */
    protected $arrangementRange;

    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;
    
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
     * ¿Es requerido para importacion?
     * 
     * @var boolean
     * @ORM\Column(name="requiredToImport",type="boolean")
     */
    protected $requiredToImport = false;
    
    /**
     * Detalles de la formula del indicador
     * @var \Pequiven\MasterBundle\Entity\Formula\FormulaDetail
     * @ORM\OneToMany(targetEntity="Pequiven\MasterBundle\Entity\Formula\FormulaDetail",mappedBy="indicator",cascade={"persist","remove"}, orphanRemoval=true)
     */
    protected $formulaDetails;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->objetives = new \Doctrine\Common\Collections\ArrayCollection();
        $this->valuesIndicator = new \Doctrine\Common\Collections\ArrayCollection();
        $this->childrens=  new \Doctrine\Common\Collections\ArrayCollection();
        $this->formulaDetails = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add objetives
     *
     * @param \Pequiven\ObjetiveBundle\Entity\Objetive $objetives
     * @return Indicator
     */
    public function addObjetive(\Pequiven\ObjetiveBundle\Entity\Objetive $objetives)
    {
        $objetives->addIndicator($this);
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
    
    /**
     * Set refParent
     *
     * @param string $refParent
     * @return Indicator
     */
    public function setRefParent($refParent)
    {
        $this->refParent = $refParent;

        return $this;
    }

    /**
     * Get refParent
     *
     * @return string 
     */
    public function getRefParent()
    {
        return $this->refParent;
    }

    /**
     * Set period
     *
     * @param \Pequiven\SEIPBundle\Entity\Period $period
     * @return Indicator
     */
    public function setPeriod(\Pequiven\SEIPBundle\Entity\Period $period)
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
     * Set frequencyNotificationIndicator
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator\FrequencyNotificationIndicator $frequencyNotificationIndicator
     * @return Indicator
     */
    public function setFrequencyNotificationIndicator(\Pequiven\IndicatorBundle\Entity\Indicator\FrequencyNotificationIndicator $frequencyNotificationIndicator = null)
    {
        $this->frequencyNotificationIndicator = $frequencyNotificationIndicator;

        return $this;
    }

    /**
     * Get frequencyNotificationIndicator
     *
     * @return \Pequiven\IndicatorBundle\Entity\Indicator\FrequencyNotificationIndicator 
     */
    public function getFrequencyNotificationIndicator()
    {
        return $this->frequencyNotificationIndicator;
    }
    
    /**
     * Add valuesIndicator
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator $valuesIndicator
     * @return Indicator
     */
    public function addValuesIndicator(\Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator $valuesIndicator)
    {
        $valuesIndicator->setIndicator($this);
        
        $this->valuesIndicator->add($valuesIndicator);

        return $this;
    }

    /**
     * Remove valuesIndicator
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator $valuesIndicator
     */
    public function removeValuesIndicator(\Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator $valuesIndicator)
    {
        $this->valuesIndicator->removeElement($valuesIndicator);
    }

    /**
     * Get valuesIndicator
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getValuesIndicator()
    {
        return $this->valuesIndicator;
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
     * Set valueFinal
     *
     * @param string $valueFinal
     * @return Indicator
     */
    public function setValueFinal($valueFinal)
    {
        $this->progressToDate = 0;
        if($valueFinal > 0 && $this->totalPlan > 0){
            $this->progressToDate = ($valueFinal / $this->totalPlan) * 100;
        }
        $this->valueFinal = $valueFinal;

        return $this;
    }

    /**
     * Get valueFinal
     *
     * @return string 
     */
    public function getValueFinal()
    {
        return $this->valueFinal;
    }
    
    /**
     * 
     * @return string
     */
    public function __toString() {
        return $this->getDescription() ? $this->getRef().' - '.$this->getDescription() : '-';
    }

    /**
     * Add histories
     *
     * @param \Pequiven\SEIPBundle\Entity\Historical $histories
     * @return Indicator
     */
    public function addHistory(\Pequiven\SEIPBundle\Entity\Historical $histories)
    {
        $this->histories->add($histories);

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

    /**
     * Add observations
     *
     * @param \Pequiven\SEIPBundle\Entity\Observation $observations
     * @return Indicator
     */
    public function addObservation(\Pequiven\SEIPBundle\Entity\Observation $observations)
    {
        $this->observations->add($observations);

        return $this;
    }

    /**
     * Remove observations
     *
     * @param \Pequiven\SEIPBundle\Entity\Observation $observations
     */
    public function removeObservation(\Pequiven\SEIPBundle\Entity\Observation $observations)
    {
        $this->observations->removeElement($observations);
    }

    /**
     * Get observations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getObservations()
    {
        return $this->observations;
    }

    /**
     * Set details
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator\IndicatorDetails $details
     * @return Indicator
     */
    public function setDetails(\Pequiven\IndicatorBundle\Entity\Indicator\IndicatorDetails $details = null)
    {
        $this->details = $details;

        return $this;
    }

    /**
     * Get details
     *
     * @return \Pequiven\IndicatorBundle\Entity\Indicator\IndicatorDetails
     */
    public function getDetails()
    {
        return $this->details;
    }
    
    function getTotalPlan() {
        return $this->totalPlan;
    }

    function setTotalPlan($totalPlan) {
        $this->totalPlan = $totalPlan;
        
        return $this;
    }

    /**
     * Set parent
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator $parent
     * @return Indicator
     */
    public function setParent(\Pequiven\IndicatorBundle\Entity\Indicator $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Pequiven\IndicatorBundle\Entity\Indicator 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add childrens
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator $childrens
     * @return Indicator
     */
    public function addChildren(\Pequiven\IndicatorBundle\Entity\Indicator $childrens)
    {
        $childrens->setParent($this);
        $this->childrens->add($childrens);

        return $this;
    }

    /**
     * Remove childrens
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator $childrens
     */
    public function removeChildren(\Pequiven\IndicatorBundle\Entity\Indicator $childrens)
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
    
    function getProgressToDate() 
    {
        return $this->progressToDate;
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
     * Devuelve el valor que sera tomado en cuenta para los resuldatos
     * @return type
     */
    public function getResult() {
        return $this->progressToDate;
    }

    public function getResultWithWeight() {
        $result = ( $this->getResult() * $this->getWeight()) / 100;
        return $result;
    }
    
    public function updateLastDateCalculateResult() 
    {
        $this->lastDateCalculateResult = new \DateTime();
    }
    
    public function clearLastDateCalculateResult() 
    {
        $this->lastDateCalculateResult = null;
    }
    
    public function isAvailableInResult() 
    {
        return true;
    }
    
    function getDeletedAt() {
        return $this->deletedAt;
    }

    function setDeletedAt($deletedAt) {
        $this->deletedAt = $deletedAt;
        
        return $this;
    }
    
    function setProgressToDate($progressToDate) {
        $this->progressToDate = $progressToDate;
    }
    
    public function __clone() {
        if($this->id > 0){
            $this->id = null;
            
            $this->createdAt = null;
            $this->lastDateCalculateResult = null;
            $this->updatedAt = null;
            $this->userCreatedAt = null;
            $this->userUpdatedAt = null;
            
            $this->period = null;
            
            $this->valuesIndicator = new ArrayCollection();
            
            $this->valueFinal = 0;
            
            $this->histories = new ArrayCollection();
            $this->observations = new ArrayCollection();
            $this->details = new Indicator\IndicatorDetails();
            
            $this->objetives = new ArrayCollection();
            
            $this->childrens = new ArrayCollection();
            $this->progressToDate = 0;
        }
    }
    
    public function setResult($result) 
    {
        $this->progressToDate = $result;
    }
    
    /**
     * Set resultReal
     *indicators
     * @param float $resultReal
     * @return Indicator
     */
    public function setResultReal($resultReal)
    {
        $this->resultReal = $resultReal;

        return $this;
    }

    /**
     * Get resultReal
     *
     * @return float 
     */
    public function getResultReal()
    {
        return $this->resultReal;
    }
    
    function isCouldBePenalized() 
    {
        return $this->couldBePenalized;
    }

    function isForcePenalize() 
    {
        return $this->forcePenalize;
    }

    function setCouldBePenalized($couldBePenalized) 
    {
        $this->couldBePenalized = $couldBePenalized;
        
        return $this;
    }

    function setForcePenalize($forcePenalize) 
    {
        $this->forcePenalize = $forcePenalize;
        
        return $this;
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
     * Add formulaDetails
     *
     * @param \Pequiven\MasterBundle\Entity\Formula\FormulaDetail $formulaDetails
     * @return Indicator
     */
    public function addFormulaDetail(\Pequiven\MasterBundle\Entity\Formula\FormulaDetail $formulaDetails)
    {
        $formulaDetails->setIndicator($this);
        $this->formulaDetails->add($formulaDetails);

        return $this;
    }

    /**
     * Remove formulaDetails
     *
     * @param \Pequiven\MasterBundle\Entity\Formula\FormulaDetail $formulaDetails
     */
    public function removeFormulaDetail(\Pequiven\MasterBundle\Entity\Formula\FormulaDetail $formulaDetails)
    {
        $this->formulaDetails->removeElement($formulaDetails);
    }

    /**
     * Get formulaDetails
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFormulaDetails()
    {
        return $this->formulaDetails;
    }
}
