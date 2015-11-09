<?php

namespace Pequiven\SEIPBundle\Controller\Sip\Center;

use Pequiven\SEIPBundle\Controller\SEIPController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Pequiven\SEIPBundle\Entity\Sip\Center\Observations;
use Pequiven\SEIPBundle\Form\Sip\Center\ObservationsType;

/**
 * Controlador Centros
 * @author Maximo Sojo maxsojo13@gmail.com
 *
 */
class CenterController extends SEIPController {

    /**
     * 
     * @param Request $request
     * @return type
     */
    public function assistsAction(Request $request) {

        $id = $request->get('id');
        
        var_dump($id);
        die();
        
    }

    /**
     * 
     * @param Request $request
     * @return type
     */
    public function formObservationsAction(Request $request) {

        $observations = new Observations();
        
        $form = $this->createForm(new ObservationsType(), $observations);

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('Form/Observations.html'))
                ->setTemplateVar($this->config->getPluralResourceName())
                ->setData(array(            
                'form' => $form->createView(),
                ))
        ;
        $view->getSerializationContext()->setGroups(array('id', 'api_list'));
        
        return $view;
        
    }

    /**
     * Guardamos las obervaciones
     * 
     * @param Request $request
     * @return type
     */
    public function addObservationsAction(Request $request) {
        
        $em = $this->getDoctrine()->getEntityManager();

        $form = $this->createForm(new ObservationsType(), new Observations());

        $form->bind($this->getRequest());

        if ($form->isValid()) {
            $Observations = $form->getData();

            $em->persist($Observations);
            $em->flush();

            //return $this->redirect(...);
            var_dump("Cargado!");
            die();
        }
        
    }
    
    /**
     * Listado de Centros
     *
     *
     */
    public function listAction(Request $request) {

        $criteria = $request->get('filter', $this->config->getCriteria());
        $sorting = $request->get('sorting', $this->config->getSorting());

        $repository = $this->getRepository();

        $repository = $this->getRepository('pequiven.repository.center');

        //$criteria['cult'] = false;

        if ($this->config->isPaginated()) {
            $resources = $this->resourceResolver->getResource(
                    $repository, 'createPaginatorByCentro', array($criteria, $sorting)
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
        $apiDataUrl = $this->generateUrl('pequiven_sip_center_list', $routeParameters);

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
            $view->getSerializationContext()->setGroups(array('id', 'api_list','codigoCentro'));
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

        $center = $this->get('pequiven.repository.center')->find($id);
        $assist = 0;
        
//        if ($cutl->getAssistance()) {
//            $assist = 1;
//        } else {
//            $assist = 0;
//        }

        return $this->render('PequivenSEIPBundle:Sip:Center\show.html.twig', array(
                    'center' => $center,
                    'assist' => $assist
        ));
    }

}
