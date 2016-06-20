<?php

namespace Pequiven\SEIPBundle\Controller\Planning;

use Pequiven\IndicatorBundle\Entity\Indicator;
use Symfony\Component\HttpFoundation\Request;
use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Pequiven\IndicatorBundle\Entity\IndicatorLevel;
use Pequiven\SEIPBundle\Model\Common\CommonObject;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controlador de los indicadores (Planificacion)
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
class IndicatorController extends ResourceController {

    public function createValueIndicatorFile(Indicator $indicator, Request $request) {
        $valueIndicatorFile = new Indicator\ValueIndicator\ValueIndicatorFile();
        $fileUploaded = false;

        $valuesIndicator = $indicator->getValuesIndicator();
        foreach ($valuesIndicator as $valueIndicator) {
            if ($valueIndicator->getId() == $request->get("valueIndicatorId")) {
                $valueIndicatorFile->setValueIndicator($valueIndicator);
                foreach ($request->files as $file) {
                    //VALIDA QUE EL ARCHIVO SEA UN PDF
                    //SE GUARDAN LOS CAMPOS EN BD
                    $valueIndicatorFile->setCreatedBy($this->getUser());
                    $valueIndicatorFile->setNameFile($file->getClientOriginalName());
                    $valueIndicatorFile->setPath(Indicator\ValueIndicator\ValueIndicatorFile::getUploadDir());
                    $valueIndicatorFile->setExtensionFile($file->guessExtension());

                    //SE MUEVE EL ARCHIVO AL SERVIDOR
                    $file->move($this->container->getParameter("kernel.root_dir") . '/../web/' . Indicator\ValueIndicator\ValueIndicatorFile::getUploadDir(), Indicator\ValueIndicator\ValueIndicatorFile::NAME_FILE . $valueIndicator->getId());
                    $fileUploaded = $file->isValid();
                }
            }
        }

        if (!$fileUploaded) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($valueIndicatorFile);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', $this->trans('action.messages.saveFileSuccess', array(), 'PequivenIndicatorBundle'));
            $request->request->set("uploadFile", "");
            $this->redirect($this->generateUrl("pequiven_indicator_show", array("id" => $indicator->getId())));
        } else {
            $this->get('session')->getFlashBag()->add('error', $this->trans('action.messages.errorFileUpload', array(), 'PequivenIndicatorBundle'));
            $request->request->set("uploadFile", "");
            $this->redirect($this->generateUrl("pequiven_indicator_show", array("id" => $indicator->getId())));
        }
    }

    public function showAction(Request $request) {
        $resource = $this->findOr404($request);
        $uploadFile = $request->get("uploadFile");


        //SI SE SUBIO EL ARCHIVO SE PROCEDE A GUARDARLO
        if ($uploadFile != null) {

            $band = false;
            //VALIDACION QUE SEA UN ARCHIVO PERMITIDO
            foreach ($request->files as $file) {
                if (in_array($file->guessExtension(), \Pequiven\IndicatorBundle\Model\Indicator\ValueIndicatorFile::getTypesFile())) {
                    $band = true;
                }
            }
            if ($band) {
                $this->createValueIndicatorFile($resource, $request);
            } else {
                $this->get('session')->getFlashBag()->add('error', $this->trans('action.messages.InvalidFile', array(), 'PequivenIndicatorBundle'));
                $this->redirect($this->generateUrl("pequiven_indicator_show", array("id" => $request->get("id"))));
            }
        }


        $level = $resource->getIndicatorLevel()->getLevel();

        $rol = null;
        $roleByLevel = array(
            IndicatorLevel::LEVEL_ESTRATEGICO => array('ROLE_SEIP_INDICATOR_VIEW_STRATEGIC', 'ROLE_SEIP_PLANNING_VIEW_INDICATOR_STRATEGIC', 'ROLE_SEIP_SIG_INDICATOR_VIEW'),
            IndicatorLevel::LEVEL_TACTICO => array('ROLE_SEIP_INDICATOR_VIEW_TACTIC', 'ROLE_SEIP_PLANNING_VIEW_INDICATOR_TACTIC', 'ROLE_SEIP_SIG_INDICATOR_VIEW'),
            IndicatorLevel::LEVEL_OPERATIVO => array('ROLE_SEIP_INDICATOR_VIEW_OPERATIVE', 'ROLE_SEIP_PLANNING_VIEW_INDICATOR_OPERATIVE', 'ROLE_SEIP_SIG_INDICATOR_VIEW')
        );

        $roleEditDeleteByLevel = array(
            IndicatorLevel::LEVEL_ESTRATEGICO => array('ROLE_SEIP_INDICATOR_EDIT_STRATEGIC', "ROLE_SEIP_INDICATOR_DELETE_STRATEGIC", "ROLE_SEIP_INDICATOR_APPROVED_STRATEGIC"),
            IndicatorLevel::LEVEL_TACTICO => array('ROLE_SEIP_INDICATOR_EDIT_TACTIC', "ROLE_SEIP_INDICATOR_DELETE_TACTIC", "ROLE_SEIP_INDICATOR_APPROVED_TACTIC"),
            IndicatorLevel::LEVEL_OPERATIVO => array('ROLE_SEIP_INDICATOR_EDIT_OPERATIVE', "ROLE_SEIP_INDICATOR_DELETE_OPERATIVE", "ROLE_SEIP_INDICATOR_APPROVED_OPERATIVE")
        );

        $securityService = $this->getSecurityService();

        $hasPermissionToUpdate = $isAllowToDelete = $hasPermissionToApproved = false;

//        if (!$this->getSecurityService()->isGranted(array('ROLE_SEIP_VIEW_RESULT_BY_LINE_STRATEGIC_SPECIAL'))) {

        if (isset($roleByLevel[$level])) {
            $rol = $roleByLevel[$level];
            $hasPermissionToUpdate = $securityService->isGrantedFull($roleEditDeleteByLevel[$level][0], $resource);
            $isAllowToDelete = $securityService->isGrantedFull($roleEditDeleteByLevel[$level][1], $resource);
        }

        $securityService->checkSecurity($rol);

        if (!$securityService->isGranted($rol[1])) {
            if (!$securityService->isGranted($rol[0])) {
                $securityService->checkSecurity($rol[2], $resource);
            }
//            $securityService->checkSecurity($rol[0], $resource);
        }
//        }

        $errorFormula = null;

        if ($resource->getFormula() !== null) {
            $indicatorService = $this->getIndicatorService();
            $formula = $resource->getFormula();
            $errorFormula = $indicatorService->validateFormula($formula);
        }

        if (!$this->getSecurityService()->isGranted(array('ROLE_SEIP_VIEW_RESULT_BY_LINE_STRATEGIC_SPECIAL'))) {
            $hasPermissionToApproved = $securityService->isGrantedFull($roleEditDeleteByLevel[$level][2], $resource);
        }

        $data = array(
            'dataSource' => array(
                'chart' => array(),
                'colorRange' => array(
                    'color' => array(),
                ),
            ),
        );

        $indicatorService->updateTagIndicator($resource);

        $resultService = $this->getResultService();
        $arrangementRangeService = $this->getArrangementRangeService();
        $indicatorRange = array();
        $errorArrangementRange = null;
        if ($resource->getArrangementRange() !== null) {//En caso de que el indicador tenga un rango de gestión asignado, se procede a evaluar la definición del rango
            $errorArrangementRange = $arrangementRangeService->validateArrangementRange($resource->getArrangementRange(), $resource->getTendency());
            if ($errorArrangementRange == null) {
                $tendency = $resource->getTendency();
                $indicatorRange['good'] = $resultService->calculateRangeGood($resource, $tendency, CommonObject::TYPE_RESULT_ARRANGEMENT);
                $indicatorRange['middle'] = $resultService->calculateRangeMiddle($resource, $tendency, CommonObject::TYPE_RESULT_ARRANGEMENT);
                $indicatorRange['bad'] = $resultService->calculateRangeBad($resource, $tendency, CommonObject::TYPE_RESULT_ARRANGEMENT);
                $data['dataSource']['chart'] = $resultService->getDataChartWidget($resource);
                $color = $arrangementRangeService->getDataColorRangeWidget($resource->getArrangementRange(), $resource->getTendency());
                $data['dataSource']['colorRange']['color'] = $color;
            }
        } else {//En caso de que el indicador no tenga un rango de gestión asignado se setea el mensaje de error
            $errorArrangementRange = $this->trans('pequiven_indicator.errors.arrangementRange_not_assigned', array(), 'PequivenIndicatorBundle');
        }


        $isAllowToDownload = $indicatorService->validFileIndicator($resource);
        $valueIndicatorId = $indicatorService->validFileIndicator($resource, true);


        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('show.html'))
                ->setData(array(
            $this->config->getResourceName() => $resource,
            'errorFormula' => $errorFormula,
            'errorArrangementRange' => $errorArrangementRange,
            'indicatorService' => $indicatorService,
            'data' => $data,
            'indicatorRange' => $indicatorRange,
            'hasPermissionToUpdate' => $hasPermissionToUpdate,
            'isAllowToDelete' => $isAllowToDelete,
            'isAllowToDownload' => $isAllowToDownload,
            'valueIndicatorIdDownload' => $valueIndicatorId,
            'hasPermissionToApproved' => $hasPermissionToApproved
                ))
        ;
        $view->getSerializationContext()->setGroups(array('id', 'api_list', 'valuesIndicator', 'api_details', 'sonata_api_read'));
        return $this->handleView($view);
    }

    /**
     * Vista en modo dashboard del indicador seleccionado
     * @param Request $request
     * @return type
     */
    public function showDashboardAction(Request $request) {
        $resource = $this->findOr404($request);
        $securityService = $this->getSecurityService();
        $indicatorService = $this->getIndicatorService();
        $urlParent = $textParent = '';
        $boxRender = $this->get('tecnocreaciones_box.render');

        //Obtenemos el nivel del indicador
        $level = $resource->getIndicatorLevel()->getLevel();

        $rol = null;
        $roleByLevel = array(
            IndicatorLevel::LEVEL_ESTRATEGICO => array('ROLE_SEIP_INDICATOR_VIEW_STRATEGIC', 'ROLE_SEIP_PLANNING_VIEW_INDICATOR_STRATEGIC'),
            IndicatorLevel::LEVEL_TACTICO => array('ROLE_SEIP_INDICATOR_VIEW_TACTIC', 'ROLE_SEIP_PLANNING_VIEW_INDICATOR_TACTIC'),
            IndicatorLevel::LEVEL_OPERATIVO => array('ROLE_SEIP_INDICATOR_VIEW_OPERATIVE', 'ROLE_SEIP_PLANNING_VIEW_INDICATOR_OPERATIVE')
        );
        if (isset($roleByLevel[$level])) {
            $rol = $roleByLevel[$level];
        }

        if (!$this->getSecurityService()->isGranted(array('ROLE_SEIP_VIEW_RESULT_BY_LINE_STRATEGIC_SPECIAL'))) {
            $securityService->checkSecurity($rol);

            if (!$securityService->isGranted($rol[1])) {
                $securityService->checkSecurity($rol[0], $resource);
            }
        }

        //Sección dónde se define el haeder del showDashboard
        $labelsByLevel = Indicator::getLabelsByLevelIndicator(); //Obtenemos las etiquetas de los indicadores por nivel
        if ($level == IndicatorLevel::LEVEL_ESTRATEGICO) {
            foreach ($resource->getLineStrategics() as $lineStrategic) {
                $urlParent = $this->generateUrl('pequiven_line_strategic_show', array('id' => $lineStrategic->getId()));
                $textParent = $lineStrategic->getDescription();
            }
        } else {
            if ($resource->getParent()) {
                $urlParent = $this->generateUrl('pequiven_indicator_show', array('id' => $resource->getParent()->getId()));
                $textParent = $resource->getParent()->getRef();
            } else {
                $textParent = $this->trans($labelsByLevel[$level], array(), 'PequivenIndicatorBundle');
            }
        }

        //Actualizamos las posibles etiquetas del indicador
        $indicatorService->updateTagIndicator($resource);
        $indicatorService->updateIndicatorChartDetails($resource);

        $resultService = $this->getResultService();
        $arrangementRangeService = $this->getArrangementRangeService();

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('showDashboard.html'))
                ->setData(array(
            $this->config->getResourceName() => $resource,
            'indicatorService' => $indicatorService,
            'urlParent' => $urlParent,
            'boxRender' => $boxRender,
            'textParent' => $textParent,
                ))
        ;
        $view->getSerializationContext()->setGroups(array('id', 'api_list', 'valuesIndicator', 'api_details', 'sonata_api_read'));
        return $this->handleView($view);
    }

    /**
     * Aprueba un indicador
     * 
     * @param Request $request
     * @return type
     */
    public function approvedAction(Request $request) {
        $resource = $this->findOr404($request);

        $securityService = $this->getSecurityService();
        $roleByLevel = array(
            \Pequiven\IndicatorBundle\Model\IndicatorLevel::LEVEL_ESTRATEGICO => 'ROLE_SEIP_INDICATOR_APPROVED_STRATEGIC',
            \Pequiven\IndicatorBundle\Model\IndicatorLevel::LEVEL_TACTICO => 'ROLE_SEIP_INDICATOR_APPROVED_TACTIC',
            \Pequiven\IndicatorBundle\Model\IndicatorLevel::LEVEL_OPERATIVO => 'ROLE_SEIP_INDICATOR_APPROVED_OPERATIVE',
        );

        $level = $resource->getIndicatorLevel()->getLevel();
        if (isset($roleByLevel[$level])) {
            $rol = $roleByLevel[$level];
        }

        $securityService->checkSecurity($rol, $resource);

        $details = $resource->getDetails();
        if ($details === null) {
            $details = new Indicator\IndicatorDetails();
        }
        $details->setApprovalDate(new \DateTime());
        $details->setApprovedBy($this->getUser());
        $resource->setDetails($details);

        $resource->setStatus(\Pequiven\IndicatorBundle\Entity\Indicator::STATUS_APPROVED);

        $this->domainManager->update($resource, 'approved');

        return $this->redirectHandler->redirectTo($resource);
    }

    /**
     * Lista de Indicadores por nivel(Estratégico, Táctico u Operativo)
     * 
     * @param Request $request
     * @return type
     */
    function listAction(Request $request) {
        $level = $request->get('level');


        $rol = null;
        $roleByLevel = array(
            IndicatorLevel::LEVEL_ESTRATEGICO => array('ROLE_SEIP_INDICATOR_VIEW_STRATEGIC', 'ROLE_SEIP_PLANNING_LIST_INDICATOR_STRATEGIC'),
            IndicatorLevel::LEVEL_TACTICO => array('ROLE_SEIP_INDICATOR_VIEW_TACTIC', 'ROLE_SEIP_PLANNING_LIST_INDICATOR_TACTIC'),
            IndicatorLevel::LEVEL_OPERATIVO => array('ROLE_SEIP_INDICATOR_VIEW_OPERATIVE', 'ROLE_SEIP_PLANNING_LIST_INDICATOR_OPERATIVE')
        );
        if (isset($roleByLevel[$level])) {
            $rol = $roleByLevel[$level];
        }

        $this->getSecurityService()->checkSecurity($rol);

        $criteria = $request->get('filter', $this->config->getCriteria());
        $sorting = $request->get('sorting', $this->config->getSorting());
        $repository = $this->getRepository();

        $criteria['indicatorLevel'] = $level;
        $criteria['applyPeriodCriteria'] = true;

        if ($this->config->isPaginated()) {
            $resources = $this->resourceResolver->getResource(
                    $repository, 'createPaginatorByLevel', array($criteria, $sorting)
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
            'level' => $level,
        );
        $apiDataUrl = $this->generateUrl('pequiven_indicator_list', $routeParameters);

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('list.html'))
                ->setTemplateVar($this->config->getPluralResourceName())
        ;
        $view->getSerializationContext()->setGroups(array('id', 'api_list', 'valuesIndicator', 'api_details', 'sonata_api_read', 'formula'));
        if ($request->get('_format') == 'html') {
            $labelsSummary = array();
            foreach (Indicator::getLabelsSummary() as $key => $value) {
                $labelsSummary[] = array(
                    'id' => $key,
                    'description' => $this->trans($value, array(), 'PequivenIndicatorBundle'),
                );
            }

            $data = array(
                'apiDataUrl' => $apiDataUrl,
                $this->config->getPluralResourceName() => $resources,
                'level' => $level,
                'labelsSummary' => $labelsSummary
            );
            $view->setData($data);
        } else {
            $formatData = $request->get('_formatData', 'default');

            $view->setData($resources->toArray('', array(), $formatData));
        }
        return $this->handleView($view);
    }

    /**
     * @Security("is_granted(['ROLE_WORKER_PLANNING','ROLE_SEIP_INDICATOR_ADD_OBSERVATION'])")
     * @param Request $request
     * @return type
     */
    function addObservationAction(Request $request) {
        $resource = $this->findOr404($request);

        $comment = $request->get('observation');
        if ($comment == '') {
            $this->setFlash('error', 'pequiven.error.empty_comment');
            return $this->redirectHandler->redirectTo($resource);
        }

        $observation = new \Pequiven\SEIPBundle\Entity\Observation();
        $observation
                ->setDescription($comment)
                ->setCreatedBy($this->getUser())
        ;
        $resource->addObservation($observation);

        $this->domainManager->dispatchEvent('pre_add_observation', new \Sylius\Bundle\ResourceBundle\Event\ResourceEvent($resource));
        $this->domainManager->update($resource);

        $this->setFlash('success', 'pequiven.indicator.add_observation');

        return $this->redirectHandler->redirectTo($resource);
    }

    /**
     * Lista de Errores en las fichas de Indicadores 
     * 
     * @param Request $request
     * @return type
     */
    function listErrorAction(Request $request) {
        $criteria = $request->get('filter', $this->config->getCriteria());
        $sorting = $request->get('sorting', $this->config->getSorting());
        $repository = $this->getRepository();

        if ($this->config->isPaginated()) {
            $resources = $this->resourceResolver->getResource(
                    $repository, 'createPaginatorForAll', array($criteria, $sorting)
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
        $apiDataUrl = $this->generateUrl('pequiven_indicator_list_error', $routeParameters);

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('listError.html'))
                ->setTemplateVar($this->config->getPluralResourceName())
        ;
        $view->getSerializationContext()->setGroups(array('id', 'api_list', 'api_details', 'sonata_api_read', 'resultIndicator', 'tendency'));
        if ($request->get('_format') == 'html') {
            $labelsSummary = array();
            foreach (Indicator::getLabelsSummary() as $key => $value) {
                $labelsSummary[] = array(
                    'id' => $key,
                    'description' => $this->trans($value, array(), 'PequivenIndicatorBundle'),
                );
            }

            $data = array(
                'apiDataUrl' => $apiDataUrl,
                $this->config->getPluralResourceName() => $resources,
                'labelsSummary' => $labelsSummary
            );
            $view->setData($data);
        } else {
            $formatData = $request->get('_formatData', 'default');

            $view->setData($resources->toArray('', array(), $formatData));
        }
        return $this->handleView($view);
    }

    /**
     * A
     * @param \Pequiven\IndicatorBundle\Entity\Indicator $entity
     * @param type $description
     */
    private function addObservation(\Pequiven\IndicatorBundle\Entity\Indicator $entity, $description) {
        $observation = new \Pequiven\SEIPBundle\Entity\Observation();
        $observation
                ->setDescription($description)
                ->setCreatedBy($this->getUser())
        ;
        $entity->addObservation($observation);
    }

    /**
     * Gerencias de 1ra línea para la tabla de visualización del menú de planificación
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function selectGerenciaFirstAction(Request $request) {
        $response = new JsonResponse();

        $dataGerencia = array();
        $em = $this->getDoctrine()->getManager();
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();

        $results = $this->get('pequiven.repository.gerenciafirst')->getGerenciaOptions();

        $totalResults = count($results);
        if (is_array($results) && $totalResults > 0) {
            foreach ($results as $result) {
                foreach ($result as $gerencia) {
                    $dataGerencia[] = array(
                        'idComplejo' => $gerencia->getComplejo()->getId(),
                        'optGroup' => $gerencia->getComplejo()->getDescription(),
                        'id' => $gerencia->getId(),
                        'description' => $gerencia->getDescription()
                    );
                }
            }
        } else {
            $dataGerencia[] = array("empty" => true);
        }

        $response->setData($dataGerencia);

        return $response;
    }

    /**
     * Función que devuelve la(s) gerencias de 2da línea asociada a las gerencias de 1ra línea cargadas de acuerdo al objetivo táctico seleccionado
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function selectGerenciaSecondListAction(Request $request) {
        $response = new JsonResponse();
        $gerenciaSecondChildren = array();
        $em = $this->getDoctrine()->getManager();
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();

        $gerencia = $request->request->get('gerencia');

        $results = $this->get('pequiven.repository.gerenciasecond')->findByGerenciaFirst(array('gerencia' => $gerencia));

        foreach ($results as $result) {
            $complejo = $result->getGerencia()->getComplejo();
            $gerencia = $result->getGerencia();
            $gerenciaSecondChildren[] = array(
                'idGroup' => $complejo->getId() . '-' . $gerencia->getId(),
                'optGroup' => $complejo->getRef() . '-' . $gerencia->getDescription(),
                'id' => $result->getId(),
                'description' => $result->getDescription()
            );
        }

        $response->setData($gerenciaSecondChildren);

        return $response;
    }

    /**
     * 
     * @param Request $request
     * @return type
     */
    public function getIsGrantEditButtonAction(Request $request) {

        $id = $request->get('id');
        $index = $request->get('index');

        $indicatorService = $this->getIndicatorService();

        $indicator = $this->get('pequiven.repository.indicator')->find($id); //Obtenemos el indicador

        $rs = $indicatorService->isGrantToEdit($indicator, $index);
        
        $response = new JsonResponse();
        $data = array();
        $data["data"] = $rs;
        $response->setData($data);
        return $response;
        
//        var_dump($rs);die();
//
//        return $rs;
    }

    /**
     * Elimina todos los valores cargados en un indicador
     * @param Request $request
     * @return type
     */
    public function removeValuesAction(Request $request) {
        $resource = $this->findOr404($request);
        $indicatorService = $indicatorService = $this->getIndicatorService();

        $em = $this->getDoctrine()->getManager();
        $freq = $resource->getFrequencyNotificationIndicator()->getDays();
        $cantResultados = $freq / 360;

        $cont = 0;
        $flag = false;
        foreach ($resource->getValuesIndicator() as $valueIndicator) {
            $cont++;
            if ($flag == false) {
                $registro = $indicatorService->isGrantToEdit($resource, $cont);
                if ($registro) {
                    $flag = true;
                    $em->remove($valueIndicator);
                }
            } else {
                $em->remove($valueIndicator);
            }
        }
        $em->flush();

        return $this->redirectHandler->redirectTo($resource);
    }

    public function vizualiceFileAction(Request $request) {
        $securityService = $this->getSecurityService();
        if ($securityService->isGranted(array("ROLE_SEIP_PLANNING_INDICATOR_SHOW_FILE"))) {
            $path = Indicator\ValueIndicator\ValueIndicatorFile::LOCATION_UPLOAD_FILE;
            $name = Indicator\ValueIndicator\ValueIndicatorFile::NAME_FILE;
            $ruta = $this->container->getParameter("kernel.root_dir") . '/../web/' . $path . "/" . $name . $request->get("id");

            header('Content-type: application/pdf');
            readfile($ruta);
        } else {
            $em = $this->getDoctrine();
            $entity = $em->getRepository("\Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator")->find($request->get("id"));
            $securityService->checkSecurity('ROLE_SEIP_PLANNING_INDICATOR_SHOW_FILE', $entity);
        }
    }

    public function deleteAction(Request $request) {
        $redirectUrl = $request->get("redirectUrl");

        $resource = $this->findOr404($request);
        $this->domainManager->delete($resource);

        return $this->redirectHandler->redirect($redirectUrl);
    }

    public function generateUrlFile(Request $request) {

        $response = new JsonResponse();
        $data = array();
        $data["url"] = $this->generateUrl("pequiven_indicator_vizualice_file", array("id" => $request->get("id")));
        $response->setData($data);
        return $response;
    }

    public function showButtonDownload(Request $request) {
        $em = $this->getDoctrine();
        $valueIndicator = $em->getRepository("\Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator")->find($request->get("id"));

        $archivo = $valueIndicator->getValueIndicatorFile();
        $flag = true;
        
        if ($archivo) {
            $flag = true;
        } else {
            $flag = false;
        }
        
        $response = new JsonResponse();
        $data = array();
        $data["data"] = $flag;
        $response->setData($data);
        return $response;
        
    }

    /**
     * 
     * @return \Pequiven\SEIPBundle\Service\SecurityService
     */
    protected function getSecurityService() {
        return $this->container->get('seip.service.security');
    }

    /**
     * 
     * @return \Pequiven\ArrangementBundle\Service\ArrangementRangeService
     */
    protected function getArrangementRangeService() {
        return $this->container->get('pequiven_arrangement.service.arrangementrange');
    }

    /**
     * 
     * @return \Pequiven\SEIPBundle\Service\ResultService
     */
    protected function getResultService() {
        return $this->container->get('seip.service.result');
    }

    /**
     * 
     * @return \Pequiven\IndicatorBundle\Service\IndicatorService
     */
    protected function getIndicatorService() {
        return $this->container->get('pequiven_indicator.service.inidicator');
    }

    public function loadFileAction(Request $request) {
        $indicatorId = $request->get("id");
        $indicator = $this->container->get('pequiven.repository.indicator')->findOneBy(array("id" => $indicatorId));

        $indicatorFile = new \Pequiven\IndicatorBundle\Entity\Indicator\IndicatorFile();
        $fileUploaded = false;

        foreach ($request->files as $file) {

            $indicatorFile->setCreatedBy($this->getUser());
            $indicatorFile->setNameFile(base64_encode($file->getClientOriginalName()));
            $indicatorFile->setNameFileOriginal($file->getClientOriginalName());
            $indicatorFile->setPath(\Pequiven\IndicatorBundle\Model\Indicator\IndicatorFile::getUploadDir());
            $indicatorFile->setExtensionFile($file->guessExtension());

            //SE MUEVE EL ARCHIVO AL SERVIDOR
            $file->move($this->container->getParameter("kernel.root_dir") . '/../web/' . \Pequiven\IndicatorBundle\Model\Indicator\IndicatorFile::getUploadDir(), base64_encode($file->getClientOriginalName()));
            $fileUploaded = $file->isValid();
        }


        if (!$fileUploaded) {
            $em = $this->getDoctrine()->getEntityManager();
            $indicatorFile->setIndicator($indicator);
            $em->persist($indicatorFile);
            $em->flush();

//            $this->get('session')->getFlashBag()->add('success', $this->trans('action.messages.saveFileSuccess', array(), 'PequivenIndicatorBundle'));
//            $request->request->set("uploadFile", "");
//            $this->redirect($this->generateUrl("pequiven_indicator_show", array("id" => $indicator->getId())));

            $this->get('session')->getFlashBag()->add('success', $this->trans('action.messages.saveFileSuccess', array(), 'PequivenIndicatorBundle'));
            //$request->request->set("fileIndicator", "");
            //$this->redirect($this->generateUrl("pequiven_indicator_show", array("id" => $indicator->getId())));
        } else {
            $this->get('session')->getFlashBag()->add('error', $this->trans('action.messages.errorFileUpload', array(), 'PequivenIndicatorBundle'));
            //$request->request->set("fileIndicator", "");
            //$this->redirect($this->generateUrl("pequiven_indicator_show", array("id" => $indicator->getId())));
        }

        //$this->showAction($request);
        return $this->redirect($this->generateUrl("pequiven_indicator_show", array("id" => $indicator->getId())));
    }

//    public function getIndicatorPnrAction() {
//        $cond = array(
//            "period"=>"2",
//            "calculationMethod"=>"0",
//            "typeOfResultSection"=>"3"
//        );
//        $indicators = $this->get('pequiven.repository.indicator')->findBy($cond);
//        
//        foreach ($indicators as $ind) {
//            print($ind->getRef()."<br>");
//            print($ind->getFormula());
//            $indValues = $ind->getValuesIndicator();
//            $productReport = $ind->getValueIndicatorConfig();
//            var_dump($productReport->getId());
//            foreach ($indValues as $indValue) {
//                print_r($indValue->getFormulaParameters());
//                print("<br>");
//            }
//            
//            print("<br>");
//            print("<br>");
//            die();
//        }
//        
//        die();
//    }
}
