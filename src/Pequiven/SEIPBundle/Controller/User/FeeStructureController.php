<?php

namespace Pequiven\SEIPBundle\Controller\User;

use Pequiven\SEIPBundle\Controller\SEIPController;
use Symfony\Component\HttpFoundation\Request;
use Pequiven\SEIPBundle\Entity\User\FeeStructure;
use Pequiven\SEIPBundle\Entity\User\MovementFeeStructure;
use Pequiven\SEIPBundle\Form\User\MovementFeeStructureInType;
use Pequiven\SEIPBundle\Form\User\MovementFeeStructureOutType;
use Pequiven\SEIPBundle\Form\User\CreateFeeStructureType;

/**
 * GESTION EN LA ESTRUCTURA DE CARGOS SEIP
 */
class FeeStructureController extends SEIPController {

    public function showAction(Request $request) {

        $array = array();
        $structure = array();
        $em = $this->getDoctrine()->getManager();
        $gerencias = $em->getRepository('PequivenMasterBundle:Gerencia')->getgerencias();

        if ($request->get('gerencia') != null) {
            $gerencia = $request->get('gerencia');
        } else {
            if($this->getUser()->getGerencia()){
            $gerencia = $this->getUser()->getGerencia()->getid();            }
            else{
                $this->get('session')->getFlashBag()->add('error', "Usted no se Encuentra Asignado a Ninguna Gerencia de Primera Línea");
                $gerencia='NO TIENE';
            }
            
        }

        $gerenciaobj = $em->getRepository('PequivenMasterBundle:Gerencia')->findOneById($gerencia);
        $feestructure = new FeeStructure();
        $formCreate = $this->createForm(new CreateFeeStructureType($gerencia), $feestructure);
        $formCreate->handleRequest($request);

        $Gte = $this->get('pequiven_seip.repository.feestructure')->getGerente($gerencia);

        if ($Gte != null) {
            foreach ($Gte as $g) {
                $Gerente = $g;
            }
            $array[] = $this->getRepository()->find($Gerente->getid());
            $structure = $this->GenerateTree($Gerente->getid(), $array);
        }

        return $this->render('PequivenSEIPBundle:User:FeeStructure/show.html.twig', array(
                    'user' => $this->getUser(),
                    'gerencias' => $gerencias,
                    'structure' => $structure,
                    'form_create' => $formCreate->createView(),
                    'gerencia_ant' => $gerenciaobj
        ));
    }

    /**
     * GENERA EL ARBOL DE SUBORDINADOS EN LA ESTRUCTURA ORGANIZATIVA
     * @param type $padre
     * @param type $array
     * @return type
     */
    public function GenerateTree($padre, $array) {

        $children = $this->get('pequiven_seip.repository.feestructure')->getChildren($padre);

        if ($children == null) {
            return $array;
        }

        foreach ($children as $child) {
            $array[] = $child;
            $array = $this->GenerateTree($child->getid(), $array);
        }

        return $array;
    }

    /**
     * Insert
     * @return type
     */
    public function assignAction(Request $request) {

        $period = $this->getPeriodService()->getPeriodActive(true);

        $movementFeeStructure = new MovementFeeStructure();
        $form = $this->createForm(new MovementFeeStructureInType(), $movementFeeStructure);

        $structure = $this->get('pequiven_seip.repository.feestructure')->find($request->get('id'));

        if (isset($request->get('fee_structure_add')["_token"])) {
            $em = $this->getDoctrine()->getManager();
            $form->bind($this->getRequest());
            $movementFeeStructure = $form->getData();

            $movementFeeStructure->setPeriod($period);
            $movementFeeStructure->setType('I');
            $movementFeeStructure->setCreatedBy($this->getUser());
            $movementFeeStructure->setFeestructure($structure);

            if ($request->get('fee_structure_add_encargado')) {
                $encargado = 1;
            } else {
                $encargado = 0;
            }

//Asignación de Usuario
            $UserAssigned = $request->get('fee_structure_add')["User"];
            $UserAssigned = $this->get('pequiven.repository.user')->find($UserAssigned);
            $structure->setUser($UserAssigned); //Actualización de Cargo
            $structure->setEncargado($encargado); //Actualización de Cargo

            $em->persist($movementFeeStructure);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Cargo Asignado Exitosamente.');
            die();
        } elseif ($structure->getUser() != null) {
            echo "El Cargo ya esta Asignado!";
            die();
        } else {
            $formAction = "form_fee_structure_assign";
            $check = $user = true;
            $view = $this
                    ->view()
                    ->setTemplate($this->config->getTemplate('_form.html'))
                    ->setTemplateVar($this->config->getPluralResourceName())
                    ->setData(array(
                'formAction' => $formAction,
                'user' => $user,
                'check' => $check,
                'form' => $form->createView(),
                    ))
            ;
            $view->getSerializationContext()->setGroups(array('id', 'api_list'));
            return $view;
        }
    }

