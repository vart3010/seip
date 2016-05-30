<?php

namespace Pequiven\SEIPBundle\Controller;

use Pequiven\SEIPBundle\Controller\SEIPController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controlador de gráficos en el SEIP
 *
 */
class ChartController extends SEIPController {

    /**
     * 0-Función que retorna la data de los indicadores asociados en un gráfico de tipo dona.
     * @return JsonResponse
     */
    public function getDataChartTypeDoughnutIndicatorsAssociatedAction(Request $request) {
        $response = new JsonResponse();

        $idIndicator = $request->get('id');

        $indicatorService = $this->getIndicatorService(); //Obtenemos el servicio del indicador

        $indicator = $this->get('pequiven.repository.indicator')->find($idIndicator); //Obtenemos el indicador

        $dataChart = $indicatorService->getDataDashboardWidgetDoughnut($indicator, array('childrens' => true)); //Obtenemos la data del gráfico de acuerdo al indicador

        $response->setData($dataChart); //Seteamos la data del gráfico en Json

        return $response;
    }

    /**
     * 1-Función que retorna la data para un gráfico tipo barras vertical para mostrar el real/plan de los indicadores asociados respecto al eje izquierdo y el resultado de la medición en valor porcentual respecto al lado derecho de los indicadores hijos.
     * @return JsonResponse
     */
    public function getDataChartTypeColumnLineDualAxisIndicatorsAssociatedAction(Request $request) {
        $response = new JsonResponse();

        $idIndicator = $request->get('id');

        $indicatorService = $this->getIndicatorService(); //Obtenemos el servicio del indicador

        $indicator = $this->get('pequiven.repository.indicator')->find($idIndicator); //Obtenemos el indicador

        $dataChart = $indicatorService->getChartColumnLineDualAxis($indicator, array('childrens' => true)); //Obtenemos la data del gráfico de acuerdo al indicador

        $response->setData($dataChart); //Seteamos la data del gráfico en Json

        return $response;
    }

    /**
     * 2-Función que retorna la data para un gráfico de tipo dona. Muestra en la dona el valor de las variables de la fórmula del indicador
     * @return JsonResponse
     */
    public function getDataChartTypeDoughnutWithVariablesRealPLanAction(Request $request) {
        $response = new JsonResponse();

        $idIndicator = $request->get('id');

        $indicatorService = $this->getIndicatorService(); //Obtenemos el servicio del indicador

        $indicator = $this->get('pequiven.repository.indicator')->find($idIndicator); //Obtenemos el indicador

        $dataChart = $indicatorService->getDataDashboardWidgetDoughnut($indicator, array('withVariablesRealPLan' => true)); //Obtenemos la data del gráfico de acuerdo al indicador

        $response->setData($dataChart); //Seteamos la data del gráfico en Json

        return $response;
    }

    /**
     * 3-Función que retorna la data para un gráfico para mostrar las variables de un indicador que esten marcadas como "real".
     * @return JsonResponse
     */
    public function getDataChartPieVariablesMarkedRealAction(Request $request) {
        $response = new JsonResponse();

        $idIndicator = $request->get('id');

        $indicatorService = $this->getIndicatorService(); //Obtenemos el servicio del indicador

        $indicator = $this->get('pequiven.repository.indicator')->find($idIndicator); //Obtenemos el indicador

        $dataChart = $indicatorService->getDataDashboardPie($indicator, array('viewVariablesMarkedReal' => true)); //Obtenemos la data del gráfico de acuerdo al indicador

        $response->setData($dataChart); //Seteamos la data del gráfico en Json

        return $response;
    }

    /**
     * 4-Función que retorna la data para un gráfico tipo barras vertical para mostrar el real/plan de los parámetros de cada mes. Sólo para el caso en que sean 2 parámetros (Bien sea plan y real automático o plan y real automático a partir de ecuación).
     * @return JsonResponse
     */
    public function getDataChartTypeColumnLineDualAxisRealPlanAction(Request $request) {
        $response = new JsonResponse();

        $idIndicator = $request->get('id');

        $indicatorService = $this->getIndicatorService(); //Obtenemos el servicio del indicador

        $indicator = $this->get('pequiven.repository.indicator')->find($idIndicator); //Obtenemos el indicador

        $dataChart = $indicatorService->getChartColumnLineDualAxis($indicator, array('withVariablesRealPLan' => true)); //Obtenemos la data del gráfico de acuerdo al indicador

        $response->setData($dataChart); //Seteamos la data del gráfico en Json

        return $response;
    }

