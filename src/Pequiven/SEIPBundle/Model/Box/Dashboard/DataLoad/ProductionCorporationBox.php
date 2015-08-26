<?php

namespace Pequiven\SEIPBundle\Model\Box\Dashboard\DataLoad;

/**
 * Muestra la base para el dashboard de Producción
 *
 */
class ProductionCorporationBox extends \Tecnocreaciones\Bundle\BoxBundle\Model\GenericBox
{
    public function getName() {
        return 'dashboard_data_load_production_corporation';
    }

    public function getParameters() 
    {   
        $typeView = $this->getRequest()->get('typeView');
        
        return array(
            'typeView' => $typeView,
        );
    }

    public function getTemplateName() {
        return 'PequivenSEIPBundle:Monitor:Dashboard\DataLoad\Production\productionCorporation.html.twig';
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
    
    /**
     * Manejador de usuario o administrador
     * @return \Pequiven\SEIPBundle\Model\UserManager
     */
    private function getUserManager() 
    {
        return $this->container->get('seip.user_manager');
    }
}
