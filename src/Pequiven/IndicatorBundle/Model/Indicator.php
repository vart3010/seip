<?php

namespace Pequiven\IndicatorBundle\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * Modelo del indicador
 *
 * @author matias
 */
abstract class Indicator implements IndicatorInterface {

    /**
     * Estatus borrador
     */
    const STATUS_DRAFT = 0;

    /**
     * Estatus Aprobado
     */
    const STATUS_APPROVED = 1;

    /**
     * Tipo de calculo por formula y valores de las variables manuales
     */
    const TYPE_CALCULATION_FORMULA_MANUALLY = 0;

    /**
     * Tipo de calculo por formula y valores de las variables automaticos
     */
    const TYPE_CALCULATION_FORMULA_AUTOMATIC = 1;

    /**
     * Tipo de calculo por formula y valores de las variables automaticos desde ecuacion con las variables de lo hijos
     */
    const TYPE_CALCULATION_FORMULA_AUTOMATIC_FROM_EQ = 2;
    
    // TIPOS DE SECCIONES DE RESULTADOS A PARTIR DE LAS PLANTILLAS DE REPORTE
    
    /**
     * Sección Producción Bruta
     */
    const TYPE_RESULT_SECTION_PRODUCTION_GROSS = 1;
    /**
     * Sección Producción Neta
     */
    const TYPE_RESULT_SECTION_PRODUCTION_NET = 2;
    /**
     * Sección Producción No Realizada
     */
    const TYPE_RESULT_SECTION_UNREALIZED_PRODUCTION = 3;
    /**
     * Sección Materia Prima
     */
    const TYPE_RESULT_SECTION_RAW_MATERIAL = 4;
    /**
     * Sección Servicios
     */
    const TYPE_RESULT_SECTION_SERVICES = 5;
    /**
     * Sección Factor de Servicio
     */
    const TYPE_RESULT_SECTION_SERVICE_FACTOR = 6;
    /**
     * Sección Flujo de Gas
     */
    const TYPE_RESULT_SECTION_GAS_FLOW = 7;
    

    /**
     * Indicador con fórmula asociada
     */
    const INDICATOR_WITH_FORMULA = 'INDICATOR_WITH_FORMULA';

    /**
     * Indicador sin fórmula asociada
     */
    const INDICATOR_WITHOUT_FORMULA = 'INDICATOR_WITHOUT_FORMULA';

    /**
     * Indicador con resultado
     */
    const INDICATOR_WITH_RESULT = 'INDICATOR_WITH_RESULT';

    /**
     * Indicador sin resultado
     */
    const INDICATOR_WITHOUT_RESULT = 'INDICATOR_WITHOUT_RESULT';
    
    /**
     * Indicador sin Frecuencia de Notificación
     */
    const INDICATOR_WITHOUT_FREQUENCY_NOTIFICATION = 'INDICATOR_WITHOUT_FREQUENCY_NOTIFICATION';

    /**
     * Tipo de detalle (Ninguno)
     */
    const TYPE_DETAIL_NONE = 0;

    /**
     * Tipo de detalle (Carga diara de produccion)
     */
    const TYPE_DETAIL_DAILY_LOAD_PRODUCTION = 1;

    /**
     * Metodo de cálculo tradicional donde se acumulan las variables
     */
    const CALCULATION_METHOD_ACCUMULATION_OF_VARIABLES = 0;

    /**
     * Metodo de cálculo por promedio de los resultados de cada hijos en sus resultados
     */
    const CALCULATION_METHOD_AVERAGE_BASED_ON_NUMBER_CHILDREN = 1;

    /**
     * Metodo de cálculo por promedio del plan y real acumulado de los hijos
     */
    const CALCULATION_METHOD_AVERAGE_PLAN_REAL_CHILDREN = 2;

    /**
     * Metodo de cálculo por promedio ponderado del resultado de los hijos
     */
    const CALCULATION_METHOD_WEIGHTED_AVERAGE_RESULT_CHILDREN = 3;
    
