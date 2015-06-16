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

        $causeFailService = $this->getCauseFailService();

        $datosServices = array("causeFailService" => $causeFailService, "fails" => $fails, "failNames" => $failsNames);
        $datachar = $causeFailService->generatePieTotals($resource, $datosServices);

        


        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('show.html'))
                ->setData(array(
            $this->config->getResourceName() => $resource,
            "internalCauses" => $failsNames[0],
            "externalCauses" => $failsNames[1],
            "causeFailService" => $causeFailService,
            "dataInternal" => json_encode($datachar[0]), //DATOS[0] => INTERNAS DATOS[1]=>EXTERNAS
            "dataExternal" => json_encode($datachar[1]) //DATOS[0] => INTERNAS DATOS[1]=>EXTERNAS
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
    

}
