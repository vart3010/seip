<?php

namespace Pequiven\IndicatorBundle\Controller;

use Pequiven\SEIPBundle\Controller\SEIPController;
use Symfony\Component\HttpFoundation\Request;
use Pequiven\MasterBundle\Model\LineStrategic;

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

        //SI VIENE DE UN TABLERO DE INDICADORES
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

                    $tree[(string) $lineStrategic]['child'][$tag][(string) $indicator] = $indicator;
                    $data[(string) $lineStrategic->getRef()][(string) $indicator->getRef()] = $indicatorService->getDataDashboardWidgetBulb($indicator);

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
