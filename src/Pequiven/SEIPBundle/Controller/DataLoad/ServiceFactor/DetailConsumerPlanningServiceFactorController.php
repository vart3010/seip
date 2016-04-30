<?php

namespace Pequiven\SEIPBundle\Controller\DataLoad\ServiceFactor;

use Pequiven\SEIPBundle\Controller\SEIPController;

/**
 * Controlador de Detalle de consumo de factor de servicio
 *
 * @author Matías Jiménez <matei249@gmail.com>
 */
class DetailConsumerPlanningServiceFactorController extends SEIPController
{
    public function createNew() 
    {
        $entity = parent::createNew();
        $request = $this->getRequest();
        $consumerPlanningServiceFactorId = $request->get("consumerPlanningServiceFactor");
        if($consumerPlanningServiceFactorId > 0){
            $em = $this->getDoctrine()->getManager();
            $consumerPlanningServiceFactor = $em->find("Pequiven\SEIPBundle\Entity\DataLoad\ServiceFactor\ConsumerPlanningServiceFactor", $consumerPlanningServiceFactorId);
            $entity->setConsumerPlanningServiceFactor($consumerPlanningServiceFactor);
        }
        return $entity;
    }
    
    public function createAction(\Symfony\Component\HttpFoundation\Request $request) 
    {
        $resource = $this->createNew();
        $form = $this->getForm($resource);

        if ($request->isMethod('POST') && $form->submit($request)->isValid()) {
            $resource = $this->domainManager->create($resource);

            $url = $this->generateUrl("pequiven_consumer_planning_servicefactor_show",array(
                "id" => $resource->getConsumerPlanningServiceFactor()->getId(),
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

            $url = $this->generateUrl("pequiven_consumer_planning_servicefactor_show",array(
                "id" => $resource->getConsumerPlanningServiceFactor()->getId(),
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
