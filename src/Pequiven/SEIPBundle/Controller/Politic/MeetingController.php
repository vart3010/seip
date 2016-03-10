<?php

namespace Pequiven\SEIPBundle\Controller\Politic;

use DateTime;
use Pequiven\SEIPBundle\Controller\SEIPController;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Pequiven\SEIPBundle\Entity\Politic\Meeting;
use Pequiven\SEIPBundle\Form\Politic\MeetingType;
use Pequiven\SEIPBundle\Entity\Politic\Assistance;
use Symfony\Component\HttpFoundation\JsonResponse;
use Pequiven\SEIPBundle\Form\Politic\MeetingFileType;

/**
 * Controlador de reuniones de estudio de trabajo
 *
 */
class MeetingController extends SEIPController {

    public function createAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $idWorkStudyCircle = $request->get('workStudyCircle_id');
        $workStudyCircle = $em->getRepository('PequivenSEIPBundle:Politic\WorkStudyCircle')->findOneBy(array('id' => $idWorkStudyCircle));

        if ($workStudyCircle->getPhase() > 1) {
            $members = $workStudyCircle->getMembers();
        } else {
            $members = $workStudyCircle->getUserWorkerId();
        }

        $meeting = new Meeting();
        $form = $this->createForm(new MeetingType, $meeting);
        $form->handleRequest($request);

        $user = $this->getUser();
        $em->getConnection()->beginTransaction();

        if ($form->isSubmitted() && $form->isValid()) {

            if ($workStudyCircle->getPhase() == \Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle::PHASE_ONE) {
                $members = $workStudyCircle->getUserWorkerId();
            } elseif ($workStudyCircle->getPhase() == \Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle::PHASE_TWO) {
                $members = $workStudyCircle->getMembers();
            }

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

                if ($request->get("meeting_data")["duration"]["hour"] != "0" || $request->get("meeting_data")["duration"]["minute"] != "0") {
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

                    return $this->redirect($this->generateUrl('pequiven_meeting_show', array("id" => $meetingObj->getId())));
                } else {
                    $this->get('session')->getFlashBag()->add('error', 'Debe llenar el campo Duración.');
                }
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

    public function createMeetingFile(Meeting $meeting, $files, $categoryFiles) {
        //$idMeeting = $meeting->getId();
        $idWorkStudyCircle = $meeting->getWorkStudyCircle();
        $fileName = $idWorkStudyCircle->getId() . "_" . $meeting->getId();
        $fileUploaded = false;
        $fileExist = false;
        $em = $this->getDoctrine()->getEntityManager();




        foreach ($files as $file) {
            $ifExistFile = $em->getRepository('PequivenSEIPBundle:Politic\MeetingFile')->findBy(array('nameFile' => base64_encode($file["nameFile"]->getClientOriginalName())));

            if (count($ifExistFile) == 0) {
                $meetingFile = new \Pequiven\SEIPBundle\Entity\Politic\MeetingFile;
                $meetingFile->setCreatedBy($this->getUser());
                $meetingFile->setNameFile($file["nameFile"]->getClientOriginalName());
                $meetingFile->setPath(\Pequiven\SEIPBundle\Model\Politic\MeetingFile::getUploadDir());
                $meetingFile->setExtensionFile($file["nameFile"]->guessExtension());
                $meetingFile->setMeeting($meeting);

                foreach ($categoryFiles as $key => $value) {
                    $categoryFileEntity = $em->getRepository('PequivenSEIPBundle:Politic\CategoryFile')->findOneBy(array('id' => $value));
                    $meetingFile->addCategoryFile($categoryFileEntity);
                }

//                $workStudyCircleFile = new \Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircleFile();
//                $workStudyCircleFile->setCreatedBy($this->getUser());
//                $workStudyCircleFile->setNameFile($file->getClientOriginalName());
//                $workStudyCircleFile->setPath(\Pequiven\SEIPBundle\Model\Politic\WorkStudyCircleFile::getUploadDir());
//                $workStudyCircleFile->setExtensionFile($file->guessExtension());
//                $workStudyCircleFile->setWorkStudyCircle($meeting->getWorkStudyCircle());
                //SE MUEVE EL ARCHIVO AL SERVIDOR
                $file["nameFile"]->move($this->container->getParameter("kernel.root_dir") . '/../web/' . \Pequiven\SEIPBundle\Model\Politic\MeetingFile::getUploadDir(), \Pequiven\SEIPBundle\Model\Politic\MeetingFile::NAME_FILE . $fileName . "_" . base64_encode($file["nameFile"]->getClientOriginalName()));
                $fileUploaded = $file["nameFile"]->isValid();
            } else {
                $fileExist = true;
            }
        }


        if (!$fileExist) {
            if (!$fileUploaded) {


                $em->persist($meetingFile);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', $this->trans('action.messages.saveFileSuccess', array(), 'PequivenIndicatorBundle'));
                //$request->request->set("uploadFile", "");
                $this->redirect($this->generateUrl("pequiven_meeting_show", array("id" => $meeting->getId())));
            } else {
                $this->get('session')->getFlashBag()->add('error', $this->trans('action.messages.errorFileUpload', array(), 'PequivenIndicatorBundle'));
                //$request->request->set("uploadFile", "");
                $this->redirect($this->generateUrl("pequiven_meeting_show", array("id" => $meeting->getId())));
            }
        } else {
            $this->get('session')->getFlashBag()->add('error', "El archivo ya existe.");
            //$request->request->set("uploadFile", "");
            $this->redirect($this->generateUrl("pequiven_meeting_show", array("id" => $meeting->getId())));
        }
    }

    public function generateUrlFileAction(Request $request) {

        $response = new JsonResponse();
        $data = array();
        $data["url"] = $this->generateUrl("pequiven_work_study_circle_download_file", array("id" => $request->get("id")));
        $response->setData($data);
        return $response;
    }

    public function downloadFileAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $idFile = $request->get("id");
        $file = $em->getRepository('PequivenSEIPBundle:Politic\MeetingFile')->findOneBy(array('id' => $idFile));


        $path = \Pequiven\SEIPBundle\Model\Politic\MeetingFile::LOCATION_UPLOAD_FILE;
        $name = \Pequiven\SEIPBundle\Model\Politic\MeetingFile::NAME_FILE;
        $idMeeting = $file->getMeeting();
        $workStudyCircle = $file->getMeeting()->getWorkStudyCircle();

        $ruta = $this->container->getParameter("kernel.root_dir") . '/../web/' . $path . "/" . $name . $workStudyCircle->getId() . "_" . $idMeeting->getId() . "_" . base64_encode($file->getNameFile());

        header('Content-type: application/pdf');
        readfile($ruta);
    }