    /**
     * 5-Función que retorna la data para un gráfico para mostrar las variables de un indicador que esten marcadas como "plan".
     * @return JsonResponse
     */
    public function getDataChartPieVariablesMarkedPlanAction(Request $request) {
        $response = new JsonResponse();

        $idIndicator = $request->get('id');

        $indicatorService = $this->getIndicatorService(); //Obtenemos el servicio del indicador

        $indicator = $this->get('pequiven.repository.indicator')->find($idIndicator); //Obtenemos el indicador

        $dataChart = $indicatorService->getDataDashboardPie($indicator, array('viewVariablesMarkedPlan' => true)); //Obtenemos la data del gráfico de acuerdo al indicador

        $response->setData($dataChart); //Seteamos la data del gráfico en Json

        return $response;
    }

    /**
     * 6-Función que retorna la data para un gráfico tipo barra vertical/área para mostrar el real/plan de acuerdo a la frecuencia de notificación
     * @param Request $request
     * @return JsonResponse
     */
    public function getDataChartBarsAreaVariablesRealPlanByFrequencyNotificationAction(Request $request) {
        $response = new JsonResponse();

        $idIndicator = $request->get('id');

        $indicatorService = $this->getIndicatorService(); //Obtenemos el servicio del indicador

        $indicator = $this->get('pequiven.repository.indicator')->find($idIndicator); //Obtenemos el indicador

        $dataChart = $indicatorService->getDataDashboardBarsArea($indicator, array('byFrequencyNotification' => true)); //Obtenemos la data del gráfico de acuerdo al indicador

        $response->setData($dataChart); //Seteamos la data del gráfico en Json

        return $response;
    }

    /**
     * 7-Función que retorna la data para un gráfico de tipo pie y sólo las variable sumativas a la parte plan de una fórmula a partir de ecuación.
     * @return JsonResponse
     */
    public function getDataChartPieVariablesPlanFromEquationAction(Request $request) {
        $response = new JsonResponse();

        $idIndicator = $request->get('id');

        $indicatorService = $this->getIndicatorService(); //Obtenemos el servicio del indicador

        $indicator = $this->get('pequiven.repository.indicator')->find($idIndicator); //Obtenemos el indicador

        $dataChart = $indicatorService->getDataDashboardPie($indicator, array('viewVariablesFromPlanEquation' => true)); //Obtenemos la data del gráfico de acuerdo al indicador

        $response->setData($dataChart); //Seteamos la data del gráfico en Json

        return $response;
    }

    /**
     * 8-Función que retorna la data para un gráfico de tipo pie y sólo las variable sumativas a la parte real de una fórmula a partir de ecuación.
     * @return JsonResponse
     */
    public function getDataChartPieVariablesRealFromEquationAction(Request $request) {
        $response = new JsonResponse();

        $idIndicator = $request->get('id');

        $indicatorService = $this->getIndicatorService(); //Obtenemos el servicio del indicador

        $indicator = $this->get('pequiven.repository.indicator')->find($idIndicator); //Obtenemos el indicador

        $dataChart = $indicatorService->getDataDashboardPie($indicator, array('viewVariablesFromRealEquation' => true)); //Obtenemos la data del gráfico de acuerdo al indicador

        $response->setData($dataChart); //Seteamos la data del gráfico en Json

        return $response;
    }

    /**
     * 9-Función que retorna la data para un gráfico de tipo columna y con 2 ejes verticales. Sólo para un indicador con fórmula real/plan (automático o a partir de ecuación)
     * @return JsonResponse
     */
    public function getDataChartColumnLineDualAxisByFrequencyNotificationAction(Request $request) {
        $response = new JsonResponse();

        $idIndicator = $request->get('id');

        $indicatorService = $this->getIndicatorService(); //Obtenemos el servicio del indicador

        $indicator = $this->get('pequiven.repository.indicator')->find($idIndicator); //Obtenemos el indicador

        $dataChart = $indicatorService->getChartColumnLineDualAxis($indicator, array('byFrequencyNotification' => true)); //Obtenemos la data del gráfico de acuerdo al indicador

        $response->setData($dataChart); //Seteamos la data del gráfico en Json

        return $response;
    }

    /**
     * 10-Función que retorna la data para un gráfico tipo barras vertical para mostrar el real/plan de los parámetros de cada mes. Sólo para el caso en que sean 2 parámetros (Bien sea plan y real automático o plan y real automático a partir de ecuación).
     * @return JsonResponse
     */
    public function getDataChartBarsAreaVariablesMarkedRealPlanByFrequencyNotificationAction(Request $request) {
        $response = new JsonResponse();

        $idIndicator = $request->get('id');

        $indicatorService = $this->getIndicatorService(); //Obtenemos el servicio del indicador

        $indicator = $this->get('pequiven.repository.indicator')->find($idIndicator); //Obtenemos el indicador

        $dataChart = $indicatorService->getDataDashboardBarsArea($indicator, array('withVariablesMarkedRealPlanByFrequencyNotification' => true)); //Obtenemos la data del gráfico de acuerdo al indicador

        $response->setData($dataChart); //Seteamos la data del gráfico en Json

        return $response;
    }

