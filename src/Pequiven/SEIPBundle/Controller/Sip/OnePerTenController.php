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
        $datos = array("nombre" => "", "centro" => "", "nameCentro" => "", "msj" => "");


        $user = $em->getRepository("\Pequiven\SEIPBundle\Entity\User")->findOneBy(array("identification" => $cedula));
        $onePerTen = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\OnePerTen")->findOneBy(array("user" => $request->get("idUserOne")));

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
                            $ced = explode("-", $userCne["cedula"]);

                            $datos["nombre"] = $userCne["nombre"];
                            $datos["cedula"] = $ced[1];
                            $datos["centro"] = "";
                            $datos["nameCentro"] = $userCne["centro"];
                        } else {
                            $nameCentro = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->getCentro($rep->getCodigoCentro());
                            $datos["nombre"] = $rep->getNombre();
                            $datos["cedula"] = $rep->getCedula();
                            $datos["centro"] = $rep->getCodigoCentro();
                            $datos["nameCentro"] = $nameCentro[0]["description"];
                        }
                    } else {
                        $nameCentro = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->getCentro($nomina->getCodigoCentro());
                        $datos["nombre"] = $nomina->getEmpleado();
                        $datos["cedula"] = $rep->getCedula();
                        $datos["centro"] = $nomina->getCodigoCentro();
                        $datos["nameCentro"] = $nameCentro[0]["description"];
                    }
                }
            } else {
                $datos["msj"] = "El usuario es Nómina Pequiven";
            }
        } else {
            $datos["msj"] = "El usuario ya esta agregado a tu 1x10";
        }

        $response->setData($datos);
        return $response;
    }

    public function saveAction(Request $request) {
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();

        //DATOS TEN
        $cedula = $request->get("cedula");
        $codCentro = $request->get("codCentro");
        $nombreCentro = $request->get("nombreCentro");
        $nombre = $request->get("nombre");
        $telefono = $request->get("telefono");

        $idUserOne = $request->get("idUserOne");

        $onePerTen = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\OnePerTen")->findOneBy(array("user" => $idUserOne));


        $em->getConnection()->beginTransaction();
//        //ONE
//        $onePerTen = new OnePerTen();
//        $onePerTen->setUser($user);
//        $onePerTen->setCedula($user->getIndentification());
//        $onePerTen->setCreatedBy($user);
//        $em->persist($onePerTen);
        //MEMBERS
        $onePerTenMembers = new OnePerTenMembers();
        $onePerTenMembers->setOne($onePerTen);
        $onePerTenMembers->setCedula($cedula);
        $onePerTenMembers->setNombre($nombre);
        $onePerTenMembers->setCodCentro($codCentro);
        $onePerTenMembers->setNombreCentro($nombreCentro);
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
