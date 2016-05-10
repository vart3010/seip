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

/**
 * Controlador de producto de reporte
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class ProductReportController extends SEIPController {

    public function createNew() {
        $entity = parent::createNew();
        $request = $this->getRequest();
        $plantReportId = $request->get("plantReport");
        if ($plantReportId > 0) {
            $em = $this->getDoctrine()->getManager();
            $plantReport = $em->find("Pequiven\SEIPBundle\Entity\DataLoad\PlantReport", $plantReportId);
            $entity->setPlantReport($plantReport);
        }
        return $entity;
    }

    public function showAction(Request $request) {
        $periodService = $this->getPeriodService();
        $factorConversionService = $this->getFactorConversionService();
        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('show.html'))
                ->setTemplateVar($this->config->getResourceName())
                ->setData([
                $this->config->getResourceName() => $this->findOr404($request),
                    'isAllowPlanningReport' => $periodService->isAllowPlanningReport(),
                    'factorConversionService' => $factorConversionService,
                    'productReportService'=>$this->getProductReportService(),
                    'dateNow'=>  new \DateTime(date("Y-m-d", strtotime("-1 day")))
                ])
        ;

        return $this->handleView($view);
    }

    public function showGroupsAction(Request $request) {

        $productReport = $this->get("pequiven.repository.product_report")->findOneBy(array("id" => $request->get("id")));
        $periodService = $this->getPeriodService();
        $labelsMonths = CommonObject::getLabelsMonths();
        $nameGroup = $productReport->getNameGroup();

        /**
         * SE HACE LA SUMATORIA DE TODOS LOS PRODUCTOS DE ESE GRUPO DE PRODUCTOS
         * 
         * SE PRE-LLENAN LOS ARRAYS 
         *
         *
         * ARRAYS DE PRODUCCION 
         */
        $arrayProductGross = array();
        $arrayProductNet = array();
        $fieldsProduction = array(
            "idMonth" => 0.0,
            "month" => 0.0,
            "daily" => 0.0,
            "unit" => ""
        );
        $arrayProductGross = CommonObject::fillArrayMonth($arrayProductGross, $fieldsProduction);
        $arrayProductNet = CommonObject::fillArrayMonth($arrayProductNet, $fieldsProduction);

        /**
         * ARRAY DE DETALLE DE PRODUCCION
         */
        $arrayDetailProducction = array();
        $fieldsProductionDetail = array(
            "idMonth" => 0,
            "tpGross" => 0,
            "trGross" => 0,
            "tpNet" => 0,
            "trNet" => 0,
        );
        $arrayDetailProducction = CommonObject::fillArrayMonth($arrayDetailProducction, $fieldsProductionDetail);

        /**
         * ARRAY DE MATERIA PRIMA
         */
        $arrayRawMaterial = array();
        /**
         * ARRAY DE PRODUCCION NO REALIZADA 
         */
        $arrayUnrealizedProduction = array();
        $fieldsUnrealizedProduction = array(
            "month" => 0,
            "total" => 0
        );
        $arrayUnrealizedProduction = CommonObject::fillArrayMonth($arrayUnrealizedProduction, $fieldsUnrealizedProduction);


        /**
         * ARRAY DE INVENTARIO
         */
        $arrayInventory = array();
        $fieldsInventory = array(
            "month" => 0,
            "total" => 0
        );
        $arrayInventory = CommonObject::fillArrayMonth($arrayInventory, $fieldsInventory);

        /**
         * SE RECORREN LOS HIJOS DE PRODUCTOS
         */
        $productsChilds = $productReport->getChildrensGroup();

        foreach ($productsChilds as $productsReport) {
            //var_dump($product->getId());
            // foreach ($product->getProductReports() as $productsReport) {

            /**
             * PRODUCCION NETA Y BRUTA
             */
            foreach ($productsReport->getProductPlannings() as $productPlanning) {
                if ($productPlanning->getType() == \Pequiven\SEIPBundle\Model\DataLoad\Production\ProductPlanning::TYPE_GROSS) {
                    $arrayProductGross[$productPlanning->getMonth()]["idMonth"] = $labelsMonths[$productPlanning->getMonth()];
                    //$arrayProductGross[$productPlanning->getMonth()]["unit"] = $product->getProductUnit()->getUnit();
                    $arrayProductGross[$productPlanning->getMonth()]["month"] += $productPlanning->getTotalMonth();
                    $arrayProductGross[$productPlanning->getMonth()]["daily"] += $productPlanning->getDailyProductionCapacity();
                } else if ($productPlanning->getType() == \Pequiven\SEIPBundle\Model\DataLoad\Production\ProductPlanning::TYPE_NET) {
                    $arrayProductNet[$productPlanning->getMonth()]["idMonth"] = $labelsMonths[$productPlanning->getMonth()];
                    //$arrayProductNet[$productPlanning->getMonth()]["unit"] = $product->getProductUnit()->getUnit();
                    $arrayProductNet[$productPlanning->getMonth()]["month"] += $productPlanning->getTotalMonth();
                    $arrayProductNet[$productPlanning->getMonth()]["daily"] += $productPlanning->getDailyProductionCapacity();
                }
            }
            /**
             * DETALLES DE PRODUCCION
             */
            foreach ($productsReport->getProductDetailDailyMonthsSortByMonth() as $detailDailyMonth) {
                $arrayDetailProducction[$detailDailyMonth->getMonth()]["idMonth"] = $labelsMonths[$detailDailyMonth->getMonth()];
                $arrayDetailProducction[$detailDailyMonth->getMonth()]["tpGross"] += $detailDailyMonth->getTotalGrossPlan();
                $arrayDetailProducction[$detailDailyMonth->getMonth()]["trGross"] += $detailDailyMonth->getTotalGrossReal();
                $arrayDetailProducction[$detailDailyMonth->getMonth()]["tpNet"] += $detailDailyMonth->getTotalNetPlan();
                $arrayDetailProducction[$detailDailyMonth->getMonth()]["trNet"] += $detailDailyMonth->getTotalNetReal();
            }

            /**
             * CONSUMO DE MATERIA PRIMA
             */
            foreach ($productsReport->getRawMaterialConsumptionPlannings() as $rawMaterial) {

                if (!array_key_exists($rawMaterial->getId(), $arrayRawMaterial)) {
                    $arrayRawMaterial[$rawMaterial->getProduct()->getId()]["name"] = $rawMaterial->getProduct()->getname();
                    $arrayRawMaterial[$rawMaterial->getProduct()->getId()]["tp"] = $rawMaterial->getTotalPlan();
                    $arrayRawMaterial[$rawMaterial->getProduct()->getId()]["tr"] = $rawMaterial->getTotalReal();
                    $arrayRawMaterial[$rawMaterial->getProduct()->getId()]["aliquot"] = $rawMaterial->getAliquot();
                } else {
                    $arrayRawMaterial[$rawMaterial->getProduct()->getId()]["name"] = $rawMaterial->getProduct()->getname();
                    $arrayRawMaterial[$rawMaterial->getProduct()->getId()]["tp"] += $rawMaterial->getTotalPlan();
                    $arrayRawMaterial[$rawMaterial->getProduct()->getId()]["tr"] += $rawMaterial->getTotalReal();
                    $arrayRawMaterial[$rawMaterial->getProduct()->getId()]["aliquot"] += $rawMaterial->getAliquot();
                }
            }
            /**
             * PRODUCCION NO REALIZADA
             */
            $contMonthPnr = 1;
            foreach ($productsReport->getUnrealizedProductionsSortByMonth() as $unrealizedProduction) {
                $arrayUnrealizedProduction[$contMonthPnr]["month"] = $labelsMonths[$contMonthPnr];
                $arrayUnrealizedProduction[$contMonthPnr]["total"] += $unrealizedProduction->getTotal();
                $contMonthPnr++;
            }
            /**
             * INVENTARIO
             */
            $contMonthInventory = 1;
            foreach ($productsReport->getInventorySortByMonth() as $inventory) {
                $arrayInventory[$contMonthInventory]["month"] = $labelsMonths[$contMonthInventory];
                $arrayInventory[$contMonthInventory]["total"] += $inventory->getTotal();
                $contMonthInventory++;
            }
            //}
        }

        //die();
        //$productReport = $this->get("pequiven.repository.product_report")->findOneBy(array("id" => $request->get("id")));
        $lines = array();
        foreach ($productsChilds as $productReport) {
            if (!in_array($productReport->getProduct()->getProductionLine()->getName(), $lines)) {
                $lines[] = $productReport->getProduct()->getProductionLine()->getName();
            }
        }

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('showGroups.html'))
                ->setTemplateVar($this->config->getResourceName())
                ->setData([
            $this->config->getResourceName() => $this->findOr404($request),
            'product_report' => $productReport,
            'isAllowPlanningReport' => $periodService->isAllowPlanningReport(),
            'totalProductGross' => $arrayProductGross,
            'totalProductNet' => $arrayProductNet,
            'totalDetailProducction' => $arrayDetailProducction,
            'rawMaterial' => $arrayRawMaterial,
            'unrealizedProduction' => $arrayUnrealizedProduction,
            'inventory' => $arrayInventory,
            "productionLines" => $lines,
            "productChildrens" => $productsChilds,
            "groupName" => $nameGroup
                ])
        ;

        return $this->handleView($view);
    }

    /**
     * Ejecuta el presupuesto de produccion bruta para calcular lo demas
     * @param Request $request
     * @return type
     */
    public function runPlanningAction(Request $request) {
        set_time_limit(0);

        $resource = $this->findOr404($request);
        $productPlanningsNet = $resource->getProductPlanningsNet(); //Presupuesto de produccion neto
        $productPlanningsGross = $resource->getProductPlanningsGross(); //Presupuesto de bruta
//Construir o completar presupuesto neta en base a bruta
        foreach ($productPlanningsGross as $productPlanningGross) {
            if (!isset($productPlanningsNet[$productPlanningGross->getMonth()])) {
                $cloneNet = clone $productPlanningGross;
                $cloneNet->setType(\Pequiven\SEIPBundle\Entity\DataLoad\Production\ProductPlanning::TYPE_NET);
                $productPlanningsNet[$productPlanningGross->getMonth()] = $cloneNet;

//Porcentaje de la produccion bruta que va para la neta
                $netProductionPercentage = $productPlanningGross->getNetProductionPercentage();
                $dailyProductionCapacity = $cloneNet->getDailyProductionCapacity();
//Calcular produccion neta en base al porcentaje de la bruta
                $total = ($dailyProductionCapacity * $netProductionPercentage) / 100;
                $cloneNet->setDailyProductionCapacity($total);

                foreach ($cloneNet->getRanges() as $range) {
                    if ($range->getType() == \Pequiven\SEIPBundle\Model\DataLoad\Production\Range::TYPE_FIXED_VALUE) {
                        $range->setValue($total);
                    } elseif ($range->getType() == \Pequiven\SEIPBundle\Model\DataLoad\Production\Range::TYPE_CAPACITY_FACTOR) {
                        $range->setValue($netProductionPercentage);
                    }
                }
                $resource->addProductPlanning($cloneNet);
                if ($netProductionPercentage == 0) {
                    $cloneNet->setTotalMonth(0);
                }
            } else {

//Porcentaje de la produccion bruta que va para la neta
                $netProductionPercentage = $productPlanningGross->getNetProductionPercentage();
                $dailyProductionCapacity = $productPlanningGross->getDailyProductionCapacity();
//Calcular produccion neta en base al porcentaje de la bruta
                $total = ($dailyProductionCapacity * $netProductionPercentage) / 100;
                $productPlanningsNet[$productPlanningGross->getMonth()]->setDailyProductionCapacity($total);
                $presupuestoTotalBrutaMes = $productPlanningGross->getTotalMonth();
                $totalPresupuestoNetaMes = ($presupuestoTotalBrutaMes * $netProductionPercentage) / 100;
                $productPlanningsNet[$productPlanningGross->getMonth()]->setTotalMonth($totalPresupuestoNetaMes);

                if (count($productPlanningsNet[$productPlanningGross->getMonth()]->getRanges()) > 0) {
                    foreach ($productPlanningsNet[$productPlanningGross->getMonth()]->getRanges() as $range) {
                        if ($range->getType() == \Pequiven\SEIPBundle\Model\DataLoad\Production\Range::TYPE_FIXED_VALUE) {
                            $total = ($range->getValue() * $netProductionPercentage) / 100;
                            $range->setValue($total);
                        } elseif ($range->getType() == \Pequiven\SEIPBundle\Model\DataLoad\Production\Range::TYPE_CAPACITY_FACTOR) {
                            $range->setValue($netProductionPercentage);
                        }
                    }
                } else {
                    foreach ($productPlanningGross->getRanges() as $range) {
                        $cloneRange = clone $range;
                        if ($cloneRange->getType() == \Pequiven\SEIPBundle\Model\DataLoad\Production\Range::TYPE_FIXED_VALUE) {
                            $total = ($range->getValue() * $netProductionPercentage) / 100;
                            $cloneRange->setValue($total);
                        } elseif ($cloneRange->getType() == \Pequiven\SEIPBundle\Model\DataLoad\Production\Range::TYPE_CAPACITY_FACTOR) {
                            $cloneRange->setValue($netProductionPercentage);
                        }
                        $productPlanningsNet[$productPlanningGross->getMonth()]->addRange($cloneRange);
                    }
                }

                if ($netProductionPercentage == 0) {
                    $productPlanningsNet[$productPlanningGross->getMonth()]->setTotalMonth(0);
                }
                $this->save($productPlanningsNet[$productPlanningGross->getMonth()], true);
            }
        }
        $this->save($resource);
        

//Planificacion de productos
        $productPlannings = $resource->getProductPlannings();
//Planificacion de Paradas por mes
        $plantStopPlanningsByMonths = $resource->getPlantReport()->getPlantStopPlanningSortByMonth();
//Planificacion de Consumo de materia prima por productos
        $rawMaterialConsumptionPlannings = $resource->getRawMaterialConsumptionPlannings();

        $propertyAccessor = \Symfony\Component\PropertyAccess\PropertyAccess::createPropertyAccessor();
        $countProduct = 0;
        $productDetailDailyMonthsCache = $resource->getProductDetailDailyMonthsSortByMonth();
//Iteramos la planificacion de la produccion
        foreach ($productPlannings as $productPlanning) {
            $daysStopsArray = array();
//Buscamos el mes
            $month = $productPlanning->getMonth();
//Buscamos los dias de paradas del mes
            if (isset($plantStopPlanningsByMonths[$month])) {
                $plantStopPlanning = $plantStopPlanningsByMonths[$month];
                $daysStops = $plantStopPlanning->getDayStopsByDay();
//Dias de paradas del mes
                foreach ($daysStops as $daysStop) {
                    $daysStopsArray[] = $daysStop->getNroDay();
                }
            }
//Ragos de planificacion
            $ranges = $productPlanning->getRanges();

            if (!isset($productDetailDailyMonthsCache[$productPlanning->getMonth()])) {
                $productDetailDailyMonth = new \Pequiven\SEIPBundle\Entity\DataLoad\Production\ProductDetailDailyMonth();
                $productDetailDailyMonth->setMonth($productPlanning->getMonth());
                $productDetailDailyMonth->setProductReport($resource);
                $productDetailDailyMonthsCache[$productPlanning->getMonth()] = $productDetailDailyMonth;
            } else {
                $productDetailDailyMonth = $productDetailDailyMonthsCache[$productPlanning->getMonth()];
            }

            $typeProductPlanning = $productPlanning->getType();
            $prefix = "";
            if ($typeProductPlanning === \Pequiven\SEIPBundle\Model\DataLoad\Production\ProductPlanning::TYPE_GROSS) {
                $prefix = "Gross";
            } else if ($typeProductPlanning === \Pequiven\SEIPBundle\Model\DataLoad\Production\ProductPlanning::TYPE_NET) {
                $prefix = "Net";
            }

            foreach ($ranges as $range) {
                $dateFrom = $range->getDateFrom();
                $dateEnd = $range->getDateEnd();

                $dayFrom = $dateFrom->format("d");
                $dayEnd = $dateEnd->format("d");
                $type = $range->getType();
                $originalValue = $range->getValue();
                $value = 0;

                if ($type === \Pequiven\SEIPBundle\Model\DataLoad\Production\Range::TYPE_FIXED_VALUE) {
                    $value = $originalValue;
                } else if ($type === \Pequiven\SEIPBundle\Model\DataLoad\Production\Range::TYPE_CAPACITY_FACTOR) {
                    $productPlanning = $range->getProductPlanning();
                    $value = ($productPlanning->getDailyProductionCapacity() / 100) * $originalValue;
                }

                for ($day = $dayFrom; $day <= $dayEnd; $day++) {
                    $dayInt = (int) $day;
                    $propertyDayPlanProduction = sprintf("day%s%sPlan", $dayInt, $prefix);
                    $propertyDayPlan = sprintf("day%sPlan", $dayInt);
                    $dayInStop = false; //Es dia de parada
                    if (in_array($dayInt, $daysStopsArray)) {
                        $dayInStop = true;
                    }

//Solo si es bruta se calcula la meteria prima
                    if ($typeProductPlanning === \Pequiven\SEIPBundle\Model\DataLoad\Production\ProductPlanning::TYPE_GROSS) {
//Recorremos las meterias primas para calcular el valor por el alicuota
                        foreach ($rawMaterialConsumptionPlannings as $rawMaterialConsumptionPlanning) {
//Detalle de consumo de materia prima por mes
                            $detailRawMaterialConsumptions = $rawMaterialConsumptionPlanning->getDetailByMonth();
                            if (!isset($detailRawMaterialConsumptions[$month])) {
//Si no esta el mes de consumo declarado lo creamos
                                $detailRawMaterialConsumption = new \Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial\DetailRawMaterialConsumption();
                                $detailRawMaterialConsumption
                                        ->setMonth($month)
                                ;
                                $rawMaterialConsumptionPlanning->addDetailRawMaterialConsumption($detailRawMaterialConsumption);
                            } else {
//Tomamos el mes que ya existe para actualizar los valores del plan
                                $detailRawMaterialConsumption = $detailRawMaterialConsumptions[$month];
                            }
                            if ($dayInStop === true) {
                                $propertyAccessor->setValue($detailRawMaterialConsumption, $propertyDayPlan, 0);
                            } else {
                                if ($rawMaterialConsumptionPlanning->isAutomaticCalculationPlan() === true) {
//Calcular el consumo de materia prima del dia en base la alicuota
                                    $aliquot = $rawMaterialConsumptionPlanning->getAliquot();
                                    $totalByAliquot = $value * $aliquot;
                                    $propertyAccessor->setValue($detailRawMaterialConsumption, $propertyDayPlan, $totalByAliquot);
                                }
                            }
                            $this->save($rawMaterialConsumptionPlanning);
                        }
                    }//Fin de calculo de materia prima

                    if ($dayInStop === true) {
                        $propertyAccessor->setValue($productDetailDailyMonth, $propertyDayPlanProduction, 0);
                        continue;
                    }
//Sete o actualiza el valor
                    $propertyAccessor->setValue($productDetailDailyMonth, $propertyDayPlanProduction, $value);
                }
            }
            $this->save($productDetailDailyMonth, false);
            $countProduct++;
        }
        if ($countProduct > 0) {
            foreach ($productDetailDailyMonthsCache as $productDetailDailyMonth) {
                $this->save($productDetailDailyMonth, false);
            }
            $this->flush();
        }
        foreach ($rawMaterialConsumptionPlannings as $rawMaterialConsumptionPlanning) {
            $rawMaterialConsumptionPlanning->calculate();
            $this->save($rawMaterialConsumptionPlanning);
        }
        $months = \Pequiven\SEIPBundle\Service\ToolService::getMonthsLabels();
//Completar los inventarios
        $inventorys = $resource->getInventorySortByMonth();
        $unrealizedProductions = $resource->getUnrealizedProductionsSortByMonth();
        foreach ($months as $month => $label) {
//Si el inventario no esta lo agrega
            if (!isset($inventorys[$month])) {
                $inventory = new \Pequiven\SEIPBundle\Entity\DataLoad\Inventory\Inventory();
                $inventory->setMonth($month);
                $resource->addInventory($inventory);

                $this->save($inventory, false);
            }
//Si la pnr no esta lo agrega
            if (!isset($unrealizedProductions[$month])) {
                $unrealizedProduction = new \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProduction();
                $unrealizedProduction->setMonth($month);

                $resource->addUnrealizedProduction($unrealizedProduction);
                $this->save($unrealizedProduction, false);
            }
        }

        $this->flush();

        return $this->redirectHandler->redirectTo($resource);
    }

    public function deleteAction(Request $request) {
        $resource = $this->findOr404($request);

        $url = $this->generateUrl("pequiven_plant_report_show", array(
            "id" => $resource->getPlantReport()->getId(),
        ));

        $this->domainManager->delete($resource);
        return $this->redirect($url);
    }

    public function createActionGroup(Request $request) {
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
                return $this->redirectHandler->redirectToRoute($this->config->getRedirectRoute('update'), ['id' => $resource->getId()]);
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
    
    

    /**
     * 
     * @return type
     */
    protected function getFactorConversionService() {
        return $this->container->get('pequiven_factorConversion.service.factorConversion');
    }

    protected function getProductReportService() {
        return $this->container->get('seip.service.productReport');
    }

}
