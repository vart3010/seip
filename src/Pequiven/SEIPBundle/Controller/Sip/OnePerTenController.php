<?php

namespace Pequiven\SEIPBundle\Controller\Sip;

use Pequiven\SEIPBundle\Controller\SEIPController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Pequiven\SEIPBundle\Entity\Sip\OnePerTen;
use Pequiven\SEIPBundle\Entity\Sip\OnePerTenMembers;
use Pequiven\SEIPBundle\Form\Sip\OnePerTenType;

/**
 * Controlador de gráficos en el SEIP
 *
 */
class OnePerTenController extends SEIPController {

    public function listAction(Request $request) {
        //return $this->render('PequivenSEIPBundle:Sip:onePerTen\list.html.twig', array());


        $criteria = $request->get('filter', $this->config->getCriteria());
        $sorting = $request->get('sorting', $this->config->getSorting());

        $repository = $this->getRepository('pequiven.repository.onePerTen');

        if ($this->config->isPaginated()) {
            $resources = $this->resourceResolver->getResource(
                    $repository, 'createPaginatorByOnePerTen', array($criteria, $sorting)
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
        $apiDataUrl = $this->generateUrl('pequiven_onePerTen_list', $routeParameters);

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('list.html'))
                ->setTemplateVar($this->config->getPluralResourceName())
        ;
        
        $profilesPoliticEvaluation = array();
        $profilesPoliticEvaluation[] = array('id' => 1,'description' => 'Perfil 1');
        $profilesPoliticEvaluation[] = array('id' => 2,'description' => 'Perfil 2');
        $profilesPoliticEvaluation[] = array('id' => 3,'description' => 'Perfil 3');
        $profilesPoliticEvaluation[] = array('id' => 4,'description' => 'Perfil 4');
        $profilesPoliticEvaluation[] = array('id' => 5,'description' => 'Perfil 5');
        
        $statusRevocatorySignature = array();
        $statusRevocatorySignature[] = array('id' => -1,'description' => 'Sin Información');
        $statusRevocatorySignature[] = array('id' => 0,'description' => 'No Firmó');
        $statusRevocatorySignature[] = array('id' => 1,'description' => 'Firmó');
        $statusRevocatorySignature[] = array('id' => 2,'description' => 'R');
        
        if ($request->get('_format') == 'html') {
            $data = array(
                'apiDataUrl' => $apiDataUrl,
                $this->config->getPluralResourceName() => $resources,
                'profilesPoliticEvaluation' => $profilesPoliticEvaluation,
                'statusRevocatorySignature' => $statusRevocatorySignature,
            );
            $view->setData($data);
        } else {
            $view->getSerializationContext()->setGroups(array('id', 'api_list'));
            $formatData = $request->get('_formatData', 'default');

            $view->setData($resources->toArray('', array(), $formatData));
        }

        return $this->handleView($view);
    }
    
    /**
     * Función que devuelve el paginador con las propuestas agrupados por los círculos heredados
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function listWithVoteAction(Request $request) {

        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();

        $criteria = $request->get('filter', $this->config->getCriteria());
        $sorting = $request->get('sorting', $this->config->getSorting());

        $workStudyCircleParent = $request->get('workStudyCircleParent');

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('PequivenSEIPBundle:Sip\NominaCentro');

        if ($this->config->isPaginated()) {
            $resources = $this->resourceResolver->getResource(
                    $repository, 'createPaginatorByCentroWithVotePqv', array($criteria, $sorting)
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

        $view = $this
                ->view()
                ->setTemplate('PequivenSEIPBundle:Sip:Center/show.html.twig')
                ->setTemplateVar($this->config->getPluralResourceName())
        ;
        $view->getSerializationContext()->setGroups(array('id', 'api_list'));
        if ($request->get('_format') == 'html') {
            $view->setData($resources);
        } else {
            $formatData = $request->get('_formatData', 'default');

            $view->setData($resources->toArray('', array(), $formatData));
        }
        return $this->handleView($view);
    }

    public function createAction(Request $request) {
        $formSearchOne = $this->createForm(new OnePerTenType);
        return $this->render('PequivenSEIPBundle:Sip:onePerTen\show.html.twig', array(
                    "form" => $formSearchOne->createView(),
                    "members" => "",
                    "user" => ""
        ));
    }

    public function addMemberAction(Request $request) {
        return $this->render('PequivenSEIPBundle:Sip:onePerTen\add.html.twig', array(
                    "idUserOne" => $request->get("idUserOne")
        ));
    }

    public function searchAction(Request $request) {
        $response = new JsonResponse();
        $em = $this->getDoctrine()->getEntityManager();
        $cedula = $request->get('ced');
        $datos = array(
            "nombre" => "",
            "centro" => "",
            "nameCentro" => "",
            "codigoParroquia" => "",
            "nombreParroquia" => "",
            "codigoMunicipio" => "",
            "nombreMunicipio" => "",
            "codigoEstado" => "",
            "nombreEstado" => "",
            "msj" => ""
        );

        $user = $em->getRepository("\Pequiven\SEIPBundle\Entity\User")->findOneBy(array("identification" => $cedula));

        //$onePerTen = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\OnePerTen")->findOneBy(array("user" => $request->get("idUserOne")));
        $onePerTen = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\OnePerTen")->getOnePerTen($request->get("idUserOne"));

        //$onePerTen = $this->get("pequiven.repository.onePerTen")->findOneBy(array("user" => "26"));
        $onePerTen = $onePerTen[0];
        $ciOne = $onePerTen->getCedula();


        if (($ciOne != "0") && (!is_null($ciOne))) {

            //SE BUSCA EL ESTADO EN REP
            $repOne = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Rep")->findOneBy(array("cedula" => $ciOne));


            //if (!isset($repOne)) {
            if ((count($repOne) <= 0)) {

                //SE BUSCA ESTADO EN CNE de ONE
                $cne = $this->getCneService();
                $userCneOne = $cne->getDatosCne($ciOne);
                $estadoOne = $userCneOne["estado"];
                sleep(4);
                //if (isset($estadoOne)) {
                // SE BUSCA ESTADO DE MIEMBRO
                $userCneMember = $cne->getDatosCne($cedula);
                $estadoMember = $userCneMember["estado"];

//            $repMember = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Rep")->findOneBy(array("cedula" => $cedula));
//            $codEstadoMember = $repMember->getCodigoEstado();
//            $estadoMember = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Estado")->findOneBy(array("id" => $codEstadoMember));
//            $estadoMember = $estadoOne->getDescription();
            } else {

                //SE BUSCA ESTADO ONE EN REP
                $codEstadoOne = $repOne->getCodigoEstado();
                $estadoOne = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Estado")->findOneBy(array("id" => $codEstadoOne));
                $estadoOne = $estadoOne->getDescription();

                // SE BUSCA ESTADO DE MIEMBRO
//            $cneMember = $this->getCneService();
//            $userCneMember = $cneMember->getDatosCne($cedula);
//            $estadoMember = $userCneMember["estado"];
                $repMember = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Rep")->findOneBy(array("cedula" => $cedula));
                if (count($repMember) > 0) {
                    $codEstadoMember = $repMember->getCodigoEstado();
                    $estadoMember = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Estado")->findOneBy(array("id" => $codEstadoMember));
                    $estadoMember = $estadoMember->getDescription();
                } else {
                    $estadoMember = "";
                    $datos["msj"] = "Miembro Ingresado no se encuentra registrado en tu Región o no Existe.";
                    $response->setData($datos);
                    return $response;
                }
            }

            if ($estadoOne == $estadoMember) {

                $onePerTenMembers = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\OnePerTenMembers")->findBy(
                        array(
                            "cedula" => $cedula,
                            "one" => $onePerTen->getId()
                        )
                );


                if (count($onePerTenMembers) <= 0) {

                    if (!isset($user) || $user->getWorkStudyCircle() == "null") {

                        if ($cedula != "" || $cedula != 0) {

                            /**
                             * VALIDACION CON NOMINA PQV
                             */
                            $nomina = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Nomina")->findOneBy(array("cedula" => $cedula));

                            if (is_null($nomina)) {
                                //VALIDA CON REP CARABOBO 
                                $rep = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Rep")->findOneBy(array("cedula" => $cedula));

                                if (is_null($rep)) {
                                    //VALIDACION CON CNE
                                    // $cne = $this->getCneService();
                                    sleep(4);
                                    $userCne = $cne->getDatosCne($cedula);

                                    $ced = explode("-", $userCne["cedula"]);

                                    $rs = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Estado")->findOneBy(array("description" => $userCne["estado"]));

                                    if (!is_null($rs)) {
                                        $datos["nombre"] = $userCne["nombre"];
                                        $datos["cedula"] = $ced[1];
                                        $datos["centro"] = "";
                                        $datos["nameCentro"] = $userCne["centro"];
                                        $datos["codigoParroquia"] = "";
                                        $datos["nombreParroquia"] = $userCne["parroquia"];
                                        $datos["codigoMunicipio"] = "";
                                        $datos["nombreMunicipio"] = $userCne["municipio"];
                                        $datos["codigoEstado"] = "";
                                        $datos["nombreEstado"] = $userCne["estado"];
                                    } else {
                                        $nameCentro = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->getCentro($rep->getCodigoCentro());
                                        $parroquia = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Parroquia")->findOneBy(array("id" => $rep->getCodigoParroquia()));
                                        $municipio = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Municipio")->findOneBy(array("id" => $rep->getCodigoMunicipio()));
                                        $estado = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Estado")->findOneBy(array("id" => $rep->getCodigoEstado()));
                                        $datos["nombre"] = $rep->getNombre();
                                        $datos["cedula"] = $rep->getCedula();
                                        $datos["centro"] = $rep->getCodigoCentro();
                                        $datos["nameCentro"] = $nameCentro[0]["description"];
                                        $datos["codigoParroquia"] = $parroquia->getId();
                                        $datos["nombreParroquia"] = $parroquia->getDescription();
                                        $datos["codigoMunicipio"] = $municipio->getId();
                                        $datos["nombreMunicipio"] = $municipio->getDescription();
                                        $datos["codigoEstado"] = $estado->getId();
                                        $datos["nombreEstado"] = $estado->getDescription();
                                    }
                                } else {
                                    $nameCentro = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->getCentro($rep->getCodigoCentro());
                                    $parroquia = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Parroquia")->findOneBy(array("id" => $rep->getCodigoParroquia()));
                                    $municipio = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Municipio")->findOneBy(array("id" => $rep->getCodigoMunicipio()));
                                    $estado = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Estado")->findOneBy(array("id" => $rep->getCodigoEstado()));
                                    $datos["nombre"] = $rep->getNombre();
                                    $datos["cedula"] = $rep->getCedula();
                                    $datos["centro"] = $rep->getCodigoCentro();
                                    $datos["nameCentro"] = $nameCentro[0]["description"];
                                    $datos["codigoParroquia"] = $parroquia->getId();
                                    $datos["nombreParroquia"] = $parroquia->getDescription();
                                    $datos["codigoMunicipio"] = $municipio->getId();
                                    $datos["nombreMunicipio"] = $municipio->getDescription();
                                    $datos["codigoEstado"] = $estado->getId();
                                    $datos["nombreEstado"] = $estado->getDescription();
                                }
                            } else {

                                $nameCentro = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->getCentro($nomina->getCodigoCentro());
                                $parroquia = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Parroquia")->findOneBy(array("id" => $nomina->getCodigoParroquia()));
                                $municipio = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Municipio")->findOneBy(array("id" => $nomina->getCodigoMunicipio()));
                                $estado = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Estado")->findOneBy(array("id" => $nomina->getCodigoEstado()));
                                $datos["nombre"] = $nomina->getEmpleado();
                                $datos["cedula"] = $nomina->getCedula();
                                $datos["centro"] = $nomina->getCodigoCentro();
                                $datos["nameCentro"] = $nameCentro[0]["description"];
                                $datos["codigoParroquia"] = $parroquia->getId();
                                $datos["nombreParroquia"] = $parroquia->getDescription();
                                $datos["codigoMunicipio"] = $municipio->getId();
                                $datos["nombreMunicipio"] = $municipio->getDescription();
                                $datos["codigoEstado"] = $estado->getId();
                                $datos["nombreEstado"] = $estado->getDescription();
                            }
                        }
                    } else {
                        $datos["msj"] = "El usuario es Nómina Pequiven";
                    }
                } else {
                    $datos["msj"] = "El usuario ya esta agregado a tu 1x10";
                }
            } else {
                $datos["msj"] = "El miembro esta fuera de la Región.";
            }
        } else {
            $datos["msj"] = "El responsable de 1x10 no tiene cédula registrada.";
        }

        $response->setData($datos);
        return $response;
    }

    public function saveAction(Request $request) {
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();

        //DATOS TEN
        $cedula = $request->get("cedula");
        $nombre = $request->get("nombre");
        $telefono = $request->get("telefono");
        $codCentro = $request->get("codCentro");
        $nombreCentro = $request->get("nombreCentro");
        $codParroquia = $request->get("codParroquia");
        $nombreParroquia = $request->get("nombreParroquia");
        $codMunicipio = $request->get("codMunicipio");
        $nombreMunicipio = $request->get("nombreMunicipio");
        $codEstado = $request->get("codEstado");
        $nombreEstado = $request->get("nombreEstado");

        $idUserOne = $request->get("idUserOne");

        $onePerTen = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\OnePerTen")->getOnePerTen($request->get("idUserOne"));
        //$onePerTen = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\OnePerTen")->findOneBy(array("user" => $idUserOne));


        $em->getConnection()->beginTransaction();
//        //ONE
//        $onePerTen = new OnePerTen();
//        $onePerTen->setUser($user);
//        $onePerTen->setCedula($user->getIndentification());
//        $onePerTen->setCreatedBy($user);
//        $em->persist($onePerTen);
        //MEMBERS
        $onePerTenMembers = new OnePerTenMembers();
        $onePerTenMembers->setOne($onePerTen[0]);
        $onePerTenMembers->setCedula($cedula);
        $onePerTenMembers->setNombre($nombre);
        $onePerTenMembers->setCodCentro($codCentro);
        $onePerTenMembers->setNombreCentro($nombreCentro);
        $onePerTenMembers->setCodigoParroquia($codParroquia);
        $onePerTenMembers->setNombreParroquia($nombreParroquia);
        $onePerTenMembers->setCodigoMunicipio($codMunicipio);
        $onePerTenMembers->setNombreMunicipio($nombreMunicipio);
        $onePerTenMembers->setCodigoEstado($codEstado);
        $onePerTenMembers->setNombreEstado($nombreEstado);
        $onePerTenMembers->setTelefono($telefono);
        $onePerTenMembers->setCreatedBy($user);
        $em->persist($onePerTenMembers);

        try {
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            throw $e;
        }
        $this->get('session')->getFlashBag()->add('success', 'Miembro Agregado Correctamente.');
        return $this->redirect($this->generateUrl('pequiven_search_members', array("user" => $idUserOne)));
    }

    public function showAction(Request $request) {
        $em = $this->getDoctrine()->getEntityManager();
        $onePerTenService = $this->getOnePerTenService();
        $onePerTen = $this->findOr404($request);//Obtenemos el objeto OnePerTen
        $user = $onePerTen->getUser();//Obtenemos el objeto usuario
        $members = $onePerTen->getTen();//Miembros del 1x10 del empleado

        $isCoordinator = 'No Aplica';
        $textWorkStudyCircle = 'No Aplica';
        $workStudyCircle = is_null($user) ? $user : $user->getWorkStudyCircle();
        if(!is_null($workStudyCircle)){
            $isCoordinator = $workStudyCircle->getCoordinator()->getId() == $user->getId() ? 'Sí' :'No';
            $textWorkStudyCircle = $workStudyCircle->getCodigo().$workStudyCircle->getName();
        }
        
        //Inicio de variable para saber si la persona trabajó como CUTL, Sala o CNE en las elecciones asamblea 2015
        $wasSupportAssemblyElections = 0;
            
        //Determinamos si fue CUTL en las elecciones asamblea 2015
        if($onePerTen->getCutl() == 1){
            $wasSupportAssemblyElections = 1;
        }
        //Determinamos si trabajó en la Sala Situacional en las elecciones asamblea 2015
        if($onePerTen->getSala() == 1){
            $wasSupportAssemblyElections = 1;
        }
        //Determinamos si trabajo como miembro del CNE en las elecciones asamblea 2015
        if($onePerTen->getCne() == 1){
            $wasSupportAssemblyElections = 1;
        }
        
        //Obtenemos efectividad del 1x10 registrado en PQV
        $efectividad = $onePerTenService->obtainEfficiencyOnePerTen($members);
        
        $profileItemsAvailables = $onePerTenService->obtainProfileItemsAvailables($onePerTen);
        $profileItemsWithWeight = $onePerTenService->obtainProfileItemsWithWeight($onePerTen, $profileItemsAvailables);
        $profileItemsWithResult = $onePerTenService->obtainProfileItemsWithResult($onePerTen, $profileItemsWithWeight,$members);

        $texts = array();
        $texts[-1] = 'Sin Información';
        $texts[0] = 'No';
        $texts[1] = 'Sí';
        
        $textsFirmaRevocatorio = array(
            -1 => 'Sin Información',
            0 => 'No',
            1 => 'F',
            2 => 'R',
        );
        
        $isAllowToAddAnalisis = false;
        if(!is_null($user) && ($user->getId() == 70 || $user->getId() == 112)){
            $isAllowToAddAnalisis = true;
        }
        
        
        //CUANDO CARGA UN ARCHIVO
        if (count($request->files) > 0) {
            $categoryFilesSelected = $request->get("onePerTenFile_data");


            $band = false;
            //VALIDACION QUE SEA UN ARCHIVO PERMITIDO
            foreach ($request->files as $file) {
                if (in_array($file["nameFile"]->guessExtension(), \Pequiven\SEIPBundle\Model\Sip\OnePerTenFile::getTypesFile())) {
                    $band = true;
                }
            }
            if ($band) {
                $this->createOnePerTenFile($onePerTen, $request->files, $categoryFilesSelected["categoryFile"]);
            } else {
                $this->get('session')->getFlashBag()->add('error', $this->trans('action.messages.InvalidFile', array(), 'PequivenIndicatorBundle'));
            }
        }
        $files = !(is_null($onePerTen)) ? $onePerTen->getOnePerTenFile() : null;
        
        $formSearchOne = $this->createForm(new OnePerTenType);
        return $this->render('PequivenSEIPBundle:Sip:onePerTen\show.html.twig', array(
                    "form" => $formSearchOne->createView(),
                    "user" => $user,
                    "isCoordinator" => $isCoordinator,
                    "textWorkStudyCircle" => $textWorkStudyCircle,
                    "onePerTen" => $onePerTen,
                    "wasSupportAssemblyElections" => $wasSupportAssemblyElections,
                    "workStudyCircle" => $workStudyCircle,
                    "texts" => $texts,
                    "textsFirmaRevocatorio" => $textsFirmaRevocatorio,
                    "members" => $members,
                    "efectividad" => $efectividad,
                    "profileItemsWithResult" => $profileItemsWithResult,
                    "isAllowToAddAnalisis" => $isAllowToAddAnalisis,
                    'files' => $files
        ));
    }
    
    public function uploadFilesAction(Request $request) {
        $onePerTenFile = new \Pequiven\SEIPBundle\Entity\Sip\OnePerTenFile();
        $form = $this->createForm(new \Pequiven\SEIPBundle\Form\Sip\OnePerTenFileType(), $onePerTenFile);
        $em = $this->getDoctrine();
        //$onePerTen = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\OnePerTen")->find($request->get("idOnePerTen"));

        return $this->render('PequivenSEIPBundle:Sip:onePerTen\uploadFile.html.twig', array(
                    'data' => $request->get("idOnePerTen"),
                    'form' => $form->createView()
        ));
    }
    
    public function uploadAction(Request $request) {
        $this->redirect($this->generateUrl('pequiven_search_members', array('user' => $user->getId())));
        
        $this->redirect($this->generateUrl("pequiven_meeting_show", array(
                    'id' => $request->get("idMeeting"),
        )));
    }
    
    public function addAnalisisAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();
        $onePerTen = new OnePerTen();
        $form = $this->createForm(new OnePerTenType, $onePerTen);
        $form->handleRequest($request);
        $idOnePerTen = $request->get("idOnePerTen");

        $onePerTen = $em->getRepository('PequivenSEIPBundle:Sip\OnePerTen')->findOneBy(array('id' => $request->get("idOnePerTen")));

        if ($form->isSubmitted()) {

            $onePerTen->setAnalisis($request->get("onePerTen_search")["analisis"]);

            $em->persist($onePerTen);
            
            try {
                $em->flush();
                $em->getConnection()->commit();
            } catch (Exception $e) {
                $em->getConnection()->rollback();
                throw $e;
            }
            $this->get('session')->getFlashBag()->add('success', 'Análisis agregado con éxito ');
            
            return $this->redirect($this->generateUrl('pequiven_onePerTen_show', array("id" => $idOnePerTen)));
        }

        return $this->render('PequivenSEIPBundle:Sip:onePerTen\addAnalisis.html.twig', array(
                    'idOnePerTen' => $request->get("idOnePerTen"),
                    'form' => $form->createView()
        ));
    }

    public function deleteMemeberAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $response = new JsonResponse();

        $onePerTenMembers = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\OnePerTenMembers")->findOneBy(array("id" => $request->get("id")));

        $this->remove($onePerTenMembers);
        $this->flush();


        $response->setData($request);
        return $response;
    }

    public function exportAction(Request $request) {
        $onePerTen = $this->findOr404($request);
        
        $members = $onePerTen->getTen();
        $one = $onePerTen->getUser();
        $voto = $onePerTen->getVoto();
        
        $onePerTenService = $this->getOnePerTenService();
        
        $isCoordinator = 'No Aplica';
        $textWorkStudyCircle = 'No Aplica';
        $workStudyCircle = is_null($one) ? $one : $one->getWorkStudyCircle();
        if(!is_null($workStudyCircle)){
            $isCoordinator = $workStudyCircle->getCoordinator()->getId() == $one->getId() ? 'Sí' :'No';
            $textWorkStudyCircle = $workStudyCircle->getCodigo().$workStudyCircle->getName();
        }
        
        //Inicio de variable para saber si la persona trabajó como CUTL, Sala o CNE en las elecciones asamblea 2015
        $wasSupportAssemblyElections = 0;

        //Determinamos si fue CUTL en las elecciones asamblea 2015
        if($onePerTen->getCutl() == 1){
            $wasSupportAssemblyElections = 1;
        }
        //Determinamos si trabajó en la Sala Situacional en las elecciones asamblea 2015
        if($onePerTen->getSala() == 1){
            $wasSupportAssemblyElections = 1;
        }
        //Determinamos si trabajo como miembro del CNE en las elecciones asamblea 2015
        if($onePerTen->getCne() == 1){
            $wasSupportAssemblyElections = 1;
        }

        //Obtenemos efectividad del 1x10 registrado en PQV
        $efectividad = $onePerTenService->obtainEfficiencyOnePerTen($members);
        
        $profileItemsAvailables = $onePerTenService->obtainProfileItemsAvailables($onePerTen);
        $profileItemsWithWeight = $onePerTenService->obtainProfileItemsWithWeight($onePerTen, $profileItemsAvailables);
        $profileItemsWithResult = $onePerTenService->obtainProfileItemsWithResult($onePerTen,$profileItemsWithWeight,$members);

        $pdf = new \Pequiven\SEIPBundle\Model\PDF\SipPdf('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->setPrintLineFooter(false);
        $pdf->setContainer($this->container);
        $pdf->setPeriod($this->getPeriodService()->getPeriodActive());
        $pdf->setFooterText($this->trans('pequiven_seip.message_footer', array(), 'PequivenSEIPBundle'));

// set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('SEIP');
        $pdf->setTitle('Perfil Político');
        $pdf->SetSubject('1x10 SEIP');
        $pdf->SetKeywords('PDF, SEIP, Resultados');

        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $pdf->AddPage();
        
        $texts = array();
        $texts[-1] = 'Sin Información';
        $texts[0] = 'No';
        $texts[1] = 'Sí';

        $data = array(
            "one" => $one,
            "workStudyCircle" => $workStudyCircle,
            "voto" => $voto,
            "object" => $onePerTen,
            "texts" => $texts,
            "wasSupportAssemblyElections" => $wasSupportAssemblyElections,
            "isCoordinator" => $isCoordinator,
            "textWorkStudyCircle" => $textWorkStudyCircle,
            "members" => $members,
            "efectividad" => $efectividad,
            "profileItemsWithResult" => $profileItemsWithResult,
        );
        $html = $this->renderView('PequivenSEIPBundle:Sip:onePerTen/reportList.html.twig', $data);

        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->Output('Reporte de 1x10' . '.pdf', 'D');
    }
    
    public function createOnePerTenFile(OnePerTen $onePerTen, $files, $categoryFiles) {
        $user = $onePerTen->getUser();
        $fileName = $onePerTen->getId() . "_" . $onePerTen->getCedula();
        $fileUploaded = false;
        $fileExist = false;
        $em = $this->getDoctrine()->getEntityManager();

        foreach ($files as $file) {
            $ifExistFile = $em->getRepository('PequivenSEIPBundle:Sip\OnePerTenFile')->findBy(array('nameFile' => base64_encode($file["nameFile"]->getClientOriginalName())));

            if (count($ifExistFile) == 0) {
                $onePerTenFile = new \Pequiven\SEIPBundle\Entity\Sip\OnePerTenFile;
                $onePerTenFile->setCreatedBy($this->getUser());
                $onePerTenFile->setNameFile($file["nameFile"]->getClientOriginalName());
                $onePerTenFile->setPath(\Pequiven\SEIPBundle\Model\Sip\OnePerTenFile::getUploadDir());
                $onePerTenFile->setExtensionFile($file["nameFile"]->guessExtension());
                $onePerTenFile->setOnePerTen($onePerTen);

                foreach ($categoryFiles as $key => $value) {
                    $categoryFileEntity = $em->getRepository('PequivenSEIPBundle:Politic\CategoryFile')->findOneBy(array('id' => $value));
                    $onePerTenFile->addCategoryFile($categoryFileEntity);
                }
                
                //SE MUEVE EL ARCHIVO AL SERVIDOR
                    $file["nameFile"]->move($this->container->getParameter("kernel.root_dir") . '/../web/' . \Pequiven\SEIPBundle\Model\Sip\OnePerTenFile::getUploadDir(), \Pequiven\SEIPBundle\Model\Sip\OnePerTenFile::NAME_FILE . $fileName . "_" . base64_encode($file["nameFile"]->getClientOriginalName()));
                $fileUploaded = $file["nameFile"]->isValid();
            } else {
                $fileExist = true;
            }
        }


        if (!$fileExist) {
            if (!$fileUploaded) {


                $em->persist($onePerTenFile);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', $this->trans('action.messages.saveFileSuccess', array(), 'PequivenIndicatorBundle'));
                $this->redirect($this->generateUrl('pequiven_onePerTen_show', array('id' => $onePerTen->getId())));
            } else {
                $this->get('session')->getFlashBag()->add('error', $this->trans('action.messages.errorFileUpload', array(), 'PequivenIndicatorBundle'));
                //$request->request->set("uploadFile", "");
                $this->redirect($this->generateUrl('pequiven_onePerTen_show', array('id' => $onePerTen->getId())));
            }
        } else {
            $this->get('session')->getFlashBag()->add('error', "El archivo ya existe.");
            $this->redirect($this->generateUrl('pequiven_onePerTen_show', array('id' => $onePerTen->getId())));
        }
    }
    
    public function generateUrlFileAction(Request $request) {

        $response = new JsonResponse();
        $data = array();
        $data["url"] = $this->generateUrl("pequiven_onePerTen_download_file", array("id" => $request->get("id")));
        $response->setData($data);
        return $response;
    }
    
    public function downloadFileAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $idFile = $request->get("id");
        $file = $em->getRepository('PequivenSEIPBundle:Sip\OnePerTenFile')->findOneBy(array('id' => $idFile));


        $path = \Pequiven\SEIPBundle\Model\Sip\OnePerTenFile::LOCATION_UPLOAD_FILE;
        $name = \Pequiven\SEIPBundle\Model\Sip\OnePerTenFile::NAME_FILE;
        $onePerTen = $file->getOnePerTen();

        $ruta = $this->container->getParameter("kernel.root_dir") . '/../web/' . $path . "/" . $name . $onePerTen->getId() . "_" . $onePerTen->getCedula() . "_" . base64_encode($file->getNameFile());

        header('Content-type: application/pdf');
        readfile($ruta);
    }

    protected function getCneService() {
        return $this->container->get('seip.service.apiCne');
    }
    
    /**
    * @return \Pequiven\SEIPBundle\Service\Sip\OnePerTenService
    */
    protected function getOnePerTenService()
    {
        return $this->get('seip.service.onePerTen');
    }

}
