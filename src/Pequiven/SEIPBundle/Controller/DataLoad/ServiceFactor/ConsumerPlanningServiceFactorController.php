<?php

namespace Pequiven\SEIPBundle\Controller\DataLoad\ServiceFactor;

use Pequiven\SEIPBundle\Controller\SEIPController;

/**
 * Controlador de consumo de factor de servicio
 *
 * @author Matías Jiménez <matei249@gmail.com>
 */
class ConsumerPlanningServiceFactorController extends SEIPController 
{
    public function createNew() {
        $entity = parent::createNew();
        $request = $this->getRequest();
        $plantReportId = $request->get("plantReport");
        if($plantReportId > 0){
            $em = $this->getDoctrine()->getManager();
            $plantReport = $em->find("Pequiven\SEIPBundle\Entity\DataLoad\PlantReport", $plantReportId);
            $entity->setPlantReport($plantReport);
        }
        return $entity;
    }
    
    public function deleteAction(\Symfony\Component\HttpFoundation\Request $request) 
    {
        $resource = $this->findOr404($request);
        
        $url = $this->generateUrl("pequiven_plant_report_show",array(
            "id" => $resource->getPlantReport()->getId(),
        ));
        
        $this->domainManager->delete($resource);
        return $this->redirect($url);
    }
}
