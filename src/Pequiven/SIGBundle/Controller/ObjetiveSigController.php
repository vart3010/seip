<?php

namespace Pequiven\SIGBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Pequiven\SIGBundle\Controller\EvolutionController;
use Pequiven\ObjetiveBundle\Entity\Objetive;
use Pequiven\ObjetiveBundle\Entity\ObjetiveLevel;

/**
 * Controlador ObjetivosSIG
 *
 * @author Maximo Sojo <maxsojo13@gmail.com>
 */
class ObjetiveSigController extends EvolutionController
{
    /**
     * Finds and displays a Objetive entity of level Operative by Id.
     *
     */
    public function showAction(Request $request)
    {
        $resource = $this->findOr404($request);
        switch ($resource->getObjetiveLevel()->getId()) {
            case 1:
                $dataObject = [
                    'route' => 'Strategic',
                    'rol' => 'STRATEGIC'
                ];
                break;
            case 2:
                $dataObject = [
                    'route' => 'Tactic',
                    'rol' => 'TACTIC'
                ];
                break;
            case 3:
                $dataObject = [
                    'route' => 'Operative',
                    'rol' => 'OPERATIVE'
                ];
                break;
        }
        $securityService = $this->getSecurityService();
        $securityService->checkSecurity(array('ROLE_SEIP_OBJECTIVE_VIEW_'.$dataObject['rol'],'ROLE_SEIP_PLANNING_VIEW_OBJECTIVE_'.$dataObject['rol'],'ROLE_SEIP_SIG_OBJECTIVE_VIEW_'.$dataObject['rol']));
        
        if(!$securityService->isGranted('ROLE_SEIP_PLANNING_VIEW_OBJECTIVE_'.$dataObject['rol'])){
            if(!$securityService->isGranted('ROLE_SEIP_SIG_OBJECTIVE_VIEW_'.$dataObject['rol'])){
                $securityService->checkSecurity('ROLE_SEIP_OBJECTIVE_VIEW_'.$dataObject['rol'],$resource);
            } else{
                $securityService->checkSecurity('ROLE_SEIP_SIG_OBJECTIVE_VIEW_'.$dataObject['rol'],$resource);
            }
        }
        $indicatorService = $this->getIndicatorService();
        
        //TODO: Colocar la validación de si el objetivo táctico está aprobado
        $hasPermissionToApproved = $securityService->isGrantedFull("ROLE_SEIP_OBJECTIVE_APPROVED_".$dataObject['rol'],$resource);
        $hasPermissionToUpdate = $securityService->isGrantedFull("ROLE_SEIP_OBJECTIVE_EDIT_".$dataObject['rol'],$resource);
        $isAllowToDelete = $securityService->isGrantedFull("ROLE_SEIP_OBJECTIVE_DELETE_".$dataObject['rol'],$resource);
        
        $idManagements = [];
        $indicators    = [];
        $idIndicators  = [];
        foreach ($resource->getManagementSystems() as $managementsystems) {
            $idManagements[] = $managementsystems->getId();
        }
        
        foreach ($resource->getIndicators() as $dataIndicators) {            
            foreach ($dataIndicators->getManagementSystems() as $indicatorsManagement) {
                if (in_array($indicatorsManagement->getId(), $idManagements)) {                        
                    $indicators[] = $dataIndicators;                
                }
            }
        }
        $indicators = array_unique($indicators);
        
        $view = $this
            ->view()
            ->setTemplate('PequivenSIGBundle:Objetive:'.$dataObject['route'].'/show.html.twig')
            ->setTemplateVar('entity')
            ->setData(array(
                'entity'            => $resource,
                'indicators'        => $indicators,
                'indicatorService'  => $indicatorService,
                'hasPermissionToUpdate'   => $hasPermissionToUpdate,
                'hasPermissionToApproved' => $hasPermissionToApproved,
                'isAllowToDelete'         => $isAllowToDelete,
            ))
        ;
        $groups = array_merge(array('id','api_list','gerencia','gerenciaSecond'), $request->get('_groups',array()));
        $view->getSerializationContext()->setGroups($groups);
        return $this->handleView($view);
    }

