<?php

namespace Pequiven\TrelloBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('PequivenTrelloBundle:Default:index.html.twig', array('name' => $name));
    }
}
