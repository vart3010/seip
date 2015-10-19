<?php

namespace Pequiven\SIGBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Controlador ArrangementProgram SIG
 *
 * @author Maximo Sojo <maxsojo13@gmail.com>
 */
class ArrangementProgramSigController extends ResourceController
{
    public function evolutionAction(Request $request)
    {
    	$id = $request->get("id");//Id ArrangmentProgram
        $month = $request->get('month'); //El mes pasado por parametro

        $em = $this->getDoctrine()->getManager();

        $data = $this->findEvolutionCause($request);//Carga la data de las causas y sus acciones relacionadas
    	
    	$ArrangementProgram = $em->getRepository('PequivenArrangementProgramBundle:ArrangementProgram')->findWithData($id);
        //Creaciń de Grafico para informe de Evolución
        $response = new JsonResponse();

        $ArrangementProgramService = $this->getArrangementProgramService(); //Obtenemos el servicio del indicador
        
        $dataChart = $ArrangementProgramService->getDataChartOfArrangementProgramEvolution($ArrangementProgram); //Obtenemos la data del gráfico de acuerdo al programa

        $dataCause = $ArrangementProgramService->getDataChartOfCausesEvolution($ArrangementProgram, $month); //Obtenemos la data del grafico de las causas de desviación

        //Carga de las Causas
        $results = $this->get('pequiven.repository.sig_causes_report_evolution')->findBy(array('arrangementProgram' => $id,'month' => $month, 'typeObject' => 2));
        
        //Carga el analisis de la tendencia
        $trend = $this->get('pequiven.repository.sig_trend_report_evolution')->findBy(array('arrangementProgram' => $id, 'month' => $month, 'typeObject' => 2));
       
        //Carga el analisis de Causas
        $causeAnalysis = $this->get('pequiven.repository.sig_causes_analysis')->findBy(array('arrangementProgram'=> $id, 'month' => $month, 'typeObject'=> 2));
        
        $analysis = $sumCause = 0;

        $dataAction = [
            'action' => $data["action"],
            'values' => $data["actionValue"] 
        ];

        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('evolution.html'))
            ->setData(array(
                'ArrangementProgram'  => $ArrangementProgram,
                'data'                => $dataChart,
                'dataCause'           => $dataCause,
                'trend'               => $trend,
                'month'               => $month,
                'analysis'            => $causeAnalysis,
                'cause'               => $results,
                'sumCause'            => $sumCause,                
                'dataAction'          => $dataAction,                
                'verification'        => $data['verification'],
                'typeObject'          => 2   
            ));

        return $this->handleView($view);
    }

    /**
     * Buscamos las acciones de las causas
     * @param Request $request
     * @return \Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionCauses
     * @throws type
     */
    private function findEvolutionCause(Request $request)
    {
        $id = $request->get('id'); 
        //Mes Actual
        $monthActual = date("m");
        //Mes Consultado       
        $month = $request->get('month'); 
        //Carga de variable base
        $opc = false; $idAction = $actionResult = 0; $idCons = [0];
        //$results = $this->get('pequiven.repository.sig_causes_report_evolution')->findBy(array('indicator' => $idIndicator,'month'=> $month));
        $results = $this->get('pequiven.repository.sig_causes_report_evolution')->findBy(array('arrangementProgram' => $id));
  
        //Determinando si esta en historico de informe o periodo actual
        if($month < $monthActual){
            $statusCons = 1;
        }else{
            $statusCons = 0;
        }
        
        $cause = array();
        if($results){

            foreach ($results as $value) {
                
                $idCause = $value->getId();
                
                $cause[] = $idCause;
            }

            $action = $this->get('pequiven.repository.sig_action_indicator')->findBy(array('evolutionCause' => $cause));
             
        }        
        
        if(!$results){
            $action = null;
        }

        //Carga de las acciones para sacar la verificaciones realizadas
        if($action){
         
            foreach ($action as $value) {
                //$idAction[] = $value->getId();
                $relation = $value->getRelactionValue();
                    //var_dump(count($relation));
                    foreach ($relation as $value) {
                            
                            $monthAction = $value->getMonth();
                            $monthGet = (int)$month;

                        if ($monthAction === $monthGet) {
                            //var_dump(count($value->getId()));
                            $idAction = $value->getActionValue()->getId();
                            $idCons[] = $idAction;
                            //var_dump($value->getActionValue()->getId());
                            //$actionResult = $this->get('pequiven.repository.sig_action_indicator')->findBy(array('id' => $idAction));
                        //$verification[] = $this->get('pequiven.repository.sig_action_verification')->findByactionPlan($idAction);
                            
                        }            
                    }
            }
            $actionResult = $this->get('pequiven.repository.sig_action_indicator')->findBy(array('id' => $idCons));
        }  

//        $actionsValues = EvolutionActionValue::getActionValues($idCons, $month);          
        $actionsValues = $this->get('pequiven.repository.sig_action_value_indicator')->findBy(array('actionValue' => $idCons, 'month' => $month));    
        $cant = count($actionResult);

        if($opc = false){
            $idAction = null;
        } 
        $verification = $this->get('pequiven.repository.sig_action_verification')->findBy(array('arrangementProgram' => $id, 'month' => $month));                
        
        //Carga de array con la data
        $data = [

            'action'        => $actionResult, //Pasando la data de las acciones si las hay
            'verification'  => $verification, //Pasando la data de las verificaciones
            //'results'     => $results //Pasando la data de las causas si las hay
            'actionValue'   => $actionsValues,
            'cant'          => $cant

        ];

        return $data;
    } 

    /**
     * 
     * @return \Pequiven\SEIPBundle\Service\SecurityService
     */
    protected function getSecurityService() {

        return $this->container->get('seip.service.security');
    }  

    /**
     * @return \Pequiven\SEIPBundle\Service\FusionChartExportService
     */
    private function getFusionChartExportService()
    {
        return $this->container->get('pequiven_seip.service.fusion_chart');
    } 

    /**
     * 
     * @return \Pequiven\IndicatorBundle\Service\ArrangementProgramService
     */
    protected function getArrangementProgramService() {
        return $this->container->get('pequiven.service.arrangementprogram');
    } 

    /**
     *  Period
     *
     */
    protected function getPeriodService() {
        return $this->container->get('pequiven_seip.service.period');
    }
}