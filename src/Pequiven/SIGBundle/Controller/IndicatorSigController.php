<?php

namespace Pequiven\SIGBundle\Controller;

use Pequiven\IndicatorBundle\Entity\Indicator;
use Pequiven\SIGBundle\Entity\ManagementSystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController;
use Pequiven\SIGBundle\Controller\EvolutionController;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Pequiven\IndicatorBundle\Entity\IndicatorLevel;

use Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionCause;
use Pequiven\IndicatorBundle\Form\EvolutionIndicator\EvolutionCauseType;
use Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionTrend;
use Pequiven\IndicatorBundle\Form\EvolutionIndicator\EvolutionTrendType;
use Pequiven\IndicatorBundle\Form\EvolutionIndicator\IndicatorLastPeriodType;
use Pequiven\IndicatorBundle\Form\EvolutionIndicator\IndicatorConfigSigType;
use Pequiven\IndicatorBundle\Form\EvolutionIndicator\EvolutionIndicatorCloningType;

/**
 * Controlador Informe de Evolución del Indicador
 *
 * @author Maximo Sojo <maxsojo13@gmail.com>
 */
class IndicatorSigController extends EvolutionController {

    /**
     * Lista de Indicadores por nivel(Estratégico, Táctico u Operativo)
     * Filtrados por managementSystems
     * @param Request $request
     * @return type
     */
    function listAction(Request $request) {

        $level = $request->get('level');

        $rol = null;
        $roleByLevel = array(
            IndicatorLevel::LEVEL_ESTRATEGICO => array('ROLE_SEIP_SIG_INDICATOR_LIST'),
            IndicatorLevel::LEVEL_TACTICO => array('ROLE_SEIP_SIG_INDICATOR_LIST'),
            IndicatorLevel::LEVEL_OPERATIVO => array('ROLE_SEIP_SIG_INDICATOR_LIST')
        );
        if (isset($roleByLevel[$level])) {
            $rol = $roleByLevel[$level];
        }

        $this->getSecurityService()->checkSecurity($rol);

        $criteria = $request->get('filter', $this->config->getCriteria());
        $sorting = $request->get('sorting', $this->config->getSorting());
        $repository = $this->container->get('pequiven.repository.sig_indicator');
        
        $criteria['indicatorLevel'] = $level;
        $criteria['applyPeriodCriteria'] = true;

        if ($this->config->isPaginated()) {
            $resources = $this->resourceResolver->getResource(
                    $repository, 'createPaginatorByLevelSIG', array($criteria, $sorting)
            );


            $maxPerPage = $this->config->getPaginationMaxPerPage();
            if (($limit = $request->query->get('limit')) && $limit > 0) {
                if ($limit > 100) {
                    $limit = 100;
                }
                $maxPerPage = $limit;
            }
            $resources->setCurrentPage($request->get('page', 1), true, true);
            $resources->setMaxPerPage($maxPerPage);
        } else {
            $resources = $this->resourceResolver->getResource(
                    $repository, 'findBy', array($criteria, $sorting, $this->config->getLimit())
            );
        }
        $routeParameters = array(
            '_format' => 'json',
            'level' => $level,
        );
        $apiDataUrl = $this->generateUrl('pequiven_indicatorsig_list', $routeParameters);
        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('list.html'))
                ->setTemplateVar($this->config->getPluralResourceName())
        ;

