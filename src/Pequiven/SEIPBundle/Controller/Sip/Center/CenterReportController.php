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

        $onePerTen = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\OnePerTen")->findOneBy(array('cedula' => $cedula));
        
        if (count($onePerTen) <= 0) {
                if ($cedula != "" || $cedula != 0) {
                        //VALIDA CON ONE_PER_TEN_MEMBER
                        $OnePerTenMembers = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\OnePerTenMembers")->findBy(array("cedula" => $cedula));

                        if (is_null($OnePerTenMembers)) {
                            //VALIDACION CON CNE
                            $datos["msj"] = "La persona no esta registrada.";
                            
                        } else {
//                            $members = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\OnePerTenMembers")->findBy(array("cedula" => $cedula));
                            $members = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\OnePerTenMembers")->getOnePerTenVotoPeople($cedula);
                            foreach($members as $member){
                                $datos["nombre"] = $member->getNombre();
                                $datos["cedula"] = $member->getCedula();
                                $datos["telefono"] = $member->getTelefono();
                                $datos["nameCentro"] = $member->getNombreCentro();
                            }
                        }                    
                }            
        } else {

        $onePerTen = $this->get('pequiven.repository.onePerTen')->findOneBy(array('cedula' => $cedula));                                                        
            $datos["nombre"] = $onePerTen->getUser()->getOnlyFullNameUser();
            $datos["cedula"] = $onePerTen->getUser()->getIndentification();
            $datos["telefono"] = $onePerTen->getUser()->getCellphone();
            $datos["id"] = $onePerTen->getUser()->getId();                            
        }

        $response->setData($datos);
        return $response;
	}

	/**
	 *
	 *	Guardando 
	 *
	 */ 
	public function saveAction(Request $request){
        
        $em = $this->getDoctrine()->getManager();
        
        $id = $request->get("id");
        $cedula = $request->get("cedula");

        $fecha = date("Y-m-d");
        $fecha = date_create_from_format("Y-m-d", $fecha);
        
        $em->getConnection()->beginTransaction();        
        
        $onePerTenResult = new OnePerTen();

        $onePerTenResult = $this->get('pequiven.repository.onePerTen')->findOneBy(array('cedula' => $cedula));
        
        $nominaCentro = $this->get('pequiven.repository.nominaCentro')->findOneBy(array('cedula' => $cedula));
        
        if (count($onePerTenResult) != 0) {
            $voto = 1;
            $onePerTenResult->setVoto($voto);
            $onePerTenResult->setFechaVoto($fecha);
            $nominaCentro->setVoto($voto);

            $em->persist($onePerTenResult);
            $em->persist($nominaCentro);
            $em->flush();
            
        }else{

//            $OnePerTenMembers = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\OnePerTenMembers")->findBy(array("cedula" => $cedula));
            $OnePerTenMembers = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\OnePerTenMembers")->getOnePerTenVotoPeople($cedula);

            if (count($OnePerTenMembers) != 0) {
                $voto = 1;
                foreach($OnePerTenMembers as $onePerTenMember){
                    $onePerTenMember->setVoto($voto);
                    $onePerTenMember->setFechaVoto($fecha);
                    $em->persist($onePerTenMember);
                }
//                $OnePerTenMembers->setVoto($voto);                
//                $OnePerTenMembers->setFechaVoto($fecha);                
            }else{
                $voto = 0;
            }
            $em->flush();
        }
        

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