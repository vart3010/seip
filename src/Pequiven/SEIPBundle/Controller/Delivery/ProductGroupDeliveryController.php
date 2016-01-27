<?php

namespace Pequiven\SEIPBundle\Controller\Delivery;

use Pequiven\SEIPBundle\Controller\SEIPController;
use Symfony\Component\HttpFoundation\Request;
use Pequiven\SEIPBundle\Model\Common\CommonObject;
use Pequiven\SEIPBundle\Form\DataLoad\PlantReportType;

/**
 * Reporte de grupo de productos despacho
 *
 * @author Victor Tortolero <vart10.30@gmail.com>
 */
class ProductGroupDeliveryController extends SEIPController {
    
     public function createNew() {
        $entity = parent::createNew();
        $request = $this->getRequest();
        $reportTemplateDeliveryId = $request->get("reportTemplateDelivery");
        if ($reportTemplateDeliveryId > 0) {
            $em = $this->getDoctrine()->getManager();
            $reportTemplateDelivery = $em->find("Pequiven\SEIPBundle\Entity\Delivery\ReportTemplateDelivery", $reportTemplateDeliveryId);
            $entity->init($reportTemplateDelivery);
        }
        return $entity;
    }
    
}
