<?php

namespace Pequiven\SEIPBundle\Controller\Sip\Center;

use Pequiven\SEIPBundle\Controller\SEIPController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Pequiven\SEIPBundle\Entity\Sip\Ubch;


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
	public function addMemberAction(Request $request){
	
		$idCentro = $request->get("idCentro");
		
		return $this->render('PequivenSEIPBundle:Sip:Center/Ubch/addMembers.html.twig', 
			array(
				'idCentro' => $idCentro
			));
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

        $user = $em->getRepository("\Pequiven\SEIPBundle\Entity\User")->findOneBy(array("identification" => $cedula));

        $ubch = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Ubch")->findBy(
                array(
                    "cedula" => $cedula,                    
                )
        );
        if (count($ubch) <= 0) {
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
            $datos["msj"] = "El usuario ya esta agregado a una UBCH";
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
		
		$id = $request->get("idCentro");
		
		$user = $this->getUser();

        $em = $this->getDoctrine()->getManager();
        
        $center = $this->get('pequiven.repository.center')->find($id);	        

        //Formateando las Cedulas
        if (strpos($request->get("cedula"), "-")) {                    
             $cedula = trim($request->get("cedula"), "V-");                            	 
        }else{
             $cedula = $request->get("cedula");
        }

        //DATOS DEL REGISTRO
        $cedula = $cedula;
        $codCentro = $center->getCodigoCentro();
        $nombreCentro = $request->get("nombreCentro");
        $nombre = $request->get("nombre");
        $telefono = $request->get("telefono");
        $cargo = 2;


        $em->getConnection()->beginTransaction();

        $ubch = new Ubch();
        
        $ubch->setCedula($cedula);
        $ubch->setNombre($nombre);
        $ubch->setCodigoCentro($codCentro);
        $ubch->setTelefono($telefono);
        $ubch->setCargo($cargo);
        $ubch->setCreatedBy($user);
        
        $em->persist($ubch);


        try {
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            throw $e;
        }
        $this->get('session')->getFlashBag()->add('success', 'Miembro Agregado Exitosamente.');
        
        return $this->redirect($this->generateUrl('pequiven_sip_center_show', array("id" => $id)));
	}
	/**
	 *	Api CNE
	 *
	 */
	protected function getCneService() {
        return $this->container->get('seip.service.apiCne');
    }
}