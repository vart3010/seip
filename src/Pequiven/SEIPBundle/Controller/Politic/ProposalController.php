<?php

namespace Pequiven\SEIPBundle\Controller\Politic;

use DateTime;
use Pequiven\SEIPBundle\Entity\Politic\Proposal;
use Pequiven\SEIPBundle\Controller\SEIPController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sylius\Bundle\ResourceBundle\Event\ResourceEvent;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Pequiven\SEIPBundle\Form\Politic\ProposalType;

/**
 * Controlador de la propuesta del círculo de estudio de trabajo
 *
 */
class ProposalController extends SEIPController {

    public function createAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $idWorkStudyCircle = $request->get('workStudyCircle_id');
        $workStudyCircle = $em->getRepository('PequivenSEIPBundle:Politic\WorkStudyCircle')->findOneBy(array('id' => $idWorkStudyCircle));

        $proposal = new Proposal();
        $form = $this->createForm(new ProposalType, $proposal);
        $form->handleRequest($request);

        $proposalsRegistered = $em->getRepository('PequivenSEIPBundle:Politic\Proposal')->findBy(array('workStudyCircle' => $idWorkStudyCircle));
        $proposalsArray = array();
        foreach ($proposalsRegistered as $proposalRegistered) {
            $proposalsArray[$proposalRegistered->getLineStrategic()->getId()] = true;
        }

