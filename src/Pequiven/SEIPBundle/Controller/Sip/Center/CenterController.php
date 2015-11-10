<?php

namespace Pequiven\SEIPBundle\Controller\Sip\Center;

use Pequiven\SEIPBundle\Controller\SEIPController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Pequiven\SEIPBundle\Entity\Sip\Center\Observations;
use Pequiven\SEIPBundle\Form\Sip\Center\ObservationsType;
use Pequiven\SEIPBundle\Form\Sip\Center\StatusType;

use Pequiven\SEIPBundle\Entity\Sip\Center\Assists;
use Pequiven\SEIPBundle\Form\Sip\Center\AssistsType;

/**
 * Controlador Centros
 * @author Maximo Sojo <maxsojo13@gmail.com>
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
        
        $em = $this->getDoctrine()->getManager();

        $codigoCentro = $request->get('idCenter');        

        $cutl = $this->get('pequiven.repository.cutl')->findBy(array('codigoCentro' => $codigoCentro));
        
        $contCutl = count($cutl);

        foreach ($cutl as $value) {
            $cedula = $value->getCedula();            

            if (isset($request->get('sip_center_assists')[$value->getId()])) {
                $value = 1;
            }else{
                $value = 0;
            }

        $cedulaCutl = $cedula;

        $form = $this->createForm(new AssistsType(), new Assists());

        $form->bind($this->getRequest());

        $em->getConnection()->beginTransaction();
        
        if ($form->isSubmitted()) {

            $Assists = $form->getData();            
            $Assists->setCodigoCentro($codigoCentro);
            $Assists->setCedula($cedulaCutl);
            $Assists->setAssists($value);
            $em->persist($Assists);        
            $em->flush();
        }
            try {
                $em->flush();
                $em->getConnection()->commit();
            } catch (Exception $e) {
                $em->getConnection()->rollback();
                throw $e;
            }
        }
        $this->get('session')->getFlashBag()->add('success', "Asistencia Añadida Correctamente");
        
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

        $status = 1;//Status Observación Enviada

        $em = $this->getDoctrine()->getEntityManager();

        $form = $this->createForm(new ObservationsType(), new Observations());

        $form->bind($this->getRequest());

        if ($form->isSubmitted()) {
            $Observations = $form->getData();
            
            $Observations->setCodigoCentro($idCenter);
            $Observations->setStatus($status);

            $em->persist($Observations);
            $em->flush();
            //return $this->redirect(...);            
        }
        $this->get('session')->getFlashBag()->add('success', "Requerimiento Añadido Correctamente");                        
        
    }

    /**
     * 
     * @param Request $request
     * @return type
     */
    public function formStatusAction(Request $request) {
        
        $id = $request->get('idObs');

        $em = $this->getDoctrine()->getEntityManager();

        $observations = new Observations();        
        $form = $this->createForm(new StatusType(), $observations);

        if (isset($request->get('sip_center_observations_status')['status'])) {
            
            $form->bind($this->getRequest());
            
            $status = $request->get('sip_center_observations_status')['status'];

            $Observations = $this->get('pequiven.repository.observations')->find($id);
            
            $Observations->setStatus($status);
            
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', "Estatus Cambiado Correctamente");
            
        }else{
            $view = $this
                    ->view()
                    ->setTemplate($this->config->getTemplate('Form/Status.html'))
                    ->setTemplateVar($this->config->getPluralResourceName())
                    ->setData(array(            
                    'form' => $form->createView(),
                    ))
            ;
            $view->getSerializationContext()->setGroups(array('id', 'api_list'));
            
            return $view;

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

        //Carga de Nombre de CUTL
        foreach ($cutl as $value) {            
            $nomCutl[$value->getCedula()] = $value->getNombre();            
        }

        //Carga de Categorias
        $catObs = [
            1 => 'Propaganda',
            2 => 'Transporte',
            3 => 'Hidratación',
            4 => 'Logistica',
            5 => 'Asistencia'
        ];

        //Carga de status
        $status = [
            1 => "Enviado",
            2 => "Recibido",
            3 => "Aprobado",
            4 => "Rechazado"
        ];
        
        
        $assist = $this->get('pequiven.repository.assists')->findBy(array('codigoCentro' => $codigoCentro));

        $observations = $this->get('pequiven.repository.observations')->findBy(array('codigoCentro' => $codigoCentro));


        return $this->render('PequivenSEIPBundle:Sip:Center\show.html.twig', array(
                    'center'        => $center,
                    'cutl'          => $cutl,
                    'assist'        => $assist,
                    'observations'  => $observations,
                    'nomCutl'       => $nomCutl,
                    'catObs'        => $catObs,
                    'status'        => $status
        ));
    }

}