        $view->getSerializationContext()->setGroups(array('id', 'api_list', 'valuesIndicator', 'managementSystems', 'api_details', 'sonata_api_read', 'formula'));
        if ($request->get('_format') == 'html') {
            $labelsSummary = array();
            foreach (Indicator::getLabelsSummary() as $key => $value) {
                $labelsSummary[] = array(
                    'id' => $key,
                    'description' => $this->trans($value, array(), 'PequivenSIGBundle'),
                );
            }

            $data = array(
                'apiDataUrl' => $apiDataUrl,
                $this->config->getPluralResourceName() => $resources,
                'level' => $level,
                'labelsSummary' => $labelsSummary
            );
            $view->setData($data);
        } else {
            $formatData = $request->get('_formatData', 'default');

            $view->setData($resources->toArray('', array(), $formatData));
        }
        return $this->handleView($view);
    }

    /**
     * Vista indice de evolucion
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function evolutionAction(Request $request) {
        
        $resource = $this->findOr404($request);
        
        $sumCause = 0; 
        $typeObject = 1;

        $idIndicator = $request->get('id');

        $indicator = $this->get('pequiven.repository.indicator')->find($idIndicator); //Obtenemos el indicador        
        
        //Validación para Visualizar informe de Evolución
        if (!$indicator->getShowEvolutionView()) {
            $this->get('session')->getFlashBag()->add('success', 'Indicador no Habilitado para Visualizar Informe de Evolución');
            return $this->redirect($this->generateUrl("pequiven_indicator_show", array("id" => $indicator->getId())));         
        }

        $indicatorBase = $indicator;
        //Seteo de Indicador a clonar
        if ($indicator->getParentCloning()) {
            $indicator = $indicator->getParentCloning();    
            $idIndicator = $indicator->getId();                
                if ($indicator->getParentCloning()) {                    
                    $indicator = $indicator->getParentCloning();
                    $idIndicator = $indicator->getId();                
                }            
        }
        

        $month = $request->get('month'); //El mes pasado por parametro
        $evolutionService = $this->getEvolutionService(); //Obtenemos el servicio de las causas            
        $data = $evolutionService->findEvolutionCause($indicator, $request, $typeObject); //Carga la data de las causas y sus acciones relacionadas
        
        $approve = $evolutionService->findToCheckApproveEvolution($indicator, $typeObject, $month); //Carga la data de las causas y sus acciones relacionadas
       
        //Validación de que el mes pasado este entre los validos
        if ($month > 12) {
            $this->get('session')->getFlashBag()->add('error', "El mes consultado no es un mes valido!");
            $month = 12;
        } elseif ($month < 1) {
            $this->get('session')->getFlashBag()->add('error', "El mes consultado no es un mes valido!");
            $month = 01;
        }

        //Url export
        $urlExportFromChart = $this->generateUrl('pequiven_indicator_evolution_export_chart', array('id' => $request->get("id"), 'month' => $month, 'typeObj' => 1));
        
        //Carga de data de Indicador para armar grafica
        $response = new JsonResponse();

        $indicatorService = $this->getIndicatorService(); //Obtenemos el servicio del indicador
        
        $dataChart = $indicatorService->getDataChartOfIndicatorEvolution($indicatorBase,$urlExportFromChart,$month); //Obtenemos la data del gráfico de acuerdo al indicador
        
        //Carga de los datos de la grafica de las Causas de Desviación
        $dataCause = $evolutionService->getDataChartOfCausesEvolution($indicator, $urlExportFromChart, $month, $typeObject); //Obtenemos la data del grafico de las causas de desviación
        
        $causes = $this->get('pequiven.repository.sig_causes_report_evolution')->findBy(array('idObject' => $idIndicator, 'month' => $month, 'typeObject' => $typeObject));
        foreach ($causes as $value) {
            $dataCa = $value->getValueOfCauses();
            $sumCause = $sumCause + $dataCa;
        }

        //Carga el analisis de la tendencia
        $trend = $this->get('pequiven.repository.sig_trend_report_evolution')->findBy(array('idObject' => $idIndicator, 'month' => $month, 'typeObject' => $typeObject));
        //Carga del analisis de las causas
        $causeAnalysis = $this->get('pequiven.repository.sig_causes_analysis')->findBy(array('idObject' => $idIndicator, 'month' => $month, 'typeObject' => $typeObject));
        //Carga de la señalización de la tendencia de la grafica        
        $tendency = $indicator->getTendency()->getId();
        $font = array();
        switch ($tendency) {
            case 0:
                $font = [
                    'icon' => '',
                    'text' => ''
                ];
                break;
            case 1:
                $font = [
                    'icon' => 'long-arrow-up',
                    'text' => 'Mejor hacia...'
                ];
                break;
            case 2:
                $font = [
                    'icon' => 'long-arrow-down',
                    'text' => 'Mejor hacia...'
                ];
                break;
            case 3:
                $font = [
                    'icon' => 'long-arrow-right',
                    'text' => 'Estable...'
                ];
                break;
        }

        $dataAction = [
            'action' => $data["action"],
            'values' => $data["actionValue"]
        ];
        
        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('evolution.html'))
                ->setData(array(
            'data' => $dataChart,
            'verification' => $data["verification"],
            'dataCause'  => $dataCause,
            'analysis'   => $causeAnalysis,//Analisis de Causas
            'cause'      => $causes,//Causas
            'sumCause'   => $sumCause,//suma de causas
            'month'      => $month,
            'dataAction' => $dataAction,
            'trend'      => $trend,
            'font'       => $font,
            'typeObject' => $typeObject,
            'id'         => $idIndicator,
            'lastPeriod' => $indicator->getIndicatorLastPeriod(),
            'route'      => "pequiven_indicator_evolution", //Ruta para carga de Archivo
            'urlExportFromChart' => $urlExportFromChart,
            'approve'    => $approve,
            $this->config->getResourceName() => $resource,            
        ));

        return $this->handleView($view);
    }

    /**
     * Retorna el formulario de la relacion del indicador con periodo Anterior
     * 
     * @param Request $request
     * @return type
     */
    function getFormAction(Request $request) {
        $indicator = $this->findIndicatorOr404($request);
        $period = $indicator->getPeriod()->getId() - 1;
        
        $indicatorRel = new Indicator();
        $form = $this->createForm(new IndicatorLastPeriodType($period), $indicatorRel);

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('form/form.html'))
                ->setTemplateVar($this->config->getPluralResourceName())
                ->setData(array(
            'indicator' => $indicator,
            'form' => $form->createView(),
                ))
        ;
        $view->getSerializationContext()->setGroups(array('id', 'api_list'));
        return $view;
    }

    /**
     * Añade la relacion con el indicador 2014
     * 
     * @param Request $request
     * @return type
     */
    public function addLastPeriodAction(Request $request) {
        $idIndicator = $request->get('idObject');

        $lastPeriod = $request->get('lastPeriod')['indicatorlastPeriod'];
        
        $em = $this->getDoctrine()->getManager();
        $indicatorRel = $this->get('pequiven.repository.sig_indicator')->find($idIndicator);

        if ($indicatorRel) {
            $dataLast = $this->get('pequiven.repository.sig_indicator')->find($lastPeriod);
        }

        $indicatorRel->setIndicatorLastPeriod($dataLast);
        $em->flush();
        $this->get('session')->getFlashBag()->add('success', "Relación Cargada Correctamente");
    }

    /**
     * Elimina la relación con el Indicador 2014
     * 
     * @param Request $request
     * @return type
     */
    public function deleteLastPeriodAction(Request $request) {
        $idIndicator = $request->get('id');

        $em = $this->getDoctrine()->getManager();
        $indicatorRel = $this->get('pequiven.repository.sig_indicator')->find($idIndicator);

        if ($indicatorRel) {
            $dataLast = NULL;
        }

        $indicatorRel->setIndicatorLastPeriod($dataLast);

        $em->flush();
        $this->get('session')->getFlashBag()->add('success', "Relación Eliminada Correctamente");
    }

    /**
     * Retorna el formulario de configuracion de la grafica del infome de evolución
     * 
     * @param Request $request
     * @return type
     */
    function getFormConfigAction(Request $request)
    {
        $id = $request->get('idObject');        
        //$typeObject = $request->get('typeObj');
        //$month = $request->get('evolutiontrend')['month'];//Carga de Mes pasado        
        
        $indicator = new indicator();
        $form  = $this->createForm(new IndicatorConfigSigType(), $indicator);
        
        if ($request->get('configSig')) {
            $em = $this->getDoctrine()->getManager();
            $indicatorRel = $this->get('pequiven.repository.sig_indicator')->find($id);
            
            $medition = $request->get('configSig')['indicatorSigMedition'];

            $indicatorRel->setIndicatorSigMedition($medition);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', "Configuración de Medición Cargada Correctamente");
            die();
        }

        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('form/form_config_chart.html'))
            ->setTemplateVar($this->config->getPluralResourceName())
            ->setData(array(                
                'form' => $form->createView(),
            ))
        ;
        $view->getSerializationContext()->setGroups(array('id','api_list'));
        return $view;
    }

    /**
     * Retorna el formulario de Carga de Indicador al que se clonara el informe de evolución
     * 
     * @param Request $request
     * @return type
     */
    function getFormCloningAction(Request $request)
    {
        $id = $request->get('id');        
        $indicatorData = $this->get('pequiven.repository.sig_indicator')->find($id);                    
        $period = $indicatorData->getPeriod()->getId();

        $indicator = new indicator();
        $form  = $this->createForm(new EvolutionIndicatorCloningType($period), $indicator);
        
        if ($request->get('indicatoCloning')['parentCloning']) {
            $em = $this->getDoctrine()->getManager();            
            $indicatorCloning = $this->get('pequiven.repository.sig_indicator')->find($request->get('indicatoCloning')['parentCloning']);                                

            $indicatorData->setParentCloning($indicatorCloning);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', "Datos Cargados Correctamente");
            die();
        }

        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('form/form_cloning.html'))
            ->setTemplateVar($this->config->getPluralResourceName())
            ->setData(array(                
                'form' => $form->createView(),
            ))
        ;
        $view->getSerializationContext()->setGroups(array('id','api_list'));
        return $view;
    }    
    
    /**
     * Busca el indicador o retorna un 404
     * @param Request $request
     * @return \Pequiven\IndicatorBundle\Entity\Indicator
     * @throws type
     */
    private function findIndicatorOr404(Request $request) {
        $id = $request->get('idObject');

        $indicator = $this->get('pequiven.repository.indicator')->find($id);
        if (!$indicator) {
            throw $this->createNotFoundException();
        }
        return $indicator;
    }

    public function loadAction(Request $request){

        $levels = [
            1 => "Indicadores Estratégicos",
            2 => "Indicadores Tácticos",
            3 => "Indicadores Operativos",            
        ];
        
        $cont = $trendData = $causeData = $cause = $actionData = $level = 0;
        $dataStrategic = $dataTactic = $dataOperative = $totalStrategic = $totalTactic = $totalOperative = 0;
        $dataStrategicIn = $dataTacticIn = $dataOperativeIn = [];
        $indicatorsStrategic = $indicatorsTactic = $indicatorsOperatives = [];
        
        if ($request->get('m')) {            
            for ($i=1; $i <= count($levels); $i++) {             
                $indicators = $this->get('pequiven.repository.indicator')->findQueryIndicatorValid($this->getPeriodService()->getPeriodActive(), $i);                                    
                foreach ($indicators as $valueIndicator) {
                    $trendAnalysis = $this->get('pequiven.repository.sig_trend_report_evolution')->findBy(array('indicator' => $valueIndicator->getId(), 'month' => $request->get('m'), 'typeObject' => 1));        
                    if ($trendAnalysis) {
                        $trendData = $trendData + count($trendAnalysis);
                    }
                    if ($i == 1) {
                        $totalStrategic++;
                        if ($trendAnalysis or $valueIndicator->getParentCloning()) {
                            $dataStrategic = $dataStrategic + 1;                                    
                            $indicatorsStrategic[] = $valueIndicator;                    
                        }else{
                            $dataStrategicIn[] = $valueIndicator;
                        }
                    }elseif ($i == 2) {
                        $totalTactic++;
                        if ($trendAnalysis or $valueIndicator->getParentCloning()) {
                            $dataTactic = $dataTactic + 1;                                    
                            $indicatorsTactic[] = $valueIndicator;                                            
                        }else{
                            $dataTacticIn[] = $valueIndicator;
                        }
                    }elseif ($i == 3) {
                        $totalOperative++;
                        if ($trendAnalysis or $valueIndicator->getParentCloning()) {
                            $dataOperative = $dataOperative + 1;                        
                            $indicatorsOperatives[] = $valueIndicator;                                            
                        }else{
                            $dataOperativeIn[] = $valueIndicator;
                        }
                    }
                    $causeAnalysis = $this->get('pequiven.repository.sig_causes_analysis')->findBy(array('indicator' => $valueIndicator->getId(), 'month' => $request->get('m')));
                    if ($causeAnalysis) {
                        $causeData = $causeData + count($causeAnalysis);                
                        //$causeData = $causeData + count($causeAnalysis);
                    }

                    $causes = $this->get('pequiven.repository.sig_causes_report_evolution')->findBy(array('indicator' => $valueIndicator->getId(), 'month' => $request->get('m')));                                    
                    if ($causes) {
                        $cause = $cause + count($causes);
                        //$cause = $cause + count($causes);
                    }
                    foreach ($causes as $key => $valueCause) {
                        $action = $this->get('pequiven.repository.sig_action_indicator')->findBy(array('evolutionCause' => $valueCause->getId()));
                        if ($action) {
                            $actionData = $actionData + count($action);
                            //$actionData = $actionData + count($action);
                        }
                    }
                    $cont++;                                           
                }
            }
            
            $dataIndicators = [
                1 => $dataStrategic,
                2 => $dataTactic,
                3 => $dataOperative
            ];

            $dataIndicatorsInLoad = [
                1 => $dataStrategicIn,
                2 => $dataTacticIn,
                3 => $dataOperativeIn
            ];

            $dataTotal = [
                1 => $totalStrategic, 
                2 => $totalTactic,
                3 => $totalOperative
            ];

            $indicators = [
                1 => $indicatorsStrategic,
                2 => $indicatorsTactic,
                3 => $indicatorsOperatives
            ];

            $dataGeneral = [
                1 => "Analisis de Tendencias Cargados: " . $trendData,
                2 => "Analisis de Causas Cargados: " . $causeData,
                3 => "Causas Cargadas: " . $cause,
                4 => "Planes de Acción Cargados: " . $actionData
            ];
            $data = [                                    
                'dataIndicators'       => $dataIndicators,
                'dataTotal'            => $dataTotal,
                'indicators'           => $indicators,
                'dataGeneral'          => $dataGeneral,
                'dataIndicatorsInLoad' => $dataIndicatorsInLoad,
                'value'                => 1,
                'month'                => $request->get('m'),
                'host'  => $_SERVER["HTTP_HOST"]
            ];
        }else{
            $data = [
                'value' => 0,
                'host'  => $_SERVER["HTTP_HOST"]
            ];            
        }        
        
        return $this->render('PequivenSIGBundle:Indicator:load.html.twig', array('data' => $data, 'levels' => $levels));
    }

    /**
     *
     *
     */
    public function getUrlEvolutionAction(Request $request){
        $response = new JsonResponse();        
        
        $routeParameters = [
            'route' =>  $request->get('url'),
            'value' =>  $request->get('value')
        ];

        $DataUrl = $this->generateUrl($routeParameters['route'], array('m' => $routeParameters['value']));
        
        $DataUrl = "http://".$_SERVER["HTTP_HOST"].$DataUrl;

        $data = [
            'dataUrl' => $DataUrl,            
        ];

        $response->setData($data);

        return $response;        
    }

    /**
     * 
     * @return \Pequiven\SIGBundle\Service\EvolutionService
     */
    protected function getEvolutionService() {
        return $this->container->get('seip.service.evolution');
    } 

    /**
     * 
     * @return \Pequiven\IndicatorBundle\Service\IndicatorService
     */
    protected function getIndicatorService() {
        return $this->container->get('pequiven_indicator.service.inidicator');
    }    

    /**
     * 
     * @return \Pequiven\SEIPBundle\Service\SecurityService
     */
    protected function getSecurityService() {

        return $this->container->get('seip.service.security');
    } 
    /**
     *  Period
     *
     */
    protected function getPeriodService() {
        return $this->container->get('pequiven_seip.service.period');
    }

}
