<?php

namespace Pequiven\IndicatorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\IndicatorBundle\Model\Indicator as ModelIndicator;
use Pequiven\SEIPBundle\Entity\PeriodItemInterface;
use Pequiven\IndicatorBundle\Entity\IndicatorGroup;

/**
 * Indicator
 *
 * @ORM\Table(name="seip_indicator")
 * @ORM\Entity(repositoryClass="Pequiven\IndicatorBundle\Repository\IndicatorRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @ORM\HasLifecycleCallbacks()
 */
class Indicator extends ModelIndicator implements \Pequiven\SEIPBundle\Entity\Result\ResultItemInterface, PeriodItemInterface {

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
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Formula",inversedBy="indicators")
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
     * @var \Pequiven\IndicatorBundle\Entity\Indicator
     * @ORM\OneToOne(targetEntity="\Pequiven\IndicatorBundle\Entity\Indicator")
     * @ORM\JoinColumn(name="indicator_last_period", referencedColumnName="id", nullable=true)
     */
    private $indicatorlastPeriod;

    /**
     * LineStrategic
     * 
     * @var \Pequiven\MasterBundle\Entity\LineStrategic
     * @ORM\ManyToMany(targetEntity="\Pequiven\MasterBundle\Entity\LineStrategic", inversedBy="indicators")
     * @ORM\JoinTable(name="seip_indicators_linestrategics")
     */
    private $lineStrategics;

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
     * Archivos de indicador
     * 
     * @var \Pequiven\IndicatorBundle\Entity\Indicator\IndicatorFile
     * @ORM\OneToMany(targetEntity="Pequiven\IndicatorBundle\Entity\Indicator\IndicatorFile",mappedBy="indicator",cascade={"persist","remove"})
     */
    protected $indicatorFiles;

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
     * Indicador al que suma este indicador (Para el cálculo de resultados)
     * 
     * @var \Pequiven\IndicatorBundle\Entity\Indicator
     * @ORM\ManyToOne(targetEntity="Pequiven\IndicatorBundle\Entity\Indicator",inversedBy="childrens",cascade={"persist"})
     */
    protected $parent;

    /**
     * Indicadores que suman a este indicador (Para el cálculo de resultados)
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
     * ¿Es requerido para importacion? Quiere decir que es obligatorio para el siguiente período a planificar.
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
     * Configuracion de origen de datos de los detalles de los valores de indicadores
     * 
     * @var \Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator\ValueIndicatorConfig
     * @ORM\OneToOne(targetEntity="Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator\ValueIndicatorConfig",inversedBy="indicator")
     * @ORM\JoinColumn(nullable=true)
     */
    private $valueIndicatorConfig;

    /**
     * Etiquetas del indicador
     * 
     * @var \Pequiven\IndicatorBundle\Entity\Indicator\TagIndicator
     * @ORM\OneToMany(targetEntity="Pequiven\IndicatorBundle\Entity\Indicator\TagIndicator",mappedBy="indicator",cascade={"persist","remove"})
     */
    protected $tagsIndicator;

    /**
     * Detalles de los gráficos del Indicador
     * 
     * @var \Pequiven\IndicatorBundle\Entity\Indicator\IndicatorChartDetails
     * @ORM\OneToMany(targetEntity="Pequiven\IndicatorBundle\Entity\Indicator\IndicatorChartDetails",mappedBy="indicator",cascade={"persist","remove"})
     */
    protected $indicatorsChartDetails;

    /**
     * ¿El resultado del indicador se calcula en tipo Porcentaje?
     * @var boolean
     * @ORM\Column(name="resultInPercentage",type="boolean")
     */
    private $resultInPercentage = true;

    /**
     * ¿Se mostrará la etiqueta en vez del resultado de medición?
     * @var boolean
     * @ORM\Column(name="showTagInResult",type="boolean")
     */
    private $showTagInResult = false;

    /**
     * ¿Se mostrará la etiqueta en vez del resultado de medición en el tacómetro?
     * @var boolean
     * @ORM\Column(name="showTagInDashboardResult",type="boolean")
     */
    private $showTagInDashboardResult = false;

    /**
     * ¿Mostar etiqueta "valor" en la ficha del indicador?
     * @var boolean
     * @ORM\Column(name="showRealValue",type="boolean")
     */
    private $showRealValue = true;

    /**
     * ¿Mostar etiqueta "Plan anual" en la ficha del indicador?
     * @var boolean
     * @ORM\Column(name="showPlanValue",type="boolean")
     */
    private $showPlanValue = true;

    /**
     * ¿Mostar resultados del indicador?
     * @var boolean
     * @ORM\Column(name="showResults",type="boolean")
     */
    private $showResults = true;

    /**
     * ¿Mostar puntos de atencion del indicador?
     * @var boolean
     * @ORM\Column(name="showFeatures",type="boolean")
     */
    private $showFeatures = false;

    /**
     * ¿Mostar los gráficos del indicador en la página de dashboard?
     * @var boolean
     * @ORM\Column(name="showCharts",type="boolean")
     */
    private $showCharts = true;

    /**
     * ¿Mostar las etiquetas del indicador en la página del dashboard?
     * @var boolean
     * @ORM\Column(name="showTags",type="boolean")
     */
    private $showTags = false;

    /**
     * ¿Mostar navegación al informe de evolución?
     * @var boolean
     * @ORM\Column(name="showEvolutionView",type="boolean")
     */
    private $showEvolutionView = true;

