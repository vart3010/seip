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
use Pequiven\SEIPBundle\Entity\Sip\Center\Inventory;
use Pequiven\SEIPBundle\Form\Sip\Center\InventoryType;

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
            $idAssist = $value->getId();
            //Carga de Asistencia
            if (isset($request->get('sip_center_assists')[$idAssist])) {
                $value = 1;
            } else {
                $value = 0;
            }
            //Carga de Observación
            if (isset($request->get('sip_center_assists')["obs_" . $idAssist])) {
                $Observations = strtoupper($request->get('sip_center_assists')["obs_" . $idAssist]);
            } else {
                $Observations = NULL;
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
                $Assists->setObservations($Observations);
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
        $this->get('session')->getFlashBag()->add('success', "Asistencia Añadida Exitosamente");
    }

    /**
     *
     *  Eliminación de Asistencia
     *
     *
     */
    public function delAssistsAction(Request $request) {

        $id = $request->get('id');

        $em = $this->getDoctrine()->getManager();

        $results = $this->get('pequiven.repository.assists')->find($id);

        if ($results) {

            $em->remove($results);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Asistencia Eliminada Exitosamente');
            return true;
        }
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

        $status = 1; //Status Observación Enviada

        $obs = strtoupper($request->get('sip_center_observations')['observations']);

        $em = $this->getDoctrine()->getEntityManager();

        $form = $this->createForm(new ObservationsType(), new Observations());

        $form->bind($this->getRequest());

        if ($form->isSubmitted()) {
            $Observations = $form->getData();

            $Observations->setObservations($obs);
            $Observations->setCodigoCentro($idCenter);
            $Observations->setStatus($status);

            $em->persist($Observations);
            $em->flush();
            //return $this->redirect(...);            
        }
        $this->get('session')->getFlashBag()->add('success', "Requerimiento Añadido Exitosamente");
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

            $this->get('session')->getFlashBag()->add('success', "Estatus Cambiado Exitosamente");
        } else {
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
     *
     *  Eliminación de Observacion
     *
     *
     */
    public function delObservationsAction(Request $request) {

        $id = $request->get('id');

        $em = $this->getDoctrine()->getManager();

        $results = $this->get('pequiven.repository.observations')->find($id);

        if ($results) {

            $em->remove($results);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Observación Eliminada Exitosamente');
            return true;
        }
    }

    /**
     * Formulario de Inventario de materiales CUTL
     * @param Request $request
     * @return type
     */
    public function formInventoryAction(Request $request) {

        $em = $this->getDoctrine()->getEntityManager();

        $idCenter = $request->get('idCenter');

        $inventory = new Inventory();

        $form = $this->createForm(new InventoryType(), $inventory);


        if (isset($request->get('sip_center_inventory')['material'])) {

            $obs = strtoupper($request->get('sip_center_inventory')['observations']);

            $material = $request->get('sip_center_inventory')['material'];

            $material = $this->get('pequiven.repository.material')->find($material);

            $form->bind($this->getRequest());

            //Seteo de datos
            $inventory->setObservations($obs);
            $inventory->setCodigoCentro($idCenter);
            $inventory->setMaterial($material);

            $inventory = $form->getData();

            $em->persist($inventory);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Registro Añadido Exitosamente');
        }

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('Form/Inventory.html'))
                ->setTemplateVar($this->config->getPluralResourceName())
                ->setData(array(
            'form' => $form->createView(),
                ))
        ;
        $view->getSerializationContext()->setGroups(array('id', 'api_list'));

        return $view;
    }

    /**
     *
     *  Eliminación de Inventario
     *
     *
     */
    public function delInventoryAction(Request $request) {

        $id = $request->get('id');

        $em = $this->getDoctrine()->getManager();

        $results = $this->get('pequiven.repository.inventory')->find($id);

        if ($results) {

            $em->remove($results);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Registro Eliminada de Inventario Exitosamente');
            return true;
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
            $view->getSerializationContext()->setGroups(array('id', 'api_list', 'codigoCentro'));
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

        $em = $this->getDoctrine()->getManager();

        $id = $request->get('id');

        $center = $this->get('pequiven.repository.center')->find($id);

        $codigoCentro = $center->getCodigoCentro();

        $cutl = $this->get('pequiven.repository.cutl')->findBy(array('codigoCentro' => $codigoCentro));

        $ubch = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Ubch")->findBy(array("codigoCentro" => $codigoCentro));
        
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
            5 => 'Asistencia',
            6 => 'Telefonia',
        ];

        //Carga de status
        $status = [
            1 => "Abierto",
            2 => "Pendiente",
            3 => "Seguimiento",
            4 => "Cerrado",
            5 => "Rechazado"
        ];

        //Color de status
        $color = [
            1 => "#12799f",
            2 => "#e12002",
            3 => "#d1b200",
            4 => "#03c842",
            5 => "#920a00"
        ];

        //Carga de status
        $ubchCargo = [
            1 => "Jefe",
            2 => "Patrullero",            
        ];

        $assist = $this->get('pequiven.repository.assists')->findBy(array('codigoCentro' => $codigoCentro));

        $observations = $this->get('pequiven.repository.observations')->findBy(array('codigoCentro' => $codigoCentro));

        $inventory = $this->get('pequiven.repository.inventory')->findBy(array('codigoCentro' => $codigoCentro));

        return $this->render('PequivenSEIPBundle:Sip:Center\show.html.twig', array(

                    'center'        => $center,
                    'cutl'          => $cutl,
                    'assist'        => $assist,
                    'observations'  => $observations,
                    'nomCutl'       => $nomCutl,
                    'catObs'        => $catObs,
                    'status'        => $status,
                    'inventory'     => $inventory,
                    'colorStatus'   => $color,
                    'ubch'          => $ubch,
                    'ubchCargo'     => $ubchCargo
        ));
    }

    /**
     * Exportación a PDF
     * @param Request $request
     */
    public function ExportAction(Request $request) {
        $id = $request->get('idCenter');
        $type = $request->get('type');

        $reportService = $this->container->get('seip.service.report');
        $parameters = array("idCentro" => $id);

        //EN CASO DE VENIR DEL BOTON DE ASISTENCIAS
        if ($type == 2) {
            $route = "SIP/Asist_CUTL.jrxml";
        }

        //EN CASO DE VENIR DEL BOTON DE REQUERIMIENTOS
        if ($type == 3) {
            $route = "SIP/Obs_CUTL.jrxml";
        }

        //EN CASO DE VENIR DEL BOTON DE INVENTARIO
        if ($type == 4) {
            $route = "SIP/Inv_CUTL.jrxml";
        }

        $reportService->DownloadReportService($parameters, $route);

        return $this->redirect($this->generateUrl('pequiven_sip_center_show', array('id' => $id)));
    }

}
