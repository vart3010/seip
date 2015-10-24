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
        //$resource = $this->findOr404($request);

        //$form = $this->getForm($resource);

    	$id = $request->get("id");//Id ArrangmentProgram
        
        $month = $request->get('month'); //El mes pasado por parametro

        $em = $this->getDoctrine()->getManager();

        $data = $this->findEvolutionCause($request);//Carga la data de las causas y sus acciones relacionadas
    	
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


        //SI SE SUBIO EL ARCHIVO SE PROCEDE A GUARDARLO
        /*if ($uploadFile != null) {

            $band = false;
            //VALIDACION QUE SEA UN ARCHIVO PERMITIDO
            foreach ($request->files as $file) {
                if (in_array($file->guessExtension(), \Pequiven\IndicatorBundle\Model\Indicator\ValueIndicatorFile::getTypesFile())) {
                    $band = true;
                }
            }
            if ($band) {
                $this->createValueCauseFile($resource, $request);
            } else {
                $this->get('session')->getFlashBag()->add('error', $this->trans('action.messages.InvalidFile', array(), 'PequivenIndicatorBundle'));
                $this->redirect($this->generateUrl("pequiven_seip_arrangementprogram_evolution_sig", array("id" => $request->get("id"),"month" => $month)));
            }
        }*/
        //fin de la carga

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
                'typeObject'          => 2 ,
                'id'                  => $id,
                'route'               => "pequiven_seip_arrangementprogram_evolution_sig"//Ruta para carga de Archivo
            ));

        return $this->handleView($view);
    }

    public function createValueCauseFile(ArrangementProgram $ArrangementProgram, Request $request) {

        $EvolutionCauseFile = new Indicator\EvolutionIndicator\EvolutionCauseFile();
        
        $fileUploaded = false;
        
        $month = date("m");//Carga del mes de Creación de la causa "Automatico"  
        
        $causeAnalysis = $request->get('cause');
        
        $causeData = $this->get('pequiven.repository.sig_causes_analysis')->find($causeAnalysis);
        
            if ($causeData->getId() == $causeAnalysis) {
        
                $EvolutionCauseFile->setValueCause($causeData);
                foreach ($request->files as $file) {
                    //VALIDA QUE EL ARCHIVO SEA UN PDF
                    //SE GUARDAN LOS CAMPOS EN BD
                    $EvolutionCauseFile->setCreatedBy($this->getUser());
                    $EvolutionCauseFile->setNameFile($file->getClientOriginalName());
                    $EvolutionCauseFile->setPath(Indicator\EvolutionIndicator\EvolutionCauseFile::getUploadDir());
                    $EvolutionCauseFile->setExtensionFile($file->guessExtension());

                    //SE MUEVE EL ARCHIVO AL SERVIDOR
                    $file->move($this->container->getParameter("kernel.root_dir") . '/../web/' . Indicator\EvolutionIndicator\EvolutionCauseFile::getUploadDir(), Indicator\ValueIndicator\ValueIndicatorFile::NAME_FILE . $causeData->getId());
                    $fileUploaded = $file->isValid();
                }
            }
        
        if (!$fileUploaded) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($EvolutionCauseFile);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', $this->trans('action.messages.saveFileSuccess', array(), 'PequivenIndicatorBundle'));
            $request->request->set("uploadFile", "");
            $this->redirect($this->generateUrl("pequiven_indicator_evolution", array("id" => $request->get("id"),"month" => $month)));
        } else {
            $this->get('session')->getFlashBag()->add('error', $this->trans('action.messages.errorFileUpload', array(), 'PequivenIndicatorBundle'));
            $request->request->set("uploadFile", "");
            $this->redirect($this->generateUrl("pequiven_indicator_evolution", array("id" => $request->get("id"),"month" => $month)));            
        }
    }

    /**
     *
     * Generate URL files
     * 
     */
    public function generateUrlFile(Request $request) {

        $response = new JsonResponse();
        $data = array();
        $data["url"] = $this->generateUrl("pequiven_indicator_vizualice_file", array("id" => $request->get("id")));
        $response->setData($data);
        return $response;
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
                
                $relation = $value->getRelactionValue();
                    
                    foreach ($relation as $value) {
                            
                            $monthAction = $value->getMonth();
                            $monthGet = (int)$month;

                        if ($monthAction === $monthGet) {
                            
                            $idAction = $value->getActionValue()->getId();
                            $idCons[] = $idAction;                                                        
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