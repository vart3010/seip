<?php

namespace Pequiven\SEIPBundle\Controller\Sip\Center;

use Pequiven\SEIPBundle\Controller\SEIPController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


/**
 * Controlador de UBCH
 * @author Maximo Sojo <maxsojo13@gmail.com>
 *
 */
class UbchController extends SEIPController {

	/**
	 *
	 *	Añadiendo miembro UBCH
	 *
	 */
	public function addMemberAction(){

		return $this->render('PequivenSEIPBundle:Sip:Center/Ubch/addMembers.html.twig');
	}

	/**
	 *
	 *	Consulta de Miembro UBCH
	 *
	 */
	public function searchAction(Request $request){

		$response = new JsonResponse();
        $em = $this->getDoctrine()->getEntityManager();
        $cedula = $request->get('ced');
        $datos = array("nombre" => "", "centro" => "", "nameCentro" => "", "msj" => "");

        var_dump($cedula);
        die();
        $user = $em->getRepository("\Pequiven\SEIPBundle\Entity\User")->findOneBy(array("identification" => $cedula));
        $onePerTen = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\OnePerTen")->findOneBy(array("user" => $request->get("idUserOne")));


        $onePerTenMembers = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\OnePerTenMembers")->findBy(
                array(
                    "cedula" => $cedula,
                    "one" => $onePerTen->getId()
                )
        );
        if (count($onePerTenMembers) <= 0) {
            if (!isset($user) || $user->getWorkStudyCircle() == "null") {
                if ($cedula != "" || $cedula != 0) {
                    /**
                     * VALIDACION CON NOMINA PQV
                     */
                    $nomina = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Nomina")->findOneBy(array("cedula" => $cedula));
                    if (is_null($nomina)) {
                        //VALIDA CON REP CARABOBO 
                        $rep = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Rep")->findOneBy(array("cedula" => $cedula));
                        if (is_null($rep)) {
                            //VALIDACION CON CNE
                            $cne = $this->getCneService();
                            $userCne = $cne->getDatosCne($cedula);

                            $datos["nombre"] = $userCne["nombre"];
                            $datos["cedula"] = $userCne["cedula"];
                            $datos["centro"] = "";
                            $datos["nameCentro"] = $userCne["centro"];
                        } else {
                            $nameCentro = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->getCentro($rep->getCodigoCentro());
                            $datos["nombre"] = $rep->getNombre();
                            $datos["cedula"] = $rep->getCedula();
                            $datos["centro"] = $rep->getCodigoCentro();
                            $datos["nameCentro"] = $nameCentro[0]["description"];
                        }
                    } else {
                        $nameCentro = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->getCentro($nomina->getCodigoCentro());
                        $datos["nombre"] = $nomina->getEmpleado();
                        $datos["cedula"] = $rep->getCedula();
                        $datos["centro"] = $nomina->getCodigoCentro();
                        $datos["nameCentro"] = $nameCentro[0]["description"];
                    }
                }
            } else {
                $datos["msj"] = "El usuario es Nómina Pequiven";
            }
        } else {
            $datos["msj"] = "El usuario ya esta agregado a tu 1x10";
        }

        $response->setData($datos);
        return $response;
	}
	/**
	 *
	 *	Guardando el Miembro de la Ubch
	 *
	 */ 
	public function saveAction(Request $request){
		die("Recibido");
		$user = $this->getUser();

        $em = $this->getDoctrine()->getManager();

        //DATOS TEN
        $cedula = $request->get("cedula");
        $codCentro = $request->get("codCentro");
        $nombreCentro = $request->get("nombreCentro");
        $nombre = $request->get("nombre");
        $telefono = $request->get("telefono");

        
        $em->getConnection()->beginTransaction();


        try {
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            throw $e;
        }
        $this->get('session')->getFlashBag()->add('success', 'Miembro Agregado Exitosamente.');
        die();
        //return $this->redirect($this->generateUrl('pequiven_search_members', array("user" => $idUserOne)));
	}
}