<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Pequiven\SEIPBundle\Controller\Planning;

use Symfony\Component\HttpFoundation\Request;
use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Pequiven\SEIPBundle\Model\PDF\SeipPdf;
use Pequiven\MasterBundle\Entity\Rol;

/**
 * Controlador para mostrar los resultados
 *
 * @author matias
 */
class ResultController extends ResourceController 
{    
    /**
     * Función que devuelve el paginador con las gerencias de 2da Línea
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function listResultAction(Request $request)
    {
        $securityService = $this->getSecurityService();
        $securityService->checkSecurity(array('ROLE_SEIP_RESULT_LIST_BY_MANAGEMENT','ROLE_SEIP_PLANNING_LIST_RESULT_ALL'));
        
        $em = $this->getDoctrine();
        
        $criteria = $request->get('filter',$this->config->getCriteria());
        $sorting = $request->get('sorting',$this->config->getSorting());
        $repository = $em->getRepository('PequivenMasterBundle:GerenciaSecond');
        
        if(!$securityService->isGranted('ROLE_SEIP_PLANNING_LIST_RESULT_ALL')){
            $user = $this->getUser();
            $rol = $user->getLevelRealByGroup();
            if($rol == Rol::ROLE_MANAGER_SECOND){
                $criteria['gerenciaSecondId'] = $user->getGerenciaSecond();
            }elseif ($rol == Rol::ROLE_MANAGER_FIRST) {
                $criteria['gerenciaFirstId'] = $user->getGerencia();
            }elseif ($rol == Rol::ROLE_GENERAL_COMPLEJO || $rol == Rol::ROLE_DIRECTIVE) {
                $criteria['complejoId'] = $user->getComplejo();
            }
        }
        if ($this->config->isPaginated()) {
            $resources = $this->resourceResolver->getResource(
                $repository,
                'createPaginatorGerenciaSecond',
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
            ->setTemplate($this->config->getTemplate('list.html'))
            ->setTemplateVar($this->config->getPluralResourceName())
        ;
        $view->getSerializationContext()->setGroups(array('id','api_list','complejo','gerencia'));
        if($request->get('_format') == 'html'){
            $view->setData($resources);
        }else{
            $formatData = $request->get('_formatData','default');

            $view->setData($resources->toArray('',array(),$formatData));
        }
        return $this->handleView($view);
    }
    
    /**
     * Función que renderiza el Monitor de Objetivos Operativos
     * 
     * @Template("PequivenSEIPBundle:Planning:Result/Operative/showMonitor.html.twig")
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return type
     */
    public function showMonitorAction(Request $request)
    {
        $categories = array();
        $linkToExportResult = '';
        $resultIndicator = $resultArrangementProgram = $resultObjetives = array();
        $showResultObjetives = false;
        $level = $request->get('level');
        
        $rol = null;
        $rolByLevel = array(
            \Pequiven\SEIPBundle\Model\Common\CommonObject::LEVEL_GERENCIA => array('ROLE_SEIP_RESULT_VIEW_TACTIC','ROLE_SEIP_PLANNING_VIEW_RESULT_TACTIC'),
            \Pequiven\SEIPBundle\Model\Common\CommonObject::LEVEL_GERENCIA_SECOND => array('ROLE_SEIP_RESULT_VIEW_OPERATIVE','ROLE_SEIP_PLANNING_VIEW_RESULT_OPERATIVE')
        );
        if(isset($rolByLevel[$level])){
            $rol = $rolByLevel[$level];
        }
        $securityService = $this->getSecurityService();
        $securityService->checkSecurity($rol);
        
        $em = $this->getDoctrine();
        $id = $request->get('id');
        
        $tree = $objetives = array();
        $caption = '';
        if($level == \Pequiven\SEIPBundle\Model\Common\CommonObject::LEVEL_GERENCIA){
            $linkToExportResult = $this->generateUrl('pequiven_seip_result_export', array('level' => \Pequiven\SEIPBundle\Model\Common\CommonObject::LEVEL_GERENCIA,'id' => $id));
            $urlExportFromChart = $this->generateUrl('pequiven_seip_result_export_from_chart',array('level' => \Pequiven\SEIPBundle\Model\Common\CommonObject::LEVEL_GERENCIA,'id' => $id));
            $showResultObjetives = true;
            $caption = $this->trans('result.captionObjetiveTactical',array(),'PequivenSEIPBundle');
            
            $gerencia = $this->get('pequiven.repository.gerenciafirst')->findWithObjetives($id);
            if($gerencia){
                $objetives = $gerencia->getTacticalObjectives();
                foreach ($objetives as $objetive) {
                    foreach ($objetive->getParents() as $parent) {
                        if(!isset($tree[(string)$parent])){
                            $tree[(string)$parent] = array(
                                'parent' => $parent,
                                'child' => array(),
                            );
                        }
                        $tree[(string)$parent]['child'][(string)$objetive] = $objetive;
                    }
                }
            }
            $entity = $gerencia;
        }elseif($level == \Pequiven\SEIPBundle\Model\Common\CommonObject::LEVEL_GERENCIA_SECOND){
            $linkToExportResult = $this->generateUrl('pequiven_seip_result_export', array('level' => \Pequiven\SEIPBundle\Model\Common\CommonObject::LEVEL_GERENCIA_SECOND,'id' => $id));
            $urlExportFromChart = $this->generateUrl('pequiven_seip_result_export_from_chart',array('level' => \Pequiven\SEIPBundle\Model\Common\CommonObject::LEVEL_GERENCIA_SECOND,'id' => $id));
            $caption = $this->trans('result.captionObjetiveOperative',array(),'PequivenSEIPBundle');
            
            $gerenciaSecond = $em->getRepository('PequivenMasterBundle:GerenciaSecond')->findWithObjetives($id);
            $objetives = $gerenciaSecond->getOperationalObjectives();
            foreach ($objetives as $objetive) {
                foreach ($objetive->getParents() as $parent) {
                    if($parent->getGerencia()->getId() === $gerenciaSecond->getGerencia()->getId()){
                        if(!isset($tree[(string)$parent])){
                            $tree[(string)$parent] = array(
                                'parent' => $parent,
                                'child' => array(),
                            );
                        }
                        $tree[(string)$parent]['child'][(string)$objetive] = $objetive;
                    }
                }
            }
            $entity = $gerenciaSecond;
        }
        
        if(!$securityService->isGranted($rol[1])){
            $securityService->checkSecurity($rol[0],$entity);
        }
        $subCaption = $this->trans('result.subCaptionObjetiveOperative',array(),'PequivenSEIPBundle');
        $data = array(
            'dataSource' => array(
                'chart' => array(
                    'caption' => $caption,
                    'subCaption' => $subCaption,
                ),
                'categories' => array(
                    'category' => array(),
                ),
                'dataset' => array(),
            ),
        );
        //Configuramos el alto del gráfico
        $totalObjects = count($objetives);
        $heightChart = ($totalObjects * 30) + 150;
        
        //Data del gráfico
        foreach($objetives as $objetive){
            $viewObjetiveInChart = true;
            
            if($level == \Pequiven\SEIPBundle\Model\Common\CommonObject::LEVEL_GERENCIA_SECOND){
                foreach ($objetive->getParents() as $parent) {
                    if($parent->getGerencia()->getId() != $entity->getGerencia()->getId()){
                        $viewObjetiveInChart = false;
                    }
                }
            }
            
            if($viewObjetiveInChart){
            
                $refObjetive = $objetive->getRef();
                $flagResultIndicator = $flagResultArrangementProgram = $flagResultObjetives = false;
                $categories[] = array('label' => $refObjetive);
                foreach($objetive->getResults() as $result){
                    $urlObjetive =  $this->generateUrl('objetiveOperative_show', array('id' => $objetive->getId()));
                    $totalIndicator = 0.0;
                    $totalObjetives = 0.0;
                    $flagResultIndicatorInternal = false;
                    $flagResultObjetivesInternal = false;

                    if($result->getTypeResult() == \Pequiven\SEIPBundle\Model\Result\Result::TYPE_RESULT_INDICATOR){
                        $totalIndicator += $result->getResultWithWeight();
                        $flagResultIndicator = $flagResultIndicatorInternal = true;
                    }
                    if($result->getTypeResult() == \Pequiven\SEIPBundle\Model\Result\Result::TYPE_RESULT_ARRANGEMENT_PROGRAM){
                        $resultArrangementProgram[] = array('value' => bcadd($result->getResultWithWeight(),'0',2),'link' => $urlObjetive, 'bgColor' => '');
                        $flagResultArrangementProgram = true;
                    }
                    if($result->getTypeResult() == \Pequiven\SEIPBundle\Model\Result\Result::TYPE_RESULT_OBJECTIVE){
                        $totalObjetives+= $result->getResultWithWeight();
                        $flagResultObjetives = $flagResultObjetivesInternal = true;
                    }
                    if($result->getTypeResult() == \Pequiven\SEIPBundle\Model\Result\Result::TYPE_RESULT_OF_RESULT){
                        foreach ($result->getChildrens() as $child) {
                            if($child->getTypeResult() == \Pequiven\SEIPBundle\Model\Result\Result::TYPE_RESULT_INDICATOR){
                                $totalIndicator += ($child->getResultWithWeight()*$result->getWeight())/100;
                                $flagResultIndicator = $flagResultIndicatorInternal = true;
                            }elseif($child->getTypeResult() == \Pequiven\SEIPBundle\Model\Result\Result::TYPE_RESULT_OBJECTIVE){
                                $totalObjetives+= ($child->getResultWithWeight()*$result->getWeight())/100;
                                $flagResultObjetives = $flagResultObjetivesInternal = true;
                            }
                        }
                    }

                    if($flagResultIndicatorInternal === true){
                        $resultIndicator[] = array('value' => bcadd($totalIndicator,'0',2),'link' => $urlObjetive);
                    }
                    if($flagResultObjetivesInternal === true){
                        $resultObjetives[] = array('value' => bcadd($totalObjetives,'0',2),'link' => $urlObjetive, 'bgColor' => '');
                    }
                }

                //Completar valores para que no de error.
                if(!$flagResultArrangementProgram){
                    $resultArrangementProgram[] = array('value' => bcadd(0,'0',2));
                }
                if(!$flagResultIndicator){
                    $resultIndicator[] = array('value' => bcadd(0,'0',2));

                }
                if(!$flagResultObjetives){
                    $resultObjetives[] = array('value' => bcadd(0,'0',2));
                }
            }
        }
        if(count($resultIndicator) > 0){
            $data['dataSource']['dataset'][] = array(
                    'seriesname' => $this->trans('chart.result.objetiveOperative.seriesNamePlan1'),
                    'data' => $resultIndicator,
                );
        }
        if(count($resultArrangementProgram) > 0){
            $data['dataSource']['dataset'][] = array(
                'seriesname' => $this->trans('chart.result.objetiveOperative.seriesNamePlan2'),
                'data' => $resultArrangementProgram,
            );
        }
        if($showResultObjetives && count($resultObjetives) > 0){
            $data['dataSource']['dataset'][] = array(
                'seriesname' => $this->trans('chart.result.objetiveOperative.seriesNamePlan3'),
                'data' => $resultObjetives,
            );
        }
        
        $data['dataSource']['categories']['category'] = $categories;
        
        $resultService = $this->getResultService();
        
        return array(
            'object' => $objetives,
            'entity' => $entity,
            'heightChart' => $heightChart,
            'data' => $data,
            'tree' => $tree,
            'resultService' => $resultService,
            'linkToExportResult' => $linkToExportResult,
            'urlExportFromChart' => $urlExportFromChart,
            'level' => $level,
        );
    }
    
