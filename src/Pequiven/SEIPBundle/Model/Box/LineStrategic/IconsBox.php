<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Model\Box\LineStrategic;

use Tecnocreaciones\Bundle\BoxBundle\Model\GenericBox;
use Pequiven\MasterBundle\Entity\LineStrategic;

/**
 * Description of IconsBox
 *
 */
class IconsBox extends GenericBox 
{
    public function getDescription() {
        return 'Contiene una lista de las líneas estratégicas en formato de íconos';
    }

    public function getName() {
        return 'pequiven_seip_box_linestrategic_viewdashboard';
    }

    public function getParameters() {
        
        $em = $this->getDoctrine()->getManager();
        
        $iconsLineStrategic = LineStrategic::getIcons();
        $linesStrategics = $this->container->get('pequiven.repository.linestrategic')->findBy(array('deletedAt' => null));
        
//        var_dump(count($linesStrategics));
//        die();
                           
//        $datas = array();
//        $dataRealTactic = array();
//        $dataPlanTactic = array();
//        $dataPorcTactic = array();
//        $dataLinkTactic = array();
//        $categories = array();
//        
//        //Resultados Tácticos
//        $resultsTactics = $this->container->get('pequiven.repository.monitor')->getTotalObjetivesTacticByGerenciaGroup();
//        
//        foreach($resultsTactics as $resultTactic){
//            $resTactic = $resultTactic['PlanObjTactic'] == 0 ? bcadd(0,'0',2) : bcadd(((float)$resultTactic['RealObjTactic'] / (float)$resultTactic['PlanObjTactic']) * 100,'0',2);
//            $urlTypeGroup =  $this->generateUrl('monitorObjetiveTacticByGroup', array('typeGroup' => $resultTactic['Grupo']));
//            $dataPorcTactic[] = array('value' => $resTactic, 'link' => $urlTypeGroup);
//            $dataPlanTactic[] = array('value' => $resultTactic['PlanObjTactic'], 'link' => $urlTypeGroup);
//            $dataRealTactic[] = array('value' => $resultTactic['RealObjTactic'], 'link' => $urlTypeGroup);
//            $dataLinkTactic[] = array('typeGroup' => $resultTactic['Descripcion'],'porcCarga' => $resTactic, 'linkTypeGroup' => $urlTypeGroup);
//            $categories[] = array('label' => $resultTactic['Descripcion']);
//        }
//        $optionsChart = array('typeLabel' => 'auto');
//        
//        $datas['dataPorcTactic'] = $dataPorcTactic;
//        $datas['dataPlanTactic'] = $dataPlanTactic;
//        $datas['dataRealTactic'] = $dataRealTactic;
//        $datas['dataLinkTactic'] = $dataLinkTactic;
//        $datas['categories'] = $categories;
//        $datas['optionsChart'] = $optionsChart;
//        
        
        return array(
            'iconsLineStrategic' => $iconsLineStrategic,
            'linesStrategics' => $linesStrategics,
        );
    }
    
    public function hasPermission() {
        return $this->isGranted(array('ROLE_DIRECTIVE','ROLE_DIRECTIVE_AUX','ROLE_WORKER_PLANNING'));
    }
    
    public function getTemplateName() {
        return 'PequivenSEIPBundle:LineStrategic:Dashboard/viewGroup.html.twig';
    }
    
    public function getTranslationDomain() {
        return 'PequivenSEIPBundle';
    }
    
    public function getAreasPermitted() {
        return array(
            \Pequiven\SEIPBundle\Model\Box\AreasBox::DASHBOARD,
            \Pequiven\SEIPBundle\Model\Box\AreasBox::PRINCIPAL
        );
    }
}
