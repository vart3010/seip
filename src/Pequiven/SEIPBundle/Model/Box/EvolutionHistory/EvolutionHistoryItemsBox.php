<?php

namespace Pequiven\SEIPBundle\Model\Box\EvolutionHistory;

/**
 * Muestra los historicos del Informe de Evolución
 *
 * @author Maximo Sojo
 */
class EvolutionHistoryItemsBox extends \Tecnocreaciones\Bundle\BoxBundle\Model\GenericBox {

    public function getName() {
        return 'pequiven_seip_box_evolution_items';
    }

    public function getParameters() {
        
    }

    public function getTranslationDomain() {
        return 'PequivenSEIPBundle';
    }

    public function getDescription() {
        return 'Muestra los diferentes Historicos del Informe de Evolution';
    }

    public function getTemplateName() {
        return 'PequivenSIGBundle:Template:Box\EvolutionHistory.html.twig';
    }

    public function getAreasNotPermitted() {
        return array(
        );
    }

    /**
     * 
     * @return \Pequiven\SEIPBundle\Service\PeriodService
     */
    protected function getPeriodService() {
        return $this->container->get('pequiven_seip.service.period');
    }

    protected function getSecurityService() {
        return $this->container->get('seip.service.security');
    }

    /**
     * 
     * @return type
     */
    public function getResultService() {
        return $this->container->get('seip.service.result');
    }

}
