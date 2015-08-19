<?php

namespace Pequiven\SEIPBundle\Model\Box\Dashboard\DataLoad;

/**
 * Muestra la base para el dashboard de Producción
 *
 */
class ProductionByCompanyBox extends \Tecnocreaciones\Bundle\BoxBundle\Model\GenericBox
{
    public function getName() {
        return 'dashboard_data_load_production_by_company';
    }

    public function getParameters() 
    {
        //Obtenemos los ReportsTemplates que tiene el usuario disponible para ver (A menos que tenga el rol ROLE_SEIP_OPERATION_REPORT_TEMPLATES_ALL)
        $repositoryReportTemplate = $this->container->get('pequiven.repository.report_template');
        $user = $this->getUser();
        $userManager = $this->getUserManager();
        $typeViews = array();
        $typeViews['view_type_pqv'] = false;
        $typeViews['view_type_eemm'] = false;
        
        $arrayReportTemplatesPQV = array(
            'CPHC' => true,
            'CPAMC' => true,
        );
        
        $reportTemplates = array();
        
        if($this->isGranted(array('ROLE_SEIP_OPERATION_REPORT_TEMPLATES_ALL'))){
            $resultReportTemplates = $repositoryReportTemplate->findAll();
            //Seteamos sólo los reportTemplates de PQV, ya que los de la EEMM y Filiales se buscan directo en el controlador del gráfico
            foreach($resultReportTemplates as $resultReportTemplate){
                if($resultReportTemplate->getCompany()->getTypeOfCompany() == \Pequiven\SEIPBundle\Entity\CEI\Company::TYPE_OF_COMPANY_MATRIZ && array_key_exists($resultReportTemplate->getLocation()->getAlias(), $arrayReportTemplatesPQV)){
                    $reportTemplates[] = $resultReportTemplate;
                }
            }
            $typeViews['view_type_pqv'] = true;
            $typeViews['view_type_eemm'] = true;
        } else{
            $resultReportTemplates = $user->getReportTemplates();
            if($userManager->hasReportTemplatesByTypeOfCompany($user, \Pequiven\SEIPBundle\Entity\CEI\Company::TYPE_OF_COMPANY_MATRIZ)){
                $typeViews['view_type_pqv'] = true;
                //Seteamos sólo los reportTemplates de PQV, ya que los de la EEMM y Filiales se buscan directo en el controlador del gráfico
                foreach($resultReportTemplates as $resultReportTemplate){
                    if($resultReportTemplate->getCompany()->getTypeOfCompany() == \Pequiven\SEIPBundle\Entity\CEI\Company::TYPE_OF_COMPANY_MATRIZ && array_key_exists($resultReportTemplate->getLocation()->getAlias(), $arrayReportTemplatesPQV)){
                        $reportTemplates[] = $resultReportTemplate;
                    }
                }
            }
            if($userManager->hasReportTemplatesByTypeOfCompany($user, \Pequiven\SEIPBundle\Entity\CEI\Company::TYPE_OF_COMPANY_AFFILIATED) || $userManager->hasReportTemplatesByTypeOfCompany($user, \Pequiven\SEIPBundle\Entity\CEI\Company::TYPE_OF_COMPANY_MIXTA)){
                $typeViews['view_type_eemm'] = true;
            }
        }
        
        return array(
            'reportTemplates'  => $reportTemplates,
            'typeViews' => $typeViews
        );
    }

    public function getTemplateName() {
        return 'PequivenSEIPBundle:Monitor:Dashboard\DataLoad\Production\productionByCompany.html.twig';
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
