<?php

namespace Pequiven\IndicatorBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Pequiven\IndicatorBundle\Entity\Indicator;
use Pequiven\IndicatorBundle\Entity\IndicatorLevel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Pequiven\ArrangementBundle\Entity\ArrangementRange;
use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController as baseController;

/**
 * Description of IndicatorOperativeController
 *
 * @author matias
 */
class IndicatorOperativeController extends baseController {
    /**
     * @return type
     */
    public function listAction() {
        $this->getSecurityService()->checkSecurity('ROLE_SEIP_INDICATOR_LIST_OPERATIVE');
        
        return $this->render("PequivenIndicatorBundle:Operative:list.html.twig");
    }

    /**
     * Función que devuelve el paginador con los indicadores operativos
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function indicatorListAction(Request $request) {
        $this->getSecurityService()->checkSecurity('ROLE_SEIP_INDICATOR_LIST_OPERATIVE');
        
        $criteria = $request->get('filter', $this->config->getCriteria());
        $sorting = $request->get('sorting', $this->config->getSorting());
        $repository = $this->getRepository();

        $criteria['indicatorLevel'] = IndicatorLevel::LEVEL_OPERATIVO;
        $criteria['applyPeriodCriteria'] = true;
        $criteria['gerencia'] = $request->get('gerencia');

        if ($this->config->isPaginated()) {
            $resources = $this->resourceResolver->getResource(
                    $repository, 'createPaginatorOperative', array($criteria, $sorting)
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
        $view->getSerializationContext()->setGroups(array('id','api_list','indicators','formula'));
        if ($request->get('_format') == 'html') {
            $view->setData($resources);
        } else {
            $formatData = $request->get('_formatData', 'default');

            $view->setData($resources->toArray('', array(), $formatData));
        }
        return $this->handleView($view);
    }

    /**
     * Función que registra un indicador operativo
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @Template("PequivenIndicatorBundle:Operative:register.html.twig")
     * @return type
     * @throws \Pequiven\IndicatorBundle\Controller\Exception
     */
    public function createAction(Request $request) 
    {
        $this->getPeriodService()->checkIsOpen();
        
        $this->getSecurityService()->checkSecurity('ROLE_SEIP_INDICATOR_CREATE_OPERATIVE');
        
        $periodService = $this->get('pequiven_seip.service.period');
        $period = $periodService->getPeriodActive();
        $form = $this->createForm($this->get('pequiven_indicator.operative.registration.form.type'));

        $lastId = '';

        $em = $this->getDoctrine()->getManager();
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();
        $role = $user->getRoles();
        $refParent = '';

        $em->getConnection()->beginTransaction();

        if ($request->isMethod('POST') && $form->submit($request)->isValid()) {
            $object = $form->getData();
            $data = $this->container->get('request')->get("pequiven_indicator_operative_registration");
            $object->setSummary($data['description']);

            if(strlen($data['gerenciaSecond']) == 0){
                $em->getConnection()->rollback();
                $this->get('session')->getFlashBag()->add('success', 'error falta gerencia 2da línea');
            }

            $objetive = $em->getRepository('PequivenObjetiveBundle:Objetive')->findOneBy(array('id' => $data['parentOperative'],'period'=>$period));
            $object->setRefParent($objetive->getRef());
            $refIndicator = $data['ref'];
            $object->setPeriod($period);

            $data['tendency'] = (int)$data['tendency'];
            $object->setWeight(bcadd(str_replace(',', '.', $data['weight']), '0', 2));
            $object->setUserCreatedAt($user);

            //Obtenemos y seteamos el nivel del indicador
            $indicatorLevel = $em->getRepository('PequivenIndicatorBundle:IndicatorLevel')->findOneBy(array('level' => IndicatorLevel::LEVEL_OPERATIVO));
            $object->setIndicatorLevel($indicatorLevel);

            //En caso de que el Indicador tenga Fórmula se obtiene y se setea respectivamente
            if (isset($data['formula'])) {
                $formula = $em->getRepository('PequivenMasterBundle:Formula')->findOneBy(array('id' => $data['formula']));
                $object->setFormula($formula);
            }

            $em->persist($object);

            try {
                $em->flush();
                $lastId = $em->getConnection()->lastInsertId();
                $em->getConnection()->commit();
            } catch (Exception $e) {
                $em->getConnection()->rollback();
                throw $e;
            }

            //Obtenemos el último indicador guardado y le añadimos el rango de gestión o semáforo
            $lastObjectInsert = $this->get("pequiven.repository.indicator")->findOneBy(array('ref' => $refIndicator,'period' => $period->getId(),'refParent' => $objetive->getRef()));
            $this->createArrangementRange($lastObjectInsert, $data);

            //Guardamos la relación entre el indicador y el objetivo
            $this->createObjetiveIndicator($lastObjectInsert);

            $this->get('session')->getFlashBag()->add('success', $this->trans('action.messages.registerIndicatorOperativeSuccessfull', array(), 'PequivenIndicatorBundle'));

            return $this->redirect($this->generateUrl('pequiven_indicator_menu_list_operative', array(
                                    )
            ));
        }

        return array(
            'form' => $form->createView(),
            'role_name' => $role[0]
        );
    }

