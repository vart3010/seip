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
     *  $type = Tipo de Consulta 1:General, 2:Pqv, 3:1x10
     */
    public function generalAction(Request $request){

        $type = 1;

        $linkValue = 1;//Validacion de muestra de link para bajar nivel
        //Carga de data
        $response = new JsonResponse();
        
        $CenterService = $this->getCenterService();

        $dataChart = $CenterService->getDataChartOfVotoGeneral($type); //General
        
        $dataChartLine = $CenterService->getDataChartOfVotoGeneralLine($type); //Linea de Tiempo

        $contCons = 0;

        $dataChartEstadoC = $CenterService->getDataChartOfVotoGeneralEstado("EDO. CARABOBO",$linkValue, $type); //General                    
        $dataChartEstadoZ = $CenterService->getDataChartOfVotoGeneralEstado("EDO. ZULIA",$linkValue, $type); //General            
        $dataChartEstadoA = $CenterService->getDataChartOfVotoGeneralEstado("EDO. ANZOATEGUI",$linkValue, $type); //General            
        $dataChartEstadoO = $CenterService->getDataChartOfVotoGeneralEstado("OTROS",$linkValue, $type); //General            

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
        
        $type = $request->get('type');

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
        $linkValue = 1;//Validacion de muestra de link para bajar nivel
        $cont = $suma = 0;

        $mcpo = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->findByMunicipios($estado);            

        foreach ($mcpo as $key => $value) {
            $municipio = $mcpo[$cont]["descriptionMunicipio"];
            $dataChartMcpo[1][] = $CenterService->getDataChartOfVotoGeneralMunicipio($estado,$linkValue,$municipio, $type); //General            
            $cont++; 
        } 
        $cantMcpo = count($dataChartMcpo[1]);
        
        //Carga de data
        $response = new JsonResponse();        

        $dataChart = $CenterService->getDataChartOfVotoGeneralEstado($estado,$linkValue, $type); //General
        
        return $this->render('PequivenSEIPBundle:Sip:Center/Display/voto_general_edo.html.twig',array(
                'data'          => $dataChart,
                'dataChartMcpo' => $dataChartMcpo,
                'cantMcpo'      => $cantMcpo
            ));
        
    }

    /**
     *
     * Voto General por Municipio
     *
     */
    public function generalMcpoAction(){
        return $this->render('PequivenSEIPBundle:Sip:Center/Display/voto_general_mcpo.html.twig');
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
        
        $linkValue = 1;
        
        $type = 2;

        $dataChart = $CenterService->getDataChartOfVotoGeneral($type); //Paso de data  


        $dataChartLine = $CenterService->getDataChartOfVotoGeneralLine($type); //Linea de Tiempo

        $contCons = 0;

        $dataChartEstadoC = $CenterService->getDataChartOfVotoGeneralEstado("EDO. CARABOBO",$linkValue, $type); //General                    
        $dataChartEstadoZ = $CenterService->getDataChartOfVotoGeneralEstado("EDO. ZULIA",$linkValue, $type); //General            
        $dataChartEstadoA = $CenterService->getDataChartOfVotoGeneralEstado("EDO. ANZOATEGUI",$linkValue, $type); //General            
        $dataChartEstadoO = $CenterService->getDataChartOfVotoGeneralEstado("OTROS",$linkValue, $type); //General            

        return $this->render('PequivenSEIPBundle:Sip:Center/Display/voto_pqv.html.twig', array(
                'data'      => $dataChart,
                'dataHours' => $dataChartLine,
                'dataEstadoC'=> $dataChartEstadoC,
                'dataEstadoZ'=> $dataChartEstadoZ,
                'dataEstadoA'=> $dataChartEstadoA,
                'dataEstadoO'=> $dataChartEstadoO
            )); 
        
	}

    protected function getCenterService() {
        return $this->container->get('seip.service.center');
    }
}