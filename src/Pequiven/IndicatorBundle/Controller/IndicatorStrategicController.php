<?php

namespace Pequiven\IndicatorBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Pequiven\IndicatorBundle\Entity\Indicator;
use Pequiven\IndicatorBundle\Entity\IndicatorLevel;
use Pequiven\ArrangementBundle\Entity\ArrangementRange;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController as baseController;

/**
 * Description of IndicatorStrategicController
 *
 * @author matias
 */
class IndicatorStrategicController extends baseController {

    /** Función que retorna la vista con la lista de los indicadores estratégicos
     * @return type
     */
    public function listAction() {
        $this->getSecurityService()->checkSecurity('ROLE_SEIP_INDICATOR_LIST_STRATEGIC');
        
        return $this->render("PequivenIndicatorBundle:Strategic:list.html.twig");
    }

    /**
     * Función que devuelve el paginador con los indicadores estratégicos
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function indicatorListAction(Request $request) {
        $this->getSecurityService()->checkSecurity('ROLE_SEIP_INDICATOR_LIST_STRATEGIC');
        
        $criteria = $request->get('filter', $this->config->getCriteria());
        $sorting = $request->get('sorting', $this->config->getSorting());
        $repository = $this->getRepository();

        $criteria['indicatorLevel'] = IndicatorLevel::LEVEL_ESTRATEGICO;
        $criteria['applyPeriodCriteria'] = true;

        if ($this->config->isPaginated()) {
            $resources = $this->resourceResolver->getResource(
                    $repository, 'createPaginatorStrategic', array($criteria, $sorting)
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
     * Función que registra un indicador estratégico a partir del registro de un objetivo estratégico
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @Template("PequivenIndicatorBundle:Strategic:registerFromObjetive.html.twig")
     * @return type
     * @throws \Pequiven\IndicatorBundle\Controller\Exception
     */
    public function createFromObjetiveAction(Request $request) {

        $form = $this->createForm($this->get('pequiven_indicator.strategicfo.registration.form.type'));

        $lastId = '';

        $em = $this->getDoctrine()->getManager();
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();

        $em->getConnection()->beginTransaction();

        if ($request->isMethod('POST') && $form->submit($request)->isValid()) {
            $object = $form->getData();
            $data = $this->container->get('request')->get("pequiven_indicator_strategicfo_registration");

            $object->setRefParent($data['refObjetive']);
            $object->setSummary($data['description']);
            $object->setTmp(true);
            
            $data['tendency'] = (int)$data['tendency'];            
            $object->setUserCreatedAt($user);

            //Obtenemos y seteamos el nivel del indicador
            $indicatorLevel = $em->getRepository('PequivenIndicatorBundle:IndicatorLevel')->findOneBy(array('level' => IndicatorLevel::LEVEL_ESTRATEGICO));
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

            $lastObjectInsert = $this->get("pequiven.repository.indicator")->findOneBy(array('id' => $lastId));
            $this->createArrangementRange($lastObjectInsert, $data);

            return $this->redirect($this->generateUrl('pequiven_indicator_register_redirect'));
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * Función que registra un indicador estratégico
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @Template("PequivenIndicatorBundle:Strategic:register.html.twig")
     * @return type
     * @throws \Pequiven\IndicatorBundle\Controller\Exception
     */
    public function createAction(Request $request) 
    {
        $this->getPeriodService()->checkIsOpen();
        
        $this->getSecurityService()->checkSecurity('ROLE_SEIP_INDICATOR_CREATE_STRATEGIC');

        $form = $this->createForm($this->get('pequiven_indicator.strategic.registration.form.type'));

        if ($request->isMethod('POST') && $form->submit($request)->isValid()) {
            $lastId = '';

            $em = $this->getDoctrine()->getManager();
            $securityContext = $this->container->get('security.context');
            $user = $securityContext->getToken()->getUser();

            $em->getConnection()->beginTransaction();

            $object = $form->getData();
            $data = $this->container->get('request')->get("pequiven_indicator_strategic_registration");
            $object->setSummary($data['description']);
            $data['tendency'] = (int)$data['tendency'];            
            $object->setUserCreatedAt($user);
            $object->setPeriod($this->getPeriodService()->getPeriodActive());

            //Obtenemos y seteamos el nivel del indicador
            $indicatorLevel = $em->getRepository('PequivenIndicatorBundle:IndicatorLevel')->findOneBy(array('level' => IndicatorLevel::LEVEL_ESTRATEGICO));
            $object->setIndicatorLevel($indicatorLevel);
            
            //Obtenemos y seteamos la refParent del Objetivo Estratégico al que pertenece
            $objetive = $em->getRepository('PequivenObjetiveBundle:Objetive')->findOneBy(array('id' => $data['parents'][0]));
            $object->setRefParent($objetive->getRef());

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
            $this->createArrangementRange($object, $data);

            //Guardamos la relación entre el indicador y el objetivo
            $this->createObjetiveIndicator($object);

            $this->get('session')->getFlashBag()->add('success', $this->trans('action.messages.registerIndicatorStrategicSuccessfull', array(), 'PequivenIndicatorBundle'));

            return $this->redirect($this->generateUrl('pequiven_indicator_menu_list_strategic', array(
                                    )
            ));
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * Función que guarda en la tabla intermedia el indicador creado al objetivo estratégico seleccionado
     * @param \Pequiven\IndicatorBundle\Entity\Indicator $indicator
     * @return boolean
     * @throws \Pequiven\IndicatorBundle\Controller\Exception
     */
    public function createObjetiveIndicator(Indicator $indicator) {

        $em = $this->getDoctrine()->getManager();
        $objetives = $em->getRepository('PequivenObjetiveBundle:Objetive')->findBy(array('ref' => $indicator->getRefParent()));
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
     * Devuelve los Indicadores Estratégicos de acuerdo a la Línea Estratégica que este
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function selectIndicatorStrategicFromRefParentAction(Request $request) {
        $response = new JsonResponse();

        $indicatorsStrategic = array();
        $em = $this->getDoctrine()->getManager();

        $refParentId = $request->request->get('refParentId');
        $indicatorLevelId = IndicatorLevel::LEVEL_ESTRATEGICO;

        $results = $this->get("pequiven.repository.indicator")->findBy(array('refParent' => $refParentId, 'indicatorLevel' => $indicatorLevelId, 'tmp' => true));
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
     * Devuelve la Referencia del Indicador, de acuerdo a la cantidad que ya se encuentren registrados para el objetivo estratégico seleccionado
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function displayRefIndicatorAction(Request $request) {
        $response = new JsonResponse();

        $data = array();
        $objetiveStrategicId = $request->request->get('objetiveStrategicId');
       
        $sequenceGenerator = $this->getSequenceGenerator();
        $indicator = $this->get('pequiven.repository.objetive')->find($objetiveStrategicId);
        $ref = $sequenceGenerator->getNextRefChildIndicatorByObjetive($indicator);
        
        $data[] = array('ref' => $ref);
        $response->setData($data);
        return $response;
    }

    /**
     * Devuelve la Referencia del Indicador, de acuerdo a la cantidad que ya se encuentren registrados para el objetivo estratégico que se esta creando
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function displayRefIndicatorFromObjetiveAction(Request $request) {
        $response = new JsonResponse();

        $data = array();
        $options = array();

        $refParent = $request->request->get('refParentId');
        $options['refParent'] = $refParent;
        $options['type'] = 'STRATEGIC';
        $ref = $this->setNewRef($options);

        $data[] = array('ref' => $ref);
        $response->setData($data);
        return $response;
    }

    /**
     * Función que devuelve la referencia del indicador estratégico que se esta creando
     * @param type $options
     */
    public function setNewRef($options = array()) {

        $results = $this->get('pequiven.repository.indicatorstrategic')->getByOptionRefParent($options);
        $refIndicator = 'IE-' . $options['refParent'];
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
    
    /**
     * 
     * @return \Pequiven\SEIPBundle\Service\SequenceGenerator
     */
    private function getSequenceGenerator() 
    {
        return $this->get('seip.sequence_generator');
    }
}
