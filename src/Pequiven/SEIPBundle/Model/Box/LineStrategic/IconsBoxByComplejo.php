<?php

namespace Pequiven\SEIPBundle\Model\Box\LineStrategic;

use Tecnocreaciones\Bundle\BoxBundle\Model\GenericBox;
use Pequiven\MasterBundle\Entity\LineStrategic;
use Pequiven\SEIPBundle\Model\Common\CommonObject;

/**
 * Description of IconsBox
 *
 */
class IconsBoxByComplejo extends GenericBox 
{
    public function getDescription() {
        return 'Contiene una lista de los indicatores estratégicos en formato de íconos';
    }

    public function getName() {
        return 'pequiven_seip_box_linestrategic_icons_dashboard_complejo';
    }

    /**
     * 
     * @return type
     */
    public function getParameters() {
        
        $em = $this->getDoctrine()->getManager();
        
        $idComplejo = $this->getRequest()->get('complejo'); 
        $iconsLineStrategic = LineStrategic::getIcons();
        $linesStrategics = $this->container->get('pequiven.repository.linestrategic')->findBy(array('deletedAt' => null));
        $tree = $data = $style = array();
        $indicatorService = $this->getIndicatorService();
        $resultService = $this->getResultService();
        
        
        foreach($linesStrategics as $lineStrategic){
            
            $indicators = $this->container->get('pequiven.repository.indicator')->findByLineStrategicAndOrderShowFromParent($lineStrategic->getId(),'ASC',array('specific' => true,'complejo' => $idComplejo));
           
           foreach ($indicators as $indicator) {
                if(!isset($tree[(string)$lineStrategic])){
                    $tree[(string)$lineStrategic] = array(
                        'parent' => $lineStrategic,
                        'child' => array(),
                    );
                }
            }
           
        }
        
        foreach($tree as $t){
            $linesAsociated[]= (int)substr($t['parent'],0,1);
        }
        
        return array(
            'iconsLineStrategic' => $iconsLineStrategic,
            'linesStrategics' => $linesStrategics,
            'idComplejo' => $idComplejo,
            'tree' => $tree,
            'style' => $style,
            'indicatorService' => $indicatorService,
            'linesAsociated' => $linesAsociated,
        );
    }
    
    public function hasPermission() {
        return $this->isGranted(array('ROLE_DIRECTIVE','ROLE_WORKER_PLANNING','ROLE_SEIP_VIEW_RESULT_BY_LINE_STRATEGIC_SPECIAL','ROLE_SEIP_RESULT_VIEW_BY_INDICATORS_CPJAA','ROLE_SEIP_RESULT_VIEW_BY_INDICATORS_CPAMC','ROLE_SEIP_RESULT_VIEW_BY_INDICATORS_CPHC'));
    }
    
    public function getTemplateName() {
        return 'PequivenSEIPBundle:LineStrategic:viewIconsDashboardByComplejo.html.twig';
    }
    
    public function getTranslationDomain() {
        return 'PequivenSEIPBundle';
    }
    
    public function getAreasPermitted() {
        return array(
            \Pequiven\SEIPBundle\Model\Box\AreasBox::DASHBOARD,
            \Pequiven\SEIPBundle\Model\Box\AreasBox::PRINCIPAL
        );
    }
    
    /**
     * Servicio de los Indicadores
     * @return \Pequiven\IndicatorBundle\Service\IndicatorService
     */
    public function getIndicatorService()
    {
        return $this->container->get('pequiven_indicator.service.inidicator');
    }
    
    /**
     * Servicio que calcula los resultados
     * @return \Pequiven\SEIPBundle\Service\ResultService
     */
    public function getResultService()
    {
        return $this->container->get('seip.service.result');
    }
}
