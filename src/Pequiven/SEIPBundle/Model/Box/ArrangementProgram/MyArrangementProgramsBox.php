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
        
        $period = $this->container->get('pequiven.repository.period')->findOneActive();
        $criteria['ap.period'] = $period;
        $criteria['ap.user'] = $this->getUser();
        
        $resources = $repository->createPaginatorByAssignedResponsibles($criteria,$orderBy);
        return array(
            'result'  => $resources->toArray()
        );
    }

    public function getTemplateName() {
        return 'PequivenSEIPBundle:Monitor:ArrangementProgram/myArrangementPrograms.html.twig';
    }

}
