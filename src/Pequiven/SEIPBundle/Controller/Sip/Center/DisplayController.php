<?php

namespace Pequiven\SEIPBundle\Controller\Sip\Center;

use Pequiven\SEIPBundle\Controller\SEIPController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


/**
 * Controlador Display
 * @author Maximo Sojo <maxsojo13@gmail.com>
 *
 */
class DisplayController extends SEIPController {

    /**
     *
     *  Voto General
     *
     */
    public function generalAction(Request $request){

        $linkValue = 1;//Validacion de muestra de link para bajar nivel
        //Carga de data
        $response = new JsonResponse();
        
        $CenterService = $this->getCenterService();

        $dataChart = $CenterService->getDataChartOfVotoGeneral(); //General
        
        $dataChartLine = $CenterService->getDataChartOfVotoGeneralLine(); //Linea de Tiempo

        $contCons = 0;

        $dataChartEstadoC = $CenterService->getDataChartOfVotoGeneralEstado("EDO. CARABOBO",$linkValue); //General                    
        $dataChartEstadoZ = $CenterService->getDataChartOfVotoGeneralEstado("EDO. ZULIA",$linkValue); //General            
        $dataChartEstadoA = $CenterService->getDataChartOfVotoGeneralEstado("EDO. ANZOATEGUI",$linkValue); //General            
        $dataChartEstadoO = $CenterService->getDataChartOfVotoGeneralEstado("OTROS",$linkValue); //General            

        return $this->render('PequivenSEIPBundle:Sip:Center/Display/voto_general.html.twig', array(
                'data'      => $dataChart,
                'dataHours' => $dataChartLine,
                'dataEstadoC'=> $dataChartEstadoC,
                'dataEstadoZ'=> $dataChartEstadoZ,
                'dataEstadoA'=> $dataChartEstadoA,
                'dataEstadoO'=> $dataChartEstadoO
            ));
        
    }

    /**
     *
     *  General por estado
     *
     */
    public function generalEdoAction(Request $request){
        
        $em = $this->getDoctrine()->getManager();
        
        $CenterService = $this->getCenterService();//Llamado al Servicio de Centro

        $estado = $request->get('edo');

        if ($estado == 1) {
            $estado = "EDO. CARABOBO";
        }elseif($estado == 2){
            $estado = "EDO. ZULIA";
        }elseif($estado == 3){
            $estado = "EDO. ANZOATEGUI";
        }elseif($estado == 4){
            $estado = "OTROS";
        }
        $linkValue = 0;//Validacion de muestra de link para bajar nivel
        $cont = $suma = 0;

        $mcpo = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->findByMunicipios($estado);            

        foreach ($mcpo as $key => $value) {
            $municipio = $mcpo[$cont]["descriptionMunicipio"];
            $dataChartMcpo[] = $CenterService->getDataChartOfVotoGeneralMunicipio($estado,$linkValue,$municipio); //General            
            $cont++; 
        }         
        
        //Carga de data
        $response = new JsonResponse();        

        $contCons = 0;

        $dataChart = $CenterService->getDataChartOfVotoGeneralEstado($estado,$linkValue); //General
        
        
        //$dataChartMunicipio = $CenterService->getDataChartOfVotoGeneralMunicipio($estado,$linkValue); //General
        
        return $this->render('PequivenSEIPBundle:Sip:Center/Display/voto_general_edo.html.twig',array(
                'data'          => $dataChart,
                'dataChartMcpo' => $dataChartMcpo
            ));
        
    }

	/**
	 *
	 *	Voto Pequiven
	 *
	 */
	public function votoAction(Request $request){

        //Carga de data
        $response = new JsonResponse();
        
        $CenterService = $this->getCenterService();

        $dataChart = $CenterService->getDataChartOfVotoPqv(); //Paso de data        

        return $this->render('PequivenSEIPBundle:Sip:Center/Display/voto_pqv.html.twig', array(
                'data' => $dataChart
            ));
        
	}

    protected function getCenterService() {
        return $this->container->get('seip.service.center');
    }
}