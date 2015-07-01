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
 * Controlador de producto de reporte
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class ProductReportController extends SEIPController
{
    public function createNew() {
        $entity = parent::createNew();
        $request = $this->getRequest();
        $plantReportId = $request->get("plantReport");
        if($plantReportId > 0){
            $em = $this->getDoctrine()->getManager();
            $plantReport = $em->find("Pequiven\SEIPBundle\Entity\DataLoad\PlantReport", $plantReportId);
            $entity->setPlantReport($plantReport);
        }
        return $entity;
    }
    
    /**
     * Ejecuta el presupuesto de produccion bruta para calcular lo demas
     * @param Request $request
     * @return type
     */
    public function runPlanningAction(Request $request)
    {
        set_time_limit(0);
        
        $resource = $this->findOr404($request);
        $productPlanningsNet = $resource->getProductPlanningsNet();//Presupuesto de produccion neto
        $productPlanningsGross = $resource->getProductPlanningsGross();//Presupuesto de bruta
        
        
        //Construir o completar presupuesto neta en base a bruta
        foreach ($productPlanningsGross as $productPlanningGross) {
            if(!isset($productPlanningsNet[$productPlanningGross->getMonth()])){
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
                    if($range->getType() == \Pequiven\SEIPBundle\Model\DataLoad\Production\Range::TYPE_FIXED_VALUE){
                        $range->setValue($total);
                    }elseif($range->getType() == \Pequiven\SEIPBundle\Model\DataLoad\Production\Range::TYPE_CAPACITY_FACTOR){
                        $range->setValue($netProductionPercentage);
                    }
                }
                $resource->addProductPlanning($cloneNet);
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
            if(isset($plantStopPlanningsByMonths[$month])){
                $plantStopPlanning = $plantStopPlanningsByMonths[$month];
                $daysStops = $plantStopPlanning->getDayStopsByDay();
                //Dias de paradas del mes
                foreach ($daysStops as $daysStop) {
                    $daysStopsArray[] = $daysStop->getNroDay();
                }
            }
            //Ragos de planificacion
            $ranges = $productPlanning->getRanges();
            
            if(!isset($productDetailDailyMonthsCache[$productPlanning->getMonth()])){
                $productDetailDailyMonth = new \Pequiven\SEIPBundle\Entity\DataLoad\Production\ProductDetailDailyMonth();
                $productDetailDailyMonth->setMonth($productPlanning->getMonth());
                $productDetailDailyMonth->setProductReport($resource);
                $productDetailDailyMonthsCache[$productPlanning->getMonth()] = $productDetailDailyMonth;
            }else{
                $productDetailDailyMonth = $productDetailDailyMonthsCache[$productPlanning->getMonth()];
            }
            
            $typeProductPlanning = $productPlanning->getType();
            $prefix = "";
            if($typeProductPlanning === \Pequiven\SEIPBundle\Model\DataLoad\Production\ProductPlanning::TYPE_GROSS){
                $prefix = "Gross";
            }else if($typeProductPlanning === \Pequiven\SEIPBundle\Model\DataLoad\Production\ProductPlanning::TYPE_NET){
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
                
                if($type === \Pequiven\SEIPBundle\Model\DataLoad\Production\Range::TYPE_FIXED_VALUE){
                    $value = $originalValue;
                }else if($type === \Pequiven\SEIPBundle\Model\DataLoad\Production\Range::TYPE_CAPACITY_FACTOR){
                    $productPlanning = $range->getProductPlanning();
                    $value = ($productPlanning->getDailyProductionCapacity() / 100) * $originalValue;
                }
                
                for($day = $dayFrom; $day <= $dayEnd; $day++){
                    $dayInt = (int)$day;
                    $propertyDayPlanProduction = sprintf("day%s%sPlan",$dayInt,$prefix);
                    $propertyDayPlan = sprintf("day%sPlan",$dayInt);
                    $dayInStop = false;//Es dia de parada
                    if(in_array($dayInt,$daysStopsArray)){
                        $dayInStop = true;
                    }
                    
                    //Solo si es bruta se calcula la meteria prima
                    if($typeProductPlanning === \Pequiven\SEIPBundle\Model\DataLoad\Production\ProductPlanning::TYPE_GROSS){
                        //Recorremos las meterias primas para calcular el valor por el alicuota
                        foreach ($rawMaterialConsumptionPlannings as $rawMaterialConsumptionPlanning) {
                            //Detalle de consumo de materia prima por mes
                            $detailRawMaterialConsumptions = $rawMaterialConsumptionPlanning->getDetailByMonth();
                            if(!isset($detailRawMaterialConsumptions[$month])){
                                //Si no esta el mes de consumo declarado lo creamos
                                $detailRawMaterialConsumption = new \Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial\DetailRawMaterialConsumption();
                                $detailRawMaterialConsumption
                                        ->setMonth($month)
                                        ;
                                $rawMaterialConsumptionPlanning->addDetailRawMaterialConsumption($detailRawMaterialConsumption);
                            }else{
                                //Tomamos el mes que ya existe para actualizar los valores del plan
                                $detailRawMaterialConsumption = $detailRawMaterialConsumptions[$month];
                            }
                            if($dayInStop === true){
                                $propertyAccessor->setValue($detailRawMaterialConsumption, $propertyDayPlan, 0);
                            }else{
                                //Calcular el consumo de materia prima del dia en base la alicuota
                                $aliquot = $rawMaterialConsumptionPlanning->getAliquot();
                                $totalByAliquot = $value * $aliquot;
                                $propertyAccessor->setValue($detailRawMaterialConsumption, $propertyDayPlan, $totalByAliquot);
                            }
                            $detailRawMaterialConsumption->totalize();
                            $rawMaterialConsumptionPlanning->calculate();
                            $this->save($rawMaterialConsumptionPlanning);
                        }
                    }
                    
                    if($dayInStop === true){
                        $propertyAccessor->setValue($productDetailDailyMonth, $propertyDayPlanProduction, 0);
                        continue;
                    }
                    $propertyAccessor->setValue($productDetailDailyMonth, $propertyDayPlanProduction, $value);
                }
            }
            $this->save($productDetailDailyMonth,false);
            $countProduct++;
        }
        if($countProduct > 0){
            foreach ($productDetailDailyMonthsCache as $productDetailDailyMonth) {
                $this->save($productDetailDailyMonth,false);
            }
            $this->flush();
        }
        
        $months = \Pequiven\SEIPBundle\Service\ToolService::getMonthsLabels();
        //Completar los inventarios
        $inventorys = $resource->getInventorySortByMonth();
        $unrealizedProductions = $resource->getUnrealizedProductionsSortByMonth();
        foreach ($months as $month => $label) {
            if(!isset($inventorys[$month])){
                $inventory = new \Pequiven\SEIPBundle\Entity\DataLoad\Inventory\Inventory();
                $inventory->setMonth($month);
                $resource->addInventory($inventory);
                
                $this->save($inventory,false);
            }
            if(!isset($unrealizedProductions[$month])){
                $unrealizedProduction = new \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProduction();
                $unrealizedProduction->setMonth($month);
                
                $resource->addUnrealizedProduction($unrealizedProduction);
                $this->save($unrealizedProduction,false);
            }
        }
        
        $this->flush();
        
        return $this->redirectHandler->redirectTo($resource);
    }
    
    public function deleteAction(Request $request) 
    {
        $resource = $this->findOr404($request);
        
        $url = $this->generateUrl("pequiven_plant_report_show",array(
            "id" => $resource->getPlantReport()->getId(),
        ));
        
        $this->domainManager->delete($resource);
        return $this->redirect($url);
    }
}
