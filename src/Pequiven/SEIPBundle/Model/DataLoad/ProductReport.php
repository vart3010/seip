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
abstract class ProductReport extends BaseModel implements ProductReportInterface {

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
    public function getTypeProductLabel() {
        $typeProduct = $this->getTypeProduct();
        $typeProductLabels = $this->getTypeProductLabels();
        $label = "";
        if (isset($typeProductLabels[$typeProduct])) {
            $label = $typeProductLabels[$typeProduct];
        }
        return $label;
    }

    /**
     * Retorna los tipos de productos
     * @return string
     */
    public static function getTypeProductLabels() {
        return array(
            self::TYPE_PRODUCT_FINAL => "pequiven_seip.product_report.type.final",
            self::TYPE_PRODUCT_BYPRODUCT => "pequiven_seip.product_report.type.byproduct",
        );
    }

    /**
     * Devuelve la planificacion de la produccion bruta
     * @return type
     */
    public function getProductPlanningsGross() {
        return $this->getProductPlanningsByType(Production\ProductPlanning::TYPE_GROSS);
    }

    /**
     * Devuelve la planificacion de la produccion neta
     * @return type
     */
    public function getProductPlanningsNet() {
        return $this->getProductPlanningsByType(Production\ProductPlanning::TYPE_NET);
    }

    /**
     * REtorna la planificacion de produccion por tipo bruta o neta
     * @param type $type
     * @return type
     */
    public function getProductPlanningsByType($type) {
        $productPlannings = $this->getProductPlannings();
        $result = array();
        foreach ($productPlannings as $productPlanning) {
            if ($productPlanning->getType() === $type) {
                $result[$productPlanning->getMonth()] = $productPlanning;
            }
        }
        ksort($result);
        return $result;
    }

    /**
     * Retorna el total hasta el dia
     * @return type
     */
    public function getTotalToDay() {
        $now = new \DateTime();
        $month = (int) $now->format("m");
        $day = (int) $now->format("d");
        $productDetailDailyMonths = $this->getProductDetailDailyMonthsSortByMonth();
        $totalGrossPlan = $totalGrossReal = $totalNetPlan = $totalNetReal = $totalGrossPlanBefore = $totalGrossRealBefore = $totalNetPlanBefore = $totalNetRealBefore = 0.0;
        foreach ($productDetailDailyMonths as $monthDetail => $productDetailDailyMonth) {
            if ($monthDetail > $month) {
                continue;
            }

            if ($month == $monthDetail) {
                $totalGrossToDay = $productDetailDailyMonth->getTotalGrossToDay($day);
                $totalGrossPlan = $totalGrossPlan + $totalGrossToDay['tp'];
                $totalGrossReal = $totalGrossReal + $totalGrossToDay['tr'];

                $totalNetToDay = $productDetailDailyMonth->getTotalNetToDay($day);
                $totalNetPlan = $totalNetPlan + $totalNetToDay['tp'];
                $totalNetReal = $totalNetReal + $totalNetToDay['tr'];
            } else {

                $totalGrossPlan = $totalGrossPlan + $productDetailDailyMonth->getTotalGrossPlan();
                $totalGrossReal = $totalGrossReal + $productDetailDailyMonth->getTotalGrossReal();

                $totalNetPlan = $totalNetPlan + $productDetailDailyMonth->getTotalNetPlan();
                $totalNetReal = $totalNetReal + $productDetailDailyMonth->getTotalNetReal();

                $totalGrossPlanBefore = $totalGrossPlan;
                $totalGrossRealBefore = $totalGrossReal;

                $totalNetPlanBefore = $totalNetPlan;
                $totalNetRealBefore = $totalNetReal;
            }
        }
        $percentageGross = $percentageNet = $percentageGrossBefore = $percentageNetBefore = 0.0;
        if ($totalGrossPlan > 0) {
            $percentageGross = ($totalGrossReal * 100) / $totalGrossPlan;
        }
        if ($totalGrossPlanBefore > 0) {
            $percentageGrossBefore = ($totalGrossRealBefore * 100) / $totalGrossPlanBefore;
        }
        if ($totalNetPlan > 0) {
            $percentageNet = ($totalNetReal * 100) / $totalNetPlan;
        }
        if ($totalNetPlanBefore > 0) {
            $percentageNetBefore = ($totalNetRealBefore * 100) / $totalNetPlanBefore;
        }
        $total = array(
            'tp_gross' => $totalGrossPlan,
            'tr_gross' => $totalGrossReal,
            'percentage_gross' => $percentageGross,
            'tp_net' => $totalNetPlan,
            'tr_net' => $totalNetReal,
            'percentage_net' => $percentageNet,
            'tp_gross_b' => $totalGrossPlanBefore, //Total plan mes anterior
            'tr_gross_b' => $totalGrossRealBefore,
            'percentage_gross_b' => $percentageGrossBefore,
            'tp_net_b' => $totalNetPlanBefore,
            'tr_net_b' => $totalNetRealBefore,
            'percentage_net_b' => $percentageNetBefore,
        );
        return $total;
    }

