<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Controller\PrePlanning;

use Pequiven\SEIPBundle\Controller\SEIPController;
use Pequiven\SEIPBundle\Service\PeriodService;
use Symfony\Component\HttpFoundation\Request;
use Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanningUser;

/**
 * Controlador de la pre-planificacion de usuario
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class PrePlanningUserController extends SEIPController
{
    public function indexAction(Request $request) 
    {
        $type = $request->get('type');
        if($type == PrePlanningUser::FORM_PLANNING){
            $this->getSecurityService()->checkSecurity('ROLE_SEIP_PRE_PLANNING_LIST_PLANNING');
        }elseif($type == PrePlanningUser::FORM_STATISTICS){
            $this->getSecurityService()->checkSecurity('ROLE_SEIP_PRE_PLANNING_LIST_STATISTICS');
        }else{
            $this->getSecurityService()->checkSecurity(null);
        }
        
        $period = $request->get('period');
        
        $criteria = $request->get('filter',$this->config->getCriteria());
        $sorting = $request->get('sorting',$this->config->getSorting());
        $repository = $this->getRepository();
        
        if($type == PrePlanningUser::FORM_PLANNING){
            $criteria['period'] = $this->getPeriodService()->getPeriodActive();
            $resources = $this->resourceResolver->getResource(
                $repository,
                'createPaginator',
                array($criteria, $sorting)
            );
        }elseif($type == PrePlanningUser::FORM_STATISTICS){
            $resources = $repository->findWithIndicators($this->getPeriodService()->getPeriodActive(),$criteria,$sorting);
        }
        
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
            $labelsStatus = PrePlanningUser::getLabelsStatus();
            $view->setData(
                    array(
                        $this->config->getPluralResourceName() => $resources,
                        'labels_status' => $labelsStatus,
                    ));
        }else{
            $formatData = $request->get('_formatData','default');
            $view->getSerializationContext()->setGroups(array('id','api_list','period'));
            
            $view->setData($resources->toArray($this->config->getRedirectRoute('index'),array('period' => $period,'type' => $type),$formatData));
        }
        return $this->handleView($view);
    }
  
    public function showAction(Request $request) {
        return parent::showAction($request);
    }
    
    /**
     * @return PeriodService
     */
    protected function getPeriodService()
    {
        return $this->container->get('pequiven_seip.service.period');
    }
    
}
