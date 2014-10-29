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
        $categories = array();
        $categories[] = array('label' => "Comercializadoras");
        $categories[] = array('label' => "Complejos");
        $categories[] = array('label' => "Sede Corporativa");
        $categories[] = array('label' => "Proyectos");
        
        $datas = $this->getDataObjetivesChart();
        $i = 0;
        foreach($datas['dataLinkTactic'] as $data){
            $datas['dataLinkTactic'][$i]['typeGroup'] = $categories[$i]['label'];
            $i++;
        }
        $boxRender = $this->get('tecnocreaciones_box.render');
        return array(
            'dataPlanTactic' => $datas['dataPlanTactic'],
            'dataRealTactic' => $datas['dataRealTactic'],
            'dataPorcTactic' => $datas['dataPorcTactic'],
            'dataLinkTactic' => $datas['dataLinkTactic'],
            'categories' => $categories,
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
        
        //Resultados Tácticos
        $resultsTactics = $em->getRepository('PequivenSEIPBundle:Monitor')->getTotalObjetivesTacticByGerenciaGroup();
        //var_dump($results);
        foreach($resultsTactics as $resultTactic){
            $resTactic = $resultTactic['PlanObjTactic'] == 0 ? bcadd(0,'0',2) : bcadd(((float)$resultTactic['RealObjTactic'] / (float)$resultTactic['PlanObjTactic']) * 100,'0',2);
            $dataPorcTactic[] = array('value' => $resTactic);
            $dataPlanTactic[] = array('value' => $resultTactic['PlanObjTactic']);
            $dataRealTactic[] = array('value' => $resultTactic['RealObjTactic']);
            $dataLinkTactic[] = array('typeGroup' => $resultTactic['typeGroup'],'porcCarga' => $resTactic, 'linkTypeGroup' => $this->generateUrl('monitorObjetiveTacticByGroup', array('typeGroup' => $resultTactic['typeGroup'])));
        }
        $datas['dataPorcTactic'] = $dataPorcTactic;
        $datas['dataPlanTactic'] = $dataPlanTactic;
        $datas['dataRealTactic'] = $dataRealTactic;
        $datas['dataLinkTactic'] = $dataLinkTactic;
        
        return $datas;
    }

}
