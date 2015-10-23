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
            $childrens = $plantReport->getPlant()->getChildrens();

            if (count($childrens) == 0) { //SIN HIJOS
                $arrayPlants[] = array(
                    "id" => $plantReport->getPlant()->getId(),
                    "name" => $plantReport->getPlant()->getName(),
                    "alias" => $plantReport->getPlant()->getEntity()->getAlias(),
                    "entity" => $plantReport,
                    "plantReportId" => $plantReport->getId()
                );
            } else if (count($childrens) > 0) { //CON HIJOS
                $cont = 0;
                $arrayProductsIds = array();
                $groupNames = "";
                foreach ($childrens as $children) {
                    foreach ($children->getProducts() as $productChild) {
                        if (!in_array($productChild->getName(), $arrayProductsIds)) {
                            $arrayProductsIds[] = $productChild->getName();
                        }
                    }
                    if ($cont == 0) {
                        $groupNames .= $children->getName();
                    } else {
                        $groupNames .= "," . $children->getName();
                    }
                    $cont++;
                }
                $arrayPlantsGroup[] = array(
                    "id" => $plantReport->getPlant()->getId(),
                    "name" => $plantReport->getPlant()->getName(),
                    "groups" => $groupNames,
                    "alias" => $plantReport->getPlant()->getEntity()->getAlias(),
                    "entity" => $plantReport,
                    "products" => $arrayProductsIds,
                    "plantReportId" => $plantReport->getId()
                );
            }
        }




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
     * Notificar produccion
     * @param Request $request
     * @return type
     * @throws type
     */
    public function loadAction(Request $request) {
        $dateString = null;
        if ($this->getSecurityService()->isGranted(array('ROLE_SEIP_DATA_LOAD_CHANGE_DATE', 'ROLE_SEIP_OPERATION_LOAD_FIVE_DAYS'))) {
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
         * CODIGO PARA HABILITAR LA NOTIFICACION POR UN MES COMPLETO
         */
        $monthActive = "";

        if ($monthActive == "") {
            $monthActive = date("m");
        }

        $year = date("Y");
        $daysMonth = cal_days_in_month(CAL_GREGORIAN, $monthActive, $year);
        $startDayMonth = "01/" . $monthActive . "/" . $year;
        $endDayMonth = $daysMonth . "/" . $monthActive . "/" . $year;


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
            'form' => $form->createView(),
                ))
        ;

        return $this->handleView($view);
    }

    /**
     * CODIGO QUE VALIDA LOS DIAS PARA NOTIFICAR LA PRODUCCION
     * SI TIENE EL ROL "ROLE_SEIP_OPERATION_LOAD_FIVE_DAYS"
     * DEJA CARGAR 5 DIAS ANTES DEL DIA ACTUAL
     */
    function getTransfDate($fecha, $dia) {
        list($day, $mon, $year) = explode('/', $fecha);
        return date('d/m/Y', mktime(0, 0, 0, $mon, $day + $dia, $year));
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

//                var_dump ($rawMaterialsArray);

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
                            $rawMaterials[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL_MP][$key] = $rawMaterial;
                        }
                    }
                }
//                var_dump($unrealizedProduction->getMonth());
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

//        var_dump($internalRawMaterials);
//        var_dump($externalRawMaterials);
//        die();
//Recorremos las producciones no realizadas
        foreach ($unrealizedProductions as $unrealizedProduction) {
            $monthUnrealizedProduction = $unrealizedProduction->getMonth();

//Seteamos el valor dia y mes
            if ($month == $unrealizedProduction->getMonth()) {
                $pnrByCausesIntExt = $causeFailService->getFailsCause($unrealizedProduction);
                $pnrByCausesMP = $causeFailService->getPNRByFailsCauseMp($unrealizedProduction, $rawMaterials);
                foreach ($failsInternal as $failInternal) {
                    $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL][$failInternal->getName()]['day'] = $pnrByCausesIntExt[$methodTypeCausesIntExt[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]][$failInternal->getName()][$day];
                    $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]['total']['day'] = $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]['total']['day'] + $pnrByCausesIntExt[$methodTypeCausesIntExt[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]][$failInternal->getName()][$day];
                    for ($dayMonth = 1; $dayMonth <= $day; $dayMonth++) {
                        $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL][$failInternal->getName()]['month'] = $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL][$failInternal->getName()]['month'] + $pnrByCausesIntExt[$methodTypeCausesIntExt[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]][$failInternal->getName()][$dayMonth];
                        $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]['total']['month'] = $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]['total']['month'] + $pnrByCausesIntExt[$methodTypeCausesIntExt[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]][$failInternal->getName()][$dayMonth];
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
                                $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]['total']['year'] = $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]['total']['year'] + $pnrByCausesIntExt[$methodTypeCausesIntExt[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]][$failInternal->getName()][$dayMonth];
                            }
                        } else {
                            $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL][$failInternal->getName()]['year'] = $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL][$failInternal->getName()]['year'] + $pnrByCausesIntExt[$methodTypeCausesIntExt[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]][$failInternal->getName()][$dayMonth];
                            $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]['total']['year'] = $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]['total']['year'] + $pnrByCausesIntExt[$methodTypeCausesIntExt[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]][$failInternal->getName()][$dayMonth];
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


