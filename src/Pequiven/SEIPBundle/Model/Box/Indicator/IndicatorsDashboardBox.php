<?php

namespace Pequiven\SEIPBundle\Model\Box\Indicator;

use Tecnocreaciones\Bundle\BoxBundle\Model\GenericBox;
use Pequiven\MasterBundle\Entity\LineStrategic;
use Pequiven\IndicatorBundle\Entity\IndicatorLevel;

/**
 * Description of IndicatorsDashboardBox
 *
 */
class IndicatorsDashboardBox extends GenericBox {

    public function getDescription() {
        return 'Contiene la base del dashboard de un Indicador';
    }

    public function getName() {
        return 'pequiven_seip_box_indicators_dashboard';
    }

    public function getParameters() {

        $em = $this->getDoctrine()->getManager();
        $seeTagIndicators = false; //Bandera para saber si se muestran o no las etiquetas del indicador
        $boxRender = $this->get('tecnocreaciones_box.render'); //Servicio para llamar los boxes
        $idIndicator = $this->getRequest()->get('id'); //Obtenemos el id del indicador a visualizar
        $indicator = $this->container->get('pequiven.repository.indicator')->find($idIndicator); //Obtenemos el indicador que se esta visualizando
        $idLineStrategic = ''; //Id de la Línea Estratégica
        $indicatorsGroup = $dataWidget = array(); //Grupo de Indicadores a mostrar en la barra lateral izquierda de la plantilla
        $indicatorService = $this->getIndicatorService();
        $labelsMonths = array();
        foreach (\Pequiven\SEIPBundle\Model\Common\CommonObject::getLabelsMonths() as $key => $value) {
            $labelsMonths[$key] = array(
                'id' => $key,
                'description' => $value,
            );
        }
        ksort($labelsMonths);
//        var_dump($labelsMonths);
//        die();

        if ($indicatorService->isIndicatorHasParents($indicator)) {

            //Comparamos el nivel del indicador y asi obtener el id de la Línea Estratégica a la cual esta alineada el mismo
            if ($indicator->getIndicatorLevel()->getLevel() == IndicatorLevel::LEVEL_ESTRATEGICO) {                
                if ($this->getRequest()->get('idGroup')) {
                    $group = $this->container->get('pequiven.repository.indicatorgroup')->findOneById($this->getRequest()->get('idGroup'));
                    $indicatorsGroup = $group->getIndicators();                    
                } else {
                    foreach ($indicator->getLineStrategics() as $lineStrategic) {
                        $idLineStrategic = $lineStrategic->getId();
                        if (count($lineStrategic->getIndicators()) > 0) {
//                    $indicatorsGroup = $lineStrategic->getIndicators();
                            $indicatorsGroup = $this->container->get('pequiven.repository.indicator')->findByLineStrategicAndOrderShowFromParent($lineStrategic->getId());
                        }
                    }
                }
                if (count($indicator->getChildrens()) == 0) {
                    $seeTagIndicators = true;
                }
            } elseif (($indicatorParent = $indicator->getParent()) != NULL) {
                $flagParent = false;
                $cont = 1;
                while (!$flagParent) {
                    if ($indicatorParent->getIndicatorLevel()->getLevel() == IndicatorLevel::LEVEL_ESTRATEGICO) {//En caso de que estemos en el indicador Táctico
                        $flagParent = true;
                        if ($cont == 1) {//En caso de que se este viendo un indicador táctico
//                        $indicatorsGroup = $indicatorParent->getChildrens();
                            $indicatorsGroup = $this->container->get('pequiven.repository.indicator')->findByParentAndOrderShow($indicatorParent->getId());
                            if (count($indicator->getChildrens()) == 0) {
                                $seeTagIndicators = true;
                            }
                        }
                        foreach ($indicatorParent->getLineStrategics() as $lineStrategic) {
                            $idLineStrategic = $lineStrategic->getId();
                        }
                    } else {
                        $cont++;
//                    $indicatorsGroup = $indicatorParent->getChildrens();//En caso de que se este viendo un indicador operativo, obtenemos los indicadores asociados al táctico, antes de actualizar el objeto indicadorPadre
                        $indicatorsGroup = $this->container->get('pequiven.repository.indicator')->findByParentAndOrderShow($indicatorParent->getId()); //En caso de que se este viendo un indicador operativo, obtenemos los indicadores asociados al táctico, antes de actualizar el objeto indicadorPadre
                        $indicatorParent = $indicatorParent->getParent();
                    }
                }
            }
        }

        //Obtenemos la data para los widget en forma de bulbo de la barra lateral izquierda
        foreach ($indicatorsGroup as $indicatorGroup) {
            $dataWidget[(string) $indicatorGroup->getRef()] = $indicatorGroup->getEvaluateInPeriod() == true ? $indicatorService->getDataWidgetAngularGauge($indicatorGroup) : $indicatorService->getDataDashboardWidgetBulb($indicatorGroup, \Pequiven\SEIPBundle\Model\Common\CommonObject::OPEN_URL_SAME_WINDOW);
        }

        $iconsLineStrategic = LineStrategic::getIcons();
        $linesStrategics = $this->container->get('pequiven.repository.linestrategic')->findBy(array('deletedAt' => null));

        //Esta sección es para los distintos tipos de gráficos del indicador

        if (count($indicator->getCharts()) == 0) {//En caso de que el indicador no tenga ningín gráfico asociado
            $seeTagIndicators = true;
        } else {
            $charts = $indicator->getCharts(); //Obtenemos los gráficos que están disponibles para el dashboard del indicador
        }

        $dataChart = $indicatorService->getDataDashboardWidgetDoughnut($indicator);

        $dataChartColumn = array();
        $seeInColumn = false;
        $seeInColumnSingleAxis = false;

        $arrayIdProduccion = array();
        $arrayIdProduccion[] = 1;
        $arrayIdProduccion[] = 1043;

        if ($indicator->getIndicatorLevel()->getLevel() == IndicatorLevel::LEVEL_TACTICO) {
            if ($indicator->getParent() != null) {
                if (in_array($indicator->getParent()->getId(), $arrayIdProduccion)) {
                    $seeInColumn = true;
                    $dataChartColumn = $indicatorService->getChartColumnLineDualAxis($indicator);
                }
            }
        } elseif ($indicator->getIndicatorLevel()->getLevel() == IndicatorLevel::LEVEL_OPERATIVO) {
            if ($indicator->getParent() != null) {
                if (count($indicator->getParent()->getParent()) > 0) {
                    if (in_array($indicator->getParent()->getParent()->getId(), $arrayIdProduccion)) {
                        $seeInColumn = true;
                        $seeInColumnSingleAxis = true;
                        $dataChartColumn = $indicatorService->getDataChartOfResultIndicator($indicator);
                    }
                }
            }
        }

        $rs = array();
        $type = $indicator->getCharts();
//        foreach ($type as $t) {
//            array_push($rs, $t->);
//        }

        return array(
            'iconsLineStrategic' => $iconsLineStrategic,
            'linesStrategics' => $linesStrategics,
            'idLineStrategic' => $idLineStrategic,
            'seeTagIndicators' => $seeTagIndicators,
            'boxRender' => $boxRender,
            'indicatorsGroup' => $indicatorsGroup,
            'dataWidget' => $dataWidget,
            'indicator' => $indicator,
            'chartest' => $rs,
//            'dataMultiLevelPie' => $dataMultiLevelPie,
            'dataChart' => $dataChart,
            'indicatorService' => $indicatorService,
            'seeInColumn' => $seeInColumn,
            'seeInColumnSingleAxis' => $seeInColumnSingleAxis,
            'dataChartColumn' => $dataChartColumn,
            'labelsMonths' => $labelsMonths,
        );
    }

    public function hasPermission() {
        return $this->isGranted(array('ROLE_DIRECTIVE', 'ROLE_DIRECTIVE_AUX', 'ROLE_WORKER_PLANNING', 'ROLE_SEIP_VIEW_RESULT_BY_LINE_STRATEGIC_SPECIAL'));
    }

    public function getTemplateName() {
        return 'PequivenSEIPBundle:Planning:Indicator/Dashboard/viewDashboardBase.html.twig';
    }

    public function getTranslationDomain() {
        return 'PequivenSEIPBundle';
    }

    public function getAreasPermitted() {
        return array(
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