    /**
     * 11-Función que retorna la data para un gráfico tipo barras vertical para mostrar las variables marcadas como real/plan de la fórmula del indicador respecto al eje izquierdo, de acuerdo a la frecuencia de notificación.
     * @return JsonResponse
     */
    public function getDataChartColumnVariablesMarkedRealPlanByFrequencyNotificationAction(Request $request) {
        $response = new JsonResponse();

        $idIndicator = $request->get('id');

        $indicatorService = $this->getIndicatorService(); //Obtenemos el servicio del indicador

        $indicator = $this->get('pequiven.repository.indicator')->find($idIndicator); //Obtenemos el indicador

        $dataChart = $indicatorService->getDataChartColumnMultiSeries3d($indicator, array('withVariablesMarkedRealPlanByFrequencyNotification' => true)); //Obtenemos la data del gráfico de acuerdo al indicador

        $response->setData($dataChart); //Seteamos la data del gráfico en Json

        return $response;
    }

    /**
     * 12-Función que retorna la data para un gráfico tipo dona para mostrar el resultado real/plan a partir de la ecuación para gráficos de la fórmula del indicador.
     * @return JsonResponse
     */
    public function getDataChartVariablesRealPlanFromDashboardEquationDoughnutAction(Request $request) {
        $response = new JsonResponse();

        $idIndicator = $request->get('id');

        $indicatorService = $this->getIndicatorService(); //Obtenemos el servicio del indicador

        $indicator = $this->get('pequiven.repository.indicator')->find($idIndicator); //Obtenemos el indicador

        $dataChart = $indicatorService->getDataDashboardWidgetDoughnut($indicator, array('withVariablesRealPlanFromDashboardEquation' => true)); //Obtenemos la data del gráfico de acuerdo al indicador

        $response->setData($dataChart); //Seteamos la data del gráfico en Json

        return $response;
    }

    /**
     * 13-Función que retorna la data para un gráfico tipo columna 3d para mostrar el resultado real/plan de la ecuación para gráficos de la fórmula del indicador respecto al eje izquierdo, de cada indicador asociado
     * @return JsonResponse
     */
    public function getDataChartColumnRealPlanIndicatorsAssociatedFromDashboardEquationAction(Request $request) {
        $response = new JsonResponse();

        $idIndicator = $request->get('id');

        $indicatorService = $this->getIndicatorService(); //Obtenemos el servicio del indicador

        $indicator = $this->get('pequiven.repository.indicator')->find($idIndicator); //Obtenemos el indicador

        $dataChart = $indicatorService->getDataChartColumnMultiSeries3d($indicator, array('withVariablesRealPlanFromDashboardEquationFromChildrens' => true)); //Obtenemos la data del gráfico de acuerdo al indicador

        $response->setData($dataChart); //Seteamos la data del gráfico en Json

        return $response;
    }

    /**
     * 14-Función que retorna la data para un gráfico tipo columna 3d para mostrar el resultado real/plan de la ecuación para gráficos de la fórmula del indicador respecto al eje izquierdo, de acuerdo a la frecuencia de notificación
     * @return JsonResponse
     */
    public function getDataChartColumnRealPlanByFrequencyNotificationFromDashboardEquationAction(Request $request) {
        $response = new JsonResponse();

        $idIndicator = $request->get('id');

        $indicatorService = $this->getIndicatorService(); //Obtenemos el servicio del indicador

        $indicator = $this->get('pequiven.repository.indicator')->find($idIndicator); //Obtenemos el indicador

        $dataChart = $indicatorService->getDataChartColumnMultiSeries3d($indicator, array('withVariablesRealPlanByFrequencyNotificationFromDashboardEquation' => true)); //Obtenemos la data del gráfico de acuerdo al indicador

        $response->setData($dataChart); //Seteamos la data del gráfico en Json

        return $response;
    }

    /**
     * 15-Función que retorna la data para un gráfico tipo stacked column 3d para mostrar el resultado , de acuerdo a la frecuencia de notificación de las variables asociadas a la fórmula del indicador, con el total acumulado por variables al final
     * @return JsonResponse
     */
    public function getDataChartStackedColumnVariableByFrequencyNotificationWithTotalAction(Request $request) {
        $response = new JsonResponse();

        $idIndicator = $request->get('id');

        $indicatorService = $this->getIndicatorService(); //Obtenemos el servicio del indicador

        $indicator = $this->get('pequiven.repository.indicator')->find($idIndicator); //Obtenemos el indicador

        $dataChart = $indicatorService->getDataChartStackedColumn3d($indicator, array('variablesByFrequencyNotificationWithTotal' => true)); //Obtenemos la data del gráfico de acuerdo al indicador

        $response->setData($dataChart); //Seteamos la data del gráfico en Json

        return $response;
    }

