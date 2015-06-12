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
     * 
     * @param type $options
     */
    public function getCauseFail(UnrealizedProduction $unrealizedProduction, $options = array()) {
        $reflection = new \ReflectionClass($unrealizedProduction);
        $methods = $reflection->getMethods();
        
        $em = $this->container->get('doctrine')->getManager();
        $fails = $em->getRepository('PequivenSEIPBundle:CEI\Fail')->findQueryByTypeResult(\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL);
        $totalFails = count($fails);
        
        
        if ($options["paramDay"] != "") {
            $Match = "getDay" . $options["paramDay"] . "Details";
            $nameMatch = "/^" . $Match . "+$/";
        } else {
            $nameMatch = '/^getDay\d+Details+$/';
        }

        if ($options["typeCause"] == "InternalCauses") {
            $methodGetType = "getInternalCauses";
        } else if ($options["typeCause"] == "ExternalCauses") {
            $methodGetType = "getExternalCauses";
        }
        
        $cont = 0;
        $mounts = array();
        $days = $unrealizedProduction->getDaysPerMonth($unrealizedProduction->getMonth());

        foreach ($methods as $m) {

            $methodName = $m->getName();

            if (preg_match($nameMatch, $methodName)) {

                $metodsDetails = $unrealizedProduction->$methodName();
                if ($metodsDetails != "") {
                    foreach ($metodsDetails->$methodGetType() as $md) {
                        array_push($mounts, $md->getMount());
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

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

}
