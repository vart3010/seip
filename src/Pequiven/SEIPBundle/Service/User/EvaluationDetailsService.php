<?php

namespace Pequiven\SEIPBundle\Service\User;


/**
 * Servicio que se encarga de actualizar los detalles de la evaluación del usuario
 * 
 * service (seip.service.evaluation_details)
 */
class EvaluationDetailsService implements \Symfony\Component\DependencyInjection\ContainerAwareInterface {
    protected $container;
    
    const RESULT_OK = 1;
    const RESULT_NO_ITEMS = 2;
    const RESULT_NUM_PERSONAL_NOT_EXIST = 3;
    const RESULT_INVALID_CONFIGURATION = 4;
    /**
     * No tiene auditoria
     */
    const RESULT_NO_AUDIT = 5;
    private $errors;
    
    function refreshValueEvaluation(\Pequiven\SEIPBundle\Entity\User $user, \Pequiven\SEIPBundle\Entity\Period $period)
    {
        
        $this->errors= array();
//        $numPersonal = $request->get('numPersonal');
//        $periodName = $request->get('period');
        $status = self::RESULT_OK;

        $criteria = $arrangementPrograms = $objetives = $goals = $arrangementProgramsForObjetives = $objetivesOO = $objetivesOT = $objetivesOE = array();
        
        $periodActual = $period;
        $canBeEvaluated = $isValidAudit = true;
        $sumResult = 0.0;
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
                
                $sumResult = $arrangementProgram->getUpdateResultByAdmin() ? $sumResult + $arrangementProgram->getResultModified() : $sumResult + $arrangementProgram->getResult();
                        
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
                $objetivesStrategic = $this->container->get('pequiven.repository.objetive')->findAllStrategicByPeriod($period);
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
                
                $sumResult = $objetive->getUpdateResultByAdmin() ? $sumResult + $objetive->getResultModified() : $sumResult + $objetive->getResult();
                
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
                if($objetive->getObjetiveLevel()->getLevel() == \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_OPERATIVO){
                    $objetivesOO[$objetive->getId()] = $data;
                }else if($objetive->getObjetiveLevel()->getLevel() == \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_TACTICO){
                    $objetivesOT[$objetive->getId()] = $data;
                }else if($objetive->getObjetiveLevel()->getLevel() == \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_ESTRATEGICO){
                    $objetivesOE[$objetive->getId()] = $data;
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
                
                $sumResult = $goal->getUpdateResultByAdmin() ? $sumResult + $goal->getResultModified() : $sumResult + $goal->getResult();
                
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
            }

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
        
        $em = $this->getDoctrine()->getManager();
        $evaluationDetailsRepository = $this->container->get('pequiven.repository.evaluation_details');
        $evaluationDetailsObject = $evaluationDetailsRepository->findBy(array('user' => $user->getId(), 'period' => $period->getId()));
        
        if(!$evaluationDetailsObject){
            $evaluationDetails = new \Pequiven\SEIPBundle\Entity\User\EvaluationDetails();
        } else{
            $evaluationDetails = $evaluationDetailsObject[0];
        }
        
        if(!$canBeEvaluated || count($this->errors) > 0){
            $evaluationDetails->setError(1);
        }
        
        $levelRealUser = $user->getLevelRealByGroup();
        $groups = $user->getGroups();
        foreach ($groups as $group) {
            if($group->getLevel() == $levelRealUser){
                $rolReal = $group;
                break;
            }
        }
        
        $evaluationDetails->setRole($rolReal);
        $evaluationDetails->setUser($user);
        $evaluationDetails->setPeriod($period);
        if($user->getComplejo()){
            $evaluationDetails->setLocation($user->getComplejo());
        }
        if($user->getGerencia()){
            $evaluationDetails->setGerencia($user->getGerencia());
        }
        if($user->getGerenciaSecond()){
            $evaluationDetails->setGerenciaSecond($user->getGerenciaSecond());
        }
        $evaluationDetails->setQuantityItems($totalItems);
        $evaluationDetails->setSumResult($sumResult);
        
        $em->persist($evaluationDetails);
        
        $em->flush();
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
    
    private function addErrorTrans($error,array $parameters = array()) {
        if(is_array($error)){
            $this->errors = array_merge($this->errors,$error);
        }else{
            $message = $this->trans($error,$parameters,'PequivenSEIPBundle');
            $this->errors[md5($message)] = $message;
        }
    }
    
    /**
     * Generates a URL from the given parameters.
     *
     * @param string         $route         The name of the route
     * @param mixed          $parameters    An array of parameters
     * @param bool|string    $referenceType The type of reference (one of the constants in UrlGeneratorInterface)
     *
     * @return string The generated URL
     *
     * @see UrlGeneratorInterface
     */
    protected function generateUrl($route, $parameters = array(), $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH) {
        return $this->container->get('router')->generate($route, $parameters, $referenceType);
    }
    
    /**
     * Servicio de resultados
     * @return \Pequiven\SEIPBundle\Service\ResultService
     */
    private function getResultService(){
        return $this->container->get('seip.service.result');
    }
    
    /**
     * Shortcut to return the Doctrine Registry service.
     *
     * @return \Doctrine\Bundle\DoctrineBundle\Registry
     *
     * @throws \LogicException If DoctrineBundle is not available
     */
    protected function getDoctrine() {
        if (!$this->container->has('doctrine')) {
            throw new \LogicException('The DoctrineBundle is not registered in your application.');
        }

        return $this->container->get('doctrine');
    }
    
    protected function trans($id,array $parameters = array(), $domain = 'messages')
    {
        return $this->container->get('translator')->trans($id, $parameters, $domain);
    }
    
    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
        $this->container = $container;
    }
    
}