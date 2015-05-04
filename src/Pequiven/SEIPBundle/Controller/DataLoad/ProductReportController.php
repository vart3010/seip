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
    public function runPlanningAction(Request $request)
    {
        $resource = $this->findOr404($request);
        //addProductDetailDailyMonth
        $productPlannings = $resource->getProductPlannings();
        $propertyAccessor = \Symfony\Component\PropertyAccess\PropertyAccess::createPropertyAccessor();
        
        $countProduct = 0;
        foreach ($productPlannings as $productPlanning) {
            $daysStops = $productPlanning->getDaysStops();
            $daysStopsArray = array();
            foreach ($daysStops as $daysStop) {
                $daysStopsArray[] = $daysStop->getNroDay();
            }
            $ranges = $productPlanning->getRanges();
            
            $productDetailDailyMonth = new \Pequiven\SEIPBundle\Entity\DataLoad\Production\ProductDetailDailyMonth();
            $productDetailDailyMonth->setMonth($productPlanning->getMonth());
            
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
                    $value = ($productPlanning->getDesignCapacity() / 100) * $originalValue;
                }
                for($day = $dayFrom; $day < $dayEnd; $day++){
                    $dayInt = (int)$day;
                    if(in_array($dayInt,$daysStopsArray)){
                        continue;
                    }
                    $propertyPath = sprintf("day%sPlan",$dayInt);
                    $propertyAccessor->setValue($productDetailDailyMonth, $propertyPath, $value);
                }
            }
            $resource->addProductDetailDailyMonth($productDetailDailyMonth);
            $this->save($productDetailDailyMonth,false);
            $countProduct++;
        }
        if($countProduct > 0){
            $this->flush();
        }
        
        return $this->redirectHandler->redirectTo($resource);
    }
}