    /**
     * Metodo de cálculo dónde variables parciales se obtienen a través de ecuaciones de las variables
     */
    const CALCULATION_METHOD_OF_EQUATION_PARTIAL_VARIABLES = 4;
    
    
    /**
     * Tipo de compañia matriz
     */
    const TYPE_OF_COMPANY_MATRIZ = 0;
    
    /**
     * Tipo de compañia filial
     */
    const TYPE_OF_COMPANY_AFFILIATED = 1;
    
    /**
     * Tipo de compañia mixta
     */
    const TYPE_OF_COMPANY_MIXTA = 2;
    
    /**
     * Tipo de compañia mixta
     */
    const TYPE_OF_COMPANY_AFFILIATED_MIXTA = 3;
    
    const TYPE_OBJECT = 'indicator';
    
    const RESULT_RANGE_GOOD = 1;
    const RESULT_RANGE_MIDDLE = 2;
    const RESULT_RANGE_BAD = 3;

    /**
     * @var integer
     * 
     * @ORM\Column(name="typeOfCalculation", type="integer", nullable=false)
     */
    protected $typeOfCalculation = self::TYPE_CALCULATION_FORMULA_MANUALLY;
    
    /**
     * @var integer
     * 
     * @ORM\Column(name="typeOfRangeFromResult", type="integer", nullable=false)
     */
    protected $typeOfRangeFromResult = self::RESULT_RANGE_GOOD;

    /**
     * IndicatorLevel
     * @var \Pequiven\IndicatorBundle\Entity\IndicatorLevel
     * @ORM\ManyToOne(targetEntity="\Pequiven\IndicatorBundle\Entity\IndicatorLevel")
     * @ORM\JoinColumn(name="fk_indicator_level", referencedColumnName="id",nullable = false)
     */
    protected $indicatorLevel;

    /**
     * Etiqueta del tipo de resumen de los indicadores
     * @var type 
     */
    protected $labelSummary = '';

    /**
     * Tipo de detalle
     * 
     * @var integer
     * @ORM\Column(name="typeDetailValue",type="integer")
     */
    protected $typeDetailValue = self::TYPE_DETAIL_NONE;

    /**
     * Metodos de calculo
     * 
     * @var integer
     * @ORM\Column(name="calculationMethod",type="integer")
     */
    protected $calculationMethod = self::CALCULATION_METHOD_ACCUMULATION_OF_VARIABLES;

    /**
     * Variable que se va mostrar en plantilla de indicador
     * @var type 
     */
    protected $variableToShow;
    
    /**
     * 
     * @var integer
     * @ORM\Column(name="typeOfResultSection", type="integer", nullable=false)
     */
    protected $typeOfResultSection = self::TYPE_CALCULATION_FORMULA_MANUALLY;

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

    /**
     * Get indicatorLevel
     *
     * @return \Pequiven\IndicatorBundle\Entity\IndicatorLevel 
     */
    public function getIndicatorLevel() {
        return $this->indicatorLevel;
    }

    /**
     * Retorna el tipo de calculo del indicador
     * @return integer
     */
    function getTypeOfCalculation() {
        return $this->typeOfCalculation;
    }

    /**
     * Establece el tipo de calculo del indicador
     * 
     * @param integer $typeOfCalculation Indicator::TYPE_CALCULATION_*
     * @return \Pequiven\IndicatorBundle\Model\Indicator
     */
    function setTypeOfCalculation($typeOfCalculation) {
        $this->typeOfCalculation = $typeOfCalculation;

        return $this;
    }

    /**
     * Retorna los tipos de calculo disponible de los indicadores y sus etiquetas.
     * 
     * @staticvar array $typesOfCalculation
     * @return array
     */
    static function getTypesOfCalculation() {
        static $typesOfCalculation = array(
            self::TYPE_CALCULATION_FORMULA_MANUALLY => 'pequiven_indicator.type_calculation.formula_manually',
            self::TYPE_CALCULATION_FORMULA_AUTOMATIC => 'pequiven_indicator.type_calculation.formula_automatic',
            self::TYPE_CALCULATION_FORMULA_AUTOMATIC_FROM_EQ => 'pequiven_indicator.type_calculation.formula_automatic_from_eq',
        );
        return $typesOfCalculation;
    }

