<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com.ve
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Controller\DataLoad\Plant;

use Pequiven\SEIPBundle\Controller\SEIPController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controlador de la planificacion de paradas de la planta
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class PlantStopPlanningController extends SEIPController 
{
    public function createAction(Request $request) 
    {
        $resource = $this->createNew();
        $form = $this->getForm($resource);

        if ($request->isMethod('POST') && $form->submit($request)->isValid()) {
            $resource = $this->domainManager->create($resource);

            $url = $this->generateUrl("pequiven_plant_report_show",array(
                "id" => $resource->getPlantReport()->getId(),
            ));
            return $this->redirect($url);
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
    
    public function updateAction(Request $request) 
    {
        $resource = $this->findOr404($request);
        
        $originalDaysStops = new \Doctrine\Common\Collections\ArrayCollection();
        // Create an ArrayCollection of the current Tag objects in the database
        foreach ($resource->getDayStops() as $daysStop) {
            $originalDaysStops->add($daysStop);
        }
        $form = $this->getForm($resource);
        $form->handleRequest($request);
        if (($request->isMethod('PUT') || $request->isMethod('POST')) && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            foreach ($originalDaysStops as $daysStop) {
                if(false === $resource->getDayStops()->contains($daysStop)){
                    $resource->getDayStops()->removeElement($daysStop);
                    $em->remove($daysStop);
                }
            }
            
            $this->domainManager->update($resource);

            return $this->redirectHandler->redirectTo($resource);
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
    
    public function deleteAction(Request $request) 
    {
        $resource = $this->findOr404($request);
        
        $url = $this->generateUrl("pequiven_plant_report_show",array(
            "id" => $resource->getPlantReport()->getId(),
        ));
        
        $this->domainManager->delete($resource);
        return $this->redirect($url);
    }
    
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
}