    /**
     * @var float
     * 
     * @ORM\Column(name="indicatorWeight", type="float", nullable=true)
     */
    private $indicatorWeight = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="summary", type="text", nullable=true)
     */
    private $summary;

    /**
     * ¿Será medido en el período actual?
     * @var boolean
     * @ORM\Column(name="evaluetaInPeriod",type="boolean")
     */
    private $evaluateInPeriod = true;

    /**
     * Snippet para calcular el plan
     * @var string
     * @ORM\Column(name="snippetPlan",type="text",nullable=true)
     */
    protected $snippetPlan;

    /**
     * Snippet para calcular el real
     * @var string
     * @ORM\Column(name="snippetReal",type="text",nullable=true)
     */
    protected $snippetReal;

    /**
     * Puntos de atencion
     * @var Indicator\FeatureIndicator
     * @ORM\OneToMany(targetEntity="Pequiven\IndicatorBundle\Entity\Indicator\FeatureIndicator",mappedBy="indicator")
     */
    protected $featuresIndicator;

    /**
     * @var integer
     *
     * @ORM\Column(name="orderShowFromParent", type="integer")
     */
    private $orderShowFromParent = 1;

    /**
     * Estatus del programa de gestion
     * @var integer
     *
     * @ORM\Column(name="status", type="integer")
     */
    protected $status = self::STATUS_DRAFT;

    /**
     * @ORM\ManyToMany(targetEntity="Pequiven\SIGBundle\Entity\ManagementSystem", inversedBy="indicators", cascade={"persist","remove"})
     * @ORM\JoinTable(name="seip_indicators_management_systems")
     */
    private $managementSystems;

    /**
     * @var string
     *
     * @ORM\Column(name="showByRealValue", type="string", length=50, nullable=true)
     */
    private $showByRealValue;

    /**
     * @var string
     *
     * @ORM\Column(name="showByPlanValue", type="string", length=50, nullable=true)
     */
    private $showByPlanValue;

    /**
     * ¿Será renderizado en un gráfico tipo Pie, y las variables que conforman el equation_real y equation_plan?
     * @var boolean
     * @ORM\Column(name="viewVariablesFromEquationInDashboardPie",type="boolean")
     */
    private $viewVariablesFromEquationInDashboardPie = false;

    /**
     * ¿Las variables que conforman el equation_real y equation_plan, se complementan o son por separadas, es decir en un mismo gráfico o separando las de real y plan en 2 gráficos?
     * @var boolean
     * @ORM\Column(name="variablesRealPlanComplement",type="boolean")
     */
    private $variablesRealPlanComplement = false;

    /**
     * ¿Se quiere mostrar el valor de una variable en lugar del valor real en la ficha del indicador?
     * @var boolean
     * @ORM\Column(name="isValueFromTextReal",type="boolean")
     */
    private $isValueFromTextReal = false;

    /**
     * 
     * @var type 
     * @ORM\Column(name="textValueFromVariableReal",type="text", nullable=true)
     */
    private $textValueFromVariableReal;

    /**
     * ¿Se quiere mostrar el valor de una variable en lugar del valor plan en la ficha del indicador?
     * @var boolean
     * @ORM\Column(name="isValueFromTextPlan",type="boolean")
     */
    private $isValueFromTextPlan = false;

    /**
     * 
     * @var type 
     * @ORM\Column(name="textValueFromVariablePlan",type="text", nullable=true)
     */
    private $textValueFromVariablePlan;

    /**
     * ¿Se quiere mostrar el valor de una ecuación en lugar del valor real en la ficha del indicador?
     * @var boolean
     * @ORM\Column(name="isValueRealFromEquationRealFormula",type="boolean")
     */
    private $isValueRealFromEquationRealFormula = false;

    /**
     * ¿Se quiere mostrar el valor de una ecuación en lugar del valor plan en la ficha del indicador?
     * @var boolean
     * @ORM\Column(name="isValuePlanFromEquationPlanFormula",type="boolean")
     */
    private $isValuePlanFromEquationPlanFormula = false;

    /**
     * ¿Se puede mostrar el rango?
     * @var boolean
     * @ORM\Column(name="showRange",type="boolean")
     */
    private $showRange = true;

    /**
     * Tipo de empresa
     * @var integer
     * @ORM\Column(name="typeOfCompany",type="integer")
     */
    private $typeOfCompany = self::TYPE_OF_COMPANY_MATRIZ;

    /**
     * ¿Se mostrarán las etiquetas en 2 columnas?
     * @var boolean
     * @ORM\Column(name="showTagsInTwoColumns",type="boolean")
     */
    private $showTagsInTwoColumns = false;

    /**
     * ¿Los valores del indicador son acumulativos?
     * @var boolean
     * @ORM\Column(name="resultIsAccumulative",type="boolean")
     */
    private $resultIsAccumulative = false;

    /**
     * ¿Los valores del indicador son acumulativos con el mes?
     * @var boolean
     * @ORM\Column(name="resultIsAccumulativeWithToMonth",type="boolean")
     */
    private $resultIsAccumulativeWithToMonth = false;

    /**
     * ¿En los gráficos de columna, se mostrará una columna al final con el acumulado de lo mostrado antes?
     * @var boolean
     * @ORM\Column(name="showColumnAccumulativeInDashboard",type="boolean")
     */
    private $showColumnAccumulativeInDashboard = false;

    /**
     * ¿En los gráficos de columna, se mostrará una sola columna plan, al final y con el valor de 'plan anual' que es el mismo?
     * @var boolean
     *  @ORM\Column(name="showColumnPlanOneTimeInDashboard",type="boolean")
     */
    private $showColumnPlanOneTimeInDashboard = false;

    /**
     * ¿EL indicador tendrá en cuenta sólo los resultados de los hijos, para el cálculo del resultado final?
     * @var boolean
     *  @ORM\Column(name="resultIsFromChildrensResult",type="boolean")
     */
    private $resultIsFromChildrensResult = false;

    /**
     * ¿EL indicador tendrá en cuencta resultados adicionales para mostrarlo en una columna nueva?
     * @var boolean
     * @ORM\Column(name="resultsAdditionalInDashboardColumn",type="boolean")
     */
    private $resultsAdditionalInDashboardColumn = false;

    /**
     * ¿En los gráficos de columna, se mostrará una columna plan, al final y con el valor de 'plan anual' que es el mismo?
     * @var boolean
     *  @ORM\Column(name="showColumnPlanAtTheEnd",type="boolean")
     */
    private $showColumnPlanAtTheEnd = false;

    /**
     * ¿EL indicador esta disponible para verse en el dashboard de tipo específico?
     * @var boolean
     *  @ORM\Column(name="showByDashboardSpecific",type="boolean")
     */
    private $showByDashboardSpecific = false;

    /**
     * Complejo
     * 
     * @var \Pequiven\MasterBundle\Entity\Complejo
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Complejo")
     * @ORM\JoinColumn(nullable=true)
     */
    private $complejoDashboardSpecific;

    /**
     * ¿EL indicador tomará en cuenta las variables de valor estático?
     * @var boolean
     *  @ORM\Column(name="validVariableStaticValue",type="boolean")
     */
    private $validVariableStaticValue = false;

    /**
     * @var integer
     * 
     * @ORM\Column(name="indicator_sig_medition", type="integer", nullable=true)
     */
    private $indicatorSigMedition = 1;

    /**
     * Indicador
     * 
     * @var \Pequiven\IndicatorBundle\Entity\Indicator
     * @ORM\ManyToOne(targetEntity="Pequiven\IndicatorBundle\Entity\Indicator",inversedBy="indicatorEvolutionCloning",cascade={"persist"})
     */
    protected $parentCloning;

    /**
     * @var \Pequiven\IndicatorBundle\Entity\Indicator
     *
     * @ORM\OneToMany(targetEntity="Pequiven\IndicatorBundle\Entity\Indicator",mappedBy="parentCloning",cascade={"persist"}))          
     */
    private $indicatorEvolutionCloning;

    /**
     * ¿El indicador esta disponible para verse en el dashboard de forma trimestral? (Para aquellos cuya frecuencia de notificación sea mensual)
     * @var boolean
     *  @ORM\Column(name="showDashboardByQuarter",type="boolean")
     */
    private $showDashboardByQuarter = false;

    /**
     * ¿Mostrar notificacion de indicador no evaluado en periodo actual?
     * @var boolean
     *  @ORM\Column(name="notshowIndicatorNoEvaluateInPeriod",type="boolean")
     */
    private $notshowIndicatorNoEvaluateInPeriod = false;

    /**
     * ¿EL indicador será ignorado para el resultado del indicador padre?
     * @var boolean
     *  @ORM\Column(name="ignoredByParentResult",type="boolean")
     */
    private $ignoredByParentResult = false;

    /**
     * check para activar la carga de  archivos
     * @var boolean
     *  @ORM\Column(name="loadFiles",type="boolean")
     */
    private $loadFiles = false;

    /**
     * Número del resultado para forzar
     * @var integer
     * @ORM\Column(name="numberValueIndicatorToForce",type="integer", nullable=true)
     */
    private $numberValueIndicatorToForce = 1;

    /**
     * ¿Mostrar grafico de barras hasta mes consultado o global?
     * @var boolean
     *  @ORM\Column(name="viewDataChartIndicatorEvolution",type="boolean")
     */
    private $viewDataChartEvolutionConsultedMonth = false;

    /**
     * Decimales en Gráfica de Informe de Evolución
     * @var integer
     *  @ORM\Column(name="decimalsToChartEvolution",type="integer")
     */
    private $decimalsToChartEvolution = 0;

    /**
     * ¿Se puede mostrar el rango?
     * @var boolean
     * @ORM\Column(name="showResultWithoutPercentageInDashboard",type="boolean", nullable=true)
     */
    private $showResultWithoutPercentageInDashboard = true;

    /**
     * Charts
     * 
     * @var \Pequiven\SEIPBundle\Entity\Chart
     * @ORM\ManyToMany(targetEntity="\Pequiven\SEIPBundle\Entity\Chart", inversedBy="indicators")
     * @ORM\JoinTable(name="seip_indicators_charts")
     */
    private $charts;

    /**
     * Grupo     
     * @var IndicatorGroup
     * @ORM\ManyToMany(targetEntity="Pequiven\IndicatorBundle\Entity\IndicatorGroup",inversedBy="indicators")     
     * @ORM\JoinTable(name="seip_indicatorgroup_indicator")     
     */
    private $indicatorGroup;

    /**
     * @var boolean
     * @ORM\Column(name="showIndicatorGroups", type="boolean")
     */
    private $showIndicatorGroups = false;
    
    /**
     * ¿El Valor Plan del Indicador no acumula?
     * @var boolean
     * @ORM\Column(name="planIsNotAccumulative",type="boolean")
     */
    private $planIsNotAccumulative = false;

    /**
     * Constructor
     */
    public function __construct() {

        $this->objetives = new \Doctrine\Common\Collections\ArrayCollection();
        $this->lineStrategics = new \Doctrine\Common\Collections\ArrayCollection();
        $this->valuesIndicator = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tagsIndicator = new \Doctrine\Common\Collections\ArrayCollection();
        $this->childrens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->formulaDetails = new \Doctrine\Common\Collections\ArrayCollection();
        $this->featuresIndicator = new \Doctrine\Common\Collections\ArrayCollection();
        $this->charts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->managementSystems = new \Doctrine\Common\Collections\ArrayCollection();
        $this->indicatorGroup = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Indicator
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
     * @return Indicator
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
     * @return Indicator
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
     * Set ref
     *
     * @param string $ref
     * @return Indicator
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
     * Set weight
     *
     * @param float $weight
     * @return Indicator
     */
    public function setWeight($weight) {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Set goal
     *
     * @param float $goal
     * @return Indicator
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
     * Set enabled
     *
     * @param boolean $enabled
     * @return Indicator
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
     * Set userCreatedAt
     *
     * @param \Pequiven\SEIPBundle\Entity\User $userCreatedAt
     * @return Indicator
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
     * @return Indicator
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
     * Set formula
     *
     * @param \Pequiven\MasterBundle\Entity\Formula $formula
     * @return Indicator
     */
    public function setFormula(\Pequiven\MasterBundle\Entity\Formula $formula = null) {
        $this->formula = $formula;

        return $this;
    }

    /**
     * Get formula
     *
     * @return \Pequiven\MasterBundle\Entity\Formula 
     */
    public function getFormula() {
        return $this->formula;
    }

    /**
     * Set tendency
     *
     * @param \Pequiven\MasterBundle\Entity\Tendency $tendency
     * @return Indicator
     */
    public function setTendency(\Pequiven\MasterBundle\Entity\Tendency $tendency = null) {
        $this->tendency = $tendency;

        return $this;
    }

    /**
     * Get tendency
     *
     * @return \Pequiven\MasterBundle\Entity\Tendency 
     */
    public function getTendency() {
        return $this->tendency;
    }

    /**
     * Set tmp
     *
     * @param boolean $tmp
     * @return Indicator
     */
    public function setTmp($tmp) {
        $this->tmp = $tmp;

        return $this;
    }

    /**
     * Get tmp
     *
     * @return boolean 
     */
    public function getTmp() {
        return $this->tmp;
    }

    /**
     * Add objetives
     *
     * @param \Pequiven\ObjetiveBundle\Entity\Objetive $objetives
     * @return Indicator
     */
    public function addObjetive(\Pequiven\ObjetiveBundle\Entity\Objetive $objetives) {
        $objetives->addIndicator($this);
        $this->objetives->add($objetives);

        return $this;
    }

    /**
     * Remove objetives
     *
     * @param \Pequiven\ObjetiveBundle\Entity\Objetive $objetives
     */
    public function removeObjetive(\Pequiven\ObjetiveBundle\Entity\Objetive $objetives) {
        $this->objetives->removeElement($objetives);
    }

    /**
     * Get objetives
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getObjetives() {
        return $this->objetives;
    }

    /**
     * Add indicatorlastPeriod
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator
     * @return Indicator
     */
    public function addIndicatorLastPeriod(\Pequiven\IndicatorBundle\Entity\Indicator $indicatorlastPeriod) {
        $indicatorlastPeriod->addIndicator($this);
        $this->indicatorlastPeriod->add($indicatorlastPeriod);

        return $this;
    }

    /**
     * Remove indicatorlastPeriod
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator $indicatorlastPeriod
     */
    public function removeIndicatorLastPeriod(\Pequiven\IndicatorBundle\Entity\Indicator $indicatorlastPeriod) {
        $this->indicatorlastPeriod->removeElement($indicatorlastPeriod);
    }

    /**
     * Set indicatorlastPeriod
     *
     * @param \Pequiven\ArrangementBundle\Entity\Indicator $indicatorlastPeriod
     * @return Indicator
     */
    public function setIndicatorLastPeriod(\Pequiven\IndicatorBundle\Entity\Indicator $indicatorlastPeriod = null) {
        $this->indicatorlastPeriod = $indicatorlastPeriod;

        return $this;
    }

    /**
     * Get indicatorlastPeriod
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIndicatorLastPeriod() {
        return $this->indicatorlastPeriod;
    }

    /**
     * Set arrangementRange
     *
     * @param \Pequiven\ArrangementBundle\Entity\ArrangementRange $arrangementRange
     * @return Indicator
     */
    public function setArrangementRange(\Pequiven\ArrangementBundle\Entity\ArrangementRange $arrangementRange = null) {
        $this->arrangementRange = $arrangementRange;

        return $this;
    }

    /**
     * Get arrangementRange
     *
     * @return \Pequiven\ArrangementBundle\Entity\ArrangementRange 
     */
    public function getArrangementRange() {
        return $this->arrangementRange;
    }

    /**
     * Set refParent
     *
     * @param string $refParent
     * @return Indicator
     */
    public function setRefParent($refParent) {
        $this->refParent = $refParent;

        return $this;
    }

    /**
     * Get refParent
     *
     * @return string 
     */
    public function getRefParent() {
        return $this->refParent;
    }

    /**
     * Set period
     *
     * @param \Pequiven\SEIPBundle\Entity\Period $period
     * @return Indicator
     */
    public function setPeriod(\Pequiven\SEIPBundle\Entity\Period $period) {
        $this->period = $period;

        return $this;
    }

    /**
     * Get period
     *
     * @return \Pequiven\SEIPBundle\Entity\Period 
     */
    public function getPeriod() {
        return $this->period;
    }

    /**
     * Set frequencyNotificationIndicator
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator\FrequencyNotificationIndicator $frequencyNotificationIndicator
     * @return Indicator
     */
    public function setFrequencyNotificationIndicator(\Pequiven\IndicatorBundle\Entity\Indicator\FrequencyNotificationIndicator $frequencyNotificationIndicator = null) {
        $this->frequencyNotificationIndicator = $frequencyNotificationIndicator;

        return $this;
    }

    /**
     * Get frequencyNotificationIndicator
     *
     * @return \Pequiven\IndicatorBundle\Entity\Indicator\FrequencyNotificationIndicator 
     */
    public function getFrequencyNotificationIndicator() {
        return $this->frequencyNotificationIndicator;
    }

    /**
     * Add valuesIndicator
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator $valuesIndicator
     * @return Indicator
     */
    public function addValuesIndicator(\Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator $valuesIndicator) {
        $valuesIndicator->setIndicator($this);

        $this->valuesIndicator->add($valuesIndicator);

        return $this;
    }

    /**
     * Remove valuesIndicator
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator $valuesIndicator
     */
    public function removeValuesIndicator(\Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator $valuesIndicator) {
        $this->valuesIndicator->removeElement($valuesIndicator);
    }

    /**
     * Get valuesIndicator
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getValuesIndicator() {
        return $this->valuesIndicator;
    }

    /**
     * Get indicatorLevel
     *
     * @return \Pequiven\IndicatorBundle\Entity\IndicatorLevel 
     */
    public function getIndicatorLevel() {
        return $this->indicatorLevel;
    }

    /**
     * Set valueFinal
     *
     * @param string $valueFinal
     * @return Indicator
     */
    public function setValueFinal($valueFinal) {
        $this->progressToDate = 0;
        if ($this->totalPlan != 0 && !$this->getResultIsFromChildrensResult()) {//En caso de que el valor plan sea diferente de cero
            if ($this->resultInPercentage) {//En caso de que el resultado del indicador tenga que convertirse en valor porcentual
                $this->progressToDate = ($valueFinal / $this->totalPlan) * 100;
            } else {
                $this->progressToDate = ($valueFinal / $this->totalPlan);
            }
        } else {
            $this->progressToDate = $valueFinal;
        }
        $this->valueFinal = $valueFinal;

        return $this;
    }

    /**
     * Get valueFinal
     *
     * @return string 
     */
    public function getValueFinal() {
        return $this->valueFinal;
    }

    /**
     * 
     * @return string
     */
    public function __toString() {
        return $this->getDescription() ? $this->getRef() . ' - ' . $this->getDescription() : '-';
    }

    /**
     * Add histories
     *
     * @param \Pequiven\SEIPBundle\Entity\Historical $histories
     * @return Indicator
     */
    public function addHistory(\Pequiven\SEIPBundle\Entity\Historical $histories) {
        $this->histories->add($histories);

        return $this;
    }

    /**
     * Remove histories
     *
     * @param \Pequiven\SEIPBundle\Entity\Historical $histories
     */
    public function removeHistory(\Pequiven\SEIPBundle\Entity\Historical $histories) {
        $this->histories->removeElement($histories);
    }

    /**
     * Get histories
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getHistories() {
        return $this->histories;
    }

    /**
     * Add observations
     *
     * @param \Pequiven\SEIPBundle\Entity\Observation $observations
     * @return Indicator
     */
    public function addObservation(\Pequiven\SEIPBundle\Entity\Observation $observations) {
        $this->observations->add($observations);

        return $this;
    }

    /**
     * Remove observations
     *
     * @param \Pequiven\SEIPBundle\Entity\Observation $observations
     */
    public function removeObservation(\Pequiven\SEIPBundle\Entity\Observation $observations) {
        $this->observations->removeElement($observations);
    }

    /**
     * Get observations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getObservations() {
        return $this->observations;
    }

    /**
     * Set details
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator\IndicatorDetails $details
     * @return Indicator
     */
    public function setDetails(\Pequiven\IndicatorBundle\Entity\Indicator\IndicatorDetails $details = null) {
        $this->details = $details;

        return $this;
    }

    /**
     * Get details
     *
     * @return \Pequiven\IndicatorBundle\Entity\Indicator\IndicatorDetails
     */
    public function getDetails() {
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
    public function setParent(\Pequiven\IndicatorBundle\Entity\Indicator $parent = null) {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Pequiven\IndicatorBundle\Entity\Indicator 
     */
    public function getParent() {
        return $this->parent;
    }

    /**
     * Add childrens
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator $childrens
     * @return Indicator
     */
    public function addChildren(\Pequiven\IndicatorBundle\Entity\Indicator $childrens) {
        $childrens->setParent($this);
        $this->childrens->add($childrens);

        return $this;
    }

    /**
     * Remove childrens
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator $childrens
     */
    public function removeChildren(\Pequiven\IndicatorBundle\Entity\Indicator $childrens) {
        $this->childrens->removeElement($childrens);
    }

    /**
     * Get childrens
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildrens() {
        return $this->childrens;
    }

    function getProgressToDate() {
        return $this->progressToDate;
    }

    /**
     * Get weight
     *
     * @return float 
     */
    public function getWeight() {
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

    public function updateLastDateCalculateResult() {
        $this->lastDateCalculateResult = new \DateTime();
    }

    public function clearLastDateCalculateResult() {
        $this->lastDateCalculateResult = null;
    }

    public function isAvailableInResult() {
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
        if ($this->id > 0) {
            $this->id = null;

            $this->ref = null;
            $this->createdAt = null;
            $this->lastDateCalculateResult = null;
            $this->updatedAt = null;
            $this->userCreatedAt = null;
            $this->userUpdatedAt = null;

            $this->period = null;

            $this->valuesIndicator = new ArrayCollection();

            $this->managementSystems = new ArrayCollection();

            $this->valueFinal = 0;
            $this->totalPlan = 0;
            $this->progressToDate = 0;
            $this->resultReal = 0;
            $this->status = 0;

            $this->featuresIndicator = new ArrayCollection();
            $this->histories = new ArrayCollection();
            $this->observations = new ArrayCollection();
            $this->details = new Indicator\IndicatorDetails();
            $this->valueIndicatorConfig = null;

            $this->objetives = new ArrayCollection();

            $this->childrens = new ArrayCollection();

            $this->indicatorlastPeriod = null;
        }
    }

    public function setResult($result) {
        $this->progressToDate = $result;
    }

    /**
     * Set resultReal
     * indicators
     * @param float $resultReal
     * @return Indicator
     */
    public function setResultReal($resultReal) {
        $this->resultReal = $resultReal;

        return $this;
    }

    /**
     * Get resultReal
     *
     * @return float 
     */
    public function getResultReal() {
        return $this->resultReal;
    }

    function isCouldBePenalized() {
        return $this->couldBePenalized;
    }

    function isForcePenalize() {
        return $this->forcePenalize;
    }

    function setCouldBePenalized($couldBePenalized) {
        $this->couldBePenalized = $couldBePenalized;

        return $this;
    }

    function setForcePenalize($forcePenalize) {
        $this->forcePenalize = $forcePenalize;

        return $this;
    }

    /**
     * Set requiredToImport
     *
     * @param boolean $requiredToImport
     * @return Objetive
     */
    public function setRequiredToImport($requiredToImport) {
        $this->requiredToImport = $requiredToImport;

        return $this;
    }

    /**
     * Get requiredToImport
     *
     * @return boolean 
     */
    public function getRequiredToImport() {
        return $this->requiredToImport;
    }

    /**
     * Add lineStrategics
     *
     * @param \Pequiven\MasterBundle\Entity\LineStrategic $lineStrategics
     * @return Indicator
     */
    public function addLineStrategic(\Pequiven\MasterBundle\Entity\LineStrategic $lineStrategics) {
        $this->lineStrategics[] = $lineStrategics;

        return $this;
    }

    /**
     * Remove lineStrategics
     *
     * @param \Pequiven\MasterBundle\Entity\LineStrategic $lineStrategics
     */
    public function removeLineStrategic(\Pequiven\MasterBundle\Entity\LineStrategic $lineStrategics) {
        $this->lineStrategics->removeElement($lineStrategics);
    }

    /**
     * Get lineStrategics
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLineStrategics() {
        return $this->lineStrategics;
    }

    /**
     * Add formulaDetails
     *
     * @param \Pequiven\MasterBundle\Entity\Formula\FormulaDetail $formulaDetails
     * @return Indicator
     */
    public function addFormulaDetail(\Pequiven\MasterBundle\Entity\Formula\FormulaDetail $formulaDetails) {
        $formulaDetails->setIndicator($this);
        $this->formulaDetails->add($formulaDetails);

        return $this;
    }

    /**
     * Remove formulaDetails
     *
     * @param \Pequiven\MasterBundle\Entity\Formula\FormulaDetail $formulaDetails
     */
    public function removeFormulaDetail(\Pequiven\MasterBundle\Entity\Formula\FormulaDetail $formulaDetails) {
        $this->formulaDetails->removeElement($formulaDetails);
    }

    /**
     * Get formulaDetails
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFormulaDetails() {
        return $this->formulaDetails;
    }

    /**
     * @ORM\PrePersist()
     */
    function prePersist() {
        $this->details = new Indicator\IndicatorDetails;
    }

    /**
     * Set valueIndicatorConfig
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator\ValueIndicatorConfig $valueIndicatorConfig
     * @return Indicator
     */
    public function setValueIndicatorConfig(\Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator\ValueIndicatorConfig $valueIndicatorConfig = null) {
        $this->valueIndicatorConfig = $valueIndicatorConfig;

        return $this;
    }

    /**
     * Get valueIndicatorConfig
     *
     * @return \Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator\ValueIndicatorConfig 
     */
    public function getValueIndicatorConfig() {
        return $this->valueIndicatorConfig;
    }

    public function getDescriptionWithStrPad($pad_length) {
        return str_pad($this->description, $pad_length, ' ', STR_PAD_RIGHT);
    }

    /**
     * Set calculationMethod
     *
     * @param integer $calculationMethod
     * @return Indicator
     */
    public function setCalculationMethod($calculationMethod) {
        $this->calculationMethod = $calculationMethod;

        return $this;
    }

    /**
     * Get calculationMethod
     *
     * @return integer 
     */
    public function getCalculationMethod() {
        return $this->calculationMethod;
    }

    /**
     * Add tagsIndicator
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator\TagIndicator $tagsIndicator
     * @return Indicator
     */
    public function addTagsIndicator(\Pequiven\IndicatorBundle\Entity\Indicator\TagIndicator $tagsIndicator) {
        $tagsIndicator->setIndicator($this);

        $this->tagsIndicator->add($tagsIndicator);

        return $this;
    }

    /**
     * Remove tagsIndicator
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator\TagIndicator $tagsIndicator
     */
    public function removeTagsIndicator(\Pequiven\IndicatorBundle\Entity\Indicator\TagIndicator $tagsIndicator) {
        $this->tagsIndicator->removeElement($tagsIndicator);
    }

    /**
     * Get tagsIndicator
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTagsIndicator() {
        return $this->tagsIndicator;
    }

    /**
     * Add indicatorsChartDetails
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator\IndicatorChartDetails $indicatorsChartDetails
     * @return Indicator
     */
    public function addIndicatorsChartDetails(\Pequiven\IndicatorBundle\Entity\Indicator\IndicatorChartDetails $indicatorsChartDetails) {
        $indicatorsChartDetails->setIndicator($this);

        $this->indicatorsChartDetails->add($indicatorsChartDetails);

        return $this;
    }

    /**
     * Remove indicatorsChartDetails
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator\IndicatorChartDetails $indicatorsChartDetails
     */
    public function removeIndicatorsChartDetails(\Pequiven\IndicatorBundle\Entity\Indicator\IndicatorChartDetails $indicatorsChartDetails) {
        $this->indicatorsChartDetails->removeElement($indicatorsChartDetails);
    }

    /**
     * Get indicatorsChartDetails
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIndicatorsChartDetails() {
        return $this->indicatorsChartDetails;
    }

    /**
     * Set resultInPercentage
     *
     * @param boolean $resultInPercentage
     * @return Indicator
     */
    public function setResultInPercentage($resultInPercentage) {
        $this->resultInPercentage = $resultInPercentage;

        return $this;
    }

    /**
     * Get resultInPercentage
     *
     * @return boolean 
     */
    public function getResultInPercentage() {
        return $this->resultInPercentage;
    }

    /**
     * Set showTagInResult
     *
     * @param boolean $showTagInResult
     * @return Indicator
     */
    public function setShowTagInResult($showTagInResult) {
        $this->showTagInResult = $showTagInResult;

        return $this;
    }

    /**
     * Get showTagInResult
     *
     * @return boolean 
     */
    public function getShowTagInResult() {
        return $this->showTagInResult;
    }

    /**
     * Set showTagInDashboardResult
     *
     * @param boolean $showTagInDashboardResult
     * @return Indicator
     */
    public function setShowTagInDashboardResult($showTagInDashboardResult) {
        $this->showTagInDashboardResult = $showTagInDashboardResult;

        return $this;
    }

    /**
     * Get showTagInDashboardResult
     *
     * @return boolean 
     */
    public function getShowTagInDashboardResult() {
        return $this->showTagInDashboardResult;
    }

    function getIndicatorWeight() {
        return $this->indicatorWeight;
    }

    function setIndicatorWeight($indicatorWeight) {
        $this->indicatorWeight = $indicatorWeight;
    }

    public function showResultOfIndicator() {
        if (!$this->showTagInResult) {
            return $this->resultReal;
        } else {
            foreach ($this->getTagsIndicator() as $tagIndicator) {
                if ($tagIndicator->getShowInIndicatorResult()) {
                    if ($tagIndicator->getTypeTag() == Indicator\TagIndicator::TAG_TYPE_NUMERIC) {
                        return $tagIndicator->getValueOfTag();
                    } else {
                        return ((float) $tagIndicator->getTextOfTag() + 0.0);
                    }
                }
            }
        }
    }

    /**
     * Set summary
     *
     * @param string $summary
     * @return Indicator
     */
    public function setSummary($summary) {
        $this->summary = $summary;

        return $this;
    }

    /**
     * Get summary
     *
     * @return string 
     */
    public function getSummary() {
        return $this->summary;
    }

    function getShowRealValue() {
        return $this->showRealValue;
    }

    function getShowPlanValue() {
        return $this->showPlanValue;
    }

    function isShowRealValue() {
        return $this->showRealValue;
    }

    function isShowPlanValue() {
        return $this->showPlanValue;
    }

    function getShowEvolutionView() {
        return $this->showEvolutionView;
    }

    function isShowEvolutionView() {
        return $this->showEvolutionView;
    }

    function setShowEvolutionView($showEvolutionView) {
        $this->showEvolutionView = $showEvolutionView;
    }

    function setShowRealValue($showRealValue) {
        $this->showRealValue = $showRealValue;
    }

    function setShowPlanValue($showPlanValue) {
        $this->showPlanValue = $showPlanValue;
    }

    function getEvaluateInPeriod() {
        return $this->evaluateInPeriod;
    }

    function setEvaluateInPeriod($evaluateInPeriod) {
        $this->evaluateInPeriod = $evaluateInPeriod;
    }

    /**
     * Get forcePenalize
     *
     * @return boolean 
     */
    public function getForcePenalize() {
        return $this->forcePenalize;
    }

    /**
     * Set snippetPlan
     *
     * @param string $snippetPlan
     * @return Indicator
     */
    public function setSnippetPlan($snippetPlan) {
        $this->snippetPlan = $snippetPlan;

        return $this;
    }

    /**
     * Get snippetPlan
     *
     * @return string 
     */
    public function getSnippetPlan() {
        return $this->snippetPlan;
    }

    /**
     * Set snippetReal
     *
     * @param string $snippetReal
     * @return Indicator
     */
    public function setSnippetReal($snippetReal) {
        $this->snippetReal = $snippetReal;

        return $this;
    }

    /**
     * Get snippetReal
     *
     * @return string 
     */
    public function getSnippetReal() {
        return $this->snippetReal;
    }

    /**
     * Set showResults
     *
     * @param boolean $showResults
     * @return Indicator
     */
    public function setShowResults($showResults) {
        $this->showResults = $showResults;

        return $this;
    }

    /**
     * Get showResults
     *
     * @return boolean 
     */
    public function getShowResults() {
        return $this->showResults;
    }

    /**
     * Get showResults
     *
     * @return boolean 
     */
    public function isShowResults() {
        return $this->showResults;
    }

    /**
     * Set showFeatures
     *
     * @param boolean $showFeatures
     * @return Indicator
     */
    public function setShowFeatures($showFeatures) {
        $this->showFeatures = $showFeatures;

        return $this;
    }

    /**
     * Get showFeatures
     *
     * @return boolean 
     */
    public function getShowFeatures() {
        return $this->showFeatures;
    }

    /**
     * Get showFeatures
     *
     * @return boolean 
     */
    public function isShowFeatures() {
        return $this->showFeatures;
    }

    /**
     * Add featuresIndicator
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator\FeatureIndicator $featuresIndicator
     * @return Indicator
     */
    public function addFeaturesIndicator(\Pequiven\IndicatorBundle\Entity\Indicator\FeatureIndicator $featuresIndicator) {
        $featuresIndicator->setIndicator($this);
        $this->featuresIndicator->add($featuresIndicator);

        return $this;
    }

    /**
     * Remove featuresIndicator
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator\FeatureIndicator $featuresIndicator
     */
    public function removeFeaturesIndicator(\Pequiven\IndicatorBundle\Entity\Indicator\FeatureIndicator $featuresIndicator) {
        $this->featuresIndicator->removeElement($featuresIndicator);
    }

    /**
     * Get featuresIndicator
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFeaturesIndicator() {
        return $this->featuresIndicator;
    }

    /**
     * Set indicatorLevel
     *
     * @param \Pequiven\IndicatorBundle\Entity\IndicatorLevel $indicatorLevel
     * @return Indicator
     */
    public function setIndicatorLevel(\Pequiven\IndicatorBundle\Entity\IndicatorLevel $indicatorLevel) {
        $this->indicatorLevel = $indicatorLevel;

        return $this;
    }

    function getOrderShowFromParent() {
        return $this->orderShowFromParent;
    }

    function setOrderShowFromParent($orderShowFromParent) {
        $this->orderShowFromParent = $orderShowFromParent;
    }

    /**
     * 
     * @return integer
     */
    function getStatus() {
        return $this->status;
    }

    /**
     * Establecer status Indicator::STATUS_*
     * @param type $status
     * @return \Pequiven\IndicatorBundle\Entity\Indicator
     */
    function setStatus($status) {
        $this->status = $status;

        return $this;
    }

    /**
     * Set showCharts
     *
     * @param boolean $showCharts
     * @return Indicator
     */
    public function setShowCharts($showCharts) {
        $this->showCharts = $showCharts;

        return $this;
    }

    /**
     * Get showCharts
     *
     * @return boolean 
     */
    public function getShowCharts() {
        return $this->showCharts;
    }

    /**
     * Set showTags
     *
     * @param boolean $showTags
     * @return Indicator
     */
    public function setShowTags($showTags) {
        $this->showTags = $showTags;

        return $this;
    }

    /**
     * Get showTags
     *
     * @return boolean 
     */
    public function getShowTags() {
        return $this->showTags;
    }

    /**
     * Add managementSystems
     *
     * @param \Pequiven\SIGBundle\Entity\ManagementSystem $managementSystems
     * @return Indicator
     */
    public function addManagementSystem(\Pequiven\SIGBundle\Entity\ManagementSystem $managementSystems) {
        $this->managementSystems[] = $managementSystems;

        return $this;
    }

    /**
     * Remove managementSystems
     *
     * @param \Pequiven\SIGBundle\Entity\ManagementSystem $managementSystems
     */
    public function removeManagementSystem(\Pequiven\SIGBundle\Entity\ManagementSystem $managementSystems) {
        $this->managementSystems->removeElement($managementSystems);
    }

    /**
     * Get managementSystems
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getManagementSystems() {
        return $this->managementSystems;
    }

    /**
     * Set viewVariablesFromEquationInDashboardPie
     *
     * @param boolean $viewVariablesFromEquationInDashboardPie
     * @return Indicator
     */
    public function setViewVariablesFromEquationInDashboardPie($viewVariablesFromEquationInDashboardPie) {
        $this->viewVariablesFromEquationInDashboardPie = $viewVariablesFromEquationInDashboardPie;

        return $this;
    }

    /**
     * Get viewVariablesFromEquationInDashboardPie
     *
     * @return boolean 
     */
    public function getViewVariablesFromEquationInDashboardPie() {
        return $this->viewVariablesFromEquationInDashboardPie;
    }

    /**
     * Set showByRealValue
     *
     * @param string $showByRealValue
     * @return Indicator
     */
    public function setShowByRealValue($showByRealValue) {
        $this->showByRealValue = $showByRealValue;

        return $this;
    }

    /**
     * Get showByRealValue
     *
     * @return string 
     */
    public function getShowByRealValue() {
        return $this->showByRealValue;
    }

    /**
     * Set showByPlanValue
     *
     * @param string $showByPlanValue
     * @return Indicator
     */
    public function setShowByPlanValue($showByPlanValue) {
        $this->showByPlanValue = $showByPlanValue;

        return $this;
    }

    /**
     * Get showByPlanValue
     *
     * @return string 
     */
    public function getShowByPlanValue() {
        return $this->showByPlanValue;
    }

    /**
     * Set variablesRealPlanComplement
     *
     * @param boolean $variablesRealPlanComplement
     * @return Indicator
     */
    public function setVariablesRealPlanComplement($variablesRealPlanComplement) {
        $this->variablesRealPlanComplement = $variablesRealPlanComplement;

        return $this;
    }

    /**
     * Get variablesRealPlanComplement
     *
     * @return boolean 
     */
    public function getVariablesRealPlanComplement() {
        return $this->variablesRealPlanComplement;
    }

    /**
     * 
     * @param type $isValueFromTextReal
     * @return \Pequiven\IndicatorBundle\Entity\Indicator
     */
    public function setIsValueFromTextReal($isValueFromTextReal) {
        $this->isValueFromTextReal = $isValueFromTextReal;

        return $this;
    }

    /**
     * 
     * @return type
     */
    public function getIsValueFromTextReal() {
        return $this->isValueFromTextReal;
    }

    /**
     * 
     * @param type $TextValueFromVariableReal
     * @return \Pequiven\IndicatorBundle\Entity\Indicator
     */
    public function setTextValueFromVariableReal($TextValueFromVariableReal) {
        $this->textValueFromVariableReal = $TextValueFromVariableReal;

        return $this;
    }

    /**
     * Get
     * @return type
     */
    public function getTextValueFromVariableReal() {
        return $this->textValueFromVariableReal;
    }

    /**
     * Set isValueFromTextPlan
     * @param type $isValueFromTextPlan
     * @return \Pequiven\IndicatorBundle\Entity\Indicator
     */
    public function setIsValueFromTextPlan($isValueFromTextplan) {
        $this->isValueFromTextPlan = $isValueFromTextplan;

        return $this;
    }

    /**
     * Get isValueFromTextPlan
     * @return boolean
     */
    public function getIsValueFromTextPlan() {
        return $this->isValueFromTextPlan;
    }

    /**
     * Set textValueFromVariablePlan
     * @param String $TextValueFromVariablePlan
     * @return \Pequiven\IndicatorBundle\Entity\Indicator
     */
    public function setTextValueFromVariablePlan($TextValueFromVariablePlan) {
        $this->textValueFromVariablePlan = $TextValueFromVariablePlan;

        return $this;
    }

    /**
     * Get textValueFromVariablePlan
     * @return type
     */
    public function getTextValueFromVariablePlan() {
        return $this->textValueFromVariablePlan;
    }

    /**
     * Set isValueRealFromEquationRealFormula
     *
     * @param boolean $isValueRealFromEquationRealFormula
     * @return Indicator
     */
    public function setIsValueRealFromEquationRealFormula($isValueRealFromEquationRealFormula) {
        $this->isValueRealFromEquationRealFormula = $isValueRealFromEquationRealFormula;

        return $this;
    }

    /**
     * Get isValueRealFromEquationRealFormula
     *
     * @return boolean 
     */
    public function getIsValueRealFromEquationRealFormula() {
        return $this->isValueRealFromEquationRealFormula;
    }

    /**
     * Set isValuePlanFromEquationPlanFormula
     *
     * @param boolean $isValuePlanFromEquationPlanFormula
     * @return Indicator
     */
    public function setIsValuePlanFromEquationPlanFormula($isValuePlanFromEquationPlanFormula) {
        $this->isValuePlanFromEquationPlanFormula = $isValuePlanFromEquationPlanFormula;

        return $this;
    }

    /**
     * Get isValuePlanFromEquationPlanFormula
     *
     * @return boolean 
     */
    public function getIsValuePlanFromEquationPlanFormula() {
        return $this->isValuePlanFromEquationPlanFormula;
    }

    /**
     * 
     * @param type $isShowRange
     * @return \Pequiven\IndicatorBundle\Entity\Indicator
     */
    public function setShowRange($showRange) {
        $this->showRange = $showRange;

        return $this;
    }

    /**
     * 
     * @return type
     */
    public function getShowRange() {
        return $this->showRange;
    }

    /**
     * 
     * @param type $showTagsInTwoColumns
     * @return \Pequiven\IndicatorBundle\Entity\Indicator
     */
    public function setShowTagsInTwoColumns($showTagsInTwoColumns) {
        $this->showTagsInTwoColumns = $showTagsInTwoColumns;

        return $this;
    }

    /**
     * 
     * @return type
     */
    public function getShowTagsInTwoColumns() {
        return $this->showTagsInTwoColumns;
    }

    /**
     * Set typeOfCompany
     *
     * @param integer $typeOfCompany
     * @return Indicator
     */
    public function setTypeOfCompany($typeOfCompany) {
        $this->typeOfCompany = $typeOfCompany;

        return $this;
    }

    /**
     * Get typeOfCompany
     *
     * @return integer 
     */
    public function getTypeOfCompany() {
        return $this->typeOfCompany;
    }

    /**
     * 
     * @param type $resultIsAccumulative
     * @return \Pequiven\IndicatorBundle\Entity\Indicator
     */
    public function setResultIsAccumulative($resultIsAccumulative) {
        $this->resultIsAccumulative = $resultIsAccumulative;

        return $this;
    }

    /**
     * 
     * @return type
     */
    public function getResultIsAccumulative() {
        return $this->resultIsAccumulative;
    }

    function getResultIsAccumulativeWithToMonth() {
        return $this->resultIsAccumulativeWithToMonth;
    }

    function setResultIsAccumulativeWithToMonth($resultIsAccumulativeWithToMonth) {
        $this->resultIsAccumulativeWithToMonth = $resultIsAccumulativeWithToMonth;
    }

    /**
     * 
     * @param type $showColumnAccumulativeInDashboard
     * @return \Pequiven\IndicatorBundle\Entity\Indicator
     */
    public function setShowColumnAccumulativeInDashboard($showColumnAccumulativeInDashboard) {
        $this->showColumnAccumulativeInDashboard = $showColumnAccumulativeInDashboard;

        return $this;
    }

    /**
     * 
     * @return type
     */
    public function getShowColumnAccumulativeInDashboard() {
        return $this->showColumnAccumulativeInDashboard;
    }

    /**
     * 
     * @param type $showColumnPlanOneTimeInDashboard
     * @return \Pequiven\IndicatorBundle\Entity\Indicator
     */
    public function setShowColumnPlanOneTimeInDashboard($showColumnPlanOneTimeInDashboard) {
        $this->showColumnPlanOneTimeInDashboard = $showColumnPlanOneTimeInDashboard;

        return $this;
    }

    /**
     * 
     * @return type
     */
    public function getShowColumnPlanAtTheEnd() {
        return $this->showColumnPlanAtTheEnd;
    }

    /**
     * 
     * @param type $showColumnPlanAtTheEnd
     * @return \Pequiven\IndicatorBundle\Entity\Indicator
     */
    public function setShowColumnPlanAtTheEnd($showColumnPlanAtTheEnd) {
        $this->showColumnPlanAtTheEnd = $showColumnPlanAtTheEnd;

        return $this;
    }

    /**
     * 
     * @return type
     */
    public function getShowColumnPlanOneTimeInDashboard() {
        return $this->showColumnPlanOneTimeInDashboard;
    }

    /**
     * 
     * @param type $resultIsFromChildrensResult
     * @return \Pequiven\IndicatorBundle\Entity\Indicator
     */
    public function setResultIsFromChildrensResult($resultIsFromChildrensResult) {
        $this->resultIsFromChildrensResult = $resultIsFromChildrensResult;

        return $this;
    }

    /**
     * 
     * @return type
     */
    public function getResultIsFromChildrensResult() {
        return $this->resultIsFromChildrensResult;
    }

    /**
     * 
     * @param type $showByDashboardSpecific
     * @return \Pequiven\IndicatorBundle\Entity\Indicator
     */
    public function setShowByDashboardSpecific($showByDashboardSpecific) {
        $this->showByDashboardSpecific = $showByDashboardSpecific;

        return $this;
    }

    /**
     * 
     * @return type
     */
    public function getShowByDashboardSpecific() {
        return $this->showByDashboardSpecific;
    }

    /**
     * 
     * @param type $showDashboardByQuarter
     * @return \Pequiven\IndicatorBundle\Entity\Indicator
     */
    public function setShowDashboardByQuarter($showDashboardByQuarter) {
        $this->showDashboardByQuarter = $showDashboardByQuarter;

        return $this;
    }

    /**
     * 
     * @return type
     */
    public function getShowDashboardByQuarter() {
        return $this->showDashboardByQuarter;
    }

    /**
     * 
     * @param type $resultsAdditionalInDashboardColumn
     * @return \Pequiven\IndicatorBundle\Entity\Indicator
     */
    public function setResultsAdditionalInDashboardColumn($resultsAdditionalInDashboardColumn) {
        $this->resultsAdditionalInDashboardColumn = $resultsAdditionalInDashboardColumn;

        return $this;
    }

    /**
     * 
     * @return type
     */
    public function getResultsAdditionalInDashboardColumn() {
        return $this->resultsAdditionalInDashboardColumn;
    }

    /**
     * 
     * @param type $validVariableStaticValue
     * @return \Pequiven\IndicatorBundle\Entity\Indicator
     */
    public function setValidVariableStaticValue($validVariableStaticValue) {
        $this->validVariableStaticValue = $validVariableStaticValue;

        return $this;
    }

    /**
     * 
     * @return type
     */
    public function getValidVariableStaticValue() {
        return $this->validVariableStaticValue;
    }

    /**
     * Set complejoDashboardSpecific
     *
     * @param \Pequiven\MasterBundle\Entity\Complejo $complejoDashboardSpecific
     * @return Indicator
     */
    public function setComplejoDashboardSpecific(\Pequiven\MasterBundle\Entity\Complejo $complejoDashboardSpecific = null) {
        $this->complejoDashboardSpecific = $complejoDashboardSpecific;

        return $this;
    }

    /**
     * Get complejoDashboardSpecific
     *
     * @return \Pequiven\MasterBundle\Entity\Complejo 
     */
    public function getComplejoDashboardSpecific() {
        return $this->complejoDashboardSpecific;
    }

    /**
     * Set indicatorSigMedition
     *
     * @param float $indicatorSigMedition
     * @return Indicator
     */
    public function setIndicatorSigMedition($indicatorSigMedition) {
        $this->indicatorSigMedition = $indicatorSigMedition;

        return $this;
    }

    /**
     * Get indicatorSigMedition
     *
     * @return float 
     */
    public function getIndicatorSigMedition() {
        return $this->indicatorSigMedition;
    }

    /**
     * Set parentCloning
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator $parentCloning
     * @return Indicator
     */
    public function setParentCloning(\Pequiven\IndicatorBundle\Entity\Indicator $parentCloning = null) {
        $this->parentCloning = $parentCloning;

        return $this;
    }

    /**
     * Get parentCloning
     *
     * @return \Pequiven\IndicatorBundle\Entity\Indicator 
     */
    public function getParentCloning() {
        return $this->parentCloning;
    }

    /**
     * Add indicatorEvolutionCloning
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator
     * @return Indicator
     */
    public function addIndicatorEvolutionCloning(\Pequiven\IndicatorBundle\Entity\Indicator $indicatorEvolutionCloning) {
        $indicatorEvolutionCloning->addParentCloning($this);
        $this->indicatorEvolutionCloning->add($indicatorEvolutionCloning);

        return $this;
    }

    /**
     * Remove indicatorEvolutionCloning
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator $indicatorEvolutionCloning
     */
    public function removeIndicatorEvolutionCloning(\Pequiven\IndicatorBundle\Entity\Indicator $indicatorEvolutionCloning) {
        $this->indicatorEvolutionCloning->removeElement($indicatorEvolutionCloning);
    }

    /**
     * Get indicatorEvolutionCloning
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getindIcatorEvolutionCloning() {
        return $this->indicatorEvolutionCloning;
    }

    /**
     * 
     * @param type $notshowIndicatorNoEvaluateInPeriod
     * @return \Pequiven\IndicatorBundle\Entity\Indicator
     */
    public function setNotshowIndicatorNoEvaluateInPeriod($notshowIndicatorNoEvaluateInPeriod) {
        $this->notshowIndicatorNoEvaluateInPeriod = $notshowIndicatorNoEvaluateInPeriod;

        return $this;
    }

    /**
     * 
     * @return type
     */
    public function getNotshowIndicatorNoEvaluateInPeriod() {
        return $this->notshowIndicatorNoEvaluateInPeriod;
    }

    /**
     * Set ignoredByParentResult
     *
     * @param boolean $ignoredByParentResult
     * @return Indicator
     */
    public function setIgnoredByParentResult($ignoredByParentResult) {
        $this->ignoredByParentResult = $ignoredByParentResult;

        return $this;
    }

    /**
     * Get ignoredByParentResult
     *
     * @return boolean 
     */
    public function getIgnoredByParentResult() {
        return $this->ignoredByParentResult;
    }

    /**
     * Add rawMaterialConsumptionPlannings
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator\IndicatorFile
     * @return Indicator
     */
    public function addIndicatorFiles(\Pequiven\IndicatorBundle\Entity\Indicator\IndicatorFile $indicatorFiles) {
        $indicatorFiles->setIndicator($this);
        $this->indicatorFiles->add($indicatorFiles);

        return $this;
    }

    /**
     * Remove indicatorFiles
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator\IndicatorFile $indicatorFiles
     */
    public function removeIndicatorFiles(\Pequiven\IndicatorBundle\Entity\Indicator\IndicatorFile $indicatorFiles) {
        $this->indicatorFiles->removeElement($indicatorFiles);
    }

    /**
     * Get indicatorFiles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIndicatorFiles() {
        return $this->indicatorFiles;
    }

    function getLoadFiles() {
        return $this->loadFiles;
    }

    function setLoadFiles($loadFiles) {
        $this->loadFiles = $loadFiles;
    }

    function getNumberValueIndicatorToForce() {
        return $this->numberValueIndicatorToForce;
    }

    function setNumberValueIndicatorToForce($numberValueIndicatorToForce) {
        $this->numberValueIndicatorToForce = $numberValueIndicatorToForce;
    }

    function getViewDataChartEvolutionConsultedMonth() {
        return $this->viewDataChartEvolutionConsultedMonth;
    }

    function setViewDataChartEvolutionConsultedMonth($viewDataChartEvolutionConsultedMonth) {
        $this->viewDataChartEvolutionConsultedMonth = $viewDataChartEvolutionConsultedMonth;
    }

    function getDecimalsToChartEvolution() {
        return $this->decimalsToChartEvolution;
    }

    function setDecimalsToChartEvolution($decimalsToChartEvolution) {
        $this->decimalsToChartEvolution = $decimalsToChartEvolution;
    }

    function getShowResultWithoutPercentageInDashboard() {
        return $this->showResultWithoutPercentageInDashboard;
    }

    function setShowResultWithoutPercentageInDashboard($showResultWithoutPercentageInDashboard) {
        $this->showResultWithoutPercentageInDashboard = $showResultWithoutPercentageInDashboard;
    }

    /**
     * Add charts
     *
     * @param \Pequiven\SEIPBundle\Entity\Chart $charts
     * @return Indicator
     */
    public function addChart(\Pequiven\SEIPBundle\Entity\Chart $charts) {
        $this->charts[] = $charts;
        return $this;
    }

    public function removeChart(\Pequiven\SEIPBundle\Entity\Chart $charts) {
        $this->charts->removeElement($charts);
    }

    public function getCharts() {
        return $this->charts;
    }

    public function addIndicatorGroup(IndicatorGroup $indicatorGroup) {
        $this->indicatorGroup[] = $indicatorGroup;
        return $this;
    }

    public function removeIndicatorGroup(IndicatorGroup $indicatorGroup) {
        $this->indicatorGroup->removeElement($indicatorGroup);
    }

    function getIndicatorGroup() {
        return $this->indicatorGroup;
    }

    function getShowIndicatorGroups() {
        return $this->showIndicatorGroups;
    }

    function setShowIndicatorGroups($showIndicatorGroups) {
        $this->showIndicatorGroups = $showIndicatorGroups;
    }
    
    function getPlanIsNotAccumulative() {
        return $this->planIsNotAccumulative;
    }

    function setPlanIsNotAccumulative($planIsNotAccumulative) {
        $this->planIsNotAccumulative = $planIsNotAccumulative;
    }

}
