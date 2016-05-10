<?php

namespace Pequiven\SEIPBundle\Model\Box\UnrealizedProduction;

use Tecnocreaciones\Bundle\BoxBundle\Model\GenericBox;
use Pequiven\MasterBundle\Entity\LineStrategic;
use Pequiven\SEIPBundle\Model\Common\CommonObject;

/**
 * Description of IconsBox
 *
 */
class UnrealizedProductionBox extends GenericBox {

    public function getDescription() {
        return 'Contiene una lista de los indicatores estratégicos en formato de íconos de acuerdo a una Línea Estratégica seleccionada';
    }

    public function getName() {
        return 'pequiven_seip_box_unrealized_production';
    }

    protected function getCauseFailService() {
        return $this->container->get('seip.service.causefail');
    }

    public function getParameters() {
        
        $idUnrealizedProduction = $this->getRequest()->get('id');

        $unrealizedProduction = $this->container->get('pequiven.repository.unrealized_production')->findOneBy(array('deletedAt' => null, 'id' => $idUnrealizedProduction));


        $causeFailService = $this->getCauseFailService();
        $totals = $causeFailService->getTotalsCategoriesFails($unrealizedProduction, array("typeCause" => "InternalCauses"));

        $categories = $causeFailService->getCategoriesFails(); //[0]=>INTERNAL [1]=>EXTERNAL

        $finalValues = array();
        $c=0;
        foreach ($categories[1] as $cat) {
            $tp = array();
            $tp["label"] = $cat;
            $tp["value"] = $totals[$c];
            $c++;
            array_push($finalValues, $tp);
        }

        return array(
            "title" => "PNR",
            "data" => json_encode($finalValues)
        );
    }

    public function getTemplateName() {
        return 'PequivenSEIPBundle:DataLoad:Production/UnrealizedProduction/Box/chartUnrealizedProduction.html.twig';
    }

}
