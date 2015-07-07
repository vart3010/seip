<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com.ve
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Controller\DataLoad;

use Pequiven\SEIPBundle\Controller\SEIPController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controlador de plantilla de reporte
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class ReportTemplateController extends SEIPController 
{
    public function indexAction(Request $request) 
    {
        $criteria = $request->get('filter',$this->config->getCriteria());
        $sorting = $request->get('sorting',$this->config->getSorting());
        $repository = $this->getRepository();

            $resources = $this->resourceResolver->getResource(
                $repository,
                'createPaginator',
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
        
        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('index.html'))
            ->setTemplateVar($this->config->getPluralResourceName())
        ;
        if($request->get('_format') == 'html'){
            $view->setData($resources);
        }else{
            $formatData = $request->get('_formatData','default');
            $view->setData($resources->toArray($this->config->getRedirectRoute('index'),array(),$formatData));
        }
        return $this->handleView($view);
    }
    
    public function listAction(Request $request) 
    {
        $criteria = $request->get('filter',$this->config->getCriteria());
        $sorting = $request->get('sorting',$this->config->getSorting());
        $repository = $this->getRepository();

            $resources = $this->resourceResolver->getResource(
                $repository,
                'createPaginator',
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
        
        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('list.html'))
            ->setTemplateVar($this->config->getPluralResourceName())
        ;
        if($request->get('_format') == 'html'){
            $view->setData($resources);
        }else{
            $formatData = $request->get('_formatData','default');
            $view->setData($resources->toArray($this->config->getRedirectRoute('list'),array(),$formatData));
        }
        return $this->handleView($view);
    }
    
    /**
     * Notificar produccion
     * @param Request $request
     * @return type
     * @throws type
     */
    public function loadAction(Request $request) 
    {
        $dateString = null;
        if($this->getSecurityService()->isGranted('ROLE_SEIP_DATA_LOAD_CHANGE_DATE')){
            $dateString = $request->get('dateNotification',null);
        }
        $plantReport = $request->get('plant_report',null);
        if($plantReport === null){
            return $this->redirect($this->generateUrl('pequiven_plant_report_index'));
        }
        $dateNotification = null;
        if($dateString !== null){
            $dateNotification = \DateTime::createFromFormat('d/m/Y', $dateString);
        }
        if($dateNotification === null){
            $dateNotification = new \DateTime();
        }
        $resource = $this->getRepository()->findToNotify($request->get("id"),$dateNotification,$plantReport);
        
        if(!$resource){
            throw $this->createNotFoundException('No se encontro la planificacion');
        }
        
        $form = $this->createForm(new \Pequiven\SEIPBundle\Form\DataLoad\Notification\ReportTemplateType($dateNotification,$resource),$resource);
        
        if($request->isMethod('POST') && $form->submit($request,false)->isValid()){
            $data = $form->getData();
            $data->recalculate();
            $this->domainManager->update($resource);
            return $this->redirect($this->generateUrl('pequiven_report_template_list'));
        }
        
        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('load.html'))
            ->setTemplateVar($this->config->getResourceName())
            ->setData(array(
                $this->config->getResourceName() => $resource,
                'dateNotification' => $dateNotification,
                'form' => $form->createView(),
            ))
        ;

        return $this->handleView($view);
    }
    
    /**
     * Vizualizar la planificacion
     * @param Request $request
     * @return type
     */
    public function vizualiceAction(Request $request)
    {
        $plantReportId = null;
        if($request->isMethod("POST")){
            $formData = $request->get("form");
            $plantReportId = (int)$formData['plantReport'];
        }
        
        $dateReport = new \DateTime();
        if(!$this->getSecurityService()->isGranted('ROLE_SEIP_DATA_LOAD_CHANGE_DATE')){
            $dateReport = new \DateTime();
        }
        $plantReport = $this->get('pequiven.repository.plant_report')->find($plantReportId);
        $productsReport = array();
        $plantReports = new \Doctrine\Common\Collections\ArrayCollection();
        $emptyValue = "Seleccione";
        if($plantReport){
            $plantReports->add($plantReport);
            $productsReport = $plantReport->getProductsReport()->toArray();
        }
        $showDay = $showMonth = $showYear = $defaultShow = true;
        $form = $this
            ->createFormBuilder()
            ->add('reportTemplate','entity',array(
                'label_attr' => array('class' => 'label bold'),
                'class' => 'Pequiven\SEIPBundle\Entity\DataLoad\ReportTemplate',
                'property' => 'reportTemplateWithName',
                'required' => false,
                'empty_value' => $emptyValue,
                'translation_domain' => 'PequivenSEIPBundle',
                'attr' => array('class' => 'select2 input-xlarge'),
                'multiple' => true,
                )
            )
            ->add('plantReport','entity',array(
                'label_attr' => array('class' => 'label bold'),
                'class' => 'Pequiven\SEIPBundle\Entity\DataLoad\PlantReport',
                'property' => 'plant',
                'required' => true,
                'empty_value' => $emptyValue,
                'translation_domain' => 'PequivenSEIPBundle',
                'attr' => array('class' => 'select2 input-xlarge'),
                'multiple' => false,
                'group_by' => 'reportTemplateWithName'
                )
            )
            ->add('dateReport','date',[
                'format' => 'd/M/y',
                'widget' => 'single_text',
                'translation_domain' => 'PequivenSEIPBundle',
                'attr' => array('class' => 'input'),
                'data' => $dateReport,
            ])
            ->add('productsReport','entity',[
                'label_attr' => array('class' => 'label bold'),
                'class' => 'Pequiven\SEIPBundle\Entity\DataLoad\ProductReport',
                'multiple' => true,
                'translation_domain' => 'PequivenSEIPBundle',
                'required' => false,
                'attr' => array('class' => 'select2 input-xlarge'),
            ])
            ->add('showDay','checkbox',[
                'label_attr' => array('class' => 'label bold'),
                'required' => false,
                'translation_domain' => 'PequivenSEIPBundle',
                'data' => $defaultShow,
            ])
            ->add('showMonth','checkbox',[
                'label_attr' => array('class' => 'label bold'),
                'required' => false,
                'translation_domain' => 'PequivenSEIPBundle',
                'data' => $defaultShow,
            ])
            ->add('showYear','checkbox',[
                'label_attr' => array('class' => 'label bold'),
                'required' => false,
                'translation_domain' => 'PequivenSEIPBundle',
                'data' => $defaultShow,
            ])
            ->add('typeReport','choice',[
                'choices' => [
                    'Gross' => 'Bruta',
                    'Net' => 'Neta',
                ],
                'data' => 'Gross',
                'attr' => array('class' => 'select2 input-xlarge'),
                'translation_domain' => 'PequivenSEIPBundle',
            ])
            ->getForm();
        
        if($request->isMethod('POST') && $form->submit($request)->isValid()){
            $data = $form->getData();
            $showDay = $data['showDay'];
            $showMonth = $data['showMonth'];
            $showYear = $data['showYear'];
            $productsReport = $data['productsReport'];
            if($productsReport && count($productsReport) > 0){
                foreach ($productsReport as $productReport) {
                    $productsReportId[] = $productReport->getId();
                }
                    foreach ($plantReport->getProductsReport() as $productReport) {
                        if(!in_array($productReport->getId(), $productsReportId)){
                            $plantReport->getProductsReport()->removeElement($productReport);
                            continue;
                        }
                    }
                    $plantReports->add($plantReport);
            }
            
        }
        $data = $form->getData();
        $typeReport = $data['typeReport'];
        if($typeReport === null){
            $typeReport = 'Gross';
        }
        $dateReport = $data['dateReport'];
        $reportTemplates = $data['reportTemplate'];
        if($reportTemplates){
            foreach ($reportTemplates as $reportTemplate) {
                foreach ($reportTemplate->getPlantReports() as $plantReport) {
                    if(!$plantReports->contains($plantReport)){
                        $plantReports->add($plantReport);
                    }
                }
            }
        }
        
        $productsReport = new \Doctrine\Common\Collections\ArrayCollection();
        $consumerPlanningServices = new \Doctrine\Common\Collections\ArrayCollection();
        $rawMaterialConsumptionPlannings = new \Doctrine\Common\Collections\ArrayCollection();
        
        $productsReportByIdProduct = $consumerPlanningServicesByIdService = $rawMaterialConsumptionPlanningsById = array();
        foreach ($plantReports as $plantReport) {
            foreach ($plantReport->getProductsReport() as $productReport) {
                $product = $productReport->getProduct();
                if(!isset($productsReportByIdProduct[$product->getId()])){
                    $productsReportByIdProduct[$product->getId()] = array();
                }
                $productsReportByIdProduct[$product->getId()][] = $productReport;
                
                foreach ($productReport->getRawMaterialConsumptionPlannings() as $rawMaterialConsumptionPlanning) {
                    $product = $rawMaterialConsumptionPlanning->getProduct();
                    if(!isset($rawMaterialConsumptionPlanningsById[$product->getId()])){
                        $rawMaterialConsumptionPlanningsById[$product->getId()] = array();
                    }
                    $rawMaterialConsumptionPlanningsById[$product->getId()][] = $rawMaterialConsumptionPlanning;
                }
                
            }
            
            foreach ($plantReport->getConsumerPlanningServices() as $consumerPlanningService) {
                $service = $consumerPlanningService->getService();
                if(!isset($consumerPlanningServicesByIdService[$service->getId()])){
                    $consumerPlanningServicesByIdService[$service->getId()] = array();
                }
                $consumerPlanningServicesByIdService[$service->getId()][] = $consumerPlanningService;
                
            }
        }
        foreach ($productsReportByIdProduct as $id => $groups) {
            foreach ($groups as $productReport) {
                if(!$productsReport->contains($productReport)){
                    $productsReport->add($productReport);
                }
            }
        }
        foreach ($consumerPlanningServicesByIdService as $id => $groups) {
            foreach ($groups as $consumerPlanningService) {
                if(!$consumerPlanningServices->contains($consumerPlanningService)){
                    $consumerPlanningServices->add($consumerPlanningService);
                }
            }
        }
        
        foreach ($rawMaterialConsumptionPlanningsById as $id => $groups) {
            foreach ($groups as $rawMaterialConsumptionPlanning) {
                if(!$rawMaterialConsumptionPlannings->contains($rawMaterialConsumptionPlanning)){
                    $rawMaterialConsumptionPlannings->add($rawMaterialConsumptionPlanning);
                }
            }
        }
        
        $data = array(
            'dateReport' => $dateReport,
            'productsReport' => $productsReport,
            'consumerPlanningServices' => $consumerPlanningServices,
            'rawMaterialConsumptionPlannings' => $rawMaterialConsumptionPlannings,
            'plantReportId' => $plantReportId,
            'form' => $form->createView(),
            'showDay' => $showDay,
            'showMonth' => $showMonth,
            'showYear' => $showYear,
            'typeReport' => $typeReport,
        );

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('vizualice.html'))
                ;
        $view->setData($data);
        
        $exportToPdf = $request->get('exportToPdf',false);
        if($exportToPdf == true){
            $pdf = new \Pequiven\SEIPBundle\Model\PDF\SeipPdf('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->setPrintLineFooter(false);
            $pdf->setContainer($this->container);
            $pdf->setPeriod($this->getPeriodService()->getPeriodActive());
            $pdf->setFooterText($this->trans('pequiven_seip.message_footer',array(), 'PequivenSEIPBundle'));

            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('SEIP');
            $pdf->setTitle('Reporte del día');
            $pdf->SetSubject('Resultados SEIP');
            $pdf->SetKeywords('PDF, SEIP, Resultados');

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
//            $pdf->SetFont('times', 'BI', 12);

            // add a page
            $pdf->AddPage();

            // set some text to print
            $html = $this->renderView('PequivenSEIPBundle:DataLoad/ReportTemplate:vizualice_data.html.twig',$data);

            // print a block of text using Write()
            $pdf->writeHTML($html, true, false, true, false, '');

//            $pdf->Output('Reporte del dia'.'.pdf', 'I');
            $pdf->Output('Reporte del dia'.'.pdf', 'D');
        }
        
        return $this->handleView($view);
    }
}
