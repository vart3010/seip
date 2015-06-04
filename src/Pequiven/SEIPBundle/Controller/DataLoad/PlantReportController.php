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
 * Reporte de planta
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class PlantReportController extends SEIPController
{
    public function createNew() 
    {
        $entity = parent::createNew();
        $request = $this->getRequest();
        $reportTemplateId = $request->get("reportTemplate");
        if($reportTemplateId > 0){
            $em = $this->getDoctrine()->getManager();
            $reportTemplate = $em->find("Pequiven\SEIPBundle\Entity\DataLoad\ReportTemplate", $reportTemplateId);
            $entity->init($reportTemplate);
        }
        return $entity;
    }
    
    public function runAction(Request $request)
    {
        $resource = $this->findOr404($request);
        
        $plantStopPlanningsByMonths = $resource->getPlantStopPlanningSortByMonth();
        $consumerPlanningServices = $resource->getConsumerPlanningServices();
        $propertyAccessor = \Symfony\Component\PropertyAccess\PropertyAccess::createPropertyAccessor();
        
        foreach ($consumerPlanningServices as $consumerPlanningService) {
            $details = $consumerPlanningService->getDetails();
            foreach ($details as $detail) {
                $daysStopsArray = array();
                $month = $detail->getMonth();
                if(isset($plantStopPlanningsByMonths[$month])){
                    $daysStops = $plantStopPlanningsByMonths[$month];
                    foreach ($daysStops as $daysStop) {
                        $daysStopsArray[] = $daysStop->getNroDay();
                    }
                }
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

                    if($type === \Pequiven\SEIPBundle\Model\DataLoad\RawMaterial\Range::TYPE_FIXED_VALUE){
                        $value = $originalValue;
                    }else if($type === \Pequiven\SEIPBundle\Model\DataLoad\RawMaterial\Range::TYPE_PERCENTAGE_BUDGET){
                        $value = ($monthBudget / 100) * $originalValue;
                    }

                    for($day = $dayFrom; $day < $dayEnd; $day++){
                        $dayInt = (int)$day;
                        $propertyPath = sprintf("day%sPlan",$dayInt);
                        if(in_array($dayInt,$daysStopsArray)){
                            $propertyAccessor->setValue($details, $propertyPath, 0);
                            continue;
                        }
                        $propertyAccessor->setValue($detail, $propertyPath, $value);
                        $this->save($detail);
                    }
                }
            }
            foreach ($resource->getPlantStopPlannings() as $plantStopPlanning)
            {
                $ranges = $plantStopPlanning->getRanges();
                if($ranges->count()){
                    foreach ($plantStopPlanning->getRanges() as $range) {

                        $totalHours = 0;
                        if($range->getOtherTime() === true){
                            $totalHours = $range->getHours();
                        }else{
                            if($range->getStopTime()){
                                $totalHours = $range->getStopTime()->getHours();
                            }
                        }
                        $dateFrom = $range->getDateFrom();
                        $dateEnd = $range->getDateEnd();
                        
                        $startDay = $dateFrom->format("d");
                        $endDay = $dateEnd->format("d");
                        for($i = $startDay; $i <= $endDay; $i++){
                            $dayStop = new \Pequiven\SEIPBundle\Entity\DataLoad\Plant\DayStop();
                            $day = clone($dateFrom);
                            $day->setDate($day->format('Y'), $day->format('m'), $i);
                            $dayStop->setDay($day);
                            $dayStop->setOtherTime($range->getOtherTime());
                            $dayStop->setStopTime($range->getStopTime());
                            $dayStops[] = $dayStop;
                        }
                    }
                    $dayStopsByDay = $plantStopPlanning->getDayStopsByDay();
                    foreach ($dayStops as $dayStop) {
                        if(!isset($dayStopsByDay[$dayStop->getNroDay()])){
                            $plantStopPlanning->addDayStop($dayStop);
                        }
                    }
                    $dayStopsCount = count($plantStopPlanning->getDayStopsByDay());
                    $totalStops = $plantStopPlanning->getTotalStops();
                    if($dayStopsCount > $totalStops){
                        $month = $this->trans($plantStopPlanning->getMonthLabel(),array(),'PequivenSEIPBundle');
                        $this->setFlash('error', 'pequiven.error.total_number_stops_no_be_greater_than_indicated',array(
                            "%totalDaysStops%" => $dayStopsCount,
                            "%totalStops%" => $totalStops,
                            "%month%" => $month,
                        )
                        );
                    }
                }
            }
        }
        $this->flush();
        return $this->redirectHandler->redirectTo($resource);
    }
    
    public function deleteAction(Request $request) 
    {
        $resource = $this->findOr404($request);
        
        $url = $this->generateUrl("pequiven_report_template_show",array(
            "id" => $resource->getReportTemplate()->getId(),
        ));
        
        $this->domainManager->delete($resource);
        return $this->redirect($url);
    }
}