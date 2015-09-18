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
        
        $proposalsRegistered = $em->getRepository('PequivenSEIPBundle:Politic\Proposal')->findBy(array('workStudyCircle' => $idWorkStudyCircle));
        $proposalsArray = array();
        foreach ($proposalsRegistered as $proposalRegistered){
            $proposalsArray[$proposalRegistered->getLineStrategic()->getId()] = true;
        }

        $user = $this->getUser();
        $em->getConnection()->beginTransaction();
        if ($form->isSubmitted() && $form->isValid()) {
            
            $proposal1 = $request->get("proposal_data")["description1"];
            $proposal2 = $request->get("proposal_data")["description2"];
            $proposals = array();
            array_push($proposals, $proposal1);
            array_push($proposals, $proposal2);
            
            //Obtenemos Línea Estratégica
            $LineStrategicRepository = $em->getRepository('PequivenMasterBundle:LineStrategic');
            $lineStrategicObject = $LineStrategicRepository->findOneBy(array('id' => $request->get("proposal_data")["lineStrategic"]));
            
            if (strlen($proposal1) > 0 && strlen($proposal2) > 0){
                if(array_key_exists($request->get("proposal_data")["lineStrategic"], $proposalsArray)){
                    $this->get('session')->getFlashBag()->add('error', 'La Línea Estratégica ya tiene sus 2 propuestas');
                } else{
                    for($i = 1;$i <= 2; $i++){
                        $proposalObject = new Proposal();
                        $proposalObject->setCreatedBy($user);
                        $proposalObject->setPeriod($period = $this->getPeriodService()->getPeriodActive());
                        $proposalObject->setWorkStudyCircle($workStudyCircle);
                        $proposalObject->setLineStrategic($lineStrategicObject);
                        $proposalObject->setDescription($proposals[$i-1]);
                        $em->persist($proposalObject);
                    }

                    $em->flush();

                    try {
                        $em->flush();
                        $em->getConnection()->commit();
                    } catch (Exception $e) {
                        $em->getConnection()->rollback();
                        throw $e;
                    }

                    $this->get('session')->getFlashBag()->add('success', 'Propuestas guardadas correctamente');

                    return $this->redirect($this->generateUrl('pequiven_work_study_circle_show', array("id" => $workStudyCircle->getId())));
                }
            } else{
                $this->get('session')->getFlashBag()->add('error', 'Debe agregar 2 propuestas por línea estratégica');
            }
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

    /**
     * Edición de Propuestas
     *
     *
     */
    public function editAction(request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $id = $request->get('id');
        $idCircle = $request->get('idCircle');

        $proposalData = $em->getRepository('PequivenSEIPBundle:Politic\Proposal')->findOneBy(array('id' => $id));      
        

        $form = $this->createForm(new ProposalType, $proposalData);//Para reutilizar en form de la propuesta (El select2)
        $form->handleRequest($request);

        $em->getConnection()->beginTransaction();
        
        if ($form->isSubmitted()) {
            
            //$line = $request->get("proposal_data")['lineStrategic'];//Recibiendo el id de la Linea
            $description = $request->get("proposal_data")['description'];//Recibiendo la Propuesta Editada

            //$lineData = $this->get('pequiven.repository.linestrategic')->findOneBy(array('id' => $line)); //Llamada linea

            //$proposalData->setLineStrategic($lineData);//Pasando la linea
            $proposalData->setDescription($description);//Pasando la propuesta editada
            
            $em->persist($proposalData);

            try {
                $em->flush();
                $em->getConnection()->commit();
            } catch (Exception $e) {
                $em->getConnection()->rollback();
                throw $e;
            }

            $this->get('session')->getFlashBag()->add('success', 'Propuesta Actualizada Correctamente');
            return $this->redirect($this->generateUrl('pequiven_work_study_circle_show', array("id" => $idCircle)));
        }

        return $this->render('PequivenSEIPBundle:Politic:Proposal/edit.html.twig', array(
                    'proposal' => $proposalData,
                    'circle'   => $idCircle,
                    'form'     => $form->createView()
        ));
    }

    /**
     *
     *  Vista de propuesta
     *
     */
    public function viewAction(request $request)
    {   
        $id = $request->get('id');
        $idCircle = $request->get('idCircle');

        $proposalData = $em->getRepository('PequivenSEIPBundle:Politic\Proposal')->findOneBy(array('id' => $id));      

        return $this->render('PequivenSEIPBundle:Politic:Proposal/edit.html.twig', array(
                    'proposal' => $proposalData,
                    //'circle'   => $idCircle,
                    //'form'     => $form->createView()
        ));
    }
    
}