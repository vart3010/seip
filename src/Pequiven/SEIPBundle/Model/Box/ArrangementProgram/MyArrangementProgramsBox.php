<?php

namespace Pequiven\SEIPBundle\Model\Box\ArrangementProgram;

/**
 * Muestra un resumen de mis programas de gestion
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
class MyArrangementProgramsBox extends \Tecnocreaciones\Bundle\BoxBundle\Model\GenericBox
{
    public function getName() {
        return 'pequiven_seip_box_my_arrangementprogram_summary';
    }

    public function getParameters() 
    {
        $criteria = array();
        $orderBy = array();
        $repository = $this->container->get('pequiven_seip.repository.arrangementprogram');
        
        $period = $this->getPeriodService()->getPeriodActive();
        $criteria['ap.period'] = $period;
        $criteria['ap.user'] = $this->getUser();
        
        $resources = $repository->createPaginatorByAssignedResponsibles($criteria,$orderBy);
        $resources->setMaxPerPage(5);
        return array(
            'result'  => $resources->toArray()
        );
    }

    public function getTemplateName() {
        return 'PequivenSEIPBundle:Monitor:ArrangementProgram/myArrangementPrograms.html.twig';
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
        return 'Muestra un resumen de los programas de gestión donde el usuario sea responsable de las metas o del programa.';
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
