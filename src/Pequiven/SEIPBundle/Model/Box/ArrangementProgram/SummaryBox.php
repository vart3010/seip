<?php

namespace Pequiven\SEIPBundle\Model\Box\ArrangementProgram;

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
        
        $summaryTactical = $repository->findGroupByType(\Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_TACTIC);
        $summaryOperative = $repository->findGroupByType(\Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_OPERATIVE);
        
        return array(
            'summaryTactical' => $summaryTactical,
            'summaryOperative' => $summaryOperative,
        );
    }

}