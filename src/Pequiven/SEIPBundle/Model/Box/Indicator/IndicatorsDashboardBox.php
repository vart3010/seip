<?php

namespace Pequiven\SEIPBundle\Model\Box\Indicator;

use Tecnocreaciones\Bundle\BoxBundle\Model\GenericBox;
use Pequiven\MasterBundle\Entity\LineStrategic;
use Pequiven\IndicatorBundle\Entity\IndicatorLevel;

/**
 * Description of IndicatorsDashboardBox
 *
 */
class IndicatorsDashboardBox extends GenericBox 
{
    public function getDescription() {
        return 'Contiene la base del dashboard de un Indicador';
    }

    public function getName() {
        return 'pequiven_seip.box.indicators_dashboard';
    }

    public function getParameters() {
        
        $em = $this->getDoctrine()->getManager();
        $seeTree = false;//Bandera para saber si el indicador tiene relación con otros indicadores
        $boxRender = $this->get('tecnocreaciones_box.render');//Servicio par allamar los boxes
        $idIndicator = $this->getRequest()->get('id');//Obtenemos el id del indicador a visualizar
        $indicator = $this->container->get('pequiven.repository.indicator')->find($idIndicator);//Obtenemos el indicador que se esta visualizando
        $idLineStrategic = '';//Id de la Línea Estratégica
        $indicatorsGroup = $dataWidget = array();//Grupo de Indicadores a mostrar en la barra lateral izquierda de la plantilla
        $indicatorService = $this->getIndicatorService();
        
        //Comparamos el nivel del indicador y asi obtener el id de la Línea Estratégica a la cual esta alineada el mismo
        if($indicator->getIndicatorLevel()->getLevel() == IndicatorLevel::LEVEL_ESTRATEGICO){
            foreach($indicator->getLineStrategics() as $lineStrategic){
                $idLineStrategic = $lineStrategic->getId();
                if(count($lineStrategic->getIndicators()) > 0){
//                    $indicatorsGroup = $lineStrategic->getIndicators();
                    $indicatorsGroup = $this->container->get('pequiven.repository.indicator')->findByLineStrategicAndOrderShowFromParent($lineStrategic->getId());
                }
            }
            if(count($indicator->getChildrens()) > 0){
                $seeTree = true;
            }
        } elseif(($indicatorParent = $indicator->getParent()) != NULL){
            $seeTree = true;
            $flagParent = false;
            $cont = 1;
            while(!$flagParent){
                if($indicatorParent->getIndicatorLevel()->getLevel() == IndicatorLevel::LEVEL_ESTRATEGICO){//En caso de que estemos en el indicador Táctico
                    $flagParent = true;
                    if($cont == 1){//En caso de que se este viendo un indicador táctico
//                        $indicatorsGroup = $indicatorParent->getChildrens();
                        $indicatorsGroup = $this->container->get('pequiven.repository.indicator')->findByParentAndOrderShow($indicatorParent->getId());
                    }
                    foreach($indicatorParent->getLineStrategics() as $lineStrategic){
                        $idLineStrategic = $lineStrategic->getId();
                    }
                } else{
                    $cont++;
//                    $indicatorsGroup = $indicatorParent->getChildrens();//En caso de que se este viendo un indicador operativo, obtenemos los indicadores asociados al táctico, antes de actualizar el objeto indicadorPadre
                    $indicatorsGroup = $this->container->get('pequiven.repository.indicator')->findByParentAndOrderShow($indicatorParent->getId());//En caso de que se este viendo un indicador operativo, obtenemos los indicadores asociados al táctico, antes de actualizar el objeto indicadorPadre
                    $indicatorParent = $indicatorParent->getParent();
                }
            }
        }
        
        
        //Obtenemos la data para los widget en forma de bulbo de la barra lateral izquierda
        foreach($indicatorsGroup as $indicatorGroup){
            $dataWidget[(string)$indicatorGroup->getRef()] = $indicatorService->getDataDashboardWidgetBulb($indicatorGroup,  \Pequiven\SEIPBundle\Model\Common\CommonObject::OPEN_URL_SAME_WINDOW);
        }
        
        $iconsLineStrategic = LineStrategic::getIcons();
        $linesStrategics = $this->container->get('pequiven.repository.linestrategic')->findBy(array('deletedAt' => null));
        
//        $dataMultiLevelPie = $indicatorService->getDataDashboardWidgetMultiLevelPie($indicator);
        $dataChart = $indicatorService->getDataDashboardWidgetDoughnut($indicator);
        
        $dataChartColumn = array();
        $seeInColumn = false;
        $seeInColumnSingleAxis = false;
        
        $arrayIdProduccion = array();
        $arrayIdProduccion[] = 1; 
        
        if($indicator->getIndicatorLevel()->getLevel() == IndicatorLevel::LEVEL_TACTICO){
            if(in_array($indicator->getParent()->getId(), $arrayIdProduccion)){
                $seeInColumn = true;
                $dataChartColumn = $indicatorService->getChartColumnLineDualAxis($indicator);
            }
        } elseif($indicator->getIndicatorLevel()->getLevel() == IndicatorLevel::LEVEL_OPERATIVO){
            if(in_array($indicator->getParent()->getParent()->getId(), $arrayIdProduccion)){
                $seeInColumn = true;
                $seeInColumnSingleAxis = true;
                $dataChartColumn = $indicatorService->getDataChartOfResultIndicator($indicator);
            }
        }
        
        return array(
            'iconsLineStrategic' => $iconsLineStrategic,
            'linesStrategics' => $linesStrategics,
            'idLineStrategic' => $idLineStrategic,
            'seeTree' => $seeTree,
            'boxRender' => $boxRender,
            'indicatorsGroup' => $indicatorsGroup,
            'dataWidget' => $dataWidget,
            'indicator' => $indicator,
//            'dataMultiLevelPie' => $dataMultiLevelPie,
            'dataChart' => $dataChart,
            'indicatorService' => $indicatorService,
            'seeInColumn' => $seeInColumn,
            'seeInColumnSingleAxis' => $seeInColumnSingleAxis,
            'dataChartColumn' => $dataChartColumn,
        );
    }
    
    
    public function hasPermission() {
        return $this->isGranted(array('ROLE_DIRECTIVE','ROLE_DIRECTIVE_AUX','ROLE_WORKER_PLANNING'));
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