//VERIFICA SI VIENE DE REPORTE DE PRODUCCION O SE LE DA AL BOTON PARA GENERAR REPORTE
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

    /**
     * Vizualizar la planificacion
     * @param Request $request
     * @return type
     */
    public function vizualiceAction(Request $request) {

        $plantReportId = null;
        if ($request->isMethod("POST")) {
            $formData = $request->get("form");
            $plantReportId = (int) $formData['plantReport'];
        }

        $dateReport = new \DateTime(date("Y-m-d", strtotime("-1 day")));

        if (!$this->getSecurityService()->isGranted('ROLE_SEIP_DATA_LOAD_CHANGE_DATE')) {
            $dateReport = new \DateTime(date("Y-m-d", strtotime("-1 day")));
        }
        $plantReport = $this->get('pequiven.repository.plant_report')->find($plantReportId);
        $productsReport = array();
        $plantReports = new \Doctrine\Common\Collections\ArrayCollection();
        $emptyValue = "Seleccione";
        if ($plantReport) {
            $plantReports->add($plantReport);
            $productsReport = $plantReport->getProductsReport()->toArray();
        }
        $showDay = $showMonth = $showYear = $defaultShow = $withDetails = true;
        $dateFrom = $dateEnd = new \DateTime();
        $byRange = false;

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
                ->add('plantReport', 'entity', $parametersPlantReport)
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
                    'label_attr' => array('class' => 'label bold'),
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
                ->getForm();
        $productsReportConsulting = [];

        $showProduction = null;
        $showRawMaterial = null;
        $showService = null;
        $showPnr = null;
        $showInventory = null;
        $showObservation = null;

        if ($request->isMethod('POST') && $form->submit($request)->isValid()) {

            $data = $form->getData();

            $byRange = $data['byRange'];
//$withDetails = $data['withDetails'];
            $showDay = $data['showDay'];
            $showMonth = $data['showMonth'];
            $showYear = $data['showYear'];

            $showProduction = $data["showProduction"];
            $showRawMaterial = $data["showRawMaterial"];
            $showPnr = $data["showPnr"];
            $showService = $data["showServices"];
            $showInventory = $data["showInventory"];
            $showObservation = $data["showObservation"];


            $dateFrom = $data['dateFrom'];
            $dateEnd = $data['dateEnd'];

            $productsReportConsulting = $data['productsReport'];
            if ($productsReportConsulting && count($productsReportConsulting) > 0) {
                foreach ($productsReportConsulting as $productReport) {
                    $productsReportId[] = $productReport->getId();
                }
                foreach ($plantReport->getProductsReport() as $productReport) {
                    if (!in_array($productReport->getId(), $productsReportId)) {
                        $plantReport->getProductsReport()->removeElement($productReport);
                        continue;
                    }
                }
                $plantReports->add($plantReport);
            }
        }


        $data = $form->getData();
        $typeReport = $data['typeReport'];
        if ($typeReport === null) {
            $typeReport = 'Gross';
        }
        $dateReport = $data['dateReport'];
        $reportTemplates = $data['reportTemplate'];
        if ($reportTemplates) {
            foreach ($reportTemplates as $reportTemplate) {
                foreach ($reportTemplate->getPlantReports() as $plantReport) {
                    if (!$plantReports->contains($plantReport)) {
                        $plantReports->add($plantReport);
                    }
                }
            }
        }


//PRODUCTION
        $arrayProduction = array();
        $totalProdPlan = 0.0;
        $totalProdReal = 0.0;
//RAWMATERIAL
        $arrayRawMaterial = array();
        $totalRawPlan = 0.0;
        $totalRawReal = 0.0;

//CONSUMO DE MATERIA PRIMA
        $arrayProdServices = array();
        $arrayConsumerServices = array();

//PRODUCION NO REALIZADA
        $arrayUnrealizedProduction = array();
        $arrayNamesUnrealizedProduction = array();

//invetario
        $arrayInventory = array();
        $arrayNamesInventory = array();

//OBSERVACIONES
        $arrayObservation = array();


//COMPLEJOS CONSULTADOS
        $plants = array();

        $exportToPdf = $request->get('exportToPdf', false);

        if ($byRange === true) {

            $dateDesde = $dateFrom->format("U");
            $dateHasta = $dateEnd->format("U");




            foreach ($plantReports as $planReport) {
                if (!in_array($plantReport->getReportTemplate()->getName(), $plants)) {
                    $plants[] = $plantReport->getReportTemplate()->getName();
                }


                foreach ($planReport->getProductsReport() as $productReport) {

//var_dump($productReport->getname());
                    $i = $dateDesde;
                    $rs = array();
                    $totalPlan = $totalReal = $totalPercentaje = $totalPnr = 0.0;
//$totalRawPlan = $totalRawReal = 0.0;
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

//VERIFICA SI VA A EXPORTAR Y OBVIA LAS OBSERVACIONES VACIAS
                        if ($exportToPdf) {
                            if ($rs["observation"] != "") {
                                $arrayObservation[] = array("day" => $timeNormal, "productName" => $productReport->getProduct()->getName() . " (" . $productReport->getPlantReport()->getPlant()->getName() . ")", "observation" => $rs["observation"]);
                            }
                        } else {
                            $arrayObservation[] = array("day" => $timeNormal, "productName" => $productReport->getProduct()->getName() . " (" . $productReport->getPlantReport()->getPlant()->getName() . ")", "observation" => $rs["observation"]);
                        }




                        $i = $i + 86400; //VOY RECORRIENDO DIA POR DIA
                    }
//PRODUCTION 
                    $rs["productName"] = $productReport->getProduct()->getName() . " (" . $productReport->getProduct()->getProductUnit()->getUnit() . ")";

                    $arrayProduction[] = $rs;

//CONSUMO DE MATERIA PRIMA

                    $i = $dateDesde;

//VERIFICA SI EL PRODUCTO ES MATERIA PRIMA
                    //if ($productReport->getProduct()->getIsRawMaterial()) {
                    foreach ($productReport->getRawMaterialConsumptionPlannings() as $rawMaterial) {
                        $totalRawDayPlan = 0.0;
                        $totalRawDayReal = 0.0;
                        if ($rawMaterial->getProduct()->getIsRawMaterial()) {
                            while ($i != ($dateHasta + 86400)) {
                                $timeNormal = new \DateTime(date("Y-m-d", $i));
                                $rawMaterialResult = $rawMaterial->getSummary($timeNormal);

                                $totalRawDayPlan += $rawMaterialResult["total_day_plan"];
                                $totalRawDayReal += $rawMaterialResult["total_day"];
                                $totalRawPlan += $rawMaterialResult["total_day_plan"];
                                $totalRawReal += $rawMaterialResult["total_day"];

                                $i = $i + 86400; //VOY RECORRIENDO DIA POR DIA
                            }


                            $arrayRawMaterial[] = array(
                                "productName" => $rawMaterial->getProduct()->getName() . " (" . $rawMaterial->getProduct()->getProductUnit()->getUnit() . ")",
                                "planRaw" => $totalRawDayPlan,
                                "realRaw" => $totalRawDayReal
                            );
                        }
                    }
//                    $arrayRawMaterial[] = array(
//                        "productName" => $productReport->getProduct()->getName() . " (" . $productReport->getProduct()->getProductUnit()->getUnit() . ")",
//                        "planRaw" => $totalRawDayPlan,
//                        "realRaw" => $totalRawDayReal
//                    );
                    //}
                }
//CONSUMO DE SERVICIOS
                foreach ($planReport->getConsumerPlanningServices() as $consumerPlanningService) {
                    $i = $dateDesde;
                    $serviceName = $consumerPlanningService->getService()->getName() . " (" . $consumerPlanningService->getService()->getServiceUnit() . ")";
                    $serviceId = $consumerPlanningService->getService()->getId();

                    if (!in_array($serviceName, $arrayProdServices)) {
                        array_push($arrayProdServices, $serviceName);
                        $arrayConsumerServices[$serviceId] = array("productName" => $serviceName, "plan" => 0.0, "real" => 0.0);
                    }
                    while ($i != ($dateHasta + 86400)) {

                        $timeNormal = new \DateTime(date("Y-m-d", $i));
                        $consumerPlanning = $consumerPlanningService->getSummary($timeNormal);

                        $arrayConsumerServices[$serviceId]["real"] += $consumerPlanning["total_day"];
                        $arrayConsumerServices[$serviceId]["plan"] += $consumerPlanning["total_day_plan"];

                        $i += 86400; //VOY RECORRIENDO DIA POR DIA
                    }
                }

//PRODUCION NO REALIZADA
                $i = $dateDesde;

                foreach ($planReport->getProductsReport() as $productReport) {
                    $productId = $productReport->getProduct()->getId();
//      var_dump($productReport->getName());
                    if (!in_array($productId, $arrayNamesUnrealizedProduction)) {
                        $arrayNamesUnrealizedProduction[] = $productId;
                        $arrayUnrealizedProduction[$productId] = array("productName" => $productReport->getProduct()->getName() . " (" . $productReport->getProduct()->getProductUnit()->getUnit() . ")", "total" => 0.0);
                    }

                    while ($i != ($dateHasta + 86400)) {
                        $timeNormal = new \DateTime(date("Y-m-d", $i));
                        $unrealizedProduction = $productReport->getSummaryUnrealizedProductions($timeNormal);
//            var_dump($unrealizedProduction);
                        $arrayUnrealizedProduction[$productId]["total"] += $unrealizedProduction["total_day"];

                        $i += 86400; //VOY RECORRIENDO DIA POR DIA
                    }
                }

//INVENTARIO

                foreach ($planReport->getProductsReport() as $productReport) {
                    $productId = $productReport->getProduct()->getId();
                    $timeNormal = new \DateTime(date("Y-m-d", $dateHasta));
                    $Inventory = $productReport->getSummaryInventory($timeNormal);
                    $arrayInventory[] = array("productName" => $productReport->getProduct()->getName() . " (" . $productReport->getProduct()->getProductUnit()->getUnit() . ")", "total" => $Inventory["total_day"]);
                }
            }

//TOTALES DE PRODUCCION
            if ($totalProdPlan > 0) {
                $subTotalProdPlan = ($totalProdReal * 100) / $totalProdPlan;
            } else {
                $totalProdPlan = 0.0;
            }
            $arrayProductionTotals = array(
                $totalProdPlan,
                $totalProdReal,
                $subTotalProdPlan,
                $totalProdPlan - $totalProdReal);

//TOTALES DE MATERIA PRIMA
            $arrayRawMaterialTotals = array(
                $totalRawPlan,
                $totalRawReal
            );

            $tools = new \Pequiven\SEIPBundle\Service\ToolService();
            if (count($data["reportTemplate"]) != 0) {
                $plant = $data["reportTemplate"][0]->getName();
            } else {
                $plant = "null";
            }

            asort($arrayObservation);
            $reportService = $this->getProductReportService();


            $graphicProducctionRange = $reportService->generateColumn3dLineryPerRange(array("caption" => "Producción por Dia", "subCaption" => "Valores Expresados en TM"), $arrayProduction, array("range" => $byRange, "dateFrom" => $dateFrom, "dateEnd" => $dateEnd));



            $data = array(
                'dateReport' => $dateReport,
                'production' => $arrayProduction,
                'totalProduction' => $arrayProductionTotals,
                'rawMaterial' => $arrayRawMaterial,
                'totalRawMaterial' => $arrayRawMaterialTotals,
                'consumerPlanning' => $arrayConsumerServices,
                'unrealizedProduction' => $arrayUnrealizedProduction,
                'inventory' => $arrayInventory,
                'observation' => $arrayObservation,
                'plantsNames' => $plants,
                'typeReport' => $typeReport,
                'plantReportId' => $plantReportId,
                'form' => $form->createView(),
                'showDay' => $showDay,
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
                "graphicRange" => $graphicProducctionRange,
                "securityService" => $this->getSecurityService(),
                "plant" => $plant,
                "tools" => $tools
            );

            $view = $this
                    ->view()
                    ->setTemplate($this->config->getTemplate('vizualice.html'))
            ;
            $view->setData($data);
        } else {


            $productsReport = new \Doctrine\Common\Collections\ArrayCollection();
            $consumerPlanningServices = new \Doctrine\Common\Collections\ArrayCollection();
            $rawMaterialConsumptionPlannings = new \Doctrine\Common\Collections\ArrayCollection();

            $productsReportByIdProduct = $consumerPlanningServicesByIdService = $rawMaterialConsumptionPlanningsById = array();
            foreach ($plantReports as $plantReport) {

                if (!in_array($plantReport->getReportTemplate()->getName(), $plants)) {
                    $plants[] = $plantReport->getReportTemplate()->getName();
                }

                foreach ($plantReport->getProductsReport() as $productReport) {
                    $product = $productReport->getProduct();
                    if (!isset($productsReportByIdProduct[$product->getId()])) {
                        $productsReportByIdProduct[$product->getId()] = array();
                    }
                    $productsReportByIdProduct[$product->getId()][] = $productReport;

                    foreach ($productReport->getRawMaterialConsumptionPlannings() as $rawMaterialConsumptionPlanning) {
                        $product = $rawMaterialConsumptionPlanning->getProduct();
                        if (!isset($rawMaterialConsumptionPlanningsById[$product->getId()])) {
                            $rawMaterialConsumptionPlanningsById[$product->getId()] = array();
                        }
                        $rawMaterialConsumptionPlanningsById[$product->getId()][] = $rawMaterialConsumptionPlanning;
                    }
                }

                foreach ($plantReport->getConsumerPlanningServices() as $consumerPlanningService) {
                    $service = $consumerPlanningService->getService();
                    if (!isset($consumerPlanningServicesByIdService[$service->getId()])) {
                        $consumerPlanningServicesByIdService[$service->getId()] = array();
                    }
                    $consumerPlanningServicesByIdService[$service->getId()][] = $consumerPlanningService;
                }
            }

            foreach ($productsReportByIdProduct as $id => $groups) {
                foreach ($groups as $productReport) {
                    if (!$productsReport->contains($productReport)) {
                        $productsReport->add($productReport);
                    }
                }
            }

            foreach ($consumerPlanningServicesByIdService as $id => $groups) {
                foreach ($groups as $consumerPlanningService) {
                    if (!$consumerPlanningServices->contains($consumerPlanningService)) {
                        $consumerPlanningServices->add($consumerPlanningService);
                    }
                }
            }

            foreach ($rawMaterialConsumptionPlanningsById as $id => $groups) {
                foreach ($groups as $rawMaterialConsumptionPlanning) {
                    if (!$rawMaterialConsumptionPlannings->contains($rawMaterialConsumptionPlanning)) {
                        $rawMaterialConsumptionPlannings->add($rawMaterialConsumptionPlanning);
                    }
                }
            }
//Filtrar productos que quiere el usuario
            if ($productsReportConsulting && count($productsReportConsulting) > 0) {
                foreach ($productsReport as $productReport) {
                    if (!$productsReportConsulting->contains($productReport)) {
                        $productsReport->removeElement($productReport);
                    }
                }
            }

            $reportService = $this->getProductReportService();

            $graphicsDays = $reportService->generateColumn3dLinery(array("caption" => "Producción por Dia", "subCaption" => "Valores Expresados en TM"), $productsReport, array("range" => $byRange, "dateFrom" => $dateFrom, "dateEnd" => $dateEnd), $dateReport, $typeReport, "getSummaryDay", "plan", "real");
            $graphicsMonth = $reportService->generateColumn3dLinery(array("caption" => "Producción por Mes", "subCaption" => "Valores Expresados en TM"), $productsReport, array("range" => $byRange, "dateFrom" => $dateFrom, "dateEnd" => $dateEnd), $dateReport, $typeReport, "getSummaryMonth", "plan_acumulated", "real_acumulated");
            $graphicsYear = $reportService->generateColumn3dLinery(array("caption" => "Producción por Año", "subCaption" => "Valores Expresados en MTM"), $productsReport, array("range" => $byRange, "dateFrom" => $dateFrom, "dateEnd" => $dateEnd), $dateReport, $typeReport, "getSummaryYear", "plan_acumulated", "real_acumulated", 1000);

            //PRODUCTION
            $dayPlan = 0.0;
            $dayReal = 0.0;

            $MonthPlan = 0.0;
            $MonthPlanAcumulated = 0.0;
            $MonthRealAcumualated = 0.0;

            $yearPlan = 0.0;
            $yearPlanAcumulated = 0.0;
            $yearRealAcumualated = 0.0;



            $summaryProducction = array();
            $summaryProducctionTotals = array();

            $observations = array();

            foreach ($productsReport as $productReport) {
                //PRODUCCTION DAY
                $summaryDay = $productReport->getSummaryDay($dateReport, $typeReport);

                $dayPlan+=$summaryDay["plan"];
                $dayReal+=$summaryDay["real"];

                if ($summaryDay["plan"] - $summaryDay["real"] < 0) {
                    $var = 0;
                } else {
                    $var = $summaryDay["plan"] - $summaryDay["real"];
                }

                //ME TRAIGO LAS OBSERVACIONES 
                $observations[] = array(
                    "nameProduct" => $productReport->getProduct()->getName() . " (" . $productReport->getPlantReport()->getPlant()->getName() . ")",
                    "obs" => $summaryDay["observation"]
                );

                if ($summaryDay["plan"] > 0) {
                    $ejecutionDay = ($summaryDay["real"] * 100) / $summaryDay["plan"];
                } else {
                    $ejecutionDay = 0;
                }
                $summaryProducction["day"][] = array(
                    "nameProduct" => $productReport->getProduct()->getName() . " (" . $productReport->getProduct()->getProductUnit() . ")",
                    "plan" => number_format($summaryDay["plan"], 2, ',', '.'),
                    "real" => number_format($summaryDay["real"], 2, ',', '.'),
                    "ejecution" => number_format($ejecutionDay, 2, ',', '.'),
                    "var" => number_format($var, 2, ',', '.')
                );


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

                //RAW MATERIAL 
                //if ($productReport->getProduct()->getIsRawMaterial()) {
                foreach ($productReport->getRawMaterialConsumptionPlannings() as $rawMaterial) {
                    if ($rawMaterial->getProduct()->getIsRawMaterial()) {
                        $rawMaterialResult = $rawMaterial->getSummary($dateReport);
                        $arrayRawMaterial[] = array(
                            "productName" => $rawMaterial->getProduct()->getName() . " (" . $rawMaterial->getProduct()->getProductUnit()->getUnit() . ")",
                            "plan" => number_format($rawMaterialResult["total_day_plan"], 2, ',', '.'),
                            "real" => number_format($rawMaterialResult["total_day"], 2, ',', '.'),
                            "plan_month" => number_format($rawMaterialResult["total_month_plan"], 2, ',', '.'),
                            "real_month" => number_format($rawMaterialResult["total_month"], 2, ',', '.'),
                            "plan_year" => number_format($rawMaterialResult["total_year_plan"], 2, ',', '.'),
                            "real_year" => number_format($rawMaterialResult["total_year"], 2, ',', '.')
                        );
                    }
                }
                //}
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
//            $totalConsumerServices = array(
//                "plan" => 0.0,
//                "real" => 0.0,
//                "plan_month" => 0.0,
//                "real_month" => 0.0,
//                "plan_year" => 0.0,
//                "real_year" => 0.0,
//            );
            $arrayConsumerServices = array();

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

            foreach ($plantReports as $planReport) {
                //CONSUMO DE SERVICIOS

                foreach ($planReport->getConsumerPlanningServices() as $consumerPlanningService) {

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
                }


                //PRODUCION NO REALIZADA

                foreach ($planReport->getProductsReport() as $productReport) {
                    $productId = $productReport->getProduct()->getId();

                    if (!in_array($productId, $arrayNamesUnrealizedProduction)) {
                        $arrayNamesUnrealizedProduction[] = $productId;
                        $arrayUnrealizedProduction[$productId] = array(
                            "productName" => $productReport->getProduct()->getName() . " (" . $productReport->getProduct()->getProductUnit()->getUnit() . ")",
                            //ID DEL PRODUCT_REPORT
                            "productId" => $productReport->getId(),
                            "reportTemplateId" => $productReport->getPlantReport()->getReportTemplate()->getId(),
                            //ID DEL PRODUCTO
                            "idProduct" => $productId
                        );
                    }

                    $unrealizedProduction = $productReport->getSummaryUnrealizedProductions($dateReport);

                    $arrayUnrealizedProduction[$productId]["day"] = $unrealizedProduction["total_day"];
                    $arrayUnrealizedProduction[$productId]["month"] = $unrealizedProduction["total_month"];
                    $arrayUnrealizedProduction[$productId]["year"] = $unrealizedProduction["total_year"];

                    $totalUnrealizedProduction["day"] += $unrealizedProduction["total_day"];
                    $totalUnrealizedProduction["month"] += $unrealizedProduction["total_month"];
                    $totalUnrealizedProduction["year"] += $unrealizedProduction["total_year"];
                }


                foreach ($planReport->getProductsReport() as $productReport) {
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






//TOTALES YEAR PRODUCTIONS
            if ($dayPlan - $dayReal < 0) {
                $varDay = 0;
            } else {
                $varDay = $dayPlan - $dayReal;
            }
            if ($dayReal != 0) {
                $ejecutionDay = ($dayPlan * 100) / $dayReal;
            } else {
                $ejecutionDay = 0.0;
            }
            $summaryProducctionTotals["day"] = array(
                "plan_total" => number_format($dayPlan, 2, ',', '.'),
                "real_total" => number_format($dayReal, 2, ',', '.'),
                "ejectution_total" => number_format($ejecutionDay, 2, ',', '.'),
                "var" => number_format($varDay, 2, ',', '.')
            );

            //TOTALES MONTH PRODUCCTIONS
            if ($MonthPlanAcumulated - $MonthRealAcumualated) {
                $varMonth = 0;
            } else {
                $varMonth = $MonthPlanAcumulated - $MonthRealAcumualated;
            }

            if ($MonthRealAcumualated != 0) {
                $ejecutionMonth = ($MonthPlanAcumulated * 100) / $MonthRealAcumualated;
            } else {
                $ejecutionMonth = 0.0;
            }
            $summaryProducctionTotals["month"] = array(
                "plan_total" => number_format($MonthPlan, 2, ',', '.'),
                "plan_acumulated_total" => number_format($MonthPlanAcumulated, 2, ',', '.'),
                "real_acumulated_total" => number_format($MonthRealAcumualated, 2, ',', '.'),
                "ejectution_total" => number_format($ejecutionMonth, 2, ',', '.'),
                "var" => number_format($varMonth, 2, ',', '.')
            );


            //TOTALES YEAR PRODUCCTIONS
            if (($yearPlanAcumulated - $yearRealAcumualated) < 0) {
                $varMonth = 0;
            } else {
                $varMonth = $yearPlanAcumulated - $yearRealAcumualated;
            }

            if ($yearRealAcumualated != 0) {
                $ejecutionYear = ($yearPlanAcumulated * 100) / $yearRealAcumualated;
            } else {
                $ejecutionYear = 0.0;
            }
            $summaryProducctionTotals["year"] = array(
                "plan_total" => number_format($yearPlan, 2, ',', '.'),
                "plan_acumulated_total" => number_format($yearPlanAcumulated, 2, ',', '.'),
                "real_acumulated_total" => number_format($yearRealAcumualated, 2, ',', '.'),
                "ejectution_total" => number_format($ejecutionYear, 2, ',', '.'),
                "var" => number_format($varMonth, 2, ',', '.')
            );




            $tools = new \Pequiven\SEIPBundle\Service\ToolService();


            if (count($data["reportTemplate"]) != 0) {
                $plant = $data["reportTemplate"][0]->getName();
            } else {
                $plant = "null";
            }

            $data = array(
                'dateReport' => $dateReport,
                'productsReport' => $productsReport,
                'productReport' => $productsReport,
                'typeReport' => $typeReport,
                'producction' => $summaryProducction,
                'totalProducction' => $summaryProducctionTotals,
                'rawMaterials' => $arrayRawMaterial,
                'consumerServices' => $arrayConsumerServices,
                'totalConsumerServices' => $totalConsumerServices,
                'unrealizedProductions' => $arrayUnrealizedProduction,
                'totalUnrealizedProduction' => $totalUnrealizedProduction,
                'inventorys' => $arrayInventory,
                'totalInventorys' => $totalInventory,
                'observations' => $observations,
                'plantReportId' => $plantReportId,
                'plantsNames' => $plants,
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
                "graphicsDays" => $graphicsDays,
                "graphicsMonth" => $graphicsMonth,
                "graphicsYear" => $graphicsYear,
                "securityService" => $this->getSecurityService(),
                "plant" => $plant,
                "tools" => $tools
            );

            $view = $this
                    ->view()
                    ->setTemplate($this->config->getTemplate('vizualice.html'))
            ;
            $view->setData($data);
        }

        $sections = array(
            "production" => $showProduction,
            "rawMaterial" => $showRawMaterial,
            "services" => $showService,
            "inventory" => $showInventory,
            "pnr" => $showPnr,
            "observations" => $showObservation
        );



        if ($exportToPdf == "1") {
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
            if ($byRange) {
                $html = $this->renderView('PequivenSEIPBundle:DataLoad/ReportTemplate:vizualice_data_by_range.html.twig', $data);
            } else {
                $html = $this->renderView('PequivenSEIPBundle:DataLoad/ReportTemplate:vizualice_data.html.twig', $data);
            }
// print a block of text using Write()
            $pdf->writeHTML($html, true, false, true, false, '');

//            $pdf->Output('Reporte del dia'.'.pdf', 'I');
            $pdf->Output('Reporte del dia' . '.pdf', 'D');
        } else if ($exportToPdf == "2") {
            if ($byRange) {
                $production = array(
                    "production" => $arrayProduction,
                    "totalProduction" => $arrayProductionTotals,
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
        }

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
        $activeSheet->setCellValue("H2", $days[date("N")] . ", " . date("d/m/Y"));

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

            $t = 0;
            $activeSheet->getStyle("B" . $row . ":" . "F" . $row)->applyFromArray($styleArray);

            for ($x = 0; $x < count($impressOperacion["col"]); $x++) {
//$cell = $impressOperacion["col"][$x] . $row;
                if ($impressOperacion["col"][$x] == "B") {
                    $activeSheet->setCellValue($impressOperacion["col"][$x] . $row, "Totales");
                } else {
                    $activeSheet->setCellValue($impressOperacion["col"][$x] . $row, number_format($totalProduction[$x - 1], 2, ",", "."));
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
        $activeSheet->setCellValue("H2", $days[date("N")] . ", " . date("d/m/Y"));

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

                        array_push($rowData, $productReport->getProduct()->getName() . " (" . $productReport->getProduct()->getProductUnit() . ")");

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
                "col" => array("B", "C", "D", "E"),
                "campos" => array("Producto", "DIA", "MES", "AÑO"),
                "color" => "ffaa15"
            );

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
                "col" => array("B", "C", "D", "E"),
                "campos" => array("Producto", "DIA", "MES", "AÑO"),
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

        $productos = array();
        $totalDay = array();
        $totalMonth = array();
        $totalYear = array();

        foreach ($rawMaterial as $rs) {

            $productos[] = $rs->getProduct()->getName() . " (" . $rs->getProduct()->getProductUnit() . ")";
//$productos[] = $rs->$name;
            array_push($totalDay, $rs->getSummary($dateReport)["total_day"]);
            array_push($totalMonth, $rs->getSummary($dateReport)["total_month"]);
            array_push($totalYear, $rs->getSummary($dateReport)["total_year"]);
//var_dump($rawMaterialConsumption->getSummary($dateReport));
        }

        return $this->getArrayTable($rawMaterial, $dateReport, $productos, $totalDay, $totalMonth, $totalYear);
    }

    public function getDataConsumerPlanning($consumerPlanning, $dateReport) {

        $productos = array();
        $totalDay = array();
        $totalMonth = array();
        $totalYear = array();

        foreach ($consumerPlanning as $rs) {
            $productos[] = $rs->getService()->getName() . " (" . $rs->getService()->getServiceUnit() . ")";
//$productos[] = $rs->$name;
            array_push($totalDay, $rs->getSummary($dateReport)["total_day"]);
            array_push($totalMonth, $rs->getSummary($dateReport)["total_month"]);
            array_push($totalYear, $rs->getSummary($dateReport)["total_year"]);
//var_dump($rawMaterialConsumption->getSummary($dateReport));
        }



        return $this->getArrayTable($consumerPlanning, $dateReport, $productos, $totalDay, $totalMonth, $totalYear);
    }

    public function getDataUnrealizedProduction($productsReport, $dateReport) {

        $productos = array();
        $totalDay = array();
        $totalMonth = array();
        $totalYear = array();

        foreach ($productsReport as $rs) {
            $productos[] = $rs->getProduct()->getName() . " (" . $rs->getProduct()->getProductUnit() . ")";
//$productos[] = $rs->$name;
            array_push($totalDay, $rs->getSummaryUnrealizedProductions($dateReport)["total_day"]);
            array_push($totalMonth, $rs->getSummaryUnrealizedProductions($dateReport)["total_month"]);
            array_push($totalYear, $rs->getSummaryUnrealizedProductions($dateReport)["total_year"]);
//var_dump($rawMaterialConsumption->getSummary($dateReport));
        }



        return $this->getArrayTable($productsReport, $dateReport, $productos, $totalDay, $totalMonth, $totalYear);
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

//var_dump($rawMaterialConsumption->getSummary($dateReport));
        }



        return $this->getArrayTable($productsReport, $dateReport, $productos, $totalDay, $totalMonth, $totalMonth, $totalYear);
    }

    /**
     * 
     * @param type $arrayData
     * @return array
     */
    public function getArrayTable($arrayData, $dateReport, $productos, $totalDay, $totalMonth, $totalYear) {

        $consumos = array();

        $day = array();
        $month = array();
        $year = array();

        foreach (array_unique($productos) as $prod) {
            $rep = array_keys($productos, $prod);
            $tDay = 0;
            $tMonth = 0;
            $tYear = 0;
            if ($rep > 0) {
                foreach ($rep as $r) {
                    $tDay = $tDay + $totalDay[$r];
                    $tMonth = $tMonth + $totalMonth[$r];
                    if (count($totalYear) > 0) {
                        $tYear = $tYear + $totalYear[$r];
                    }
                }
                $day[] = $tDay;
                $month[] = $tMonth;
                if (count($totalYear) > 0) {
                    $year[] = $tYear;
                }
            } else {
                $day[] = $totalDay[$r];
                $month[] = $totalMonth[$r];
                if (count($totalYear) > 0) {
                    $year[] = $totalYear[$r];
                }
            }
        }
        $consumos[] = array_unique($productos);
        $consumos[] = $day;
        $consumos[] = $month;
        $consumos[] = $year;

        return $consumos;
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
