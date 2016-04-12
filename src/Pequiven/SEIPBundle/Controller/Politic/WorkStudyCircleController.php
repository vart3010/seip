<?php

namespace Pequiven\SEIPBundle\Controller\Politic;

use DateTime;
use Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle;
use Pequiven\SEIPBundle\Controller\SEIPController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sylius\Bundle\ResourceBundle\Event\ResourceEvent;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Pequiven\SEIPBundle\Form\Politic\WorkStudyCircleType;

/**
 * Controlador del círculo de estudio de trabajo
 *
 */
class WorkStudyCircleController extends SEIPController {

    public function editWorkStudyCircleMemberAction(Request $request) {

        $em = $this->getDoctrine()->getManager();

        $idUser = $request->get('idUser');

        $user = $em->getRepository('PequivenSEIPBundle:User')->find($idUser);

        if (!$user) {
            throw $this->createNotFoundException('Unable to find ArrangementProgram entity.');
        }

        $formUser = $this->createForm(new \Pequiven\SEIPBundle\Form\User\UserType(), $user);
        $formUser->handleRequest($request);

        $em->getConnection()->beginTransaction();
        if ($formUser->isSubmitted() && $formUser->isValid()) {
            $em->persist($user);

            try {
                $em->flush();
                $em->getConnection()->commit();
            } catch (Exception $e) {
                $em->getConnection()->rollback();
                throw $e;
            }

            $this->get('session')->getFlashBag()->add('success', 'Miembro actualizado correctamente');
            return $this->redirect($this->generateUrl('pequiven_work_study_circle_show', array("id" => $user->getWorkStudyCircle()->getId())));
        }

        return $this->render('PequivenSEIPBundle:Politic:WorkStudyCircle\editMember.html.twig', array(
                    'user' => $user,
                    'form_user' => $formUser->createView()
        ));
    }

    public function createAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $workStudyCircle = new WorkStudyCircle();
        $form = $this->createForm(new WorkStudyCircleType, $workStudyCircle);
        $form->handleRequest($request);

        $userData = new \Pequiven\SEIPBundle\Entity\User();
        $formUser = $this->createForm(new \Pequiven\SEIPBundle\Form\User\UserType(), $userData);
        $formUser->handleRequest($request);

        $user = $this->getUser();
        //$period = $this->getPeriodService();
        $em->getConnection()->beginTransaction();
        if ($form->isSubmitted() && $form->isValid()) {

            $idsUsers = $request->get("workStudyCircle_data")["userWorkerId"];
            $countUsers = count($idsUsers);
            $securityService = $this->getSecurityService();


            $validMinUsers = 8;

            if ($securityService->isGranted(array("ROLE_SEIP_WORK_STUDY_CIRCLES_INACTIVE_VALIDATION_MEMBERS"))) {
                $validMinUsers = 1;
            }


            if ($countUsers < $validMinUsers) {
                $this->get('session')->getFlashBag()->add('error', 'Debe Agregar ' . $validMinUsers . ' miembros como mínimo');
            } else {


                $workStudyCircle->setCreatedBy($user);
                $workStudyCircle->setPeriod($period = $this->getPeriodService()->getPeriodActive());
                $workStudyCircle->setCodigo($this->setNewRef($request->get("workStudyCircle_data")["complejo"]));

                $em->persist($workStudyCircle);
                $em->flush();

                $user->setCellphone($request->get("userType_data")["cellphone"]);
                $user->setIndentification($request->get("userType_data")["indentification"]);
                $user->setExt($request->get("userType_data")["ext"]);

                try {
                    $em->flush();
                    $em->getConnection()->commit();
                } catch (Exception $e) {
                    $em->getConnection()->rollback();
                    throw $e;
                }

                $workStudyCircle = $em->getRepository('PequivenSEIPBundle:Politic\WorkStudyCircle')->findOneBy(array('createdBy' => $user->getId()));

                $this->addWorkStudyCircleToUser($workStudyCircle, $request->get("workStudyCircle_data")["userWorkerId"]);
                $this->addWorkStudyCircleToUser($workStudyCircle, array($user->getId()));

                $this->get('session')->getFlashBag()->add('success', 'Círculo de Estudio guardado correctamente');
                //return $this->redirect($this->generateUrl('pequiven_seip_default_index'));
                return $this->redirect($this->generateUrl('pequiven_work_study_circle_show', array("id" => $workStudyCircle->getId())));
                //return $this->redirect($this->generateUrl('saci_people_list', array('id' => $people->getId())));
            }
        }

