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
        $observations = array();
        $reportTemplateRepository = $this->container->get('pequiven.repository.report_template');
        
        $boxRender = $this->container->get('tecnocreaciones_box.render');
        $typeView = $this->getRequest()->get('typeView');
        $idReportTemplate = $this->getRequest()->get('reportTemplateId');
        
        $daySearch = date("j", strtotime('-1 day'));
        if(date("j") == 1){
            $monthSearch = date("n", strtotime('-1 month'));
        } else{
            $monthSearch = date("n");
        }
        
        $reportTemplate = $reportTemplateRepository->find($idReportTemplate);
        
        $plantReports = $reportTemplate->getPlantReports();
        foreach($plantReports as $plantReport){
            $productReports = $plantReport->getProductsReport();
            foreach($productReports as $productReport){
                $productDetailDailyMonths = $productReport->getProductDetailDailyMonthsSortByMonth();
                if(array_key_exists($monthSearch, $productDetailDailyMonths)){
                    if(($observation = $productDetailDailyMonths[$monthSearch]->getObservationByDay($daySearch)) != null){
//                        $observations[$productReport->getId()] = array('product' => $productReport->getProduct()->getName(), 'observation' => $observation);
                        $observations[] = array('product' => $productReport->getProduct()->getName(), 'observation' => $observation);
                    }
                }
            }
        }
        
        return array(
            'typeView' => $typeView,
            'reportTemplateId' => $idReportTemplate,
            'observations' => $observations,
        );
    }

    public function getTemplateName() {
        return 'PequivenSEIPBundle:Monitor:Dashboard/DataLoad/Production/ReportTemplate/production.html.twig';
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
