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
    public function evolutionAction()
    {
        return $this->render('PequivenSIGBundle:ArrangementProgram:evolution.html.twig');
    }
}