<?php

namespace Pequiven\SEIPBundle\Controller\Sip\Center;

use Pequiven\SEIPBundle\Controller\SEIPController;
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

        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();

        $cod = $this->get('pequiven.repository.siplist')->getCodes($request->get("edo"), $request->get("mcpo"), $request->get("parroq"));

        if ((($request->get("type2")) != ($request->get("type"))) && ($request->get("type2") != null)) {
            $bandera = $request->get("type2");
            $codigos[3] = $request->get("type2");
        } else {
            $bandera = $request->get("type");
            $codigos[3] = $request->get("type");
        }

        if ($bandera == 1) {
            $tipo = "General";
        }

        if ($bandera == 2) {
            $tipo = "PQV";
        }

        if ($bandera == 3) {
            $tipo = "1x10";
        }

        if ($bandera == 4) {
            $tipo = "Circuito 5";
        }

//       var_dump('TypeA' . $request->get("type") . ' typeB' . $request->get("type2"));
//        //    var_dump($tipo);
//       die();

        foreach ($cod as $nom) {
            $nombres[0] = $nom["descriptionEstado"];
            $nombres[1] = $nom["descriptionMunicipio"];
            $nombres[2] = $nom["descriptionParroquia"];
            $nombres[3] = $tipo;
        }

        $codigos[0] = $request->get("edo");
        $codigos[1] = $request->get("mcpo");
        $codigos[2] = $request->get("parroq");
        $codigos[3] = $request->get("type");
        $codigos[4] = $request->get("codigoCentro");


        $data = $this->get('pequiven.repository.siplist')->getGeneralVote($nombres[0], $nombres[1], $nombres[2], $tipo, $codigos[4]);

        return $this->render('PequivenSEIPBundle:Sip:Center/List/ListGeneralVote.html.twig', array(
                    'user' => $this->getUser(),
                    'data' => $data,
                    'nombres' => $nombres,
                    'codigos' => $codigos
        ));
    }

    protected function getCenterService() {
        return $this->container->get('seip.service.center');
    }

}
