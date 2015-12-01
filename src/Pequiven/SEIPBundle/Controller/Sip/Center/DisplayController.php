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

        //Carga de data
        $response = new JsonResponse();
        
        $CenterService = $this->getCenterService();

        $dataChart = $CenterService->getDataChartOfVotoGeneral(); //General
        
        $dataChartLine = $CenterService->getDataChartOfVotoGeneralLine(); //Linea de Tiempo

        return $this->render('PequivenSEIPBundle:Sip:Center/Display/voto_general.html.twig', array(
                'data' => $dataChart
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