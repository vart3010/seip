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
}