    /**
     * Total hasta el dia de materia prima
     * @return type
     */
    function getTotalToDayRawMaterial()
    {
        $now = new \DateTime();
        $month = (int)$now->format("m");
        $day = (int)$now->format("d");

        $rawMaterialConsumptionPlannings = $this->getRawMaterialConsumptionPlannings();
        $totalPlan = $totalReal = $totalPlanBefore = $totalRealBefore = 0.0;
        foreach ($rawMaterialConsumptionPlannings as $rawMaterialConsumptionPlanning) {
            $detailByMonth = $rawMaterialConsumptionPlanning->getDetailByMonth();
            foreach ($detailByMonth as $monthDetail => $detail) {
                if($monthDetail > $month){
                    continue;
                }

                if($month == $monthDetail){
                    $totalToDay = $detail->getTotalToDay($day);
                    $totalPlan = $totalPlan + $totalToDay['tp'];
                    $totalReal = $totalReal + $totalToDay['tr'];
                }else{
                    $totalPlan = $totalPlan + $detail->getTotalPlan();
                    $totalReal = $totalReal + $detail->getTotalReal();

                    $totalPlanBefore = $totalPlan;
                    $totalRealBefore = $totalReal;
                }
            }
        }
        $percentage = $percentageBefore = 0;
        if($totalPlan > 0){
            $percentage = ($totalReal * 100) / $totalPlan;
        }
        if($totalPlanBefore > 0){
            $percentageBefore = ($totalRealBefore * 100) / $totalPlanBefore;
        }
        $total = array(
            'tp' => $totalPlan,
            'tr' => $totalReal,
            'percentage' => $percentage,

            'tp_b' => $totalPlanBefore,
            'tr_b' => $totalRealBefore,
            'percentage_b' => $percentageBefore,
        );
        return $total;
    }

    /**
     * Obtiene el total hasta el dia de la pnr
     * @return type
     */
    public function getTotalToDayUnrealizedProductions() {
        $now = new \DateTime();
        $month = (int) $now->format("m");
        $day = (int) $now->format("d");

        $unrealizedProductions = $this->getUnrealizedProductionsSortByMonth();
        $totalReal = $totalRealBefore = 0.0;
        foreach ($unrealizedProductions as $unrealizedProduction) {
            $monthDetail = $unrealizedProduction->getMonth();
            if ($monthDetail > $month) {
                continue;
            }

            if ($month == $monthDetail) {
                $totalToDay = $unrealizedProduction->getTotalToDay($day);
                $totalReal = $totalReal + $totalToDay;
            } else {
                $totalReal = $totalReal + $unrealizedProduction->getTotal();
                $totalRealBefore = $totalReal;
            }
        }
        $total = array(
            'tr' => $totalReal,
            'tr_b' => $totalRealBefore, //Total mes anterior
        );
        return $total;
    }

