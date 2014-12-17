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
    
    function updateResultOfObjetive()
    {
        
    }
}
