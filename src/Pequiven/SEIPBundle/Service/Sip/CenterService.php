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
            $estado = 7;
        }elseif ($estado == "EDO. ZULIA") {
            $estado = 21;
        }elseif ($estado == "EDO. ANZOATEGUI") {
            $estado = 2;
        }elseif($estado == "OTROS"){
            $estado = 30;
        }

        return $estado;
    }

    /**
     *
     *
     *
     */
    public function AsignedDescriptionEdo($estado){
        //ASIGNO ID A ESTADOS PARA MEJOR VISTA DE RUTA
        if ($estado == 7) {
            $estado = "EDO. CARABOBO";
        }elseif ($estado == 21) {
            $estado = "EDO. ZULIA";
        }elseif ($estado == 2) {
            $estado = "EDO. ANZOATEGUI";
        }elseif($estado == 30){
            $estado = "OTROS";
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
        $chart["valueFontColor"] = "#ffffff";
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
        
        $votoNo = $votoSi = 0;

        $resultVal = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->findByEstado();
        $votoNo = $resultVal[0]["SUM(votoNO)"];
        $votoSi = $resultVal[0]["SUM(votoSI)"];        

        if ($type == 1) {
            $caption = "Voto General";
            $votosOneMembers = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->findByEstadoMembers();
            $votoNo = $votoNo + $votosOneMembers[0]["SUM(votoNO)"];
            $votoSi = $votoSi + $votosOneMembers[0]["SUM(votoSI)"];            
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

        return json_encode($data);        
    }
    
    /**
     *
     *  Grafica de Votos por Hora
     *
     */
    public function getDataChartOfVotoGeneralLine($type) {
        
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
//        $chart["paletteColors"]  = "#0075c2,#c90606,#f2c500,#12a830,#1aaf5d";
        $chart["showBorder"] = "0";
        $chart["yaxisvaluespadding"] = "10";
        $chart["valueFontColor"] = "#ffffff";
        $chart["rotateValues"]   = "0";
        $chart["bgAlpha"] = "0,0";//Fondo 
        $chart["theme"]          = "fint";
        $chart["showborder"]     = "0";
        $chart["decimals"]       = "0";
        $chart["legendBgColor"] = "#ffffff";
        $chart["legendItemFontSize"] = "10";
        
        $chart["outCnvBaseFontColor"] = "#ffffff";
        $chart["visible"] = "1";

        $chart["usePlotGradientColor"] = "0";
        $chart["plotBorderAlpha"] = "10";
        $chart["legendBorderAlpha"] = "0";
        $chart["legendBgAlpha"] = "0";
        $chart["legendItemFontColor"] = "#ffffff";
        $chart["baseFontColor"] = "#ffffff";        
        
        $chart["divLineDashed"] = "0";
        $chart["showHoverEffect"] = "1";
        $chart["valuePosition"] = "ABOVE";
        $chart["dashed"] = "0";
        $chart["divLineDashLen"] = "0";
        $chart["divLineGapLen"] = "0";
        $chart["canvasBgAlpha"] = "0,0";
        $chart["toolTipBgColor"] = "#000000";
        $chart["formatNumberScale"] = "0";

        $em = $this->getDoctrine()->getManager();

        $label = $dataLinea = $dataMeta = array();

        //Carga de Nombres de Labels
        $dataSetLinea["seriesname"] = "Horas";        

        $horas = 9;
        $votos = 0;
        $cont = 4;
        $horaIni = $horaReal = 9;
        
        $resultHoras = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->findByGeneralHoras($type); 

        //Sumatoria de Horas
        $contSuma = $sumaInicio = 0;
        for ($i=0; $i <5 ; $i++) { 
            $sumaInicio = $sumaInicio + $resultHoras[$contSuma]["Si"];            
            $contSuma++;
        }
        
        //plan por tipo
        $planType = array();
        $planType[1] = (float)41704;
        $planType[2] = (float)4534;
        $planType[3] = (float)4328;
        $planType[4] = (float)37170;

        
        if(max($resultHoras) >= 12) {
            $horas = max($resultHoras)["Hora"] - 8;            
        }        

        if (isset($resultHoras)) {            
            for ($i=0; $i <=$horas; $i++) { 
                
                if ($horaIni == 13) {
                    $horaIni = $horaIni - 12;
                }          

                $linea = $horaIni.":00";                      
                $label["label"] = $linea;     
                $category[] = $label;
                
                if ($cont == 4) {
                    $votos = $votos + $sumaInicio;
                    $cont++;
                }
                if (isset($resultHoras[$cont]["Hora"])) {
                    $horaSet = (int)$resultHoras[$cont]["Hora"];                    
                }                
                
                if ($horaSet == $horaReal AND $horaSet != 9) {
                    $votos = $votos + $resultHoras[$cont]["Si"];                    
                    $cont++;           
                }else{
                    $votos = $votos;
                }
                
                $dataLinea["value"] = $votos;//((float)$votos/(float)41657)*100;//bcdiv($votos, bcadd(41657, 0, 2), 2); //(float)$votos/41657; //Carga de valores
                $dataSetLinea["data"][] = $dataLinea; //data linea            

                $horaReal++;
                $horaIni++;                 
            }
        }else{
            $dataSetLinea["data"][] = 0;
        }
        
        $dataSetLinea['plan'][] = array("value" => $planType[$type]*(float)((float)5/100));
        $dataSetLinea['plan'][] = array("value" => $planType[$type]*(float)((float)10/100));
        $dataSetLinea['plan'][] = array("value" => $planType[$type]*(float)((float)20/100));
        $dataSetLinea['plan'][] = array("value" => $planType[$type]*(float)((float)35/100));
        $dataSetLinea['plan'][] = array("value" => $planType[$type]*(float)((float)50/100));
        $dataSetLinea['plan'][] = array("value" => $planType[$type]*(float)((float)65/100));
        $dataSetLinea['plan'][] = array("value" => $planType[$type]*(float)((float)80/100));
        $dataSetLinea['plan'][] = array("value" => $planType[$type]*(float)((float)90/100));
        $dataSetLinea['plan'][] = array("value" => $planType[$type]*(float)((float)95/100));
        $dataSetLinea['plan'][] = array("value" => $planType[$type]);
        $dataSetLinea['plan'][] = array("value" => $planType[$type]);
        $dataSetLinea['plan'][] = array("value" => $planType[$type]);
        $dataSetLinea['plan'][] = array("value" => $planType[$type]);
        $dataSetLinea['plan'][] = array("value" => $planType[$type]);
        $dataSetLinea['plan'][] = array("value" => $planType[$type]);
        
            $dataSetValues['plan'] = array('seriesname' => 'Plan', 'parentyaxis' => 'S', 'renderas' => 'Line', 'color' => '#ffffff', 'data' => $dataSetLinea['plan']);
            $dataSetValues['votos'] = array('seriesname' => 'Votos * Horas', 'parentyaxis' => 'S', 'renderas' => 'Line', 'color' => '#ff0000', 'data' => $dataSetLinea['data']);
            //$dataMeta["value"] = 0;
            //$dataSetMeta["data"][] = $dataMeta;
        

        $data['dataSource']['chart'] = $chart;
        $data['dataSource']['categories'][]["category"] = $category;
        $data['dataSource']['dataset'][] = $dataSetValues['plan'];
        $data['dataSource']['dataset'][] = $dataSetValues['votos'];
        
        return json_encode($data);
    }


    /**
     *
     *  Grafica de Votos por Hora
     *
     */
    public function getDataChartOfVotoGeneralLineEstado($type, $estado) {

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
//        $chart["paletteColors"]  = "#0075c2,#c90606,#f2c500,#12a830,#1aaf5d";
        $chart["showBorder"] = "0";
        $chart["yaxisvaluespadding"] = "10";
        $chart["valueFontColor"] = "#ffffff";
        $chart["rotateValues"]   = "0";
        $chart["bgAlpha"] = "0,0";//Fondo 
        $chart["theme"]          = "fint";
        $chart["showborder"]     = "0";
        $chart["decimals"]       = "0";
        $chart["legendBgColor"] = "#ffffff";
        $chart["legendItemFontSize"] = "10";
        
        $chart["outCnvBaseFontColor"] = "#ffffff";
        $chart["visible"] = "1";

        $chart["usePlotGradientColor"] = "0";
        $chart["plotBorderAlpha"] = "10";
        $chart["legendBorderAlpha"] = "0";
        $chart["legendBgAlpha"] = "0";
        $chart["legendItemFontColor"] = "#ffffff";
        $chart["baseFontColor"] = "#ffffff";        
        
        $chart["divLineDashed"] = "0";
        $chart["showHoverEffect"] = "1";
        $chart["valuePosition"] = "ABOVE";
        $chart["dashed"] = "0";
        $chart["divLineDashLen"] = "0";
        $chart["divLineGapLen"] = "0";
        $chart["canvasBgAlpha"] = "0,0";
        $chart["toolTipBgColor"] = "#000000";
        $chart["formatNumberScale"] = "0";

        $em = $this->getDoctrine()->getManager();

        $label = $dataLinea = $dataMeta = array();

        //Carga de Nombres de Labels
        $dataSetLinea["seriesname"] = "Horas";        

        $horas = 9;
        $votos = 0;
        $cont = 4;
        $horaIni = $horaReal = 9;
        
        $resultHoras = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->findByGeneralHorasEstado($type, $estado); 

        //Sumatoria de Horas
        $contSuma = $sumaInicio = 0;
        for ($i=0; $i <5 ; $i++) { 
            $sumaInicio = $sumaInicio + $resultHoras[$contSuma]["Si"];            
            $contSuma++;
        }
        
        //plan por tipo
        $planType = array();
        if ($type == 1) {
            $planType["EDO. CARABOBO"] = (float)18179;
            $planType["EDO. ZULIA"] = (float)16754;
            $planType["EDO. ANZOATEGUI"] = (float)2579;
            $planType["OTROS"] = (float)37170;                
        }elseif ($type == 2) {
            $planType["EDO. CARABOBO"] = (float)1840;
            $planType["EDO. ZULIA"] = (float)1850;
            $planType["EDO. ANZOATEGUI"] = (float)280;
            $planType["OTROS"] = (float)37170;
        }

        
        if(max($resultHoras) >= 12) {
            $horas = max($resultHoras)["Hora"] - 8;            
        }        
        
        if (isset($resultHoras)) {            
            for ($i=0; $i <=$horas; $i++) { 
                
                if ($horaIni == 13) {
                    $horaIni = $horaIni - 12;
                }          

                $linea = $horaIni.":00";                      
                $label["label"] = $linea;     
                $category[] = $label;
                
                if ($cont == 4) {
                    $votos = $votos + $sumaInicio;
                    $cont++;
                }
                if (isset($resultHoras[$cont]["Hora"])) {
                    $horaSet = (int)$resultHoras[$cont]["Hora"];                    
                }                
                
                if ($horaSet == $horaReal AND $horaSet != 9) {
                    $votos = $votos + $resultHoras[$cont]["Si"];                    
                    $cont++;           
                }else{
                    $votos = $votos;
                }
                
                $dataLinea["value"] = $votos;//((float)$votos/(float)41657)*100;//bcdiv($votos, bcadd(41657, 0, 2), 2); //(float)$votos/41657; //Carga de valores
                $dataSetLinea["data"][] = $dataLinea; //data linea            

                $horaReal++;
                $horaIni++;                 
            }
        }else{
            $dataSetLinea["data"][] = 0;
        }
        
        $dataSetLinea['plan'][] = array("value" => $planType[$estado]*(float)((float)5/100));
        $dataSetLinea['plan'][] = array("value" => $planType[$estado]*(float)((float)10/100));
        $dataSetLinea['plan'][] = array("value" => $planType[$estado]*(float)((float)20/100));
        $dataSetLinea['plan'][] = array("value" => $planType[$estado]*(float)((float)35/100));
        $dataSetLinea['plan'][] = array("value" => $planType[$estado]*(float)((float)50/100));
        $dataSetLinea['plan'][] = array("value" => $planType[$estado]*(float)((float)65/100));
        $dataSetLinea['plan'][] = array("value" => $planType[$estado]*(float)((float)80/100));
        $dataSetLinea['plan'][] = array("value" => $planType[$estado]*(float)((float)90/100));
        $dataSetLinea['plan'][] = array("value" => $planType[$estado]*(float)((float)95/100));
        $dataSetLinea['plan'][] = array("value" => $planType[$estado]);
        $dataSetLinea['plan'][] = array("value" => $planType[$estado]);
        $dataSetLinea['plan'][] = array("value" => $planType[$estado]);
        $dataSetLinea['plan'][] = array("value" => $planType[$estado]);
        $dataSetLinea['plan'][] = array("value" => $planType[$estado]);
        $dataSetLinea['plan'][] = array("value" => $planType[$estado]);
        
            $dataSetValues['plan'] = array('seriesname' => 'Plan', 'parentyaxis' => 'S', 'renderas' => 'Line', 'color' => '#ffffff', 'data' => $dataSetLinea['plan']);
            $dataSetValues['votos'] = array('seriesname' => 'Votos * Horas', 'parentyaxis' => 'S', 'renderas' => 'Line', 'color' => '#ff0000', 'data' => $dataSetLinea['data']);
            //$dataMeta["value"] = 0;
            //$dataSetMeta["data"][] = $dataMeta;
        

        $data['dataSource']['chart'] = $chart;
        $data['dataSource']['categories'][]["category"] = $category;
        $data['dataSource']['dataset'][] = $dataSetValues['plan'];
        $data['dataSource']['dataset'][] = $dataSetValues['votos'];
        
        return json_encode($data);
    }

    /**
     *
     *  Grafica de Votos por Hora
     *
     */
    public function getDataChartOfVotoGeneralLineMcpo($type,$estado,$mcpo) {
        
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
//        $chart["paletteColors"]  = "#0075c2,#c90606,#f2c500,#12a830,#1aaf5d";
        $chart["showBorder"] = "0";
        $chart["yaxisvaluespadding"] = "10";
        $chart["valueFontColor"] = "#ffffff";
        $chart["rotateValues"]   = "0";
        $chart["bgAlpha"] = "0,0";//Fondo 
        $chart["theme"]          = "fint";
        $chart["showborder"]     = "0";
        $chart["decimals"]       = "0";
        $chart["legendBgColor"] = "#ffffff";
        $chart["legendItemFontSize"] = "10";
        
        $chart["outCnvBaseFontColor"] = "#ffffff";
        $chart["visible"] = "1";

        $chart["usePlotGradientColor"] = "0";
        $chart["plotBorderAlpha"] = "10";
        $chart["legendBorderAlpha"] = "0";
        $chart["legendBgAlpha"] = "0";
        $chart["legendItemFontColor"] = "#ffffff";
        $chart["baseFontColor"] = "#ffffff";        
        
        $chart["divLineDashed"] = "0";
        $chart["showHoverEffect"] = "1";
        $chart["valuePosition"] = "ABOVE";
        $chart["dashed"] = "0";
        $chart["divLineDashLen"] = "0";
        $chart["divLineGapLen"] = "0";
        $chart["canvasBgAlpha"] = "0,0";
        $chart["toolTipBgColor"] = "#000000";
        $chart["formatNumberScale"] = "0";

        $em = $this->getDoctrine()->getManager();

        $label = $dataLinea = $dataMeta = array();

        //Carga de Nombres de Labels
        $dataSetLinea["seriesname"] = "Horas";        

        $horas = 9;
        $votos = $horaSet = 0;
        $cont = 3;
        $horaIni = $horaReal = 9;
        
        $mcpo = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->findByMunicipioName($estado,$mcpo);                    
        $mcpo = $mcpo[0]["descriptionMunicipio"];
        
        $estado = $this->AsignedDescriptionEdo($estado);
        $resultHoras = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->findByGeneralHorasMcpo($type,$estado,$mcpo); 

        //Sumatoria de Horas
        $contSuma = $sumaInicio = 0;
        for ($i=0; $i <4 ; $i++) { 
            $sumaInicio = $sumaInicio + $resultHoras[$contSuma]["Si"];            
            $contSuma++;
        }
        
        $mcpoVoto = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->findByVotosMunicipiosCant($estado, $mcpo, $type);            
        $votoSI = $mcpoVoto[0]["SUM(votoSI)"];
        $votoNO = $mcpoVoto[0]["SUM(votoNO)"];

        $cantVoto = $votoSI + $votoNO;

        //plan por tipo
        $planType = array();
        $planType[1] = (float)$cantVoto;
        
        if(max($resultHoras) >= 12) {
            $horas = max($resultHoras)["Hora"] - 8;            
        }        
        
        if (isset($resultHoras)) {            
            for ($i=0; $i <=$horas; $i++) { 
                
                if ($horaIni == 13) {
                    $horaIni = $horaIni - 12;
                }          

                $linea = $horaIni.":00";                      
                $label["label"] = $linea;     
                $category[] = $label;
                
                if ($cont == 3) {
                    $votos = $votos + $sumaInicio;
                    $cont++;
                }elseif(isset($resultHoras[$cont]["Hora"])) {
                    $horaSet = (int)$resultHoras[$cont]["Hora"];                    
                }      
                if ($horaSet == $horaReal AND $horaSet != 9) {
                    $votos = $votos + $resultHoras[$cont]["Si"];                    
                    $cont++;           
                }else{
                    $votos = $votos;
                }
                
                $dataLinea["value"] = $votos;//((float)$votos/(float)41657)*100;//bcdiv($votos, bcadd(41657, 0, 2), 2); //(float)$votos/41657; //Carga de valores
                $dataSetLinea["data"][] = $dataLinea; //data linea            

                $horaReal++;
                $horaIni++;                 
            }
        }else{
            $dataSetLinea["data"][] = 0;
        }
        
        $dataSetLinea['plan'][] = array("value" => $planType[1]*(float)((float)5/100));
        $dataSetLinea['plan'][] = array("value" => $planType[1]*(float)((float)10/100));
        $dataSetLinea['plan'][] = array("value" => $planType[1]*(float)((float)20/100));
        $dataSetLinea['plan'][] = array("value" => $planType[1]*(float)((float)35/100));
        $dataSetLinea['plan'][] = array("value" => $planType[1]*(float)((float)50/100));
        $dataSetLinea['plan'][] = array("value" => $planType[1]*(float)((float)65/100));
        $dataSetLinea['plan'][] = array("value" => $planType[1]*(float)((float)80/100));
        $dataSetLinea['plan'][] = array("value" => $planType[1]*(float)((float)90/100));
        $dataSetLinea['plan'][] = array("value" => $planType[1]*(float)((float)95/100));
        $dataSetLinea['plan'][] = array("value" => $planType[1]);
        $dataSetLinea['plan'][] = array("value" => $planType[1]);
        $dataSetLinea['plan'][] = array("value" => $planType[1]);
        $dataSetLinea['plan'][] = array("value" => $planType[1]);
        $dataSetLinea['plan'][] = array("value" => $planType[1]);
        $dataSetLinea['plan'][] = array("value" => $planType[1]);
        
            $dataSetValues['plan'] = array('seriesname' => 'Plan', 'parentyaxis' => 'S', 'renderas' => 'Line', 'color' => '#ffffff', 'data' => $dataSetLinea['plan']);
            $dataSetValues['votos'] = array('seriesname' => 'Votos * Horas', 'parentyaxis' => 'S', 'renderas' => 'Line', 'color' => '#ff0000', 'data' => $dataSetLinea['data']);
            //$dataMeta["value"] = 0;
            //$dataSetMeta["data"][] = $dataMeta;
        

        $data['dataSource']['chart'] = $chart;
        $data['dataSource']['categories'][]["category"] = $category;
        $data['dataSource']['dataset'][] = $dataSetValues['plan'];
        $data['dataSource']['dataset'][] = $dataSetValues['votos'];
        
        return json_encode($data);
    }

    /**
     *
     *  Grafica General de Estado
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
        $chart["valueFontColor"] = "#ffffff";
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
            $resultVal = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->findByEstadoData($estado);            
            $votoSi = $resultVal[0]["SUM(votoSI)"];
            $votoNo = $resultVal[0]["SUM(votoNO)"];                            
        }else{
            $otros = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->findByEstadoOtros();            
            $votoSi = $otros[0]["SUM(votoSI)"];
            $votoNo = $otros[0]["SUM(votoNO)"];            
        }

        //SI VIENE DE GENERAL
        if ($type == 1) {    
            if ($estado == "OTROS") {
                $votosOneMembersEdo = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->findByEstadoMembersEdoOtros($estado);
                $votoSi = $votoSi + $votosOneMembersEdo[0]["SUM(votoSI)"];
                $votoNo = $votoNo + $votosOneMembersEdo[0]["SUM(votoNO)"];                            
            }else{
                $votosOneMembersEdo = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->findByEstadoMembersEdo($estado);
                $votoSi = $votoSi + $votosOneMembersEdo[0]["SUM(votoSI)"];
                $votoNo = $votoNo + $votosOneMembersEdo[0]["SUM(votoNO)"];
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
            }elseif($linkValue == 2 AND $estado == 7 OR $estado == 21 OR $estado == 2){
                $dataLocal["link"] = $this->generateUrl('pequiven_sip_display_voto_localidad', array('edo'=> $estado));
                $chart["showvalues"]     = "1";
                $chart["showLegend"] = "1";                
                $labelSi = "SI";
                $labelNo = "NO";
            }elseif($linkValue == 10){                
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

        return json_encode($data);                
    }

    /**
     *
     *  Grafica de Votos Municipio Barra
     *
     */
    public function getDataChartOfVotoMcpo($estado, $type, $linkValue) {
        
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

        $chart["caption"] = "Municipios";
        $chart["captionFontColor"] = "#e20000";
        $chart["captionFontSize"] = "20";                
        $chart["palette"]        = "1";
        $chart["showvalues"]     = "1";
        $chart["paletteColors"]  = "#0075c2,#c90606,#f2c500,#12a830,#1aaf5d";
        $chart["showBorder"] = "0";
        $chart["showCanvasBorder"] = "0";
        $chart["yaxisvaluespadding"] = "10";
        $chart["valueFontColor"] = "#ffffff";
        $chart["rotateValues"]   = "1";
        $chart["bgAlpha"] = "0,0";//Fondo         
        $chart["theme"]          = "fint";
        $chart["showborder"]     = "0";
        $chart["decimals"]       = "0";
        $chart["legendBgColor"] = "#ffffff";
        $chart["legendItemFontSize"] = "10";
        $chart["legendItemFontColor"] = "#666666";
        $chart["baseFontColor"] = "#ffffff";        
        $chart["outCnvBaseFontColor"] = "#ffffff";
        $chart["formatNumberScale"] = "0";

        $chart["usePlotGradientColor"] = "0";
        $chart["plotBorderAlpha"] = "10";
        $chart["legendBorderAlpha"] = "0";
        $chart["legendBgAlpha"] = "0";
        $chart["legendItemFontColor"] = "#ffffff";
        $chart["baseFontColor"] = "#ffffff";
        $chart["legendItemFontColor"] = "#ffffff";
        
        $chart["divLineDashed"] = "0";
        $chart["showHoverEffect"] = "1";
        $chart["valuePosition"] = "ABOVE";
        $chart["dashed"] = "0";
        $chart["divLineDashLen"] = "0";
        $chart["divLineGapLen"] = "0";
        $chart["canvasBgAlpha"] = "0,0";
        $chart["toolTipBgColor"] = "#000000";
        //$chart["visible"] = "0";
        //$chart["labelDisplay"] = "ROTATE";

        $em = $this->getDoctrine()->getManager();
        $estadoDescription = $estado;
        $estado = $this->AsignedIdEdo($estado);//Id Estado

        $label = $dataPlan = $dataReal = array();
        //Carga de Nombres de Labels
        $dataSetReal["seriesname"] = "Real";
        $dataSetPlan["seriesname"] = "Plan";
        
        $mcpo = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->findByMunicipios($estado);            
        $cantMcpo = count($mcpo);
        $cont = $municipio = 0;

        foreach ($mcpo as $key => $value) {
            //Municipio Para consulta
            $municipio = $mcpo[$cont]["descriptionMunicipio"];
            $linea = $municipio;
            $label["label"] = $linea;     
            $category[] = $label;
            
            //Votos por Municipio
            $mcpoVoto = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->findByVotosMunicipios($municipio, $estadoDescription);            
            if (isset($mcpoVoto[0]["SUM(votoSI)"])) {
                $dataRealVoto = $mcpoVoto[0]["SUM(votoSI)"];                
            }else{
                $dataRealVoto = 0;
            }
            if (isset($mcpoVoto[0]["SUM(votoNO)"])) {
                $dataPlanVoto = $mcpoVoto[0]["SUM(votoNO)"];                
            }else{
                $dataPlanVoto = 0;                
            }


            $muncpo = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->findByMcpoId($municipio, $estado);            
            $muncpo = $muncpo[0]["id"];            
            
            if ($type == 1) {
                $mcpoVotoGeneral = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->findByVotosMunicipiosGeneral($municipio, $estadoDescription);            
                if (isset($mcpoVotoGeneral[0]["SUM(votoSI)"])) {
                    $dataRealVoto = $dataRealVoto + $mcpoVotoGeneral[0]["SUM(votoSI)"];                    
                }else{
                    $dataRealVoto = $dataRealVoto + 0;
                }
                if (isset($mcpoVotoGeneral[0]["SUM(votoNO)"])) {
                    $dataPlanVoto = $dataPlanVoto + $mcpoVotoGeneral[0]["SUM(votoNO)"];                                                        
                }else{
                    $dataPlanVoto = $dataPlanVoto + 0;                    
                }

                $link = $this->generateUrl('pequiven_sip_display_voto_general_mcpo',array('edo' => $estado, 'type' => $type, 'mcpo' => $muncpo));            
            }elseif($type == 2){        
                $link = $this->generateUrl('pequiven_sip_display_voto_pqv_mcpo',array('edo' => $estado, 'type' => $type, 'mcpo' => $muncpo));
            }
                
            if ($linkValue == 1) {
                $dataReal["link"]  = $link;
                $chart["showvalues"] = "1";
            }else{
                $chart["showvalues"] = "0";
            }
            
            $dataPlan["value"] = $dataPlanVoto + $dataRealVoto;
            $dataSetPlan["data"][] = $dataPlan; //data Plan

            $dataReal["value"] = $dataRealVoto;
            $dataSetReal["data"][] = $dataReal; //data Real
            
            $cont++;        
        }
        if ($estado == 30) {
            $name = "OTROS";
            $chart["caption"] = $name;
            $label["label"] = $name;     
            $category[] = $label;

            $otros = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->findByMunicipioOtros();
            $votoSi = $otros[1]["Cant"];
            $votoNo = $otros[0]["Cant"];

            $dataPlan["value"] = $votoSi + $votoNo;
            $dataSetPlan["data"][] = $dataPlan; //data Plan

            $dataReal["value"] = $votoSi;
            $dataSetReal["data"][] = $dataReal; //data Real
        }

        $data['dataSource']['chart'] = $chart;
        $data['dataSource']['categories'][]["category"] = $category;
        //$data['dataSource']['dataset'][] = $dataSetValues['votos'];
        $data['dataSource']['dataset'][] = $dataSetPlan;
        $data['dataSource']['dataset'][] = $dataSetReal;

        return json_encode($data);
    }

    /**
     *
     *  Grafica Parroquia
     *
     */
    public function getDataChartOfVotoGeneralParroquia($estado ,$mcpo ,$linkValue, $type) {

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
        $chart["valueFontColor"] = "#ffffff";
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
        $edoMcpo = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->findByMcpoAndEdoId($estado, $mcpo);            
        $estado = $edoMcpo[0]["edo"];
        $mcpo = $edoMcpo[0]["mcpo"];

        if ($estado != 30) {            
            $mcpoVoto = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->findByVotosMunicipiosId($estado, $mcpo);            
            $votoSI = $mcpoVoto[0]["SUM(votoSI)"];
            $votoNO = $mcpoVoto[0]["SUM(votoNO)"];            
        }else{
            $otros = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->findByEstadoOtros();
            $votoSI = $otros[1]["Cant"];
            $votoNO = $otros[0]["Cant"];
        }

        if ($type == 1) {            
            $mcpoVotoGeneral = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->findByVotosMunicipiosIdGeneral($estado, $mcpo);            
            $votoSI = $votoSI + $mcpoVotoGeneral[0]["SUM(votoSI)"];
            $votoNO = $votoNO + $mcpoVotoGeneral[0]["SUM(votoNO)"];            
        }

            $chart["caption"] = $mcpo;
            $label = "";
            $dataLocal["label"] = $label; //Carga de valores                
            $dataLocal["value"] = $votoSI; //Carga de valores
            if ($linkValue == 1) {
            $dataLocal["link"]  = $this->generateUrl('pequiven_sip_display_voto_general_estado',array('edo' => $estado));
                $chart["showvalues"] = "0";
            }else{
                $chart["showvalues"] = "1";
            }

            $dataSetLocal["data"][] = $dataLocal; //data 

            $label = "";
            $dataLocal["label"] = $label; //Carga de valores                
            $dataLocal["value"] = $votoNO; //Carga de valores
            $dataSetLocal["data"][] = $dataLocal; //data 

        $data['dataSource']['chart'] = $chart;                
        $data['dataSource']['dataset'][] = $dataSetLocal;

        return json_encode($data);        
    }

    /**
     *
     *  Grafica de Votos Parroquia Barra
     *
     */
    public function getDataChartOfVotoParroquiaData($estado, $mcpo, $linkValue, $type ) {
        
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

        $chart["caption"] = "Parroquias";
        $chart["captionFontColor"] = "#e20000";
        $chart["captionFontSize"] = "20";                
        $chart["palette"]        = "1";
        $chart["showvalues"]     = "1";
        $chart["paletteColors"]  = "#0075c2,#c90606,#f2c500,#12a830,#1aaf5d";
        $chart["showBorder"] = "0";
        $chart["showCanvasBorder"] = "0";
        $chart["yaxisvaluespadding"] = "10";
        $chart["valueFontColor"] = "#ffffff";
        $chart["rotateValues"]   = "1";
        $chart["bgAlpha"] = "0,0";//Fondo         
        $chart["theme"]          = "fint";
        $chart["showborder"]     = "0";
        $chart["decimals"]       = "0";
        $chart["legendBgColor"] = "#ffffff";
        $chart["legendItemFontSize"] = "10";
        $chart["legendItemFontColor"] = "#666666";
        $chart["baseFontColor"] = "#ffffff";        
        $chart["outCnvBaseFontColor"] = "#ffffff";
        $chart["formatNumberScale"] = "0";

        $chart["usePlotGradientColor"] = "0";
        $chart["plotBorderAlpha"] = "10";
        $chart["legendBorderAlpha"] = "0";
        $chart["legendBgAlpha"] = "0";
        $chart["legendItemFontColor"] = "#ffffff";
        $chart["baseFontColor"] = "#ffffff";
        $chart["legendItemFontColor"] = "#ffffff";
        
        $chart["divLineDashed"] = "0";
        $chart["showHoverEffect"] = "1";
        $chart["valuePosition"] = "ABOVE";
        $chart["dashed"] = "0";
        $chart["divLineDashLen"] = "0";
        $chart["divLineGapLen"] = "0";
        $chart["canvasBgAlpha"] = "0,0";
        $chart["toolTipBgColor"] = "#000000";

        $em = $this->getDoctrine()->getManager();   
        $estadoId = $estado;
        $estado = $this->AsignedIdEdo($estado);//Id Estado

        $label = $dataPlan = $dataReal = array();
        //Carga de Nombres de Labels
        $dataSetReal["seriesname"] = "Real";
        $dataSetPlan["seriesname"] = "Plan";
        
        $parroq = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->findByParroquias($estado, $mcpo);                    
        $cantParroq = count($parroq);
        $cont = 0;

        foreach ($parroq as $key => $value) {
            //Municipio Para consulta
            $parroquia = $parroq[$cont]["descriptionParroquia"];
            $codParroquia = $parroq[$cont]["codigoParroquia"];
            $linea = $parroquia;
            $label["label"] = $linea;     
            $category[] = $label;
            
            $estado = $this->AsignedDescriptionEdo($estado);
            //Votos por Parroquia
            $parroqVoto = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->findByVotosParroquia($parroquia, $estado);            
            if(isset($parroqVoto[0]["SUM(votoSI)"])){
                $votoSI = $parroqVoto[0]["SUM(votoSI)"];                
            }else{
                $votoSI = 0;             
            }

            if(isset($parroqVoto[0]["SUM(votoNO)"])){                
                $votoNO = $parroqVoto[0]["SUM(votoNO)"];
            }else{                
                $votoNO = 0;
            }
            
            if ($type == 1) {
                $parroqGeneral = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->findByVotosParroquiaGeneral($parroquia, $estado);            
                if (isset($parroqGeneral[0]["SUM(votoSI)"])) {
                    $votoSI = $votoSI + $parroqGeneral[0]["SUM(votoSI)"];                    
                }else{
                    $votoSI = $votoSI + 0;                    
                }
                if (isset($parroqGeneral[0]["SUM(votoNO)"])) {
                    $votoNO = $votoNO + $parroqGeneral[0]["SUM(votoNO)"];                        
                }else{
                    $votoNO = $votoNO + 0;
                }

                $estado = $this->AsignedIdEdo($estado);//Id Estado

                $link = $this->generateUrl('pequiven_sip_list_voto_general',array('edo' =>$estadoId,'mcpo' => $mcpo, 'type' => $type, 'parroq' => $codParroquia));            
            }elseif($type == 2){        
                $link = $this->generateUrl('pequiven_sip_list_voto_general',array('edo' =>$estadoId,'mcpo' => $mcpo, 'type' => $type, 'parroq' => $codParroquia));
            }
            
            $dataReal["link"]  = $link;                        
            $dataPlan["value"] = $votoSI + $votoNO;
            $dataSetPlan["data"][] = $dataPlan; //data Plan

            $dataReal["value"] = $votoSI;
            $dataSetReal["data"][] = $dataReal; //data Real
            
            $cont++;       
        }
        if ($estado == 30) {
            $name = "OTROS";
            $chart["caption"] = $name;
            $label["label"] = $name;     
            $category[] = $label;

            $otros = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->findByMunicipioOtros();
            $votoSi = $otros[1]["Cant"];
            $votoNo = $otros[0]["Cant"];

            $dataPlan["value"] = $votoSI + $votoNO;
            $dataSetPlan["data"][] = $dataPlan; //data Plan

            $dataReal["value"] = $votoSI;
            $dataSetReal["data"][] = $dataReal; //data Real
        }

        $data['dataSource']['chart'] = $chart;
        $data['dataSource']['categories'][]["category"] = $category;
        //$data['dataSource']['dataset'][] = $dataSetValues['votos'];
        $data['dataSource']['dataset'][] = $dataSetPlan;
        $data['dataSource']['dataset'][] = $dataSetReal;

        return json_encode($data);
    }

    /**
     *
     *  Grafica de Voto Localidad
     *
     */
    public function getDataChartOfLocalidad($localidad) {
        
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

        $chart["caption"] = $localidad;
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
        $chart["valueFontColor"] = "#ffffff";
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
        
        $resultLocalidad = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->findByLocalidad($localidad);
        $votoNO = $votoSI = 0;

        $votoSI = $resultLocalidad[0]["SUM(votoSI)"];
        $votoNO = $resultLocalidad[0]["SUM(votoNO)"];
        
        $resultLocalidad1x10 = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->findByLocalidad1x10($localidad);
        $votoSI = $votoSI + $resultLocalidad1x10[0]["SUM(votoSI)"];
        $votoNO = $votoNO + $resultLocalidad1x10[0]["SUM(votoNO)"];

        $label = "SI";
        $dataLocal["label"] = $label; //Carga de valores                
        $dataLocal["value"] = $votoSI; //Carga de valores
        $dataSetLocal["data"][] = $dataLocal; //data 

        $label = "NO";
        $dataLocal["label"] = $label; //Carga de valores                
        $dataLocal["value"] = $votoNO; //Carga de valores
        $dataSetLocal["data"][] = $dataLocal; //data 
        

        $data['dataSource']['chart'] = $chart;                
        $data['dataSource']['dataset'][] = $dataSetLocal;

        return json_encode($data);        
    }

    /**
     *
     *  Grafica de Votos Parroquia Barra
     *
     */
    public function getDataChartOfLocalidadBar($localidad) {
        
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

        //$chart["caption"] = $localidad;
        $chart["captionFontColor"] = "#e20000";
        $chart["captionFontSize"] = "20";                
        $chart["palette"]        = "1";
        $chart["showvalues"]     = "1";
        $chart["paletteColors"]  = "#0075c2,#c90606,#f2c500,#12a830,#1aaf5d";
        $chart["showBorder"] = "0";
        $chart["showCanvasBorder"] = "0";
        $chart["yaxisvaluespadding"] = "10";
        $chart["valueFontColor"] = "#ffffff";
        $chart["rotateValues"]   = "1";
        $chart["bgAlpha"] = "0,0";//Fondo         
        $chart["theme"]          = "fint";
        $chart["showborder"]     = "0";
        $chart["decimals"]       = "0";
        $chart["showLegend"] = "0";
        $chart["legendBgColor"] = "#ffffff";
        $chart["legendItemFontSize"] = "10";
        $chart["legendItemFontColor"] = "#666666";
        $chart["baseFontColor"] = "#ffffff";        
        $chart["outCnvBaseFontColor"] = "#ffffff";
        $chart["formatNumberScale"] = "0";

        $chart["usePlotGradientColor"] = "0";
        $chart["plotBorderAlpha"] = "10";
        $chart["legendBorderAlpha"] = "0";
        $chart["legendBgAlpha"] = "0";
        $chart["legendItemFontColor"] = "#ffffff";
        $chart["baseFontColor"] = "#ffffff";
        $chart["legendItemFontColor"] = "#ffffff";
        
        $chart["divLineDashed"] = "0";
        $chart["showHoverEffect"] = "1";
        $chart["valuePosition"] = "ABOVE";
        $chart["dashed"] = "0";
        $chart["divLineDashLen"] = "0";
        $chart["divLineGapLen"] = "0";
        $chart["canvasBgAlpha"] = "0,0";
        $chart["toolTipBgColor"] = "#000000";

        $em = $this->getDoctrine()->getManager();
        
        $label = $dataPlan = $dataReal = array();
        
        
        $resultLocalidad = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->findByLocalidad($localidad);
        $votoNO = $votoSI = 0;

        $votoSI = $resultLocalidad[0]["SUM(votoSI)"];
        $votoNO = $resultLocalidad[0]["SUM(votoNO)"];

        //votos
        $label["label"] = "Votos PQV";     
        $category[] = $label;        

        $dataReal["value"] = $votoSI; //Carga de valores General
        $dataSetReal["data"][] = $dataReal; //data                 
        $dataPlan["value"] = $votoNO + $votoSI; //Carga de valores General
        $dataSetPlan["data"][] = $dataPlan; //data 


        //1x10
        $resultLocalidad = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->findByLocalidad1x10($localidad);
        $votoSI = $resultLocalidad[0]["SUM(votoSI)"];
        $votoNO = $resultLocalidad[0]["SUM(votoNO)"];

        $label["label"] = "1x10";     
        $category[] = $label;
        
        $dataReal["value"] = $votoSI; //Carga de valores General
        $dataSetReal["data"][] = $dataReal; //data                 
        $dataPlan["value"] = $votoNO + $votoSI; //Carga de valores General
        $dataSetPlan["data"][] = $dataPlan; //data 

        $dataSetReal["seriesname"] = "Real";                
        $dataSetPlan["seriesname"] = "Plan";                

        $data['dataSource']['chart'] = $chart;
        $data['dataSource']['categories'][]["category"] = $category;
        $data['dataSource']['dataset'][] = $dataSetPlan;
        $data['dataSource']['dataset'][] = $dataSetReal;

        return json_encode($data);
    }

    /**
     *
     *  Grafica de Voto Circuito 5 PQV
     *
     */
    public function getDataChartOfCircuito5($estado) {
        
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

        $chart["caption"] = "Voto Circuito 5 PQV";
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
        $chart["valueFontColor"] = "#ffffff";
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
        $chart["legendBgColor"] = "#ffffff";
        $chart["legendItemFontSize"] = "10";
        $chart["legendItemFontColor"] = "#666666";

        $em = $this->getDoctrine()->getManager();
        
        $label = $dataLocalidad = array();
        
        //Carga de Nombres de Labels
        $dataSetLocal["seriesname"] = "Voto Pequiven";        
        
        $resultEstado = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->findByCircuito5Edo($estado);
        $votoNO = $votoSI = 0;

        $votoSI = $resultEstado[0]["SUM(votoSI)"];
        $votoNO = $resultEstado[0]["SUM(votoNO)"];
        
        $chart["showLegend"] = "0";
        $label = "SI";
        $dataLocal["label"] = $label; //Carga de valores                
        $dataLocal["value"] = $votoSI; //Carga de valores
        $dataSetLocal["data"][] = $dataLocal; //data 

        $label = "NO";
        $dataLocal["label"] = $label; //Carga de valores                
        $dataLocal["value"] = $votoNO; //Carga de valores
        $dataSetLocal["data"][] = $dataLocal; //data 
        

        $data['dataSource']['chart'] = $chart;                
        $data['dataSource']['dataset'][] = $dataSetLocal;

        return json_encode($data);        
    }


    /**
     *
     *  Grafica de Voto Circuito 5 1x10
     *
     */
    public function getDataChartOfCircuito51x10($estado) {
        
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

        $chart["caption"] = "Voto Circuito 5 1x10";
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
        $chart["valueFontColor"] = "#ffffff";
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
        $chart["legendBgColor"] = "#ffffff";
        $chart["legendItemFontSize"] = "10";
        $chart["legendItemFontColor"] = "#666666";

        $em = $this->getDoctrine()->getManager();
        
        $label = $dataLocalidad = array();
        
        //Carga de Nombres de Labels
        $dataSetLocal["seriesname"] = "Voto Pequiven";        
        
        $resultCir51x10 = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->findByCircuito5Edo1x10($estado);
        $votoNO = $votoSI = 0;

        $votoSI = $resultCir51x10[0]["SUM(votoSI)"];
        $votoNO = $resultCir51x10[0]["SUM(votoNO)"];
        
        $chart["showLegend"] = "0";
        $label = "SI";
        $dataLocal["label"] = $label; //Carga de valores                
        $dataLocal["value"] = $votoSI; //Carga de valores
        $dataSetLocal["data"][] = $dataLocal; //data 

        $label = "NO";
        $dataLocal["label"] = $label; //Carga de valores                
        $dataLocal["value"] = $votoNO; //Carga de valores
        $dataSetLocal["data"][] = $dataLocal; //data 
        

        $data['dataSource']['chart'] = $chart;                
        $data['dataSource']['dataset'][] = $dataSetLocal;

        return json_encode($data);        
    }

    /**
     *
     *  Grafica de Votos Circuito Barra
     *
     */
    public function getDataChartOfCircuitoBarra($estado) {
        
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

        $chart["caption"] = "General";
        $chart["captionFontColor"] = "#e20000";
        $chart["captionFontSize"] = "15";                
        $chart["palette"]        = "1";
        $chart["showvalues"]     = "1";
        $chart["paletteColors"]  = "#0075c2,#c90606,#f2c500,#12a830,#1aaf5d";
        $chart["showBorder"] = "0";
        $chart["showCanvasBorder"] = "0";
        $chart["yaxisvaluespadding"] = "10";
        $chart["valueFontColor"] = "#ffffff";
        $chart["rotateValues"]   = "1";
        $chart["bgAlpha"] = "0,0";//Fondo         
        $chart["theme"]          = "fint";
        $chart["showborder"]     = "0";
        $chart["decimals"]       = "0";
        $chart["showLegend"] = "0";
        $chart["legendBgColor"] = "#ffffff";
        $chart["legendItemFontSize"] = "10";
        $chart["legendItemFontColor"] = "#666666";
        $chart["baseFontColor"] = "#ffffff";        
        $chart["outCnvBaseFontColor"] = "#ffffff";
        $chart["formatNumberScale"] = "0";

        $chart["usePlotGradientColor"] = "0";
        $chart["plotBorderAlpha"] = "10";
        $chart["legendBorderAlpha"] = "0";
        $chart["legendBgAlpha"] = "0";
        $chart["legendItemFontColor"] = "#ffffff";
        $chart["baseFontColor"] = "#ffffff";
        $chart["legendItemFontColor"] = "#ffffff";
        
        $chart["divLineDashed"] = "0";
        $chart["showHoverEffect"] = "1";
        $chart["valuePosition"] = "ABOVE";
        $chart["dashed"] = "0";
        $chart["divLineDashLen"] = "0";
        $chart["divLineGapLen"] = "0";
        $chart["canvasBgAlpha"] = "0,0";
        $chart["toolTipBgColor"] = "#000000";
        
        $chart["saxisvaluespadding"] = "10";
        $chart["pYAxisMaxValue"] = "1000";        

        $chart["sYAxisMaxValue"] = "50000";
        //$chart["sYAxisName"] = "Exit Poll";        
        
        $em = $this->getDoctrine()->getManager();
        
        $label = $dataPlan = $dataReal = array();
        $count = 1;
        $votoNO = $votoSI = 0;

        $parroquias = [
            1 => "PQ. U TOCUYITO", 
            2 => "PQ. U INDEPENDENCIA", 
            3 => "PQ. MIGUEL PEÑA",
            4 => "PQ. RAFAEL URDANETA", 
            5 => "PQ. NEGRO PRIMERO", 
            6 => "PQ. SANTA ROSA"
        ];
        
        foreach ($parroquias as $value) {
            $parroquia = $parroquias[$count];
            $label["label"] = $parroquia;     
            $category[] = $label;        
            
            //General PQV
            $tipo = "PQV";
            $resultLocalidad = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->findByCircuito5Barra($estado, $parroquia, $tipo);
            if (isset($resultLocalidad[0]["SUM(votoSI)"])) {
                $votoSI = $resultLocalidad[0]["SUM(votoSI)"];                
            }else{
                $votoSI = 0;
            }

            if (isset($resultLocalidad[0]["SUM(votoNO)"])) {
                $votoNO = $resultLocalidad[0]["SUM(votoNO)"];                
            }else{
                $votoNO = 0;
            }
            
            $dataReal["value"] = $votoSI; //Carga de valores General
            $dataSetReal["data"][] = $dataReal; //data                 
            
            $dataPlan1["value"] = $votoNO + $votoSI; //Carga de valores General
            $dataSetPlan["data"][] = $dataPlan1; //data 

            //General 1x10            
            $label["label"] = "1x10";     
            $category[] = $label; 

            $tipo = "1x10";
            $resultVal1x10 = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->findByCircuito5Barra($estado, $parroquia, $tipo);
            if (isset($resultVal1x10[0]["SUM(votoSI)"])) {
                $votoSI = $resultVal1x10[0]["SUM(votoSI)"];                
            }else{
                $votoSI = 0;
            }

            if (isset($resultVal1x10[0]["SUM(votoNO)"])) {
                $votoNO = $resultVal1x10[0]["SUM(votoNO)"];                
            }else{
                $votoNO = 0;
            }
            
            $dataReal["value"] = $votoSI; //Carga de valores General
            $dataSetReal["data"][] = $dataReal; //data                 
            
            $dataPlan2["value"] = $votoNO + $votoSI; //Carga de valores General
            $dataSetPlan["data"][] = $dataPlan2; //data 
             
            
            $count++;        
        }    
        
        $dataSetReal["seriesname"] = "Real";                
        $dataSetPlan["seriesname"] = "Plan";                

        $data['dataSource']['chart'] = $chart;
        $data['dataSource']['categories'][]["category"] = $category;
        $data['dataSource']['dataset'][] = $dataSetPlan;
        $data['dataSource']['dataset'][] = $dataSetReal;

        return json_encode($data);
    }


    /**
     *
     *  Grafica de Votos Circuito Barra
     *
     */
    public function getDataChartOfCircuitoBarraPoll() {
        
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

        $chart["caption"] = "Exit Poll";
        $chart["captionFontColor"] = "#e20000";
        $chart["captionFontSize"] = "15";                
        $chart["palette"]        = "1";
        $chart["showvalues"]     = "1";
        $chart["paletteColors"]  = "#0075c2,#c90606,#f2c500,#12a830,#1aaf5d";
        $chart["showBorder"] = "0";
        $chart["showCanvasBorder"] = "0";
        $chart["yaxisvaluespadding"] = "10";
        $chart["valueFontColor"] = "#ffffff";
        $chart["rotateValues"]   = "1";
        $chart["bgAlpha"] = "0,0";//Fondo         
        $chart["theme"]          = "fint";
        $chart["showborder"]     = "0";
        $chart["decimals"]       = "0";
        $chart["showLegend"] = "0";
        $chart["legendBgColor"] = "#ffffff";
        $chart["legendItemFontSize"] = "10";
        $chart["legendItemFontColor"] = "#666666";
        $chart["baseFontColor"] = "#ffffff";        
        $chart["outCnvBaseFontColor"] = "#ffffff";
        $chart["formatNumberScale"] = "0";

        $chart["usePlotGradientColor"] = "0";
        $chart["plotBorderAlpha"] = "10";
        $chart["legendBorderAlpha"] = "0";
        $chart["legendBgAlpha"] = "0";
        $chart["legendItemFontColor"] = "#ffffff";
        $chart["baseFontColor"] = "#ffffff";
        $chart["legendItemFontColor"] = "#ffffff";
        
        $chart["divLineDashed"] = "0";
        $chart["showHoverEffect"] = "1";
        $chart["valuePosition"] = "ABOVE";
        $chart["dashed"] = "0";
        $chart["divLineDashLen"] = "0";
        $chart["divLineGapLen"] = "0";
        $chart["canvasBgAlpha"] = "0,0";
        $chart["toolTipBgColor"] = "#000000";
        
        //$chart["saxisvaluespadding"] = "10";
        //$chart["pYAxisMaxValue"] = "1000";        

        //$chart["sYAxisMaxValue"] = "50000";
        //$chart["sYAxisName"] = "Exit Poll";        
        
        $em = $this->getDoctrine()->getManager();
        
        $label = $dataPlan = $dataReal = array();
        $count = 1;
        $votoNO = $votoSI = 0;

        $parroquias = [
            1 => "PQ. U TOCUYITO", 
            2 => "PQ. U INDEPENDENCIA", 
            3 => "PQ. MIGUEL PEÑA",
            4 => "PQ. RAFAEL URDANETA", 
            5 => "PQ. NEGRO PRIMERO", 
            6 => "PQ. SANTA ROSA"
        ];
        
        foreach ($parroquias as $value) {
            $parroquia = $parroquias[$count];
            $label["label"] = $parroquia;     
            $category[] = $label; 
            
            $dataPoll = [
                1 => 15620,//"PQ. U TOCUYITO", 
                2 => 9631,//"PQ. U INDEPENDENCIA", 
                3 => 100929,//"PQ. MIGUEL PEÑA",
                4 => 43263,//"PQ. RAFAEL URDANETA", 
                5 => 3700,//"PQ. NEGRO PRIMERO", 
                6 => 17334//"PQ. SANTA ROSA"
            ];
            //Cantidad de Votos
            $dataM = $dataPoll[$count];            
            $dataReal3["parentyaxis"] = 'S';                        
            $dataReal3["renderas"] = 'column';                        
            $dataReal3["color"] = '#47ac44';            
            $dataReal3["value"] = $dataM; //Carga de valores General
            $dataSetReal['data'][] = $dataReal3; //data 
            //$dataSetReal['data'] = array('parentyaxis' => 'S', 'renderas' => 'column', 'data' => $dataSetReal['data']);            

            $dataPlan3["value"] = ""; //Carga de valores General
            $dataSetPlan["data"][] = $dataPlan3; //data             
            
            $count++;        
        }    
        
        $dataSetReal["seriesname"] = "Real";                
        $dataSetPlan["seriesname"] = "Plan";                

        $data['dataSource']['chart'] = $chart;
        $data['dataSource']['categories'][]["category"] = $category;
        $data['dataSource']['dataset'][] = $dataSetPlan;
        $data['dataSource']['dataset'][] = $dataSetReal;

        return json_encode($data);
    }
    /**
     *
     *  Grafica de Voto 1x10
     *
     */
    public function getDataChartOf1x10() {
        
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

        $chart["caption"] = "Voto General 1x10";
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
        $chart["valueFontColor"] = "#ffffff";
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
        $chart["legendBgColor"] = "#ffffff";
        $chart["legendItemFontSize"] = "10";
        $chart["legendItemFontColor"] = "#666666";

        $em = $this->getDoctrine()->getManager();
        
        $label = $dataLocalidad = array();
        
        //Carga de Nombres de Labels
        $dataSetLocal["seriesname"] = "Voto Pequiven";        
        
        $votoNO = $votoSI = 0;
        $result1x10 = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->findBy1x10();
        $votoSI = $result1x10[0]["SUM(votoSI)"];
        $votoNO = $result1x10[0]["SUM(votoNO)"];
        
        $chart["showLegend"] = "0";
        $label = "SI";
        $dataLocal["label"] = $label; //Carga de valores                
        $dataLocal["value"] = $votoSI; //Carga de valores
        $dataSetLocal["data"][] = $dataLocal; //data 

        $label = "NO";
        $dataLocal["label"] = $label; //Carga de valores                
        $dataLocal["value"] = $votoNO; //Carga de valores
        $dataSetLocal["data"][] = $dataLocal; //data 
        

        $data['dataSource']['chart'] = $chart;                
        $data['dataSource']['dataset'][] = $dataSetLocal;

        return json_encode($data);        
    }


    /**
     *
     *  Grafica de Votos Circuito Barra
     *
     */
    public function getDataChartOfBarra1x10() {
        
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

        //$chart["caption"] = "General 1x10 Estados";
        $chart["captionFontColor"] = "#e20000";
        $chart["captionFontSize"] = "20";                
        $chart["palette"]        = "1";
        $chart["showvalues"]     = "1";
        $chart["paletteColors"]  = "#0075c2,#c90606,#f2c500,#12a830,#1aaf5d";
        $chart["showBorder"] = "0";
        $chart["showCanvasBorder"] = "0";
        $chart["yaxisvaluespadding"] = "10";
        $chart["valueFontColor"] = "#ffffff";
        $chart["rotateValues"]   = "1";
        $chart["bgAlpha"] = "0,0";//Fondo         
        $chart["theme"]          = "fint";
        $chart["showborder"]     = "0";
        $chart["decimals"]       = "0";
        $chart["showLegend"] = "0";
        $chart["legendBgColor"] = "#ffffff";
        $chart["legendItemFontSize"] = "10";
        $chart["legendItemFontColor"] = "#666666";
        $chart["baseFontColor"] = "#ffffff";        
        $chart["outCnvBaseFontColor"] = "#ffffff";
        $chart["formatNumberScale"] = "0";

        $chart["usePlotGradientColor"] = "0";
        $chart["plotBorderAlpha"] = "10";
        $chart["legendBorderAlpha"] = "0";
        $chart["legendBgAlpha"] = "0";
        $chart["legendItemFontColor"] = "#ffffff";
        $chart["baseFontColor"] = "#ffffff";
        $chart["legendItemFontColor"] = "#ffffff";
        
        $chart["divLineDashed"] = "0";
        $chart["showHoverEffect"] = "1";
        $chart["valuePosition"] = "ABOVE";
        $chart["dashed"] = "0";
        $chart["divLineDashLen"] = "0";
        $chart["divLineGapLen"] = "0";
        $chart["canvasBgAlpha"] = "0,0";
        $chart["toolTipBgColor"] = "#000000";

        $em = $this->getDoctrine()->getManager();
        
        $label = $dataPlan = $dataReal = array();
        $count = 1;
        $votoNO = $votoSI = 0;

        $estados = [
            1 => "EDO. CARABOBO", 
            2 => "EDO. ZULIA", 
            3 => "EDO. ANZOATEGUI",
            4 => "OTROS"             
        ];
        
        foreach ($estados as $value) {
            $estado = $estados[$count];
            $label["label"] = $estado;     
            $category[] = $label;        
            
            if ($estado != "OTROS") {
                $resultEstado = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->findByBarra1x10($estado);                
            }else{
                $resultEstado = $em->getRepository("\Pequiven\SEIPBundle\Entity\Sip\Centro")->findByBarra1x10Otros();                
            }
            
            if (isset($resultEstado[0]["SUM(votoSI)"])) {
                $votoSI = $resultEstado[0]["SUM(votoSI)"];                
            }else{
                $votoSI = 0;
            }

            if (isset($resultEstado[0]["SUM(votoNO)"])) {
                $votoNO = $resultEstado[0]["SUM(votoNO)"];                
            }else{
                $votoNO = 0;
            }
            
            $dataReal1["value"] = $votoSI; //Carga de valores General
            $dataSetReal["data"][] = $dataReal1; //data                 
            
            $dataPlan1["value"] = $votoNO + $votoSI; //Carga de valores General
            $dataSetPlan["data"][] = $dataPlan1; //data 

            $count++;        
        }    

        $dataSetReal["seriesname"] = "Real";                
        $dataSetPlan["seriesname"] = "Plan";                

        $data['dataSource']['chart'] = $chart;
        $data['dataSource']['categories'][]["category"] = $category;
        $data['dataSource']['dataset'][] = $dataSetPlan;
        $data['dataSource']['dataset'][] = $dataSetReal;

        return json_encode($data);
    }
    
    public function consultTableOpen(\Pequiven\SEIPBundle\Entity\Sip\Center\ReportCentro $reportCentro){
        $observations = $reportCentro->getObservations();
        
        $open = false;
        foreach($observations as $observation){
            if($observation->getNotification() == 1){
                $open = true;
                break;
            }
        }
        
        return $open;
    }
    
    public function consultCenterIsOpen(){
        
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