<?php

namespace Pequiven\SEIPBundle\Service;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ProductReportService implements ContainerAwareInterface {

    private $container;

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    /**
     * FUNCION QUE ARMA EL VECTOR NAMES/VALUES PARA HACER GRAFICAS
     * @param type $productReport
     * @param type $dateReport
     * @param type $typeReport
     * @param type $var
     * @return array
     */
    public function getArray($productReport, $dateReport, $typeReport, $methodFrecuency, $var = "plan") {
        $rs = array();
        foreach ($productReport as $product) {
            //array_push($rs["names"], $product->getProduct()->getname());
            $typeVar = $product->$methodFrecuency($dateReport, $typeReport);
            //array_push($rs["values"],$typeVar[$var]);
            $rs[$product->getProduct()->getName()] = $typeVar[$var];
            //var_dump($product->getProduct()->getname());
            //var_dump($product->getSummaryDay($dateReport, $typeReport));
        }

        return $rs;
    }

    public function getArrayByDateFromInternalCausesPnr(\DateTime $dateReport, \Pequiven\SEIPBundle\Entity\DataLoad\ProductReport $productReport) {
        $day = date_format($dateReport, 'j');
        $month = date_format($dateReport, 'n');
        $monthWithZero = date_format($dateReport, 'm');
        $year = date_format($dateReport, 'Y');

        $em = $this->getDoctrine()->getManager();
        $causeFailService = $this->getCauseFailService();

        $rawMaterials = array(
            \Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL_MP => array(),
        );

        $methodTypeCausesIntExt = array(
            \Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL => "TYPE_FAIL_INTERNAL",
        );

        $result = array();

        //Seteamos el total por tipo de causa de PNR
        $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]['total']['day'] = 0.0;
        $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]['total']['month'] = 0.0;
        $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]['total']['year'] = 0.0;

        //Obtenemos la plantilla del reporte
//        $reportTemplateId = $options['idReportTemplate'];
//        $reportTemplate = $this->container->get('pequiven.repository.report_template')->findOneBy(array('id' => $reportTemplateId));
        //Obtenemos el producto
//        $product = $em->getRepository("Pequiven\SEIPBundle\Entity\CEI\Product")->find($options["idProduct"]);
        //Obtenemos el Reporte del Producto
