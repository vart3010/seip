<?php

namespace Pequiven\SEIPBundle\Controller\Sip\Center;

use Pequiven\SEIPBundle\Controller\SEIPController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Pequiven\SEIPBundle\Entity\Sip\OnePerTen;
use Pequiven\SEIPBundle\Entity\Sip\OnePerTenMembers;


/**
 * Controlador Registro de Votos
 * @author Maximo Sojo <maxsojo13@gmail.com>
 *
 */
class CenterReportController extends SEIPController {

	/**
	 *
	 *	Consulta 
	 *
	 */
	public function searchAction(Request $request){

		$response = new JsonResponse();
        $em = $this->getDoctrine()->getEntityManager();
        $cedula = $request->get('ced');
        $datos = array("nombre" => "", "centro" => "", "nameCentro" => "", "msj" => "");

        $onePerTen = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\OnePerTen")->getOnePerTenVoto($cedula);
        
        if (count($onePerTen) <= 0) {
                if ($cedula != "" || $cedula != 0) {
                        //VALIDA CON ONE_PER_TEN_MEMBER
                        $OnePerTenMembers = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\OnePerTenMembers")->findOneBy(array("cedula" => $cedula));

                        if (is_null($OnePerTenMembers)) {
                            //VALIDACION CON CNE
                            $datos["msj"] = "La persona no esta registrada.";
                            
                        } else {
                            $members = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\OnePerTenMembers")->findOneBy(array("cedula" => $cedula));

                            $datos["nombre"] = $members->getNombre();
                            $datos["cedula"] = $members->getCedula();
                            $datos["telefono"] = $members->getTelefono();
                            //$datos["centro"] = $members->getCodigoCentro();
                            //$datos["nameCentro"] = $nameCentro[0]["description"];
                        }                    
                }            
        } else {

        $onePerTen = $this->get('pequiven.repository.onePerTen')->getOnePerTenVoto($cedula);
            foreach ($onePerTen as $value) {                                             
                $datos["nombre"] = $value->getUser()->getOnlyFullNameUser();
                $datos["cedula"] = $value->getUser()->getIndentification();
                $datos["telefono"] = $value->getUser()->getCellphone();
                $datos["id"] = $value->getUser()->getId();
            }        
            
            //$datos["centro"] = $result->getCodigoCentro();
            //$datos["nameCentro"] = $nameCentro[0]["description"];
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
        
        $em = $this->getDoctrine()->getManager();
        
        $id = $request->get("id");
        $cedula = $request->get("cedula");
        
        $em->getConnection()->beginTransaction();        
        
        $onePerTenResult = new OnePerTen();

        $onePerTenResult = $this->get('pequiven.repository.onePerTen')->getOnePerTenVoto($cedula);
        
        if (count($onePerTenResult) != 0) {
            $voto = 1;
            $onePerTenResult[0]->setVoto($voto);            
            $em->persist($onePerTenResult[0]);
            $em->flush();
            
        }else{

            $OnePerTenMembers = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\OnePerTenMembers")->findOneBy(array("cedula" => $cedula));

            if (count($OnePerTenMembers) != 0) {
                $voto = 1;
                $OnePerTenMembers->setVoto($voto);                
            }else{
                $voto = 0;
                var_dump("hola");
            }
        }
        
        $em->flush();

        try {   
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            throw $e;
        }
        //$center = $this->get('pequiven.repository.center')->find($id);            
        
        $this->get('session')->getFlashBag()->add('success', 'Voto Registrado Exitosamente.');
        
        return $this->redirect($this->generateUrl('pequiven_sip_report_voto'));
	}

	/**
	 *
	 *	busqueda
	 *
	 */
	public function showAction(Request $request){
		
		return $this->render('PequivenSEIPBundle:Sip:Center/Voto/show.html.twig');
        
	}
}