    /**
     * Recalcula los resultados
     * 
     * @param Request $request
     * @return type
     * @throws type
     */
    public function recalculateAction(Request $request)
    {
        $this->getSecurityService()->checkSecurity('ROLE_SEIP_PLANNING_OPERATION_RECALCULATE_RESULT');
        
        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('recalculate.html'))
            ->setTemplateVar($this->config->getPluralResourceName())
        ;
        $arrangementprogramRepository = $this->get('pequiven_seip.repository.arrangementprogram');
        $indicatorRepository = $this->get('pequiven.repository.indicator');
        if($request->isMethod('POST'))
        {
            $resultService = $this->getResultService();
            $id = $request->get('id');
            $type = $request->get('type');
            $data = array();
            $data['success'] = false;
            try {
                if($type == 1){
                    $resource = $arrangementprogramRepository->findWithData($id);
                    if($resource){
                        $resultService->refreshValueArrangementProgram($resource);
                    }
                }elseif($type == 2){
                    $resource = $indicatorRepository->find($id);
                    $resultService->refreshValueIndicator($resource);
                }
                $data['success'] = true;
            } catch (\Exception $exc) {
                $success = false;
                $data['code'] = $exc->getCode();
                $data['message'] = $exc->getMessage();
                $data['id'] = $id;
                $view->setStatusCode(500);
            }

            $view->setData($data);
            return $this->handleView($view);
        }
        
