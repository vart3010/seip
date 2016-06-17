<?php

namespace Pequiven\SEIPBundle\Model\Box\ArrangementProgram;

use Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram;
use Pequiven\MasterBundle\Entity\Rol;
use Tecnocreaciones\Bundle\BoxBundle\Model\GenericBox;

/**
 * Resumen de los programas de gestion que tengo pendiente por aprobar
 *
 * @author Matias Jimenez
 */
class SummaryTotalBox extends GenericBox 
{
    public function getName() {
        return 'pequiven_seip_box_arrangementprogram_summary_total';
    }
    
    public function getTemplateName() {
        return 'PequivenSEIPBundle:Monitor:ArrangementProgram/summaryTotal.html.twig';
    }
    
    public function getParameters() {
        
        $summary = $this->getSummary();
        
        return array(
            'summary' => $summary,
        );
    }
    
    public function getSummary(){
        $criteria = array();
        $summary = array();
        $criteria['gerencia'] = $this->getRequest()->get("idGerencia");
        $repository = $this->get('pequiven_seip.repository.arrangementprogram');
        
        //Cargados
        $criteria['type'] = ArrangementProgram::SUMMARY_TYPE_CHARGED;
        $summary['charged'] = $repository->getSummaryCharged($criteria);
        //Borrador
        $criteria['type'] = ArrangementProgram::SUMMARY_TYPE_BY_STATUS;
        $criteria['status'] = ArrangementProgram::STATUS_DRAFT;
        $summary['draft'] = $repository->getSummaryCharged($criteria);
        //En Revisión
        $criteria['status'] = ArrangementProgram::STATUS_IN_REVIEW;
        $summary['in_review'] = $repository->getSummaryCharged($criteria);
        //Revisado
        $criteria['status'] = ArrangementProgram::STATUS_REVISED;
        $summary['revised'] = $repository->getSummaryCharged($criteria);
        //Aprobados
        $criteria['status'] = ArrangementProgram::STATUS_APPROVED;
        $summary['approved'] = $repository->getSummaryCharged($criteria);
        //Rechazados
        $criteria['status'] = ArrangementProgram::STATUS_REJECTED;
        $summary['rejected'] = $repository->getSummaryCharged($criteria);
        //Finalizados
        $criteria['status'] = ArrangementProgram::STATUS_FINISHED;
        $summary['finished'] = $repository->getSummaryCharged($criteria);
        //Notificados
        $criteria['type'] = ArrangementProgram::SUMMARY_TYPE_NOTIFIED;
        $summary['notified'] = $repository->getNotified($criteria);
        //Por Notificar
        $criteria['type'] = ArrangementProgram::SUMMARY_TYPE_NOT_NOTIFIED;
        $summary['not_notified'] = $repository->getNotified($criteria);
        //Notificados pero con Proceso sin cerrar
        $criteria['type'] = ArrangementProgram::SUMMARY_TYPE_NOTIFIED_BUT_STILL_IN_PROGRESS;
        $summary['notified_but_still_in_progress'] = $repository->getNotified($criteria);
        
        return $summary;
    }
    
    public function hasPermission() {
        return $this->isGranted(array('ROLE_WORKER_PLANNING'));
    }
    
    public function getAreasNotPermitted() 
    {
        return array(
            \Pequiven\SEIPBundle\Model\Box\AreasBox::EVENTS
        );
    }
    
    public function getTranslationDomain() {
        return 'PequivenSEIPBundle';
    }
    
    public function getDescription() {
        return 'Genera un resumen de los programas de gestion por gerencia, con los status definidos en el sistema.';
    }
}