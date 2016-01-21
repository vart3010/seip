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
        
//        $criteria['applyPeriodCriteria'] = true;
        
        $resources = $this->resourceResolver->getResource(
                $repository, 'createPaginatorReportTemplateDelivery', array($criteria, $sorting)
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
            $view->setData($resources->toArray($this->config->getRedirectRoute('index'), array(), $formatData));
        }
        return $this->handleView($view);
    }

}
