<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com.ve
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Controller\DataLoad\Inventory;

use Pequiven\SEIPBundle\Controller\SEIPController;

/**
 * Controlador de inventario de producto
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class InventoryController extends SEIPController
{
    public function createNew() 
    {
        $entity = parent::createNew();
        $request = $this->getRequest();
        $productReportId = $request->get("productReport");
        if($productReportId > 0){
            $em = $this->getDoctrine()->getManager();
            $productReport = $em->getRepository("Pequiven\SEIPBundle\Entity\DataLoad\ProductReport")->find($productReportId);
            $entity->setProductReport($productReport);
        }
        return $entity;
    }
    
    public function createAction(\Symfony\Component\HttpFoundation\Request $request) 
    {
        $resource = $this->createNew();
        
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
    
    public function updateAction(\Symfony\Component\HttpFoundation\Request $request) 
    {
        $resource = $this->findOr404($request);
        $form = $this->getForm($resource);

        if (($request->isMethod('PUT') || $request->isMethod('POST')) && $form->submit($request)->isValid()) {

            $this->domainManager->update($resource);

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
            ->setTemplate($this->config->getTemplate('update.html'))
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
