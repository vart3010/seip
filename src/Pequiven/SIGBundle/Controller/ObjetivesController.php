<?php

namespace Pequiven\SIGBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ObjetivesController extends Controller
{
    public function strategicAction()
    {
        return $this->render('PequivenSIGBundle:Objetives:list.html.twig');
    }
   
}