<?php

namespace Pequiven\SEIPBundle\Controller\Sip\Center;

use Pequiven\SEIPBundle\Controller\SEIPController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Pequiven\SEIPBundle\Entity\Sip\Center\Observations;
use Pequiven\SEIPBundle\Form\Sip\Center\ObservationsType;

use Pequiven\SEIPBundle\Entity\Sip\Center\Assists;
use Pequiven\SEIPBundle\Form\Sip\Center\AssistsType;

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
    public function formAssistsAction(Request $request) {

        $idCenter = $request->get('idCenter');

        $cutl = $this->get('pequiven.repository.cutl')->findBy(array('codigoCentro' => $idCenter));

        $observations = new Assists();
        
        $form = $this->createForm(new AssistsType(), $observations);

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('Form/Assists.html'))
                ->setTemplateVar($this->config->getPluralResourceName())
                ->setData(array( 
                'cutl' => $cutl,           
                'form' => $form->createView(),
                ))
        ;
        $view->getSerializationContext()->setGroups(array('id', 'api_list'));
        
        return $view;
        
    }

    /**
     * Guardamos las asistencias
     * 
     * @param Request $request
     * @return type
     */
    public function addAssistsAction(Request $request) {
        
        $idCenter = $request->get('idCenter');
        
        $cedulaCutl = $request->get('sip_center_assists')['cedula'];
        $value = 0;

        if ($request->get('switchAssistance')) {
            $value = 1;
        }else{
            $value = 0;
        }
        
        $em = $this->getDoctrine()->getEntityManager();

        $form = $this->createForm(new AssistsType(), new Assists());

        $form->bind($this->getRequest());

        //if ($form->isValid()) {
            $Assists = $form->getData();
            
            $Assists->setCodigoCentro($idCenter);
            $Assists->setCedula($cedulaCutl);
            $Assists->setAssists($value);

            $em->persist($Assists);
            $em->flush();

            //return $this->redirect(...);
            var_dump("Cargado!");
            die();
        //}
        
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
        
        $idCenter = $request->get('idCenter');

        $em = $this->getDoctrine()->getEntityManager();

        $form = $this->createForm(new ObservationsType(), new Observations());

        $form->bind($this->getRequest());

        if ($form->isValid()) {
            $Observations = $form->getData();
            
            $Observations->setCodigoCentro($idCenter);

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

        $codigoCentro = $center->getCodigoCentro();
        
        $cutl = $this->get('pequiven.repository.cutl')->findBy(array('codigoCentro' => $codigoCentro));
        
        foreach ($cutl as $value) {
            
            $nomCutl = [
                $value->getCedula() => $value->getNombre()
            ];
            
        }
        
        
        $assist = $this->get('pequiven.repository.assists')->findBy(array('codigoCentro' => $codigoCentro));

        $observations = $this->get('pequiven.repository.observations')->findBy(array('codigoCentro' => $codigoCentro));

//        if ($cutl->getAssistance()) {
//            $assist = 1;
//        } else {
//            $assist = 0;
//        }

        return $this->render('PequivenSEIPBundle:Sip:Center\show.html.twig', array(
                    'center'        => $center,
                    'cutl'          => $cutl,
                    'assist'        => $assist,
                    'observations'  => $observations,
                    'nomCutl'        => $nomCutl
        ));
    }

}
