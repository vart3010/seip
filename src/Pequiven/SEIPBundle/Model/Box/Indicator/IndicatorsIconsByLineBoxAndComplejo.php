<?php

namespace Pequiven\SEIPBundle\Model\Box\Indicator;

use Tecnocreaciones\Bundle\BoxBundle\Model\GenericBox;
use Pequiven\MasterBundle\Entity\LineStrategic;
use Pequiven\SEIPBundle\Model\Common\CommonObject;

/**
 * Description of IconsBox
 *
 */
class IndicatorsIconsByLineBoxAndComplejo extends GenericBox 
{
    public function getDescription() {
        return 'Contiene una lista de los indicatores estratégicos en formato de íconos de acuerdo a una Línea Estratégica seleccionada';
    }

    public function getName() {
        return 'pequiven_seip_box_linestrategic_icons_indicator_by_line_and_complejo';
    }

    public function getParameters() {
        
        $em = $this->getDoctrine()->getManager();
        
        $idComplejo = $this->getRequest()->get('idComplejo');
        $idLinea = $this->getRequest()->get('id');
        //var_dump($idLinea);
        //die();
        //$idLineStrategic = $this->getRequest()->get('id');
        $linesStrategics = $this->container->get('pequiven.repository.linestrategic')->findBy(array('deletedAt' => null, 'id'=>$idLinea),array('orderShow' => 'ASC'));
        $tree = $data = $style = array();
        $indicatorService = $this->getIndicatorService();
        $resultService = $this->getResultService();
        
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
        
        return array(
            'lineStrategic' => $lineStrategic,
            'tree' => $tree,
            'data' => $data,
            'style' => $style,
            'idComplejo' => $idComplejo,
            'indicatorService' => $indicatorService,
        );
    }
    
    
    public function hasPermission() {
        return $this->isGranted(array('ROLE_DIRECTIVE','ROLE_WORKER_PLANNING','ROLE_SEIP_VIEW_RESULT_BY_LINE_STRATEGIC_SPECIAL','ROLE_SEIP_RESULT_VIEW_BY_INDICATORS_CPJAA','ROLE_SEIP_RESULT_VIEW_BY_INDICATORS_CPAMC','ROLE_SEIP_RESULT_VIEW_BY_INDICATORS_CPHC'));
    }
    
    public function getTemplateName() {
        return 'PequivenSEIPBundle:LineStrategic:Dashboard/viewIndicatorsGroupByLineAndComplejo.html.twig';
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