    /**
     * 16-Función que retorna la data para un gráfico tipo column 3d para mostrar el resultado de un mes (Ideado para aquellos indicadores con fórmula acumulativo de cada carga) de los indicadores asociados, con el total acumulado al final
     * @return JsonResponse
     */
    public function getDataChartColumnResultIndicatorsAssociatedWithTotalByMonthAction(Request $request) {
        $response = new JsonResponse();

        $idIndicator = $request->get('id');
        $month = $request->get('month', date("n"));

        $indicatorService = $this->getIndicatorService(); //Obtenemos el servicio del indicador

        $indicator = $this->get('pequiven.repository.indicator')->find($idIndicator); //Obtenemos el indicador

        $dataChart = $indicatorService->getDataChartColumn3d($indicator, array('resultIndicatorsAssociatedWithTotalByMonth' => true, 'month' => $month)); //Obtenemos la data del gráfico de acuerdo al indicador

        $response->setData($dataChart); //Seteamos la data del gráfico en Json

        return $response;
    }

    /**
     * 17-Función que retorna la data para un gráfico tipo column 3d para mostrar el resultado de un mes (Ideado para aquellos indicadores con fórmula acumulativo de cada carga) de los indicadores asociados agrupados por tipo de empresa, con el total acumulado al final
     * @return JsonResponse
     */
    public function getDataChartColumnResultIndicatorsAssociatedGroupByTypeCompanyWithTotalByMonthAction(Request $request) {
        $response = new JsonResponse();

        $idIndicator = $request->get('id');
        $month = $request->get('month', date("n"));

        $indicatorService = $this->getIndicatorService(); //Obtenemos el servicio del indicador

        $indicator = $this->get('pequiven.repository.indicator')->find($idIndicator); //Obtenemos el indicador

        $dataChart = $indicatorService->getDataChartColumn3d($indicator, array('resultIndicatorsAssociatedGroupByTypeCompanyWithTotalByMonth' => true, 'month' => $month)); //Obtenemos la data del gráfico de acuerdo al indicador

        $response->setData($dataChart); //Seteamos la data del gráfico en Json

        return $response;
    }

    /**
     * 18-Función que retorna la data para un gráfico tipo multiseries de línea, para las lesiones personales con tiempo, acumulados, sólo del indicador (período actual y anterior)
     * @return JsonResponse
     */
    public function getDataChartMultiSeriesLineIndicatorPersonalInjuryWithAccumulatedTimeAction(Request $request) {
        $response = new JsonResponse();

        $idIndicator = $request->get('id');

        $indicatorService = $this->getIndicatorService(); //Obtenemos el servicio del indicador

        $indicator = $this->get('pequiven.repository.indicator')->find($idIndicator); //Obtenemos el indicador

        $dataChart = $indicatorService->getDataChartLineMultiSeries($indicator, array('resultIndicatorPersonalInjuryWithAccumulatedTime' => true, 'variables' => array("lesionados_con_tiempo_perdido" => true, "lesiones_con_tiempo_perdido" => true), 'path_array' => 'resultIndicatorPersonalInjuryWithAccumulatedTime')); //Obtenemos la data del gráfico de acuerdo al indicador

        $response->setData($dataChart); //Seteamos la data del gráfico en Json

        return $response;
    }

    /**
     * 19-Función que retorna la data para un gráfico tipo multiseries de línea, para las lesiones personales sin tiempo, sólo del indicador (período actual y anterior)
     * @return JsonResponse
     */
    public function getDataChartMultiSeriesLineIndicatorPersonalInjuryWithoutAccumulatedTimeAction(Request $request) {
        $response = new JsonResponse();

        $idIndicator = $request->get('id');

        $indicatorService = $this->getIndicatorService(); //Obtenemos el servicio del indicador

        $indicator = $this->get('pequiven.repository.indicator')->find($idIndicator); //Obtenemos el indicador

        $dataChart = $indicatorService->getDataChartLineMultiSeries($indicator, array('resultIndicatorPersonalInjuryWithoutAccumulatedTime' => true, 'variables' => array("lesionados_sin_tiempo_perdido" => true), 'path_array' => 'resultIndicatorPersonalInjuryWithoutAccumulatedTime')); //Obtenemos la data del gráfico de acuerdo al indicador

        $response->setData($dataChart); //Seteamos la data del gráfico en Json

        return $response;
    }

    /**
     * 20-Función que retorna la data para un gráfico tipo multiseries de línea, para las lesiones personales con y sin tiempo, acumulados, de los hijos del indicador
     * @return JsonResponse
     */
    public function getDataChartMultiSeriesLineIndicatorPersonalInjuryWithAndWithoutAccumulatedTimeFromChildrensAction(Request $request) {
        $response = new JsonResponse();

        $idIndicator = $request->get('id');

        $indicatorService = $this->getIndicatorService(); //Obtenemos el servicio del indicador

        $indicator = $this->get('pequiven.repository.indicator')->find($idIndicator); //Obtenemos el indicador

        $dataChart = $indicatorService->getDataChartLineMultiSeries($indicator, array('resultIndicatorPersonalInjuryWithAndWithoutAccumulatedTimeFromChildrens' => true)); //Obtenemos la data del gráfico de acuerdo al indicador

        $response->setData($dataChart); //Seteamos la data del gráfico en Json

        return $response;
    }

