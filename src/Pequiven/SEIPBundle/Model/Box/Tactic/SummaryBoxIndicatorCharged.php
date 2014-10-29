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
class SummaryBoxIndicatorCharged extends GenericBox {
    
    public function getName() {
        return 'pequiven_seip_box_tactic_summaryindicatorcharged';
    }
    
    public function getTemplateName() {
        return 'PequivenSEIPBundle:Monitor:Tactic/summaryIndicatorChargedGerenciaFirstGroup.html.twig';
    }
    
    public function getParameters() {
        $em = $this->getDoctrine()->getManager();
        
        $datas = $this->getDataIndicatorTacticGroup();
        
        return array(
            'dataRealTactic' => $datas['dataRealTactic'],
            'dataPlanTactic' => $datas['dataPlanTactic'],
            'dataPorcTactic' => $datas['dataPorcTactic'],
            'categories' => $datas['categories'],
            );
    }
    
    /**
     * Función que obtiene los Indicadores Tácticos agrupados por tipo de Gerencia de 1ra Línea
     * @return type
     */
    public function getDataIndicatorTacticGroup(){
        $em = $this->getDoctrine()->getManager();
        
        $datas = array();
        $dataRealTactic = array();
        $dataPlanTactic = array();
        $dataPorcTactic = array();
        $dataLinkTactic = array();
        $categories = array();
        
        //Resultados Operativos
        $resultsTactics = $em->getRepository('PequivenSEIPBundle:Monitor')->getTotalIndicatorTacticByGerenciaGroup();
        
        foreach($resultsTactics as $resultTactic){
            $resTactic = $resultTactic['PlanIndTactic'] == 0 ? bcadd(0,'0',2) : bcadd(((float)$resultTactic['RealIndTactic'] / (float)$resultTactic['PlanIndTactic']) * 100,'0',2);
            $dataPorcTactic[] = array('value' => $resTactic);
            $dataPlanTactic[] = array('value' => $resultTactic['PlanIndTactic']);
            $dataRealTactic[] = array('value' => $resultTactic['RealIndTactic']);
            $dataLinkTactic[] = array('typeGroup' => $resultTactic['Descripcion'],'porcCarga' => $resTactic,'linkTypeGroup' => $this->generateUrl('monitorObjetiveTacticByGroup', array('typeGroup' => $resultTactic['Grupo'])));
            $categories[] = array('label' => $resultTactic['Descripcion']);
        }
        
        $datas['dataPorcTactic'] = $dataPorcTactic;
        $datas['dataPlanTactic'] = $dataPlanTactic;
        $datas['dataRealTactic'] = $dataRealTactic;
        $datas['dataLinkTactic'] = $dataLinkTactic;
        $datas['categories'] = $categories;
        
        return $datas;
    }
}
