<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Service;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Exception;
use LogicException;
use Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram;
use Pequiven\IndicatorBundle\Entity\Indicator;
use Pequiven\MasterBundle\Entity\Rol;
use Pequiven\ObjetiveBundle\Entity\Objetive;
use Pequiven\SIGBundle\Entity\ManagementSystem;
use Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle;
use Pequiven\SEIPBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Servicio para evaluar la seguridad en la aplicacion (seip.service.security)
 * 
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class SecurityService implements ContainerAwareInterface
{
    private $container;
    
    /**
     * Lista de Métodos para validar
     * @return type
     */
    private function getMethodValidMap()
    {
        return array(
            'ROLE_SEIP_PRE_PLANNING_CREATE_TACTIC' => 'evaluatePrePlanning',
            'ROLE_SEIP_PRE_PLANNING_CREATE_OPERATIVE' => 'evaluatePrePlanning',
            
            'ROLE_SEIP_OBJECTIVE_VIEW_STRATEGIC' => 'evaluateStrategicObjetive',
            'ROLE_SEIP_OBJECTIVE_VIEW_TACTIC' => 'evaluateTacticObjetive',
            'ROLE_SEIP_OBJECTIVE_VIEW_OPERATIVE' => 'evaluateOperativeObjetive',
            'ROLE_SEIP_SIG_OBJECTIVE_VIEW_TACTIC' => 'evaluateTacticObjetiveSIG',
            'ROLE_SEIP_SIG_OBJECTIVE_VIEW_OPERATIVE' => 'evaluateTacticObjetiveSIG',
            
            'ROLE_SEIP_INDICATOR_VIEW_STRATEGIC' => 'evaluateStrategicIndicator',
            'ROLE_SEIP_INDICATOR_VIEW_TACTIC' => 'evaluateTacticIndicator',
            'ROLE_SEIP_INDICATOR_VIEW_OPERATIVE' => 'evaluateOperativeIndicator',
            'ROLE_SEIP_SIG_INDICATOR_VIEW' => 'evaluateSIGIndicator',
            
            'ROLE_SEIP_RESULT_VIEW_TACTIC' => 'evaluateTacticResult',
            'ROLE_SEIP_RESULT_VIEW_OPERATIVE' => 'evaluateTacticResult',
            
            'ROLE_SEIP_ARRANGEMENT_PROGRAM_VIEW_TACTIC' => 'evaluateTacticArrangementProgram',
            'ROLE_SEIP_ARRANGEMENT_PROGRAM_VIEW_OPERATIVE' => 'evaluateTacticArrangementProgram',
            'ROLE_SEIP_SIG_ARRANGEMENT_PROGRAM_VIEW_TACTIC' => 'evaluateTacticArrangementProgramSIG',
            'ROLE_SEIP_SIG_ARRANGEMENT_PROGRAM_VIEW_OPERATIVE' => 'evaluateTacticArrangementProgramSIG',
            
            'ROLE_SEIP_OBJECTIVE_EDIT_STRATEGIC' => 'evaluateObjetiveEdit',
            'ROLE_SEIP_OBJECTIVE_EDIT_TACTIC' => 'evaluateObjetiveEdit',
            'ROLE_SEIP_OBJECTIVE_EDIT_OPERATIVE' => 'evaluateObjetiveEdit',
            
            'ROLE_SEIP_OBJECTIVE_DELETE_STRATEGIC' => 'evaluateObjetiveDelete',
            'ROLE_SEIP_OBJECTIVE_DELETE_TACTIC' => 'evaluateObjetiveDelete',
            'ROLE_SEIP_OBJECTIVE_DELETE_OPERATIVE' => 'evaluateObjetiveDelete',
            
            'ROLE_SEIP_INDICATOR_EDIT_STRATEGIC' => 'evaluateIndicatorEdit',
            'ROLE_SEIP_INDICATOR_EDIT_TACTIC' => 'evaluateIndicatorEdit',
            'ROLE_SEIP_INDICATOR_EDIT_OPERATIVE' => 'evaluateIndicatorEdit',
            
            'ROLE_SEIP_INDICATOR_DELETE_STRATEGIC' => 'evaluateIndicatorDelete',
            'ROLE_SEIP_INDICATOR_DELETE_TACTIC' => 'evaluateIndicatorDelete',
            'ROLE_SEIP_INDICATOR_DELETE_OPERATIVE' => 'evaluateIndicatorDelete',
            
            'ROLE_SEIP_OBJECTIVE_APPROVED_STRATEGIC' => 'evaluateObjetiveApproved',
            'ROLE_SEIP_OBJECTIVE_APPROVED_TACTIC' => 'evaluateObjetiveApproved',
            'ROLE_SEIP_OBJECTIVE_APPROVED_OPERATIVE' => 'evaluateObjetiveApproved',
            
            'ROLE_SEIP_INDICATOR_APPROVED_STRATEGIC' => 'evaluateIndicatorApproved',
            'ROLE_SEIP_INDICATOR_APPROVED_TACTIC' => 'evaluateIndicatorApproved',
            'ROLE_SEIP_INDICATOR_APPROVED_OPERATIVE' => 'evaluateIndicatorApproved',
            
            'ROLE_SEIP_WORK_STUDY_CIRCLE_VIEW' => 'evaluateWorkStudyCircle',
        );
    }
    
    /**
     * Evalúa si el CET (Cualquier fase) puede ser visto
     * @param type $rol
     * @param WorkStudyCircle $workStudyCircle
     * @return boolean
     */
    function evaluateWorkStudyCircle($rol, WorkStudyCircle $workStudyCircle) 
    {
        $result = false;
        $user = $this->getUser();
        if($this->isGranted('ROLE_SEIP_WORK_STUDY_CIRCLES_VIEW_ALL_PHASE')){
            $result = true;
        }elseif($workStudyCircle->getPhase() == WorkStudyCircle::PHASE_ONE){
            if($workStudyCircle->getId() == $user->getWorkStudyCircle()->getId()){
                $result = true;
            }
        } elseif($workStudyCircle->getPhase() == WorkStudyCircle::PHASE_TWO || $workStudyCircle->getPhase() == WorkStudyCircle::PHASE_THREE || $workStudyCircle->getPhase() == WorkStudyCircle::PHASE_FOUR){
            foreach($user->getWorkStudyCircles() as $workStudyCircleObject){
                if($workStudyCircle->getId() == $workStudyCircleObject->getId()){
                    $result = true;
                }
            }
        }
        
        return $result;
    }
    
     /**
     * Evalúa si el Objetivo (cualquier nivel) puede ser aprobado
     * @param type $rol
     * @param Objetive $objetive
     * @return boolean
     */
    function evaluateObjetiveApproved($rol,Objetive $objetive) 
    {
        $result = false;
        if($objetive->getPeriod()->getParent() == null){
            if($objetive->getStatus() == Objetive::STATUS_DRAFT && $objetive->getPeriod()->isActive() === true){
                $result = true;
            } elseif($objetive->getStatus() == Objetive::STATUS_DRAFT){
                        $result = true;
                    } else{
                        $result = false;
                    }
                } else{
            if($objetive->getStatus() == Objetive::STATUS_DRAFT && $objetive->getPeriod()->isActive() === true){
                $result = true;
            } elseif($objetive->getStatus() == Objetive::STATUS_DRAFT && $objetive->getPeriod()->getParent()->isActive()){
                $result = true;            
            } else{
                $result = false;
            }
        }
        
        if($result == true){
            if($objetive->getObjetiveLevel()->getLevel() == \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_OPERATIVO){
                $totalParents = count($objetive->getParents());
                $contParents = 0;
                foreach ($objetive->getParents() as $parent){
                    if ($parent->getStatus() == Objetive::STATUS_APPROVED){
                        $contParents++;
                    }
                }
                if($contParents == $totalParents){
                    $result = true;
                } else{
                    $result = false;
                }
            } else{
                $result = true;
            }
        }
        
        return $result;
    }
    
    /**
     * Evalúa si el Indicador (cualquier nivel) puede ser aprobado
     * @param type $rol
     * @param Indicator $indicator
     * @return boolean
     */
    function evaluateIndicatorApproved($rol,Indicator $indicator)
    {
        $result = false;
        if($indicator->getPeriod()->getParent() == null){
            if($indicator->getStatus() == Indicator::STATUS_DRAFT && $indicator->getPeriod()->isActive() === true){
                $result = true;
            } elseif($indicator->getStatus() == Indicator::STATUS_DRAFT){
                $result = true;            
            } else{
                $result = false;
            }
        } else{
            if($indicator->getStatus() == Indicator::STATUS_DRAFT && $indicator->getPeriod()->isActive() === true){
                $result = true;
            } elseif($indicator->getStatus() == Indicator::STATUS_DRAFT && $indicator->getPeriod()->getParent()->isActive()){
                $result = true;            
            } else{
                $result = false;
            }
        }
        
        return $result;
    }
    
    /**
     * Evalúa si el Programa de Gestión (cualquier nivel) puede ser visto
     * @param type $rol
     * @param ArrangementProgram $arrangementProgram
     * @return boolean
     */
    private function evaluateTacticArrangementProgram($rol, ArrangementProgram $arrangementProgram)
    {
        $user = $this->getUser();
        $valid = false;
        $rol = $user->getLevelRealByGroup();
        if($rol === Rol::ROLE_DIRECTIVE){
            $valid = true;
        }else{
            if($arrangementProgram->getType() == ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_TACTIC){
                $objetive = $arrangementProgram->getTacticalObjective();
                $gerencia = $objetive->getGerencia();
                if($rol == Rol::ROLE_GENERAL_COMPLEJO && $gerencia->getComplejo() === $user->getComplejo()){
                    $valid = true;
                }elseif($rol == Rol::ROLE_MANAGER_FIRST && $gerencia === $user->getGerencia()){
                    $valid = true;
                }elseif(($rol == Rol::ROLE_MANAGER_SECOND || $rol == Rol::ROLE_SUPERVISER || $rol == Rol::ROLE_WORKER_PQV) && $gerencia === $user->getGerenciaSecond()->getGerencia()){
                    $valid = true;
                }
            }elseif($arrangementProgram->getType() == ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_OPERATIVE){
                $objetive = $arrangementProgram->getOperationalObjective();
                $gerenciaSecond = $objetive->getGerenciaSecond();
                $gerencia = $objetive->getGerencia();
                if($rol == Rol::ROLE_GENERAL_COMPLEJO && $gerencia->getComplejo() === $user->getComplejo()){
                    $valid = true;
                }elseif($rol == Rol::ROLE_MANAGER_FIRST && $gerencia === $user->getGerencia()){
                    $valid = true;
                }elseif(($rol == Rol::ROLE_MANAGER_SECOND || $rol == Rol::ROLE_SUPERVISER || $rol == Rol::ROLE_WORKER_PQV) && $gerenciaSecond === $user->getGerenciaSecond()){
                    $valid = true;
                }
            }
            
            if($valid === false){
                if($arrangementProgram->getType() == ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_TACTIC){
                    if($this->isGranted('ROLE_SEIP_ARRANGEMENT_PROGRAM_MANAGER_FIRST_CLONE_VIEW_TACTIC')){
                        $valid = true;
                    }
                }
                
                if($arrangementProgram->getType() == ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_OPERATIVE){
                    if($this->isGranted('ROLE_SEIP_ARRANGEMENT_PROGRAM_MANAGER_FIRST_CLONE_VIEW_OPERATIVE')){
                        $valid = true;
                    }
                }
                
                //Evaluo si soy responsable del programa de gestion
                if($arrangementProgram->getResponsibles()->contains($user) === true){
                    $valid = true;
                }
                //Evaluo sino estoy en algunas de las metas
                if($valid === false){
                    $goals = $arrangementProgram->getTimeline()->getGoals();
                    foreach ($goals as $goal) {
                        if($goal->getResponsibles()->contains($user) === true){
                            $valid = true;
                            break;
                        }
                    }
                }
                //Evaluo si tengo permisos para notificar el programa
                if($valid === false){
                    $period = $this->getPeriodService()->getPeriodActive();
                    $em = $this->getDoctrine()->getManager();
                    $criteria = array(
                        'ap.user' => $user,
                        'ap.period' => $period,
                        'ap.id' => $arrangementProgram,
                    );
                    $arrangementProgramRepository = $em->getRepository('Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram');
                    $paginator = $arrangementProgramRepository->createPaginatorByNotified($criteria);
                    if($paginator->getNbResults() > 0){
                        $valid = true;
                    }
                }
            }
        }
        if(!$valid){
            $this->checkSecurity();
        } else{
            return $valid;
        }
    }


    /**
     * Evalua que tambien se encuentre habilitado la pre-planificacion
     * @throws type
     */
    private function evaluatePrePlanning()
    {
        $seipConfiguration = $this->getSeipConfiguration();
        if($seipConfiguration->isEnablePrePlanning() === false){
            throw $this->createAccessDeniedHttpException($this->buildMessage('the_pre_planning_is_not_enabled', 'error'));
        }
    }

    /**
     * Evalúa si la persona tiene permiso para ver los resultados (Nivel Táctico o Nivel Operativo)
     * @param type $rol
     * @param type $entity
     */
    private function evaluateTacticResult($rol,$entity) 
    {
        $user = $this->getUser();
        $valid = false;
        $rol = $user->getLevelByGroup(\Pequiven\SEIPBundle\Model\Common\CommonObject::TYPE_LEVEL_USER_ALL);
        if($rol === Rol::ROLE_DIRECTIVE){
            $valid = true;
        }else{
            if(is_a($entity, 'Pequiven\MasterBundle\Entity\Gerencia')){
                $gerencia = $entity;
                if($rol == Rol::ROLE_GENERAL_COMPLEJO && $gerencia->getComplejo() === $user->getComplejo()){
                    $valid = true;
                }elseif($rol == Rol::ROLE_MANAGER_FIRST && $gerencia === $user->getGerencia()){
                    $valid = true;
                }elseif(($rol == Rol::ROLE_MANAGER_SECOND || $rol == Rol::ROLE_SUPERVISER || $rol == Rol::ROLE_WORKER_PQV) && $gerencia === $user->getGerenciaSecond()->getGerencia()){
                    $valid = true;
                }
            }elseif(is_a($entity, 'Pequiven\MasterBundle\Entity\GerenciaSecond')){
                $gerenciaSecond = $entity;
                $gerencia = $entity->getGerencia();
                if($rol == Rol::ROLE_GENERAL_COMPLEJO && $gerencia->getComplejo() === $user->getComplejo()){
                    $valid = true;
                }elseif($rol == Rol::ROLE_MANAGER_FIRST && $gerencia === $user->getGerencia()){
                    $valid = true;
                }elseif(($rol == Rol::ROLE_MANAGER_SECOND || $rol == Rol::ROLE_SUPERVISER || $rol == Rol::ROLE_WORKER_PQV) && $gerenciaSecond === $user->getGerenciaSecond()){
                    $valid = true;
                }
            }
        }
        if(!$valid){
            $this->checkSecurity();
        } else{
            return $valid;
        }
    }

    /**
     * Evalúa si el usuario tiene permiso para ver los Indicadores que pertenecen a SIG
     * @param type $rol
     * @param Indicator $indicator
     */
    private function evaluateSIGIndicator($rol, Indicator $indicator)
    {
        $user = $this->getUser();
        $valid = false;
        $rol = $user->getLevelRealByGroup();
        
        $managementSystems = $indicator->getManagementSystems();
        if(count($managementSystems) > 0){
            $valid = true;
        }

        return $valid;
    }
    
    /**
     * Evalúa si el usuario tiene permiso para ver los Indicadores Estratégicos
     * @param type $rol
     * @param Indicator $indicator
     */
    private function evaluateStrategicIndicator($rol, Indicator $indicator)
    {
        $user = $this->getUser();
        $valid = false;
        $rol = $user->getLevelRealByGroup();
        if($rol === Rol::ROLE_DIRECTIVE){
            $valid = true;
        }elseif($user->getId() == 1381 OR $user->getId() == 5318 OR $user->getId() == 1334 OR $user->getId() == 1338 OR $user->getId() == 1383 OR $user->getId() == 1385){
            
            foreach ($indicator->getObjetives() as $value) {
                foreach ($value->getLineStrategics() as $line) {
                    if($line->getId() === 2){
                        $valid = true;
                    }                                    
                }
            }

        }elseif($user->getId() == 871 OR $user->getId() == 887 OR $user->getId() == 4531){
            
            foreach ($indicator->getObjetives() as $value) {
                foreach ($value->getLineStrategics() as $line) {
                    if($line->getId() === 5){
                        $valid = true;
                    }                                    
                }
            }

        }else{
        }

        if(!$valid){
            $this->checkSecurity();
        } else{
            return $valid;
        }
    }
    
    /**
     * Evalúa si el usuario tiene permiso para ver los Indicadores Tácticos
     * @param type $rol
     * @param Indicator $indicator
     */
    function evaluateTacticIndicator($rol, Indicator $indicator)
    {
        $valid = false;
        $user = $this->getUser();
//        $rol = $user->getLevelRealByGroup();
        $rol = $user->getLevelAllByGroup();
        if($rol === Rol::ROLE_DIRECTIVE){
            $valid = true;
        }else{
            foreach ($indicator->getObjetives() as $objetive) {
                $gerencia = $objetive->getGerencia();
                if($rol == Rol::ROLE_GENERAL_COMPLEJO && $gerencia->getComplejo() === $user->getComplejo()){
                    $valid = true;
                }elseif($rol == Rol::ROLE_MANAGER_FIRST && $gerencia === $user->getGerencia()){
                    $valid = true;
                }elseif(($rol == Rol::ROLE_MANAGER_SECOND || $rol == Rol::ROLE_SUPERVISER || $rol == Rol::ROLE_WORKER_PQV) && $gerencia === $user->getGerenciaSecond()->getGerencia()){
                    $valid = true;
                }
                
                if($valid === true){
                    break;
                }
            }
        }
        
        if(!$valid){
            $this->checkSecurity();
        } else{
            return $valid;
        }
    }
    
    /**
     * Evalúa si el usuario tiene permiso para ver los Indicadores Operativos
     * @param type $rol
     * @param Indicator $indicator
     */
    function evaluateOperativeIndicator($rol, Indicator $indicator)
    {
        $valid = false;
        $user = $this->getUser();
        $rol = $user->getLevelRealByGroup();
        if($rol === Rol::ROLE_DIRECTIVE){
            $valid = true;
        }else{
            foreach ($indicator->getObjetives() as $objetive) {
                $gerenciaSecond = $objetive->getGerenciaSecond();
                $gerencia = $objetive->getGerencia();

                if($rol == Rol::ROLE_GENERAL_COMPLEJO && $gerencia->getComplejo() === $user->getComplejo()){
                    $valid = true;
                }elseif($rol == Rol::ROLE_MANAGER_FIRST && $gerencia === $user->getGerencia()){
                    $valid = true;
                }elseif(($rol == Rol::ROLE_MANAGER_SECOND || $rol == Rol::ROLE_SUPERVISER || $rol == Rol::ROLE_WORKER_PQV) && $gerenciaSecond === $user->getGerenciaSecond()){
                    $valid = true;
                }
                
                if($valid === true){
                    break;
                }
            }
        }
        
        if($this->isGranted('ROLE_SEIP_INDICATOR_VIEW_OPERATIVE')){
            $valid = true;
        }
        
        if(!$valid){
            $this->checkSecurity();
        } else{
            return $valid;
        }
    }
    
    /**
     * Evalúa si el usuario tiene permiso para ver los Objetivos Estratégicos
     * @param type $rol
     * @param Objetive $objetive
     */
    private function evaluateStrategicObjetive($rol, Objetive $objetive)
    {
        $user = $this->getUser();
        $valid = false;
        $rol = $user->getLevelRealByGroup();
        if($rol === Rol::ROLE_DIRECTIVE){
            $valid = true;
        }else{
        }
        if(!$valid){
            $this->checkSecurity();
        }
    }
    
    /**
     * Evalúa si el usuario tiene permiso para ver los Objetivos Tácticos
     * @param type $rol
     * @param Objetive $objetive
     * @return boolean
     */
    private function evaluateTacticObjetive($rol, Objetive $objetive)
    {
        $valid = false;
        $user = $this->getUser();
        $rol = $user->getLevelRealByGroup();
        
        if($rol === Rol::ROLE_DIRECTIVE){
            $valid = true;
        }else{
            $gerencia = $objetive->getGerencia();
            if($rol == Rol::ROLE_GENERAL_COMPLEJO && $gerencia->getComplejo() === $user->getComplejo()){
                $valid = true;
            }elseif($rol == Rol::ROLE_MANAGER_FIRST && $gerencia === $user->getGerencia()){
                $valid = true;
            }elseif(($rol == Rol::ROLE_MANAGER_SECOND || $rol == Rol::ROLE_SUPERVISER || $rol == Rol::ROLE_WORKER_PQV) && $gerencia === $user->getGerenciaSecond()->getGerencia()){
                $valid = true;
            }
        }
        if(!$valid){
            $this->checkSecurity();
        } else{
            return $valid;
        }
    }
    
    /**
     * Evalúa si el usuario tiene permiso para ver los Objetivos Tácticos
     * @param type $rol
     * @param Objetive $objetive
     * @return boolean
     */
    private function evaluateTacticObjetiveSIG($rol, Objetive $objetive)
    {
        $valid = false;
        $user = $this->getUser();
        $rol = $user->getLevelRealByGroup();
        
        if($objetive->getManagementSystems()){
            $valid = true;
        }
        
        if(!$valid){
            $this->checkSecurity();
        } else{
            return $valid;
        }
    }
    
    /**
     * Evalúa si el usuario tiene permiso para ver los Programas de Gestión SIG
     * @param type $rol
     * @param ArrangementProgram $arrangementProgram
     * @return boolean
     */
    private function evaluateTacticArrangementProgramSIG($rol, ArrangementProgram $arrangementProgram)
    {
        $valid = true;
        $user = $this->getUser();
        $rol = $user->getLevelRealByGroup();
        
        if($arrangementProgram->getCategoryArrangementProgram()->getId() == ArrangementProgram::ASSOCIATE_ARRANGEMENT_PROGRAM_SIG){
            $valid = true;
        }
        
        if(!$valid){
            $this->checkSecurity();
        } else{
            return $valid;
        }
    }
    
    /**
     * Evalúa si el usuario tiene permiso para ver los Objetivos Operativos
     * @param type $rol
     * @param Objetive $objetive
     * @return boolean
     */
    private function evaluateOperativeObjetive($rol, Objetive $objetive)
    {
        $user = $this->getUser();
        $rol = $user->getLevelRealByGroup();
        $valid = false;
        if($rol == Rol::ROLE_DIRECTIVE){
            $valid = true;
        }else{
            $gerenciaSecond = $objetive->getGerenciaSecond();
            $gerencia = $objetive->getGerencia();
            
            if($rol == Rol::ROLE_GENERAL_COMPLEJO && $gerencia->getComplejo() === $user->getComplejo()){
                $valid = true;
            }elseif($rol == Rol::ROLE_MANAGER_FIRST && $gerencia === $user->getGerencia()){
                $valid = true;
            }elseif(($rol == Rol::ROLE_MANAGER_SECOND || $rol == Rol::ROLE_SUPERVISER || $rol == Rol::ROLE_WORKER_PQV) && $gerenciaSecond === $user->getGerenciaSecond()){
                $valid = true;
            }
        }
        if(!$valid){
            $this->checkSecurity();
        } else{
            return $valid;
        }
    }
    
    /**
     * Evalúa si el usuario tiene permiso para editar un Objetivo (cualquier nivel)
     * @param type $rol
     * @param Objetive $objective
     * @return boolean
     */
    private function evaluateObjetiveEdit($rol,Objetive $objective)
    {
        $result = false;
        if($objective->getPeriod()->getParent() == null){
            if($objective->getPeriod()->isActive() === true){
                if($objective->getStatus() == Objetive::STATUS_DRAFT){
                    $result = true;
                }
            }else{
                $result = false;
            }
        } else{
            if($objective->getPeriod()->isActive() === true || $objective->getPeriod()->getParent()->isOpened() == true){
                if($objective->getStatus() == Objetive::STATUS_DRAFT){
                    $result = true;
                }
            }else{
                $result = false;
            }
        }
        return $result;
    }
    
    /**
     * Evalúa si el usuario tiene permiso para borrar un Objetivo (cualquier nivel)
     * @param type $rol
     * @param Objetive $objective
     * @return boolean
     */
    private function evaluateObjetiveDelete($rol,Objetive $objective)
    {
        $result = false;
        if($objective->getPeriod()->getParent() == null){
            if($objective->getPeriod()->isActive() === true){
                if($objective->getStatus() == Objetive::STATUS_DRAFT){
                    $result = true;
                }
            }else{
                $result = false;
            }
        } else{
            if($objective->getPeriod()->isActive() === true || $objective->getPeriod()->getParent()->isOpened() == true){
                if($objective->getStatus() == Objetive::STATUS_DRAFT){
                    $result = true;
                }
            }else{
                $result = false;
            }
        }
        return $result;
    }
    
    /**
     * Evalúa si el usuario tiene permiso para editar un Indicador (cualquier nivel)
     * @param type $rol
     * @param Indicator $indicator
     * @return boolean
     */
    private function evaluateIndicatorEdit($rol,  Indicator $indicator)
    {
        $indicatorService = $this->getIndicatorService();//Llamado al servicio
        
        $roleEditByLevel = array(
            \Pequiven\IndicatorBundle\Entity\IndicatorLevel::LEVEL_ESTRATEGICO => "ROLE_SEIP_INDICATOR_EDIT_STRATEGIC",
            \Pequiven\IndicatorBundle\Entity\IndicatorLevel::LEVEL_TACTICO => "ROLE_SEIP_INDICATOR_EDIT_TACTIC",
            \Pequiven\IndicatorBundle\Entity\IndicatorLevel::LEVEL_OPERATIVO => "ROLE_SEIP_INDICATOR_EDIT_OPERATIVE"
        );
       
        $value = $indicatorService->isIndicatorHasParents($indicator);//Llamando al metodo
        
        $result = false;
        if($indicator->getPeriod()->getParent() == null){
            if($indicator->getPeriod()->isActive() === true){
                if($this->isGranted($roleEditByLevel[$indicator->getIndicatorLevel()->getLevel()])){
                    if($indicator->getStatus() == Indicator::STATUS_DRAFT){
                        if ($value === false) {
                            if ($this->isGranted('ROLE_SEIP_PLANNING_INDICATOR_EDIT')) {
                                $result = true;
                            }else{
                                $result = false;                            
                            }
                        }else{
                            $result = true;                        
                        }
                    }
                }
            }else{
                $result = false;
            }     
        } else{
            if($indicator->getPeriod()->isActive() === true || $indicator->getPeriod()->getParent()->isOpened() == true){
                if($this->isGranted($roleEditByLevel[$indicator->getIndicatorLevel()->getLevel()])){
                    if($indicator->getStatus() == Indicator::STATUS_DRAFT){
                        if ($value === false) {
                            if ($this->isGranted('ROLE_SEIP_PLANNING_INDICATOR_EDIT')) {
                                $result = true;
                            }else{
                                $result = false;                            
                            }
                        }else{
                            $result = true;                        
                        }
                    }
                }
            }else{
                $result = false;
            }     
        }
           
        return $result;
    }
    
    /**
     * Evalúa si el usuario tiene permiso para borrar un Indicador (cualquier nivel)
     * @param type $rol
     * @param Indicator $indicator
     * @return boolean
     */
    private function evaluateIndicatorDelete($rol,  Indicator $indicator)
    {
        $roleDeleteByLevel = array(
            \Pequiven\IndicatorBundle\Entity\IndicatorLevel::LEVEL_ESTRATEGICO => "ROLE_SEIP_INDICATOR_DELETE_STRATEGIC",
            \Pequiven\IndicatorBundle\Entity\IndicatorLevel::LEVEL_TACTICO => "ROLE_SEIP_INDICATOR_DELETE_TACTIC",
            \Pequiven\IndicatorBundle\Entity\IndicatorLevel::LEVEL_OPERATIVO => "ROLE_SEIP_INDICATOR_DELETE_OPERATIVE"
        );
        
        $result = false;
        if($indicator->getPeriod()->getParent() == null){
            if($indicator->getPeriod()->isActive() === true){
                if($this->isGranted($roleDeleteByLevel[$indicator->getIndicatorLevel()->getLevel()])){
                    if($indicator->getStatus() == Indicator::STATUS_DRAFT){
                        $result = true;
                    }
                }
            }else{
                $result = false;
            }
        } else{
            if($indicator->getPeriod()->isActive() === true || $indicator->getPeriod()->getParent()->isOpened() == true){
                if($this->isGranted($roleDeleteByLevel[$indicator->getIndicatorLevel()->getLevel()])){
                    if($indicator->getStatus() == Indicator::STATUS_DRAFT){
                        $result = true;
                    }
                }
            }else{
                $result = false;
            }
        }
        return $result;
    }

    /**
     * Evalua que el usuario tenga acceso a la seccion especifica, ademas se valida con un segundo metodo
     * @param type $rol
     * @param type $parameters
     * @throws AccessDeniedHttpException
     */
    public function checkSecurity($rol = null,$parameters = null,$throwException = true) {
        if($rol === null){
            throw $this->createAccessDeniedHttpException($this->trans('pequiven_seip.security.permission_denied'));
        }
        $roles = $rol;
        if(!is_array($rol)){
            $roles = array($rol);
        }
        $valid = $this->isGranted($roles,$parameters);
        $quantityRoles = count($roles);
        foreach ($roles as $rol) {
            if(!$valid){
                if($throwException === true){
                    throw $this->createAccessDeniedHttpException($this->buildMessage($rol));
                }else{
                    return $valid;
                }
            }
            $methodValidMap = $this->getMethodValidMap();
            if($quantityRoles == 1 && isset($methodValidMap[$rol])){
                $method = $methodValidMap[$rol];
                $valid = call_user_func_array(array($this,$method),array($rol,$parameters));
                if(!$valid){
                    if($throwException === true){
                        throw $this->createAccessDeniedHttpException($this->buildMessage($rol));
                    }else{
                        return $valid;
                    }
                }
            }
        }
        return $valid;
    }
    
    public function checkMethodSecurity($rol = null,$parameters = null,$throwException = true){
        if($rol === null){
            throw $this->createAccessDeniedHttpException($this->trans('pequiven_seip.security.permission_denied'));
        }
        $roles = $rol;
        if(!is_array($rol)){
            $roles = array($rol);
        }
        $valid = false;
        $quantityRoles = count($roles);
        foreach ($roles as $rol) {
//            if(!$valid){
//                if($throwException === true){
//                    throw $this->createAccessDeniedHttpException($this->buildMessage($rol));
//                }else{
//                    return $valid;
//                }
//            }
            $methodValidMap = $this->getMethodValidMap();
            if($quantityRoles == 1 && isset($methodValidMap[$rol])){
                $method = $methodValidMap[$rol];
                $valid = call_user_func_array(array($this,$method),array($rol,$parameters));
                if(!$valid){
                    if($throwException === true){
                        throw $this->createAccessDeniedHttpException($this->buildMessage($rol));
                    }else{
                        return $valid;
                    }
                }
            }
        }
        return $valid;
    }
    
    /**
     * Genera el mensaje de error
     * @param type $rol
     * @param type $prefix
     * @return type
     */
    private function buildMessage($rol,$prefix = '403')
    {
        return $this->trans(sprintf('pequiven_seip.security.%s.%s', $prefix,strtolower($rol)));
    }

    /**
     * Returns a AccessDeniedHttpException.
     *
     * This will result in a 403 response code. Usage example:
     *
     *     throw $this->createAccessDeniedHttpException('Permission Denied!');
     *
     * @param string    $message  A message
     * @param Exception $previous The previous exception
     *
     * @return AccessDeniedHttpException
     */
    private function createAccessDeniedHttpException($message = 'Permission Denied!', Exception $previous = null)
    {
        $this->setFlash('error', $message);
        return new AccessDeniedHttpException($message, $previous);
    }
    
    protected function trans($id,array $parameters = array(), $domain = 'PequivenSEIPBundle')
    {
        return $this->container->get('translator')->trans($id, $parameters, $domain);
    }
    
    /**
     * Envia un mensaje flash
     * 
     * @param array $type success|error
     * @param type $message
     * @param type $parameters
     * @param type $domain
     * @return type
     */
    protected function setFlash($type,$message,$parameters = array(),$domain = 'flashes')
    {
        return $this->container->get('session')->getBag('flashes')->add($type,$message);
    }
    
    /**
     * 
     * @return SecurityContextInterface
     * @throws LogicException
     */
    protected function getSecurityContext()
    {
        if (!$this->container->has('security.context')) {
            throw new LogicException('The SecurityBundle is not registered in your application.');
        }

        return $this->container->get('security.context');
    }
    
     /**
     * Get a user from the Security Context
     *
     * @return User
     *
     * @throws LogicException If SecurityBundle is not available
     *
     * @see TokenInterface::getUser()
     */
    private function getUser()
    {
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
    
    function isGranted($roles,$object = null)
    {
        return $this->getSecurityContext()->isGranted($roles,$object);
    }
    
    function isGrantedFull($roles,$object = null)
    {
        return $this->checkSecurity($roles, $object,false);
    }
    
    /**
     * 
     * @return Configuration
     */
    private function getSeipConfiguration()
    {
        return $this->container->get('seip.configuration');
    }
    
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
    public function getDoctrine()
    {
        if (!$this->container->has('doctrine')) {
            throw new LogicException('The DoctrineBundle is not registered in your application.');
        }

        return $this->container->get('doctrine');
    }
    
    /**
     * 
     * @return PeriodService
     */
    public function getPeriodService()
    {
        return $this->container->get('pequiven_seip.service.period');
    }

    /**
     * 
     * @return \Pequiven\IndicatorBundle\Service\IndicatorService
     */
    protected function getIndicatorService() {
        return $this->container->get('pequiven_indicator.service.inidicator');
    }
}
