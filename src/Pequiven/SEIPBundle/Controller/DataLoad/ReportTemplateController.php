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

/**
 * Controlador de plantilla de reporte
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class ReportTemplateController extends SEIPController {

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
            $view->setData($resources->toArray($this->config->getRedirectRoute('index'), array(), $formatData));
        }
        return $this->handleView($view);
    }

    public function listAction(Request $request) {
        $criteria = $request->get('filter', $this->config->getCriteria());
        $sorting = $request->get('sorting', $this->config->getSorting());
        $repository = $this->getRepository();

        $resources = $this->resourceResolver->getResource(
                $repository, 'createPaginator', array($criteria, $sorting)
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
        if ($request->get('_format') == 'html') {
            $view->setData($resources);
        } else {
            $formatData = $request->get('_formatData', 'default');
            $view->setData($resources->toArray($this->config->getRedirectRoute('list'), array(), $formatData));
        }
        return $this->handleView($view);
    }

    public function showAction(Request $request) {
        $reportTemplate = $this->getRepository()->find($request->get("id"));
        $plantReports = $reportTemplate->getPlantReports();

        $arrayPlants = array();
        $arrayPlantsGroup = array();
        $groupNames = "";

        foreach ($plantReports as $plantReport) {

            $childrens = $plantReport->getChildrensGroup();
            //var_dump(count($childrens));
            if (count($childrens) > 0) {

                $cont = 0;
                $arrayPlantsIds = array();
                $groupNames = "";
                foreach ($childrens as $children) {
                    //var_dump($children);
                    $plant = $children->getPlant();

                    if (!in_array($plant->getName(), $arrayPlantsIds)) {
                        $arrayPlantsIds[] = $plant->getName();
                    }

                    if ($cont == 0) {
                        $groupNames .= $plant->getName();
                    } else {
                        $groupNames .= "," . $plant->getName();
                    }
                    $cont++;
                }

                $arrayPlantsGroup[] = array(
                    "id" => $children->getPlant()->getId(),
                    "name" => $plantReport->getnameGroup(),
                    "groups" => $groupNames,
                    "alias" => $children->getPlant()->getEntity()->getAlias(),
                    "entity" => $children,
                    "products" => $arrayPlantsIds,
                    "plantReportId" => $plantReport->getId()
                );
            } else {
                $arrayPlants[] = array(
                    "id" => $plantReport->getPlant()->getId(),
                    "name" => $plantReport->getPlant()->getName(),
                    "alias" => $plantReport->getPlant()->getEntity()->getAlias(),
                    "entity" => $plantReport,
                    "plantReportId" => $plantReport->getId()
                );
            }


//            if (count($childrens) == 0) { //SIN HIJOS
//                $arrayPlants[] = array(
//                    "id" => $plantReport->getPlant()->getId(),
//                    "name" => $plantReport->getPlant()->getName(),
//                    "alias" => $plantReport->getPlant()->getEntity()->getAlias(),
//                    "entity" => $plantReport,
//                    "plantReportId" => $plantReport->getId()
//                );
//            } else if (count($childrens) > 0) { //CON HIJOS
//                $cont = 0;
//                $arrayProductsIds = array();
//                $groupNames = "";
//                foreach ($childrens as $children) {
//                    foreach ($children->getProducts() as $productChild) {
//                        if (!in_array($productChild->getName(), $arrayProductsIds)) {
//                            $arrayProductsIds[] = $productChild->getName();
//                        }
//                    }
//                    if ($cont == 0) {
//                        $groupNames .= $children->getName();
//                    } else {
//                        $groupNames .= "," . $children->getName();
//                    }
//                    $cont++;
//                }
//                $arrayPlantsGroup[] = array(
//                    "id" => $plantReport->getPlant()->getId(),
//                    "name" => $plantReport->getPlant()->getName(),
//                    "groups" => $groupNames,
//                    "alias" => $plantReport->getPlant()->getEntity()->getAlias(),
//                    "entity" => $plantReport,
//                    "products" => $arrayProductsIds,
//                    "plantReportId" => $plantReport->getId()
//                );
//            }
        }
        //var_dump($arrayPlantsGroup);
        // die();


        $data = array(
            "report_template" => $reportTemplate,
            "plants" => $arrayPlants,
            "plantsGroup" => $arrayPlantsGroup
        );

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('show.html'))
                ->setTemplateVar($this->config->getResourceName())
                ->setData($data)
        ;

        return $this->handleView($view);
    }

    /**
     * Notificar producción
     * @param Request $request
     * @return type
     * @throws type
     */
    public function loadAction(Request $request) {
        $dateString = null;
        if ($this->getSecurityService()->isGranted(array('ROLE_SEIP_DATA_LOAD_CHANGE_DATE', 'ROLE_SEIP_OPERATION_LOAD_FIVE_DAYS', 'ROLE_SEIP_OPERATION_LOAD_QUARTER'))) {
            $dateString = $request->get('dateNotification', null);
        }
        $plantReportToLoad = $request->get('plant_report', null);
        if ($plantReportToLoad === null) {
            return $this->redirect($this->generateUrl('pequiven_plant_report_index'));
        }


        $dateNotification = null;
        if ($dateString !== null) {
            $dateNotification = \DateTime::createFromFormat('d/m/Y', $dateString);
        }
        if ($dateNotification === null) {
            $dateNotification = new \DateTime();
            $dateNotification->sub(new \DateInterval('P1D'));
        }
        $resource = $this->getRepository()->findToNotify($request->get("id"), $dateNotification, $plantReportToLoad);

        if (!$resource) {
            throw $this->createNotFoundException('No se encontro la planificacion');
        }
        $month = (int) $dateNotification->format("m");
        $methodDetailPnr = sprintf("getDay%sDetails", (int) $dateNotification->format("d"));

        $originalInternalCauses = new \Doctrine\Common\Collections\ArrayCollection();
        $originalExternalCauses = new \Doctrine\Common\Collections\ArrayCollection();
        $originalInternalCausesMp = new \Doctrine\Common\Collections\ArrayCollection();
        $originalExternalCausesMp = new \Doctrine\Common\Collections\ArrayCollection();

        foreach ($resource->getPlantReports() as $plantReport) {
            if ($plantReport->getId() !== (int) $plantReportToLoad) {
                continue;
            }
            foreach ($plantReport->getProductsReport() as $productReport) {
                $unrealizedProductionsSortByMonth = $productReport->getUnrealizedProductionsSortByMonth();
                if (!isset($unrealizedProductionsSortByMonth[$month])) {
                    break;
                }
                $unrealizedProduction = $unrealizedProductionsSortByMonth[$month];
                $unrealizedProductionDay = $unrealizedProduction->$methodDetailPnr();
                if (!$unrealizedProductionDay) {
                    break;
                }

                foreach ($unrealizedProductionDay->getInternalCauses() as $value) {
                    $originalInternalCauses->add($value);
                }
                foreach ($unrealizedProductionDay->getExternalCauses() as $value) {
                    $originalExternalCauses->add($value);
                }
                foreach ($unrealizedProductionDay->getInternalCausesMp() as $value) {
                    $originalInternalCausesMp->add($value);
                }
                foreach ($unrealizedProductionDay->getExternalCausesMp() as $value) {
                    $originalExternalCausesMp->add($value);
                }
            }
        }//fin for


        $form = $this->createForm(new \Pequiven\SEIPBundle\Form\DataLoad\Notification\ReportTemplateType($dateNotification, $resource), $resource);

        if ($request->isMethod('POST') && $form->submit($request, true)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            foreach ($resource->getPlantReports() as $plantReport) {
                if ($plantReport->getId() !== (int) $plantReportToLoad) {
                    continue;
                }
                foreach ($plantReport->getProductsReport() as $productReport) {
                    $unrealizedProductionsSortByMonth = $productReport->getUnrealizedProductionsSortByMonth();
                    if (!isset($unrealizedProductionsSortByMonth[$month])) {
                        break;
                    }
                    $unrealizedProduction = $unrealizedProductionsSortByMonth[$month];
                    $unrealizedProductionDay = $unrealizedProduction->$methodDetailPnr();
                    if (!$unrealizedProductionDay) {
                        break;
                    }

                    foreach ($originalInternalCauses as $original) {
                        if (false === $unrealizedProductionDay->getInternalCauses()->contains($original)) {
                            $unrealizedProductionDay->getInternalCauses()->removeElement($original);
                            $em->remove($original);
                        }
                    }

                    foreach ($originalExternalCauses as $original) {
                        if (false === $unrealizedProductionDay->getExternalCauses()->contains($original)) {
                            $unrealizedProductionDay->getExternalCauses()->removeElement($original);
                            $em->remove($original);
                        }
                    }

                    foreach ($originalInternalCausesMp as $original) {
                        if (false === $unrealizedProductionDay->getInternalCausesMp()->contains($original)) {
                            $unrealizedProductionDay->getInternalCausesMp()->removeElement($original);
                            $em->remove($original);
                        }
                    }

                    foreach ($originalExternalCausesMp as $original) {
                        if (false === $unrealizedProductionDay->getExternalCausesMp()->contains($original)) {
                            $unrealizedProductionDay->getExternalCausesMp()->removeElement($original);
                            $em->remove($original);
                        }
                    }
                }
            }//fin for
            $em->flush();

            $resource->recalculate();
            $this->domainManager->update($resource);
            return $this->redirect($this->generateUrl('pequiven_report_template_list'));
        }


        $fecha = date('d/m/Y');

        /**
         * Código para habilitar la notificación por 1 mes completo.
         */
        $monthActive = "";

        if ($monthActive == "") {
            $monthActive = date("m");
        }

        $year = date("Y");
        $daysMonth = cal_days_in_month(CAL_GREGORIAN, $monthActive, $year);
        $startDayMonth = "01/" . $monthActive . "/" . $year;
        $endDayMonth = $daysMonth . "/" . $monthActive . "/" . $year;

        $periodActive = $this->getPeriodService()->getPeriodActive();
        $yearPeriodSelected = date("Y", $periodActive->getDateStart()->getTimestamp());

        $startDateQuarter = $this->getTransfDate($fecha, -1);
        $endDateQuarter = $this->getTransfDate($fecha, -1);


        //Notificación por Trimestre del Período 2015
        $user = $this->getUser();
        if (($quarterToLoad = $user->getQuarterToLoadOperationProduction()) > 0) {
            switch ($quarterToLoad) {
                case 1:
                    $startDateQuarter = "01/01/" . $yearPeriodSelected;
                    $endDateQuarter = "31/03/" . $yearPeriodSelected;
                    break;
                case 2:
                    $startDateQuarter = "01/04/" . $yearPeriodSelected;
                    $endDateQuarter = "30/06/" . $yearPeriodSelected;
                    break;
                case 3:
                    $startDateQuarter = "01/07/" . $yearPeriodSelected;
                    $endDateQuarter = "30/09/" . $yearPeriodSelected;
                    break;
                case 4:
                    $startDateQuarter = "01/10/" . $yearPeriodSelected;
                    $endDateQuarter = "31/12/" . $yearPeriodSelected;
                    break;
            }
        }

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('load.html'))
                ->setTemplateVar($this->config->getResourceName())
                ->setData(array(
            $this->config->getResourceName() => $resource,
            'dateNotification' => $dateNotification,
            'startDate' => $this->getTransfDate($fecha, -5),
            'endDate' => $this->getTransfDate($fecha, -1),
            'startDayMonth' => $startDayMonth,
            'endDayMonth' => $endDayMonth,
            'startDateQuarter' => $startDateQuarter,
            'endDateQuarter' => $endDateQuarter,
            'yearPeriodSelected' => $yearPeriodSelected,
            'form' => $form->createView(),
                ))
        ;

        return $this->handleView($view);
    }

    /**
     * Código que válida los días para notificar la producción,
     * si tiene el rol "ROLE_SEIP_OPERATION_LOAD_FIVE_DAYS" deja cargar 5 días antes del día actual
     */
    function getTransfDate($fecha, $dia) {
        list($day, $mon, $year) = explode('/', $fecha);
        return date('d/m/Y', mktime(0, 0, 0, $mon, $day + $dia, $year));
    }

    public function visualizePnrPerRangeProduct(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $causeFailService = $this->getCauseFailService();

        $rawMaterials = array(
            \Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL_MP => array(),
            \Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL_MP => array(),
        );

        $methodTypeCausesMP = array(
            \Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL_MP => "getInternalCausesMp",
            \Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL_MP => "getExternalCausesMp",
        );

        $methodTypeCausesIntExt = array(
            \Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL => "TYPE_FAIL_INTERNAL",
            \Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL => "TYPE_FAIL_EXTERNAL",
        );

        //Obtenemos las etiquetas de los tipos de falla por PRN
        $labelsTypesFailsPNR = \Pequiven\SEIPBundle\Entity\CEI\Fail::getTypeFailsLabels();

        //Seteamos el total por tipo de causa de PNR
        $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]['total'] = 0.0;
        $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL]['total'] = 0.0;
        $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL_MP]['total'] = 0.0;
        $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL_MP]['total'] = 0.0;


        //Seccion de fechas
        $startDate = $request->get("startDate");
        $endDate = $request->get("endDate");

        $formatStartDay = \DateTime::createFromFormat('d-m-Y', $startDate);
        $formatEndDay = \DateTime::createFromFormat('d-m-Y', $endDate);


        //Se setean las por separados el dia,mes y año por separado por la fecha inicio y fin
        $startDay = date_format($formatStartDay, 'j');
        $startMonth = date_format($formatStartDay, 'n');
        $startYear = date_format($formatStartDay, 'Y');

        $endDay = date_format($formatEndDay, 'j');
        $endMonth = date_format($formatEndDay, 'n');
        $endYear = date_format($formatEndDay, 'Y');


        //Obtenemos la plantilla del reporte
        $reportTemplateId = $request->get('idReportTemplate');
        $reportTemplate = $this->container->get('pequiven.repository.report_template')->findOneBy(array('id' => $reportTemplateId));

        //Obtenemos el producto
        $product = $em->getRepository("Pequiven\SEIPBundle\Entity\CEI\Product")->find($request->get("idProduct"));

        //Obtenemos el Reporte del Producto
        $productReportId = $request->get('idProductReport');
        $productReport = $this->container->get('pequiven.repository.product_report')->find($productReportId);

        //Obtenemos las producciones no realizadas, asociadas al Reporte del Producto
        $unrealizedProductions = $productReport->getUnrealizedProductions();

        //Obtenemos las categorías de las causas de PNR por fallas por tipo Interna y Externa
        $failsInternal = $causeFailService->getFails(\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL);
        $failsExternal = $causeFailService->getFails(\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL);

        //Seteamos en el arreglo, la sección Causas Internas
        foreach ($failsInternal as $failInternal) {
            $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL][$failInternal->getName()]['total'] = 0.0;
        }

        //Seteamos en el arreglo, la sección Causas Externas
        foreach ($failsExternal as $failExternal) {
            $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL][$failExternal->getName()]['total'] = 0.0;
        }

        //Seteamos los productos de materia prima, por los cuales existió PNR.
        foreach ($unrealizedProductions as $unrealizedProduction) {

            if ($unrealizedProduction->getMonth() >= $startMonth && $unrealizedProduction->getMonth() <= $endMonth) {

                $rawMaterialsArray = $causeFailService->getRawMaterialsByFails($unrealizedProduction, "RANGE", array("startDate" => $formatStartDay, "endDate" => $formatEndDay));

                $externalRawMaterials = $rawMaterialsArray[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL_MP];
                $internalRawMaterials = $rawMaterialsArray[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL_MP];


                if (count($externalRawMaterials) > 0) {
                    foreach ($externalRawMaterials as $key => $rawMaterial) {
                        if (!array_key_exists($key, $rawMaterials[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL_MP])) {
                            $rawMaterials[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL_MP][$key] = $rawMaterial;
                        }
                    }
                }
                if (count($internalRawMaterials) > 0) {
                    foreach ($internalRawMaterials as $key => $rawMaterial) {
                        if (!array_key_exists($key, $rawMaterials[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL_MP])) {
                            $rawMaterials[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL_MP][$key] = $rawMaterial;
                        }
                    }
                }
            }
        }

        $externalRawMaterials = $rawMaterials[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL_MP];
        $internalRawMaterials = $rawMaterials[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL_MP];

        //Seteamos en el arreglo la sección Causas Internas MP
        if (count($internalRawMaterials) > 0) {
            foreach ($internalRawMaterials as $internalRawMaterial) {
                $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL_MP][$internalRawMaterial->getName()]['total'] = 0.0;
            }
        } else {
            $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL_MP]['empty']['total'] = 0.0;
        }

        //Seteamos en el arreglo la sección Causas Externa MP
        if (count($externalRawMaterials) > 0) {
            foreach ($externalRawMaterials as $externalRawMaterial) {
                $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL_MP][$externalRawMaterial->getName()]['total'] = 0.0;
            }
        } else {
            $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL_MP]['empty']['total'] = 0.0;
        }

        //Recorremos las producciones no realizadas
        foreach ($unrealizedProductions as $unrealizedProduction) {
            $monthUnrealizedProduction = $unrealizedProduction->getMonth();

            //Seteamos el valor dia y mes
            if ($monthUnrealizedProduction >= $startMonth && $monthUnrealizedProduction <= $endMonth) {
                $daysMonth = $causeFailService->getDaysMonth($unrealizedProduction);
                $pnrByCausesIntExt = $causeFailService->getFailsCause($unrealizedProduction);
                $pnrByCausesMP = $causeFailService->getPNRByFailsCauseMp($unrealizedProduction, $rawMaterials);



                foreach ($failsInternal as $failInternal) {
                    for ($day = 1; $day <= $daysMonth; $day++) {
                        $flag = false;
                        if ($monthUnrealizedProduction == $startMonth && $monthUnrealizedProduction == $endMonth) {
                            //Recorrer desde diaIni hasta diaFin
                            if ($day >= $startDay && $day <= $endDay) {
                                $flag = true;
                            }
                        } elseif ($monthUnrealizedProduction == $startMonth) {
                            //Recorrer desde diaInicial hasta finde mes
                            if ($day >= $startDay && $day <= $daysMonth) {
                                $flag = true;
                            }
                        } elseif ($monthUnrealizedProduction == $endMonth) {
                            //Recorrer desde dia 1 hasta el dinFin
                            if ($day >= 1 && $day <= $endDay) {
                                $flag = true;
                            }
                        } else {
                            $flag = true;
                        }

                        if ($flag) {
                            $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL][$failInternal->getName()]['total'] = $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL][$failInternal->getName()]['total'] + $pnrByCausesIntExt[$methodTypeCausesIntExt[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]][$failInternal->getName()][$day];
                        }
                    }
                }
                foreach ($failsExternal as $failExternal) {
                    for ($day = 1; $day <= $daysMonth; $day++) {
                        $flag = false;
                        if ($monthUnrealizedProduction == $startMonth && $monthUnrealizedProduction == $endMonth) {
                            //Recorrer desde diaIni hasta diaFin
                            if ($day >= $startDay && $day <= $endDay) {
                                $flag = true;
                            }
                        } elseif ($monthUnrealizedProduction == $startMonth) {
                            //Recorrer desde diaInicial hasta finde mes
                            if ($day >= $startDay && $day <= $daysMonth) {
                                $flag = true;
                            }
                        } elseif ($monthUnrealizedProduction == $endMonth) {
                            //Recorrer desde dia 1 hasta el dinFin
                            if ($day >= 1 && $day <= $endDay) {
                                $flag = true;
                            }
                        } else {
                            $flag = true;
                        }
                        if ($flag) {
                            $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL][$failExternal->getName()]['total'] = $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL][$failExternal->getName()]['total'] + $pnrByCausesIntExt[$methodTypeCausesIntExt[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL]][$failExternal->getName()][$day];
                        }
                    }
                }
                if (count($internalRawMaterials) > 0) {
                    foreach ($internalRawMaterials as $internalRawMaterial) {
                        for ($day = 1; $day <= $daysMonth; $day++) {
                            $flag = false;
                            if ($monthUnrealizedProduction == $startMonth && $monthUnrealizedProduction == $endMonth) {
                                //Recorrer desde diaIni hasta diaFin
                                if ($day >= $startDay && $day <= $endDay) {
                                    $flag = true;
                                }
                            } elseif ($monthUnrealizedProduction == $startMonth) {
                                //Recorrer desde diaInicial hasta finde mes
                                if ($day >= $startDay && $day <= $daysMonth) {
                                    $flag = true;
                                }
                            } elseif ($monthUnrealizedProduction == $endMonth) {
                                //Recorrer desde dia 1 hasta el dinFin
                                if ($day >= 1 && $day <= $endDay) {
                                    $flag = true;
                                }
                            } else {
                                $flag = true;
                            }
                            if ($flag) {
                                $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL_MP][$internalRawMaterial->getName()]['total'] = $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL_MP][$internalRawMaterial->getName()]['total'] + $pnrByCausesMP[$methodTypeCausesMP[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL_MP]][$internalRawMaterial->getName()][$day];
                            }
                        }
                    }
                }
                if (count($externalRawMaterials) > 0) {
                    foreach ($externalRawMaterials as $externalRawMaterial) {
                        for ($day = 1; $day <= $daysMonth; $day++) {
                            $flag = false;
                            if ($monthUnrealizedProduction == $startMonth && $monthUnrealizedProduction == $endMonth) {
                                //Recorrer desde diaIni hasta diaFin
                                if ($day >= $startDay && $day <= $endDay) {
                                    $flag = true;
                                }
                            } elseif ($monthUnrealizedProduction == $startMonth) {
                                //Recorrer desde diaInicial hasta finde mes
                                if ($day >= $startDay && $day <= $daysMonth) {
                                    $flag = true;
                                }
                            } elseif ($monthUnrealizedProduction == $endMonth) {
                                //Recorrer desde dia 1 hasta el dinFin
                                if ($day >= 1 && $day <= $endDay) {
                                    $flag = true;
                                }
                            } else {
                                $flag = true;
                            }
                            if ($flag) {
                                $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL_MP][$externalRawMaterial->getName()]['total'] = $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL_MP][$externalRawMaterial->getName()]['total'] + $pnrByCausesMP[$methodTypeCausesMP[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL_MP]][$externalRawMaterial->getName()][$day];
                            }
                        }
                    }
                }
            }
        }


        $data = array(
            "result" => $result,
            "product" => $product,
            "failsInternal" => $failsInternal,
            "failsExternal" => $failsExternal,
            "internalRawMaterials" => $internalRawMaterials,
            "externalRawMaterials" => $externalRawMaterials,
            "reportTemplate" => $reportTemplate,
            "startDate" => $formatStartDay,
            "endDate" => $formatEndDay,
            "labelsTypesFailsPNR" => $labelsTypesFailsPNR
        );
        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('show_causes_by_range_time.html'))
                ->setTemplateVar($this->config->getResourceName());

        $view->setData($data);

        return $this->handleView($view);
    }

    /**
     * Vista para mostrar la PNR de un producto desde reporte de produccion
     */
    public function visualizePnrProduct(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $causeFailService = $this->getCauseFailService();
        $pnrByCausesIntExt = $pnrByCausesMP = array();

        $rawMaterials = array(
            \Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL_MP => array(),
            \Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL_MP => array(),
        );

        $methodTypeCausesMP = array(
            \Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL_MP => "getInternalCausesMp",
            \Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL_MP => "getExternalCausesMp",
        );

        $methodTypeCausesIntExt = array(
            \Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL => "TYPE_FAIL_INTERNAL",
            \Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL => "TYPE_FAIL_EXTERNAL",
        );

        //Obtenemos las etiquetas de los tipos de falla por PRN
        $labelsTypesFailsPNR = \Pequiven\SEIPBundle\Entity\CEI\Fail::getTypeFailsLabels();

        $result = array();

        //Seteamos el total por tipo de causa de PNR
        $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]['total']['day'] = 0.0;
        $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]['total']['month'] = 0.0;
        $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]['total']['year'] = 0.0;
        $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL]['total']['day'] = 0.0;
        $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL]['total']['month'] = 0.0;
        $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL]['total']['year'] = 0.0;
        $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL_MP]['total']['day'] = 0.0;
        $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL_MP]['total']['month'] = 0.0;
        $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL_MP]['total']['year'] = 0.0;
        $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL_MP]['total']['day'] = 0.0;
        $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL_MP]['total']['month'] = 0.0;
        $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL_MP]['total']['year'] = 0.0;

        //SECCIÓN FECHA
        $dateReport = $request->get('dateReport', null);

        $dateNotification = null;
        if ($dateReport !== null) {
            $dateNotification = \DateTime::createFromFormat('d/m/Y', $dateReport);
        }
        if ($dateNotification === null) {
            $dateNotification = new \DateTime();
        }
        $dateReport = $dateNotification;

        $day = date_format($dateReport, 'j');
        $month = date_format($dateReport, 'n');
        $monthWithZero = date_format($dateReport, 'm');
        $year = date_format($dateReport, 'Y');

        //Obtenemos la plantilla del reporte
        $reportTemplateId = $request->get('idReportTemplate');
        $reportTemplate = $this->container->get('pequiven.repository.report_template')->findOneBy(array('id' => $reportTemplateId));

        //Obtenemos el producto
        $product = $em->getRepository("Pequiven\SEIPBundle\Entity\CEI\Product")->find($request->get("idProduct"));

        //Obtenemos el Reporte del Producto
        $productReportId = $request->get('idProductReport');
        $productReport = $this->container->get('pequiven.repository.product_report')->find($productReportId);

        //Obtenemos las producciones no realizadas, asociadas al Reporte del Producto
        $unrealizedProductions = $productReport->getUnrealizedProductions();

        //Obtenemos las categorías de las causas de PNR por fallas por tipo Interna y Externa
        $failsInternal = $causeFailService->getFails(\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL);
        $failsExternal = $causeFailService->getFails(\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL);

        //Seteamos en el arreglo, la sección Causas Internas
        foreach ($failsInternal as $failInternal) {
            $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL][$failInternal->getName()]['day'] = 0.0;
            $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL][$failInternal->getName()]['month'] = 0.0;
            $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL][$failInternal->getName()]['year'] = 0.0;
        }
        //Seteamos en el arreglo, la sección Causas Externas
        foreach ($failsExternal as $failExternal) {
            $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL][$failExternal->getName()]['day'] = 0.0;
            $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL][$failExternal->getName()]['month'] = 0.0;
            $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL][$failExternal->getName()]['year'] = 0.0;
        }

        //Seteamos los productos de materia prima, por los cuales existió PNR.
        foreach ($unrealizedProductions as $unrealizedProduction) {
            if ($unrealizedProduction->getMonth() <= $month) {
                $rawMaterialsArray = $causeFailService->getRawMaterialsByFails($unrealizedProduction);
                $externalRawMaterials = $rawMaterialsArray[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL_MP];
                $internalRawMaterials = $rawMaterialsArray[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL_MP];



                if (count($externalRawMaterials) > 0) {
                    foreach ($externalRawMaterials as $key => $rawMaterial) {
                        if (!array_key_exists($key, $rawMaterials[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL_MP])) {
                            $rawMaterials[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL_MP][$key] = $rawMaterial;
                        }
                    }
                }
                if (count($internalRawMaterials) > 0) {
                    foreach ($internalRawMaterials as $key => $rawMaterial) {
                        if (!array_key_exists($key, $rawMaterials[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL_MP])) {
                            $rawMaterials[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL_MP][$key] = $rawMaterial;
                        }
                    }
                }
            }
        }

        $externalRawMaterials = $rawMaterials[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL_MP];
        $internalRawMaterials = $rawMaterials[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL_MP];

        //Seteamos en el arreglo la sección Causas Internas MP
        if (count($internalRawMaterials) > 0) {
            foreach ($internalRawMaterials as $internalRawMaterial) {
                $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL_MP][$internalRawMaterial->getName()]['day'] = 0.0;
                $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL_MP][$internalRawMaterial->getName()]['month'] = 0.0;
                $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL_MP][$internalRawMaterial->getName()]['year'] = 0.0;
            }
        } else {
            $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL_MP]['empty']['day'] = 0.0;
            $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL_MP]['empty']['month'] = 0.0;
            $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL_MP]['empty']['year'] = 0.0;
        }

        //Seteamos en el arreglo la sección Causas Externa MP
        if (count($externalRawMaterials) > 0) {
            foreach ($externalRawMaterials as $externalRawMaterial) {
                $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL_MP][$externalRawMaterial->getName()]['day'] = 0.0;
                $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL_MP][$externalRawMaterial->getName()]['month'] = 0.0;
                $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL_MP][$externalRawMaterial->getName()]['year'] = 0.0;
            }
        } else {
            $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL_MP]['empty']['day'] = 0.0;
            $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL_MP]['empty']['month'] = 0.0;
            $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL_MP]['empty']['year'] = 0.0;
        }


        //Recorremos las producciones no realizadas
        foreach ($unrealizedProductions as $unrealizedProduction) {
            $monthUnrealizedProduction = $unrealizedProduction->getMonth();

            //Seteamos el valor dia y mes
            if ($month == $unrealizedProduction->getMonth()) {
                $pnrByCausesIntExt = $causeFailService->getFailsCause($unrealizedProduction);
                $pnrByCausesMP = $causeFailService->getPNRByFailsCauseMp($unrealizedProduction, $rawMaterials);
                foreach ($failsInternal as $failInternal) {
                    $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL][$failInternal->getName()]['day'] = $pnrByCausesIntExt[$methodTypeCausesIntExt[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]][$failInternal->getName()][$day];
                    if ($failInternal->getName() != 'Sobre Producción') {
                        $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]['total']['day'] = $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]['total']['day'] + $pnrByCausesIntExt[$methodTypeCausesIntExt[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]][$failInternal->getName()][$day];
                    }
                    for ($dayMonth = 1; $dayMonth <= $day; $dayMonth++) {
                        $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL][$failInternal->getName()]['month'] = $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL][$failInternal->getName()]['month'] + $pnrByCausesIntExt[$methodTypeCausesIntExt[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]][$failInternal->getName()][$dayMonth];
                        if ($failInternal->getName() != 'Sobre Producción') {
                            $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]['total']['month'] = $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]['total']['month'] + $pnrByCausesIntExt[$methodTypeCausesIntExt[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]][$failInternal->getName()][$dayMonth];
                        }
                    }
                }
                foreach ($failsExternal as $failExternal) {
                    $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL][$failExternal->getName()]['day'] = $pnrByCausesIntExt[$methodTypeCausesIntExt[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL]][$failExternal->getName()][$day];
                    $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL]['total']['day'] = $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL]['total']['day'] + $pnrByCausesIntExt[$methodTypeCausesIntExt[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL]][$failExternal->getName()][$day];
                    for ($dayMonth = 1; $dayMonth <= $day; $dayMonth++) {
                        $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL][$failExternal->getName()]['month'] = $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL][$failExternal->getName()]['month'] + $pnrByCausesIntExt[$methodTypeCausesIntExt[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL]][$failExternal->getName()][$dayMonth];
                        $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL]['total']['month'] = $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL]['total']['month'] + $pnrByCausesIntExt[$methodTypeCausesIntExt[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL]][$failExternal->getName()][$dayMonth];
                    }
                }
                if (count($internalRawMaterials) > 0) {
                    foreach ($internalRawMaterials as $internalRawMaterial) {
                        $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL_MP][$internalRawMaterial->getName()]['day'] = $pnrByCausesMP[$methodTypeCausesMP[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL_MP]][$internalRawMaterial->getName()][$day];
                        $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL_MP]['total']['day'] = $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL_MP]['total']['day'] + $pnrByCausesMP[$methodTypeCausesMP[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL_MP]][$internalRawMaterial->getName()][$day];
                        for ($dayMonth = 1; $dayMonth <= $day; $dayMonth++) {
                            $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL_MP][$internalRawMaterial->getName()]['month'] = $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL_MP][$internalRawMaterial->getName()]['month'] + $pnrByCausesMP[$methodTypeCausesMP[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL_MP]][$internalRawMaterial->getName()][$dayMonth];
                            $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL_MP]['total']['month'] = $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL_MP]['total']['month'] + $pnrByCausesMP[$methodTypeCausesMP[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL_MP]][$internalRawMaterial->getName()][$dayMonth];
                        }
                    }
                }
                if (count($externalRawMaterials) > 0) {
                    foreach ($externalRawMaterials as $externalRawMaterial) {
                        $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL_MP][$externalRawMaterial->getName()]['day'] = $pnrByCausesMP[$methodTypeCausesMP[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL_MP]][$externalRawMaterial->getName()][$day];
                        $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL_MP]['total']['day'] = $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL_MP]['total']['day'] + $pnrByCausesMP[$methodTypeCausesMP[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL_MP]][$externalRawMaterial->getName()][$day];
                        for ($dayMonth = 1; $dayMonth <= $day; $dayMonth++) {
                            $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL_MP][$externalRawMaterial->getName()]['month'] = $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL_MP][$externalRawMaterial->getName()]['month'] + $pnrByCausesMP[$methodTypeCausesMP[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL_MP]][$externalRawMaterial->getName()][$dayMonth];
                            $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL_MP]['total']['month'] = $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL_MP]['total']['month'] + $pnrByCausesMP[$methodTypeCausesMP[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL_MP]][$externalRawMaterial->getName()][$dayMonth];
                        }
                    }
                }
            }


            //Seteamos el valor año
            if ($monthUnrealizedProduction <= $month) {
                $pnrByCausesIntExt = $causeFailService->getFailsCause($unrealizedProduction);
                $pnrByCausesMP = $causeFailService->getPNRByFailsCauseMp($unrealizedProduction, $rawMaterials);
                foreach ($failsInternal as $failInternal) {
                    for ($dayMonth = 1; $dayMonth <= \Pequiven\SEIPBundle\Model\Common\CommonObject::getDaysPerMonth($monthUnrealizedProduction, $year); $dayMonth++) {
                        if ($month == $monthUnrealizedProduction) {
                            if ($dayMonth <= $day) {
                                $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL][$failInternal->getName()]['year'] = $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL][$failInternal->getName()]['year'] + $pnrByCausesIntExt[$methodTypeCausesIntExt[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]][$failInternal->getName()][$dayMonth];
                                if ($failInternal->getName() != 'Sobre Producción') {
                                    $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]['total']['year'] = $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]['total']['year'] + $pnrByCausesIntExt[$methodTypeCausesIntExt[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]][$failInternal->getName()][$dayMonth];
                                }
                            }
                        } else {
                            $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL][$failInternal->getName()]['year'] = $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL][$failInternal->getName()]['year'] + $pnrByCausesIntExt[$methodTypeCausesIntExt[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]][$failInternal->getName()][$dayMonth];
                            if ($failInternal->getName() != 'Sobre Producción') {
                                $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]['total']['year'] = $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]['total']['year'] + $pnrByCausesIntExt[$methodTypeCausesIntExt[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]][$failInternal->getName()][$dayMonth];
                            }
                        }
                    }
                }
                foreach ($failsExternal as $failExternal) {
                    for ($dayMonth = 1; $dayMonth <= \Pequiven\SEIPBundle\Model\Common\CommonObject::getDaysPerMonth($monthUnrealizedProduction, $year); $dayMonth++) {
                        if ($month == $monthUnrealizedProduction) {
                            if ($dayMonth <= $day) {
                                $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL][$failExternal->getName()]['year'] = $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL][$failExternal->getName()]['year'] + $pnrByCausesIntExt[$methodTypeCausesIntExt[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL]][$failExternal->getName()][$dayMonth];
                                $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL]['total']['year'] = $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL]['total']['year'] + $pnrByCausesIntExt[$methodTypeCausesIntExt[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL]][$failExternal->getName()][$dayMonth];
                            }
                        } else {
                            $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL][$failExternal->getName()]['year'] = $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL][$failExternal->getName()]['year'] + $pnrByCausesIntExt[$methodTypeCausesIntExt[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL]][$failExternal->getName()][$dayMonth];
                            $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL]['total']['year'] = $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL]['total']['year'] + $pnrByCausesIntExt[$methodTypeCausesIntExt[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL]][$failExternal->getName()][$dayMonth];
                        }
                    }
                }
                if (count($internalRawMaterials) > 0) {
                    foreach ($internalRawMaterials as $internalRawMaterial) {
                        for ($dayMonth = 1; $dayMonth <= \Pequiven\SEIPBundle\Model\Common\CommonObject::getDaysPerMonth($monthUnrealizedProduction, $year); $dayMonth++) {
                            if ($month == $monthUnrealizedProduction) {
                                if ($dayMonth <= $day) {
                                    $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL_MP][$internalRawMaterial->getName()]['year'] = $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL_MP][$internalRawMaterial->getName()]['year'] + $pnrByCausesMP[$methodTypeCausesMP[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL_MP]][$internalRawMaterial->getName()][$dayMonth];
                                    $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL_MP]['total']['year'] = $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL_MP]['total']['year'] + $pnrByCausesMP[$methodTypeCausesMP[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL_MP]][$internalRawMaterial->getName()][$dayMonth];
                                }
                            } else {
                                $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL_MP][$internalRawMaterial->getName()]['year'] = $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL_MP][$internalRawMaterial->getName()]['year'] + $pnrByCausesMP[$methodTypeCausesMP[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL_MP]][$internalRawMaterial->getName()][$dayMonth];
                                $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL_MP]['total']['year'] = $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL_MP]['total']['year'] + $pnrByCausesMP[$methodTypeCausesMP[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL_MP]][$internalRawMaterial->getName()][$dayMonth];
                            }
                        }
                    }
                }
                if (count($externalRawMaterials) > 0) {
                    foreach ($externalRawMaterials as $externalRawMaterial) {
                        for ($dayMonth = 1; $dayMonth <= \Pequiven\SEIPBundle\Model\Common\CommonObject::getDaysPerMonth($monthUnrealizedProduction, $year); $dayMonth++) {
                            if ($month == $monthUnrealizedProduction) {
                                if ($dayMonth <= $day) {
                                    $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL_MP][$externalRawMaterial->getName()]['year'] = $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL_MP][$externalRawMaterial->getName()]['year'] + $pnrByCausesMP[$methodTypeCausesMP[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL_MP]][$externalRawMaterial->getName()][$dayMonth];
                                    $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL_MP]['total']['year'] = $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL_MP]['total']['year'] + $pnrByCausesMP[$methodTypeCausesMP[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL_MP]][$externalRawMaterial->getName()][$dayMonth];
                                }
                            } else {
                                $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL_MP][$externalRawMaterial->getName()]['year'] = $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL_MP][$externalRawMaterial->getName()]['year'] + $pnrByCausesMP[$methodTypeCausesMP[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL_MP]][$externalRawMaterial->getName()][$dayMonth];
                                $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL_MP]['total']['year'] = $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL_MP]['total']['year'] + $pnrByCausesMP[$methodTypeCausesMP[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL_MP]][$externalRawMaterial->getName()][$dayMonth];
                            }
                        }
                    }
                }
            }
        }

        $data = array(
            "product" => $product,
            "dateReport" => $dateReport,
            "reportTemplate" => $reportTemplate,
            "productReport" => $productReport,
            "result" => $result,
            "failsExternal" => $failsExternal,
            "failsInternal" => $failsInternal,
            "internalRawMaterials" => $internalRawMaterials,
            "externalRawMaterials" => $externalRawMaterials,
            "labelsTypesFailsPNR" => $labelsTypesFailsPNR,
            "rawMaterials" => $rawMaterials,
        );


        //Verifica si viene de reporte de producción o se le da al botón para generar reporte.
        if ($request->get("exportExcel") == null || $request->get("exportExcel") == '0') {
            $view = $this
                    ->view()
                    ->setTemplate($this->config->getTemplate('show_causes_by_time.html'))
                    ->setTemplateVar($this->config->getResourceName());

            $view->setData($data);
            return $this->handleView($view);
        } else {

            $path = $this->get('kernel')->locateResource('@PequivenObjetiveBundle/Resources/skeleton/produccion_no_realizada.xls');
            $now = new \DateTime();
            $objPHPExcel = \PHPExcel_IOFactory::load($path);
            $objPHPExcel
                    ->getProperties()
                    ->setCreator("SEIP")
                    ->setTitle('SEIP - Reporte De Producción')
                    ->setCreated()
                    ->setLastModifiedBy('SEIP')
                    ->setModified()
            ;
            $objPHPExcel->setActiveSheetIndex(0);
            $activeSheet = $objPHPExcel->getActiveSheet();

            $arrayCauses = array(
                "0" => \Pequiven\SEIPBundle\Model\CEI\Fail::TYPE_FAIL_INTERNAL,
                "1" => \Pequiven\SEIPBundle\Model\CEI\Fail::TYPE_FAIL_EXTERNAL,
                "2" => \Pequiven\SEIPBundle\Model\CEI\Fail::TYPE_FAIL_INTERNAL_MP,
                "3" => \Pequiven\SEIPBundle\Model\CEI\Fail::TYPE_FAIL_EXTERNAL_MP
            );



            $styleCategories = array(
                "0" => array(
                    'font' => array(
                        'bold' => true,
                        'size' => 13
                    ),
                    'alignment' => array(
                        'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                    'fill' => array(
                        'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                            'rgb' => "99ccf0"
                        )
                    )),
                "1" => array(
                    'font' => array(
                        'bold' => true,
                        'size' => 13
                    ),
                    'alignment' => array(
                        'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                    'fill' => array(
                        'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                            'rgb' => "99ff66"
                        )
                    )),
                "2" => array(
                    'font' => array(
                        'bold' => true,
                        'size' => 13
                    ),
                    'alignment' => array(
                        'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                    'fill' => array(
                        'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                            'rgb' => "ffcc99"
                        )
                    )),
                "3" => array(
                    'font' => array(
                        'bold' => true,
                        'size' => 13
                    ),
                    'alignment' => array(
                        'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                    'fill' => array(
                        'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                            'rgb' => "66ff99"
                        )
                    ))
            );



            $styleTotals = array(
                'font' => array(
                    'bold' => true,
            ));
            $index = 4;
            foreach ($result as $key => $causes) {
                $nameCategorie = \Pequiven\SEIPBundle\Model\CEI\Fail::getTypeFilLabelByType($arrayCauses[$key]);

//$activeSheet->mergeCells("B" . $index . ":" . "E" . $index);
                $activeSheet->setCellValue("B" . $index, $this->trans($nameCategorie, array(), "PequivenSEIPBundle"));

                $activeSheet->getRowDimension($index)->setRowHeight(20);
                $activeSheet->getStyle("B" . $index)->applyFromArray($styleCategories[$key]);
                $activeSheet->getStyle("C" . $index)->applyFromArray($styleCategories[$key]);
                $activeSheet->getStyle("D" . $index)->applyFromArray($styleCategories[$key]);
                $activeSheet->getStyle("E" . $index)->applyFromArray($styleCategories[$key]);
                $index++;
                foreach ($causes as $key => $categories) {
                    if ($key != "total") {
                        if ($key == "empty") {
                            $key = "Sin Causas";
                        }
                        $activeSheet->setCellValue("B" . $index, $key);
                        $activeSheet->setCellValue("C" . $index, $categories["day"]);
                        $activeSheet->setCellValue("D" . $index, $categories["month"]);
                        $activeSheet->setCellValue("E" . $index, $categories["year"]);
                        $index++;
                    }
                }
                foreach ($causes as $key => $categories) {
                    if ($key == "total") {
                        $activeSheet->getStyle("B" . $index)->applyFromArray($styleTotals);
                        $activeSheet->setCellValue("B" . $index, ucwords($key));
                        $activeSheet->setCellValue("C" . $index, $categories["day"]);
                        $activeSheet->setCellValue("D" . $index, $categories["month"]);
                        $activeSheet->setCellValue("E" . $index, $categories["year"]);
                        $index++;
                    }
                }
            }



            $fileName = sprintf("Reporte de Producción " . date("d-m-Y") . ".xls");

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $fileName . '"');
            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');

            // If you're serving to IE over SSL, then the following may be needed
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0

            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            exit;
        }
    }

    public function summaryProduction($productsReports, $dateReport, $typeReport) {

        $dayPlan = 0.0;
        $dayReal = 0.0;

        $observations = array();

        $summaryProducction = array();
        $summaryProductionTotals = array(
            "day" => array(
                "ppto" => 0.0,
                "real" => 0.0,
                "ejec" => 0.0,
                "var" => 0.0
            ),
            "month" => array(
                "ppto" => 0.0,
                "pptoAcumulado" => 0.0,
                "realAcumulado" => 0.0,
                "ejec" => 0.0,
                "var" => 0.0
            ),
            "year" => array(
                "ppto" => 0.0,
                "pptoAcumulado" => 0.0,
                "realAcumulado" => 0.0,
                "ejec" => 0.0,
                "var" => 0.0
            )
        );

        //PRODUCTS REPORTS
        foreach ($productsReports as $productReport) {
            //var_dump($productReport->getProduct()->getId());
            //PRODUCCION DIARIA
            $summaryDay = $productReport->getSummaryDay($dateReport, $typeReport);

            $dayPlan+=$summaryDay["plan"];
            $dayReal+=$summaryDay["real"];

            if ($summaryDay["plan"] - $summaryDay["real"] < 0) {
                $var = 0;
            } else {
                $var = $summaryDay["plan"] - $summaryDay["real"];
            }

            //ME TRAIGO LAS OBSERVACIONES 
            if($summaryDay["observation"] !="")  { 
                $observations[] = array(
                    "nameProduct" => $productReport->getProduct()->getName() . " (" . $productReport->getPlantReport()->getPlant()->getName() . ")",
                    "obs" => $summaryDay["observation"]
                );
            }      

            if ($summaryDay["plan"] > 0) {
                $ejecutionDay = ($summaryDay["real"] * 100) / $summaryDay["plan"];
            } else {
                $ejecutionDay = 0;
            }

            $group = null;
            if ($productReport->getParent() != null) {
                $group = $productReport->getParent()->getId();
            }

            $summaryProducction["day"][] = array(
                "idProduct" => $productReport->getProduct()->getId(),
                "idPlant" => $productReport->getPlantReport()->getPlant()->getId(),
                "group" => $group,
                "nameProduct" => $productReport->getProduct()->getName() . " (" . $productReport->getProduct()->getProductUnit() . ")",
                "plan" => number_format($summaryDay["plan"], 2, ',', '.'),
                "real" => number_format($summaryDay["real"], 2, ',', '.'),
                "ejecution" => number_format($ejecutionDay, 2, ',', '.'),
                "var" => number_format($var, 2, ',', '.')
            );
            //TOTALES SECCION DIA
            $summaryProductionTotals["day"]["ppto"] +=$summaryDay["plan"];
            $summaryProductionTotals["day"]["real"] +=$summaryDay["real"];
            $summaryProductionTotals["day"]["ejec"] +=$ejecutionDay;
            $summaryProductionTotals["day"]["var"] +=$var;
        }
        var_dump($summaryProducction);
    }

    public function reportAction(Request $request) {


        $plantReportId = null;
        if ($request->isMethod("POST")) {
            $formData = $request->get("form");
            if (isset($formData['plantReport'])) {
                $plantReportId = (int) $formData['plantReport'];
            }
        }

        $periodActive = $this->getPeriodService()->getPeriodActive();
        $yearPeriodSelected = date("Y", $periodActive->getDateStart()->getTimestamp());

        $startDatePeriod = "01/01/" . $yearPeriodSelected;
        $endDatePeriod = "31/12/" . $yearPeriodSelected;

        $dateReport = new \DateTime(date("Y-m-d", strtotime("-1 day")));

        if (!$this->getSecurityService()->isGranted('ROLE_SEIP_DATA_LOAD_CHANGE_DATE')) {
            $dateReport = new \DateTime(date("Y-m-d", strtotime("-1 day")));
        }

        /* CHECKS DE FILTROS PREDETERMINADOS COMO TRUE */
        $showDay = $showMonth = $showYear = $defaultShow = $withDetails = true;
        $dateFrom = $dateEnd = new \DateTime();

        $byRange = false;

        $emptyValue = "Seleccione";
        $parametersReportTemplate = array(
            'label_attr' => array('class' => 'label bold'),
            'class' => 'Pequiven\SEIPBundle\Entity\DataLoad\ReportTemplate',
            'property' => 'reportTemplateWithName',
            'required' => false,
            'empty_value' => $emptyValue,
            'translation_domain' => 'PequivenSEIPBundle',
            'attr' => array('class' => 'select2 input-xlarge'),
            'multiple' => true,
        );
        $qb = function (\Pequiven\SEIPBundle\Repository\DataLoad\ReportTemplateRepository $repository) {
            return $repository->getQueryBuilderByUser();
        };
        $parametersReportTemplate['query_builder'] = $qb;

        $parametersPlantReport = array(
            'label_attr' => array('class' => 'label bold'),
            'class' => 'Pequiven\SEIPBundle\Entity\DataLoad\PlantReport',
            'property' => 'plant',
            'required' => true,
            'empty_value' => $emptyValue,
            'translation_domain' => 'PequivenSEIPBundle',
            'attr' => array('class' => 'select2 input-xlarge'),
            'multiple' => false,
            'group_by' => 'reportTemplateWithName'
        );
        $qb = function (\Pequiven\SEIPBundle\Repository\DataLoad\PlantReportRepository $repository) {
            return $repository->getQueryBuilderByUser();
        };
        $parametersPlantReport['query_builder'] = $qb;

        $form = $this
                ->createFormBuilder()
                ->add('reportTemplate', 'entity', $parametersReportTemplate)
                //->add('plantReport', 'entity', $parametersPlantReport)
                ->add('dateReport', 'date', [
                    'label_attr' => array('class' => 'label bold'),
                    'format' => 'd/M/y',
                    'widget' => 'single_text',
                    'translation_domain' => 'PequivenSEIPBundle',
                    'attr' => array('class' => 'input input-xlarge'),
                    'data' => $dateReport,
                    'required' => false,
                ])
                ->add('productsReport', 'entity', [
                    'label_attr' => array('class' => 'label bold'),
                    'class' => 'Pequiven\SEIPBundle\Entity\DataLoad\ProductReport',
                    'multiple' => true,
                    'translation_domain' => 'PequivenSEIPBundle',
                    'required' => false,
                    'attr' => array('class' => 'select2 input-xlarge'),
                ])
                ->add('showDay', 'checkbox', [
                    'label_attr' => array('class' => 'label bold'),
                    'required' => false,
                    'translation_domain' => 'PequivenSEIPBundle',
                    'data' => $defaultShow,
                ])
                ->add('showMonth', 'checkbox', [
                    'label_attr' => array('class' => 'label bold'),
                    'required' => false,
                    'translation_domain' => 'PequivenSEIPBundle',
                    'data' => $defaultShow,
                ])
                ->add('showYear', 'checkbox', [
                    'label_attr' => array('class' => 'label bold'),
                    'required' => false,
                    'translation_domain' => 'PequivenSEIPBundle',
                    'data' => $defaultShow,
                ])
                ->add('byRange', 'checkbox', [
                    'label_attr' => array('class' => 'label bold'),
                    'required' => false,
                    'translation_domain' => 'PequivenSEIPBundle',
                    'data' => false,
                ])
//                ->add('withDetails', 'checkbox', [
//                    'label_attr' => array('class' => 'label bold'),
//                    'required' => false,
//                    'translation_domain' => 'PequivenSEIPBundle',
//                ])
                ->add('dateFrom', 'date', [
                    'label_attr' => array('class' => 'label bold'),
                    'format' => 'd/M/y',
                    'widget' => 'single_text',
                    'translation_domain' => 'PequivenSEIPBundle',
                    'attr' => array('class' => 'input input-xlarge'),
                    'required' => false,
                ])
                ->add('dateEnd', 'date', [
                    'label_attr' => array('class' => 'label bold'),
                    'format' => 'd/M/y',
                    'widget' => 'single_text',
                    'translation_domain' => 'PequivenSEIPBundle',
                    'attr' => array('class' => 'input input-xlarge'),
                    'required' => false,
                ])
                ->add('typeReport', 'choice', [
                    'label_attr' => array('class' => 'label bold'),
                    'choices' => [
                        'Gross' => 'Bruta',
                        'Net' => 'Neta',
                    ],
                    'data' => 'Gross',
                    'attr' => array('class' => 'select2 input-xlarge'),
                    'translation_domain' => 'PequivenSEIPBundle',
                ])
                ->add('showProduction', 'checkbox', [
                    'label_attr' => array('class' => 'label bold'),
                    'required' => false,
                    'translation_domain' => 'PequivenSEIPBundle',
                    'data' => $defaultShow,
                ])
                ->add('showRawMaterial', 'checkbox', [
                    'label_attr' => array('class' => 'label bold'),
                    'required' => false,
                    'translation_domain' => 'PequivenSEIPBundle',
                    'data' => $defaultShow,
                ])
                ->add('showServices', 'checkbox', [
                    'label_attr' => array('class' => 'label bold'),
                    'required' => false,
                    'translation_domain' => 'PequivenSEIPBundle',
                    'data' => $defaultShow,
                ])
                ->add('showPnr', 'checkbox', [
                    //           'label_attr' => array('class' => 'label bold'),
                    'required' => false,
                    'translation_domain' => 'PequivenSEIPBundle',
                    'data' => $defaultShow,
                ])
                ->add('showInventory', 'checkbox', [
                    'label_attr' => array('class' => 'label bold'),
                    'required' => false,
                    'translation_domain' => 'PequivenSEIPBundle',
                    'data' => $defaultShow,
                ])
                ->add('showObservation', 'checkbox', [
                    'label_attr' => array('class' => 'label bold'),
                    'required' => false,
                    'translation_domain' => 'PequivenSEIPBundle',
                    'data' => $defaultShow,
                ])
                ->add('showGroupsPlants', 'checkbox', [
                    'label_attr' => array('class' => 'label bold'),
                    'required' => false,
                    'translation_domain' => 'PequivenSEIPBundle',
                    'data' => false,
                ])
                ->add('overProduction', 'choice', array(
                    'label_attr' => array('class' => 'label bold'),
                    'choices' => array(
                        '0' => 'No Alterar Sobre-Producción',
                        '1' => 'Sumar Sobre-Producción',
                        '2' => 'Restar Sobre-Producción'
                    ),
                    'multiple' => false,
                    'expanded' => false,
                    'attr' => array('class' => 'select2'),
                    'translation_domain' => 'PequivenSEIPBundle',
                    'data'=>false
                ))

                ->getForm();

        $showProduction = null;
        $showRawMaterial = null;
        $showService = null;
        $showPnr = null;
        $showInventory = null;
        $showObservation = null;

        if ($request->isMethod('POST') && $form->submit($request)->isValid()) {

            $exportToPdf = $request->get('exportToPdf', false);
            //var_dump("aqui: "+$exportToPdf);


            $data = $form->getData();

            $byRange = $data['byRange'];
//$withDetails = $data['withDetails'];
            $showDay = $data['showDay'];
            $showMonth = $data['showMonth'];
            $showYear = $data['showYear'];

            $dateFrom = $data["dateFrom"];
            $dateEnd = $data["dateEnd"];
            $groupsPlants = $data["showGroupsPlants"];

            $showProduction = $data["showProduction"];
            $showRawMaterial = $data["showRawMaterial"];
            $showPnr = $data["showPnr"];
            $showService = $data["showServices"];
            $showInventory = $data["showInventory"];
            $showObservation = $data["showObservation"];

            $reportTemplates = $data["reportTemplate"];

            $typeReport = $data['typeReport'];
            $dateReport = $data['dateReport']; //new

            $overProduction = $data["overProduction"];



            $dayPlan = 0.0;
            $dayReal = 0.0;

            $MonthPlan = 0.0;
            $MonthPlanAcumulated = 0.0;
            $MonthRealAcumualated = 0.0;

            $yearPlan = 0.0;
            $yearPlanAcumulated = 0.0;
            $yearRealAcumualated = 0.0;

            $summaryProducction = array();
            $summaryProductionTotals = array(
                "day" => array(
                    "ppto" => 0.0,
                    "real" => 0.0,
                    "ejec" => 0.0,
                    "var" => 0.0
                ),
                "month" => array(
                    "ppto" => 0.0,
                    "pptoAcumulado" => 0.0,
                    "realAcumulado" => 0.0,
                    "ejec" => 0.0,
                    "var" => 0.0
                ),
                "year" => array(
                    "ppto" => 0.0,
                    "pptoAcumulado" => 0.0,
                    "realAcumulado" => 0.0,
                    "ejec" => 0.0,
                    "var" => 0.0
                )
            );



            $observations = array();
            $arrayIdProducts = array();

            //$groupsProducts = array();
            //CONSUMO DE MATERIA PRIMA
            $arrayProdServices = array();
            $arrayConsumerServices = array();
            $arrayRawMaterial = array();
            $arrayRawMaterialTotals = array();

            if ($showDay) {
                $arrayRawMaterialTotals["plan"] = 0.0;
                $arrayRawMaterialTotals["real"] = 0.0;
            }
            if ($showMonth) {
                $arrayRawMaterialTotals["plan_month"] = 0.0;
                $arrayRawMaterialTotals["real_month"] = 0.0;
            }
            if ($showYear) {
                $arrayRawMaterialTotals["plan_year"] = 0.0;
                $arrayRawMaterialTotals["real_year"] = 0.0;
            }

            //CONSUME SERVICES
//            $totalConsumerServices = array();
            if ($showDay) {
                $totalConsumerServices["plan"] = 0.0;
                $totalConsumerServices["real"] = 0.0;
            }
            if ($showMonth) {
                $totalConsumerServices["plan_month"] = 0.0;
                $totalConsumerServices["real_month"] = 0.0;
            }
            if ($showYear) {
                $totalConsumerServices["plan_year"] = 0.0;
                $totalConsumerServices["real_year"] = 0.0;
            }


            //UNERALIZED PRODUCCTION
            $arrayUnrealizedProduction = array();
            $totalUnrealizedProduction = array(
                "day" => 0.0,
                "month" => 0.0,
                "year" => 0.0
            );

            //INVENTORY
            $arrayInventory = array();
            $totalInventory = array(
                "day" => 0.0,
                "day_preview" => 0.0
            );
            
            $plants = array();

            //HASTA LA FECHA
            if (!$byRange) {
                $dataProductsReports = new \Doctrine\Common\Collections\ArrayCollection();
                $rawMaterialConsumptionPlanningObjects = new \Doctrine\Common\Collections\ArrayCollection();
                $consumerPlanningServiceObjects = new \Doctrine\Common\Collections\ArrayCollection();

                //SESSION HASTA LA FECHA SIN GRUPO DE PLANTAS
                if (!$groupsPlants) {

                    //var_dump($dateReport);

                    foreach ($reportTemplates as $reportTemplate) {

                        foreach ($reportTemplate->getPlantReports() as $plantReport) {
                            if (!in_array($plantReport->getReportTemplate()->getName(), $plants)) {
                                $plants[] = $plantReport->getReportTemplate()->getName();
                            }
                            //PRODUCTS REPORTS
                            foreach ($plantReport->getProductsReport() as $productReport) {
                                
                                //VALIDA Q SEAN PLANTS REPORTS HIJOS
                                if ($productReport->getIsGroup() == 0) {

                                    if (!$dataProductsReports->contains($productReport)) {
                                        $dataProductsReports->add($productReport);
                                    }
                                    //var_dump($productReport->getProduct()->getId());
                                    //PRODUCCION DIARIA
                                    $summaryDay = $productReport->getSummaryDay($dateReport, $typeReport);

                                    $dayPlan+=$summaryDay["plan"];
                                    $dayReal+=$summaryDay["real"];

                                    
                                    
                                    //ME TRAIGO LAS OBSERVACIONES 
                                    if($summaryDay["observation"] !="")  { 
                                        $observations[] = array(
                                            "nameProduct" => $productReport->getProduct()->getName() . " (" . $productReport->getPlantReport()->getPlant()->getName() . ")",
                                            "obs" => $summaryDay["observation"]
                                        );
                                    }


                                    if ($summaryDay["plan"] - $summaryDay["real"] < 0) {
                                        $var = 0;
                                    } else {
                                        $var = $summaryDay["plan"] - $summaryDay["real"];
                                    }

                                    if ($summaryDay["plan"] > 0) {
                                        $ejecutionDay = ($summaryDay["real"] * 100) / $summaryDay["plan"];
                                    } else {
                                        $ejecutionDay = 0;
                                    }

                                    $group = null;
                                    if ($productReport->getParent() != null) {
                                        $group = $productReport->getParent()->getId();
                                    }

                                    $summaryProducction["day"][] = array(
                                        "idProduct" => $productReport->getProduct()->getId(),
                                        "idPlant" => $productReport->getPlantReport()->getPlant()->getId(),
                                        "group" => $group,
                                        "nameProduct" => $productReport->getProduct()->getName() . " (" . $productReport->getProduct()->getProductUnit() . ")",
                                        "plan" => number_format($summaryDay["plan"], 2, ',', '.'),
                                        "real" => number_format($summaryDay["real"], 2, ',', '.'),
                                        "ejecution" => number_format($ejecutionDay, 2, ',', '.'),
                                        "var" => number_format($var, 2, ',', '.')
                                    );
                                    //TOTALES SECCION DIA
                                    $summaryProductionTotals["day"]["ppto"] +=$summaryDay["plan"];
                                    $summaryProductionTotals["day"]["real"] +=$summaryDay["real"];
                                    #$summaryProductionTotals["day"]["ejec"] +=$ejecutionDay;
                                    #$summaryProductionTotals["day"]["var"] +=$var;




                                    //PRODUCCTION MONTH
                                    $summaryMonth = $productReport->getSummaryMonth($dateReport, $typeReport);

                                    $MonthPlan+=$summaryMonth["plan_month"];
                                    $MonthPlanAcumulated+=$summaryMonth["plan_acumulated"];
                                    $MonthRealAcumualated+=$summaryMonth["real_acumulated"];

                                    if ($summaryMonth["plan_acumulated"] - $summaryMonth["real_acumulated"] < 0) {
                                        $varMonth = 0;
                                    } else {
                                        $varMonth = $summaryMonth["plan_acumulated"] - $summaryMonth["real_acumulated"];
                                    }

                                    if ($summaryMonth["plan_acumulated"] > 0) {
                                        $ejecutionMonth = ($summaryMonth["real_acumulated"] * 100) / $summaryMonth["plan_acumulated"];
                                    } else {
                                        $ejecutionMonth = 0;
                                    }

                                    $summaryProducction["month"][] = array(
                                        "nameProduct" => $productReport->getProduct()->getName() . " (" . $productReport->getProduct()->getProductUnit() . ")",
                                        "plan_month" => number_format($summaryMonth["plan_month"], 2, ',', '.'),
                                        "plan_acumulated" => number_format($summaryMonth["plan_acumulated"], 2, ',', '.'),
                                        "real_acumulated" => number_format($summaryMonth["real_acumulated"], 2, ',', '.'),
                                        "ejecution" => number_format($ejecutionMonth, 2, ',', '.'),
                                        "var" => number_format($varMonth, 2, ',', '.')
                                    );
                                    //TOTALES SECCION MES
                                    $summaryProductionTotals["month"]["ppto"] +=$summaryMonth["plan_month"];
                                    $summaryProductionTotals["month"]["pptoAcumulado"] +=$summaryMonth["plan_acumulated"];
                                    $summaryProductionTotals["month"]["realAcumulado"] +=$summaryMonth["real_acumulated"];
                                    #$summaryProductionTotals["month"]["ejec"] +=$ejecutionMonth;
                                    #$summaryProductionTotals["month"]["var"] +=$varMonth;


                                    //PRODUCCTION YEAR
                                    $summaryYear = $productReport->getSummaryYear($dateReport, $typeReport);

                                    $yearPlan+=$summaryYear["plan_year"];
                                    $yearPlanAcumulated+=$summaryYear["plan_acumulated"];
                                    $yearRealAcumualated+=$summaryYear["real_acumulated"];

                                    if ($summaryYear["plan_acumulated"] - $summaryYear["real_acumulated"] < 0) {
                                        $varYear = 0;
                                    } else {
                                        $varYear = $summaryYear["plan_acumulated"] - $summaryYear["real_acumulated"];
                                    }


                                    if ($summaryYear["plan_acumulated"] > 0) {
                                        $ejecutionYear = ($summaryYear["real_acumulated"] * 100) / $summaryYear["plan_acumulated"];
                                    } else {
                                        $ejecutionYear = 0;
                                    }

                                    $summaryProducction["year"][] = array(
                                        "nameProduct" => $productReport->getProduct()->getName() . " (" . $productReport->getProduct()->getProductUnit() . ")",
                                        "plan_year" => number_format($summaryYear["plan_year"], 2, ',', '.'),
                                        "plan_acumulated" => number_format($summaryYear["plan_acumulated"], 2, ',', '.'),
                                        "real_acumulated" => number_format($summaryYear["real_acumulated"], 2, ',', '.'),
                                        "ejecution" => number_format($ejecutionYear, 2, ',', '.'),
                                        "var" => number_format($varYear, 2, ',', '.')
                                    );

                                    //TOTALES SECCION AÑO
                                    $summaryProductionTotals["year"]["ppto"] +=$summaryYear["plan_year"];
                                    $summaryProductionTotals["year"]["pptoAcumulado"] +=$summaryYear["plan_acumulated"];
                                    $summaryProductionTotals["year"]["realAcumulado"] +=$summaryYear["real_acumulated"];
                                    #$summaryProductionTotals["year"]["ejec"] +=$ejecutionYear;
                                    #$summaryProductionTotals["year"]["var"] +=$varYear;

                                    $cont = 0;

                                    //RAW MATERIAL 
                                    foreach ($productReport->getRawMaterialConsumptionPlannings() as $rawMaterial) {
                                        $rawMaterialConsumptionPlanningObjects[] = $rawMaterial;
                                        if ($rawMaterial->getProduct()->getIsRawMaterial()) {
                                            $rawMaterialResult = $rawMaterial->getSummary($dateReport);
                                            $idProduct = $rawMaterial->getProduct()->getId();


                                            if (!in_array($idProduct, $arrayIdProducts)) {
                                                $arrayIdProducts[] = $idProduct;
                                                //$n = $rawMaterial->getProductReport()->getPlantReport()->getPlant();
                                                $arrayRawMaterial[] = array(
                                                    "id" => $rawMaterial->getProduct()->getId(),
                                                    "productName" => $rawMaterial->getProduct()->getName() . " (" . $rawMaterial->getProduct()->getProductUnit()->getUnit() . ")",
                                                    //"productName" => $n,
                                                    "plan" => number_format($rawMaterialResult["total_day_plan"], 2, ",", "."),
                                                    "real" => number_format($rawMaterialResult["total_day"], 2, ",", "."),
                                                    "plan_month" => number_format($rawMaterialResult["total_month_plan"], 2, ",", "."),
                                                    "real_month" => number_format($rawMaterialResult["total_month"], 2, ",", "."),
                                                    "plan_year" => number_format($rawMaterialResult["total_year_plan"], 2, ",", "."),
                                                    "real_year" => number_format($rawMaterialResult["total_year"], 2, ",", ".")
                                                );
                                            } else {
                                                $indice = array_search($idProduct, $arrayIdProducts);

                                                //var_dump($rawMaterial->getProduct()->getName() . " | nuevo: " . $arrayRawMaterial[$indice]["real_year"] . "- suma: " . $rawMaterialResult["total_year"]);
                                                $arrayRawMaterial[$indice]["plan"] = $arrayRawMaterial[$indice]["plan"] + $rawMaterialResult["total_day_plan"];
                                                $arrayRawMaterial[$indice]["real"] = $arrayRawMaterial[$indice]["real"] + $rawMaterialResult["total_day"];
                                                $arrayRawMaterial[$indice]["plan_month"] = $arrayRawMaterial[$indice]["plan_month"] + $rawMaterialResult["total_month_plan"];
                                                $arrayRawMaterial[$indice]["real_month"] = $arrayRawMaterial[$indice]["real_month"] + $rawMaterialResult["total_month"];
                                                $arrayRawMaterial[$indice]["plan_year"] = $arrayRawMaterial[$indice]["plan_year"] + $rawMaterialResult["total_year_plan"];
                                                $arrayRawMaterial[$indice]["real_year"] = $arrayRawMaterial[$indice]["real_year"] + $rawMaterialResult["total_year"];
                                            }

                                            if ($showDay) {
                                                $arrayRawMaterialTotals["plan"] += $rawMaterialResult["total_day_plan"];
                                                $arrayRawMaterialTotals["real"] += $rawMaterialResult["total_day"];
                                            }
                                            if ($showMonth) {
                                                $arrayRawMaterialTotals["plan_month"] += $rawMaterialResult["total_month_plan"];
                                                $arrayRawMaterialTotals["real_month"] += $rawMaterialResult["total_month"];
                                            }
                                            if ($showYear) {
                                                $arrayRawMaterialTotals["plan_year"] += $rawMaterialResult["total_year_plan"];
                                                $arrayRawMaterialTotals["real_year"] += $rawMaterialResult["total_year"];
                                            }
                                            $cont++;
                                        }
                                    }//RAW MATERIAL
                                }
                            } //PRODUCT REPORT


                            $summaryProductionTotals["day"]["ejec"] = $this->getEjecution($summaryProductionTotals["day"]["ppto"],$summaryProductionTotals["day"]["real"],false);
                            $summaryProductionTotals["day"]["var"] = $this->getVariation($summaryProductionTotals["day"]["ppto"],$summaryProductionTotals["day"]["real"],false);

                            $summaryProductionTotals["month"]["ejec"] = $this->getEjecution($summaryProductionTotals["month"]["pptoAcumulado"],$summaryProductionTotals["month"]["realAcumulado"],false);
                            $summaryProductionTotals["month"]["var"] = $this->getVariation($summaryProductionTotals["month"]["pptoAcumulado"],$summaryProductionTotals["month"]["realAcumulado"],false);

                            $summaryProductionTotals["year"]["ejec"] = $this->getEjecution($summaryProductionTotals["year"]["pptoAcumulado"],$summaryProductionTotals["year"]["realAcumulado"],false);
                            $summaryProductionTotals["year"]["var"] = $this->getVariation($summaryProductionTotals["year"]["pptoAcumulado"],$summaryProductionTotals["year"]["realAcumulado"],false);




                            //CONSUMO DE SERVICIOS 
                            foreach ($plantReport->getConsumerPlanningServices() as $consumerPlanningService) {
                            $consumerPlanningServiceObjects[] = $consumerPlanningService;

                                $serviceName = $consumerPlanningService->getService()->getName() . " (" . $consumerPlanningService->getService()->getServiceUnit() . ")";
                                $serviceId = $consumerPlanningService->getService()->getId();

                                if (!in_array($serviceName, $arrayProdServices)) {
                                    array_push($arrayProdServices, $serviceName);
                                    $arrayConsumerServices[$serviceId] = array(
                                        "productName" => $serviceName,
                                        "plan" => 0.0,
                                        "real" => 0.0,
                                        "plan_month" => 0.0,
                                        "real_month" => 0.0,
                                        "plan_year" => 0.0,
                                        "real_year" => 0.0
                                    );
                                }
                                $consumerPlanning = $consumerPlanningService->getSummary($dateReport);
                                if ($showDay) {
                                    $totalConsumerServices["plan"] += $consumerPlanning["total_day_plan"];
                                    $totalConsumerServices["real"] += $consumerPlanning["total_day"];
                                }
                                if ($showMonth) {
                                    $totalConsumerServices["plan_month"] += $consumerPlanning["total_month_plan"];
                                    $totalConsumerServices["real_month"] += $consumerPlanning["total_month"];
                                }
                                if ($showYear) {
                                    $totalConsumerServices["plan_year"] += $consumerPlanning["total_year_plan"];
                                    $totalConsumerServices["real_year"] += $consumerPlanning["total_year"];
                                }


                                $arrayConsumerServices[$serviceId]["real"] += $consumerPlanning["total_day"];
                                $arrayConsumerServices[$serviceId]["plan"] += $consumerPlanning["total_day_plan"];
                                $arrayConsumerServices[$serviceId]["real_month"] += $consumerPlanning["total_month"];
                                $arrayConsumerServices[$serviceId]["plan_month"] += $consumerPlanning["total_month_plan"];
                                $arrayConsumerServices[$serviceId]["real_year"] += $consumerPlanning["total_year"];
                                $arrayConsumerServices[$serviceId]["plan_year"] += $consumerPlanning["total_year_plan"];
                            }//FIN CONSUMO DE SERVICIOS
                            //
                            //PRODUCION NO REALIZADA
                            $productReportService = $this->getProductReportService();
                            foreach ($plantReport->getProductsReport() as $productReport) {
                                if (!$productReport->getIsGroup()) {
                                    $productId = $productReport->getProduct()->getId();
                                    $productReportId = $productReport->getId();

//                    if (!in_array($productReportId, $arrayNamesUnrealizedProduction)) {
//                        $arrayNamesUnrealizedProduction[] = $productId;
                                    $arrayUnrealizedProduction[$productReportId] = array(
                                        "productName" => $productReport->getName() . " (" . $productReport->getProduct()->getProductUnit()->getUnit() . ")",
                                        //ID DEL PRODUCT_REPORT
                                        "productId" => $productReport->getId(),
                                        "reportTemplateId" => $productReport->getPlantReport()->getReportTemplate()->getId(),
                                        //ID DEL PRODUCTO
                                        "idProduct" => $productId
                                    );
                                    // }
                                    $unrealizedProduction = $productReport->getSummaryUnrealizedProductionsFilterCause($dateReport);
                                    if($overProduction==1) {
                                        
                                        $excludePnr = $productReportService->getArrayByDateFromInternalCausesPnr($dateReport, $productReport);
                                        //var_dump($excludePnr[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]["Sobre Producción"]);
                                        //var_dump($unrealizedProduction["total_day"]);
                                        //var_dump($excludePnr[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]["Sobre Producción"]['day']);
                                        $unrealizedProduction["total_day"] = $unrealizedProduction["total_day"] - $excludePnr[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]["Sobre Producción"]['day'];
                                        $unrealizedProduction["total_month"] = $unrealizedProduction["total_month"] - $excludePnr[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]["Sobre Producción"]['month'];
                                        //var_dump($unrealizedProduction["total_month"]);
                                        //var_dump($excludePnr[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]["Sobre Producción"]['month']);
                                        $unrealizedProduction["total_year"] = ($unrealizedProduction["total_year"] - $excludePnr[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]["Sobre Producción"]['year']);

                                    } else if($overProduction==2) { 
                                        #$unrealizedProduction = $productReport->getSummaryUnrealizedProductionsFilterCause($dateReport);
                                        $excludePnr = $productReportService->getArrayByDateFromInternalCausesPnr($dateReport, $productReport);
                                        //var_dump($excludePnr[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]["Sobre Producción"]);
                                        //var_dump($unrealizedProduction["total_day"]);
                                        //var_dump($excludePnr[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]["Sobre Producción"]['day']);
                                        $unrealizedProduction["total_day"] = ($unrealizedProduction["total_day"] - $excludePnr[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]["Sobre Producción"]['day'])-$excludePnr[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]["Sobre Producción"]['day'];
                                        $unrealizedProduction["total_month"] = ($unrealizedProduction["total_month"] - $excludePnr[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]["Sobre Producción"]['month'])-$excludePnr[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]["Sobre Producción"]['month'];
                                        //var_dump($unrealizedProduction["total_month"]);
                                        //var_dump($excludePnr[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]["Sobre Producción"]['month']);
                                        $unrealizedProduction["total_year"] = ($unrealizedProduction["total_year"] - $excludePnr[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]["Sobre Producción"]['year'])-$excludePnr[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]["Sobre Producción"]['year'];
                                    } else {

                                        $unrealizedProduction["total_day"] = $unrealizedProduction["total_day"];
                                        $unrealizedProduction["total_month"] = $unrealizedProduction["total_month"];
                                        $unrealizedProduction["total_year"] = $unrealizedProduction["total_year"];
                                    }
                                    
                                    /*$unrealizedProduction = $productReport->getSummaryUnrealizedProductionsFilterCause($dateReport);
                                    $excludePnr = $productReportService->getArrayByDateFromInternalCausesPnr($dateReport, $productReport);
                                    //var_dump($excludePnr[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]["Sobre Producción"]);
                                    //var_dump($unrealizedProduction["total_day"]);
                                    //var_dump($excludePnr[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]["Sobre Producción"]['day']);
                                    $unrealizedProduction["total_day"] = $unrealizedProduction["total_day"] - $excludePnr[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]["Sobre Producción"]['day'];
                                    $unrealizedProduction["total_month"] = $unrealizedProduction["total_month"] - $excludePnr[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]["Sobre Producción"]['month'];
                                    //var_dump($unrealizedProduction["total_month"]);
                                    //var_dump($excludePnr[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]["Sobre Producción"]['month']);
                                    $unrealizedProduction["total_year"] = ($unrealizedProduction["total_year"] - $excludePnr[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]["Sobre Producción"]['year']);
                                    //var_dump($unrealizedProduction["total_year"]);
                                    //var_dump($excludePnr[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]["Sobre Producción"]['year']);
*/
                                    

                                    $arrayUnrealizedProduction[$productReportId]["day"] = $unrealizedProduction["total_day"];
                                    $arrayUnrealizedProduction[$productReportId]["month"] = $unrealizedProduction["total_month"];
                                    $arrayUnrealizedProduction[$productReportId]["year"] = $unrealizedProduction["total_year"];

                                    $totalUnrealizedProduction["day"] += $unrealizedProduction["total_day"];
                                    $totalUnrealizedProduction["month"] += $unrealizedProduction["total_month"];
                                    $totalUnrealizedProduction["year"] += $unrealizedProduction["total_year"];
                                }
                            }//FIN PNR
                            //INVENTARIO
                            foreach ($plantReport->getProductsReport() as $productReport) {
                            $productReportsObjects[] = $productReport;
                                if (!$productReport->getIsGroup()) {
                                    $productId = $productReport->getProduct()->getId();
                                    $Inventory = $productReport->getSummaryInventory($dateReport);
                                    $totalInventory["day"] += $Inventory["total_day"];
                                    $totalInventory["day_preview"] += $Inventory["total_month"];

                                    $arrayInventory[] = array(
                                        "productName" => $productReport->getProduct()->getName() . " (" . $productReport->getProduct()->getProductUnit()->getUnit() . ")",
                                        "day" => $Inventory["total_day"],
                                        "day_preview" => $Inventory["total_month"]
                                    );
                                }
                            }//FIN INVENTARIO
                        }//PLANT REPORT
                    }//REPORT TEMPLATE
//                $keyPrimary = array_keys($arrayRawMaterial);
//                foreach ($keyPrimary as $kp) {
//                    $keySecond = array_keys($arrayRawMaterial[$kp]);
//                    foreach ($keySecond as $ks) {
//                        if (gettype($arrayRawMaterial[$kp][$ks]) != "string") {
//                            //echo($arrayRawMaterial[$kp][$ks] . "\n");
//                            $arrayRawMaterial[$kp][$ks] = number_format($arrayRawMaterial[$kp][$ks], 2, ",", ".");
//                        }
//                    }
//                }
                    //die();
                    $reportService = $this->getProductReportService();
                    $graphicsDays = $reportService->generateColumn3dLinery(array("caption" => "Producción por Dia", "subCaption" => "Valores Expresados en TM"), $dataProductsReports, array("range" => $byRange, "dateFrom" => $dateFrom, "dateEnd" => $dateEnd), $dateReport, $typeReport, "getSummaryDay", "plan", "real");
                    $graphicsMonth = $reportService->generateColumn3dLinery(array("caption" => "Producción por Mes", "subCaption" => "Valores Expresados en TM"), $dataProductsReports, array("range" => $byRange, "dateFrom" => $dateFrom, "dateEnd" => $dateEnd), $dateReport, $typeReport, "getSummaryMonth", "plan_acumulated", "real_acumulated");
                    $graphicsYear = $reportService->generateColumn3dLinery(array("caption" => "Producción por Año", "subCaption" => "Valores Expresados en MTM"), $dataProductsReports, array("range" => $byRange, "dateFrom" => $dateFrom, "dateEnd" => $dateEnd), $dateReport, $typeReport, "getSummaryYear", "plan_acumulated", "real_acumulated", 1000);


                    $data = array(
                        'productsReport' => "",
                        'dateReport' => $dateReport,
                        'production' => $summaryProducction,
                        'totalProduction' => $summaryProductionTotals,
                        'observations' => $observations,
                        'rawMaterials' => $arrayRawMaterial,
                        'totalRawMaterial' => $arrayRawMaterialTotals,
                        'consumerServices' => $arrayConsumerServices,
                        'unrealizedProductions' => $arrayUnrealizedProduction,
                        'inventorys' => $arrayInventory,
                        //'observation' => $arrayObservation,
                        'plantsNames' => $plants,
                        'typeReport' => $typeReport,
                        'plantReportId' => $plantReportId,
                        'form' => $form->createView(),
                        'showDay' => $showDay,
                        'showMonth' => $showMonth,
                        'showYear' => $showYear,
                        'byRange' => $byRange,
                        'showProduction' => $showProduction,
                        'showRawMaterial' => $showRawMaterial,
                        'showPnr' => $showPnr,
                        'showService' => $showService,
                        'showInventory' => $showInventory,
                        'showObservation' => $showObservation,
                        //'withDetails' => $withDetails,
                        'dateFrom' => $dateFrom,
                        'dateEnd' => $dateEnd,
                        'typeReport' => $typeReport,
                        //"graphicRange" => $graphicProducctionRange,
                        "securityService" => $this->getSecurityService(),
                        //"plant" => $plant,
                        //"tools" => $tools,
                        "startDatePeriod" => $startDatePeriod,
                        "endDatePeriod" => $endDatePeriod,
                        "groupsPlants" => false,
                        "graphicsDays" => $graphicsDays,
                        "graphicsMonth" => $graphicsMonth,
                        "graphicsYear" => $graphicsYear
                    );
                    
                    if ($exportToPdf == 1) {
                        $pdf = new \Pequiven\SEIPBundle\Model\PDF\NewSeipPdf('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
                        $pdf->setPrintLineFooter(false);
                        $pdf->setContainer($this->container);
                        $pdf->setPeriod($this->getPeriodService()->getPeriodActive());
                        $pdf->setFooterText($this->trans('pequiven_seip.message_footer', array(), 'PequivenSEIPBundle'));

                        // set document information
                        $pdf->SetCreator(PDF_CREATOR);
                        $pdf->SetAuthor('SEIP');
                        $pdf->setTitle('Reporte de Produccion');
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
                        //$pdf->SetFont('times', 'BI', 12);
                        // add a page
                        $pdf->AddPage();

                        // set some text to print
                        if ($byRange) {
                            $html = $this->renderView('PequivenSEIPBundle:DataLoad/ReportTemplate:vizualice_data_by_range.html.twig', $data);
                        } else {
                            $html = $this->renderView('PequivenSEIPBundle:DataLoad/ReportTemplate:vizualice_data.html.twig', $data);
                        }
                        // print a block of text using Write()
                        $pdf->writeHTML($html, true, false, true, false, '');

                        //$pdf->Output('Reporte del dia'.'.pdf', 'I');
                        $pdf->Output('Reporte de Produccion' . '.pdf', 'D');
                    } elseif ($exportToPdf == 2) {
                        
                        $sections = array(
                            "production" => $showProduction,
                            "rawMaterial" => $showRawMaterial,
                            "services" => $showService,
                            "inventory" => $showInventory,
                            "pnr" => $showPnr,
                            "observations" => $showObservation
                        );
                        
                        if ($byRange) {
                            $production = array(
                                "production" => $summaryProducction,
                                "totalProduction" => $summaryProductionTotals,
                                "rawMaterial" => $arrayRawMaterial,
                                "consumerPlanningServices" => $arrayConsumerServices,
                                "unrealizedProducction" => $arrayUnrealizedProduction,
                                "inventory" => $arrayInventory,
                                "observation" => $observations,
                                "plants" => $plants
                            );

                            $this->ExportExcelActionByRange($production, $sections);
                        } else {
                            $this->exportExcelAction($productReportsObjects, $typeReport, $dateReport, $rawMaterialConsumptionPlanningObjects, $consumerPlanningServiceObjects, $plants, $sections, $totalConsumerServices);
                        }
                    } else {

                        $view = $this
                                ->view()
                                ->setTemplate($this->config->getTemplate('reportVisualize.html'))
                        ;
                        $view->setData($data);

                        return $this->handleView($view);
                    }

//                    $view = $this
//                            ->view()
//                            ->setTemplate($this->config->getTemplate('reportVisualize.html'))
//                    ;
//                    $view->setData($data);
//
//                    return $this->handleView($view);
                } else {//POR GRUPO DE PLANTAS Y REPORTE HASTA LA FECHA
                    //POR GRUPO DE PLANTAS Y REPORTE HASTA LA FECHA
                    ////POR GRUPO DE PLANTAS Y REPORTE HASTA LA FECHA
                    //
                    $summaryProduction = array();
                    $arrayConsumerServices = array();
                    $arrayUnrealizedProduction = array();
                    $arrayInventory = array();
                    $groupsCount = 0;


                    //VARS PNR
                    $dayPnr = 0.0;
                    $monthPnr = 0.0;
                    $yearPnr = 0.0;

                    //VARS INVENTORY
                    $dayInventory = 0.0;
                    $monthInventory = 0.0;
                    $yearInventory = 0.0;

                    //ARRAYS
                    $summaryDayGroups = array();
                    $summaryMonthGroups = array();
                    $summaryYearGroups = array();
                    $summaryRawMaterial = array();
                    $summaryConsumeServices = array();

                    $totalsProduction = array(
                        "day"=>array(
                            "plan"=>0.0,
                            "real"=>0.0,
                            "ejec"=>0.0,
                            "perc"=>0.0
                        ),
                        "month"=>array(
                            "plan_month"=>0.0,
                            "plan_acumulated"=>0.0,
                            "real_acumulated"=>0.0,
                            "ejec"=>0.0,
                            "perc"=>0.0
                        ),
                        "year"=>array(
                            "plan_year"=>0.0,
                            "plan_acumulated"=>0.0,
                            "real_acumulated"=>0.0,
                            "ejec"=>0.0,
                            "perc"=>0.0
                        )    
                    );

                    $arrayUnrealizedProduction = array();

                    foreach ($reportTemplates as $reportTemplate) {
                        foreach ($reportTemplate->getPlantReports() as $plantReport) {

                            
                            $childrens = $plantReport->getChildrensGroup();
                            $nameGroup = $plantReport->getNameGroup();
                            //var_dump($nameGroup);

                            if (count($childrens) > 0) {
                                $dayPlan = 0;
                                $dayReal = 0;
                                
                                $MonthPlan = 0;
                                $MonthPlanAcumulated = 0;
                                $MonthRealAcumualated = 0;

                                $yearPlan = 0; 
                                $yearPlanAcumulated = 0;
                                $yearRealAcumualated  = 0;


                                $dayPlanRaw = 0;
                                $dayRealRaw = 0;
                                $monthPlanRaw =0;
                                $monthRealRaw =0;
                                $yearPlanRaw =0;
                                $yearRealRaw =0;

                                $consumeReal = 0.0;
                                $consumePlan = 0.0;
                                $consumeRealMonth = 0.0;
                                $consumePlanMonth = 0.0;
                                $consumeRealYear = 0.0;
                                $consumePlanYear = 0.0;

                                

                                $arrayProdServices = array();
                                
                                $totalPnrPlantGroups = array(
                                    "day"=>0.0,
                                    "month"=>0.0,
                                    "year"=>0.0
                                );
                                
                                
                                foreach ($childrens as $child) {
                                   

                                    foreach ($child->getProductsReport() as $productReport) {
                                        if ($productReport->getIsGroup() == 0) {
                                            //var_dump($productReport->getId());
                                            //SUMMARY DAY
                                            $summaryDay = $productReport->getSummaryDay($dateReport, $typeReport);

                                            $dayPlan+=$summaryDay["plan"];
                                            $dayReal+=$summaryDay["real"];


                                            //ME TRAIGO LAS OBSERVACIONES 
                                            if($summaryDay["observation"] !="")  { 
                                                $observations[] = array(
                                                    "nameProduct" => $productReport->getProduct()->getName() . " (" . $productReport->getPlantReport()->getPlant()->getName() . ")",
                                                    "obs" => $summaryDay["observation"]
                                                );
                                            }

                                            //SUMMARY MONTH
                                            $summaryMonth = $productReport->getSummaryMonth($dateReport, $typeReport);
                                            

                                            $MonthPlan+=$summaryMonth["plan_month"];
                                            $MonthPlanAcumulated+=$summaryMonth["plan_acumulated"];
                                            $MonthRealAcumualated+=$summaryMonth["real_acumulated"];


                                            //SUMMARY YEAR
                                            $summaryYear = $productReport->getSummaryYear($dateReport, $typeReport);
                                            
                                            $yearPlan+=$summaryYear["plan_year"];
                                            $yearPlanAcumulated+=$summaryYear["plan_acumulated"];
                                            $yearRealAcumualated+=$summaryYear["real_acumulated"];
                                            

                                            $cont = 0;

                                            foreach ($productReport->getRawMaterialConsumptionPlannings() as $rawMaterial) {
                                                $rawMaterialConsumptionPlanningObjects[] = $rawMaterial;
                                                if ($rawMaterial->getProduct()->getIsRawMaterial()) {
                                                    $rawMaterialResult = $rawMaterial->getSummary($dateReport);
                                                    $idProduct = $rawMaterial->getProduct()->getId();


                                                    if (!in_array($idProduct, $arrayIdProducts)) {
                                                        $arrayIdProducts[] = $idProduct;
                                                        //$n = $rawMaterial->getProductReport()->getPlantReport()->getPlant();
                                                        $arrayRawMaterial[] = array(
                                                            "id" => $rawMaterial->getProduct()->getId(),
                                                            "productName" => $rawMaterial->getProduct()->getName() . " (" . $rawMaterial->getProduct()->getProductUnit()->getUnit() . ")",
                                                            //"productName" => $n,
                                                            "plan" => number_format($rawMaterialResult["total_day_plan"], 2, ",", "."),
                                                            "real" => number_format($rawMaterialResult["total_day"], 2, ",", "."),
                                                            "plan_month" => number_format($rawMaterialResult["total_month_plan"], 2, ",", "."),
                                                            "real_month" => number_format($rawMaterialResult["total_month"], 2, ",", "."),
                                                            "plan_year" => number_format($rawMaterialResult["total_year_plan"], 2, ",", "."),
                                                            "real_year" => number_format($rawMaterialResult["total_year"], 2, ",", ".")
                                                        );
                                                    } else {
                                                        $indice = array_search($idProduct, $arrayIdProducts);

                                                        //var_dump($rawMaterial->getProduct()->getName() . " | nuevo: " . $arrayRawMaterial[$indice]["real_year"] . "- suma: " . $rawMaterialResult["total_year"]);
                                                        $arrayRawMaterial[$indice]["plan"] = $arrayRawMaterial[$indice]["plan"] + $rawMaterialResult["total_day_plan"];
                                                        $arrayRawMaterial[$indice]["real"] = $arrayRawMaterial[$indice]["real"] + $rawMaterialResult["total_day"];
                                                        $arrayRawMaterial[$indice]["plan_month"] = $arrayRawMaterial[$indice]["plan_month"] + $rawMaterialResult["total_month_plan"];
                                                        $arrayRawMaterial[$indice]["real_month"] = $arrayRawMaterial[$indice]["real_month"] + $rawMaterialResult["total_month"];
                                                        $arrayRawMaterial[$indice]["plan_year"] = $arrayRawMaterial[$indice]["plan_year"] + $rawMaterialResult["total_year_plan"];
                                                        $arrayRawMaterial[$indice]["real_year"] = $arrayRawMaterial[$indice]["real_year"] + $rawMaterialResult["total_year"];
                                                    }

                                                    if ($showDay) {
                                                        $arrayRawMaterialTotals["plan"] += $rawMaterialResult["total_day_plan"];
                                                        $arrayRawMaterialTotals["real"] += $rawMaterialResult["total_day"];
                                                    }
                                                    if ($showMonth) {
                                                        $arrayRawMaterialTotals["plan_month"] += $rawMaterialResult["total_month_plan"];
                                                        $arrayRawMaterialTotals["real_month"] += $rawMaterialResult["total_month"];
                                                    }
                                                    if ($showYear) {
                                                        $arrayRawMaterialTotals["plan_year"] += $rawMaterialResult["total_year_plan"];
                                                        $arrayRawMaterialTotals["real_year"] += $rawMaterialResult["total_year"];
                                                    }
                                                    $cont++;
                                                }
                                            }//RAW MATERIAL

                                            
                                        }

                                        

                                    }//FIN DE PRODUCTOS POR PLANT REPORT

                                     //CONSUMO DE SERVICIOS 
                                    foreach ($child->getConsumerPlanningServices() as $consumerPlanningService) {
                                    $consumerPlanningServiceObjects[] = $consumerPlanningService;

                                        $serviceName = $consumerPlanningService->getService()->getName() . " (" . $consumerPlanningService->getService()->getServiceUnit() . ")";
                                        $serviceId = $consumerPlanningService->getService()->getId();

                                        if (!in_array($serviceName, $arrayProdServices)) {
                                            array_push($arrayProdServices, $serviceName);
                                            $arrayConsumerServices[$serviceId] = array(
                                                "productName" => $serviceName,
                                                "plan" => 0.0,
                                                "real" => 0.0,
                                                "plan_month" => 0.0,
                                                "real_month" => 0.0,
                                                "plan_year" => 0.0,
                                                "real_year" => 0.0
                                            );
                                        }
                                        $consumerPlanning = $consumerPlanningService->getSummary($dateReport);
                                        
                                        $arrayConsumerServices[$serviceId]["real"] += $consumerPlanning["total_day"];
                                        $arrayConsumerServices[$serviceId]["plan"] += $consumerPlanning["total_day_plan"];
                                        $arrayConsumerServices[$serviceId]["real_month"] += $consumerPlanning["total_month"];
                                        $arrayConsumerServices[$serviceId]["plan_month"] += $consumerPlanning["total_month_plan"];
                                        $arrayConsumerServices[$serviceId]["real_year"] += $consumerPlanning["total_year"];
                                        $arrayConsumerServices[$serviceId]["plan_year"] += $consumerPlanning["total_year_plan"];
                                    }//FIN CONSUMO DE SERVICIOS
                                    
                                    //PRODUCION NO REALIZADA
                                    $productReportService = $this->getProductReportService();
                                    foreach ($child->getProductsReport() as $productReport) {
                                        if (!$productReport->getIsGroup()) {
                                            $productId = $productReport->getProduct()->getId();
                                            $productReportId = $productReport->getId();

                                            $unrealizedProduction = $productReport->getSummaryUnrealizedProductionsFilterCause($dateReport);
                                            
                                            if($overProduction==1) {
                                                $excludePnr = $productReportService->getArrayByDateFromInternalCausesPnr($dateReport, $productReport);
                                                $totalPnrPlantGroups["day"] += $unrealizedProduction["total_day"] - $excludePnr[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]["Sobre Producción"]['day'];

                                                $totalPnrPlantGroups["month"] += $unrealizedProduction["total_month"] - $excludePnr[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]["Sobre Producción"]['month'];

                                                $totalPnrPlantGroups["year"] += ($unrealizedProduction["total_year"] - $excludePnr[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]["Sobre Producción"]['year']);

                                            } else  if($overProduction==2) {
                                                $excludePnr = $productReportService->getArrayByDateFromInternalCausesPnr($dateReport, $productReport);
                                                $totalPnrPlantGroups["day"] += ($unrealizedProduction["total_day"] - $excludePnr[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]["Sobre Producción"]['day'])-$excludePnr[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]["Sobre Producción"]['day'];

                                                $totalPnrPlantGroups["month"] += ($unrealizedProduction["total_month"] - $excludePnr[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]["Sobre Producción"]['month'])-$excludePnr[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]["Sobre Producción"]['month'];

                                                $totalPnrPlantGroups["year"] += ($unrealizedProduction["total_year"] - $excludePnr[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]["Sobre Producción"]['year'])-$excludePnr[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]["Sobre Producción"]['year'];
                                            } else {
                                                $totalPnrPlantGroups["day"] += $unrealizedProduction["total_day"];
                                                $totalPnrPlantGroups["month"] += $unrealizedProduction["total_month"];
                                                $totalPnrPlantGroups["year"] += $unrealizedProduction["total_year"];
                                            }
                                                                                        
                                        }
                                    }//FIN PNR

                                    //INVENTARIO
                                    foreach ($child->getProductsReport() as $productReport) {
                                    $productReportsObjects[] = $productReport;
                                        if (!$productReport->getIsGroup()) {
                                            if($productReport->getProduct()->isEnabled()) { 
                                                $productId = $productReport->getProduct()->getId();
                                                $Inventory = $productReport->getSummaryInventory($dateReport);
                                                $totalInventory["day"] += $Inventory["total_day"];
                                                $totalInventory["day_preview"] += $Inventory["total_month"];

                                                $arrayInventory[] = array(
                                                    "productName" => $productReport->getProduct()->getName() . " (" . $productReport->getProduct()->getProductUnit()->getUnit() . ")",
                                                    "day" => $Inventory["total_day"],
                                                    "day_preview" => $Inventory["total_month"]
                                                );
                                            }
                                        }
                                    }//FIN INVENTARIO

                                }                                
                                

                                $groupsCount++;

                                $summaryDayGroups[] = array(
                                    "nameGroup"=>$nameGroup,
                                    "plan"=>$this->setNumberFormat($dayPlan),
                                    "real"=>$this->setNumberFormat($dayReal),
                                    "percentaje"=>0.0,
                                    "pnr"=>0.0,
                                    "ejec"=>$this->getEjecution($dayPlan,$dayReal),
                                    "var"=>$this->getVariation($dayPlan,$dayReal)
                                );
                                $totalsProduction["day"]["plan"] += $dayPlan;
                                $totalsProduction["day"]["real"] += $dayReal;
                                


                                $summaryMonthGroups[] = array(
                                    "nameGroup"=>$nameGroup,
                                    "plan_month"=>$this->setNumberFormat($MonthPlan),
                                    "plan_acumulated"=>$this->setNumberFormat($MonthPlanAcumulated),
                                    "real_acumulated"=>$this->setNumberFormat($MonthRealAcumualated),
                                    "percentaje"=>0.0,
                                    "pnr"=>0.0,
                                    "ejecution"=>$this->getEjecution($MonthPlanAcumulated,$MonthRealAcumualated),
                                    "var"=>$this->getVariation($MonthPlanAcumulated,$MonthRealAcumualated)
                                );
                                $totalsProduction["month"]["plan_month"] += $MonthPlan;
                                $totalsProduction["month"]["plan_acumulated"] += $MonthPlanAcumulated;
                                $totalsProduction["month"]["real_acumulated"] += $MonthRealAcumualated;
                                

                                $summaryYearGroups[] = array(
                                    "nameGroup"=>$nameGroup,
                                    "plan_year"=>$this->setNumberFormat($yearPlan),
                                    "plan_acumulated"=>$this->setNumberFormat($yearPlanAcumulated),
                                    "real_acumulated"=>$this->setNumberFormat($yearRealAcumualated),
                                    "percentaje"=>0.0,
                                    "pnr"=>0.0,
                                    "ejecution"=>$this->getEjecution($yearPlanAcumulated,$yearRealAcumualated),
                                    "var"=>$this->getVariation($yearPlanAcumulated,$yearRealAcumualated)
                                );
                                $totalsProduction["year"]["plan_year"] += $yearPlan;
                                $totalsProduction["year"]["plan_acumulated"] += $yearPlanAcumulated;
                                $totalsProduction["year"]["real_acumulated"] += $yearRealAcumualated;


                                //PNR AGRUPADA
                                $arrayUnrealizedProduction[] = array(
                                    "nameGroup"=>$nameGroup,
                                    "day"=>$totalPnrPlantGroups["day"],
                                    "month"=>$totalPnrPlantGroups["month"],
                                    "year"=>$totalPnrPlantGroups["year"]
                                );
                               

                            }
                           
                        }
                    }
                }   

                
                //DIA
                $totalsProduction["day"]["ejec"] = $this->getEjecution($totalsProduction["day"]["plan"],$totalsProduction["day"]["real"],false);
                $totalsProduction["day"]["perc"] = $this->getVariation($totalsProduction["day"]["plan"],$totalsProduction["day"]["real"],false);

                //MES
                $totalsProduction["month"]["ejec"] = $this->getEjecution($totalsProduction["month"]["plan_acumulated"],$totalsProduction["month"]["real_acumulated"],false);
                $totalsProduction["month"]["perc"] = $this->getVariation($totalsProduction["month"]["plan_acumulated"],$totalsProduction["month"]["real_acumulated"],false);

                //AÑO
                $totalsProduction["year"]["ejec"] = $this->getEjecution($totalsProduction["year"]["plan_acumulated"],$totalsProduction["year"]["real_acumulated"],false);
                $totalsProduction["year"]["perc"] = $this->getVariation($totalsProduction["year"]["plan_acumulated"],$totalsProduction["year"]["real_acumulated"],false);

                $summaryProduction["day"] = $summaryDayGroups;
                $summaryProduction["month"] = $summaryMonthGroups;
                $summaryProduction["year"] = $summaryYearGroups;

                $reportService = $this->getProductReportService();

                $graphicsDays = $reportService->generateColumn3dLineryPerPlantGroups(array("caption" => "Producción por Dia", "subCaption" => "Valores Expresados en TM","range"=>$byRange), $summaryProduction, array("range" => $byRange, "dateFrom" => $dateFrom, "dateEnd" => $dateEnd),"day", "plan", "real");

                $graphicsMonth = $reportService->generateColumn3dLineryPerPlantGroups(array("caption" => "Producción por Mes", "subCaption" => "Valores Expresados en TM","range"=>$byRange), $summaryProduction, array("range" => $byRange, "dateFrom" => $dateFrom, "dateEnd" => $dateEnd),"month", "plan_acumulated", "real_acumulated");

                $graphicsYear = $reportService->generateColumn3dLineryPerPlantGroups(array("caption" => "Producción por Mes", "subCaption" => "Valores Expresados en TM","range"=>$byRange), $summaryProduction, array("range" => $byRange, "dateFrom" => $dateFrom, "dateEnd" => $dateEnd),"year", "plan_acumulated", "real_acumulated");



                $data = array(
                    'productsReport' => "",
                    'dateReport' => $dateReport,
                    'production' => $summaryProduction,
                    'totalProduction' => $totalsProduction,
                    'observations' => $observations,
                    'rawMaterials' => $arrayRawMaterial,
                    'consumerServices' => $arrayConsumerServices,
                    'unrealizedProductions' => $arrayUnrealizedProduction,
                    'inventorys' => $arrayInventory,
                    'typeReport' => $typeReport,
                    'plantReportId' => $plantReportId,
                    'form' => $form->createView(),
                    'showDay' => $showDay,
                    'showMonth' => $showMonth,
                    'showYear' => $showYear,
                    'byRange' => $byRange,
                    'showProduction' => $showProduction,
                    'showRawMaterial' => $showRawMaterial,
                    'showPnr' => $showPnr,
                    'showService' => $showService,
                    'showInventory' => $showInventory,
                    'showObservation' => $showObservation,
                    'dateFrom' => $dateFrom,
                    'dateEnd' => $dateEnd,
                    'typeReport' => $typeReport,
                    "securityService" => $this->getSecurityService(),
                    "startDatePeriod" => $startDatePeriod,
                    "endDatePeriod" => $endDatePeriod,
                    "groupsPlants" => $groupsPlants,
                    "graphicsDays"=>$graphicsDays,
                    "graphicsMonth"=>$graphicsMonth,
                    "graphicsYear"=>$graphicsYear
                );
                
                $view = $this
                        ->view()
                        ->setTemplate($this->config->getTemplate('reportVisualize.html'))
                ;
                $view->setData($data);

                return $this->handleView($view);
               
                //return $this->handleView($view);
            } else {
                //FILTRO POR RANGO SIN GRUPO DE PLANTAS

                if (!$groupsPlants) {
                    //FILTRO POR RANGO 
                    $dateDesde = $dateFrom->format("U");
                    $dateHasta = $dateEnd->format("U");

                    $totalProdPlan = 0;
                    $totalProdReal = 0;

                   // $exportToPdf = false;
                    $arrayIdProductsByRange = array();
                    $summaryProductionTotals = array(
                        "ppto" => 0.0,
                        "real" => 0.0,
                        "ejec" => 0.0,
                        "var" => 0.0
                    );
                    $rawMaterialRangeTotals = array(
                        "ppto" => 0.0,
                        "real" => 0.0,
                        "ejec" => 0.0,
                        "var" => 0.0
                    );
                    $serviceRangeTotals = array(
                        "ppto" => 0.0,
                        "real" => 0.0,
                        "ejec" => 0.0,
                        "var" => 0.0
                    );
                    $arrayObservation = array();
                    #$arrayProduction = array();
                    $summaryProduction = array();
                    $arrayProdServices = array();

                    $arrayNamesUnrealizedProduction = array();
                    $plants = array();

                    foreach ($reportTemplates as $reportTemplate) {
                        //var_dump($reportTemplate->getShortName());
                        $plants[] = $reportTemplate->getName();
                        foreach ($reportTemplate->getPlantReports() as $plantReport) {

                            //PRODUCTS REPORTS
                            foreach ($plantReport->getProductsReport() as $productReport) {
                                if (!$productReport->getIsGroup()) {

                                    $i = $dateDesde;
                                    $rs = array();
                                    $totalPlan = $totalReal = $totalPercentaje = $totalPnr = 0.0;
                                    $totalRawPlan = $totalRawReal = 0.0;
                                    while ($i != ($dateHasta + 86400)) {
                                        $timeNormal = new \DateTime(date("Y-m-d", $i));
                                        //RESULTADOS DE PRODUCCION
                                        $rs = $productReport->getSummaryDay($timeNormal, $typeReport);
                                        $totalPlan += $rs["plan"];
                                        $totalReal += $rs["real"];
                                        $totalProdPlan += $rs["plan"];
                                        $totalProdReal += $rs["real"];

                                        $totalPercentaje += $rs["percentage"];
                                        $totalPnr += $rs["pnr"];
                                        $rs["plan"] = $totalPlan;
                                        $rs["real"] = $totalReal;
                                        if ($totalPlan > 0) {
                                            $rs["percentage"] = ($totalReal * 100) / $totalPlan;
                                        } else {
                                            $rs["percentage"] = 0.0;
                                            $rs["pnr"] = 0.0;
                                        }
                                        $pnr = $totalPlan - $totalReal;
                                        if ($pnr > 0) {
                                            $rs["pnr"] = $pnr;
                                        } else {
                                            $rs["pnr"] = 0.0;
                                        }
                                        //var_dump($rs["observation"]);
                                        

                                        //Verifica si va a exportar y obvia las observaciones vacías.
                                        if ($exportToPdf) {
                                            if ($rs["observation"] != "" || is_null($rs["observation"])) {
                                                $arrayObservation[] = array("day" => $timeNormal, "productName" => $productReport->getProduct()->getName() . " (" . $productReport->getPlantReport()->getPlant()->getName() . ")", "observation" => $rs["observation"]);
                                            }
                                        } else {
                                            $arrayObservation[] = array("day" => $timeNormal, "productName" => $productReport->getProduct()->getName() . " (" . $productReport->getPlantReport()->getPlant()->getName() . ")", "observation" => $rs["observation"]);
                                        }
                                        $i = $i + 86400; //VOY RECORRIENDO DIA POR DIA
                                        //TOTALES PRODUCCTION
                                    }
                                    //PRODUCTION 
                                    $rs["productName"] = $productReport->getProduct()->getName() . " (" . $productReport->getProduct()->getProductUnit()->getUnit() . ")";

                                    

                                    $summaryProductionTotals["ppto"] +=$totalPlan;
                                    $summaryProductionTotals["real"] +=$totalReal; 
                                    #$summaryProductionTotals["ejec"] +=$ejectRange;
                                    #$summaryProductionTotals["var"] +=$varRange;


                                    $summaryProduction[] = $rs;

                                    //CONSUMO DE MATERIA PRIMA
                                    //VERIFICA SI EL PRODUCTO ES MATERIA PRIMA


                                    foreach ($productReport->getRawMaterialConsumptionPlannings() as $rawMaterial) {
                                        if ($rawMaterial->getProduct()->getIsRawMaterial()) {
                                            $totalRawDayPlan = 0.0;
                                            $totalRawDayReal = 0.0;

                                            $i = $dateDesde;


                                            while ($i != ($dateHasta + 86400)) {
                                                $timeNormal = new \DateTime(date("Y-m-d", $i));
                                                $rawMaterialResult = $rawMaterial->getSummary($timeNormal);

                                                $totalRawDayPlan += $rawMaterialResult["total_day_plan"];
                                                $totalRawDayReal += $rawMaterialResult["total_day"];
                                                $totalRawPlan += $rawMaterialResult["total_day_plan"];
                                                $totalRawReal += $rawMaterialResult["total_day"];

                                                $i = $i + 86400; //VOY RECORRIENDO DIA POR DIA
                                            }
                                            $idProduct = $rawMaterial->getProduct()->getId();

                                            if (!in_array($idProduct, $arrayIdProductsByRange)) {
                                                $arrayIdProductsByRange[] = $idProduct;
                                                //$n = $rawMaterial->getProductReport()->getPlantReport()->getPlant()->getName();
                                                $arrayRawMaterial[] = array(
                                                    "productName" => $rawMaterial->getProduct()->getName() . " (" . $rawMaterial->getProduct()->getProductUnit()->getUnit() . ")",
                                                    "productId" => $rawMaterial->getProduct()->getId(),
                                                    "planRaw" => $totalRawDayPlan,
                                                    "realRaw" => $totalRawDayReal
                                                );
                                            } else {
                                                $indice = array_search($idProduct, $arrayIdProductsByRange);

                                                $arrayRawMaterial[$indice]["planRaw"] = $arrayRawMaterial[$indice]["planRaw"] + $totalRawDayPlan;
                                                $arrayRawMaterial[$indice]["realRaw"] = $arrayRawMaterial[$indice]["realRaw"] + $totalRawDayReal;
                                            }
                                            //TOTALES RAW MATERIAL RANGE
                                            if ($rawMaterialRangeTotals["ppto"] > 0) {
                                                $ejectRange = ($rawMaterialRangeTotals["real"] * 100) / $rawMaterialRangeTotals["ppto"];
                                            } else {
                                                $ejectRange = 0.0;
                                            }

                                            if ($totalRawDayPlan - $totalRawDayReal < 0) {
                                                $varRange = 0;
                                            } else {
                                                $varRange = $totalRawDayPlan - $totalRawDayReal;
                                            }


                                            //TOTALES RAW MATERIAL RANGE 
                                            $rawMaterialRangeTotals["ppto"] += $totalRawDayPlan;
                                            $rawMaterialRangeTotals["real"] += $totalRawDayReal;
                                            $rawMaterialRangeTotals["ejec"] += $ejectRange;
                                            $rawMaterialRangeTotals["var"] += $varRange;
                                        }
                                    }
                                }
                            } //END PRODUCT REPORT RANGE



                            //CONSUMO DE SERVICIOS
                            foreach ($plantReport->getConsumerPlanningServices() as $consumerPlanningService) {
                                $i = $dateDesde;
                                $serviceName = $consumerPlanningService->getService()->getName() . " (" . $consumerPlanningService->getService()->getServiceUnit() . ")";
                                $serviceId = $consumerPlanningService->getService()->getId();

                                $totalServicePlan = 0.0;
                                $totalServiceReal = 0.0;

                                if (!in_array($serviceName, $arrayProdServices)) {
                                    array_push($arrayProdServices, $serviceName);
                                    $arrayConsumerServices[$serviceId] = array("productName" => $serviceName, "plan" => 0.0, "real" => 0.0);
                                }
                                while ($i != ($dateHasta + 86400)) {

                                    $timeNormal = new \DateTime(date("Y-m-d", $i));
                                    $consumerPlanning = $consumerPlanningService->getSummary($timeNormal);
                                    $totalServicePlan +=$consumerPlanning["total_day_plan"];
                                    $totalServiceReal +=$consumerPlanning["total_day"];

                                    $arrayConsumerServices[$serviceId]["real"] += $consumerPlanning["total_day"];
                                    $arrayConsumerServices[$serviceId]["plan"] += $consumerPlanning["total_day_plan"];

                                    $i += 86400; //VOY RECORRIENDO DIA POR DIA
                                }

                                //TOTALES CONSUMO DE SERVICIOS
                                if ($serviceRangeTotals["ppto"] > 0) {
                                    $ejectRangeService = ($serviceRangeTotals["real"] * 100) / $serviceRangeTotals["ppto"];
                                } else {
                                    $ejectRangeService = 0.0;
                                }

                                if ($totalServicePlan - $totalServiceReal < 0) {
                                    $varRangeService = 0;
                                } else {
                                    $varRangeService = $totalServicePlan - $totalServiceReal;
                                }



                                $serviceRangeTotals["ppto"] += $totalServicePlan;
                                $serviceRangeTotals["real"] += $totalServiceReal;
                                $serviceRangeTotals["ejec"] += $ejectRangeService;
                                $serviceRangeTotals["var"] += $varRangeService;
                            }

                            //PRODUCION NO REALIZADA
                            $i = $dateDesde;
                            $productReportService = $this->getProductReportService();
                            foreach ($plantReport->getProductsReport() as $productReport) {
                                if (!$productReport->getIsGroup()) {
                                    $productReportId = $productReport->getId();
                                    if (!in_array($productReportId, $arrayNamesUnrealizedProduction)) {
                                        $arrayNamesUnrealizedProduction[] = $productReportId;
                                        $arrayUnrealizedProduction[$productReportId] = array(
                                            "productName" => $productReport->getName() . " (" . $productReport->getProduct()->getProductUnit()->getUnit() . ")",
                                            "idProduct" => $productReport->getProduct()->getId(),
                                            "idProductReport" => $productReport->getId(),
                                            "idReportTemplate" => $plantReport->getReportTemplate()->getId(),
                                            "total" => 0.0
                                        );
                                    }

                                    while ($i != ($dateHasta + 86400)) {
                                        $timeNormal = new \DateTime(date("Y-m-d", $i));
                                        $unrealizedProduction = $productReport->getSummaryUnrealizedProductions($timeNormal);

                                        //$unrealizedProduction = $productReport->getSummaryUnrealizedProductionsFilterCause($dateReport);
                                        $excludePnr = $productReportService->getArrayByDateFromInternalCausesPnr($timeNormal, $productReport);


                                        if($overProduction==1) {
                                            $arrayUnrealizedProduction[$productReportId]["total"] += $unrealizedProduction["total_day"] - $excludePnr[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]["Sobre Producción"]['day'];
                                        } else if($overProduction==2) {
                                            $arrayUnrealizedProduction[$productReportId]["total"] += ($unrealizedProduction["total_day"] - $excludePnr[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]["Sobre Producción"]['day'])-$excludePnr[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]["Sobre Producción"]['day'];
                                        } else {
                                            $arrayUnrealizedProduction[$productReportId]["total"] += $unrealizedProduction["total_day"];
                                        }

                                        

                                        $i += 86400; //VOY RECORRIENDO DIA POR DIA
                                    }
                                }
                            } //FIN PNR
    //                        var_dump($excludePnr);
    //                        die();


                            //INVENTARIO
                            foreach ($plantReport->getProductsReport() as $productReport) {
                                if (!$productReport->getIsGroup()) {
                                    if($productReport->getProduct()->isEnabled()) { 
                                        $productId = $productReport->getProduct()->getId();
                                        $timeNormal = new \DateTime(date("Y-m-d", $dateHasta));
                                        $Inventory = $productReport->getSummaryInventory($timeNormal);
                                        $arrayInventory[] = array("productName" => $productReport->getProduct()->getName() . " (" . $productReport->getProduct()->getProductUnit()->getUnit() . ")", "total" => $Inventory["total_day"]);
                                    }
                                }
                            }//END INVENTARIO
                        } //END PLANT REPORT RANGE

                        #CALCULO DE PORCENTAJE Y VARIACION DE LOS TOTALES DE PRODUCION
                        if ($summaryProductionTotals["ppto"] > 0) {
                            $ejectRange = ($summaryProductionTotals["real"] * 100) / $summaryProductionTotals["ppto"];
                        } else {
                            $ejectRange = 0.0;
                        }

                        if ($totalPlan - $totalReal < 0) {
                            $varRange = 0;
                        } else {
                            $varRange = $totalPlan - $totalReal;
                        }

                        $summaryProductionTotals["ejec"] +=$ejectRange;
                        $summaryProductionTotals["var"] +=$varRange;

                    } //END REPORT TEMPLATE RANGE
                    
                    $reportService = $this->getProductReportService();
                    $graphicsDays = $reportService->generateColumn3dLinery(array("caption" => "Producción por Dia", "subCaption" => "Valores Expresados en TM"), $summaryProduction, array("range" => $byRange, "dateFrom" => $dateFrom, "dateEnd" => $dateEnd), $dateReport, $typeReport, "getSummaryDay", "plan", "real");


                } else {
                    ////
                    //POR RANGO Y POR GRUPO DE PLANTAS
                    ///

                    $dateDesde = $dateFrom->format("U");
                    $dateHasta = $dateEnd->format("U");

                    $totalProdPlan = 0;
                    $totalProdReal = 0;

                    $summaryProduction = array();
                    $summaryProductionTotals = array();
                    $arrayObservation = array();
                    

                    $arrayIdProductsByRange = array();
             
                    $summaryProducctionRangeTotals = array(
                        "ppto" => 0.0,
                        "real" => 0.0,
                        "ejec" => 0.0,
                        "var" => 0.0
                    );
                    $rawMaterialRangeTotals = array(
                        "ppto" => 0.0,
                        "real" => 0.0,
                        "ejec" => 0.0,
                        "var" => 0.0
                    );
                    $serviceRangeTotals = array(
                        "ppto" => 0.0,
                        "real" => 0.0,
                        "ejec" => 0.0,
                        "var" => 0.0
                    );
                    $arrayObservation = array();
                    $production = array();


                    $arrayNamesUnrealizedProduction = array();
                    $plants = array();
                    $totalPlanProd=0.0;
                    $totalRealProd=0.0;

                    $arrayConsumerServices = array();
                    $arrayUnrealizedProduction = array();                        
                    

                    foreach ($reportTemplates as $reportTemplate) {
                        //var_dump($reportTemplate->getShortName());
                        $plants[] = $reportTemplate->getName();

                        foreach ($reportTemplate->getPlantReports() as $plantReport) {
                            //PRODUCTS REPORTS
                            $childrens = $plantReport->getChildrensGroup();
                            $nameGroup = $plantReport->getNameGroup();


                           $pnrGroup = 0;

                            if(count($childrens)>0) {
                                $planDay = 0.0;
                                $realDay = 0.0;

                                
                                #var_dump($nameGroup);

                                $totalPnrGroup = 0;

                                foreach ($childrens as $child) {
                                    foreach ($child->getProductsReport() as $productReport) {
                                        if (!$productReport->getIsGroup()) {

                                            $i = $dateDesde;
                                            $rs = array();
                                            $totalPlan = $totalReal = $totalPercentaje = $totalPnr = 0.0;
                                            $totalRawPlan = $tiotalRawReal = 0.0;
                                            while ($i != ($dateHasta + 86400)) {
                                                $timeNormal = new \DateTime(date("Y-m-d", $i));
                                                
                                                //RESULTADOS DE PRODUCCION
                                                $rs = $productReport->getSummaryDay($timeNormal, $typeReport);
                                                $planDay+= $rs["plan"];
                                                $realDay+= $rs["real"];
                                                $totalPlanProd += $rs["plan"];
                                                $totalRealProd += $rs["real"];

                                                //Verifica si va a exportar y obvia las observaciones vacías.
                                                if ($exportToPdf) {
                                                    if ($rs["observation"] != "" || is_null($rs["observation"])) {
                                                        $arrayObservation[] = array("day" => $timeNormal, "productName" => $productReport->getProduct()->getName() . " (" . $productReport->getPlantReport()->getPlant()->getName() . ")", "observation" => $rs["observation"]);
                                                    }
                                                } else {
                                                    $arrayObservation[] = array("day" => $timeNormal, "productName" => $productReport->getProduct()->getName() . " (" . $productReport->getPlantReport()->getPlant()->getName() . ")", "observation" => $rs["observation"]);
                                                }
                                                
                                                $i = $i + 86400;
                                            }
                                            
                                        }
                                        //RAW MATERIAL
                                        foreach ($productReport->getRawMaterialConsumptionPlannings() as $rawMaterial) {
                                            if ($rawMaterial->getProduct()->getIsRawMaterial()) {
                                                $totalRawDayPlan = 0.0;
                                                $totalRawDayReal = 0.0;

                                                $i = $dateDesde;

                                                while ($i != ($dateHasta + 86400)) {
                                                    $timeNormal = new \DateTime(date("Y-m-d", $i));
                                                    $rawMaterialResult = $rawMaterial->getSummary($timeNormal);

                                                    $totalRawDayPlan += $rawMaterialResult["total_day_plan"];
                                                    $totalRawDayReal += $rawMaterialResult["total_day"];

                                                    $i = $i + 86400; //VOY RECORRIENDO DIA POR DIA
                                                }
                                                $idProduct = $rawMaterial->getProduct()->getId();

                                                if (!in_array($idProduct, $arrayIdProductsByRange)) {
                                                    $arrayIdProductsByRange[] = $idProduct;
                                                    //$n = $rawMaterial->getProductReport()->getPlantReport()->getPlant()->getName();
                                                    $arrayRawMaterial[] = array(
                                                        "productName" => $rawMaterial->getProduct()->getName() . " (" . $rawMaterial->getProduct()->getProductUnit()->getUnit() . ")",
                                                        "productId" => $rawMaterial->getProduct()->getId(),
                                                        "planRaw" => $totalRawDayPlan,
                                                        "realRaw" => $totalRawDayReal
                                                    );
                                                } else {
                                                    $indice = array_search($idProduct, $arrayIdProductsByRange);

                                                    $arrayRawMaterial[$indice]["planRaw"] = $arrayRawMaterial[$indice]["planRaw"] + $totalRawDayPlan;
                                                    $arrayRawMaterial[$indice]["realRaw"] = $arrayRawMaterial[$indice]["realRaw"] + $totalRawDayReal;
                                                }
                                            }
                                        }
                                        //END RAW MATERIAL

                                    }

                                    //CONSUMO DE SERVICIOS
                                    foreach ($child->getConsumerPlanningServices() as $consumerPlanningService) {
                                        $i = $dateDesde;
                                        $serviceName = $consumerPlanningService->getService()->getName() . " (" . $consumerPlanningService->getService()->getServiceUnit() . ")";
                                        $serviceId = $consumerPlanningService->getService()->getId();

                                        #$totalServicePlan = 0.0;
                                        #$totalServiceReal = 0.0;

                                        if (!in_array($serviceName, $arrayProdServices)) {
                                            array_push($arrayProdServices, $serviceName);
                                            $arrayConsumerServices[$serviceId] = array("productName" => $serviceName, "plan" => 0.0, "real" => 0.0);
                                        }
                                        while ($i != ($dateHasta + 86400)) {

                                            $timeNormal = new \DateTime(date("Y-m-d", $i));
                                            $consumerPlanning = $consumerPlanningService->getSummary($timeNormal);
                                            #var_dump($consumerPlanning);
                                            #$totalServicePlan +=$consumerPlanning["total_day_plan"];
                                            #$totalServiceReal +=$consumerPlanning["total_day"];
                                            #var_dump($consumerPlanning);

                                            $arrayConsumerServices[$serviceId]["real"] += $consumerPlanning["total_day"];
                                            $arrayConsumerServices[$serviceId]["plan"] += $consumerPlanning["total_day_plan"];

                                            $i += 86400; //VOY RECORRIENDO DIA POR DIA
                                        }
                                    }
                                    //CONSUMO SERVICIOS

                                    
                                    //PRODUCION NO REALIZADA
                                    $i = $dateDesde;
                                    $productReportService = $this->getProductReportService();
                                    
                                    #print $nameGroup;

                                    foreach ($child->getProductsReport() as $productReport) {
                                        
                                        #var_dump($productReport->getName());

                                        if (!$productReport->getIsGroup()) {
                                            $productReportId = $productReport->getId();

                                            
                                            while ($i != ($dateHasta + 86400)) {
                                                $timeNormal = new \DateTime(date("Y-m-d", $i));
                                                $unrealizedProduction = $productReport->getSummaryUnrealizedProductions($timeNormal);

                                                //$unrealizedProduction = $productReport->getSummaryUnrealizedProductionsFilterCause($dateReport);
                                                $excludePnr = $productReportService->getArrayByDateFromInternalCausesPnr($timeNormal, $productReport);


                                                if($overProduction==1) {
                                                    #$arrayUnrealizedProduction[$productReportId]["total"] += $unrealizedProduction["total_day"] - $excludePnr[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]["Sobre Producción"]['day'];
                                                    $pnrGroup  += $unrealizedProduction["total_day"] - $excludePnr[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]["Sobre Producción"]['day'];
                                                } else if($overProduction==2) {
                                                    #$arrayUnrealizedProduction[$productReportId]["total"] += ($unrealizedProduction["total_day"] - $excludePnr[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]["Sobre Producción"]['day'])-$excludePnr[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]["Sobre Producción"]['day'];
                                                    $pnrGroup += ($unrealizedProduction["total_day"] - $excludePnr[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]["Sobre Producción"]['day'])-$excludePnr[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]["Sobre Producción"]['day'];
                                                } else {
                                                    #$arrayUnrealizedProduction[$productReportId]["total"] += $unrealizedProduction["total_day"];
                                                    $pnrGroup += $unrealizedProduction["total_day"];
                                                }
                                                $i += 86400; //VOY RECORRIENDO DIA POR DIA
                                            }
                                        }
                                    } //FIN PNR
                                    #var_dump($pnrGroup);
                                    $totalPnrGroup += $pnrGroup;

                                   

                                } 
                                $summaryProduction[] = array (
                                    "nameGroup"=>$nameGroup,
                                    "plan"=>$this->setNumberFormat($planDay),
                                    "real"=>$this->setNumberFormat($realDay),
                                    "ejec"=>$this->getEjecution($planDay,$realDay),
                                    "var"=>$this->getVariation($planDay,$realDay),
                                );
                                $arrayUnrealizedProduction[] = array(
                                    "nameGroup"=>$nameGroup,
                                    "total"=>$totalPnrGroup
                                );                         
                            }
                        }
                    }
                    $summaryProductionTotals = array(
                        "plan"=>$this->setNumberFormat($totalPlanProd),
                        "real"=>$this->setNumberFormat($totalRealProd),
                        "ejec"=>$this->getEjecution($totalPlanProd,$totalRealProd),
                        "var"=>$this->getVariation($totalPlanProd,$totalRealProd)
                    );


                    $reportService = $this->getProductReportService();
                    $graphicProducctionRange = $reportService->generateColumn3dLineryPerRange(
                        array("caption" => "Producción por Dia", "subCaption" => "Valores Expresados en TM"), 
                        $summaryProduction,
                        array("range" => $byRange, "dateFrom" => $dateFrom, "dateEnd" => $dateEnd),
                        1,
                        true
                    );


                }
                
                

                

                $data = array(
                    'productsReport' => "",
                    'form' => $form->createView(),
                    "securityService" => $this->getSecurityService(),
                    "byRange" => true,
                    'production' => $summaryProduction,
                    'totalProduction' => $summaryProductionTotals,
                    "rawMaterial" => $arrayRawMaterial,
                    "totalRawMaterial" => null,
                    "consumerPlanning" => $arrayConsumerServices,
                    "totalConsumeService" => null,
                    "unrealizedProduction" => $arrayUnrealizedProduction,
                    "inventory" => $arrayInventory,
                    "observation" => $arrayObservation,
                    "startDatePeriod" => $startDatePeriod,
                    "endDatePeriod" => $endDatePeriod,
                    'typeReport' => $typeReport,
                    'showDay' => $showDay,
                    'showMonth' => $showMonth,
                    'showYear' => $showYear,
                    'byRange' => $byRange,
                    'showProduction' => $showProduction,
                    'showRawMaterial' => $showRawMaterial,
                    'showPnr' => $showPnr,
                    'showService' => $showService,
                    'showInventory' => $showInventory,
                    'showObservation' => $showObservation,
                    'dateFrom' => $dateFrom,
                    'dateEnd' => $dateEnd,
                    'groupsPlants'=>$groupsPlants,
                    'graphicRange' => $graphicProducctionRange
                );


                if ($exportToPdf == "1") {
                    //var_dump("report pdf");
                
                
                    $pdf = new \Pequiven\SEIPBundle\Model\PDF\NewSeipPdf('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
                    $pdf->setPrintLineFooter(false);
                    $pdf->setContainer($this->container);
                    $pdf->setPeriod($this->getPeriodService()->getPeriodActive());
                    $pdf->setFooterText($this->trans('pequiven_seip.message_footer', array(), 'PequivenSEIPBundle'));

        // set document information
                    $pdf->SetCreator(PDF_CREATOR);
                    $pdf->SetAuthor('SEIP');
                    $pdf->setTitle('Reporte de Produccion');
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
                    if ($byRange) {
                        $html = $this->renderView('PequivenSEIPBundle:DataLoad/ReportTemplate:vizualice_data_by_range.html.twig', $data);
                    } else {
                        $html = $this->renderView('PequivenSEIPBundle:DataLoad/ReportTemplate:vizualice_data.html.twig', $data);
                    }
        // print a block of text using Write()
                    $pdf->writeHTML($html, true, false, true, false, '');

        //            $pdf->Output('Reporte del dia'.'.pdf', 'I');
                    $pdf->Output('Reporte de Produccion' . '.pdf', 'D');
                } else if ($exportToPdf == "2") {

                    $sections = array(
                            "production" => $showProduction,
                            "rawMaterial" => $showRawMaterial,
                            "services" => $showService,
                            "inventory" => $showInventory,
                            "pnr" => $showPnr,
                            "observations" => $showObservation
                        );

                    if ($byRange) {
                        $production = array(
                            "production" => $arrayProduction,
                            "totalProduction" => $summaryProducctionRangeTotals,
                            "rawMaterial" => $arrayRawMaterial,
                            "consumerPlanningServices" => $arrayConsumerServices,
                            "unrealizedProducction" => $arrayUnrealizedProduction,
                            "inventory" => $arrayInventory,
                            "observation" => $arrayObservation,
                            "plants" => $plants
                        );

                        $this->ExportExcelActionByRange($production, $sections);
                    } else {
                        $this->exportExcelAction($productsReport, $typeReport, $dateReport, $rawMaterialConsumptionPlannings, $consumerPlanningServices, $plants, $sections, $totalConsumerServices);
                    }
                } else {

                    $view = $this
                            ->view()
                            ->setTemplate($this->config->getTemplate('reportVisualize.html'))
                    ;
                    $view->setData($data);

                    return $this->handleView($view);
                }





                
            }
        } //FIN DE FORM-SUBMIT

        $data = array(
            'productsReport' => "",
            'form' => $form->createView(),
            "securityService" => $this->getSecurityService(),
            "byRange" => false,
            "startDatePeriod" => $startDatePeriod,
            "endDatePeriod" => $endDatePeriod,
            'production' => null,
            'typeReport' => null,
            'showDay' => $showDay,
            'showMonth' => $showMonth,
            'showYear' => $showYear,
            'byRange' => $byRange,
            'showProduction' => $showProduction,
            'showRawMaterial' => $showRawMaterial,
            'showPnr' => $showPnr,
            'showService' => $showService,
            'showInventory' => $showInventory,
            'showObservation' => $showObservation,
            'dateFrom' => $dateFrom,
            'dateEnd' => $dateEnd,
            'groupsPlants' => null,
        );


        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('reportVisualize.html'))
        ;
        $view->setData($data);

        return $this->handleView($view);
    }



    public function ExportExcelActionByRange($data, $sections) {

        $days = array(
            "Domingo",
            "Lunes",
            "Martes",
            "Miercoles",
            "Jueves",
            "Viernes",
            "Sábado"
        );

        $path = $this->get('kernel')->locateResource('@PequivenObjetiveBundle/Resources/skeleton/reporte_produccion.xls');
        $now = new \DateTime();
        $objPHPExcel = \PHPExcel_IOFactory::load($path);
        $objPHPExcel
                ->getProperties()
                ->setCreator("SEIP")
                ->setTitle('SEIP - Reporte De Producción')
                ->setCreated()
                ->setLastModifiedBy('SEIP')
                ->setModified()
        ;
        $objPHPExcel->setActiveSheetIndex(0);
        $activeSheet = $objPHPExcel->getActiveSheet();


        $styleArray = array(
            'font' => array(
                'bold' => true,
                'color' => array("rgb" => 'FF0000')
            ),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER
            )
        );
        $activeSheet->getStyle("H2")->applyFromArray($styleArray);
        $activeSheet->setCellValue("H2", $days[date("N")-1] . ", " . date("d/m/Y"));

        $row = 4;

//COMPLEJOS

        $styleArray = array(
            'font' => array(
                'bold' => true,
            )
        );
        $plants = $data["plants"];
        foreach ($plants as $plant) {
            $activeSheet->getStyle("B" . $row)->applyFromArray($styleArray);
            $activeSheet->setCellValue("B" . $row, $plant);
            $activeSheet->mergeCells("B" . $row . ":" . "F" . $row);
            $row++;
        }

        if ($sections["production"]) {
            //REGISTROS PRODDUCION
            $impressOperacion = array(
                "title" => "Producción",
                "col" => array("B", "C", "D", "E", "F"),
                "campos" => array("Producto", "PPTO", "REAL", "EJEC(%)", "VAR"),
                "fieldsShow" => array("productName", "plan", "real", "percentage", "pnr"),
                "rowStart" => $row + 1,
                "plan" => "plan",
                "real" => "real",
                "color" => "55b34a"
            );

            $this->setFormatTitle($impressOperacion, $activeSheet, $row);
            $row = $this->setTitlesRows($activeSheet, $impressOperacion, $row);
            $production = $data["production"];
            $totalProduction = $data["totalProduction"];
            //var_dump($totalProduction);

            foreach ($production as $prod) {
                for ($i = 0; $i < count($impressOperacion["col"]); $i++) {
                    $cell = $impressOperacion["col"][$i] . $row;
                    if ($i != 0) {
                        $field = number_format((float) $prod[$impressOperacion["fieldsShow"][$i]], 2, ',', '.');
                    } else {
                        $field = $prod[$impressOperacion["fieldsShow"][$i]];
                    }
                    $activeSheet->setCellValue($cell, $field);
                }
                $row++;
            }

            //AGREGA TOTALES
            $styleArray = array(
                'font' => array(
                    'bold' => true,
                ),
                'fill' => array(
                    'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                        'rgb' => "dddddd"
                    )
                )
            );

            $activeSheet->getStyle("B" . $row . ":" . "F" . $row)->applyFromArray($styleArray);

            //var_dump($totalProduction);
            $temp = array();

            //CONVIERTE EL VECTOR INDEXADO EN UN VECTOR NORMAL PARA Q PUEDA LLAMAR LOS VALORES
            foreach ($totalProduction as $value ) {
                $temp[] = $value;
            }

            for ($x = 0; $x < count($impressOperacion["col"]); $x++) {
                if ($impressOperacion["col"][$x] == "B") {
                    $activeSheet->setCellValue($impressOperacion["col"][$x] . $row, "Totales");
                } else {
                    $activeSheet->setCellValue($impressOperacion["col"][$x] . $row, number_format($temp[$x-1], 2, ",", "."));
                }
            }
            $row++;
        }
        
        

        if ($sections["rawMaterial"]) {
//REGISTRO MATERIA PRIMA
            $rawMaterialData = array(
                "title" => "Consumo de Materia Prima",
                "col" => array("B", "C", "D"),
                "campos" => array("Producto", "PPTO", "REAL"),
                "fieldsShow" => array("productName", "planRaw", "realRaw"),
                "rowStart" => $row,
                "plan" => "plan",
                "real" => "real",
                "color" => "ffaa15"
            );
            $this->setFormatTitle($rawMaterialData, $activeSheet, $row);
            $row = $this->setTitlesRows($activeSheet, $rawMaterialData, $row);

            $rawMaterial = $data["rawMaterial"];
            foreach ($rawMaterial as $raw) {
                for ($i = 0; $i < count($rawMaterialData["col"]); $i++) {
                    $cell = $rawMaterialData["col"][$i] . $row;
                    if ($i != 0) {
                        $field = number_format((float) $raw[$rawMaterialData["fieldsShow"][$i]], 2, ',', '.');
                    } else {
                        $field = $raw[$rawMaterialData["fieldsShow"][$i]];
                    }
                    $activeSheet->setCellValue($cell, $field);
                }
                $row++;
            }
        }

        if ($sections["services"]) {
//REGISTRO CONSUMO DE SERVICIOS
            $consumerServiceData = array(
                "title" => "Consumo de Servicios",
                "col" => array("B", "C", "D"),
                "campos" => array("Producto", "PPTO", "REAL"),
                "fieldsShow" => array("productName", "plan", "real"),
                "rowStart" => $row,
                "plan" => "plan",
                "real" => "real",
                "color" => "98bfbf"
            );

            $this->setFormatTitle($consumerServiceData, $activeSheet, $row);
            $row = $this->setTitlesRows($activeSheet, $consumerServiceData, $row);

            $consumerPlanningService = $data["consumerPlanningServices"];
            foreach ($consumerPlanningService as $consume) {
                for ($i = 0; $i < count($consumerServiceData["col"]); $i++) {
                    $cell = $consumerServiceData["col"][$i] . $row;
                    if ($i != 0) {
                        $field = number_format((float) $consume[$consumerServiceData["fieldsShow"][$i]], 2, ',', '.');
                    } else {
                        $field = $consume[$consumerServiceData["fieldsShow"][$i]];
                    }
                    $activeSheet->setCellValue($cell, $field);
                }
                $row++;
            }
        }

        if ($sections["pnr"]) {
//PNR
            $pnr = array(
                "title" => "Producción No Realizada",
                "col" => array("B", "C"),
                "campos" => array("Producto", "TOTAL"),
                "fieldsShow" => array("productName", "total"),
                "rowStart" => $row,
                "plan" => "plan",
                "real" => "real",
                "color" => "62cf5a"
            );
            $this->setFormatTitle($pnr, $activeSheet, $row);
            $row = $this->setTitlesRows($activeSheet, $pnr, $row);


            $unrealizedProducction = $data["unrealizedProducction"];
            foreach ($unrealizedProducction as $unrealized) {
                for ($i = 0; $i < count($pnr["col"]); $i++) {
                    $cell = $pnr["col"][$i] . $row;
                    if ($i != 0) {
                        $field = number_format((float) $unrealized[$pnr["fieldsShow"][$i]], 2, ',', '.');
                    } else {
                        $field = $unrealized[$pnr["fieldsShow"][$i]];
                    }
                    $activeSheet->setCellValue($cell, $field);
                }
                $row++;
            }
        }


        if ($sections["inventory"]) {

//INVENTARIO
            $inventory = array(
                "title" => "Inventario",
                "col" => array("B", "C"),
                "campos" => array("Producto", "TOTAL"),
                "fieldsShow" => array("productName", "total"),
                "rowStart" => $row,
                "plan" => "plan",
                "real" => "real",
                "color" => "ddbb15"
            );
            $this->setFormatTitle($inventory, $activeSheet, $row);
            $row = $this->setTitlesRows($activeSheet, $inventory, $row);


            $inventoryData = $data["inventory"];
            foreach ($inventoryData as $inv) {
                for ($i = 0; $i < count($inventory["col"]); $i++) {
                    $cell = $inventory["col"][$i] . $row;
                    if ($i != 0) {
                        $field = number_format((float) $inv[$inventory["fieldsShow"][$i]], 2, ',', '.');
                    } else {
                        $field = $inv[$inventory["fieldsShow"][$i]];
                    }
                    $activeSheet->setCellValue($cell, $field);
                }
                $row++;
            }
        }


        if ($sections["observations"]) {
//OBSERVACIONES

            $observation = array(
                "title" => "PUNTOS DE ATENCIÓN",
                "col" => array("B", "C", "D"),
                "campos" => array("Producto", "Día", "Observación"),
                "fieldsShow" => array("productName", "day", "observation"),
                "rowStart" => $row,
                "plan" => "plan",
                "real" => "real",
                "color" => "FF0000"
            );
            $this->setFormatTitleObservation($observation, $activeSheet, $row);
            $row = $this->setTitlesRowsObservation($activeSheet, $observation, $row);

            $styleObs = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => \PHPExcel_Style_Border::BORDER_MEDIUM,
                    )
                )
            );

            $styleProductObs = array(
                'font' => array(
                    'bold' => true,
                ),
                'fill' => array(
                    'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                        'rgb' => "dddddd"
                    )
                )
            );

            $styleDay = array(
                'alignment' => array(
                    'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER
                )
            );


            $styleProduct = array(
                'alignment' => array(
                    'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                    'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER
                )
            );


            $styleTextObservation = array(
                'alignment' => array(
                    'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                    'vertical' => \PHPExcel_Style_Alignment::VERTICAL_JUSTIFY
                )
            );

            $observationData = $data["observation"];
            foreach ($observationData as $obs) {
//$activeSheet->getRowDimension($row)->setRowHeight("15");
                $activeSheet->getRowDimension($row)->setRowHeight("40");

                for ($i = 0; $i < count($observation["col"]); $i++) {
                    $cell = $observation["col"][$i] . $row;
                    $activeSheet->getStyle($observation["col"][$i] . $row)->applyFromArray($styleObs);


                    if ($i == 0) {
                        $activeSheet->getStyle($observation["col"][$i] . $row)->applyFromArray($styleProduct);
                        $activeSheet->getStyle($observation["col"][$i] . $row)->applyFromArray($styleProductObs);
                    }
                    if ($observation["fieldsShow"][$i] == "day") {
                        $activeSheet->getStyle($observation["col"][$i] . $row)->applyFromArray($styleDay);
                        $field = $obs[$observation["fieldsShow"][$i]]->format("d-m-y");
                    } else {
                        $field = $obs[$observation["fieldsShow"][$i]];
                    }
                    if ($i == 2) {
                        $activeSheet->getStyle($observation["col"][$i] . $row)->applyFromArray($styleTextObservation);
                        $activeSheet->mergeCells($observation["col"][$i] . $row . ":" . "H" . $row);
                        $activeSheet->getStyle("H" . $row)->applyFromArray($styleObs);
                    }
                    $buscar = array(chr(13) . chr(10), "\r\n", "\n", "\r", "\n\r", "\t");
                    $reemplazar = array("", "", "", "", "", "");

                    $cadena = str_ireplace($buscar, $reemplazar, $field);
                    $activeSheet->setCellValue($cell, $cadena);
                }
                $row++;
            }
        }
        

        $fileName = sprintf("Reporte de Producción " . date("d-m-Y") . ".xls");

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    public function exportExcelAction($productsReport, $typeReport, $dateReport, $rawMaterialConsumptionPlannings, $consumerPlanningServices, $plants, $sections, $totalConsumerServices) {

        $days = array(
            "Domingo",
            "Lunes",
            "Martes",
            "Miercoles",
            "Jueves",
            "Viernes",
            "Sábado"
        );
        
//        $days = array();
//        $days[] = "Lunes";
//        $days[] = "Martes";
//        $days[] = "Miércoles";
//        $days[] = "Jueves";
//        $days[] = "Viernes";
//        $days[] = "Sábado";
//        $days[] = "Domingo";

        $path = $this->get('kernel')->locateResource('@PequivenObjetiveBundle/Resources/skeleton/reporte_produccion.xls');
        $objPHPExcel = \PHPExcel_IOFactory::load($path);
        $objPHPExcel
                ->getProperties()
                ->setCreator("SEIP")
                ->setTitle('SEIP - Reporte De Producción')
                ->setCreated()
                ->setLastModifiedBy('SEIP')
                ->setModified()
        ;
        $objPHPExcel->setActiveSheetIndex(0);
        $activeSheet = $objPHPExcel->getActiveSheet();

        $productReportService = $this->getProductReportService();

        $arrayCategories = array();
        $arrayPlan = array();
        $arrayReal = array();

        $styleArray = array(
            'font' => array(
                'bold' => true,
                'color' => array("rgb" => 'FF0000')
            ),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER
            )
        );
        $activeSheet->getStyle("H2")->applyFromArray($styleArray);
        $activeSheet->setCellValue("H2", $days[date("N")-1] . ", " . date("d/m/Y"));

        $rowCont = 4;

