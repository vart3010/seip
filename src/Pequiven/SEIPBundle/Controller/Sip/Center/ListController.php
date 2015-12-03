<?php

namespace Pequiven\SEIPBundle\Controller\Sip\Center;

use Pequiven\SEIPBundle\Controller\SEIPController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controlador Display
 * @author Gilbert C. <glavrjk@gmail.com>
 *
 */
class ListController extends SEIPController {

    /**
     *
     * 	Voto Pequiven
     *
     */
    public function ListGeneralVoteAction(Request $request) {

        $criteria = $request->get('filter', $this->config->getCriteria());
        $sorting = $request->get('sorting', $this->config->getSorting());

        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();

        $repository = $this->get('pequiven.repository.siplist');
    }

    public function ShowListAction($data) {

        return $this->render('PequivenSEIPBundle:Sip:ListGeneralVote.html.twig', array(
                    'user' => $this->getUser(),
                    'data' => $data
        ));
    }

//        //Carga de data
//        $response = new JsonResponse();
//        
//        $CenterService = $this->getCenterService();
//
//        $dataChart = $CenterService->getDataChartOfVotoPqv(); //Paso de data        
//
//        return $this->render('PequivenSEIPBundle:Sip:Center/Display/voto.html.twig', array(
//                'data' => $dataChart
//            ));

    protected function getCenterService() {
        return $this->container->get('seip.service.center');
    }

}