        $period = $this->getPeriodService()->getPeriodActive();
        
        $qbArrangementprogram = $arrangementprogramRepository->findQueryWithResultNull($period);
        $qbArrangementprogram->select('ap.id,ap.ref');
        $resultsArrangementprogram = $qbArrangementprogram->getQuery()->getResult(\Doctrine\ORM\AbstractQuery::HYDRATE_ARRAY);
        
        $qbIndicator = $indicatorRepository->findQueryWithResultNull($period);
        $qbIndicator->select('i.id,i.ref');
        $resultsIndicator = $qbIndicator->getQuery()->getResult(\Doctrine\ORM\AbstractQuery::HYDRATE_ARRAY);
                
        $view->setData(array(
            'resultsArrangementprogram' => $resultsArrangementprogram,
            'resultsIndicator' => $resultsIndicator
        ));
        
        return $this->handleView($view);
    }
    
    /**
     * Exportar los resultados de la gerencia seleccionada en formato PDF
     * @param Request $request
     */
    public function exportAction(Request $request)
    {
//        if($request->isMethod('POST')){
//            $exportRequestStream = $request->request->all();
//            $request->request->remove('charttype');
//            $request->request->remove('stream');
//            $request->request->remove('stream_type');
//            $request->request->remove('meta_bgColor');
//            $request->request->remove('meta_bgAlpha');
//            $request->request->remove('meta_DOMId');
//            $request->request->remove('meta_width');
//            $request->request->remove('meta_height');
//            $request->request->remove('parameters');
//            $fusionchartService = $this->getFusionChartExportService();
//            $fileSVG = $fusionchartService->exportFusionChart($exportRequestStream);
//        }
        
        $showResultObjetives = false;
        $level = $request->get('level');
        $resultService = $this->getResultService();
        $periodService = $this->getPeriodService();
        $images = array();
        $em = $this->getDoctrine();
        $id = $request->get('id');
        
        $tree = $objetives = array();
        $caption = '';
        $images['good'] = $resultService->generateAsset('bundles/pequivenseip/logotipos/bullet_green.png');
        $images['middle'] = $resultService->generateAsset('bundles/pequivenseip/logotipos/bullet_yellow.png');
        $images['bad'] = $resultService->generateAsset('bundles/pequivenseip/logotipos/bullet_red.png');
        if($level == \Pequiven\SEIPBundle\Model\Common\CommonObject::LEVEL_GERENCIA){
            $showResultObjetives = true;
            $caption = $this->trans('result.captionObjetiveTactical',array(),'PequivenSEIPBundle');
            $gerencia = $this->get('pequiven.repository.gerenciafirst')->findWithObjetives($id);
            $objetives = $gerencia->getTacticalObjectives();
            foreach ($objetives as $objetive) {
                foreach ($objetive->getParents() as $parent) {
                    if(!isset($tree[(string)$parent])){
                        $tree[(string)$parent] = array(
                            'parent' => $parent,
                            'child' => array(),
                        );
                    }
                    $tree[(string)$parent]['child'][(string)$objetive] = $objetive;
                }
            }
            $entity = $gerencia;
        }elseif($level == \Pequiven\SEIPBundle\Model\Common\CommonObject::LEVEL_GERENCIA_SECOND){
            $caption = $this->trans('result.captionObjetiveOperative',array(),'PequivenSEIPBundle');
            $gerenciaSecond = $em->getRepository('PequivenMasterBundle:GerenciaSecond')->findWithObjetives($id);
            $objetives = $gerenciaSecond->getOperationalObjectives();
            foreach ($objetives as $objetive) {
                foreach ($objetive->getParents() as $parent) {
                    if($parent->getGerencia()->getId() === $gerenciaSecond->getGerencia()->getId()){
                        if(!isset($tree[(string)$parent])){
                            $tree[(string)$parent] = array(
                                'parent' => $parent,
                                'child' => array(),
                            );
                        }
                        $tree[(string)$parent]['child'][(string)$objetive] = $objetive;
                    }
                }
            }
            $entity = $gerenciaSecond;
        }
        
        $pdf = new SeipPdf('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->setContainer($this->container);
        $pdf->setPeriod($periodService->getPeriodActive());
        $pdf->setFooterText($this->trans('pequiven_seip.message_footer',array(), 'PequivenSEIPBundle'));

        $namePdf = $this->trans('pequiven_seip.results.resultsByGerencia', array('%gerencia%' => $entity->getDescription()), 'PequivenSEIPBundle');
//        $title = $this->trans('pequiven_seip.results.results',array(),'PequivenSEIPBundle');
        $title = $namePdf;
        
        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('SEIP');
        $pdf->setTitle($title);
        $pdf->SetSubject('Resultados SEIP');
        $pdf->SetKeywords('PDF, SEIP, Resultados');

        // set default header data
//        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        
        // set font
        $pdf->SetFont('times', 'BI', 12);

        if(isset($fileSVG)){
            if(strlen($fileSVG) > 0){
                $pdf->AddPage();
                $pdf->ImageSVG('http://localhost/seip/web/php-export-handler/temp/'.$fileSVG);
            }
        }
        
        // add a page
        $pdf->AddPage();
        
        // set some text to print
        $html = $this->renderView('PequivenSEIPBundle:Result:viewPdf.html.twig',array(
            'entity' => $entity,
            'tree' => $tree,
            'level' => $level,
            'resultService' => $resultService,
            'images' => $images));
        
//        print($html);
//        die();

        // print a block of text using Write()
        $pdf->writeHTML($html, true, false, true, false);
        
        $pdf->Output($namePdf.'.pdf', 'D');
//        die();
    }
    
    /**
     * Exportar los resultados de la gerencia seleccionada en formato PDF
     * @param Request $request
     */
    public function exportFromChartAction(Request $request){
        
        $id = $request->get('id');
        $level = $request->get('level');
        
        return $this->redirect($this->generateUrl('pequiven_seip_result_export', array('level' => $level,'id' => $id)));
    }
    
    protected function trans($id,array $parameters = array(), $domain = 'messages')
    {
        return $this->get('translator')->trans($id, $parameters, $domain);
    }
    
    /**
     * Servicio de resultados
     * @return \Pequiven\SEIPBundle\Service\ResultService
     */
    private function getResultService(){
        return $this->container->get('seip.service.result');
    }
    
    /**
     * @return \Pequiven\SEIPBundle\Service\PeriodService
     */
    private function getPeriodService()
    {
        return $this->container->get('pequiven_arrangement_program.service.period');
    }
    
    /**
     * @return \Pequiven\SEIPBundle\Service\FusionChartExportService
     */
    private function getFusionChartExportService()
    {
        return $this->container->get('pequiven_seip.service.fusion_chart');
    }
    
    /**
     * Manejador de usuario o administrador
     * @return \Pequiven\SEIPBundle\Model\PDF\SeipPdf
     */
//    private function getSeipPdf() 
//    {
//        return $this->container->get('seip.pdf');
//    }
    
    /**
     * 
     * @return \Pequiven\SEIPBundle\Service\SecurityService
     */
    protected function getSecurityService()
    {
        return $this->container->get('seip.service.security');
    }
}
