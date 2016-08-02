<?php

namespace Pequiven\SEIPBundle\Controller\Delivery;

use Pequiven\SEIPBundle\Controller\SEIPController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controlador de plantilla de reporte de ventas
 *
 * @author Victor Tortolero <vart10.30@gmail.com>
 */
class ReportTemplateDeliveryController extends SEIPController {

    public function indexAction(Request $request) {

        $criteria = $request->get('filter', $this->config->getCriteria());
        $sorting = $request->get('sorting', $this->config->getSorting());
        $repository = $this->getRepository();

        $criteria['applyPeriodCriteria'] = true;

        $resources = $this->resourceResolver->getResource(
                $repository, 'createPaginatorByUser', array($criteria, $sorting)
        );

        $maxPerPage = $this->config->getPaginationMaxPerPage();
        if (($limit = $request->query->get('limit')) && $limit > 0) {
            if ($limit > 100) {
                $limit = 100;
            }
            $maxPerPage = $limit;
        }
        $resources->setCurrentPage($request->get('page', 1), true, true);
        $resources->setMaxPerPage($maxPerPage);

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('index.html'))
                ->setTemplateVar($this->config->getPluralResourceName())
        ;
        if ($request->get('_format') == 'html') {
            $view->setData($resources);
        } else {
            $formatData = $request->get('_formatData', 'default');
            $view->setData($resources->toArray('', array(), $formatData));
        }
        return $this->handleView($view);
    }

    public function createAction(Request $request) {
        $saveAndClose = $request->get("save_and_close");

        $resource = $this->createNew();
        $form = $this->getForm($resource);

        if ($request->isMethod('POST') && $form->submit($request)->isValid()) {
            $resource = $this->domainManager->create($resource);

            if (null === $resource) {
                return $this->redirectHandler->redirectToIndex();
            }

            if ($saveAndClose !== null) {
                return $this->redirectHandler->redirectTo($resource);
            } else {
                return $this->redirectHandler->redirectToRoute($this->config->getRedirectRoute('update'), ['id' => $resource->getId()]);
            }
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

    public function showAction(Request $request) {
        $reportTemplateDelivery = $this->getRepository()->find($request->get("id"));
        $productGroup = $reportTemplateDelivery->getProductGroupDelivery();

        $data = array(
            "reportTemplateDelivery" => $reportTemplateDelivery,
            "productGroup" => $productGroup
        );
        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('show.html'))
                ->setTemplateVar($this->config->getResourceName())
                ->setData($data)
        ;

        return $this->handleView($view);
    }

}
