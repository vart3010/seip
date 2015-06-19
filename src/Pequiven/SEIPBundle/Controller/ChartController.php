<?php

namespace Pequiven\SEIPBundle\Controller;

use Pequiven\SEIPBundle\Controller\SEIPController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controlador de gráficos en el SEIP
 *
 */
 
class ChartController extends SEIPController 
{
    
    /**
     * Función que retorna la data para un gráfico de tipo dona. Ejemplo para los indicadores estratégicos y muestre como está constituido el mismo
     * @return JsonResponse
     */
    public function getDataChartTypeDoughnutAction(Request $request){
        $response = new JsonResponse();
        
        $idIndicator = $request->get('id');
        
        $indicatorService = $this->getIndicatorService();//Obtenemos el servicio del indicador
        
        $indicator = $this->get('pequiven.repository.indicator')->find($idIndicator);//Obtenemos el indicador
        
        $dataChart = $indicatorService->getDataDashboardWidgetDoughnut($indicator,array('childrens' => true));//Obtenemos la data del gráfico de acuerdo al indicador
        
        $response->setData($dataChart);//Seteamos la data del gráfico en Json
        
        return $response;
    }
    
    /**
     * Función que retorna la data para un gráfico de tipo dona. Muestra en la dona el valor de las variables de la fórmula del indicador
     * @return JsonResponse
     */
    public function getDataChartTypeDoughnutWithVariablesAction(Request $request){
        $response = new JsonResponse();
        
        $idIndicator = $request->get('id');
        
        $indicatorService = $this->getIndicatorService();//Obtenemos el servicio del indicador
        
        $indicator = $this->get('pequiven.repository.indicator')->find($idIndicator);//Obtenemos el indicador
        
        $dataChart = $indicatorService->getDataDashboardWidgetDoughnut($indicator,array('withVariables' => true));//Obtenemos la data del gráfico de acuerdo al indicador
        
        $response->setData($dataChart);//Seteamos la data del gráfico en Json
        
        return $response;
    }
    
    /**
     * Función que retorna la data para un gráfico de tipo columna y con 2 ejes verticales.
     * @return JsonResponse
     */
    public function getDataChartTypeColumnLineDualAxisAction(Request $request){
        $response = new JsonResponse();
        
        $idIndicator = $request->get('id');
        
        $indicatorService = $this->getIndicatorService();//Obtenemos el servicio del indicador
        
        $indicator = $this->get('pequiven.repository.indicator')->find($idIndicator);//Obtenemos el indicador
        
        $dataChart = $indicatorService->getChartColumnLineDualAxis($indicator);//Obtenemos la data del gráfico de acuerdo al indicador
        
        $response->setData($dataChart);//Seteamos la data del gráfico en Json
        
        return $response;
    }
    
    /**
     * Función que retorna la data para un gráfico de tipo columna y con 2 ejes verticales.
     * @return JsonResponse
     */
    public function getDataChartTypePieVariablesOrTagsAction(Request $request){
        $response = new JsonResponse();
        
        $idIndicator = $request->get('id');
        
        $indicatorService = $this->getIndicatorService();//Obtenemos el servicio del indicador
        
        $indicator = $this->get('pequiven.repository.indicator')->find($idIndicator);//Obtenemos el indicador
        
        $dataChart = $indicatorService->getDataDashboardPie($indicator,array());//Obtenemos la data del gráfico de acuerdo al indicador
        
        $response->setData($dataChart);//Seteamos la data del gráfico en Json
        
        return $response;
    }
    
    /**
     * Servicio de los Indicadores
     * @return \Pequiven\IndicatorBundle\Service\IndicatorService
     */
    public function getIndicatorService()
    {
        return $this->container->get('pequiven_indicator.service.inidicator');
    }
    
    /**
     * Servicio que calcula los resultados
     * @return \Pequiven\SEIPBundle\Service\ResultService
     */
    public function getResultService()
    {
        return $this->container->get('seip.service.result');
    }
    
}