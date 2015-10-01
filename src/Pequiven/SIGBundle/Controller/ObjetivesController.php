<?php

namespace Pequiven\SIGBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Pequiven\ObjetiveBundle\Entity\Objetive;
use Pequiven\ObjetiveBundle\Entity\ObjetiveLevel;

/**
 * Controlador ObjetivosSIG
 *
 * @author Maximo Sojo <maxsojo13@gmail.com>
 */
class ObjetivesController extends ResourceController
{
    public function strategicAction()
    {
        return $this->render('PequivenSIGBundle:Objetives:list.html.twig');
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
            ObjetiveLevel::LEVEL_ESTRATEGICO => array('ROLE_SEIP_INDICATOR_VIEW_STRATEGIC', 'ROLE_SEIP_PLANNING_LIST_INDICATOR_STRATEGIC'),
            ObjetiveLevel::LEVEL_TACTICO => array('ROLE_SEIP_INDICATOR_VIEW_TACTIC', 'ROLE_SEIP_PLANNING_LIST_INDICATOR_TACTIC'),
            ObjetiveLevel::LEVEL_OPERATIVO => array('ROLE_SEIP_INDICATOR_VIEW_OPERATIVE', 'ROLE_SEIP_PLANNING_LIST_INDICATOR_OPERATIVE')
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
        $repository = $this->container->get('pequiven.repository.gerenciafirst');

        if ($this->config->isPaginated()) {
            $resources = $this->resourceResolver->getResource(
                $repository,
                'createPaginatorGerenciaFirst',
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
        $view->getSerializationContext()->setGroups(array('id','api_list','complejo'));
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
    public function exportAction(Request $request)
    {
        $this->getSecurityService()->checkSecurity(array('ROLE_SEIP_OBJECTIVE_LIST_MATRIX_OBJECTIVES','ROLE_SEIP_PLANNING_LIST_OBJECTIVE_MATRIX_OBJECTIVES'));
        
        $managementSystemId = $request->get('managementSystem');

        $managementSystem = null;
        if($managementSystemId !== null){
            $managementSystem = $this->get('pequiven.repository.sig_management_system')->find($managementSystemId);
        }
        $managementSystemAll = $this->get('pequiven.repository.sig_management_system')->findAll();

        $idGerencia = $request->get('id');
        $gerencia = $this->get('pequiven.repository.gerenciafirst')->find($idGerencia);//Obtenemos la gerencia
        
        	
        /*foreach ($managementSystemAll as $value) {
        	$managementSystem = $value->getId();*/
        	//$objetivesTactics = $this->get('pequiven.repository.objetive')->findBy(array('gerencia' => $gerencia->getId(),'objetiveLevel' => \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_TACTICO,'period' => $this->getPeriodService()->getPeriodActive()));
        	
        //Objetivos Tácticos de la Gerencia
        $objetivesTactics = $this->get('pequiven.repository.objetive')->getObjetivesManagementSystem($gerencia);

        //}
        
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
        
        $path = $this->get('kernel')->locateResource('@PequivenObjetiveBundle/Resources/skeleton/matriz_de_objetivos.xls');
        $now = new \DateTime();
        $objPHPExcel = \PHPExcel_IOFactory::load($path);
        $objPHPExcel
                ->getProperties()
                ->setCreator("SEIP")
                ->setTitle('SEIP - Matriz de Objetivos')
                ->setCreated()
                ->setLastModifiedBy('SEIP')
                ->setModified()
                ;
        $objPHPExcel
                ->setActiveSheetIndex(0);
        $activeSheet = $objPHPExcel->getActiveSheet();
        $activeSheet->getDefaultRowDimension()->setRowHeight();
        
//        $activeSheet->setTitle($gerencia->getDescription());
        //Gerencia de la matriz de objetivos e indicadores
        $activeSheet->setCellValue('A3', $gerencia->getDescription());
        
        $row = 8;//Fila Inicial del skeleton
        $contResult = 0;//Contador de resultados totales
        $rowHeight = 70;//Alto de la fila
        
        $rowIniTac = $row;//Fila Inicial del Objetivo Táctico
        $rowFinTac = $row;//Fila Final del Objetivo Táctico
        
        $lastRowOpe = 8;
        foreach($objetivesTactics as $objetiveTactic){//Recorremos los objetivos tácticos de la Gerencia
//            if($managementSystem !== null && $managementSystem !== $objetiveTactic->getManagementSystem()){
//                continue;
//            }
            $indicatorsTactics = $objetiveTactic->getIndicators();
            $totalIndicatorTactics = count($indicatorsTactics);
            $objetivesOperatives = $objetiveTactic->getChildrens();
            $totalObjetiveOperatives = count($objetivesOperatives);
            if($totalObjetiveOperatives > 0){//Si el objetivo táctico tiene objetivos operativos
                foreach($objetivesOperatives as $objetiveOperative){//Recorremos los Objetivos Operativos
//                    if($managementSystem !== null && $managementSystem !== $objetiveOperative->getManagementSystem()){
//                        continue;
//                    }
                    $contTotalObjOperatives = 0;
                    $rowIniOpe = $row;//Fila Inicial del Objetivo Operativo
                    $indicatorsOperatives = $objetiveOperative->getIndicators();
                    $totalIndicatorOperatives = count($indicatorsOperatives);
                    if($totalIndicatorOperatives > 0){//Si el objetivo operativo tiene indicadores operativos
                        foreach($indicatorsOperatives as $indicatorOperative){
                            $activeSheet->setCellValue('R'.$row, $indicatorOperative->getRef().' '.$indicatorOperative->getDescription());//Seteamos el Indicador Operativo
                            $activeSheet->setCellValue('S'.$row, $indicatorOperative->getFormula()->getEquation());//Seteamos la Fórmula del Indicador Operativo
                            $activeSheet->setCellValue('U'.$row, $indicatorOperative->getWeight());//Seteamos el Peso del Indicador Operativo
                            
                            $activeSheet->mergeCells(sprintf('S%s:T%s',($row),($row)));
                            $row++;
                            $contResult++;
                        }
                    } else{//En caso de que el objetivo operativo no tenga indicadores operativos
                        $activeSheet->setCellValue('R'.$row, $this->trans('miscellaneous.noCharged', array(), 'PequivenSEIPBundle'));//Seteamos el texto de que no hay cargado
                        $activeSheet->setCellValue('S'.$row, $this->trans('miscellaneous.noCharged', array(), 'PequivenSEIPBundle'));//Seteamos el texto de que no hay cargado
                        $activeSheet->setCellValue('U'.$row, $this->trans('miscellaneous.noCharged', array(), 'PequivenSEIPBundle'));//Seteamos el texto de que no hay cargado
                        
                        $activeSheet->mergeCells(sprintf('S%s:T%s',($row),($row)));
                        
                        $row++;
                        $contResult++;
                    }
                    $rowFinOpe = $row - 1;//Fila Final del Objetivo Operativo
                    $rowFinTac = $row - 1;//Fila Final del Objetivo Táctico
                    
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
                    
                    $activeSheet->setCellValue('V'.$rowIniOpe, $textArrangementProgramsOperatives);//Seteamos los Programas de Gestión del Objetivo Operativo

                    $activeSheet->setCellValue('N'.$rowIniOpe, $objetiveOperative->getRef().' '.$objetiveOperative->getDescription());//Seteamos el Objetivo Operativo
                    $activeSheet->setCellValue('O'.$rowIniOpe, $objetiveOperative->getGerenciaSecond()->getDescription());//Seteamos la Gerencia de 2da Línea del Objetivo Operativo
                    $activeSheet->getStyle('O'.$rowIniOpe)->applyFromArray($styleArray);//Aplicamos formato a la celda de la Gerencia de 2da Línea del Objetivo Operativo
                    $activeSheet->setCellValue('P'.$rowIniOpe, $objetiveOperative->getGoal());//Seteamos la Meta del Objetivo Operativo
                    $activeSheet->setCellValue('Q'.$rowIniOpe, $objetiveOperative->getWeight());//Seteamos el Peso del Objetivo Operativo
                    
                    $activeSheet->mergeCells(sprintf('N%s:N%s',($rowIniOpe),($rowFinOpe)));
                    $activeSheet->mergeCells(sprintf('O%s:O%s',($rowIniOpe),($rowFinOpe)));
                    $activeSheet->mergeCells(sprintf('P%s:P%s',($rowIniOpe),($rowFinOpe)));
                    $activeSheet->mergeCells(sprintf('Q%s:Q%s',($rowIniOpe),($rowFinOpe)));
                    $activeSheet->mergeCells(sprintf('V%s:V%s',($rowIniOpe),($rowFinOpe)));
                    $contTotalObjOperatives++;
                    if($totalObjetiveOperatives = $contTotalObjOperatives){
                        $lastRowOpe = $rowIniOpe;
                    }
                }
                
                if($totalIndicatorTactics > 0){//Si el Objetivo Táctico tiene Indicadores Táctico
                    $rowsSectionOperative = $row - $rowIniTac;
                    $rowIndTac = $rowIniTac;
                    $contIndTac = 0;

                    foreach($indicatorsTactics as $indicatorTactic){
                        $activeSheet->setCellValue('I'.$rowIndTac, $indicatorTactic->getRef().' '.$indicatorTactic->getDescription());//Seteamos el Indicador Táctico
                        $activeSheet->setCellValue('J'.$rowIndTac, $indicatorTactic->getFormula()->getEquation());//Seteamos la Fórmula del Indicador Táctico
                        $activeSheet->setCellValue('L'.$rowIndTac, $indicatorTactic->getWeight());//Seteamos el Peso del Indicador Táctico
                        $activeSheet->mergeCells(sprintf('J%s:K%s',($rowIndTac),($rowIndTac)));
                        $contIndTac++;
                        if($contIndTac == $totalIndicatorTactics && $rowIndTac <= $rowFinTac){
                            $activeSheet->mergeCells(sprintf('I%s:I%s',($rowIndTac),($rowFinTac)));
                            $activeSheet->mergeCells(sprintf('J%s:K%s',($rowIndTac),($rowFinTac)));
                            $activeSheet->mergeCells(sprintf('L%s:L%s',($rowIndTac),($rowFinTac)));
                        }
                        $rowIndTac++;
                    }
                    
                    if($totalIndicatorTactics > $rowsSectionOperative){
                        $rowFinTac = $rowIndTac - 1;
                        $activeSheet->mergeCells(sprintf('N%s:N%s',($rowIniOpe),($rowFinTac)));
                        $activeSheet->mergeCells(sprintf('O%s:O%s',($rowIniOpe),($rowFinTac)));
                        $activeSheet->mergeCells(sprintf('P%s:P%s',($rowIniOpe),($rowFinTac)));
                        $activeSheet->mergeCells(sprintf('Q%s:Q%s',($rowIniOpe),($rowFinTac)));
                        $activeSheet->mergeCells(sprintf('R%s:R%s',($rowIniOpe),($rowFinTac)));
                        $activeSheet->mergeCells(sprintf('S%s:T%s',($rowIniOpe),($rowFinTac)));
                        $activeSheet->mergeCells(sprintf('U%s:U%s',($rowIniOpe),($rowFinTac)));
                        $activeSheet->mergeCells(sprintf('V%s:V%s',($rowIniOpe),($rowFinTac)));
                    }
                    
                } else{//En caso de que el Objetivo Táctico no tenga Indicadores Tácticos
                    $activeSheet->setCellValue('I'.$rowIniTac, $this->trans('miscellaneous.noCharged', array(), 'PequivenSEIPBundle'));//Seteamos el texto de que no hay cargado
                    $activeSheet->setCellValue('J'.$rowIniTac, $this->trans('miscellaneous.noCharged', array(), 'PequivenSEIPBundle'));//Seteamos el texto de que no hay cargado
                    $activeSheet->setCellValue('L'.$rowIniTac, $this->trans('miscellaneous.noCharged', array(), 'PequivenSEIPBundle'));//Seteamos el texto de que no hay cargado
                    $activeSheet->mergeCells(sprintf('J%s:K%s',($rowIniTac),($rowIniTac)));
                    
                    $activeSheet->mergeCells(sprintf('I%s:I%s',($rowIniTac),($rowFinTac)));
                    $activeSheet->mergeCells(sprintf('J%s:K%s',($rowIniTac),($rowFinTac)));
                    $activeSheet->mergeCells(sprintf('L%s:L%s',($rowIniTac),($rowFinTac)));
                }
            } else{//En caso de que el objetivo táctico no tenga objetivos operativos
                $activeSheet->setCellValue('N'.$rowIniTac, $this->trans('miscellaneous.noCharged', array(), 'PequivenSEIPBundle'));//Seteamos el texto de que no hay cargado
                $activeSheet->setCellValue('O'.$rowIniTac, $this->trans('miscellaneous.noCharged', array(), 'PequivenSEIPBundle'));//Seteamos el texto de que no hay cargado
                $activeSheet->setCellValue('P'.$rowIniTac, $this->trans('miscellaneous.noCharged', array(), 'PequivenSEIPBundle'));//Seteamos el texto de que no hay cargado
                $activeSheet->setCellValue('Q'.$rowIniTac, $this->trans('miscellaneous.noCharged', array(), 'PequivenSEIPBundle'));//Seteamos el texto de que no hay cargado
                $activeSheet->setCellValue('R'.$rowIniTac, $this->trans('miscellaneous.noCharged', array(), 'PequivenSEIPBundle'));//Seteamos el texto de que no hay cargado
                $activeSheet->setCellValue('S'.$rowIniTac, $this->trans('miscellaneous.noCharged', array(), 'PequivenSEIPBundle'));//Seteamos el texto de que no hay cargado
                $activeSheet->setCellValue('U'.$rowIniTac, $this->trans('miscellaneous.noCharged', array(), 'PequivenSEIPBundle'));//Seteamos el texto de que no hay cargado
                $activeSheet->setCellValue('V'.$rowIniTac, $this->trans('miscellaneous.noCharged', array(), 'PequivenSEIPBundle'));//Seteamos el texto de que no hay cargado
                
                $activeSheet->mergeCells(sprintf('S%s:T%s',($rowIniTac),($rowIniTac)));
                
                if($totalIndicatorTactics > 0){//Si el Objetivo Táctico tiene Indicadores Táctico
                    $rowIndTac = $rowIniTac;
                    $rowFinTac = $rowIniTac + $totalIndicatorTactics - 1;
                    $contIndTac = 0;
                    foreach($indicatorsTactics as $indicatorTactic){
                        $activeSheet->setCellValue('I'.$rowIndTac, $indicatorTactic->getRef().' '.$indicatorTactic->getDescription());//Seteamos el Indicador Táctico
                        $activeSheet->setCellValue('J'.$rowIndTac, $indicatorTactic->getFormula()->getEquation());//Seteamos la Fórmula del Indicador Táctico
                        $activeSheet->setCellValue('L'.$rowIndTac, $indicatorTactic->getWeight());//Seteamos el Peso del Indicador Táctico
                        $activeSheet->mergeCells(sprintf('J%s:K%s',($rowIndTac),($rowIndTac)));
                        
                        $contIndTac++;

                        $rowIndTac++;
                        $row++;
                        $contResult++;
                    }
                } else{//En caso de que el Objetivo Táctico no tenga Indicadores Tácticos
                    $activeSheet->setCellValue('I'.$rowIniTac, $this->trans('miscellaneous.noCharged', array(), 'PequivenSEIPBundle'));//Seteamos el texto de que no hay cargado
                    $activeSheet->setCellValue('J'.$rowIniTac, $this->trans('miscellaneous.noCharged', array(), 'PequivenSEIPBundle'));//Seteamos el texto de que no hay cargado
                    $activeSheet->setCellValue('L'.$rowIniTac, $this->trans('miscellaneous.noCharged', array(), 'PequivenSEIPBundle'));//Seteamos el texto de que no hay cargado
                    $activeSheet->mergeCells(sprintf('J%s:K%s',($rowIniTac),($rowIniTac)));
                    
                    $row++;
                    $contResult++;
                }
            }
            
            $activeSheet->setCellValue('G'.$rowIniTac, $objetiveTactic->getRef().' '.$objetiveTactic->getDescription());//Seteamos el Objetivo Táctico
            $activeSheet->setCellValue('H'.$rowIniTac, $objetiveTactic->getGoal());//Seteamos la Meta del Objetivo Táctico
            
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
            $activeSheet->setCellValue('M'.$rowIniTac, $textArrangementProgramsTactic);//Seteamos los Programas de Gestión del Objetivo Táctico
            
            if($rowFinTac < $rowIniTac){
                $rowFinTac = $row - 1;
            }
            $activeSheet->mergeCells(sprintf('G%s:G%s',($rowIniTac),($rowFinTac)));
            $activeSheet->mergeCells(sprintf('H%s:H%s',($rowIniTac),($rowFinTac)));
            $activeSheet->mergeCells(sprintf('M%s:M%s',($rowIniTac),($rowFinTac)));
            
            //Sección Línea Estratégica y Objetivos Estratégicos
            $objetivesStrategics = $objetiveTactic->getParents();
            $totalObjetivesStrategics = count($objetivesStrategics);
            $contObjStra = 1;
            $textObjStra = '';
            $textLineStrategic = '';
            
            foreach($objetivesStrategics as $objetiveStrategic){
                if($totalObjetivesStrategics > 1){
                    $textObjStra.= $objetiveStrategic->getRef().' '.$objetiveStrategic->getDescription()."\n";
                    if($contObjStra == 1){
                        $lineStrategics = $objetiveStrategic->getLineStrategics();
                        foreach($lineStrategics as $lineStrategic){
                            $textLineStrategic.= $lineStrategic->getRef().' '.$lineStrategic->getDescription()."\n";
                        }
                    } else{
                        if($beforeLineStraRef === $objetiveStrategic->getRef()){
                        } else{
                            $lineStrategics = $objetiveStrategic->getLineStrategics();
                            foreach($lineStrategics as $lineStrategic){
                                $textLineStrategic.= $lineStrategic->getRef().' '.$lineStrategic->getDescription()."\n";
                            }
                        }
                        $beforeLineStraRef = $objetiveStrategic->getLineStrategics()->getRef();
                    }
                } else{
                    $lineStrategics = $objetiveStrategic->getLineStrategics();
                    foreach($lineStrategics as $lineStrategic){
                        $textLineStrategic.= $lineStrategic->getRef().' '.$lineStrategic->getDescription();
                    }
                    $textObjStra.= $objetiveStrategic->getRef().' '.$objetiveStrategic->getDescription();
                }
            }
            
            $activeSheet->setCellValue('A'.$rowIniTac, $textLineStrategic);//Seteamos la Línea Estratégica
            $activeSheet->setCellValue('B'.$rowIniTac, $textObjStra);//Seteamos el Objetivo Estratégico
            
            $activeSheet->mergeCells(sprintf('A%s:A%s',($rowIniTac),($rowFinTac)));
            $activeSheet->mergeCells(sprintf('B%s:B%s',($rowIniTac),($rowFinTac)));
            
            $rowIniTac = $row;//Actualizamos la fila inicial del nivel Táctico
        }

        $row = 8;//Fila Inicial del skeleton
        for($i=$row;$i<=$rowFinTac;$i++){//Recorremos toda la matriz para setear el alto y los bordes en cada celda
            $activeSheet->getRowDimension($i)->setRowHeight($rowHeight);
            $activeSheet->getStyle(sprintf('A%s:V%s',$i,$i))->applyFromArray($styleArrayBordersContent);
        }
        $row = $rowFinTac + 1;
        $activeSheet->setCellValue(sprintf('A%s',$row),'NIVEL DE REVISION: 1');
        $activeSheet->setCellValue(sprintf('V%s',$row),'C-CP-DM-OI-R-001');
        $activeSheet->getStyle(sprintf('A%s:V%s',$row,$row))->getFont()->setSize(8);
        
        $fileName = sprintf('SEIP-Matriz de Objetivos-%s-%s.xls',$gerencia->getDescription(),$now->format('Ymd-His'));
        
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