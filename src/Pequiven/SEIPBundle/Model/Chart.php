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
    const TYPE_CHART_COLUMN_REAL_PLAN_INDICATORS_ASSOCIATED = 1;
    
    /**
     * Gráfico tipo dona para mostrar las variables de la fórmula del indicador.
     */
    const TYPE_CHART_VARIABLES_REAL_PLAN_DOUGHNUT = 2;
    
    /**
     * Gráfico para mostrar las variables de un indicador que esten marcadas como "real"
     */
    const TYPE_CHART_PIE_VARIABLES_MARKED_REAL = 3;
    
    /**
     * Gráfico tipo barras vertical para mostrar el real/plan en el eje izquierdo y el resultado de la medición en el eje derecho del indicador.
     */
    const TYPE_CHART_COLUMN_VARIABLES_REAL_PLAN = 4;
    
    /**
     * Gráfico para mostrar las variables de un indicador que esten marcadas como "plan"
     */
    const TYPE_CHART_PIE_VARIABLES_MARKED_PLAN = 5;
    
    /**
     * Gráfico tipo barra vertical/área para mostrar el real/plan de acuerdo a la frecuencia de notificación
     */
    const TYPE_CHART_BARS_AREA_VARIABLES_REAL_PLAN_BY_FREQUENCY_NOTIFICATION = 6;
    
    /**
     * Gráfico para mostrar las variables (sumativas al plan) de un indicador con fórmula a partir de ecuación
     */
    const TYPE_CHART_PIE_VARIABLES_PLAN_FROM_EQUATION = 7;
    
    /**
     * Gráfico para mostrar las variables (sumativas al real) de un indicador con fórmula a partir de ecuación
     */
    const TYPE_CHART_PIE_VARIABLES_REAL_FROM_EQUATION = 8;
    
    /**
     * Gráfico tipo barras vertical para mostrar el real/plan de los resultados respecto al eje izquierdo y el resultado de la medición en valor porcentual respecto al lado derecho, de acuerdo a la frecuencia de notificación
     */
    const TYPE_CHART_COLUMN_REAL_PLAN_BY_FREQUENCY_NOTIFICATION = 9;
    
    /**
     * Gráfico tipo barra vertical/área para mostrar las variables marcadas como real en área y plan como barra, de acuerdo a la frecuencia de notificación.
     */
    const TYPE_CHART_BARS_AREA_VARIABLES_MARKED_REAL_PLAN_BY_FREQUENCY_NOTIFICATION = 10;
    
    /**
     * Gráfico tipo columna 3d para mostrar las variables marcadas como real/plan de la fórmula del indicador respecto al eje izquierdo, de acuerdo a la frecuencia de notificación
     */
    const TYPE_CHART_COLUMN_VARIABLES_MARKED_REAL_PLAN_BY_FREQUENCY_NOTIFICATION = 11;
    
    /**
     * Gráfico tipo dona para mostrar el resultado real/plan a partir de la ecuación para gráficos de la fórmula del indicador.
     */
    const TYPE_CHART_VARIABLES_REAL_PLAN_FROM_DASHBOARD_EQUATION_DOUGHNUT = 12;
    
    /**
     * Gráfico tipo columna 3d para mostrar el resultado real/plan de la ecuación para gráficos de la fórmula del indicador respecto al eje izquierdo, de cada indicador asociado
     */
    const TYPE_CHART_COLUMN_REAL_PLAN_INDICATORS_ASSOCIATED_FROM_DASHBOARD_EQUATION = 13;
    
    /**
     * Gráfico tipo columna 3d para mostrar el resultado real/plan de la ecuación para gráficos de la fórmula del indicador respecto al eje izquierdo, de acuerdo a la frecuencia de notificación
     */
    const TYPE_CHART_COLUMN_REAL_PLAN_BY_FREQUENCY_NOTIFICATION_FROM_DASHBOARD_EQUATION = 14;
    
    /**
     * Gráfico tipo stacked column 3d para mostrar el resultado , de acuerdo a la frecuencia de notificación de las variables asociadas a la fórmula del indicador, con el total acumulado por variables al final
     */
    const TYPE_CHART_STACKED_COLUMN_VARIABLE_BY_FREQUENCY_NOTIFICATION_WITH_TOTAL = 15;
    
    /**
     * Gráfico tipo column 3d para mostrar el resultado de un mes (Ideado para aquellos indicadores con fórmula acumulativo de cada carga) de los indicadores asociados, con el total acumulado al final
     */
    const TYPE_CHART_COLUMN_RESULT_INDICATORS_ASSOCIATED_WITH_TOTAL_BY_MONTH = 16;
    
    /**
     * Gráfico tipo column 3d para mostrar el resultado de un mes (Ideado para aquellos indicadores con fórmula acumulativo de cada carga) de los indicadores asociados agrupados por tipo de empresa, con el total acumulado al final
     */
    const TYPE_CHART_COLUMN_RESULT_INDICATORS_ASSOCIATED_GROUP_BY_TYPE_COMPANY_WITH_TOTAL_BY_MONTH = 17;
    
    /**
     * Gráfico tipo multiseries de línea, para las lesiones personales con tiempo, acumulados, sólo del indicador (período actual y anterior)
     */
    const TYPE_CHART_MULTI_SERIES_LINE_INDICATOR_PERSONAL_INJURY_WITH_ACCUMULATED_TIME = 18;
    
    /**
     * Gráfico tipo multiseries de línea, para las lesiones personales sin tiempo, sólo del indicador (período actual y anterior)
     */
    const TYPE_CHART_MULTI_SERIES_LINE_INDICATOR_PERSONAL_INJURY_WITHOUT_ACCUMULATED_TIME = 19;
    
    /**
     * Gráfico tipo multiseries de línea, para las lesiones personales con y sin tiempo y dias perdidos, acumulados, de los hijos del indicador
     */
    const TYPE_CHART_MULTI_SERIES_LINE_INDICATOR_PERSONAL_INJURY_WHIT_AND_WITHOUT_ACCUMULATED_TIME_FROM_CHILDRENS = 20;
        
    /**
     * Gráfico tipo multiseries de línea, para los días perdidos, sólo del indicador (período actual y anterior)
     */
    const TYPE_CHART_MULTI_SERIES_LINE_INDICATOR_LOST_DAYS_ACCUMULATED_TIME = 21;
    
    /**
     * Gráfico tipo multiseries columna 3d, para mostrar el resultado de una suma de variables de los indicadores hijos (lesionados con tiempo perdidoa, sin tiempo perdido y días perdidos), según sea el caso del período actual y anterior
     */
    const TYPE_CHART_MULTI_SERIES_COLUMN_INDICATORS_ASSOCIATED_PERSONAL_INJURY_WITH_AND_WITHOUT_AND_LOST_DAYS_BY_PERIOD_WITH_ACCUMULATED = 22;
    
    /**
     * Gráfico tipo multiseries columna + línea, todo respecto al mismo eje, para mostrar el resultado de la suma de variables por frecuencia del indicador agrupados por compañia y del período actual y anterior (línea) y el acumulado por período (columna) al final.
     */
    const TYPE_CHART_MULTI_SERIES_COLUMN_LINE_INDICATOR_PERSONAL_INJURY_WITH_AND_WITHOUT_AND_LOST_DAYS_BY_FREQUENCY_NOTIFICATION_BY_PERIOD_GROUP_BY_COMPANY_WITH_ACCUMULATED = 23;
    
    /**
     * Gráfico tipo mulsiseries columna + línea, todo respecto al mismo eje, para mostrar el resultado de las lesiones con tiempo perdido por frecuencia de notificación del indicador del período actual y anterior (línea) y el acumulado por período (columna) al final.
     */
    const TYPE_CHART_MULTI_SERIES_COLUMN_LINE_INDICATOR_PERSONAL_INJURY_WITH_LOST_TIME_BY_FREQUENCY_NOTIFICATION_BY_PERIOD_WITH_ACCUMULATED = 24;
    
    /**
     * Gráfico tipo mulsiseries columna + línea, todo respecto al mismo eje, para mostrar el resultado de las lesiones sin tiempo perdido por frecuencia de notificación del indicador del período actual y anterior (línea) y el acumulado por período (columna) al final.
     */
    const TYPE_CHART_MULTI_SERIES_COLUMN_LINE_INDICATOR_PERSONAL_INJURY_WITHOUT_LOST_TIME_BY_FREQUENCY_NOTIFICATION_BY_PERIOD_WITH_ACCUMULATED = 25;
    
    /**
     * Gráfico tipo mulsiseries columna + línea, todo respecto al mismo eje, para mostrar el resultado de los días perdidos por frecuencia de notificación del indicador del período actual y anterior (línea) y el acumulado por período (columna) al final.
     */
    const TYPE_CHART_MULTI_SERIES_COLUMN_LINE_INDICATOR_LOST_DAYS_BY_FREQUENCY_NOTIFICATION_BY_PERIOD_WITH_ACCUMULATED = 26;
    
    /**
     * Gráfico sólo para avances de proyectos por frecuencia de notificación
     */
    const TYPE_CHART_PROGRESS_PROJECTS_BY_FREQUENCY_NOTIFICATION = 27;
    
    /**
     * Gráfico tipo barras vertical para mostrar el real/plan de los resultados respecto al eje izquierdo y el resultado de la medición en valor porcentual respecto al lado derecho, de acuerdo a una frecuencia de notificación diferente a la del indicador
     */
    const TYPE_CHART_COLUMN_REAL_PLAN_BY_DIFFERENT_FREQUENCY_NOTIFICATION = 28;
    
    /**
     * Gráfico tipo multiseries de línea, con un trendline de forma horizontal
     */
    const TYPE_CHART_MULTI_SERIES_LINE_INDICATOR_WITH_TRENDLINE_HORIZONTAL = 29;    
    
    /**
     * Gráfico tipo Pirámide 3D Seccionada REAL
     */
    const TYPE_CHART_REAL_PYRAMID_3D_SECTIONED = 30;
    
    /**
     * Gráfico tipo Pirámide 3D Seccionada PLAN
     */
    const TYPE_CHART_PLAN_PYRAMID_3D_SECTIONED = 31;
    
    /**
     * Gráfico tipo Cilindro Apilado
     */
    const TYPE_CHART_STACKED_COLUMN_3D_BY_INDICATOR = 32;
    
    /**
     * Gráfico tipo Cilindro Apilado
     */
    const TYPE_CHART_MULTI_SERIES_LINE_INDICATOR_WITH_TRENDLINE_HORIZONTAL_AND_ONLY_RESULT = 33;
    
    
    
    const TYPE_EXAMPLE = 100;
       
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
            self::TYPE_CHART_COLUMN_REAL_PLAN_INDICATORS_ASSOCIATED_FROM_DASHBOARD_EQUATION => 'chart.type.indicatorsAssociatedColumnMultiSeriesRealPlanFromDashboardEquation',
            self::TYPE_CHART_COLUMN_REAL_PLAN_BY_FREQUENCY_NOTIFICATION_FROM_DASHBOARD_EQUATION => 'chart.type.resultsOfIndicatorColumnMultiSeriesRealPlanByFrequencyNotificationFromDashboardEquation',
            self::TYPE_CHART_STACKED_COLUMN_VARIABLE_BY_FREQUENCY_NOTIFICATION_WITH_TOTAL => 'chart.type.indicatorVariablesStackedColumnByFrequencyNotificationWithTotal',
            self::TYPE_CHART_COLUMN_RESULT_INDICATORS_ASSOCIATED_WITH_TOTAL_BY_MONTH => 'chart.type.indicatorsAssociatedColumnWithTotalByMonth',
            self::TYPE_CHART_COLUMN_RESULT_INDICATORS_ASSOCIATED_GROUP_BY_TYPE_COMPANY_WITH_TOTAL_BY_MONTH => 'chart.type.indicatorsAssociatedColumnGroupByTypeCompanyWithTotalByMonth',
            self::TYPE_CHART_MULTI_SERIES_LINE_INDICATOR_PERSONAL_INJURY_WITH_ACCUMULATED_TIME => 'chart.type.indicatorPersonalInjuryWithAccumulatedTime',
            self::TYPE_CHART_MULTI_SERIES_LINE_INDICATOR_PERSONAL_INJURY_WITHOUT_ACCUMULATED_TIME => 'chart.type.indicatorPersonalInjuryWithoutAccumulatedTime',
            self::TYPE_CHART_MULTI_SERIES_LINE_INDICATOR_PERSONAL_INJURY_WHIT_AND_WITHOUT_ACCUMULATED_TIME_FROM_CHILDRENS => 'chart.type.indicatorPersonalInjuryWithAndWithoutAccumulatedTimeFromChildrens',
            self::TYPE_CHART_MULTI_SERIES_LINE_INDICATOR_LOST_DAYS_ACCUMULATED_TIME => 'chart.type.indicatorLostDaysAccumulatedTime',
            self::TYPE_CHART_MULTI_SERIES_COLUMN_INDICATORS_ASSOCIATED_PERSONAL_INJURY_WITH_AND_WITHOUT_AND_LOST_DAYS_BY_PERIOD_WITH_ACCUMULATED => 'chart.type.indicatorsAssociatedPersonalInjuryWithAndWithoutAndLostDaysByPeriodWithAccumulated',
            self::TYPE_CHART_MULTI_SERIES_COLUMN_LINE_INDICATOR_PERSONAL_INJURY_WITH_AND_WITHOUT_AND_LOST_DAYS_BY_FREQUENCY_NOTIFICATION_BY_PERIOD_GROUP_BY_COMPANY_WITH_ACCUMULATED => 'chart.type.indicatorPersonalInjuryWithAndWithoutAndLostDaysByFrequencyNotificationByPeriodGroupByCompanyWithAccumulated',
            self::TYPE_CHART_MULTI_SERIES_COLUMN_LINE_INDICATOR_PERSONAL_INJURY_WITH_LOST_TIME_BY_FREQUENCY_NOTIFICATION_BY_PERIOD_WITH_ACCUMULATED => 'chart.type.indicatorPersonalInjuryWithLostTimeByFrequencyNotificationByPeriodWithAccumulated',
            self::TYPE_CHART_MULTI_SERIES_COLUMN_LINE_INDICATOR_PERSONAL_INJURY_WITHOUT_LOST_TIME_BY_FREQUENCY_NOTIFICATION_BY_PERIOD_WITH_ACCUMULATED => 'chart.type.indicatorPersonalInjuryWithoutLostTimeByFrequencyNotificationByPeriodWithAccumulated',
            self::TYPE_CHART_MULTI_SERIES_COLUMN_LINE_INDICATOR_LOST_DAYS_BY_FREQUENCY_NOTIFICATION_BY_PERIOD_WITH_ACCUMULATED => 'chart.type.indicatorLostDaysByFrequencyNotificationByPeriodWithAccumulated',
            self::TYPE_CHART_PROGRESS_PROJECTS_BY_FREQUENCY_NOTIFICATION => 'chart.type.typeChartProgressProjectsByFrequencyNotification',
            self::TYPE_CHART_COLUMN_REAL_PLAN_BY_DIFFERENT_FREQUENCY_NOTIFICATION => 'chart.type.indicatorsVariablesRealPlanByDifferentFrequencyNotification',
            self::TYPE_CHART_MULTI_SERIES_LINE_INDICATOR_WITH_TRENDLINE_HORIZONTAL => 'chart.type.indicatorWithTrendlineHorizontal',
            self::TYPE_CHART_REAL_PYRAMID_3D_SECTIONED => 'chart.type.indicatorPyramidRealSection',
            self::TYPE_CHART_PLAN_PYRAMID_3D_SECTIONED => 'chart.type.indicatorPyramidPlanSection',
            self::TYPE_CHART_STACKED_COLUMN_3D_BY_INDICATOR => 'chart.type.stackedColumn3dByIndicator',
            self::TYPE_CHART_MULTI_SERIES_LINE_INDICATOR_WITH_TRENDLINE_HORIZONTAL_AND_ONLY_RESULT => 'chart.type.indicatorWithTrendlineHorizontalOnlyResult',
            self::TYPE_EXAMPLE => 'chart.type.example',
        );
         
         return $typesOfChart;
    }
    
}