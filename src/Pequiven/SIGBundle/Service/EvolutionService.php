<?php

namespace Pequiven\SIGBundle\Service;

use Doctrine\Bundle\DoctrineBundle\Registry;
use ErrorException;
use Exception;
use LogicException;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Servicios para los informes de evolución
 * 
 * 
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
class EvolutionService implements ContainerAwareInterface {

	private $container;

	/**
     * Buscamos las acciones de las causas
     * @param Request $request
     * @return \Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionCauses
     * @throws type
     */
    public function findEvolutionCause($object, $request, $typeObject) {        
        $id = $object->getId();

        //Mes Consultado       
        $month = $request->get('month');

        //Carga de variable base
        $opc = false;
        $idAction = $actionResult = 0;
        $idCons = [0];

        //$results = $this->container->get('pequiven.repository.sig_causes_report_evolution')->findBy(array('indicator' => $idIndicator,'month'=> $month));
        if ($typeObject == 1) {
            $results = $this->container->get('pequiven.repository.sig_causes_report_evolution')->findBy(array('indicator' => $id));
        } elseif ($typeObject == 2) {
            $results = $this->container->get('pequiven.repository.sig_causes_report_evolution')->findBy(array('arrangementProgram' => $id));
        }

        $cause = array();
        if ($results) {
            foreach ($results as $value) {
                $idCause = $value->getId();
                $cause[] = $idCause;
            }
            $action = $this->container->get('pequiven.repository.sig_action_indicator')->findBy(array('evolutionCause' => $cause));
        }

        if (!$results) {
            $action = null;
        }

        //Carga de las acciones para sacar la verificaciones realizadas
        if ($action) {
            foreach ($action as $value) {
                $relation = $value->getRelactionValue();
                foreach ($relation as $value) {
                    $monthAction = $value->getMonth();
                    $monthGet = (int) $month;
                    if ($monthAction === $monthGet) {

                        $idAction = $value->getActionValue()->getId();
                        $idCons[] = $idAction;
                    }
                }
            }
            $actionResult = $this->container->get('pequiven.repository.sig_action_indicator')->findBy(array('id' => $idCons));
        }
//        $actionsValues = EvolutionActionValue::getActionValues($idCons, $month);          
        $actionsValues = $this->container->get('pequiven.repository.sig_action_value_indicator')->findBy(array('actionValue' => $idCons, 'month' => $month));
        $cant = count($actionResult);

        if ($opc = false) {
            $idAction = null;
        }
        if ($typeObject == 1) {
            $verification = $this->container->get('pequiven.repository.sig_action_verification')->findBy(array('indicator' => $id, 'month' => $month));
        } elseif ($typeObject == 2) {
            $verification = $this->container->get('pequiven.repository.sig_action_verification')->findBy(array('arrangementProgram' => $id, 'month' => $month));
        }

        //Carga de array con la data
        $data = [
            'action'        => $actionResult, //Pasando la data de las acciones si las hay
            'verification'  => $verification, //Pasando la data de las verificaciones            
            'actionValue'   => $actionsValues,
            'cant'          => $cant
        ];

        return $data;
    }   

    /**
     * 
     * Gráfico de Columna para Causas de Desviación
     * @return type
     */
    public function getDataChartOfCausesEvolution($object, $urlExportFromChart, $month, $typeObject) {

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
        $chart["valueFontColor"] = "#000000";
        $chart["showvalues"] = "0";
        $chart["showSum"] = "1";
        $chart["numberSuffix"] = "%";
        $chart["bgalpha"] = "0,0";
        $chart["baseFontColor"] = "#ffffff";
        $chart["bgColor"] = "#ffffff";
        $chart["legendBgColor"] = "#ffffff";
        $chart["legendItemFontSize"] = "10";
        $chart["legendItemFontColor"] = "#666666";
        $chart["toolTipColor"] = "#ffffff";
        $chart["outCnvBaseFontColor"] = "#000000";
        $chart["visible"] = "1";
        $chart["theme"] = "fint";
        $chart["snumbersuffix"] = "%";
        $chart["decimals"] = "0";
        $chart["setadaptiveymin"] = "1";
        $chart["setadaptivesymin"] = "1";
        $chart["linethickness"] = "5";
        $chart["showborder"] = "0";
        $chart["exportenabled"] = "1";
        $chart["exportatclient"] = "0";
        $chart["exportFormats"] = "PNG= Exportar Informe de Evolución PDF";
        $chart["exportFileName"] = "Grafico Resultados ";
        $chart["exporthandler"] = $urlExportFromChart;

        //Inicialización
        $category = $dataSetCause = array();
        $label = $dataCause = array();
        $contCause = 1;
        //Carga de Nombres de Labels
        $dataSetCause["seriesname"] = "Causas";
        $monthCause = (int)$month;
        
        switch ($typeObject) {
            case '1':
                $query = $object->getindicatorCause();
                break;
            case '2':
                $query = $object->getArrangementProgramCauses();
                break;
            case '3':
                $query = 0;
                break;            
            default:
                $query = 0;
                break;
        }            

        foreach ($query as $value) {                
            if ($value->getMonth() === $monthCause) {                
                $label["label"] = $value->getCauses();                    
                $contCause = $contCause + 1;
                $category[] = $label;
            }
        }
        
        foreach ($query as $value) {                
            if ($value->getMonth() === $monthCause) {                                    
                $dataCause["value"] = $value->getvalueOfCauses();
                $dataSetCause["data"][] = $dataCause;                
            }                
        }        
           
        $data['dataSource']['chart'] = $chart;
        $data['dataSource']['categories'][]["category"] = $category;
        $data['dataSource']['dataset'][] = $dataSetCause;

        return $data;
    }

    /**
     *
     *
     */
	public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
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