    /**
     * 21-Función que retorna la data para un gráfico tipo multiseries de línea, para los días perdidos, sólo del indicador (período actual y anterior)
     * @return JsonResponse
     */
    public function getDataChartMultiSeriesLineIndicatorLostDaysAccumulatedTimeAction(Request $request) {
        $response = new JsonResponse();

        $idIndicator = $request->get('id');

        $indicatorService = $this->getIndicatorService(); //Obtenemos el servicio del indicador

        $indicator = $this->get('pequiven.repository.indicator')->find($idIndicator); //Obtenemos el indicador

        $dataChart = $indicatorService->getDataChartLineMultiSeries($indicator, array('resultIndicatorLostDaysAccumulatedTime' => true, 'variables' => array("dias_perdidos" => true, "dias_perdidos_severidad" => true), 'path_array' => 'resultIndicatorLostDaysAccumulatedTime')); //Obtenemos la data del gráfico de acuerdo al indicador

        $response->setData($dataChart); //Seteamos la data del gráfico en Json

        return $response;
    }

    /**
     * 22-Función que retorna la data para un gráfico tipo multiseries columna 3d, para mostrar el resultado de una suma de variables de los indicadores hijos (lesionados con tiempo perdidoa, sin tiempo perdido y días perdidos), según sea el caso del período actual y anterior
     * @return JsonResponse
     */
    public function getDataChartMultiSeriesIndicatorAssociatedPersonalInjuryWithAndWithoutAndLostDaysByPeriodWithAccumulatedAction(Request $request) {
        $response = new JsonResponse();

        $idIndicator = $request->get('id');

        $indicatorService = $this->getIndicatorService(); //Obtenemos el servicio del indicador

        $indicator = $this->get('pequiven.repository.indicator')->find($idIndicator); //Obtenemos el indicador

        $dataChart = $indicatorService->getDataChartColumnMultiSeries3d($indicator, array('resultIndicatorsAssociatedPersonalInjuryWithAndWithoutAndLostDaysByPeriodAccumulated' => true, 'variables' => array("lesionados_con_tiempo_perdido" => true, "lesiones_con_tiempo_perdido" => true, "lesionados_sin_tiempo_perdido" => true, "dias_perdidos" => true), 'path_array' => 'resultIndicatorsAssociatedPersonalInjuryWithAndWithoutAndLostDaysByPeriodAccumulated')); //Obtenemos la data del gráfico de acuerdo al indicador

        $response->setData($dataChart); //Seteamos la data del gráfico en Json

        return $response;
    }

    /**
     * 23-Función que retorna la data para un gráfico tipo multiseries columna 3d, para mostrar el resultado de una suma de variables de los indicadores hijos (lesionados con tiempo perdidoa, sin tiempo perdido y días perdidos), según sea el caso del período actual y anterior
     * @return JsonResponse
     */
    public function getDataChartMultiSeriesColumnLineIndicatorPersonalInjuryWithAndWithoutAndLostDaysByFrequencyNotificationByPeriodGroupByCompanyWithAccumulatedAction(Request $request) {
        $response = new JsonResponse();

        $idIndicator = $request->get('id');

        $indicatorService = $this->getIndicatorService(); //Obtenemos el servicio del indicador

        $indicator = $this->get('pequiven.repository.indicator')->find($idIndicator); //Obtenemos el indicador

        $dataChart = $indicatorService->getChartColumnLineDualAxis($indicator, array('resultIndicatorPersonalInjuryWithAndWithoutAndLostDaysByFrequencyNotificationByPeriodGroupByCompanyAccumulated' => true, 'variables' => array("lesionados_con_tiempo_perdido" => true, "lesiones_con_tiempo_perdido" => true, "lesionados_sin_tiempo_perdido" => true, "dias_perdidos" => true, "dias_perdidos_severidad" => true), 'path_array' => 'resultIndicatorPersonalInjuryWithAndWithoutAndLostDaysByFrequencyNotificationByPeriodGroupByCompanyAccumulated')); //Obtenemos la data del gráfico de acuerdo al indicador

        $response->setData($dataChart); //Seteamos la data del gráfico en Json

        return $response;
    }

