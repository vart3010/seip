<?php

namespace Pequiven\IndicatorBundle\Controller;

use Pequiven\SEIPBundle\Controller\SEIPController;
use Symfony\Component\HttpFoundation\Request;

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
        }


        if (($this->getRequest()->get('idLineStrategic')) && ($this->getRequest()->get('idGroup'))) {
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


        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('Dashboard/viewDashboardGroupIndicator.html'))
                ->setData($data)
        ;

        return $this->handleView($view);
    }

    protected function getPeriodService() {
        return $this->container->get('pequiven_seip.service.period');
    }

}
