<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com.ve
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Controller\DataLoad\Production;

use Pequiven\SEIPBundle\Controller\SEIPController;

/**
 * Controlador de la NPR
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class UnrealizedProductionController extends SEIPController {

    public function createNew() {
        $entity = parent::createNew();
        $request = $this->getRequest();
        $productReportId = $request->get("productReport");
        if ($productReportId > 0) {
            $em = $this->getDoctrine()->getManager();
            $productReport = $em->getRepository("Pequiven\SEIPBundle\Entity\DataLoad\ProductReport")->find($productReportId);
            $entity->setProductReport($productReport);
        }
        return $entity;
    }

    public function createAction(\Symfony\Component\HttpFoundation\Request $request) {
        $resource = $this->createNew();

        $form = $this->getForm($resource);

        if ($request->isMethod('POST') && $form->submit($request)->isValid()) {
            $resource = $this->domainManager->create($resource);

            $url = $this->generateUrl("pequiven_product_report_show", array(
                "id" => $resource->getProductReport()->getId(),
            ));

            return $this->redirectHandler->redirect($url);
        }

        if ($this->config->isApiRequest()) {
            return $this->handleView($this->view($form));
        }

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('create.html'))
                ->setData(array(
            $this->config->getResourceName() => $resource,
            'form' => $form->createView()
                ))
        ;

        return $this->handleView($view);
    }

    public function updateAction(\Symfony\Component\HttpFoundation\Request $request) {
        $resource = $this->findOr404($request);
        $form = $this->getForm($resource);

        if (($request->isMethod('PUT') || $request->isMethod('POST')) && $form->submit($request)->isValid()) {

            $this->domainManager->update($resource);

            $url = $this->generateUrl("pequiven_product_report_show", array(
                "id" => $resource->getProductReport()->getId(),
            ));

            return $this->redirectHandler->redirect($url);
        }

        if ($this->config->isApiRequest()) {
            return $this->handleView($this->view($form));
        }

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('update.html'))
                ->setData(array(
            $this->config->getResourceName() => $resource,
            'form' => $form->createView()
                ))
        ;

        return $this->handleView($view);
    }

    public function deleteAction(\Symfony\Component\HttpFoundation\Request $request) {
        $resource = $this->findOr404($request);

        $url = $this->generateUrl("pequiven_product_report_show", array(
            "id" => $resource->getProductReport()->getId(),
        ));

        $this->domainManager->delete($resource);
        return $this->redirect($url);
    }

    public function showAction(\Symfony\Component\HttpFoundation\Request $request) {
        $resource = $this->findOr404($request);

        $productReportId = $request->get("productReportId");


        $urealizedService = $this->getUnrealizedProductionService();
        $failsNames = $urealizedService->getCauseValueDay();
        
//        var_dump($resource->getId());die();


        $causeFailService = $this->getCauseFailService();
        $causes = $causeFailService->getFailsCause($resource);
        $mp = $causeFailService->getFailsCauseMp($resource);

        //$datosServices = array("causeFailService" => $causeFailService, "fails" => $causes, "failNames" => $failsNames);
        $datosServicesInternal = array("data" => $causeFailService->getArrayTotals($resource, $causes["TYPE_FAIL_INTERNAL"], $failsNames[0]));
        $datacharInternal = $causeFailService->generatePieTotals($resource, $datosServicesInternal);

        $datosServicesExternal = array("data" => $causeFailService->getArrayTotals($resource, $causes["TYPE_FAIL_EXTERNAL"], $failsNames[1]));
        $datacharExternal = $causeFailService->generatePieTotals($resource, $datosServicesExternal);
        
        $daysOfMonth = $causeFailService->getDaysMonth($resource);
        
        $arrayTotalDays = array();
        $arrayDays = array();
        $arrayDetailDays = array();
        for ($i = 1;$i <= $daysOfMonth; $i++){
            $arrayTotalDays[$i] = 0.0;
            $arrayDays[$i] = 0;
        }
        //SUMAMOS LAS INTERNAS Y EXTERNAS
        for ($i = 1; $i <= $daysOfMonth; $i++){
            $arrayTotalDays[$i] = $arrayTotalDays[$i] + $causes["TYPE_FAIL_INTERNAL"]["total"][$i] + $causes["TYPE_FAIL_EXTERNAL"]["total"][$i];
        }
        //SUMAMOS LAS INTERNAS POR MP
        if(isset($mp["getInternalCausesMp"])){
            for ($i = 1; $i <= $daysOfMonth; $i++){
                $arrayTotalDays[$i] = $arrayTotalDays[$i] + $mp["getInternalCausesMp"]["total"][$i];
            }
        }
        //SUMAMOS LAS EXTERNAS POR MP
        if(isset($mp["getExternalCausesMp"])){
            for ($i = 1; $i <= $daysOfMonth; $i++){
                $arrayTotalDays[$i] = $arrayTotalDays[$i] + $mp["getExternalCausesMp"]["total"][$i];
            }
        }
        
        for ($i = 1; $i <= $daysOfMonth; $i++){
            $nameMethod = 'getDay'.$i;
            $arrayDetailDays[$i] = $resource->{$nameMethod}();
            if($arrayTotalDays[$i] == $resource->{$nameMethod}()){
                $arrayDays[$i] = 1;
            }
        }
//        var_dump($arrayTotalDays[30]);var_dump($resource->getDay30());die();
//        var_dump($arrayDays);die();
        
        $numDaysDifferent = 0;
        for($i = 1; $i<= $daysOfMonth; $i++){
            if($arrayDays[$i] == 0){
                $numDaysDifferent++;
            }
        }

//        $mp = $causeFailService->getFailsCauseMp($resource);
        $datacharInternalMp = $datacharExternalMp = "";
        if (count($mp) > 0) {
            $InternalCategoriesMp = array();
            $ExternalCategoriesMp = array();
            if (isset($mp["getInternalCausesMp"])) {
                foreach ($mp["getInternalCausesMp"] as $key => $values) {
                    if ($key != "total") {
                        array_push($InternalCategoriesMp, $key);
                    }
                }
            }
            if (isset($mp["getInternalCausesMp"])) {
                foreach ($mp["getInternalCausesMp"] as $key => $values) {
                    if ($key != "total") {
                        array_push($ExternalCategoriesMp, $key);
                    }
                }
                $datosServicesInternalMp = array("data" => $causeFailService->getArrayTotals($resource, $mp["getInternalCausesMp"], $InternalCategoriesMp));
                $datacharInternalMp = $causeFailService->generatePieTotals($resource, $datosServicesInternalMp);
            } else {
                $datacharInternalMp = "test";
            }

            if (isset($mp["getExternalCausesMp"])) {
                foreach ($mp["getExternalCausesMp"] as $key => $values) {
                    if ($key != "total") {
                        array_push($ExternalCategoriesMp, $key);
                    }
                }
                $datosServicesExternalMp = array("data" => $causeFailService->getArrayTotals($resource, $mp["getExternalCausesMp"], $ExternalCategoriesMp));
                $datacharExternalMp = $causeFailService->generatePieTotals($resource, $datosServicesExternalMp);
            } else {

                if (isset($mp["getInternalCausesMp"])) {
                    $datosServicesInternalMp = array("data" => $causeFailService->getArrayTotals($resource, $mp["getInternalCausesMp"], $InternalCategoriesMp));
                    $datacharInternalMp = $causeFailService->generatePieTotals($resource, $datosServicesInternalMp);
                }
                if (isset($mp["getExternalCausesMp"])) {
                    $datosServicesInternalMp = array("data" => $causeFailService->getArrayTotals($resource, $mp["getExternalCausesMp"], $ExternalCategoriesMp));
                    $datacharExternalMp = $causeFailService->generatePieTotals($resource, $datosServicesInternalMp);
                }
            }
        }
        
//        var_dump($arrayDays);die();
        
        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('show.html'))
                ->setData(array(
            $this->config->getResourceName() => $resource,
            "internalCauses" => $failsNames[0],
            "externalCauses" => $failsNames[1],
            "causeFailService" => $causeFailService,
            "arrayDays" => $arrayDays,
            "arrayTotalDays" => $arrayTotalDays,
            "arrayDetailDays" => $arrayDetailDays,
            "numDaysDifferent" => $numDaysDifferent,
            "causes" => $causes,
            "mp" => $mp,
            "dataInternal" => json_encode($datacharInternal),
            "dataExternal" => json_encode($datacharExternal),
            "dataInternalMp" => ($datacharInternalMp),
            "dataExternalMp" => ($datacharExternalMp),
            "productReportId" => $productReportId
        ));

        return $this->handleView($view);
    }

    /**
     * 
     * @return \Pequiven\SEIPBundle\Service\CEI\CauseFailService
     */
    protected function getCauseFailService() {
        return $this->container->get('seip.service.causefail');
    }

    protected function getUnrealizedProductionService() {
        return $this->container->get('seip.service.unrealizedProduction');
    }

}
