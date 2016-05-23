<?php

namespace Pequiven\MasterBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Pequiven\MasterBundle\Entity\LineStrategic;
use Pequiven\SEIPBundle\Controller\SEIPController;

/**
 * Description of LineStrategicController
 *
 */
class LineStrategicController extends SEIPController {

    /**
     * Retorna el Tablero con las Líneas Estratégicas definidas en el SEIP
     * @param Request $request
     * @return type
     */
    public function viewDashboardAction(Request $request) {
        $boxRender = $this->get('tecnocreaciones_box.render');

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('Dashboard/viewDashboard.html'))
                ->setData(array(
            'boxRender' => $boxRender
                ))
        ;

        return $this->handleView($view);
    }

    /**
     * Retorna el Tablero con los Grupos de Indicadores
     * @param Request $request
     * @return type
     */
    public function viewDashboardGroupAction(Request $request) {
        $boxRender = $this->get('tecnocreaciones_box.render');

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('Dashboard/viewDashboardGroupIndicator.html'))
                ->setData(array(
            'boxRender' => $boxRender
                ))
        ;

        return $this->handleView($view);
    }

    /**
     * Retorna el Tablero con los indicadores estratégicos definidos en el SEIP De acuerdo al Complejo Seleccionado
     * @param Request $request
     * @return type
     */
    public function viewDashboarComplejoAction(Request $request) {
        $boxRender = $this->get('tecnocreaciones_box.render');
        $idComplejo = $request->get('complejo');
        $labelsSummary = \Pequiven\MasterBundle\Entity\Complejo::getLabelsSummary();

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('Dashboard/viewDashboardComplejo.html'))
                ->setData(array(
            'boxRender' => $boxRender,
            'summaryComplejo' => $labelsSummary[$idComplejo]
                ))
        ;

        return $this->handleView($view);
    }

    /**
     * Retorna el Tablero con los indicadores especificos
     * @param Request $request
     * @return type
     */
    public function viewOnlyIndicatorSpecificAction(Request $request) {
        $boxRender = $this->get('tecnocreaciones_box.render');
        $idComplejo = $request->get('complejo');

        $labelsSummary = \Pequiven\MasterBundle\Entity\Complejo::getLabelsSummary();

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('viewByIndicatorSpecific.html'))
                ->setData(array(
            'boxRender' => $boxRender,
            'summaryComplejo' => $labelsSummary[$idComplejo]
                ))
        ;

        return $this->handleView($view);
    }

    /**
     * Retorna el Tablero con los indicadores estratégicos definidos en el SEIP
     * @param Request $request
     * @return type
     */
    public function viewOnlyIndicatorAction(Request $request) {
        $boxRender = $this->get('tecnocreaciones_box.render');

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('viewByIndicator.html'))
                ->setData(array(
            'boxRender' => $boxRender
                ))
        ;

        return $this->handleView($view);
    }

    /**
     * Retorna los semaforos de acuerdo al complejo seleccionado
     * @param Request $request
     * @return type
     */
    public function showResultsByComplejoAction(Request $request) {
        $resource = $this->findOr404($request);
        $boxRender = $this->get('tecnocreaciones_box.render');
        $idComplejo = $request->get('idComplejo');
        $labelsSummary = \Pequiven\MasterBundle\Entity\Complejo::getLabelsSummary();
        $labelsSummary = $labelsSummary[$idComplejo];
                
        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('Dashboard/viewResultsByComplejo.html'))
                ->setData(array(
                'boxRender' => $boxRender,
                'labelsSummary' => $labelsSummary,
            $this->config->getResourceName() => $resource
        ));

        return $this->handleView($view);
    }

    /*     * ** */

    public function showAction(Request $request) {

        $resource = $this->findOr404($request);

        $resultIndicator = $resultArrangementProgram = $resultObjetives = array();
        $objetives = $resource->getObjetives();
        $tree = array();

        $caption = $this->trans('result.captionObjetiveStrategic', array(), 'PequivenSEIPBundle');
        $subCaption = $this->getPeriodService()->getPeriodActive()->getDescription();
        $data = array(
            'dataSource' => array(
                'chart' => array(
                    'caption' => $caption,
                    'subCaption' => $subCaption,
                ),
                'categories' => array(
                    'category' => array(),
                ),
                'dataset' => array(),
            ),
        );
        //Configuramos el alto del gráfico
        $totalObjects = count($objetives);
        $heightChart = ($totalObjects * 30) + 150;

        //Data del gráfico
        foreach ($objetives as $objetive) {
            $objetivesTactics = $objetive->getChildrens();
            foreach ($objetivesTactics as $objetiveTactic) {
//                foreach ($objetive->getParents() as $parent) {
                if (!isset($tree[(string) $objetive])) {
                    $tree[(string) $objetive] = array(
                        'parent' => $objetive,
                        'child' => array(),
                    );
                }
                $tree[(string) $objetive]['child'][(string) $objetiveTactic] = $objetiveTactic;
//                }
            }


            $refObjetive = $objetive->getRef();
            $flagResultIndicator = $flagResultObjetives = false;
            $categories[] = array('label' => $refObjetive);
            foreach ($objetive->getResults() as $result) {
                $urlObjetive = $this->generateUrl('objetiveStrategic_show', array('id' => $objetive->getId()));
                $totalIndicator = 0.0;
                $totalObjetives = 0.0;
                $flagResultIndicatorInternal = false;
                $flagResultObjetivesInternal = false;

                if ($result->getTypeResult() == \Pequiven\SEIPBundle\Model\Result\Result::TYPE_RESULT_INDICATOR) {
                    $totalIndicator += $result->getResultWithWeight();
                    $flagResultIndicator = $flagResultIndicatorInternal = true;
                }
                if ($result->getTypeResult() == \Pequiven\SEIPBundle\Model\Result\Result::TYPE_RESULT_OBJECTIVE) {
                    $totalObjetives+= $result->getResultWithWeight();
                    $flagResultObjetives = $flagResultObjetivesInternal = true;
                }
                if ($result->getTypeResult() == \Pequiven\SEIPBundle\Model\Result\Result::TYPE_RESULT_OF_RESULT) {
                    foreach ($result->getChildrens() as $child) {
                        if ($child->getTypeResult() == \Pequiven\SEIPBundle\Model\Result\Result::TYPE_RESULT_INDICATOR) {
                            $totalIndicator += ($child->getResultWithWeight() * $result->getWeight()) / 100;
                            $flagResultIndicator = $flagResultIndicatorInternal = true;
                        } elseif ($child->getTypeResult() == \Pequiven\SEIPBundle\Model\Result\Result::TYPE_RESULT_OBJECTIVE) {
                            $totalObjetives+= ($child->getResultWithWeight() * $result->getWeight()) / 100;
                            $flagResultObjetives = $flagResultObjetivesInternal = true;
                        }
                    }
                }

                if ($flagResultIndicatorInternal === true) {
                    $resultIndicator[] = array('value' => bcadd($totalIndicator, '0', 2), 'link' => $urlObjetive);
                }
                if ($flagResultObjetivesInternal === true) {
                    $resultObjetives[] = array('value' => bcadd($totalObjetives, '0', 2), 'link' => $urlObjetive, 'bgColor' => '');
                }
            }

            if (!$flagResultIndicator) {
                $resultIndicator[] = array('value' => bcadd(0, '0', 2));
            }
            if (!$flagResultObjetives) {
                $resultObjetives[] = array('value' => bcadd(0, '0', 2));
            }
        }
        if (count($resultIndicator) > 0) {
            $data['dataSource']['dataset'][] = array(
                'seriesname' => $this->trans('chart.result.objetiveOperative.seriesNamePlan1'),
                'data' => $resultIndicator,
            );
        }
        if (count($resultObjetives) > 0) {
            $data['dataSource']['dataset'][] = array(
                'seriesname' => $this->trans('chart.result.objetiveOperative.seriesNamePlan3'),
                'data' => $resultObjetives,
            );
        }

        $data['dataSource']['categories']['category'] = $categories;

        $resultService = $this->getResultService();

        $boxRender = $this->get('tecnocreaciones_box.render');

        $answer = $request->get('r');

        $id = $request->get('id');
        if ($answer == 1) {
            $id = $id + 1;
            if ($id > 7) {
                $id = 1;
            }
        }

        $dataArray = array(
            $this->config->getResourceName() => $resource,
            'object' => $objetives,
            'tree' => $tree,
            'heightChart' => $heightChart,
            'data' => $data,
            'resultService' => $resultService,
            'boxRender' => $boxRender,
            'answer' => $answer,
            'id' => $id,
        );

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('show.html'))
                ->setData($dataArray)
        ;

        return $this->handleView($view);
    }

    /**
     * Método que muestra 
     * @param Request $request
     * @return type
     */
    public function viewOnlyObjetiveAction(Request $request) {
        $typeObject = $request->get('object');
        $iconsLineStrategic = LineStrategic::getIcons();
        $resultIndicator = $resultArrangementProgram = $resultObjetives = array();
//        $objetives = $resource->getObjetives();
        $tree = array();

        $objetivesStrategics = $this->get('pequiven.repository.objetive')->findAllStrategicByPeriod($this->getPeriodService()->getPeriodActive());

        $caption = $this->trans('result.captionObjetiveStrategic', array(), 'PequivenSEIPBundle');
        $subCaption = $this->getPeriodService()->getPeriodActive()->getDescription();
        $data = array(
            'dataSource' => array(
                'chart' => array(
                    'caption' => $caption,
                    'subCaption' => $subCaption,
                ),
                'categories' => array(
                    'category' => array(),
                ),
                'dataset' => array(),
            ),
        );
        //Configuramos el alto del gráfico
        $totalObjects = count($objetivesStrategics);
        $heightChart = ($totalObjects * 30) + 150;

        //Data del gráfico
        foreach ($objetivesStrategics as $objetive) {
            foreach ($objetive->getLineStrategics() as $parent) {
                if (!isset($tree[(string) $parent])) {
                    $tree[(string) $parent] = array(
                        'parent' => $parent,
                        'child' => array(),
                    );
                }
                $tree[(string) $parent]['child'][(string) $objetive] = $objetive;
            }

            $refObjetive = $objetive->getRef();
            $flagResultIndicator = $flagResultObjetives = false;
            $categories[] = array('label' => $refObjetive);
            foreach ($objetive->getResults() as $result) {
                $urlObjetive = $this->generateUrl('objetiveStrategic_show', array('id' => $objetive->getId()));
                $totalIndicator = 0.0;
                $totalObjetives = 0.0;
                $flagResultIndicatorInternal = false;
                $flagResultObjetivesInternal = false;

                if ($result->getTypeResult() == \Pequiven\SEIPBundle\Model\Result\Result::TYPE_RESULT_INDICATOR) {
                    $totalIndicator += $result->getResultWithWeight();
                    $flagResultIndicator = $flagResultIndicatorInternal = true;
                }
                if ($result->getTypeResult() == \Pequiven\SEIPBundle\Model\Result\Result::TYPE_RESULT_OBJECTIVE) {
                    $totalObjetives+= $result->getResultWithWeight();
                    $flagResultObjetives = $flagResultObjetivesInternal = true;
                }
                if ($result->getTypeResult() == \Pequiven\SEIPBundle\Model\Result\Result::TYPE_RESULT_OF_RESULT) {
                    foreach ($result->getChildrens() as $child) {
                        if ($child->getTypeResult() == \Pequiven\SEIPBundle\Model\Result\Result::TYPE_RESULT_INDICATOR) {
                            $totalIndicator += ($child->getResultWithWeight() * $result->getWeight()) / 100;
                            $flagResultIndicator = $flagResultIndicatorInternal = true;
                        } elseif ($child->getTypeResult() == \Pequiven\SEIPBundle\Model\Result\Result::TYPE_RESULT_OBJECTIVE) {
                            $totalObjetives+= ($child->getResultWithWeight() * $result->getWeight()) / 100;
                            $flagResultObjetives = $flagResultObjetivesInternal = true;
                        }
                    }
                }

                if ($flagResultIndicatorInternal === true) {
                    $resultIndicator[] = array('value' => bcadd($totalIndicator, '0', 2), 'link' => $urlObjetive);
                }
                if ($flagResultObjetivesInternal === true) {
                    $resultObjetives[] = array('value' => bcadd($totalObjetives, '0', 2), 'link' => $urlObjetive, 'bgColor' => '');
                }
            }

            if (!$flagResultIndicator) {
                $resultIndicator[] = array('value' => bcadd(0, '0', 2));
            }
            if (!$flagResultObjetives) {
                $resultObjetives[] = array('value' => bcadd(0, '0', 2));
            }
        }
        if (count($resultIndicator) > 0) {
            $data['dataSource']['dataset'][] = array(
                'seriesname' => $this->trans('chart.result.objetiveOperative.seriesNamePlan1'),
                'data' => $resultIndicator,
            );
        }
        if (count($resultObjetives) > 0) {
            $data['dataSource']['dataset'][] = array(
                'seriesname' => $this->trans('chart.result.objetiveOperative.seriesNamePlan3'),
                'data' => $resultObjetives,
            );
        }

        $data['dataSource']['categories']['category'] = $categories;

        $resultService = $this->getResultService();

        $boxRender = $this->get('tecnocreaciones_box.render');

        $dataArray = array(
//            $this->config->getResourceName() => $resource,
//            'object' => $objetives,
            'iconsLineStrategic' => $iconsLineStrategic,
            'tree' => $tree,
            'heightChart' => $heightChart,
            'data' => $data,
            'resultService' => $resultService,
            'boxRender' => $boxRender
        );

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('viewByObjetive.html'))
                ->setData($dataArray)
        ;

        return $this->handleView($view);
    }

    /**
     * 
     * @return \Pequiven\SEIPBundle\Service\PeriodService
     */
    protected function getPeriodService() {
        return $this->container->get('pequiven_seip.service.period');
    }

    /**
     * 
     * @return \Pequiven\SEIPBundle\Service\ResultService
     */
    protected function getResultService() {
        return $this->container->get('seip.service.result');
    }

}
