<?php

namespace Pequiven\ArrangementProgramBundle\Controller;

use DateTime;
use Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram;
use Pequiven\ArrangementProgramBundle\Entity\Timeline;
use Pequiven\SEIPBundle\Controller\SEIPController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sylius\Bundle\ResourceBundle\Event\ResourceEvent;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class MovementEmployeeControler extends SEIPController {

    public function showAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $workStudyCircle = $em->getRepository('PequivenSEIPBundle:Politic\WorkStudyCircle')->findOneBy(array('id' => $request->get("id")));

//        $proposals = $em->getRepository('PequivenSEIPBundle:Politic\Proposal')->findBy(array('workStudyCircle' => $workStudyCircle->getId()));
        $proposals = $workStudyCircle->getProposals();
        $meetings = $workStudyCircle->getMeeting();

        $user = $this->getUser();

        return $this->render('PequivenSEIPBundle:Politic:WorkStudyCircle\show.html.twig', array(
                    'workStudyCircle' => $workStudyCircle,
                    'userData' => $user,
                    'proposals' => $proposals,
                    'meetings' => $meetings,
                    'user' => $user
        ));
    }
    
    public function getUrlMovementAction(Request $request) {
        var_dump($request);
        
    }

}
