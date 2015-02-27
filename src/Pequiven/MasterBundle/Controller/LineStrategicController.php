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
    public function viewDashboardAction(Request $request){
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
    
    public function showAction(Request $request) {
        
        $resource = $this->findOr404($request);
        
        $resultIndicator = $resultArrangementProgram = $resultObjetives = array();
        $objetives = $resource->getObjetives();
        $showResultObjetives = false;
        
        $caption = $this->trans('result.captionObjetiveStrategic',array(),'PequivenSEIPBundle');
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
        foreach($objetives as $objetive){
            $refObjetive = $objetive->getRef();
            $flagResultIndicator = $flagResultObjetives = false;
            $categories[] = array('label' => $refObjetive);
            foreach($objetive->getResults() as $result){
                $urlObjetive =  $this->generateUrl('objetiveStrategic_show', array('id' => $objetive->getId()));
                $totalIndicator = 0.0;
                $totalObjetives = 0.0;
                $flagResultIndicatorInternal = false;
                $flagResultObjetivesInternal = false;

                if($result->getTypeResult() == \Pequiven\SEIPBundle\Model\Result\Result::TYPE_RESULT_INDICATOR){
                    $totalIndicator += $result->getResultWithWeight();
                    $flagResultIndicator = $flagResultIndicatorInternal = true;
                }
                if($result->getTypeResult() == \Pequiven\SEIPBundle\Model\Result\Result::TYPE_RESULT_OBJECTIVE){
                    $totalObjetives+= $result->getResultWithWeight();
                    $flagResultObjetives = $flagResultObjetivesInternal = true;
                }
                if($result->getTypeResult() == \Pequiven\SEIPBundle\Model\Result\Result::TYPE_RESULT_OF_RESULT){
                    foreach ($result->getChildrens() as $child) {
                        if($child->getTypeResult() == \Pequiven\SEIPBundle\Model\Result\Result::TYPE_RESULT_INDICATOR){
                            $totalIndicator += ($child->getResultWithWeight()*$result->getWeight())/100;
                            $flagResultIndicator = $flagResultIndicatorInternal = true;
                        }elseif($child->getTypeResult() == \Pequiven\SEIPBundle\Model\Result\Result::TYPE_RESULT_OBJECTIVE){
                            $totalObjetives+= ($child->getResultWithWeight()*$result->getWeight())/100;
                            $flagResultObjetives = $flagResultObjetivesInternal = true;
                        }
                    }
                }

                if($flagResultIndicatorInternal === true){
                    $resultIndicator[] = array('value' => bcadd($totalIndicator,'0',2),'link' => $urlObjetive);
                }
                if($flagResultObjetivesInternal === true){
                    $resultObjetives[] = array('value' => bcadd($totalObjetives,'0',2),'link' => $urlObjetive, 'bgColor' => '');
                }
            }

            if(!$flagResultIndicator){
                $resultIndicator[] = array('value' => bcadd(0,'0',2));

            }
            if(!$flagResultObjetives){
                $resultObjetives[] = array('value' => bcadd(0,'0',2));
            }
        }
        if(count($resultIndicator) > 0){
            $data['dataSource']['dataset'][] = array(
                    'seriesname' => $this->trans('chart.result.objetiveOperative.seriesNamePlan1'),
                    'data' => $resultIndicator,
                );
        }
        if(count($resultObjetives) > 0){
            $data['dataSource']['dataset'][] = array(
                'seriesname' => $this->trans('chart.result.objetiveOperative.seriesNamePlan3'),
                'data' => $resultObjetives,
            );
        }
        
        $data['dataSource']['categories']['category'] = $categories;
        
        $resultService = $this->getResultService();
        
        $boxRender = $this->get('tecnocreaciones_box.render');
        
        $dataArray =  array(
            $this->config->getResourceName() => $resource,
            'object' => $objetives,
            'heightChart' => $heightChart,
            'data' => $data,
            'resultService' => $resultService,
            'boxRender' => $boxRender
        );
        
        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('show.html'))
                ->setData($dataArray)
                ;
        
        return $this->handleView($view);
    }
    
    /**
     * 
     * @return \Pequiven\SEIPBundle\Service\PeriodService
     */
    protected function getPeriodService()
    {
        return $this->container->get('pequiven_arrangement_program.service.period');
    }
    
    /**
     * 
     * @return \Pequiven\SEIPBundle\Service\ResultService
     */
    protected function getResultService()
    {
        return $this->container->get('seip.service.result');
    }
}