    public function showAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $idMeeting = $request->get("id");
        $meeting = $em->getRepository('PequivenSEIPBundle:Politic\Meeting')->findOneBy(array('id' => $idMeeting));


        $workStudyCircle = $meeting->getWorkStudyCircle();

        if ($workStudyCircle->getPhase() > 1) {
            $members = $workStudyCircle->getMembers();
        } else {
            $members = $workStudyCircle->getUserWorkerId();
        }

        $assistance = $meeting->getAssistances();
        $assistanceIds = array();
        $assistanceObs = array();
        foreach ($assistance as $assis) {
            $assistanceIds[$assis->getUser()->getId()] = $assis->getAssistance();
            $assistanceObs[$assis->getUser()->getId()] = $assis->getObservation();
        }



        //CUANDO CARGA UN ARCHIVO
        if (count($request->files) > 0) {
            $categoryFilesSelected = $request->get("meetingFile_data");


            $band = false;
            //VALIDACION QUE SEA UN ARCHIVO PERMITIDO
            foreach ($request->files as $file) {
                if (in_array($file["nameFile"]->guessExtension(), \Pequiven\SEIPBundle\Model\Politic\MeetingFile::getTypesFile())) {
                    $band = true;
                }
            }
            if ($band) {
                $this->createMeetingFile($meeting, $request->files, $categoryFilesSelected["meeting"]);
            } else {
                $this->get('session')->getFlashBag()->add('error', $this->trans('action.messages.InvalidFile', array(), 'PequivenIndicatorBundle'));
                //$this->redirect($this->generateUrl("pequiven_meeting_show", array("meeting_id" => $request->get("idMeeting"))));
            }
        }
        $files = $meeting->getMeetingFile();

