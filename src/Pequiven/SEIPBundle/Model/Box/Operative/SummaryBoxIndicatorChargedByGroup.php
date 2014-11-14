<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\SEIPBundle\Model\Box\Operative;

use Tecnocreaciones\Bundle\BoxBundle\Model\GenericBox;
/**
 * Description of SummaryIndicatorCharged
 *
 * @author matias
 */
class SummaryBoxIndicatorChargedByGroup extends GenericBox {
    
    public function getName() {
            return 'pequiven_seip_box_operative_summaryindicatorchargedbygroup';
    }
    
    public function getTemplateName() {
        return 'PequivenSEIPBundle:Monitor:Operative/summaryIndicatorChargedGerenciaFirstByGroup.html.twig';
    }
    
    public function getParameters() {
        $em = $this->getDoctrine()->getManager();
        
        $datas = $this->getDataIndicatorTacticGroup();
        return array(
            'indicatorOperative' => $datas['indicatorOperative']
            );
    }
    
    /**
     * Función que obtiene los Indicadores Operativos agrupados por tipo de Gerencia de 1ra Línea
     * @return type
     */
    public function getDataIndicatorTacticGroup(){
        $em = $this->getDoctrine()->getManager();
        
        $typeGroup = $this->getRequest()->get("typeGroup");
        
        $datas = array();
        $indicatorOperative = array();
        $dataLinkTactic = array();
        
        //Resultados Operativos
        $resultsOperatives = $em->getRepository('PequivenSEIPBundle:Monitor')->getTotalIndicatorOperativeByGerenciaGroup(array('typeGroup' => $typeGroup));
        
        foreach($resultsOperatives as $resultOperative){
            $resOperative = $resultOperative['PlanIndOperative'] == 0 ? bcadd(0,'0',2) : bcadd(((float)$resultOperative['RealIndOperative'] / (float)$resultOperative['PlanIndOperative']) * 100,'0',2);
            $indicatorOperative[] = array(
                'gerencia' => $resultOperative['Gerencia'],
                'realOperative' => $resultOperative['RealIndOperative'],
                'planOperative' => $resultOperative['PlanIndOperative'],
                'porcOperative' => $resOperative,
                'res' => (float)$resOperative
            );
//            $dataLinkTactic[] = array('typeGroup' => $resultTactic['Descripcion'],'porcCarga' => $resTactic,'linkTypeGroup' => $this->generateUrl('monitorObjetiveTacticByGroup', array('typeGroup' => $resultTactic['Grupo'])));
        }
        
//        $datas['dataLinkTactic'] = $dataLinkTactic;
        $datas['indicatorOperative'] = $indicatorOperative;
        
        return $datas;
    }
}
