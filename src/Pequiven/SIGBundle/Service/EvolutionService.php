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
     *
     *  Periodos Validos
     *
     */
    public function getLastPeriods($periodLoad){
        $periodLoad = $periodLoad - 1;

        $periods = [
            1 => "2014",
            2 => "2015",
            3 => "2016"
        ];

        foreach ($periods as $key => $value) {
            $arrayLabelAnt[] = $value;
        }

        for ($i = 0; $i < $periodLoad; $i++) {
            $labelAnt["label"] = $arrayLabelAnt[$i]; //Label de periodos anteriores
            $category[] = $labelAnt; //Label de periodos anteriores            
        }
        $data = [
            'periods' => $periods,
            'category'=> $category
        ];

        return $data;
    }

	/**
     * Buscamos las entidades consultadas
     * @param Request $request
     * @return \Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionCauses
     * @throws type
     */
    public function getObjectEntity($id, $typeObject) { 
        if ($typeObject == 1) {
            $result = $this->container->get('pequiven.repository.indicator')->find($id);
        } elseif ($typeObject == 2) {
            $result = $this->container->get('pequiven_seip.repository.arrangementprogram')->find($id);
        }elseif ($typeObject == 3) {
            $result = $this->container->get('pequiven.repository.objetive')->find($id);
        }

        return $result;
    }  

    /**
     * Buscamos las entidades consultadas
     * @param Request $request
     * @return \Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionCauses
     * @throws type
     */
    public function getObjectLoadFile($id, $typeObject) { 
        if ($typeObject == 1) {
            $result = $this->container->get('pequiven.repository.sig_causes_analysis')->find($id);
        }
        return $result;
    }   

    /**
     *
     *  Metodo de Validación de Estatus del Informe de Evolución
     *
     */
    public function findToCheckApproveEvolution($object, $typeObject, $month){
        $validStatus = 'check';
        $status = 1;
        $em = $this->getDoctrine();
        $result = $em->getRepository('Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionApprove')->findBy(array('idObject' => $object->getId(),'month' => $month, 'typeObject' => $typeObject));
        if (count($result)) {
            foreach ($result as $key => $value) {
                if (!$value->getStatusCheck()) {
                    $validStatus = 'check';
                    $status = 1;
                }elseif (!$value->getStatusApprove()) {
                    $validStatus = 'approve';
                    $status = 2;
                }else{
                    $validStatus = '';
                    $status = 3;
                }
            }
        }        

        $data = [
            'button' => $validStatus,
            'status' => $status           
        ];

        return $data;
    }

    /**
     *
     *  Metodo de Validación de Estatus del Informe de Evolución
     *
     */
    public function updateToCheckApproveEvolution($id, $typeObject, $month){
        $validStatus = 'check';
        $status = 1;
        $user = $this->getUser(); 
        $em = $this->getDoctrine()->getManager();        
        $result = $em->getRepository('Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionApprove')->findOneBy(array('idObject' => $id,'month' => $month, 'typeObject' => $typeObject));
        
        if (count($result) != 0) {            
            if (!$result->getStatusCheck()) {
                $result->setStatusCheck(1);
                $result->setUserCheck($user);
                $message = "Revisado";                
            }else{
                $result->setStatusApprove(1);
                $result->setUserApprove($user);                                
                $message = "Aprobado";
            }            
            $em->flush();
        }     

        $data = [
            'button'  => $validStatus,
            'status'  => $status,
            'message' => $message
        ];

        return $data;
    }

    /**
     * Buscamos las acciones de las causas
     * @param Request $request
     * @return \Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionCauses
     * @throws type
     */
    public function findEvolutionCause($object, $request, $typeObject, $syncValid) {        
        $id = $object->getId();        
        //Mes Consultado       
        $month = $request->get('month');
        //Carga de variable base
        $action = null;
        $opc = false;
        $idAction = $actionResult = 0;
        $idCons = [0];
        $action = "";

        $object = $this->getObjectEntity($id, $typeObject);        
        $cause = $this->findCausesEvolution($object->getId(), null, $typeObject); 
        $causesData = [];
        for ($i=0; $i <count($cause['id']) ; $i++) { 
            $causesData[$cause['id'][$i]] = $cause['sync'][$i];            
        }   
        
        if (count($cause['id']) > 0) {$action = $this->container->get('pequiven.repository.sig_action_indicator')->findBy(array('evolutionCause' => $cause['id']));}
        
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
            //$actionResult = $this->container->get('pequiven.repository.sig_action_indicator')->findBy(array('id' => $idCons));            
        }
        $idAction = $ref = $action = $typeAction = $dateStart = $dateEnd = $advance = $responsibles = $observations = $sync = [];
        $actionsValues = $this->container->get('pequiven.repository.sig_action_value_indicator')->findBy(array('actionValue' => $idCons, 'month' => $month));
        //Nuevo codigo para carga de acciones
        if ($syncValid == true) {
            foreach ($actionsValues as $value) {
                //$idCauses = $value->getActionValue()->getEvolutionCause()->getId();            
                $idAction[]     = $value->getActionValue()->getId();
                $ref[]          = $value->getActionValue()->getRef();
                $action[]       = $value->getActionValue()->getAction();
                $typeAction[]   = $value->getActionValue()->getIndicatorAction()->getRef();
                $dateStart[]    = $value->getActionValue()->getDateStart();
                $dateEnd[]      = $value->getActionValue()->getDateEnd();
                $advance[]      = $value->getAdvance();
                $responsibles[$value->getActionValue()->getId()] = $value->getActionValue()->getResponsible();
                $observations[] = $value->getObservations();
                $sync[]         = $causesData[$value->getActionValue()->getEvolutionCause()->getId()];            
            }
            
            $dataAction = [
                'id'          =>$idAction,
                'ref'         =>$ref,
                'action'      =>$action,
                'typeAction'  =>$typeAction,
                'dateStart'   =>$dateStart,
                'dateEnd'     =>$dateEnd,
                'advance'     =>$advance,
                'responsibles'=>$responsibles,
                'observations'=>$observations,
                'sync'        => $sync,
                'cant'        => count($idAction)
            ];
            //$cant = count($actionResult);
            $actionsValues = $dataAction;
        }
        $cant = count($actionsValues);
        
        if ($opc = false) {$idAction = null;}                
        $verification = $this->container->get('pequiven.repository.sig_action_verification')->findBy(array('idObject' => $id, 'month' => $month, 'typeObject' => $typeObject));
        //Carga de array con la data
        $data = [
            //'action'        => $actionResult, //Pasando la data de las acciones si las hay
            'verification'  => $verification, //Pasando la data de las verificaciones            
            'actionValue'   => $actionsValues, //acciones
            'cant'          => $cant
        ];
        
        return $data;
    }   

    public function findCausesEvolution($idObject, $month, $typeObject){
        $causesData = $id = $description = $createdBy = $valueofCause = $createdByUserName = $sync = [];
        if ($month != null) {$causes = $this->container->get('pequiven.repository.sig_causes_report_evolution')->findBy(array('idObject' => $idObject, 'month' => $month, 'typeObject' => $typeObject));}else{$causes = $this->container->get('pequiven.repository.sig_causes_report_evolution')->findBy(array('idObject' => $idObject, 'typeObject' => $typeObject));}
        foreach ($causes as $valueCauses) {
            $id[] = $valueCauses->getId();
            $description[] = $valueCauses->getCauses();
            $valueofCause[] = $valueCauses->getValueOfCauses();
            $createdBy[] = $valueCauses->getCreatedBy()->getFirstname()." ".$valueCauses->getCreatedBy()->getLastname();
            $createdByUserName[] = $valueCauses->getCreatedBy()->getUsername();
            $sync[] = null;
        }
        $em = $this->getDoctrine()->getManager();        
        $result = $em->getRepository('Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionCauseSync')->findBy(array('idObject' => $idObject,'typeObject' => $typeObject));
        if ($result) {
            foreach ($result as $valueCauseSync) {
                if ($month != null) { $cause = $this->container->get('pequiven.repository.sig_causes_report_evolution')->findOneBy(array('id'=>$valueCauseSync->getCause(),'month' => $month));}else{ $cause = $this->container->get('pequiven.repository.sig_causes_report_evolution')->find($valueCauseSync->getCause());}
                if ($cause) {
                    $id[] = $cause->getId();   
                    $description[] = $cause->getCauses();
                    $valueofCause[] = $cause->getValueOfCauses();
                    $createdBy[] = $cause->getCreatedBy()->getFirstname()." ".$cause->getCreatedBy()->getLastname();
                    $createdByUserName[] = $cause->getCreatedBy()->getUsername();                                  
                    $sync[] = true;
                }
            }            
        }
        
        $causesData = [
            'id'                => $id,
            'description'       => $description,
            'valueofCause'      => $valueofCause,
            'createdBy'         => $createdBy,
            'createdByUserName' => $createdByUserName,
            'sync'              => $sync,
            'cant'              => count($id),
        ];
        
        return $causesData;
    }
    public function getGoalsArrangementProgram($arrangementprogram){
        $timeline = $arrangementprogram->getTimeline();
        $planned = $real = [];
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
        
        $data = [
            'planned' => $planned,
            'real'    => $real
        ];
        
        return $data;
    }

    /**
     *
     *
     *
     */
    public function getValuesOfIndicators($indicator){
        $cont = 1;
        $planned = $real = [];
        foreach ($indicator->getValuesIndicator() as $value) {
            $real[$cont] = $value->getValueOfIndicator();
            $cont++;
        }
        
        $data = [
            'planned' => $planned,
            'real'    => $real
        ];
        return $data;
    }

    /**
     *
     *
     *
     */
    public  function getDataChartOfObjetiveEvolution($object, $urlExportFromChart, $month){
        $valuePorcen = 100;
        $periodCharge = $object->getPeriod()->getId();
        $dataPeriods = $this->getLastPeriods($periodCharge);        
        $periods = $dataPeriods['periods'];
        $IndicatorService = $this->getIndicatorService(); //Obtenemos el servicio de los programas            
        
        $data = [];
        if (count($object->getIndicators()) != 0) {
            $indicators = $object->getIndicators();  
            foreach ($indicators as $value) {
                $labelsFrequencyNotificationArray = $IndicatorService->getLabelsByIndicatorFrequencyNotification($value);
                $data[] = $this->getValuesOfIndicators($value);                            
            }                        
            $objectCons = 1;
            $contReal = count($labelsFrequencyNotificationArray);            
        }elseif(count($object->getArrangementPrograms()) != 0){
            $arrangementprogram = $object->getArrangementPrograms();
            foreach ($arrangementprogram as $value) {            
                $data[] = $this->getGoalsArrangementProgram($value);            
            }
            $objectCons = 2;
            $contReal = 12;
        }

        $real = [];
        for ($i=0; $i < $contReal; $i++) {         
            for ($j=0; $j < count($data); $j++) {                 
                if ($data[$j]['real']) {                    
                    $dataReal = $data[$j]['real'][$i+1];                                        
                    $real[$i+1] = $dataReal + $dataReal;
                }
            }            
        }
        
        $ArrangementProgramService = $this->getArrangementProgramService(); //Obtenemos el servicio de los programas            

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
        $labelProm                 = "Promedio";
        $labelobj                  = "Objetivo ".$periods[$periodCharge];
        $category = $dataPeriods['category'];        
        
        $cantData = (int)$month;          
        if ($cantData > count($real)) {
            $cantData = count($real);
        }

        $cont = 1;
        if ($periodCharge > 2) {
            $dataSetReal["data"][] = array( 'value' => '' );//Data vacia para saltar 2014
            $dataSetPlan["data"][] = array( 'value' => '' );//Data vacia para saltar 2014
            $dataSetTend["data"][] = array( 'value' => '' );//Data vacia para saltar 2014            
        }
        
        $dataSetReal["data"][] = array( 'value' => '' );//Data vacia para saltar 2014
        $dataSetPlan["data"][] = array( 'value' => '' );//Data vacia para saltar 2014
        $dataSetTend["data"][] = array( 'value' => '' );//Data vacia para saltar 2014
        
        if ($cantData >= 3) {                    
            $dataTendency = $ArrangementProgramService->ArrangementCalculateTendency($real, $cantData);//Calculo de Tendencia en servicio de Programas de Gestión
        }
        for ($i=0; $i < $cantData; $i++) {                 
            if ($real[$cont] != NULL) { 
                if ($objectCons == 1) {
                    $month = $labelsFrequencyNotificationArray[$cont];
                }else{
                    $month = $ArrangementProgramService->getMonthsArrangementProgram($cont);//Carga de labels de los meses                    
                }
                
                $label["label"] = $month;
                $category[] = $label;            
                //Carga de la data Real
                $dataReal["value"] = $real[$cont];
                $dataSetReal["data"][] = $dataReal;
                
                //Carga de la Data Plan
                $dataPlan["value"] = $object->getResultOfObjetive();//$planned[$cont];
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
        $dataAcum["value"] = $object->getResultOfObjetive();//Pasando data a data prom
        $dataAcum["color"] = '#0a5f87';            
        $dataSetReal["data"][] = $dataAcum;//promedio

        //Label Objetivo
        $labelo["label"] = $labelobj;//Label del ObjAcum
        $category[] = $labelo;//Label del ObjAcum

        //Pasando Objetivo Acum
        $dataObj["value"] = $object->getGoal();//Pasando data a Dataobj
        $dataObj["color"] = '#087505';            
        $dataSetReal["data"][] = $dataObj;//Acumulado

        //Carga de linea de real
        $dataSetPlan['data'] = array('seriesname' => 'Plan', 'parentyaxis' => 'S', 'renderas' => 'Line', 'data' => $dataSetPlan['data']);
        //Carga de Tendencia
        $cantValue = count($dataSetTend['data']);
        

        $dataSetValues['tendencia'] = 0;                
        if ($cantValue >= 4) {
            $dataSetValues['tendencia'] = array('seriesname' => 'Tendencia', 'parentyaxis' => 'S', 'renderas' => 'Line', 'color' => '#dbc903', 'data' => $dataSetTend['data']);                
        }

        for ($i = 1; $i < $periodCharge; $i++) {            
            $dataAnt["value"] = 0;
            $dataAnt["color"] = '#f2c500';
            $dataSetAnt["showvalues"] = "1";
            $dataSetAnt["data"][] = $dataAnt;
        }
        
        $data['dataSource']['chart'] = $chart;
        $data['dataSource']['categories'][]["category"] = $category;
        $data['dataSource']['dataset'][] = $dataSetValues['tendencia'];
        $data['dataSource']['dataset'][] = $dataSetReal;
        $data['dataSource']['dataset'][] = $dataSetAnt;
        $data['dataSource']['dataset'][] = $dataSetPlan['data'];

        return $data;
    }

    /**
     * 
     * Gráfico de Columna para Causas de Desviación
     * @return type
     */
    public function getDataChartOfCausesEvolution($object, $urlExportFromChart, $month, $typeObject, $causes) {

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
        $chart["yaxisname"] = "VALOR PORCENTUAL DE LA CAUSA";
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
        
        //$causes = $this->container->get('pequiven.repository.sig_causes_report_evolution')->findBy(array('idObject' => $object->getId(), 'month' => $month, 'typeObject' => $typeObject));
        
        for ($i=0; $i < $causes['cant'] ; $i++) { 
            $label["label"] = $causes['description'][$i];                    
            $contCause = $contCause + 1;
            $category[] = $label;
        }

        for ($i=0; $i <$causes['cant'] ; $i++) { 
            $dataCause["value"] = $causes['valueofCause'][$i];
            $dataSetCause["data"][] = $dataCause;                
        }
        /*foreach ($causes as $value) {                
            if ($value->getMonth() === $monthCause) {                
                $label["label"] = $value->getCauses();                    
                $contCause = $contCause + 1;
                $category[] = $label;
            }
        }
        
        foreach ($causes as $value) {                
            if ($value->getMonth() === $monthCause) {                                    
                $dataCause["value"] = $value->getvalueOfCauses();
                $dataSetCause["data"][] = $dataCause;                
            }                
        } */       
           
        $data['dataSource']['chart'] = $chart;
        $data['dataSource']['categories'][]["category"] = $category;
        $data['dataSource']['dataset'][] = $dataSetCause;

        return $data;
    }

    /**
     * 
     * @return \Pequiven\IndicatorBundle\Service\IndicatorService
     */
    protected function getIndicatorService() {
        return $this->container->get('pequiven_indicator.service.inidicator');
    }    


    /**
     * 
     * @return \Pequiven\IndicatorBundle\Service\ArrangementProgramService
     */
    protected function getArrangementProgramService() {
        return $this->container->get('pequiven.service.arrangementprogram');
    } 

    /**
     * Servicio que calcula los resultados
     * @return \Pequiven\SEIPBundle\Service\ResultService
     */
    public function getResultService()
    {
        return $this->container->get('seip.service.result');
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

    /**
     * Get a user from the Security Context
     *
     * @return mixed
     *
     * @throws LogicException If SecurityBundle is not available
     *
     * @see TokenInterface::getUser()
     */
    public function getUser() {
        if (!$this->container->has('security.context')) {
            throw new LogicException('The SecurityBundle is not registered in your application.');
        }

        if (null === $token = $this->container->get('security.context')->getToken()) {
            return;
        }

        if (!is_object($user = $token->getUser())) {
            return;
        }

        return $user;
    }
}