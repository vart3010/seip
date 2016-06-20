<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\SEIPBundle\Controller\Planning;

use Symfony\Component\HttpFoundation\Request;
use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Pequiven\SEIPBundle\Model\PDF\SeipPdfH;
use Pequiven\MasterBundle\Entity\Rol;
use Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram;

/**
 * Controlador para mostrar los resultados
 *
 * @author matias
 */
class ResultController extends ResourceController {

    /**
     * Función que devuelve el paginador con las gerencias de 2da Línea
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function listResultAction(Request $request) {
        $securityService = $this->getSecurityService();
        $securityService->checkSecurity(array('ROLE_SEIP_RESULT_LIST_BY_MANAGEMENT', 'ROLE_SEIP_PLANNING_LIST_RESULT_ALL'));

        $em = $this->getDoctrine();

        $criteria = $request->get('filter', $this->config->getCriteria());
        $sorting = $request->get('sorting', $this->config->getSorting());
        $repository = $this->get('pequiven.repository.gerenciasecond');

        if (!$securityService->isGranted('ROLE_SEIP_PLANNING_LIST_RESULT_ALL')) {
            $user = $this->getUser();
            $rol = $user->getLevelByGroup(\Pequiven\SEIPBundle\Model\Common\CommonObject::TYPE_LEVEL_USER_ALL);
            if ($rol == Rol::ROLE_MANAGER_SECOND || $rol == Rol::ROLE_SUPERVISER || $rol == Rol::ROLE_WORKER_PQV) {
                $criteria['gerenciaSecondId'] = $user->getGerenciaSecond();
            } elseif ($rol == Rol::ROLE_MANAGER_FIRST) {
                $criteria['gerenciaFirstId'] = $user->getGerencia();
            } elseif ($rol == Rol::ROLE_GENERAL_COMPLEJO) {
                $criteria['complejoId'] = $user->getComplejo();
            }
        }
        if ($this->config->isPaginated()) {
            $resources = $this->resourceResolver->getResource(
                    $repository, 'createPaginatorGerenciaSecond', array($criteria, $sorting)
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
                ->setTemplate($this->config->getTemplate('list.html'))
                ->setTemplateVar($this->config->getPluralResourceName())
        ;
        $view->getSerializationContext()->setGroups(array('id', 'api_list', 'complejo', 'gerencia'));
        if ($request->get('_format') == 'html') {
            $view->setData($resources);
        } else {
            $formatData = $request->get('_formatData', 'default');

            $view->setData($resources->toArray('', array(), $formatData));
        }
        return $this->handleView($view);
    }

    /**
     * 
     * @param Request $request
     * @return type
     */
    public function userListItem(Request $request) {

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('listUserItem.html'))
                ->setData(array("id" => $request->get("idUser")))
//                ->setData(array("numPersonal"=>$request->get("numPersonal")))
        ;

