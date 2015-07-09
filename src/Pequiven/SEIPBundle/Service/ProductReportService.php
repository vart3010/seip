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
    public function getArray($productReport, $dateReport, $typeReport, $methodFrecuency,$var = "plan") {
        $rs = array();
        foreach ($productReport as $product) {
            //array_push($rs["names"], $product->getProduct()->getname());
            $typeVar = $product->$methodFrecuency($dateReport, $typeReport);
            //array_push($rs["values"],$typeVar[$var]);
            $rs[$product->getProduct()->getname()] = $typeVar[$var];
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

}
