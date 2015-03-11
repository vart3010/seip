<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Controller\Planning\ValueIndicator;

use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController;

/**
 * Controlador de configuracion de detalles de valores de indicador
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class ValueIndicatorConfigController extends ResourceController
{
    public function createAction(\Symfony\Component\HttpFoundation\Request $request) 
    {
        $indicatorId = $request->get('indicator_id');
        $indicator = $this->get('pequiven.repository.indicator')->find($indicatorId);
        
        $resource = $this->createNew();
        $resource->setIndicator($indicator);
        
        $form = $this->getForm($resource);

        if ($request->isMethod('POST') && $form->submit($request)->isValid()) {
            $resource = $this->domainManager->create($resource);

            if (null === $resource) {
                return $this->redirectHandler->redirectToIndex();
            }

            return $this->redirectHandler->redirectTo($resource);
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
}
