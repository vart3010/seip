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
        $i = 0;
        foreach($datas['dataLinkOperative'] as $data){
            $datas['dataLinkOperative'][$i]['typeGroup'] = $categories[$i]['label'];
            $i++;
        }
        return array(
            'dataPlanTactic' => $datas['dataPlanTactic'],
            'dataRealTactic' => $datas['dataRealTactic'],
            'dataPorcTactic' => $datas['dataPorcTactic'],
            'dataLinkTactic' => $datas['dataLinkTactic'],
            'dataPlanOperative' => $datas['dataPlanOperative'],
            'dataRealOperative' => $datas['dataRealOperative'],
            'dataPorcOperative' => $datas['dataPorcOperative'],
            'dataLinkOperative' => $datas['dataLinkOperative'],
            'categories' => $categories
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
        $dataRealOperative = array();
        $dataPlanOperative = array();
        $dataPorcOperative = array();
        $dataLinkOperative = array();
        
        //Resultados Tácticos
        $resultsTactics = $em->getRepository('PequivenSEIPBundle:Monitor')->getTotalObjetivesTacticByGerenciaGroup();
        //var_dump($results);
        foreach($resultsTactics as $resultTactic){
            $resTactic = $resultTactic['PlanObjTactic'] == 0 ? bcadd(0,'0',2) : bcadd(((float)$resultTactic['RealObjTactic'] / (float)$resultTactic['PlanObjTactic']) * 100,'0',2);
            $dataPorcTactic[] = array('value' => $resTactic);
            $dataPlanTactic[] = array('value' => $resultTactic['PlanObjTactic']);
            $dataRealTactic[] = array('value' => $resultTactic['RealObjTactic']);
            $dataLinkTactic[] = array('typeGroup' => $resultTactic['typeGroup'],'porcCarga' => $resTactic);
        }
        $datas['dataPorcTactic'] = $dataPorcTactic;
        $datas['dataPlanTactic'] = $dataPlanTactic;
        $datas['dataRealTactic'] = $dataRealTactic;
        $datas['dataLinkTactic'] = $dataLinkTactic;
        
        //Resultados Operativos
        $resultsOperatives = $em->getRepository('PequivenSEIPBundle:Monitor')->getTotalObjetivesOperativeByGerenciaGroup();
        
        foreach($resultsOperatives as $resultOperative){
            $resOperative = $resultOperative['PlanObjOperative'] == 0 ? bcadd(0,'0',2) : bcadd(((float)$resultOperative['RealObjOperative'] / (float)$resultOperative['PlanObjOperative']) * 100,'0',2);
            $dataPorcOperative[] = array('value' => $resOperative);
            $dataPlanOperative[] = array('value' => $resultOperative['PlanObjOperative']);
            $dataRealOperative[] = array('value' => $resultOperative['RealObjOperative']);
            $dataLinkOperative[] = array('typeGroup' => $resultOperative['typeGroup'],'porcCarga' => $resOperative);
        }
        $datas['dataPorcOperative'] = $dataPorcOperative;
        $datas['dataPlanOperative'] = $dataPlanOperative;
        $datas['dataRealOperative'] = $dataRealOperative;
        $datas['dataLinkOperative'] = $dataLinkOperative;
        
        return $datas;
    }

}
