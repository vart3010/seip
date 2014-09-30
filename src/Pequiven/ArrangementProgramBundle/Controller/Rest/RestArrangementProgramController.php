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
        $data = $timelines[0]->getGoals();
        $view = $this->view();
        $result = array(
            'data' => $data,
        );
        $view->setData($result);
        $view->getSerializationContext()->setGroups(array('id','api_list','goalDetails'));
        $view->setTemplate("PequivenArrangementProgramBundle:Rest:ArrangementProgram/form.html.twig");
        return $view;
    }
    
    /**
     * @Annotations\Put("/{id}/goals-details.{_format}/{slug}",name="put_arrangementprogram_rest_restarrangementprogram_putgoalsdetails",requirements={"_format"="html|json|xml"},defaults={"_format"="html"})
     */
    function putGoalsDetailsAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PequivenArrangementProgramBundle:ArrangementProgram')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ArrangementProgram entity.');
        }
        $timelines = $entity->getTimelines();
        $data = $timelines[0]->getGoals();
        $view = $this->view();
        $result = array(
            'data' => $data,
        );
        $view->setData($result);
        $view->getSerializationContext()->setGroups(array('id','api_list','goalDetails'));
        $view->setTemplate("PequivenArrangementProgramBundle:Rest:ArrangementProgram/form.html.twig");
        return $view;
    }
}
