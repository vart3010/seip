<?php

namespace Pequiven\SEIPBundle\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * Modelo del gráfico
 *
 * @author matias
 */
abstract class Chart
{
    
    /**
     * Gráfico tipo dona para mostrar los indicadores asociados de acuerdo y junto con el resultado de medición
     */
    const TYPE_CHART_INDICATORS_ASSOCIATED = 0;
    
    /**
     * Gráfico tipo barras vertical para mostrar el real/plan de los indicadores asociados respecto al eje izquierdo y el resultado de la medición en valor porcentual respecto al lado derecho
     */
    const TYPE_CHART_COLUMN_REAL_PLAN = 1;
    
    /**
     * Gráfico tipo dona para mostrar las variables de la fórmula del indicador.
     */
    const TYPE_CHART_VARIABLES_DOUGHNUT = 2;
    
    /**
     * Gráfico para mostrar las variables (sumativas al real o al plan) o etiquetas (de un tipo en especifico, texto o numéricas)
     */
    const TYPE_CHART_PIE_VARIABLES_OR_TAGS = 3;
    
    /**
     * Gráfico tipo barras vertical para mostrar el real/plan de los parámetros de cada mes. Sólo para el caso en que sean 2 parámetros (Bien sea plan y real automático o plan y real automático a partir de ecuación)
     */
    const TYPE_CHART_COLUMN_FROM_FORMULA_PARAMETERS = 4;
    
    /**
     * Gráfico para mostrar los resultados de diferentes variables y que forman parte de un mismo valor
     */
    const TYPE_CHART_PIE_FROM_TAGS = 5;
    
    /**
     * Gráfico para mostrar los resultados de diferentes variables y que forman parte de un mismo valor
     */
    const TYPE_CHART_BARS_AREA = 6;
    
    // NOMBRES DE LOS GRÁFICOS
    
    /**
     * Nombre del gráfico para mostrar los indicadores asociados
     */
    const CHART_INDICATORS_ASSOCIATED_WITH_RESULT = 'CHART_INDICATORS_ASSOCIATED_WITH_RESULT';
    
    /**
     * Gráfico para poder mostrar el real, plan y resultado de los indicadores asociados
     */
    const CHART_INDICATORS_ASSOCIATED_REAL_PLAN_WITH_RESULT = 'CHART_INDICATORS_ASSOCIATED_REAL_PLAN_WITH_RESULT';
    
    /**
     * Nombre del gráfico para mostrar las variables de los indicadores 
     */
    const CHART_INDICATORS_WITH_VARIABLES = 'CHART_INDICATORS_WITH_VARIABLES';
    
    /**
     * Nombre del gráfico para mostrar las variables o etiquetas de los indicadores en forma de torta
     */
    const CHART_INDICATORS_VARIABLES_OR_TAGS_IN_PIE = 'CHART_INDICATORS_VARIABLES_OR_TAGS_IN_PIE';
    
    /**
     * Nombre del gráfico para mostrar las variables o etiquetas de los indicadores en forma de Barra t Area
     */
    const CHART_INDICATORS_BARS_AREA = 'CHART_INDICATORS_BARS_AREA';
    
    
    
    /**
     * @var integer
     * 
     * @ORM\Column(name="typeOfChart", type="integer", nullable=false)
     */
    protected $typeOfChart = self::TYPE_CHART_INDICATORS_ASSOCIATED;
    
    
    /**
     * Retorna el tipo de gráfico
     * @return integer
     */
    function getTypeOfChart() 
    {
        return $this->typeOfChart;
    }
    
    /**
     * Establece el tipo de gráfico
     * 
     * @param integer $typeOfChart Chart::TYPE_CHART_*
     * @return \Pequiven\SEIPBundle\Model\Chart
     */
    function setTypeOfChart($typeOfChart) {
        $this->typeOfChart = $typeOfChart;
        
        return $this;
    }
    
    /**
     * Retorna las etiquetas de cada tipo de gráfico que existe en el sistema
     * @return type
     */
    static function getLabelsTypeOfChart()
    {
         static $typesOfChart = array(
            self::TYPE_CHART_INDICATORS_ASSOCIATED => 'chart.type.indicatorsAssociatedDoughnut',
            self::TYPE_CHART_COLUMN_REAL_PLAN => 'chart.type.indicatorsAssociatedRealPlanWithResult',
            self::TYPE_CHART_VARIABLES_DOUGHNUT => 'chart.type.indicatorsDoughnutWithVariables',
            self::TYPE_CHART_PIE_VARIABLES_OR_TAGS => 'chart.type.indicatorsVariablesOrTagsInPie',
            self::TYPE_CHART_COLUMN_FROM_FORMULA_PARAMETERS => 'chart.type.resultsOfIndicator',
            self::TYPE_CHART_PIE_FROM_TAGS => 'chart.type.resultsOfVariable',
            self::TYPE_CHART_BARS_AREA => 'chart.type.indicatorsBarArea'
        );
         
         return $typesOfChart;
    }
    
}