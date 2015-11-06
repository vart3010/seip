<?php

namespace Pequiven\SEIPBundle\Controller\Sip;

use Pequiven\SEIPBundle\Controller\SEIPController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controlador de gráficos en el SEIP
 *
 */
class OnePerTenController extends SEIPController {

    public function createAction(Request $request) {
        return $this->render('PequivenSEIPBundle:Sip:onePerTen\create.html.twig', array());
    }

    public function searchAction(Request $request) {
        $response = new JsonResponse();
        $cedula = $request->request->get('ced');
        var_dump($cedula);


        die();
        $response->setData($request);
        return $response;
    }

}
