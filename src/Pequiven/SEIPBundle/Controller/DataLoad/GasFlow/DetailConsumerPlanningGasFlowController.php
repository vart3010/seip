<?php

namespace Pequiven\SEIPBundle\Controller\DataLoad\GasFlow;

use Pequiven\SEIPBundle\Controller\SEIPController;

/**
 * Controlador de Detalle de consumo de flujo de gas
 *
 * @author Matías Jiménez <matei249@gmail.com>
 */
class DetailConsumerPlanningGasFlowController extends SEIPController
{
    public function createNew() 
    {
        $entity = parent::createNew();
        $request = $this->getRequest();
        $consumerPlanningGasFlowId = $request->get("consumerPlanningGasFlow");
        if($consumerPlanningGasFlowId > 0){
            $em = $this->getDoctrine()->getManager();
            $consumerPlanningGasFlow = $em->find("Pequiven\SEIPBundle\Entity\DataLoad\GasFlow\ConsumerPlanningGasFlow", $consumerPlanningGasFlowId);
            $entity->setConsumerPlanningGasFlow($consumerPlanningGasFlow);
        }
        return $entity;
    }
    
    public function createAction(\Symfony\Component\HttpFoundation\Request $request) 
    {
        $resource = $this->createNew();
        $form = $this->getForm($resource);

        if ($request->isMethod('POST') && $form->submit($request)->isValid()) {
            $resource = $this->domainManager->create($resource);

            $url = $this->generateUrl("pequiven_consumer_planning_gasflow_show",array(
                "id" => $resource->getConsumerPlanningGasFlow()->getId(),
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

            $url = $this->generateUrl("pequiven_consumer_planning_gasflow_show",array(
                "id" => $resource->getConsumerPlanningGasFlow()->getId(),
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