    function getTypeOfCalculationLabel() {
        $typesOfCalculation = self::getTypesOfCalculation();
        if (isset($typesOfCalculation[$this->typeOfCalculation]) === false) {
            throw new Exception(sprintf('The type of calculation "%s" dont exist', $this->typeOfCalculation));
        }
        return $typesOfCalculation[$this->typeOfCalculation];
    }

    public function hasNotification() {
        if (count($this->getValuesIndicator()) > 0) {
            return true;
        }
        return false;
    }

    /**
     * Retorna las etiquetas definidas para los tipos de resumen
     * 
     * @staticvar array $labelsStatus
     * @return string
     */
    static function getLabelsSummary() {
        static $labelsStatus = array(
            self::INDICATOR_WITH_FORMULA => 'pequiven_indicator.summary.with_formula',
            self::INDICATOR_WITHOUT_FORMULA => 'pequiven_indicator.summary.without_formula',
            self::INDICATOR_WITH_RESULT => 'pequiven_indicator.summary.with_result',
            self::INDICATOR_WITHOUT_RESULT => 'pequiven_indicator.summary.without_result',
            self::INDICATOR_WITHOUT_FREQUENCY_NOTIFICATION => 'pequiven_indicator.summary.without_frequency_notification',
        );
        return $labelsStatus;
    }

    /**
     * Retorna la etiqueta que corresponde a un estatus del programa de gestion
     * @return string
     */
    function getLabelSummary() {
        $labels = $this->getLabelsSummary();
        if (isset($labels[$this->labelSummary])) {
            return $labels[$this->labelSummary];
        }
    }

    /**
     * 
     * @param \Pequiven\MasterBundle\Entity\Formula\Variable $variable
     * @return \Pequiven\MasterBundle\Entity\Formula\FormulaDetail
     */
    function getFormulaDetailByVariable(\Pequiven\MasterBundle\Entity\Formula\Variable $variable) {
        $result = null;
        foreach ($this->getFormulaDetails() as $formulaDetail) {
            if ($formulaDetail->getVariable() === $variable) {
                $result = $formulaDetail;
                break;
            }
        }
        return $result;
    }

    /**
     * Etiquetas de los tipos de detalles del indicador
     * @staticvar array $labelTypeDetail
     * @return string
     */
    static function getLabelsTypeDetail() {
        static $labelTypeDetail = array(
            self::TYPE_DETAIL_NONE => 'pequiven_indicator.type_detail.none',
            self::TYPE_DETAIL_DAILY_LOAD_PRODUCTION => 'pequiven_indicator.type_detail.daily_load_production',
        );
        return $labelTypeDetail;
    }

    /**
     * Retorna las etiquetas de cada metodo de calculo
     * @return type
     */
    static function getLabelsCalculationMethod() {
        return array(
            self::CALCULATION_METHOD_ACCUMULATION_OF_VARIABLES => 'pequiven_indicator.calculation_method.accumulation_of_variables',
            self::CALCULATION_METHOD_AVERAGE_BASED_ON_NUMBER_CHILDREN => 'pequiven_indicator.calculation_method.average_based_number_children',
            self::CALCULATION_METHOD_AVERAGE_PLAN_REAL_CHILDREN => 'pequiven_indicator.calculation_method.average_plan_real_children',
            self::CALCULATION_METHOD_WEIGHTED_AVERAGE_RESULT_CHILDREN => 'pequiven_indicator.calculation_method.weighted_average_result_children',
            self::CALCULATION_METHOD_OF_EQUATION_PARTIAL_VARIABLES => 'pequiven_indicator.calculation_method.equation_of_partial_variables',
        );
    }

    /**
     * 
     * @return Retorna la etiqueta del meotod de calculo del indicador
     */
    public function getLabelCalculationMethod() {
        $labels = self::getLabelsCalculationMethod();
        if (isset($labels[$this->calculationMethod])) {
            return $labels[$this->calculationMethod];
        }
    }

    /**
     * Retorna la etiqueta del detalle del valor de indicador
     * @return type
     */
    public function getLabelTypeDetailValue() {
        $labels = self::getLabelsTypeDetail();
        if (isset($labels[$this->typeDetailValue])) {
            return $labels[$this->typeDetailValue];
        }
    }

