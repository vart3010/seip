<?php

namespace Pequiven\SEIPBundle\Service;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class productReportService implements ContainerAwareInterface {

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

        return $pie;
    }

    public function generateColumn3dLinery($titles, $productReport, $dateReport, $typeReport, $methodFrecuency, $plan, $real) {
        $data = array(
            'dataSource' => array(
                'chart' => array(),
                'categories' => array(),
                'dataset' => array(),
            ),
        );

        $chart = array();

        $chart["caption"] = $titles["caption"];
        $chart["subCaption"] = $titles["subCaption"];
        //        $chart["xAxisName"] = "Indicador";
        $chart["yAxisName"] = "TM";
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
        //$chart["legendItemFontSize"] = "15";
        

        $rs = array();
        $categories = array();
        $valuesReal = array();
        $valuesPlan = array();
        $percentaje = array();



        foreach ($productReport as $product) {
            if ($product->getProduct()->getIsCheckToReportProduction()) {
                $typeVar = $product->$methodFrecuency($dateReport, $typeReport);
                //$rs[$product->getProduct()->getName()] = $typeVar["plan"+$var];

                $categories[] = array("label" => $product->getProduct()->getName());
                $valuesReal[] = array("value" => number_format($typeVar[$real] / 1000, 2, ',', '.'));
                $valuesPlan[] = array("value" => number_format($typeVar[$plan] / 1000, 2, ',', '.'));
                $perc = 0;
                if ($typeVar[$plan] > 0) {
                    $perc = ($typeVar[$real] * 100) / $typeVar[$plan];
                }
                $percentaje[] = array("value" => number_format($perc, 2, ',', '.'));
            }
        }


        $data["dataSource"]["chart"] = $chart;
        $data["dataSource"]["categories"][]["category"] = $categories;
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

}
