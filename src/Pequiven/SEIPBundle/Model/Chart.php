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
    //TIPOS DE GRÁFICOS
    
    /**
     * Gráfico tipo dona para mostrar los indicadores asociados de acuerdo y junto con el resultado de medición
     */
    const TYPE_CHART_INDICATORS_ASSOCIATED_DOUGHNUT = 0; //ACTIVO Y USADO
    
    /**
     * Gráfico tipo barras vertical para mostrar el real/plan de los indicadores asociados respecto al eje izquierdo y el resultado de la medición en valor porcentual respecto al lado derecho de los indicadores hijos
     */
    const TYPE_CHART_COLUMN_REAL_PLAN_INDICATORS_ASSOCIATED = 1; //ACTIVO Y USADO
    
    /**
     * Gráfico tipo dona para mostrar las variables de la fórmula del indicador.
     */
    const TYPE_CHART_VARIABLES_REAL_PLAN_DOUGHNUT = 2; //ACTIVO Y USADO
    
    /**
     * Gráfico para mostrar las variables de un indicador que esten marcadas como "real"
     */
    const TYPE_CHART_PIE_VARIABLES_MARKED_REAL = 3; //ACTIVO Y USADO
    
    /**
     * Gráfico tipo barras vertical para mostrar el real/plan en el eje izquierdo y el resultado de la medición en el eje derecho del indicador.
     */
    const TYPE_CHART_COLUMN_VARIABLES_REAL_PLAN = 4; //ACTIVO Y USADO
    
    /**
     * Gráfico para mostrar las variables de un indicador que esten marcadas como "plan"
     */
    const TYPE_CHART_PIE_VARIABLES_MARKED_PLAN = 5; //ACTIVO Y USADO
    
    /**
     * Gráfico tipo barra vertical/área para mostrar el real/plan de acuerdo a la frecuencia de notificación
     */
    const TYPE_CHART_BARS_AREA_VARIABLES_REAL_PLAN_BY_FREQUENCY_NOTIFICATION = 6; //ACTIVO Y USADO
    
    /**
     * Gráfico para mostrar las variables (sumativas al plan) de un indicador con fórmula a partir de ecuación
     */
    const TYPE_CHART_PIE_VARIABLES_PLAN_FROM_EQUATION = 7; //ACTIVO Y USADO
    
    /**
     * Gráfico para mostrar las variables (sumativas al real) de un indicador con fórmula a partir de ecuación
     */
    const TYPE_CHART_PIE_VARIABLES_REAL_FROM_EQUATION = 8; //ACTIVO Y USADO
    
    /**
     * Gráfico tipo barras vertical para mostrar el real/plan de los resultados respecto al eje izquierdo y el resultado de la medición en valor porcentual respecto al lado derecho, de acuerdo a la frecuencia de notificación
     */
    const TYPE_CHART_COLUMN_REAL_PLAN_BY_FREQUENCY_NOTIFICATION = 9; // ACTIVO Y USADO
    
    /**
     * Gráfico tipo barra vertical/área para mostrar las variables marcadas como real en área y plan como barra, de acuerdo a la frecuencia de notificación.
     */
    const TYPE_CHART_BARS_AREA_VARIABLES_MARKED_REAL_PLAN_BY_FREQUENCY_NOTIFICATION = 10; // NO USADO
    
    /**
     * Gráfico tipo columna 3d para mostrar las variables marcadas como real/plan de la fórmula del indicador respecto al eje izquierdo, de acuerdo a la frecuencia de notificación
     */
    const TYPE_CHART_COLUMN_VARIABLES_MARKED_REAL_PLAN_BY_FREQUENCY_NOTIFICATION = 11;
    
    /**
     * Gráfico tipo dona para mostrar el resultado real/plan a partir de la ecuación para gráficos de la fórmula del indicador.
     */
    const TYPE_CHART_VARIABLES_REAL_PLAN_FROM_DASHBOARD_EQUATION_DOUGHNUT = 12; //ACTIVO Y USADO
    
    const TYPE_EXAMPLE = 20;
       
    /**
     * @var integer
     * 
     * @ORM\Column(name="typeOfChart", type="integer", nullable=false)
     */
    protected $typeOfChart = self::TYPE_CHART_INDICATORS_ASSOCIATED_DOUGHNUT;
    
    
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
            self::TYPE_CHART_INDICATORS_ASSOCIATED_DOUGHNUT => 'chart.type.indicatorsAssociatedDoughnut',
            self::TYPE_CHART_COLUMN_REAL_PLAN_INDICATORS_ASSOCIATED => 'chart.type.indicatorsAssociatedRealPlanWithResult',
            self::TYPE_CHART_VARIABLES_REAL_PLAN_DOUGHNUT => 'chart.type.indicatorsDoughnutWithVariables',
            self::TYPE_CHART_PIE_VARIABLES_MARKED_REAL => 'chart.type.indicatorsVariablesMarkedRealInPie',
            self::TYPE_CHART_COLUMN_VARIABLES_REAL_PLAN => 'chart.type.resultsOfIndicator',
            self::TYPE_CHART_PIE_VARIABLES_MARKED_PLAN => 'chart.type.indicatorsVariablesMarkedPlanInPie',
            self::TYPE_CHART_BARS_AREA_VARIABLES_REAL_PLAN_BY_FREQUENCY_NOTIFICATION => 'chart.type.indicatorsVariablesRealPlanBarAreaByFrequencyNotification',
            self::TYPE_CHART_PIE_VARIABLES_PLAN_FROM_EQUATION => 'chart.type.indicatorsVariablesPlanFromEquationInPie',
            self::TYPE_CHART_PIE_VARIABLES_REAL_FROM_EQUATION => 'chart.type.indicatorsVariablesRealFromEquationInPie',
            self::TYPE_CHART_COLUMN_REAL_PLAN_BY_FREQUENCY_NOTIFICATION => 'chart.type.indicatorsVariablesRealPlanByFrequencyNotification',
            self::TYPE_CHART_BARS_AREA_VARIABLES_MARKED_REAL_PLAN_BY_FREQUENCY_NOTIFICATION => 'chart.type.indicatorsBarAreaVariablesMarkedRealPlanByFrequencyNotification',
            self::TYPE_CHART_COLUMN_VARIABLES_MARKED_REAL_PLAN_BY_FREQUENCY_NOTIFICATION => 'chart.type.indicatorsColumnMultiSeriesVariablesMarkedRealPlanByFrequencyNotification',
            self::TYPE_CHART_VARIABLES_REAL_PLAN_FROM_DASHBOARD_EQUATION_DOUGHNUT => 'chart.type.indicatorsDoughnutWithVariablesRealPlanFromDashboardEquation',
            self::TYPE_EXAMPLE => 'chart.type.example',
        );
         
         return $typesOfChart;
    }
    
}