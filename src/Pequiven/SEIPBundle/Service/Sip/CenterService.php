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
     *
     *
     */
    public function AsignedIdEdo($estado){
        //ASIGNO ID A ESTADOS PARA MEJOR VISTA DE RUTA
        if ($estado == "EDO. CARABOBO") {
            $estado = 1;
        }elseif ($estado == "EDO. ZULIA") {
            $estado = 2;
        }elseif ($estado == "EDO. ANZOATEGUI") {
            $estado = 3;
        }elseif($estado == "OTROS"){
            $estado = 4;
        }

        return $estado;
    }

    /**
     *
     *	Grafica General
     *
     */
    public function getDataChartOfVotoGeneral($type) {
        
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
        
        $chart["captionFontColor"] = "#e20000";
        $chart["sYAxisName"] = "";
        $chart["sNumberSuffix"] = "";
        $chart["sYAxisMaxValue"] = "100";
        $chart["paletteColors"] = "#e20000,#0075c2,#1aaf5d,#e20000,#f2c500,#f45b00,#8e0000";
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

        $em = $this->getDoctrine()->getManager();

        $label = $dataLocalidad = array();

        //Carga de Nombres de Labels
        $dataSetLocal["seriesname"] = "Voto Pequiven";
        //Personal PQV por centro 
        $result = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\NominaCentro")->findAll();

        $resultVal = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\NominaCentro")->findBy(array('descriptionEstado' => "EDO. CARABOBO"));
        $votoNo = $votoSi = 0;

        foreach ($result as $value) {           
            $cedula = $value->getCedula();
            $voto = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\OnePerTen")->findOneBy(array('cedula' => $cedula));  
                if (isset($voto)) {                    
                    if ($voto->getVoto() == 1){
                        $votoSi = $votoSi + 1;
                    }elseif($voto->getVoto() == 0){
                        $votoNo = $votoNo + 1;
                    }                
                }
        }
        if ($type == 1) {
            $caption = "Voto General";
            $votosOneMembers = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->findByEstadoMembers();
            $votoSi = $votoSi + $votosOneMembers[1]["Cant"];
            $votoNo = $votoNo + $votosOneMembers[0]["Cant"];            
        }elseif($type == 2){
            $caption = "Voto General PQV";

        }
        $chart["caption"] = $caption;//Nombre Grafica

            $label = "SI";
            $dataLocal["label"] = $label; //Carga de valores                
            $dataLocal["value"] = $votoSi; //Carga de valores
            $dataSetLocal["data"][] = $dataLocal; //data 

            $label = "NO";
            $dataLocal["label"] = $label; //Carga de valores                
            $dataLocal["value"] = $votoNo; //Carga de valores
            $dataSetLocal["data"][] = $dataLocal; //data 

        $data['dataSource']['chart'] = $chart;                
        $data['dataSource']['dataset'][] = $dataSetLocal;

        return $data;
    }

    public function getDataChartOfVotoGeneralLine() {
        
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

        $chart["caption"] = "Votos por Hora";
        $chart["captionFontColor"] = "#e20000";
        $chart["captionFontSize"] = "20";                
        $chart["palette"]        = "1";
        $chart["showvalues"]     = "0";
        $chart["paletteColors"]  = "#0075c2,#c90606,#f2c500,#12a830,#1aaf5d";
        $chart["showBorder"] = "0";
        $chart["yaxisvaluespadding"] = "10";
        $chart["valueFontColor"] = "#000000";
        $chart["rotateValues"]   = "0";
        $chart["bgAlpha"] = "0,0";//Fondo 
        $chart["theme"]          = "fint";
        //$chart["YAxisMaxValue"] = "150";
        //$chart["decimalSeparator"] = ",";
        //$chart["decimals"] = "2";
        $chart["showborder"]     = "0";
        $chart["decimals"]       = "0";
        $chart["legendBgColor"] = "#ffffff";
        $chart["legendItemFontSize"] = "10";
        $chart["legendItemFontColor"] = "#666666";
        $chart["outCnvBaseFontColor"] = "#000000";
        $chart["visible"] = "1";

        $em = $this->getDoctrine()->getManager();

        $label = $dataLinea = $dataMeta = array();

        //Carga de Nombres de Labels
        $dataSetLinea["seriesname"] = "Horas";        

        $horas = 13;
        $cont = 0;
        $horaIni = 7;

        for ($i=0; $i <= $horas; $i++) {             
            
            if ($horaIni == 13) {
                $horaIni = $horaIni - 12;
            }            

            $linea = $horaIni.":00";                      
            $label["label"] = $linea;     
            $category[] = $label;
            $horaIni++;
            $cont++;
        
        }

        $votosPrueba = 150;
        for ($i=0; $i <= $horas; $i++) {             
          
            $dataLinea["value"] = $votosPrueba; //Carga de valores
            $dataSetLinea["data"][] = $dataLinea; //data linea
            $votosPrueba = $votosPrueba * 1.5;
        }
            $dataSetValues['votos'] = array('seriesname' => 'Votos * Horas', 'parentyaxis' => 'S', 'renderas' => 'Line', 'color' => '#dbc903', 'data' => $dataSetLinea['data']);
            //$dataMeta["value"] = 0;
            //$dataSetMeta["data"][] = $dataMeta;
        

        $data['dataSource']['chart'] = $chart;
        $data['dataSource']['categories'][]["category"] = $category;
        $data['dataSource']['dataset'][] = $dataSetValues['votos'];
        

        return $data;
        //return json_encode($data);
    }

    /**
     *
     *  Grafica General
     *
     */
    public function getDataChartOfVotoGeneralEstado($estado,$linkValue,$type) {
        
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

        $chart["caption"] = $estado;
        $chart["captionFontColor"] = "#e20000";
        $chart["sYAxisName"] = "";
        $chart["sNumberSuffix"] = "";
        $chart["sYAxisMaxValue"] = "0";
        $chart["paletteColors"] = "#e20000,#0075c2,#1aaf5d,#e20000,#f2c500,#f45b00,#8e0000";
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
        $chart["rotateValues"] = "0";
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
        $chart["legendBgColor"] = "#ffffff";
        $chart["legendItemFontSize"] = "10";
        $chart["legendItemFontColor"] = "#666666";

        $em = $this->getDoctrine()->getManager();

        $label = $dataLocalidad = array();

        //Carga de Nombres de Labels
        $dataSetLocal["seriesname"] = "Voto Pequiven";
        
        $votoNo = $votoSi = 0;

        if ($estado != "OTROS") {
            $resultVal = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\NominaCentro")->findBy(array('descriptionEstado' => $estado));
            foreach ($resultVal as $value) {           
                $cedula = $value->getCedula();
                $voto = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\OnePerTen")->findOneBy(array('cedula' => $cedula));  
                    if (isset($voto)) {                    
                        if ($voto->getVoto() == 1){
                            $votoSi = $votoSi + 1;
                        }elseif($voto->getVoto() == 0){
                            $votoNo = $votoNo + 1;
                        }                
                    }
            }
            
        }else{
            $otros = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->findByEstadoOtros();
            $votoSi = $otros[1]["Cant"];
            $votoNo = $otros[0]["Cant"];
        }

        //SI VIENE DE GENERAL
        if ($type == 1) {            
            $votosOneMembersEdo = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->findByEstadoMembersEdo($estado);
            if (isset($votosOneMembersEdo[1]["Cant"])) {
                $votoSi = $votoSi + $votosOneMembersEdo[1]["Cant"];                
            }
            if (isset($votosOneMembersEdo[0]["Cant"])) {
                $votoNo = $votoNo + $votosOneMembersEdo[0]["Cant"];                            
            }            
            $estado = $this->AsignedIdEdo($estado);
            
            $link  = $this->generateUrl('pequiven_sip_display_voto_general_estado',array('edo' => $estado,'type' => $type));
        }elseif($type == 2){
            $estado = $this->AsignedIdEdo($estado);

            $link  = $this->generateUrl('pequiven_sip_display_voto_pqv_edo',array('edo' => $estado,'type' => $type));            
        }

            if ($linkValue == 1) {
                $dataLocal["link"] = $link;
                $chart["showvalues"]     = "0";
                $chart["showLegend"] = "0";
                $labelSi = "";
                $labelNo = "";
            }else{
                $chart["showvalues"]     = "1";
                $chart["showLegend"] = "1";                
                $labelSi = "SI";
                $labelNo = "NO";
            }

            $dataLocal["label"] = $labelSi; //Carga de valores SI               
            $dataLocal["value"] = $votoSi; //Carga de valores SI
            $dataSetLocal["data"][] = $dataLocal; //data SI

            $dataLocal["label"] = $labelNo; //Carga de valores NO               
            $dataLocal["value"] = $votoNo; //Carga de valores NO
            $dataSetLocal["data"][] = $dataLocal; //data NO

        $data['dataSource']['chart'] = $chart;                
        $data['dataSource']['dataset'][] = $dataSetLocal;

        //return $data;
        return json_encode($data);                
    }

    /**
     *
     *  Grafica General
     *
     */
    public function getDataChartOfVotoGeneralMunicipio($estado,$linkValue,$municipio) {

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

        $chart["caption"] = $municipio;
        $chart["captionFontColor"] = "#e20000";
        $chart["sYAxisName"] = "";
        $chart["sNumberSuffix"] = "";
        $chart["sYAxisMaxValue"] = "0";
        $chart["paletteColors"] = "#e20000,#0075c2,#1aaf5d,#e20000,#f2c500,#f45b00,#8e0000";
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
        $chart["rotateValues"] = "0";
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
        $chart["showLegend"] = "0";
        $chart["legendBgColor"] = "#ffffff";
        $chart["legendItemFontSize"] = "10";
        $chart["legendItemFontColor"] = "#666666";

        $em = $this->getDoctrine()->getManager();

        $label = $dataLocalidad = array();

        //Carga de Nombres de Labels
        $dataSetLocal["seriesname"] = "Voto Pequiven";
        //Personal PQV por centro         
        $votoNo = $votoSi = 0;

        if ($estado != "OTROS") {            
            $mcpoVoto = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->findByVotosMunicipios($municipio, $estado);            
            if (isset($mcpoVoto[0]["Cant"])) {
                $votoNo = $mcpoVoto[0]["Cant"];                            
            }
            if (isset($mcpoVoto[1]["Cant"])) {
                $votoSi = $mcpoVoto[1]["Cant"];                
            }
        }else{
            $otros = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->findByEstadoOtros();
            $votoSi = $otros[1]["Cant"];
            $votoNo = $otros[0]["Cant"];
        }
            //ASIGNO ID A ESTADO ṔARA MEJOR VISTA DE RUTA        
            if ($estado == "EDO. CARABOBO") {
                $estado = 1;
            }elseif ($estado == "EDO. ZULIA") {
                $estado = 2;
            }elseif ($estado == "EDO. ANZOATEGUI") {
                $estado = 3;
            }elseif($estado == "OTROS"){
                $estado = 4;
            }

            $label = "";
            $dataLocal["label"] = $label; //Carga de valores                
            $dataLocal["value"] = $votoSi; //Carga de valores
            if ($linkValue == 1) {
                $dataLocal["link"]  = $this->generateUrl('pequiven_sip_display_voto_general_estado',array('edo' => $estado));
                $chart["showvalues"] = "0";
            }else{
                $chart["showvalues"] = "1";
            }

            $dataSetLocal["data"][] = $dataLocal; //data 

            $label = "";
            $dataLocal["label"] = $label; //Carga de valores                
            $dataLocal["value"] = $votoNo; //Carga de valores
            $dataSetLocal["data"][] = $dataLocal; //data 

        $data['dataSource']['chart'] = $chart;                
        $data['dataSource']['dataset'][] = $dataSetLocal;

        //return $data;
        return json_encode($data);        
    }

    /**
     *
     *  Grafica General
     *
     */
    public function getDataChartOfVotoGeneralParroquia($estado,$linkValue,$parroquia) {

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

        $chart["caption"] = $parroquia;
        $chart["captionFontColor"] = "#e20000";
        $chart["sYAxisName"] = "";
        $chart["sNumberSuffix"] = "";
        $chart["sYAxisMaxValue"] = "0";
        $chart["paletteColors"] = "#e20000,#0075c2,#1aaf5d,#e20000,#f2c500,#f45b00,#8e0000";
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
        $chart["rotateValues"] = "0";
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
        $chart["showLegend"] = "0";
        $chart["legendBgColor"] = "#ffffff";
        $chart["legendItemFontSize"] = "10";
        $chart["legendItemFontColor"] = "#666666";

        $em = $this->getDoctrine()->getManager();

        $label = $dataLocalidad = array();
        var_dump($parroquia);

        //Carga de Nombres de Labels
        $dataSetLocal["seriesname"] = "Voto Pequiven";

        //Personal PQV por centro         
        $votoNo = $votoSi = 0;

        if ($estado != "OTROS") {            
            $mcpoVoto = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->findByVotosMunicipios($municipio);            
            if (isset($mcpoVoto[0]["Cant"])) {
                $votoNo = $mcpoVoto[0]["Cant"];                            
            }
            if (isset($otros[1]["Cant"])) {
                $votoSi = $otros[1]["Cant"];                
            }
        }else{
            $otros = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->findByEstadoOtros();
            $votoSi = $otros[1]["Cant"];
            $votoNo = $otros[0]["Cant"];
        }
            //ASIGNO ID A ESTADO ṔARA MEJOR VISTA DE RUTA        
            if ($estado == "EDO. CARABOBO") {
                $estado = 1;
            }elseif ($estado == "EDO. ZULIA") {
                $estado = 2;
            }elseif ($estado == "EDO. ANZOATEGUI") {
                $estado = 3;
            }elseif($estado == "OTROS"){
                $estado = 4;
            }

            $label = "";
            $dataLocal["label"] = $label; //Carga de valores                
            $dataLocal["value"] = $votoSi; //Carga de valores
            if ($linkValue == 1) {
            $dataLocal["link"]  = $this->generateUrl('pequiven_sip_display_voto_general_estado',array('edo' => $estado));
                $chart["showvalues"] = "0";
            }else{
                $chart["showvalues"] = "1";
            }

            $dataSetLocal["data"][] = $dataLocal; //data 

            $label = "";
            $dataLocal["label"] = $label; //Carga de valores                
            $dataLocal["value"] = $votoNo; //Carga de valores
            $dataSetLocal["data"][] = $dataLocal; //data 

        $data['dataSource']['chart'] = $chart;                
        $data['dataSource']['dataset'][] = $dataSetLocal;

        //return $data;
        return json_encode($data);        
    }

    /**
     *
     *  Grafica de Voto PQV
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
            $cedula = $value->getCedula();

              /*  $voto = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\OnePerTen")->findBy(array('cedula' => $cedula));  
            
                foreach ($voto as $data) {                                                      
                    if ($data->getVoto() == 1){
                        $votoSi = $votoSi + 1;
                    }else{
                        $votoNo = $votoNo + 1;
                    }
                }*/
        }
            $dataCountV = count($resultVal);
            /*$label = "EDO. CARABOBO";
            $dataLocal["label"] = $label; //Carga de valores                
            $dataLocal["value"] = $votoSi; //Carga de valores
            $dataSetLocal["data"][] = $dataLocal; //data */


        $resultZul = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\NominaCentro")->findBy(array('descriptionEstado' => "EDO. ZULIA"));
            $label = "EDO. ZULIA";  
            $dataCountZ = count($resultZul);      
            $dataLocal["label"] = $label; //Carga de valores                
            $dataLocal["value"] = $dataCountZ; //Carga de valores
            $dataSetLocal["data"][] = $dataLocal; //data
        
        $otros = $result - ($dataCountV + $dataCountZ);
            $label = "OTROS";           
            $dataLocal["label"] = $label; //Carga de valores                
            $dataLocal["value"] = $otros; //Carga de valores
            $dataSetLocal["data"][] = $dataLocal; //data
        

        $data['dataSource']['chart'] = $chart;                
        $data['dataSource']['dataset'][] = $dataSetLocal;

        return $data;
    }

    /**
     * Generates a URL from the given parameters.
     *
     * @param string         $route         The name of the route
     * @param mixed          $parameters    An array of parameters
     * @param bool|string    $referenceType The type of reference (one of the constants in UrlGeneratorInterface)
     *
     * @return string The generated URL
     *
     * @see UrlGeneratorInterface
     */
    protected function generateUrl($route, $parameters = array(), $referenceType = \Symfony\Component\Routing\Generator\UrlGeneratorInterface::ABSOLUTE_PATH) {
        return $this->container->get('router')->generate($route, $parameters, $referenceType);
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