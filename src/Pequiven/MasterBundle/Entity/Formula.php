<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\MasterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\MasterBundle\Model\Formula as modelFormula;

/**
 * Formula
 *
 * @ORM\Table(name="seip_c_formula")
 * @ORM\Entity(repositoryClass="Pequiven\MasterBundle\Repository\FormulaRepository")
 * @author matias
 */
class Formula extends modelFormula implements \Pequiven\SEIPBundle\Entity\PeriodItemInterface
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
     * @ORM\Column(name="description", type="string", length=300, nullable=true)
     */
    private $description;
    
    /**
     * Ecuacion
     * 
     * @var string
     * @ORM\Column(name="equation", type="text")
     */
    private $equation;
    
    /**
     * Ecuacion real con variables
     * @var string
     * @ORM\Column(name="equationReal", type="text")
     */
    private $equationReal;
    
    /**
     * FormulaLevel
     * @var \Pequiven\MasterBundle\Entity\FormulaLevel
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\FormulaLevel")
     * @ORM\JoinColumn(name="fk_formula_level", referencedColumnName="id")
     */
    private $formulaLevel;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled = true;
    
    /**
     * Variables de la formula
     * 
     * @var \Pequiven\MasterBundle\Entity\Formula\Variable
     * @ORM\ManyToMany(targetEntity="Pequiven\MasterBundle\Entity\Formula\Variable", inversedBy="formulas")
     */
    protected $variables;
    
    /**
     * Variable para calcular el valor Real.
     * @var \Pequiven\MasterBundle\Entity\Formula\Variable
     * @ORM\ManyToOne(targetEntity="Pequiven\MasterBundle\Entity\Formula\Variable")
     */
    protected $variableToRealValue;
    
    /**
     * Variable para calcular el valor Plan.
     * @var \Pequiven\MasterBundle\Entity\Formula\Variable
     * @ORM\ManyToOne(targetEntity="Pequiven\MasterBundle\Entity\Formula\Variable")
     */
    protected $variableToPlanValue;

    /**
     * Ecuacion para calcular el valor real (Se puede usar las variables de la formula)
     * 
     * @var string
     * @ORM\Column(name="sourceEquationReal", type="text",nullable=true)
     */
    private $sourceEquationReal;
    
    /**
     * Ecuacion para calcular el valor planificado (Se puede usar las variables de la formula)
     * 
     * @var string
     * @ORM\Column(name="sourceEquationPlan", type="text",nullable=true)
     */
    private $sourceEquationPlan;
    
    /**
     * Ecuacion para calcular el valor real a mostrar en los gráficos tipo dona, r/p por frecuencia de notificación (Se pueden usar las variables de la formula)
     * 
     * @var string
     * @ORM\Column(name="dashboardEquationReal", type="text",nullable=true)
     */
    private $dashboardEquationReal;
    
    /**
     * Ecuacion para calcular el valor plan a mostrar en los gráficos tipo dona, r/p por frecuencia de notificación (Se pueden usar las variables de la formula)
     * 
     * @var string
     * @ORM\Column(name="dashboardEquationPlan", type="text",nullable=true)
     */
    private $dashboardEquationPlan;
    
    /**
     * Ecuacion para calcular el valor real a mostrar en la ficha del indicador, para cuando este activado el isValueRealFromEquationRealFormula del indicador
     * 
     * @var string
     * @ORM\Column(name="cardEquationReal", type="text",nullable=true)
     */
    private $cardEquationReal;
    
    /**
     * Ecuacion para calcular el valor plan a mostrar en la ficha del indicador, para cuando este activado el isValuePlanFromEquationPlanFormula del indicador
     * 
     * @var string
     * @ORM\Column(name="cardEquationPlan", type="text",nullable=true)
     */
    private $cardEquationPlan;
    
     /**
     * Periodo.
     * 
     * @var \Pequiven\SEIPBundle\Entity\Period
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Period")
     * @ORM\JoinColumn(nullable=false)
     */
    private $period;
    
    /**
     *
     * @var \Pequiven\IndicatorBundle\Entity\Indicator
     * @ORM\OneToMany(targetEntity="Pequiven\IndicatorBundle\Entity\Indicator",mappedBy="formula")
     */
    private $indicators;

    public function __construct() {
        $this->variables = new ArrayCollection();
        $this->indicators = new ArrayCollection();
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
     * @return Formula
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
     * @return Formula
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
     * @return Formula
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
     * Set equation
     *
     * @param string $equation
     * @return Formula
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
     * Set userCreatedAt
     *
     * @param \Pequiven\SEIPBundle\Entity\User $userCreatedAt
     * @return Formula
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
     * @return Formula
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
     * Set enabled
     *
     * @param boolean $enabled
     * @return Formula
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
     * Set formulaLevel
     *
     * @param \Pequiven\MasterBundle\Entity\FormulaLevel $formulaLevel
     * @return Formula
     */
    public function setFormulaLevel(\Pequiven\MasterBundle\Entity\FormulaLevel $formulaLevel = null)
    {
        $this->formulaLevel = $formulaLevel;

        return $this;
    }

    /**
     * Get formulaLevel
     *
     * @return \Pequiven\MasterBundle\Entity\FormulaLevel 
     */
    public function getFormulaLevel()
    {
        return $this->formulaLevel;
    }

    /**
     * Add variables
     *
     * @param \Pequiven\MasterBundle\Entity\Formula\Variable $variables
     * @return Formula
     */
    public function addVariable(\Pequiven\MasterBundle\Entity\Formula\Variable $variables)
    {
        $this->variables[] = $variables;

        return $this;
    }

    /**
     * Remove variables
     *
     * @param \Pequiven\MasterBundle\Entity\Formula\Variable $variables
     */
    public function removeVariable(\Pequiven\MasterBundle\Entity\Formula\Variable $variables)
    {
        $this->variables->removeElement($variables);
    }

    /**
     * Get variables
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVariables()
    {
        return $this->variables;
    }

    /**
     * Set equationReal
     *
     * @param string $equationReal
     * @return Formula
     */
    public function setEquationReal($equationReal)
    {
        $this->equationReal = $equationReal;

        return $this;
    }

    /**
     * Get equationReal
     *
     * @return string 
     */
    public function getEquationReal()
    {
        return $this->equationReal;
    }
    
    /**
     * Retorna el tipo de calculo de la formula
     * @return integer
     */
    function getTypeOfCalculation() 
    {
        return $this->typeOfCalculation;
    }
    
    /**
     * Establece el tipo de calculo de la formula
     * 
     * @param integer $typeOfCalculation Formula::TYPE_CALCULATION_*
     * @return Formula
     */
    function setTypeOfCalculation($typeOfCalculation) {
        $this->typeOfCalculation = $typeOfCalculation;
        
        return $this;
    }
    
    /**
     * Set variableToRealValue
     *
     * @param \Pequiven\MasterBundle\Entity\Formula\Variable $variableToRealValue
     * @return Formula
     */
    public function setVariableToRealValue(\Pequiven\MasterBundle\Entity\Formula\Variable $variableToRealValue = null)
    {
        $this->variableToRealValue = $variableToRealValue;

        return $this;
    }

    /**
     * Get variableToRealValue
     *
     * @return \Pequiven\MasterBundle\Entity\Formula\Variable 
     */
    public function getVariableToRealValue()
    {
        return $this->variableToRealValue;
    }

    /**
     * Set variableToPlanValue
     *
     * @param \Pequiven\MasterBundle\Entity\Formula\Variable $variableToPlanValue
     * @return Formula
     */
    public function setVariableToPlanValue(\Pequiven\MasterBundle\Entity\Formula\Variable $variableToPlanValue = null)
    {
        $this->variableToPlanValue = $variableToPlanValue;

        return $this;
    }

    /**
     * Get variableToPlanValue
     *
     * @return \Pequiven\MasterBundle\Entity\Formula\Variable 
     */
    public function getVariableToPlanValue()
    {
        return $this->variableToPlanValue;
    }
    
    
    function getSourceEquationReal() {
        return $this->sourceEquationReal;
    }

    function getSourceEquationPlan() {
        return $this->sourceEquationPlan;
    }

    function setSourceEquationReal($sourceEquationReal) {
        $this->sourceEquationReal = $sourceEquationReal;
        
        return $this;
    }

    function setSourceEquationPlan($sourceEquationPlan) {
        $this->sourceEquationPlan = $sourceEquationPlan;
        
        return $this;
    }

    public function __toString() 
    {
        $toString = \Pequiven\SEIPBundle\Service\ToolService::truncate($this->getEquation());
        return $toString != '' ? $toString : '-';
    }
    
    function setVariables($variables) {
        $this->variables = $variables;
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
            $this->userCreatedAt = null;
            $this->userUpdatedAt = null;
            
            $this->period = null;
        }
    }
    
    /**
     * Add indicators
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator $indicators
     * @return Formula
     */
    public function addIndicator(\Pequiven\IndicatorBundle\Entity\Indicator $indicators)
    {
        $this->indicators->add($indicators);

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
    
    /**
     * Set dashboardEquationReal
     *
     * @param text $dashboardEquationReal
     * @return Formula
     */
    public function setDashboardEquationReal($dashboardEquationReal)
    {
        $this->dashboardEquationReal = $dashboardEquationReal;

        return $this;
    }

    /**
     * Get dashboardEquationReal
     *
     * @return text
     */
    public function getDashboardEquationReal()
    {
        return $this->dashboardEquationReal;
    }
    
    /**
     * Set dashboardEquationPlan
     *
     * @param text $dashboardEquationPlan
     * @return Formula
     */
    public function setDashboardEquationPlan($dashboardEquationPlan)
    {
        $this->dashboardEquationPlan = $dashboardEquationPlan;

        return $this;
    }

    /**
     * Get dashboardEquationPlan
     *
     * @return text
     */
    public function getDashboardEquationPlan()
    {
        return $this->dashboardEquationPlan;
    }
    
    /**
     * Set cardEquationReal
     *
     * @param text $cardEquationReal
     * @return Formula
     */
    public function setCardEquationReal($cardEquationReal)
    {
        $this->cardEquationReal = $cardEquationReal;

        return $this;
    }

    /**
     * Get cardEquationReal
     *
     * @return text
     */
    public function getCardEquationReal()
    {
        return $this->cardEquationReal;
    }
    
    /**
     * Set cardEquationPlan
     *
     * @param text $cardEquationPlan
     * @return Formula
     */
    public function setCardEquationPlan($cardEquationPlan)
    {
        $this->cardEquationPlan = $cardEquationPlan;

        return $this;
    }

    /**
     * Get cardEquationPlan
     *
     * @return text
     */
    public function getCardEquationPlan()
    {
        return $this->cardEquationPlan;
    }
}
