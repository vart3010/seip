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

use Pequiven\MasterBundle\Entity\Rol;

/**
 * API de Resultados
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class ResultApiController extends \FOS\RestBundle\Controller\FOSRestController
{
    function getUserItemsAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $numPersonal = $request->get('numPersonal');
        $period = $this->container->get('pequiven.repository.period')->findOneActive();
        
        $user = $this->get('pequiven_seip.repository.user')->findUserByNumPersonal($numPersonal);
        if(!$user){
            throw $this->createNotFoundException(sprintf('El numero de personal "%s" no existe',$numPersonal));
        }
        $level = $user->getLevelRealByGroup();
        
        //Repositorios
        $goalRepository = $this->container->get('pequiven_seip.repository.arrangementprogram_goal');
        $arrangementProgramRepository = $this->container->get('pequiven_seip.repository.arrangementprogram');
        
        $criteria = $arrangementPrograms = $objetives = $goals = $arrangementProgramsForObjetives = array();
        
        //Programas de gestion donde es responsable
        $arrangementProgramsGoals = $arrangementProgramRepository->findByUserAndPeriodNotGoals($user,$period,$criteria);
        foreach ($arrangementProgramsGoals as $arrangementProgramsGoal) {
            $arrangementPrograms[$arrangementProgramsGoal->getId()] = $arrangementProgramsGoal;
            $arrangementProgramsForObjetives[$arrangementProgramsGoal->getId()] = $arrangementProgramsGoal;
        }
        
        //Metas de otros programa de gestion donde no es reponsable
        $goalsNotResponsible = $goalRepository->findGoalsByUserAndPeriod($user,$period,$criteria);
        foreach ($goalsNotResponsible as $goal) {
            $goals[$goal->getId()] = $goal;
            $arrangementProgram = $goal->getTimeline()->getArrangementProgram();
            $arrangementProgramsForObjetives[$arrangementProgram->getId()] = $arrangementProgram;
        }
        $this->getObjetiveFromPrograms($arrangementProgramsForObjetives, $objetives);
        
        $canBeEvaluated = true;
        $errors = array();
        $referenceType = \Symfony\Component\Routing\Generator\UrlGeneratorInterface::ABSOLUTE_URL;
        foreach ($arrangementProgramsForObjetives as $arrangementProgram) {
            $details = $arrangementProgram->getDetails();
            $url = $this->generateUrl('pequiven_seip_arrangementprogram_show',
                                array(
                                    'id' => $arrangementProgram->getId()
                                ),$referenceType
                            );
            $link = sprintf('<a href="%s" target="_blank">%s</a>',$url,$arrangementProgram);
            //Se evalua que la notificacion no este en progeso
            if($details->getNotificationInProgressByUser() !== null){
                $errors[] = sprintf('El usuario "%s" debe finalizar el proceso de notificación en el programa de gestión "%s".',$details->getNotificationInProgressByUser(),$link);
                $canBeEvaluated = false;
                continue;
            }
            //Se evalua que no tenga avance cargado
            if($details->getLastNotificationInProgressByUser()  === null && $arrangementProgram->getResult() == 0){
                $errors[] = sprintf('El programa de gestión "%s" no tiene avances cargados.',$link);
                $canBeEvaluated = false;
            }
        }
        
        foreach ($arrangementPrograms as $key => $arrangementProgram) {
            $arrangementPrograms[$key] = array(
                'id' => sprintf('PG-%s',$arrangementProgram->getId()),
                'description' => $arrangementProgram->getRef(),
                'result' => $this->formatResult($arrangementProgram->getResult()),
            );
        }
        
        foreach ($objetives as $key => $objetive) {
            $objetives[$key] = array(
                'id' => sprintf('OB-%s',$objetive->getId()),
                'description' => $objetive->getDescription(),
                'result' => $this->formatResult($objetive->getResult()),
            );
        }
        
        foreach ($goals as $key => $goal) {
            $goals[$key] = array(
                'id' => sprintf('ME-%s',$goal->getId()),
                'description' => $goal->getName(),
                'result' => $this->formatResult($goal->getGoalDetails()->getAdvance()),
            );
        }
        
        //Se evalua que tenga por lo menos un item
        if(count($goals) == 0 && count($arrangementPrograms) == 0 && count($objetives) == 0){
            $canBeEvaluated = false;
            $errors[] = sprintf('El usuario "%s" no tiene items asociados para su evaluación.',$user);
        }
        
        if(!$canBeEvaluated){
            $goals = $arrangementPrograms = $objetives = array();
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
                        'objetives' => $objetives,
                    ),
                ),
            ),
            'errors' => $errors,
            'success' => true,
        );
        if(!$canBeEvaluated){
            $data['success'] = false;
        }
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
                $objetive = $arrangementProgram->getOperationalObjective();
            }
            if($objetive){
                $objetives[$objetive->getId()] = $objetive;
            }
        }
    }
    
    private function formatResult($result){
        return number_format($result,3);
    }
}
