<?php

namespace Pequiven\IndicatorBundle\Controller;

use Pequiven\SEIPBundle\Controller\SEIPController;
use Symfony\Component\HttpFoundation\Request;
use Pequiven\MasterBundle\Model\LineStrategic;
use Pequiven\IndicatorBundle\Model\IndicatorLevel;

/**
 * Grupos de Indicadores
 * @author Gilbert C. <glavrjk@gmail.com> 
 */
class IndicatorGroupController extends SEIPController {

    /**
     * METODO PARA MOSTRAR LOS GRUPOS ASOCIADOS A UN INDICADOR
     * @param Request $request
     * @return type
     */
    public function showDashboardIndicatorsGroupAction(Request $request) {

        $boxRender = $this->get('tecnocreaciones_box.render');
        $indicatorService = $this->getIndicatorService();
        $idLineStrategicId = $this->getRequest()->get('idLineStrategic');
        $indicatorId = $this->getRequest()->get('indicatorId');
        $lineStrategic = $this->container->get('pequiven.repository.linestrategic')->findOneBy(array('deletedAt' => null, 'id' => $idLineStrategicId));
        $indicator = $this->container->get('pequiven.repository.indicator')->findOneById($indicatorId);
        $groups = $indicator->getIndicatorGroup();

        if (count($groups) == 1) {
            $groups = $groups[0]->getchildrens();
        }

        //SI VIENE DE UN TABLERO DE INDICADORES POR GERENCIA
        if ($this->getRequest()->get('board')) {
            $board = 1;
        } else {
            $board = null;
        }

        $indicatorData = $indicatorService->getDataDashboardWidgetBulb($indicator);

        $data = array(
            'lineStrategic' => $lineStrategic,
            'indicator' => $indicator,
            'data' => $indicatorData,
            'groups' => $groups,
            'board' => $board,
            'boxRender' => $boxRender
        );

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('Dashboard/viewDashboardGroupIndicator.html'))
                ->setData($data)
        ;

