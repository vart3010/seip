<?php

namespace Pequiven\SEIPBundle\Model\Box\ArrangementProgram;

use Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram;
use Pequiven\MasterBundle\Entity\Rol;
use Tecnocreaciones\Bundle\BoxBundle\Model\GenericBox;

/**
 * Resumen de los programas de gestion que tengo pendiente por aprobar
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
class SummaryBox extends GenericBox 
{
    public function getName() {
        return 'pequiven_seip_box_arrangementprogram_summary';
    }
    
    public function getTemplateName() {
        return 'PequivenSEIPBundle:Monitor:ArrangementProgram/summary.html.twig';
    }
    
    public function getParameters() {
        $repository = $this->get('pequiven_seip.repository.arrangementprogram');
        
        $summaryTactical = $repository->findGroupByType(ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_TACTIC);
        $summaryOperative = $repository->findGroupByType(ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_OPERATIVE);
        
        return array(
            'summaryTactical' => $summaryTactical,
            'summaryOperative' => $summaryOperative,
        );
    }
    
    public function hasPermission() {
        return $this->isGranted(array(Rol::getRoleName(Rol::ROLE_MANAGER_SECOND)));
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
        return 'Genera un resumen de los programas de gestion que el usuario tiene pendiente por aprobar.';
    }
}