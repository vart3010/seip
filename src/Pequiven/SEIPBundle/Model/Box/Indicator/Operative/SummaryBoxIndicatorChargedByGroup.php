<?php

namespace Pequiven\SEIPBundle\Model\Box\Indicator\Operative;

use Tecnocreaciones\Bundle\BoxBundle\Model\GenericBox;
/**
 * Resumen de los indicadores cargados a nivel operativo por tipo de gerencia en donde se muestra el plan y el total a cargar durante el período seleccionado.
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
        $datas = $this->getDataIndicatorTacticGroup();
        return array(
            'indicatorOperative' => $datas['indicatorOperative']
            );
    }
    
    public function getDescription() {
        return 'Resumen de los indicadores cargados a nivel operativo por tipo de gerencia.';
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
        $resultsOperatives = $this->container->get('pequiven.repository.monitor')->getTotalIndicatorOperativeByGerenciaGroup(array('typeGroup' => $typeGroup));
        
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