        return $this->handleView($view);
    }

    /**
     * METODO PARA MOSTRAR LOS INDICADORES DE UN GRUPO ASOCIADO O EN SU DEFECTO LOS GRUPOS HIJOS DE UN GRUPO
     * @param Request $request
     * @return type
     */
    public function showDashboardIndicatorsFromGroupAction(Request $request) {

        $boxRender = $this->get('tecnocreaciones_box.render');
        $lineStrategicId = $this->getRequest()->get('idLineStrategic');
        $lineStrategic = $this->container->get('pequiven.repository.linestrategic')->findOneBy(array('deletedAt' => null, 'id' => $lineStrategicId));
        $group = $this->container->get('pequiven.repository.indicatorgroup')->findOneById($this->getRequest()->get('idGroup'));
        $indicatorId = $this->getRequest()->get('indicatorId');
        $indicator = $this->container->get('pequiven.repository.indicator')->findOneById($indicatorId);
        $childGroups = $group->getchildrens();

        //SI NO TIENE HIJOS
        if (count($childGroups) == 0) {
            //SI VIENE DE UN TABLERO DE INDICADORES
            if ($this->getRequest()->get('board')) {
                //REDIRIJO A showDashboardGerenciasAction
                return $this->redirect($this->generateUrl('pequiven_dashboardgerencias', array('idGroup' => $group->getId(), 'idLineStrategic' => $lineStrategicId)));
            } else {
                return $this->redirect($this->generateUrl('pequiven_line_strategic_show', array('IndicatorGroup' => $group->getId(), 'id' => $lineStrategicId)));
            }
        } else {

            //MUESTRO UNA VISTA IGUAL A LA DE showDashboardIndicatorsGroupAction SOLO QUE AHORA MUESTRA A SU HIJO COMO PRINCIPAL
            if (count($childGroups) == 1) {
                $childGroups = $childGroups[0]->getchildrens();
            }

            $indicatorData = $this->getIndicatorService()->getDataDashboardWidgetBulb($indicator);

            //SI VIENE DE UN TABLERO DE INDICADORES
            if ($this->getRequest()->get('board')) {
                $board = 1;
            } else {
                $board = null;
            }

            $data = array(
                'lineStrategic' => $lineStrategic,
                'indicator' => $indicator,
                'data' => $indicatorData,
                'board' => $board,
                'groups' => $childGroups,
                'boxRender' => $boxRender
            );


            $view = $this
                    ->view()
                    ->setTemplate($this->config->getTemplate('Dashboard/viewDashboardGroupIndicator.html'))
                    ->setData($data)
            ;

            return $this->handleView($view);
        }
    }

    /**
     * METODO PARA MOSTRAR LOS INDICADORES PERTENECIENTES A UN TABLERO DE GERENCIAS (GRUPO) POR UNA O CUALQUIER LINEA ESTRATEGICA 
     * @param Request $request
     */
    public function showDashboardGerenciasAction(Request $request) {

        $boxRender = $this->get('tecnocreaciones_box.render');
        $tree = $data = $style = array();
        $iconsLineStrategic = LineStrategic::getIcons();
        $indicatorService = $this->getIndicatorService();
        $group = $this->container->get('pequiven.repository.indicatorgroup')->findOneById($this->getRequest()->get('idGroup'));

        if ($this->getRequest()->get('idLineStrategic')) {
            $idLineStrategic = $this->getRequest()->get('idLineStrategic');
        } else {
            $idLineStrategic = null;
        }

        $maxPerTag = 9;
        $cont = 1;
        $tag = 1;
        $totalInd = 0;

        foreach ($group->getIndicators() as $indicator) {
            foreach ($indicator->getLineStrategics() as $lineStrategic) {
                if (($lineStrategic->getId() == $idLineStrategic) || (!$idLineStrategic)) {
                    if (!isset($tree[(string) $lineStrategic])) {
                        $tree[(string) $lineStrategic] = array(
                            'parent' => $lineStrategic,
                            'child' => array(),
                        );
                    }

                    $options = array(
                        "url" => 'pequiven_indicator_showdashboardtablero',
                        "urlParameters" => array('id' => $indicator->getId())
                    );

                    $tree[(string) $lineStrategic]['child'][$tag][(string) $indicator] = $indicator;
                    $data[(string) $lineStrategic->getRef()][(string) $indicator->getRef()] = $indicatorService->getDataDashboardWidgetBulb($indicator, 12, $options);
                    $totalInd++;

                    if ($cont == $maxPerTag) {
                        $tag++;
                        $cont = 1;
                    } else {
                        $cont++;
                    }
                }
            }
        }

        $data = array(
            'indicators' => $group->getIndicators(),
            'iconsLineStrategic' => $iconsLineStrategic,
            'boxRender' => $boxRender,
            'group' => $group,
            'tree' => $tree,
            'data' => $data,
            'board' => 1,
            'style' => $style,
            'tags' => ceil($totalInd / $maxPerTag),
            'indicatorService' => $indicatorService
        );

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('Dashboard/viewDashboardPanelIndicator.html'))
                ->setData($data)
        ;

        return $this->handleView($view);
    }

    /**
     * FUNCION QUE RETORNA LOS GRAFICOS (DASHBOARD) DE UN INDICADOR ESPECIFICO
     * @return type
     */
    public function showIndicatorDashboardAction() {

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

        $options = array(
            "url" => 'pequiven_indicator_showdashboardtablero',
            "urlParameters" => array('id' => $indicator->getId())
        );

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

        $dataChart = $indicatorService->getDataDashboardWidgetDoughnut($indicator, $options);

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
                    $dataChartColumn = $indicatorService->getChartColumnLineDualAxis($indicator, $options);
                }
            }
        } elseif ($indicator->getIndicatorLevel()->getLevel() == IndicatorLevel::LEVEL_OPERATIVO) {
            if ($indicator->getParent() != null) {
                if (count($indicator->getParent()->getParent()) > 0) {
                    if (in_array($indicator->getParent()->getParent()->getId(), $arrayIdProduccion)) {
                        $seeInColumn = true;
                        $seeInColumnSingleAxis = true;
                        $dataChartColumn = $indicatorService->getDataChartOfResultIndicator($indicator, $options);
                    }
                }
            }
        }

        $rs = array();
        $type = $indicator->getCharts();