//        $productReportId = $options['idProductReport'];
//        $productReport = $this->container->get('pequiven.repository.product_report')->find($productReportId);
        //Obtenemos las producciones no realizadas, asociadas al Reporte del Producto
        $unrealizedProductions = $productReport->getUnrealizedProductions();

        //Obtenemos las categorías de las causas de PNR por fallas por tipo Interna y Externa
        $failsInternal = $causeFailService->getFails(\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL);

        //Seteamos en el arreglo, la sección Causas Internas
        foreach ($failsInternal as $failInternal) {
            $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL][$failInternal->getName()]['day'] = 0.0;
            $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL][$failInternal->getName()]['month'] = 0.0;
            $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL][$failInternal->getName()]['year'] = 0.0;
        }

        //Recorremos las producciones no realizadas
        foreach ($unrealizedProductions as $unrealizedProduction) {
            $monthUnrealizedProduction = $unrealizedProduction->getMonth();

            //Seteamos el valor dia y mes
            if ($month == $unrealizedProduction->getMonth()) {
                $pnrByCausesIntExt = $causeFailService->getFailsCause($unrealizedProduction);
                foreach ($failsInternal as $failInternal) {
                    if ($failInternal->getName() == 'Sobre Producción') {
                        $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL][$failInternal->getName()]['day'] = $pnrByCausesIntExt[$methodTypeCausesIntExt[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]][$failInternal->getName()][$day];
                        $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]['total']['day'] = $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]['total']['day'] + $pnrByCausesIntExt[$methodTypeCausesIntExt[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]][$failInternal->getName()][$day];
                    }
                    for ($dayMonth = 1; $dayMonth <= $day; $dayMonth++) {
                        if ($failInternal->getName() == 'Sobre Producción') {
                            $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL][$failInternal->getName()]['month'] = $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL][$failInternal->getName()]['month'] + $pnrByCausesIntExt[$methodTypeCausesIntExt[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]][$failInternal->getName()][$dayMonth];
                            $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]['total']['month'] = $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]['total']['month'] + $pnrByCausesIntExt[$methodTypeCausesIntExt[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]][$failInternal->getName()][$dayMonth];
                        }
                    }
                }
            }


            //Seteamos el valor año
            if ($monthUnrealizedProduction <= $month) {
                $pnrByCausesIntExt = $causeFailService->getFailsCause($unrealizedProduction);
                foreach ($failsInternal as $failInternal) {
                    for ($dayMonth = 1; $dayMonth <= \Pequiven\SEIPBundle\Model\Common\CommonObject::getDaysPerMonth($monthUnrealizedProduction, $year); $dayMonth++) {
                        if ($month == $monthUnrealizedProduction) {
                            if ($dayMonth <= $day) {
                                if ($failInternal->getName() == 'Sobre Producción') {
                                    $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL][$failInternal->getName()]['year'] = $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL][$failInternal->getName()]['year'] + $pnrByCausesIntExt[$methodTypeCausesIntExt[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]][$failInternal->getName()][$dayMonth];
                                    $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]['total']['year'] = $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]['total']['year'] + $pnrByCausesIntExt[$methodTypeCausesIntExt[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]][$failInternal->getName()][$dayMonth];
                                }
                            }
                        } else {
                            if ($failInternal->getName() == 'Sobre Producción') {
                                $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL][$failInternal->getName()]['year'] = $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL][$failInternal->getName()]['year'] + $pnrByCausesIntExt[$methodTypeCausesIntExt[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]][$failInternal->getName()][$dayMonth];
                                $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]['total']['year'] = $result[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]['total']['year'] + $pnrByCausesIntExt[$methodTypeCausesIntExt[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]][$failInternal->getName()][$dayMonth];
                            }
                        }
                    }
                }
            }
        }

        return $result;
    }

    public function generatePie($data) {
        $chart = array();

        $chart["caption"] = $data["caption"];

        $chart["paletteColors"] = "#0075c2,#1aaf5d,#f2c500,#f45b00,#8e0000";
        $chart["bgColor"] = "ffffff";
        $chart["showBorder"] = "0";
        $chart["use3DLighting"] = "1";
        $chart["showShadow"] = "0";
        $chart["enableSmartLabels"] = "1";
        $chart["startingAngle"] = "0";
        $chart["showPercentValues"] = "0";
        $chart["showPercentInTooltip"] = "0";
        $chart["decimals"] = "1";
        $chart["captionFontSize"] = "14";
        $chart["subcaptionFontSize"] = "14";
        $chart["subcaptionFontBold"] = "1";
        $chart["showPercentInTooltip"] = "0";
        $chart["toolTipColor"] = "#ffffff";
        $chart["toolTipBorderThickness"] = "0";
        $chart["toolTipBgColor"] = "#000000";
        $chart["toolTipBgAlpha"] = "80";
        $chart["toolTipBorderRadius"] = "2";
        $chart["toolTipPadding"] = "5";
        $chart["showHoverEffect"] = "0";
        $chart["showLegend"] = "1";
        $chart["legendBgColor"] = "#ffffff";
        $chart["legendBorderAlpha"] = "0";
        $chart["legendShadow"] = "0";
        $chart["legendItemFontSize"] = "14";
        $chart["legendItemFontColor"] = "#666666";
        $chart["valueFontSize"] = "14";
        $chart["legendPosition"] = "RIGHT";
        $chart["legendCaptionAlignment"] = "right";


        $rs = array();
        foreach ($data["array"] as $key => $value) {
            array_push($rs, array(
                "label" => $key . " (" . $value . ")",
                "value" => $value,
                "toolText" => $key . " (" . $value . ")",
                "displayValue" => \Pequiven\SEIPBundle\Service\ToolService::truncate($key, array("limit" => "15"))
            ));
        }
        $chart["subcaption"] = $data["subCaption"];


        $pie = array(
            'dataSource' => array(
                'chart' => $chart,
                'data' => $rs
            ),
        );

        return json_encode($chart);
        //return $pie;
    }

    public function generateColumn3dLineryPerPlantGroups($titles, $summaryProduction, $range, $methodFrecuency, $fieldPlan, $fieldReal,$division = 1) {

        $data = array(
            'dataSource' => array(
                'chart' => array(),
                'categories' => array(),
                'dataset' => array(),
            ),
        );

        $chart = array();
        
         if ($range["range"]) {
            $chart["caption"] = "Producción desde " . $range["dateFrom"]->format("d-m-Y") . " hasta " . $range["dateEnd"]->format("d-m-Y");
        } else {
            $chart["caption"] = $titles["caption"];
        }
        $chart["subCaption"] = $titles["subCaption"];
        //        $chart["xAxisName"] = "Indicador";
        if ($division == 1) {
            $chart["pYAxisName"] = "Cantidad (TM)";
        } else if ($division == 1000) {
            $chart["pYAxisName"] = "Cantidad (MTM)";
        }
        $chart["sYAxisName"] = "% Ejecucion";
        $chart["sNumberSuffix"] = "%";
        $chart["sYAxisMaxValue"] = "100";
        $chart["paletteColors"] = "#0075c2,#1aaf5d,#f2c500";
        $chart["bgColor"] = "#ffffff";
        $chart["showBorder"] = "0";
        $chart["showCanvasBorder"] = "0";
        $chart["usePlotGradientColor"] = "0";
        $chart["plotBorderAlpha"] = "10";
        $chart["legendBorderAlpha"] = "0";
        $chart["legendBgAlpha"] = "0";
        $chart["legendShadow"] = "0";
        $chart["showHoverEffect"] = "1";
        $chart["valueFontColor"] = "#000000";
        $chart["valuePosition"] = "ABOVE";
        $chart["rotateValues"] = "1";
        $chart["placeValuesInside"] = "0";
        $chart["divlineColor"] = "#999999";
        $chart["divLineDashed"] = "1";
        $chart["divLineDashLen"] = "1";
        $chart["divLineGapLen"] = "1";
        $chart["canvasBgColor"] = "#ffffff";
        $chart["captionFontSize"] = "14";
        $chart["subcaptionFontSize"] = "14";
        $chart["subcaptionFontBold"] = "0";
        $chart["decimalSeparator"] = ",";
        $chart["thousandSeparator"] = ".";
        $chart["inDecimalSeparator"] = ",";
        $chart["inThousandSeparator"] = ".";
        $chart["decimals"] = "2";

        $chart["exportenabled"] = "1";
        $chart["exportatclient"] = "0";
        $chart["exportFormats"] = "PNG= Exportar como PNG|PDF= Exportar como PDF";
        $chart["exportFileName"] = "Grafico Resultados ";

        $data["dataSource"]["chart"] = $chart;
        #var_dump($summaryProduction);

        $arrayCategories = array();

        $perc = array();
        $plan = array();
        $real = array();



        foreach ($summaryProduction[$methodFrecuency] as $production) {
            $arrayCategories[] = array("label" => $production["nameGroup"]);
            $plan[] = array("value" => $production[$fieldPlan]);
            $real[] = array("value" => $production[$fieldReal]);

            if($production[$fieldPlan]==0) { 
                $p = 0.0;
            } else {
                $p = (($production[$fieldReal] * 100) / $production[$fieldPlan]);
            }

            $perc[] = array("value"=> number_format( $p, 2, ',', '.'));
        }
        $data["dataSource"]["categories"][]["category"] = $arrayCategories;
        $data["dataSource"]["dataset"][] = array(
            "seriesname" => "Plan",
            "data" => $plan
        );
        $data["dataSource"]["dataset"][] = array(
            "seriesname" => "Real",
            "data" => $real
        );
     
        $data["dataSource"]["dataset"][] = array(
            "seriesname" => "Porcentaje",
            "renderAs" => "line",
            "parentYAxis" => "S",
            "showValues" => "0",
            "data" => $perc
        );
        //var_dump(json_encode($data["dataSource"]["dataset"]));

        


        #var_dump($data["dataSource"]["dataset"]);
        #die();

        return json_encode($data);
    }

    public function generateColumn3dLinery($titles, $productReport, $range, $dateReport, $typeReport, $methodFrecuency, $plan, $real, $division = 1) {
        $data = array(
            'dataSource' => array(
                'chart' => array(),
                'categories' => array(),
                'dataset' => array(),
            ),
        );

        $chart = array();
        if ($range["range"]) {
            $chart["caption"] = "Producción desde " . $range["dateFrom"]->format("d-m-Y") . " hasta " . $range["dateEnd"]->format("d-m-Y");
        } else {
            $chart["caption"] = $titles["caption"];
        }
        $chart["subCaption"] = $titles["subCaption"];
        //        $chart["xAxisName"] = "Indicador";
        if ($division == 1) {
            $chart["pYAxisName"] = "Cantidad (TM)";
        } else if ($division == 1000) {
            $chart["pYAxisName"] = "Cantidad (MTM)";
        }
        $chart["sYAxisName"] = "% Ejecucion";
        $chart["sNumberSuffix"] = "%";
        $chart["sYAxisMaxValue"] = "100";
        $chart["paletteColors"] = "#0075c2,#1aaf5d,#f2c500";
        $chart["bgColor"] = "#ffffff";
        $chart["showBorder"] = "0";
        $chart["showCanvasBorder"] = "0";
        $chart["usePlotGradientColor"] = "0";
        $chart["plotBorderAlpha"] = "10";
        $chart["legendBorderAlpha"] = "0";
        $chart["legendBgAlpha"] = "0";
        $chart["legendShadow"] = "0";
        $chart["showHoverEffect"] = "1";
        $chart["valueFontColor"] = "#000000";
        $chart["valuePosition"] = "ABOVE";
        $chart["rotateValues"] = "1";
        $chart["placeValuesInside"] = "0";
        $chart["divlineColor"] = "#999999";
        $chart["divLineDashed"] = "1";
        $chart["divLineDashLen"] = "1";
        $chart["divLineGapLen"] = "1";
        $chart["canvasBgColor"] = "#ffffff";
        $chart["captionFontSize"] = "14";
        $chart["subcaptionFontSize"] = "14";
        $chart["subcaptionFontBold"] = "0";
        $chart["decimalSeparator"] = ",";
        $chart["thousandSeparator"] = ".";
        $chart["inDecimalSeparator"] = ",";
        $chart["inThousandSeparator"] = ".";
        $chart["decimals"] = "2";

        $chart["exportenabled"] = "1";
        $chart["exportatclient"] = "0";
        $chart["exportFormats"] = "PNG= Exportar como PNG|PDF= Exportar como PDF";
        $chart["exportFileName"] = "Grafico Resultados ";
//        $chart["exporthandler"] = "http://107.21.74.91/";
//        $chart["html5exporthandler"] = "http://107.21.74.91/";
        //$chart["legendItemFontSize"] = "15";


        $rs = array();
        $categoriesGraphic = array();
        $valuesReal = array();
        $valuesPlan = array();
        $percentaje = array();
        $lastReal = 0;
        $lastPlan = 0;
        $lastCategory = "";

        $arrayCategories = array();
        $arrayPlan = array();
        $arrayReal = array();

        if (!$range["range"]) {
            foreach ($productReport as $product) {
                if ($product->getProduct()->getIsCheckToReportProduction()) {
                    $typeVar = $product->$methodFrecuency($dateReport, $typeReport);
                    array_push($arrayCategories, $product->getProduct()->getName());
                    array_push($arrayPlan, $typeVar[$plan]);
                    array_push($arrayReal, $typeVar[$real]);
                }
            }
        } else {
            $dateStart = $range["dateFrom"]->format("U");
            $dateEnd = $range["dateEnd"]->format("U");

            $dayUnixTime = 86400;
            $cantDias = ($dateEnd - $dateStart) / $dayUnixTime;


            foreach ($productReport as $product) {

                if ($product->getProduct()->getIsCheckToReportProduction()) {
                    $sumPlan = 0;
                    $sumReal = 0;

                    for ($d = 0; $d <= $cantDias; $d++) {
                        $date = $dateStart + ($d * $dayUnixTime);
                        $dateReport = new \DateTime(date("Y-m-d", $date));
                        $typeVar = $product->$methodFrecuency($dateReport, $typeReport);
                        $sumPlan += $typeVar[$plan];
                        $sumReal += $typeVar[$real];
                    }
                    //var_dump($product->getName() . "=>" . $sumPlan);

                    array_push($arrayCategories, $product->getProduct()->getName());
                    array_push($arrayPlan, $sumPlan);
                    array_push($arrayReal, $sumReal);
                }
            }
        }


        $cont = 0;
        $desplazamiento = 0;
        foreach (array_unique($arrayCategories) as $categories) {
            $categoriesGraphic[] = array("label" => $categories);
            $rep = array_keys($arrayCategories, $categories);

            if (count($rep) > 1) {

                if (count($rep) > $desplazamiento) {
                    $desplazamiento = $desplazamiento + count($rep) - 1;
                }

                $totalPlan = 0;
                $totalReal = 0;
                $totalPerc = 0;

                foreach ($rep as $r) {
                    $totalPlan = $totalPlan + $arrayPlan[$r];
                    $totalReal = $totalReal + $arrayReal[$r];
                }

                if ($arrayPlan[$r] > 0) {
                    $totalPerc = ($totalReal * 100) / $totalPlan;
                }

                $percentaje[] = array("value" => number_format($totalPerc, 2, ',', '.'));
                $valuesReal[] = array("value" => number_format($totalReal / $division, 2, ',', '.'));
                $valuesPlan[] = array("value" => number_format($totalPlan / $division, 2, ',', '.'));
            } else {
                $valuesReal[] = array("value" => number_format($arrayReal[$cont + $desplazamiento] / $division, 2, ',', '.'));
                $valuesPlan[] = array("value" => number_format($arrayPlan[$cont + $desplazamiento] / $division, 2, ',', '.'));
                $perc = 0;

                if ($arrayPlan[$cont + $desplazamiento] > 0) {
                    $perc = ($arrayReal[$cont + $desplazamiento] * 100) / $arrayPlan[$cont + $desplazamiento];
                }

                $percentaje[] = array("value" => number_format($perc, 2, ',', '.'));
            }
            //    var_dump($cont."-".$desplazamiento);
            //var_dump($cont + $desplazamiento);
            $cont++;
        }
//       var_dump($arrayReal);
//       die();



        $data["dataSource"]["chart"] = $chart;
        $data["dataSource"]["categories"][]["category"] = $categoriesGraphic;
        $data["dataSource"]["dataset"][] = array(
            "seriesname" => "Plan",
            "data" => $valuesPlan
        );
        $data["dataSource"]["dataset"][] = array(
            "seriesname" => "Real",
            "data" => $valuesReal
        );
        $data["dataSource"]["dataset"][] = array(
            "seriesname" => "Porcentaje",
            "renderAs" => "line",
            "parentYAxis" => "S",
            "showValues" => "0",
            "data" => $percentaje
        );
        //var_dump(json_encode($data["dataSource"]["dataset"]));

        return json_encode($data);
    }

    public function generateColumn3dLineryPerRange($titles, $production, $range, $division = 1,$group=false) {
        $data = array(
            'dataSource' => array(
                'chart' => array(),
                'categories' => array(),
                'dataset' => array(),
            ),
        );

        $chart = array();
        if ($range["range"]) {
            $chart["caption"] = "Producción desde " . $range["dateFrom"]->format("d-m-Y") . " hasta " . $range["dateEnd"]->format("d-m-Y");
        } else {
            $chart["caption"] = $titles["caption"];
        }
        $chart["subCaption"] = $titles["subCaption"];
        //        $chart["xAxisName"] = "Indicador";
        if ($division == 1) {
            $chart["pYAxisName"] = "Cantidad (TM)";
        } else if ($division == 1000) {
            $chart["pYAxisName"] = "Cantidad (MTM)";
        }
        $chart["sYAxisName"] = "% Ejecucion";
        $chart["sNumberSuffix"] = "%";
        $chart["sYAxisMaxValue"] = "100";
        $chart["paletteColors"] = "#0075c2,#1aaf5d,#f2c500";
        $chart["bgColor"] = "#ffffff";
        $chart["showBorder"] = "0";
        $chart["showCanvasBorder"] = "0";
        $chart["usePlotGradientColor"] = "0";
        $chart["plotBorderAlpha"] = "10";
        $chart["legendBorderAlpha"] = "0";
        $chart["legendBgAlpha"] = "0";
        $chart["legendShadow"] = "0";
        $chart["showHoverEffect"] = "1";
        $chart["valueFontColor"] = "#000000";
        $chart["valuePosition"] = "ABOVE";
        $chart["rotateValues"] = "1";
        $chart["placeValuesInside"] = "0";
        $chart["divlineColor"] = "#999999";
        $chart["divLineDashed"] = "1";
        $chart["divLineDashLen"] = "1";
        $chart["divLineGapLen"] = "1";
        $chart["canvasBgColor"] = "#ffffff";
        $chart["captionFontSize"] = "14";
        $chart["subcaptionFontSize"] = "14";
        $chart["subcaptionFontBold"] = "0";
        $chart["decimalSeparator"] = ",";
        $chart["thousandSeparator"] = ".";
        $chart["inDecimalSeparator"] = ",";
        $chart["inThousandSeparator"] = ".";
        $chart["decimals"] = "2";

        $chart["exportenabled"] = "1";
        $chart["exportatclient"] = "0";
        $chart["exportFormats"] = "PNG= Exportar como PNG|PDF= Exportar como PDF";
        $chart["exportFileName"] = "Grafico Resultados ";
        $chart["exporthandler"] = "http://107.21.74.91/";

        $categoriesGraphic = $valuesPlan = $valuesReal = $percentaje = array();

        foreach ($production as $prod) {
            if(!$group) { 
                $categoriesGraphic[] = array("label" => $prod["productName"]);
                $valuesReal[] = array("value" => number_format($prod["real"], 2, ',', '.'));
                $valuesPlan[] = array("value" => number_format($prod["plan"], 2, ',', '.'));
                $percentaje[] = array("value" => number_format($prod["percentage"], 2, ',', '.'));
            } else {
                $categoriesGraphic[] = array("label" => $prod["nameGroup"]);
                $valuesReal[] = array("value" => $prod["real"]);
                $valuesPlan[] = array("value" =>$prod["plan"]);
                $percentaje[] = array("value" => "0.0");
            }
        }


        $data["dataSource"]["chart"] = $chart;
        $data["dataSource"]["categories"][]["category"] = $categoriesGraphic;
        $data["dataSource"]["dataset"][] = array(
            "seriesname" => "Plan",
            "data" => $valuesPlan
        );
        $data["dataSource"]["dataset"][] = array(
            "seriesname" => "Real",
            "data" => $valuesReal
        );
        $data["dataSource"]["dataset"][] = array(
            "seriesname" => "Porcentaje",
            "renderAs" => "line",
            "parentYAxis" => "S",
            "showValues" => "0",
            "data" => $percentaje
        );
        //var_dump(json_encode($data["dataSource"]["dataset"]));

        return json_encode($data);
    }


    /**
    * retorna el datetime por mes mes
    */
    public function getTimeNowMonth($month,$unrealizedProduction) {
        $dayMonth = $unrealizedProduction->getDaysPerMonth($month,"2016");
        //$s = "31/01/2016 00:00:00";
        $s = $dayMonth.'-'.$month.'-'.date("Y");
        //var_dump($s);
        $fecha = \DateTime::createFromFormat('d-m-Y', $s);
        #$fecha = DateTime::createFromFormat('j-M-Y', '15-Feb-2009');
        #echo $fecha->format('Y-m-d');
        #var_dump($fecha);
        return $fecha;

        
    }

    /**
     * Shortcut to return the Doctrine Registry service.
     *
     * @return Registry
     *
     * @throws LogicException If DoctrineBundle is not available
     */
    public function getDoctrine() {
        if (!$this->container->has('doctrine')) {
            throw new LogicException('The DoctrineBundle is not registered in your application.');
        }

        return $this->container->get('doctrine');
    }

    protected function getCauseFailService() {
        return $this->container->get('seip.service.causefail');
    }

}
