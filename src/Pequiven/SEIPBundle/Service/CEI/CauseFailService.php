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

//    public function getFailsMp() {
//        $em = $this->container->get('doctrine')->getManager();
//        $fails = $em->getRepository('PequivenSEIPBundle:DataLoad\Production\UnrealizedProductionDay')->findQueryByType();
//        return $fails;
//    }

    public function getDaysMonth(UnrealizedProduction $unrealizedProduction) {
        return $unrealizedProduction->getDaysPerMonth($unrealizedProduction->getMonth());
    }

    public function getArrayTotalsMp(UnrealizedProduction $unrealizedProduction, $mp, $type) {
        $days = $this->getDaysMonth($unrealizedProduction);

        $totals = array();

        //var_dump($mp[$type]["total"]);
        $total = 0;
        foreach ($mp[$type] as $key => $product) {

            if ($key == "total") {
                
                for ($d = 1; $d < $days; $d++) {
                    $total = $total + $product[$d];
                }
            } else {
                $sumaCat = 0;
                for ($d = 1; $d < $days; $d++) {
                    $sumaCat = $sumaCat + $product[$d];
                }
                array_push($totals, $sumaCat);
            }
        }
        array_push($totals, $total);
        //var_dump($totals);
        return $totals;
    }

    public function getArrayTotals(UnrealizedProduction $unrealizedProduction, $arrayCauses, $categories) {
        $days = $this->getDaysMonth($unrealizedProduction);
        $totals = array();


        foreach ($categories as $cat) {
            $total_cat = 0;
            $cant_total = 0;
            for ($d = 1; $d <= $days; $d++) {
                $total_cat = $total_cat + $arrayCauses[$cat][$d];
                $cant_total = $cant_total + $arrayCauses['total'][$d];
            }
            //array_push($totals, $total_cat);
            $totals[$cat] = $total_cat;
        }
        $totals['total'] = $cant_total;

        return $totals;
    }

    public function getFailsCauseMp(UnrealizedProduction $unrealizedProduction) {
        $reflection = new \ReflectionClass($unrealizedProduction);
        $methods = $reflection->getMethods();
        $nameMatch = '/^getDay\d+Details+$/';

        $daysMonth = $this->getDaysMonth($unrealizedProduction);

        $methodTypeCauses = array(
            "getInternalCausesMp",
            "getExternalCausesMp"
        );

        //Obtenemos la materia prima por la cual no se realizo la producciòn
        $productsInternalMp = array();
        $productsExternalMp = array();
        $cont = 0;
        foreach ($methods as $m) {

            $methodName = $m->getName();
            if (preg_match($nameMatch, $methodName)) {    //filtra los metodos getDayXXDetails
                $unrealizedProductionDay = $unrealizedProduction->$methodName();
//                var_dump($methodName);

                if ($unrealizedProductionDay != "") {
                    foreach ($methodTypeCauses as $key) { //RECORRE EL ARRAY DE CAUSAS
//                        var_dump($key);
                        foreach ($unrealizedProductionDay->$key() as $fails) {
                            if ($key == "getInternalCausesMp") {
                                if (!array_key_exists($fails->getRawMaterial()->getName(), $productsInternalMp)) {
                                    $productsInternalMp[$fails->getRawMaterial()->getName()] = $fails->getRawMaterial();
                                }
                            }
                            if ($key == "getExternalCausesMp") {
                                if (!array_key_exists($fails->getRawMaterial()->getName(), $productsExternalMp)) {
                                    $productsExternalMp[$fails->getRawMaterial()->getName()] = $fails->getRawMaterial();
                                }
                            }

//                            var_dump($fails->getRawMaterial()->getName());
//                            $mp[$key][$fails->getRawMaterial()->getName()][$cont] = 0;
                        }
                    }
                }
                $cont++;
            }
        }
        //var_dump($productsExternalMp);
        $mp = array();

        foreach ($productsInternalMp as $InternalMp) {
            for ($x = 1; $x <= $daysMonth; $x++) {
                $mp["getInternalCausesMp"][$InternalMp->getName()][$x] = 0.0;
                $mp["getInternalCausesMp"]["total"][$x] = 0.0;
            }
        }

        foreach ($productsExternalMp as $ExternaMp) {
            for ($x = 1; $x <= $daysMonth; $x++) {
                $mp["getExternalCausesMp"][$ExternaMp->getName()][$x] = 0.0;
                $mp["getExternalCausesMp"]["total"][$x] = 0.0;
            }
        }

        //var_dump($productsInternalMp);
        //Obtenemos nuestra matriz [tipo_pnr_mp][producto][dia]
        $cont = 0;
        foreach ($methods as $m) {

            $methodName = $m->getName();
            if (preg_match($nameMatch, $methodName)) {    //filtra los metodos getDayXXDetails
                $unrealizedProductionDay = $unrealizedProduction->$methodName();
                //var_dump($methodName);

                if ($unrealizedProductionDay != "") {
                    foreach ($methodTypeCauses as $key) { //RECORRE EL ARRAY DE CAUSAS
                        //var_dump($key);
                        foreach ($unrealizedProductionDay->$key() as $fails) {
                            //var_dump($fails->getRawMaterial()->getName());
                            $mp[$key][$fails->getRawMaterial()->getName()][$cont] = $fails->getMount();
                            $mp[$key]["total"][$cont] = $mp[$key]["total"][$cont] + $fails->getMount();
                        }
                    }
                }
                $cont++;
            }
        }
        //var_dump($mp["getInternalCausesMp"]);
        
        return $mp;
    }

    public function getFailsCause(UnrealizedProduction $unrealizedProduction) {
        //OBTIENE METODOS DE UNREALIZED_PRODUCTION
        $reflection = new \ReflectionClass($unrealizedProduction);
        $methods = $reflection->getMethods();

        $nameMatch = '/^getDay\d+Details+$/';

        $regs = array();

        $categoriesInternal = $this->getFails(\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL);
        $categoriesExternal = $this->getFails(\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL);

        $causes_array = array(
            "getInternalCauses" => count($categoriesInternal),
            "getExternalCauses" => count($categoriesExternal)
//            "getInternalCausesMp",
//            "getExternalCausesMp"
        );

        $causes = array(
            \Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL => 'TYPE_FAIL_INTERNAL',
            \Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL => 'TYPE_FAIL_EXTERNAL',
        );

        $daysMonth = $this->getDaysMonth($unrealizedProduction);
        //Internas
        foreach ($categoriesInternal as $categorieInternal) {
            for ($day = 1; $day <= $daysMonth; $day++) {
                $regs[$causes[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]][$categorieInternal->getName()][$day] = 0.0;
                $regs[$causes[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]]['total'][$day] = 0.0;
            }
        }
        //Externas
        foreach ($categoriesExternal as $categorieExternal) {
            for ($day = 1; $day <= $daysMonth; $day++) {
                $regs[$causes[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL]][$categorieExternal->getName()][$day] = 0.0;
                $regs[$causes[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL]]['total'][$day] = 0.0;
            }
        }

        //Rellenar el vector de las internas y externas por defecto $array[]
        //$causes_array_rs = array();
        $cont = 1;

        //RECORRE LOS METODOS DE UNREALIZED_PRODUCTION
        foreach ($methods as $m) {

            $methodName = $m->getName();
            if (preg_match($nameMatch, $methodName)) {    //filtra los metodos getDayXXDetails
                $unrealizedProductionDay = $unrealizedProduction->$methodName();
                //var_dump($methodName);

                if ($unrealizedProductionDay != "") {
                    foreach ($causes_array as $key => $cantidad) { //RECORRE EL ARRAY DE CAUSAS
                        //var_dump($key);
                        foreach ($unrealizedProductionDay->$key() as $fails) {
                            //var_dump($fails->getMount());
                            if ($key == 'getInternalCauses') {
                                $regs[$causes[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]][$fails->getFail()->getName()][$cont] = $fails->getMount();
                                $regs[$causes[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]]['total'][$cont] = $regs[$causes[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]]['total'][$cont] + $fails->getMount();
                            } else if ($key == 'getExternalCauses') {
                                $regs[$causes[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL]][$fails->getFail()->getName()][$cont] = $fails->getMount();
                                $regs[$causes[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL]]['total'][$cont] = $regs[$causes[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL]]['total'][$cont] + $fails->getMount();
                            }
                        }
                    }
                }

                //var_dump($regs);
                //array_push($causes_array_rs, $regs);
                $cont++;
            }
        }
        //var_dump($causes_array_rs);
//        var_dump($regs);
//        die();
        return $regs;
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
            $methodGetMp = "getInternalCausesMp";
            $typeFail = \Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL;
        } else if ($options["typeCause"] == "ExternalCauses") {
            $methodGetType = "getExternalCauses";
            $methodGetMp = "getExternalCausesMp";
            $typeFail = \Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_EXTERNAL;
        }


        $totalFails = count($this->getFails($typeFail));

