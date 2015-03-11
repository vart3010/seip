<?php

namespace Pequiven\SEIPBundle\Model\Box\LineStrategic;

use Tecnocreaciones\Bundle\BoxBundle\Model\GenericBox;
use Pequiven\MasterBundle\Entity\LineStrategic;
use Pequiven\SEIPBundle\Model\Common\CommonObject;

/**
 * Description of IconsBox
 *
 */
class IconsBox extends GenericBox 
{
    public function getDescription() {
        return 'Contiene una lista de las líneas estratégicas en formato de íconos';
    }

    public function getName() {
        return 'pequiven_seip_box_linestrategic_viewdashboard';
    }

    public function getParameters() {
        
        $em = $this->getDoctrine()->getManager();
        
        $iconsLineStrategic = LineStrategic::getIcons();
        $linesStrategics = $this->container->get('pequiven.repository.linestrategic')->findBy(array('deletedAt' => null),array('orderShow' => 'ASC'));
        $tree = $data = $style = array();
        $indicatorService = $this->getIndicatorService();
        $resultService = $this->getResultService();
        
        foreach($linesStrategics as $lineStrategic){
            $indicators = $lineStrategic->getIndicators();
            $valueIndicators = $indicatorService->calculateSimpleAverage($lineStrategic);
            $type = $resultService->evaluateRangeStandar($valueIndicators);
            
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
//        var_dump($style);
//        die();
        return array(
            'iconsLineStrategic' => $iconsLineStrategic,
            'linesStrategics' => $linesStrategics,
            'tree' => $tree,
            'data' => $data,
            'style' => $style,
        );
    }
    
    public function hasPermission() {
        return $this->isGranted(array('ROLE_DIRECTIVE','ROLE_DIRECTIVE_AUX','ROLE_WORKER_PLANNING'));
    }
    
    public function getTemplateName() {
        return 'PequivenSEIPBundle:LineStrategic:Dashboard/viewGroup.html.twig';
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