    /**
     * 24-Función que retorna la data para un gráfico tipo mulsiseries columna + línea, todo respecto al mismo eje, para mostrar el resultado de las lesiones con tiempo perdido por frecuencia de notificación del indicador del período actual y anterior (línea) y el acumulado por período (columna) al final.
     * @return JsonResponse
     */
    public function getDataChartMultiSeriesColumnLineIndicatorPersonalInjuryWithLostTimeByFrequencyNotificationByPeriodWithAccumulatedAction(Request $request) {
        $response = new JsonResponse();

        $idIndicator = $request->get('id');

        $indicatorService = $this->getIndicatorService(); //Obtenemos el servicio del indicador

        $indicator = $this->get('pequiven.repository.indicator')->find($idIndicator); //Obtenemos el indicador

        $dataChart = $indicatorService->getChartColumnLineDualAxis($indicator, array('resultIndicatorPersonalInjuryWithLostTimeByFrequencyNotificationByPeriodAccumulated' => true, 'variables' => array("lesionados_con_tiempo_perdido" => true, "lesiones_con_tiempo_perdido" => true), 'path_array' => 'resultIndicatorPersonalInjuryWithLostTimeByFrequencyNotificationByPeriodAccumulated')); //Obtenemos la data del gráfico de acuerdo al indicador

        $response->setData($dataChart); //Seteamos la data del gráfico en Json

        return $response;
    }

    /**
     * 25-Función que retorna la data para un gráfico tipo mulsiseries columna + línea, todo respecto al mismo eje, para mostrar el resultado de las lesiones sin tiempo perdido por frecuencia de notificación del indicador del período actual y anterior (línea) y el acumulado por período (columna) al final.
     * @return JsonResponse
     */
    public function getDataChartMultiSeriesColumnLineIndicatorPersonalInjuryWithoutLostTimeByFrequencyNotificationByPeriodWithAccumulatedAction(Request $request) {
        $response = new JsonResponse();

        $idIndicator = $request->get('id');

        $indicatorService = $this->getIndicatorService(); //Obtenemos el servicio del indicador

        $indicator = $this->get('pequiven.repository.indicator')->find($idIndicator); //Obtenemos el indicador

        $dataChart = $indicatorService->getChartColumnLineDualAxis($indicator, array('resultIndicatorPersonalInjuryWithoutLostTimeByFrequencyNotificationByPeriodAccumulated' => true, 'variables' => array("lesionados_sin_tiempo_perdido" => true), 'path_array' => 'resultIndicatorPersonalInjuryWithoutLostTimeByFrequencyNotificationByPeriodAccumulated')); //Obtenemos la data del gráfico de acuerdo al indicador

        $response->setData($dataChart); //Seteamos la data del gráfico en Json

        return $response;
    }

    /**
     * 26-Función que retorna la data para un gráfico tipo mulsiseries columna + línea, todo respecto al mismo eje, para mostrar el resultado de los días perdidos por frecuencia de notificación del indicador del período actual y anterior (línea) y el acumulado por período (columna) al final.
     * @return JsonResponse
     */
    public function getDataChartMultiSeriesColumnLineIndicatorLostDaysByFrequencyNotificationByPeriodWithAccumulatedAction(Request $request) {
        $response = new JsonResponse();

        $idIndicator = $request->get('id');

        $indicatorService = $this->getIndicatorService(); //Obtenemos el servicio del indicador

        $indicator = $this->get('pequiven.repository.indicator')->find($idIndicator); //Obtenemos el indicador

        $dataChart = $indicatorService->getChartColumnLineDualAxis($indicator, array('resultIndicatorLostDaysByFrequencyNotificationByPeriodAccumulated' => true, 'variables' => array("dias_perdidos" => true, "dias_perdidos_severidad" => true), 'path_array' => 'resultIndicatorLostDaysByFrequencyNotificationByPeriodAccumulated')); //Obtenemos la data del gráfico de acuerdo al indicador

        $response->setData($dataChart); //Seteamos la data del gráfico en Json

        return $response;
    }

    /**
     * 27-Función que retorna la data para un gráfico sólo para avances de proyectos por frecuencia de notificación.
     * @return JsonResponse
     */
    public function getDataChartChartProgressProjectsByFrequencyNotificationAction(Request $request) {
        $response = new JsonResponse();

        $idIndicator = $request->get('id');

        $indicatorService = $this->getIndicatorService(); //Obtenemos el servicio del indicador

        $indicator = $this->get('pequiven.repository.indicator')->find($idIndicator); //Obtenemos el indicador

        $dataChart = $indicatorService->getChartColumnLineDualAxis($indicator, array('progressProjectsByFrequencyNotification' => true, 'path_array' => 'progressProjectsByFrequencyNotification')); //Obtenemos la data del gráfico de acuerdo al indicador

        $response->setData($dataChart); //Seteamos la data del gráfico en Json

        return $response;
    }

    /**
     * 28-Función que retorna la data para un gráfico de tipo columna y con 2 ejes verticales. Sólo para un indicador con fórmula real/plan (automático o a partir de ecuación)
     * @return JsonResponse
     */
    public function getDataChartColumnLineDualAxisByDifferentFrequencyNotificationAction(Request $request) {
        $response = new JsonResponse();

        $idIndicator = $request->get('id');

        $indicatorService = $this->getIndicatorService(); //Obtenemos el servicio del indicador

        $indicator = $this->get('pequiven.repository.indicator')->find($idIndicator); //Obtenemos el indicador

        $dataChart = $indicatorService->getChartColumnLineDualAxis($indicator, array('byDifferentFrequencyNotification' => true)); //Obtenemos la data del gráfico de acuerdo al indicador

        $response->setData($dataChart); //Seteamos la data del gráfico en Json

        return $response;
    }

