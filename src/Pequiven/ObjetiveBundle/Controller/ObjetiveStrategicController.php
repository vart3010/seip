<?php

namespace Pequiven\ObjetiveBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Pequiven\ObjetiveBundle\Entity\ObjetiveLevel;
use Pequiven\ArrangementBundle\Entity\ArrangementRange;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController as baseController;
use Pequiven\ObjetiveBundle\Entity\Objetive;
use Pequiven\MasterBundle\Entity\Rol;

/**
 * Description of ObjetiveStrategicController
 *
 * @author matias
 */
class ObjetiveStrategicController extends baseController {

    /**
     * Función que retorna la vista con la lista de los objetivos estratégicos
     * @return type
     */
    public function listAction() {
        $this->getSecurityService()->checkSecurity('ROLE_SEIP_OBJECTIVE_LIST_STRATEGIC');

        return $this->render("PequivenObjetiveBundle:Strategic:list.html.twig");
    }

    /**
     * Finds and displays a Objetive entity of level Strategic by Id.
     *
     * @Template("PequivenObjetiveBundle:Strategic:show.html.twig")
     */
    public function showAction(Request $request) {
        $securityService = $this->getSecurityService();
        $securityService->checkSecurity(array('ROLE_SEIP_OBJECTIVE_VIEW_STRATEGIC', 'ROLE_SEIP_PLANNING_VIEW_OBJECTIVE_STRATEGIC'));

        $id = $request->get("id");
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PequivenObjetiveBundle:Objetive')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Objetive entity.');
        }
        if (!$securityService->isGranted('ROLE_SEIP_PLANNING_VIEW_OBJECTIVE_STRATEGIC')) {
            $securityService->checkSecurity('ROLE_SEIP_OBJECTIVE_VIEW_STRATEGIC', $entity);
        }

        $indicatorService = $this->getIndicatorService();
        $hasPermissionToApproved = $securityService->isGrantedFull("ROLE_SEIP_OBJECTIVE_APPROVED_STRATEGIC", $entity);
        $hasPermissionToUpdate = $securityService->isGrantedFull("ROLE_SEIP_OBJECTIVE_EDIT_STRATEGIC", $entity);
        $isAllowToDelete = $securityService->isGrantedFull("ROLE_SEIP_OBJECTIVE_DELETE_STRATEGIC", $entity);

        return array(
            'entity' => $entity,
            'indicatorService' => $indicatorService,
            'hasPermissionToUpdate' => $hasPermissionToUpdate,
            'isAllowToDelete' => $isAllowToDelete,
            'hasPermissionToApproved' => $hasPermissionToApproved,
        );
    }

    /**
     * FUNCION QUE EXPORTA LA FICHA DEL OBJETIVO A PDF
     * @param Request $request
     * @return type
     * @throws type
     */
    public function exportAction(Request $request) {
        $id = $request->get("id");
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PequivenObjetiveBundle:Objetive')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Objetive entity.');
        }

        $indicatorService = $this->getIndicatorService();

        $data=array(
            'entity' => $entity,
            'indicatorService' => $indicatorService,
        );

        $this->generatePdf($data, 'Ficha de Objetivo Estratégico', 'PequivenObjetiveBundle:Strategic:viewPdf.html.twig');
    }

    /**
     * Función que devuelve el paginador con los objetivos estratégicos
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function objetiveListAction(Request $request) {
        $this->getSecurityService()->checkSecurity('ROLE_SEIP_OBJECTIVE_LIST_STRATEGIC');

        $criteria = $request->get('filter', $this->config->getCriteria());
        $sorting = $request->get('sorting', $this->config->getSorting());
        $repository = $this->getRepository();

        $criteria['objetiveLevel'] = ObjetiveLevel::LEVEL_ESTRATEGICO;
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

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('list.html'))
                ->setTemplateVar($this->config->getPluralResourceName())
        ;
        $view->getSerializationContext()->setGroups(array('id', 'api_list', 'indicators', 'formula'));
        if ($request->get('_format') == 'html') {
            $view->setData($resources);
        } else {
            $formatData = $request->get('_formatData', 'default');

            $view->setData($resources->toArray('', array(), $formatData));
        }
        return $this->handleView($view);
    }

    /**
     * Función que registra un objetivo estratégico
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @Template("PequivenObjetiveBundle:Strategic:register.html.twig")
     * @return type
     * @throws \Pequiven\ObjetiveBundle\Controller\Exception
     */
    public function createAction(Request $request) {
        $this->getPeriodService()->checkIsOpen();

        $this->getSecurityService()->checkSecurity('ROLE_SEIP_OBJECTIVE_CREATE_STRATEGIC');

        $form = $this->createForm($this->get('pequiven_objetive.strategic.registration.form.type'));

        //Obtenemos el valor del nivel del objetivo
        $em = $this->getDoctrine()->getManager();
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();

        $em->getConnection()->beginTransaction();
        if ($request->isMethod('POST') && $form->submit($request)->isValid()) {
            $object = $form->getData();
            $data = $this->container->get('request')->get("pequiven_objetive_strategic_registration");

            $data['tendency'] = (int) $data['tendency'];
            $object->setGoal(bcadd(str_replace(',', '.', $data['goal']), '0', 3));
            $object->setUserCreatedAt($user);
            $ref = $data['ref'];

            //Obtenemos y Seteamos el nivel del objetivo
            $objetiveLevel = $em->getRepository('PequivenObjetiveBundle:ObjetiveLevel')->findOneBy(array('level' => ObjetiveLevel::LEVEL_ESTRATEGICO));
            $object->setObjetiveLevel($objetiveLevel);

            if (isset($data['indicators'])) {
                foreach ($data['indicators'] as $value) {
                    $indicator = $this->get("pequiven.repository.indicator")->findOneBy(array('id' => $value));
                    $indicator->setTmp(false);
                    $em->persist($indicator);
                    $object->addIndicator($indicator);
                }
            }
            $object->setPeriod($this->getPeriodService()->getPeriodActive());
            $em->persist($object);

            try {
                $em->flush();
//                $lastId = $em->getConnection()->lastInsertId();
                $em->getConnection()->commit();
            } catch (Exception $e) {
                $em->getConnection()->rollback();
                throw $e;
            }

            //Obtenemos el último objetivo guardado y le añadimos el rango de gestión o semáforo
            $objetives = $em->getRepository('PequivenObjetiveBundle:Objetive')->findBy(array('ref' => $ref));
            $this->createArrangementRange($objetives, $data);

            $this->get('session')->getFlashBag()->add('success', $this->trans('action.messages.registerObjetiveStrategicSuccessfull', array(), 'PequivenObjetiveBundle'));

            return $this->redirect($this->generateUrl('pequiven_objetive_menu_list_strategic', array(
                                    )
            ));
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * Función que guarda en la tabla intermedia el rango de gestión (semáforo) del objetivo creado
     * @param type $objetives
     * @param type $data
     * @return boolean
     * @throws \Pequiven\ObjetiveBundle\Controller\Exception
     */
    public function createArrangementRange(Objetive $objetive, $data = array()) {
        $arrangementRange = new ArrangementRange();
        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();
//        $totalObjetives = count($objetives);

        $arrangementRange->setObjetive($objetive);
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
            if ($data['tendency'] < 3) {//Comportamiento No Estable
                $arrangementRange->setRankBottomMixedTop(bcadd(str_replace(',', '.', $data['rankBottomMixedTop']), '0', 3));
                $arrangementRange->setOpRankBottomMixedTop($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankBottomMixedTop'])));
                $arrangementRange->setRankBottomMixedBottom(bcadd(str_replace(',', '.', $data['rankBottomMixedBottom']), '0', 3));
                $arrangementRange->setOpRankBottomMixedBottom($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankBottomMixedBottom'])));
            } else { //Comportamiento Estable
                //Rango Bajo-Alto
                $arrangementRange->setRankBottomMixedTop(bcadd(str_replace(',', '.', $data['rankBottomTopBasic']), '0', 3));
                $arrangementRange->setOpRankBottomMixedTop($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankBottomTopBasic'])));
                //Rango Bajo-Bajo
                $arrangementRange->setRankBottomMixedBottom(bcadd(str_replace(',', '.', $data['rankBottomBottomBasic']), '0', 3));
                $arrangementRange->setOpRankBottomMixedBottom($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankBottomBottomBasic'])));
            }
        }

        $em->persist($arrangementRange);

//        if ($totalObjetives > 0) {
//            foreach ($objetives as $objetive) {
//                $objectArrangementRange = clone $arrangementRange;
//                $objectArrangementRange->setObjetive($objetive);
//                $em->persist($objectArrangementRange);
//            }
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

    /**
     * Devuelve la Referencia del Objetivo, de acuerdo a la cantidad que ya se encuentren registrados
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function displayRefObjetiveAction(Request $request) {
        $response = new JsonResponse();
        $data = array();
        $options = array();

        $options['lineStrategicId'] = $request->request->get('lineStrategicId');
        $ref = $this->setNewRef($options);

        $data[] = array('ref' => $ref);
        $response->setData($data);
        return $response;
    }

    /**
     * Función que devuelve la referencia del objetivo estratégico que se esta creando
     * @param array $options
     */
    public function setNewRef($options = array()) {
        $em = $this->getDoctrine()->getManager();
        $lineStrategics = array();
        $lineStrategics[] = $options['lineStrategicId'];
        $results = $em->getRepository('PequivenObjetiveBundle:Objetive')->getByLineStrategic($lineStrategics);

        $refLineStrategic = $em->getRepository('PequivenMasterBundle:LineStrategic')->findOneBy(array('id' => $options['lineStrategicId']))->getRef();

        $total = count($results);
        if (is_array($results) && $total > 0) {
            $ref = $refLineStrategic . ($total + 1) . '.';
        } else {
            $ref = $refLineStrategic . '1.';
        }

        return $ref;
    }

    /**
     * @return \Pequiven\SEIPBundle\Service\PeriodService
     */
    protected function getPeriodService() {
        return $this->container->get('pequiven_seip.service.period');
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
     * @return \Pequiven\IndicatorBundle\Service\IndicatorService
     */
    private function getIndicatorService() {
        return $this->container->get('pequiven_indicator.service.inidicator');
    }

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
        $pdf->SetMargins(PDF_MARGIN_LEFT, 35, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->AddPage();       
        $html = $this->renderView($template, $data);
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output(utf8_decode($title). '.pdf', 'D');
    }

}