    /**
     * Resumen del dia
     * @param \DateTime $date
     * @return type
     */
    public function getSummaryDay(\DateTime $date, $prefix) {
        $month = (int) $date->format("m");
        $day = (int) $date->format("d");

        $productDetailDailyMonths = $this->getProductDetailDailyMonthsSortByMonth();
        $plan = $real = 0.0;
        $observation = null;
        if (isset($productDetailDailyMonths[$month])) {
            $detail = $productDetailDailyMonths[$month];
            $namePlan = sprintf('getDay%s%sPlan', $day, $prefix);
            $nameReal = sprintf('getDay%s%sReal', $day, $prefix);
            $nameObservation = sprintf('getDay%sObservation', $day);
            $plan = $detail->$namePlan();
            $real = $detail->$nameReal();
            $observation = $detail->$nameObservation();
        }
        $percentage = 0;
        $pnr = $plan - $real;
        if ($plan > 0) {
            $percentage = ($real * 100) / $plan;
        }
        if ($pnr < 0) {
            $pnr = 0;
        }
        $total = array(
            'plan' => $plan,
            'real' => $real,
            'percentage' => $percentage,
            'pnr' => $pnr,
            'observation' => $observation,
        );
        return $total;
    }

    /**
     * Resumen del mes
     * @param \DateTime $date
     * @param type $prefix
     * @return type
     */
    public function getSummaryMonth(\DateTime $date, $prefix) {
        $month = (int) $date->format("m");
        $day = (int) $date->format("d");

        $productDetailDailyMonths = $this->getProductDetailDailyMonthsSortByMonth();
        $planMonth = $planAcumulated = $realAcumulated = 0.0;
        if (isset($productDetailDailyMonths[$month])) {
            $detail = $productDetailDailyMonths[$month];
            $totalNamePlan = sprintf('getTotal%sPlan', $prefix);
            $totalNameToDay = sprintf('getTotal%sToDay', $prefix);
            $planMonth = $detail->$totalNamePlan();
            $totals = $detail->$totalNameToDay($day);
            $planAcumulated = $totals['tp'];
            $realAcumulated = $totals['tr'];
        }
        $percentage = 0;
        $pnr = $planAcumulated - $realAcumulated;
        if ($planAcumulated > 0) {
            $percentage = ($realAcumulated * 100) / $planAcumulated;
        }
        if ($pnr < 0) {
            $pnr = 0;
        }
        $total = array(
            'plan_month' => $planMonth,
            'plan_acumulated' => $planAcumulated,
            'real_acumulated' => $realAcumulated,
            'percentage' => $percentage,
            'pnr' => $pnr,
            'meta' => $pnr,
        );
        return $total;
    }

    /**
     * Resumen del año
     * @param \DateTime $date
     * @param type $prefix
     * @return type
     */
    public function getSummaryYear(\DateTime $date, $prefix) {
        $month = (int) $date->format("m");
        $day = (int) $date->format("d");

        $productDetailDailyMonths = $this->getProductDetailDailyMonthsSortByMonth();
        $planYear = $planAcumulated = $realAcumulated = 0.0;

        $totalNamePlan = sprintf('getTotal%sPlan', $prefix);
        $totalNameReal = sprintf('getTotal%sReal', $prefix);
        $totalNameToDay = sprintf('getTotal%sToDay', $prefix);
//        var_dump((string)$this->getProduct());
        foreach ($productDetailDailyMonths as $monthDetail => $detail) {
            $planYear = $planYear + $detail->$totalNamePlan();
//            var_dump(sprintf("method %s, mes %s, total %s",$totalNamePlan,$monthDetail,$detail->$totalNamePlan()));
            if ($monthDetail > $month) {
                continue;
            }

            if ($month == $monthDetail) {
                $totalToDay = $detail->$totalNameToDay($day);
                $planAcumulated = $planAcumulated + $totalToDay['tp'];
                $realAcumulated = $realAcumulated + $totalToDay['tr'];
            } else {
                $planAcumulated = $planAcumulated + $detail->$totalNamePlan();
                $realAcumulated = $realAcumulated + $detail->$totalNameReal();
            }
        }
        $percentage = 0;
        $pnr = $planAcumulated - $realAcumulated;
        if ($planAcumulated > 0) {
            $percentage = ($realAcumulated * 100) / $planAcumulated;
        }
        if ($pnr < 0) {
            $pnr = 0;
        }
        $total = array(
            'plan_year' => $planYear,
            'plan_acumulated' => $planAcumulated,
            'real_acumulated' => $realAcumulated,
            'percentage' => $percentage,
            'pnr' => $pnr,
            'meta' => 0,
        );
        return $total;
    }