        return $this->render('PequivenSEIPBundle:Politic:WorkStudyCircle\create.html.twig', array(
                    'form' => $form->createView(),
                    'user' => $user,
                    'form_user' => $formUser->createView()
        ));
    }

    public function addWorkStudyCircleToUser(WorkStudyCircle $workStudyCircle, $members = array(), $options = array()) {
        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();
        foreach ($members as $member) {

            $user = $em->getRepository('PequivenSEIPBundle:User')->findOneBy(array('id' => $member));

            if (isset($options['typeCoordinator'])) {
                if ($options['typeCoordinator'] == WorkStudyCircle::TYPE_COORDINATOR) {
                    $workStudyCircle->setCoordinator($user);
                } elseif ($options['typeCoordinator'] == WorkStudyCircle::TYPE_COORDINATOR_DISCUSSION) {
                    $workStudyCircle->setCoordinatorDiscussion($user);
                }
                $em->persist($workStudyCircle);
            } else {
                $user->setWorkStudyCircle($workStudyCircle);
                $workStudyCircle->addMembers($user);
                $em->persist($user);
                $em->persist($workStudyCircle);
            }
        }

//        if($includeUser){
//            $user = $this->getUser();
//            $user->setWorkStudyCircle($workStudyCircle);
//            $em->persist($user);
//        }

        try {
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            throw $e;
        }

        return true;
    }

    public function setNewRef($location) {
        $em = $this->getDoctrine()->getManager();
        $complejo = $em->getRepository('PequivenMasterBundle:Complejo')->findOneBy(array('id' => $location));
        $workStudyCircles = $em->getRepository('PequivenSEIPBundle:Politic\WorkStudyCircle')->findBy(array('complejo' => $location));
        $totalWorkStudyCircles = count($workStudyCircles);

        $ref = 'CET-' . $complejo->getRef() . '-';
        $contRef = $totalWorkStudyCircles + 1;
        if ($totalWorkStudyCircles < 10) {
            $ref = $ref . '000' . $contRef;
        } elseif ($totalWorkStudyCircles >= 10 && $totalWorkStudyCircles < 100) {
            $ref = $ref . '00' . $contRef;
        } elseif ($totalWorkStudyCircles >= 100 && $totalWorkStudyCircles < 1000) {
            $ref = $ref . '0' . $contRef;
        } elseif ($totalWorkStudyCircles >= 1000) {
            $ref = $ref . $contRef;
        }

        return $ref;
    }

    public function showAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $workStudyCircle = $em->getRepository('PequivenSEIPBundle:Politic\WorkStudyCircle')->findOneBy(array('id' => $request->get("id")));

        $rolView = 'ROLE_SEIP_WORK_STUDY_CIRCLE_VIEW';
        $securityService = $this->getSecurityService();
        $securityService->checkMethodSecurity($rolView, $workStudyCircle);

        $workStudyCircleService = $this->getWorkStudyCircleService();
        $proposals = $workStudyCircle->getProposals();
        $meetings = $workStudyCircle->getMeeting();

        $user = $this->getUser();

        $isALlowToEdit = $workStudyCircleService->isAllowToEdit($workStudyCircle);
        $isAllowToAddMembers = $workStudyCircleService->isAllowToAddMembers($workStudyCircle);
        $isAllowToEditMembers = $workStudyCircleService->isAllowToEditMembers($workStudyCircle);
        $isAllowToDeleteMembers = $workStudyCircleService->isAllowToDeleteMembers($workStudyCircle);
        $isAllowToAddMeetings = $workStudyCircleService->isAllowToAddMeetings($workStudyCircle);
        $isAllowToAddProposals = $workStudyCircleService->isAllowToAddProposals($workStudyCircle);
        $isAllowToEditProposals = $workStudyCircleService->isAllowToEditProposals($workStudyCircle);

        return $this->render('PequivenSEIPBundle:Politic:WorkStudyCircle\show.html.twig', array(
                    'workStudyCircle' => $workStudyCircle,
                    'userData' => $user,
                    'proposals' => $proposals,
                    'meetings' => $meetings,
                    'user' => $user,
                    'isAllowToEdit' => $isALlowToEdit,
                    'isAllowToAddMembers' => $isAllowToAddMembers,
                    'isAllowToEditMembers' => $isAllowToEditMembers,
                    'isAllowToDeleteMembers' => $isAllowToDeleteMembers,
                    'isAllowToAddMeetings' => $isAllowToAddMeetings,
                    'isAllowToAddProposals' => $isAllowToAddProposals,
                    'isAllowToEditProposals' => $isAllowToEditProposals,
                    'periodService' => $this->getPeriodService()
        ));
    }

    public function showPhaseAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $workStudyCircle = $em->getRepository('PequivenSEIPBundle:Politic\WorkStudyCircle')->findOneBy(array('id' => $request->get("id")));

        $rolView = 'ROLE_SEIP_WORK_STUDY_CIRCLE_VIEW';
        $securityService = $this->getSecurityService();
        $securityService->checkMethodSecurity($rolView, $workStudyCircle);

        $workStudyCircleService = $this->getWorkStudyCircleService();

        $proposals = $workStudyCircle->getProposals();
        $meetings = $workStudyCircle->getMeeting();

        $user = $this->getUser();

        $isAllowToAddMeetings = false;
        $isAllowToAddProposals = false;

        if ($workStudyCircle->getphase() < 4) {
            $isAllowToAddMeetings = $workStudyCircleService->isAllowToAddMeetings($workStudyCircle);
            $isAllowToAddProposals = $workStudyCircleService->isAllowToAddProposals($workStudyCircle);
        } else {
            foreach ($user->getWorkStudyCircles() as $circulos) {
                if ($circulos->getphase() == 4) {
                    $isAllowToAddMeetings = true;
                    $isAllowToAddProposals = true;
                }
            }
        }


        $isALlowToEdit = $workStudyCircleService->isAllowToEdit($workStudyCircle);
        $isAllowToAddMembers = $workStudyCircleService->isAllowToAddMembers($workStudyCircle);
        $isAllowToEditMembers = $workStudyCircleService->isAllowToEditMembers($workStudyCircle);
        $isAllowToEditProposals = $workStudyCircleService->isAllowToEditProposals($workStudyCircle);

        return $this->render('PequivenSEIPBundle:Politic:WorkStudyCircle\showPhase.html.twig', array(
                    'workStudyCircle' => $workStudyCircle,
                    'userData' => $user,
                    'proposals' => $proposals,
                    'meetings' => $meetings,
                    'user' => $user,
                    'isAllowToEdit' => $isALlowToEdit,
                    'isAllowToAddMembers' => $isAllowToAddMembers,
                    'isAllowToEditMembers' => $isAllowToEditMembers,
                    'isAllowToAddMeetings' => $isAllowToAddMeetings,
                    'isAllowToAddProposals' => $isAllowToAddProposals,
                    'isAllowToEditProposals' => $isAllowToEditProposals,
        ));
    }

    protected function getPeriodService() {
        return $this->container->get('pequiven_seip.service.period');
    }

    public function addOthersMembersAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $workStudyCircle = new WorkStudyCircle();
        $form = $this->createForm(new WorkStudyCircleType, $workStudyCircle);
        $form->handleRequest($request);

        $workStudyCircleRepo = $em->getRepository('PequivenSEIPBundle:Politic\WorkStudyCircle')->findOneBy(array('id' => $request->get("idWorkStudyCircle")));

        if ($form->isSubmitted()) {

            $this->addWorkStudyCircleToUser($workStudyCircleRepo, $request->get("workStudyCircle_data")["userWorkerId"], array('includeUser' => false));


            $this->get('session')->getFlashBag()->add('success', 'Nuevos miembros han sido agregados con éxito ');
            //return $this->redirect($this->generateUrl('pequiven_seip_default_index'));
            return $this->redirect($this->generateUrl('pequiven_work_study_circle_show', array("id" => $request->get("idWorkStudyCircle"))));
        }

        return $this->render('PequivenSEIPBundle:Politic:WorkStudyCircle\addOthersMembers.html.twig', array(
                    'id' => $request->get("idWorkStudyCircle"),
                    'form' => $form->createView()
        ));
    }

    public function addCoordinatorAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $workStudyCircle = new WorkStudyCircle();
        $form = $this->createForm(new WorkStudyCircleType($request->get('idWorkStudyCircle')), $workStudyCircle);
        $form->handleRequest($request);
        $typeCoordinator = $request->get('typeCoordinator');

        $workStudyCircleObject = $em->getRepository('PequivenSEIPBundle:Politic\WorkStudyCircle')->findOneBy(array('id' => $request->get("idWorkStudyCircle")));
        if ($form->isSubmitted()) {

            $this->addWorkStudyCircleToUser($workStudyCircleObject, $request->get("workStudyCircle_data")["members"], array('includeUser' => false, 'typeCoordinator' => $typeCoordinator));

            if ($typeCoordinator == WorkStudyCircle::TYPE_COORDINATOR) {
                $this->get('session')->getFlashBag()->add('success', 'Coordinador del CET añadido con éxito');
            } elseif ($typeCoordinator == WorkStudyCircle::TYPE_COORDINATOR_DISCUSSION) {
                $this->get('session')->getFlashBag()->add('success', 'Coordinador de debate añadido con éxito');
            }
            //return $this->redirect($this->generateUrl('pequiven_seip_default_index'));
            return $this->redirect($this->generateUrl('pequiven_work_study_circle_show_phase', array("id" => $request->get("idWorkStudyCircle"))));
        }

        return $this->render('PequivenSEIPBundle:Politic:WorkStudyCircle\addCoordinator.html.twig', array(
                    'id' => $request->get("idWorkStudyCircle"),
                    'form' => $form->createView(),
                    'typeCoordinator' => $typeCoordinator
        ));
    }

    public function viewAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $phase = $request->get('phase');
        $complejo = $this->get('pequiven_seip.repository.complejo')->findAll(); //Llamada de complejo

        foreach ($complejo as $value) {

            $idComplejo = $value->getId();

            //USUARIOS REGISTRADOS EN GRUPO
            $usersNotNull = $this->get('pequiven_seip.repository.user')->findQueryUsersAllRegister($idComplejo);

            $workStudyCircle = $em->getRepository('PequivenSEIPBundle:Politic\WorkStudyCircle')->findBy(array('complejo' => $idComplejo, 'phase' => $phase));

            $complejosCant[] = count($workStudyCircle);

            $cantNotNull[] = count($usersNotNull);
        }

        // PARCHE REVISAR INCONSISTENCIAS EN BASE DE DATOS "TO DO NEXT YEAR"
        $usersTemp = array(1804, 1806, 342, 606); //TOTAL DE USUARIOS DE PEQUIVEN

        if ($request->get('pdf') != null) {

            $datos = array(
                'workStudyCircle' => $workStudyCircle,
                'complejo' => $complejo,
                'users' => $usersTemp,
                'complejosCant' => $complejosCant,
                'cantNotNull' => $cantNotNull
            );

            $this->generatePdf($datos, 'Reporte Gral. de Círculos de Trabajo', 'PequivenSEIPBundle:Politic:WorkStudyCircle\GeneralViewPdf.html.twig');
        } else {

            $workService = $this->getWorkStudyCircleService();

            $titlesCircles = array(
                "caption" => "Cantidad de Circulos por Complejo",
                "subCaption" => "",
                "ejeyLeft" => "Cant Circulos",
                "type" => "circle"
            );

            $titlesUser = array(
                "caption" => "Cantidad de Circulos por Complejo",
                "subCaption" => "",
                "ejeyLeft" => "Cant Empleados",
                "type" => "user"
            );

            $datosGraphic = array(
                "complejos" => $complejo,
                "usersTemp" => $usersTemp,
                "complejosCant" => $complejosCant,
                "cantNotNull" => $cantNotNull
            );

            $generateColumnCircle = $workService->generateColumn3d($titlesCircles, $datosGraphic);
            $generateColumnUsers = $workService->generateColumn3d($titlesUser, $datosGraphic);


            $totalCircleGoal = $totalCircleReg = $totalEmpGoal = $totalEmpReg = 0;
            for ($i = 0; $i < count($complejo); $i++) {
                $totalCircleGoal += ($usersTemp[$i] / 12);
                $totalCircleReg += $complejosCant[$i];
                $totalEmpGoal += $usersTemp[$i];
                $totalEmpReg += $cantNotNull[$i];
            }

            return $this->render('PequivenSEIPBundle:Politic:WorkStudyCircle\view.html.twig', array(
                        'workStudyCircle' => $workStudyCircle,
                        'complejo' => $complejo,
                        'users' => $usersTemp,
                        'complejosCant' => $complejosCant,
                        'cantNotNull' => $cantNotNull,
                        'graphicCircle' => $generateColumnCircle,
                        'graphicUser' => $generateColumnUsers,
                        'phase' => $phase,
            ));
        }
    }

    public function listAction(Request $request) {

        $criteria = $request->get('filter', $this->config->getCriteria());
        $sorting = $request->get('sorting', $this->config->getSorting());
        $repository = $this->getRepository();
        $phase = $request->get('phase');
        $circle = $this->get('pequiven.repository.work_study_circle')->findAll(); //Carga los Criculos

        $criteria['phase'] = $phase;
        //$criteria['period'] = $this->getPeriodService()->getPeriodActive()->getId();


        if ($this->config->isPaginated()) {
            $resources = $this->resourceResolver->getResource(
                    $repository, 'createPaginatorByWorkStudyCircle', array($criteria, $sorting)
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
        $apiDataUrl = $this->generateUrl('pequiven_work_study_circle_list', $routeParameters);

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('list.html'))
                ->setTemplateVar($this->config->getPluralResourceName())
        ;
        if ($request->get('_format') == 'html') {
//            $labelsCircle = array();
//            foreach ($circle as $value) {
//                
//                $labelsCircle[] = array(
//                    'codigo' => $value->getCodigo(),                   
//                    'complejo' => $value->getComplejo(),
//                    'name' => $value->getName(),
//                    'id' => $value->getId(),
//
//                );
//            }
//        
            $data = array(
                'apiDataUrl' => $apiDataUrl,
                'phase' => $phase,
                $this->config->getPluralResourceName() => $resources,
//                   'labelsCircle' => $labelsCircle            
            );
            $view->setData($data);
        } else {
            $view->getSerializationContext()->setGroups(array('id', 'api_list', 'complejo', 'region'));
            $formatData = $request->get('_formatData', 'default');

            $view->setData($resources->toArray('', array(), $formatData));
        }
        return $this->handleView($view);
    }

    /**
     * 
     * @param Request $request
     */
    public function exportAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $workStudyCircle = $em->getRepository('PequivenSEIPBundle:Politic\WorkStudyCircle')->findOneBy(array('id' => $request->get("idWorkStudyCircle")));
        $user = $this->getUser();
        $proposals = $em->getRepository('PequivenSEIPBundle:Politic\Proposal')->findBy(array('workStudyCircle' => $request->get("idWorkStudyCircle")));
        $meetings = $workStudyCircle->getMeeting();

        $lineStrategics = null;

        //RECORRO LAS PROPUESTAS PARA SACAR LAS LINEAS DE CADA UNA NO IMPORTA SI SE REPITEN
        foreach ($proposals as $prop) {
            $lineStrategics[] = $prop->getLineStrategic()->getDescription();
        }

        //AGRUPO EL ARREGLO POR LINEA, ES DECIR UN REGISTRO POR CADA LINEA QUE TENGA PROPUESTA. 
        //KEY->DESCRIPCION LINEA y VALUE->FRECUENCIA (CUANTAS VECES SE REPITE)
        //TODO: ARREGLAR ESTO, DA ERROR
        if ($lineStrategics <> null) {
            $lineas = array_count_values($lineStrategics);
        } else {
            $lineas = null;
        }

        $data = array(
            'workStudyCircle' => $workStudyCircle,
            'userData' => $user,
            'proposals' => $proposals,
            'meetings' => $meetings,
            'lineas' => $lineas
        );

        $this->generatePdf($data, 'Reporte de Círculo de Trabajo', 'PequivenSEIPBundle:Politic:WorkStudyCircle\viewPdf.html.twig');
    }

    public function exportBackRestAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $workStudyCircle = $em->getRepository('PequivenSEIPBundle:Politic\WorkStudyCircle')->findOneBy(array('id' => $request->get("idWorkStudyCircle")));
        $user = $this->getUser();
        $proposals = $em->getRepository('PequivenSEIPBundle:Politic\Proposal')->findBy(array('workStudyCircle' => $request->get("idWorkStudyCircle")));
        $meetings = $workStudyCircle->getMeeting();

        $lineStrategics = null;

        //RECORRO LAS PROPUESTAS PARA SACAR LAS LINEAS DE CADA UNA NO IMPORTA SI SE REPITEN
        foreach ($proposals as $prop) {
            $lineStrategics[] = $prop->getLineStrategic()->getDescription();
        }

        //AGRUPO EL ARREGLO POR LINEA, ES DECIR UN REGISTRO POR CADA LINEA QUE TENGA PROPUESTA. 
        //KEY->DESCRIPCION LINEA y VALUE->FRECUENCIA (CUANTAS VECES SE REPITE)
        //TODO: ARREGLAR ESTO, DA ERROR
        if ($lineStrategics <> null) {
            $lineas = array_count_values($lineStrategics);
        } else {
            $lineas = null;
        }

        $data = array(
            'workStudyCircle' => $workStudyCircle,
            'userData' => $user,
            'proposals' => $proposals,
            'meetings' => $meetings,
            'lineas' => $lineas
        );

        $this->generatePdf($data, 'Constancia de Respaldo Revolucionario', 'PequivenSEIPBundle:Politic:WorkStudyCircle\BackRestPdf.html.twig');
    }

    public function generatePdf($data, $title, $template) {

        $pdf = new \Pequiven\SEIPBundle\Model\PDF\CETSeipPdf('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->setPrintLineFooter(false);
        $pdf->setContainer($this->container);
        $pdf->setPeriod($this->getPeriodService()->getPeriodActive());
        $pdf->setFooterText($this->trans('pequiven_seip.message_footer', array(), 'PequivenSEIPBundle'));
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('SEIP');
        $pdf->setTitle($title);
        $pdf->SetSubject('Resultados SEIP');
        $pdf->SetKeywords('PDF, SEIP, Resultados');
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 45, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->AddPage();
        $html = $this->renderView($template, $data);
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output(utf8_decode($title) . '.pdf', 'D');
    }

    /**
     * Elimina un miembro del Círculo
     * 
     * @param Request $request
     * @return type
     */
    public function deleteMemberAction(Request $request) {
        $idUser = $request->get('idUser');

        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();
        $repository = $this->getRepositoryById('user');
        $user = $repository->find($idUser);

        $idWorkStudyCircle = $user->getWorkStudyCircle()->getId();
        $workStudyCircle = $em->getRepository('PequivenSEIPBundle:Politic\WorkStudyCircle')->findOneBy(array('id' => $idWorkStudyCircle));
        $user->setWorkStudyCircle();
        $workStudyCircle->removeMembers($user);

        $em->persist($user);
        $em->persist($workStudyCircle);

        try {
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            throw $e;
        }

        $this->get('session')->getFlashBag()->add('success', $this->trans('flashes.messages.deleteMember', array('%user%' => $user->getOnlyFullNameUser()), 'workStudyCircle'));

        return true;
    }

    protected function getSecurityService() {
        return $this->container->get('seip.service.security');
    }

    protected function getWorkStudyCircleService() {
        return $this->container->get('seip.service.workStudyCircle');
    }

}