//COMPLEJOS

        $styleArray = array(
            'font' => array(
                'bold' => true,
            )
        );
        foreach ($plants as $plant) {
            $activeSheet->getStyle("B" . $rowCont)->applyFromArray($styleArray);
            $activeSheet->setCellValue("B" . $rowCont, $plant);
            $activeSheet->mergeCells("B" . $rowCont . ":" . "F" . $rowCont);
            $rowCont++;
        }

        $impressOperacion = array(
            "getSummaryDay" => array(
                "title" => "Producción Diaria",
                "col" => array("B", "C", "D", "E", "F"),
                "campos" => array("Producto", "PPTO", "REAL", "EJEC(%)", "VAR"),
                "rowStart" => 7,
                "plan" => "plan",
                "real" => "real",
                "color" => "55b34a"
            ),
            "getSummaryMonth" => array(
                "title" => "Producción Mensual",
                "col" => array("B", "C", "D", "E", "F", "G"),
                "campos" => array("Producto", "PPTO", "PPTO-MES", "REAL", "EJEC(%)", "VAR"),
                "rowStart" => 7,
                "plan_time" => "plan_month",
                "plan" => "plan_acumulated",
                "real" => "real_acumulated",
                "color" => "ffff15"
            )
            ,
            "getSummaryYear" => array(
                "title" => "Producción Anual",
                "col" => array("B", "C", "D", "E", "F", "G"),
                "campos" => array("Producto", "PPTO", "PPTO-AÑO", "REAL", "EJEC(%)", "VAR"),
                "rowStart" => 7,
                "plan_time" => "plan_year",
                "plan" => "plan_acumulated",
                "real" => "real_acumulated",
                "color" => "e56666"
            )
        );

        if ($sections["production"]) {
            $rowCont++;
            $row = 0;
            $arrayPerTime = array();
            foreach ($impressOperacion as $key => $imp) {
                $rs = array();
                $totalPlan = 0;
                $totalReal = 0;
                $totalPlanTime = 0;

                foreach ($productsReport as $productReport) {
                    $row = $imp["rowStart"];

                    $typeVar = $productReport->$key($dateReport, $typeReport);
                    $totalReal += $typeVar[$imp["real"]];
                    $totalPlan += $typeVar[$imp["plan"]];
                    if (array_key_exists("plan_time", $imp)) {
                        $totalPlanTime += $typeVar[$imp["plan_time"]];
                    }
                    if ($productReport->getProduct()->getIsCheckToReportProduction()) {
                        $rowData = array();

                        array_push($rowData, $productReport->getPlantReport()->getPlant()->getName() . ' - ' . $productReport->getProduct()->getName() . " (" . $productReport->getProduct()->getProductUnit() . ")");

                        if (array_key_exists("plan_time", $imp)) {
                            array_push($rowData, number_format((float) $typeVar[$imp["plan_time"]], 2, ',', '.'));
// $totalPlan+= $typeVar[$imp["plan_time"]];
                        }

                        array_push($rowData, number_format((float) $typeVar[$imp["plan"]], 2, ',', '.'));



                        array_push($rowData, number_format($typeVar[$imp["real"]], 2, ",", "."));


                        if ($typeVar[$imp["plan"]] > 0) {
                            array_push($rowData, number_format((float) ($typeVar[$imp["real"]] * 100) / $typeVar[$imp["plan"]], 2, ',', '.'));
                        } else {
                            array_push($rowData, 0);
                        }

                        $var = number_format((float) $typeVar[$imp["plan"]] - $typeVar[$imp["real"]], 2, ',', '.');
                        if ($var < 0) {
                            array_push($rowData, 0);
                        } else {
                            array_push($rowData, $var);
                        }

                        array_push($rs, $rowData);
                    }
                }
                if ($totalPlan > 0) {
                    $perc = ($totalReal * 100) / $totalPlan;
                } else {
                    $perc = 0;
                }
                $var = $totalPlan - $totalReal;
                if ($var < 0) {
                    $var = 0;
                }
                if ($key == "getSummaryDay") {
                    $arrayPerTime = array(
                        $totalPlan, $totalReal, $perc, $var
                    );
                } else {
                    $arrayPerTime = array(
                        $totalPlanTime, $totalPlan, $totalReal, $perc, $var
                    );
                }

//var_dump($arrayPerTime);


                /** SET TITLES** */
                $this->setFormatTitle($imp, $activeSheet, $rowCont);
                $rowCont = $this->setTitlesRows($activeSheet, $imp, $rowCont);

                foreach ($rs as $registros) {
                    $mat = array();
                    $g = 0;
                    foreach ($registros as $regs) {
                        $mat[$imp["col"][$g] . $rowCont] = $regs;
                        $activeSheet->setCellValue($imp["col"][$g] . $rowCont, $regs);
                        $g++;
                    }
                    $rowCont++;
                }

                $styleArray = array(
                    'font' => array(
                        'bold' => true,
                    ),
                    'fill' => array(
                        'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                            'rgb' => "dddddd"
                        )
                    )
                );
                /*                 * *****TOTALES DE PRODUCCION **************** */
                $t = 0;
                $activeSheet->getStyle($imp["col"][$t] . $rowCont)->applyFromArray($styleArray);
                $activeSheet->setCellValue($imp["col"][$t] . $rowCont, "Totales");
                foreach ($arrayPerTime as $perTime) {
                    $activeSheet->getStyle($imp["col"][$t + 1] . $rowCont)->applyFromArray($styleArray);
                    $activeSheet->setCellValue($imp["col"][$t + 1] . $rowCont, number_format(($perTime), 2, ",", "."));
                    $t++;
                }
                $rowCont++;
            }
        }


        if ($sections["rawMaterial"]) {
            /** CONSUMO DE MATERIA PRIMA * */
            $matPrima = $this->getDataRawMateria($rawMaterialConsumptionPlannings, $dateReport);

            $dataMateriaPrima = array(
                "row" => $rowCont,
                "title" => "Consumo Materia Prima",
                "col" => array("B", "C", "D", "E", "F", "G", "H"),
                "campos" => array("Producto", "PPTO-DIA", "REAL-DIA", "PPTO-MES", "REAL-MES", "PPTO-AÑO", "REAL-AÑO"),
                "color" => "ffaa15"
            );
//            var_dump($matPrima);
//            die();
            $this->setFormatTitle($dataMateriaPrima, $activeSheet, $rowCont);
            $rowCont = $this->setTitlesRows($activeSheet, $dataMateriaPrima, $rowCont);
//$activeSheet->setCellValue("B".$rowCont,"holas");

            $c = 0;
            foreach ($dataMateriaPrima["col"] as $cols) {
                $contCol = $rowCont;
                foreach ($matPrima[$c] as $cons) {
//var_dump($cols.$contCol."=>".$cons);
                    if (gettype($cons) == "string") {
                        $activeSheet->setCellValue($cols . $contCol, $cons);
                    } else {
                        $activeSheet->setCellValue($cols . $contCol, number_format($cons, 2, ',', '.'));
                    }
                    $contCol++;
                }
                $c++;
            }
            $rowCont = $contCol;
            /*             * ****************************** */
        }

        if ($sections["services"]) {
            /** CONSUMO DE SERVICIOS * */
            $consumos = $this->getDataConsumerPlanning($consumerPlanningServices, $dateReport);

            $dataConsumo = array(
                "row" => $rowCont + 1,
                "title" => "Servicios",
                "col" => array("B", "C", "D", "E", "F", "G", "H"),
                "campos" => array("Producto", "PPTO-DIA", "REAL-DIA", "PPTO-MES", "REAL-MES", "PPTO-AÑO", "REAL-AÑO"),
                "color" => "98bfbf"
            );

            $this->setFormatTitle($dataConsumo, $activeSheet, $rowCont);
            $rowCont = $this->setTitlesRows($activeSheet, $dataConsumo, $rowCont);

            $c = 0;
            $totals = array();
            foreach ($dataConsumo["col"] as $cols) {
                $contCol = $rowCont;
                $contTotal = 0;
                foreach ($consumos[$c] as $cons) {
                    if (gettype($cons) == "string") {
                        $activeSheet->setCellValue($cols . $contCol, $cons);
                    } else {
                        $contTotal += $cons;
                        $activeSheet->setCellValue($cols . $contCol, number_format($cons, 2, ',', '.'));
                    }
                    $contCol++;
                }
                $totals[] = $contTotal;
                $c++;
            }
            $rowCont = $contCol;

            $styleTotalConsumer = array(
                'font' => array(
                    'bold' => true,
                )
            );

//TOTALES DE CONSUMO DE SERVICIOS
            $contRow = 0;
            foreach ($dataConsumo["col"] as $cols) {
                if ($contRow > 0) {
                    $activeSheet->getStyle($cols . $rowCont)->applyFromArray($styleArray);
                    $activeSheet->setCellValue($cols . $rowCont, number_format($totals[$contRow], 2, ',', '.'));
                } else {
                    $activeSheet->getStyle($cols . $rowCont)->applyFromArray($styleArray);
                    $activeSheet->setCellValue($cols . $rowCont, "Totales");
                }
                $contRow++;
            }
            $rowCont++;
//**********************************/
        }

        if ($sections["pnr"]) {
///****PRODUCCION NO REALIZADA **//////////
            $unrealizedProduction = $this->getDataUnrealizedProduction($productsReport, $dateReport);

            $dataUnrealized = array(
                "row" => $rowCont + 1,
                "title" => "Producción No Realizada",
                "col" => array("B", "C", "D", "E"),
                "campos" => array("Producto", "DIA", "MES", "AÑO"),
                "color" => "62cf5a"
            );
            $this->setFormatTitle($dataUnrealized, $activeSheet, $rowCont);
            $rowCont = $this->setTitlesRows($activeSheet, $dataUnrealized, $rowCont);

            $c = 0;
            foreach ($dataUnrealized["col"] as $cols) {
                $contCol = $rowCont;
                foreach ($unrealizedProduction[$c] as $cons) {
//var_dump($cols.$contCol."=>".$cons);
                    if (gettype($cons) == "string") {
                        $activeSheet->setCellValue($cols . $contCol, $cons);
                    } else {
                        $activeSheet->setCellValue($cols . $contCol, number_format($cons, 2, ',', '.'));
                    }
                    $contCol++;
                }
                $c++;
            }
            $rowCont = $contCol;
            /*             * ****************************** */
        }

        if ($sections["inventory"]) {

///****INVENTARIO  **//////////
            $inventario = $this->getDataInventario($productsReport, $dateReport);

            $dataInventario = array(
                "row" => $rowCont,
                "title" => "Inventario",
                "col" => array("B", "C", "D"),
                "campos" => array("Producto", "DIA", "DIA ANTERIOR"),
                "color" => "ddbb15"
            );
            $this->setFormatTitle($dataInventario, $activeSheet, $rowCont);
            $rowCont = $this->setTitlesRows($activeSheet, $dataInventario, $rowCont);

            $c = 0;
            foreach ($dataInventario["col"] as $cols) {
                $contCol = $rowCont;
                foreach ($inventario[$c] as $cons) {
//var_dump($cols.$contCol."=>".$cons);
                    if (gettype($cons) == "string") {
                        $activeSheet->setCellValue($cols . $contCol, $cons);
                    } else {
                        $activeSheet->setCellValue($cols . $contCol, number_format($cons, 2, ',', '.'));
                    }
                    $contCol++;
                }
                $c++;
            }
            $rowCont = $contCol;
            /*             * ****************************** */
        }

        if ($sections["observations"]) {
///**** OBSERVACIONES  **//////////
            $observaciones = $this->getDataInventario($productsReport, $dateReport);
            $dataObservaciones = array(
                "title" => "PUNTOS DE ATENCIÓN",
                "row" => $rowCont,
                "col" => array("B", "C"),
                "campos" => array("Producto", "Observación"),
                "color" => "FF0000"
            );
            $observaciones = array();
            $name = array();
            $obs = array();

            $styleObs = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => \PHPExcel_Style_Border::BORDER_MEDIUM,
                    )
                ),
                'alignment' => array(
                    'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                    'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER
                ),
            );

            $styleProductObs = array(
                'font' => array(
                    'bold' => true,
                ),
                'fill' => array(
                    'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                        'rgb' => "dddddd"
                    )
                ),
                'alignment' => array(
                    'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                    'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER
                ),
            );

            foreach ($productsReport as $productReport) {
                $name[] = $productReport->getProduct()->getName();
                $det = $productReport->getSummaryDay($dateReport, $typeReport);
                if ($det["observation"] != "") {
                    $obs[] = $det["observation"];
                } else {
                    $obs[] = "NINGÚNA OBSERVACIÓN.";
                }
            }
            $observaciones[] = $name;
            $observaciones[] = $obs;

            $this->setFormatTitleObservation($dataObservaciones, $activeSheet, $rowCont);
            $rowCont = $this->setTitlesRowsObservation($activeSheet, $dataObservaciones, $rowCont, "C");

            $c = 0;
            foreach ($dataObservaciones["col"] as $cols) {

                $contCol = $rowCont;
                $activeSheet->getColumnDimension($cols)->setAutoSize(true);
                $cr = 0;
                foreach ($observaciones[$c] as $cons) {
                    $activeSheet->getRowDimension($contCol)->setRowHeight("40");

                    $buscar = array(chr(13) . chr(10), "\r\n", "\n", "\r", "\n\r", "\t");
                    $reemplazar = array("", "", "", "", "", "");

                    $cadena = str_ireplace($buscar, $reemplazar, $cons);
//$activeSheet->setCellValue($cell, $cadena);

                    $activeSheet->setCellValue($cols . $contCol, strip_tags($cadena));

                    if ($c == 1) {
                        $activeSheet->mergeCells($cols . $contCol . ":" . "H" . $contCol);
                        $activeSheet->getStyle($cols . $contCol)->applyFromArray($styleObs);
                        $activeSheet->getStyle("H" . $contCol)->applyFromArray($styleObs);
                        $activeSheet->getStyle($cols . $contCol)->getAlignment()->setWrapText(true);
                    }
                    if ($c == 0) {
                        $activeSheet->getStyle($cols . $contCol)->applyFromArray($styleProductObs);
                    }
                    $activeSheet->getStyle($cols . $contCol)->applyFromArray($styleObs);
                    $contCol++;
                    $cr++;
                }
                $c++;
            }
            $rowCont = $contCol;
            /*             * ****************************** */
        }

        $fileName = sprintf("Reporte de Producción " . date("d-m-Y") . ".xls");

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    public function setFormatTitle($imp, $activeSheet, $rowCont) {
        $styleArray = array(
            'font' => array(
                'bold' => true,
            ),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
            'fill' => array(
                'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array(
                    'rgb' => $imp["color"]
                )
            )
        );

        $rowCont = $rowCont + 1;
        $totalCol = count($imp["col"]);
        $ini = $imp["col"][0] . $rowCont;
        $fin = $imp["col"][$totalCol - 1] . $rowCont;
        $activeSheet->getRowDimension($rowCont)->setRowHeight(20);
        $activeSheet->mergeCells($ini . ":" . $fin);
        $activeSheet->getStyle($ini)->applyFromArray($styleArray);
        $activeSheet->setCellValue($imp["col"][0] . $rowCont, $imp["title"]);
    }

    public function setFormatTitleObservation($imp, $activeSheet, $rowCont) {
        $styleArray = array(
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => 'FFFFFF')
            ),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
            'fill' => array(
                'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array(
                    'rgb' => $imp["color"]
                )
            )
        );

        $rowCont = $rowCont + 1;
        $totalCol = count($imp["col"]);
        $ini = $imp["col"][0] . $rowCont;
        $fin = "H" . $rowCont;
        $activeSheet->getRowDimension($rowCont)->setRowHeight(20);
        $activeSheet->mergeCells($ini . ":" . $fin);
        $activeSheet->getStyle($ini)->applyFromArray($styleArray);
        $activeSheet->setCellValue($imp["col"][0] . $rowCont, $imp["title"]);
    }

    public function setTitlesRows($activeSheet, $imp, $rowCont) {
        $styleArray = array(
            'font' => array(
                'bold' => true,
            ),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
            'fill' => array(
                'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array(
                    'rgb' => "dddddd"
                )
            )
        );

        $rowCont = $rowCont + 2;