    /**
     *
     *  Metodo informe de evolución
     *
     */
    public function evolutionAction(Request $request){
        $resource = $this->findOr404($request);        
        
        $idObject = $request->get('id');
        $typeObject = 3;
        $month    = $request->get('month');
        $sumCause = 0;
        
        $evolutionService = $this->getEvolutionService(); //Obtenemos el servicio de las causas            

        $object = $this->container->get('pequiven.repository.objetive')->find($idObject);
        //Validación para Visualizar informe de Evolución
        if (!$object->getShowEvolutionView()) {
            $this->get('session')->getFlashBag()->add('success', 'Objetivo no Habilitado para Visualizar Informe de Evolución');
            return $this->redirect($this->generateUrl("pequiven_seip_default_index"));         
        }
        //Url export
        $urlExportFromChart = $this->generateUrl('pequiven_indicator_evolution_export_chart', array('id' => $request->get("id"), 'month' => $month, 'typeObj' => 3));
        //Grafica de Evolución
        $dataChartEvolution = $evolutionService->getDataChartOfObjetiveEvolution($object, $urlExportFromChart, $month); //Obtenemos la data del gráfico de acuerdo al indicador

        //Consulta de Causas
        $causes = $evolutionService->findCausesEvolution($idObject,$month,$typeObject);        
        for ($i=0; $i < $causes['cant']; $i++) { 
            $dataCa = $causes['valueofCause'][$i];
            $sumCause = $sumCause + $dataCa;            
        }

        //Carga de los datos de la grafica de las Causas de Desviación
        $dataChartCause = $evolutionService->getDataChartOfCausesEvolution($object, $urlExportFromChart, $month, $typeObject, $causes); //Obtenemos la data del grafico de las causas de desviación
        
        $objetive = $this->get('pequiven.repository.objetive')->find($idObject); //Obtenemos el Objetivo 
        //Carga el analisis de la tendencia
        $trend = $this->get('pequiven.repository.sig_trend_report_evolution')->findBy(array('idObject' => $idObject, 'month' => $month, 'typeObject' => $typeObject));
        //Carga del analisis de las causas
        $causeAnalysis = $this->get('pequiven.repository.sig_causes_analysis')->findBy(array('idObject' => $idObject, 'month' => $month, 'typeObject' => $typeObject));
        
        $data = $evolutionService->findEvolutionCause($object, $request, $typeObject, true); //Carga la data de las causas y sus acciones relacionadas        
        
        $dataAction = [
            //'action' => $data["action"],
            'values' => $data["actionValue"]
        ];
        
        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('evolution.html'))
                ->setData(array(
                'typeObject' => 3,
                'month'      => $month,
                'entity'     => $objetive,                
                'data'                => $dataChartEvolution,
                'dataCause'           => $dataChartCause,
                'trend'               => $trend,                
                'analysis'            => $causeAnalysis,
                'cause'               => $causes,
                'sumCause'            => $sumCause,                
                'dataAction'          => $dataAction,                
                'verification'        => $data["verification"],                
                'id'                  => null,
                'cloning'             => null,
                'route'               => "pequiven_seip_arrangementprogram_evolution_sig",//Ruta para carga de Archivo
                'level'               => $objetive->getObjetiveLevel()->getId(),
                $this->config->getResourceName() => $resource,                
        ));

