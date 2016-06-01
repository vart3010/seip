<?php

namespace Pequiven\IndicatorBundle\Controller;

use Pequiven\SEIPBundle\Controller\SEIPController;
use Symfony\Component\HttpFoundation\Request;
use Pequiven\MasterBundle\Model\LineStrategic;

/**
 * Grupos de Indicadores
 */
class IndicatorGroupController extends SEIPController {

    public function showDashboardAction(Request $request) {

        $boxRender = $this->get('tecnocreaciones_box.render');

        if (($this->getRequest()->get('idLineStrategic')) && ($this->getRequest()->get('IndicatorId'))) {
            $idLineStrategicId = $this->getRequest()->get('idLineStrategic');
            $indicatorId = $this->getRequest()->get('IndicatorId');
            $lineStrategic = $this->container->get('pequiven.repository.linestrategic')->findOneBy(array('deletedAt' => null, 'id' => $idLineStrategicId));
            $indicator = $this->container->get('pequiven.repository.indicator')->findOneById($indicatorId);
            $groups = $indicator->getIndicatorGroup();

            if (count($groups) == 1) {
                $groups = $groups[0]->getchildrens();
            }

            $data = array(
                'lineStrategic' => $lineStrategic,
                'indicator' => $indicator,
                'groups' => $groups,
                'boxRender' => $boxRender
            );


            $view = $this
                    ->view()
                    ->setTemplate($this->config->getTemplate('Dashboard/viewDashboardGroupIndicator.html'))
                    ->setData($data)
            ;

            return $this->handleView($view);
        }



        if (($this->getRequest()->get('idLineStrategic')) && ($this->getRequest()->get('idGroup')) && (!$this->getRequest()->get('tablero'))) {
            $idLineStrategicId = $this->getRequest()->get('idLineStrategic');
            $lineStrategic = $this->container->get('pequiven.repository.linestrategic')->findOneBy(array('deletedAt' => null, 'id' => $idLineStrategicId));
            $group = $this->container->get('pequiven.repository.indicatorgroup')->findOneById($this->getRequest()->get('idGroup'));

            if (count($group->getchildrens()) > 1) {
                $groupsChild = $group->getchildrens();
                $data = array(
                    'lineStrategic' => $lineStrategic,
                    'parentGroup' => $group,
                    'indicator' => null,
                    'groups' => $groupsChild,
                    'boxRender' => $boxRender
                );
            } else if (count($group->getchildrens()) == 1) {
                $groupsChild = $group->getchildrens();
                return $this->redirect($this->generateUrl('pequiven_line_strategic_show', array('IndicatorGroup' => $groupsChild[0]->getId(), 'id' => $idLineStrategicId)));
            } else {
                return $this->redirect($this->generateUrl('pequiven_line_strategic_show', array('IndicatorGroup' => $this->getRequest()->get('idGroup'), 'id' => $idLineStrategicId)));
            }
        }

        //METODO PARA LOS TABLEROS POR GRUPO
        if (($this->getRequest()->get('tablero')) && ($this->getRequest()->get('idGroup')) && ($this->getRequest()->get('idLineStrategic'))) {
            if ($this->getRequest()->get('tablero') == 1) {
                $tree = $data = $style = array();
                $iconsLineStrategic = LineStrategic::getIcons();
                $indicatorService = $this->getIndicatorService();
                $group = $this->container->get('pequiven.repository.indicatorgroup')->findOneById($this->getRequest()->get('idGroup'));
                $idLineStrategic = $this->getRequest()->get('idLineStrategic');

                $maxPerTag = 9;
                $cont = 1;
                $tag = 1;
                $totalInd = 0;

                foreach ($group->getIndicators() as $indicator) {
                    foreach ($indicator->getLineStrategics() as $lineStrategic) {
                        if ($lineStrategic->getId() == $idLineStrategic) {
                            if (!isset($tree[(string) $lineStrategic])) {
                                $tree[(string) $lineStrategic] = array(
                                    'parent' => $lineStrategic,
                                    'child' => array(),
                                );
                            }

                            $tree[(string) $lineStrategic]['child'][$tag][(string) $indicator] = $indicator;
                            $data[(string) $lineStrategic->getRef()][(string) $indicator->getRef()] = $indicatorService->getDataDashboardWidgetBulb($indicator);
                            //var_dump('tag=' . $tag . ' / cont=' . $cont);
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

                
//                die();

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
        }
    }

    public function showLineStrategicByGroupAction() {

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
