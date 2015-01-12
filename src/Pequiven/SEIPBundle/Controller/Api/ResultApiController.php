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
 * Description of ResultAPIController
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
        
        //Repositorios
        $goalRepository = $this->container->get('pequiven_seip.repository.arrangementprogram_goal');
        $arrangementProgramRepository = $this->container->get('pequiven_seip.repository.arrangementprogram');
        
        $criteria = $arrangementPrograms = array();
        $objetives = array();
        $goals = array();
        
        //Programas de gestion donde es responsable
        $arrangementProgramsGoals = $arrangementProgramRepository->findByUserAndPeriodNotGoals($user,$period,$criteria);
        foreach ($arrangementProgramsGoals as $arrangementProgramsGoal) {
            $arrangementPrograms[$arrangementProgramsGoal->getId()] = $arrangementProgramsGoal;
        }
        
        //Metas de otros programa de gestion donde no es reponsable
        $goalsNotResponsible = $goalRepository->findGoalsByUserAndPeriod($user,$period,$criteria);
        foreach ($goalsNotResponsible as $goal) {
            $goals[$goal->getId()] = $goal;
            $arrangementProgram = $goal->getTimeline()->getArrangementProgram();
            $arrangementPrograms[$arrangementProgram->getId()] = $arrangementProgram;
        }
        $this->getObjetiveFromPrograms($arrangementPrograms, $objetives);
        
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
        
        $data = array(
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
