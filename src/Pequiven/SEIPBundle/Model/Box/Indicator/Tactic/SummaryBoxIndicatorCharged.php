<?php

namespace Pequiven\SEIPBundle\Model\Box\Indicator\Tactic;

use Tecnocreaciones\Bundle\BoxBundle\Model\GenericBox;

/**
 * Resumen de los indicadores cargados a nivel tactico en donde se muestra el plan y el total a cargar durante el período seleccionado.
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
        $datas = $this->getDataIndicatorTacticGroup();
        return array(
            'indicatorTactic' => $datas['indicatorTactic']
            );
    }
    
    public function getDescription() {
        return 'Resumen de los indicadores cargados a nivel tactico.';
    }
    
    /**
     * Función que obtiene los Indicadores Tácticos agrupados por tipo de Gerencia de 1ra Línea
     * @return type
     */
    public function getDataIndicatorTacticGroup(){
        $em = $this->getDoctrine()->getManager();
        
        $datas = array();
        $indicatorTactic = array();
        $dataLinkTactic = array();
        
        //Resultados Operativos
        $resultsTactics = $this->container->get('pequiven.repository.monitor')->getTotalIndicatorTacticByGerenciaGroup();
        
        foreach($resultsTactics as $resultTactic){
            $resTactic = $resultTactic['PlanIndTactic'] == 0 ? bcadd(0,'0',2) : bcadd(((float)$resultTactic['RealIndTactic'] / (float)$resultTactic['PlanIndTactic']) * 100,'0',2);
            $indicatorTactic[] = array(
                'description' => $resultTactic['Descripcion'],
                'realTactic' => $resultTactic['RealIndTactic'],
                'planTactic' => $resultTactic['PlanIndTactic'],
                'porcTactic' => $resTactic,
                'res' => (float)$resTactic
            );
            $dataLinkTactic[] = array('typeGroup' => $resultTactic['Descripcion'],'porcCarga' => $resTactic,'linkTypeGroup' => $this->generateUrl('monitorObjetiveTacticByGroup', array('typeGroup' => $resultTactic['Grupo'])));
        }
        
        $datas['dataLinkTactic'] = $dataLinkTactic;
        $datas['indicatorTactic'] = $indicatorTactic;
        
        return $datas;
    }
    
    public function getTranslationDomain() {
        return 'PequivenSEIPBundle';
    }
    
    public function hasPermission() {
        return $this->isGranted(array('ROLE_WORKER_PLANNING'));
    }
    
    public function getAreasNotPermitted() 
    {
        return array(
            \Pequiven\SEIPBundle\Model\Box\AreasBox::EVENTS
        );
    }
}
