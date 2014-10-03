<?php

namespace Pequiven\ArrangementProgramBundle\Controller\Rest;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations;

/**
 * Controlador rest de los programas de gestion
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 * @Route("/api/arrangement-program")
 */
class RestArrangementProgramController extends FOSRestController
{
    /**
     * @Annotations\Get("/{id}/goals-details.{_format}",name="get_arrangementprogram_rest_restarrangementprogram_putgoalsdetails",requirements={"_format"="html|json|xml"},defaults={"_format"="html"})
     */
    function getGoalsDetailsAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PequivenArrangementProgramBundle:ArrangementProgram')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ArrangementProgram entity.');
        }
        $timelines = $entity->getTimelines();
        $data = array();
        foreach ($timelines[0]->getGoals() as $goal) {
            $data[] = $goal->getGoalDetails();
        }
        $view = $this->view();
        $result = array(
            'data' => $data,
            'success' => true,
            'total' => count($data)
        );
        $view->setData($result);
        $view->getSerializationContext()->setGroups(array('id','api_list','goal','goalDetails'));
        $view->setTemplate("PequivenArrangementProgramBundle:Rest:ArrangementProgram/form.html.twig");
        return $view;
    }
    
    /**
     * @Annotations\Put("/{id}/goals-details.{_format}/{slug}",name="put_arrangementprogram_rest_restarrangementprogram_putgoalsdetails",requirements={"_format"="html|json|xml"},defaults={"_format"="html"})
     */
    function putGoalsDetailsAction($id,Request $request,$slug) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PequivenArrangementProgramBundle:GoalDetails')->find($slug);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GoalDetails entity.');
        }
        $form = $this->createForm(new \Pequiven\ArrangementProgramBundle\Form\GoalDetailsType(),$entity);
        $dataRequest = $request->request->all();
        
        unset($dataRequest['id']);
        unset($dataRequest['null']);
        
        $form->submit($dataRequest,false);
//        var_dump($dataRequest);
        $success = false;
        if($form->isValid()){
            $success = true;
            $em->persist($entity);
            $em->flush();
        }else{
            $entity = $form;
        }
        
        $view = $this->view();
        $result = array(
            'data' => $entity,
            'success' => $success,
            'total' => 1,
            'messages' => 'Exitooooo'
        );
        $view->setData($result);
        $view->getSerializationContext()->setGroups(array('id','api_list','goalDetails'));
        $view->setTemplate("PequivenArrangementProgramBundle:Rest:ArrangementProgram/form.html.twig");
        return $view;
    }
}
