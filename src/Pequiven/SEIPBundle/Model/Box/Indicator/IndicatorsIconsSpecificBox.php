<?php

namespace Pequiven\SEIPBundle\Model\Box\Indicator;

use Tecnocreaciones\Bundle\BoxBundle\Model\GenericBox;
use Pequiven\MasterBundle\Entity\LineStrategic;
use Pequiven\SEIPBundle\Model\Common\CommonObject;

/**
 * Description of IconsBox
 *
 */
class IndicatorsIconsSpecificBox extends GenericBox 
{
    public function getDescription() {
        return 'Contiene una lista de los indicatores estratégicos en formato de íconos';
    }

    public function getName() {
        return 'pequiven_seip_box_linestrategic_icons_indicator_specific_dashboard';
    }

    /**
     * 
     * @return type
     */
    public function getParameters() {
        
        $em = $this->getDoctrine()->getManager();
        
        $idComplejo = $this->getRequest()->get('complejo');        
        
        $iconsLineStrategic = LineStrategic::getIcons();
        $linesStrategics = $this->container->get('pequiven.repository.linestrategic')->findBy(array('deletedAt' => null),array('orderShow' => 'ASC'));
        $tree = $data = $style = array();
        $indicatorService = $this->getIndicatorService();
        $resultService = $this->getResultService();
        
//        $indicatorsArray = array(1638,1634,1753,1630,1750,1754,1632,1658,1659,1660,1661,1663,1662,1664,1665,1668,1669,1666,1667,1924,1736,1737,1738,1525,1526,1693,1694,1695,1696,1697,1698,1532,1531,2268);
//        $lineStrategicsIndicatorsArray = array(1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,5,5,5,2,2,5,5,5,5,5,5,1,1,5);
        
//        $indicators = $this->container->get('pequiven.repository.indicator')->findBy(array('id' => $indicatorsArray));
//        
//        var_dump(count($indicators));die();
        
        foreach($linesStrategics as $lineStrategic){
            $indicators = $this->container->get('pequiven.repository.indicator')->findByLineStrategicAndOrderShowFromParent($lineStrategic->getId(),'ASC',array('specific' => true,'complejo' => $idComplejo));
            
            $valueIndicators = $indicatorService->calculateSimpleAverage($lineStrategic,2,array('specific' => true));
            if(count($indicators) > 0){
            $type = $resultService->evaluateRangeByTotal($valueIndicators,count($indicators));
            } else{
                $type = $resultService->evaluateRangeByTotal($valueIndicators);
            }
            
            if($type == CommonObject::TYPE_RANGE_GOOD){
                $style[(string)$lineStrategic->getRef()] = 'background: rgba(88,181,63,0.25);';
            } elseif($type == CommonObject::TYPE_RANGE_MIDDLE){
                $style[(string)$lineStrategic->getRef()] = 'background: rgba(202,202,73,0.25);';
            } elseif($type == CommonObject::TYPE_RANGE_BAD){
                $style[(string)$lineStrategic->getRef()] = 'background: rgba(210,148,129,0.25);';
            }
            
            foreach ($indicators as $indicator) {
                if(!isset($tree[(string)$lineStrategic])){
                    $tree[(string)$lineStrategic] = array(
                        'parent' => $lineStrategic,
                        'child' => array(),
                    );
                }
                $tree[(string)$lineStrategic]['child'][(string)$indicator] = $indicator;
                $data[(string)$lineStrategic->getRef()][(string)$indicator->getRef()] = $indicatorService->getDataDashboardWidgetBulb($indicator);
            }
        }
//        die();
        
        return array(
            'iconsLineStrategic' => $iconsLineStrategic,
            'linesStrategics' => $linesStrategics,
            'tree' => $tree,
            'data' => $data,
            'style' => $style,
            'indicatorService' => $indicatorService,
        );
    }
    
    public function hasPermission() {
        return $this->isGranted(array('ROLE_SEIP_RESULT_VIEW_BY_INDICATORS_CPJAA'));
    }
    
    public function getTemplateName() {
        return 'PequivenSEIPBundle:LineStrategic:Dashboard/viewIndicatorsGroup.html.twig';
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