//        foreach ($type as $t) {
//            array_push($rs, $t->);
//        }

        $data = array(
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
            'data' => $indicatorService->getDataDashboardWidgetBulb($indicator),
            'options' => $options
        );

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('Dashboard/viewIndicatorDashboard.html'))
                ->setData($data)
        ;

        return $this->handleView($view);
    }

    /**
     * FUNCION PARA DESPLEGAS LAS LINEAS ESTRATÉGICAS DE UN TABLERO DE INDICADORES
     * @return type
     */
    public function showLineStrategicByGroupAction(Request $request) {

        $group = $this->container->get('pequiven.repository.indicatorgroup')->findOneById($this->getRequest()->get('idGroup'));
        $iconsLineStrategic = LineStrategic::getIcons();
        $indicatorService = $this->getIndicatorService();
        $lineStrategics = array();
        $alllineStrategic = $this->container->get('pequiven.repository.linestrategic')->findBy(array('deletedAt' => null));

        if ($group->getIndicators() == null) {
            $this->get('session')->getFlashBag()->add('error', "El Tablero NO Posee Indicadores Asociados");
        } else {
            foreach ($group->getIndicators() as $indicator) {
                foreach ($indicator->getLineStrategics() as $ls) {
                    if (!isset($lineStrategics[$ls->getId()])) {
                        $lineStrategics[$ls->getId()] = $ls;
                    }
                }
            }
        }

        $data = array(
            'iconsLineStrategic' => $iconsLineStrategic,
            'indicatorService' => $indicatorService,
            'lineStrategics' => $lineStrategics,
            'group' => $group,
            'alllineStrategic' => $alllineStrategic
        );

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('Dashboard/viewDashboardPanelLineStrategicByGroup.html'))
                ->setData($data)
        ;

        return $this->handleView($view);
    }

    /**
     * FUNCION PARA DESPLEGAS LOS GRUPOS DE INDICADORES HIJOS DE UN GRUPO (TABLEROS DE INDICADORES CPJAA)
     * @return type
     */
    public function showSubIndicatorGroupsByGroupAction(Request $request) {

        $groupParent = $this->container->get('pequiven.repository.indicatorgroup')->findOneById($this->getRequest()->get('idGroup'));
        $indicatorService = $this->getIndicatorService();
        $indicators = array();

        $groups = $groupParent->getchildrens();

        if ($groupParent->getchildrens() == null) {
            $this->get('session')->getFlashBag()->add('error', "El Tablero NO Posee Indicadores Asociados");
        } else {
            foreach ($groups as $groupChild) {
                foreach ($groupChild->getIndicators() as $ind) {
                    if (!isset($indicators[$ind->getId()])) {
                        $indicators[$ind->getId()] = $ind;
                    }
                }
            }
        }

        $data = array(            
            'indicatorService' => $indicatorService,
            'indicators' => $indicators,
            'groups' => $groups  ,
            'group' => $groupParent
        );

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('Dashboard/viewDashboardPanelSubGroupIndicatorByGroup.html'))
                ->setData($data)
        ;

        return $this->handleView($view);
    }

    protected function getPeriodService() {
        return $this->container->get('pequiven_seip.service.period');
    }

    /**
     * Servicio de los Indicadores
     * @return \Pequiven\IndicatorBundle\Service\IndicatorService
     */
    public function getIndicatorService() {
        return $this->container->get('pequiven_indicator.service.inidicator');
    }

}