        return $this->handleView($view);
    }

    /**
     * EXPORTA LA EVALUACION DE GESTION DE UN USUARIO 
     * @param Request $request
     */
    public function exportManagementUserListItem(Request $request) {

        $datosUser = array();
        $period = $this->getPeriodService()->getPeriodActive()->getName();


        if ($this->getRequest()->get('idUser') != null) {
            $idUser = $this->getRequest()->get('idUser');
            $searchUser = $this->container->get("pequiven.repository.user")->find($idUser);
            $datosUser = array("nombre" => $searchUser->getFullNameUser());
        } else {
            $idUser = $this->getUser()->getId();
        }

        $resultService = $this->getResultService();
        $userItems = $resultService->getUserItems($idUser, $period);

        $data = array(
            'user' => $searchUser,
            'userItems' => $userItems,
            'period' => $period,
        );

        $this->generatePdf($data, 'Resultados de Gestión', 'PequivenSEIPBundle:Monitor/User:UserSummaryItemsPdfFormat.html.twig');
    }

    /**
     * GENERA EL PDF
     * @param type $data
     * @param type $title
     * @param type $template
     */
    public function generatePdf($data, $title, $template) {

        $pdf = new \Pequiven\SEIPBundle\Model\PDF\NewSeipPdf('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
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
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
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
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function generateUrlFile(Request $request) {

        $response = new JsonResponse();
        $data = array();
        $data["url"] = $this->generateUrl("pequiven_list_user_items", array("idUser" => $request->get("idUser")));
        $response->setData($data);
        return $response;
    }

    /**
     * Función que renderiza el Monitor de Objetivos Operativos
     * 
     * @Template("PequivenSEIPBundle:Planning:Result/Operative/showMonitor.html.twig")
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return type
     */
    public function showMonitorAction(Request $request) {
        $categories = array();
        $linkToExportResult = '';
        $resultIndicator = $resultArrangementProgram = $resultObjetives = array();
        $showResultObjetives = false;
        $level = $request->get('level');

        $rol = null;
        $rolByLevel = array(
            \Pequiven\SEIPBundle\Model\Common\CommonObject::LEVEL_GERENCIA => array('ROLE_SEIP_RESULT_VIEW_TACTIC', 'ROLE_SEIP_PLANNING_VIEW_RESULT_TACTIC'),
            \Pequiven\SEIPBundle\Model\Common\CommonObject::LEVEL_GERENCIA_SECOND => array('ROLE_SEIP_RESULT_VIEW_OPERATIVE', 'ROLE_SEIP_PLANNING_VIEW_RESULT_OPERATIVE')
        );
        if (isset($rolByLevel[$level])) {
            $rol = $rolByLevel[$level];
        }
        $securityService = $this->getSecurityService();
        $securityService->checkSecurity($rol);

        $em = $this->getDoctrine();
        $id = $request->get('id');

        $tree = $objetives = array();
        $caption = '';
        if ($level == \Pequiven\SEIPBundle\Model\Common\CommonObject::LEVEL_GERENCIA) {
            $linkToExportResult = $this->generateUrl('pequiven_seip_result_export', array('level' => \Pequiven\SEIPBundle\Model\Common\CommonObject::LEVEL_GERENCIA, 'id' => $id));
            $urlExportFromChart = $this->generateUrl('pequiven_seip_result_export_from_chart', array('level' => \Pequiven\SEIPBundle\Model\Common\CommonObject::LEVEL_GERENCIA, 'id' => $id));
            $showResultObjetives = true;
            $caption = $this->trans('result.captionObjetiveTactical', array(), 'PequivenSEIPBundle');

            $gerencia = $this->get('pequiven.repository.gerenciafirst')->findWithObjetives($id);
            if ($gerencia) {
                $objetives = $gerencia->getTacticalObjectives();
                foreach ($objetives as $objetive) {
                    foreach ($objetive->getParents() as $parent) {
                        if (!isset($tree[(string) $parent])) {
                            $tree[(string) $parent] = array(
                                'parent' => $parent,
                                'child' => array(),
                            );
                        }
                        $tree[(string) $parent]['child'][(string) $objetive] = $objetive;
                    }
                }
            }
            $entity = $gerencia;
        } elseif ($level == \Pequiven\SEIPBundle\Model\Common\CommonObject::LEVEL_GERENCIA_SECOND) {
            $linkToExportResult = $this->generateUrl('pequiven_seip_result_export', array('level' => \Pequiven\SEIPBundle\Model\Common\CommonObject::LEVEL_GERENCIA_SECOND, 'id' => $id));
            $urlExportFromChart = $this->generateUrl('pequiven_seip_result_export_from_chart', array('level' => \Pequiven\SEIPBundle\Model\Common\CommonObject::LEVEL_GERENCIA_SECOND, 'id' => $id));
            $caption = $this->trans('result.captionObjetiveOperative', array(), 'PequivenSEIPBundle');

            $gerenciaSecond = $this->get('pequiven.repository.gerenciasecond')->findWithObjetives($id);
            $objetives = $gerenciaSecond->getOperationalObjectives();
            foreach ($objetives as $objetive) {
                foreach ($objetive->getParents() as $parent) {
                    if ($parent->getGerencia()->getId() === $gerenciaSecond->getGerencia()->getId()) {
                        if (!isset($tree[(string) $parent])) {
                            $tree[(string) $parent] = array(
                                'parent' => $parent,
                                'child' => array(),
                            );
                        }
                        $tree[(string) $parent]['child'][(string) $objetive] = $objetive;
                    }
                }
            }
            $entity = $gerenciaSecond;
        }

        if (!$securityService->isGranted($rol[1])) {
            $securityService->checkSecurity($rol[0], $entity);
        }
        //$subCaption = $this->trans('result.subCaptionObjetiveOperative',array(),'PequivenSEIPBundle');
        $period = $this->getPeriodService()->getEntityPeriodActive();
        $subCaption = $period->getDescription();

        $data = array(
            'dataSource' => array(
                'chart' => array(
                    'caption' => $caption,
                    'subCaption' => $subCaption,
                    'exporthandler' => $linkToExportResult,
                ),
                'categories' => array(
                    'category' => array(),
                ),
                'dataset' => array(),
            ),
        );

        //Configuramos el alto del gráfico
        $totalObjects = count($objetives);
        $heightChart = ($totalObjects * 40) + 200;

        //Data del gráfico
        foreach ($objetives as $objetive) {
            $viewObjetiveInChart = true;

            if ($level == \Pequiven\SEIPBundle\Model\Common\CommonObject::LEVEL_GERENCIA_SECOND) {
                foreach ($objetive->getParents() as $parent) {
                    if ($parent->getGerencia()->getId() != $entity->getGerencia()->getId()) {
                        $viewObjetiveInChart = false;
                    }
                }
            }

            if ($viewObjetiveInChart) {

                $refObjetive = $objetive->getRef();
                $flagResultIndicator = $flagResultArrangementProgram = $flagResultObjetives = false;
                $categories[] = array('label' => $refObjetive);
                foreach ($objetive->getResults() as $result) {
                    $urlObjetive = $this->generateUrl('objetiveOperative_show', array('id' => $objetive->getId()));
                    $totalIndicator = 0.0;
                    $totalObjetives = 0.0;
                    $flagResultIndicatorInternal = false;
                    $flagResultObjetivesInternal = false;

                    if ($result->getTypeResult() == \Pequiven\SEIPBundle\Model\Result\Result::TYPE_RESULT_INDICATOR) {
                        $totalIndicator += $result->getResultWithWeight();
                        $flagResultIndicator = $flagResultIndicatorInternal = true;
                    }
                    if ($result->getTypeResult() == \Pequiven\SEIPBundle\Model\Result\Result::TYPE_RESULT_ARRANGEMENT_PROGRAM) {
                        $resultArrangementProgram[] = array('value' => bcadd($result->getResultWithWeight(), '0', 2), 'link' => $urlObjetive, 'bgColor' => '');
                        $flagResultArrangementProgram = true;
                    }
                    if ($result->getTypeResult() == \Pequiven\SEIPBundle\Model\Result\Result::TYPE_RESULT_OBJECTIVE) {
                        $totalObjetives+= $result->getResultWithWeight();
                        $flagResultObjetives = $flagResultObjetivesInternal = true;
                    }
                    if ($result->getTypeResult() == \Pequiven\SEIPBundle\Model\Result\Result::TYPE_RESULT_OF_RESULT) {
                        foreach ($result->getChildrens() as $child) {
                            if ($child->getTypeResult() == \Pequiven\SEIPBundle\Model\Result\Result::TYPE_RESULT_INDICATOR) {
                                $totalIndicator += ($child->getResultWithWeight() * $result->getWeight()) / 100;
                                $flagResultIndicator = $flagResultIndicatorInternal = true;
                            } elseif ($child->getTypeResult() == \Pequiven\SEIPBundle\Model\Result\Result::TYPE_RESULT_OBJECTIVE) {
                                $totalObjetives+= ($child->getResultWithWeight() * $result->getWeight()) / 100;
                                $flagResultObjetives = $flagResultObjetivesInternal = true;
                            }
                        }
                    }

                    if ($flagResultIndicatorInternal === true) {
                        $resultIndicator[] = array('value' => bcadd($totalIndicator, '0', 2), 'link' => $urlObjetive);
                    }
                    if ($flagResultObjetivesInternal === true) {
                        $resultObjetives[] = array('value' => bcadd($totalObjetives, '0', 2), 'link' => $urlObjetive, 'bgColor' => '');
                    }
                }

                //Completar valores para que no de error.
                if (!$flagResultArrangementProgram) {
                    $resultArrangementProgram[] = array('value' => bcadd(0, '0', 2));
                }
                if (!$flagResultIndicator) {
                    $resultIndicator[] = array('value' => bcadd(0, '0', 2));
                }
                if (!$flagResultObjetives) {
                    $resultObjetives[] = array('value' => bcadd(0, '0', 2));
                }
            }
        }
        if (count($resultIndicator) > 0) {
            $data['dataSource']['dataset'][] = array(
                'seriesname' => $this->trans('chart.result.objetiveOperative.seriesNamePlan1'),
                'data' => $resultIndicator,
            );
        }
        if (count($resultArrangementProgram) > 0) {
            $data['dataSource']['dataset'][] = array(
                'seriesname' => $this->trans('chart.result.objetiveOperative.seriesNamePlan2'),
                'data' => $resultArrangementProgram,
            );
        }
        if ($showResultObjetives && count($resultObjetives) > 0) {
            $data['dataSource']['dataset'][] = array(
                'seriesname' => $this->trans('chart.result.objetiveOperative.seriesNamePlan3'),
                'data' => $resultObjetives,
            );
        }

        $data['dataSource']['categories']['category'] = $categories;

        $resultService = $this->getResultService();

        return array(
            'object' => $objetives,
            'entity' => $entity,
            'heightChart' => $heightChart,
            'data' => $data,
            'tree' => $tree,
            'resultService' => $resultService,
            'linkToExportResult' => $linkToExportResult,
            'urlExportFromChart' => $urlExportFromChart,
            'level' => $level,
            'period' => $subCaption,
        );
    }

    /**
     * Recalcula los resultados
     * 
     * @param Request $request
     * @return type
     * @throws type
     */
    public function recalculateAction(Request $request) {
        $this->getSecurityService()->checkSecurity('ROLE_SEIP_PLANNING_OPERATION_RECALCULATE_RESULT');

        $period = $this->getPeriodService()->getPeriodActive();
        $user = $this->getUser();
        
        $isAllowPolitic = false;
        if($user->getId() == 112 || $user->getId() == 22){
            $isAllowPolitic = true;
        }

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('recalculate.html'))
                ->setTemplateVar($this->config->getPluralResourceName())
        ;
        $arrangementprogramRepository = $this->get('pequiven_seip.repository.arrangementprogram');
        $indicatorRepository = $this->get('pequiven.repository.indicator');
//        $userRepository = $this->container->get('pequiven_seip.repository.user');
        $userRepository = $this->get('pequiven.repository.user');
        $onePerTenRepository = $this->get('pequiven.repository.oneperten');
        
        if ($request->isMethod('POST')) {
            $resultService = $this->getResultService();
            $id = $request->get('id');
            $type = $request->get('type');
            $data = array();
            $data['success'] = false;
            try {
                if ($type == 1) {
                    $resource = $arrangementprogramRepository->findWithData($id);
                    if ($resource) {
                        $resultService->refreshValueArrangementProgram($resource);
                    }
                } elseif ($type == 2) {
                    $resource = $indicatorRepository->find($id);
                    $resultService->refreshValueIndicator($resource);
                } elseif ($type == 3) {
                    $evaluationDetailsService = $this->getEvaluationDetailsService();
                    $resource = $userRepository->findBy(array('id' => $id));
                    $evaluationDetailsService->refreshValueEvaluation($resource[0], $period->getParent());
                } elseif ($type == 4) {
                    $onePerTenService = $this->getOnePerTenService();
                    $resource = $onePerTenRepository->find($id);
                    $onePerTenService->refreshProfileValue($resource);
                }
                $data['success'] = true;
            } catch (\Exception $exc) {
                $success = false;
                $data['code'] = $exc->getCode();
                $data['message'] = $exc->getMessage();
                $data['id'] = $id;
                $view->setStatusCode(500);
            }
            $view->setData($data);
            return $this->handleView($view);
        }

        //Programas de Gestión
        $qbArrangementprogram = $arrangementprogramRepository->findQueryWithResultNull($period);
        $qbArrangementprogram->select('ap.id,ap.ref');
        $resultsArrangementprogram = $qbArrangementprogram->getQuery()->getResult(\Doctrine\ORM\AbstractQuery::HYDRATE_ARRAY);
        //Indicadores
        $qbIndicator = $indicatorRepository->findQueryWithResultNull($period);
        $qbIndicator->select('i.id,i.ref');
        $resultsIndicator = $qbIndicator->getQuery()->getResult(\Doctrine\ORM\AbstractQuery::HYDRATE_ARRAY);
        //Evaluación Usuarios
        $qbUsers = $userRepository->findQueryWithRoleOwner();
        $qbUsers->select('u.id,u.numPersonal');
        $resultsUserEvaluationDetails = $qbUsers->getQuery()->getResult(\Doctrine\ORM\AbstractQuery::HYDRATE_ARRAY);
        //Perfiles Políticos
        if($isAllowPolitic){
            $qbOnePerTen = $onePerTenRepository->findQueryWithResultNull($period);
            $qbOnePerTen->select('opt.id,u.firstname,u.lastname');
            $resultsOnePerTen = $qbOnePerTen->getQuery()->getResult(\Doctrine\ORM\AbstractQuery::HYDRATE_ARRAY);
        }
        
        $dataArray = array(
            'resultsArrangementprogram' => $resultsArrangementprogram,
            'resultsIndicator' => $resultsIndicator,
            'resultsUserEvaluationDetails' => $resultsUserEvaluationDetails,
            'isAllowPolitic' => $isAllowPolitic,
        );
        if($isAllowPolitic){
            $dataArray['resultsOnePerTen'] = $resultsOnePerTen;
        }

        $view->setData($dataArray);

        return $this->handleView($view);
    }

    /**
     * Exportar los resultados de la gerencia seleccionada en formato PDF
     * @param Request $request
     */
    public function exportAction(Request $request) {

        if ($request->isMethod('POST')) {
            $exportRequestStream = $request->request->all();
            $request->request->remove('charttype');
            $request->request->remove('stream');
            $request->request->remove('stream_type');
            $request->request->remove('meta_bgColor');
            $request->request->remove('meta_bgAlpha');
            $request->request->remove('meta_DOMId');
            $request->request->remove('meta_width');
            $request->request->remove('meta_height');
            $request->request->remove('parameters');
            $fusionchartService = $this->getFusionChartExportService();
            $fileSVG = $fusionchartService->exportFusionChart($exportRequestStream);
        }

        //Busqueda de la Imagen Descargada
//        $routing = "/var/www/html/seip";
        $routing = $this->container->getParameter('kernel.root_dir');
        $nameSVG = glob("$routing/../web/php-export-handler/temp/*.png");

        $user = $this->getUser()->getId(); //Id Usuario    
        $user = str_pad($user, 6, "0", STR_PAD_LEFT);

        $cont = 0;
        $contImg = 1;
        foreach ($nameSVG as $value) {
            $pos = strpos($nameSVG[$cont], $user);
            if ($pos !== false) {
                if (strpos($nameSVG[$cont], "stackedbar3d")) {
                    $chartName = $nameSVG[$cont];
                    $contImg ++;
                }
            }
            $cont ++;
        }

        $showResultObjetives = false;
        $level = $request->get('level');
        $resultService = $this->getResultService();
        $periodService = $this->getPeriodService();
        $images = array();
        $em = $this->getDoctrine();
        $id = $request->get('id');

        $tree = $objetives = array();
        $caption = '';
        $images['good'] = $resultService->generateAsset('bundles/pequivenseip/logotipos/bullet_green.png');
        $images['middle'] = $resultService->generateAsset('bundles/pequivenseip/logotipos/bullet_yellow.png');
        $images['bad'] = $resultService->generateAsset('bundles/pequivenseip/logotipos/bullet_red.png');
        if ($level == \Pequiven\SEIPBundle\Model\Common\CommonObject::LEVEL_GERENCIA) {
            $showResultObjetives = true;
            $caption = $this->trans('result.captionObjetiveTactical', array(), 'PequivenSEIPBundle');
            $gerencia = $this->get('pequiven.repository.gerenciafirst')->findWithObjetives($id);
            $objetives = $gerencia->getTacticalObjectives();
            foreach ($objetives as $objetive) {
                foreach ($objetive->getParents() as $parent) {
                    if (!isset($tree[(string) $parent])) {
                        $tree[(string) $parent] = array(
                            'parent' => $parent,
                            'child' => array(),
                        );
                    }
                    $tree[(string) $parent]['child'][(string) $objetive] = $objetive;
                }
            }
            $entity = $gerencia;
        } elseif ($level == \Pequiven\SEIPBundle\Model\Common\CommonObject::LEVEL_GERENCIA_SECOND) {
            $caption = $this->trans('result.captionObjetiveOperative', array(), 'PequivenSEIPBundle');
            $gerenciaSecond = $this->get('pequiven.repository.gerenciasecond')->findWithObjetives($id);
            $objetives = $gerenciaSecond->getOperationalObjectives();
            foreach ($objetives as $objetive) {
                foreach ($objetive->getParents() as $parent) {
                    if ($parent->getGerencia()->getId() === $gerenciaSecond->getGerencia()->getId()) {
                        if (!isset($tree[(string) $parent])) {
                            $tree[(string) $parent] = array(
                                'parent' => $parent,
                                'child' => array(),
                            );
                        }
                        $tree[(string) $parent]['child'][(string) $objetive] = $objetive;
                    }
                }
            }
            $entity = $gerenciaSecond;
        }

        $pdf = new \Pequiven\SEIPBundle\Model\PDF\NewSeipPdf('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->setPrintLineFooter(false);
        $pdf->setContainer($this->container);
        $pdf->setPeriod($this->getPeriodService()->getPeriodActive());
        $pdf->setFooterText($this->trans('pequiven_seip.message_footer', array(), 'PequivenSEIPBundle'));
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('SEIP');
        $pdf->setTitle('Resultados de Objetivos por Gerencia');
        $pdf->SetSubject('Resultados SEIP');
        $pdf->SetKeywords('PDF, SEIP, Resultados');
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 35, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->AddPage();
        $namePdf = $entity->getDescription();
        $period = $this->getPeriodService()->getEntityPeriodActive();

        $html = $this->renderView('PequivenSEIPBundle:Result:viewPdf.html.twig', array(
            'chartName' => $chartName,
            'entity' => $entity,
            'tree' => $tree,
            'level' => $level,
            'resultService' => $resultService,
            'images' => $images,
            'period' => $period));

        // print a block of text using Write()
        $pdf->writeHTML($html, true, false, true, false);

        $pdf->Output('Resultados - ' . $namePdf . '.pdf', 'D');

        $this->rmTempFile($chartName);
    }

    /**
     *
     *  Eliminación de Imagen Temporal
     *
     */
    public function rmTempFile($chartName) {
        $imgChart = $chartName; //Ruta              

        shell_exec("rm $imgChart"); //Eliminamos
    }

    /**
     * Exportar los resultados de la gerencia seleccionada en formato PDF
     * @param Request $request
     */
    public function exportFromChartAction(Request $request) {

        $id = $request->get('id');
        $level = $request->get('level');

        return $this->redirect($this->generateUrl('pequiven_seip_result_export', array('level' => $level, 'id' => $id)));
    }

    /**
     * Retorna el template para visualizar los objetivos deseados
     * @param Request $request
     * @return type
     * @throws type
     */
    public function indexObjetivesAction(Request $request) {
        $level = $request->get("level");
        $templates = array(
            \Pequiven\ObjetiveBundle\Model\ObjetiveLevel::LEVEL_ESTRATEGICO => "PequivenObjetiveBundle:Strategic:list.html.twig",
            \Pequiven\ObjetiveBundle\Model\ObjetiveLevel::LEVEL_TACTICO => "PequivenObjetiveBundle:Tactic:list.html.twig",
            \Pequiven\ObjetiveBundle\Model\ObjetiveLevel::LEVEL_OPERATIVO => "PequivenObjetiveBundle:Operative:list.html.twig",
        );
        if (!isset($templates[$level])) {
            throw $this->createNotFoundException();
        }

        $template = $templates[$level];
        return $this->render($template);
    }

    public function indexIndicatorsAction(Request $request) {
        $level = $request->get("level");
        $templates = array(
            \Pequiven\ObjetiveBundle\Model\ObjetiveLevel::LEVEL_ESTRATEGICO => "PequivenIndicatorBundle:Strategic:list.html.twig",
            \Pequiven\ObjetiveBundle\Model\ObjetiveLevel::LEVEL_TACTICO => "PequivenIndicatorBundle:Tactic:list.html.twig",
            \Pequiven\ObjetiveBundle\Model\ObjetiveLevel::LEVEL_OPERATIVO => "PequivenIndicatorBundle:Operative:list.html.twig",
        );
        if (!isset($templates[$level])) {
            throw $this->createNotFoundException();
        }

        $template = $templates[$level];
        return $this->render($template);
    }

    public function indexArrangementProgramsAction(Request $request) {
        $criteria = $request->get('filter', $this->config->getCriteria());
        $user = $this->getUser();
        $level = $user->getLevelRealByGroup();
        if ($level >= \Pequiven\MasterBundle\Entity\Rol::ROLE_GENERAL_COMPLEJO) {
            if (isset($criteria['typeManagement']) && $criteria['typeManagement'] == \Pequiven\MasterBundle\Entity\GerenciaSecond::TYPE_MANAGEMENT_BINDING) {
                unset($criteria['firstLineManagement']);
                unset($criteria['complejo']);
            }
        } elseif ($level == \Pequiven\MasterBundle\Entity\Rol::ROLE_MANAGER_FIRST) {

            $criteria['firstLineManagement'] = $user->getGerencia()->getId();
            $criteria['complejo'] = $user->getComplejo()->getId();
        }

        $view = $this
                ->view()
                ->setTemplate("PequivenArrangementProgramBundle:ArrangementProgram:index.html.twig")
        //->setTemplateVar()
        ;
        $labelsStatus = array();
        foreach (ArrangementProgram::getLabelsStatus() as $key => $value) {
            $labelsStatus[] = array(
                'id' => $key,
                'description' => $this->trans($value, array(), 'PequivenArrangementProgramBundle'),
            );
        }

        $isAllowFilterComplejo = $this->getUserManager()->isAllowFilterComplejo($user); //Filtro de localidad
        $isAllowFilterFirstLineManagement = $this->getUserManager()->isAllowFilterFirstLineManagement($user); //Filtro de gerencia de primera linea
        $isAllowFilterManagementSecondLine = $this->getUserManager()->isAllowFilterManagementSecondLine($user); //Filtro de gerencia de segunda linea
        $isAllowFilterTypeManagement = ($level >= \Pequiven\MasterBundle\Entity\Rol::ROLE_GENERAL_COMPLEJO);

        $typesManagement = array();
        foreach (\Pequiven\MasterBundle\Entity\GerenciaSecond::getTypesManagement() as $key => $typeManagement) {
            $typesManagement[] = array(
                'id' => $key,
                'label' => $this->trans($typeManagement, array(), 'PequivenArrangementProgramBundle')
            );
        }

        $view->setData(array(
            'labelsStatus' => $labelsStatus,
            'isAllowFilterComplejo' => $isAllowFilterComplejo,
            'isAllowFilterFirstLineManagement' => $isAllowFilterFirstLineManagement,
            'isAllowFilterManagementSecondLine' => $isAllowFilterManagementSecondLine,
            'isAllowFilterTypeManagement' => $isAllowFilterTypeManagement,
            'typesManagement' => $typesManagement,
            'user' => $user
        ));
        return $this->handleView($view);
    }

    protected function trans($id, array $parameters = array(), $domain = 'messages') {
        return $this->get('translator')->trans($id, $parameters, $domain);
    }

    /**
     * Servicio de resultados
     * @return \Pequiven\SEIPBundle\Service\ResultService
     */
    private function getResultService() {
        return $this->container->get('seip.service.result');
    }

    /**
     * Servicio del detalle de las evaluaciones
     * @return \Pequiven\SEIPBundle\Service\User\EvaluationDetailsService
     */
    private function getEvaluationDetailsService() {
        return $this->container->get('seip.service.evaluation_details');
    }

    /**
     * @return \Pequiven\SEIPBundle\Service\PeriodService
     */
    protected function getPeriodService() {
        return $this->container->get('pequiven_seip.service.period');
    }

    /**
     * @return \Pequiven\SEIPBundle\Service\FusionChartExportService
     */
    private function getFusionChartExportService() {
        return $this->container->get('pequiven_seip.service.fusion_chart');
    }

    /**
     * 
     * @return \Pequiven\SEIPBundle\Service\SecurityService
     */
    protected function getSecurityService() {
        return $this->container->get('seip.service.security');
    }

    /**
     * Manejador de usuario o administrador
     * @return \Pequiven\SEIPBundle\Model\UserManager
     */
    private function getUserManager() {
        return $this->get('seip.user_manager');
    }
    
    /**
    * @return \Pequiven\SEIPBundle\Service\Sip\OnePerTenService
    */
    protected function getOnePerTenService()
    {
        return $this->get('seip.service.onePerTen');
    }

}
