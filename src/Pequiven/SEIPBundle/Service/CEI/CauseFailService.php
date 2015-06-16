<?php

namespace Pequiven\SEIPBundle\Service\CEI;

use Doctrine\Bundle\DoctrineBundle\Registry;
use ErrorException;
use Exception;
use LogicException;
use Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProduction;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Servicios para el indicador
 * 
 * service seip.service.causefail
 */
class CauseFailService implements ContainerAwareInterface {

    private $container;

    /**
     * Metodo general para instanciar el la consulta de fallas por tipo
     * 
     * @param type $type
     * @return type
     */
    public function getFails($type) {
        $em = $this->container->get('doctrine')->getManager();
        $fails = $em->getRepository('PequivenSEIPBundle:CEI\Fail')->findQueryByTypeResult($type);
        return $fails;
    }

    /**
     * Function usada para armar las listas de PNR interna y externa, devuelve un vector con la cantidad de paradas 
     * de cada categoria por dia del mes
     * 
     * @param UnrealizedProduction $unrealizedProduction
     * @param type $options
     * @return string
     */
    public function getCauseFail(UnrealizedProduction $unrealizedProduction, $options = array()) {
        $reflection = new \ReflectionClass($unrealizedProduction);
        $methods = $reflection->getMethods();





        if ($options["paramDay"] != "") {
            $Match = "getDay" . $options["paramDay"] . "Details";
            $nameMatch = "/^" . $Match . "+$/";
        } else {
            $nameMatch = '/^getDay\d+Details+$/';
        }

        if ($options["typeCause"] == "InternalCauses") {
            $methodGetType = "getInternalCauses";
            $typeFail = \Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL;
        } else if ($options["typeCause"] == "ExternalCauses") {
            $methodGetType = "getExternalCauses";
            $typeFail = \Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL;
        }


        $totalFails = count($this->getFails($typeFail));


        $cont = 0;
        $mounts = array();
        $days = $unrealizedProduction->getDaysPerMonth($unrealizedProduction->getMonth());

        foreach ($methods as $m) {

            $methodName = $m->getName();

            if (preg_match($nameMatch, $methodName)) {
                $metodsDetails = $unrealizedProduction->$methodName();

                if ($metodsDetails != "") {
                    $contFails = 0;
                    foreach ($metodsDetails->$methodGetType() as $md) {
                        array_push($mounts, $md->getMount());
                        $contFails++;
                    }
                    if ($totalFails != $contFails) {
                        for ($x = $contFails; $x < $totalFails; $x++) {
                            $mounts[$x] = "0";
                        }
                    }
                } else {
                    for ($i = 0; $i < $totalFails; $i++) {
                        array_push($mounts, "0");
                    }
                }
                $cont++;
                if ($cont == $days) {
                    break;
                }
            }
        }
        return $mounts;
    }

    /**
     * Metodo que devuleve el total de Paradas por categorias de fallas
     * 
     * @param UnrealizedProduction $unrealizedProduction
     * @param type $options
     * @return type
     */
    public function getTotalsCategoriesFails(UnrealizedProduction $unrealizedProduction, $options = array()) {
        $daysMonth = $unrealizedProduction->getDaysPerMonth($unrealizedProduction->getMonth());



        if ($options["typeCause"] == "InternalCauses") {
            $typeFail = \Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL;
        } else if ($options["typeCause"] == "ExternalCauses") {
            $typeFail = \Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL;
        }

        $totalFails = count($this->getFails($typeFail));

        $total = 0;
        $results = array();
        for ($j = 0; $j < $totalFails; $j++) {
            $results[$j] = 0;
        }
        for ($i = 0; $i < $daysMonth; $i++) {
            $arr = array();
            $arr["paramDay"] = $i;
            $arr["typeCause"] = $options["typeCause"];
            $totalsFails = $this->getCauseFail($unrealizedProduction, $arr);

            for ($j = 0; $j < $totalFails; $j++) {
                $results[$j] = $results[$j] + $totalsFails[$j];
            }
        }

//        $totalsFails = $this->getCauseFail($unrealizedProduction, $arr);
//        $total = $total + $totalsFails[0];

        return $results;
    }

    public function getCategoriesFails() {

        $em = $this->getDoctrine()->getManager();

        $fails = array();
        $failsNames = array();
        $cont = 0;

        $fails[0] = $em->getRepository('PequivenSEIPBundle:CEI\Fail')->findQueryByTypeResult(\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL);
        $fails[1] = $em->getRepository('PequivenSEIPBundle:CEI\Fail')->findQueryByTypeResult(\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL);


        foreach ($fails as $fail) {
            $rs = array();
            foreach ($fail as $f) {
                array_push($rs, $f->getname());
            }
            array_push($failsNames, $rs);
            $cont++;
        }

        return $failsNames;
    }

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    public function generatePieTotals(UnrealizedProduction $unrealizedProduction, $options = array()) {

        $chart = array();

        $chart["caption"] = "PNR Total";

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
        $chart["legendItemFontSize"] = "12";
        $chart["legendItemFontColor"] = "#666666";





        $causeFailService = $options["causeFailService"];
        $total = 0;
        $char = array();
        for ($x = 0; $x < count($options["fails"]); $x++) {
            if ($x == 0) {
                $type = "InternalCauses";
            } else if ($x == 1) {
                $type = "ExternalCauses";
            }
            $totalCatValues = $causeFailService->getTotalsCategoriesFails($unrealizedProduction, array("typeCause" => $type));

            $finalValues = array();
            $c = 0;

            foreach ($options["failNames"][$x] as $cat) {

//                $tp["label"] = \Pequiven\SEIPBundle\Service\ToolService::truncate($cat,array("limit"=>"7"));
//                $tp["value"] = $totalCatValues[$c];
//                $tp["displayValue"] = $totalCatValues[$c];

                $tp["label"] = $cat." (".$totalCatValues[$c].")";
                $tp["value"] = $totalCatValues[$c];
                $tp["toolText"] = $cat." (".$totalCatValues[$c].")";;
                $tp["displayValue"] = \Pequiven\SEIPBundle\Service\ToolService::truncate($cat,array("limit"=>"10"));

                $total = $total + $totalCatValues[$c];
                $c++;
                array_push($finalValues, $tp);
            }
            $char[$x] = $finalValues;
        }

        $chart["subcaption"] = number_format($total, 2, ',', '.');


        $pie[0] = array(
            'dataSource' => array(
                'chart' => $chart,
                'data' => $char[0],
            ),
        );

        $pie[1] = array(
            'dataSource' => array(
                'chart' => $chart,
                'data' => $char[1],
            ),
        );

        return $pie;
    }

    /**
     * Shortcut to return the Doctrine Registry service.
     *
     * @return \Doctrine\Bundle\DoctrineBundle\Registry
     *
     * @throws LogicException If DoctrineBundle is not available
     */
    public function getDoctrine() {
        if (!$this->container->has('doctrine')) {
            throw new LogicException('The DoctrineBundle is not registered in your application.');
        }

        return $this->container->get('doctrine');
    }

}
