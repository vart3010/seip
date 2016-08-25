<?php

namespace Pequiven\SEIPBundle\Controller\DataLoad\GasFlow;

use Pequiven\SEIPBundle\Controller\SEIPController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controlador de consumo de flujo de gas
 *
 * @author Matías Jiménez <matei249@gmail.com>
 */
class ConsumerPlanningGasFlowController extends SEIPController 
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
    
    public function deleteAction(Request $request) 
    {
        $resource = $this->findOr404($request);
        
        $url = $this->generateUrl("pequiven_plant_report_show",array(
            "id" => $resource->getPlantReport()->getId(),
        ));
        
        $this->domainManager->delete($resource);
        return $this->redirect($url);
    }
    
    public function uploadDataGasFlow(Request $request){
        $excelService = $this->getPhpExcelReaderService();
    }
    
    protected function getPhpExcelReaderService() {
        return $this->get('seip.service.phpexcelreader');
    }
}
