<?php

namespace Pequiven\SEIPBundle\Model\Box\Indicator\Operative;

use Tecnocreaciones\Bundle\BoxBundle\Model\GenericBox;

/**
 * Resumen de los indicadores cargados a nivel operativo en donde se muestra el plan y el total a cargar durante el período seleccionado.
 *
 * @author matias
 */
class SummaryBoxIndicatorCharged extends GenericBox
{
    
    public function getName() {
        return 'pequiven_seip_box_operative_summaryindicatorcharged';
    }
    
    public function getTemplateName() {
        return 'PequivenSEIPBundle:Monitor:Operative/summaryIndicatorChargedGerenciaFirstGroup.html.twig';
    }
    
    public function getParameters() {
        $datas = $this->getDataIndicatorOperativeGroup();
        return array(
            'indicatorOperative' => $datas['indicatorOperative']
            );
    }
    
    /**
     * Función que obtiene los Indicadores Operativos agrupados por tipo de Gerencia de 1ra Línea
     * @return type
     */
    public function getDataIndicatorOperativeGroup(){
        $em = $this->getDoctrine()->getManager();
        
        $datas = array();
        $indicatorOperative = array();
        $dataLinkOperative = array();
        
        //Resultados Operativos
        $resultsOperatives = $this->container->get('pequiven.repository.monitor')->getTotalIndicatorOperativeByGerenciaGroup();
        
        foreach($resultsOperatives as $resultOperative){
            $resOperative = $resultOperative['PlanIndOperative'] == 0 ? bcadd(0,'0',2) : bcadd(((float)$resultOperative['RealIndOperative'] / (float)$resultOperative['PlanIndOperative']) * 100,'0',2);
            $indicatorOperative[] = array(
                'description' => $resultOperative['Descripcion'],
                'realOperative' => $resultOperative['RealIndOperative'],
                'planOperative' => $resultOperative['PlanIndOperative'],
                'porcOperative' => $resOperative,
                'res' => (float)$resOperative
            );
            $dataLinkOperative[] = array('typeGroup' => $resultOperative['Descripcion'],'porcCarga' => $resOperative,'linkTypeGroup' => $this->generateUrl('monitorObjetiveOperativeByGroup', array('typeGroup' => $resultOperative['Grupo'])));
        }
        
        $datas['dataLinkOperative'] = $dataLinkOperative;
        $datas['indicatorOperative'] = $indicatorOperative;
        
        return $datas;
    }
    
    public function getAreasNotPermitted() 
    {
        return array(
            \Pequiven\SEIPBundle\Model\Box\AreasBox::EVENTS
        );
    }
    
    public function hasPermission() {
        return $this->isGranted(array('ROLE_WORKER_PLANNING'));
    }
    
    public function getTranslationDomain() {
        return 'PequivenSEIPBundle';
    }
    
    public function getDescription() {
        return 'Resumen de los indicadores cargados a nivel operativo.';
    }
}