    /**
     * Remove
     * @return type
     */
    public function removeAction(Request $request) {

        $period = $this->getPeriodService()->getPeriodActive(true);

        $movementFeeStructure = new MovementFeeStructure();
        $form = $this->createForm(new MovementFeeStructureOutType(), $movementFeeStructure);

        $structure = $this->get('pequiven_seip.repository.feestructure')->find($request->get('id'));

        if (isset($request->get('fee_structure_add')["_token"])) {
            $em = $this->getDoctrine()->getManager();

            $form->bind($this->getRequest());
            $movementFeeStructure = $form->getData();

            $movementFeeStructure->setPeriod($period);
            $movementFeeStructure->setType('O');
            $movementFeeStructure->setCreatedBy($this->getUser());
            $movementFeeStructure->setFeestructure($structure);

//Asignación de Usuario
            $UserAssigned = NULL;
            $structure->setUser($UserAssigned); //Actualización de Cargo
            $structure->setEncargado($UserAssigned); //

            $em->persist($movementFeeStructure);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Cargo Removido Exitosamente.');
            die();
        } elseif ($structure->getUser() === null) {
            echo "El Cargo no esta Asignado!";
            die();
        } else {
            $formAction = "form_fee_structure_remove";
            $check = $user = false;
            $view = $this
                    ->view()
                    ->setTemplate($this->config->getTemplate('_form.html'))
                    ->setTemplateVar($this->config->getPluralResourceName())
                    ->setData(array(
                'formAction' => $formAction,
                'user' => $user,
                'check' => $check,
                'form' => $form->createView(),
                    ))
            ;
            $view->getSerializationContext()->setGroups(array('id', 'api_list'));
            return $view;
        }
    }

    /**
     * 
     * @param Request $request
     * @return type
     */
    public function CreateAction(Request $request) {

        $array = array();
        $structure = array();

        //DATOS AUDITORIA
        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();

        if ($request->get('gerencia') != null) {
            $gerencia = $request->get('gerencia');
        }

        $gerenciaobj = $em->getRepository('PequivenMasterBundle:Gerencia')->findOneById($gerencia);
        $feestructure = new FeeStructure();
        $formCreate = $this->createForm(new CreateFeeStructureType($gerencia), $feestructure);
        $formCreate->handleRequest($request);

        if (($formCreate->isSubmitted()) && ($request->get("feestructurecreate")["charge"] != '')) {

            //DATOS DEL FORMULARIO

            if ($request->get("feestructurecreate")["gerenciasecond"] == '') {
                $gerenciaform2 = null;
            } else {
                $gerenciaform2 = $request->get("feestructurecreate")["gerenciasecond"];
            }

            if ($request->get("feestructurecreate")["coordinacion"] == '') {
                $coord = null;
            } else {
                $coord = $request->get("feestructurecreate")["coordinacion"];
            }

            if (isset($request->get("feestructurecreate")["staff"])) {
                $staff = 1;
            } else {
                $staff = 0;
            }

            $repeat = $request->get('repeat');
            $charge = $request->get("feestructurecreate")["charge"];
            $parent = $request->get("feestructurecreate")["parent"];

            //INSTANCIACION DE OBJETOS            
            $complejoobj = $gerenciaobj->getcomplejo();
            $gerencia2obj = $em->getRepository('PequivenMasterBundle:GerenciaSecond')->findOneById($gerenciaform2);
            $coordobj = $em->getRepository('PequivenMasterBundle:Coordinacion')->findOneById($coord);
            $parentobj = $this->getRepository()->findOneById($parent);

            for ($i = 1; $i <= $repeat; $i++) {
                $feestructure = new FeeStructure();
                $feestructure->setComplejo($complejoobj);
                $feestructure->setGerencia($gerenciaobj);
                if ($gerencia2obj != null) {
                    $feestructure->setGerenciasecond($gerencia2obj);
                }
                if ($coordobj != null) {
                    $feestructure->setCoordinacion($coordobj);
                }
                $feestructure->setCharge($charge);
                $feestructure->setParent($parentobj);
                $feestructure->setStaff($staff);
                $feestructure->setEnabled(1);
                $feestructure->setEncargado(0);
                $em->persist($feestructure);
            }

            try {
                $em->flush();
                $em->getConnection()->commit();
            } catch (Exception $e) {
                $em->getConnection()->rollback();
                throw $e;
            }
        }

        $Gte = $this->get('pequiven_seip.repository.feestructure')->getGerente($gerencia);

        if ($Gte != null) {
            foreach ($Gte as $g) {
                $Gerente = $g;
            }
            $array[] = $this->getRepository()->find($Gerente->getid());
            $structure = $this->GenerateTree($Gerente->getid(), $array);
        }

        return $this->redirect($this->generateUrl('pequiven_user_feestructure', array('gerencia' => $gerencia)));
    }

    /**
     *  Period
     *
     */
    protected function getPeriodService() {
        return $this->container->get('pequiven_seip.service.period');
    }

}
