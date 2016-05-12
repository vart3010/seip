<?php

namespace Pequiven\ArrangementProgramBundle\Controller\Rest;

use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram;
use Pequiven\ArrangementProgramBundle\Form\GoalDetailsType;
use Pequiven\ArrangementProgramBundle\Model\GoalDetails;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Pequiven\ArrangementProgramBundle\Entity\GoalDetailsInd;
use Pequiven\ArrangementProgramBundle\Form\GoalDetailsIndType;

/**
 * Controlador rest de Notificacion de los programas de gestion
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 * @Route("/arrangementprogram")
 */
class RestArrangementProgramController extends FOSRestController {

    /**
     * @Route("/{id}/{user}/goals-details.{_format}",name="get_arrangementprogram_rest_restarrangementprogram_getgoalsdetails",requirements={"_format"="html|json|xml"},defaults={"_format"="html"},options={"expose"=true})
     * @Method({"GET", "POST", "PUT"})       
     */
    function getGoalsDetailsAction($id, Request $request) {
// * @Annotations\Get("/{id}/goals-details.{_format}",name="get_arrangementprogram_rest_restarrangementprogram_getgoalsdetails",requirements={"_format"="html|json|xml"},defaults={"_format"="html"})     
// * @Annotations\Get("/{id}/goals-details.{_format}",name="get_arrangementprogram_rest_restarrangementprogram_getgoalsdetails",requirements={"_format"="html|json|xml"},defaults={"_format"="html"})
// * @Route("/{id}/{user}/goals-details.{_format}",name="get_arrangementprogram_rest_restarrangementprogram_getgoalsdetails",requirements={"_format"="html|json|xml"},defaults={"_format"="html"},options={"expose"=true})
// * @Method({"GET", "POST"})     

        if ($request->get('user') != null) {
            $user = $request->get('user');
        } else {
            $user = '0';
        }

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('PequivenArrangementProgramBundle:ArrangementProgram')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ArrangementProgram entity.');
        }

        $data = array();
        $responsibles = $em->getRepository('PequivenArrangementProgramBundle:Goal')->getGoalResponsiblesUserbyAP($id, $user);
        $userobj = $this->get('pequiven.repository.user')->findOneById($user);

        // SI SE ESCOGIO UN RESPONSABLE EN ESPECIFICO PARA NOTIFICAR 
        if ($user != '0') {
            $list = $em->getRepository('PequivenArrangementProgramBundle:Goal')->getGoalByResponsibleByAP($id, $user);
        } else {
            $list = $entity->getTimeline()->getGoals();
        }

        foreach ($list as $goal) {
            if ($user != 0) {
                $searchCriteria = array('goalDetails' => $goal->getGoalDetails(), 'user' => $userobj);
                $obj = $em->getRepository('PequivenArrangementProgramBundle:GoalDetailsInd')->findOneBy($searchCriteria);

                if ($obj) {
                    //SI HAY NOTIFICACIONES INDIVIDUALES SUSTITUYO EL VALOR GRUPAL POR EL INDIVIDUAL                    
                    if (($obj->getJanuaryReal()) != null) {
                        $goal->getGoalDetails()->setJanuaryReal($obj->getJanuaryReal());
                    }
                    if (($obj->getFebruaryReal()) != null) {
                        $goal->getGoalDetails()->setFebruaryReal($obj->getFebruaryReal());
                    }
                    if (($obj->getMarchReal()) != null) {
                        $goal->getGoalDetails()->setMarchReal($obj->getMarchReal());
                    }
                    if (($obj->getAprilReal()) != null) {
                        $goal->getGoalDetails()->setAprilReal($obj->getAprilReal());
                    }
                    if (($obj->getMayReal()) != null) {
                        $goal->getGoalDetails()->setMayReal($obj->getMayReal());
                    }
                    if (($obj->getJuneReal()) != null) {
                        $goal->getGoalDetails()->setJuneReal($obj->getJuneReal());
                    }
                    if (($obj->getJulyReal()) != null) {
                        $goal->getGoalDetails()->setJulyReal($obj->getJulyReal());
                    }
                    if (($obj->getAugustReal()) != null) {
                        $goal->getGoalDetails()->setAugustReal($obj->getAugustReal());
                    }
                    if (($obj->getSeptemberReal()) != null) {
                        $goal->getGoalDetails()->setSeptemberReal($obj->getSeptemberReal());
                    }
                    if (($obj->getOctoberReal()) != null) {
                        $goal->getGoalDetails()->setOctoberReal($obj->getOctoberReal());
                    }
                    if (($obj->getNovemberReal()) != null) {
                        $goal->getGoalDetails()->setNovemberReal($obj->getNovemberReal());
                    }
                    if (($obj->getDecemberReal()) != null) {
                        $goal->getGoalDetails()->setDecemberReal($obj->getDecemberReal());
                    }
                }
            }

            $data[] = $goal->getGoalDetails();
        }

        $view = $this->view();

        $result = array(
            'data' => $data,
            'success' => true,
            'total' => count($data),
            'responsibles' => $responsibles,
            'userobj' => $userobj,
            'user' => $user,
        );

