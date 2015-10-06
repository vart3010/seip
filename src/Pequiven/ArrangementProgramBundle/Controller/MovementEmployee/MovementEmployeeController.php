<?php

namespace Pequiven\ArrangementProgramBundle\Controller\MovementEmployee;

use DateTime;
use Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram;
use Pequiven\ArrangementProgramBundle\Entity\Goal;
use Pequiven\ArrangementProgramBundle\Entity\MovementEmployee\MovementDetails;
use Pequiven\ArrangementProgramBundle\Entity\Timeline;
use Pequiven\SEIPBundle\Controller\SEIPController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sylius\Bundle\ResourceBundle\Event\ResourceEvent;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class MovementEmployeeController extends SEIPController {

    public function showAction(Request $request) {
        $id=$request->get('idGoal');
        
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('PequivenArrangementProgramBundle:Goal')->find($id);
        
        return $this->render('PequivenArrangementProgramBundle:MovementEmployee:show.html.twig', array(
                    'goal' => $entity,
                    'user' => $this->getUser()
                    
        ));
    }

}