        $user = $this->getUser();
        $em->getConnection()->beginTransaction();
        if ($form->isSubmitted() && $form->isValid()) {

            $proposal1 = strtoupper($request->get("proposal_data")["description1"]);
            $proposal2 = strtoupper($request->get("proposal_data")["description2"]);
            $proposal3 = strtoupper($request->get("proposal_data")["description3"]);
            $proposal4 = strtoupper($request->get("proposal_data")["description4"]);
            $proposal5 = strtoupper($request->get("proposal_data")["description5"]);
            $proposal6 = strtoupper($request->get("proposal_data")["description6"]);
            $proposal7 = strtoupper($request->get("proposal_data")["description7"]);
            $proposal8 = strtoupper($request->get("proposal_data")["description8"]);
            $proposal9 = strtoupper($request->get("proposal_data")["description9"]);
            $proposal10 = strtoupper($request->get("proposal_data")["description10"]);

//            if (strlen($proposal1) > 20 && strlen($proposal2) > 20 && strlen($proposal3) > 20) {
                $proposals = array();
                array_push($proposals, $proposal1);
                array_push($proposals, $proposal2);
                array_push($proposals, $proposal3);
                array_push($proposals, $proposal4);
                array_push($proposals, $proposal5);
                array_push($proposals, $proposal6);
                array_push($proposals, $proposal7);
                array_push($proposals, $proposal8);
                array_push($proposals, $proposal9);
                array_push($proposals, $proposal10);

                //Obtenemos Línea Estratégica
                $LineStrategicRepository = $em->getRepository('PequivenMasterBundle:LineStrategic');
                $lineStrategicObject = $LineStrategicRepository->findOneBy(array('id' => $request->get("proposal_data")["lineStrategic"]));

//                if (strlen($proposal1) > 0 && strlen($proposal2) > 0 && strlen($proposal3) > 0 && strlen($proposal4) > 0 && strlen($proposal5) > 0) {
//                    if (array_key_exists($request->get("proposal_data")["lineStrategic"], $proposalsArray)) {
//                        $this->get('session')->getFlashBag()->add('error', 'La Línea Estratégica ya tiene sus 5 propuestas');
//                    } else {
                        for ($i = 1; $i <= 10; $i++) {
                            if(strlen($proposals[$i-1]) > 0){
                                $proposalObject = new Proposal();
                                $proposalObject->setCreatedBy($user);
                                $proposalObject->setPeriod($period = $this->getPeriodService()->getPeriodActive());
                                $proposalObject->setWorkStudyCircle($workStudyCircle);
                                $proposalObject->setLineStrategic($lineStrategicObject);
                                $proposalObject->setDescription($proposals[$i - 1]);
                                $em->persist($proposalObject);
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

                        $this->get('session')->getFlashBag()->add('success', 'Propuestas guardadas correctamente');

                        return $this->redirect($this->generateUrl('pequiven_work_study_circle_show_phase', array("id" => $workStudyCircle->getId())));
//                    }
//                } else {
//                    $this->get('session')->getFlashBag()->add('error', 'Debe agregar 5 propuestas por línea estratégica');
//                }
//            } else {
//                $this->get('session')->getFlashBag()->add('error', 'Las propuestas deben tener 20 caracteres como mínimo');
//            }
        }

        return $this->render('PequivenSEIPBundle:Politic:Proposal\create.html.twig', array(
                    'form' => $form->createView(),
                    'user' => $user,
                    'workStudyCircle' => $workStudyCircle,
        ));
    }

    /**
     * Devuelve los Objetivos Estratégicos de acuerdo a la Línea Estratégica seleccionada
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getObjetiveFromLineStrategicAction(Request $request) {
        $response = new JsonResponse();

        $objetiveChildrenStrategic = array();
        $em = $this->getDoctrine()->getManager();

        $lineStrategicId = $request->request->get('lineStrategicId');
        $lineStrategicArray = explode(',', $lineStrategicId);

        $results = $this->get('pequiven.repository.objetive')->getByLineStrategic($lineStrategicArray);
        $totalResults = count($results);
        if (is_array($results) && $totalResults > 0) {
            foreach ($results as $result) {
                $objetiveChildrenStrategic[] = array("ref" => $result->getRef(), "description" => $result->getDescription());
            }
        } else {
            $objetiveChildrenStrategic[] = array("empty" => true);
        }
        $response->setData($objetiveChildrenStrategic);

        return $response;
    }

    /**
     * Edición de Propuestas
     *
     *
     */
    public function editAction(request $request) {
        $em = $this->getDoctrine()->getManager();

        $id = $request->get('id');

        $proposalData = $em->getRepository('PequivenSEIPBundle:Politic\Proposal')->findOneBy(array('id' => $id));
        $idCircle = $proposalData->getWorkStudyCircle()->getId(); //Carga de id para el retorno al circulo

        $form = $this->createForm(new ProposalType, $proposalData); //Para reutilizar en form de la propuesta (El select2)
        $form->handleRequest($request);

        $em->getConnection()->beginTransaction();

        if ($form->isSubmitted()) {

            //$line = $request->get("proposal_data")['lineStrategic'];//Recibiendo el id de la Linea
            $description = strtoupper($request->get("proposal_data")['description']); //Recibiendo la Propuesta Editada
            //$lineData = $this->get('pequiven.repository.linestrategic')->findOneBy(array('id' => $line)); //Llamada linea
            //$proposalData->setLineStrategic($lineData);//Pasando la linea
            $proposalData->setDescription($description); //Pasando la propuesta editada

            $em->persist($proposalData);

            try {
                $em->flush();
                $em->getConnection()->commit();
            } catch (Exception $e) {
                $em->getConnection()->rollback();
                throw $e;
            }

            $this->get('session')->getFlashBag()->add('success', 'Propuesta Actualizada Correctamente');
            return $this->redirect($this->generateUrl('pequiven_work_study_circle_show_phase', array("id" => $idCircle)));
        }

        return $this->render('PequivenSEIPBundle:Politic:Proposal/edit.html.twig', array(
                    'proposal' => $proposalData,
                    'circle' => $idCircle,
                    'form' => $form->createView()
        ));
    }

    /**
     *
     *  Vista de propuesta
     *
     */
    public function showAction(request $request) {
        $em = $this->getDoctrine()->getManager();

        $id = $request->get('id');

        $idCircle = $request->get('idCircle');

        $proposalData = $em->getRepository('PequivenSEIPBundle:Politic\Proposal')->findOneBy(array('id' => $id));

        return $this->render('PequivenSEIPBundle:Politic:Proposal/show.html.twig', array(
                    'proposal' => $proposalData,
                    'circle' => $idCircle
        ));
    }

    public function exportAction(request $request) {
        $em = $this->getDoctrine()->getManager();
        $workStudyCircle = $em->getRepository('PequivenSEIPBundle:Politic\WorkStudyCircle')->findOneBy(array('id' => $request->get("idWorkStudyCircle")));
        $user = $this->getUser();
        $proposals = $em->getRepository('PequivenSEIPBundle:Politic\Proposal')->findBy(array('workStudyCircle' => $request->get("idWorkStudyCircle")));
        $lineStrategics = array();

        //RECORRO LAS PROPUESTAS PARA SACAR LAS LINEAS DE CADA UNA NO IMPORTA SI SE REPITEN
        foreach ($proposals as $prop) {
            $lineStrategics[] = $prop->getLineStrategic()->getDescription();
        }

        //AGRUPO EL ARREGLO POR LINEA, ES DECIR UN REGISTRO POR CADA LINEA QUE TENGA PROPUESTA. 
        //KEY->DESCRIPCION LINEA y VALUE->FRECUENCIA (CUANTAS VECES SE REPITE)

        $lineas = array_count_values($lineStrategics);

        $data = array(
            'workStudyCircle' => $workStudyCircle,
            'userData' => $user,
            'proposals' => $proposals,
            'lineas' => $lineas
        );

        $this->generatePdf($data, 'Reporte de Propuestas de Círculo de Estudio y Trabajo', 'PequivenSEIPBundle:Politic:Proposal\viewPdf.html.twig');
    }

    /**
     *
     *  Propuestas Vista General
     *
     */
    public function viewAction(request $request) {
        $em = $this->getDoctrine()->getManager();

        $proposal = $em->getRepository('PequivenSEIPBundle:Politic\Proposal')->findAll();
        $phase = $request->get('phase');

        $lineas = $this->get('pequiven.repository.linestrategic')->findAll(); //LineasEstrategicas
        //Carga de data de Indicador para armar grafica
        $response = new JsonResponse();

        $workService = $this->getWorkStudyCircleService();

        $dataChart = $workService->getDataChartOfProposalData($proposal, $lineas); //Paso de data de la propuesta

        $dataChartLocalidad = $workService->getDataChartOfProposalDataLocalidad($proposal); //Paso de data de la propuesta

        return $this->render('PequivenSEIPBundle:Politic:Proposal/view.html.twig', array(
                    'data' => $dataChart,
                    'dataLocalidad' => $dataChartLocalidad
        ));
    }

    /**
     * Lista de Indicadores por nivel(Estratégico, Táctico u Operativo)
     * 
     * @param Request $request
     * @return type
     */
    function listAction(Request $request) {

        $criteria = $request->get('filter', $this->config->getCriteria());
        $sorting = $request->get('sorting', $this->config->getSorting());
        $repository = $this->getRepository();
        $phase = $request->get('phase');

        $criteria['phase'] = $phase;

        if ($this->config->isPaginated()) {
            $resources = $this->resourceResolver->getResource(
                    $repository, 'createPaginatorProposal', array($criteria, $sorting)
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
        $apiDataUrl = $this->generateUrl('pequiven_proposal_list', $routeParameters);

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('list.html'))
                ->setTemplateVar($this->config->getPluralResourceName())
        ;
        $view->getSerializationContext()->setGroups(array('id', 'api_list', 'workStudyCircle', 'lineStrategic', 'complejo'));
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

    /**
     * Función que devuelve el paginador con las propuestas agrupados por los círculos heredados
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function listPhaseAction(Request $request) {

        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();

        $criteria = $request->get('filter', $this->config->getCriteria());
        $sorting = $request->get('sorting', $this->config->getSorting());

        $workStudyCircleParent = $request->get('workStudyCircleParent');

        $repository = $this->getRepository();
        $criteria['workStudyCircleParent'] = $workStudyCircleParent;

        //$criteria['user'] = $user->getId();

        if ($this->config->isPaginated()) {
            $resources = $this->resourceResolver->getResource(
                    $repository, 'createPaginatorInheritedByWorkStudyCircle', array($criteria, $sorting)
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

        $view = $this
                ->view()
                ->setTemplate('PequivenSEIPBundle:Politic:WorkStudyCircle/showPhase.html.twig')
                ->setTemplateVar($this->config->getPluralResourceName())
        ;
        $view->getSerializationContext()->setGroups(array('id', 'api_list', 'workStudyCircle', 'lineStrategic'));
        if ($request->get('_format') == 'html') {
            $view->setData($resources);
        } else {
            $formatData = $request->get('_formatData', 'default');

            $view->setData($resources->toArray('', array(), $formatData));
        }
        return $this->handleView($view);
    }

    public function generatePdf($data, $title, $template) {
        $pdf = new \Pequiven\SEIPBundle\Model\PDF\SeipPdf('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
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

    protected function getWorkStudyCircleService() {
        return $this->container->get('seip.service.workStudyCircle');
    }

}
