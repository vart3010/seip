<?php

namespace Pequiven\SEIPBundle\Controller\Politic;

use DateTime;
use Pequiven\SEIPBundle\Controller\SEIPController;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Pequiven\SEIPBundle\Entity\Politic\Meeting;
use Pequiven\SEIPBundle\Form\Politic\MeetingType;
use Pequiven\SEIPBundle\Entity\Politic\Assistance;

/**
 * Controlador de reuniones de estudio de trabajo
 *
 */
class MeetingController extends SEIPController {

    public function createAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $idWorkStudyCircle = $request->get('workStudyCircle_id');
        $workStudyCircle = $em->getRepository('PequivenSEIPBundle:Politic\WorkStudyCircle')->findOneBy(array('id' => $idWorkStudyCircle));

        $members = $workStudyCircle->getUserWorkerId();

        $meeting = new Meeting();
        $form = $this->createForm(new MeetingType, $meeting);
        $form->handleRequest($request);

        $user = $this->getUser();
        $em->getConnection()->beginTransaction();

        if ($form->isSubmitted() && $form->isValid()) {

            $members = $workStudyCircle->getUserWorkerId();

            $idsCheck = array();
            $obsUser = array();
            foreach ($members as $member) {

                if (isset($request->get("meeting_extra")["member_" . $member->getId()])) {
                    $idsCheck[$member->getid()] = $request->get("meeting_extra")["member_" . $member->getId()];
                } else {
                    $idsCheck[$member->getid()] = "0";
                }

                if (isset($request->get("meeting_extra")["obs_" . $member->getId()])) {
                    $obsUser[$member->getid()] = $request->get("meeting_extra")["obs_" . $member->getId()];
                } else {
                    $obsUser[$member->getid()] = "";
                }
            }

            //VALIDA QUE NINGUN CAMPO DE OBSERVACION ESTE VACIO - SEGUNDA VALIDACION
            $band = true;
            $cont = 0;
            foreach ($members as $member) {
                if (($idsCheck[$member->getId()] == 0) && ($obsUser[$member->getId()] == "")) {
                    $band = false;
                    break;
                }
                $cont++;
            }



            if ($band) {

                $date = $request->get("meeting_data")["date"];
                $date = str_replace("/", "-", $date);
                $date = new \DateTime($date);

                $timeData = new DateTime("now");
                $time = $timeData->setTime($request->get("meeting_data")["duration"]["hour"], $request->get("meeting_data")["duration"]["minute"]);


                $meetingObj = new Meeting();
                $meetingObj->setCreatedBy($user);
                $meetingObj->setDate($date);
                $meetingObj->setPlace($request->get("meeting_data")["place"]);
                $meetingObj->setSubject($request->get("meeting_data")["subject"]);
                $meetingObj->setObservation($request->get("meeting_data")["observation"]);
                $meetingObj->setDuration($time);
                $meetingObj->setWorkStudyCircle($workStudyCircle);
                $em->persist($meetingObj);

                //SE AGREGAN LOS MIEMBROS A LA LISTA DE ASISTENCIA DE LA REUNION CON ASSISTENCIA = FALSE 
                //$members = $workStudyCircle->getUserWorkerId();
                foreach ($members as $member) {
                    $assistance = new Assistance();
                    $assistance->setUser($member);
                    $assistance->setMeeting($meetingObj);
                    $assistance->setAssistance($idsCheck[$member->getId()]);
                    $assistance->setObservation($obsUser[$member->getId()]);
                    $em->persist($assistance);
                }


                $em->flush();

                try {
                    $em->flush();
                    $em->getConnection()->commit();
                } catch (Exception $e) {
                    $em->getConnection()->rollback();
                    throw $e;
                }

                $this->get('session')->getFlashBag()->add('success', 'Reunión Guardada Correctamente');

                return $this->redirect($this->generateUrl('pequiven_meeting_show', array("meeting_id" => $meetingObj->getId())));
            } else {
                $this->get('session')->getFlashBag()->add('error', 'Debe llenar el campo Observación.');
            }
        }



