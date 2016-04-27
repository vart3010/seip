<?php

namespace Pequiven\MasterBundle\Entity\Formula;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\MasterBundle\Model\Formula\Variable as  Model;
/**
 * Variable
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Pequiven\MasterBundle\Repository\VariableRepository")
 */
class Variable extends Model implements \Pequiven\SEIPBundle\Entity\PeriodItemInterface
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
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;

    /**
     * Ecuacion para calcular el valor de la variable
     * 
     * @var string
     * @ORM\Column(name="equation", type="text", nullable=true)
     */
    private $equation;

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
     * Formulas que usan esta variable
     * 
     * @var \Pequiven\MasterBundle\Entity\Formula
     * @ORM\ManyToMany(targetEntity="Pequiven\MasterBundle\Entity\Formula", mappedBy="variables")
     */
    protected $formulas;
    
    /**
     * Periodo.
     * 
     * @var \Pequiven\SEIPBundle\Entity\Period
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Period")
     * @ORM\JoinColumn(nullable=false)
     */
    private $period;
    
    /**
     * ¿La Variable es estática y no se acumula?
     * @var boolean
     * @ORM\Column(name="staticValue",type="boolean")
     */
    private $staticValue = false;
    
    /**
     * ¿La Variable es usada sólo por una etiqueta del indicador?
     * @var boolean 
     * @ORM\Column(name="usedOnlyByTag",type="boolean")
     */
    private $usedOnlyByTag = false;
    
    /**
     * @var string
     *
     * @ORM\Column(name="summary", type="text", nullable=true)
     */
    private $summary;
    
    /**
     * ¿La Variable será utilizada como real en el dashboard tipo pie del indicador?
     * @var boolean
     * @ORM\Column(name="showRealInDashboardPie",type="boolean")
     */
    private $showRealInDashboardPie = false;
    
    /**
     * ¿La Variable será utilizada como plan en el dashboard tipo pie del indicador?
     * @var boolean
     * @ORM\Column(name="showPlanInDashboardPie",type="boolean")
     */
    private $showPlanInDashboardPie = false;
    
    /**
     * ¿La Variable será utilizada como real en el dashboard tipo barra/área del indicador?
     * @var boolean
     * @ORM\Column(name="showRealInDashboardBarArea",type="boolean")
     */
    private $showRealInDashboardBarArea = false;
    
    /**
     * ¿La Variable será utilizada como plan en el dashboard tipo barra/área del indicador?
     * @var boolean
     * @ORM\Column(name="showPlanInDashboardBarArea",type="boolean")
     */
    private $showPlanInDashboardBarArea = false;
    
    /**
     * ¿La Variable será utilizada como real en el dashboard tipo columna multi series 3d del indicador?
     * @var boolean
     * @ORM\Column(name="showRealInDashboardColumn",type="boolean")
     */
    private $showRealInDashboardColumn = false;
    
    /**
     * ¿La Variable será utilizada como plan en el dashboard tipo columna multi series 3d del indicador?
     * @var boolean
     * @ORM\Column(name="showPlanInDashboardColumn",type="boolean")
     */
    private $showPlanInDashboardColumn = false;
    
    /**
     * Unidad del resultado
     * @var string
     * @ORM\Column(name="unitResult",type="string",length=90, nullable=true)
     */
    private $unitResult;
    
    /**
     * Get staticValue
     *
     * @return boolean 
     */
    public function isStaticValue() {
        return $this->staticValue;
    }

    /**
     * Set staticValue
     * @param type $staticValue
     * @return Variable
     */
    public function setStaticValue($staticValue) {
        $this->staticValue = $staticValue;
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
     * Set description
     *
     * @param string $description
     * @return Variable
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
     * Set name
     *
     * @param string $name
     * @return Variable
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Variable
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
     * @return Variable
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
     * Add formulas
     *
     * @param \Pequiven\MasterBundle\Entity\Formula $formulas
     * @return Variable
     */
    public function addFormula(\Pequiven\MasterBundle\Entity\Formula $formulas)
    {
        $this->formulas[] = $formulas;

        return $this;
    }

    /**
     * Remove formulas
     *
     * @param \Pequiven\MasterBundle\Entity\Formula $formulas
     */
    public function removeFormula(\Pequiven\MasterBundle\Entity\Formula $formulas)
    {
        $this->formulas->removeElement($formulas);
    }

    /**
     * Get formulas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFormulas()
    {
        return $this->formulas;
    }
    
    public function __toString()
    {
        $toString = $this->getName();
        if($this->equation != ''){
            $toString .= ' (EQ)';
        }
        return $toString != '' ? $toString : '-';
    }
    
    function getPeriod() {
        return $this->period;
    }

    function setPeriod(\Pequiven\SEIPBundle\Entity\Period $period) {
        $this->period = $period;
        
        return $this;
    }
    
    public function __clone() {
        if($this->id > 0){
            $this->id = null;
            $this->createdAt = null;
            $this->updatedAt = null;
            $this->period = null;
        }
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->formulas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set equation
     *
     * @param string $equation
     * @return Variable
     */
    public function setEquation($equation)
    {
        $this->equation = $equation;

        return $this;
    }

    /**
     * Get equation
     *
     * @return string 
     */
    public function getEquation()
    {
        return $this->equation;
    }
    
    /**
     * Get usedOnlyByTag
     *
     * @return boolean 
     */
    public function getUsedOnlyByTag()
    {
        return $this->usedOnlyByTag;
    }

    /**
     * Set usedOnlyByTag
     * @param type $usedOnlyByTag
     * @return Variable
     */
    public function setUsedOnlyByTag($usedOnlyByTag) {
        $this->usedOnlyByTag = $usedOnlyByTag;
    }
    
        /**
     * Set summary
     *
     * @param string $summary
     * @return Indicator
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * Get summary
     *
     * @return string 
     */
    public function getSummary()
    {
        return $this->summary;
    }
    
    /**
     * Get showRealInDashboardPie
     *
     * @return boolean 
     */
    public function getShowRealInDashboardPie()
    {
        return $this->showRealInDashboardPie;
    }

    /**
     * Set showRealInDashboardPie
     * @param type $showRealInDashboardPie
     * @return Variable
     */
    public function setShowRealInDashboardPie($showRealInDashboardPie) {
        $this->showRealInDashboardPie = $showRealInDashboardPie;
    }
    
    /**
     * Get showPlanInDashboardPie
     *
     * @return boolean 
     */
    public function getShowPlanInDashboardPie()
    {
        return $this->showPlanInDashboardPie;
    }

    /**
     * Set showPlanInDashboardPie
     * @param type $showPlanInDashboardPie
     * @return Variable
     */
    public function setShowPlanInDashboardPie($showPlanInDashboardPie) {
        $this->showPlanInDashboardPie = $showPlanInDashboardPie;
    }
    
    /**
     * Get showRealInDashboardBarArea
     *
     * @return boolean 
     */
    public function getShowRealInDashboardBarArea()
    {
        return $this->showRealInDashboardBarArea;
    }

    /**
     * Set showRealInDashboardBarArea
     * @param type $showRealInDashboardBarArea
     * @return Variable
     */
    public function setShowRealInDashboardBarArea($showRealInDashboardBarArea) {
        $this->showRealInDashboardBarArea = $showRealInDashboardBarArea;
    }
    
    /**
     * Get showPlanInDashboardBarArea
     *
     * @return boolean 
     */
    public function getShowPlanInDashboardBarArea()
    {
        return $this->showPlanInDashboardBarArea;
    }

    /**
     * Set showPlanInDashboardBarArea
     * @param type $showPlanInDashboardBarArea
     * @return Variable
     */
    public function setShowPlanInDashboardBarArea($showPlanInDashboardBarArea) {
        $this->showPlanInDashboardBarArea = $showPlanInDashboardBarArea;
    }
    
    /**
     * Get showRealInDashboardColumn
     *
     * @return boolean 
     */
    public function getShowRealInDashboardColumn()
    {
        return $this->showRealInDashboardColumn;
    }

    /**
     * Set showRealInDashboardColumn
     * @param type $showRealInDashboardColumn
     * @return Variable
     */
    public function setShowRealInDashboardColumn($showRealInDashboardColumn) {
        $this->showRealInDashboardColumn = $showRealInDashboardColumn;
    }
    
    /**
     * Get showPlanInDashboardColumn
     *
     * @return boolean 
     */
    public function getShowPlanInDashboardColumn()
    {
        return $this->showPlanInDashboardColumn;
    }

    /**
     * Set showPlanInDashboardColumn
     * @param type $showPlanInDashboardColumn
     * @return Variable
     */
    public function setShowPlanInDashboardColumn($showPlanInDashboardColumn) {
        $this->showPlanInDashboardColumn = $showPlanInDashboardColumn;
    }
    
    /**
     * Get unitResult
     * 
     * @return String
     */
    function getUnitResult() {
        return $this->unitResult;
    }

    /**
     * Set unitResult
     * 
     * @param type $unitResult
     * @return Variable
     */
    function setUnitResult($unitResult) {
        $this->unitResult = $unitResult;
    }
    
    function getUnitResultValue()
    {
        $result = "";
        if($this->unitResult != ""){
            $unit = @json_decode($this->unitResult);
            if($unit->unit){
                $result = $unit->unit;
            }
        }
        return $result;
    }
    
}
