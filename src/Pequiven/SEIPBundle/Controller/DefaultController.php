<?php

namespace Pequiven\SEIPBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController as baseController;

class DefaultController extends Controller {

    /** Página Principal del Sistema
     * @Route("/")
     * @Template()
     */
    public function indexAction() {
        return array(
        );
    }
    
    /**
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return type
     * @Route("/{period}/change-period",name="seip_change_period")
     */
    public function changePeriodAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $referer = $request->get('referer',null);
        $periodId = $request->get('period',null);
        
        $periodRepository = $this->get('pequiven.repository.period');
        $period = $periodRepository->find($periodId);
        $periodService = $this->getPeriodService();
        if($period){
            $periodService->setPeriodActive($period);
        }
        return $this->redirect($referer);
    }
    
    /**
     * @return \Pequiven\SEIPBundle\Service\PeriodService
     */
    public function getPeriodService()
    {
        return $this->get('pequiven_arrangement_program.service.period');
    }
}
