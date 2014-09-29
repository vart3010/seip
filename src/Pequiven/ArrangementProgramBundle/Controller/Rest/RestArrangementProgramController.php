<?php

namespace Pequiven\ArrangementProgramBundle\Controller\Rest;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\RestBundle\Controller\FOSRestController;

/**
 * Controlador rest de los programas de gestion
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 * @Route("/api/arrangement-program")
 */
class RestArrangementProgramController extends FOSRestController
{
    /**
     * 
     * @Route("/{id}/goals-details")
     */
    function getGoalsDetailsAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PequivenArrangementProgramBundle:ArrangementProgram')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ArrangementProgram entity.');
        }
        $view = $this->view();
        $view->setTemplate("PequivenArrangementProgramBundle:Rest:ArrangementProgram/form.html.twig");
        return $view;
    }
}
