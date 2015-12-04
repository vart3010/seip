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

        if ($estado == 7) {
            $estado = "EDO. CARABOBO";
        }elseif($estado == 21){
            $estado = "EDO. ZULIA";
        }elseif($estado == 2){
            $estado = "EDO. ANZOATEGUI";
        }elseif($estado == 30){
            $estado = "OTROS";
        }
        $cont = $suma = 0;

        $response = new JsonResponse();        
        $linkValue = 1;//Validacion de muestra de link para bajar nivel
        $dataChartMcpo = $CenterService->getDataChartOfVotoMcpo($estado, $type, $linkValue); //General

        //Carga de data
        $linkValue = 2;
        $dataChart = $CenterService->getDataChartOfVotoGeneralEstado($estado,$linkValue, $type); //General
        
        return $this->render('PequivenSEIPBundle:Sip:Center/Display/voto_general_edo.html.twig',array(
                'data'          => $dataChart,
                'dataChartMcpo' => $dataChartMcpo,                
            ));
        
    }

    /**
     *
     * Voto General por Municipio
     *
     */
    public function generalMcpoAction(Request $request){
        $type = $request->get('type');
        $estado = $request->get('edo');
        $mcpo = $request->get('mcpo');

        $em = $this->getDoctrine()->getManager();
        $CenterService = $this->getCenterService();//Llamado al Servicio de Centro

        $linkValue = 1;
        $dataChartParroquias = $CenterService->getDataChartOfVotoParroquiaData($estado, $mcpo, $linkValue, $type); //General
        
        $linkValue = 0;
        $dataChart = $CenterService->getDataChartOfVotoGeneralParroquia($estado, $mcpo, $linkValue, $type); //General
        
        return $this->render('PequivenSEIPBundle:Sip:Center/Display/voto_general_mcpo.html.twig', array(
            'data'              => $dataChart,
            'dataChartParroq'   => $dataChartParroquias
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

    public function circuitoAction(){
        return  $this->render('PequivenSEIPBundle:Sip:Center/Display/voto_circuito.html.twig');
    }

    public function cetAction(){
        return  $this->render('PequivenSEIPBundle:Sip:Center/Display/voto_cet.html.twig');
    }

    public function localidadAction(){
        $CenterService = $this->getCenterService();//Llamado al Servicio de Centro
        
        $localidad = "Sede Corporativa";
        $dataChartLocalidadSede = $CenterService->getDataChartOfLocalidad($localidad); //General
        $dataChartLocalidadSedeBar = $CenterService->getDataChartOfLocalidadBar($localidad); //General

        $localidad = "Complejo Petroquímico Hugo Chávez";
        $dataChartLocalidadMoron = $CenterService->getDataChartOfLocalidad($localidad); //General
        $dataChartLocalidadMoronBar = $CenterService->getDataChartOfLocalidadBar($localidad); //General

        return  $this->render('PequivenSEIPBundle:Sip:Center/Display/voto_localidad.html.twig',array(
                'dataChartLocalidadSede'    => $dataChartLocalidadSede, 
                'dataChartLocalidadMoron'   => $dataChartLocalidadMoron,
                'dataChartSede'            => $dataChartLocalidadSedeBar,
                'dataChartMoron'            => $dataChartLocalidadMoronBar
                ));
    }

    protected function getCenterService() {
        return $this->container->get('seip.service.center');
    }
}