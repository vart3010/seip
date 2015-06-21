<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com.ve
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Model\DataLoad;

use Pequiven\SEIPBundle\Model\BaseModel;

/**
 * Modelo de producto de reporte
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
abstract class ProductReport extends BaseModel implements ProductReportInterface
{
    /**
     * Tipo: Producto final
     */
    const TYPE_PRODUCT_FINAL = 0;
    /**
     * Tipo: Sub-producto
     */
    const TYPE_PRODUCT_BYPRODUCT = 1;

    /**
     * Retorna la etiqueta del tipo de producto
     * @return string
     */
    public function getTypeProductLabel()
    {
        $typeProduct = $this->getTypeProduct();
        $typeProductLabels = $this->getTypeProductLabels();
        $label = "";
        if(isset($typeProductLabels[$typeProduct])){
            $label = $typeProductLabels[$typeProduct];
        }
        return $label;
    }
    
    /**
     * Retorna los tipos de productos
     * @return string
     */
    public static function getTypeProductLabels()
    {
        return array(
            self::TYPE_PRODUCT_FINAL => "pequiven_seip.product_report.type.final",
            self::TYPE_PRODUCT_BYPRODUCT => "pequiven_seip.product_report.type.byproduct",
        );
    }
    /**
     * Devuelve la planificacion de la produccion bruta
     * @return type
     */
    public function getProductPlanningsGross()
    {
        return $this->getProductPlanningsByType(Production\ProductPlanning::TYPE_GROSS);
    }
    
    /**
     * Devuelve la planificacion de la produccion neta
     * @return type
     */
    public function getProductPlanningsNet()
    {
        return $this->getProductPlanningsByType(Production\ProductPlanning::TYPE_NET);
    }
    
    public function getProductPlanningsByType($type)
    {
        $productPlannings = $this->getProductPlannings();
        $result = array();
        foreach ($productPlannings as $productPlanning) {
            if($productPlanning->getType() === $type){
                $result[$productPlanning->getMonth()] = $productPlanning;
            }
        }
        ksort($result);
        return $result;
    }
    
    public function getTotalToDay()
    {
        $now = new \DateTime();
        $month = (int)$now->format("m");
        $day = (int)$now->format("d");
        $productDetailDailyMonths = $this->getProductDetailDailyMonthsSortByMonth();
        $totalGrossPlan = $totalGrossReal = $totalNetPlan = $totalNetReal = $totalMonthBefore = 0.0;
        foreach ($productDetailDailyMonths as $monthDetail => $productDetailDailyMonth) {
            if($monthDetail > $month){
                break;
            }
            
            if($month == $monthDetail){
                $totalGrossToDay = $productDetailDailyMonth->getTotalGrossToDay($day);
                $totalGrossPlan = $totalGrossPlan + $totalGrossToDay['tp'];
                $totalGrossReal = $totalGrossReal + $totalGrossToDay['tr'];

                $totalNetToDay = $productDetailDailyMonth->getTotalNetToDay($day);
                $totalNetPlan = $totalNetPlan + $totalNetToDay['tp'];
                $totalNetReal = $totalNetReal + $totalNetToDay['tr'];
            }else{
                $totalMonthBefore = $totalMonthBefore + $productDetailDailyMonth->getTotalGrossReal();
                
                $totalGrossPlan = $totalGrossPlan + $productDetailDailyMonth->getTotalGrossPlan();
                $totalGrossReal = $totalGrossReal + $productDetailDailyMonth->getTotalGrossReal();

                $totalNetPlan = $totalNetPlan + $productDetailDailyMonth->getTotalNetPlan();
                $totalNetReal = $totalNetReal + $productDetailDailyMonth->getTotalNetReal();
            }
            
        }
        $percentageGross = $percentageNet = 0.0;
        if($totalGrossReal > 0){
            $percentageGross = ($totalGrossReal * 100) / $totalGrossPlan;
        }
        if($totalNetReal > 0){
            $percentageNet = ($totalNetReal * 100) / $totalNetPlan;
        }
        $total = array(
            'tp_gross' => $totalGrossPlan,
            'tr_gross' => $totalGrossReal,
            'percentage_gross' => $percentageGross,
            
            'tp_net' => $totalNetPlan,
            'tr_net' => $totalNetReal,
            'percentage_net' => $percentageNet,
            
            'total_month_before' => $totalMonthBefore,//Total mes anterior
        );
        return $total;
    }
    
    function getTotalToDayRawMaterial()
    {
        $now = new \DateTime();
        $month = (int)$now->format("m");
        $day = (int)$now->format("d");
        
        $rawMaterialConsumptionPlannings = $this->getRawMaterialConsumptionPlannings();
        $totalPlan = $totalReal = $totalMonthBefore = 0.0;
        foreach ($rawMaterialConsumptionPlannings as $rawMaterialConsumptionPlanning) {
            $detailByMonth = $rawMaterialConsumptionPlanning->getDetailByMonth();
            foreach ($detailByMonth as $monthDetail => $detail) {
                if($monthDetail > $month){
                    break;
                }

                if($month == $monthDetail){
                    $totalToDay = $detail->getTotalToDay($day);
                    $totalPlan = $totalPlan + $totalToDay['tp'];
                    $totalReal = $totalReal + $totalToDay['tr'];
                }else{
                    $totalMonthBefore = $totalMonthBefore + $detail->getTotalReal();
                    $totalPlan = $totalPlan + $detail->getTotalPlan();
                    $totalReal = $totalReal + $detail->getTotalReal();
                }
            }
        }
        $percentage = 0;
        if($totalPlan > 0){
            $percentage = ($totalReal * 100) / $totalPlan;
        }
        $total = array(
            'tp' => $totalPlan,
            'tr' => $totalReal,
            'percentage' => $percentage,
            
            'total_month_before' => $totalMonthBefore,//Total mes anterior
        );
        return $total;
    }
    
    public function getTotalToDayUnrealizedProductions()
    {
        $now = new \DateTime();
        $month = (int)$now->format("m");
        $day = (int)$now->format("d");
        
        $unrealizedProductions = $this->getUnrealizedProductionsSortByMonth();
        $totalReal = $totalMonthBefore = 0.0;
        foreach ($unrealizedProductions as $unrealizedProduction) {
            $monthDetail = $unrealizedProduction->getMonth();
            if($monthDetail > $month){
                break;
            }

            if($month == $monthDetail){
                $totalToDay = $unrealizedProduction->getTotalToDay($day);
                $totalReal = $totalReal + $totalToDay;
            }else{
                $totalMonthBefore = $totalMonthBefore + $unrealizedProduction->getTotal();
                $totalReal = $totalReal + $unrealizedProduction->getTotal();
            }
        }
        $total = array(
            'tr' => $totalReal,
            
            'total_month_before' => $totalMonthBefore,//Total mes anterior
        );
        return $total;
    }
}
