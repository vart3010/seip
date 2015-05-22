<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com.ve
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Controller\DataLoad\Service;

use Pequiven\SEIPBundle\Controller\SEIPController;

/**
 * Controlador de Detalle de consumo de servicio
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class DetailConsumerPlanningServiceController extends SEIPController
{
    public function createNew() 
    {
        $entity = parent::createNew();
        $request = $this->getRequest();
        $consumerPlanningServiceId = $request->get("consumerPlanningService");
        if($consumerPlanningServiceId > 0){
            $em = $this->getDoctrine()->getManager();
            $consumerPlanningService = $em->find("Pequiven\SEIPBundle\Entity\DataLoad\Service\ConsumerPlanningService", $consumerPlanningServiceId);
            $entity->setConsumerPlanningService($consumerPlanningService);
        }
        return $entity;
    }
    
    public function createAction(\Symfony\Component\HttpFoundation\Request $request) 
    {
        $resource = $this->createNew();
        $form = $this->getForm($resource);

        if ($request->isMethod('POST') && $form->submit($request)->isValid()) {
            $resource = $this->domainManager->create($resource);

            $url = $this->generateUrl("pequiven_consumer_planning_service_show",array(
                "id" => $resource->getConsumerPlanningService()->getId(),
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

            $url = $this->generateUrl("pequiven_consumer_planning_service_show",array(
                "id" => $resource->getConsumerPlanningService()->getId(),
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
}
