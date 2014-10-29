<?php

namespace Pequiven\SEIPBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController as baseController;

class DefaultController extends Controller {

    /** Página Principal del Sistema
     * @Route("/")
     * @Template()
     */
    public function indexAction() {
        
        $datas = $this->getDataObjetivesChart();
        
        $boxRender = $this->get('tecnocreaciones_box.render');
        return array(
            'dataPlanTactic' => $datas['dataPlanTactic'],
            'dataRealTactic' => $datas['dataRealTactic'],
            'dataPorcTactic' => $datas['dataPorcTactic'],
            'dataLinkTactic' => $datas['dataLinkTactic'],
            'optionsChart' => $datas['optionsChart'],
            'categories' => $datas['categories'],
            'boxRender' => $boxRender,
        );
    }

    /**
     * Función que retorna la data para los gráficos de la página principal
     * @return boolean
     */
    public function getDataObjetivesChart() {
        $em = $this->getDoctrine()->getManager();
        $datas = array();
        $dataRealTactic = array();
        $dataPlanTactic = array();
        $dataPorcTactic = array();
        $dataLinkTactic = array();
        $categories = array();
        
        //Resultados Tácticos
        $resultsTactics = $em->getRepository('PequivenSEIPBundle:Monitor')->getTotalObjetivesTacticByGerenciaGroup();
        
        foreach($resultsTactics as $resultTactic){
            $resTactic = $resultTactic['PlanObjTactic'] == 0 ? bcadd(0,'0',2) : bcadd(((float)$resultTactic['RealObjTactic'] / (float)$resultTactic['PlanObjTactic']) * 100,'0',2);
            $dataPorcTactic[] = array('value' => $resTactic);
            $dataPlanTactic[] = array('value' => $resultTactic['PlanObjTactic']);
            $dataRealTactic[] = array('value' => $resultTactic['RealObjTactic']);
            $dataLinkTactic[] = array('typeGroup' => $resultTactic['Descripcion'],'porcCarga' => $resTactic, 'linkTypeGroup' => $this->generateUrl('monitorObjetiveTacticByGroup', array('typeGroup' => $resultTactic['Grupo'])));
            $categories[] = array('label' => $resultTactic['Descripcion']);
        }
        $optionsChart = array('typeLabel' => 'auto');
        
        $datas['dataPorcTactic'] = $dataPorcTactic;
        $datas['dataPlanTactic'] = $dataPlanTactic;
        $datas['dataRealTactic'] = $dataRealTactic;
        $datas['dataLinkTactic'] = $dataLinkTactic;
        $datas['categories'] = $categories;
        $datas['optionsChart'] = $optionsChart;
        
        return $datas;
    }

}
