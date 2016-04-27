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
        
        $linkValue = 10;
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
        
        $dataChartLine = $CenterService->getDataChartOfVotoGeneralLineEstado($type,$estado); //Linea de Tiempo

        $response = new JsonResponse();         

        $linkValue = 1;//Validacion de muestra de link para bajar nivel
        $dataChartMcpo = $CenterService->getDataChartOfVotoMcpo($estado, $type, $linkValue); //General

        //Carga de data
        $linkValue = 2;
        $dataChart = $CenterService->getDataChartOfVotoGeneralEstado($estado,$linkValue, $type); //General
        
        return $this->render('PequivenSEIPBundle:Sip:Center/Display/voto_general_edo.html.twig',array(
                'data'          => $dataChart,
                'dataChartMcpo' => $dataChartMcpo,
                'dataHours' => $dataChartLine,                
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
        
        $dataChartLine = $CenterService->getDataChartOfVotoGeneralLineMcpo($type,$estado,$mcpo); //Linea de Tiempo

        $linkValue = 1;
        $dataChartParroquias = $CenterService->getDataChartOfVotoParroquiaData($estado, $mcpo, $linkValue, $type); //General
        
        $linkValue = 0;
        $dataChart = $CenterService->getDataChartOfVotoGeneralParroquia($estado, $mcpo, $linkValue, $type); //General
        
        return $this->render('PequivenSEIPBundle:Sip:Center/Display/voto_general_mcpo.html.twig', array(
            'data'              => $dataChart,
            'dataChartParroq'   => $dataChartParroquias,
            'dataHours'    => $dataChartLine
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
        $CenterService = $this->getCenterService();//Llamado al Servicio de Centro
        
        $type = 3;
        $dataChartLine = $CenterService->getDataChartOfVotoGeneralLine($type);

        $estado = "EDO. CARABOBO";
        $dataChartCircuto = $CenterService->getDataChartOfCircuito5($estado); //General
        $dataChartCircuto1x10 = $CenterService->getDataChartOfCircuito51x10($estado); //General        
        $dataChartCircutoBarra = $CenterService->getDataChartOfCircuitoBarra($estado); //General        
        $dataChartPoll = $CenterService->getDataChartOfCircuitoBarraPoll(); //General        

        return  $this->render('PequivenSEIPBundle:Sip:Center/Display/voto_circuito.html.twig',array(
            'dataChartCircuto'      => $dataChartCircuto,
            'dataChartCircuto1x10'  => $dataChartCircuto1x10,
            'dataChartCircutoBarra' => $dataChartCircutoBarra,
            'dataHours'             => $dataChartLine,
            'dataChartPoll'         => $dataChartPoll
            ));
    }

    public function cetAction(){
        return  $this->render('PequivenSEIPBundle:Sip:Center/Display/voto_cet.html.twig');
    }

    public function onePerTenAction(){
        $CenterService = $this->getCenterService();//Llamado al Servicio de Centro

        $type = 4;
        $dataChartLine = $CenterService->getDataChartOfVotoGeneralLine($type);
        
        $dataChart1x10 = $CenterService->getDataChartOf1x10(); //General        
        $dataChartBarra = $CenterService->getDataChartOfBarra1x10(); //General        

        return  $this->render('PequivenSEIPBundle:Sip:Center/Display/voto_1x10.html.twig',array(
            'dataChart1x10' => $dataChart1x10,
            'dataChartBarra' => $dataChartBarra,
            'dataHours'             => $dataChartLine
            ));        
    }

    public function localidadAction(Request $request){
        $CenterService = $this->getCenterService();//Llamado al Servicio de Centro
        
        $estado = $request->get('edo'); 
        if ($estado == 7) {
            $localidad = "Sede Corporativa";            

            $localidad = "Complejo Petroquímico Hugo Chávez";
            $dataChartLocalidadMoron = $CenterService->getDataChartOfLocalidad($localidad); //General
            $dataChartLocalidadMoronBar = $CenterService->getDataChartOfLocalidadBar($localidad); //General
        }elseif ($estado == 2) {
            $localidad = "Complejo Petroquímico GD José Antonio Anzoátegui";
            $dataChartLocalidadMoron = "";
            $dataChartLocalidadMoronBar = "";
        }else{
            $localidad = "Complejo Petroquímico Ana Maria Campos";
            $dataChartLocalidadMoron = "";
            $dataChartLocalidadMoronBar = "";
        }
        
        $dataChartLocalidadSede = $CenterService->getDataChartOfLocalidad($localidad); //General
        $dataChartLocalidadSedeBar = $CenterService->getDataChartOfLocalidadBar($localidad); //General


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