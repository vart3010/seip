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

    public function addWorkStudyCircleToUser(WorkStudyCircle $workStudyCircle, $members = array()) {
        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();
        foreach ($members as $member) {
            $user = $em->getRepository('PequivenSEIPBundle:User')->findOneBy(array('id' => $member));
            $user->setWorkStudyCircle($workStudyCircle);
            $em->persist($user);
        }

        $user = $this->getUser();
        $user->setWorkStudyCircle($workStudyCircle);
        $em->persist($user);

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

        $user = $this->getUser();

        return $this->render('PequivenSEIPBundle:Politic:WorkStudyCircle\show.html.twig', array(
                    'workStudyCircle' => $workStudyCircle,
                    'userData' => $user
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

            $this->addWorkStudyCircleToUser($workStudyCircleRepo, $request->get("workStudyCircle_data")["userWorkerId"]);


            $this->get('session')->getFlashBag()->add('success', 'Nuevos miembros han sido agregados con éxito ');
            //return $this->redirect($this->generateUrl('pequiven_seip_default_index'));
            return $this->redirect($this->generateUrl('pequiven_work_study_circle_show', array("id" => $request->get("idWorkStudyCircle"))));
        }

        return $this->render('PequivenSEIPBundle:Politic:WorkStudyCircle\addOthersMembers.html.twig', array(
                    'id' => $request->get("idWorkStudyCircle"),
                    'form' => $form->createView()
        ));
    }

    public function viewAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $complejo = $this->get('pequiven_seip.repository.complejo')->findAll(); //Llamada de complejo

        foreach ($complejo as $value) {

            $idComplejo = $value->getId();

            //$users = $this->get('pequiven_seip.repository.user')->findQueryUsersAll($idComplejo); //Carga los Usuarios Reales

            $usersNotNull = $this->get('pequiven_seip.repository.user')->findQueryUsersAllRegister($idComplejo); //Carga los Usuarios worStudyCircleId =  NULL

            $workStudyCircle = $em->getRepository('PequivenSEIPBundle:Politic\WorkStudyCircle')->findBy(array('complejo' => $idComplejo));

            $complejosCant[] = count($workStudyCircle);

            //$usersCant[] = count($users);
            //$cantNull[] = count($users) - count($usersNull);
            $cantNotNull[] = count($usersNotNull);
            //var_dump(count($users));
        }

        $arrayTemp = array(1804, 1806, 342, 606);

        return $this->render('PequivenSEIPBundle:Politic:WorkStudyCircle\view.html.twig', array(
                    'workStudyCircle' => $workStudyCircle,
                    'complejo' => $complejo,
                    //'users' => $usersCant,
                    'users' => $arrayTemp,
                    'complejosCant' => $complejosCant,
                    'cantNull' => $cantNotNull
        ));

        //return $this->render('PequivenSEIPBundle:Politic:WorkStudyCircle\view.html.twig');
    }
    
    
    public function listAction(Request $request) {
        
        $criteria = $request->get('filter', $this->config->getCriteria());
        $sorting = $request->get('sorting', $this->config->getSorting());
        $repository = $this->getRepository();
        $circle = $this->get('pequiven.repository.work_study_circle')->findAll(); //Carga los Criculos
        
        //var_dump();
        //die();
        //$criteria['applyPeriodCriteria'] = true;

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
        );
        $apiDataUrl = $this->generateUrl('pequiven_work_study_circle_list', $routeParameters);

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('list.html'))
                ->setTemplateVar($this->config->getPluralResourceName())
        ;
        //$view->getSerializationContext()->setGroups(array('id', 'api_list','codigo', 'name'));
        if ($request->get('_format') == 'html') {
            $labelsCircle = array();
            foreach ($circle as $value) {
                
                $labelsCircle[] = array(
                    'codigo' => $value->getCodigo(),
                    'name' => $value->getName(),
                );
            }
        
            $data = array(
                   'apiDataUrl' => $apiDataUrl,
                    $this->config->getPluralResourceName() => $resources,
                   'labelsCircle' => $labelsCircle            
            );
            $view->setData($data);
        } else {
            $formatData = $request->get('_formatData', 'default');

            $view->setData($resources->toArray('', array(), $formatData));
        }
        return $this->handleView($view);
                
    }

    public function exportAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $workStudyCircle = $em->getRepository('PequivenSEIPBundle:Politic\WorkStudyCircle')->findOneBy(array('id' => $request->get("idWorkStudyCircle")));

        $user = $this->getUser();

        $data = array(
            'workStudyCircle' => $workStudyCircle,
            'userData' => $user
        );

        $this->generatePdf($data);
    }

    public function generatePdf($data) {
        $pdf = new \Pequiven\SEIPBundle\Model\PDF\SeipPdf('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->setPrintLineFooter(false);
        $pdf->setContainer($this->container);
        $pdf->setPeriod($this->getPeriodService()->getPeriodActive());
        $pdf->setFooterText($this->trans('pequiven_seip.message_footer', array(), 'PequivenSEIPBundle'));

// set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('SEIP');
        $pdf->setTitle('Reporte del día');
        $pdf->SetSubject('Resultados SEIP');
        $pdf->SetKeywords('PDF, SEIP, Resultados');

        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
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

        $html = $this->renderView('PequivenSEIPBundle:Politic:WorkStudyCircle\viewPdf.html.twig', $data);

// print a block of text using Write()
        $pdf->writeHTML($html, true, false, true, false, '');

//            $pdf->Output('Reporte del dia'.'.pdf', 'I');
        $pdf->Output('Reporte del dia' . '.pdf', 'D');
    }

    protected function getSecurityService() {
        return $this->container->get('seip.service.security');
    }

}
