<?php

namespace Pequiven\IndicatorBundle\Entity\Indicator;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\IndicatorBundle\Model\Indicator\IndicatorDetails as Model;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Detalles del indicador
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 * @ORM\Table()
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class IndicatorDetails extends Model {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Ultimo valor del indicador
     * 
     * @var integer
     * @ORM\Column(name="previusValue", type="float",precision = 3)
     */
    private $previusValue = 0;

    /**
     * Persona que notifico la ultima vez valor al indicador
     * 
     * @var \Pequiven\SEIPBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\User")
     */
    private $lastNotificationBy;

    /**
     * Fecha de ultima notificacion
     * 
     * @var \DateTime
     * @ORM\Column(name="lastNotificationAt", type="datetime",nullable=true)
     */
    private $lastNotificationAt;

    /**
     * Ultimos parametros de las variables de la formula
     * 
     * @var array
     * @ORM\Column(name="lastNotificationParameters",type="array")
     */
    private $lastNotificationParameters;

    /**
     * Formula
     * @var \Pequiven\MasterBundle\Entity\Formula
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Formula")
     */
    private $lastFormulaUsed;

    /**
     * Tipo de unidad (Resultado de gestion)
     * @var string
     * @ORM\Column(name="resultManagementUnitType",type="string",length=50, nullable=true)
     */
    private $resultManagementUnitType;

    /**
     * Unidad (Resultado de gestion)
     * @var string
     * @ORM\Column(name="resultManagementUnit",type="string",length=90, nullable=true)
     */
    private $resultManagementUnit;

    /**
     * Unidad concatenada (Resultado de gestion)
     * @var string
     * @ORM\Column(name="resultManagementUnitGroup",type="string",length=90, nullable=true)
     */
    private $resultManagementUnitGroup;

    /**
     * Tipo de unidad (Resultado del plan)
     * @var string
     * @ORM\Column(name="resultPlanUnitType",type="string",length=50, nullable=true)
     */
    private $resultPlanUnitType;

    /**
     * Unidad (Resultado del plan)
     * @var string
     * @ORM\Column(name="resultPlanUnit",type="string",length=90, nullable=true)
     */
    private $resultPlanUnit;

    /**
     * Unidad concatenada (Resultado del plan)
     * @var string
     * @ORM\Column(name="resultPlanUnitGroup",type="string",length=90, nullable=true)
     */
    private $resultPlanUnitGroup;

    /**
     * Tipo de unidad (Resultado del real)
     * @var string
     * @ORM\Column(name="resultRealUnitType",type="string",length=50, nullable=true)
     */
    private $resultRealUnitType;

    /**
     * Unidad (Resultado del real)
     * @var string
     * @ORM\Column(name="resultRealUnit",type="string",length=90, nullable=true)
     */
    private $resultRealUnit;

    /**
     * Unidad concatenada (Resultado del real)
     * @var string
     * @ORM\Column(name="resultRealUnitGroup",type="string",length=90, nullable=true)
     */
    private $resultRealUnitGroup;

    /**
     *
     * @var \Pequiven\IndicatorBundle\Entity\Indicator
     * @ORM\OneToOne(targetEntity="Pequiven\IndicatorBundle\Entity\Indicator",mappedBy="details",cascade={"persist","remove"})
     */
    private $indicator;

    /**
     * Origen de resultado
     * @var integer
     * @ORM\Column(name="sourceResult",type="integer")
     */
    private $sourceResult = self::SOURCE_RESULT_ALL;

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
     * @ORM\Column(name="approvalDate", type="datetime",nullable=true)
     */
    private $approvalDate;

    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     *
     * @var type 
     * @ORM\Column(name="showlValueReal",type="boolean", nullable=true)
     */
    //private $showlValueReal = false;

    /** Variable de la formula del indicador para mostrar Valor Real
     * @var string
     * @ORM\Column(name="varIndicatorReal",type="string",length=90, nullable=true)
     * */
    
    
    
     /**
     * Formulas que usan esta variable
     * 
     * @var \Pequiven\MasterBundle\Entity\Formula
     * @ORM\ManyToOne(targetEntity="Pequiven\MasterBundle\Entity\Formula\Variable")
     */
    private $varIndicatorReal;

    /**
     *
     * @var type 
     * @ORM\Column(name="isCheckReal",type="boolean", nullable=true)
     */
    private $isCheckReal = false;

    /**
     *
     * @var type 
     * @ORM\Column(name="isCheckPlan",type="boolean", nullable=true)
     */
    private $isCheckPlan = false;

    
    /**
     * Formulas que usan esta variable
     * 
     * @var \Pequiven\MasterBundle\Entity\Formula
     * @ORM\ManyToOne(targetEntity="Pequiven\MasterBundle\Entity\Formula\Variable")
     */
    private $varIndicatorPlan;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set previusValue
     *
     * @param integer $previusValue
     * @return IndicatorDetails
     */
    public function setPreviusValue($previusValue) {
        $this->previusValue = $previusValue;

        return $this;
    }

    /**
     * Get previusValue
     *
     * @return integer 
     */
    public function getPreviusValue() {
        return $this->previusValue;
    }

    /**
     * Set lastNotificationAt
     *
     * @param \DateTime $lastNotificationAt
     * @return IndicatorDetails
     */
    public function setLastNotificationAt($lastNotificationAt) {
        $this->lastNotificationAt = $lastNotificationAt;

        return $this;
    }

    /**
     * Get lastNotificationAt
     *
     * @return \DateTime 
     */
    public function getLastNotificationAt() {
        return $this->lastNotificationAt;
    }

    /**
     * Set lastNotificationBy
     *
     * @param \Pequiven\SEIPBundle\Entity\User $lastNotificationBy
     * @return IndicatorDetails
     */
    public function setLastNotificationBy(\Pequiven\SEIPBundle\Entity\User $lastNotificationBy = null) {
        $this->lastNotificationBy = $lastNotificationBy;

        return $this;
    }

    /**
     * Get lastNotificationBy
     *
     * @return \Pequiven\SEIPBundle\Entity\User 
     */
    public function getLastNotificationBy() {
        return $this->lastNotificationBy;
    }

    /**
     * Set lastNotificationParameters
     *
     * @param array $lastNotificationParameters
     * @return IndicatorDetails
     */
    public function setLastNotificationParameters($lastNotificationParameters) {
        $this->lastNotificationParameters = $lastNotificationParameters;

        return $this;
    }

    /**
     * Get lastNotificationParameters
     *
     * @return array 
     */
    public function getLastNotificationParameters() {
        return $this->lastNotificationParameters;
    }

    function getLastFormulaUsed() {
        return $this->lastFormulaUsed;
    }

    function setLastFormulaUsed(\Pequiven\MasterBundle\Entity\Formula $lastFormulaUsed) {
        $this->lastFormulaUsed = $lastFormulaUsed;

        return $this;
    }

    /**
     * Set resultManagementUnitType
     *
     * @param string $resultManagementUnitType
     * @return IndicatorDetails
     */
    public function setResultManagementUnitType($resultManagementUnitType) {
        $this->resultManagementUnitType = $resultManagementUnitType;

        return $this;
    }

    /**
     * Get resultManagementUnitType
     *
     * @return string 
     */
    public function getResultManagementUnitType() {
        return $this->resultManagementUnitType;
    }

    /**
     * Set resultManagementUnit
     *
     * @param string $resultManagementUnit
     * @return IndicatorDetails
     */
    public function setResultManagementUnit($resultManagementUnit) {
        $this->resultManagementUnit = $resultManagementUnit;

        return $this;
    }

    /**
     * Get resultManagementUnit
     *
     * @return string 
     */
    public function getResultManagementUnit() {
        return $this->resultManagementUnit;
    }

    /**
     * Set resultManagementUnitGroup
     *
     * @param string $resultManagementUnitGroup
     * @return IndicatorDetails
     */
    public function setResultManagementUnitGroup($resultManagementUnitGroup) {
        $this->resultManagementUnitGroup = $resultManagementUnitGroup;

        return $this;
    }

    /**
     * Get resultManagementUnitGroup
     *
     * @return string 
     */
    public function getResultManagementUnitGroup() {
        return $this->resultManagementUnitGroup;
    }

    /**
     * Set resultPlanUnitType
     *
     * @param string $resultPlanUnitType
     * @return IndicatorDetails
     */
    public function setResultPlanUnitType($resultPlanUnitType) {
        $this->resultPlanUnitType = $resultPlanUnitType;

        return $this;
    }

    /**
     * Get resultPlanUnitType
     *
     * @return string 
     */
    public function getResultPlanUnitType() {
        return $this->resultPlanUnitType;
    }

    /**
     * Set resultPlanUnit
     *
     * @param string $resultPlanUnit
     * @return IndicatorDetails
     */
    public function setResultPlanUnit($resultPlanUnit) {
        $this->resultPlanUnit = $resultPlanUnit;

        return $this;
    }

    /**
     * Get resultPlanUnit
     *
     * @return string 
     */
    public function getResultPlanUnit() {
        return $this->resultPlanUnit;
    }

    /**
     * Set resultPlanUnitGroup
     *
     * @param string $resultPlanUnitGroup
     * @return IndicatorDetails
     */
    public function setResultPlanUnitGroup($resultPlanUnitGroup) {
        $this->resultPlanUnitGroup = $resultPlanUnitGroup;

        return $this;
    }

    /**
     * Get resultPlanUnitGroup
     *
     * @return string 
     */
    public function getResultPlanUnitGroup() {
        return $this->resultPlanUnitGroup;
    }

    /**
     * Set resultRealUnitType
     *
     * @param string $resultRealUnitType
     * @return IndicatorDetails
     */
    public function setResultRealUnitType($resultRealUnitType) {
        $this->resultRealUnitType = $resultRealUnitType;

        return $this;
    }

    /**
     * Get resultRealUnitType
     *
     * @return string 
     */
    public function getResultRealUnitType() {
        return $this->resultRealUnitType;
    }

    /**
     * Set resultRealUnit
     *
     * @param string $resultRealUnit
     * @return IndicatorDetails
     */
    public function setResultRealUnit($resultRealUnit) {
        $this->resultRealUnit = $resultRealUnit;

        return $this;
    }

    /**
     * Get resultRealUnit
     *
     * @return string 
     */
    public function getResultRealUnit() {
        return $this->resultRealUnit;
    }

    /**
     * Set resultRealUnitGroup
     *
     * @param string $resultRealUnitGroup
     * @return IndicatorDetails
     */
    public function setResultRealUnitGroup($resultRealUnitGroup) {
        $this->resultRealUnitGroup = $resultRealUnitGroup;

        return $this;
    }

    /**
     * Get resultRealUnitGroup
     *
     * @return string 
     */
    public function getResultRealUnitGroup() {
        return $this->resultRealUnitGroup;
    }

    /**
     * Set indicator
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator $indicator
     * @return IndicatorDetails
     */
    public function setIndicator(\Pequiven\IndicatorBundle\Entity\Indicator $indicator = null) {
        $this->indicator = $indicator;

        return $this;
    }

    /**
     * Get indicator
     *
     * @return \Pequiven\IndicatorBundle\Entity\Indicator 
     */
    public function getIndicator() {
        return $this->indicator;
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist() {
        $this->updateValues();
    }

    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate() {
        $this->updateValues();
    }

    private function updateValues() {
        if ($this->resultManagementUnitGroup) {
            $unitGroup = json_decode($this->resultManagementUnitGroup);
            $this->resultManagementUnitType = $unitGroup->unitType;
            $this->resultManagementUnit = $unitGroup->unit;
        }

        if ($this->resultPlanUnitGroup) {
            $unitGroup = json_decode($this->resultPlanUnitGroup);
            $this->resultPlanUnitType = $unitGroup->unitType;
            $this->resultPlanUnit = $unitGroup->unit;
        }

        if ($this->resultRealUnitGroup) {
            $unitGroup = json_decode($this->resultRealUnitGroup);
            $this->resultRealUnitType = $unitGroup->unitType;
            $this->resultRealUnit = $unitGroup->unit;
        }
    }

    public function __toString() {
        $toString = '-';
        if ($this->id > 0) {
            $toString = $this->id . '';
        }
        return $toString;
    }

    /**
     * Set sourceResult
     *
     * @param integer $sourceResult
     * @return IndicatorDetails
     */
    public function setSourceResult($sourceResult) {
        $this->sourceResult = $sourceResult;

        return $this;
    }

    /**
     * Get sourceResult
     *
     * @return integer 
     */
    public function getSourceResult() {
        return $this->sourceResult;
    }

    /**
     * Set approvalDate
     *
     * @param \DateTime $approvalDate
     * @return ObjetiveDetails
     */
    public function setApprovalDate($approvalDate) {
        $this->approvalDate = $approvalDate;

        return $this;
    }

    /**
     * Get approvalDate
     *
     * @return \DateTime 
     */
    public function getApprovalDate() {
        return $this->approvalDate;
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     * @return ObjetiveDetails
     */
    public function setDeletedAt($deletedAt) {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime 
     */
    public function getDeletedAt() {
        return $this->deletedAt;
    }

    /**
     * Set approvedBy
     *
     * @param \Pequiven\SEIPBundle\Entity\User $approvedBy
     * @return ObjetiveDetails
     */
    public function setApprovedBy(\Pequiven\SEIPBundle\Entity\User $approvedBy = null) {
        $this->approvedBy = $approvedBy;

        return $this;
    }

    /**
     * Get approvedBy
     *
     * @return \Pequiven\SEIPBundle\Entity\User 
     */
    public function getApprovedBy() {
        return $this->approvedBy;
    }

    /**
     * 
     * @param \Pequiven\MasterBundle\Entity\Formula\Variable $varIndicatorReal
     * @return \Pequiven\IndicatorBundle\Entity\Indicator\IndicatorDetails
     */
    public function setVarIndicatorReal(\Pequiven\MasterBundle\Entity\Formula\Variable $varIndicatorReal) {
        $this->varIndicatorReal = $varIndicatorReal;
        //return $this;
    }
    
    /**
     * 
     * @return type
     */
    public function getVarIndicatorReal() {
        return $this->varIndicatorReal;
    }

    
    /**
     * 
     * @param \Pequiven\MasterBundle\Entity\Formula\Variable $varIndicatorPlan
     * @return \Pequiven\IndicatorBundle\Entity\Indicator\IndicatorDetails
     */
    public function setVarIndicatorPlan(\Pequiven\MasterBundle\Entity\Formula\Variable $varIndicatorPlan) {
        $this->varIndicatorPlan = $varIndicatorPlan;
        return $this;
    }
    
    /**
     * 
     * @return type
     */
    public function getVarIndicatorPlan() {
        return $this->varIndicatorPlan;
    }

    /**
     * 
     * @param type $isCheckReal
     */
    public function setIsCheckReal($isCheckReal) {
        $this->isCheckReal = $isCheckReal;
    }
    /**
     * 
     * @return type
     */
    public function getIsCheckReal() {
        return $this->isCheckReal;
    }

    
    /**
     * 
     * @param type $isCheckPlan
     */
    public function setIsCheckPlan($isCheckPlan) {
        $this->isCheckPlan = $isCheckPlan;
    }

    /**
     * 
     * @return type
     */
    public function getIsCheckPlan() {
        return $this->isCheckPlan;
    }

}
