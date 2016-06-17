<?php

namespace Pequiven\SIGBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram;


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
        $typeObject = 2;

        $em = $this->getDoctrine()->getManager();
        $ArrangementProgram = $em->getRepository('PequivenArrangementProgramBundle:ArrangementProgram')->findWithData($id);

        $evolutionService = $this->getEvolutionService(); //Obtenemos el servicio de las causas            
        $data = $evolutionService->findEvolutionCause($ArrangementProgram, $request, $typeObject); //Carga la data de las causas y sus acciones relacionadas
        
        //Validación de que el mes pasado este entre los validos
        if ($month > 12) {
            $this->get('session')->getFlashBag()->add('error', "El mes consultado no es un mes valido!");
            $month = 12;            
        }elseif ($month < 1) {
            $this->get('session')->getFlashBag()->add('error', "El mes consultado no es un mes valido!");
            $month = 01;            
        }

        //Cargando el Archivo
        $uploadFile = $request->get("uploadFile");//Recibiendo archivo

        $urlExportFromChart = $this->generateUrl('pequiven_indicator_evolution_export_chart', array('id' => $request->get("id"), 'month' => $month, 'typeObj' => 2));

        //Creaciń de Grafico para informe de Evolución
        $response = new JsonResponse();

        $ArrangementProgramService = $this->getArrangementProgramService(); //Obtenemos el servicio del indicador
        
        $dataChart = $ArrangementProgramService->getDataChartOfArrangementProgramEvolution($ArrangementProgram, $urlExportFromChart, $month); //Obtenemos la data del gráfico de acuerdo al programa

        $dataCause = $evolutionService->getDataChartOfCausesEvolution($ArrangementProgram, $urlExportFromChart, $month, $typeObject); //Obtenemos la data del grafico de las causas de desviación
        
        $analysis = $sumCause = 0;

        //Carga de las Causas
        $results = $this->get('pequiven.repository.sig_causes_report_evolution')->findBy(array('idObject' => $id,'month' => $month, 'typeObject' => $typeObject));
        
        foreach ($results as $value) {
            $dataCa = $value->getValueOfCauses();
            $sumCause = $sumCause + $dataCa;
        }

        //Carga el analisis de la tendencia
        $trend = $this->get('pequiven.repository.sig_trend_report_evolution')->findBy(array('idObject' => $id, 'month' => $month, 'typeObject' => $typeObject));
       
        //Carga el analisis de Causas
        $causeAnalysis = $this->get('pequiven.repository.sig_causes_analysis')->findBy(array('idObject'=> $id, 'month' => $month, 'typeObject'=> $typeObject));
        

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
                'typeObject'          => $typeObject ,
                'id'                  => $id,
                'route'               => "pequiven_seip_arrangementprogram_evolution_sig"//Ruta para carga de Archivo
            ));

        return $this->handleView($view);
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
     * @return \Pequiven\SEIPBundle\Service\SecurityService
     */
    protected function getSecurityService() {

        return $this->container->get('seip.service.security');
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