//        $totalFailsMp = count($this->getFailsMp());
//        
//        var_dump($totalFailsMp);
//        die();

        $cont = 0;
        $mounts = array();
        $days = $unrealizedProduction->getDaysPerMonth($unrealizedProduction->getMonth());
        //$mpc = 0;
        foreach ($methods as $m) {

            $methodName = $m->getName();

            if (preg_match($nameMatch, $methodName)) {
                $metodsDetails = $unrealizedProduction->$methodName();

                if ($metodsDetails != "") {

                    $contFails = 0;
                    foreach ($metodsDetails->$methodGetType() as $md) { //CAUSAS INTO EXT
                        array_push($mounts, $md->getMount());
                        $contFails++;
                    }

                    //CAUSAS POR MP, FALTA AGREGARLO
//                    foreach ($metodsDetails->$methodGetMp() as $causesMp) { //CAUSAS POR MATERIA PRIMA INT EXT
//                        array_push($mounts, $causesMp->getMount());
//                        //$mpc++;
//                        $contFails++;
//                    }

                    if ($totalFails != $contFails) {
                        for ($x = $contFails; $x < $totalFails; $x++) {
                            $mounts[$x] = "0";
                        }
                    }
                } else {
                    for ($i = 0; $i < ($totalFails); $i++) {
                        array_push($mounts, "0");
                    }
                    //array_push($mounts, "0");
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


        $data = $options["data"];
        $totalPnr = $data["total"];
        unset($data["total"]);
        $rs = array();
        foreach ($data as $key => $value) {
            array_push($rs, array(
                "label" => $key . " (" . $value . ")",
                "value" => $value,
                "toolText" => $key . " (" . $value . ")",
                "displayValue" => \Pequiven\SEIPBundle\Service\ToolService::truncate($key, array("limit" => "7"))
            ));
        }

//
//        $causeFailService = $options["causeFailService"];
//        $total = 0;
//        $char = array();
//        for ($x = 0; $x < count($options["fails"]); $x++) {
//            if ($x == 0) {
//                $type = "InternalCauses";
//            } else if ($x == 1) {
//                $type = "ExternalCauses";
//            }
//            $totalCatValues = $causeFailService->getTotalsCategoriesFails($unrealizedProduction, array("typeCause" => $type));
//
//            $finalValues = array();
//            $c = 0;
//
//            foreach ($options["failNames"][$x] as $cat) {
//
////                $tp["label"] = \Pequiven\SEIPBundle\Service\ToolService::truncate($cat,array("limit"=>"7"));
////                $tp["value"] = $totalCatValues[$c];
////                $tp["displayValue"] = $totalCatValues[$c];
//
//                $tp["label"] = $cat . " (" . $totalCatValues[$c] . ")";
//                $tp["value"] = $totalCatValues[$c];
//                $tp["toolText"] = $cat . " (" . $totalCatValues[$c] . ")";
//                ;
//                $tp["displayValue"] = \Pequiven\SEIPBundle\Service\ToolService::truncate($cat, array("limit" => "10"));
//
//                $total = $total + $totalCatValues[$c];
//                $c++;
//                array_push($finalValues, $tp);
//            }
//            $char[$x] = $finalValues;
//        }
        $chart["subcaption"] = number_format($totalPnr, 2, ',', '.');


//        $pie[0] = array(
//            'dataSource' => array(
//                'chart' => $chart,
//                'data' => $char[0],
//            ),
//        );

        $pie = array(
            'dataSource' => array(
                'chart' => $chart,
                'data' => $rs
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
