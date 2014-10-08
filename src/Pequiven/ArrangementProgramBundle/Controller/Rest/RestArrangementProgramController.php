<?php

namespace Pequiven\ArrangementProgramBundle\Controller\Rest;

use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use Pequiven\ArrangementProgramBundle\Form\GoalDetailsType;
use Pequiven\ArrangementProgramBundle\Model\GoalDetails;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccessor;

/**
 * Controlador rest de los programas de gestion
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 * @Route("/api/arrangement-program")
 */
class RestArrangementProgramController extends FOSRestController
{
    /**
     * @Annotations\Get("/{id}/goals-details.{_format}",name="get_arrangementprogram_rest_restarrangementprogram_putgoalsdetails",requirements={"_format"="html|json|xml"},defaults={"_format"="html"})
     */
    function getGoalsDetailsAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PequivenArrangementProgramBundle:ArrangementProgram')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ArrangementProgram entity.');
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
        $view->setData($result);
        $view->getSerializationContext()->setGroups(array('id','api_list','goal','goalDetails'));
        $view->setTemplate("PequivenArrangementProgramBundle:Rest:ArrangementProgram/form.html.twig");
        return $view;
    }
    
    /**
     * @Annotations\Put("/{id}/goals-details.{_format}/{slug}",name="put_arrangementprogram_rest_restarrangementprogram_putgoalsdetails",requirements={"_format"="html|json|xml"},defaults={"_format"="html"})
     */
    function putGoalsDetailsAction($id,Request $request,$slug) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PequivenArrangementProgramBundle:GoalDetails')->find($slug);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GoalDetails entity.');
        }
        $form = $this->createForm(new GoalDetailsType(),$entity);
        $dataRequest = $request->request->all();
        
        unset($dataRequest['id']);
        unset($dataRequest['null']);
        
        $form->submit($dataRequest,false);
        $success = false;
        if($form->isValid()){
            //Habilitar limpiar los valores reales si el planeado se establecio en cero
            $isEnabledClearRealByPlannedEmpty = true;
            if($isEnabledClearRealByPlannedEmpty === true){
                $propertyAccessor = new PropertyAccessor();
                foreach (GoalDetails::getMonthsPlanned() as $planned => $monthNumber) {
                    $value = $propertyAccessor->getValue($entity,$planned);
                    $monthReal = GoalDetails::getMonthOfRealByMonth($monthNumber);
                    if($value == '' || $value == '0' || $value === null){
                        $propertyAccessor->setValue($entity, $monthReal, 0);
                    }
                }
            }
            
            $em->persist($entity);
            $em->flush();
            $success = true;
        }else{
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
        $view->getSerializationContext()->setGroups(array('id','api_list','goal','goalDetails'));
        $view->setTemplate("PequivenArrangementProgramBundle:Rest:ArrangementProgram/form.html.twig");
        return $view;
    }
}
