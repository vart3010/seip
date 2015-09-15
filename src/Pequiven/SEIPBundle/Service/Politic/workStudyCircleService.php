<?php

namespace Pequiven\SEIPBundle\Service\Politic;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class workStudyCircleService implements ContainerAwareInterface {

    private $container;

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    public function generateColumn3d($conf, $datos) {
        $data = array(
            'dataSource' => array(
                'chart' => array(),
                'categories' => array(),
                'dataset' => array(),
            ),
        );


        $chart = array();

        $chart["caption"] = $conf["caption"];
        $chart["subCaption"] = $conf["subCaption"];
        $chart["pYAxisName"] = $conf["ejeyLeft"];
        $chart["sYAxisName"] = "% Inscritos";
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

        $usersTemp = $datos["usersTemp"]; //USUARIOS TOTALES DE PEQUIVEN POR COMPLEJO
        $complejosCant = $datos["complejosCant"]; //CANTIDAD DE CIRCULOS POR COMPLEJO
        $cantNotNull = $datos["cantNotNull"]; //CANTIDAD DE USUARIOS REGISTRADOS EN CIRCULOS
        $complejos = $datos["complejos"];

        $categories = array();
        $meta = $real = array();
        for ($i = 0; $i < count($complejos); $i++) {
            $categories[] = array("label" => $complejos[$i]->getRef());
            
            if ($conf["type"] == "circle") {
                $meta[] = array("value" => number_format(($usersTemp[$i] / 12), '2', ',', '.'));
                $real[] = array("value" => $complejosCant[$i]);
                $perc = (($complejosCant[$i]) * 100) / ($usersTemp[$i] / 12);
                $percentaje[] = array("value" => number_format($perc, 2, ',', '.'));
                
            } else if ($conf["type"] == "user") {
                $meta[] = array("value" => number_format(($usersTemp[$i]), '2', ',', '.'));
                $real[] = array("value" => $cantNotNull[$i]);
                $perc = ($cantNotNull[$i] * 100) / $usersTemp[$i];
                $percentaje[] = array("value" => number_format($perc, 2, ',', '.'));
            }
        }

        $data["dataSource"]["dataset"][] = array(
            "seriesname" => "Real",
            "data" => $real
        );
        $data["dataSource"]["dataset"][] = array(
            "seriesname" => "Meta",
            "data" => $meta
        );

        $data["dataSource"]["dataset"][] = array(
            "seriesname" => "Porcentaje",
            "renderAs" => "line",
            "parentYAxis" => "S",
            "showValues" => "0",
            "data" => $percentaje
        );


        $data["dataSource"]["chart"] = $chart;
        $data["dataSource"]["categories"][]["category"] = $categories;

        return json_encode($data);
    }

}
