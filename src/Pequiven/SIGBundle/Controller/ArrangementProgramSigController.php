<?php

namespace Pequiven\SIGBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Controlador ArrangementProgram SIG
 *
 * @author Maximo Sojo <maxsojo13@gmail.com>
 */
class ArrangementProgramSigController extends ResourceController
{
    public function evolutionAction(Request $request)
    {
    	$id = $request->get("id");
        $em = $this->getDoctrine()->getManager();
    	
    	$ArrangementProgram = $em->getRepository('PequivenArrangementProgramBundle:ArrangementProgram')->findWithData($id);

    	$view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('evolution.html'))
            ->setData(array(
                'ArrangementProgram'  => $ArrangementProgram,
            ));

        return $this->handleView($view);
    }
}