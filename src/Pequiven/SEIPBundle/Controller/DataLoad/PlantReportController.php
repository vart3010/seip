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
    
    public function indexAction(Request $request) 
    {
        $criteria = $request->get('filter',$this->config->getCriteria());
        $sorting = $request->get('sorting',$this->config->getSorting());
        $repository = $this->getRepository();

        
        $resources = $this->resourceResolver->getResource(
            $repository,
            'createPaginator',
            array($criteria, $sorting)
        );
        $maxPerPage = $this->config->getPaginationMaxPerPage();
        if(($limit = $request->query->get('limit')) && $limit > 0){
            if($limit > 100){
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
        if($request->get('_format') == 'html'){
            $view->setData($resources);
        }else{
            $formatData = $request->get('_formatData','default');
            $view->getSerializationContext()->setGroups(array('id','api_list','api_report_template'));
            $view->setData($resources->toArray($this->config->getRedirectRoute('index'),array(),$formatData));
        }
        return $this->handleView($view);
    }
    
    /**
     * Ejecuta la planificacion de la planta
     * @param Request $request
     * @return type
     */
    public function runAction(Request $request)
    {
        $resource = $this->findOr404($request);
        $productsReport = $resource->getProductsReport();
        $plantStopPlanningsByMonths = $resource->getPlantStopPlanningSortByMonth();
        $consumerPlanningServices = $resource->getConsumerPlanningServices();
        $propertyAccessor = \Symfony\Component\PropertyAccess\PropertyAccess::createPropertyAccessor();
        
        $getDayStops = function($month) use ($plantStopPlanningsByMonths){
            $daysStopsArray = array();
            if(isset($plantStopPlanningsByMonths[$month])){
                $daysStops = $plantStopPlanningsByMonths[$month];
                foreach ($daysStops as $daysStop) {
                    $daysStopsArray[] = $daysStop->getNroDay();
                }
            }
            return $daysStopsArray;
        };
        
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

                        if($type === \Pequiven\SEIPBundle\Model\DataLoad\RawMaterial\Range::TYPE_FIXED_VALUE){
                            $value = $originalValue;
                        }else if($type === \Pequiven\SEIPBundle\Model\DataLoad\RawMaterial\Range::TYPE_PERCENTAGE_BUDGET){
                            $value = ($monthBudget / 100) * $originalValue;
                        }

                        for($day = $dayFrom; $day <= $dayEnd; $day++){
                            $dayInt = (int)$day;
                            $propertyPath = sprintf("day%sPlan",$dayInt);
                            $propertyPathGross = sprintf("day%sGrossPlan",$dayInt);
                            if(in_array($dayInt,$daysStopsArray)){
                                $propertyAccessor->setValue($detail, $propertyPath, 0);
                                continue;
                            }

                            $totalPlan = 0.0;
                            //Recorremos los productos para calcular el plan del dia
                            foreach ($productsReport as $productReport) {
                                $productDetailDailyMonths = $productReport->getProductDetailDailyMonthsSortByMonth();
                                if(isset($productDetailDailyMonths[$month])){
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
            for($month = 1; $month <= 12; $month++){
                if(!isset($detailsByMonth[$month])){
                    $daysStopsArray = $getDayStops($month);
                    
                    $detail = new \Pequiven\SEIPBundle\Entity\DataLoad\Service\DetailConsumerPlanningService();
                    $detail->setMonth($month);
                    $consumerPlanningService->addDetailConsumerPlanningService($detail);

                    for($day = 1; $day <= 31; $day++){
                        $dayInt = (int)$day;
                        $propertyPath = sprintf("day%sPlan",$dayInt);
                        $propertyPathGross = sprintf("day%sGrossPlan",$dayInt);
                        if(in_array($dayInt,$daysStopsArray)){
                            $propertyAccessor->setValue($detail, $propertyPath, 0);
                            continue;
                        }

                        $totalPlan = 0.0;
                        //Recorremos los productos para calcular el plan del dia
                        foreach ($productsReport as $productReport) {
                            $productDetailDailyMonths = $productReport->getProductDetailDailyMonthsSortByMonth();
                            if(isset($productDetailDailyMonths[$month])){
                                $dayPlan = $propertyAccessor->getValue($productDetailDailyMonths[$month], $propertyPathGross);
                                $totalPlan = $totalPlan + $dayPlan;
                            }
                        }
                        $total = $aliquot * $totalPlan;
                        $propertyAccessor->setValue($detail, $propertyPath, $total);
                        $this->save($detail);
                    }

                    $this->save($consumerPlanningService);
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