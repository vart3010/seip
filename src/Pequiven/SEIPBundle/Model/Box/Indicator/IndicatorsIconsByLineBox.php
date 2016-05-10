<?php

namespace Pequiven\SEIPBundle\Model\Box\Indicator;

use Tecnocreaciones\Bundle\BoxBundle\Model\GenericBox;
use Pequiven\MasterBundle\Entity\LineStrategic;
use Pequiven\SEIPBundle\Model\Common\CommonObject;

/**
 * Description of IconsBox
 *
 */
class IndicatorsIconsByLineBox extends GenericBox {

    public function getDescription() {
        return 'Contiene una lista de los indicatores estratégicos en formato de íconos de acuerdo a una Línea Estratégica seleccionada';
    }

    public function getName() {
        return 'pequiven_seip_box_linestrategic_icons_indicator_by_line_dashboard';
    }

    public function getParameters() {

        $em = $this->getDoctrine()->getManager();

        $idLineStrategic = $this->getRequest()->get('id');
        $lineStrategic = $this->container->get('pequiven.repository.linestrategic')->findOneBy(array('deletedAt' => null, 'id' => $idLineStrategic));

        if ($this->getRequest()->get('IndicatorGroup')) {            
            $indicators = $this->container->get('pequiven.repository.indicator')->findByIndicatorGroup($this->getRequest()->get('IndicatorGroup'));
        } else {
            $indicators = $this->container->get('pequiven.repository.indicator')->findByLineStrategicAndOrderShowFromParent($lineStrategic->getId());
        }

        $tree = $data = $style = array();
        $indicatorService = $this->getIndicatorService();
        $resultService = $this->getResultService();

//        foreach($linesStrategics as $lineStrategic){
//            $indicators = $lineStrategic->getIndicators();

        $valueIndicators = $indicatorService->calculateSimpleAverage($lineStrategic, 2);
        $type = $resultService->evaluateRangeByTotal($valueIndicators, count($indicators));

        if ($type == CommonObject::TYPE_RANGE_GOOD) {
            $style[(string) $lineStrategic->getRef()] = 'background: rgba(88,181,63,0.25);';
        } elseif ($type == CommonObject::TYPE_RANGE_MIDDLE) {
            $style[(string) $lineStrategic->getRef()] = 'background: rgba(202,202,73,0.25);';
        } elseif ($type == CommonObject::TYPE_RANGE_BAD) {
            $style[(string) $lineStrategic->getRef()] = 'background: rgba(210,148,129,0.25);';
        }

        foreach ($indicators as $indicator) {
            if (!isset($tree[(string) $lineStrategic])) {
                $tree[(string) $lineStrategic] = array(
                    'parent' => $lineStrategic,
                    'child' => array(),
                );
            }
            $tree[(string) $lineStrategic]['child'][(string) $indicator] = $indicator;
            //$data[(string)$lineStrategic->getRef()][(string)$indicator->getRef()] = $indicator->getEvaluateInPeriod() == true ? $indicatorService->getDataWidgetAngularGauge($indicator) : $indicatorService->getDataDashboardWidgetBulb($indicator);
            if ($indicator->getNotShowIndicatorNoEvaluateInPeriod() != true) {
                $data[(string) $lineStrategic->getRef()][(string) $indicator->getRef()] = $indicatorService->getDataDashboardWidgetBulb($indicator);
            }
        }

        return array(
            'lineStrategic' => $lineStrategic,
            'tree' => $tree,
            'data' => $data,
            'style' => $style,
        );
    }

    public function hasPermission() {
        return $this->isGranted(array('ROLE_DIRECTIVE', 'ROLE_WORKER_PLANNING', 'ROLE_SEIP_VIEW_RESULT_BY_LINE_STRATEGIC_SPECIAL'));
    }

    public function getTemplateName() {
        return 'PequivenSEIPBundle:LineStrategic:Dashboard/viewIndicatorsGroupByLine.html.twig';
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
    public function getIndicatorService() {
        return $this->container->get('pequiven_indicator.service.inidicator');
    }

    /**
     * Servicio que calcula los resultados
     * @return \Pequiven\SEIPBundle\Service\ResultService
     */
    public function getResultService() {
        return $this->container->get('seip.service.result');
    }

}
