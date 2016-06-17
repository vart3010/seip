<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com.ve
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Controller\DataLoad;

use Pequiven\SEIPBundle\Controller\SEIPController;
use Symfony\Component\HttpFoundation\Request;
use Pequiven\SEIPBundle\Model\Common\CommonObject;
use Pequiven\SEIPBundle\Form\DataLoad\PlantReportType;

/**
 * Reporte de planta
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class PlantReportController extends SEIPController {

    public function createNew() {
        $entity = parent::createNew();
        $request = $this->getRequest();
        $reportTemplateId = $request->get("reportTemplate");
        if ($reportTemplateId > 0) {
            $em = $this->getDoctrine()->getManager();
            $reportTemplate = $em->find("Pequiven\SEIPBundle\Entity\DataLoad\ReportTemplate", $reportTemplateId);
            $entity->init($reportTemplate);
        }
        return $entity;
    }

    public function indexAction(Request $request) {
        $criteria = $request->get('filter', $this->config->getCriteria());
        $sorting = $request->get('sorting', $this->config->getSorting());
        $repository = $this->getRepository();

        $criteria['applyPeriodCriteria'] = true;

        $resources = $this->resourceResolver->getResource(
                $repository, 'createPaginatorByUser', array($criteria, $sorting)
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
                ->setTemplate($this->config->getTemplate('index.html'))
                ->setTemplateVar($this->config->getPluralResourceName())
        ;
        if ($request->get('_format') == 'html') {
            $view->setData($resources);
        } else {
            $formatData = $request->get('_formatData', 'default');
            $view->getSerializationContext()->setGroups(array('id', 'api_list', 'api_report_template'));
            $view->setData($resources->toArray($this->config->getRedirectRoute('index'), array(), $formatData));
        }
        return $this->handleView($view);
    }

    public function showGroupAction(Request $request) {
        $plantReport = $this->getRepository()->findOneBy(array("id" => $request->get("id")));
        $childs = $plantReport->getPlant()->getChildrens();


        $data = array(
            "plant_report" => $plantReport,
            "childs" => $childs
        );

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('showGroup.html'))
                ->setTemplateVar($this->config->getResourceName())
                ->setData($data)
        ;




        return $this->handleView($view);
    }

    public function createGroupAction(Request $request) {
        $saveAndClose = $request->get("save_and_close");

        $resource = $this->createNew();
        $form = $this->getForm($resource);

        if ($request->isMethod('POST') && $form->submit($request)->isValid()) {
            $resource = $this->domainManager->create($resource);

            if (null === $resource) {
                return $this->redirectHandler->redirectToIndex();
            }

            if ($saveAndClose !== null) {
                return $this->redirectHandler->redirectTo($resource);
            } else {
                return $this->redirectHandler->redirectToRoute($this->config->getRedirectRoute('group_update'), ['id' => $resource->getId()]);
            }
        }

        if ($this->config->isApiRequest()) {
            return $this->handleView($this->view($form));
        }

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('group/create.html'))
                ->setData(array(
            $this->config->getResourceName() => $resource,
            'form' => $form->createView()
                ))
        ;

        return $this->handleView($view);
    }

    public function showAction(Request $request) {

        $plantReport = $this->getRepository()->find($request->get("id"));

        #$childs = $plantReport->getPlant()->getChildrens();
        $childs = $plantReport->getchildrensGroup();

        $totalStops = array();
        $totalHours = array();
        $totalProducts = array();
        $totalP = array();
        $totalGroupsProducts = array();
        $totalGroups = array();

        $totalServices = array();

        $alicuota = array();

        $totalStops = CommonObject::fillArrayMonth($totalStops);
        $totalHours = CommonObject::fillArrayMonth($totalHours);

        $hasGroupProducts = false;



        /**
         * METODO PARA CUANDO HAY GRUPO DE PLANTAS
         * SACO LOS HIJOS Y LUEGO LOS REPORTPLANT DE CADA UNO Y RECORRO ACUMULANDO
         * LAS PARADAS DE PLANTAS,
         * PRODUCTOS Y 
         * SERVICIOS
         */
        $productReports = $plantReport->getProductsReport();

        foreach ($productReports as $productReport) {
            //$product = $productReport->getproduct();

            if ($productReport->getIsGroup()) {
                $productReportChildrens = $productReport->getChildrensGroup();
                //SE EXTRAEN LOS SUBPRODUCTOS PARA MOSTRAR ABAJO DE ETIQUETA
                $groupNames = array();
                $units = array();
                $lines = array();

                $cont = 0;
                foreach ($productReportChildrens as $childs) {
                    if (!in_array($childs->getProduct()->getName(), $groupNames)) {
                        $groupNames[] = $childs->getProduct()->getName();
                    }
                    if (!in_array($childs->getProduct()->getProductUnit(), $units)) {
                        $units[] = $childs->getProduct()->getProductUnit();
                    }
                    if (!in_array($childs->getProduct()->getProductionLine(), $lines)) {
                        $lines[] = $childs->getProduct()->getProductionLine();
                    }
                }
                $totalGroups[] = array(
                    "id" => $productReport->getId(),
                    "name" => $productReport->getNameGroup(),
                    "line" => $lines,
                    "unit" => $units,
                    "entityProductReport" => $productReport,
                    "groupsProducts" => $groupNames
                );
            } else {

                $totalP[] = array(
                    "id" => $productReport->getId(),
                    "name" => $productReport->getName(),
                    "line" => $productReport->getProduct()->getProductionLine(),
                    "unit" => $productReport->getProduct()->getProductUnit(),
                    "entityProductReport" => $productReport,
                    "groupsProducts" => ""
                );
            }
        }


        if (count($childs) > 0) { 

            //SECCIÒN PRODUCTOS HEREDADOS
            #foreach ($childs as $child) {
            foreach ($childs as $plantReportByChild) {
                //PLANT STOP PLANNING
                $planStopPlannings = $plantReportByChild->getPlantStopPlannings();
                foreach ($planStopPlannings as $planStopPlanning) {
                    if (array_key_exists($planStopPlanning->getMonth(), $totalStops)) {
                        $totalStops[$planStopPlanning->getMonth()] += $planStopPlanning->getTotalStops();
                        $totalHours[$planStopPlanning->getMonth()] += $planStopPlanning->getTotalHours();
                    }
                }

                //SERVICIOS
                foreach ($plantReportByChild->getConsumerPlanningServices() as $planningService) {
                    if (array_key_exists($planningService->getService()->getId(), $alicuota)) {
                        $alicuota[$planningService->getService()->getId()] += $planningService->getAliquot();
                    } else {
                        $alicuota[$planningService->getService()->getId()] = $planningService->getAliquot();
                    }
                    if (!CommonObject::validIdExist($planningService->getService()->getId(), $totalServices)) {
                        //if (!$this->validIdExist($planningService->getService()->getId(), $totalServices)) {
                        $totalServices[] = array(
                            "id" => $planningService->getService()->getId(),
                            "name" => $planningService->getService()->getName(),
                            "unit" => $planningService->getService()->getServiceUnit(),
                            "alicuota" => $alicuota
                        );
                    }
                }
            }
            # }
        }


        $labelMonth = \Pequiven\SEIPBundle\Model\Common\CommonObject::getLabelsMonths();
        $stopPlanningTable = array();
        for ($i = 1; $i <= 12; $i++) {
            $stopPlanningTable[] = array(
                "month" => $i . " - " . $labelMonth[$i],
                "stop" => $totalStops[$i],
                "hours" => $totalHours[$i]
            );
        }

        $data = array(
            "plant_report" => $plantReport,
            "childs" => $childs,
            "stopPlanning" => $stopPlanningTable,
            "products" => $totalP,
            "totalGroups" => $totalGroups,
            "services" => $totalServices,
            "alicuota" => $alicuota
        );