    /**
     * Retorna el resumen de la pnr
     * @param \DateTime $date
     * @return type
     */
    public function getSummaryUnrealizedProductions(\DateTime $date) {
        $month = (int) $date->format("m");
        $day = (int) $date->format("d");

        $totalDay = $totalMonth = $totalYear = 0.0;

        $unrealizedProductions = $this->getUnrealizedProductionsSortByMonth();
        
        foreach ($unrealizedProductions as $monthDetail => $detail) {
            //var_dump($detail);
            
            $totalYear = $totalYear + $detail->getTotal();

            if ($monthDetail > $month) {
                continue;
            }

            if ($month == $monthDetail) {
                $totalDayName = 'getDay' . $day;
                $totalDay = $detail->$totalDayName();
                $totalMonth = $totalMonth + $detail->getTotal();
            }
        }

        $total = array(
            'total_day' => $totalDay,
            'total_month' => $totalMonth,
            'total_year' => $totalYear,
        );
        return $total;
    }
    /**
     * FILTRO POR CAUSA
     * @param \DateTime $date
     * @return type
     */
    public function getSummaryUnrealizedProductionsFilterCause(\DateTime $date) {
        $month = (int) $date->format("m");
        $day = (int) $date->format("d");

        $totalDay = $totalMonth = $totalYear = 0.0;

        //$unrealizedProductions = $this->getUnrealizedProductionsSortByMonthWithOutProduction($failService);
        $unrealizedProductions = $this->getUnrealizedProductionsSortByMonth();
        
        //Obtener el array [total_day] [total_month] y [total_year] de la PNR por causa SOBRE PRODUCCIÓN
        
        
        foreach ($unrealizedProductions as $monthDetail => $detail) {
            
            $totalYear = $totalYear + $detail->getTotal();

            if ($monthDetail > $month) {
                continue;
            }

            if ($month == $monthDetail) {
                $totalDayName = 'getDay' . $day;
                $totalDay = $detail->$totalDayName();
                $totalMonth = $totalMonth + $detail->getTotal();
            }
        }
        
        //$totalYear = $totalYear - $totalOverProduction[year]
        //$totalMonth = $totalMonth - $totalOverProduction[month]
        //$totalDay = $totalDay - $totalOverProduction[day]

        $total = array(
            'total_day' => $totalDay,
            'total_month' => $totalMonth,
            'total_year' => $totalYear,
        );
        return $total;
    }

    /**
     * Retorna el resumen del inventario
     * @param \DateTime $date
     * @return type
     */
    public function getSummaryInventory(\DateTime $date) {
        $month = (int) $date->format("m");
        $day = (int) $date->format("d");

        $totalDay = $totalMonth = 0.0;

        $inventorys = $this->getInventorySortByMonth();
        foreach ($inventorys as $monthDetail => $detail) {
            if ($monthDetail > $month) {
                continue;
            }

            if ($month == $monthDetail) {
                $totalDayName = 'getDay' . $day;
                $totalDay = $detail->$totalDayName();
                $totalMonth = $detail->getYesterDayDate($date);
            }
        }

        $total = array(
            'total_day' => $totalDay,
            'total_month' => $totalMonth,
        );
        return $total;
    }

}
