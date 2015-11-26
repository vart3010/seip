<?php

namespace Pequiven\SEIPBundle\Controller\Sip\Center;

use Pequiven\SEIPBundle\Controller\SEIPController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Pequiven\SEIPBundle\Entity\Sip\Ubch;
use Pequiven\SEIPBundle\Form\Sip\Center\UbchType;
use Pequiven\SEIPBundle\Form\Sip\Center\UbchCargoType;


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

        $ubchJefe = $this->get('pequiven.repository.center')->findBy(array("cedulaubch" => $cedula));
        $ubchJefe = count($ubchJefe);
        
        $ubch = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Ubch")->findBy(
                array(
                    "cedula" => $cedula,                    
                )
        );
        if (count($ubch) <= 0) {
            if ($ubchJefe === 0) {
                if ($cedula != "" || $cedula != 0) {
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
                }
            } else {
                $datos["msj"] = "No puede añadir al Jefe de la UBCH como Patrullero";
            }
        } else {
            $datos["msj"] = "La persona ya esta registrada en una UBCH";
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
	 *	Ficha UBCH
	 *
	 */
	public function showAction(Request $request){
		
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

		return $this->render('PequivenSEIPBundle:Sip:Center/Ubch/show.html.twig',array(
			'center'	=> $center,
			'ubch'		=> $ubch,
            'ubchCargo' => $labelsCargo

			));
	}

    /**
     *
     *  Eliminación el Miembro de la UBCH
     *
     *
     */
    public function delUbchAction(Request $request) {

        $id = $request->get('id');

        $em = $this->getDoctrine()->getManager();

        $results = $this->get('pequiven.repository.ubch')->find($id);
        
        if ($results) {

            $em->remove($results);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Miembro Eliminada Exitosamente');
            return true;
        }
    }

    /**
     * 
     * @param Request $request
     */
    public function updateAssistance(Request $request) {
        
        $id = $request->get('idMember');       

        $status = $request->get('status');

        $em = $this->getDoctrine()->getEntityManager();
        
        $ubch = $this->get('pequiven.repository.ubch')->find($id);
        
        $ubch->setNotification($status);        

            $em->persist($ubch);
            $em->flush();

        return true;
    }

    /**
     *
     *
     *
     */
    public function formUbchAction(Request $request){

        $id = $request->get('id');

        $em = $this->getDoctrine()->getEntityManager();

        $Ubch = new Ubch();
        $form = $this->createForm(new UbchType(), $Ubch);
        
        if (isset($request->get('sip_ubch')['observations'])) {
            $id = $request->get('id');
            
            if (isset($request->get('sip_ubch')['notification'])) {
                $not = 1;
            } else {
                $not = 0;
            }
            $Obs = $request->get('sip_ubch')['observations'];
            $form->bind($this->getRequest());
            
            $Ubch = $this->get('pequiven.repository.ubch')->find($id);

            $Ubch->setNotification($not);
            $Ubch->setObservations($Obs);

            $em->flush();

            $this->get('session')->getFlashBag()->add('success', "Reporte Cargado Exitosamente");
        } else {
            $view = $this
                    ->view()
                    ->setTemplate('PequivenSEIPBundle:Sip:Center\Form\Ubch.html.twig')
                    ->setTemplateVar($this->config->getPluralResourceName())
                    ->setData(array(
                'form' => $form->createView(),
                    ))
            ;
            $view->getSerializationContext()->setGroups(array('id', 'api_list'));

            return $view;
        }
    }

    /**
     * 
     * @param Request $request
     * @return type
     */
    public function formCargoAction(Request $request) {

        $id = $request->get('id');

        $em = $this->getDoctrine()->getEntityManager();

        $cargo = new Ubch();

        $form = $this->createForm(new UbchCargoType(), $cargo);
        
        if (isset($request->get('sip_ubch_cargo')['cargo'])) {

            $form->bind($this->getRequest());
            $cargo = $request->get('sip_ubch_cargo')['cargo'];
            
            $ubch = $this->get('pequiven.repository.ubch')->find($id);

            $ubch->setCargo($cargo);

            $em->flush();

            $this->get('session')->getFlashBag()->add('success', "Cargo Actualizado Exitosamente");
        } else {
            $view = $this
                    ->view()
                    ->setTemplate('PequivenSEIPBundle:Sip:Center/Form/UbchCargo.html.twig')
                    ->setTemplateVar($this->config->getPluralResourceName())
                    ->setData(array(
                    'form' => $form->createView(),
                    ))
            ;
            $view->getSerializationContext()->setGroups(array('id', 'api_list'));

            return $view;
        }
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