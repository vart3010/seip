<?php

namespace Pequiven\SEIPBundle\Controller\Sip\Center;

use Pequiven\SEIPBundle\Controller\SEIPController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


/**
 * Controlador Registro de Votos
 * @author Maximo Sojo <maxsojo13@gmail.com>
 *
 */
class CenterReportController extends SEIPController {

	/**
	 *
	 *	Añadiendo voto
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
	 *	Consulta 
	 *
	 */
	public function searchAction(Request $request){

		$response = new JsonResponse();
        $em = $this->getDoctrine()->getEntityManager();
        $cedula = $request->get('ced');
        $datos = array("nombre" => "", "centro" => "", "nameCentro" => "", "msj" => "");

        $onePerTen = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\OnePerTen")->findOneBy(array('cedula' => $cedula));
        //var_dump($cedula);
        var_dump(count($onePerTen));
        die();
        if (count($onePerTen) <= 0) {
                if ($cedula != "" || $cedula != 0) {
                        //VALIDA CON ONE_PER_TEN_MEMBER
                        $OnePerTenMembers = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\OnePerTenMembers")->findOneBy(array("cedula" => $cedula));

                        if (is_null($OnePerTenMembers)) {
                            //VALIDACION CON CNE
                            $datos["msj"] = "La persona no esta registrada.";
                            /*$cne = $this->getCneService();
                            $userCne = $cne->getDatosCne($cedula);

                            $datos["nombre"] = $userCne["nombre"];
                            $datos["cedula"] = $userCne["cedula"];
                            $datos["centro"] = "";
                            $datos["nameCentro"] = $userCne["centro"];*/
                        } else {
                            $nameCentro = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\OnePerTenMembers")->findOneBy(array("cedula" => $cedula));
                            $datos["nombre"] = $rep->getNombre();
                            $datos["cedula"] = $rep->getCedula();
                            $datos["centro"] = $rep->getCodigoCentro();
                            $datos["nameCentro"] = $nameCentro[0]["description"];
                        }                    
                }            
        } else {
        $onePerTen = $this->get('pequiven.repository.onePerTen')->findOneBy(
            array('cedula' => $cedula));

            $datos["nombre"] = $rep->getNombre();
            $datos["cedula"] = $rep->getCedula();
            $datos["centro"] = $rep->getCodigoCentro();
            $datos["nameCentro"] = $nameCentro[0]["description"];
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
        
        return $this->redirect($this->generateUrl('pequiven_ubch_show', array("id" => $id)));
	}

	/**
	 *
	 *	busqueda
	 *
	 */
	public function showAction(Request $request){
		
		return $this->render('PequivenSEIPBundle:Sip:Center/Voto/show.html.twig');
        
	}

    /**
     *
     * Exportar reporte ubch
     *
     */
    public function exportAction(Request $request) {

        $id = $request->get('id');
        
        $em = $this->getDoctrine()->getManager();

        $center = $this->get('pequiven.repository.center')->find($id);

        $codigoCentro = $center->getCodigoCentro();
        
        $ubch = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Ubch")->findBy(array("codigoCentro" => $codigoCentro));

        //Carga de status
        foreach (Ubch::getCargoUbch() as $key => $value) {
            $labelsCargo[] = array(
                'id' => $key,
                'description' => $this->trans($value, array(), 'PequivenArrangementProgramBundle'),
            );
        }

            //Carga de status
            foreach (Ubch::getCargoUbch() as $key => $value) {
                $labelsCargo[] = array(
                    'id' => $key,
                    'description' => $this->trans($value, array(), 'PequivenArrangementProgramBundle'),
                );
            }

        //Periodo
        $period = $this->getPeriodService()->getPeriodActive();
        
        $data = array(
            'center'    => $center,
            'ubch'      => $ubch, 
            'ubchCargo' => $labelsCargo,
            'period'    => $period
           
        );

        $this->generatePdf($data);
    }

    public function generatePdf($data) {
        $pdf = new \Pequiven\SEIPBundle\Model\Sip\PDF\UbchPdf('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->setPrintLineFooter(false);
        $pdf->setContainer($this->container);
        //$pdf->setPeriod($this->getPeriodService()->getPeriodActive());
        //$pdf->setFooterText($this->trans('pequiven_seip.message_footer', array(), 'PequivenSEIPBundle'));
    // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('SEIP');
        $pdf->setTitle('');
        $pdf->SetSubject('Resultados UBCH');
        $pdf->SetKeywords('PDF, UBCH, Resultados');

        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, 35, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // set font
    //  $pdf->SetFont('times', 'BI', 12);
    // add a page        
        $pdf->AddPage('L');

    // set some text to print 
        $html = $this->renderView('PequivenSEIPBundle:Sip:Center/Ubch/viewPdf.html.twig', $data);

    // print a block of text using Write()
        $pdf->writeHTML($html, true, false, true, false, '');

    //            $pdf->Output('Reporte del dia'.'.pdf', 'I');
        $pdf->Output('Reporte Ubch' . '.pdf', 'D');
    }

	/**
	 *	Api CNE
	 *
	 */
	protected function getCneService() {
        return $this->container->get('seip.service.apiCne');
    }
}