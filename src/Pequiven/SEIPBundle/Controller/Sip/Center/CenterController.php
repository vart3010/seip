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
use Pequiven\SEIPBundle\Form\Sip\Center\AssistsEditType;
use Pequiven\SEIPBundle\Entity\Sip\Center\Inventory;
use Pequiven\SEIPBundle\Form\Sip\Center\InventoryType;
use Pequiven\SEIPBundle\Entity\Sip\Center\StatusCentro;

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
     * 
     * @param Request $request
     * @return type
     */
    public function formAssistsEditAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $idCenter = $request->get('idCenter');
        
        $fecha = date("Y-m-d");
        //$fecha = date_create_from_format("Y/m/d", $fecha);        
        $cutl = $this->get('pequiven.repository.cutl')->findBy(array('codigoCentro' => $idCenter));
        $resultCenter = $this->get('pequiven.repository.assists')->getAssistFechaCenter($idCenter, $fecha);
        $resultCutl = $this->get('pequiven.repository.assists')->getAssistFecha($idCenter, $fecha);
        

        $assists = new Assists();
        $statusCentro = new StatusCentro();
        $form = $this->createForm(new AssistsEditType(), $assists);
        $cont = 1;
        if (isset($request->get('sip_center_assists')["obs_centro"])) {
            
            foreach ($cutl as $cutlValues) {
                $contC = $cont - 1;
                
                $idCutl = $resultCutl[$contC]["id"];
                $idCenter = $resultCenter[$contC]["id"];

                $form->bind($this->getRequest());

                $assists = $this->get('pequiven.repository.assists')->find($idCutl);            
                $statusCentro = $this->get('pequiven.repository.statusCentro')->find($idCenter);                            
                
                $idCutl = $cutlValues->getId();//Id cutl


                $ObsCentro = $request->get('sip_center_assists')["obs_centro"];
                //Status del centro
                if (isset($request->get('sip_center_assists')["status"])) {
                    $status = 1;
                } else {
                    $status = 0;
                }
                //Carga de Asistencia
                if (isset($request->get('sip_center_assists')[$idCutl])) {
                    $value = 1;
                } else {
                    $value = 0;
                }
                //Carga de Observación
                if (isset($request->get('sip_center_assists')["obs_".$idCutl])) {
                    $Observations = strtoupper($request->get('sip_center_assists')["obs_" . $idCutl]);
                } else {
                    $Observations = NULL;
                }
                
                    $resultCutl = $form->getData();                
                    $assists->setAssists($value);                
                    $assists->setObservations($Observations);
                    
                    $em->flush();
                    
                    if ($cont == 1) {                        
                        $statusCentro->setStatus($status);
                        $statusCentro->setObservations($ObsCentro);
                        
                        $em->flush();
                    }        
                    
                    $cont++;
            }

            
        }else{

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('Form/AssistsEdit.html'))
                ->setTemplateVar($this->config->getPluralResourceName())
                ->setData(array(
                'resultCutl'    => $resultCutl,
                'resultCenter'  => $resultCenter,
                'cutl'          => $cutl,
                'fecha'         => $fecha,
                'form'          => $form->createView(),
                ))
        ;
        $view->getSerializationContext()->setGroups(array('id', 'api_list'));

        return $view;
        }
    }

    /**
     * Guardamos las asistencias
     * 
     * @param Request $request
     * @return type
     */
    public function addAssistsAction(Request $request) {

        $ObsCentro = $request->get('sip_center_assists')["obs_centro"];
        $fecha = $request->get('sip_center_assists')['fecha'];

        $em = $this->getDoctrine()->getManager();

        $codigoCentro = $request->get('idCenter');

        $cutl = $this->get('pequiven.repository.cutl')->findBy(array('codigoCentro' => $codigoCentro));

        //$assist = $this->get('pequiven.repository.assists')->findBy(array('codigoCentro' => $codigoCentro));
        //$fecha = $request->get('sip_center_assists')['fecha'];
        //$fecha = date("Y-d-m H:i:s", strtotime($fecha)); 
        //$aprob = 1;

        $fecha = date_create_from_format("d/m/Y", $fecha);

        $contCutl = count($cutl);
        $cont = 1;

        foreach ($cutl as $value) {
            $cedula = $value->getCedula();
            $idAssist = $value->getId();
            //Status del centro
            if (isset($request->get('sip_center_assists')["status"])) {
                $status = 1;
            } else {
                $status = 0;
            }

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

                if ($cont == 1) {
                    $statusCentro = new StatusCentro();
                    $statusCentro->setCodigoCentro($codigoCentro);
                    $statusCentro->setFecha($fecha);
                    $statusCentro->setStatus($status);
                    $statusCentro->setObservations($ObsCentro);

                    $em->persist($statusCentro);
                    $em->flush();
                }
            }

            try {
                $em->flush();
                $em->getConnection()->commit();
            } catch (Exception $e) {
                $em->getConnection()->rollback();
                throw $e;
            }
            $cont++;
        }
        $this->get('session')->getFlashBag()->add('success', "Datos Cargados Exitosamente");
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

        $center = $this->get('pequiven.repository.center')->findOneBy(array('codigoCentro'=>$idCenter));

        $obs = strtoupper($request->get('sip_center_observations')['observations']);

        $em = $this->getDoctrine()->getEntityManager();

        $form = $this->createForm(new ObservationsType(), new Observations());

        $form->bind($this->getRequest());

        if ($form->isSubmitted()) {
            $Observations = $form->getData();

            $Observations->setObservations($obs);
            $Observations->setCodigoCentro($idCenter);
            $Observations->setCentro($center->getDescription());
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
            
            $center = $this->get('pequiven.repository.center')->findOneBy(array('codigoCentro'=>$idCenter));

            $obs = strtoupper($request->get('sip_center_inventory')['observations']);

            $material = $request->get('sip_center_inventory')['material'];

            $material = $this->get('pequiven.repository.material')->find($material);

            $form->bind($this->getRequest());

            //Seteo de datos
            $inventory->setObservations($obs);
            $inventory->setCodigoCentro($idCenter);
            $inventory->setMaterial($material);
            $inventory->setCentro($center->getDescription());

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

        $cantCutl = 0;

        $center = $this->get('pequiven.repository.center')->find($id);

        //Personal PQV por centro
        //$result = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Rep")->getPqvCentro($center->getCodigoCentro());
        $result = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\NominaCentro")->findBy(array('codigoCentro' => $center->getCodigoCentro()));
        
        $result = count($result);
        
        $codigoCentro = $center->getCodigoCentro();

        $cutl = $this->get('pequiven.repository.cutl')->findBy(array('codigoCentro' => $codigoCentro));

        $centerAct = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Center\StatusCentro")->findBy(array("codigoCentro" => $codigoCentro));

        $ubch = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Ubch")->findBy(array("codigoCentro" => $codigoCentro));

        $cantCutl = count($cutl);
        //Carga de Nombre de CUTL
        if ($cantCutl == 0) {
            $nomCutl = array();
            $cedula = 0;
        } else {
            foreach ($cutl as $value) {
                $nomCutl[$value->getCedula()] = $value->getNombre();
                $cedula = $value->getCedula();
            }
        }

        $validacionCutl = $cedula;
        //var_dump($nomCutl);
        //die();
        //Carga de Categorias
        $catObs = [
            1 => 'Propaganda',
            2 => 'Transporte',
            3 => 'Hidratación',
            4 => 'Logistica',
            5 => 'Asistencia',
            6 => 'Telefonia',
            7 => 'Otros...',
            8 => 'Servicios de Luz',
            9 => 'Servicios de Agua',
            10 => 'Servicios de Aseo',
            11 => 'Material de Oficina',
            12 => 'Cava',
            13 => 'Termo de Agua',
            14 => 'CNE',
            15 => 'Comida'
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
            2 => "#03c842",
            3 => "#d1b200",
            4 => "#e12002",
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
                    'center' => $center,
                    'cutl' => $cutl,
                    'assist' => $assist,
                    'observations' => $observations,
                    'nomCutl' => $nomCutl,
                    'catObs' => $catObs,
                    'status' => $status,
                    'inventory' => $inventory,
                    'colorStatus' => $color,
                    'ubch' => $ubch,
                    'ubchCargo' => $ubchCargo,
                    'cantCutl' => $cantCutl,
                    'validacionCutl' => $validacionCutl,
                    'centerAct' => $centerAct,
                    'pqvCentro' => $result
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
            //$route = "SIP/AsistTabla.jrxml";
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

    /**
     *
     *  Lista de Personal PQV
     *
     */
    public function listPqvAction(Request $request) {

        $idCentro = $request->get('idCentro');
        $center = $this->get('pequiven.repository.center')->find($idCentro);
        $codCentro = $center->getCodigoCentro(); //Cargo el codigo del centro

        $criteria = $request->get('filter', $this->config->getCriteria());
        $sorting = $request->get('sorting', $this->config->getSorting());

        $repository = $this->getRepository();
        $repository = $this->get('pequiven.repository.nominaCentro');        
        

        $criteria['codCentro'] = $codCentro;

        if ($this->config->isPaginated()) {
            $resources = $this->resourceResolver->getResource(
                    $repository, 'createPaginatorByCentroPqv', array($criteria, $sorting)
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
            'idCentro' => $idCentro
        );
        $apiDataUrl = $this->generateUrl('pequiven_sip_cutl_list_pqv', $routeParameters);

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('listPqv.html'))
                ->setTemplateVar($this->config->getPluralResourceName())
        ;
        if ($request->get('_format') == 'html') {
            $data = array(
                'apiDataUrl' => $apiDataUrl,
                $this->config->getPluralResourceName() => $resources,
            );
            $view->setData($data);
        } else {
            $view->getSerializationContext()->setGroups(array('id', 'api_list','cedula','nombre', 'codigoCentro'));
            $formatData = $request->get('_formatData', 'default');

            $view->setData($resources->toArray('', array(), $formatData));
        }

        return $this->handleView($view);
    }


    /**
     *
     *  Lista de de Requerimientos
     *
     */
    public function listRequestAction(Request $request) {

        $criteria = $request->get('filter', $this->config->getCriteria());
        $sorting = $request->get('sorting', $this->config->getSorting());

        $repository = $this->getRepository();
        $repository = $this->get('pequiven.repository.observations');        
        
        //$criteria['codCentro'] = $codCentro;

        if ($this->config->isPaginated()) {
            $resources = $this->resourceResolver->getResource(
                    $repository, 'createPaginatorByRequest', array($criteria, $sorting)
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
            '_format' => 'json'
        );
        $apiDataUrl = $this->generateUrl('pequiven_sip_request_list', $routeParameters);

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('listRequest.html'))
                ->setTemplateVar($this->config->getPluralResourceName())
        ;
        if ($request->get('_format') == 'html') {
            $labelsStatus = array();
            foreach (Observations::getCategoriasObservations() as $key => $value) {
                $labelsObservations[] = array(
                    'id' => $key,
                    'description' => $this->trans($value, array(), 'PequivenArrangementProgramBundle'),
                );
            }

            foreach (Observations::getStatusObservations() as $key => $value) {
                $labelsStatus[] = array(
                    'id' => $key,
                    'description' => $this->trans($value, array(), 'PequivenArrangementProgramBundle'),
                );
            }

            $data = array(
                'labelsObservations' => $labelsObservations,
                'labelsStatus'       => $labelsStatus,
                'apiDataUrl'         => $apiDataUrl,
                $this->config->getPluralResourceName() => $resources,
            );
            $view->setData($data);
        } else {
            $view->getSerializationContext()->setGroups(array('id', 'api_list', 'codigoCentro', 'status', 'categoria', 'observations', 'fecha'));
            $formatData = $request->get('_formatData', 'default');

            $view->setData($resources->toArray('', array(), $formatData));
        }

        return $this->handleView($view);
    }

    /**
     *
     *  Lista de Inventario
     *
     */
    public function listInventoryAction(Request $request) {

        $criteria = $request->get('filter', $this->config->getCriteria());
        $sorting = $request->get('sorting', $this->config->getSorting());

        $repository = $this->getRepository();
        $repository = $this->get('pequiven.repository.inventory');        
        
        //$criteria['codCentro'] = $codCentro;

        if ($this->config->isPaginated()) {
            $resources = $this->resourceResolver->getResource(
                    $repository, 'createPaginatorByInventory', array($criteria, $sorting)
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
            '_format' => 'json'
        );
        $apiDataUrl = $this->generateUrl('pequiven_sip_request_list_inventory', $routeParameters);

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('listInventory.html'))
                ->setTemplateVar($this->config->getPluralResourceName())
        ;
        if ($request->get('_format') == 'html') {
            $data = array(
                'apiDataUrl' => $apiDataUrl,
                $this->config->getPluralResourceName() => $resources,
            );
            $view->setData($data);
        } else {
            $view->getSerializationContext()->setGroups(array('id', 'api_list', 'codigoCentro', 'material', 'cantidad', 'observations', 'fecha'));
            $formatData = $request->get('_formatData', 'default');

            $view->setData($resources->toArray('', array(), $formatData));
        }

        return $this->handleView($view);
    }

}
