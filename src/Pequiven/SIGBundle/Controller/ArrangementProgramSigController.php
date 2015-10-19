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
                'typeObject'          => 2   
            ));

        return $this->handleView($view);
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