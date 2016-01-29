<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Controller\Api;

/**
 * API de Resultados
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class ResultApiController extends \FOS\RestBundle\Controller\FOSRestController
{
    const RESULT_OK = 1;
    const RESULT_NO_ITEMS = 2;
    const RESULT_NUM_PERSONAL_NOT_EXIST = 3;
    const RESULT_INVALID_CONFIGURATION = 4;
    /**
     * No tiene auditoria
     */
    const RESULT_NO_AUDIT = 5;
    
    private $errors;
    
    private function addErrorTrans($error,array $parameters = array()) {
        if(is_array($error)){
            $this->errors = array_merge($this->errors,$error);
        }else{
            $message = $this->trans($error,$parameters,'PequivenSEIPBundle');
            $this->errors[md5($message)] = $message;
        }
    }
    function getUserItemsAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $this->errors= array();
        $numPersonal = $request->get('numPersonal');
        $periodName = $request->get('period');
        $status = self::RESULT_OK;

        $criteria = $arrangementPrograms = $objetives = $goals = $arrangementProgramsForObjetives = $objetivesOO = $objetivesOT = $objetivesOE = array();
        
        if($periodName === null){
            $this->addErrorTrans('pequiven_seip.errors.you_must_specify_the_period_inquiry');
        }
        if($numPersonal === null){
            $this->addErrorTrans('pequiven_seip.errors.you_must_specify_number_staff_consult');
        }
        
        $period = $this->container->get('pequiven.repository.period')->findOneBy(array(
            'name' => $periodName,
        ));
        
        $user = $this->get('pequiven_seip.repository.user')->findUserByNumPersonal($numPersonal);
        
        if(!$user && $numPersonal != ''){
            $this->addErrorTrans('pequiven_seip.errors.the_number_staff_does_not_exist',array(
                '%numPersonal%' => $numPersonal,
            ));
            $status = self::RESULT_NUM_PERSONAL_NOT_EXIST;
        }
        
        if($periodName != '' && !$period){
            $this->addErrorTrans('pequiven_seip.errors.the_period_does_not_exist',array(
                '%period%' => $periodName
            ));
        }
        
        $periodActual = $period;
        $canBeEvaluated = $isValidAudit = true;
        if(count($this->errors) == 0){
            //Repositorios
            $goalRepository = $this->container->get('pequiven_seip.repository.arrangementprogram_goal');
            $arrangementProgramRepository = $this->container->get('pequiven_seip.repository.arrangementprogram');
            $allArrangementPrograms = $arrangementProgramsObjects = $allIndicators = array();

            //Programas de gestion donde es responsable
            $arrangementProgramsGoals = $arrangementProgramRepository->findByUserAndPeriodNotGoals($user,$period,$criteria);
            foreach ($arrangementProgramsGoals as $arrangementProgramsGoal) {
                $arrangementProgramsObjects[$arrangementProgramsGoal->getId()] = $arrangementProgramsGoal;
                $allArrangementPrograms[$arrangementProgramsGoal->getId()] = $arrangementProgramsGoal;
                $arrangementProgramsForObjetives[$arrangementProgramsGoal->getId()] = $arrangementProgramsGoal;
            }

            //Metas de otros programa de gestion donde no es reponsable
            $goalsNotResponsible = $goalRepository->findGoalsByUserAndPeriod($user,$period,$criteria);
            foreach ($goalsNotResponsible as $goal) {
                $goals[$goal->getId()] = $goal;
                $arrangementProgram = $goal->getTimeline()->getArrangementProgram();
                $arrangementProgramsForObjetives[$arrangementProgram->getId()] = $arrangementProgram;
                $allArrangementPrograms[$arrangementProgram->getId()] = $arrangementProgram;
            }
            $this->getObjetiveFromPrograms($arrangementProgramsForObjetives, $objetives);
            
            foreach ($arrangementProgramsObjects as $key => $arrangementProgram) {
                $period = $arrangementProgram->getPeriod();
                
                $summary = $arrangementProgram->getSummary();
                
                $planDateStart = $summary['dateStartPlanned'];
                $planDateEnd = $summary['dateEndPlanned'];
                
                $realDateStart = $summary['dateStartReal'];
                $realDateEnd = $summary['dateEndReal'];
                        
                $arrangementPrograms[$key] = array(
                    'id' => sprintf('PG-%s',$arrangementProgram->getId()),
                    'description' => $arrangementProgram->getRef(),
                    'result' => $arrangementProgram->getUpdateResultByAdmin() ? $this->formatResult($arrangementProgram->getResultModified()) : $this->formatResult($arrangementProgram->getResult()),
                    'dateStart' => array(
                        'plan' => $this->formatDateTime($planDateStart),
                        'real' => $this->formatDateTime($realDateStart)
                    ),
                    'dateEnd' => array(
                        'plan' => $this->formatDateTime($planDateEnd),
                        'real' => $this->formatDateTime($realDateEnd)
                    ),
                );
            }
            
            $gerenciaFirst = $user->getGerencia();
            $gerenciaSecond = $user->getGerenciaSecond();
            
            if($gerenciaFirst && $gerenciaFirst->isValidAudit() === false){
               $isValidAudit = false; 
               $this->addErrorTrans('pequiven_seip.errors.the_first_line_management_no_audit',array("%gerenciaFirst%" => $gerenciaFirst));
               $status = self::RESULT_NO_AUDIT;
            }
            if($gerenciaSecond && $gerenciaSecond->isValidAudit() === false){
               $isValidAudit = false; 
               $this->addErrorTrans('pequiven_seip.errors.the_second_line_management_no_audit',array("%gerenciaSecond%" => $gerenciaSecond->getGerencia()));
               $status = self::RESULT_NO_AUDIT;
            }

            if(($user->getLevelRealByGroup() == \Pequiven\MasterBundle\Model\Rol::ROLE_MANAGER_FIRST ) || $user->getLevelRealByGroup() == \Pequiven\MasterBundle\Model\Rol::ROLE_GENERAL_COMPLEJO) {
                if($gerenciaFirst){
                    foreach ($gerenciaFirst->getTacticalObjectives() as $objetive) {
                        if($objetive->getObjetiveLevel()->getLevel() == \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_TACTICO){
                            if($objetive->getPeriod()->getId() == $periodActual->getId()){
                                $objetives[$objetive->getId()] = $objetive;
                            }
                        }
                    }
                }else{
                    $this->addErrorTrans('pequiven_seip.errors.the_user_is_not_assigned_first_line_management',array(
                        '%user%' => $user,
                    ));
                    $status = self::RESULT_INVALID_CONFIGURATION;
                }
            } else if($user->getLevelRealByGroup() == \Pequiven\MasterBundle\Model\Rol::ROLE_MANAGER_SECOND) {
                if($gerenciaSecond){
                    foreach ($gerenciaSecond->getOperationalObjectives() as $objetive) {
                        if($objetive->getPeriod()->getId() == $periodActual->getId()){
                            $objetives[$objetive->getId()] = $objetive;
                        }
                    }
                }else{
                    $this->addErrorTrans('pequiven_seip.errors.the_user_is_not_assigned_second_line_management',array(
                        '%user%' => $user,
                    ));
                    $status = self::RESULT_INVALID_CONFIGURATION;
                }
            }else if($user->getLevelRealByGroup() == \Pequiven\MasterBundle\Model\Rol::ROLE_DIRECTIVE){
                $objetivesStrategic = $this->get('pequiven.repository.objetive')->findAllStrategicByPeriod($period);
                foreach ($objetivesStrategic as $objetive) {
                    if($objetive->getPeriod()->getId() == $periodActual->getId()){
                        $objetives[$objetive->getId()] = $objetive;
                    }
                }
            }
            
            //Recorrer todos los objetivos
            foreach ($objetives as $key => $objetive) {
                $period = $objetive->getPeriod();
                $planDateStart = $period->getDateStart();
                $planDateEnd = $period->getDateEnd();
                
                foreach ($objetive->getArrangementPrograms() as $arrangementProgram) {
                    $allArrangementPrograms[$arrangementProgram->getId()] = $arrangementProgram;
                }
                foreach ($objetive->getIndicators() as $indicator) {
                    $allIndicators[$indicator->getId()] = $indicator;
                }
                
                $data = array(
                    'id' => sprintf('OB-%s',$objetive->getId()),
                    'description' => $objetive->getDescription(),
                    'result' => $objetive->getUpdateResultByAdmin() ? $this->formatResult($objetive->getResultModified()) : $this->formatResult($objetive->getResult()),
                    'dateStart' => array(
                        'plan' => $this->formatDateTime($planDateStart),
                        'real' => $this->formatDateTime($planDateStart)
                    ),
                    'dateEnd' => array(
                        'plan' => $this->formatDateTime($planDateEnd),
                        'real' => $this->formatDateTime($planDateEnd)
                    ),
                );
                if ($objetive->getObjetiveLevel()->getLevel() == \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_OPERATIVO) {
                    if ($objetive->getgerencia() == $user->getgerencia()) {
                        $objetivesOO[$objetive->getId()] = $data;
                    }
                } else if ($objetive->getObjetiveLevel()->getLevel() == \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_TACTICO) {
                    if ($objetive->getgerencia() == $user->getgerencia()) {
                        $objetivesOT[$objetive->getId()] = $data;
                    }
                } else if ($objetive->getObjetiveLevel()->getLevel() == \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_ESTRATEGICO) {
                    if ($objetive->getgerencia() == $user->getgerencia()) {
                        $objetivesOE[$objetive->getId()] = $data;
                    }
                }
            }

            foreach ($goals as $key => $goal)
            {
                $goalDetails = $goal->getGoalDetails();
                $summary = $goalDetails->getSummary();
                
                $planDateStart = $goal->getStartDate();
                $realDateStart = clone($planDateStart);
                $realDateStart->setDate($realDateStart->format('Y'), $summary['realMonthDateStart'], 1);
                
                $planDateEnd = $goal->getEndDate();
                $realDateEnd = clone($planDateEnd);
                $realDateEnd->setDate($realDateEnd->format('Y'), $summary['realMonthDateEnd'], \Pequiven\SEIPBundle\Service\ToolService::getLastDayMonth($realDateEnd->format('Y'), $summary['realMonthDateEnd']));
                
                $goals[$key] = array(
                    'id' => sprintf('ME-%s',$goal->getId()),
                    'description' => $goal->getName(),
                    'result' => $goal->getUpdateResultByAdmin() ? $this->formatResult($goal->getResultModified()) : $this->formatResult($goal->getResult()),
                    'dateStart' => array(
                        'plan' => $this->formatDateTime($planDateStart),
                        'real' => $this->formatDateTime($realDateStart)
                    ),
                    'dateEnd' => array(
                        'plan' => $this->formatDateTime($planDateEnd),
                        'real' => $this->formatDateTime($realDateEnd)
                    ),
                );
            }
            $referenceType = \Symfony\Component\Routing\Generator\UrlGeneratorInterface::ABSOLUTE_URL;
            foreach ($allArrangementPrograms as $arrangementProgram) {
                $details = $arrangementProgram->getDetails();
                $url = $this->generateUrl('pequiven_seip_arrangementprogram_show',
                    array(
                        'id' => $arrangementProgram->getId()
                    ),$referenceType
                );
                $link = sprintf('<a href="%s" target="_blank">%s</a>',$url,$arrangementProgram);
                //Se evalua que la notificacion no este en progeso
                if($details->getNotificationInProgressByUser() !== null){
                    $this->addErrorTrans('pequiven_seip.errors.user_must_complete_notification_process_management_program',array(
                        '%user%' => $details->getNotificationInProgressByUser(),
                        '%arrangementProgram%' => $link,
                    ));
                    $canBeEvaluated = false;
                    continue;
                }
                //Se evalua que no tenga avance cargado
//                if($details->getLastNotificationInProgressByUser()  === null && $arrangementProgram->getResult() == 0){
//                    $this->addErrorTrans('pequiven_seip.errors.the_management_program_does_not_progress_loaded',array(
//                        '%arrangementProgram%' => $link,
//                    ));
//                    $canBeEvaluated = false;
//                }
            }
            
//            Se comento para no evaluar los indicadores en cero
//            foreach ($allIndicators as $indicator) {
//                if($indicator->hasNotification() === false){
//                    $url = $this->generateUrl('pequiven_indicator_show',
//                        array(
//                            'id' => $indicator->getId()
//                        ),\Symfony\Component\Routing\Generator\UrlGeneratorInterface::ABSOLUTE_URL
//                    );
//                    $link = sprintf('<a href="%s" target="_blank">%s</a>',$url,$indicator);
//                    $this->addErrorTrans('pequiven_seip.errors.the_indicator_has_not_loaded_values',array(
//                        '%indicator%' => $link,
//                    ));
//                    $canBeEvaluated = false;
//                }
//            }

            $resultService = $this->getResultService();
            $isValidAdvance = $resultService->validateAdvanceOfObjetives($objetives);
            if(!$isValidAdvance){
                $canBeEvaluated = $isValidAdvance;
                $this->addErrorTrans($resultService->getErrors());
            }

            //Se evalua que tenga por lo menos un item
            if(count($goals) == 0 && count($arrangementPrograms) == 0 && count($objetives) == 0){
                $canBeEvaluated = false;
                $this->addErrorTrans('pequiven_seip.errors.user_has_no_associated_items_evaluation',array(
                    '%user%' => $user,
                ));
                $status = self::RESULT_NO_ITEMS;
            }
        }//endif if count errors
        
        $totalItems = count($goals) + count($arrangementPrograms) + count($objetivesOO) + count($objetivesOT) + count($objetivesOE);
        
        if($totalItems == 0){
            $canBeEvaluated = false;
            $this->addErrorTrans('pequiven_seip.errors.user_not_quantity_items',array(
                '%user%' => $user,
            ));
        }
        if(!$canBeEvaluated || count($this->errors) > 0){
            $goals = $arrangementPrograms = $objetives = $objetivesOO = $objetivesOT = $objetivesOE = array();
        }
        
        $data = array(
            'data' => array(
                'user' => $user,
                'evaluation' => array(
                    'management' => array(
                        'goals' => $goals,
                        'arrangementPrograms' => $arrangementPrograms,
                    ),
                    'results' => array(
                        'objetives' => array(
                            'OO' => $objetivesOO,
                            'OT' => $objetivesOT,
                            'OE' => $objetivesOE,
                        ),
                    ),
                ),
                'quantityItems' => $totalItems,
            ),
            'status' => $status,
            'errors' => $this->errors,
            'success' => true,
        );
        if(!$canBeEvaluated || count($this->errors) > 0){
            $data['success'] = false;
        }
        $view = $this->view($data);
        $view->getSerializationContext()->setGroups(array('api_list','api_result','sonata_api_read'));
        
        return $this->handleView($view);
    }
    
    
    function getItemsSaiAction(\Symfony\Component\HttpFoundation\Request $request){
        
        $this->errors= array();
        $periodName = $request->get('period');
        $typeGerencia = $request->get('typeGerencia');
        $codeGerencia = $request->get('codeGerencia');

        $objetives = $objetivesOO = $objetivesOT = $objetivesOE = array();
        
        if($periodName === null){
            $this->addErrorTrans('pequiven_seip.errors.you_must_specify_the_period_inquiry');
        }
        if($typeGerencia === null){
            $this->addErrorTrans('pequiven_seip.errors.you_must_specify_type_gerencia');
        }
        if($codeGerencia === null){
            $this->addErrorTrans('pequiven_seip.errors.you_must_specify_code_gerencia');
        }
        
        $period = $this->container->get('pequiven.repository.period')->findOneBy(array(
            'name' => $periodName,
        ));
        if($typeGerencia == 1){
            $gerencia = $this->container->get('pequiven.repository.gerenciafirst')->findOneBy(array(
                'abbreviation' => $codeGerencia,
            ));
        } else{
            $gerencia = $this->container->get('pequiven.repository.gerenciasecond')->findOneBy(array(
                'abbreviation' => $codeGerencia,
            ));
        }
        
        $periodActual = $period;
        $totalItems = 0;
        
        if($typeGerencia == 1){
            foreach ($gerencia->getTacticalObjectives() as $objetive) {
//                if($objetive->getObjetiveLevel()->getLevel() == \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_TACTICO){
                if($objetive->getPeriod()->getId() == $periodActual->getId()){
                    $objetives[$objetive->getId()] = $objetive;
                }
//                }
            }
        } else{
            foreach ($gerencia->getOperationalObjectives() as $objetive) {
                if($objetive->getPeriod()->getId() == $periodActual->getId()){
                    $objetives[$objetive->getId()] = $objetive;
                }
            }
        }

//        $objetivesStrategic = $this->get('pequiven.repository.objetive')->findAllStrategicByPeriod($period);
//        foreach ($objetivesStrategic as $objetive) {
//            if($objetive->getPeriod()->getId() == $periodActual->getId()){
//                $objetives[$objetive->getId()] = $objetive;
//            }
//        }
        
        //Recorrer todos los objetivos
        foreach ($objetives as $key => $objetive) {
            $period = $objetive->getPeriod();

            $data = array(
                'ref' => sprintf('OB-%s',$objetive->getRef()),
                'description' => $objetive->getDescription(),
//                'result' => $objetive->getUpdateResultByAdmin() ? $this->formatResult($objetive->getResultModified()) : $this->formatResult($objetive->getResult()),
                'result' => $this->formatResult($objetive->getResult()),
                'level' => $objetive->getObjetiveLevel()->getDescription(),
//                'dateStart' => array(
//                    'plan' => $this->formatDateTime($planDateStart),
//                    'real' => $this->formatDateTime($planDateStart)
//                ),
//                'dateEnd' => array(
//                    'plan' => $this->formatDateTime($planDateEnd),
//                    'real' => $this->formatDateTime($planDateEnd)
//                ),
            );
            if($objetive->getObjetiveLevel()->getLevel() == \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_OPERATIVO){
                $objetivesOO[$objetive->getId()] = $data;
            }else if($objetive->getObjetiveLevel()->getLevel() == \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_TACTICO){
                $objetivesOT[$objetive->getId()] = $data;
            }else if($objetive->getObjetiveLevel()->getLevel() == \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_ESTRATEGICO){
                $objetivesOE[$objetive->getId()] = $data;
            }
            $totalItems++;
        }
        
        $data = array(
            'data' => array(
                'gerencia' => $gerencia->getDescription(),
                'performance' => array(
                    'objetives' => array(
                        'OO' => $objetivesOO,
                        'OT' => $objetivesOT,
                        'OE' => $objetivesOE,
                    ),
                ),
            'quantityItems' => $totalItems,
            ),
            'errors' => $this->errors,
            'success' => true,
        );
        
        $view = $this->view($data);
        $view->getSerializationContext()->setGroups(array('api_list','api_result','sonata_api_read'));
        
        return $this->handleView($view);
    }

    /**
     * Buscar objetivos del programa de gestion
     * @param type $arrangementPrograms
     * @param type $objetives
     */
    private function getObjetiveFromPrograms($arrangementPrograms,&$objetives) {
        foreach ($arrangementPrograms as $arrangementProgram) {
            $objetive = null;
            if($arrangementProgram->getType() == \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_OPERATIVE){
                $objetive = $arrangementProgram->getOperationalObjective();
            }elseif ($arrangementProgram->getType() == \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_TACTIC) {
                $objetive = $arrangementProgram->getTacticalObjective();
            }
            if($objetive){
                $objetives[$objetive->getId()] = $objetive;
            }
        }
    }
    
    /**
     * Formatea los decimales antes de enviar los resultados.
     * @param type $result
     * @return type
     */
    private function formatResult($result){
        return number_format($result,2);
    }
    
    /**
     * Formatea la fecha antes de enviarla en la api.
     * 
     * @param type $date
     * @return type
     */
    private function formatDateTime($date) {
        $r = '';
        if(is_a($date, 'DateTime')){
            $r = $date->format('d-m-Y');
        }else{
            $r = $date;
        }
        return $r;
    }

    /**
     * Servicio de resultados
     * @return \Pequiven\SEIPBundle\Service\ResultService
     */
    private function getResultService(){
        return $this->container->get('seip.service.result');
    }
    
    protected function trans($id,array $parameters = array(), $domain = 'messages')
    {
        return $this->get('translator')->trans($id, $parameters, $domain);
    }
}