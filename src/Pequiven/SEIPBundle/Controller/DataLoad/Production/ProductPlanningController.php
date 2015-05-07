<?php
/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Controller\DataLoad\Production;

use Pequiven\SEIPBundle\Controller\SEIPController;

/**
 * Controlador de planificacion de productos
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class ProductPlanningController extends SEIPController
{
    public function createAction(\Symfony\Component\HttpFoundation\Request $request) 
    {
        $resource = $this->createNew();
        
        $productReportId = $request->get("productReport");
        $productReport = $this->getDoctrine()->getManager()->find("Pequiven\SEIPBundle\Entity\DataLoad\ProductReport", $productReportId);
        $resource->setProductReport($productReport);
        $resource->setType((int)$request->get("type"));
        
        $form = $this->getForm($resource);

        if ($request->isMethod('POST') && $form->submit($request)->isValid()) {
            $resource = $this->domainManager->create($resource);

            $url = $this->generateUrl("pequiven_product_report_show",array(
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
                'form'                           => $form->createView()
            ))
        ;

        return $this->handleView($view);
    }
    
    public function deleteAction(\Symfony\Component\HttpFoundation\Request $request) 
    {
        $resource = $this->findOr404($request);
        
        $url = $this->generateUrl("pequiven_product_report_show",array(
            "id" => $resource->getProductReport()->getId(),
        ));
        
        $this->domainManager->delete($resource);
        return $this->redirect($url);
    }
}