    /**
     * Función que llama el formulario de registro de un indicador operativo a partir del registro de un objetivo operativo
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @Template("PequivenIndicatorBundle:Operative:registerFromObjetive.html.twig")
     * @return type
     * @throws \Pequiven\IndicatorBundle\Controller\Exception
     */
    public function createFromObjetiveAction(Request $request) {

        $form = $this->createForm($this->get('pequiven_indicator.operativefo.registration.form.type'));

        $lastId = '';

        $em = $this->getDoctrine()->getManager();
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();

        $em->getConnection()->beginTransaction();

        if ($request->isMethod('POST') && $form->submit($request)->isValid()) {
            $object = $form->getData();
            $data = $this->container->get('request')->get("pequiven_indicator_operativefo_registration");

            $object->setRefParent($data['refObjetive']);
            $object->setTmp(true);
            $data['tendency'] = (int)$data['tendency'];
            $object->setWeight(bcadd(str_replace(',', '.', $data['weight']), '0', 2));
            $object->setUserCreatedAt($user);

            //Obtenemos y seteamos el nivel del indicador
            $indicatorLevel = $em->getRepository('PequivenIndicatorBundle:IndicatorLevel')->findOneBy(array('level' => IndicatorLevel::LEVEL_OPERATIVO));
            $object->setIndicatorLevel($indicatorLevel);

            //En caso de que el Indicador tenga Fórmula se obtiene y se setea respectivamente
            if (isset($data['formula'])) {
                $formula = $em->getRepository('PequivenMasterBundle:Formula')->findOneBy(array('id' => $data['formula']));
                $object->setFormula($formula);
            }

            $em->persist($object);

            try {
                $em->flush();
                $lastId = $em->getConnection()->lastInsertId();
                $em->getConnection()->commit();
            } catch (Exception $e) {
                $em->getConnection()->rollback();
                throw $e;
            }

            //Obtenemos el último indicador guardado y le añadimos el rango de gestión o semáforo
            $lastObjectInsert = $this->get("pequiven.repository.indicator")->findOneBy(array('id' => $lastId));
            $this->createArrangementRange($lastObjectInsert, $data);

            return $this->redirect($this->generateUrl('pequiven_indicator_register_redirect'));
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * 
     * @param \Pequiven\IndicatorBundle\Entity\Indicator $indicator
     * @param type $data
     * @return boolean
     * @throws \Pequiven\IndicatorBundle\Controller\Exception
     */
    public function createArrangementRange(Indicator $indicator, $data = array()) {
        $arrangementRange = new ArrangementRange();
        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();

        $arrangementRange->setIndicator($indicator);
        $arrangementRange->setPeriod($this->getPeriodService()->getPeriodActive());

        //Seteamos los valores de rango alto
        $arrangementRange->setTypeRangeTop($em->getRepository('PequivenMasterBundle:ArrangementRangeType')->findOneBy(array('id' => $data['arrangementRangeTypeTop'])));
        if ($data['typeArrangementRangeTypeTop'] == 'TOP_BASIC') {
            $arrangementRange->setRankTopBasic(bcadd(str_replace(',', '.', $data['rankTopBasic']), '0', 3));
            $arrangementRange->setOpRankTopBasic($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankTopBasic'])));
        } else if ($data['typeArrangementRangeTypeTop'] == 'TOP_MIXED') {
            $arrangementRange->setRankTopMixedTop(bcadd(str_replace(',', '.', $data['rankTopMixedTop']), '0', 3));
            $arrangementRange->setOpRankTopMixedTop($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankTopMixedTop'])));
            $arrangementRange->setRankTopMixedBottom(bcadd(str_replace(',', '.', $data['rankTopMixedBottom']), '0', 3));
            $arrangementRange->setOpRankTopMixedBottom($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankTopMixedBottom'])));
        }

        //Seteamos los valores de rango medio alto
        $arrangementRange->setTypeRangeMiddleTop($em->getRepository('PequivenMasterBundle:ArrangementRangeType')->findOneBy(array('id' => $data['arrangementRangeTypeMiddleTop'])));
        if ($data['typeArrangementRangeTypeMiddleTop'] == 'MIDDLE_TOP_BASIC') {
            $arrangementRange->setRankMiddleTopBasic(bcadd(str_replace(',', '.', $data['rankMiddleTopBasic']), '0', 3));
            $arrangementRange->setOpRankMiddleTopBasic($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankMiddleTopBasic'])));
        } else if ($data['typeArrangementRangeTypeMiddleTop'] == 'MIDDLE_TOP_MIXED') {
            $arrangementRange->setRankMiddleTopMixedTop(bcadd(str_replace(',', '.', $data['rankMiddleTopMixedTop']), '0', 3));
            $arrangementRange->setOpRankMiddleTopMixedTop($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankMiddleTopMixedTop'])));
            $arrangementRange->setRankMiddleTopMixedBottom(bcadd(str_replace(',', '.', $data['rankMiddleTopMixedBottom']), '0', 3));
            $arrangementRange->setOpRankMiddleTopMixedBottom($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankMiddleTopMixedBottom'])));
        }

        //Seteamos los valores de rango medio bajo
        $arrangementRange->setTypeRangeMiddleBottom($em->getRepository('PequivenMasterBundle:ArrangementRangeType')->findOneBy(array('id' => $data['arrangementRangeTypeMiddleBottom'])));
        if ($data['typeArrangementRangeTypeMiddleBottom'] == 'MIDDLE_BOTTOM_BASIC') {
            $arrangementRange->setRankMiddleBottomBasic(bcadd(str_replace(',', '.', $data['rankMiddleBottomBasic']), '0', 3));
            $arrangementRange->setOpRankMiddleBottomBasic($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankMiddleBottomBasic'])));
        } else if ($data['typeArrangementRangeTypeMiddleBottom'] == 'MIDDLE_BOTTOM_MIXED') {
            $arrangementRange->setRankMiddleBottomMixedTop(bcadd(str_replace(',', '.', $data['rankMiddleBottomMixedTop']), '0', 3));
            $arrangementRange->setOpRankMiddleBottomMixedTop($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankMiddleBottomMixedTop'])));
            $arrangementRange->setRankMiddleBottomMixedBottom(bcadd(str_replace(',', '.', $data['rankMiddleBottomMixedBottom']), '0', 3));
            $arrangementRange->setOpRankMiddleBottomMixedBottom($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankMiddleBottomMixedBottom'])));
        }

        //Seteamos los valores de rango bajo
        $arrangementRange->setTypeRangeBottom($em->getRepository('PequivenMasterBundle:ArrangementRangeType')->findOneBy(array('id' => $data['arrangementRangeTypeBottom'])));
        if ($data['typeArrangementRangeTypeBottom'] == 'BOTTOM_BASIC') {
            $arrangementRange->setRankBottomBasic(bcadd(str_replace(',', '.', $data['rankBottomBasic']), '0', 3));
            $arrangementRange->setOpRankBottomBasic($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankBottomBasic'])));
        } else if ($data['typeArrangementRangeTypeBottom'] == 'BOTTOM_MIXED') {
            if($data['tendency'] < 3){//Comportamiento No Estable
                $arrangementRange->setRankBottomMixedTop(bcadd(str_replace(',', '.', $data['rankBottomMixedTop']), '0', 3));
                $arrangementRange->setOpRankBottomMixedTop($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankBottomMixedTop'])));
                $arrangementRange->setRankBottomMixedBottom(bcadd(str_replace(',', '.', $data['rankBottomMixedBottom']), '0', 3));
                $arrangementRange->setOpRankBottomMixedBottom($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankBottomMixedBottom'])));
            } else{ //Comportamiento Estable
                //Rango Bajo-Alto
                $arrangementRange->setRankBottomMixedTop(bcadd(str_replace(',', '.', $data['rankBottomTopBasic']), '0', 3));
                $arrangementRange->setOpRankBottomMixedTop($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankBottomTopBasic'])));
                //Rango Bajo-Bajo
                $arrangementRange->setRankBottomMixedBottom(bcadd(str_replace(',', '.', $data['rankBottomBottomBasic']), '0', 3));
                $arrangementRange->setOpRankBottomMixedBottom($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankBottomBottomBasic'])));
            }
        }

        $em->persist($arrangementRange);

        try {
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            throw $e;
        }

        return true;
    }

    /**
     * Función que guarda en la tabla intermedia el indicador creado al objetivo operativo seleccionado
     * @param \Pequiven\IndicatorBundle\Entity\Indicator $indicator
     * @return boolean
     * @throws \Pequiven\IndicatorBundle\Controller\Exception
     */
    public function createObjetiveIndicator(Indicator $indicator) {

        $em = $this->getDoctrine()->getManager();
        $objetives = $em->getRepository('PequivenObjetiveBundle:Objetive')->findBy(array('ref' => $indicator->getRefParent(),'period' => $indicator->getPeriod()->getId()));
        $totalObjetives = count($objetives);
        $em->getConnection()->beginTransaction();
        if ($totalObjetives > 0) {
            foreach ($objetives as $objetive) {
                $objetive->addIndicator($indicator);
                $em->persist($objetive);
            }
        }

        try {
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            throw $e;
        }

        return true;
    }

    /**
     * Devuelve los Indicadores Operativos de acuerdo a la Línea Estratégica que este
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function selectIndicatorOperativeFromRefParentAction(Request $request) {
        $response = new JsonResponse();

        $indicatorsStrategic = array();
        $em = $this->getDoctrine()->getManager();
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();

        $refParentId = $request->request->get('refParentId');
        $indicatorLevelId = IndicatorLevel::LEVEL_OPERATIVO;

        $results = $this->get("pequiven.repository.indicator")->findBy(array('refParent' => $refParentId, 'indicatorLevel' => $indicatorLevelId, 'tmp' => true, 'userCreatedAt' => $user));
        $totalResults = count($results);

        if (is_array($results) && $totalResults > 0) {
            foreach ($results as $result) {
                $indicatorsStrategic[] = array("id" => $result->getId(), "description" => $result->getRef() . ' ' . $result->getDescription());
            }
        } else {
            $indicatorsStrategic[] = array("empty" => true);
        }

        $response->setData($indicatorsStrategic);

        return $response;
    }

    /**
     * Función que devuelve la(s) gerencias de 2da línea asociadas a la gerencia de 1ra línea seleccionada
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function selectGerenciaSecondAction(Request $request) {
        $response = new JsonResponse();
        $gerenciaSecondChildren = array();
        $em = $this->getDoctrine()->getManager();
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();

        if ($securityContext->isGranted(array('ROLE_DIRECTIVE', 'ROLE_DIRECTIVE_AUX','ROLE_WORKER_PLANNING'))) {
            $gerencia = $request->request->get('gerencia');
            $results = $this->get('pequiven.repository.gerenciasecond')->findBy(array('enabled' => true, 'gerencia' => $gerencia));
        } elseif ($securityContext->isGranted(array('ROLE_MANAGER_FIRST', 'ROLE_MANAGER_FIRST_AUX'))) {
            $objetiveTacticId = $request->request->get('objetiveTacticId');
            $results = $this->get('pequiven.repository.gerenciasecond')->findBy(array('enabled' => true, 'gerencia' => $em->getRepository('PequivenObjetiveBundle:Objetive')->findOneBy(array('id' => $objetiveTacticId))->getGerencia()->getId()));
        } else {
            $objetiveTacticId = $request->request->get('objetiveTacticId');
            $results = $this->get('pequiven.repository.gerenciasecond')->findBy(array('enabled' => true, 'complejo' => $em->getRepository('PequivenObjetiveBundle:Objetive')->findOneBy(array('id' => $objetiveTacticId))->getGerencia()->getComplejo()->getId(), 'modular' => true));
        }

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
     * Devuelve los Objetivos Tácticos de acuerdo al Objetivo Estratégico seleccionado
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function selectObjetiveTacticFromObjetiveStrategicAction(Request $request) {
        $response = new JsonResponse();
        $objetiveChildrenTactic = array();

        $objetiveStrategicId = explode(',', $request->request->get('objetiveStrategicId'));

        if (is_array($objetiveStrategicId)) {
            $results = $this->get('pequiven.repository.objetiveoperative')->getByParent($objetiveStrategicId,array('enabled' => true,'fromIndicator' => true));

            $totalResults = count($results);
            if (is_array($results) && $totalResults > 0) {
                foreach ($results as $result) {
                    $objetiveChildrenTactic[] = array("id" => $result->getId(), "description" => $result->getRef() . ' ' . $result->getDescription());
                }
            } else {
                $objetiveChildrenTactic[] = array("empty" => true);
            }
        } else {
            $objetiveChildrenTactic[] = array("empty" => true, "initial" => true);
        }

        $response->setData($objetiveChildrenTactic);

        return $response;
    }

    /**
     * Devuelve los objetivos operativos de acuerdo a el objetivo táctico y la gerencia de 2da línea seleccionada
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function selectObjetiveOperativeAction(Request $request) {
        $response = new JsonResponse();
        $objetiveChildrenOperative = array();
        $em = $this->getDoctrine()->getManager();
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();

        $objetiveTacticId = explode(',', $request->request->get('objetiveTacticId'));
        $gerenciaSecondId = $securityContext->isGranted(array('ROLE_MANAGER_SECOND', 'ROLE_MANAGER_SECOND_AUX')) ? $user->getGerenciaSecond()->getId() : $request->request->get('gerenciaSecondId');

        if (is_array($objetiveTacticId) && is_numeric($gerenciaSecondId)) {
            $results = $this->get('pequiven.repository.objetiveoperative')->getByParent($objetiveTacticId, array('fromIndicator' => true, 'gerenciaSecondId' => $gerenciaSecondId,'enabled' => true));

            $totalResults = count($results);
            if (is_array($results) && $totalResults > 0) {
                foreach ($results as $result) {
                    $objetiveChildrenOperative[] = array("id" => $result->getId(), "description" => $result->getRef() . ' ' . $result->getDescription());
                }
            } else {
                $objetiveChildrenOperative[] = array("empty" => true);
            }
        } else {
            $objetiveChildrenOperative[] = array("empty" => true, "initial" => true);
        }

        $response->setData($objetiveChildrenOperative);

        return $response;
    }

    /**
     * Devuelve la Referencia del Indicador, de acuerdo a la cantidad que ya se encuentren registrados para el objetivo operativo seleccionado
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function displayRefIndicatorAction(Request $request) {
        $response = new JsonResponse();

        $data = array();
        $options = array();
        $em = $this->getDoctrine()->getManager();

        $objetiveOperativeId = $request->request->get('objetiveOperativeId');
        $options['refParent'] = $em->getRepository('PequivenObjetiveBundle:Objetive')->findOneBy(array('id' => $objetiveOperativeId))->getRef();
        $options['type'] = 'OPERATIVE';
        $options['idObjetive'] = $objetiveOperativeId;
        $ref = $this->setNewRef($options);

        $data[] = array('ref' => $ref);
        $response->setData($data);
        return $response;
    }

    /**
     * Devuelve la Referencia del Indicador, de acuerdo a la cantidad que ya se encuentren registrados para el objetivo operativo que se esta creando
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function displayRefIndicatorFromObjetiveAction(Request $request) {
        $response = new JsonResponse();

        $data = array();
        $options = array();

        $refParent = $request->request->get('refParentId');
        $options['refParent'] = $refParent;
        $options['type'] = 'OPERATIVE';
        $ref = $this->setNewRef($options);

        $data[] = array('ref' => $ref);
        $response->setData($data);
        return $response;
    }

    /**
     * Función que devuelve la referencia del indicador operativo que se esta creando
     * @param type $options
     */
    public function setNewRef($options = array()) {
        $em = $this->getDoctrine()->getManager();
        $em->getFilters()->disable('softdeleteable');
//        $results = $this->get('pequiven.repository.indicatortactic')->getByOptionRefParent($options);
        $results = $this->get('pequiven.repository.indicatortactic')->getByParent($options);
        $em->getFilters()->enable('softdeleteable');
        $refIndicator = 'IO-' . $options['refParent'];
        $total = count($results);
        if (is_array($results) && $total > 0) {
            $ref = $refIndicator . ($total + 1) . '.';
        } else {
            $ref = $refIndicator . '1.';
        }

        return $ref;
    }

    /**
     * @return \Pequiven\SEIPBundle\Service\PeriodService
     */
    protected function getPeriodService()
    {
        return $this->container->get('pequiven_seip.service.period');
    }
    
    /**
     * 
     * @return \Pequiven\SEIPBundle\Service\SecurityService
     */
    protected function getSecurityService()
    {
        return $this->container->get('seip.service.security');
    }
}
