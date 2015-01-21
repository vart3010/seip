<?php

namespace Pequiven\ArrangementProgramBundle\Controller\Rest;

use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use Pequiven\ArrangementProgramBundle\Entity\ArrangementProgramTemplate;
use Pequiven\ArrangementProgramBundle\Form\GoalDetailsType;
use Pequiven\ArrangementProgramBundle\Model\GoalDetails;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Controlador rest de los programas de gestion
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 * @Route("/template/arrangement-program")
 */
class RestArrangementProgramTemplateController extends FOSRestController 
{
    /**
     * @Annotations\Get("/{id}/goals-details.{_format}",name="get_arrangementprogram_rest_arrangementprogram_template_goalsdetails",requirements={"_format"="html|json|xml"},defaults={"_format"="html"})
     */
    function getGoalsDetailsAction($id, Request $request) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PequivenArrangementProgramBundle:ArrangementProgramTemplate')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ArrangementProgramTemplate entity.');
        }
        $timeline = $entity->getTimeline();
        $data = array();
        foreach ($timeline->getGoals() as $goal) {
            $data[] = $goal->getGoalDetails();
        }

        $view = $this->view();
        $result = array(
            'data' => $data,
            'success' => true,
            'total' => count($data)
        );
        if ($request->get('_format') == 'html') {
//            $date = new DateTime();
//            $month = $date->format('m');
//            $percentaje = 0;
//            $propertyAccessor = \Symfony\Component\PropertyAccess\PropertyAccess::createPropertyAccessor();
//            foreach (GoalDetails::getMonthsPlanned() as $key => $monthGoal) {
//                if($month < $monthGoal){
//                    $percentaje = $propertyAccessor->getValue($object,$key);
//                }
//            }
//            foreach ($timeline->getGoals() as $goal) {
//                $goal->getGoalDetails()
//            }
//            foreach (GoalDetails::getMonthsPlanned() as $planned => $monthNumber) {
//                    $valuePlanned = $propertyAccessor->getValue($entity, $planned);
//                    $monthReal = GoalDetails::getMonthOfRealByMonth($monthNumber);
//                    $valueReal = $propertyAccessor->getValue($entity, $monthReal);
//                    if ($isEnabledEditByPlannedLoad && ($valuePlanned == '' || $valuePlanned == '0' || $valuePlanned === null)) {
//                        $propertyAccessor->setValue($entity, $monthReal, 0);
//                    } else if ($valueReal > $valuePlanned) {
//                        //Valida que el valor real no pueda ser mayor al planeado.
//                        if ($isAllowLoadingLongerThanPlannedRealValue === false) {
//                            $propertyAccessor->setValue($entity, $monthReal, $valuePlanned);
//                        }
//                    }
//                }
//          
            $result['monthsPlanned'] = GoalDetails::getMonthsPlanned();
        }
        $view->setData($result);
        $view->getSerializationContext()->setGroups(array('id', 'api_list', 'goal', 'goalDetails'));
        $view->setTemplate("PequivenArrangementProgramBundle:Rest:ArrangementProgramTemplate/form.html.twig");
        return $view;
    }

    /**
     * @Annotations\Put("/{id}/goals-details.{_format}/{slug}",name="put_arrangementprogram_rest_restarrangementprogram_template_goalsdetails",requirements={"_format"="html|json|xml"},defaults={"_format"="html"})
     */
    function putGoalsDetailsAction($id, Request $request, $slug) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PequivenArrangementProgramBundle:GoalDetails')->find($slug);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GoalDetails entity.');
        }
        $arrangementProgram = $entity->getGoal()->getTimeline()->getArrangementProgram();

        if ($arrangementProgram !== null) {
            throw new AccessDeniedException();
        }

        $form = $this->createForm(new GoalDetailsType(), $entity);
        $dataRequest = $request->request->all();

        unset($dataRequest['id']);
        unset($dataRequest['null']);
        
        $form->submit($dataRequest, false);
        $success = false;
        if ($form->isValid()) {
            //Habilitar limpiar los valores reales si el planeado se establecio en cero
            $isEnabledClearRealByPlannedEmpty = true;
            //Permitir cargar valor real mayor a planificado.
            $isAllowLoadingLongerThanPlannedRealValue = true;
            //Habilitar edicion del valor real dependiendo si la planeada no esta vacia
            $isEnabledEditByPlannedLoad = false;
            if ($isEnabledClearRealByPlannedEmpty === true) {
                $propertyAccessor = new PropertyAccessor();
                foreach (GoalDetails::getMonthsPlanned() as $planned => $monthNumber) {
                    $valuePlanned = $propertyAccessor->getValue($entity, $planned);
                    $monthReal = GoalDetails::getMonthOfRealByMonth($monthNumber);
                    $valueReal = $propertyAccessor->getValue($entity, $monthReal);
                    if ($isEnabledEditByPlannedLoad && ($valuePlanned == '' || $valuePlanned == '0' || $valuePlanned === null)) {
                        $propertyAccessor->setValue($entity, $monthReal, 0);
                    } else if ($valueReal > $valuePlanned) {
                        //Valida que el valor real no pueda ser mayor al planeado.
                        if ($isAllowLoadingLongerThanPlannedRealValue === false) {
                            $propertyAccessor->setValue($entity, $monthReal, $valuePlanned);
                        }
                    }
                }
            }
            //Habilitar limpiar los valores planeados no sobrepasen el 100% distribuido en todas las columnas
            $clearPlannedOnComplete = true;
            if ($clearPlannedOnComplete === true) {
                //Limite de porcentaje que se asigna al planeado
                $limitPlannedPercentaje = 100;
                $percentajeAcumulated = 0;
                $propertyAccessor = new PropertyAccessor();
                $disable = false;
                foreach (GoalDetails::getMonthsPlanned() as $planned => $monthNumber) {
                    $percentaje = $propertyAccessor->getValue($entity, $planned);
                    $percentajeAcumulated += $percentaje;
                    if ($disable) {
                        $propertyAccessor->setValue($entity, $planned, 0);
                        continue;
                    }
                    if ($percentajeAcumulated >= $limitPlannedPercentaje) {
                        $diff = $percentaje - ($percentajeAcumulated - $limitPlannedPercentaje);
                        $propertyAccessor->setValue($entity, $planned, $diff);
                        $disable = true;
                    }
                }
            }

            $em->persist($entity);
            $em->flush();
            $success = true;
        } else {
            $entity = $form;
        }

        $view = $this->view();
        $result = array(
            'data' => $entity,
            'success' => $success,
            'total' => 1,
            'messages' => 'Exitooooo'
        );
        $view->setData($result);
        $view->getSerializationContext()->setGroups(array('id', 'api_list', 'goal', 'goalDetails'));
        $view->setTemplate("PequivenArrangementProgramBundle:Rest:ArrangementProgramTemplate/form.html.twig");
        return $view;
    }
    
    /**
     * Manejador de programa de gestion
     * 
     * @return \Pequiven\ArrangementProgramBundle\Model\ArrangementProgramManager
     */
    private function getArrangementProgramManager()
    {
        return $this->get('seip.arrangement_program.manager');
    }
}
