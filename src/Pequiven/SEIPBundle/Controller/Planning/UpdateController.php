<?php

namespace Pequiven\SEIPBundle\Controller\Planning;

use Pequiven\SEIPBundle\EventListener\SeipEvents;
use Sylius\Bundle\ResourceBundle\Event\ResourceEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Controlador para lanzar eventos y actualizar resultados
 *
 * @author inhack20
 */
class UpdateController extends Controller
{
    /**
     * Actualiza los resultados de los programas de gestion (Falta optimizar)
     * @return \Symfony\Component\HttpFoundation\Response
     */
    function updateResultArrangementProgramAction()
    {
        ini_set('max_execution_time', 300); //300 seconds = 5 minutes
        $period = $this->getPeriodService()->getPeriodActive();
        $arrangementprograms = $this->get('pequiven_seip.repository.arrangementprogram')->findAllWithData(array(
            'period' => $period,
        ));
        $em = $this->getDoctrine()->getManager();
        foreach ($arrangementprograms as $arrangementprogram) {
            $summary = $arrangementprogram->getSummary(array(
            'limitMonthToNow' => true
            ));
            $arrangementprogram->setProgressToDate($summary['advances']);
            $summary = $arrangementprogram->getSummary();
            $arrangementprogram->setTotalAdvance($summary['advances']);
            
            $em->persist($arrangementprogram);
            $this->get('event_dispatcher')->dispatch(SeipEvents::RESULT_ARRANGEMENT_PROGRAM_UPDATE,new ResourceEvent($arrangementprogram));
        }
        $em->flush();
        return new \Symfony\Component\HttpFoundation\Response('OK');
    }
    
    /**
     * Actualiza el resultado de los objetivos
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return type
     */
    function updateResultOfObjetiveAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $id = $request->get('id',null);
        $referral = $request->get('referral',null);
        $respository = $this->get('pequiven.repository.objetive');
        $objetives = array();
        if($id != null){
            $objetives[] = $respository->find($id);
        }else{
//            $objetives[] = $respository->find($id);
        }
        $resultService = $this->getResultService();
        $resultService->updateResultOfObjects($objetives);
        
        $flashBag = $this->getRequest()->getSession()->getFlashBag();
        $flashBag->add('success',  $this->trans('pequiven.result.success.update',array(),'flashes'));
        if($id > 0){
            return $this->redirect($referral);
        }
    }
    
    /**
     * Actualiza los resultados de los indicadores
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return type
     */
    function updateResultOfIndicatorAction(\Symfony\Component\HttpFoundation\Request $request) 
    {
        $id = $request->get('id',null);
        $referral = $request->get('referral',null);
        $respository = $this->get('pequiven.repository.indicator');
        $objects = array();
        if($id != null){
            $objects[] = $respository->find($id);
        }else{
//            $objetives[] = $respository->find($id);
        }
        $resultService = $this->getResultService();
        foreach ($objects as $indicator) {
            $resultService->refreshValueIndicator($indicator);
        }
        
        $flashBag = $this->getRequest()->getSession()->getFlashBag();
        $flashBag->add('success',  $this->trans('pequiven.result.success.update',array(),'flashes'));
        
        if($id > 0){
            return $this->redirect($referral);
        }
    }
    
    /**
     * Actualiza los resultados de los programas de gestion
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return type
     */
    function updateResultOfArrangementProgramAction(\Symfony\Component\HttpFoundation\Request $request) 
    {
        $id = $request->get('id',null);
                
        $referral = $request->get('referral',null);
        $respository = $this->get('pequiven_seip.repository.arrangementprogram');
        $objects = array();
        if($id != null){
            $objects[] = $respository->find($id);
        }else{
//            $objetives[] = $respository->find($id);
        }
        $resultService = $this->getResultService();
        foreach ($objects as $object) {
            $resultService->refreshValueArrangementProgram($object);
        }
        
        $flashBag = $this->getRequest()->getSession()->getFlashBag();
        $flashBag->add('success',  $this->trans('pequiven.result.success.update',array(),'flashes'));
        
        if($id > 0){
            return $this->redirect($referral);
        }
    }
    
    protected function trans($id,array $parameters = array(), $domain = 'messages')
    {
        return $this->get('translator')->trans($id, $parameters, $domain);
    }
    
    /**
     * Servicio que calcula los resultados
     * @return \Pequiven\SEIPBundle\Service\ResultService
     */
    public function getResultService()
    {
        return $this->container->get('seip.service.result');
    }
    
    /**
     * 
     * @return \Pequiven\SEIPBundle\Service\PeriodService
     */
    protected function getPeriodService()
    {
        return $this->container->get('pequiven_seip.service.period');
    }
}