//$activeSheet->setCellValue("B".$rowCont,"hola");
        $camp = 0;
        foreach ($imp["campos"] as $campos) {
            $col = $imp["col"][$camp];
//var_dump($col . $rowCont, $campos);
            $activeSheet->setCellValue($col . $rowCont, $campos);
            $activeSheet->getStyle($col . $rowCont)->applyFromArray($styleArray);
            $camp++;
        }
        $rowCont = $rowCont + 1;

        return $rowCont;
    }

    public function setTitlesRowsObservation($activeSheet, $imp, $rowCont, $init = "D") {
        $styleArray = array(
            'font' => array(
                'bold' => true,
            ),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
            'fill' => array(
                'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array(
                    'rgb' => "dddddd"
                )
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_MEDIUM,
                )
            )
        );


        $rowCont = $rowCont + 2;
        $camp = 0;
        foreach ($imp["campos"] as $campos) {
            $col = $imp["col"][$camp];
            $activeSheet->setCellValue($col . $rowCont, $campos);
            $activeSheet->getStyle($col . $rowCont)->applyFromArray($styleArray);
            $activeSheet->mergeCells($init . $rowCont . ":" . "H" . $rowCont);
            $activeSheet->getStyle("H" . $rowCont)->applyFromArray($styleArray);
            $camp++;
        }
        $rowCont = $rowCont + 1;

        return $rowCont;
    }

    public function getDataRawMateria($rawMaterial, $dateReport) {
        
        $em = $this->getDoctrine()->getManager();

        $productos = array();
        $totalDay = array();
        $totalMonth = array();
        $totalYear = array();
        $totalDayPlan = array();
        $totalMonthPlan = array();
        $totalYearPlan = array();
        
        

        foreach ($rawMaterial as $rs) {
            //$rs = $this->container->get('pequiven.repository.product')->findOneBy(array('id' => $rs['id']));
            //$rs = $em->getRepository("Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial\RawMaterialConsumptionPlanning")->find($rs["id"]);
            $productos[] = $rs->getProduct()->getName() . " (" . $rs->getProduct()->getProductUnit() . ")";
//$productos[] = $rs->$name;
            //REAL
            array_push($totalDay, $rs->getSummary($dateReport)["total_day"]);
            array_push($totalMonth, $rs->getSummary($dateReport)["total_month"]);
            array_push($totalYear, $rs->getSummary($dateReport)["total_year"]);
            //PLAN
            array_push($totalDayPlan, $rs->getSummary($dateReport)["total_day_plan"]);
            array_push($totalMonthPlan, $rs->getSummary($dateReport)["total_month_plan"]);
            array_push($totalYearPlan, $rs->getSummary($dateReport)["total_year_plan"]);
            $idsPlanta[] = $rs->getProductReport()->getPlantReport()->getPlant()->getId();
//var_dump($rawMaterialConsumption->getSummary($dateReport));
        }
        

        return $this->getArrayTable($rawMaterial, $dateReport, $productos, $idsPlanta, $totalDay, $totalMonth, $totalYear, $totalDayPlan, $totalMonthPlan, $totalYearPlan);
    }

    public function getDataConsumerPlanning($consumerPlanning, $dateReport) {

        $productos = array();
        $totalDay = array();
        $totalMonth = array();
        $totalYear = array();

        $totalDayPlan = array();
        $totalMonthPlan = array();
        $totalYearPlan = array();
        $idsPlanta = array();

        foreach ($consumerPlanning as $rs) {
            $productos[] = $rs->getService()->getName() . " (" . $rs->getService()->getServiceUnit() . ")";
//$productos[] = $rs->$name;
            $plant[] = $rs->getPlantReport()->getPlant()->getId();
            //REAL
            array_push($totalDay, $rs->getSummary($dateReport)["total_day"]);
            array_push($totalMonth, $rs->getSummary($dateReport)["total_month"]);
            array_push($totalYear, $rs->getSummary($dateReport)["total_year"]);
            //PLAN
            array_push($totalDayPlan, $rs->getSummary($dateReport)["total_day_plan"]);
            array_push($totalMonthPlan, $rs->getSummary($dateReport)["total_month_plan"]);
            array_push($totalYearPlan, $rs->getSummary($dateReport)["total_year_plan"]);
//var_dump($rawMaterialConsumption->getSummary($dateReport));
            $idsPlanta[] = $rs->getPlantReport()->getPlant()->getId();
        }



        return $this->getArrayTable($consumerPlanning, $dateReport, $productos, $idsPlanta, $totalDay, $totalMonth, $totalYear, $totalDayPlan, $totalMonthPlan, $totalYearPlan);
    }

    public function getDataUnrealizedProduction($productsReport, $dateReport) {

        $productReportService = $this->getProductReportService();
        $productos = array();
        $totalDay = array();
        $totalMonth = array();
        $totalYear = array();

        foreach ($productsReport as $rs) {
            $productos[] = $rs->getProduct()->getName() . " (" . $rs->getProduct()->getProductUnit() . ")";
            
            $excludePnr = $productReportService->getArrayByDateFromInternalCausesPnr($dateReport, $rs);
            //$unrealizedProduction["total_day"] = $unrealizedProduction["total_day"] - $excludePnr[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]["Sobre Producción"]['day'];
            //$unrealizedProduction["total_month"] = $unrealizedProduction["total_month"] - $excludePnr[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]["Sobre Producción"]['month'];
            //$unrealizedProduction["total_year"] = ($unrealizedProduction["total_year"] - $excludePnr[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]["Sobre Producción"]['year']);
            //$productos[] = $rs->getProduct()->getName() . " (" . $rs->getProduct()->getProductUnit() . ")";
            //$productos[] = $rs->$name;
            $valueDay = $rs->getSummaryUnrealizedProductions($dateReport)["total_day"] - $excludePnr[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]["Sobre Producción"]['day'];
            $valueMonth = $rs->getSummaryUnrealizedProductions($dateReport)["total_month"] - $excludePnr[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]["Sobre Producción"]['month'];
            $valueYear = $rs->getSummaryUnrealizedProductions($dateReport)["total_year"] - $excludePnr[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]["Sobre Producción"]['year'];
            
            array_push($totalDay, $valueDay);
            array_push($totalMonth, $valueMonth);
            array_push($totalYear, $valueYear);
            //var_dump($rawMaterialConsumption->getSummary($dateReport));
            $idsPlanta[] = $rs->getPlantReport()->getPlant()->getId();
        }


        return $this->getArrayTable($productsReport, $dateReport, $productos, $idsPlanta, $totalDay, $totalMonth, $totalYear);
    }

    public function getDataInventario($productsReport, $dateReport) {

        $productos = array();
        $totalDay = array();
        $totalMonth = array();
        $totalYear = array();

        foreach ($productsReport as $rs) {
            $productos[] = $rs->getProduct()->getName() . " (" . $rs->getProduct()->getProductUnit() . ")";
            //$productos[] = $rs->$name;
            array_push($totalDay, number_format($rs->getSummaryInventory($dateReport)["total_day"], 2, ',', '.'));
            array_push($totalMonth, number_format($rs->getSummaryInventory($dateReport)["total_month"], 2, ',', '.'));
            $idsPlanta[] = $rs->getPlantReport()->getPlant()->getId();
            //var_dump($rawMaterialConsumption->getSummary($dateReport));
        }
        return $this->getArrayTable($productsReport, $dateReport, $productos, $idsPlanta, $totalDay, $totalMonth, $totalMonth, $totalYear);
    }

    /**
     * 
     * @param type $arrayData
     * @return array
     */
    public function getArrayTable($arrayData, $dateReport, $productos, $idsPlanta, $totalDay, $totalMonth, $totalYear, $totalDayPlan = array(), $totalMonthPlan = array(), $totalYearPlan = array()) {

        $consumos = array();
        //REAL
        $day = array();
        $month = array();
        $year = array();
        //PLAN
        $dayPlan = array();
        $monthPlan = array();
        $yearPlan = array();


        //AL SER LAS PLANTAS DE METOR Y SUPERMETANOL NO AGRUPA PRODUCTOS
        if (in_array("62", $idsPlanta) || in_array("63", $idsPlanta)) {
            $cont = 0;
            foreach ($productos as $prod) {
                $day[] = $totalDay[$cont];
                $month[] = $totalMonth[$cont];
                if (count($totalDayPlan) > 0) {
                    $dayPlan[] = $totalDayPlan[$cont];
                    $monthPlan[] = $totalMonthPlan[$cont];
                }
                if (count($totalYear) > 0) {
                    $year[] = $totalYear[$cont];
                    if (count($totalDayPlan) > 0) {
                        $yearPlan[] = $totalYearPlan[$cont];
                    }
                }
                $cont++;
            }
            $consumos[] = $productos;
            if (count($totalDayPlan) > 0) {
                $consumos[] = $dayPlan;
            }
            $consumos[] = $day;
            if (count($totalDayPlan) > 0) {
                $consumos[] = $monthPlan;
            }
            $consumos[] = $month;
            if (count($totalDayPlan) > 0) {
                $consumos[] = $yearPlan;
            }
            $consumos[] = $year;
        } else {

            foreach (array_unique($productos) as $prod) {
                $rep = array_keys($productos, $prod);
                $tDay = 0;
                $tMonth = 0;
                $tYear = 0;
                $tDayPlan = 0;
                $tMonthPlan = 0;
                $tYearPlan = 0;
                if ($rep > 0) {
                    foreach ($rep as $r) {
                        $tDay = $tDay + $totalDay[$r];
                        $tMonth = $tMonth + $totalMonth[$r];
                        if (count($totalDayPlan) > 0) {
                            $tDayPlan = $tDayPlan + $totalDayPlan[$r];
                            $tMonthPlan = $tMonthPlan + $totalMonthPlan[$r];
                        }
                        if (count($totalYear) > 0) {
                            $tYear = $tYear + $totalYear[$r];
                            if (count($totalDayPlan) > 0) {
                                $tYearPlan = $tYearPlan + $totalYearPlan[$r];
                            }
                        }
                    }
                    $day[] = $tDay;
                    $month[] = $tMonth;
                    if (count($totalDayPlan) > 0) {
                        $dayPlan[] = $tDayPlan;
                        $monthPlan[] = $tMonthPlan;
                    }
                    if (count($totalYear) > 0) {
                        $year[] = $tYear;
                        if (count($totalDayPlan) > 0) {
                            $yearPlan[] = $tYearPlan;
                        }
                    }
                } else {
                    $day[] = $totalDay[$r];
                    $month[] = $totalMonth[$r];
                    if (count($totalDayPlan) > 0) {
                        $dayPlan[] = $totalDayPlan[$r];
                        $monthPlan[] = $totalMonthPlan[$r];
                    }
                    if (count($totalYear) > 0) {
                        $year[] = $totalYear[$r];
                        if (count($totalDayPlan) > 0) {
                            $yearPlan[] = $totalYearPlan[$r];
                        }
                    }
                }
            }
            $consumos[] = array_unique($productos);
            if (count($totalDayPlan) > 0) {
                $consumos[] = $dayPlan;
            }
            $consumos[] = $day;
            if (count($totalDayPlan) > 0) {
                $consumos[] = $monthPlan;
            }
            $consumos[] = $month;
            if (count($totalDayPlan) > 0) {
                $consumos[] = $yearPlan;
            }
            $consumos[] = $year;
        }
//        
//        $nogroup = $idsPlanta; //SI ES METOR O SUPERMETANOL NO AGRUPA LAS PLANTAS
//        foreach ($arrayData as $data) {
//            //$nogroup[] = $data->getProductReport()->getPlantReport()->getPlant()->getId();
//            var_dump(get_class($data));
//        }
//        die();
//          $cont = 0;
//            foreach ($productos as $prod) {
//                $day[] = $totalDay[$cont];
//                $month[] = $totalMonth[$cont];
//                if (count($totalYear) > 0) {
//                    $year[] = $totalYear[$cont];
//                }
//                $cont++;
//            }
//            $consumos[] = $productos;
//            $consumos[] = $day;
//            $consumos[] = $month;
//            $consumos[] = $year;
//        if (in_array("62", $nogroup) || in_array("63", $nogroup)) {
//            //if($idPlanta=="62" || $idPlanta=="63") {
//            $cont = 0;
//            foreach ($productos as $prod) {
//                $day[] = $totalDay[$cont];
//                $month[] = $totalMonth[$cont];
//                if (count($totalYear) > 0) {
//                    $year[] = $totalYear[$cont];
//                }
//                $cont++;
//            }
//            $consumos[] = $productos;
//            $consumos[] = $day;
//            $consumos[] = $month;
//            $consumos[] = $year;
//            
//        } else {
//        
        //var_dump($consumos);
//      
        //}

        return $consumos;
    }

    public function setNumberFormat($value) {
        return number_format($value, 2, ',', '.');
    }

    public function getEjecution($plan,$real,$band = true) {

        if ($plan > 0) {
            $ejecution = ($real * 100) / $plan;
        } else {
            $ejecution = 0;
        }

        if($band) { 
            return $this->setNumberFormat($ejecution);
        } else {
            return $ejecution;
        }
    }

    
    public function getVariation($plan,$real,$band = true) {

        if ($plan - $real < 0) {
            $var = 0;
        } else {
            $var = $plan - $real;
        }
        
        if($band) { 
            return $this->setNumberFormat($var);
        } else {
            return $var;
        }
        

    }

    protected function getProductReportService() {
        return $this->container->get('seip.service.productReport');
    }

    protected function getUnrealizedProductionService() {
        return $this->container->get('seip.service.unrealizedProduction');
    }

    protected function getCauseFailService() {
        return $this->container->get('seip.service.causefail');
    }

}
