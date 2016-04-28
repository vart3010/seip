<?php

namespace Pequiven\SEIPBundle\Controller\User;

use Symfony\Component\HttpFoundation\Request;
use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController;

/**
 * Controlador de Localizacion
 *
 * @author inhack20
 */
class LocalizationController extends ResourceController
{
    public function createAction(Request $request) {
        $resource = $this->createNew();
        $form = $this->getForm($resource);
        $user = $this->get('pequiven.repository.user')->find($request->get('userId'));
        
        if ($request->isMethod('POST') && $form->submit($request)->isValid()) {
            $resource->setConfiguration($user->getConfiguration());
            $resource = $this->domainManager->create($resource);

            return $this->redirect($this->generateUrl('pequiven_user_update',array('id' => $user->getId())));
        }
        
        if ($this->config->isApiRequest()) {
            return $this->handleView($this->view($form));
        }

        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('create.html'))
            ->setData(array(
                $this->config->getResourceName() => $resource,
                'form'                           => $form->createView(),
                'user' => $user
            ))
        ;

        return $this->handleView($view);
    }
    
    public function updateAction(Request $request) {
        $resource = $this->findOr404($request);
        $form = $this->getForm($resource);

        if (($request->isMethod('PUT') || $request->isMethod('POST')) && $form->submit($request)->isValid()) {

            $this->domainManager->update($resource);
            $user = $resource->getConfiguration()->getUser();
            return $this->redirect($this->generateUrl('pequiven_user_update',array('id' => $user->getId())));
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
