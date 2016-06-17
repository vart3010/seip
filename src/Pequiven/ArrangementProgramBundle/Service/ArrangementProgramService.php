<?php

namespace Pequiven\ArrangementProgramBundle\Service;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Pequiven\ArrangementProgram\Entity\ArrangementProgram;
use ErrorException;
use Exception;
use LogicException;
use Pequiven\SEIPBundle\Model\Common\CommonObject;

/**
 * Servicios para el ArrangementProgram
 * 
 * service 
 * @author Maximo Sojo <maxsojo13@gmail.com>
 */
class ArrangementProgramService implements ContainerAwareInterface {
	
	private $container;

	public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    /**
     *
     * Carga de labels de los meses del informe de evolucion arrangement program
     *	
     */
    public function getMonthsArrangementProgram($cont)
    {   
        if ($cont == 1) {
            $month = "Enero";
        }elseif ($cont == 2) {
            $month = "Febrero";
        }elseif ($cont == 3) {
            $month = "Marzo";
        }elseif ($cont == 4) {
            $month = "Abril";
        }elseif ($cont == 5) {
            $month = "Mayo";
        }elseif ($cont == 6) {
            $month = "Junio";
        }elseif ($cont == 7) {
            $month = "Julio";
        }elseif ($cont == 8) {
            $month = "Agosto";
        }elseif ($cont == 9) {
            $month = "Septiembre";
        }elseif ($cont == 10) {
            $month = "Octubre";
        }elseif ($cont == 11) {
            $month = "Noviembre";
        }elseif ($cont == 12) {
            $month = "Diciembre";
        }
        return $month;        
    }

    public function ArrangementCalculateTendency($real, $cantData) {
        $cont = 1;
        $values = count($real);
        
        $dataX = $dataY = $dataXY = $dataXX = [];
        $dataTendency = 0;

        if ($values != 0) {
            for ($i=0; $i <$cantData; $i++) {             
                $data = $real[$cont];

                $dataX[] = $cont; //X
                $dataY[] = $data; //Y
                $dataXY[] = $data * $cont; //X*Y
                $dataXX[] = $cont * $cont; //X^2
                $cont++;
            }

            $sumaX = array_sum($dataX);
            $sumaY = array_sum($dataY);

            $d = ((count($dataX) * array_sum($dataXY)) - (array_sum($dataX) * array_sum($dataY)));
            $c = ((count($dataX) * array_sum($dataXX)) - (array_sum($dataX) * array_sum($dataX)));
            $b = $d / $c;

            $a = (($sumaY / count($dataY))) - ($b * ($sumaX / count($dataX)));

            $dataTendency = [
                'a' => $a,
                'b' => $b
            ];
        }
        return $dataTendency;
    }

