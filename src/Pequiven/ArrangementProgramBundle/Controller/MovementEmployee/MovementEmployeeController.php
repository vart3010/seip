<?php

namespace Pequiven\ArrangementProgramBundle\Controller\MovementEmployee;

use DateTime;
use Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram;
use Pequiven\ArrangementProgramBundle\Entity\Goal;
use Pequiven\ArrangementProgramBundle\Entity\MovementEmployee\MovementDetails;
use Pequiven\ArrangementProgramBundle\Entity\MovementEmployee\MovementEmployee;
use Pequiven\ArrangementProgramBundle\Entity\Timeline;
use Pequiven\SEIPBundle\Controller\SEIPController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sylius\Bundle\ResourceBundle\Event\ResourceEvent;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Pequiven\ArrangementProgramBundle\Form\MovementEmployee\AssignGoalType;
use Pequiven\ArrangementProgramBundle\Form\MovementEmployee\RemoveGoalType;
use Pequiven\ArrangementProgramBundle\Form\MovementEmployee\AssignGoalDetailsType;
use Pequiven\ArrangementProgramBundle\Form\MovementEmployee\RemoveGoalDetailsType;
use Pequiven\ArrangementProgramBundle\Repository\MovementEmployee\MovementEmployeeRepository;

class MovementEmployeeController extends SEIPController {

    public function showAction(Request $request) {
        $id = $request->get('idGoal');

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('PequivenArrangementProgramBundle:Goal')->find($id);

        //INSTANCIACIÓN DE ENTIDADES
        $MovementEmployee = new MovementEmployee();
        $MovementEmployeeDetails = new MovementDetails();

        //FORMULARIO DE USUARIOS
        $form = $this->createForm(new AssignGoalType(), $MovementEmployee);
        $form1 = $this->createForm(new RemoveGoalType($id), $MovementEmployee);

        //FORMULARIO DE DETALLES
        $formassigndetails = $this->createForm(new AssignGoalDetailsType(), $MovementEmployeeDetails);
        $formremovedetails = $this->createForm(new RemoveGoalDetailsType(), $MovementEmployeeDetails);

        return $this->render('PequivenArrangementProgramBundle:MovementEmployee:show.html.twig', array(
                    'goal' => $entity,
                    'user' => $this->getUser(),
                    'form' => $form->createView(),
                    'form1' => $form1->createView(),
                    'formassigndetails' => $formassigndetails->createView(),
                    'formremovedetails' => $formremovedetails->createView()
        ));
    }

    public function assignAction(Request $request) {

        $id = $request->get('idGoal');

        $em = $this->getDoctrine()->getManager();
        $goal = $em->getRepository('PequivenArrangementProgramBundle:Goal')->findOneById($id);

        $details = new MovementDetails();
        $form = $this->createForm(new AssignGoalDetailsType(), $details);
        $form->handleRequest($request);

        $movement = new MovementEmployee();
        $formUser = $this->createForm(new AssignGoalType(), $movement);
        $formUser->handleRequest($request);

        $em->getConnection()->beginTransaction();

        if ($form->isSubmitted()) {

            //DATOS DE AssignGoalDetailsType
            $cause = $request->get("AssignGoalDetails")["cause"];
            $date = $request->get("AssignGoalDetails")["date"];
            $date = str_replace("/", "-", $date);
            $date = new \DateTime($date);
            $obs = $request->get("AssignGoalDetails")["observations"];

            //DATOS AUDITORIA
            $login = $this->getUser();

            //DATOS DE AssignGoalType
            $id_user = ($request->get("AssignGoal")["User"]);
            $user = $em->getRepository('PequivenSEIPBundle:User')->findOneById($id_user);

            //CARGO LOS DATOS DE DETALLE EN DB
            $details = new MovementDetails();
            $details->setCreatedBy($login);
            $details->setReal_advance($goal->getResultReal());
            $details->setAdvance($goal->getAdvance());
            $details->setBeforePenalty($goal->getresultBeforepenalty());
            $details->setDate($date);
            $details->setType('I');
            $details->setCause($cause);
            $details->setObservations($obs);
            $em->persist($details);

            //CARGO LOS DATOS DE MOVIMIENTO EN DB
            $movement = new MovementEmployee();
            $movement->setCreatedBy($login);
            $movement->setType('Goal');
            $movement->setUser($user);
            $movement->setGoal($goal);
            $movement->setPeriod($this->getPeriodService()->getPeriodActive());
            $movement->setIn($details);
            $em->persist($movement);

            //VALIDACIÓN DE INTEGRIDAD DE DATOS EN REGISTRO DE BD
            try {
                $em->flush();
                $em->getConnection()->commit();
            } catch (Exception $e) {
                $em->getConnection()->rollback();
                throw $e;
            }
        }

        return $this->redirect($this->generateUrl('goal_movement', array('idGoal' => $id)));
    }

    public function removeAction(Request $request) {
        $id = $request->get('idGoal');
        var_dump($id);
        die();
    }

}
