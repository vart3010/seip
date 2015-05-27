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

const PHP_TIME_LIMIT = 120;
const PHP_MEMORY_LIMIT = '256M';
//const PHP_MEMORY_LIMIT = '320M';

/**
 * Controlador de pre-planificacion
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class PrePlanningController extends ResourceController
{
    private static $levels = array(
        PrePlanning::LEVEL_TACTICO => array('ROLE_SEIP_PRE_PLANNING_CREATE_TACTIC','ROLE_SEIP_PRE_PLANNING_VIEW_TACTIC'),
        PrePlanning::LEVEL_OPERATIVO => array('ROLE_SEIP_PRE_PLANNING_CREATE_OPERATIVE','ROLE_SEIP_PRE_PLANNING_VIEW_OPERATIVE'),
    );
    
    public function createAction(Request $request) 
    {
        $this->checkSecurity($request);
        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('create.html'))
            ->setTemplateVar($this->config->getPluralResourceName())
        ;
        return $this->handleView($view);
    }
    
    public function getFormAction(Request $request) 
    {
        $type = $request->get('type');
        $formTemplate = 'form.html';
        if($type == \Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanningUser::FORM_PLANNING){
            $formTemplate = 'formImportPlanning.html'; 
        } elseif ($type == \Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanningUser::FORM_STATISTICS){
            $formTemplate = 'formImportPlanning.html';
        }
        $this->checkSecurity($request);
        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate($formTemplate))
            ->setTemplateVar($this->config->getPluralResourceName())
        ;
        return $this->handleView($view);
    }
    
    /**
     * Obtiene el arbol construido para el usuario
     * @param Request $request
     * @return type
     */
    public function getPrePlanningAction(Request $request)
    {
        $this->checkSecurity($request);
        set_time_limit(PHP_TIME_LIMIT);
        ini_set("memory_limit",PHP_MEMORY_LIMIT);
        
        $level = $request->get('level');
        $user = $this->getUser();
        $prePlanningService = $this->getPrePlanningService();
        $node = (int)$request->get('node',null);
        $nodeRoot = (int)$request->get('nodeRoot',null);
        if($node == 0 && $nodeRoot > 0){
            $node = $nodeRoot;
        }
        $periodActive = $this->getPeriodService()->getPeriodActive();
        
        $structureTree = array();
        if(is_int($node) && $node > 0)
        {
            $em = $this->getDoctrine()->getManager();
            $rootTreePrePlannig =  $em->getRepository('Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanning')->find($node);
        } else {
            $rootTreePrePlannig = $prePlanningService->findRootTreePrePlannig($periodActive,$user,$level);
            if($rootTreePrePlannig){
                $rootTreePrePlannig = $rootTreePrePlannig->getPrePlanningRoot();
            }
        }
     
        if($rootTreePrePlannig){
            $structureTree = $prePlanningService->buildStructureTree($rootTreePrePlannig);
        }
        
        $data = array(
            "success" => true,
            "text" =>  "Root",
            "children"=> $structureTree,
        );
        $view = $this->view($data);
        return $this->handleView($view);
    }
    
    /**
     * Elimina items de mi nodo
     * 
     * @param Request $request
     * @return type
     */
    public function deletePrePlanningAction(Request $request)
    {
        $this->checkSecurity($request);
        
        $dataRequest = $request->request->all();
        $ids = array();
        foreach ($dataRequest as $value) {
            if(is_int($value)){
                $ids[$value] = $value;
            }
            if(isset($value['id'])){
                $ids[$value['id']] = $value['id'];
            }
        }
        $success = false;
        if(count($ids) > 0){
            $em = $this->getDoctrine()->getManager();
            $repository = $this->getRepository();
            $resources = $repository->findIn($ids);
            foreach ($resources as $resource) {
                $em->remove($resource);
            }
            $em->flush();
            $success = true;
        }
        $data = array(
            "success" => $success,
            "data" => $ids
        );
        $view = $this->view($data);
        return $this->handleView($view);
    }
    
    /**
     * Reconstruyendo el arbol nuevamente.
     * @return type
     */
    public function returnChangesAction(Request $request) 
    {
        $this->checkSecurity($request);
        set_time_limit(PHP_TIME_LIMIT);
        ini_set("memory_limit",PHP_MEMORY_LIMIT);
        $level = $request->get('level',null);
        $success = true;
        if($level){
            $user = $this->getUser();
            $prePlanningService = $this->getPrePlanningService();
            $periodActive = $this->getPeriodService()->getPeriodActive();
            $rootTreePrePlannig = $prePlanningService->findRootTreePrePlannig($periodActive,$user,$level);
            if($rootTreePrePlannig){
                $em = $this->getDoctrine()->getManager();
                $em->remove($rootTreePrePlannig);
                $em->flush();

                $objetivesArray = $this->getObjetivesArray($level);
                $prePlanningService->buildTreePrePlannig($objetivesArray,$level);
            }
        }else{
            $success = false;
        }
        $data = array(
            "success" => $success,
        );
        $view = $this->view($data);
        return $this->handleView($view);
    }
    
    /**
     * Iniciando el proceso de planificacion
     * 
     * @return type
     */
    public function startPrePlanningAction(Request $request) 
    {
        $this->checkSecurity($request);
        set_time_limit(PHP_TIME_LIMIT);
        ini_set("memory_limit",PHP_MEMORY_LIMIT);
        $level = $request->get('level',null);
        $success = false;
        $id  = 0;
        if($level){
            $user = $this->getUser();
            $prePlanningService = $this->getPrePlanningService();
            $periodActive = $this->getPeriodService()->getPeriodActive();
            $rootTreePrePlannig = $prePlanningService->findRootTreePrePlannig($periodActive,$user,$level);
            if($rootTreePrePlannig){
                $em = $this->getDoctrine()->getManager();
                $em->remove($rootTreePrePlannig);
                $em->flush();
            }

            $objetivesArray = $this->getObjetivesArray($level);
            $rootTreePrePlannig = $prePlanningService->buildTreePrePlannig($objetivesArray,$level);
            $id = $rootTreePrePlannig->getId();
            $success = true;
        }else{
            $success = false;
        }
        
        $data = array(
            "success" => $success,
            "id" => $id,
        );
        $view = $this->view($data);
        return $this->handleView($view);
    }
    
    /**
     * Actualiza los items de preplanificacion
     * 
     * @param Request $request
     * @return type
     */
    public function updatePrePlanningAction(Request $request) 
    {
        $securityService = $this->getSecurityService();
        $securityService->checkSecurity(array(
            'ROLE_SEIP_PRE_PLANNING_CREATE_TACTIC',
            'ROLE_SEIP_PRE_PLANNING_CREATE_OPERATIVE',
        ));
        
        $dataRequest = $request->request->all();
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getRepository();
        
        if(isset($dataRequest['toImport'])){
            $resource = $repository->find($dataRequest['id']);
            $resource->setToImport($dataRequest['toImport']);
            $em->persist($resource);
        } else {
            foreach ($dataRequest as $key => $value) {
                if(!isset($value['toImport'])){
                    $value['toImport'] = false;
                }
                $resource = $repository->find($value['id']);
                $resource->setToImport($value['toImport']);
                $em->persist($resource);
            }
        }
        
        $em->flush();
        $data = array(
            "success" => true,
        );
        $view = $this->view($data);
        return $this->handleView($view);
    }
    
    /**
     * Accion para importar los items
     * 
     * @param Request $request
     * @return type
     */
    public function importAction(Request $request)
    {
        $securityService = $this->getSecurityService();
        $securityService->checkSecurity(array(
            'ROLE_SEIP_PRE_PLANNING_OPERATION_IMPORT_STATISTICS_INDICATOR',
            'ROLE_SEIP_PRE_PLANNING_OPERATION_IMPORT_PLANNING_OBJETIVE',
            'ROLE_SEIP_PRE_PLANNING_OPERATION_IMPORT_PLANNING_ARRANGEMENT_PROGRAM',
            'ROLE_SEIP_PRE_PLANNING_OPERATION_IMPORT_PLANNING_ARRANGEMENT_PROGRAM_GOAL',
        ));
        
        set_time_limit(PHP_TIME_LIMIT);
        ini_set("memory_limit",PHP_MEMORY_LIMIT);
        
        $prePlanning = $this->findOr404($request);
        $user = $this->getUser();
        $prePlanningService = $this->getPrePlanningService();
        $success = $prePlanningService->importItem($prePlanning, $user);
        $error = '';
        if(is_string($success) === true){
            $error = $success;
            $success = false;
        }
        $data = array(
            "success" => $success,
            "message" => $error,
        );
        $view = $this->view($data);
        if($success == false){
            $view->setStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_NOT_ACCEPTABLE);
        }
        return $this->handleView($view);
    }
    
    /**
     * Envia la planificacion a revision
     * 
     * @param Request $request
     * @return type
     */
    public function sendToReviewAction(Request $request)
    {
        $this->checkSecurity($request);
        
        $resource = $this->findOr404($request);
        $success = false;
        $data = array();
        $em = $this->getDoctrine()->getManager();
//        var_dump(get_class($resource));
        
        $parent = $resource->getParent();
        $validToImport = true;
        $message = 'No se pudo enviar a revisión.';
        if($parent && $parent->getTypeObject() != PrePlanning::TYPE_OBJECT_ROOT_NODE){
            
            if($parent->getStatus() !== PrePlanning::STATUS_IN_REVIEW && $parent->getStatus() !== PrePlanning::STATUS_IMPORTED && $parent->getStatus() != PrePlanning::STATUS_REQUIRED)
            {
                $validToImport = false;
                $message = 'Es obligatorio enviar a revisión el item padre.';
            }
        }
        if($validToImport && $resource->getStatus() == PrePlanning::STATUS_DRAFT)
        {
            $lastItem = (boolean)$request->get('lastItem',false);
            $level = $request->get('level',null);
            
            $user = $this->getUser();
            $resource->setStatus(PrePlanning::STATUS_IN_REVIEW);
            $success = true;
            $em->persist($resource);
            if($lastItem === true){
                //enviar correo
                $periodActive = $this->getPeriodService()->getPeriodActive();
                $prePlanningService = $this->getPrePlanningService();
                $rootTreePrePlannig = $prePlanningService->findRootTreePrePlannig($periodActive,$user,$level);
                $data['messages'] = array(
                    'email_send'
                );
                $rootTreePrePlannig->setStatus(PrePlanning::STATUS_IN_REVIEW);
                $em->persist($rootTreePrePlannig);
                
                $event = new \Symfony\Component\EventDispatcher\GenericEvent($rootTreePrePlannig);
                $this->getEventDispatcher()->dispatch(\Pequiven\SEIPBundle\EventListener\SeipEvents::PRE_PLANNING_POST_SEND_TO_REVIEW,$event);
            }
            $em->flush();
            $message = 'Se envio a revision correctamente.';
        }else{
            $success = false;
        }
        
        $data["success"] = $success;
        $data["message"] = $message;
        
        $view = $this->view($data);
        if($success === false){
            $view->setStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_NOT_ACCEPTABLE);
        }
        
        return $this->handleView($view);
    }
    
    /**
     * Envia la planificacion a borrador
     * 
     * @param Request $request
     * @return type
     */
    public function sendToDraftAction(Request $request)
    {
        $securityService = $this->getSecurityService();
        $securityService->checkSecurity(array(
            'ROLE_SEIP_PRE_PLANNING_OPERATION_IMPORT_STATISTICS_INDICATOR',
            'ROLE_SEIP_PRE_PLANNING_OPERATION_IMPORT_PLANNING_OBJETIVE',
            'ROLE_SEIP_PRE_PLANNING_OPERATION_IMPORT_PLANNING_ARRANGEMENT_PROGRAM',
            'ROLE_SEIP_PRE_PLANNING_OPERATION_IMPORT_PLANNING_ARRANGEMENT_PROGRAM_GOAL',
        ));
        $rootId = $request->get('root');
        $resource = $this->findOr404($request);
        $success = false;
        $data = array();
        $em = $this->getDoctrine()->getManager();
        
        if($resource->getStatus() == PrePlanning::STATUS_IN_REVIEW){
            $lastItem = (boolean)$request->get('lastItem',false);
            $level = $request->get('level',null);
            
            $user = $this->getUser();
            $resource->setStatus(PrePlanning::STATUS_DRAFT);
            $success = true;
            $em->persist($resource);
            if($lastItem === true){
                $prePlanningService = $this->getPrePlanningService();
                $rootTreePrePlannig = $prePlanningService->findRootTreePrePlannigById($rootId);
                $data['messages'] = array(
                    'email_send'
                );
                $rootTreePrePlannig->setStatus(PrePlanning::STATUS_DRAFT);
                $em->persist($rootTreePrePlannig);
                
                $event = new \Symfony\Component\EventDispatcher\GenericEvent($rootTreePrePlannig);
                $this->getEventDispatcher()->dispatch(\Pequiven\SEIPBundle\EventListener\SeipEvents::PRE_PLANNING_POST_SEND_TO_DRAFT,$event);
            }
            $em->flush();
        }
        
        $data["success"] = $success;
        
        $view = $this->view($data);
        
        return $this->handleView($view);
    }
    
    /**
     * Obtener los objetivos para construir el arbol
     * @return type
     */
    private function getObjetivesArray($level)
    {
        $user = $this->getUser();
        $configuration = $user->getConfiguration();

        $prePlanningConfiguration = $configuration->getPrePlanningConfiguration();
        $objetivesArray = array();
        $periodActive = $this->getPeriodService()->getEntityPeriodActive();
        
        if($level == \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_OPERATIVO && $prePlanningConfiguration->getGerenciaSecond() !== null){
            $gerenciaSecond = $prePlanningConfiguration->getGerenciaSecond();
            $objetivesOperational = array();
            foreach ($gerenciaSecond->getOperationalObjectives() as $objetive) {
                if($objetive->getPeriod() !== $periodActive){
                    continue;
                }
                $objetivesOperational []= $objetive;
            }
            
            $objetivesArray = $this->getDataFromObjetives($objetivesOperational);
        }else if($level == \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_TACTICO && $prePlanningConfiguration->getGerencia() !== null){
            $gerencia = $prePlanningConfiguration->getGerencia();
            $tacticalObjectives = array();
            foreach ($gerencia->getObjetives() as $objetive) {
                if($objetive->getPeriod() !== $periodActive){
                    continue;
                }
                $tacticalObjectives []= $objetive;
            }
            $objetivesArray = $this->getDataFromObjetives($tacticalObjectives);
        }
        return $objetivesArray;
    }
    
    private function getDataFromObjetives($objetives)
    {
        $objetivesArray = array();
        foreach ($objetives as $objetive){
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
//                foreach ($objetivesArray as $value) {
//                    var_dump('parent '.$value['parent']->getRef());
//                    foreach ($value['childrens'] as $child) {
//                        var_dump('child '.$child->getRef());
//                    }
//                }
//        var_dump($objetivesArray);
        return $objetivesArray;
    }

    /**
     * @return \Pequiven\SEIPBundle\Service\PeriodService
     */
    protected function getPeriodService()
    {
        return $this->container->get('pequiven_seip.service.period');
    }
    
    /**
     * 
     * @return \Pequiven\SEIPBundle\Service\PrePlanningService
     */
    private function getPrePlanningService()
    {
        return $this->container->get('seip.service.preplanning');
    }
    
    /**
     * 
     * @return \Pequiven\SEIPBundle\Service\Configuration
     */
    private function getSeipConfiguration()
    {
        return $this->container->get('seip.configuration');
    }
    
    /**
     * 
     * @return \Pequiven\SEIPBundle\Service\SecurityService
     */
    protected function getSecurityService()
    {
        return $this->container->get('seip.service.security');
    }
    
    /**
     * Evalua la seguridad de la seccion
     * @param Request $request
     */
    private function checkSecurity(Request $request,$rol = null)
    {
        if($rol === null){
            $level = $request->get('level');
            if(isset(self::$levels[$level])){
                $rol = self::$levels[$level];
            }
        }
        $this->getSecurityService()->checkSecurity($rol);
    }
    
    /**
     * 
     * @return \Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    private function getEventDispatcher()
    {
        return $this->container->get('event_dispatcher');
    }
}
