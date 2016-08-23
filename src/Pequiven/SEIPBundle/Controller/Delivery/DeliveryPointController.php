<?php

namespace Pequiven\SEIPBundle\Controller\Delivery;

use Pequiven\SEIPBundle\Controller\SEIPController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controlador de puntos de despacho
 *
 * @author Victor Tortolero <vart10.30@gmail.com>
 */
class DeliveryPointController extends SEIPController {

    public function listAction(Request $request) {
        $criteria = $request->get('filter', $this->config->getCriteria());
        $sorting = $request->get('sorting', $this->config->getSorting());
        $repository = $this->getRepository();
        
        

        if ($this->config->isPaginated()) {
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
        } else {
            $resources = $this->resourceResolver->getResource(
                    $repository, 'findBy', array($criteria, $sorting, $this->config->getLimit())
            );
        }

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('list.html'))
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

}
