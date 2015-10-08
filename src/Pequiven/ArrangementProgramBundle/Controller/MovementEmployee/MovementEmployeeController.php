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
        $form1 = $this->createForm(new RemoveGoalType(), $MovementEmployee);

        //FORMULARIO DE DETALLES
        $formassigndetails = $this->createForm(new AssignGoalDetailsType(), $MovementEmployeeDetails);
        $formremovedetails = $this->createForm(new RemoveGoalDetailsType($id), $MovementEmployeeDetails);

        return $this->render('PequivenArrangementProgramBundle:MovementEmployee:show.html.twig', array(
                    'goal' => $entity,
                    'user' => $this->getUser(),
                    'form' => $form->createView(),
                    'form1' => $form1->createView(),
                    'formassigndetails' => $formassigndetails->createView(),
                    'formremovedetails' => $formremovedetails->createView()
        ));
    }

}
