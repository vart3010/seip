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
     * 18-Función que retorna la data para un gráfico tipo multiseries de línea, para las lesiones personales con tiempo, acumulados
     * @return JsonResponse
     */
    public function getDataChartMultiSeriesLineIndicatorPersonalInjuryWithAccumulatedTimeFromChildrensAction(Request $request) {
        $response = new JsonResponse();

        $idIndicator = $request->get('id');

        $indicatorService = $this->getIndicatorService(); //Obtenemos el servicio del indicador

        $indicator = $this->get('pequiven.repository.indicator')->find($idIndicator); //Obtenemos el indicador

        $dataChart = $indicatorService->getDataChartLineMultiSeries($indicator, array('resultIndicatorPersonalInjuryWithAccumulatedTimeFromChildrens' => true)); //Obtenemos la data del gráfico de acuerdo al indicador

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
    

}
