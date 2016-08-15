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

    public function showAction(Request $request) {
        $productGroupDelivery = $this->getRepository()->find($request->get("id"));
        $products = $productGroupDelivery->getProductsReportDelivery();

        #var_dump($products[0]);die();

        $data = array(
            "product_group_delivery" => $productGroupDelivery,
            "products" => $products[0]
        );

        foreach ($products[0] as $p) {
            var_dump($p);
        }
        die();


        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('show.html'))
                ->setTemplateVar($this->config->getResourceName())
                ->setData($data)
        ;

        return $this->handleView($view);
    }

    public function readExcel() {
        $excelService = $this->getPhpExcelReaderService();

        $fileData = array(
            "file" => "test.xlsx",
            "sheet" => 0,
            "titles" => "A1:C1",
            "data" => "A2:C19"
        );
        $fileData2 = array(
            "file" => "test.xlsx",
            "sheet" => 1,
            "titles" => "A1:C1",
            "data" => "A2:C19"
        );
        $datas = array($fileData, $fileData2);

        $secciones = $excelService->getSheetValues($datas);

        var_dump($secciones[0]["data"]);
        die();
    }

    protected function getPhpExcelReaderService() {
        return $this->get('seip.service.phpexcelreader');
    }

}
