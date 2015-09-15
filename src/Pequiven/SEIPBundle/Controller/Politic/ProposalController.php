<?php

namespace Pequiven\SEIPBundle\Controller\Politic;

use DateTime;
use Pequiven\SEIPBundle\Entity\Politic\Proposal;
use Pequiven\SEIPBundle\Controller\SEIPController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sylius\Bundle\ResourceBundle\Event\ResourceEvent;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Pequiven\SEIPBundle\Form\Politic\ProposalType;

/**
 * Controlador de la propuesta del círculo de estudio de trabajo
 *
 */
class ProposalController extends SEIPController {
    
    public function createAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $idWorkStudyCircle = $request->get('workStudyCircle_id');
        $workStudyCircle = $em->getRepository('PequivenSEIPBundle:Politic\WorkStudyCircle')->findOneBy(array('id' => $idWorkStudyCircle));
        
        $proposal = new Proposal();
        $form = $this->createForm(new ProposalType, $proposal);
        $form->handleRequest($request);        

        $user = $this->getUser();
        $em->getConnection()->beginTransaction();
        if ($form->isSubmitted() && $form->isValid()) {
            
            //Determinamos si la Línea Estratégica ya tiene 2 propuestas creadas
            $proposalRepository = $em->getRepository('PequivenSEIPBundle:Politic\Proposal');
            $proposalByLineStrategic = $proposalRepository->findBy(array('lineStrategic' => $request->get("proposal_data")["lineStrategic"]));

//            if ($countUsers < $validMinUsers) {
//                $this->get('session')->getFlashBag()->add('error', 'Debe Agregar ' . $validMinUsers . ' miembros como mínimo');
//            } else {

                $proposal->setCreatedBy($user);
                $proposal->setPeriod($period = $this->getPeriodService()->getPeriodActive());
                $proposal->setWorkStudyCircle($workStudyCircle);

                $em->persist($proposal);
                $em->flush();

                try {
                    $em->flush();
                    $em->getConnection()->commit();
                } catch (Exception $e) {
                    $em->getConnection()->rollback();
                    throw $e;
                }

                $this->get('session')->getFlashBag()->add('success', 'Propuesta guardada correctamente');
                
                return $this->redirect($this->generateUrl('pequiven_work_study_circle_show', array("id" => $workStudyCircle->getId())));
//            }
        }

        return $this->render('PequivenSEIPBundle:Politic:Proposal\create.html.twig', array(
                    'form' => $form->createView(),
                    'user' => $user,
                    'workStudyCircle' => $workStudyCircle,
        ));
    }
    
    /**
     * Devuelve los Objetivos Estratégicos de acuerdo a la Línea Estratégica seleccionada
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getObjetiveFromLineStrategicAction(Request $request) {
        $response = new JsonResponse();

        $objetiveChildrenStrategic = array();
        $em = $this->getDoctrine()->getManager();

        $lineStrategicId = $request->request->get('lineStrategicId');
        $lineStrategicArray = explode(',', $lineStrategicId);

        $results = $this->get('pequiven.repository.objetive')->getByLineStrategic($lineStrategicArray);
        $totalResults = count($results);
        if (is_array($results) && $totalResults > 0) {
            foreach ($results as $result) {
                $objetiveChildrenStrategic[] = array("ref" => $result->getRef(), "description" => $result->getDescription());
            }
        } else {
            $objetiveChildrenStrategic[] = array("empty" => true);
        }
        $response->setData($objetiveChildrenStrategic);

        return $response;
    }
    
}