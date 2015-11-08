<?php

namespace Pequiven\SEIPBundle\Controller\Sip\Cutl;

use Pequiven\SEIPBundle\Controller\SEIPController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controlador CUTL
 * @author Maximo Sojo maxsojo13@gmail.com
 *
 */
class CutlController extends SEIPController {

    /**
     * Listado de CUTL
     *
     *
     */
    public function listAction(Request $request) {

        $criteria = $request->get('filter', $this->config->getCriteria());
        $sorting = $request->get('sorting', $this->config->getSorting());

        $repository = $this->getRepository();

        $cutl = $this->get('pequiven.repository.cutl')->findAll();

        $repository = $this->getRepository('pequiven.repository.cutl');

        //$criteria['cult'] = false;

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
                $this->config->getPluralResourceName() => $resources,
            );
            $view->setData($data);
        } else {
            $view->getSerializationContext()->setGroups(array('id', 'api_list', 'cedula', 'nombre', 'centro', 'codigoCentro'));
            $formatData = $request->get('_formatData', 'default');

            $view->setData($resources->toArray('', array(), $formatData));
        }

        return $this->handleView($view);
    }

    /**
     * 
     * @param Request $request
     * @return type
     */
    public function showAction(Request $request) {

        $id = $request->get('id');

        $cutl = $this->get('pequiven.repository.cutl')->find($id);
        if ($cutl->getAssistance()) {
            $assist = 1;
        } else {
            $assist = 0;
        }

        return $this->render('PequivenSEIPBundle:Sip:cutl\show.html.twig', array(
                    'cutl' => $cutl,
                    'assist' => $assist
        ));
    }

    /**
     * 
     * @param Request $request
     */
    public function updateAssistance(Request $request) {
        $response = new JsonResponse();
        $em = $this->getDoctrine()->getEntityManager();
        $id = $request->get('idCutl');
        $status = $request->get('status');
        $obs = $request->get('obs');

        $cutl = $this->get('pequiven.repository.cutl')->findOneBy(array("id" => $id));
        $cutl->setAssistance($status);
        $cutl->setObservation($obs);

        $em->persist($cutl);
        $em->flush();

        $data = array();
        $data["url"] = $this->generateUrl("pequiven_sip_cutl_show", array("id" => $id));

        $response->setData($data);
        return $response;
    }

}
