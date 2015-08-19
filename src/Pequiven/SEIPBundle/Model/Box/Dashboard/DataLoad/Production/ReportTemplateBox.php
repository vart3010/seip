<?php

namespace Pequiven\SEIPBundle\Model\Box\Dashboard\DataLoad\Production;

/**
 * Muestra un resumen del reportTemplate especificado
 *
 */
class ReportTemplateBox extends \Tecnocreaciones\Bundle\BoxBundle\Model\GenericBox
{
    public function getName() {
        return 'dashboard_data_load_production_report_template';
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
        return 'PequivenSEIPBundle:Monitor:Dashboard/DataLoad/Production/ReportTemplate.html.twig';
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
        return 'Dashboard donde se muestra la data consolidada por Report Template';
    }
    
    /**
     * Servicio de la entidad período
     * @return \Pequiven\SEIPBundle\Service\PeriodService
     */
    protected function getPeriodService()
    {
        return $this->container->get('pequiven_seip.service.period');
    }
    
    /**
     * Servicio de la entidad Indicador
     * @return \Pequiven\IndicatorBundle\Service\IndicatorService
     */
    protected function getIndicatorService()
    {
        return $this->container->get('pequiven_indicator.service.inidicator');
    }
}
