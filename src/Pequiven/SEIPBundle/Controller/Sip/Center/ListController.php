<?php

namespace Pequiven\SEIPBundle\Controller\Sip\Center;

use Pequiven\SEIPBundle\Controller\SEIPController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controlador Display
 * @author Gilbert C. <glavrjk@gmail.com>
 *
 */
class ListController extends SEIPController {

    /**
     *
     * 	Voto Pequiven
     *
     */
    public function ListGeneralVoteAction(Request $request) {

        $criteria = $request->get('filter', $this->config->getCriteria());
        $sorting = $request->get('sorting', $this->config->getSorting());

        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();

        $repository = $this->get('pequiven.repository.siplist');
   
        if ($this->config->isPaginated()) {
            $resources = $this->resourceResolver->getResource(
                    $repository, 'getGeneralVote', array($criteria, $sorting)
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
        );
        $apiDataUrl = $this->generateUrl('pequiven_sip_list_voto_general', $routeParameters);
       
        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('ListGeneralVote.html'))
                ->setTemplateVar($this->config->getPluralResourceName())
        ;
        if ($request->get('_format') == 'html') {
            $data = array(
                'apiDataUrl' => $apiDataUrl,
                $this->config->getPluralResourceName() => $resources,
            );
            $view->setData($data);
        } else {     
//            $view->getSerializationContext()->setGroups(array('id', 'api_list', 'codigoCentro'));
            $formatData = $request->get('_formatData', 'default');

            $view->setData($resources->toArray('', array(), $formatData));
        }

        return $this->handleView($view);
    }

//        //Carga de data
//        $response = new JsonResponse();
//        
//        $CenterService = $this->getCenterService();
//
//        $dataChart = $CenterService->getDataChartOfVotoPqv(); //Paso de data        
//
//        return $this->render('PequivenSEIPBundle:Sip:Center/Display/voto.html.twig', array(
//                'data' => $dataChart
//            ));

    protected function getCenterService() {
        return $this->container->get('seip.service.center');
    }

}