//        if (count($plantReport) > 0) {
//            $viewDefault = 'showGroups.html';
//        } else {
//            $viewDefault = 'show.html';
//        }


        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate("show.html"))
                ->setTemplateVar($this->config->getResourceName())
                ->setData($data)
        ;
        return $this->handleView($view);
    }

    /**
     * Ejecuta la planificacion de la planta
     * @param Request $request
     * @return type
     */
    public function runAction(Request $request) {
        set_time_limit(400);

        $resource = $this->findOr404($request);
        $productsReport = $resource->getProductsReport();
        $plantStopPlanningsByMonths = $resource->getPlantStopPlanningSortByMonth();
        $consumerPlanningServices = $resource->getConsumerPlanningServices();
        $propertyAccessor = \Symfony\Component\PropertyAccess\PropertyAccess::createPropertyAccessor();

        //Funcion que retorna los dias de paradas
        $getDayStops = function($month) use ($plantStopPlanningsByMonths) {
            $daysStopsArray = array();
            if (isset($plantStopPlanningsByMonths[$month])) {
                $daysStops = $plantStopPlanningsByMonths[$month];
                foreach ($daysStops as $daysStop) {
                    $daysStopsArray[] = $daysStop->getNroDay();
                }
            }
            return $daysStopsArray;
        };

        //Servicios
        foreach ($consumerPlanningServices as $consumerPlanningService) {
            $details = $consumerPlanningService->getDetails();
            $aliquot = $consumerPlanningService->getAliquot();
            $detailsByMonth = $consumerPlanningService->getDetailsByMonth();
            foreach ($details as $detail) {
                $month = $detail->getMonth();
                $daysStopsArray = $getDayStops($month);

                $ranges = $detail->getRanges();
                foreach ($ranges as $range) {
                    $monthBudget = $detail->getMonthBudget();
                    $dateFrom = $range->getDateFrom();
                    $dateEnd = $range->getDateEnd();

                    $dayFrom = $dateFrom->format("d");
                    $dayEnd = $dateEnd->format("d");
                    $type = $range->getType();
                    $originalValue = $range->getValue();
                    $value = 0;

                    if ($type === \Pequiven\SEIPBundle\Model\DataLoad\RawMaterial\Range::TYPE_FIXED_VALUE) {
                        $value = $originalValue;
                    } else if ($type === \Pequiven\SEIPBundle\Model\DataLoad\RawMaterial\Range::TYPE_PERCENTAGE_BUDGET) {
                        $value = ($monthBudget / 100) * $originalValue;
                    }

                    for ($day = $dayFrom; $day <= $dayEnd; $day++) {
                        $dayInt = (int) $day;
                        $propertyPath = sprintf("day%sPlan", $dayInt);
                        $propertyPathGross = sprintf("day%sGrossPlan", $dayInt);
                        if (in_array($dayInt, $daysStopsArray)) {
                            $propertyAccessor->setValue($detail, $propertyPath, 0);
                            continue;
                        }

                        $totalPlan = 0.0;
//Recorremos los productos para calcular el plan del dia
                        foreach ($productsReport as $productReport) {
                            $productDetailDailyMonths = $productReport->getProductDetailDailyMonthsSortByMonth();
                            if (isset($productDetailDailyMonths[$month])) {
                                $dayPlan = $propertyAccessor->getValue($productDetailDailyMonths[$month], $propertyPathGross);
                                $totalPlan = $totalPlan + $dayPlan;
                            }
                        }
                        $total = $aliquot * $totalPlan;
                        $propertyAccessor->setValue($detail, $propertyPath, $total);
                        $this->save($detail);
                    }
                }
            }//Fin for
//Completar los meses que no estan definidos
//Los planes de consumo de servicios
            for ($month = 1; $month <= 12; $month++) {
                if (!isset($detailsByMonth[$month])) {
                    $daysStopsArray = $getDayStops($month);

                    $detail = new \Pequiven\SEIPBundle\Entity\DataLoad\Service\DetailConsumerPlanningService();
                    $detail->setMonth($month);
                    $consumerPlanningService->addDetailConsumerPlanningService($detail);

                    for ($day = 1; $day <= 31; $day++) {
                        $dayInt = (int) $day;
                        $propertyPath = sprintf("day%sPlan", $dayInt);
                        $propertyPathGross = sprintf("day%sGrossPlan", $dayInt);
                        if (in_array($dayInt, $daysStopsArray)) {
                            $propertyAccessor->setValue($detail, $propertyPath, 0);
                            continue;
                        }

                        $totalPlan = 0.0;
//Recorremos los productos para calcular el plan del dia
                        foreach ($productsReport as $productReport) {
                            $productDetailDailyMonths = $productReport->getProductDetailDailyMonthsSortByMonth();
                            if (isset($productDetailDailyMonths[$month])) {
                                $dayPlan = $propertyAccessor->getValue($productDetailDailyMonths[$month], $propertyPathGross);
                                $totalPlan = $totalPlan + $dayPlan;
                            }
                        }
                        $total = $aliquot * $totalPlan;
//                        var_dump($aliquot);
//                        var_dump($totalPlan);
                        $propertyAccessor->setValue($detail, $propertyPath, $total);
                        $detail->totalize();
                        $this->save($detail);
                    }

                    $this->save($consumerPlanningService);
                } else {
//Actualizar valores
                    $detail = $detailsByMonth[$month];
                    for ($day = 1; $day <= 31; $day++) {
                        $dayInt = (int) $day;
                        $propertyPath = sprintf("day%sPlan", $dayInt);
                        $propertyPathGross = sprintf("day%sGrossPlan", $dayInt);
                        if (in_array($dayInt, $daysStopsArray)) {
                            $propertyAccessor->setValue($detail, $propertyPath, 0);
                            continue;
                        }

                        $totalPlan = 0.0;
//Recorremos los productos para calcular el plan del dia
                        foreach ($productsReport as $productReport) {
                            $productDetailDailyMonths = $productReport->getProductDetailDailyMonthsSortByMonth();
                            if (isset($productDetailDailyMonths[$month])) {
                                $dayPlan = $propertyAccessor->getValue($productDetailDailyMonths[$month], $propertyPathGross);
                                $totalPlan = $totalPlan + $dayPlan;
                            }
                        }
                        $total = $aliquot * $totalPlan;
                        $propertyAccessor->setValue($detail, $propertyPath, $total);
                        $detail->totalize();
                        $this->save($detail);
                    }

                    $this->save($consumerPlanningService);
                }
            }
//Validar los dias de paradas
            foreach ($resource->getPlantStopPlannings() as $plantStopPlanning) {
                $ranges = $plantStopPlanning->getRanges();
                if ($ranges->count()) {
                    $dayStops = array();
                    foreach ($plantStopPlanning->getRanges() as $range) {

                        $totalHours = 0;
                        if ($range->getOtherTime() === true) {
                            $totalHours = $range->getHours();
                        } else {
                            if ($range->getStopTime()) {
                                $totalHours = $range->getStopTime()->getHours();
                            }
                        }
                        $dateFrom = $range->getDateFrom();
                        $dateEnd = $range->getDateEnd();
                        $startDay = $dateFrom->format("d");
                        $endDay = $dateEnd->format("d");
//                        var_dump($plantStopPlanning->getMonth());
//                        var_dump($startDay);
//                        var_dump($endDay);
                        for ($i = $startDay; $i <= $endDay; $i++) {
                            $dayStop = new \Pequiven\SEIPBundle\Entity\DataLoad\Plant\DayStop();
                            $day = clone($dateFrom);
                            $day->setDate($day->format('Y'), $day->format('m'), $i);
                            $dayStop->setDay($day);
                            $dayStop->setOtherTime($range->getOtherTime());
                            $dayStop->setStopTime($range->getStopTime());
                            $dayStops[] = $dayStop;
                        }
                    }
//                    var_dump($plantStopPlanning->getMonth());
//                    var_dump($dayStops);
                    $dayStopsByDay = $plantStopPlanning->getDayStopsByDay();
                    foreach ($dayStops as $dayStop) {
                        if (!isset($dayStopsByDay[$dayStop->getNroDay()])) {
//                            var_dump('add aja '.$dayStop->getNroDay());
                            $plantStopPlanning->addDayStop($dayStop);
                        }
                    }
                    $dayStopsCount = count($plantStopPlanning->getDayStopsByDay());
                    $totalStops = $plantStopPlanning->getTotalStops();
                    if ($dayStopsCount > $totalStops) {
                        $month = $this->trans($plantStopPlanning->getMonthLabel(), array(), 'PequivenSEIPBundle');
                        $this->setFlash('error', 'pequiven.error.total_number_stops_no_be_greater_than_indicated', array(
                            "%totalDaysStops%" => $dayStopsCount,
                            "%totalStops%" => $totalStops,
                            "%month%" => $month,
                                )
                        );
                    }
                }
            }
        }
//        die;
        $this->flush();
        return $this->redirectHandler->redirectTo($resource);
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function updateAction(Request $request) {

        $resource = $this->findOr404($request);
        $form = $this->createForm(new \Pequiven\SEIPBundle\Form\DataLoad\PlantReportType(), $resource);
//        $form = $this->createForm($this->container->get('pequiven_seipbundle_dataload_plantreport'), $resource);
//        $form = $this->getForm($resource);
        $method = $request->getMethod();

        if (in_array($method, array('POST', 'PUT', 'PATCH')) &&
                $form->submit($request, !$request->isMethod('PATCH'))->isValid()) {
            $this->domainManager->update($resource);

            return $this->redirectHandler->redirectTo($resource);
        }

        if ($this->config->isApiRequest()) {
            return $this->handleView($this->view($form));
        }

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('update.html'))
                ->setData(array(
            $this->config->getResourceName() => $resource,
            'form' => $form->createView()
                ))
        ;

        return $this->handleView($view);
    }

    public function updateGroupAction(Request $request) {

        $resource = $this->findOr404($request);
        $form = $this->createForm(new \Pequiven\SEIPBundle\Form\DataLoad\PlantReportGroupType(), $resource);
//        $form = $this->createForm($this->container->get('pequiven_seipbundle_dataload_plantreport'), $resource);
//        $form = $this->getForm($resource);
        $method = $request->getMethod();

        if (in_array($method, array('POST', 'PUT', 'PATCH')) &&
                $form->submit($request, !$request->isMethod('PATCH'))->isValid()) {
            $this->domainManager->update($resource);

            return $this->redirectHandler->redirectTo($resource);
        }

        if ($this->config->isApiRequest()) {
            return $this->handleView($this->view($form));
        }

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('group/update.html'))
                ->setData(array(
            $this->config->getResourceName() => $resource,
            'form' => $form->createView()
                ))
        ;

        return $this->handleView($view);
    }

    public function deleteAction(Request $request) {
        $resource = $this->findOr404($request);

        $url = $this->generateUrl("pequiven_report_template_show", array(
            "id" => $resource->getReportTemplate()->getId(),
        ));

        $this->domainManager->delete($resource);
        return $this->redirect($url);
    }

    public function getGroupLoadAction(Request $request) {
        //$criteria = $request->get('filter', $this->config->getCriteria());
        $em = $this->getDoctrine();
        $entityId = $request->get('entityId');
        $entityObj = $em->getRepository("Pequiven\SEIPBundle\Entity\CEI\Entity")->find($entityId);

        $period = $this->getPeriodService()->getPeriodActive();
        $entity = $em->getRepository("Pequiven\SEIPBundle\Entity\DataLoad\PlantReport")->findBy(array("entity" => $entityObj, "period" => $period));
        //var_dump($entity);
        $view = $this->view();
        $view->setData($entity);
        $view->getSerializationContext()->setGroups(array('id', 'api_list'));
        return $this->handleView($view);

//        
        //$repository = $this->get('pequiven.repository.objetiveoperative');
        //$results = $repository->findTacticalObjetives($user, $criteria);
//        $view = $this->view();
//        $view->setData($results);
//        $view->getSerializationContext()->setGroups(array('id', 'api_list', 'gerencia'));
//        return $this->handleView($view);
    }

}
