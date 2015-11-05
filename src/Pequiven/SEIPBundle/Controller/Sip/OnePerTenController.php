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

}
