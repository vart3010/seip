<?php

namespace Pequiven\SEIPBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController as baseController;

class DefaultController extends Controller {

    /**
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
        //die();

        return array(
            'dataPlan' => $datas['dataPlan'],
            'dataReal' => $datas['dataReal'],
            'dataPorc' => $datas['dataPorc'],
            'categories' => $categories
                );
    }

    /**
     * Función que retorna la data para el gráfico
     * @return boolean
     */
    public function getDataObjetivesChart() {
        $em = $this->getDoctrine()->getManager();
        $datas = array();
        $dataReal = array();
        $dataPlan = array();
        $dataPorc = array();
        
        $results = $em->getRepository('PequivenSEIPBundle:Monitor')->getTotalObjetivesByGerenciaGroup();
        //var_dump($results);
        foreach($results as $result){
            $res = $result['PlanObjTactic'] == 0 ? bcadd(0,'0',2) : bcadd(((float)$result['RealObjTactic'] / (float)$result['PlanObjTactic']) * 100,'0',2);
            $dataPorc[] = array('value' => $res);
            $dataPlan[] = array('value' => $result['PlanObjTactic']);
            $dataReal[] = array('value' => $result['RealObjTactic']);
        }
        $datas['dataPorc'] = $dataPorc;
        $datas['dataPlan'] = $dataPlan;
        $datas['dataReal'] = $dataReal;
        
        return $datas;
    }

}
