<?php

namespace Pequiven\MasterBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Pequiven\MasterBundle\Entity\LineStrategic;
use Pequiven\SEIPBundle\Controller\SEIPController;
/**
 * Description of LineStrategicController
 *
 */
class LineStrategicController extends SEIPController {
    
    
    /**
     * Retorna el Tablero con las Líneas Estratégicas definidas en el SEIP
     * @param Request $request
     * @return type
     */
    public function viewDashboardAction(Request $request){
        $boxRender = $this->get('tecnocreaciones_box.render');        
        
        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('Dashboard/viewDashboard.html'))
                ->setData(array(
                    'boxRender' => $boxRender
                ))
                ;
        
        return $this->handleView($view);
    }
    
}