    /**
     * 29-Función que retorna la data para un gráfico tipo multiseries de línea, con un trendline horizontal
     * @return JsonResponse
     */
    public function getDataChartMultiSeriesLineIndicatorWithTrendlineHorizontalAction(Request $request) {
        $response = new JsonResponse();

        $idIndicator = $request->get('id');

        $indicatorService = $this->getIndicatorService(); //Obtenemos el servicio del indicador

        $indicator = $this->get('pequiven.repository.indicator')->find($idIndicator); //Obtenemos el indicador

        $dataChart = $indicatorService->getDataChartLineMultiSeries($indicator, array('resultIndicatorWithTrendlineHorizontal' => true)); //Obtenemos la data del gráfico de acuerdo al indicador

        $response->setData($dataChart); //Seteamos la data del gráfico en Json

        return $response;
    }

    /**
     * 30 y 31-Función que retorna la data para un gráfico de piramide seccionada basada en el real o plan
     * @return JsonResponse
     * @author Gilbert C. <glavrjk@gmail.com>
     */
    public function getDataPyramid3DSectionedAction(Request $request) {

        $response = new JsonResponse();
        $idIndicator = $request->get('id');
        $type = $request->get('type');
        $options = array('type' => $type);
        $indicatorService = $this->getIndicatorService(); //Obtenemos el servicio del indicador
        $indicator = $this->get('pequiven.repository.indicator')->find($idIndicator); //Obtenemos el indicador
        $dataChart = $indicatorService->getDataPyramid3DSectioned($indicator, $options); //Obtenemos la data del gráfico de acuerdo al indicador
        $response->setData($dataChart); //Seteamos la data del gráfico en Json

        return $response;
    }

    /**
     * 32-Función que retorna un cilindro apilado con los valores plan y real de las variables de un indicador
     * @return JsonResponse
     * @author Gilbert C. <glavrjk@gmail.com>
     */
    public function getDataStackedColumn3DbyIndicatorAction(Request $request) {

        $response = new JsonResponse();
        $idIndicator = $request->get('id');
        $options = array(
            "colors" => array(
                1 => "BDBDBD",
                2 => "da2f2a",
                3 => "e58123",
                4 => "3C7BCF",
                5 => "9BC348",
                6 => "FFFFCC",
                7 => "FFFFFF",
                8 => "FFFFFF",
                9 => "FFFFFF",
                10 => "FFFFFF",
            )
        );
        $indicatorService = $this->getIndicatorService(); //Obtenemos el servicio del indicador
        $indicator = $this->get('pequiven.repository.indicator')->find($idIndicator); //Obtenemos el indicador
        $dataChart = $indicatorService->getDataStackedColumn3DbyIndicator($indicator, $options); //Obtenemos la data del gráfico de acuerdo al indicador
        $response->setData($dataChart); //Seteamos la data del gráfico en Json

        return $response;
    }

    /**
     * 29-Función que retorna la data para un gráfico tipo multiseries de línea, con un trendline horizontal
     * @return JsonResponse
     */
    public function getDataChartMultiSeriesLineIndicatorWithTrendlineHorizontalOnlyResultAction(Request $request) {
        $response = new JsonResponse();

        $idIndicator = $request->get('id');

        $indicatorService = $this->getIndicatorService(); //Obtenemos el servicio del indicador

        $indicator = $this->get('pequiven.repository.indicator')->find($idIndicator); //Obtenemos el indicador

        $dataChart = $indicatorService->getDataChartLineMultiSeries($indicator, array('resultIndicatorWithTrendlineHorizontalOnlyResult' => true)); //Obtenemos la data del gráfico de acuerdo al indicador

        $response->setData($dataChart); //Seteamos la data del gráfico en Json

        return $response;
    }

    /**
     * Función que retorna la data para un gráfico que muestre la producción por las plantas de un reportTemplate (Día, Mes y Año)
     * @return JsonResponse
     */
    public function getDataChartProductionReportTemplateByDateAction(Request $request) {
        $response = new JsonResponse();

        $idReportTemplate = $request->get('id');
        $dateSearch = $request->get('dateSearch');

        $reportTemplateService = $this->getReportTemplateService(); //Obtenemos el servicio del ReportTemplate

        $reportTemplate = $this->get('pequiven.repository.report_template')->find($idReportTemplate); //Obtenemos el ReportTemplate

        $dataChart = $reportTemplateService->getDataChartStackedColumn3d($reportTemplate, array('consolidateByReportTemplate' => true, 'dateSearch' => $dateSearch)); //Obtenemos la data del gráfico de acuerdo al indicador

        $response->setData($dataChart); //Seteamos la data del gráfico en Json

        return $response;
    }