    /**
     * Set typeDetailValue
     *
     * @param integer $typeDetailValue
     * @return Indicator
     */
    public function setTypeDetailValue($typeDetailValue) {
        $this->typeDetailValue = $typeDetailValue;

        return $this;
    }

    /**
     * Get typeDetailValue
     *
     * @return integer 
     */
    public function getTypeDetailValue() {
        return $this->typeDetailValue;
    }

    /**
     * Retorna las etiquetas de cada metodo de calculo
     * @return type
     */
    static function getLabelsByLevelIndicator() {
        return array(
            \Pequiven\IndicatorBundle\Entity\IndicatorLevel::LEVEL_ESTRATEGICO => 'pequiven_indicator.indicator_strategic',
            \Pequiven\IndicatorBundle\Entity\IndicatorLevel::LEVEL_TACTICO => 'pequiven_indicator.indicator_tactic',
            \Pequiven\IndicatorBundle\Entity\IndicatorLevel::LEVEL_OPERATIVO => 'pequiven_indicator.indicator_operative',
        );
    }
    
    /**
     * Retorna la sección de tipo de resultado del indicador
     * @return integer
     */
    function getTypeOfResultSection() {
        return $this->typeOfResultSection;
    }

    /**
     * Establece la sección de tipo de resultado del indicador
     * 
     * @param integer $typeOfResultSection
     * @return \Pequiven\IndicatorBundle\Model\Indicator
     */
    function setTypeOfResultSection($typeOfResultSection) {
        $this->typeOfResultSection = $typeOfResultSection;

        return $this;
    }
    
    /**
     * @return integer
     */
    function getTypeOfRangeFromResult() {
        return $this->typeOfRangeFromResult;
    }

    /**
     * @param integer $typeOfRangeFromResult
     * @return Indicator
     */
    function setTypeOfRangeFromResult($typeOfRangeFromResult) {
        $this->typeOfRangeFromResult = $typeOfRangeFromResult;
    }

        
    /**
     * Retorna las secciones de tipo de resultado del indicador
     * 
     * @staticvar array $typesOfResultSection
     * @return array
     */
    static function getTypesOfResultSection() {
        static $typesOfResultSection = array(
            self::TYPE_RESULT_SECTION_PRODUCTION_GROSS => 'pequiven_indicator.type_result_section.production_gross',
            self::TYPE_RESULT_SECTION_PRODUCTION_NET => 'pequiven_indicator.type_result_section.production_net',
            self::TYPE_RESULT_SECTION_UNREALIZED_PRODUCTION => 'pequiven_indicator.type_result_section.unrealized_production',
            self::TYPE_RESULT_SECTION_RAW_MATERIAL => 'pequiven_indicator.type_result_section.raw_material',
            self::TYPE_RESULT_SECTION_SERVICES => 'pequiven_indicator.type_result_section.services',
            self::TYPE_RESULT_SECTION_SERVICE_FACTOR => 'pequiven_indicator.type_result_section.service_factor',
            self::TYPE_RESULT_SECTION_GAS_FLOW => 'pequiven_indicator.type_result_section.gas_flow',
        );
        return $typesOfResultSection;
    }
    
    function getTypeOfResultSectionLabel() {
        $typesOfResultSection = self::getTypesOfResultSection();
        if (isset($typesOfResultSection[$this->typeOfResultSection]) === false) {
            throw new Exception(sprintf('The type of result section "%s" dont exist', $this->typeOfResultSection));
        }
        return $typesOfResultSection[$this->typeOfResultSection];
    }
    
    public static function getTypesOfCompanies()
    {
        return array(
            self::TYPE_OF_COMPANY_MATRIZ => 'pequiven_master.company.type.pqv',
            self::TYPE_OF_COMPANY_AFFILIATED => 'pequiven_master.company.type.affiliated',
            self::TYPE_OF_COMPANY_MIXTA => 'pequiven_master.company.type.mixta',
            self::TYPE_OF_COMPANY_AFFILIATED_MIXTA => 'pequiven_master.company.type.affiliated_mixta',
        );
    }
    
    
    
}
