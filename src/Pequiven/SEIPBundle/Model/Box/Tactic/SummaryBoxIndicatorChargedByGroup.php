<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\SEIPBundle\Model\Box\Tactic;

use Tecnocreaciones\Bundle\BoxBundle\Model\GenericBox;
/**
 * Description of SummaryIndicatorCharged
 *
 * @author matias
 */
class SummaryBoxIndicatorChargedByGroup extends GenericBox {
    
    public function getName() {
            return 'pequiven_seip_box_tactic_summaryindicatorchargedbygroup';
    }
    
    public function getTemplateName() {
        return 'PequivenSEIPBundle:Monitor:Tactic/summaryIndicatorChargedGerenciaFirstByGroup.html.twig';
    }
    
    public function getParameters() {
        $em = $this->getDoctrine()->getManager();
        
        $datas = $this->getDataIndicatorTacticGroup();
        return array(
            'indicatorTactic' => $datas['indicatorTactic']
            );
    }
    
    /**
     * Función que obtiene los Indicadores Tácticos agrupados por tipo de Gerencia de 1ra Línea
     * @return type
     */
    public function getDataIndicatorTacticGroup(){
        $em = $this->getDoctrine()->getManager();
        
        $typeGroup = $this->getRequest()->get("typeGroup");
        
        $datas = array();
        $indicatorTactic = array();
        $dataLinkTactic = array();
        
        //Resultados Tácticos
        $resultsTactics = $em->getRepository('PequivenSEIPBundle:Monitor')->getTotalIndicatorTacticByGerenciaGroup(array('typeGroup' => $typeGroup));
        
        foreach($resultsTactics as $resultTactic){
            $resTactic = $resultTactic['PlanIndTactic'] == 0 ? bcadd(0,'0',2) : bcadd(((float)$resultTactic['RealIndTactic'] / (float)$resultTactic['PlanIndTactic']) * 100,'0',2);
            $indicatorTactic[] = array(
                'gerencia' => $resultTactic['Gerencia'],
                'realTactic' => $resultTactic['RealIndTactic'],
                'planTactic' => $resultTactic['PlanIndTactic'],
                'porcTactic' => $resTactic,
                'res' => (float)$resTactic
            );
//            $dataLinkTactic[] = array('typeGroup' => $resultTactic['Descripcion'],'porcCarga' => $resTactic,'linkTypeGroup' => $this->generateUrl('monitorObjetiveTacticByGroup', array('typeGroup' => $resultTactic['Grupo'])));
        }
        
//        $datas['dataLinkTactic'] = $dataLinkTactic;
        $datas['indicatorTactic'] = $indicatorTactic;
        
        return $datas;
    }
}