        return $this->render('PequivenSEIPBundle:Politic:Meeting\create.html.twig', array(
                    'form' => $form->createView(),
                    "workStudyCircle" => $workStudyCircle,
                    'members' => $members
        ));
    }

    public function showAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $idMeeting = $request->get("meeting_id");
        $meeting = $em->getRepository('PequivenSEIPBundle:Politic\Meeting')->findOneBy(array('id' => $idMeeting));
        $workStudyCircle = $meeting->getWorkStudyCircle();

        $idCircle = $workStudyCircle->getId(); //Id Circulo

        $members = $workStudyCircle->getUserWorkerId();

        $assistance = $meeting->getAssistances();
        $assistanceIds = array();
        $assistanceObs = array();
        foreach ($assistance as $assis) {
            $assistanceIds[$assis->getUser()->getId()] = $assis->getAssistance();
            $assistanceObs[$assis->getUser()->getId()] = $assis->getObservation();
        }


        return $this->render('PequivenSEIPBundle:Politic:Meeting\show.html.twig', array(
                    'meeting' => $meeting,
                    'members' => $members,
                    'workStudyCircle' => $workStudyCircle,
                    'assistanceIds' => $assistanceIds,
                    'assistanceObs' => $assistanceObs,
                    'user' => $this->getUser()
        ));
    }

    public function editAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $idMeeting = $request->get("meeting_id");
        $meeting = $em->getRepository('PequivenSEIPBundle:Politic\Meeting')->findOneBy(array('id' => $idMeeting));

        $workStudyCircle = $meeting->getWorkStudyCircle();


        $form = $this->createForm(new MeetingType, $meeting);

        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {
            $em->getConnection()->beginTransaction();

            $date = $request->get("meeting_data")["date"];
            $date = str_replace("/", "-", $date);
            $date = new \DateTime($date);


            $meetingObj = $meeting;
            $meetingObj->setDate($date);
            $meetingObj->setPlace($request->get("meeting_data")["place"]);
            $meetingObj->setSubject($request->get("meeting_data")["subject"]);
            $meetingObj->setObservation($request->get("meeting_data")["observation"]);
            $meetingObj->setWorkStudyCircle($workStudyCircle);
            $em->persist($meetingObj);

            $em->flush();

            try {
                $em->flush();
                $em->getConnection()->commit();
            } catch (Exception $e) {
                $em->getConnection()->rollback();
                throw $e;
            }

            $this->get('session')->getFlashBag()->add('success', 'Reunión Guardada Correctamente');

            return $this->redirect($this->generateUrl('pequiven_work_study_circle_show', array("id" => $workStudyCircle->getId())));
        }


        return $this->render('PequivenSEIPBundle:Politic:Meeting\edit.html.twig', array(
                    'meeting' => $meeting,
                    'form' => $form->createView()
        ));
    }

    public function exportAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $idMeeting = $request->get("idmeeting");

        $meeting = $em->getRepository('PequivenSEIPBundle:Politic\Meeting')->findOneBy(array('id' => $idMeeting));
        $workStudyCircle = $meeting->getWorkStudyCircle();
        $members = $workStudyCircle->getUserWorkerId();

        $assistance = $meeting->getAssistances();
        $assistanceIds = array();
        $assistanceObs = array();

        foreach ($assistance as $assis) {
            $assistanceIds[$assis->getUser()->getId()] = $assis->getAssistance();
            if ($assis->getAssistance() == false) {
                // CONSTRUCCIÓN DEL ARRAY DE OBSERVACIONES. CONCADENO EL MENSAJE Y LO PREFORMATEO 
                $a = ucwords(strtolower($assis->getUser()->getfirstname())) . " " . ucwords(strtolower($assis->getUser()->getlastname()))
                        . " no Asistió por " . ucwords(strtolower($assis->getObservation()));
                $assistanceObs[] = $a;
            }
        }
        
        $data = array(
            'meeting' => $meeting,
            'members' => $members,
            'workStudyCircle' => $workStudyCircle,
            'assistanceIds' => $assistanceIds,
            'assistanceObs' => $assistanceObs,
            'user' => $this->getUser()
        );

        $this->generatePdf($data, 'Reporte de Asistencia', 'PequivenSEIPBundle:Politic:Meeting\viewPdf.html.twig');
    }

    public function exportAllAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $idWorkStudyCircle = $request->get("idWorkStudyCircle");

        $workStudyCircle = $em->getRepository('PequivenSEIPBundle:Politic\WorkStudyCircle')->findOneBy(array('id' => $idWorkStudyCircle));
        $meeting = $em->getRepository('PequivenSEIPBundle:Politic\Meeting')->findBy(array('workStudyCircle' => $idWorkStudyCircle));
        $members = $workStudyCircle->getUserWorkerId();

        $fechameeting = array();
        $asistencia = array();
        $totalAR = array();
        $totalAT = array();

        foreach ($meeting as $meet) {

            $fechameeting[] = $meet;
            $assistance = $meet->getAssistances();
            $total = 0;
            $totalneto = 0;

            foreach ($assistance as $assis) {
                $asistencia[$assis->getUser()->getId()][$meet->getId()] = $assis->getAssistance();

                if ($assis->getAssistance() == true) {
                    $total++;
                }
                $totalneto++;
            }

            $totalAR[$meet->getId()] = $total;
            $totalAT[$meet->getId()] = $totalneto;
        }

//        var_dump($fechameeting);
//        die();

        $data = array(
            'workStudyCircle' => $workStudyCircle,
            'members' => $members,
            'asistencia' => $asistencia,
            'meeting' => $meeting,
            'fechas' => $fechameeting,
            'totalAR' => $totalAR,
            'totalAT' => $totalAT
        );

        $this->generatePdf($data, 'Reporte de Asistencias a Reuniones', 'PequivenSEIPBundle:Politic:Meeting\exportAllpdf.html.twig', array('ORIENTATION' => 'P'));
    }

    public function generatePdf($data, $title, $template, $options = array()) {
        if (!isset($options['ORIENTATION'])) {
            $options['ORIENTATION'] = 'P';
        }

        $pdf = new \Pequiven\SEIPBundle\Model\PDF\SeipPdf($options['ORIENTATION'], PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->setPrintLineFooter(false);
        $pdf->setContainer($this->container);
        $pdf->setPeriod($this->getPeriodService()->getPeriodActive());
        $pdf->setFooterText($this->trans('pequiven_seip.message_footer', array(), 'PequivenSEIPBundle'));

// set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('SEIP');
        $pdf->setTitle($title);
        $pdf->SetSubject('Resultados SEIP');
        $pdf->SetKeywords('PDF, SEIP, Resultados');

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
//            $pdf->SetFont('times', 'BI', 12);
// add a page
        $pdf->AddPage();

// set some text to print

        $html = $this->renderView($template, $data);

// print a block of text using Write()
        $pdf->writeHTML($html, true, false, true, false, '');

//            $pdf->Output('Reporte del dia'.'.pdf', 'I');
        $pdf->Output($title . '.pdf', 'D');
    }

}