	/**
     * Gráfico de Columna para informe de Evolución
     * @param ArrangementProgram $ArrangementProgram
     * @return type
     */
    public function getDataChartOfArrangementProgramEvolution($ArrangementProgram, $urlExportFromChart, $month) {
    	
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

        $chart["palette"]        = "1";
        $chart["showvalues"]     = "0";
        $chart["paletteColors"]  = "#0075c2,#c90606,#f2c500,#12a830,#1aaf5d";
        $chart["yaxisvaluespadding"] = "10";
        $chart["valueFontColor"] = "#000000";
        $chart["rotateValues"]   = "0";
        $chart["theme"]          = "fint";
        $chart["showborder"]     = "0";
        $chart["decimals"]       = "0";
        $chart["exportenabled"]  = "1";
        $chart["exportatclient"] = "0";
        $chart["exportFormats"]  = "PNG= Exportar Informe de Evolución PDF";
        $chart["exportFileName"] = "Grafico Resultados ";
        $chart["exporthandler"]  = $urlExportFromChart;

        $category = $dataSetReal = $dataSetPlan = $dataSetAcum = array();
        $label = $dataReal = $dataPlan = $dataAcum = $dataMedition = array();
        $cantData = $dataTendency = 0;
        //Carga de Nombres de Labels
        $dataSetReal["seriesname"] = "Real";
        $dataSetPlan["seriesname"] = "Plan";
        $dataSetAcum["seriesname"] = "Acumulado";
        $dataSetAnt["seriesname"]  = "2014";
        $labelAntper               = "2014";
        $labelProm                 = "Promedio o Acumulado";
        $labelobj                  = "Objetivo ".$ArrangementProgram->getPeriod()->getName();

    	$real = array();
        $planned = array();
        $em = $this->getDoctrine()->getManager();
        $timeline = $ArrangementProgram->getTimeline();

        foreach ($timeline->getGoals() as $timeline_goals) {
            //ENERO
            $sump = $timeline_goals->getGoalDetails()->getJanuaryPlanned();
            $sumr = $timeline_goals->getGoalDetails()->getJanuaryReal();
            $planned[1] = $sump;
            $real[1] = $sumr;

            //+FEBRERO
            $sump += $timeline_goals->getGoalDetails()->getFebruaryPlanned();
            $sumr += $timeline_goals->getGoalDetails()->getFebruaryReal();
            $planned[2] = $sump;
            $real[2] = $sumr;

            //+MARZO
            $sump += $timeline_goals->getGoalDetails()->getMarchPlanned();
            $sumr += $timeline_goals->getGoalDetails()->getMarchReal();
            $planned[3] = $sump;
            $real[3] = $sumr;

            //+ABRIL
            $sump += $timeline_goals->getGoalDetails()->getAprilPlanned();
            $sumr += $timeline_goals->getGoalDetails()->getAprilReal();
            $planned[4] = $sump;
            $real[4] = $sumr;

            //+MAYO
            $sump += $timeline_goals->getGoalDetails()->getMayPlanned();
            $sumr += $timeline_goals->getGoalDetails()->getMayReal();
            $planned[5] = $sump;
            $real[5] = $sumr;

            //+JUNIO
            $sump += $timeline_goals->getGoalDetails()->getJunePlanned();
            $sumr += $timeline_goals->getGoalDetails()->getJuneReal();
            $planned[6] = $sump;
            $real[6] = $sumr;

            //+JULIO
            $sump += $timeline_goals->getGoalDetails()->getJulyPlanned();
            $sumr += $timeline_goals->getGoalDetails()->getJulyReal();
            $planned[7] = $sump;
            $real[7] = $sumr;

            //+AGOSTO
            $sump += $timeline_goals->getGoalDetails()->getAugustPlanned();
            $sumr += $timeline_goals->getGoalDetails()->getAugustReal();
            $planned[8] = $sump;
            $real[8] = $sumr;

            //+SEPTIEMBRE
            $sump += $timeline_goals->getGoalDetails()->getSeptemberPlanned();
            $sumr += $timeline_goals->getGoalDetails()->getSeptemberReal();
            $planned[9] = $sump;
            $real[9] = $sumr;

            //+OCTUBRE
            $sump += $timeline_goals->getGoalDetails()->getOctoberPlanned();
            $sumr += $timeline_goals->getGoalDetails()->getOctoberReal();
            $planned[10] = $sump;
            $real[10] = $sumr;

            //+NOVIEMBRE
            $sump += $timeline_goals->getGoalDetails()->getNovemberPlanned();
            $sumr += $timeline_goals->getGoalDetails()->getNovemberReal();
            $planned[11] = $sump;
            $real[11] = $sumr;

            //+DICIEMBRE
            $sump += $timeline_goals->getGoalDetails()->getDecemberPlanned();
            $sumr += $timeline_goals->getGoalDetails()->getDecemberReal();
            $planned[12] = $sump;
            $real[12] = $sumr;
        }      
            //Carga de datos del label principal Periodo-2015
            $labelAnt["label"] = $labelAntper;//Label del 2014
            $category[] = $labelAnt;//Label del 2014
            
            //$cantData = count($real);          
            $cantData = (int)$month;          

            $cont = 1;
            $dataSetReal["data"][] = array( 'value' => '' );//Data vacia para saltar 2014
            $dataSetPlan["data"][] = array( 'value' => '' );//Data vacia para saltar 2014
            $dataSetTend["data"][] = array( 'value' => '' );//Data vacia para saltar 2014
            if ($cantData >= 3) { 
                $dataTendency = $this->ArrangementCalculateTendency($real, $cantData);
            }
            for ($i=0; $i < $cantData; $i++) {                 
                if ($real[$cont] != NULL) {                                                 
                    $month = $this->getMonthsArrangementProgram($cont);//Carga de labels de los meses

                    $label["label"] = $month;
                    $category[] = $label;
                
                    //Carga de la data Real
                    $dataReal["value"] = $real[$cont];
                    $dataSetReal["data"][] = $dataReal;
                    
                    //Carga de la Data Plan
                    $dataPlan["value"] = 100;
                    $dataSetPlan["data"][] = $dataPlan;

                    //creacion de la tendencia
                    $dataRealTendency["value"] = $dataTendency['a'] + ($dataTendency['b'] * $cont);
                    $dataSetTend["data"][] = $dataRealTendency; //Data Real Tendencia
                    
                }
                    $cont++;
            }
            
            //Label Promedio o Acumunlado
            $labelp["label"] = $labelProm;//Label del Prom
            $category[] = $labelp;//Label del Prom
            
            //Data Prom
            $dataSetReal["showvalues"] = "1";
            $dataAcum["value"] = $ArrangementProgram->getResult();//Pasando data a data prom
            $dataAcum["color"] = '#0a5f87';            
            $dataSetReal["data"][] = $dataAcum;//promedio

            //Label Objetivo
            $labelo["label"] = $labelobj;//Label del ObjAcum
            $category[] = $labelo;//Label del ObjAcum

            //Pasando Objetivo Acum
            $dataObj["value"] = 100;//Pasando data a Dataobj
            $dataObj["color"] = '#087505';            
            $dataSetReal["data"][] = $dataObj;//Acumulado

            //Carga de linea de real
            $dataSetPlan['data'] = array('seriesname' => 'Plan', 'parentyaxis' => 'S', 'renderas' => 'Line', 'data' => $dataSetPlan['data']);
            //Carga de Tendencia
            $cantValue = count($dataSetTend['data']);
            

            if ($cantValue >= 4) {
                $dataSetValues['tendencia'] = array('seriesname' => 'Tendencia', 'parentyaxis' => 'S', 'renderas' => 'Line', 'color' => '#dbc903', 'data' => $dataSetTend['data']);                
            }elseif(!$cantValue) {
                $dataSetValues['tendencia'] = 0;                
            }
            else{
                $dataSetValues['tendencia'] = 0;
            }

        	//Data 2014
        	$dataAnt["value"] = 0;
            $dataAnt["color"] = '#f2c500';            
            $dataSetAnt["showvalues"] = "1";            
            $dataSetAnt["data"][] = $dataAnt;//2014
        	
        	$data['dataSource']['chart'] = $chart;
        	$data['dataSource']['categories'][]["category"] = $category;
			$data['dataSource']['dataset'][] = $dataSetValues['tendencia'];
			$data['dataSource']['dataset'][] = $dataSetReal;
			$data['dataSource']['dataset'][] = $dataSetAnt;
			$data['dataSource']['dataset'][] = $dataSetPlan['data'];
        	
        //return json_encode($data);
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
 	
 	protected function getSecurityService() {
        return $this->container->get('seip.service.security');
    }
}