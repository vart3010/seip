<?php

namespace Pequiven\SEIPBundle\Controller\Sip\Cutl;

use Pequiven\SEIPBundle\Controller\SEIPController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controlador CUTL del SIP
 *
 */
class CutlController extends SEIPController {

	/**
	 * Listado de CUTL
	 *
	 *
	 */
    public function listAction(){

    	$criteria = $request->get('filter', $this->config->getCriteria());
        $sorting = $request->get('sorting', $this->config->getSorting());
        $repository = $this->getRepository();
        $phase = $request->get('phase');
        
        //$circle = $this->get('pequiven.repository.work_study_circle')->findAll(); 
        
        $criteria['phase'] = $phase;

        if ($this->config->isPaginated()) {
            $resources = $this->resourceResolver->getResource(
                    $repository, 'createPaginatorByCutl', array($criteria, $sorting)
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
        $routeParameters = array(
            '_format' => 'json',
            'phase' => $phase,
        );
        $apiDataUrl = $this->generateUrl('pequiven_sip_cutl_list', $routeParameters);

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('list.html'))
                ->setTemplateVar($this->config->getPluralResourceName())
        ;
        if ($request->get('_format') == 'html') {
            
            $data = array(
                'apiDataUrl' => $apiDataUrl,
                'phase' => $phase,
                $this->config->getPluralResourceName() => $resources,
            );
            $view->setData($data);
        } else {
            $view->getSerializationContext()->setGroups(array('id', 'api_list', 'complejo', 'region'));
            $formatData = $request->get('_formatData', 'default');

            $view->setData($resources->toArray('', array(), $formatData));
        }
        return $this->handleView($view);

    }

}
