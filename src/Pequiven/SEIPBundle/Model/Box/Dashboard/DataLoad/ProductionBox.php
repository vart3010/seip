<?php

namespace Pequiven\SEIPBundle\Model\Box\Dashboard\DataLoad;

/**
 * Muestra la base para el dashboard de Producción
 *
 */
class ProductionBox extends \Tecnocreaciones\Bundle\BoxBundle\Model\GenericBox
{
    public function getName() {
        return 'dashboard_data_load_production';
    }

    public function getParameters() 
    {
        //Obtenemos los ReportsTemplates que tiene el usuario disponible para ver (A menos que tenga el rol ROLE_SEIP_OPERATION_REPORT_TEMPLATES_ALL)
        $repositoryReportTemplate = $this->container->get('pequiven.repository.report_template');
        $user = $this->getUser();
        
        if($this->isGranted(array('ROLE_SEIP_OPERATION_REPORT_TEMPLATES_ALL'))){
            $reportTemplates = $repositoryReportTemplate->findAll();
        } else{
            $reportTemplates = $user->getReportTemplates();
        }
        
        
        
        return array(
            'reportTemplates'  => $reportTemplates
        );
    }

    public function getTemplateName() {
        return 'PequivenSEIPBundle:Monitor:Dashboard\DataLoad\Production.html.twig';
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
        return 'Base donde se manejan los dashboards de producción';
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
