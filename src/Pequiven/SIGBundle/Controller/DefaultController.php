<?php

namespace Pequiven\SIGBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('PequivenSIGBundle:Default:index.html.twig', array('name' => $name));
    }
}
