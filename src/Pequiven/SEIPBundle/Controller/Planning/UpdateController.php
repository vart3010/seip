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
        $period = $this->container->get('pequiven.repository.period')->findOneActive();
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
        $indicatorService = $this->container->get('pequiven_indicator.service.inidicator');
        foreach ($objects as $indicator) {
            $indicatorService->calculateValueIndicator($indicator);
        }
        if($id > 0){
            return $this->redirect($referral);
        }
    }
    

    /**
     * Servicio que calcula los resultados
     * @return \Pequiven\SEIPBundle\Service\ResultService
     */
    public function getResultService()
    {
        return $this->container->get('seip.service.result');
    }
}