    /**
     * Función que retorna la data para un gráfico que muestre la producción por las plantas de un grupo de reportTemplate por Día, de acuerdo al tipo de compañía asociado
     * @return JsonResponse
     */
    public function getDataChartProductionReportTemplateByDateGroupByCompanyAction(Request $request) {
        $response = new JsonResponse();

        $typeCompany = $request->get('typeCompany');
        $dateSearch = $request->get('dateSearch');

        $reportTemplateService = $this->getReportTemplateService(); //Obtenemos el servicio del ReportTemplate

        $reportTemplate = new \Pequiven\SEIPBundle\Entity\DataLoad\ReportTemplate();

        $dataChart = $reportTemplateService->getDataChartMultiSeriesColumn3D($reportTemplate, array('consolidateByTypeCompany' => true, 'dateSearch' => $dateSearch, 'typeCompany' => $typeCompany)); //Obtenemos la data del gráfico de acuerdo al indicador

        $response->setData($dataChart); //Seteamos la data del gráfico en Json

        return $response;
    }

    /**
     * Función que retorna la data para un gráfico que muestre la producción por las plantas de un grupo de reportTemplate por Día de la corporación
     * @return JsonResponse
     */
    public function getDataChartProductionReportTemplateByDateCorporationAction(Request $request) {
        $response = new JsonResponse();

        $dateSearch = $request->get('dateSearch');
        $typeView = $request->get('typeView');

        $reportTemplateService = $this->getReportTemplateService(); //Obtenemos el servicio del ReportTemplate

        $reportTemplate = new \Pequiven\SEIPBundle\Entity\DataLoad\ReportTemplate();

        if ($typeView == \Pequiven\SEIPBundle\Entity\Monitor::MONITOR_PRODUCTION_VIEW_STATUS_CHARGE) {
            $dataChart = $reportTemplateService->getDataChartMultiSeriesColumn3D($reportTemplate, array('consolidateCorporationStatusCharge' => true, 'dateSearch' => $dateSearch));
        } elseif ($typeView == \Pequiven\SEIPBundle\Entity\Monitor::MONITOR_PRODUCTION_VIEW_COMPLIANCE) {
            $dataChart = $reportTemplateService->getDataChartMultiSeriesDualAxis($reportTemplate, array('consolidateCorporationCompliance' => true, 'dateSearch' => $dateSearch));
        }

        $response->setData($dataChart); //Seteamos la data del gráfico en Json

        return $response;
    }

    /**
     * Función que retorna la data para un gráfico que muestre la producción por las plantas de un grupo de reportTemplate por Día de la corporación
     * @return JsonResponse
     */
    public function getDataChartProductionByReportTemplateByDateAction(Request $request) {
        $response = new JsonResponse();

        $dateSearch = $request->get('dateSearch');
        $typeView = $request->get('typeView');
        $typeDate = $request->get('typeDate');
        $reportTemplateId = $request->get('reportTemplateId');

        $reportTemplateService = $this->getReportTemplateService(); //Obtenemos el servicio del ReportTemplate

        $reportTemplate = $this->get('pequiven.repository.report_template')->find($reportTemplateId); //Obtenemos el ReportTemplate

        if ($typeView == \Pequiven\SEIPBundle\Entity\Monitor::MONITOR_PRODUCTION_VIEW_STATUS_CHARGE) {
            $dataChart = $reportTemplateService->getDataChartMultiSeriesColumn3D($reportTemplate, array('reportTemplateByDateStatusCharge' => true, 'dateSearch' => $dateSearch, 'typeDate' => $typeDate));
        } elseif ($typeView == \Pequiven\SEIPBundle\Entity\Monitor::MONITOR_PRODUCTION_VIEW_COMPLIANCE) {
            $dataChart = $reportTemplateService->getDataChartMultiSeriesDualAxis($reportTemplate, array('reportTemplateByDateCompliance' => true, 'dateSearch' => $dateSearch, 'typeDate' => $typeDate));
        }

        $response->setData($dataChart); //Seteamos la data del gráfico en Json

        return $response;
    }

    /**
     * Servicio de los Indicadores
     * @return \Pequiven\IndicatorBundle\Service\IndicatorService
     */
    public function getIndicatorService() {
        return $this->container->get('pequiven_indicator.service.inidicator');
    }

    /**
     * Servicio que calcula los resultados
     * @return \Pequiven\SEIPBundle\Service\ResultService
     */
    public function getResultService() {
        return $this->container->get('seip.service.result');
    }

    /**
     * Servicio de los ReportTemplates (Producción)
     * @return \Pequiven\SEIPBundle\Service\DataLoad\ReportTemplateService
     */
    public function getReportTemplateService() {
        return $this->container->get('data_load.service.report_template');
    }

}
