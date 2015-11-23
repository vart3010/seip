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

//        $repository = $this->getRepository();
//        $cutl = $this->get('pequiven.repository.onePerTen')->findAll();

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
        if ($request->get('_format') == 'html') {
            $data = array(
                'apiDataUrl' => $apiDataUrl,
                $this->config->getPluralResourceName() => $resources,
            );
            $view->setData($data);
        } else {
            $view->getSerializationContext()->setGroups(array('id', 'api_list'));
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
                $cneOne = $this->getCneService();
                $userCneOne = $cneOne->getDatosCne($ciOne);
                $estadoOne = $userCneOne["estado"];

                // SE BUSCA ESTADO DE MIEMBRO
                $cneMember = $this->getCneService();
                $userCneMember = $cneMember->getDatosCne($cedula);
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
                }
            }

//            var_dump('One: ' . $estadoOne . ' Ten: ' . $estadoMember);
//            die();


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
                                    $cne = $this->getCneService();
                                    $userCne = $cne->getDatosCne($cedula);
                                    if ($userCne["cedula"] != "xx") {
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
                                            $datos["msj"] = "La persona debe pertenecer al mismo estado.";
                                        }
                                    } else {
                                        $datos["msj"] = "Por favor consulte nuevamente, estamos teniendo dificultades con la comunicación con el CNE.";
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

    public function searchMembersAction(Request $request) {
        $em = $this->getDoctrine()->getEntityManager();
        if ($request->get("user") == NULL) {
            if (!isset($request->get("onePerTen_search")["user"])) {
                $user = $this->getUser();
                $idUser = $user->getId();
            } else {
                $idUser = $request->get("onePerTen_search")["user"]; //Pequiven\SEIPBundle\Entity
            }
        } else {
            $idUser = $request->get("user");
        }
        $user = $em->getRepository("\Pequiven\SEIPBundle\Entity\User")->findOneBy(array("id" => $idUser));


        $members = array();
        $onePerTen = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\OnePerTen")->findOneBy(array("user" => $idUser));
        if (!is_null($onePerTen)) {
            $onePerTenMembers = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\OnePerTenMembers")->findBy(array("one" => $onePerTen->getId()));
            if (count($onePerTenMembers) > 1) {
                foreach ($onePerTenMembers as $member) {
//                    $nombreCentro = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->getCentro($member->getCodCentro());
//                    $nombreCentro = $nombreCentro[0]["description"];
                    $members[] = array(
                        "id" => $member->getId(),
                        "nombre" => $member->getNombre(),
                        "telefono" => $member->getTelefono(),
                        "idCentro" => $member->getCodCentro(),
                        "centro" => $member->getNombreCentro()
                    );
                }
            } else if (count($onePerTenMembers) == 1) {
//                $nombreCentro = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->getCentro($onePerTenMembers[0]->getCodCentro());
//                $nombreCentro = $nombreCentro[0]["description"];

                $members[] = array(
                    "id" => $onePerTenMembers[0]->getId(),
                    "nombre" => $onePerTenMembers[0]->getNombre(),
                    "telefono" => $onePerTenMembers[0]->getTelefono(),
                    "idCentro" => $onePerTenMembers[0]->getCodCentro(),
                    "centro" => $onePerTenMembers[0]->getNombreCentro()
                );
            }
        }

        $formSearchOne = $this->createForm(new OnePerTenType);
        return $this->render('PequivenSEIPBundle:Sip:onePerTen\show.html.twig', array(
                    "form" => $formSearchOne->createView(),
                    "user" => $user,
                    "members" => $members
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

    protected function getCneService() {
        return $this->container->get('seip.service.apiCne');
    }

}
