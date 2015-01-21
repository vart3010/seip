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

use Pequiven\MasterBundle\Entity\Rol;
use Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanning;
use Symfony\Component\HttpFoundation\Request;
use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController;

/**
 * Controlador de pre-planificacion
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class PrePlanningController extends ResourceController
{
    public function indexAction(Request $request) {
        return parent::indexAction($request);
    }
    
    public function getFormAction() {
        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('form.html'))
            ->setTemplateVar($this->config->getPluralResourceName())
        ;
        return $this->handleView($view);
    }
    
    public function getPrePlanningAction(Request $request)
    {
        $user = $this->getUser();
        $rol = $user->getLevelRealByGroup();
        $objetivesArray = array();
        
        if($rol == Rol::ROLE_MANAGER_SECOND){
            $gerenciaSecond = $user->getGerenciaSecond();
            $objetivesOperational = $gerenciaSecond->getOperationalObjectives();
            foreach ($objetivesOperational as $objetive){
                $parents = $objetive->getParents();
                foreach ($parents as $parent) {
                    if(isset($objetivesArray[$parent->getId()])){
                        continue;
                    }
                    $objetivesArray[$parent->getId()] = array(
                        'parent' => $parent,
                        'childrens' => array(),
                    );
                }
                $objetivesArray[$parent->getId()]['childrens'][$objetive->getId()] = $objetive;
            }
        }
        $prePlanningService = $this->getPrePlanningService();
        
        $periodActive = $this->getPeriodService()->getPeriodActive();
        $rootTreePrePlannig = $prePlanningService->findRootTreePrePlannig($periodActive,$user);
        if(!$rootTreePrePlannig){
            $rootTreePrePlannig = $prePlanningService->buildTreePrePlannig($objetivesArray);
        }
        $structureTree = $prePlanningService->buildStructureTree($rootTreePrePlannig);

        $data = array(
            "success" => true,
            "text" =>  ".",
            "children"=> $structureTree
        );
        $view = $this->view($data);
        return $this->handleView($view);
    }
    
    /**
     * @return \Pequiven\SEIPBundle\Service\PeriodService
     */
    private function getPeriodService()
    {
        return $this->container->get('pequiven_arrangement_program.service.period');
    }
    
    /**
     * 
     * @return \Pequiven\SEIPBundle\Service\PrePlanningService
     */
    private function getPrePlanningService()
    {
        return $this->container->get('seip.service.preplanning');
    }
}
