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
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @Route("/test",name="seip_change_period_test")
     */
    public function testAction(\Symfony\Component\HttpFoundation\Request $request )
    {
        $sequenceGenerator = $this->getSequenceGenerator();
//        $indicator = $this->get('pequiven.repository.indicator')->find('14');
        $indicator = $this->get('pequiven.repository.indicator')->find('65');
        $next = $sequenceGenerator->getNextRefChildIndicator($indicator);
        var_dump($next);
    }
    
    /**
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @Route("/testObjetive",name="seip_objetive_test")
     */
    public function testObjetiveAction(\Symfony\Component\HttpFoundation\Request $request )
    {
        $sequenceGenerator = $this->getSequenceGenerator();
//        $indicator = $this->get('pequiven.repository.objetive')->find('37');
        $indicator = $this->get('pequiven.repository.objetive')->find('20');
        $ref = $sequenceGenerator->getNextRefChildObjetive($indicator);
        var_dump($ref);
        
    }
    
    /**
     * @return \Pequiven\SEIPBundle\Service\PeriodService
     */
    public function getPeriodService()
    {
        return $this->get('pequiven_arrangement_program.service.period');
    }
    
    /**
     * 
     * @return \Pequiven\SEIPBundle\Service\SequenceGenerator
     */
    private function getSequenceGenerator() 
    {
        return $this->get('seip.sequence_generator');
    }
}
