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

    public function indexAction(Request $request) {

        $criteria = $request->get('filter', $this->config->getCriteria());
        $sorting = $request->get('sorting', $this->config->getSorting());
        $repository = $this->getRepository();
        
        $criteria['applyPeriodCriteria'] = true;
        
        
        var_dump("1");
        $resources = $this->resourceResolver->getResource(
                $repository, 'createPaginatorByUser', array($criteria, $sorting)
        );
        var_dump("2");
        die();
        
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

}
