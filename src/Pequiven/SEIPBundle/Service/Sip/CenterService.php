<?php

namespace Pequiven\SEIPBundle\Service\Sip;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Bundle\DoctrineBundle\Registry;
use ErrorException;
use Exception;
use LogicException;
use Pequiven\SEIPBundle\Model\Common\CommonObject;

class CenterService implements ContainerAwareInterface {

    private $container;

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    /**
     *
     *	Grafica de Voto PQV
     *
     */
    public function getDataChartOfVotoPqv() {
        
        $data = array(
            'dataSource' => array(
                'chart' => array(),
                'categories' => array(
                ),
                'dataset' => array(
                ),
            ),
        );
        $chart = array();

        $chart["caption"] = "Voto Pequiven";
        $chart["captionFontColor"] = "#e20000";
        $chart["sYAxisName"] = "";
        $chart["sNumberSuffix"] = "";
        $chart["sYAxisMaxValue"] = "100";
        $chart["paletteColors"] = "#0075c2,#1aaf5d,#e20000,#f2c500,#f45b00,#8e0000";
        $chart["bgColor"] = "#ffffff";
        $chart["showBorder"] = "0";
        $chart["showCanvasBorder"] = "0";
        $chart["usePlotGradientColor"] = "0";
        $chart["plotBorderAlpha"] = "10";
        $chart["legendBorderAlpha"] = "0";
        $chart["legendBgAlpha"] = "0";
        $chart["bgAlpha"] = "0,0";//Fondo 
        $chart["legendShadow"] = "0";
        $chart["showHoverEffect"] = "0";
        $chart["valueFontColor"] = "#000000";
        $chart["valuePosition"] = "ABOVE";
        $chart["rotateValues"] = "1";
        $chart["placeValuesInside"] = "0";
        $chart["divlineColor"] = "#999999";
        $chart["divLineDashed"] = "1";
        $chart["divLineDashLen"] = "1";
        $chart["divLineGapLen"] = "1";
        $chart["canvasBgColor"] = "#ffffff";
        $chart["captionFontSize"] = "20";
        $chart["subcaptionFontSize"] = "14";
        $chart["subcaptionFontBold"] = "0";
        $chart["decimalSeparator"] = ",";
        $chart["thousandSeparator"] = ".";
        $chart["inDecimalSeparator"] = ",";
        $chart["inThousandSeparator"] = ".";
        $chart["decimals"] = "2";
        $chart["formatNumberScale"] = "0";
        $chart["toolTipColor"] = "#ffffff";
        $chart["toolTipBgColor"] = "#000000";
        $chart["toolTipBgAlpha"] = "0";
        $chart["toolTipBorderRadius"] = "2";
        $chart["toolTipPadding"] = "5";
        $chart["showLegend"] = "1";
        $chart["legendBgColor"] = "#ffffff";
        $chart["legendItemFontSize"] = "10";
        $chart["legendItemFontColor"] = "#666666";

        //Export
        $chart["exportenabled"] = "0";
        $chart["exportatclient"] = "0";
        $chart["exportFormats"] = "PNG= Exportar como PNG|PDF= Exportar como PDF";
        $chart["exportFileName"] = "Grafico Resultados ";
        $chart["exporthandler"] = "http://107.21.74.91/";

        $em = $this->getDoctrine()->getManager();

        $label = $dataLocalidad = array();

        //Carga de Nombres de Labels
        $dataSetLocal["seriesname"] = "Voto Pequiven";
        //Personal PQV por centro 
        $result = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\NominaCentro")->findAll();
		$result = count($result);

        $resultVal = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\NominaCentro")->findBy(array('descriptionEstado' => "EDO. CARABOBO"));
        $votoNo = $votoSi = 0;

        foreach ($resultVal as $value) {
        	
        	$voto = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\OnePerTen")->findOneBy(array('cedula' => 12779136 ));
        	var_dump(count($voto));
        	die();
        		foreach ($voto as $data) {        		        			        			
        			if ($data->getVoto() == 1){
        				$votoSi = $votoSi + 1;
        			}else{
        				$votoNo = $votoNo + 1;
        			}
        		}
        }
        	$label = "EDO. CARABOBO";
        	$dataCountV = count($resultVal);
        	$dataLocal["label"] = $label; //Carga de valores        		
            $dataLocal["value"] = $votoSi; //Carga de valores
            $dataSetLocal["data"][] = $dataLocal; //data 


        /*$resultZul = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\NominaCentro")->findBy(array('descriptionEstado' => "EDO. ZULIA"));
        	$label = "EDO. ZULIA";  
        	$dataCountZ = count($resultZul);      
        	$dataLocal["label"] = $label; //Carga de valores        		
        	$dataLocal["value"] = $dataCountZ; //Carga de valores
            $dataSetLocal["data"][] = $dataLocal; //data
        
        $otros = $result - ($dataCountV + $dataCountZ);
            $label = "OTROS";          	
        	$dataLocal["label"] = $label; //Carga de valores        		
        	$dataLocal["value"] = $otros; //Carga de valores
            $dataSetLocal["data"][] = $dataLocal; //data*/
        

        $data['dataSource']['chart'] = $chart;                
        $data['dataSource']['dataset'][] = $dataSetLocal;

        return $data;
    }

    /**
     * Shortcut to return the Doctrine Registry service.
     *
     * @return Registry
     *
     * @throws LogicException If DoctrineBundle is not available
     */
    public function getDoctrine() {
        if (!$this->container->has('doctrine')) {
            throw new LogicException('The DoctrineBundle is not registered in your application.');
        }

        return $this->container->get('doctrine');
    }
}