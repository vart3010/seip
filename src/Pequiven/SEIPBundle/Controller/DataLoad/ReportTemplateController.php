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
        
        if($request->isMethod('PUT') && $form->submit($request,false)->isValid()){
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
        $plantReports = $productsReport = array();
        $emptyValue = "Seleccione";
        if($plantReport){
            $plantReports[] = $plantReport;
            $productsReport = $plantReport->getProductsReport()->toArray();
        }
        $showDay = $showMonth = $showYear = $defaultShow = true;
        $form = $this
            ->createFormBuilder()
            ->add('plantReport','entity',array(
                'label_attr' => array('class' => 'label bold'),
                'class' => 'Pequiven\SEIPBundle\Entity\DataLoad\PlantReport',
                'property' => 'plant',
                'required' => true,
                'empty_value' => $emptyValue,
                'translation_domain' => 'PequivenSEIPBundle',
                'attr' => array('class' => 'select2 input-xlarge'),
                'multiple' => false,
                'group_by' => 'reportTemplate'
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
                    $plantReports = [$plantReport];
            }
            
//            die;
        }
        $data = array(
            'dateReport' => $dateReport,
            'plantReports' => $plantReports,
            'plantReportId' => $plantReportId,
            'form' => $form->createView(),
            'showDay' => $showDay,
            'showMonth' => $showMonth,
            'showYear' => $showYear,
        );

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('vizualice.html'))
                ;
        $view->setData($data);
        return $this->handleView($view);
    }
}