        if ($request->get('_format') == 'html') {
            $result['monthsPlanned'] = GoalDetails::getMonthsPlanned();
            $result['entity'] = $entity;
        }
        $view->setData($result);
        $view->getSerializationContext()->setGroups(array('id', 'api_list', 'goal', 'goalDetails'));
        $view->setTemplate("PequivenArrangementProgramBundle:Rest:ArrangementProgram/form.html.twig");

        return $view;
    }

    /**
     * @Annotations\Put("/{id}/{user}/goals-details.{_format}/{slug}",name="put_arrangementprogram_rest_restarrangementprogram_putgoalsdetails",requirements={"_format"="html|json|xml"},defaults={"_format"="html"})
     */
    function putGoalsDetailsAction($id, Request $request, $slug) {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('PequivenArrangementProgramBundle:GoalDetails')->find($slug);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GoalDetails entity.');
        }

        //NOTIFICACION INDIVIDUAL
        if ($request->get('user') != 0) {
            $entityInd = $em->getRepository('PequivenArrangementProgramBundle:GoalDetailsInd')->findOneby(array('goalDetails' => $entity));
            $user = $request->get('user');
            $usernotific = $user;
            if (!$entityInd) {
                $entityInd = new GoalDetailsInd();
            }
            //AFECTA A LA ENTIDAD DE NOTIFICACION DE METAS INDIVIDUAL    
            $entityInd->setJanuaryPlanned($entity->getJanuaryPlanned());
            $entityInd->setFebruaryPlanned($entity->getFebruaryPlanned());
            $entityInd->setMarchPlanned($entity->getMarchPlanned());
            $entityInd->setAprilPlanned($entity->getAprilPlanned());
            $entityInd->setMayPlanned($entity->getMayPlanned());
            $entityInd->setJunePlanned($entity->getJunePlanned());
            $entityInd->setJulyPlanned($entity->getJulyPlanned());
            $entityInd->setAugustPlanned($entity->getAugustPlanned());
            $entityInd->setSeptemberPlanned($entity->getSeptemberPlanned());
            $entityInd->setOctoberPlanned($entity->getOctoberPlanned());
            $entityInd->setNovemberPlanned($entity->getNovemberPlanned());
            $entityInd->setDecemberPlanned($entity->getDecemberPlanned());
            $form = $this->createForm(new GoalDetailsIndType(), $entityInd);
        } else {
            //AFECTA A LA ENTIDAD DE NOTIFICACION DE METAS GLOBAL
            $form = $this->createForm(new GoalDetailsType(), $entity);
            $usernotific = null;
        }

        $arrangementProgram = $entity->getGoal()->getTimeline()->getArrangementProgram();
        $hasPermissionToNotify = $this->getArrangementProgramManager()->hasPermissionToNotify($arrangementProgram);
        $hasPermissionToPlanned = $this->getArrangementProgramManager()->hasPermissionToPlanned($arrangementProgram);

        if (!$hasPermissionToNotify && !$hasPermissionToPlanned) {
            throw new AccessDeniedException();
        }

        $dataRequest = $request->request->all();
        unset($dataRequest['id']);
        unset($dataRequest['null']);

        foreach ($dataRequest as $property => $value) {
            $permission = true;
            if (GoalDetails::isPlannedProperty($property) === true && $hasPermissionToPlanned === false
            ) {
                $permission = false;
            }
            if (GoalDetails::isRealProperty($property) === true && $hasPermissionToNotify === false) {
                $permission = false;
            }
            if ($permission === false) {
                throw new AccessDeniedException();
            }
        }

        $form->submit($dataRequest, false);
        $success = false;

        if ($request->get('user') != 0) {
            $entityInd->setGoalDetails($entity);
            $userObj = $em->getRepository('PequivenSEIPBundle:User')->findOneById($user);
            $entityInd->setUser($userObj);
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
                        $valuePlanned = $propertyAccessor->getValue($entityInd, $planned);
                        $monthReal = GoalDetails::getMonthOfRealByMonth($monthNumber);
                        $valueReal = $propertyAccessor->getValue($entityInd, $monthReal);
                        if ($isEnabledEditByPlannedLoad && ($valuePlanned == '' || $valuePlanned == '0' || $valuePlanned === null)) {
                            $propertyAccessor->setValue($entityInd, $monthReal, 0);
                        } else if ($valueReal > $valuePlanned) {
                            //Valida que el valor real no pueda ser mayor al planeado.
                            if ($isAllowLoadingLongerThanPlannedRealValue === false) {
                                $propertyAccessor->setValue($entityInd, $monthReal, $valuePlanned);
                            }
                        }
                    }
                }
                $em->persist($entityInd);
                $em->flush();
                $success = true;
            } else {
                $entityInd = $form;
            }
        } else {
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
        }

        $view = $this->view();
        $result = array(
            'data' => $entity,
            'success' => $success,
            'total' => 1,
            'messages' => 'Exitooooo',
            'user' => $usernotific
        );

        $view->setData($result);
        $view->getSerializationContext()->setGroups(array('id', 'api_list', 'goal', 'goalDetails'));
        $view->setTemplate("PequivenArrangementProgramBundle:Rest:ArrangementProgram/form.html.twig");
        return $view;
    }

    /**
     * Manejador de programa de gestion
     * 
     * @return \Pequiven\ArrangementProgramBundle\Model\ArrangementProgramManager
     */
    private function getArrangementProgramManager() {
        return $this->get('seip.arrangement_program.manager');
    }

}