        return $this->handleView($view);      
    }

    /**
     * Lista de Objetivos por nivel(Estratégico, Táctico u Operativo)
     * Filtrados por managementSystems 
     * @param Request $request
     * @return type
     */
    function ObjetiveslistAction(Request $request) {

        $level = $request->get('level'); 
        
        $rol = null;
        $roleByLevel = array(
            ObjetiveLevel::LEVEL_ESTRATEGICO => array('ROLE_SEIP_SIG_OBJECTIVE_VIEW'),
            ObjetiveLevel::LEVEL_TACTICO => array('ROLE_SEIP_SIG_OBJECTIVE_VIEW'),
            ObjetiveLevel::LEVEL_OPERATIVO => array('ROLE_SEIP_SIG_OBJECTIVE_VIEW')
        );
        
        if (isset($roleByLevel[$level])) {
            $rol = $roleByLevel[$level];
        }

        $this->getSecurityService()->checkSecurity($rol);
        
        $criteria = $request->get('filter', $this->config->getCriteria());
        $sorting = $request->get('sorting', $this->config->getSorting());
        $repository = $this->container->get('pequiven.repository.managementsystem_sig_objetives');
        
        $criteria['objetiveLevel'] = $level;
        $criteria['applyPeriodCriteria'] = false;

        if ($this->config->isPaginated()) {
            $resources = $this->resourceResolver->getResource(
                    $repository, 'createPaginatorByLevelSIG', array($criteria, $sorting)
            );
            $maxPerPage = $this->config->getPaginationMaxPerPage();
            if (($limit = $request->query->get('limit')) && $limit > 0) {
                if ($limit > 100) {
                    $limit = 100;
                }
                $maxPerPage = $limit;
            }
            $resources->setCurrentPage($request->get('page', 1), true, true);
            $resources->setMaxPerPage($maxPerPage);
        } else {
            $resources = $this->resourceResolver->getResource(
                    $repository, 'findBy', array($criteria, $sorting, $this->config->getLimit())
            );
        }
        $routeParameters = array(
            '_format' => 'json',
            'level' => $level,
        );
        $apiDataUrl = $this->generateUrl('pequiven_objetives_list_sig', $routeParameters);
        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('list.html'))
                ->setTemplateVar($this->config->getPluralResourceName())
        ;
        
        $view->getSerializationContext()->setGroups(array('id', 'api_list', 'valuesIndicator','managementSystems','api_details', 'sonata_api_read', 'formula'));
        if ($request->get('_format') == 'html') {            
            $data = array(
                'apiDataUrl' => $apiDataUrl,
                $this->config->getPluralResourceName() => $resources,
                'level' => $level
            );
            $view->setData($data);

        } else {
            $formatData = $request->get('_formatData', 'default');
            $view->setData($resources->toArray('', array(), $formatData));
        }
        return $this->handleView($view);

    }

    /**
     * Lista de Objetivos con Informe de Evolución
     * Filtrados por managementSystems 
     * @param Request $request
     * @return type
     */
    function ObjetiveslistEvolutionAction(Request $request) {
        $level = $request->get('level'); 
        
        $rol = null;
        $roleByLevel = array(
            ObjetiveLevel::LEVEL_ESTRATEGICO => array('ROLE_SEIP_SIG_OBJECTIVE_VIEW'),
            ObjetiveLevel::LEVEL_TACTICO => array('ROLE_SEIP_SIG_OBJECTIVE_VIEW'),
            ObjetiveLevel::LEVEL_OPERATIVO => array('ROLE_SEIP_SIG_OBJECTIVE_VIEW')
        );
        
        if (isset($roleByLevel[$level])) {
            $rol = $roleByLevel[$level];
        }

        $criteria = $request->get('filter', $this->config->getCriteria());
        $sorting = $request->get('sorting', $this->config->getSorting());
        $repository = $this->container->get('pequiven.repository.managementsystem_sig_objetives');
        
        $criteria['objetiveLevel'] = $level;        
        $criteria['applyPeriodCriteria'] = false;

        if ($this->config->isPaginated()) {
            $resources = $this->resourceResolver->getResource(
                    $repository, 'createPaginatorByLevelSIGEvolution', array($criteria, $sorting)
            );        

            $maxPerPage = $this->config->getPaginationMaxPerPage();
            if (($limit = $request->query->get('limit')) && $limit > 0) {
                if ($limit > 100) {
                    $limit = 100;
                }
                $maxPerPage = $limit;
            }
            $resources->setCurrentPage($request->get('page', 1), true, true);
            $resources->setMaxPerPage($maxPerPage);
        } else {
            $resources = $this->resourceResolver->getResource(
                    $repository, 'findBy', array($criteria, $sorting, $this->config->getLimit())
            );
        }
        $routeParameters = array(
            '_format' => 'json',
            'level' => $level                        
        );
        $apiDataUrl = $this->generateUrl('pequiven_objetives_list_sig_evolution', $routeParameters);
        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('listEvolution.html'))
                ->setTemplateVar($this->config->getPluralResourceName())
        ;
        
        $view->getSerializationContext()->setGroups(array('id', 'api_list', 'valuesIndicator','managementSystems','api_details', 'sonata_api_read', 'formula'));
        if ($request->get('_format') == 'html') {
            
            $data = array(
                'apiDataUrl' => $apiDataUrl,
                $this->config->getPluralResourceName() => $resources,
                'level' => $level                                
            );
            $view->setData($data);

        } else {
            $formatData = $request->get('_formatData', 'default');

            $view->setData($resources->toArray('', array(), $formatData));
        }
        return $this->handleView($view);

    }

    /**
     * Lista de matriz
     *
     * @param Request $request
     * @return type
     */
    public function listAction(Request $request)
    {
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();
        
        $criteria = $request->get('filter',$this->config->getCriteria());
        $sorting = $request->get('sorting',$this->config->getSorting());
        
        //$repository = $this->getRepository();        
        $repository = $this->container->get('pequiven.repository.sig_management_system'); 
        
        if ($this->config->isPaginated()) {
            $resources = $this->resourceResolver->getResource(
                $repository,
                'createPaginatorManagementSystems',
                array($criteria, $sorting)
            );
            
            $maxPerPage = $this->config->getPaginationMaxPerPage();
            if(($limit = $request->query->get('limit')) && $limit > 0){
                if($limit > 100){
                    $limit = 100;
                }
                $maxPerPage = $limit;
            }
            $resources->setCurrentPage($request->get('page', 1), true, true);
            $resources->setMaxPerPage($maxPerPage);
        } else {
            $resources = $this->resourceResolver->getResource(
                $repository,
                'findBy',
                array($criteria, $sorting, $this->config->getLimit())
            );
        }

        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('Gerencia/list.html'))
            ->setTemplateVar($this->config->getPluralResourceName())
        ;
        $view->getSerializationContext()->setGroups(array('id','api_list','managementSystem'));
        if($request->get('_format') == 'html'){
            $view->setData($resources);
        }else{
            $formatData = $request->get('_formatData','default');

            $view->setData($resources->toArray('',array(),$formatData));
        }
        return $this->handleView($view);    	
    }

    /**
     * Exportar la matriz de objetivos (Marcados con el Sistema de la Calidad)
     * @param Request $request
     */
    public function exportAction(Request $request){        
        $this->getSecurityService()->checkSecurity(array('ROLE_SEIP_SIG_OBJECTIVE_EXPORT_MATRIZ'));
        
        $managementSystemId = $request->get('id');

        $managementSystem = null;
        if($managementSystemId !== null){
            $managementSystem = $this->get('pequiven.repository.sig_management_system')->find($managementSystemId);
        }

        //Objetivos Tácticos Marcados con el Sistema de la Calidad
        $objetivesTactics = $this->get('pequiven.repository.objetive')->getObjetivesManagementSystem($managementSystem);
        
        $resource = $this->findOr404($request);
        
        //Formato para todo el documento
        $styleArrayBordersContent = array(
          'borders' => array(
            'allborders' => array(
              'style' => \PHPExcel_Style_Border::BORDER_THIN
            )
          ),
          'font' => array(
          ),
          'alignment' => array(
              'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY,
              'vertical'   => \PHPExcel_Style_Alignment::VERTICAL_TOP,
              'wrap' => true
          )
        );
        
        //Formato en negrita
        $styleArray = array(
            'font' => array(
                'bold' => true
            )
        );
        
        $path = $this->get('kernel')->locateResource('@PequivenObjetiveBundle/Resources/skeleton/matriz_de_alineacion_sig.xls');
        $now = new \DateTime();
        $objPHPExcel = \PHPExcel_IOFactory::load($path);
        $objPHPExcel
                ->getProperties()
                ->setCreator("SEIP")
                ->setTitle('SEIP - Matriz de Alineación SIG')
                ->setCreated()
                ->setLastModifiedBy('SEIP')
                ->setModified()
                ;
        $objPHPExcel
                ->setActiveSheetIndex(0);
        $activeSheet = $objPHPExcel->getActiveSheet();
        $activeSheet->getDefaultRowDimension()->setRowHeight();
        
        //Sistema de la Calidad de la Matriz
        $activeSheet->setCellValue('A3', $managementSystem->getDescription());
        
        $row = $iniFile = 7;//Fila Inicial del skeleton
        $contResult = $contInd = 0;//Contador de resultados totales
        $contTac = 1;
        $rowHeight = 70;//Alto de la fila
        $countObjTac = count($objetivesTactics);                
        $rowIniTac = $row;//Fila Inicial del Objetivo Táctico
        $rowFinTac = $row;//Fila Final del Objetivo Táctico        
        $lastRowOpe = 7;        
        $idObjManagement = 0;
        foreach($objetivesTactics as $objetiveTactic){//Recorremos los objetivos tácticos            
            $indicatorsTactics = $objetiveTactic->getIndicators();
            $totalIndicatorTactics = count($indicatorsTactics);
            $objetivesOperatives = $objetiveTactic->getChildrens();
            $totalObjetiveOperatives = count($objetivesOperatives);            
            //sistema de la calidad de objetivo tactico
            foreach ($objetiveTactic->getManagementSystems() as $data) {
                if ($data->getId() == $managementSystemId) {
                    $idObjManagement = $data->getId();                    
                }
            }
            //var_dump($totalObjetiveOperatives." ot ". $objetiveTactic->getRef());//Cantidad de hijos por objetivos Tacticos            
            //$objetiveOperative = [];
            if($totalObjetiveOperatives > 0){//Si el objetivo táctico tiene objetivos operativos
                foreach($objetivesOperatives as $value){//Recorremos los Objetivos Operativos 
                    //sistema de la calidad de objetivo operativo
                    foreach ($value->getManagementSystems() as $data) {
                        if ($data->getId() == $managementSystemId) {
                            $idObjManagement = $data->getId();                            
                            $objetiveOperative = $value;                            
                    //var_dump("Ref object: ".$objetiveOperative->getRef() ."ManagementObjec: ".$idObjManagement." management set".$managementSystemId);
                    $cantOperative = count($objetiveOperative->getManagementSystems());  
                    if ($cantOperative !== 0 && $idObjManagement == $managementSystemId) {//Si el objetivo esta marcado con el sistema de la calidad                            
                        $contTotalObjOperatives = 0;                        
                        $rowIniOpe = $row;//Fila Inicial del Objetivo Operativo
                        $indicatorsOperatives = $objetiveOperative->getIndicators();//Indicadores de Obj Operativos
                        $totalIndicatorOperatives = count($indicatorsOperatives);//Cantidad de Indicadores                        
                        if($totalIndicatorOperatives > 0){//Si el objetivo operativo tiene indicadores operativos
                            foreach($indicatorsOperatives as $indicatorOperative){                                
                                if (count($indicatorOperative->getManagementSystems()) != 0) {
                                    foreach ($indicatorOperative->getManagementSystems() as $dataManagement) {
                                        if ($dataManagement->getId() == $managementSystemId) {
                                            $activeSheet->setCellValue('J'.$row, $indicatorOperative->getRef().' '.$indicatorOperative->getDescription());//Seteamos el Indicador Operativo
                                            $activeSheet->setCellValue('K'.$row, $indicatorOperative->getFormula()->getEquation());//Seteamos la Fórmula del Indicador Operativo
                                            $activeSheet->setCellValue('M'.$row, $indicatorOperative->getWeight());//Seteamos el Peso del Indicador Operativo
                                            $activeSheet->setCellValue('N'.$row, $indicatorOperative->getFrequencyNotificationIndicator());//Seteamos la frecuencia de medicion Operativo                                            
                                            $row++;                                
                                            $contResult++;                            
                                        }
                                    }
                                }elseif($totalIndicatorOperatives == 1){//En caso de que tenga solo un indicador operativo
                                    $activeSheet->setCellValue('J'.$row, $this->trans('miscellaneous.noCharged', array(), 'PequivenSEIPBundle'));//Seteamos el texto de que no hay cargado
                                    $activeSheet->setCellValue('K'.$row, $this->trans('miscellaneous.noCharged', array(), 'PequivenSEIPBundle'));//Seteamos el texto de que no hay cargado
                                    $activeSheet->setCellValue('M'.$row, $this->trans('miscellaneous.noCharged', array(), 'PequivenSEIPBundle'));//Seteamos el texto de que no hay cargado
                                    $activeSheet->setCellValue('N'.$row, $this->trans('miscellaneous.noCharged', array(), 'PequivenSEIPBundle'));//Seteamos el texto de que no hay cargado
                                    $row++;
                                    $contResult++;
                                }
                            }                            
                        } else{//En caso de que el objetivo operativo no tenga indicadores operativos
                            $activeSheet->setCellValue('J'.$row, $this->trans('miscellaneous.noCharged', array(), 'PequivenSEIPBundle'));//Seteamos el texto de que no hay cargado
                            $activeSheet->setCellValue('K'.$row, $this->trans('miscellaneous.noCharged', array(), 'PequivenSEIPBundle'));//Seteamos el texto de que no hay cargado
                            $activeSheet->setCellValue('M'.$row, $this->trans('miscellaneous.noCharged', array(), 'PequivenSEIPBundle'));//Seteamos el texto de que no hay cargado
                            $activeSheet->setCellValue('N'.$row, $this->trans('miscellaneous.noCharged', array(), 'PequivenSEIPBundle'));//Seteamos el texto de que no hay cargado                                
                            //$row++;
                            //$contResult++;
                        }                            
                        $rowFinOpe = $row;//$row - 1;//Fila Final del Objetivo Operativo
                        $rowFinTac = $row;//$row - 1;//Fila Final del Objetivo Táctico
                        //Sección Programas de Gestión Operativos
                        $arrangementProgramsOperatives = $objetiveOperative->getArrangementPrograms();
                        $totalArrangementProgramsOperatives = count($arrangementProgramsOperatives);
                        $textArrangementProgramsOperatives = '';
                        if($totalArrangementProgramsOperatives > 0){//Si el Objetivo Operativo tiene al menos un Programa de Gestión
                            foreach($arrangementProgramsOperatives as $arrangementProgram){
                                $textArrangementProgramsOperatives.= $arrangementProgram->getRef() . "\n";
                            }
                        } else{
                            $textArrangementProgramsOperatives = $this->trans('miscellaneous.noCharged', array(), 'PequivenSEIPBundle');
                        }
                        
                        $activeSheet->setCellValue('O'.$rowIniOpe, $textArrangementProgramsOperatives);//Seteamos los Programas de Gestión del Objetivo Operativo
                        
                        //Si el objetivo operativo tiene un proceso de sistema de gestion asociado
                        $processManagement = $objetiveOperative->getProcessManagementSystem();
                        $countProcessManagement =  count($processManagement);
                        $dataProcess = '';
                        if ($countProcessManagement >= 1) {                          
                            foreach ($processManagement as $process) {
                                foreach ($process->getManagementSystem() as $valueProcessManagement) {
                                    if ($valueProcessManagement->getId()) {
                                        if ($idObjManagement === $valueProcessManagement->getId()) {                                            
                                            $dataProcess.= $process->getDescription() . "\n";                                                               
                                        }
                                    }
                                }
                            }                          
                        }else{                                                    
                            $dataProcess = $this->trans('miscellaneous.noCharged', array(), 'PequivenSEIPBundle');//Seteamos el texto de que no hay cargado
                        }                            
                        
                        //var_dump('row:'.$rowIniOpe.' -tactic- '.$objetiveTactic->getRef()." -ope- ".$objetiveOperative->getRef());//con ref parents and childrens                            
                        $activeSheet->setCellValue('H'.$rowIniOpe, $dataProcess);//Seteamos el proceso
                        $activeSheet->setCellValue('I'.$rowIniOpe, $objetiveOperative->getRef().' '.$objetiveOperative->getDescription());//Seteamos el Objetivo Operativo
                        $activeSheet->setCellValue('L'.$rowIniOpe, $objetiveOperative->getGoal());//Seteamos el Peso del Objetivo Operativo
                        if (($rowFinOpe - $rowIniOpe) > 0) {
                            $activeSheet->mergeCells(sprintf('H%s:H%s',($rowIniOpe),($rowFinOpe)));
                            $activeSheet->mergeCells(sprintf('I%s:I%s',($rowIniOpe),($rowFinOpe)));
                            $activeSheet->mergeCells(sprintf('L%s:L%s',($rowIniOpe),($rowFinOpe)));
                            $activeSheet->mergeCells(sprintf('O%s:O%s',($rowIniOpe),($rowFinOpe)));
                        }
                        //$contTotalObjOperatives++;
                        /*if($totalObjetiveOperatives = $contTotalObjOperatives){
                            $lastRowOpe = $rowIniOpe;
                            $row--;                                             
                        }*/
                        $row++;             
                    }//if de managementsystems                                                        
                        }
                    }
                }
                
                $idManagementsIndicator = 0;
                $indicatorTacticsData = [];
                if($totalIndicatorTactics > 0){//Si el Objetivo Táctico tiene Indicadores Táctico 
                    foreach($indicatorsTactics as $indicatorTactic){
                        foreach ($indicatorTactic->getManagementSystems() as $dataManagement) {
                            if ($managementSystemId == $dataManagement->getId()) {                                
                                $idManagementsIndicator = $dataManagement->getId();                            
                                $indicatorTacticsData[] = $indicatorTactic;
                            }
                        }
                    }
                }

                if($totalIndicatorTactics > 0){//Si el Objetivo Táctico tiene Indicadores Táctico
                    $rowsSectionOperative = $row - $rowIniTac;
                    $rowIndTac = $rowIniTac;
                    $contIndTac = 0;                       
                    foreach($indicatorTacticsData as $indicatorTactic){                                                    
                        $activeSheet->setCellValue('D'.$rowIndTac, $indicatorTactic->getRef().' '.$indicatorTactic->getDescription());//Seteamos el Indicador Táctico
                        $activeSheet->setCellValue('E'.$rowIndTac, $indicatorTactic->getFormula()->getEquation());//Seteamos la Fórmula del Indicador Táctico
                        $activeSheet->setCellValue('F'.$rowIndTac, $indicatorTactic->getWeight());//Seteamos el Peso del Indicador Táctico $activeSheet->mergeCells(sprintf('J%s:K%s',($rowIndTac),($rowIndTac)));
                        $contIndTac++;
                        if($contIndTac == $totalIndicatorTactics && $rowIndTac <= $rowFinTac){
                            $activeSheet->mergeCells(sprintf('D%s:D%s',($rowIndTac),($rowFinTac)));
                            $activeSheet->mergeCells(sprintf('E%s:E%s',($rowIndTac),($rowFinTac)));
                            $activeSheet->mergeCells(sprintf('F%s:F%s',($rowIndTac),($rowFinTac)));
                        }
                        $rowIndTac++;                            
                    }                    
                    /*if($totalIndicatorTactics > $rowsSectionOperative and ($rowFinTac-$rowIniOpe)>0){
                            $activeSheet->mergeCells(sprintf('I%s:I%s',($rowIniOpe),($rowFinTac)));
                            $activeSheet->mergeCells(sprintf('J%s:J%s',($rowIniOpe),($rowFinTac)));
                            $activeSheet->mergeCells(sprintf('L%s:L%s',($rowIniOpe),($rowFinTac)));
                            $activeSheet->mergeCells(sprintf('R%s:R%s',($rowIniOpe),($rowFinTac)));
                            $activeSheet->mergeCells(sprintf('M%s:M%s',($rowIniOpe),($rowFinTac)));
                            $activeSheet->mergeCells(sprintf('O%s:O%s',($rowIniOpe),($rowFinTac)));
                    }*/
                } else{//En caso de que el Objetivo Táctico no tenga Indicadores Tácticos
                    $activeSheet->setCellValue('D'.$rowIniTac, $this->trans('miscellaneous.noCharged', array(), 'PequivenSEIPBundle'));//Seteamos el texto de que no hay cargado
                    $activeSheet->setCellValue('E'.$rowIniTac, $this->trans('miscellaneous.noCharged', array(), 'PequivenSEIPBundle'));//Seteamos el texto de que no hay cargado
                    $activeSheet->setCellValue('F'.$rowIniTac, $this->trans('miscellaneous.noCharged', array(), 'PequivenSEIPBundle'));//Seteamos el texto de que no hay cargado                    $activeSheet->mergeCells(sprintf('E%s:E%s',($rowIniTac),($rowIniTac)));
                    if (($rowFinTac - $rowIniTac) > 0) {
                        $activeSheet->mergeCells(sprintf('D%s:D%s',($rowIniTac),($rowFinTac)));
                        $activeSheet->mergeCells(sprintf('E%s:E%s',($rowIniTac),($rowFinTac)));
                        $activeSheet->mergeCells(sprintf('F%s:F%s',($rowIniTac),($rowFinTac)));                        
                    }
                }

            } else{//En caso de que el objetivo táctico no tenga objetivos operativos
                $activeSheet->setCellValue('H'.$rowIniTac, $this->trans('miscellaneous.noCharged', array(), 'PequivenSEIPBundle'));//Seteamos el texto de que no hay cargado
                $activeSheet->setCellValue('I'.$rowIniTac, $this->trans('miscellaneous.noCharged', array(), 'PequivenSEIPBundle'));//Seteamos el texto de que no hay cargado
                $activeSheet->setCellValue('J'.$rowIniTac, $this->trans('miscellaneous.noCharged', array(), 'PequivenSEIPBundle'));//Seteamos el texto de que no hay cargado                
                $activeSheet->setCellValue('L'.$rowIniTac, $this->trans('miscellaneous.noCharged', array(), 'PequivenSEIPBundle'));//Seteamos el texto de que no hay cargado
                $activeSheet->setCellValue('R'.$rowIniTac, $this->trans('miscellaneous.noCharged', array(), 'PequivenSEIPBundle'));//Seteamos el texto de que no hay cargado
                $activeSheet->setCellValue('M'.$rowIniTac, $this->trans('miscellaneous.noCharged', array(), 'PequivenSEIPBundle'));//Seteamos el texto de que no hay cargado
                $activeSheet->setCellValue('O'.$rowIniTac, $this->trans('miscellaneous.noCharged', array(), 'PequivenSEIPBundle'));//Seteamos el texto de que no hay cargado                
                $activeSheet->mergeCells(sprintf('M%s:T%s',($rowIniTac),($rowIniTac)));
                
                if($totalIndicatorTactics > 0){//Si el Objetivo Táctico tiene Indicadores Táctico
                    $rowIndTac = $rowIniTac;
                    $rowFinTac = $rowIniTac + $totalIndicatorTactics - 1;
                    $contIndTac = 0;
                    foreach($indicatorTacticsData as $indicatorTactic){                                                
                        $activeSheet->setCellValue('D'.$rowIndTac, $indicatorTactic->getRef().' '.$indicatorTactic->getDescription());//Seteamos el Indicador Táctico
                        $activeSheet->setCellValue('E'.$rowIndTac, $indicatorTactic->getFormula()->getEquation());//Seteamos la Fórmula del Indicador Táctico
                        $activeSheet->setCellValue('F'.$rowIndTac, $indicatorTactic->getWeight());//Seteamos el Peso del Indicador Táctico
                        $activeSheet->mergeCells(sprintf('I%s:J%s',($rowIndTac),($rowIndTac)));                        
                        $contIndTac++;
                        $rowIndTac++;
                        $row++;
                        $contResult++;                         
                    }
                } else{//En caso de que el Objetivo Táctico no tenga Indicadores Tácticos
                    $activeSheet->setCellValue('D'.$rowIniTac, $this->trans('miscellaneous.noCharged', array(), 'PequivenSEIPBundle'));//Seteamos el texto de que no hay cargado
                    $activeSheet->setCellValue('E'.$rowIniTac, $this->trans('miscellaneous.noCharged', array(), 'PequivenSEIPBundle'));//Seteamos el texto de que no hay cargado
                    $activeSheet->setCellValue('F'.$rowIniTac, $this->trans('miscellaneous.noCharged', array(), 'PequivenSEIPBundle'));//Seteamos el texto de que no hay cargado
                    $activeSheet->mergeCells(sprintf('J%s:K%s',($rowIniTac),($rowIniTac)));                    
                    $row++;
                    $contResult++;
                }
            }
            
            $activeSheet->setCellValue('B'.$rowIniTac, $objetiveTactic->getRef().' '.$objetiveTactic->getDescription());//Seteamos el Objetivo Táctico
            $activeSheet->setCellValue('C'.$rowIniTac, $objetiveTactic->getGoal());//Seteamos la Meta del Objetivo Táctico
            //Sección Programas de Gestión Tácticos
            $arrangementProgramsTactics = $objetiveTactic->getArrangementPrograms();
            $totalArrangementProgramsTactic = count($arrangementProgramsTactics);
            $textArrangementProgramsTactic = '';
            if($totalArrangementProgramsTactic > 0){//Si el Objetivo Táctico tiene al menos un Programa de Gestión
                foreach($arrangementProgramsTactics as $arrangementProgram){
                    $textArrangementProgramsTactic.= $arrangementProgram->getRef() . "\n";
                }
            } else {
                $textArrangementProgramsTactic = $this->trans('miscellaneous.noCharged', array(), 'PequivenSEIPBundle');
            }
            $activeSheet->setCellValue('G'.$rowIniTac, $textArrangementProgramsTactic);//Seteamos los Programas de Gestión del Objetivo Táctico
            
            if($rowFinTac < $rowIniTac){
                $rowFinTac = $row - 1;
            }
            
            if (($rowFinTac - $rowIniTac) > 0) {
                $activeSheet->mergeCells(sprintf('B%s:B%s',($rowIniTac),($rowFinTac)));                
                $activeSheet->mergeCells(sprintf('C%s:C%s',($rowIniTac),($rowFinTac)));
                $activeSheet->mergeCells(sprintf('G%s:G%s',($rowIniTac),($rowFinTac)));
            }
            
            //Pasando la politica del Sistema de la Calidad
            if ($contTac == 1) {
                //Politica del Sistema de la Calidad Consultado
                $textPoliticManagementSystem = $managementSystem->getPoliticManagementSystem()->getDescriptionBody();
                $activeSheet->setCellValue('A'.$rowIniTac, $textPoliticManagementSystem);//Seteamos la Politica del Sistema de la Calidad consultado
            }elseif ($contTac == $countObjTac) {
                $rowInit = 7;
                $activeSheet->mergeCells(sprintf('A%s:A%s',($rowInit),($rowFinTac)));                
            }
            
           // $activeSheet->mergeCells(sprintf('B%s:B%s',($rowIniTac),($rowFinTac)));            
            $rowIniTac = $row;//Actualizamos la fila inicial del nivel Táctico
            $contTac++;
        }
        $row = 7;//Fila Inicial del skeleton
        for($i=$row;$i<=$rowFinTac;$i++){//Recorremos toda la matriz para setear el alto y los bordes en cada celda
            $activeSheet->getRowDimension($i)->setRowHeight($rowHeight);
            $activeSheet->getStyle(sprintf('A%s:O%s',$i,$i))->applyFromArray($styleArrayBordersContent);
        }
        $row = $rowFinTac + 1;
        $activeSheet->setCellValue(sprintf('A%s',$row),'Nota: Responsable por los Objetivos Tácticos(Generales) es la Alta Dirección de cada Sistema de Gestión(1era Linea)');
        $activeSheet->setCellValue(sprintf('A%s',$row + 1),'       Responsable por los Objetivos Operativos son los Representantes de la Alta Dirección de cada Sistema de Gestión(2da Linea)');
        $activeSheet->setCellValue(sprintf('A%s',$row + 2),'NIVEL DE REVISION: 1');
        $activeSheet->setCellValue(sprintf('O%s',$row + 2),'C-SI-GI-PG-R-005');
        $activeSheet->getStyle(sprintf('A%s:O%s',$row,$row))->getFont()->setSize(8);
        $fileName = sprintf('SEIP-Matriz de Objetivos-%s-%s.xls',$managementSystem->getDescription(),$now->format('Ymd-His'));

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$fileName.'"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
        
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
     * @return \Pequiven\SIGBundle\Service\EvolutionService
     */
    protected function getEvolutionService() {
        return $this->container->get('seip.service.evolution');
    } 

    /**
     * 
     * @return \Pequiven\SEIPBundle\Service\SecurityService
     */
    protected function getSecurityService() {

        return $this->container->get('seip.service.security');
    } 
    /**
     *  Period
     *
     */
    protected function getPeriodService() {
        return $this->container->get('pequiven_seip.service.period');
    }
   
}