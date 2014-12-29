<?php

namespace Pequiven\SEIPBundle\Model\Box\Operative;

use Tecnocreaciones\Bundle\BoxBundle\Model\GenericBox;

/**
 * Resumen de los indicadores cargados a nivel operativo.
 *
 * @author matias
 */
class SummaryBoxIndicatorCharged extends GenericBox {
    
    public function getName() {
        return 'pequiven_seip_box_operative_summaryindicatorcharged';
    }
    
    public function getTemplateName() {
        return 'PequivenSEIPBundle:Monitor:Operative/summaryIndicatorChargedGerenciaFirstGroup.html.twig';
    }
    
    public function getParameters() {
        $em = $this->getDoctrine()->getManager();
        
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
        $resultsOperatives = $em->getRepository('PequivenSEIPBundle:Monitor')->getTotalIndicatorOperativeByGerenciaGroup();
        
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
    
    public function getDescription() {
        return 'Resumen de los indicadores cargados a nivel operativo.';
    }
}