        return $this->render('PequivenSEIPBundle:Politic:Meeting\show.html.twig', array(
                    'meeting' => $meeting,
                    'members' => $members,
                    'workStudyCircle' => $workStudyCircle,
                    'assistanceIds' => $assistanceIds,
                    'assistanceObs' => $assistanceObs,
                    'user' => $this->getUser(),
                    'files' => $files
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

        if ($workStudyCircle->getPhase() > 1) {
            $members = $workStudyCircle->getMembers();
        } else {
            $members = $workStudyCircle->getUserWorkerId();
        }

        $assistance = $meeting->getAssistances();
        $assistanceIds = array();
        $assistanceObs = array();

        foreach ($assistance as $assis) {
            $assistanceIds[$assis->getUser()->getId()] = $assis->getAssistance();
            if ($assis->getAssistance() == false) {
                // CONSTRUCCIÓN DEL ARRAY DE OBSERVACIONES. CONCADENO EL MENSAJE Y LO PREFORMATEO 
                $a = ucwords(mb_strtolower($assis->getUser()->getfirstname(), 'UTF-8')) . " " . ucwords(mb_strtolower($assis->getUser()->getlastname(), 'UTF-8'))
                        . " no Asistió por " . ucwords(mb_strtolower($assis->getObservation(), 'UTF-8'));
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

        if ($workStudyCircle->getPhase() > 1) {
            $members = $workStudyCircle->getMembers();
        } else {
            $members = $workStudyCircle->getUserWorkerId();
        }

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

    public function uploadFilesAction(Request $request) {
        $meetingFile = new \Pequiven\SEIPBundle\Entity\Politic\MeetingFile();
        $form = $this->createForm(new MeetingFileType, $meetingFile);

        return $this->render('PequivenSEIPBundle:Politic:Meeting\uploadFile.html.twig', array(
                    'data' => $request->get("idMeeting"),
                    'form' => $form->createView()
        ));

//        $band = false;
////VALIDACION QUE SEA UN ARCHIVO PERMITIDO
//        foreach ($request->files as $file) {
//            if (in_array($file->guessExtension(), \Pequiven\SEIPBundle\Model\Politic\WorkStudyCircleFile::getTypesFile())) {
//                $band = true;
//            }
//        }
//
//        if ($band) {
//            
//        } else {
//            $this->get('session')->getFlashBag()->add('error', $this->trans('action.messages.InvalidFile', array(), 'PequivenIndicatorBundle'));
//        }
    }

    public function uploadAction(Request $request) {
//        return $this->render('PequivenSEIPBundle:Politic:Meeting\show.html.twig', array(
//                    'data' => $request->get("idMeeting")
//        ));


        $this->redirect($this->generateUrl("pequiven_meeting_show", array(
                    'id' => $request->get("idMeeting"),
        )));
    }

    /**
     * Lista General de Reuniones de los Circulo de Estudio
     * 
     * @param Request $request
     * @return type
     */
    function listAction(Request $request) {

        $criteria = $request->get('filter', $this->config->getCriteria());
        $sorting = $request->get('sorting', $this->config->getSorting());
        $repository = $this->container->get('pequiven.repository.meeting');
        $phase = $request->get('phase');

        $criteria['phase'] = $phase;
        $criteria['createdAt'] = $this->getPeriodService()->getPeriodActive()->getName();

        if ($this->config->isPaginated()) {
            $resources = $this->resourceResolver->getResource(
                    $repository, 'createPaginatorMeetings', array($criteria, $sorting)
            );

            $maxPerPage = $this->config->getPaginationMaxPerPage();
            if (($limit = $request->query->get('limit')) && $limit > 0) {
                if ($limit > 100) {
                    $limit = 100;
                }
                $maxPerPage = $limit;
            }
            $resources->setCurrentPage($request->get('page', 1), true, true);
            $resources->setMaxPerPage($maxPerPage);
        } else {
            $resources = $this->resourceResolver->getResource(
                    $repository, 'findBy', array($criteria, $sorting, $this->config->getLimit())
            );
        }
        $routeParameters = array(
            '_format' => 'json',
            'phase' => $phase,
        );
        $apiDataUrl = $this->generateUrl('pequiven_meeting_list', $routeParameters);

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('list.html'))
                ->setTemplateVar($this->config->getPluralResourceName())
        ;
        $view->getSerializationContext()->setGroups(array('id', 'api_list', 'date', 'subject', 'workStudyCircle', 'complejo'));
        if ($request->get('_format') == 'html') {

            $data = array(
                'apiDataUrl' => $apiDataUrl,
                'phase' => $phase,
            );
            $view->setData($data);
        } else {
            $formatData = $request->get('_formatData', 'default');

            $view->setData($resources->toArray('', array(), $formatData));
        }
        return $this->handleView($view);
    }

    public function viewAction() {

        $em = $this->getDoctrine()->getManager();

        //Carga de data
        $response = new JsonResponse();
        //$phase = $request->get('phase');

        $workService = $this->getWorkStudyCircleService();
        $period = $this->getSecurityService()->getPeriodService()->getPeriodActive()->getName();

        $meeting = $em->getRepository('PequivenSEIPBundle:Politic\Meeting')->findMeetingsbyPeriod($period);

        $dataChart = $workService->getDataChartOfMeetingsData($period); //Paso de data        

        return $this->render('PequivenSEIPBundle:Politic:Meeting\view.html.twig', array(
                    'data' => $dataChart
        ));
    }

    public function listGeneralAction(Request $request) {
        $workService = $this->getWorkStudyCircleService();
        $dataChart = $workService->getDataDocumentsChart();
        return $this->render('PequivenSEIPBundle:Politic:Meeting\viewDocuments.html.twig', array(
                    "chart" => $dataChart
        ));
    }

    protected function getWorkStudyCircleService() {
        return $this->container->get('seip.service.workStudyCircle');
    }

}
