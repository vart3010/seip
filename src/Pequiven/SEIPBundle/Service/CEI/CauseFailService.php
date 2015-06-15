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

    public function getFails($type) {
        $em = $this->container->get('doctrine')->getManager();
        $fails = $em->getRepository('PequivenSEIPBundle:CEI\Fail')->findQueryByTypeResult($type);
        return $fails;
    }

    /**
     * 
     * @param type $options
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

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

}
