<?php

namespace Pequiven\SEIPBundle\Controller\Politic;

use DateTime;
use Pequiven\SEIPBundle\Controller\SEIPController;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Pequiven\SEIPBundle\Entity\Politic\Meeting;
use Pequiven\SEIPBundle\Form\Politic\MeetingType;
use Pequiven\SEIPBundle\Entity\Politic\Assistance;

/**
 * Controlador de reuniones de estudio de trabajo
 *
 */
class MeetingController extends SEIPController {

    public function createAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $idWorkStudyCircle = $request->get('workStudyCircle_id');
        $workStudyCircle = $em->getRepository('PequivenSEIPBundle:Politic\WorkStudyCircle')->findOneBy(array('id' => $idWorkStudyCircle));

        $meeting = new Meeting();
        $form = $this->createForm(new MeetingType, $meeting);
        $form->handleRequest($request);

        $user = $this->getUser();
        $em->getConnection()->beginTransaction();

        if ($form->isSubmitted() && $form->isValid()) {
            $date = $request->get("meeting_data")["date"];
            $date = str_replace("/", "-", $date);
            $date = new \DateTime($date);


            $meetingObj = new Meeting();
            $meetingObj->setCreatedBy($user);
            $meetingObj->setDate($date);
            $meetingObj->setPlace($request->get("meeting_data")["place"]);
            $meetingObj->setSubject($request->get("meeting_data")["subject"]);
            $meetingObj->setObservation($request->get("meeting_data")["observation"]);
            $meetingObj->setWorkStudyCircle($workStudyCircle);
            $em->persist($meetingObj);

            //SE AGREGAN LOS MIEMBROS A LA LISTA DE ASISTENCIA DE LA REUNION CON ASSISTENCIA = FALSE 
            $members = $workStudyCircle->getUserWorkerId();
            foreach ($members as $member) {
                $assistance = new Assistance();
                $assistance->setUser($member);
                $assistance->setMeeting($meetingObj);
                $em->persist($assistance);
            }


            $em->flush();

            try {
                $em->flush();
                $em->getConnection()->commit();
            } catch (Exception $e) {
                $em->getConnection()->rollback();
                throw $e;
            }

            $this->get('session')->getFlashBag()->add('success', 'Reunión Guardada Correctamente');

            return $this->redirect($this->generateUrl('pequiven_meeting_view', array("meeting_id" => $meetingObj->getId())));
        }


        return $this->render('PequivenSEIPBundle:Politic:Meeting\create.html.twig', array(
                    'form' => $form->createView(),
                    "workStudyCircle" => $workStudyCircle
        ));
    }

    public function viewAcction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $idMeeting = $request->get("meeting_id");
        $meeting = $em->getRepository('PequivenSEIPBundle:Politic\Meeting')->findOneBy(array('id' => $idMeeting));
        $workStudyCircle = $meeting->getWorkStudyCircle();
        
        $idCircle = $workStudyCircle->getId();//Id Circulo

        $members = $workStudyCircle->getUserWorkerId();

        $assistance = $meeting->getAssistances();
        $assistanceIds = array();
        foreach ($assistance as $assis) {
            $assistanceIds[$assis->getUser()->getId()] = $assis->getAssistance();
        }


        return $this->render('PequivenSEIPBundle:Politic:Meeting\view.html.twig', array(
                    'meeting' => $meeting,
                    'members' => $members,
                    'workStudyCircle' => $workStudyCircle,
                    'assistanceIds' => $assistanceIds,
                    'user'=>$this->getUser()
        ));
    }

    public function editAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $idMeeting = $request->get("meeting_id");
        $meeting = $em->getRepository('PequivenSEIPBundle:Politic\Meeting')->findOneBy(array('id' => $idMeeting));

        $workStudyCircle = $meeting->getWorkStudyCircle();

        $form = $this->createForm(new MeetingType, $meeting);
        $form->handleRequest($request);
        
        $em->getConnection()->beginTransaction();
         
        if ($form->isSubmitted() && $form->isValid()) {
            $date = $request->get("meeting_data")["date"];
            $date = str_replace("/", "-", $date);
            $date = new \DateTime($date);


            $meetingObj = $meeting;
            $meetingObj->setDate($date);
            $meetingObj->setPlace($request->get("meeting_data")["place"]);
            $meetingObj->setSubject($request->get("meeting_data")["subject"]);
            $meetingObj->setObservation($request->get("meeting_data")["observation"]);
            $meetingObj->setWorkStudyCircle($workStudyCircle);
            $em->persist($meetingObj);

            $em->flush();

            try {
                $em->flush();
                $em->getConnection()->commit();
            } catch (Exception $e) {
                $em->getConnection()->rollback();
                throw $e;
            }

            $this->get('session')->getFlashBag()->add('success', 'Reunión Guardada Correctamente');

            return $this->redirect($this->generateUrl('pequiven_work_study_circle_show', array("id" => $workStudyCircle->getId())));
        }


        return $this->render('PequivenSEIPBundle:Politic:Meeting\edit.html.twig', array(
                    'meeting' => $meeting,
                    'form' => $form->createView()
        ));
    }

}
