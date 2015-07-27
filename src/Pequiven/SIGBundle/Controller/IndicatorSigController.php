<?php

namespace Pequiven\SIGBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
#use Pequiven\SEIPBundle\Controller\SEIPController;

#use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
#use Pequiven\IndicatorBundle\Entity\Indicator;
#use Pequiven\IndicatorBundle\Entity\IndicatorLevel;
#use Pequiven\ArrangementBundle\Entity\ArrangementRange;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController as baseController;

class IndicatorSigController extends Controller
{
    /*
    *Listado de IndicadoresEstrategicos
    *
    */
    public function strategiclistAction()
    {
        return $this->render('PequivenSIGBundle:Indicators/Strategic:list.html.twig');
    }

    /*
    *Listado de IndicadoresTacticos
    *
    */
    public function tacticlistAction()
    {
        return $this->render('PequivenSIGBundle:Indicators/Tactic:list.html.twig');        
    }

    /*
    *Listado de IndicadoresOperativos
    *
    */
    public function operativelistAction()
    {
        return $this->render('PequivenSIGBundle:Indicators/Operative:list.html.twig');        
    }
   
}